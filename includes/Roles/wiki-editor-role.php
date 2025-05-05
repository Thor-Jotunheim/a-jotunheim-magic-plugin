<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Wiki Editor Role Definition
 * 
 * This file defines the Wiki Editor role and its capabilities.
 */

/**
 * Create and update the Wiki Editor role with needed capabilities
 */
function jotunheim_create_wiki_editor_role() {
    // Get admin role to copy needed permissions
    $admin = get_role('administrator');
    $admin_caps = $admin->capabilities;
    
    // Check if wiki editor role exists
    $wiki_editor = get_role('wiki_editor');
    if (!$wiki_editor) {
        // Create the role
        add_role('wiki_editor', 'Wiki Editor', array('read' => true));
        $wiki_editor = get_role('wiki_editor');
    }
    
    // First, add basic capabilities
    $wiki_editor->add_cap('read');
    $wiki_editor->add_cap('upload_files');
    
    // Add editing capabilities for all post types
    $wiki_editor->add_cap('edit_posts');
    $wiki_editor->add_cap('edit_others_posts');
    $wiki_editor->add_cap('edit_published_posts');
    $wiki_editor->add_cap('edit_private_posts');
    
    // Add KB specific capabilities - copy directly from admin role
    foreach ($admin_caps as $cap => $value) {
        // Add KB editing capabilities
        if (strpos($cap, 'edit_') === 0 && strpos($cap, 'knowledgebase') !== false) {
            $wiki_editor->add_cap($cap);
        }
        
        // Add KB publishing capabilities
        if (strpos($cap, 'publish_') === 0 && strpos($cap, 'knowledgebase') !== false) {
            $wiki_editor->add_cap($cap);
        }
        
        // Add KB reading capabilities
        if (strpos($cap, 'read_') === 0 && strpos($cap, 'knowledgebase') !== false) {
            $wiki_editor->add_cap($cap);
        }
        
        // Add BasePress specific capabilities
        if (strpos($cap, 'basepress_') === 0) {
            $wiki_editor->add_cap($cap);
        }
        
        // Add taxonomy management capabilities
        if (
            $cap === 'manage_categories' || 
            strpos($cap, 'knowledgebase_cat') !== false ||
            $cap === 'manage_options'
        ) {
            $wiki_editor->add_cap($cap);
        }
    }
    
    // Explicitly add critical capabilities
    $wiki_editor->add_cap('edit_knowledgebase');
    $wiki_editor->add_cap('edit_knowledgebases');
    $wiki_editor->add_cap('edit_others_knowledgebases');
    $wiki_editor->add_cap('edit_published_knowledgebases');
    $wiki_editor->add_cap('edit_private_knowledgebases');
    $wiki_editor->add_cap('publish_knowledgebases');
    $wiki_editor->add_cap('read_private_knowledgebases');
    $wiki_editor->add_cap('manage_knowledgebase_cat');
    $wiki_editor->add_cap('edit_knowledgebase_cat');
    
    // BasePress specific capabilities
    $wiki_editor->add_cap('basepress_edit_articles');
    $wiki_editor->add_cap('basepress_edit_others_articles');
    $wiki_editor->add_cap('basepress_edit_published_articles');
    $wiki_editor->add_cap('basepress_edit_private_articles');
    $wiki_editor->add_cap('basepress_manage_sections');
    $wiki_editor->add_cap('basepress_manage_kbs');
    $wiki_editor->add_cap('basepress_manage_products');
    $wiki_editor->add_cap('basepress_manage_options');
    $wiki_editor->add_cap('manage_basepress');
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
    
    global $menu;
    
    // Find Knowledge Base menu
    $kb_menu_slug = '';
    foreach ($menu as $key => $item) {
        if (isset($item[2]) && strpos($item[2], 'post_type=') !== false && strpos($item[2], 'knowledgebase') !== false) {
            $kb_menu_slug = $item[2];
            break;
        }
    }
    
    // Remove all menu items except Knowledge Base and Profile
    if (is_array($menu)) {
        foreach ($menu as $key => $item) {
            if (!isset($item[2])) {
                continue;
            }
            
            // Keep only profile and KB menu
            if ($item[2] !== 'profile.php' && $item[2] !== $kb_menu_slug) {
                remove_menu_page($item[2]);
            }
        }
    }
}
add_action('admin_menu', 'jotunheim_hide_admin_menu_items', 999);

/**
 * Override capability checks to ensure wiki editors can access everything KB related
 */
function jotunheim_override_kb_capabilities($allcaps, $caps, $args, $user) {
    // Only apply to wiki_editor role
    if (!in_array('wiki_editor', $user->roles) || in_array('administrator', $user->roles)) {
        return $allcaps;
    }
    
    // Get requested capability
    if (empty($caps)) {
        return $allcaps;
    }
    
    // Grant all KB and BasePress related capabilities
    foreach ($caps as $cap) {
        if (
            strpos($cap, 'knowledgebase') !== false ||
            strpos($cap, 'basepress') !== false ||
            $cap === 'manage_categories' ||
            $cap === 'manage_options'
        ) {
            $allcaps[$cap] = true;
        }
    }
    
    return $allcaps;
}
add_filter('user_has_cap', 'jotunheim_override_kb_capabilities', 1, 4);