<?php
// File: editor-permissions.php
// Special permission handler to allow editors access to specific admin pages

// Prevent direct access
if (!defined('ABSPATH')) exit;

/**
 * Allow editors to access specific Jotunheim Magic admin pages only
 */
function jotunheim_allow_editor_specific_page_access() {
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
        // Add capability filter only for this specific request
        add_filter('user_has_cap', function($allcaps, $caps, $args, $user) use ($current_user, $page) {
            if ($user->ID === $current_user->ID) {
                // Only add manage_options for the current page request
                $current_page = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : '';
                $allowed_pages = ['event_zone_editor', 'item_list_editor', 'item_list_add_new_item', 'add_event_zone'];
                
                if (in_array($current_page, $allowed_pages)) {
                    $allcaps['manage_options'] = true;
                    $allcaps['edit_pages'] = true;
                }
            }
            return $allcaps;
        }, 10, 4);
    }
}

// Hook this function to run early in the admin initialization
add_action('admin_init', 'jotunheim_allow_editor_specific_page_access', 1);

/**
 * Ensure editors can see the Jotunheim Magic menu
 */
function jotunheim_ensure_editor_menu_visibility() {
    if (!is_admin() || !is_user_logged_in()) {
        return;
    }

    $current_user = wp_get_current_user();
    
    // If user is an editor, give them the capability to see the menu
    if (in_array('editor', $current_user->roles) && !in_array('administrator', $current_user->roles)) {
        add_filter('user_has_cap', function($allcaps, $caps, $args, $user) use ($current_user) {
            if ($user->ID === $current_user->ID) {
                // Only add the menu capability, don't override existing editor capabilities
                $allcaps['edit_pages'] = true;
                $allcaps['edit_posts'] = true;
            }
            return $allcaps;
        }, 10, 4);
    }
}

// Hook early to ensure menu visibility
add_action('admin_menu', 'jotunheim_ensure_editor_menu_visibility', 5);

/**
 * Block editors from accessing admin settings pages they shouldn't see
 */
function jotunheim_block_editor_admin_access() {
    if (!is_admin() || !is_user_logged_in()) {
        return;
    }

    $current_user = wp_get_current_user();
    
    // Only apply to editors, not administrators
    if (in_array('editor', $current_user->roles) && !in_array('administrator', $current_user->roles)) {
        // Get current page
        $page = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : '';
        
        // Pages editors should NOT access (only admin settings, not core editing)
        $blocked_pages = [
            'plugins.php',
            'themes.php', 
            'users.php',
            'options-general.php',
            'options-writing.php',
            'options-reading.php',
            'options-discussion.php',
            'options-media.php',
            'options-permalink.php',
            'tools.php',
            'import.php',
            'export.php',
            'update-core.php',
            'plugin-install.php',
            'plugin-editor.php',
            'theme-install.php',
            'theme-editor.php'
        ];
        
        // Check if they're trying to access a blocked page
        global $pagenow;
        if (in_array($pagenow, $blocked_pages) || in_array($page, $blocked_pages)) {
            wp_die(__('Sorry, you are not allowed to access this page.'), 403);
        }
    }
}

// Hook to block admin access
add_action('admin_init', 'jotunheim_block_editor_admin_access', 5);

/**
 * Debug function to log access attempts
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

// Hook for debugging
add_action('admin_init', 'jotunheim_debug_editor_access');