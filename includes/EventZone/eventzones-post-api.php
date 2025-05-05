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
    
    // Check if user is logged in, if not return unauthorized status
    if (!is_user_logged_in()) {
        $user_id = 'Guest';
    } else {
        $user_id = get_current_user_id();
    }
    
    // Extract the event zone data
    $params = $request->get_params();
    
    // Get columns of the eventzones table dynamically
    $table_name = $wpdb->prefix . 'eventzones';
    $columns = $wpdb->get_col("DESCRIBE $table_name", 0);
    $data = array();

    // Populate $data array with values from $request if they match column names
    foreach ($columns as $column) {
        if ($request->has_param($column)) {
            $value = $request[$column];
            $data[$column] = is_numeric($value) ? $value + 0 : sanitize_text_field($value);
        }
    }

    // Insert the event zone data into the database
    $result = $wpdb->insert(
        $table_name,
        $data,
        array_fill(0, count($data), '%s') // Dynamically generate format array
    );
    
    if ($result === false) {
        return new WP_Error('db_error', 'Error inserting event zone data', array('status' => 500));
    }
    
    // Get the newly inserted event zone ID
    $zone_id = $wpdb->insert_id;
    
    // Log the creation event - only if we have a valid zone_id
    if (!empty($zone_id)) {
        $log_table_name = $wpdb->prefix . 'eventzone_logs';
        
        $log_result = $wpdb->insert(
            $log_table_name,
            array(
                'zone_id' => $zone_id,
                'user_id' => is_numeric($user_id) ? $user_id : 'Guest',
                'action' => 'update',
                'timestamp' => current_time('mysql'),
                'details' => 'Created a new event zone.',
            ),
            array(
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
            )
        );
        
        if ($log_result === false) {
            error_log("Logging failed for creation of Zone ID {$zone_id}: " . $wpdb->last_error);
        }
    } else {
        error_log("Unable to log zone creation - no valid zone_id was generated");
    }
    
    // Return success response
    return rest_ensure_response(array(
        'success' => true,
        'zone_id' => $zone_id,
        'message' => 'Event zone created successfully.',
    ));
}
?>