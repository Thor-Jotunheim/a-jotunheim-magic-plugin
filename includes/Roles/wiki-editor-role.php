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
    // Only run this for wiki editors
    if (!is_user_logged_in() || !current_user_can('wiki_editor')) {
        return;
    }
    
    // Direct override for edit_post capability
    add_filter('map_meta_cap', function($caps, $cap, $user_id, $args) {
        // These are the capabilities we want to modify
        $edit_caps = array(
            'edit_post',
            'edit_others_posts',
            'edit_published_posts',
            'edit_others_knowledgebases'
        );
        
        if (in_array($cap, $edit_caps) && isset($args[0])) {
            $post_id = $args[0];
            $post = get_post($post_id);
            
            // Only modify for knowledge base post type
            if ($post && $post->post_type === 'knowledgebase') {
                return array('edit_knowledgebases');  // Replace with a capability they already have
            }
        }
        
        return $caps;
    }, 999, 4);  // High priority to override other filters
    
    // Show edit links for all knowledgebase posts in admin
    add_filter('post_row_actions', function($actions, $post) {
        if ($post->post_type === 'knowledgebase') {
            if (!isset($actions['edit'])) {
                $actions['edit'] = sprintf(
                    '<a href="%s">%s</a>',
                    get_edit_post_link($post->ID),
                    __('Edit')
                );
            }
        }
        return $actions;
    }, 999, 2);
}
add_action('init', 'jotunheim_allow_wiki_editors_edit_any_kb_post', 999);  // Very high priority

/**
 * Force-add editing capabilities for Wiki Editors when in admin
 */
function jotunheim_force_kb_edit_capabilities() {
    // Only run in admin and for wiki editors
    if (!is_admin() || !current_user_can('wiki_editor')) {
        return;
    }
    
    global $pagenow;
    
    // When viewing or editing a post
    if (($pagenow === 'post.php' || $pagenow === 'post-new.php') && isset($_GET['post_type']) && $_GET['post_type'] === 'knowledgebase') {
        // Add all possible editing caps
        add_filter('user_has_cap', function($allcaps) {
            $allcaps['edit_others_knowledgebases'] = true;
            $allcaps['edit_others_posts'] = true;
            $allcaps['edit_published_knowledgebases'] = true;
            $allcaps['edit_published_posts'] = true;
            $allcaps['edit_knowledgebase'] = true;
            $allcaps['edit_knowledgebases'] = true;
            return $allcaps;
        }, 999);
    }
    
    // When editing an existing post
    if ($pagenow === 'post.php' && isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['post'])) {
        $post_id = intval($_GET['post']);
        $post_type = get_post_type($post_id);
        
        if ($post_type === 'knowledgebase') {
            // Add all possible editing caps
            add_filter('user_has_cap', function($allcaps) {
                $allcaps['edit_others_knowledgebases'] = true;
                $allcaps['edit_others_posts'] = true;
                $allcaps['edit_published_knowledgebases'] = true;
                $allcaps['edit_published_posts'] = true;
                $allcaps['edit_knowledgebase'] = true;
                $allcaps['edit_knowledgebases'] = true;
                return $allcaps;
            }, 999);
        }
    }
    
    // In the posts list
    if ($pagenow === 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] === 'knowledgebase') {
        add_filter('user_has_cap', function($allcaps) {
            $allcaps['edit_others_knowledgebases'] = true;
            $allcaps['edit_others_posts'] = true;
            return $allcaps;
        }, 999);
    }
}
add_action('admin_init', 'jotunheim_force_kb_edit_capabilities');

/**
 * Modify edit post link for knowledgebase post type
 */
function jotunheim_modify_edit_post_link($url, $post_id, $context) {
    if (current_user_can('wiki_editor') && get_post_type($post_id) === 'knowledgebase') {
        // Force the edit link to work by adding a special parameter
        return add_query_arg('wiki_editor_override', '1', $url);
    }
    
    return $url;
}
add_filter('get_edit_post_link', 'jotunheim_modify_edit_post_link', 10, 3);

/**
 * Directly modify post row actions to ensure edit links for Wiki Editors
 */
function jotunheim_force_kb_row_edit_links($actions, $post) {
    // Only apply to knowledge base posts and Wiki Editors
    if ($post->post_type !== 'knowledgebase' || !current_user_can('wiki_editor')) {
        return $actions;
    }
    
    // Add edit action regardless of author
    $actions['edit'] = sprintf(
        '<a href="%s" aria-label="%s">%s</a>',
        get_edit_post_link($post->ID),
        /* translators: %s: post title */
        esc_attr(sprintf(__('Edit &#8220;%s&#8221;'), $post->post_title)),
        __('Edit')
    );
    
    // Add view action
    if (!isset($actions['view'])) {
        $actions['view'] = sprintf(
            '<a href="%s" rel="bookmark" aria-label="%s">%s</a>',
            get_permalink($post->ID),
            /* translators: %s: post title */
            esc_attr(sprintf(__('View &#8220;%s&#8221;'), $post->post_title)),
            __('View')
        );
    }
    
    return $actions;
}
// Use priority 99999 to ensure our function runs last
add_filter('post_row_actions', 'jotunheim_force_kb_row_edit_links', 99999, 2);

/**
 * Add a pre_get_posts filter to ensure wiki editors see all knowledge base posts
 */
function jotunheim_show_all_kb_posts_to_wiki_editors($query) {
    // Only modify admin queries for wiki editors
    if (!is_admin() || !current_user_can('wiki_editor') || !$query->is_main_query()) {
        return;
    }
    
    // Check if we're on the knowledgebase post type screen
    $screen = get_current_screen();
    if (!$screen || $screen->post_type !== 'knowledgebase') {
        return;
    }
    
    // Remove author restriction for wiki editors
    $query->set('author', '');
}
add_action('pre_get_posts', 'jotunheim_show_all_kb_posts_to_wiki_editors');

/**
 * Override post type capability check for wiki editors
 */
function jotunheim_override_post_edit_capability() {
    // Only apply for wiki editors
    if (!current_user_can('wiki_editor')) {
        return;
    }
    
    // This directly modifies the post type object to give edit access to wiki editors
    add_filter('register_post_type_args', function($args, $post_type) {
        if ($post_type === 'knowledgebase') {
            // Modify capability type to use something wiki editors can access
            $args['capability_type'] = 'post';
            
            // Set specific capabilities
            $args['capabilities'] = array(
                'edit_post' => 'edit_posts',
                'read_post' => 'read',
                'delete_post' => 'edit_posts',
                'edit_posts' => 'edit_posts',
                'edit_others_posts' => 'edit_posts',  // Use edit_posts instead of edit_others_posts
                'publish_posts' => 'edit_posts',
                'read_private_posts' => 'read',
            );
        }
        return $args;
    }, 99999, 2);
}
add_action('init', 'jotunheim_override_post_edit_capability', 5); // Run early to affect registration