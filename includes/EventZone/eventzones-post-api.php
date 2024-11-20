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

    // PUT/PATCH endpoint for updating an event zone by ID
    register_rest_route('jotunheim-magic/v1', '/eventzones/(?P<id>\d+)', array(
        'methods' => array('PUT', 'PATCH'),
        'callback' => 'update_eventzone_rest',
        'permission_callback' => 'can_manage_eventzones',
        'args' => array(
            'id' => array(
                'required' => true,
                'validate_callback' => function($param, $request, $key) {
                    return is_numeric($param);
                }
            ),
        ),
    ));
});

// Callback function for creating a new event zone
function create_eventzone_rest($request) {
    global $wpdb;
    $table_name = 'jotun_eventzones';

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
    return rest_ensure_response(array('status' => 'created', 'zone_id' => $new_zone_id, 'message' => 'Event zone created successfully.'));
}

// Callback function for updating an existing event zone by ID
function update_eventzone_rest($request) {
    global $wpdb;
    $table_name = 'jotun_eventzones';
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
        return new WP_Error('update_failed', 'Failed to update event zone', array('status' => 500));
    }

    return rest_ensure_response(array('status' => 'updated', 'zone_id' => $zone_id, 'message' => 'Event zone updated successfully.'));
}