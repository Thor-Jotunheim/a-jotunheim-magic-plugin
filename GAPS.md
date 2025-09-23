Turn these google app scripts into a real app so I can move away from Google Sheets.

I'm going to provide a bunch of scripts now.

Jotunheim_Admin.gs: const DEBUG_MODE = false;

const LEDGER_ARCHIVE_URL = "https://docs.google.com/spreadsheets/d/1whyGF0bU53pHm2yaK4xOxJJWiLrx9IndY5jH11GzVzo/edit"; const ARCHIVE_PLAYER_REGISTRY_SHEET = 'Player Registry'; const ARCHIVE_PLAYER_DATA_RANGE = 'A2:A';

const VALID_TRANSACTION_STATUS_ID = 1;

const ADMIN_PLAYER_NAME_STATUS = 'P3'; const ADMIN_PLAYER_NAME = 'B5:C6'; const ADMIN_TRANSACTION_STATUS_ID = 'N3'; const ADMIN_TRANSACTION_STATUS_OUTPUT = 'J2'; const ADMIN_TRANSACTION_AUTOFILL = 'H7'; const ADMIN_TRANSACTION_BUY_DATA = 'R3:DD3'; const ADMIN_TRANSACTION_CLAIM_DATA = 'R4:DD4'; const ADMIN_TRANSACTION_BUY_AND_CLAIM_DATA = 'R3:4'; const ADMIN_TRANSACTION_NO_BUYS = 'N10'; const ADMIN_TRANSACTION_NO_CLAIMS = 'O10'; const ADMIN_CLEAR_RANGES = ['B5:B6', 'G5:H6', 'C13:D42', 'J13:K42'];

const SPELL_PLAYER_NAME_STATUS = 'L3'; const SPELL_PLAYER_NAME = 'G7'; const SPELL_TRANSACTION_STATUS_ID = 'J3'; const SPELL_TRANSACTION_STATUS_OUTPUT = 'G2'; const SPELL_TRANSACTION_AUTOFILL = 'O6'; // purpose: _RecordToLedger() argument criteria const SPELL_TRANSACTION_DATA = 'O3:3'; const SPELL_CLEAR_RANGES = ['E6:E56', 'G7:G8'];

const ADMIN_LEDGER_SHEET = "Admin Ledger";

// ============================================ // UTILITY FUNCTIONS // ============================================

function _ClearRanges(sheet, ranges) { if (sheet == null) { return; }

for (var i=0; i<ranges.length; i++) { var range = ranges[i]; sheet.getRange(range).clear({contentsOnly: true, skipFilteredRows: true}); } }

// ============================================ // PLAYER REGISTRATION // ============================================

function _RegisterPlayer(registry_status_cell, player_name_cell) {

// check for errors and validate sheets

var teller_sheet = SpreadsheetApp.getActive().getActiveSheet(); if (teller_sheet == null) { SpreadsheetApp.getUi().alert("Invalid active sheet(?)"); return; }

var reg_status = teller_sheet.getRange(registry_status_cell).getValue(); var player_name = teller_sheet.getRange(player_name_cell).getValue();

if (reg_status == -1 || player_name == "") { SpreadsheetApp.getUi().alert("Player name must not be blank"); return; } if (reg_status > 0) { SpreadsheetApp.getUi().alert("Name already exists"); return; }

var registry_spreadsheet = SpreadsheetApp.openByUrl(LEDGER_ARCHIVE_URL); if (registry_spreadsheet == null) { SpreadsheetApp.getUi().alert("Unable to open file:\n" + LEDGER_ARCHIVE_URL); return; }

var player_registry_sheet = registry_spreadsheet.getSheetByName(ARCHIVE_PLAYER_REGISTRY_SHEET) if (player_registry_sheet == null) { SpreadsheetApp.getUi().alert("Invalid registry sheet '" + ARCHIVE_PLAYER_REGISTRY_SHEET + "'"); return; }

// ignore duplicate entries

var name_exists = player_registry_sheet.getRange(ARCHIVE_PLAYER_DATA_RANGE).createTextFinder(player_name).matchEntireCell(true).findNext(); if (name_exists != null) { SpreadsheetApp.getUi().alert("Duplicate name found"); return; }

// add the player to the registry

player_registry_sheet.appendRow([player_name]); SpreadsheetApp.getUi().alert("Successfully added player '" + player_name + "'");

return 0; }

function AdminRegisterPlayer() { _RegisterPlayer(ADMIN_PLAYER_NAME_STATUS, ADMIN_PLAYER_NAME); }

// ============================================ // LEDGER RECORD & CLEAR // ============================================

function _RecordToLedger(ledger_sheet_name, transaction_status_id, transaction_status_output, transaction_data_range, player_name_cell, clear_ranges, autofill_cell) {

// Check all files and errors

var sheet_doc = SpreadsheetApp.getActive(); if (sheet_doc == null) { return "Null spreadsheet(?)"; }

var teller_sheet = sheet_doc.getActiveSheet(); if (teller_sheet == null) { return "Null active sheet(?)"; }

var ledger_sheet = sheet_doc.getSheetByName(ledger_sheet_name); if (ledger_sheet == null) { return "Invalid ledger sheet:\n" + ledger_sheet_name; }

let ledger_archive_spreadsheet = SpreadsheetApp.openByUrl(LEDGER_ARCHIVE_URL); if (ledger_archive_spreadsheet == null) { return "Unable to open file:\n" + LEDGER_ARCHIVE_URL; }

let archive_sheet = ledger_archive_spreadsheet.getSheetByName(ledger_sheet_name); if (archive_sheet == null) { return "Invalid archive sheet:\n" + ledger_sheet_name; }

// copy transaction data

SpreadsheetApp.flush();

var status = teller_sheet.getRange(transaction_status_id).getValue(); var output = teller_sheet.getRange(transaction_status_output).getValue(); var transaction_data = teller_sheet.getRange(transaction_data_range).getValues(); var player_name = teller_sheet.getRange(player_name_cell).getValue(); // var success_msg = teller_sheet.getRange(success_msg_cell).getValue();

// DEBUG if (DEBUG_MODE) { SpreadsheetApp.getUi().alert( "DEBUG INFO:\n\n" + ledger_sheet_name + "\n" + transaction_status_id + " (status) : " + status + "\n" + transaction_status_output + " (output) : " + output + "\n" + transaction_data_range + " (data) rows :" + transaction_data.length + "\n" + player_name_cell + " : " + player_name + "\n\n" + // success_msg_cell + " : " + success_msg + "\n\n" + clear_ranges + " (clear ranges) \n" + autofill_cell + " (autofill cell)" );

Code
SpreadsheetApp.getUi().alert("DEBUG INDO:\n\nData range: " + transaction_data_range + "\n\nData:\n" + transaction_data);
}

