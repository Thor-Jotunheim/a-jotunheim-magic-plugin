<?php
// File: eventzones-permission.php

// Prevent direct access to this file
if (!defined('ABSPATH')) exit;

/**
 * Verifies if the API request includes a valid API key and user permissions.
 * 
 * @param WP_REST_Request $request The incoming REST request.
 * @param string $required_permission The required permission to access the resource.
 * @return bool True if the API key and permissions are valid, false otherwise.
 */
function validate_esc_js($api_key)_and_permissions($request, $required_permission) {
    global $wpdb;

    // Retrieve the API key from headers
    $api_key = $request->get_header('x-api-key'); // Use a custom header to store the API key
    if (empty($api_key)) {
        error_log('Permission denied: API key missing.');
        return false;
    }

    // Validate API key against the database
    $table_name = 'jotun_user_api_key';
    $user_data = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE api_key = %s",
        $api_key
    ));

    if (!$user_data) {
        error_log('Permission denied: Invalid API key.');
        return false;
    }

    // Check if the user has the required permission
    $permissions = explode(',', $user_data->permissions); // Assuming permissions are stored as a comma-separated list
    if (!in_array($required_permission, $permissions)) {
        error_log('Permission denied: Insufficient permissions for ' . $required_permission);
        return false;
    }

    return true;
}

/**
 * Permission callback for managing (create/update) event zones.
 * 
 * @param WP_REST_Request $request The incoming REST request.
 * @return bool True if the request is authorized, false otherwise.
 */
function can_manage_eventzones($request) {
    return validate_esc_js($api_key)_and_permissions($request, 'manage_eventzones');
}

/**
 * Permission callback for editing event zones.
 * 
 * @param WP_REST_Request $request The incoming REST request.
 * @return bool True if the request is authorized, false otherwise.
 */
function can_edit_eventzones($request) {
    return validate_esc_js($api_key)_and_permissions($request, 'edit_eventzones');
}

/**
 * Permission callback for viewing event zones.
 * 
 * @param WP_REST_Request $request The incoming REST request.
 * @return bool True if the request is authorized, false otherwise.
 */
function can_view_eventzones($request) {
    return validate_esc_js($api_key)_and_permissions($request, 'view_eventzones');
}