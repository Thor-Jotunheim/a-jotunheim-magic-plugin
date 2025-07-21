<?php
// File: editor-permissions.php
// Special permission handler to allow editors access to specific admin pages

// Prevent direct access
if (!defined('ABSPATH')) exit;

/**
 * Allow editors to access specific Jotunheim Magic admin pages
 */
function jotunheim_allow_editor_admin_access() {
    // Check if we're in admin area and user is logged in
    if (!is_admin() || !is_user_logged_in()) {
        return;
    }

    // Get current user
    $current_user = wp_get_current_user();
    
    // Check if user has editor role (but not administrator)
    if (!in_array('editor', $current_user->roles) || in_array('administrator', $current_user->roles)) {
        return;
    }

    // Get the current page parameter
    $page = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : '';

    // List of pages that editors should have access to
    $allowed_pages = [
        'event_zone_editor',
        'item_list_editor', 
        'item_list_add_new_item',
        'add_event_zone'
    ];

    // If the current page is in our allowed list, temporarily grant manage_options capability
    if (in_array($page, $allowed_pages)) {
        // Add the manage_options capability temporarily for this request
        $current_user->add_cap('manage_options');
        
        // Also add it to the user's capabilities array for this session
        add_filter('user_has_cap', function($allcaps, $caps, $args, $user) use ($current_user) {
            if ($user->ID === $current_user->ID) {
                $allcaps['manage_options'] = true;
            }
            return $allcaps;
        }, 10, 4);
    }
}

// Hook this function to run early in the admin initialization
add_action('admin_init', 'jotunheim_allow_editor_admin_access', 1);

/**
 * Alternative approach: Override the capability check for specific pages
 */
function jotunheim_override_page_capability_check($caps, $cap, $user_id, $args) {
    // Only apply to admin area
    if (!is_admin()) {
        return $caps;
    }

    // Get the current page
    $page = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : '';
    
    // Pages that editors should access
    $allowed_pages = [
        'event_zone_editor',
        'item_list_editor', 
        'item_list_add_new_item',
        'add_event_zone'
    ];

    // If trying to access one of our allowed pages and user is an editor
    if (in_array($page, $allowed_pages)) {
        $user = get_userdata($user_id);
        if ($user && in_array('editor', $user->roles)) {
            // If the capability being checked is manage_options, allow it
            if ($cap === 'manage_options') {
                return ['edit_posts']; // Return a capability the editor has
            }
        }
    }

    return $caps;
}

// Hook the capability filter
add_filter('map_meta_cap', 'jotunheim_override_page_capability_check', 10, 4);

/**
 * Ensure menu items are visible to editors
 */
function jotunheim_ensure_editor_menu_access() {
    if (!is_admin() || !is_user_logged_in()) {
        return;
    }

    $current_user = wp_get_current_user();
    
    // If user is an editor, ensure they can see admin menus
    if (in_array('editor', $current_user->roles)) {
        // Temporarily add menu access capability
        add_filter('user_has_cap', function($allcaps, $caps, $args, $user) use ($current_user) {
            if ($user->ID === $current_user->ID) {
                $allcaps['edit_pages'] = true;
                $allcaps['edit_posts'] = true;
            }
            return $allcaps;
        }, 10, 4);
    }
}

// Hook early to ensure menu visibility
add_action('admin_menu', 'jotunheim_ensure_editor_menu_access', 5);

/**
 * Ensure editors can see the Jotunheim Magic menu
 */
function jotunheim_ensure_editor_menu_visibility() {
    if (!is_admin() || !is_user_logged_in()) {
        return;
    }

    $current_user = wp_get_current_user();
    
    // If user is an editor, give them the capability to see the menus
    if (in_array('editor', $current_user->roles)) {
        // Give them the same capability that the menu requires
        add_filter('user_has_cap', function($allcaps, $caps, $args, $user) use ($current_user) {
            if ($user->ID === $current_user->ID) {
                $allcaps['edit_pages'] = true;
            }
            return $allcaps;
        }, 10, 4);
    }
}

// Hook early to ensure menu visibility
add_action('admin_menu', 'jotunheim_ensure_editor_menu_visibility', 5);

/**
 * Debug function to log access attempts (remove this in production)
 */
function jotunheim_debug_editor_access() {
    if (is_admin() && is_user_logged_in()) {
        $current_user = wp_get_current_user();
        $page = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : '';
        
        if (in_array('editor', $current_user->roles) && !empty($page)) {
            error_log("Editor {$current_user->user_login} accessing page: {$page}");
        }
    }
}

// Hook for debugging (comment out in production)
add_action('admin_init', 'jotunheim_debug_editor_access');