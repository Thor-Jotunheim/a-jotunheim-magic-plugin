<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

/**
 * Checks if a user has the required role to access or manage a trade shop.
 */
function user_has_trade_access($required_role) {
    $user = wp_get_current_user();
    if (!$user) return false;

    $user_roles = $user->roles; // WordPress roles assigned to the current user
    $role_hierarchy = get_role_hierarchy(); // Reuse the hierarchy from discord-role-access.php

    // Check if the user's role matches or exceeds the required role
    foreach ($user_roles as $user_role) {
        if ($user_role === $required_role || (isset($role_hierarchy[$user_role]) && in_array($required_role, $role_hierarchy[$user_role]))) {
            return true;
        }
    }

    return false; // Access denied
}

/**
 * Checks if a user can manage a shop based on shop type.
 */
function user_can_manage_shop($shop_name, $shop_type = 'general') {
    // Use the shop type to determine the required capability
    $capabilities = [
        'general'       => 'chosen',       // General shops
        'staff-only'    => 'moderator',    // Staff-only shops
        'admin-only'    => 'editor'        // Admin-only shops (minimum editor access)
    ];

    $required_role = $capabilities[$shop_type] ?? 'chosen';

    // Special case: Administrators always have access to everything
    $user = wp_get_current_user();
    if (in_array('administrator', $user->roles)) {
        return true;
    }

    // Check if the user has the required role
    return user_has_trade_access($required_role);
}
