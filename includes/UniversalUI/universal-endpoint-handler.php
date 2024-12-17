<?php
header('Content-Type: application/json');

// WordPress environment assumed to be loaded via jotunheim-magic.php
global $wpdb;

$action = isset($_REQUEST['action']) ? sanitize_text_field($_REQUEST['action']) : '';
$table = isset($_REQUEST['table']) ? sanitize_text_field($_REQUEST['table']) : '';
$response = [];

// Validate required parameters
if (empty($action)) {
    echo json_encode(['error' => 'No action specified.']);
    exit;
}

// Fetch endpoint configuration
$api_endpoints = $wpdb->get_results("SELECT * FROM jotun_api_endpoints WHERE enabled = 1", OBJECT_K, 'name');
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
if (empty($table) || !in_array($table, $allowed_tables)) {
    echo json_encode(['error' => 'Invalid or unauthorized table specified.']);
    exit;
}

try {
    // Execute actions (same as before)
    if ($action === 'get_players') {
        $records = $wpdb->get_results("SELECT * FROM `$table`", ARRAY_A);
        echo json_encode($records ?: []);
    }
    // Additional actions omitted for brevity...

} catch (Exception $e) {
    error_log('Error in endpoint handler: ' . $e->getMessage());
    echo json_encode(['error' => $e->getMessage()]);
}
exit;