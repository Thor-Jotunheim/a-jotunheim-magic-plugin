const DEBUG_MODE = false;

const MODERATOR_FILE_URL = "https://docs.google.com/spreadsheets/d/1SG6qF9FuqzgbxEqfHw2mHE0r-7Y0V6WFClO2JXr63aM/edit";
const ADMIN_FILE_URL = "https://docs.google.com/spreadsheets/d/1YJUJ85-1GrxwNpzypzQugvGqVv3LsYyGuvBw1Ee8WOo/edit";

const LEDGER_PLAYER_INDEX = 4; // (array index)
const LEDGER_PLAYER_RANGE = 'E5:E';
const LEDGER_DATA_RANGE = 'A5:DD';
const LEDGER_ENTRIES_ROW = 4;

// [ 0:Confirmation, 1:ConfirmKey, 2:Checkbox, 3:SheetName, 4:ArchiveName]
const LEDGER_MANAGER_CURRENT_DATE = 'J5';
const LEDGER_MANAGER_SEED_NUMBER = 'J7';

const LEDGER_MANAGER_BEEHIVE_INFO = ['F8', 'D7', 'E7', 'F7', 'G7'];
const LEDGER_MANAGER_POPUP_INFO = ['F13', 'D12', 'E12', 'F12', 'G12'];
const LEDGER_MANAGER_HALDORE_INFO = ['F18', 'D17', 'E17', 'F17', 'G17'];
const LEDGER_MANAGER_ADMIN_INFO = ['F26', 'D25', 'E25', 'F25', 'G25'];
const LEDGER_MANAGER_VIDAR_INFO = ['F31', 'D30', 'E30', 'F30', 'G30'];

const LEGACY_ITEM_INDEX = 9; // (array index: Vidar's Hammer)
const SHOP_TYPE_INDEX = 1;
const RESET_SHOP_TYPE = "World Reset";


// [ 0:ValidAction, 1:ActionOutput, 2:CurrentName, 3:NewName, 4:RegistryName, 5:ArchiveName]
const PLAYER_REGISTRY_DATA_RANGE = 'A2:A';
const NAME_CHANGE_INFO = ['F39', 'D35', 'D38', 'E38', 'F38', 'G38'];


// ============================================
//    UTILITY FUNCTIONS
// ============================================

function _ClearRanges(sheet, ranges) {
  if (sheet == null) { return; }

  for (var i=0; i<ranges.length; i++) {
    var range = ranges[i];
    sheet.getRange(range).clearContent();
  }
}

function _DeleteRowsAfter(sheet, row_index) {
  if (sheet.getMaxRows() >= row_index + 1) {
    sheet.deleteRows(row_index + 1, sheet.getMaxRows() - row_index);
  }
  sheet.getRange(row_index, 1, 1, sheet.getMaxColumns()).clearContent();
  sheet.getRange(row_index, 1).setValues([["buffer row (ignore)"]]);
}


// ============================================
//    LEDGER MANAGER
// ============================================


function _CopyAndClear(confirmation_data, source_ledger_url) {

  var manager_sheet = SpreadsheetApp.getActive().getActiveSheet();
  if (manager_sheet == null) { SpreadsheetApp.getUi().alert("Active sheet was null(?)"); return 0; }

  var action_confirmed = manager_sheet.getRange(confirmation_data[0]).getValue();
  if (!action_confirmed) { SpreadsheetApp.getUi().alert("Complete confirmation steps to perform this action."); return 0; }
  
  let ledger_sheetname = manager_sheet.getRange(confirmation_data[3]).getValue();
  var ledger_sheet = SpreadsheetApp.getActive().getSheetByName(ledger_sheetname);
  if (ledger_sheet == null) { SpreadsheetApp.getUi().alert("Unable to open sheet:\n" + ledger_sheetname); return 0; }

  var archive_sheetname = manager_sheet.getRange(confirmation_data[4]).getValue();
  var archive_sheet = SpreadsheetApp.getActive().getSheetByName(archive_sheetname);
  if (archive_sheet == null) { SpreadsheetApp.getUi().alert("Unable to open sheet:\n" + archive_sheetname); return 0; }

  let source_spreadsheet = SpreadsheetApp.openByUrl(source_ledger_url);
  if (source_spreadsheet == null) { SpreadsheetApp.getUi().alert("Unable to open file:\n" + source_ledger_url); return 0; }

  var source_ledger = source_spreadsheet.getSheetByName(ledger_sheetname);
  if (source_ledger == null) { SpreadsheetApp.getUi().alert("Unable to open sheet:\n" + ledger_sheetname); return 0; }

  var data_copy;

  if (ledger_sheet.getMaxRows() > LEDGER_ENTRIES_ROW) {
    data_copy = ledger_sheet.getRange(LEDGER_DATA_RANGE).getValues();
    archive_sheet.getRange(archive_sheet.getMaxRows()+1, 1, data_copy.length, data_copy[0].length).setValues(data_copy);
  }

  _DeleteRowsAfter(ledger_sheet, LEDGER_ENTRIES_ROW);
  _DeleteRowsAfter(source_ledger, LEDGER_ENTRIES_ROW);
  _ClearRanges(manager_sheet, [confirmation_data[1], confirmation_data[2]]);

  SpreadsheetApp.flush();
  
  if (data_copy == null) { SpreadsheetApp.getUi().alert("Ledgers cleared, but ledger data was empty!"); }

  return data_copy;
}

