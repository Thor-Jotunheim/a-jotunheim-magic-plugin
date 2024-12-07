<?php
// File: helpers.php

function has_permission($capability = 'read') {
    // Check if the user is logged in
    if (!is_user_logged_in()) {
        static $logged_out_error_logged = false;

        // Log the error only once per request
        if (!$logged_out_error_logged) {
            error_log("Permission denied: User is not logged in.");
            $logged_out_error_logged = true;
        }

        return false;
    }

    $current_user = wp_get_current_user(); // Get the current user context

    // Ensure the user context is valid
    if (empty($current_user) || !isset($current_user->ID)) {
        error_log("Permission denied: Unable to retrieve valid user context.");
        return false;
    }

    // Check if the user has the specified capability
    if (!current_user_can($capability)) {
        error_log("Permission denied for User ID: {$current_user->ID} - Missing capability: {$capability}");
        return false;
    }

    return true;
}


// Unified function to validate API keys (keys should be set in wp-config.php)
function validate_api_key($request) {
    // Retrieve the API key from the request headers
    $api_key = $request->get_header('x-api-key');

    // Ensure an API key is provided
    if (empty($api_key)) {
        error_log("Missing API key in request headers.");
        return new WP_Error('rest_forbidden', __('Missing API key.'), array('status' => 403));
    }

    // Define the valid API keys (add more keys as needed)
    $valid_keys = [
        'TRADE_API_KEY'      => defined('TRADE_API_KEY') ? TRADE_API_KEY : null,
        'EVENTZONES_API_KEY' => defined('EVENTZONES_API_KEY') ? EVENTZONES_API_KEY : null,
        'PREFAB_API_KEY'     => defined('PREFAB_API_KEY') ? PREFAB_API_KEY : null,
        // Add more keys here as needed
    ];

    // Check if the API key matches any valid key
    if (!in_array($api_key, $valid_keys, true)) {
        error_log('Invalid API key provided: ' . $api_key);
        return new WP_Error('rest_forbidden', __('Invalid API key.'), array('status' => 403));
    }

    // Set a bypass flag for the current request
    if (!defined('API_KEY_BYPASS')) {
        define('API_KEY_BYPASS', true);
    }

    return true;
}
