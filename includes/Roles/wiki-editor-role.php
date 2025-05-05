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
        
        // Knowledge Base specific capabilities - get KB post type
        $kb_post_type = function_exists('basepress_get_post_type') ? basepress_get_post_type() : 'knowledgebase';
        $kb_tax = function_exists('basepress_get_taxonomy') ? basepress_get_taxonomy() : 'knowledgebase_cat';
        
        if (post_type_exists($kb_post_type)) {
            // Standard WP capabilities for KB post type
            $wiki_editor->add_cap('edit_' . $kb_post_type);
            $wiki_editor->add_cap('edit_' . $kb_post_type . 's');
            $wiki_editor->add_cap('edit_others_' . $kb_post_type . 's');
            $wiki_editor->add_cap('edit_published_' . $kb_post_type . 's');
            $wiki_editor->add_cap('publish_' . $kb_post_type . 's');
            $wiki_editor->add_cap('read_private_' . $kb_post_type . 's');
            $wiki_editor->add_cap('delete_' . $kb_post_type . 's');
            $wiki_editor->add_cap('delete_published_' . $kb_post_type . 's');
            
            // BasePress specific capabilities
            $wiki_editor->add_cap('basepress_edit_articles');
            $wiki_editor->add_cap('basepress_edit_others_articles');
            $wiki_editor->add_cap('basepress_edit_published_articles');
            $wiki_editor->add_cap('basepress_edit_private_articles');
            $wiki_editor->add_cap('basepress_delete_articles');
            $wiki_editor->add_cap('basepress_delete_others_articles');
            $wiki_editor->add_cap('basepress_delete_published_articles');
            $wiki_editor->add_cap('basepress_delete_private_articles');
            $wiki_editor->add_cap('basepress_publish_articles');
            $wiki_editor->add_cap('basepress_read_private_articles');
            
            // BasePress KB management capabilities
            $wiki_editor->add_cap('basepress_edit_kb');
            $wiki_editor->add_cap('basepress_edit_kbs');
            $wiki_editor->add_cap('basepress_edit_others_kbs');
            $wiki_editor->add_cap('basepress_edit_published_kbs');
            $wiki_editor->add_cap('basepress_edit_private_kbs');
            
            // Management capabilities for Sections and KB management
            $wiki_editor->add_cap('basepress_manage_sections');
            $wiki_editor->add_cap('basepress_manage_options');
            $wiki_editor->add_cap('basepress_manage_kbs');
            $wiki_editor->add_cap('basepress_manage_products');
            $wiki_editor->add_cap('manage_basepress');
            $wiki_editor->add_cap('manage_categories');
            
            // Taxonomy management capabilities
            $wiki_editor->add_cap('manage_' . $kb_tax);
            $wiki_editor->add_cap('edit_' . $kb_tax);
            $wiki_editor->add_cap('delete_' . $kb_tax);
            $wiki_editor->add_cap('assign_' . $kb_tax);
        }
    }
}
add_action('init', 'jotunheim_create_wiki_editor_role');

/**
 * Hide all admin menu items except Knowledge Base and Profile for wiki editors
 */
function jotunheim_remove_admin_menu_items() {
    // Only apply to wiki_editor role (not for admins)
    if (!current_user_can('wiki_editor') || current_user_can('administrator')) {
        return;
    }
    
    global $menu, $submenu;
    
    // Get the KB post type
    $kb_post_type = function_exists('basepress_get_post_type') ? basepress_get_post_type() : 'knowledgebase';
    $kb_menu_slug = 'edit.php?post_type=' . $kb_post_type;
    
    // Only keep the profile menu and KB menu items
    if (is_array($menu)) {
        foreach ($menu as $key => $item) {
            // Skip if not a proper menu item
            if (!isset($item[2])) {
                continue;
            }
            
            // Only keep profile menu and KB menu
            if ($item[2] !== 'profile.php' && 
                $item[2] !== $kb_menu_slug) {
                remove_menu_page($item[2]);
            }
        }
    }
}
add_action('admin_menu', 'jotunheim_remove_admin_menu_items', 999);

/**
 * Add Sections and Manage KBs submenu items explicitly to ensure they appear
 */
