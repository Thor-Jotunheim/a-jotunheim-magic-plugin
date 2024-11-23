<?php
// File: eventzones-rest-api.php

// Prevent direct access
if (!defined('ABSPATH')) exit;

// Register REST API endpoints for event zones
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
        'permission_callback' => 'validate_api_key', // Requires API key
        'args' => array(
            'name' => array(
                'required' => true,
                'validate_callback' => function($param, $request, $key) {
                    return is_string($param);
                }
            ),
        ),
    ));
});

function validate_api_key($request) {
    global $wpdb;

    // Retrieve the API key from the request headers
    $api_key = $request->get_header('x-api-key');
    if (empty($api_key)) {
        error_log('API key missing from request.');
        return new WP_Error('rest_forbidden', __('API key is missing.'), array('status' => 403));
    }

    // Fetch the logged-in user's API key from the database
    $current_user = wp_get_current_user();
    if (!$current_user || !$current_user->ID) {
        error_log('Permission denied: User is not logged in.');
        return new WP_Error('rest_forbidden', __('User is not logged in.'), array('status' => 403));
    }

    $cache_key = 'api_key_user_' . $current_user->ID;
$api_key = get_transient($cache_key);

if ($api_key === false) {
    $user_data = $wpdb->get_row($wpdb->prepare(
        "SELECT api_key FROM jotun_user_api_keys WHERE user_id = %d",
        $current_user->ID
    ));
    $api_key = $user_data ? $user_data->api_key : '';
    set_transient($cache_key, $api_key, HOUR_IN_SECONDS);
}


    if (!$user_data || $api_key !== $user_data->api_key) {
        error_log('Invalid API key provided for user ID ' . $current_user->ID);
        return new WP_Error('rest_forbidden', __('Invalid API key.'), array('status' => 403));
    }

    return true;
}

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

// Callback function for fetching a single event zone by name
function fetch_eventzone_by_name_rest($request) {
    global $wpdb;
    $table_name = 'jotun_eventzones';
    $zone_name = sanitize_text_field($request['name']); // Retrieve and sanitize the name parameter

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
    $zone = $wpdb->get_row($wpdb->prepare("SELECT $column_list FROM $table_name WHERE name = %s", $zone_name), ARRAY_A);

    if ($zone) {
        return rest_ensure_response($zone);
    } else {
        return new WP_Error('zone_not_found', 'Event zone not found', array('status' => 404));
    }
}