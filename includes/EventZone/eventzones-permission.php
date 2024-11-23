<?php
// File: eventzones-permission.php

// Prevent direct access to this file
if (!defined('ABSPATH')) exit;

/**
 * Verifies if the API request includes a valid API key in the headers.
 * 
 * @param WP_REST_Request $request The incoming REST request.
 * @return bool True if the API key is valid, false otherwise.
 */
function validate_eventzones_api_key($request) {
    // Retrieve the API key from headers
    $api_key = $request->get_header('x-api-key'); // Use a custom header to store the API key

    // Check if the API key is valid
    if ($api_key !== EVENTZONES_API_KEY) {
        error_log('Permission denied: Invalid API key.');
        return false;
    }

    return true;
}

/**
 * Permission callback for managing (create/update) event zones.
 * Ensures a valid API key is present and the user has administrator or editor capabilities.
 * 
 * @param WP_REST_Request $request The incoming REST request.
 * @return bool True if the request is authorized, false otherwise.
 */
function can_manage_eventzones($request) {
    $user_id = validate_eventzones_api_key($request);
    if ($user_id) {
        // Log in the user
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);
        return true;
    } else {
        return false;
    }
}

/**
 * Permission callback for editing event zones.
 * Ensures a valid API key is present and the user has at least editor capabilities.
 * 
 * @param WP_REST_Request $request The incoming REST request.
 * @return bool True if the request is authorized, false otherwise.
 */
function can_edit_eventzones($request) {
    $user_id = validate_eventzones_api_key($request);
    if ($user_id) {
        // Log in the user
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);
        return true;
    } else {
        return false;
    }
}

/**
 * Permission callback for viewing event zones.
 * Ensures a valid API key is present.
 * 
 * @param WP_REST_Request $request The incoming REST request.
 * @return bool True if the request is authorized, false otherwise.
 */
function can_view_eventzones($request) {
    return validate_eventzones_api_key($request);
}

and 

<?php
function insert_eventzone_log(WP_REST_Request $request) {
    global $wpdb;
    $table_name = 'jotun_eventzone_logs'; // Correct table name

    // Extract and sanitize data from the request
    $zone_id = sanitize_text_field($request->get_param('zone_id'));
    $action = sanitize_text_field($request->get_param('action'));   // Correct column `action`
    $timestamp = sanitize_text_field($request->get_param('timestamp'));
    $details = sanitize_textarea_field($request->get_param('details')); // Optional column `details`

    // Always use the authenticated user's ID
    $user_id = get_current_user_id();

    if ($user_id === 0) {
        error_log("No user is logged in.");
        return new WP_Error(
            'missing_user',
            'A valid user must be logged in to perform this action.',
            array('status' => 401)
        );
    }

    // Get the user object for the user ID
    $user = get_user_by('id', $user_id);
    if (!$user) {
        error_log("Invalid user ID: $user_id");
        return new WP_Error(
            'invalid_user',
            'Invalid user ID.',
            array('status' => 400)
        );
    }

    $username = $user->user_login; // Retrieve the username

    // Include the username in the log details for better traceability
    $details .= " | User: $username";

    // Validate required parameters
    if (empty($zone_id) || empty($action) || empty($timestamp)) {
        return new WP_Error(
            'missing_parameters',
            'Missing required parameters: zone_id, action, or timestamp.',
            array('status' => 400)
        );
    }

    // Insert data into the database
    $inserted = $wpdb->insert(
        $table_name,
        array(
            'zone_id'   => $zone_id,     // Matches table column `zone_id`
            'user_id'   => $user_id,     // Matches table column `user_id`
            'action'    => $action,      // Matches table column `action`
            'timestamp' => $timestamp,   // Matches table column `timestamp`
            'details'   => $details,     // Matches table column `details`
        ),
        array('%d', '%d', '%s', '%s', '%s') // Data format types
    );

    // Debugging: Log SQL errors if the insertion fails
    if ($inserted === false) {
        error_log("Database Insert Error: " . $wpdb->last_error); // Logs detailed SQL error
        return new WP_Error(
            'log_insert_failed',
            'Failed to insert log entry: ' . $wpdb->last_error,
            array('status' => 500)
        );
    }

    // Respond with success if the insertion was successful
    return rest_ensure_response(array(
        'status'  => 'success',
        'message' => 'Log entry inserted successfully',
        'id'      => $wpdb->insert_id // Returns the ID of the inserted row
    ));
}
?>