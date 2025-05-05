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
            // Standard KB editing capabilities
            $wiki_editor->add_cap('edit_knowledgebase');
            $wiki_editor->add_cap('edit_knowledgebases');
            $wiki_editor->add_cap('edit_others_knowledgebases');
            $wiki_editor->add_cap('edit_published_knowledgebases');
            $wiki_editor->add_cap('publish_knowledgebases');
            $wiki_editor->add_cap('read_private_knowledgebases');
            
            // BasePress specific capabilities for content editing
            $wiki_editor->add_cap('basepress_edit_articles');
            $wiki_editor->add_cap('basepress_edit_knowledgebases');
            $wiki_editor->add_cap('basepress_edit_others_articles');
            $wiki_editor->add_cap('basepress_edit_published_articles');
            
            // Adding full BasePress management capabilities
            $wiki_editor->add_cap('basepress_manage_sections');
            $wiki_editor->add_cap('basepress_manage_options');
            $wiki_editor->add_cap('basepress_manage_kbs');
            $wiki_editor->add_cap('basepress_manage_products');
            $wiki_editor->add_cap('manage_basepress');
            
            // Taxonomy management for KB categories
            $wiki_editor->add_cap('manage_knowledgebase_cat');
            $wiki_editor->add_cap('edit_knowledgebase_cat');
            $wiki_editor->add_cap('delete_knowledgebase_cat');
            $wiki_editor->add_cap('assign_knowledgebase_cat');
        }
    }
}
add_action('init', 'jotunheim_create_wiki_editor_role');

/**
 * Check if current page is a restricted BasePress page
 */
function jotunheim_is_restricted_basepress_page() {
    // Get the BasePress taxonomy
    $kb_tax = function_exists('basepress_get_taxonomy') ? basepress_get_taxonomy() : 'knowledgebase_cat';
    
    // Check for Sections page
    if (isset($_GET['taxonomy']) && $_GET['taxonomy'] === $kb_tax) {
        return true;
    }
    
    // Check for Manage KB pages
    if (isset($_GET['page']) && strpos($_GET['page'], 'basepress') !== false) {
        return true;
    }
    
    return false;
}

/**
 * Redirect wiki editors away from restricted BasePress pages
 */
function jotunheim_redirect_from_restricted_pages() {
    // Only apply to wiki_editor role (not for admins)
    if (!current_user_can('wiki_editor') || current_user_can('administrator')) {
        return;
    }
    
    // If on a restricted page, redirect to main KB listing
    if (jotunheim_is_restricted_basepress_page()) {
        // Get the KB post type
        $kb_post_type = function_exists('basepress_get_post_type') ? basepress_get_post_type() : 'knowledgebase';
        
        // Redirect to the main KB articles page
        wp_safe_redirect(admin_url('edit.php?post_type=' . $kb_post_type));
        exit;
    }
}
add_action('admin_init', 'jotunheim_redirect_from_restricted_pages', 1);

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
    
    // Only keep the profile menu and KB menu items
    if (is_array($menu)) {
        foreach ($menu as $key => $item) {
            // Skip if not a proper menu item
            if (!isset($item[2])) {
                continue;
            }
            
            // Only keep profile menu and KB menu
            if ($item[2] !== 'profile.php' && 
                $item[2] !== 'edit.php?post_type=' . $kb_post_type) {
                remove_menu_page($item[2]);
            }
        }
    }
}
add_action('admin_menu', 'jotunheim_remove_admin_menu_items', 999);

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
 * Register wiki editor roles with BasePress
 */
function jotunheim_register_wiki_editor_with_basepress() {
    if (function_exists('basepress_kb_edit_post_user_roles')) {
        add_filter('basepress_kb_edit_post_user_roles', function($roles) {
            $roles[] = 'wiki_editor';
            return $roles;
        });
    }
}
add_action('init', 'jotunheim_register_wiki_editor_with_basepress', 20);