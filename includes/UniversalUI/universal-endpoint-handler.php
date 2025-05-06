<?php
header('Content-Type: application/json');

// WordPress environment assumed to be loaded via jotunheim-magic.php
global $wpdb;

// Enable debugging logs for troubleshooting
error_log("Starting universal-endpoint-handler.php");

// Allow execution only for valid AJAX or REST API requests
if (
    (!defined('DOING_AJAX') || !DOING_AJAX) &&
    (!defined('REST_REQUEST') || !REST_REQUEST)
) {
    error_log("Exiting: Not an AJAX or REST API request.");
    return;
}

// Capture request parameters
$action = isset($_REQUEST['action']) ? sanitize_text_field($_REQUEST['action']) : '';
$table = isset($_REQUEST['table']) ? sanitize_text_field($_REQUEST['table']) : '';
error_log("Action: $action, Table: $table");

// Skip invalid 'activate' requests
if ($action === 'activate' || empty($action)) {
    error_log("Skipping invalid or empty action: $action");
    echo json_encode(['status' => 'error', 'message' => 'Invalid or empty action.']);
    exit;
}

// Fetch endpoint configuration
try {
    error_log("Fetching endpoint configurations...");
    $api_endpoints = $wpdb->get_results("SELECT * FROM jotun_api_endpoints WHERE enabled = 1", OBJECT_K, 'name');
    if (!$api_endpoints) {
        error_log("Error: API configuration unavailable.");
        echo json_encode(['status' => 'error', 'message' => 'API configuration is unavailable.']);
        exit;
    }
    error_log("Endpoints fetched successfully.");
} catch (Exception $e) {
    error_log("Error fetching endpoints: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch API endpoints.']);
    exit;
}

// Process Actions
try {
    // Special handling for OAuth2 callback
    if ($action === 'oauth2callback') {
        error_log("Processing Discord OAuth2 callback");
        require_once(plugin_dir_path(__FILE__) . '../Discord/discord-oauth-handler.php');
        jotunheim_magic_handle_discord_oauth2_callback();
        exit;
    }
    
    // Check if action exists in API table
    if (!isset($api_endpoints[$action])) {
        error_log("Skipping unrecognized action: $action");
        return; // Exit without interfering with other plugins
    }

    // Valid action handling
    if ($action === 'get_players') {
        $records = $wpdb->get_results("SELECT * FROM `$table`", ARRAY_A);
        echo json_encode($records ?: []);
    } elseif ($action === 'get_event_zones') {
        $records = $wpdb->get_results("SELECT * FROM `$table`", ARRAY_A);
        echo json_encode($records ?: []);
    } else {
        error_log("Unsupported action: $action");
        echo json_encode(['status' => 'error', 'message' => 'Unsupported action.']);
    }
} catch (Exception $e) {
    error_log("Error processing action: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
exit;