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
 * Remove admin menu items that wiki editors shouldn't have access to
 */
function jotunheim_remove_admin_menu_items() {
    // Only apply to wiki_editor role (not for admins)
    if (!current_user_can('wiki_editor') || current_user_can('administrator')) {
        return;
    }
    
    // Get the KB post type
    $kb_post_type = function_exists('basepress_get_post_type') ? basepress_get_post_type() : 'knowledgebase';
    $parent_menu = 'edit.php?post_type=' . $kb_post_type;
    
    // Remove Sections from submenu
    global $submenu;
    if (isset($submenu[$parent_menu])) {
        foreach ($submenu[$parent_menu] as $key => $item) {
            // Look for Sections in the label or slug
            if (isset($item[0]) && 
                (strpos(strtolower($item[0]), 'section') !== false || 
                 (isset($item[2]) && strpos($item[2], 'section') !== false))) {
                unset($submenu[$parent_menu][$key]);
            }
            
            // Look for Manage KB items
            if (isset($item[2]) && strpos($item[2], 'basepress') !== false) {
                unset($submenu[$parent_menu][$key]);
            }
        }
    }
}
add_action('admin_menu', 'jotunheim_remove_admin_menu_items', 999);