if (status != VALID_TRANSACTION_STATUS_ID) { var err_msg = "Transaction error:\n" + teller_sheet.getRange(transaction_status_output).getValue(); return err_msg; }

for (var i=0; i<transaction_data.length; i++) { ledger_sheet.appendRow(transaction_data[i]); archive_sheet.appendRow(transaction_data[i]); }

_ClearRanges(teller_sheet, clear_ranges); teller_sheet.getRange(autofill_cell).setValue(false);

SpreadsheetApp.flush(); SpreadsheetApp.getUi().alert("Transaction with '" + player_name + "'\nrecorded successfully!");

return 0; }

function AdminRecord() {

var teller_sheet = SpreadsheetApp.getActive().getActiveSheet(); if (teller_sheet == null) { return; }

var no_buys = teller_sheet.getRange(ADMIN_TRANSACTION_NO_BUYS).getValue(); var no_claims = teller_sheet.getRange(ADMIN_TRANSACTION_NO_CLAIMS).getValue();

var transaction_data = '';

if (no_buys) { transaction_data = ADMIN_TRANSACTION_CLAIM_DATA; } else if (no_claims) { transaction_data = ADMIN_TRANSACTION_BUY_DATA; } else { transaction_data = ADMIN_TRANSACTION_BUY_AND_CLAIM_DATA; }

var err = _RecordToLedger( ADMIN_LEDGER_SHEET, ADMIN_TRANSACTION_STATUS_ID, ADMIN_TRANSACTION_STATUS_OUTPUT, transaction_data, ADMIN_PLAYER_NAME, ADMIN_CLEAR_RANGES, ADMIN_TRANSACTION_AUTOFILL);

if (err) { SpreadsheetApp.getUi().alert(err); } }

function SpellRecord() { var err = _RecordToLedger( ADMIN_LEDGER_SHEET, SPELL_TRANSACTION_STATUS_ID, SPELL_TRANSACTION_STATUS_OUTPUT, SPELL_TRANSACTION_DATA, SPELL_PLAYER_NAME, SPELL_CLEAR_RANGES, SPELL_TRANSACTION_AUTOFILL);

if (err) { SpreadsheetApp.getUi().alert(err); } }

function AdminClear() { var sheet = SpreadsheetApp.getActive().getActiveSheet(); if (sheet == null) { return; } _ClearRanges(sheet, ADMIN_CLEAR_RANGES); }

function SpellClear() { var sheet = SpreadsheetApp.getActive().getActiveSheet(); if (sheet == null) { return; } _ClearRanges(sheet, SPELL_CLEAR_RANGES); }

Player Rename.js: const MODERATOR_FILE_URL = "https://docs.google.com/spreadsheets/d/1SG6qF9FuqzgbxEqfHw2mHE0r-7Y0V6WFClO2JXr63aM/edit"; const ADMIN_FILE_URL = "https://docs.google.com/spreadsheets/d/1YJUJ85-1GrxwNpzypzQugvGqVv3LsYyGuvBw1Ee8WOo/edit";

const PLAYER_REGISTRY_DATA_RANGE = 'A2:A'; const NAME_CHANGE_INFO = ['F6', 'D2', 'D5', 'E5', 'F5', 'G5']; const LEDGER_PLAYER_RANGE = 'E5:E';

function _RenamePlayerInLedger(spreadsheet, ledger_sheet_name, target_name, new_name) { let ledger_archive_file_url = "https://docs.google.com/spreadsheets/d/1whyGF0bU53pHm2yaK4xOxJJWiLrx9IndY5jH11GzVzo/edit"; if (spreadsheet == null) { SpreadsheetApp.getUi().alert("Ledger's spreadsheet was null"); return; }

let ledger_sheet = SpreadsheetApp.openByUrl(ledger_archive_file_url).getSheetByName(ledger_sheet_name); if (ledger_sheet == null) { SpreadsheetApp.getUi().alert("Invalid sheet:\n" + ledger_sheet_name); return; }

ledger_sheet.getRange(LEDGER_PLAYER_RANGE); let target_index = ledger_sheet.createTextFinder(target_name).matchEntireCell(true).findNext(); if (target_index == null) { if (DEBUG_MODE) { SpreadsheetApp.getUi().alert(ledger_sheet_name + "\n\nNo instances of '" + target_name + "' found"); } } else { let instance_count = 0; while (target_index) { target_index.setValue(new_name); instance_count += 1; target_index = null; target_index = ledger_sheet.createTextFinder(target_name).matchEntireCell(true).findNext(); } if (DEBUG_MODE) { SpreadsheetApp.getUi().alert(ledger_sheet_name + "\n\nAll " + instance_count + " instances of '" + target_name + "' renamed to '" + new_name + "'"); } } }

function _RenamePlayerInAdminLedger(spreadsheet, ledger_sheet_name, target_name, new_name) { let ledger_file_url = "https://docs.google.com/spreadsheets/d/1YJUJ85-1GrxwNpzypzQugvGqVv3LsYyGuvBw1Ee8WOo/edit#gid=1412029809"; if (spreadsheet == null) { SpreadsheetApp.getUi().alert("Ledger's spreadsheet was null"); return; }

let ledger_sheet = SpreadsheetApp.openByUrl(ledger_file_url).getSheetByName(ledger_sheet_name); if (ledger_sheet == null) { SpreadsheetApp.getUi().alert("Invalid sheet:\n" + ledger_sheet_name); return; }

ledger_sheet.getRange(LEDGER_PLAYER_RANGE); let target_index = ledger_sheet.createTextFinder(target_name).matchEntireCell(true).findNext(); if (target_index == null) { if (DEBUG_MODE) { SpreadsheetApp.getUi().alert(ledger_sheet_name + "\n\nNo instances of '" + target_name + "' found"); } } else { let instance_count = 0; while (target_index) { target_index.setValue(new_name); instance_count += 1; target_index = null; target_index = ledger_sheet.createTextFinder(target_name).matchEntireCell(true).findNext(); } if (DEBUG_MODE) { SpreadsheetApp.getUi().alert(ledger_sheet_name + "\n\nAll " + instance_count + " instances of '" + target_name + "' renamed to '" + new_name + "'"); } } }

