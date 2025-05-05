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
            
            // Add additional BasePress capabilities
            $wiki_editor->add_cap('basepress_manage_options');
            $wiki_editor->add_cap('basepress_manage_sections');
            $wiki_editor->add_cap('basepress_manage_products');
            $wiki_editor->add_cap('manage_basepress');
        }
    }
}
add_action('init', 'jotunheim_create_wiki_editor_role');

/**
 * Check if current page is a BasePress page
 */
function jotunheim_is_basepress_page() {
    // Check if we're on a BasePress page
    if (isset($_GET['post_type']) && $_GET['post_type'] === 'knowledgebase') {
        return true;
    }
    
    // Check if we're editing a BasePress post
    if (isset($_GET['post']) && get_post_type($_GET['post']) === 'knowledgebase') {
        return true;
    }
    
    // Check specific BasePress admin pages
    if (isset($_GET['page']) && (
        $_GET['page'] === 'basepress_settings' ||
        $_GET['page'] === 'basepress_sections' ||
        $_GET['page'] === 'basepress_products'
    )) {
        return true;
    }
    
    return false;
}

/**
 * Direct override for BasePress settings access
 * 
 * This provides wiki editors access to BasePress settings pages
 * by overriding WordPress capability checks.
 */
function jotunheim_wiki_editor_basepress_access() {
    // Only for logged in users who are wiki editors
    if (!is_user_logged_in()) {
        return;
    }
    
    // Get current user
    $user = wp_get_current_user();
    
    // Check if user is a wiki editor (and not an admin)
    if (!in_array('wiki_editor', $user->roles) || in_array('administrator', $user->roles)) {
        return;
    }
    
    // Set up capability overrides for wiki editors
    add_filter('user_has_cap', 'jotunheim_wiki_editor_override_caps', 99999, 4);
    add_filter('map_meta_cap', 'jotunheim_wiki_editor_override_meta_cap', 99999, 4);
    
    // Add specific BasePress capability overrides
    add_filter('basepress_settings_capability', 'jotunheim_return_read_capability', 99999);
    add_filter('basepress_sections_capability', 'jotunheim_return_read_capability', 99999);
    add_filter('basepress_products_capability', 'jotunheim_return_read_capability', 99999);
    add_filter('option_page_capability_basepress_settings', 'jotunheim_return_read_capability', 99999);
    
    // Clean up the admin menu for wiki editors
    add_action('admin_menu', 'jotunheim_wiki_editor_clean_admin_menu', 999);
    
    // Fix UI for BasePress settings
    add_action('admin_head', 'jotunheim_fix_basepress_ui', 999);
    
    // Add an admin notice when special access mode is active
    if (jotunheim_is_basepress_page()) {
        add_action('admin_notices', 'jotunheim_wiki_editor_access_notice');
    }
}
add_action('admin_init', 'jotunheim_wiki_editor_basepress_access', 1);

/**
 * Add a notice indicating special access mode
 */
