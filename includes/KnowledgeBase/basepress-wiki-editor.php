<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * BasePress Wiki Editor Integration
 * 
 * This file handles the integration between the wiki editor role and BasePress,
 * focusing specifically on ensuring proper permissions for KB editing and admin pages.
 */

/**
 * Initialize the BasePress integration
 */
function jotunheim_init_basepress_wiki_editor() {
    // Only run if BasePress is active
    if (!class_exists('Basepress')) {
        return;
    }
    
    // Add wiki editor to the list of BasePress editor roles
    add_filter('basepress_editor_roles', 'jotunheim_add_wiki_editor_to_basepress');
    add_filter('basepress_allowed_roles', 'jotunheim_add_wiki_editor_to_basepress');
    
    // Force wiki editors to have edit capabilities for KB posts
    add_action('admin_init', 'jotunheim_add_kb_edit_capabilities');
    
    // Override menu visibility for KB special pages
    add_action('admin_menu', 'jotunheim_add_kb_admin_menu_items', 20);
    
    // Override capability checks for BasePress admin pages
    add_filter('user_has_cap', 'jotunheim_override_basepress_caps', 0, 4);
    
    // Override section management capabilities
    add_filter('basepress_user_can_manage_sections', 'jotunheim_allow_sections_access', 0, 1);
    add_filter('basepress_user_can_manage_kbs', 'jotunheim_allow_kbs_access', 0, 1);
}
add_action('plugins_loaded', 'jotunheim_init_basepress_wiki_editor', 20);

/**
 * Add wiki editor role to BasePress allowed roles
 */
function jotunheim_add_wiki_editor_to_basepress($roles) {
    if (!in_array('wiki_editor', $roles)) {
        $roles[] = 'wiki_editor';
    }
    return $roles;
}

/**
 * Add KB editing capabilities to wiki editors
 */
function jotunheim_add_kb_edit_capabilities() {
    // Only apply to wiki editor role
    if (!current_user_can('wiki_editor') || current_user_can('administrator')) {
        return;
    }
    
    // Get KB post type
    $kb_post_type = function_exists('basepress_get_post_type') ? basepress_get_post_type() : 'knowledgebase';
    
    // Get the user
    $user = wp_get_current_user();
    
    // Add basic capabilities directly to user
    $user->add_cap('edit_' . $kb_post_type);
    $user->add_cap('edit_' . $kb_post_type . 's');
    $user->add_cap('edit_published_' . $kb_post_type . 's');
    $user->add_cap('edit_others_' . $kb_post_type . 's');
    $user->add_cap('publish_' . $kb_post_type . 's');
    $user->add_cap('delete_' . $kb_post_type . 's');
    $user->add_cap('delete_others_' . $kb_post_type . 's');
    
    // BasePress specific capabilities
    $user->add_cap('basepress_edit_articles');
    $user->add_cap('basepress_edit_others_articles');
    $user->add_cap('basepress_edit_published_articles');
    $user->add_cap('basepress_delete_articles');
    $user->add_cap('basepress_publish_articles');
    
    // Admin capabilities needed for Sections and Manage KBs
    $user->add_cap('manage_categories');
    $user->add_cap('basepress_manage_sections');
    $user->add_cap('basepress_manage_kbs');
    $user->add_cap('manage_basepress');
}

/**
 * Add KB admin menu items for wiki editor
 */
function jotunheim_add_kb_admin_menu_items() {
    // Only apply to wiki editor role
    if (!current_user_can('wiki_editor') || current_user_can('administrator')) {
        return;
    }
    
    // Get KB post type
    $kb_post_type = function_exists('basepress_get_post_type') ? basepress_get_post_type() : 'knowledgebase';
    $parent_slug = 'edit.php?post_type=' . $kb_post_type;
    
    // Add Sections page with reading capability
    add_submenu_page(
        $parent_slug,
        'Sections',
        'Sections',
        'read',
        'basepress_sections',
        null // Let BasePress handle the callback
    );
    
    // Add Manage KBs page with reading capability
    add_submenu_page(
        $parent_slug,
        'Manage KBs',
        'Manage KBs',
        'read',
        'basepress_manage_kbs',
        null // Let BasePress handle the callback
    );
}

/**
 * Override BasePress capabilities for wiki editors
 */
function jotunheim_override_basepress_caps($allcaps, $caps, $args, $user) {
    // Only apply to wiki editor role
    if (!in_array('wiki_editor', $user->roles) || in_array('administrator', $user->roles)) {
        return $allcaps;
    }
    
    // Get current page
    global $pagenow;
    $page = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : '';
    $post_type = isset($_GET['post_type']) ? sanitize_text_field($_GET['post_type']) : '';
    $kb_post_type = function_exists('basepress_get_post_type') ? basepress_get_post_type() : 'knowledgebase';
    
    // If we're on a BasePress admin page or editing a KB post
    if (($pagenow === 'edit.php' && $post_type === $kb_post_type && 
         ($page === 'basepress_sections' || $page === 'basepress_manage_kbs')) ||
        ($pagenow === 'post.php' && isset($_GET['post']) && 
         get_post_type(intval($_GET['post'])) === $kb_post_type)) {
        
        // Grant all necessary capabilities
        $allcaps['manage_categories'] = true;
        $allcaps['manage_options'] = true;
        $allcaps['basepress_manage_sections'] = true;
        $allcaps['basepress_manage_kbs'] = true;
        $allcaps['manage_basepress'] = true;
        $allcaps['edit_knowledgebase'] = true;
        $allcaps['edit_knowledgebases'] = true;
        $allcaps['edit_others_knowledgebases'] = true;
        $allcaps['edit_published_knowledgebases'] = true;
    }
    
    return $allcaps;
}

/**
 * Allow wiki editors to manage sections
 */
function jotunheim_allow_sections_access($can_access) {
    if (current_user_can('wiki_editor')) {
        return true;
    }
    return $can_access;
}

/**
 * Allow wiki editors to manage KBs
 */
function jotunheim_allow_kbs_access($can_access) {
    if (current_user_can('wiki_editor')) {
        return true;
    }
    return $can_access;
}