function RegistryRenamePlayer() { let manager_sheet = SpreadsheetApp.getActive().getActiveSheet(); if (manager_sheet == null) { SpreadsheetApp.getUi().alert("Active sheet was null(?)"); return; }

let action_status = manager_sheet.getRange(NAME_CHANGE_INFO[0]).getValue(); let current_date = manager_sheet.getRange("J5").getValue(); let current_name = manager_sheet.getRange(NAME_CHANGE_INFO[2]).getValue(); let new_name = manager_sheet.getRange(NAME_CHANGE_INFO[3]).getValue(); let admin_ledger_name = "Admin Ledger"; let popup_ledger_name = "Popup Ledger"; let beehive_ledger_name = "Beehive Ledger"; let haldore_ledger_name = "Haldore Ledger"; let ledger_archive_file_url = "https://docs.google.com/spreadsheets/d/1whyGF0bU53pHm2yaK4xOxJJWiLrx9IndY5jH11GzVzo/edit";

if (!action_status) { SpreadsheetApp.getUi().alert("Invalid action"); return; }

let registry_sheet_name = manager_sheet.getRange(NAME_CHANGE_INFO[4]).getValue(); let registry_sheet = SpreadsheetApp.openByUrl(ledger_archive_file_url).getSheetByName(registry_sheet_name); if (registry_sheet == null) { SpreadsheetApp.getUi().alert("Invalid sheet:\n" + registry_sheet); return; }

let name_history_sheet_name = manager_sheet.getRange(NAME_CHANGE_INFO[5]).getValue(); let name_history_sheet = SpreadsheetApp.openByUrl(ledger_archive_file_url).getSheetByName(name_history_sheet_name); if (name_history_sheet == null) { SpreadsheetApp.getUi().alert("Invalid sheet:\n" + name_history_sheet_name); return; }

var player_registry_data = registry_sheet.getRange(PLAYER_REGISTRY_DATA_RANGE); var target_index = player_registry_data.createTextFinder(current_name).matchEntireCell(true).findNext(); if (target_index == null) { SpreadsheetApp.getUi().alert("Could not find player '" + current_name + "'"); return; }

name_history_sheet.appendRow([new_name, current_name, current_date]); target_index.setValue(new_name);

_RenamePlayerInLedger(SpreadsheetApp.openByUrl(LEDGER_ARCHIVE_URL), admin_ledger_name, current_name, new_name); _RenamePlayerInLedger(SpreadsheetApp.openByUrl(LEDGER_ARCHIVE_URL), popup_ledger_name, current_name, new_name); _RenamePlayerInLedger(SpreadsheetApp.openByUrl(LEDGER_ARCHIVE_URL), beehive_ledger_name, current_name, new_name); _RenamePlayerInLedger(SpreadsheetApp.openByUrl(LEDGER_ARCHIVE_URL), haldore_ledger_name, current_name, new_name); _RenamePlayerInAdminLedger(SpreadsheetApp.openByUrl(ADMIN_FILE_URL), admin_ledger_name, current_name, new_name);

manager_sheet.getRange(NAME_CHANGE_INFO[2]).clearContent(); manager_sheet.getRange(NAME_CHANGE_INFO[3]).clearContent(); SpreadsheetApp.flush();

SpreadsheetApp.getUi().alert("'" + current_name + "' successfully renamed to '" + new_name + "'!"); }

Jotunheim_Backend.gs: // [RegistryStatus, PlayerName, TransactionStatusID, StatusOutput, TransactionData, LedgerRow, LedgerCol ]

const MODERATOR_FILE_URL = "https://docs.google.com/spreadsheets/d/1SG6qF9FuqzgbxEqfHw2mHE0r-7Y0V6WFClO2JXr63aM/edit"; const ADMIN_FILE_URL = "https://docs.google.com/spreadsheets/d/1YJUJ85-1GrxwNpzypzQugvGqVv3LsYyGuvBw1Ee8WOo/edit"; const ARCHIVE_FILE_URL = "https://docs.google.com/spreadsheets/d/1whyGF0bU53pHm2yaK4xOxJJWiLrx9IndY5jH11GzVzo/edit";

const ARCHIVE_LEDGER_IMPORTS = [ 'Import-PopupLedger', 'Import-HaldoreLedger', 'Import-BeehiveLedger', 'Import-AdminLedger' ];

// Shop Type, Shop #, Teller, Player, Date, Total, Ymir Flesh, Gold, Vidars Hammer

const LAYOUT_SHEET_NAME = 'LayoutManager'; const LAYOUT_SHEET_LIST = 'H6:H20';

// ============================================ // UTILITY FUNCTIONS // ============================================

function _ClearRanges(sheet, ranges) { if (sheet == null) { return; }

for (var i=0; i<ranges.length; i++) { var range = ranges[i]; sheet.getRange(range).clear({contentsOnly: true, skipFilteredRows: true}); } }

// ============================================ // LAYOUT MANAGER // ============================================

function ApplyModeratorLayout() { var moderator_file = SpreadsheetApp.openByUrl(MODERATOR_FILE_URL); if (moderator_file == null) { SpreadsheetApp.getUi().alert("Unable to open file:\n" + MODERATOR_FILE_URL); return; }

var layout_manager = SpreadsheetApp.getActive().getSheetByName(LAYOUT_SHEET_NAME); if (layout_manager == null) { SpreadsheetApp.getUi().alert("Unable to open sheet:\n" + LAYOUT_SHEET_NAME); return; }

SpreadsheetApp.flush();

var moderator_sheet_list = moderator_file.getSheets(); var shown_sheets = []; var layout_list = layout_manager.getRange(LAYOUT_SHEET_LIST).getValues(); for (var i=0; i<layout_list.length; i++) { if (layout_list[i][0] != "") { shown_sheets.push(layout_list[i][0]); } }

for (var i=0; i<moderator_sheet_list.length; i++) {
if (shown_sheets.indexOf(moderator_sheet_list[i].getName()) > -1) { moderator_sheet_list[i].showSheet(); } else { moderator_sheet_list[i].hideSheet(); }

} }

