<?php
// File: editor-permissions.php
// Special permission handler to allow editors access to specific admin pages

// Prevent direct access
if (!defined('ABSPATH')) exit;

/**
 * Allow editors to access specific Jotunheim Magic admin pages only
 */
function jotunheim_allow_editor_specific_page_access() {
    // Don't run during Discord OAuth process
    if (isset($_GET['action']) && $_GET['action'] === 'oauth2callback') {
        return;
    }
    
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
                }
            }
            return $allcaps;
        }, 10, 4);
    }
}

// Hook this function to run early in the admin initialization
add_action('admin_init', 'jotunheim_allow_editor_specific_page_access', 1);

/**
 * Ensure editors can see Pages in their menu
 */
function jotunheim_restore_editor_pages_menu() {
    // Don't run during Discord OAuth process
    if (isset($_GET['action']) && $_GET['action'] === 'oauth2callback') {
        return;
    }
    
    if (!is_admin() || !is_user_logged_in()) {
        return;
    }

    $current_user = wp_get_current_user();
    
    // Only apply to editors
    if (in_array('editor', $current_user->roles) && !in_array('administrator', $current_user->roles)) {
        // Ensure editors can see and access Pages - add capabilities permanently for this session
        add_filter('user_has_cap', function($allcaps, $caps, $args, $user) use ($current_user) {
            if ($user->ID === $current_user->ID) {
                // Add all standard editor page capabilities
                $allcaps['edit_pages'] = true;
                $allcaps['edit_published_pages'] = true;
                $allcaps['edit_others_pages'] = true;
                $allcaps['publish_pages'] = true;
                $allcaps['delete_pages'] = true;
                $allcaps['delete_published_pages'] = true;
                $allcaps['delete_others_pages'] = true;
                $allcaps['read'] = true;
                $allcaps['upload_files'] = true;
                $allcaps['edit_posts'] = true;
                $allcaps['edit_published_posts'] = true;
                $allcaps['edit_others_posts'] = true;
                $allcaps['publish_posts'] = true;
                $allcaps['delete_posts'] = true;
                $allcaps['delete_published_posts'] = true;
                $allcaps['delete_others_posts'] = true;
            }
            return $allcaps;
        }, 1, 4); // Higher priority to run earlier
    }
}

// Hook to restore Pages menu for editors - run very early
add_action('init', 'jotunheim_restore_editor_pages_menu', 1);

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
        
        // Also block File Manager and other plugin pages
        $blocked_plugin_pages = [
            'wp-file-manager',
            'wp_file_manager',
            'file-manager',
            'filemanager',
            'file_manager_advanced_ui'  // This is the actual File Manager page slug
        ];
        
        // Check if they're trying to access a blocked page
        global $pagenow;
        if (in_array($pagenow, $blocked_pages) || in_array($page, $blocked_pages) || in_array($page, $blocked_plugin_pages)) {
            wp_die(__('Sorry, you are not allowed to access this page.'), 403);
        }
    }
}

// Hook to block admin access
add_action('admin_init', 'jotunheim_block_editor_admin_access', 5);

/**
 * Remove File Manager and other plugin menus from editors
 */
function jotunheim_remove_editor_plugin_menus() {
    if (!is_admin() || !is_user_logged_in()) {
        return;
    }

    $current_user = wp_get_current_user();
    
    // Only apply to editors, not administrators
    if (in_array('editor', $current_user->roles) && !in_array('administrator', $current_user->roles)) {
        // Remove File Manager menu - try multiple possible slugs
        remove_menu_page('wp-file-manager');
        remove_menu_page('wp-file-manager/file_manager.php');
        remove_menu_page('wp_file_manager');
        remove_menu_page('file-manager');
        remove_menu_page('filemanager');
        remove_menu_page('wp-file-manager-pro');
        remove_menu_page('wp-file-manager-root');
        remove_menu_page('file_manager_advanced_ui'); // Add the correct slug
        
        // Debug: Log what menus are available
        global $menu;
        if (!empty($menu)) {
            foreach ($menu as $menu_item) {
                if (isset($menu_item[2]) && stripos($menu_item[2], 'file') !== false) {
                    error_log("File Manager menu found: " . $menu_item[2]);
                    remove_menu_page($menu_item[2]);
                }
            }
        }
    }
}

// Hook to remove plugin menus from editors - try multiple priority levels
add_action('admin_menu', 'jotunheim_remove_editor_plugin_menus', 999);
add_action('admin_menu', 'jotunheim_remove_editor_plugin_menus', 9999);

/**
 * Hide File Manager menu with CSS if remove_menu_page doesn't work
 */
function jotunheim_hide_file_manager_css() {
    if (!is_admin() || !is_user_logged_in()) {
        return;
    }

    $current_user = wp_get_current_user();
    
    // Only apply to editors, not administrators
    if (in_array('editor', $current_user->roles) && !in_array('administrator', $current_user->roles)) {
        echo '<style>
            /* Hide File Manager menu items */
            #adminmenu li[class*="wp-file-manager"],
            #adminmenu li a[href*="wp-file-manager"],
            #adminmenu li a[href*="file-manager"],
            #adminmenu li a[href*="filemanager"],
            #adminmenu .toplevel_page_wp-file-manager,
            #adminmenu .toplevel_page_file-manager {
                display: none !important;
            }
        </style>';
    }
}

// Hook to add CSS hiding
add_action('admin_head', 'jotunheim_hide_file_manager_css');

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