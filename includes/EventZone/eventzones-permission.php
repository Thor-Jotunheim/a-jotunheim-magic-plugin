<?php
// File: eventzones-permission.php

// Prevent direct access to this file
if (!defined('ABSPATH')) exit;

/**
 * Validate API key from request headers
 */
function validate_api_key($request) {
    $api_key = $request->get_header('X-API-KEY');
    return defined('EVENTZONES_API_KEY') && $api_key === EVENTZONES_API_KEY;
}

/**
 * Permission callback for managing event zones (create, update, delete).
 * Ensures a valid API key is present OR the user has administrator or editor capabilities.
 *
 * @param WP_REST_Request $request The incoming REST request.
 * @return bool|WP_Error True if the request is authorized, WP_Error otherwise.
 */
function can_manage_eventzones($request) {
    // Validate API key
    if (validate_api_key($request)) {
        // If a valid API key is provided, bypass role checks
        return true;
    }

    // Check user capabilities if no valid API key is provided
    if (is_user_logged_in() && (current_user_can('edit_posts') || current_user_can('manage_options'))) {
        return true;
    }

    // If neither API key nor valid user role is present, deny access
    return new WP_Error(
        'rest_forbidden',
        __('You do not have permission to manage event zones.'),
        array('status' => 403)
    );
}