ItemList.gs: function fetchDataFromAPI() { const url = 'https://jotun.games/wp-json/jotunheim-magic/v1/items/'; const response = UrlFetchApp.fetch(url); // Make GET request const jsonData = JSON.parse(response.getContentText()); // Parse JSON response

// Define headers with corrected field names, including 'prefab_name' const headers = [ 'item_name', 'tech_tier', 'tech_name', 'item_type', 'stack_size', 'undercut', 'unit_price', 'lv2_price', 'lv3_price', 'lv4_price', 'lv5_price', 'prefab_name' ];

const output = [];

// Process each item, applying replacements to sanitize text fields jsonData.forEach(item => { const row = headers.map(header => { if (typeof item[header] === 'string') { // Remove all occurrences of double backslashes followed by an apostrophe return item[header].replace(/\{2,}/g, "\").replace(/\'/g, "'"); } return item[header]; }); output.push(row); });

return output; }

function importData() { const spreadsheet = SpreadsheetApp.getActiveSpreadsheet(); const data = fetchDataFromAPI();

// Set custom headers for the first row, including 'Prefab Name' const customHeaders = [ 'Item Name', 'Tech Tier', 'Tech Name', 'Type', 'Stack Size', 'Undercut', 'Unit Price', 'Lv2 Price', 'Lv3 Price', 'Lv4 Price', 'Lv5 Price', 'Prefab Name' ];

// Define the sheet names you want to import data to const sheetNames = ["ItemList", "ItemData"];

// Loop through each sheet name and attempt to import data if the sheet exists sheetNames.forEach(sheetName => { const sheet = spreadsheet.getSheetByName(sheetName);

Code
if (sheet) {
  // Clear existing data in the sheet
  sheet.clear();
  
  // Set headers in the first row
  sheet.getRange(1, 1, 1, customHeaders.length).setValues([customHeaders]);
  
  // Insert data starting from row 2
  sheet.getRange(2, 1, data.length, data[0].length).setValues(data);
  
  // Convert 'Undercut' column values in the sheet to "TRUE" and "FALSE"
  const undercutRange = sheet.getRange(2, 6, data.length, 1); // Column F (Undercut)
  const undercutValues = undercutRange.getValues();

  // Modify values in the 'Undercut' column to "TRUE" or "FALSE"
  for (let i = 0; i < undercutValues.length; i++) {
    undercutValues[i][0] = undercutValues[i][0] === 1 ? "TRUE" : "FALSE";
  }

  // Set the modified values back to the 'Undercut' column
  undercutRange.setValues(undercutValues);
}
// If the sheet does not exist, this iteration is skipped without error
}); }

Jotunheim_Staff.gs: const LEDGER_ARCHIVE_URL = "https://docs.google.com/spreadsheets/d/1whyGF0bU53pHm2yaK4xOxJJWiLrx9IndY5jH11GzVzo/edit"; const ARCHIVE_PLAYER_REGISTRY_SHEET = 'Player Registry'; const ARCHIVE_PLAYER_DATA_RANGE = 'A2:A';

const VALID_TRANSACTION_STATUS_ID = 1; const DEBUG_MODE = false;

const POPUP_REGISTRY_STATUS = 'R3'; const POPUP_PLAYER_NAME = 'B5'; const POPUP_TRANSACTION_STATUS_ID = 'P3'; const POPUP_TRANSACTION_STATUS_OUTPUT = 'I2'; const POPUP_TRANSACTION_AUTOFILL = 'G7'; const POPUP_TRANSACTION_DATA = 'U3:DD3'; const POPUP_CLEAR_RANGES = ['B5:B6', 'F5:G6', 'D13:E26']; const POPUP_SUCCESS_MSG = 'U6';

const HALDORE_REGISTRY_STATUS = 'R3'; const HALDORE_PLAYER_NAME = 'B5'; const HALDORE_TRANSACTION_STATUS_ID = 'P3'; const HALDORE_TRANSACTION_STATUS_OUTPUT = 'I2'; const HALDORE_TRANSACTION_AUTOFILL = 'L3'; // purpose: _RecordToLedger() argument criteria const HALDORE_TRANSACTION_DATA = 'U3:DD3'; const HALDORE_CLEAR_RANGES = ['B5:B6', 'D17:E44']; const HALDORE_SUCCESS_MSG = 'U6';

const BEEHIVE_REGISTRY_STATUS = 'R3'; const BEEHIVE_PLAYER_NAME = 'B5'; const BEEHIVE_TRANSACTION_STATUS_ID = 'P3'; const BEEHIVE_TRANSACTION_STATUS_OUTPUT = 'I2'; const BEEHIVE_TRANSACTION_AUTOFILL = 'G7'; const BEEHIVE_TRANSACTION_DATA = 'U3:DD3'; const BEEHIVE_CLEAR_RANGES = ['B5:B6', 'F5:G6', 'D13:D15']; const BEEHIVE_SUCCESS_MSG = 'U6';

const POPUP_LEDGER_SHEET = "Popup Ledger"; const HALDORE_LEDGER_SHEET = "HaldORE Ledger"; const BEEHIVE_LEDGER_SHEET = "Beehive Ledger";

// ============================================ // UTILITY FUNCTIONS // ============================================

function _ClearRanges(sheet, ranges) { if (sheet == null) { return; }

for (var i=0; i<ranges.length; i++) { var range = ranges[i]; sheet.getRange(range).clear({contentsOnly: true, skipFilteredRows: true}); } }

function PopupClear() { var sheet = SpreadsheetApp.getActive().getActiveSheet(); if (sheet == null) { return; } _ClearRanges(sheet, POPUP_CLEAR_RANGES); }

function HaldoreClear() { var sheet = SpreadsheetApp.getActive().getActiveSheet(); if (sheet == null) { return; } _ClearRanges(sheet, HALDORE_CLEAR_RANGES); }