function jotunheim_add_kb_submenu_items() {
    // Only apply to wiki_editor role (not for admins)
    if (!current_user_can('wiki_editor') || current_user_can('administrator')) {
        return;
    }
    
    // Get the KB post type
    $kb_post_type = function_exists('basepress_get_post_type') ? basepress_get_post_type() : 'knowledgebase';
    $kb_menu_slug = 'edit.php?post_type=' . $kb_post_type;
    
    // Add the Sections and Manage KBs submenu items if they don't exist
    global $submenu;
    
    // Check if the KB menu exists
    if (!isset($submenu[$kb_menu_slug])) {
        return;
    }
    
    // Check if Sections and Manage KBs are already in the menu
    $has_sections = false;
    $has_manage_kbs = false;
    
    foreach ($submenu[$kb_menu_slug] as $item) {
        if (isset($item[2]) && $item[2] === 'basepress_sections') {
            $has_sections = true;
        }
        if (isset($item[2]) && $item[2] === 'basepress_manage_kbs') {
            $has_manage_kbs = true;
        }
    }
    
    // Add Sections if it doesn't exist
    if (!$has_sections) {
        add_submenu_page(
            $kb_menu_slug,
            'Sections',
            'Sections',
            'wiki_editor',
            'basepress_sections',
            '__return_false' // This is a placeholder, BasePress will handle the actual page
        );
    }
    
    // Add Manage KBs if it doesn't exist
    if (!$has_manage_kbs) {
        add_submenu_page(
            $kb_menu_slug,
            'Manage KBs',
            'Manage KBs',
            'wiki_editor',
            'basepress_manage_kbs',
            '__return_false' // This is a placeholder, BasePress will handle the actual page
        );
    }
}
add_action('admin_menu', 'jotunheim_add_kb_submenu_items', 1000);

/**
 * Set admin dashboard redirect for wiki editors
 * This ensures they land at KB section when logging in
 */
function jotunheim_wiki_editor_redirect() {
    // Only apply to wiki_editor role (not for admins)
    if (!current_user_can('wiki_editor') || current_user_can('administrator')) {
        return;
    }
    
    // Get the KB post type
    $kb_post_type = function_exists('basepress_get_post_type') ? basepress_get_post_type() : 'knowledgebase';
    
    // Get current screen
    $screen = get_current_screen();
    
    // If on dashboard, redirect to KB
    if ($screen && $screen->id === 'dashboard') {
        wp_safe_redirect(admin_url('edit.php?post_type=' . $kb_post_type));
        exit;
    }
}
add_action('current_screen', 'jotunheim_wiki_editor_redirect');

/**
 * Register wiki editor role with BasePress
 */
function jotunheim_register_wiki_editor_with_basepress() {
    if (function_exists('basepress_add_editor_roles')) {
        // Register wiki_editor as a role that can edit BasePress content
        add_filter('basepress_editor_roles', function($roles) {
            $roles[] = 'wiki_editor';
            return $roles;
        });
        
        // Add to allowed roles
        add_filter('basepress_allowed_roles', function($roles) {
            $roles[] = 'wiki_editor';
            return $roles;
        });
    }
}
add_action('init', 'jotunheim_register_wiki_editor_with_basepress', 20);

/**
 * Fix permissions check for BasePress admin pages
 */
function jotunheim_fix_basepress_admin_page_access() {
    global $pagenow;
    
    // Only run on admin.php or edit.php with page parameter
    if (!is_admin() || ($pagenow !== 'admin.php' && $pagenow !== 'edit.php') || !isset($_GET['page'])) {
        return;
    }
    
    // Check if we're on a BasePress admin page
    $page = sanitize_text_field($_GET['page']);
    
    if ($page === 'basepress_sections' || $page === 'basepress_manage_kbs') {
        // If current user is a wiki_editor
        if (current_user_can('wiki_editor') && !current_user_can('administrator')) {
            // Add necessary filters to bypass BasePress permission checks
            add_filter('basepress_user_can_manage_sections', '__return_true');
            add_filter('basepress_user_can_manage_options', '__return_true');
            add_filter('basepress_user_can_manage_kbs', '__return_true');
            
            // Fix capability checks for specific pages
            add_filter('user_has_cap', function($allcaps, $caps, $args, $user) {
                if (!empty($args) && isset($args[0])) {
                    // Add the specific capabilities being checked
                    if ($args[0] === 'basepress_manage_sections' || 
                        $args[0] === 'basepress_manage_options' || 
                        $args[0] === 'basepress_manage_kbs' || 
                        $args[0] === 'manage_basepress') {
                        $allcaps[$args[0]] = true;
                    }
                }
                return $allcaps;
            }, 10, 4);
        }
    }
}
add_action('admin_init', 'jotunheim_fix_basepress_admin_page_access', 5);