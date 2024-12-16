<?php
header('Content-Type: application/json');
// WordPress environment is assumed to be loaded via jotunheim-magic.php

global $wpdb;

$action = isset($_REQUEST['action']) ? sanitize_text_field($_REQUEST['action']) : '';
$table = isset($_REQUEST['table']) ? sanitize_text_field($_REQUEST['table']) : '';
$response = [];

// List records from a table
if ($action === 'list_records' && !empty($table)) {
    $records = $wpdb->get_results("SELECT * FROM `$table`", ARRAY_A);
    echo json_encode($records);
    exit;
}

// Fetch details of a single record
if ($action === 'get_record' && !empty($table) && isset($_REQUEST['id'])) {
    $id = intval($_REQUEST['id']);
    $record = $wpdb->get_row($wpdb->prepare("SELECT * FROM `$table` WHERE id = %d", $id), ARRAY_A);
    echo json_encode($record);
    exit;
}

// Add a new record
if ($action === 'add_record' && !empty($table)) {
    $data = [];
    foreach ($_POST as $key => $value) {
        if ($key !== 'action' && $key !== 'table') {
            $data[sanitize_text_field($key)] = sanitize_text_field($value);
        }
    }

    if (!empty($data)) {
        $inserted = $wpdb->insert($table, $data);
        if ($inserted !== false) {
            echo json_encode(['success' => true, 'message' => 'Record added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error adding record.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No data provided to add.']);
    }
    exit;
}

// Update an existing record
if ($action === 'update_record' && !empty($table) && isset($_REQUEST['id'])) {
    $id = intval($_REQUEST['id']);
    $data = [];
    foreach ($_POST as $key => $value) {
        if ($key !== 'action' && $key !== 'table') {
            $data[sanitize_text_field($key)] = sanitize_text_field($value);
        }
    }

    if (!empty($data)) {
        $updated = $wpdb->update($table, $data, ['id' => $id]);
        if ($updated !== false) {
            echo json_encode(['success' => true, 'message' => 'Record updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating record.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No data provided to update.']);
    }
    exit;
}

// Delete a record
if ($action === 'delete_record' && !empty($table) && isset($_REQUEST['id'])) {
    $id = intval($_REQUEST['id']);
    $deleted = $wpdb->delete($table, ['id' => $id]);
    if ($deleted !== false) {
        echo json_encode(['success' => true, 'message' => 'Record deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting record.']);
    }
    exit;
}

// Default response if no valid action
echo json_encode(['error' => 'Invalid action or missing parameters.']);
exit;