function BeehiveClear() { var sheet = SpreadsheetApp.getActive().getActiveSheet(); if (sheet == null) { return; } _ClearRanges(sheet, BEEHIVE_CLEAR_RANGES); }

// ============================================ // PLAYER REGISTRATION // ============================================

function _RegisterPlayer(registry_status_cell, player_name_cell) {

// check for errors and validate sheets

var teller_sheet = SpreadsheetApp.getActive().getActiveSheet(); if (teller_sheet == null) { SpreadsheetApp.getUi().alert("Invalid active sheet(?)"); return; }

var reg_status = teller_sheet.getRange(registry_status_cell).getValue(); var player_name = teller_sheet.getRange(player_name_cell).getValue();

if (reg_status == -1 || player_name == "") { SpreadsheetApp.getUi().alert("Player name must not be blank"); return; } if (reg_status > 0) { SpreadsheetApp.getUi().alert("Name already exists"); return; }

var registry_spreadsheet = SpreadsheetApp.openByUrl(LEDGER_ARCHIVE_URL); if (registry_spreadsheet == null) { SpreadsheetApp.getUi().alert("Unable to open file:\n" + LEDGER_ARCHIVE_URL); return; }

var player_registry_sheet = registry_spreadsheet.getSheetByName(ARCHIVE_PLAYER_REGISTRY_SHEET) if (player_registry_sheet == null) { SpreadsheetApp.getUi().alert("Invalid registry sheet '" + ARCHIVE_PLAYER_REGISTRY_SHEET + "'"); return; }

// ignore duplicate entries

var name_exists = player_registry_sheet.getRange(ARCHIVE_PLAYER_DATA_RANGE).createTextFinder(player_name).matchEntireCell(true).findNext(); if (name_exists != null) { SpreadsheetApp.getUi().alert("Duplicate name found"); return; }

// add the player to the registry

player_registry_sheet.appendRow([player_name]); SpreadsheetApp.getUi().alert("Successfully added player '" + player_name + "'");

return 0; }

function PopupRegisterPlayer() { _RegisterPlayer(POPUP_REGISTRY_STATUS, POPUP_PLAYER_NAME); }

function HaldoreRegisterPlayer() { _RegisterPlayer(HALDORE_REGISTRY_STATUS, HALDORE_PLAYER_NAME); }

function BeehiveRegisterPlayer() { _RegisterPlayer(BEEHIVE_REGISTRY_STATUS, BEEHIVE_PLAYER_NAME); }

// ============================================ // LEDGER RECORD & CLEAR // ============================================

function _RecordToLedger(ledger_sheet_name, transaction_status_id, transaction_status_output, transaction_data_range, player_name_cell, success_msg_cell, clear_ranges, autofill_cell) {

// Error check and validate sheets

var sheet_doc = SpreadsheetApp.getActive(); if (sheet_doc == null) { return "Null spreadsheet(?)"; }

var teller_sheet = sheet_doc.getActiveSheet(); if (teller_sheet == null) { return "Null active sheet(?)"; }

var ledger_data_sheet = sheet_doc.getSheetByName(ledger_sheet_name); if (ledger_data_sheet == null) { return "Invalid ledger sheet '" + ledger_sheet_name + "'"}

var ledger_archive_doc = SpreadsheetApp.openByUrl(LEDGER_ARCHIVE_URL); if (ledger_archive_doc == null) { return "Could not open spreadsheet:\n" + LEDGER_ARCHIVE_URL; }

var ledger_archive_data_sheet = ledger_archive_doc.getSheetByName(ledger_sheet_name); if (ledger_archive_data_sheet == null) { return "Invalid ledger archive sheet '" + ledger_sheet_name + "'"}

SpreadsheetApp.flush();

var status = teller_sheet.getRange(transaction_status_id).getValue(); var output = teller_sheet.getRange(transaction_status_output).getValue(); var transaction_data = teller_sheet.getRange(transaction_data_range).getValues(); var player_name = teller_sheet.getRange(player_name_cell).getValue(); var success_msg = teller_sheet.getRange(success_msg_cell).getValue();

// DEBUG

if (DEBUG_MODE) { SpreadsheetApp.getUi().alert( "DEBUG INFO:\n\n" + ledger_sheet_name + "\n" + transaction_status_id + " (status) : " + status + "\n" + transaction_status_output + " (output) : " + output + "\n" + transaction_data_range + " (data) rows :" + transaction_data.length + "\n" + player_name_cell + " : " + player_name + "\n\n" + success_msg_cell + " : " + success_msg + "\n\n" + clear_ranges + " (clear ranges) \n" + autofill_cell + " (autofill cell)" ); }

if (status != VALID_TRANSACTION_STATUS_ID) { var err_msg = "Transaction error:\n" + teller_sheet.getRange(transaction_status_output).getValue(); return err_msg; }

// Copy transaction

for (i=0; i<transaction_data.length; i++) { ledger_data_sheet.appendRow(transaction_data[i]); }

for (i=0; i<transaction_data.length; i++) { ledger_archive_data_sheet.appendRow(transaction_data[i]); }

_ClearRanges(teller_sheet, clear_ranges); teller_sheet.getRange(autofill_cell).setValue(false);

SpreadsheetApp.flush(); SpreadsheetApp.getUi().alert("Transaction with '" + player_name + "' recorded successfully!\n\n" + success_msg);

return 0; }

function PopupRecord() { var err = _RecordToLedger( POPUP_LEDGER_SHEET, POPUP_TRANSACTION_STATUS_ID, POPUP_TRANSACTION_STATUS_OUTPUT, POPUP_TRANSACTION_DATA, POPUP_PLAYER_NAME, POPUP_SUCCESS_MSG, POPUP_CLEAR_RANGES, POPUP_TRANSACTION_AUTOFILL);

if (err) { SpreadsheetApp.getUi().alert(err); } }

function HaldoreRecord() { var err = _RecordToLedger( HALDORE_LEDGER_SHEET, HALDORE_TRANSACTION_STATUS_ID, HALDORE_TRANSACTION_STATUS_OUTPUT, HALDORE_TRANSACTION_DATA, HALDORE_PLAYER_NAME, HALDORE_SUCCESS_MSG, HALDORE_CLEAR_RANGES, HALDORE_TRANSACTION_AUTOFILL);

if (err) { SpreadsheetApp.getUi().alert(err); } }

