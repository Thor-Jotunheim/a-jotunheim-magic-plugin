<?php
// File: eventzones-permission.php

// Prevent direct access to this file
if (!defined('ABSPATH')) exit;

/**
 * Verifies if the API request includes a valid API key and user permissions.
 * 
 * @param WP_REST_Request $request The incoming REST request.
 * @param string $required_permission The required permission to access the resource.
 * @return true|WP_Error True if the API key and permissions are valid, WP_Error otherwise.
 */
function validate_eventzones_api_key_and_permissions($request, $required_permission) {
    global $wpdb;

    // Retrieve the current user
    $current_user = wp_get_current_user();
    if (!$current_user || $current_user->ID === 0) {
        error_log('Permission denied: User is not logged in.'); // Logging
        return new WP_Error('rest_forbidden', __('Permission denied: User is not logged in.'), array('status' => 403));
    }

    // Retrieve the API key from the request header
    $api_key = $request->get_header('x-api-key');
    if (empty($api_key)) {
        error_log('Permission denied: API key missing.');
        return new WP_Error('rest_forbidden', __('Permission denied: API key missing.'), array('status' => 403));
    }

    // Fetch the user's API key from the database
    $table_name = 'jotun_user_api_keys';
    $user_data = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE user_id = %d",
        $current_user->ID
    ));

    if (!$user_data) {
        error_log('Permission denied: No API key found for user ID ' . $current_user->ID);
        return new WP_Error('rest_forbidden', __('Permission denied: API key not found for this user.'), array('status' => 403));
    }

    // Compare the API keys
    if ($api_key !== $user_data->api_key) {
        error_log('Permission denied: Invalid API key for user ID ' . $current_user->ID);
        return new WP_Error('rest_forbidden', __('Permission denied: Invalid API key.'), array('status' => 403));
    }

    // Check for required permissions
    $permissions = explode(',', $user_data->permissions); // Assuming permissions are stored as a comma-separated list
    if (!in_array($required_permission, $permissions)) {
        error_log('Permission denied: Insufficient permissions for ' . $required_permission);
        return new WP_Error('rest_forbidden', __('Permission denied: Insufficient permissions.'), array('status' => 403));
    }

    return true;
}

/**
 * Permission callback for managing (create/update) event zones.
 * 
 * @param WP_REST_Request $request The incoming REST request.
 * @return true|WP_Error True if the request is authorized, WP_Error otherwise.
 */
function can_manage_eventzones($request) {
    return validate_eventzones_api_key_and_permissions($request, 'manage_eventzones');
}

/**
 * Permission callback for editing event zones.
 * 
 * @param WP_REST_Request $request The incoming REST request.
 * @return true|WP_Error True if the request is authorized, WP_Error otherwise.
 */
function can_edit_eventzones($request) {
    return validate_eventzones_api_key_and_permissions($request, 'edit_eventzones');
}

/**
 * Permission callback for viewing event zones.
 * 
 * @param WP_REST_Request $request The incoming REST request.
 * @return true|WP_Error True if the request is authorized, WP_Error otherwise.
 */
function can_view_eventzones($request) {
    return validate_eventzones_api_key_and_permissions($request, 'view_eventzones');
}