function ClearBeehiveLedger() {
  var data_copy = _CopyAndClear(LEDGER_MANAGER_BEEHIVE_INFO, MODERATOR_FILE_URL);
  if (data_copy) { SpreadsheetApp.getUi().alert("Beehive Ledger Cleared!"); }
}

function ClearPopupLedger() {
  var data_copy = _CopyAndClear(LEDGER_MANAGER_POPUP_INFO, MODERATOR_FILE_URL);
  if (data_copy) { SpreadsheetApp.getUi().alert("Popup Ledger Cleared!"); }
}

function ClearHaldoreLedger() {
  var data_copy = _CopyAndClear(LEDGER_MANAGER_HALDORE_INFO, MODERATOR_FILE_URL);
  if (data_copy) { SpreadsheetApp.getUi().alert("HaldORE Ledger Cleared!"); }
}

// ============================================
//    ADMIN LEDGER
// ============================================


function ClearAdminLedger() {

  var data_copy = _CopyAndClear(LEDGER_MANAGER_ADMIN_INFO, ADMIN_FILE_URL);
  if (!data_copy) { return; }

  var manager_sheet = SpreadsheetApp.getActive().getActiveSheet();
  var ledger_sheetname = manager_sheet.getRange(LEDGER_MANAGER_ADMIN_INFO[3]).getValue();
  var ledger_sheet = SpreadsheetApp.getActive().getSheetByName(ledger_sheetname);

  var world_id = manager_sheet.getRange(LEDGER_MANAGER_SEED_NUMBER).getValue();
  var current_date = manager_sheet.getRange(LEDGER_MANAGER_CURRENT_DATE).getValue();

  var new_ledger_data = [];
  var legacy_owners = [];

  // Only look for -1 values from the previous world (current seed - 1)
  var previous_world_id = world_id - 1;

  for (var i=0; i<data_copy.length; i++) {
    if (data_copy[i][LEGACY_ITEM_INDEX] == -1 && data_copy[i][0] == previous_world_id) {
      let owner_name = data_copy[i][LEDGER_PLAYER_INDEX];
      if (legacy_owners.indexOf(owner_name) < 0) {
        legacy_owners.push(owner_name);
      }
    }
  }

  if (legacy_owners.length < 1) { return; }

  for (var i=0; i<legacy_owners.length; i++) {

    new_ledger_data.push([world_id, RESET_SHOP_TYPE, "n/a", "n/a", legacy_owners[i], current_date]);

    for (var j=new_ledger_data[i].length; j<LEGACY_ITEM_INDEX; j++) {
      new_ledger_data[i].push(0);
    }
    new_ledger_data[i].push(1);
  }

  ledger_sheet.getRange(LEDGER_ENTRIES_ROW+1, 1, new_ledger_data.length, new_ledger_data[0].length).setValues(new_ledger_data);

   var admin_spreadsheet = SpreadsheetApp.openByUrl(ADMIN_FILE_URL);
  if (admin_spreadsheet == null) { SpreadsheetApp.getUi().alert("Unable to open file:\n" + ADMIN_FILE_URL); return; }

  var admin_sheet = admin_spreadsheet.getSheetByName(ledger_sheetname);
  if (admin_sheet == null) { SpreadsheetApp.getUi().alert("Invalid sheet:\n" + ledger_sheetname); return; }

  admin_sheet.getRange(LEDGER_ENTRIES_ROW+1, 1, new_ledger_data.length, new_ledger_data[0].length).setValues(new_ledger_data);

  SpreadsheetApp.getUi().alert("Admin Shop Ledger cleared!");
}


