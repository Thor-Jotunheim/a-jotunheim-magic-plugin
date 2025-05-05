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
            // Standard editing capabilities for KB
            $wiki_editor->add_cap('edit_knowledgebase');
            $wiki_editor->add_cap('edit_knowledgebases');
            $wiki_editor->add_cap('edit_others_knowledgebases');
            $wiki_editor->add_cap('edit_published_knowledgebases');
            $wiki_editor->add_cap('publish_knowledgebases');
            $wiki_editor->add_cap('read_private_knowledgebases');
            
            // Critical capabilities for Sections and Manage KBs pages
            $wiki_editor->add_cap('manage_categories');
            $wiki_editor->add_cap('edit_categories');
            $wiki_editor->add_cap('delete_categories');
            $wiki_editor->add_cap('assign_categories');
            
            // Add all capabilities that might be needed for BasePress
            $wiki_editor->add_cap('manage_options');
            $wiki_editor->add_cap('basepress_edit_articles');
            $wiki_editor->add_cap('basepress_edit_others_articles');
            $wiki_editor->add_cap('basepress_edit_published_articles');
            $wiki_editor->add_cap('basepress_edit_private_articles');
            $wiki_editor->add_cap('basepress_manage_sections');
            $wiki_editor->add_cap('basepress_manage_kbs');
            $wiki_editor->add_cap('basepress_manage_options');
            $wiki_editor->add_cap('basepress_manage_products');
            $wiki_editor->add_cap('manage_basepress');
            
            // KB taxonomy capabilities
            $kb_tax = 'knowledgebase_cat';
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
function jotunheim_hide_admin_menu_items() {
    // Only apply to wiki_editor role (not for admins)
    if (!current_user_can('wiki_editor') || current_user_can('administrator')) {
        return;
    }
    
    global $menu, $submenu;
    
    // Keep track of KB menu position to preserve it
    $kb_menu_position = null;
    $kb_post_type = 'knowledgebase'; // Default value
    
    // Find Knowledge Base menu position and post type
    if (is_array($menu)) {
        foreach ($menu as $key => $item) {
            if (isset($item[2]) && strpos($item[2], 'post_type=') !== false && strpos($item[2], 'knowledgebase') !== false) {
                $kb_menu_position = $key;
                preg_match('/post_type=([a-zA-Z0-9_-]+)/', $item[2], $matches);
                if (isset($matches[1])) {
                    $kb_post_type = $matches[1];
                }
                break;
            }
        }
    }
    
    // Remove all menu items except Knowledge Base and Profile
    if (is_array($menu)) {
        foreach ($menu as $key => $item) {
            // Skip if not a proper menu item
            if (!isset($item[2])) {
                continue;
            }
            
            // Keep only profile and KB menu
            if ($item[2] !== 'profile.php' && $key !== $kb_menu_position) {
                remove_menu_page($item[2]);
            }
        }
    }
    
    // Set dashboard redirect to KB
    add_action('current_screen', function() use ($kb_post_type) {
        $screen = get_current_screen();
        if ($screen && $screen->id === 'dashboard') {
            wp_safe_redirect(admin_url('edit.php?post_type=' . $kb_post_type));
            exit;
        }
    });
}
add_action('admin_menu', 'jotunheim_hide_admin_menu_items', 999);

/**
 * Override BasePress capability checks to ensure wiki editors have access
 */
function jotunheim_override_basepress_capability_check($allcaps, $caps, $args) {
    // Only apply to wiki_editor role
    if (!is_user_logged_in() || !current_user_can('wiki_editor') || current_user_can('administrator')) {
        return $allcaps;
    }
    
    // Grant access to critical capabilities for BasePress
    $basepress_caps = array(
        'manage_categories',
        'manage_options',
        'basepress_manage_sections',
        'basepress_manage_kbs',
        'basepress_manage_options',
        'manage_basepress'
    );
    
    foreach ($basepress_caps as $cap) {
        $allcaps[$cap] = true;
    }
    
    return $allcaps;
}
add_filter('user_has_cap', 'jotunheim_override_basepress_capability_check', 10, 3);