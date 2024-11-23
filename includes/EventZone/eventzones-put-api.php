<?php
// File: eventzones-put-api.php

// Prevent direct access
if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'eventzones-permission.php';

add_action('rest_api_init', function () {
    // PUT endpoint for updating an existing event zone by ID
    register_rest_route('jotunheim-magic/v1', '/eventzones/(?P<id>\d+)', array(
        'methods' => 'PUT',
        'callback' => 'update_eventzone_put_rest',
        'permission_callback' => 'can_manage_eventzones',
        'args' => array(
            'id' => array(
                'required' => true,
                'validate_callback' => function ($param, $request, $key) {
                    return is_numeric($param);
                }
            ),
        ),
    ));
});

// Callback function for updating an existing event zone by ID
function update_eventzone_put_rest($request) {
    global $wpdb;
    $table_name = 'jotun_eventzones';
    $logs_table = 'jotun_eventzone_logs'; // Log table name
    $zone_id = intval($request['id']); // Get the ID from the request parameters

    // Get the columns dynamically
    $columns = $wpdb->get_col("DESCRIBE $table_name", 0);
    $data = array();

    foreach ($columns as $column) {
        if ($request->has_param($column)) {
            $value = $request[$column];
            $data[$column] = is_numeric($value) ? $value + 0 : sanitize_text_field($value);
        }
    }

    // Update the row based on the ID
    $result = $wpdb->update($table_name, $data, array('id' => $zone_id));

    if ($result === false) {
        error_log("Update failed for ID $zone_id: " . $wpdb->last_error);
        return new WP_Error('update_failed', 'Failed to update event zone.', array('status' => 500));
    }

    // Log the update action
$current_user = wp_get_current_user();

if (!$current_user->exists()) {
    error_log("No authenticated user in PUT/POST handler.");
    $username = 'Guest';
} else {
    $username = $current_user->user_login;
    error_log("Authenticated user in PUT/POST handler: $username");
}

    $timestamp = current_time('mysql');
    $details = 'Updated event zone fields: ' . implode(', ', array_keys($data));

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
        error_log("Logging failed for update on Zone ID $zone_id: " . $wpdb->last_error);
    }

    // Return a success response
    return rest_ensure_response(array(
        'status' => 'updated',
        'zone_id' => $zone_id,
        'message' => 'Event zone updated successfully.'
    ));
}
?>