<?php
// File: editor-permissions.php
// Special permission handler to allow editors access to specific admin pages

// Prevent direct access
if (!defined('ABSPATH')) exit;

/**
 * Override capability check only for specific pages
 */
function jotunheim_override_specific_page_access($caps, $cap, $user_id, $args) {
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

    // Only override if we're on one of the allowed pages
    if (in_array($page, $allowed_pages)) {
        $user = get_userdata($user_id);
        if ($user && in_array('editor', $user->roles)) {
            // If checking for manage_options or edit_pages, allow it for these specific pages
            if (in_array($cap, ['manage_options', 'edit_pages'])) {
                return ['edit_posts']; // Return a capability the editor has
            }
        }
    }

    return $caps;
}

// Hook the capability filter
add_filter('map_meta_cap', 'jotunheim_override_specific_page_access', 10, 4);

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