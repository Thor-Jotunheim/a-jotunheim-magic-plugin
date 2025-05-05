<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Wiki Editor Role Definition
 * 
 * This file defines the Wiki Editor role and its capabilities.
 */

/**
 * Create the Wiki Editor role if it doesn't exist
 */
function jotunheim_create_wiki_editor_role() {
    // Check if wiki editor role already exists
    if (!get_role('wiki_editor')) {
        // Create the wiki editor role with basic capabilities
        add_role(
            'wiki_editor',
            'Wiki Editor',
            array(
                'read' => true,
                'upload_files' => true,
                'edit_posts' => true,
                'edit_published_posts' => true,
            )
        );
    }
    
    // Get the wiki editor role
    $wiki_editor = get_role('wiki_editor');
    
    // Add required capabilities for wiki editors
    if ($wiki_editor) {
        // Basic editing capabilities
        $wiki_editor->add_cap('read');
        $wiki_editor->add_cap('upload_files');
        $wiki_editor->add_cap('edit_posts');
        $wiki_editor->add_cap('edit_published_posts');
        
        // Knowledge Base specific capabilities
        if (post_type_exists('knowledgebase')) {
            $wiki_editor->add_cap('edit_knowledgebase');
            $wiki_editor->add_cap('edit_knowledgebases');
            $wiki_editor->add_cap('edit_others_knowledgebases');
            $wiki_editor->add_cap('edit_published_knowledgebases');
            $wiki_editor->add_cap('publish_knowledgebases');
            
            // BasePress specific capabilities
            $wiki_editor->add_cap('basepress_edit_articles');
            $wiki_editor->add_cap('basepress_edit_knowledgebases');
        }
    }
}
add_action('init', 'jotunheim_create_wiki_editor_role');

/**
 * Direct override for BasePress settings access
 * 
 * This provides wiki editors access to BasePress settings pages
 * by overriding WordPress capability checks.
 */

/**
 * Check if current page is a BasePress settings page
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
 * Core capability override for BasePress settings
 */
function jotunheim_wiki_editor_basepress_access() {
    // Only for logged in users who are wiki editors
    if (!is_user_logged_in() || !current_user_can('wiki_editor')) {
        return;
    }
    
    // Only on BasePress settings pages
    if (!jotunheim_is_basepress_settings_page()) {
        return;
    }
    
    // Direct capability overrides for the current user
    global $current_user;
    if ($current_user) {
        // Admin capabilities needed for BasePress settings
        $admin_caps = [
            'manage_options',
            'administrator',
            'edit_theme_options',
            'manage_categories',
            'edit_plugins',
            'activate_plugins',
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
        
        // Grant all capabilities needed
        foreach (array_merge($admin_caps, $basepress_caps) as $cap) {
            $current_user->allcaps[$cap] = true;
        }
        
        // Temporarily add administrator capability directly
        $current_user->caps['administrator'] = true;
        
        // Add a notice to indicate special access mode is active
        add_action('admin_notices', 'jotunheim_wiki_editor_access_notice');
        
        // Add capability overrides
        add_filter('user_has_cap', 'jotunheim_wiki_editor_override_caps', 99999, 4);
        add_filter('map_meta_cap', 'jotunheim_wiki_editor_override_meta_cap', 99999, 4);
        
        // Filter specific BasePress capability checks
        $basepress_filters = [
            'basepress_settings_capability',
            'basepress_sections_capability',
            'basepress_products_capability', 
            'option_page_capability_basepress_settings',
        ];
        
        foreach ($basepress_filters as $filter) {
            add_filter($filter, 'jotunheim_return_read_capability', 99999);
        }
        
        // Fix UI for BasePress settings
        add_action('admin_head', 'jotunheim_fix_basepress_ui');
    }
}
add_action('admin_init', 'jotunheim_wiki_editor_basepress_access', 1); // Early priority

/**
 * Add a notice indicating special access mode
 */
function jotunheim_wiki_editor_access_notice() {
    echo '<div class="notice notice-success is-dismissible">
        <p><strong>Wiki Editor Access:</strong> Special access mode is active for BasePress settings.</p>
    </div>';
}

/**
 * Override user capabilities check
 */
function jotunheim_wiki_editor_override_caps($allcaps, $caps, $args, $user) {
    // Only override for wiki editors
    if (!in_array('wiki_editor', (array) $user->roles)) {
        return $allcaps;
    }
    
    // Always grant these admin capabilities for BasePress settings
    if (jotunheim_is_basepress_settings_page()) {
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
        
        // Grant the specific capability being checked
        foreach ($caps as $cap) {
            $allcaps[$cap] = true;
        }
    }
    
    return $allcaps;
}

/**
 * Override meta capability mapping
 */
function jotunheim_wiki_editor_override_meta_cap($caps, $cap, $user_id, $args) {
    // Only override for wiki editors
    $user = get_user_by('id', $user_id);
    if (!$user || !in_array('wiki_editor', (array) $user->roles)) {
        return $caps;
    }
    
    // Only on BasePress settings pages
    if (!jotunheim_is_basepress_settings_page()) {
        return $caps;
    }
    
    // Admin capabilities that might be checked
    $admin_caps = [
        'manage_options',
        'edit_plugins',
        'activate_plugins',
        'administrator',
        'update_core',
        'install_plugins',
        'edit_theme_options',
        'manage_categories',
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
 * Fix UI for BasePress settings pages
 */
function jotunheim_fix_basepress_ui() {
    if (!current_user_can('wiki_editor') || !jotunheim_is_basepress_settings_page()) {
        return;
    }
    
    ?>
    <style>
        /* Ensure settings page content is visible */
        #wpcontent, #wpfooter {
            display: block !important;
        }
        
        /* Hide elements that might cause confusion */
        .update-nag,
        .notice:not(.notice-success),
        #wpfooter {
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

/**
 * Clean up the admin menu for wiki editors
 */
function jotunheim_wiki_editor_clean_admin_menu() {
    // Only for wiki editors
    if (!current_user_can('wiki_editor') || current_user_can('administrator')) {
        return;
    }
    
    // Only on certain pages to maintain access to everything wiki editors need
    if (jotunheim_is_basepress_settings_page()) {
        global $menu, $submenu;
        
        // Keep only specific menus and clean up the rest
        foreach ($menu as $key => $item) {
            // Keep only the KB menu
            if (!isset($item[2]) || $item[2] !== 'edit.php?post_type=knowledgebase') {
                unset($menu[$key]);
            }
        }
    }
}
add_action('admin_menu', 'jotunheim_wiki_editor_clean_admin_menu', 999);