<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Direct BasePress Access Override for Wiki Editors
 * 
 * This file provides direct access to BasePress settings pages for wiki editors
 * by completely bypassing WordPress permission checks.
 */

// Make sure we run early
add_action('init', 'jotunheim_wiki_editor_basepress_access', 1);
add_action('admin_init', 'jotunheim_wiki_editor_basepress_override', 1);

/**
 * Determine if we're on a BasePress settings page
 */
function jotunheim_is_basepress_settings_page() {
    if (!isset($_GET['post_type']) || $_GET['post_type'] !== 'knowledgebase') {
        return false;
    }
    
    if (!isset($_GET['page']) || $_GET['page'] !== 'basepress_settings') {
        return false;
    }
    
    return true;
}

/**
 * Check if current user is a wiki editor
 */
function jotunheim_is_wiki_editor() {
    if (!function_exists('wp_get_current_user') || !is_user_logged_in()) {
        return false;
    }
    
    $user = wp_get_current_user();
    return in_array('wiki_editor', (array) $user->roles);
}

/**
 * Add capabilities directly to the current user
 */
function jotunheim_wiki_editor_basepress_access() {
    // Only for wiki editors on BasePress settings pages
    if (!jotunheim_is_wiki_editor() || !jotunheim_is_basepress_settings_page()) {
        return;
    }
    
    // Force temporary admin capabilities
    global $current_user;
    if ($current_user) {
        // Admin core capabilities
        $admin_caps = [
            'manage_options',
            'administrator',
            'activate_plugins',
            'edit_plugins',
            'edit_theme_options',
            'manage_categories',
            'edit_categories',
            'edit_posts',
            'edit_pages',
        ];
        
        // BasePress specific capabilities
        $basepress_caps = [
            'basepress_edit_articles',
            'basepress_edit_knowledgebases',
            'basepress_manage_options',
            'basepress_manage_sections',
            'basepress_manage_products',
            'manage_basepress',
        ];
        
        // Apply all required capabilities
        foreach (array_merge($admin_caps, $basepress_caps) as $cap) {
            $current_user->allcaps[$cap] = true;
        }
    }
}

/**
 * Directly hijack BasePress capability checks
 */
function jotunheim_wiki_editor_basepress_override() {
    // Only for wiki editors on BasePress settings pages
    if (!jotunheim_is_wiki_editor() || !jotunheim_is_basepress_settings_page()) {
        return;
    }
    
    // Override capability checks for settings pages
    add_filter('user_has_cap', 'jotunheim_bypass_capability_check', 99999, 4);
    
    // Specific BasePress settings capability overrides
    $settings_filters = [
        'basepress_settings_capability',
        'basepress_sections_capability',
        'basepress_products_capability',
        'option_page_capability_basepress_settings', 
        'option_page_capability_basepress_options'
    ];
    
    foreach ($settings_filters as $filter) {
        add_filter($filter, 'jotunheim_return_read_capability', 99999);
    }
    
    // Override meta capability mapping as a last resort
    add_filter('map_meta_cap', 'jotunheim_override_meta_cap', 99999, 4);
    
    // If there's a tab specified, make sure we have access to it
    if (isset($_GET['tab'])) {
        $tab = $_GET['tab'];
        
        // Tab-specific capability overrides
        add_filter("basepress_{$tab}_capability", 'jotunheim_return_read_capability', 99999);
        add_filter("basepress_manage_{$tab}", 'jotunheim_return_read_capability', 99999);
    }
    
    // Make all admin screens available
    remove_all_filters('screen_options_show_screen');
    add_filter('screen_options_show_screen', '__return_true', 99999);
}

/**
 * Bypass capability check by granting all capabilities
 */
function jotunheim_bypass_capability_check($allcaps, $caps, $args) {
    // Set all capabilities to true
    foreach ($caps as $cap) {
        $allcaps[$cap] = true;
    }
    
    // Always grant these admin capabilities
    $admin_caps = [
        'manage_options',
        'administrator',
        'edit_theme_options',
        'manage_categories',
        'edit_plugins',
        'activate_plugins',
    ];
    
    foreach ($admin_caps as $cap) {
        $allcaps[$cap] = true;
    }
    
    return $allcaps;
}

/**
 * Override WordPress core capability mapping
 */
function jotunheim_override_meta_cap($caps, $cap, $user_id) {
    // Only for wiki editors
    if (!jotunheim_is_wiki_editor()) {
        return $caps;
    }
    
    // Admin capabilities that might be checked
    $admin_caps = [
        'manage_options',
        'administrator',
        'edit_theme_options',
        'manage_categories',
        'edit_plugins',
        'activate_plugins',
    ];
    
    // If checking an admin capability, change requirement to 'read'
    if (in_array($cap, $admin_caps)) {
        return ['read'];
    }
    
    return $caps;
}

/**
 * Return 'read' capability for any check
 */
function jotunheim_return_read_capability() {
    return 'read';
}

/**
 * Force correct menu items for wiki editors
 */
add_action('admin_menu', 'jotunheim_fix_wiki_editor_admin_menu', 999);
function jotunheim_fix_wiki_editor_admin_menu() {
    if (!jotunheim_is_wiki_editor()) {
        return;
    }
    
    // Hide all menus and only show KB menu
    if (jotunheim_is_basepress_settings_page()) {
        global $menu;
        
        // Keep only the KB menu
        foreach ($menu as $key => $item) {
            if (!isset($item[2]) || $item[2] !== 'edit.php?post_type=knowledgebase') {
                unset($menu[$key]);
            }
        }
    }
}

/**
 * Add a notice to show when access override is active
 */
add_action('admin_notices', 'jotunheim_wiki_editor_access_notice');
function jotunheim_wiki_editor_access_notice() {
    if (jotunheim_is_wiki_editor() && jotunheim_is_basepress_settings_page()) {
        echo '<div class="notice notice-success is-dismissible">
            <p><strong>Wiki Editor Access:</strong> Special access mode is active for BasePress settings.</p>
        </div>';
    }
}

/**
 * Fix admin UI for wiki editors
 */
add_action('admin_head', 'jotunheim_fix_wiki_editor_admin_ui');
function jotunheim_fix_wiki_editor_admin_ui() {
    if (jotunheim_is_wiki_editor() && jotunheim_is_basepress_settings_page()) {
        ?>
        <style>
            /* Ensure the settings page content is visible */
            #wpcontent, #wpfooter {
                display: block !important;
            }
            
            /* Hide elements that might cause confusion */
            .update-nag,
            .notice:not(.notice-success),
            #wpfooter,
            .nav-tab-wrapper .nav-tab:not(.nav-tab-active) {
                display: none !important;
            }
            
            /* Make BasePress settings form elements visible */
            .basepress-settings,
            .basepress-settings input,
            .basepress-settings select,
            .basepress-settings textarea,
            .basepress-settings .form-table,
            .basepress-settings .submit {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
            
            /* Fix for BasePress sections page */
            .basepress-sections-wrapper {
                display: block !important;
            }
            
            /* Fix for BasePress buttons */
            .basepress-settings .button,
            .basepress-settings .button-primary {
                display: inline-block !important;
                visibility: visible !important;
            }
        </style>
        <?php
    }
}