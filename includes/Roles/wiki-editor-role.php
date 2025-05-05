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