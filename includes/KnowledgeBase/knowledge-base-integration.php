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

// Include the BasePress specific wiki editor integration
require_once(plugin_dir_path(__FILE__) . 'basepress-wiki-editor.php');

// Include the BasePress permission override
require_once(plugin_dir_path(__FILE__) . 'basepress-permission-override.php');

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
 * Add required scripts and styles for front-end
 */
function jotunheim_enqueue_knowledge_base_scripts() {
    if (has_shortcode(get_the_content(), 'jotunheim_knowledge_base')) {
        wp_enqueue_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'jotunheim_enqueue_knowledge_base_scripts');

/**
 * Add direct capabilities for wiki editors
 */
function jotunheim_force_wiki_editor_capabilities() {
    if (!current_user_can('wiki_editor')) {
        return;
    }
    
    // Note: We must use current_user_can('wiki_editor') instead of checking user roles
    // since current_user_can() is more reliable in WordPress
    
    // Force admin capabilities for all BasePress related areas
    add_filter('basepress_editor_roles', 'jotunheim_add_wiki_editor_role');
    add_filter('basepress_allowed_roles', 'jotunheim_add_wiki_editor_role');
    
    // Add permission overrides for specific BasePress pages
    add_filter('basepress_user_can_manage_sections', '__return_true');
    add_filter('basepress_user_can_manage_kbs', '__return_true');
    add_filter('basepress_user_can_manage_options', '__return_true');
    add_filter('basepress_user_can_manage_products', '__return_true');
    
    // Bypass any capability checks for manage_categories
    add_filter('map_meta_cap', 'jotunheim_bypass_meta_caps', 1, 4);
}
add_action('admin_init', 'jotunheim_force_wiki_editor_capabilities', 1);

/**
 * Help function to add wiki_editor to BasePress roles
 */
function jotunheim_add_wiki_editor_role($roles) {
    if (!in_array('wiki_editor', $roles)) {
        $roles[] = 'wiki_editor';
    }
    return $roles;
}

/**
 * Bypass capability checking for specific caps
 */
function jotunheim_bypass_meta_caps($required_caps, $cap, $user_id, $args) {
    // Only for wiki editors
    $user = get_userdata($user_id);
    if (!$user || !in_array('wiki_editor', $user->roles)) {
        return $required_caps;
    }
    
    // Directly bypass checks for these capabilities
    $bypass_caps = [
        'manage_categories',
        'manage_options',
        'edit_knowledgebase',
        'edit_knowledgebases',
        'edit_others_knowledgebases',
        'basepress_manage_sections',
        'basepress_manage_kbs'
    ];
    
    if (in_array($cap, $bypass_caps)) {
        return []; // Empty array means pass the capability check
    }
    
    return $required_caps;
}

/**
 * Add direct submenu items for wiki editors
 */
function jotunheim_add_direct_kb_menu_items() {
    if (!current_user_can('wiki_editor')) {
        return;
    }
    
    // Get the KB post type
    $kb_post_type = function_exists('basepress_get_post_type') ? basepress_get_post_type() : 'knowledgebase';
    $parent_slug = 'edit.php?post_type=' . $kb_post_type;
    
    // Add Sections page with minimal capability
    add_submenu_page(
        $parent_slug,
        'Sections',
        'Sections',
        'read',
        'basepress_sections',
        null // Let BasePress handle the callback
    );
    
    // Add Manage KBs page with minimal capability
    add_submenu_page(
        $parent_slug,
        'Manage KBs',
        'Manage KBs',
        'read',
        'basepress_manage_kbs',
        null // Let BasePress handle the callback
    );
}
add_action('admin_menu', 'jotunheim_add_direct_kb_menu_items', 999);

/**
 * Hard override capability checks for KB edit pages
 */
function jotunheim_force_kb_edit_permissions() {
    if (!current_user_can('wiki_editor')) {
        return;
    }
    
    // Check if we're editing a KB post
    global $pagenow;
    if ($pagenow === 'post.php' && isset($_GET['post'])) {
        $post_id = intval($_GET['post']);
        $post_type = get_post_type($post_id);
        $kb_post_type = function_exists('basepress_get_post_type') ? basepress_get_post_type() : 'knowledgebase';
        
        // If editing a KB post, make sure wiki editors can edit it
        if ($post_type === $kb_post_type) {
            add_filter('user_has_cap', function($allcaps) {
                $allcaps['edit_knowledgebase'] = true;
                $allcaps['edit_knowledgebases'] = true;
                $allcaps['edit_others_knowledgebases'] = true;
                $allcaps['edit_published_knowledgebases'] = true;
                $allcaps['edit_private_knowledgebases'] = true;
                $allcaps['basepress_edit_articles'] = true;
                $allcaps['basepress_edit_others_articles'] = true;
                $allcaps['basepress_edit_published_articles'] = true;
                return $allcaps;
            }, 0);
        }
    }
}
add_action('admin_init', 'jotunheim_force_kb_edit_permissions', 1);