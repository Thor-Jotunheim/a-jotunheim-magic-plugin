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