function BeehiveRecord() { var err = _RecordToLedger( BEEHIVE_LEDGER_SHEET, BEEHIVE_TRANSACTION_STATUS_ID, BEEHIVE_TRANSACTION_STATUS_OUTPUT, BEEHIVE_TRANSACTION_DATA, BEEHIVE_PLAYER_NAME, BEEHIVE_SUCCESS_MSG, BEEHIVE_CLEAR_RANGES, BEEHIVE_TRANSACTION_AUTOFILL);

if (err) { SpreadsheetApp.getUi().alert(err); } }

Jotunheim_Ledger.gs: const DEBUG_MODE = false;

const MODERATOR_FILE_URL = "https://docs.google.com/spreadsheets/d/1SG6qF9FuqzgbxEqfHw2mHE0r-7Y0V6WFClO2JXr63aM/edit"; const ADMIN_FILE_URL = "https://docs.google.com/spreadsheets/d/1YJUJ85-1GrxwNpzypzQugvGqVv3LsYyGuvBw1Ee8WOo/edit";

const LEDGER_PLAYER_INDEX = 4; // (array index) const LEDGER_PLAYER_RANGE = 'E5:E'; const LEDGER_DATA_RANGE = 'A5:DD'; const LEDGER_ENTRIES_ROW = 4;

// [ 0:Confirmation, 1:ConfirmKey, 2:Checkbox, 3:SheetName, 4:ArchiveName] const LEDGER_MANAGER_CURRENT_DATE = 'J5'; const LEDGER_MANAGER_SEED_NUMBER = 'J7';

const LEDGER_MANAGER_BEEHIVE_INFO = ['F8', 'D7', 'E7', 'F7', 'G7']; const LEDGER_MANAGER_POPUP_INFO = ['F13', 'D12', 'E12', 'F12', 'G12']; const LEDGER_MANAGER_HALDORE_INFO = ['F18', 'D17', 'E17', 'F17', 'G17']; const LEDGER_MANAGER_ADMIN_INFO = ['F26', 'D25', 'E25', 'F25', 'G25']; const LEDGER_MANAGER_VIDAR_INFO = ['F31', 'D30', 'E30', 'F30', 'G30'];

const LEGACY_ITEM_INDEX = 9; // (array index: Vidar's Hammer) const SHOP_TYPE_INDEX = 1; const RESET_SHOP_TYPE = "World Reset";

// [ 0:ValidAction, 1:ActionOutput, 2:CurrentName, 3:NewName, 4:RegistryName, 5:ArchiveName] const PLAYER_REGISTRY_DATA_RANGE = 'A2:A'; const NAME_CHANGE_INFO = ['F39', 'D35', 'D38', 'E38', 'F38', 'G38'];

// ============================================ // UTILITY FUNCTIONS // ============================================

function _ClearRanges(sheet, ranges) { if (sheet == null) { return; }

for (var i=0; i<ranges.length; i++) { var range = ranges[i]; sheet.getRange(range).clearContent(); } }

function _DeleteRowsAfter(sheet, row_index) { if (sheet.getMaxRows() >= row_index + 1) { sheet.deleteRows(row_index + 1, sheet.getMaxRows() - row_index); } sheet.getRange(row_index, 1, 1, sheet.getMaxColumns()).clearContent(); sheet.getRange(row_index, 1).setValues([["buffer row (ignore)"]]); }

// ============================================ // LEDGER MANAGER // ============================================

function _CopyAndClear(confirmation_data, source_ledger_url) {

var manager_sheet = SpreadsheetApp.getActive().getActiveSheet(); if (manager_sheet == null) { SpreadsheetApp.getUi().alert("Active sheet was null(?)"); return 0; }

var action_confirmed = manager_sheet.getRange(confirmation_data[0]).getValue(); if (!action_confirmed) { SpreadsheetApp.getUi().alert("Complete confirmation steps to perform this action."); return 0; }

let ledger_sheetname = manager_sheet.getRange(confirmation_data[3]).getValue(); var ledger_sheet = SpreadsheetApp.getActive().getSheetByName(ledger_sheetname); if (ledger_sheet == null) { SpreadsheetApp.getUi().alert("Unable to open sheet:\n" + ledger_sheetname); return 0; }

var archive_sheetname = manager_sheet.getRange(confirmation_data[4]).getValue(); var archive_sheet = SpreadsheetApp.getActive().getSheetByName(archive_sheetname); if (archive_sheet == null) { SpreadsheetApp.getUi().alert("Unable to open sheet:\n" + archive_sheetname); return 0; }

let source_spreadsheet = SpreadsheetApp.openByUrl(source_ledger_url); if (source_spreadsheet == null) { SpreadsheetApp.getUi().alert("Unable to open file:\n" + source_ledger_url); return 0; }

var source_ledger = source_spreadsheet.getSheetByName(ledger_sheetname); if (source_ledger == null) { SpreadsheetApp.getUi().alert("Unable to open sheet:\n" + ledger_sheetname); return 0; }

var data_copy;

if (ledger_sheet.getMaxRows() > LEDGER_ENTRIES_ROW) { data_copy = ledger_sheet.getRange(LEDGER_DATA_RANGE).getValues(); archive_sheet.getRange(archive_sheet.getMaxRows()+1, 1, data_copy.length, data_copy[0].length).setValues(data_copy); }

_DeleteRowsAfter(ledger_sheet, LEDGER_ENTRIES_ROW); _DeleteRowsAfter(source_ledger, LEDGER_ENTRIES_ROW); _ClearRanges(manager_sheet, [confirmation_data[1], confirmation_data[2]]);

SpreadsheetApp.flush();

if (data_copy == null) { SpreadsheetApp.getUi().alert("Ledgers cleared, but ledger data was empty!"); }

return data_copy; }

function ClearBeehiveLedger() { var data_copy = _CopyAndClear(LEDGER_MANAGER_BEEHIVE_INFO, MODERATOR_FILE_URL); if (data_copy) { SpreadsheetApp.getUi().alert("Beehive Ledger Cleared!"); } }

function ClearPopupLedger() { var data_copy = _CopyAndClear(LEDGER_MANAGER_POPUP_INFO, MODERATOR_FILE_URL); if (data_copy) { SpreadsheetApp.getUi().alert("Popup Ledger Cleared!"); } }

