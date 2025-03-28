<?php
// File: eventzones-rest-api.php

// Prevent direct access
if (!defined('ABSPATH')) exit;

// Register REST API endpoints for event zones and event zone logs
add_action('rest_api_init', function () {
    // Public endpoint to fetch all event zones
    register_rest_route('jotunheim-magic/v1', '/eventzones', array(
        'methods' => 'GET',
        'callback' => 'fetch_all_eventzones_rest',
        'permission_callback' => '__return_true', // No authentication required for general access
    ));

    // Public endpoint to fetch a specific event zone by ID
    register_rest_route('jotunheim-magic/v1', '/eventzones/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'fetch_single_eventzone_rest',
        'permission_callback' => '__return_true', // No authentication required
        'args' => array(
            'id' => array(
                'required' => true,
                'validate_callback' => function($param, $request, $key) {
                    return is_numeric($param);
                }
            ),
        ),
    ));

    // Private endpoint to fetch a specific event zone by name, requires API key validation
    register_rest_route('jotunheim-magic/v1', '/eventzones/name/(?P<name>[a-zA-Z0-9_-]+)', array(
        'methods' => 'GET',
        'callback' => 'fetch_eventzone_by_name_rest',
        'permission_callback' => function($request) {
            // Use the existing validate_api_key function from helpers.php
            return validate_api_key($request);
        },
        'args' => array(
            'name' => array(
                'required' => true,
                'validate_callback' => function($param, $request, $key) {
                    return is_string($param);
                }
            ),
        ),
    ));

    // Register new endpoint for event zone logs
    register_rest_route('jotunheim-magic/v1', '/eventzone-logs', array(
        'methods' => 'GET',
        'callback' => 'fetch_all_eventzone_logs_rest',
        'permission_callback' => '__return_true', // No authentication required for log access
    ));

    register_rest_route('jotunheim-magic/v1', '/eventzone-logs/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'fetch_single_eventzone_log_rest',
        'permission_callback' => '__return_true', // No authentication required
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

// Callback function for fetching all event zones
function fetch_all_eventzones_rest($request) {
    global $wpdb;
    $table_name = 'jotun_eventzones';

    // Get column names dynamically from the database schema
    $columns = $wpdb->get_results("DESCRIBE $table_name", ARRAY_A);
    if (!$columns) {
        return new WP_Error('no_columns', 'No columns found in the table', array('status' => 404));
    }

    // Extract the column names
    $column_names = array_map(function($column) {
        return $column['Field'];
    }, $columns);

    // Create the SELECT query dynamically based on the column names
    $column_list = implode(", ", $column_names);

    // Check if there is a search parameter
    $search = $request->get_param('search');
    if (!empty($search)) {
        // Use a LIKE query for partial matching
        $zones = $wpdb->get_results($wpdb->prepare("SELECT $column_list FROM $table_name WHERE name LIKE %s", '%' . $wpdb->esc_like($search) . '%'), ARRAY_A);
    } else {
        // Fetch all zones if no search parameter is provided
        $zones = $wpdb->get_results("SELECT $column_list FROM $table_name", ARRAY_A);
    }

    if (!empty($zones)) {
        return rest_ensure_response($zones);
    } else {
        return new WP_Error('no_zones', 'No event zones found', array('status' => 404));
    }
}

// Callback function for fetching a single event zone by ID
function fetch_single_eventzone_rest($request) {
    global $wpdb;
    $table_name = 'jotun_eventzones';
    $zone_id = intval($request['id']); // Retrieve the zone ID from the request parameters

    // Get column names dynamically from the database schema
    $columns = $wpdb->get_results("DESCRIBE $table_name", ARRAY_A);
    if (!$columns) {
        return new WP_Error('no_columns', 'No columns found in the table', array('status' => 404));
    }

    // Extract the column names
    $column_names = array_map(function($column) {
        return $column['Field'];
    }, $columns);

    // Create the SELECT query dynamically based on the column names
    $column_list = implode(", ", $column_names);

    // Run the query using the dynamic column names
    $zone = $wpdb->get_row($wpdb->prepare("SELECT $column_list FROM $table_name WHERE id = %d", $zone_id), ARRAY_A);

    if ($zone) {
        return rest_ensure_response($zone);
    } else {
        return new WP_Error('zone_not_found', 'Event zone not found', array('status' => 404));
    }
}

function insert_eventzone_log(WP_REST_Request $request) {
    global $wpdb;
    $table_name = 'jotun_eventzone_logs';

    // Extract data from the request
    $zone_id = sanitize_text_field($request->get_param('zone_id'));
    $user = sanitize_text_field($request->get_param('user'));
    $change_type = sanitize_text_field($request->get_param('change_type'));
    $timestamp = sanitize_text_field($request->get_param('timestamp'));
    $details = sanitize_textarea_field($request->get_param('details'));

    // Log the incoming data for debugging purposes
    error_log("Inserting log entry: zone_id=$zone_id, user=$user, change_type=$change_type, timestamp=$timestamp, details=$details");

    // Insert data into the logs table
    $inserted = $wpdb->insert(
        $table_name,
        array(
            'zone_id' => $zone_id,
            'user' => $user,
            'change_type' => $change_type,
            'timestamp' => $timestamp,
            'details' => $details
        ),
        array(
            '%d',   // zone_id
            '%s',   // user
            '%s',   // change_type
            '%s',   // timestamp
            '%s'    // details
        )
    );

    if ($inserted) {
        return rest_ensure_response(array(
            'status' => 'success',
            'message' => 'Log entry inserted successfully'
        ));
    } else {
        error_log("Failed to insert log entry: " . $wpdb->last_error);
        return new WP_Error('log_insert_failed', 'Failed to insert log entry', array('status' => 500));
    }
}

// Function to fetch all event zone logs
function fetch_all_eventzone_logs_rest($request) {
    global $wpdb;
    $table_name = 'jotun_eventzone_logs';

    // Fetch all logs from the table
    $logs = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

    if ($logs) {
        return rest_ensure_response($logs);
    } else {
        return new WP_Error('no_logs', 'No event zone logs found', array('status' => 404));
    }
}

// Function to fetch a specific event zone log by ID
function fetch_single_eventzone_log_rest($request) {
    global $wpdb;
    $table_name = 'jotun_eventzone_logs';
    $log_id = intval($request['id']);

    // Fetch the log by its ID
    $log = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $log_id), ARRAY_A);

    if ($log) {
        return rest_ensure_response($log);
    } else {
        return new WP_Error('log_not_found', 'Event zone log not found', array('status' => 404));
    }
}