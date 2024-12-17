<?php
header('Content-Type: application/json');

// WordPress environment assumed to be loaded via jotunheim-magic.php
global $wpdb;

// Enable debugging logs for troubleshooting
error_log("Starting universal-endpoint-handler.php");

// Capture request parameters
$action = isset($_REQUEST['action']) ? sanitize_text_field($_REQUEST['action']) : '';
$table = isset($_REQUEST['table']) ? sanitize_text_field($_REQUEST['table']) : '';
error_log("Action: $action, Table: $table");

$response = [];

// Validate required parameters
if (empty($action)) {
    error_log("Error: No action specified.");
    echo json_encode(['error' => 'No action specified.']);
    exit;
}

// Fetch endpoint configuration
try {
    error_log("Fetching endpoint configurations...");
    $api_endpoints = $wpdb->get_results("SELECT * FROM jotun_api_endpoints WHERE enabled = 1", OBJECT_K, 'name');
    if (!$api_endpoints) {
        error_log("Error: API configuration unavailable.");
        echo json_encode(['error' => 'API configuration is unavailable.']);
        exit;
    }
    error_log("Endpoints fetched successfully.");
} catch (Exception $e) {
    error_log("Error fetching endpoints: " . $e->getMessage());
    echo json_encode(['error' => 'Failed to fetch API endpoints.']);
    exit;
}

// Validate action
if (!isset($api_endpoints[$action])) {
    error_log("Error: Invalid action specified - $action");
    echo json_encode(['error' => 'Invalid action specified.']);
    exit;
}
error_log("Valid action: $action");

// Ensure table exists and is allowed
try {
    error_log("Validating table: $table...");
    $allowed_tables = array_map('esc_sql', $wpdb->get_col("SHOW TABLES LIKE 'jotun_%'"));
    if (empty($table) || !in_array($table, $allowed_tables)) {
        error_log("Error: Invalid or unauthorized table - $table");
        echo json_encode(['error' => 'Invalid or unauthorized table specified.']);
        exit;
    }
    error_log("Table validated: $table");
} catch (Exception $e) {
    error_log("Error validating table: " . $e->getMessage());
    echo json_encode(['error' => 'Failed to validate table.']);
    exit;
}

// Execute actions
try {
    if ($action === 'get_players') {
        error_log("Executing get_players action...");
        $records = $wpdb->get_results("SELECT * FROM `$table`", ARRAY_A);
        echo json_encode($records ?: []);
        error_log("get_players action completed successfully.");
    } elseif ($action === 'get_event_zones') {
        error_log("Executing get_event_zones action...");
        $records = $wpdb->get_results("SELECT * FROM `$table`", ARRAY_A);
        echo json_encode($records ?: []);
        error_log("get_event_zones action completed successfully.");
    } elseif ($action === 'get_event_zone_by_name') {
        $name = isset($_REQUEST['name']) ? sanitize_text_field($_REQUEST['name']) : '';
        if (!$name) throw new Exception('Event zone name is required.');

        error_log("Executing get_event_zone_by_name with name: $name...");
        $record = $wpdb->get_row($wpdb->prepare("SELECT * FROM `$table` WHERE name = %s", $name), ARRAY_A);
        echo json_encode($record ?: ['error' => 'Event zone not found.']);
        error_log("get_event_zone_by_name action completed.");
    } else {
        throw new Exception('Invalid or unsupported action.');
    }
} catch (Exception $e) {
    error_log("Error executing action '$action': " . $e->getMessage());
    echo json_encode(['error' => $e->getMessage()]);
}
exit;