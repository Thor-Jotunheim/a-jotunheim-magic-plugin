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

    // Compare with the API key stored in wp-config.php
    if ($api_key !== EVENTZONES_API_KEY) {
        error_log('Permission denied: Invalid API key.');
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
    // Validate the API key
    if (!validate_eventzones_api_key($request)) {
        return false;
    }

    // Ensure the user has at least 'editor' capabilities
    if (!current_user_can('edit_pages')) {
        error_log('Permission denied: User does not have the required capabilities.');
        return false;
    }

    return true;
}

/**
 * Permission callback for editing event zones.
 * 
 * @param WP_REST_Request $request The incoming REST request.
 * @return bool True if the request is authorized, false otherwise.
 */
function can_edit_eventzones($request) {
    // Validate the API key
    if (!validate_eventzones_api_key($request)) {
        return false;
    }

    // Ensure the user has at least 'editor' capabilities
    if (!current_user_can('edit_posts')) {
        error_log('Permission denied: User does not have the required capabilities.');
        return false;
    }

    return true;
}

/**
 * Permission callback for viewing event zones.
 * 
 * @param WP_REST_Request $request The incoming REST request.
 * @return bool True if the request is authorized, false otherwise.
 */
function can_view_eventzones($request) {
    // Validate the API key
    if (!validate_eventzones_api_key($request)) {
        return false;
    }

    // Allow all logged-in users to view if the API key is valid
    if (!is_user_logged_in()) {
        error_log('Permission denied: User is not logged in.');
        return false;
    }

    return true;
}