function ClearHaldoreLedger() { var data_copy = _CopyAndClear(LEDGER_MANAGER_HALDORE_INFO, MODERATOR_FILE_URL); if (data_copy) { SpreadsheetApp.getUi().alert("HaldORE Ledger Cleared!"); } }

// ============================================ // ADMIN LEDGER // ============================================

function ClearAdminLedger() {

var data_copy = _CopyAndClear(LEDGER_MANAGER_ADMIN_INFO, ADMIN_FILE_URL); if (!data_copy) { return; }

var manager_sheet = SpreadsheetApp.getActive().getActiveSheet(); var ledger_sheetname = manager_sheet.getRange(LEDGER_MANAGER_ADMIN_INFO[3]).getValue(); var ledger_sheet = SpreadsheetApp.getActive().getSheetByName(ledger_sheetname);

var world_id = manager_sheet.getRange(LEDGER_MANAGER_SEED_NUMBER).getValue(); var current_date = manager_sheet.getRange(LEDGER_MANAGER_CURRENT_DATE).getValue();

var new_ledger_data = []; var legacy_owners = [];

// Only look for -1 values from the previous world (current seed - 1) var previous_world_id = world_id - 1;

for (var i=0; i<data_copy.length; i++) { if (data_copy[i][LEGACY_ITEM_INDEX] == -1 && data_copy[i][0] == previous_world_id) { let owner_name = data_copy[i][LEDGER_PLAYER_INDEX]; if (legacy_owners.indexOf(owner_name) < 0) { legacy_owners.push(owner_name); } } }

if (legacy_owners.length < 1) { return; }

for (var i=0; i<legacy_owners.length; i++) {

Code
new_ledger_data.push([world_id, RESET_SHOP_TYPE, "n/a", "n/a", legacy_owners[i], current_date]);

for (var j=new_ledger_data[i].length; j<LEGACY_ITEM_INDEX; j++) {
  new_ledger_data[i].push(0);
}
new_ledger_data[i].push(1);
}

ledger_sheet.getRange(LEDGER_ENTRIES_ROW+1, 1, new_ledger_data.length, new_ledger_data[0].length).setValues(new_ledger_data);

var admin_spreadsheet = SpreadsheetApp.openByUrl(ADMIN_FILE_URL); if (admin_spreadsheet == null) { SpreadsheetApp.getUi().alert("Unable to open file:\n" + ADMIN_FILE_URL); return; }

var admin_sheet = admin_spreadsheet.getSheetByName(ledger_sheetname); if (admin_sheet == null) { SpreadsheetApp.getUi().alert("Invalid sheet:\n" + ledger_sheetname); return; }

admin_sheet.getRange(LEDGER_ENTRIES_ROW+1, 1, new_ledger_data.length, new_ledger_data[0].length).setValues(new_ledger_data);

SpreadsheetApp.getUi().alert("Admin Shop Ledger cleared!"); }

function LedgerVidarExpire() {

// check for errors and validate sheets

var confirmation_data = LEDGER_MANAGER_VIDAR_INFO; var source_ledger_url = ADMIN_FILE_URL;

var manager_sheet = SpreadsheetApp.getActive().getActiveSheet(); if (manager_sheet == null) { SpreadsheetApp.getUi().alert("Active sheet was null(?)"); return; }

var action_confirmed = manager_sheet.getRange(confirmation_data[0]).getValue(); if (!action_confirmed) { SpreadsheetApp.getUi().alert("Complete confirmation steps to perform this action."); return; }

let ledger_sheetname = manager_sheet.getRange(confirmation_data[3]).getValue(); var ledger_sheet = SpreadsheetApp.getActive().getSheetByName(ledger_sheetname); if (ledger_sheet == null) { SpreadsheetApp.getUi().alert("Invalid local ledger:\n" + ledger_sheetname); return; }

let admin_spreadsheet = SpreadsheetApp.openByUrl(ADMIN_FILE_URL); if (admin_spreadsheet == null) { SpreadsheetApp.getUi().alert("Unable to open file:\n" + source_ledger_url); return; }

let admin_ledger = admin_spreadsheet.getSheetByName(ledger_sheetname); if (admin_ledger == null) { SpreadsheetApp.getUi().alert("Invalid remote ledger:\n" + ledger_sheetname); return; }

// List each player that has claimed a legacy item

var claimed_list = []; var legacy_reset_row_count = 0; var legacy_data_values = ledger_sheet.getRange(LEDGER_DATA_RANGE).getValues();

for (var i=0; i<legacy_data_values.length; i++) {

Code
if (legacy_data_values[i][SHOP_TYPE_INDEX] == RESET_SHOP_TYPE) {
  legacy_reset_row_count += 1;
}

if (legacy_data_values[i][LEGACY_ITEM_INDEX] < 0) {
  var owner_name = legacy_data_values[i][LEDGER_PLAYER_INDEX].toString().toUpperCase();
  claimed_list.push(owner_name);
}
}

// End script early if there are no legacy items listed

if (legacy_reset_row_count == 0) { _ClearRanges(manager_sheet, [confirmation_data[1], confirmation_data[2]]); SpreadsheetApp.flush(); SpreadsheetApp.getUi().alert("No item claims to be expired."); return; }

// Copy the current range of ledger entries with the legacy item listed // and set the value to 0 if it has not been claimed yet

var updated_data = ledger_sheet.getRange(LEDGER_ENTRIES_ROW+1, 1, legacy_reset_row_count, LEGACY_ITEM_INDEX+1).getValues();

for (var i=0; i<updated_data.length; i++) { var player_name = updated_data[i][LEDGER_PLAYER_INDEX].toString().toUpperCase(); var owner_index = claimed_list.indexOf(player_name); if (owner_index < 0) { updated_data[i][LEGACY_ITEM_INDEX] = 0; } }

ledger_sheet.getRange(LEDGER_ENTRIES_ROW+1, 1, legacy_reset_row_count, LEGACY_ITEM_INDEX+1).setValues(updated_data); admin_ledger.getRange(LEDGER_ENTRIES_ROW+1, 1, legacy_reset_row_count, LEGACY_ITEM_INDEX+1).setValues(updated_data);

_ClearRanges(manager_sheet, [confirmation_data[1], confirmation_data[2]]);

SpreadsheetApp.flush(); SpreadsheetApp.getUi().alert("Claims to Vidar's Hammer have now expired!"); }

