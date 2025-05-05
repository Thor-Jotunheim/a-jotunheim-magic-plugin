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
        // Basic capabilities
        'read' => true,
        'edit_posts' => true,
        'upload_files' => true,
        
        // Knowledge Base specific capabilities
        'edit_knowledgebase' => true,
        'edit_knowledgebases' => true,
        'edit_others_knowledgebases' => true,
        'edit_published_knowledgebases' => true,
        'edit_others_posts' => true, 
        'edit_private_knowledgebases' => true,
        'read_knowledgebase' => true,
        'read_private_knowledgebases' => true,
        'publish_knowledgebases' => true,
        'delete_knowledgebase' => true,
        'delete_knowledgebases' => true,
        'delete_published_knowledgebases' => true,
        'delete_others_knowledgebases' => true,
        'manage_categories' => true,
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
    
    // Add the custom capabilities that may be used by the BasePress Knowledge Base plugin
    $custom_caps = array(
        'basepress_view_others_sections',
        'basepress_edit_others_sections',
        'basepress_manage_sections',
        'basepress_manage_knowledgebases',
    );
    
    foreach ($custom_caps as $cap) {
        if ($wiki_editor) {
            $wiki_editor->add_cap($cap, true);
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
            // Standard post capabilities
            $post_caps = array(
                'edit_post',
                'read_post',
                'delete_post',
                'edit_posts',
                'edit_others_posts',
                'publish_posts',
                'read_private_posts',
            );
            
            // Map standard caps to the post type
            foreach ($post_caps as $cap) {
                $role->add_cap(str_replace('post', $post_type_object->name, $cap));
                $role->add_cap(str_replace('post', $post_type_object->name . 's', $cap));
            }
            
            // Add taxonomy capabilities
            $role->add_cap('manage_knowledgebase_categories');
            $role->add_cap('edit_knowledgebase_categories');
            $role->add_cap('delete_knowledgebase_categories');
            $role->add_cap('assign_knowledgebase_categories');
        }
    }
}
add_action('init', 'jotunheim_add_wiki_editor_capabilities', 20);

/**
 * Allow wiki editors to access Knowledge Base related menus
 */
function jotunheim_set_kb_menu_access() {
    if (!current_user_can('wiki_editor')) return;
    
    // Give access to the Knowledge Base admin menu
    global $pagenow;
    
    // Add specific capability to access KB admin page
    if ($pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'knowledgebase') {
        add_filter('user_has_cap', function($allcaps) {
            $allcaps['edit_knowledgebase'] = true;
            $allcaps['edit_knowledgebases'] = true;
            $allcaps['read_knowledgebase'] = true;
            $allcaps['manage_knowledgebase_terms'] = true;
            $allcaps['edit_knowledgebase_terms'] = true;
            $allcaps['delete_knowledgebase_terms'] = true;
            $allcaps['assign_knowledgebase_terms'] = true;
            $allcaps['basepress_view_others_sections'] = true;
            $allcaps['basepress_edit_others_sections'] = true;
            $allcaps['basepress_manage_sections'] = true;
            $allcaps['basepress_manage_knowledgebases'] = true;
            return $allcaps;
        });
    }
}
add_action('admin_init', 'jotunheim_set_kb_menu_access');

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
    
    // Make sure Knowledge Base submenu items are accessible
    if (isset($submenu['edit.php?post_type=knowledgebase'])) {
        // Keep all KB submenu items visible - no need to restrict them
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

/**
 * Filter admin bar nodes to ensure wiki editors see only relevant items
 */
function jotunheim_filter_admin_bar_for_wiki_editors($wp_admin_bar) {
    if (!current_user_can('wiki_editor') || current_user_can('administrator')) {
        return;
    }
    
    // Keep only specific admin bar nodes
    $keep_nodes = array('top-secondary', 'my-account', 'user-actions', 
        'user-info', 'edit-profile', 'logout', 'menu-toggle', 
        'site-name', 'view-site', 'wiki-editor-kb', 'wiki-editor-kb-all', 
        'wiki-editor-kb-add', 'wiki-editor-kb-manage', 'wiki-editor-kb-sections');
        
    // Get all nodes
    $all_nodes = $wp_admin_bar->get_nodes();
    
    if ($all_nodes) {
        foreach ($all_nodes as $node) {
            if (!in_array($node->id, $keep_nodes)) {
                $wp_admin_bar->remove_node($node->id);
            }
        }
    }
}
add_action('admin_bar_menu', 'jotunheim_filter_admin_bar_for_wiki_editors', 999);

/**
 * Allow wiki editors to edit any knowledge base post regardless of author
 */
function jotunheim_allow_wiki_editors_edit_any_kb_post() {
    if (!current_user_can('wiki_editor')) return;
    
    // When editing a single post
    add_filter('map_meta_cap', function($caps, $cap, $user_id, $args) {
        // Only apply to knowledge base post type
        if (!isset($args[0])) return $caps;
        
        $post_id = $args[0];
        $post = get_post($post_id);
        
        if (!$post || $post->post_type !== 'knowledgebase') return $caps;
        
        // Check if it's an edit capability being checked
        $edit_caps = array(
            'edit_post',
            'edit_others_posts', 
            'edit_published_posts',
            'edit_others_knowledgebases',
            'edit_knowledgebase',
            'edit_knowledgebases'
        );
        
        if (in_array($cap, $edit_caps)) {
            // Remove restrictive capabilities
            foreach ($caps as $key => $capability) {
                if ($capability == 'do_not_allow') {
                    unset($caps[$key]);
                }
            }
            
            // Add the capability needed
            $caps[] = 'edit_others_knowledgebases';
        }
        
        return $caps;
    }, 10, 4);
    
    // Ensure "Edit" links are visible in admin
    add_filter('user_has_cap', function($allcaps) {
        $allcaps['edit_others_knowledgebases'] = true;
        $allcaps['edit_others_posts'] = true;
        return $allcaps;
    }, 10);
}
add_action('init', 'jotunheim_allow_wiki_editors_edit_any_kb_post', 30);