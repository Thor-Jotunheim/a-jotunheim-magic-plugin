<?php
header('Content-Type: application/json');
// WordPress environment is assumed to be loaded via jotunheim-magic.php

global $wpdb;

// Get action from request
$action = isset($_POST['action']) ? sanitize_text_field($_POST['action']) : '';
$response = [];

// Fetch available tables with prefix `jotun_`
if ($action === 'get_tables') {
    $tables = $wpdb->get_results("SHOW TABLES LIKE 'jotun_%'", ARRAY_N);
    foreach ($tables as $table) {
        $response[] = $table[0];
    }
    echo json_encode($response);
    exit;
}

// Fetch table schema for a specific table
if ($action === 'get_table_schema') {
    $table = isset($_POST['table']) ? sanitize_text_field($_POST['table']) : '';
    if (!empty($table)) {
        $schema = $wpdb->get_results("DESCRIBE `$table`", ARRAY_A);

        // Add logic to adapt schema for form generation
        foreach ($schema as &$column) {
            if (stripos($column['Type'], 'int') !== false) {
                $column['FieldType'] = 'number';
            } elseif (stripos($column['Type'], 'text') !== false || stripos($column['Type'], 'varchar') !== false) {
                $column['FieldType'] = 'text';
            } elseif (stripos($column['Type'], 'date') !== false) {
                $column['FieldType'] = 'date';
            } else {
                $column['FieldType'] = 'text'; // Default field type
            }
        }
        
        echo json_encode($schema);
        exit;
    } else {
        echo json_encode(['error' => 'Table name is required.']);
        exit;
    }
}

// Save data to a specific table
if ($action === 'save') {
    $table = isset($_GET['table']) ? sanitize_text_field($_GET['table']) : '';
    if (!empty($table)) {
        $data = [];
        foreach ($_POST as $key => $value) {
            if ($key !== 'action') {
                $data[sanitize_text_field($key)] = sanitize_text_field($value);
            }
        }

        if (!empty($data)) {
            $inserted = $wpdb->insert($table, $data);
            if ($inserted !== false) {
                echo json_encode(['success' => true, 'message' => 'Data saved successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error saving data.']);
            }
        } else {
            echo json_encode(['error' => 'No data provided to save.']);
        }
    } else {
        echo json_encode(['error' => 'Table name is required.']);
    }
    exit;
}

// Default response if no valid action
echo json_encode(['error' => 'Invalid action.']);
exit;
