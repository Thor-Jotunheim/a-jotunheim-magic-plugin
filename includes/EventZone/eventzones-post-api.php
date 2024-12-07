<?php
// File: eventzones-post-api.php

// Prevent direct access
if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'eventzones-permission.php';

add_action('rest_api_init', function () {
    // POST endpoint for creating event zones
    register_rest_route('jotunheim-magic/v1', '/eventzones', array(
        'methods' => 'POST',
        'callback' => 'create_eventzone_rest',
        'permission_callback' => 'can_manage_eventzones',
    ));
});

// Callback function for creating a new event zone
function create_eventzone_rest($request) {
    global $wpdb;
    $table_name = 'jotun_eventzones';
    $logs_table = 'jotun_eventzone_logs'; // Log table name

    // Get columns of the eventzones table dynamically
    $columns = $wpdb->get_col("DESCRIBE $table_name", 0);
    $data = array();

    // Populate $data array with values from $request if they match column names
    foreach ($columns as $column) {
        if ($request->has_param($column)) {
            $value = $request[$column];
            $data[$column] = is_numeric($value) ? $value + 0 : sanitize_text_field($value);
        }
    }

    // Insert a new event zone
    $result = $wpdb->insert($table_name, $data);

    if ($result === false) {
        error_log("Failed to create event zone: " . $wpdb->last_error);
        return new WP_Error('creation_failed', 'Failed to create event zone', array('status' => 500));
    }

    $new_zone_id = $wpdb->insert_id;

// Log the creation action
$current_user = wp_get_current_user();

if (!$current_user->exists()) {
    error_log("No authenticated user in PUT/POST handler.");
    $username = 'Guest';
} else {
    $username = $current_user->user_login;
    error_log("Authenticated user in PUT/POST handler: $username");
}

$timestamp = current_time('mysql');
$details = 'Created a new event zone.';

$log_result = $wpdb->insert(
    $logs_table,
    array(
        'zone_id'   => $zone_id,
        'user_id'   => $username, // Log the username instead of numeric user_id
        'action'    => 'update',
        'timestamp' => $timestamp,
        'details'   => $details,
    ),
    array('%d', '%s', '%s', '%s', '%s') // Adjusted to match `user_id` as VARCHAR
);

if ($log_result === false) {
    error_log("Logging failed for creation of Zone ID $new_zone_id: " . $wpdb->last_error);
}


    return rest_ensure_response(array('status' => 'created', 'zone_id' => $new_zone_id, 'message' => 'Event zone created successfully.'));
}
?>