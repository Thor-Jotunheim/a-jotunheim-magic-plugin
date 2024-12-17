<?php
header('Content-Type: application/json');

// WordPress environment assumed to be loaded via jotunheim-magic.php
global $wpdb;

$action = isset($_REQUEST['action']) ? sanitize_text_field($_REQUEST['action']) : '';
$table = isset($_REQUEST['table']) ? sanitize_text_field($_REQUEST['table']) : '';
$response = [];

// Fetch endpoint configuration from jotun_api_endpoints
$api_endpoints = $wpdb->get_results("SELECT * FROM jotun_api_endpoints WHERE enabled = 1", OBJECT_K, 'name'); // Use the new 'name' column
if (!$api_endpoints) {
    echo json_encode(['error' => 'API configuration is unavailable.']);
    exit;
}

// Validate action
if (!isset($api_endpoints[$action])) {
    echo json_encode(['error' => 'Invalid action specified.']);
    exit;
}

// Ensure table exists and is allowed
$allowed_tables = array_map('esc_sql', $wpdb->get_col("SHOW TABLES LIKE 'jotun_%'"));
if (!in_array($table, $allowed_tables)) {
    echo json_encode(['error' => 'Invalid or unauthorized table specified.']);
    exit;
}

try {
    if ($action === 'get_players') { // Matches renamed API names
        $records = $wpdb->get_results("SELECT * FROM `$table`", ARRAY_A);
        echo json_encode($records ?: []);
    } elseif ($action === 'get_event_zones') {
        $records = $wpdb->get_results("SELECT * FROM `$table`", ARRAY_A);
        echo json_encode($records ?: []);
    } elseif ($action === 'get_event_zone_by_name') {
        $name = isset($_REQUEST['name']) ? sanitize_text_field($_REQUEST['name']) : '';
        if (!$name) throw new Exception('Event zone name is required.');

        $record = $wpdb->get_row($wpdb->prepare("SELECT * FROM `$table` WHERE name = %s", $name), ARRAY_A);
        echo json_encode($record ?: ['error' => 'Event zone not found.']);
    } elseif ($action === 'get_items') {
        $records = $wpdb->get_results("SELECT * FROM `$table`", ARRAY_A);
        echo json_encode($records ?: []);
    } elseif ($action === 'get_item_by_id') {
        $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
        if (!$id) throw new Exception('Invalid item ID.');

        $record = $wpdb->get_row($wpdb->prepare("SELECT * FROM `$table` WHERE id = %d", $id), ARRAY_A);
        echo json_encode($record ?: ['error' => 'Item not found.']);
    } elseif ($action === 'get_item_by_name') {
        $name = isset($_REQUEST['name']) ? sanitize_text_field($_REQUEST['name']) : '';
        if (!$name) throw new Exception('Item name is required.');

        $record = $wpdb->get_row($wpdb->prepare("SELECT * FROM `$table` WHERE name = %s", $name), ARRAY_A);
        echo json_encode($record ?: ['error' => 'Item not found.']);
    } elseif ($action === 'search_items') {
        $search = isset($_REQUEST['search']) ? sanitize_text_field($_REQUEST['search']) : '';
        $records = $wpdb->get_results($wpdb->prepare("SELECT * FROM `$table` WHERE name LIKE %s", "%$search%"), ARRAY_A);
        echo json_encode($records ?: []);
    } elseif ($action === 'add_player_column') {
        $column_name = isset($_REQUEST['column_name']) ? sanitize_text_field($_REQUEST['column_name']) : '';
        $column_type = isset($_REQUEST['column_type']) ? sanitize_text_field($_REQUEST['column_type']) : '';

        if (!$column_name || !$column_type) throw new Exception('Column name and type are required.');

        $wpdb->query("ALTER TABLE `$table` ADD COLUMN `$column_name` $column_type");
        echo json_encode(['success' => true, 'message' => 'Column added successfully.']);
    } else {
        throw new Exception('Invalid or unsupported action.');
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
exit;