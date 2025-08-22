APAppconst DEBUG_MODE = false;

const LEDGER_ARCHIVE_URL = "https://docs.google.com/spreadsheets/d/1whyGF0bU53pHm2yaK4xOxJJWiLrx9IndY5jH11GzVzo/edit";
const ARCHIVE_PLAYER_REGISTRY_SHEET = 'Player Registry';
const ARCHIVE_PLAYER_DATA_RANGE = 'A2:A';

const VALID_TRANSACTION_STATUS_ID = 1;

const ADMIN_PLAYER_NAME_STATUS = 'P3';
const ADMIN_PLAYER_NAME = 'B5:C6';
const ADMIN_TRANSACTION_STATUS_ID = 'N3';
const ADMIN_TRANSACTION_STATUS_OUTPUT = 'J2';
const ADMIN_TRANSACTION_AUTOFILL = 'H7';
const ADMIN_TRANSACTION_BUY_DATA = 'R3:DD3';
const ADMIN_TRANSACTION_CLAIM_DATA = 'R4:DD4';
const ADMIN_TRANSACTION_BUY_AND_CLAIM_DATA = 'R3:4';
const ADMIN_TRANSACTION_NO_BUYS = 'N10';
const ADMIN_TRANSACTION_NO_CLAIMS = 'O10';
const ADMIN_CLEAR_RANGES = ['B5:B6', 'G5:H6', 'C13:D42', 'J13:K42'];

const SPELL_PLAYER_NAME_STATUS = 'L3';
const SPELL_PLAYER_NAME = 'G7';
const SPELL_TRANSACTION_STATUS_ID = 'J3';
const SPELL_TRANSACTION_STATUS_OUTPUT = 'G2';
const SPELL_TRANSACTION_AUTOFILL = 'O6'; // purpose: _RecordToLedger() argument criteria
const SPELL_TRANSACTION_DATA = 'O3:3';
const SPELL_CLEAR_RANGES = ['E6:E56', 'G7:G8'];

const ADMIN_LEDGER_SHEET = "Admin Ledger";


// ============================================
//    UTILITY FUNCTIONS
// ============================================

function _ClearRanges(sheet, ranges) {
  if (sheet == null) { return; }

  for (var i=0; i<ranges.length; i++) {
    var range = ranges[i];
    sheet.getRange(range).clear({contentsOnly: true, skipFilteredRows: true});
  }
}


// ============================================
//    PLAYER REGISTRATION
// ============================================

function _RegisterPlayer(registry_status_cell, player_name_cell) {

  // check for errors and validate sheets

  var teller_sheet = SpreadsheetApp.getActive().getActiveSheet();
  if (teller_sheet == null) { SpreadsheetApp.getUi().alert("Invalid active sheet(?)"); return; }

  var reg_status = teller_sheet.getRange(registry_status_cell).getValue();
  var player_name = teller_sheet.getRange(player_name_cell).getValue();

  if (reg_status == -1 || player_name == "") { SpreadsheetApp.getUi().alert("Player name must not be blank"); return; }
  if (reg_status > 0) { SpreadsheetApp.getUi().alert("Name already exists"); return; }
  
  var registry_spreadsheet = SpreadsheetApp.openByUrl(LEDGER_ARCHIVE_URL);
  if (registry_spreadsheet == null) { SpreadsheetApp.getUi().alert("Unable to open file:\n" + LEDGER_ARCHIVE_URL); return; }

  var player_registry_sheet = registry_spreadsheet.getSheetByName(ARCHIVE_PLAYER_REGISTRY_SHEET)
  if (player_registry_sheet == null) { SpreadsheetApp.getUi().alert("Invalid registry sheet '" + ARCHIVE_PLAYER_REGISTRY_SHEET + "'"); return; }

  // ignore duplicate entries

  var name_exists = player_registry_sheet.getRange(ARCHIVE_PLAYER_DATA_RANGE).createTextFinder(player_name).matchEntireCell(true).findNext();
  if (name_exists != null) { SpreadsheetApp.getUi().alert("Duplicate name found"); return; }

  // add the player to the registry

  player_registry_sheet.appendRow([player_name]);
  SpreadsheetApp.getUi().alert("Successfully added player '" + player_name + "'");

  return 0;
}


function AdminRegisterPlayer() { _RegisterPlayer(ADMIN_PLAYER_NAME_STATUS, ADMIN_PLAYER_NAME); }



// ============================================
//    LEDGER RECORD & CLEAR
// ============================================


