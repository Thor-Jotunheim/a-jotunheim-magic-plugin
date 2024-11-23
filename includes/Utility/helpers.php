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

    // Check if the user has the specified capability
    if (!current_user_can($capability)) {
        error_log("Permission denied for User ID: {$current_user->ID} - Missing capability: {$capability}");
        return false;
    }

    return true;
}