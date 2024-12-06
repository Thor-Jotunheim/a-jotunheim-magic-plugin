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

// Function to validate API key directly from wp-config.php
function validate_api_key($request) {
    // Retrieve the API key from the request headers
    $api_key = $request->get_header('x-api-key');
    
    // Ensure that the key matches the one defined in wp-config.php
    if (!defined('EVENTZONES_API_KEY') || $api_key !== EVENTZONES_API_KEY) {
        error_log('Invalid API key provided.');
        return new WP_Error('rest_forbidden', __('Invalid API key.'), array('status' => 403));
    }
    return true;
}

// Callback function for fetching all event zones
function fetch_all_eventzones_rest() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'eventzones';

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
    $zones = $wpdb->get_results("SELECT $column_list FROM $table_name", ARRAY_A);

    if (!empty($zones)) {
        return rest_ensure_response($zones);
    } else {
        return new WP_Error('no_zones', 'No event zones found', array('status' => 404));
    }
}

// Callback function for fetching a single event zone by ID
function fetch_single_eventzone_rest($request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'eventzones';
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
    $table_name = $wpdb->prefix . 'eventzones';
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
