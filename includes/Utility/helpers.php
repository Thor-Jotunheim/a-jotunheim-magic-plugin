<?php
// File: helpers.php

function has_permission($capability = 'read') {
    if (!is_user_logged_in()) {
        error_log("Permission denied: User is not logged in.");
        return false;
    }

    $current_user = wp_get_current_user(); // Optional, only if needed for logging.

    if (!current_user_can($capability)) {
        // Log user ID and requested capability for debugging
        error_log("Permission denied for User ID: {$current_user->ID} - Missing capability: {$capability}");
        return false;
    }

    return true;
}