function LedgerVidarExpire() {

  // check for errors and validate sheets

  var confirmation_data = LEDGER_MANAGER_VIDAR_INFO;
  var source_ledger_url = ADMIN_FILE_URL;

  var manager_sheet = SpreadsheetApp.getActive().getActiveSheet();
  if (manager_sheet == null) { SpreadsheetApp.getUi().alert("Active sheet was null(?)"); return; }

  var action_confirmed = manager_sheet.getRange(confirmation_data[0]).getValue();
  if (!action_confirmed) { SpreadsheetApp.getUi().alert("Complete confirmation steps to perform this action."); return; }
  
  let ledger_sheetname = manager_sheet.getRange(confirmation_data[3]).getValue();
  var ledger_sheet = SpreadsheetApp.getActive().getSheetByName(ledger_sheetname);
  if (ledger_sheet == null) { SpreadsheetApp.getUi().alert("Invalid local ledger:\n" + ledger_sheetname); return; }

  let admin_spreadsheet = SpreadsheetApp.openByUrl(ADMIN_FILE_URL);
  if (admin_spreadsheet == null) { SpreadsheetApp.getUi().alert("Unable to open file:\n" + source_ledger_url); return; }
  
  let admin_ledger = admin_spreadsheet.getSheetByName(ledger_sheetname);
  if (admin_ledger == null) { SpreadsheetApp.getUi().alert("Invalid remote ledger:\n" + ledger_sheetname); return; }

  // List each player that has claimed a legacy item

  var claimed_list = [];
  var legacy_reset_row_count = 0;
  var legacy_data_values = ledger_sheet.getRange(LEDGER_DATA_RANGE).getValues();

  for (var i=0; i<legacy_data_values.length; i++) {

    if (legacy_data_values[i][SHOP_TYPE_INDEX] == RESET_SHOP_TYPE) {
      legacy_reset_row_count += 1;
    }

    if (legacy_data_values[i][LEGACY_ITEM_INDEX] < 0) {
      var owner_name = legacy_data_values[i][LEDGER_PLAYER_INDEX].toString().toUpperCase();
      claimed_list.push(owner_name);
    }
  }

  // End script early if there are no legacy items listed

  if (legacy_reset_row_count == 0) { 
    _ClearRanges(manager_sheet, [confirmation_data[1], confirmation_data[2]]);
    SpreadsheetApp.flush();
    SpreadsheetApp.getUi().alert("No item claims to be expired."); 
    return;
  }

  
  // Copy the current range of ledger entries with the legacy item listed
  // and set the value to 0 if it has not been claimed yet

  var updated_data = ledger_sheet.getRange(LEDGER_ENTRIES_ROW+1, 1, legacy_reset_row_count, LEGACY_ITEM_INDEX+1).getValues();

  for (var i=0; i<updated_data.length; i++) {
    var player_name = updated_data[i][LEDGER_PLAYER_INDEX].toString().toUpperCase();
    var owner_index = claimed_list.indexOf(player_name);
    if (owner_index < 0) {
      updated_data[i][LEGACY_ITEM_INDEX] = 0;
    }
  }

  ledger_sheet.getRange(LEDGER_ENTRIES_ROW+1, 1, legacy_reset_row_count, LEGACY_ITEM_INDEX+1).setValues(updated_data);
  admin_ledger.getRange(LEDGER_ENTRIES_ROW+1, 1, legacy_reset_row_count, LEGACY_ITEM_INDEX+1).setValues(updated_data);
  
  _ClearRanges(manager_sheet, [confirmation_data[1], confirmation_data[2]]);

  SpreadsheetApp.flush();
  SpreadsheetApp.getUi().alert("Claims to Vidar's Hammer have now expired!");
}


// ============================================
//    PLAYER REGISTRY
// ============================================

function _RenamePlayerInLedger(spreadsheet, ledger_sheet_name, target_name, new_name) {

  if (spreadsheet == null) { SpreadsheetApp.getUi().alert("Ledger's spreadsheet was null"); return; }

  let ledger_sheet = spreadsheet.getSheetByName(ledger_sheet_name);
  if (ledger_sheet == null) { SpreadsheetApp.getUi().alert("Invalid sheet:\n" + ledger_sheet_name); return; }

  ledger_sheet.getRange(LEDGER_PLAYER_RANGE);
  let target_index = ledger_sheet.createTextFinder(target_name).matchEntireCell(true).findNext();
  if (target_index == null) { 
    if (DEBUG_MODE) {
      SpreadsheetApp.getUi().alert(ledger_sheet_name + "\n\nNo instances of '" + target_name + "' found");
    }
  }
  else {
    let instance_count = 0;
    while (target_index) {
      target_index.setValue(new_name);
      instance_count += 1;
      target_index = null;
      target_index = ledger_sheet.createTextFinder(target_name).matchEntireCell(true).findNext();
    }
    if (DEBUG_MODE) {
      SpreadsheetApp.getUi().alert(ledger_sheet_name + "\n\nAll " + instance_count + " instances of '" + target_name + "' renamed to '" + new_name + "'");
    }
  }
}


