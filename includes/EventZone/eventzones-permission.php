<?php
// File: eventzones-permission.php

// Prevent direct access to this file
if (!defined('ABSPATH')) exit;

/**
 * Verifies if the API request includes a valid API key and maps it to a user ID.
 * 
 * @param WP_REST_Request $request The incoming REST request.
 * @return int|false The user ID if the API key is valid, or false otherwise.
 */
function validate_eventzones_api_key($request) {
    // Retrieve the API key from headers
    $api_key = $request->get_header('x-api-key');

    // Check if the API key exists and matches the defined constant
    if (empty($api_key) || $api_key !== EVENTZONES_API_KEY) {
        error_log('Permission denied: Invalid API key.');
        return false;
    }

    // Map API key to a WordPress user (e.g., Editor role)
    $user_query = new WP_User_Query([
        'role__in' => ['Administrator', 'Editor'], // Allow both Administrators and Editors
        'meta_query' => [
            [
                'key' => 'eventzones_api_key',
                'value' => $api_key,
                'compare' => '='
            ]
        ]
    ]);

    $users = $user_query->get_results();

    if (!empty($users)) {
        return $users[0]->ID; // Return the first matching user ID
    }

    error_log('Permission denied: No user associated with the API key.');
    return false;
}

/**
 * Ensures the user is logged in based on the API key and sets the session if needed.
 * 
 * @param WP_REST_Request $request The incoming REST request.
 * @return bool True if the user is authenticated, false otherwise.
 */
function ensure_user_authenticated($request) {
    $user_id = validate_eventzones_api_key($request);

    if ($user_id) {
        if (get_current_user_id() !== $user_id) {
            // Set the user session if not already logged in
            wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id);
        }
        return true;
    }

    return false;
}

/**
 * Permission callback for managing (create/update) event zones.
 * 
 * @param WP_REST_Request $request The incoming REST request.
 * @return bool True if the request is authorized, false otherwise.
 */
function can_manage_eventzones($request) {
    return ensure_user_authenticated($request);
}

/**
 * Permission callback for editing event zones.
 * 
 * @param WP_REST_Request $request The incoming REST request.
 * @return bool True if the request is authorized, false otherwise.
 */
function can_edit_eventzones($request) {
    return ensure_user_authenticated($request);
}

/**
 * Permission callback for viewing event zones.
 * 
 * @param WP_REST_Request $request The incoming REST request.
 * @return bool True if the request is authorized, false otherwise.
 */
function can_view_eventzones($request) {
    return validate_eventzones_api_key($request);
}
