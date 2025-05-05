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
}
add_action('init', 'jotunheim_create_wiki_editor_role');

/**
 * Direct access to edit knowledge base posts by any author
 */
function jotunheim_wiki_editor_edit_access() {
    // Only apply for wiki editors in admin
    if (!is_admin() || !current_user_can('wiki_editor')) {
        return;
    }

    // Work around the edit checks by modifying capability mapping
    add_filter('map_meta_cap', 'jotunheim_wiki_editor_map_meta_cap', 10, 4);
    
    // Force edit links to appear in the posts list
    add_filter('post_row_actions', 'jotunheim_wiki_editor_row_actions', 10, 2);
    
    // Allow editing posts of any author in the KB post list
    add_action('pre_get_posts', 'jotunheim_wiki_editor_posts_query');
}
add_action('admin_init', 'jotunheim_wiki_editor_edit_access');

/**
 * Override meta capability mapping for knowledge base posts
 */
function jotunheim_wiki_editor_map_meta_cap($caps, $cap, $user_id, $args) {
    // Only process for relevant edit capabilities
    $edit_caps = array('edit_post', 'edit_others_posts', 'edit_published_posts');
    
    if (!in_array($cap, $edit_caps) || empty($args[0])) {
        return $caps;
    }
    
    $post_id = $args[0];
    $post = get_post($post_id);
    
    // Only modify for knowledge base post type
    if (!$post || $post->post_type !== 'knowledgebase') {
        return $caps;
    }
    
    // Allow wiki editors to edit any knowledge base post
    return array('read');
}

/**
 * Ensure edit links appear for all knowledge base posts
 */
function jotunheim_wiki_editor_row_actions($actions, $post) {
    if ($post->post_type !== 'knowledgebase') {
        return $actions;
    }
    
    // Always provide an edit link
    $actions['edit'] = sprintf(
        '<a href="%s">%s</a>',
        admin_url('post.php?post=' . $post->ID . '&action=edit'),
        __('Edit')
    );
    
    return $actions;
}

/**
 * Remove author restrictions from knowledge base posts query
 */
function jotunheim_wiki_editor_posts_query($query) {
    if (!$query->is_main_query()) {
        return;
    }
    
    // Only apply to knowledge base post type
    if (isset($_GET['post_type']) && $_GET['post_type'] === 'knowledgebase') {
        $query->set('author', ''); // Remove author restriction
    }
}

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
 * Direct fix for access to edit knowledge base posts by any author
 */
function jotunheim_fix_wiki_editor_edit_access() {
    // Only apply for wiki editors
    if (!current_user_can('wiki_editor')) {
        return;
    }
    
    global $pagenow, $typenow;
    //
    // Add edit link for all KB posts
    add_filter('post_row_actions', function($actions, $post) {
        if ($post->post_type === 'knowledgebase') {
            $actions['edit'] = sprintf(
                '<a href="%s">%s</a>',
                admin_url('post.php?post=' . $post->ID . '&action=edit'),
                __('Edit')
            );
        }
        return $actions;
    }, 999, 2);
    
    // Direct permission override for edit screen
    if ($pagenow === 'post.php' && isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['post'])) {
        $post_id = intval($_GET['post']);
        $post_type = get_post_type($post_id);
        
        if ($post_type === 'knowledgebase') {
            // Override core WordPress permission check
            add_filter('user_has_cap', function($allcaps, $caps, $args, $user) use ($post_id) {
                $allcaps['edit_others_posts'] = true;
                $allcaps['edit_others_knowledgebases'] = true;
                $allcaps['edit_post'] = true;
                $allcaps['edit_published_posts'] = true;
                $allcaps['edit_published_knowledgebases'] = true;
                return $allcaps;
            }, 999, 4);
            
            // Override post edit permission check
            add_filter('map_meta_cap', function($caps, $cap, $user_id, $args) use ($post_id) {
                // For edit_post capability check
                if ($cap === 'edit_post' && isset($args[0]) && $args[0] == $post_id) {
                    return array('read');
                }
                return $caps;
            }, 999, 4);
            
            // Remove post lock
            add_filter('wp_check_post_lock_window', function() use ($post_id) {
                return 0; // Disable post lock
            });
        }
    }
}
add_action('init', 'jotunheim_fix_wiki_editor_edit_access', 999);

/**
 * Fix KB post type registration to allow wiki editors to edit any post
 */
function jotunheim_modify_kb_post_type_caps() {
    if (!current_user_can('wiki_editor')) {
        return;
    }
    
    add_filter('register_post_type_args', function($args, $post_type) {
        if ($post_type === 'knowledgebase') {
            // Set capabilities that wiki editors can access
            if (isset($args['capability_type'])) {
                $args['capability_type'] = 'post';
                $args['capabilities'] = array(
                    'edit_post' => 'edit_posts',
                    'read_post' => 'read',
                    'delete_post' => 'edit_posts',
                    'edit_posts' => 'edit_posts',
                    'edit_others_posts' => 'edit_posts',
                    'publish_posts' => 'edit_posts',
                    'read_private_posts' => 'read',
                );
            }
        }
        return $args;
    }, 999, 2);
}
add_action('init', 'jotunheim_modify_kb_post_type_caps', 1);

/**
 * Add special meta filter to bypass author checks
 */
function jotunheim_bypass_post_author_check() {
    add_filter('get_post_metadata', function($value, $post_id, $meta_key, $single) {
        // Special override for post_author when wiki_editor is trying to edit
        if (current_user_can('wiki_editor') && !current_user_can('administrator')) {
            if ($meta_key === '_edit_last' || $meta_key === '_edit_lock') {
                return false; // Skip these checks
            }
        }
        return $value;
    }, 999, 4);
}
add_action('init', 'jotunheim_bypass_post_author_check');