// ============================================ // PLAYER REGISTRY // ============================================

function _RenamePlayerInLedger(spreadsheet, ledger_sheet_name, target_name, new_name) {

if (spreadsheet == null) { SpreadsheetApp.getUi().alert("Ledger's spreadsheet was null"); return; }

let ledger_sheet = spreadsheet.getSheetByName(ledger_sheet_name); if (ledger_sheet == null) { SpreadsheetApp.getUi().alert("Invalid sheet:\n" + ledger_sheet_name); return; }

ledger_sheet.getRange(LEDGER_PLAYER_RANGE); let target_index = ledger_sheet.createTextFinder(target_name).matchEntireCell(true).findNext(); if (target_index == null) { if (DEBUG_MODE) { SpreadsheetApp.getUi().alert(ledger_sheet_name + "\n\nNo instances of '" + target_name + "' found"); } } else { let instance_count = 0; while (target_index) { target_index.setValue(new_name); instance_count += 1; target_index = null; target_index = ledger_sheet.createTextFinder(target_name).matchEntireCell(true).findNext(); } if (DEBUG_MODE) { SpreadsheetApp.getUi().alert(ledger_sheet_name + "\n\nAll " + instance_count + " instances of '" + target_name + "' renamed to '" + new_name + "'"); } } }

function RegistryRenamePlayer() {

// Error check and validate sheets

let manager_sheet = SpreadsheetApp.getActive().getActiveSheet(); if (manager_sheet == null) { SpreadsheetApp.getUi().alert("Active sheet was null(?)"); return; }

let action_status = manager_sheet.getRange(NAME_CHANGE_INFO[0]).getValue(); let action_output = manager_sheet.getRange(NAME_CHANGE_INFO[1]).getValue(); let current_date = manager_sheet.getRange(LEDGER_MANAGER_CURRENT_DATE).getValue(); let current_name = manager_sheet.getRange(NAME_CHANGE_INFO[2]).getValue(); let new_name = manager_sheet.getRange(NAME_CHANGE_INFO[3]).getValue(); let registry_sheet_name = manager_sheet.getRange(NAME_CHANGE_INFO[4]).getValue(); let name_history_sheet_name = manager_sheet.getRange(NAME_CHANGE_INFO[5]).getValue(); let admin_ledger_name = manager_sheet.getRange(LEDGER_MANAGER_ADMIN_INFO[3]).getValue(); let popup_ledger_name = manager_sheet.getRange(LEDGER_MANAGER_POPUP_INFO[3]).getValue(); let beehive_ledger_name = manager_sheet.getRange(LEDGER_MANAGER_BEEHIVE_INFO[3]).getValue(); let haldore_ledger_name = manager_sheet.getRange(LEDGER_MANAGER_HALDORE_INFO[3]).getValue();

// DEBUG INFO

if (DEBUG_MODE) { SpreadsheetApp.getUi().alert( "DEBUG INFO:\n\naction_status : " + action_status + "\n" + "action_output : " + action_output + "\n" + "current_date : " + current_date + "\n" + "current_name : " + current_name + "\n" + "new_name : " + new_name + "\n" + "registry_sheet : " + registry_sheet_name + "\n" + "archive_sheet : " + name_history_sheet_name + "\n" + "ledgers : " + admin_ledger_name + ", " + popup_ledger_name + ", " + beehive_ledger_name + ", " + haldore_ledger_name ); }

if (!action_status) { SpreadsheetApp.getUi().alert(action_output); return; }

let admin_spreadsheet = SpreadsheetApp.openByUrl(ADMIN_FILE_URL); if (admin_spreadsheet == null) { SpreadsheetApp.getUi().alert("Unable to open file:\n" + ADMIN_FILE_URL); return; }

let moderator_spreadsheet = SpreadsheetApp.openByUrl(MODERATOR_FILE_URL); if (moderator_spreadsheet == null) { SpreadsheetApp.getUi().alert("Unable to open file:\n" + MODERATOR_FILE_URL); return; }

let registry_sheet = SpreadsheetApp.getActive().getSheetByName(registry_sheet_name); if (registry_sheet == null) { SpreadsheetApp.getUi().alert("Invalid sheet:\n" + registry_sheet); return; }

let name_history_sheet = SpreadsheetApp.getActive().getSheetByName(name_history_sheet_name); if (name_history_sheet == null) { SpreadsheetApp.getUi().alert("Invalid sheet:\n" + name_history_sheet_name); return; }

// Update the player registry var player_registry_data = registry_sheet.getRange(PLAYER_REGISTRY_DATA_RANGE); var target_index = player_registry_data.createTextFinder(current_name).matchEntireCell(true).findNext(); if (target_index == null) { SpreadsheetApp.getUi().alert("Could not find player '" + current_name + "'"); return; }

name_history_sheet.appendRow([new_name, current_name, current_date]); target_index.setValue(new_name);

_RenamePlayerInLedger(SpreadsheetApp.getActive(), admin_ledger_name, current_name, new_name); _RenamePlayerInLedger(SpreadsheetApp.getActive(), popup_ledger_name, current_name, new_name); _RenamePlayerInLedger(SpreadsheetApp.getActive(), beehive_ledger_name, current_name, new_name); _RenamePlayerInLedger(SpreadsheetApp.getActive(), haldore_ledger_name, current_name, new_name);

_RenamePlayerInLedger(admin_spreadsheet, admin_ledger_name, current_name, new_name); _RenamePlayerInLedger(moderator_spreadsheet, popup_ledger_name, current_name, new_name); _RenamePlayerInLedger(moderator_spreadsheet, beehive_ledger_name, current_name, new_name); _RenamePlayerInLedger(moderator_spreadsheet, haldore_ledger_name, current_name, new_name);

manager_sheet.getRange(NAME_CHANGE_INFO[2]).clearContent(); manager_sheet.getRange(NAME_CHANGE_INFO[3]).clearContent(); SpreadsheetApp.flush();

SpreadsheetApp.getUi().alert("'" + current_name + "' successfully renamed to '" + new_name + "'!"); }