function RegistryRenamePlayer() {

  // Error check and validate sheets

  let manager_sheet = SpreadsheetApp.getActive().getActiveSheet();
  if (manager_sheet == null) { SpreadsheetApp.getUi().alert("Active sheet was null(?)"); return; }

  let action_status = manager_sheet.getRange(NAME_CHANGE_INFO[0]).getValue();
  let action_output = manager_sheet.getRange(NAME_CHANGE_INFO[1]).getValue();
  let current_date = manager_sheet.getRange(LEDGER_MANAGER_CURRENT_DATE).getValue();
  let current_name = manager_sheet.getRange(NAME_CHANGE_INFO[2]).getValue();
  let new_name = manager_sheet.getRange(NAME_CHANGE_INFO[3]).getValue();
  let registry_sheet_name = manager_sheet.getRange(NAME_CHANGE_INFO[4]).getValue();
  let name_history_sheet_name = manager_sheet.getRange(NAME_CHANGE_INFO[5]).getValue();
  let admin_ledger_name = manager_sheet.getRange(LEDGER_MANAGER_ADMIN_INFO[3]).getValue();
  let popup_ledger_name = manager_sheet.getRange(LEDGER_MANAGER_POPUP_INFO[3]).getValue();
  let beehive_ledger_name = manager_sheet.getRange(LEDGER_MANAGER_BEEHIVE_INFO[3]).getValue();
  let haldore_ledger_name = manager_sheet.getRange(LEDGER_MANAGER_HALDORE_INFO[3]).getValue();

  // DEBUG INFO

  if (DEBUG_MODE) { 
    SpreadsheetApp.getUi().alert(
      "DEBUG INFO:\n\naction_status : " + action_status + "\n" +
      "action_output : " + action_output + "\n" +
      "current_date : " + current_date + "\n" +
      "current_name : " + current_name + "\n" +
      "new_name : " + new_name + "\n" +
      "registry_sheet : " + registry_sheet_name + "\n" +
      "archive_sheet : " + name_history_sheet_name + "\n" +
      "ledgers : " + admin_ledger_name + ", " + popup_ledger_name + ", " + beehive_ledger_name + ", " + haldore_ledger_name
    );
  }

  if (!action_status) { SpreadsheetApp.getUi().alert(action_output); return; }

  let admin_spreadsheet = SpreadsheetApp.openByUrl(ADMIN_FILE_URL);
  if (admin_spreadsheet == null) { SpreadsheetApp.getUi().alert("Unable to open file:\n" + ADMIN_FILE_URL); return; }

  let moderator_spreadsheet = SpreadsheetApp.openByUrl(MODERATOR_FILE_URL);
  if (moderator_spreadsheet == null) { SpreadsheetApp.getUi().alert("Unable to open file:\n" + MODERATOR_FILE_URL); return; }

  let registry_sheet = SpreadsheetApp.getActive().getSheetByName(registry_sheet_name);
  if (registry_sheet == null) { SpreadsheetApp.getUi().alert("Invalid sheet:\n" + registry_sheet); return; }
  
  let name_history_sheet = SpreadsheetApp.getActive().getSheetByName(name_history_sheet_name);
  if (name_history_sheet == null) { SpreadsheetApp.getUi().alert("Invalid sheet:\n" + name_history_sheet_name); return; }

  // Update the player registry
  var player_registry_data = registry_sheet.getRange(PLAYER_REGISTRY_DATA_RANGE);
  var target_index = player_registry_data.createTextFinder(current_name).matchEntireCell(true).findNext();
  if (target_index == null) { SpreadsheetApp.getUi().alert("Could not find player '" + current_name + "'"); return; }
  
  name_history_sheet.appendRow([new_name, current_name, current_date]);
  target_index.setValue(new_name);

  _RenamePlayerInLedger(SpreadsheetApp.getActive(), admin_ledger_name, current_name, new_name);
  _RenamePlayerInLedger(SpreadsheetApp.getActive(), popup_ledger_name, current_name, new_name);
  _RenamePlayerInLedger(SpreadsheetApp.getActive(), beehive_ledger_name, current_name, new_name);
  _RenamePlayerInLedger(SpreadsheetApp.getActive(), haldore_ledger_name, current_name, new_name);
  
  _RenamePlayerInLedger(admin_spreadsheet, admin_ledger_name, current_name, new_name);
  _RenamePlayerInLedger(moderator_spreadsheet, popup_ledger_name, current_name, new_name);
  _RenamePlayerInLedger(moderator_spreadsheet, beehive_ledger_name, current_name, new_name);
  _RenamePlayerInLedger(moderator_spreadsheet, haldore_ledger_name, current_name, new_name);

  manager_sheet.getRange(NAME_CHANGE_INFO[2]).clearContent();
  manager_sheet.getRange(NAME_CHANGE_INFO[3]).clearContent();
  SpreadsheetApp.flush();

  SpreadsheetApp.getUi().alert("'" + current_name + "' successfully renamed to '" + new_name + "'!");
}