function _RecordToLedger(ledger_sheet_name, transaction_status_id, transaction_status_output, transaction_data_range, player_name_cell, clear_ranges, autofill_cell) {

  // Check all files and errors
  
  var sheet_doc = SpreadsheetApp.getActive();
  if (sheet_doc == null) { return "Null spreadsheet(?)"; }

  var teller_sheet = sheet_doc.getActiveSheet();
  if (teller_sheet == null) { return "Null active sheet(?)"; }

  var ledger_sheet = sheet_doc.getSheetByName(ledger_sheet_name);
  if (ledger_sheet == null) { return "Invalid ledger sheet:\n" + ledger_sheet_name; }

  let ledger_archive_spreadsheet = SpreadsheetApp.openByUrl(LEDGER_ARCHIVE_URL);
  if (ledger_archive_spreadsheet == null) { return "Unable to open file:\n" + LEDGER_ARCHIVE_URL; }

  let archive_sheet = ledger_archive_spreadsheet.getSheetByName(ledger_sheet_name);
  if (archive_sheet == null) { return "Invalid archive sheet:\n" + ledger_sheet_name; }

  // copy transaction data

  SpreadsheetApp.flush();

  var status = teller_sheet.getRange(transaction_status_id).getValue();
  var output = teller_sheet.getRange(transaction_status_output).getValue();
  var transaction_data = teller_sheet.getRange(transaction_data_range).getValues();
  var player_name = teller_sheet.getRange(player_name_cell).getValue();
  // var success_msg = teller_sheet.getRange(success_msg_cell).getValue();

  // DEBUG
  if (DEBUG_MODE) {
    SpreadsheetApp.getUi().alert(
      "DEBUG INFO:\n\n" +
      ledger_sheet_name + "\n" +
      transaction_status_id + " (status) : " + status + "\n" +
      transaction_status_output + " (output) : " + output + "\n" +
      transaction_data_range +  " (data) rows :" + transaction_data.length + "\n" +
      player_name_cell  + " : " + player_name + "\n\n" +
    //  success_msg_cell  + " : " + success_msg + "\n\n" +
      clear_ranges  + " (clear ranges) \n" +
      autofill_cell + " (autofill cell)"
    );
    
    SpreadsheetApp.getUi().alert("DEBUG INDO:\n\nData range: " + transaction_data_range + "\n\nData:\n" + transaction_data);
  }

  if (status != VALID_TRANSACTION_STATUS_ID) { 
    var err_msg = "Transaction error:\n" + teller_sheet.getRange(transaction_status_output).getValue();
    return err_msg; 
  }

  
  for (var i=0; i<transaction_data.length; i++) {
    ledger_sheet.appendRow(transaction_data[i]);
    archive_sheet.appendRow(transaction_data[i]);
  }
  
  _ClearRanges(teller_sheet, clear_ranges);
  teller_sheet.getRange(autofill_cell).setValue(false);
  
  SpreadsheetApp.flush();
  SpreadsheetApp.getUi().alert("Transaction with '" + player_name + "'\nrecorded successfully!");

  return 0;
}

function AdminRecord() { 
  
  var teller_sheet = SpreadsheetApp.getActive().getActiveSheet();
  if (teller_sheet == null) { return; }

  var no_buys = teller_sheet.getRange(ADMIN_TRANSACTION_NO_BUYS).getValue();
  var no_claims = teller_sheet.getRange(ADMIN_TRANSACTION_NO_CLAIMS).getValue();

  var transaction_data = '';

  if (no_buys) {
    transaction_data = ADMIN_TRANSACTION_CLAIM_DATA;
  }
  else if (no_claims) {
    transaction_data = ADMIN_TRANSACTION_BUY_DATA;
  }
  else {
    transaction_data = ADMIN_TRANSACTION_BUY_AND_CLAIM_DATA;
  }

  var err = _RecordToLedger(
    ADMIN_LEDGER_SHEET,
    ADMIN_TRANSACTION_STATUS_ID,
    ADMIN_TRANSACTION_STATUS_OUTPUT,
    transaction_data,
    ADMIN_PLAYER_NAME,
    ADMIN_CLEAR_RANGES,
    ADMIN_TRANSACTION_AUTOFILL);
  
  if (err) { SpreadsheetApp.getUi().alert(err); }
}

function SpellRecord() {
  var err = _RecordToLedger(
    ADMIN_LEDGER_SHEET,
    SPELL_TRANSACTION_STATUS_ID,
    SPELL_TRANSACTION_STATUS_OUTPUT,
    SPELL_TRANSACTION_DATA,
    SPELL_PLAYER_NAME,
    SPELL_CLEAR_RANGES,
    SPELL_TRANSACTION_AUTOFILL);
  
  if (err) { SpreadsheetApp.getUi().alert(err); }
}


function AdminClear() {
  var sheet = SpreadsheetApp.getActive().getActiveSheet();
  if (sheet == null) { return; }
  _ClearRanges(sheet, ADMIN_CLEAR_RANGES);
}

function SpellClear() {
  var sheet = SpreadsheetApp.getActive().getActiveSheet();
  if (sheet == null) { return; }
  _ClearRanges(sheet, SPELL_CLEAR_RANGES);
}