function jotunheim_wiki_editor_access_notice() {
    echo '<div class="notice notice-success">
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
    if (jotunheim_is_basepress_page()) {
        $admin_caps = [
            'manage_options',
            'administrator',
            'edit_theme_options',
            'manage_categories',
            'edit_plugins',
            'activate_plugins',
            'basepress_manage_options',
            'basepress_manage_sections',
            'basepress_manage_products',
            'manage_basepress',
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
    
    // Only on BasePress pages
    if (!jotunheim_is_basepress_page()) {
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
 * Clean up the admin menu for wiki editors
 */
function jotunheim_wiki_editor_clean_admin_menu() {
    // Only for wiki editors
    if (!current_user_can('wiki_editor') || current_user_can('administrator')) {
        return;
    }
    
    global $menu, $submenu;
    
    // Keep only specific menu items and clean up the rest
    foreach ($menu as $key => $item) {
        // Keep Dashboard, Media, KB, and Profile
        if (
            // Keep only essential menu items
            !in_array($item[2], [
                'index.php', // Dashboard
                'upload.php', // Media
                'edit.php?post_type=knowledgebase', // Knowledge Base
                'profile.php', // Profile
            ])
        ) {
            unset($menu[$key]);
        }
    }
    
    // Ensure KB submenu items are accessible
    if (isset($submenu['edit.php?post_type=knowledgebase'])) {
        foreach ($submenu['edit.php?post_type=knowledgebase'] as $key => $item) {
            // Make the link accessible regardless of capability
            if ($item[1] === 'basepress_manage_options' || 
                $item[1] === 'basepress_manage_sections' || 
                $item[1] === 'basepress_manage_products') {
                // Grant access by setting capability to 'read'
                $submenu['edit.php?post_type=knowledgebase'][$key][1] = 'read';
            }
        }
    }
}

/**
 * Fix UI for BasePress settings pages
 */
function jotunheim_fix_basepress_ui() {
    if (!current_user_can('wiki_editor') || !jotunheim_is_basepress_page()) {
        return;
    }
    
    // Direct manipulation of capabilities for the current BasePress page
    global $current_user;
    
    if ($current_user instanceof WP_User) {
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
        
        // Add core WordPress capabilities
        $current_user->allcaps['manage_options'] = true;
        $current_user->allcaps['administrator'] = true;
    }
    
    ?>
    <style>
        /* Ensure settings page content is visible */
        #wpcontent, #wpfooter {
            display: block !important;
        }
        
        /* Hide elements that might cause confusion */
        .update-nag,
        .notice:not(.notice-success) {
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
        
        /* Make all tables visible */
        table.wp-list-table,
        table.form-table,
        table.widefat {
            visibility: visible !important;
            display: table !important;
        }
        
        /* Fix KB menu items */
        #toplevel_page_knowledgebase,
        #menu-posts-knowledgebase,
        #menu-posts-knowledgebase * {
            display: block !important;
        }
        
        /* Ensure all admin elements are visible */
        .wrap h1,
        .wrap .page-title-action,
        .wrap .subsubsub,
        .wrap .tablenav,
        .wrap .search-box,
        .wrap .wp-list-table {
            display: block !important;
            visibility: visible !important;
        }
        
        /* Make navigation tabs visible */
        .nav-tab-wrapper,
        .nav-tab {
            display: inline-block !important;
            visibility: visible !important;
        }
    </style>
    
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            // Find and enable submit buttons
            $('.basepress-settings input[type="submit"]').removeAttr('disabled');
            
            // Force visibility on elements that might be hidden
            $('.basepress-settings, .wrap, .form-table').css('display', 'block');
            
            // Override any script that might hide elements
            setTimeout(function() {
                $('.basepress-settings input, .basepress-settings select').removeAttr('disabled');
                $('.basepress-settings, .wrap, .form-table').css('display', 'block');
            }, 500);
            
            // Handle form submissions manually if needed
            $('.basepress-settings form').on('submit', function(e) {
                // Make sure all fields are enabled before submission
                $(this).find('input, select, textarea').removeAttr('disabled');
            });
        });
    </script>
    <?php
}

/**
 * Force the current screen to be accessible
 */
function jotunheim_force_screen_access() {
    if (is_admin() && current_user_can('wiki_editor') && jotunheim_is_basepress_page()) {
        global $pagenow;
        
        // Dynamically grant access to the current screen
        add_filter('screen_options_show_screen', '__return_true');
        
        // Special handling for options.php (settings save)
        if ($pagenow === 'options.php') {
            add_filter('option_page_capability_basepress_settings', function() { return 'read'; });
            add_filter('option_page_capability_basepress_sections', function() { return 'read'; });
            add_filter('option_page_capability_basepress_products', function() { return 'read'; });
        }
    }
}
add_action('admin_init', 'jotunheim_force_screen_access', 1);

/**
 * Fix basepress menu access by adding page hooks
 */
function jotunheim_fix_basepress_menu_access() {
    if (!is_admin() || !current_user_can('wiki_editor') || current_user_can('administrator')) {
        return;
    }
    
    // Register our own versions of the pages with lower capability requirements
    $hook = add_submenu_page(
        'edit.php?post_type=knowledgebase',
        'BasePress Settings',
        'Settings',
        'read',
        'basepress_settings_override',
        'jotunheim_redirect_to_basepress_settings'
    );
    
    // Add sections page
    add_submenu_page(
        'edit.php?post_type=knowledgebase',
        'BasePress Sections',
        'Sections',
        'read',
        'basepress_sections_override',
        'jotunheim_redirect_to_basepress_sections'
    );
    
    // Add products page 
    add_submenu_page(
        'edit.php?post_type=knowledgebase',
        'BasePress Products',
        'Products',
        'read',
        'basepress_products_override',
        'jotunheim_redirect_to_basepress_products'
    );
    
    // Remove original pages from the menu but leave our overrides
    remove_submenu_page(
        'edit.php?post_type=knowledgebase', 
        'basepress_settings'
    );
    
    remove_submenu_page(
        'edit.php?post_type=knowledgebase', 
        'basepress_sections'
    );
    
    remove_submenu_page(
        'edit.php?post_type=knowledgebase', 
        'basepress_products'
    );
    
    // Fix menu highlighting for our override pages
    add_filter('parent_file', 'jotunheim_fix_parent_file');
}
add_action('admin_menu', 'jotunheim_fix_basepress_menu_access', 9999);

/**
 * Redirect functions for our override pages
 */
function jotunheim_redirect_to_basepress_settings() {
    // Temporarly set the current user as admin
    global $current_user;
    if ($current_user) {
        $current_user->allcaps['administrator'] = true;
        $current_user->allcaps['manage_options'] = true;
    }
    
    // Include the original settings page
    if (function_exists('basepress_settings_page')) {
        basepress_settings_page();
    } else {
        // If function doesn't exist, try to load it from BasePress
        $settings_file = WP_PLUGIN_DIR . '/basepress/admin/includes/settings-page.php';
        if (file_exists($settings_file)) {
            include_once($settings_file);
            if (function_exists('basepress_settings_page')) {
                basepress_settings_page();
            } else {
                echo '<div class="wrap"><h1>BasePress Settings</h1><p>Settings page could not be loaded. Please contact an administrator.</p></div>';
            }
        } else {
            echo '<div class="wrap"><h1>BasePress Settings</h1><p>Settings page could not be loaded. Please contact an administrator.</p></div>';
        }
    }
}

function jotunheim_redirect_to_basepress_sections() {
    // Temporarly set the current user as admin
    global $current_user;
    if ($current_user) {
        $current_user->allcaps['administrator'] = true;
        $current_user->allcaps['manage_options'] = true;
    }
    
    // Include the original sections page
    if (function_exists('basepress_sections_page')) {
        basepress_sections_page();
    } else {
        // If function doesn't exist, try to load it from BasePress
        echo '<div class="wrap"><h1>BasePress Sections</h1><p>Section management could not be loaded. Please contact an administrator.</p></div>';
    }
}

function jotunheim_redirect_to_basepress_products() {
    // Temporarly set the current user as admin
    global $current_user;
    if ($current_user) {
        $current_user->allcaps['administrator'] = true;
        $current_user->allcaps['manage_options'] = true;
    }
    
    // Include the original products page
    if (function_exists('basepress_products_page')) {
        basepress_products_page();
    } else {
        // If function doesn't exist, try to load it from BasePress
        echo '<div class="wrap"><h1>BasePress Products</h1><p>Product management could not be loaded. Please contact an administrator.</p></div>';
    }
}

/**
 * Fix parent file to make sure menu highlighting works
 */
function jotunheim_fix_parent_file($parent_file) {
    global $submenu_file;
    
    // Fix menu highlighting for our overrides
    if (isset($_GET['page']) && in_array($_GET['page'], ['basepress_settings_override', 'basepress_sections_override', 'basepress_products_override'])) {
        $parent_file = 'edit.php?post_type=knowledgebase';
        
        // Set specific submenu highlight
        if ($_GET['page'] === 'basepress_settings_override') {
            $submenu_file = 'basepress_settings_override';
        } else if ($_GET['page'] === 'basepress_sections_override') {
            $submenu_file = 'basepress_sections_override';
        } else if ($_GET['page'] === 'basepress_products_override') {
            $submenu_file = 'basepress_products_override';
        }
    }
    
    return $parent_file;
}