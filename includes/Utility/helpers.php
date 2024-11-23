<?php
// File: helpers.php

function has_permission($capability = 'read') {
    $current_user = wp_get_current_user();

    if (!$current_user->exists()) {
        error_log("Permission denied: User is not logged in.");
        return false;
    }

    error_log("Current User Object: " . print_r($current_user, true));

    if (!current_user_can($capability)) {
        error_log("Permission denied: User lacks the $capability capability.");
        return false;
    }

    return true;
}