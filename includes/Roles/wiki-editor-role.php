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
            
            // BasePress specific capabilities for content editing only
            $wiki_editor->add_cap('basepress_edit_articles');
            $wiki_editor->add_cap('basepress_edit_knowledgebases');
            
            // Explicitly NOT adding admin capabilities:
            // - basepress_manage_options
            // - basepress_manage_sections
            // - basepress_manage_products
            // - manage_basepress
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
 * Hide all admin menu items except Knowledge Base for wiki editors
 */
function jotunheim_remove_admin_menu_items() {
    // Only apply to wiki_editor role (not for admins)
    if (!current_user_can('wiki_editor') || current_user_can('administrator')) {
        return;
    }
    
    // Get the KB post type
    $kb_post_type = function_exists('basepress_get_post_type') ? basepress_get_post_type() : 'knowledgebase';
    $kb_menu = 'edit.php?post_type=' . $kb_post_type;
    
    global $menu, $submenu;
    
    // First, remove all menu items except profile and Knowledge Base
    if (is_array($menu)) {
        foreach ($menu as $key => $item) {
            // Skip if not a proper menu item
            if (!isset($item[2])) {
                continue;
            }
            
            // Keep only profile menu and KB menu
            if ($item[2] !== 'profile.php' && $item[2] !== $kb_menu) {
                remove_menu_page($item[2]);
            }
        }
    }
    
    // Remove specific items from KB submenu
    if (isset($submenu[$kb_menu])) {
        foreach ($submenu[$kb_menu] as $key => $item) {
            // Keep only All Articles and Add Post submenus
            if (!isset($item[2])) {
                continue;
            }
            
            // Check if this contains 'sections' or is a BasePress management page
            if (strpos(strtolower($item[0]), 'section') !== false || 
                strpos($item[2], 'edit-tags.php') !== false ||
                strpos($item[2], 'basepress') !== false) {
                remove_submenu_page($kb_menu, $item[2]);
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
    if (current_user_can('wiki_editor') && !current_user_can('administrator')) {
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
}
add_action('current_screen', 'jotunheim_wiki_editor_redirect');