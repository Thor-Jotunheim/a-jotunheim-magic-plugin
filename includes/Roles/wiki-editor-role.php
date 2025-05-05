<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Simple Wiki Editor Role Definition
 */

/**
 * Create the Wiki Editor role with needed capabilities
 */
function jotunheim_create_wiki_editor_role() {
    // Check if wiki editor role already exists
    $wiki_editor = get_role('wiki_editor');
    
    // Define capabilities for wiki editor
    $capabilities = array(
        'read' => true,
        'edit_posts' => true,
        'edit_knowledgebase' => true,
        'edit_knowledgebases' => true,
        'edit_published_knowledgebases' => true,
        'read_knowledgebase' => true,
        'read_private_knowledgebases' => true,
        'publish_knowledgebases' => true,
    );
    
    if (!$wiki_editor) {
        // Create the role if it doesn't exist
        add_role('wiki_editor', 'Wiki Editor', $capabilities);
    } else {
        // Update existing role with capabilities
        foreach ($capabilities as $cap => $grant) {
            $wiki_editor->add_cap($cap, $grant);
        }
    }
}
add_action('init', 'jotunheim_create_wiki_editor_role');

/**
 * Add capabilities for custom post types to wiki editors
 */
function jotunheim_add_wiki_editor_capabilities() {
    // Get the post type object
    $post_type_object = get_post_type_object('knowledgebase');
    
    if ($post_type_object) {
        // Add caps to the wiki editor role
        $role = get_role('wiki_editor');
        
        if ($role) {
            // Add all capabilities needed to manage knowledge base items
            $role->add_cap('edit_' . $post_type_object->name);
            $role->add_cap('read_' . $post_type_object->name);
            $role->add_cap('publish_' . $post_type_object->name . 's');
            $role->add_cap('edit_' . $post_type_object->name . 's');
            $role->add_cap('edit_published_' . $post_type_object->name . 's');
            $role->add_cap('read_private_' . $post_type_object->name . 's');
        }
    }
}
add_action('init', 'jotunheim_add_wiki_editor_capabilities', 20);

/**
 * Hide all admin menu items except Knowledge Base and Profile for wiki editors
 */
function jotunheim_hide_admin_menu_items() {
    // Only apply to wiki_editor role (not for admins)
    if (!current_user_can('wiki_editor') || current_user_can('administrator')) {
        return;
    }
    
    global $menu, $submenu;
    
    // Define allowed pages
    $allowed_top_pages = array(
        'profile.php',
        'edit.php?post_type=knowledgebase'
    );
    
    // Remove menu items
    if (is_array($menu)) {
        foreach ($menu as $key => $item) {
            if (!isset($item[2])) {
                continue;
            }
            
            // Keep only allowed pages
            if (!in_array($item[2], $allowed_top_pages)) {
                remove_menu_page($item[2]);
            }
        }
    }
    
    // Cleanup submenu items if needed
    if (isset($submenu['edit.php?post_type=knowledgebase'])) {
        // Can optionally restrict specific submenu items here if needed
    }
}
add_action('admin_menu', 'jotunheim_hide_admin_menu_items', 999);

/**
 * Redirect wiki editors to knowledge base page after login
 */
function jotunheim_redirect_wiki_editors_after_login($redirect_to, $request, $user) {
    if (isset($user->roles) && is_array($user->roles)) {
        if (in_array('wiki_editor', $user->roles) && !in_array('administrator', $user->roles)) {
            return admin_url('edit.php?post_type=knowledgebase');
        }
    }
    return $redirect_to;
}
add_filter('login_redirect', 'jotunheim_redirect_wiki_editors_after_login', 10, 3);