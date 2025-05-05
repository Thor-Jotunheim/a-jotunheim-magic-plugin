<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Knowledge Base Integration
 * 
 * This file handles the integration of the Knowledge Base functionality with WordPress.
 */

// Include the wiki editor role definition
require_once(plugin_dir_path(dirname(__FILE__)) . 'Roles/wiki-editor-role.php');

/**
 * Register knowledge base shortcode
 */
function jotunheim_register_knowledge_base_shortcode() {
    add_shortcode('jotunheim_knowledge_base', 'jotunheim_knowledge_base_shortcode');
}
add_action('init', 'jotunheim_register_knowledge_base_shortcode');

/**
 * Knowledge Base shortcode callback (simplified version after interface file deletion)
 */
function jotunheim_knowledge_base_shortcode($atts) {
    return '<p>Please contact the administrator to set up the Knowledge Base interface.</p>';
}

/**
 * Add the Wiki Editor role to BasePress editors
 */
function jotunheim_add_wiki_editor_to_basepress($roles) {
    if (!in_array('wiki_editor', $roles)) {
        $roles[] = 'wiki_editor';
    }
    return $roles;
}
add_filter('basepress_editor_roles', 'jotunheim_add_wiki_editor_to_basepress');
add_filter('basepress_allowed_roles', 'jotunheim_add_wiki_editor_to_basepress');

/**
 * Add required scripts and styles for front-end
 */
function jotunheim_enqueue_knowledge_base_scripts() {
    if (has_shortcode(get_the_content(), 'jotunheim_knowledge_base')) {
        wp_enqueue_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'jotunheim_enqueue_knowledge_base_scripts');

/**
 * Ensure wiki editors have access to Sections and Manage KB pages
 */
function jotunheim_ensure_basepress_access() {
    // Skip if not logged in or not a wiki editor
    if (!is_user_logged_in() || !current_user_can('wiki_editor') || current_user_can('administrator')) {
        return;
    }
    
    // Add filters to ensure wiki editors can access BasePress special pages
    add_filter('basepress_user_can_manage_sections', '__return_true');
    add_filter('basepress_user_can_manage_kbs', '__return_true');
    add_filter('basepress_user_can_manage_options', '__return_true');
    
    // Also unhook any capability check in BasePress that might be preventing access
    if (class_exists('Basepress_Sections_Page')) {
        remove_all_filters('admin_menu');
        add_action('admin_menu', function() {
            if (function_exists('basepress_get_post_type')) {
                $kb_post_type = basepress_get_post_type();
                
                // Directly add menu items for Sections and Manage KB using the read capability
                add_submenu_page(
                    'edit.php?post_type=' . $kb_post_type, 
                    'BasePress Sections', 
                    'Sections', 
                    'read', 
                    'basepress_sections',
                    'basepress_sections_page_output'
                );
                
                add_submenu_page(
                    'edit.php?post_type=' . $kb_post_type, 
                    'Manage Knowledge Bases', 
                    'Manage KBs', 
                    'read', 
                    'basepress_manage_kbs',
                    'basepress_manage_kbs_page_output'
                );
            }
        }, 9);
        
        // Re-add our menu hiding function with a later priority
        add_action('admin_menu', 'jotunheim_hide_admin_menu_items', 999);
    }
}
add_action('admin_init', 'jotunheim_ensure_basepress_access');

/**
 * Add direct capability checks overrides for wiki_editor in BasePress contexts
 */
function jotunheim_filter_basepress_capability_checks() {
    // Skip if not logged in or not a wiki editor
    if (!is_user_logged_in() || !current_user_can('wiki_editor') || current_user_can('administrator')) {
        return;
    }
    
    // Check if we're on a BasePress admin page
    if (is_admin() && isset($_GET['page'])) {
        $page = sanitize_text_field($_GET['page']);
        if ($page === 'basepress_sections' || $page === 'basepress_manage_kbs') {
            // Override capability check in the most aggressive way
            add_filter('map_meta_cap', function($caps, $cap) {
                if ($cap === 'manage_categories' || $cap === 'manage_options' || 
                    strpos($cap, 'basepress_') === 0) {
                    return array();  // Empty array bypasses the check
                }
                return $caps;
            }, 0, 2);
        }
    }
}
add_action('admin_init', 'jotunheim_filter_basepress_capability_checks', 1);