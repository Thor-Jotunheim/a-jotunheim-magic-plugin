<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Direct override for Wiki Editor permissions
 * 
 * This file provides a clean, focused solution to allow Wiki Editors
 * to edit knowledge base posts regardless of author.
 */

// Skip if not a Wiki Editor
if (!function_exists('current_user_can') || !current_user_can('wiki_editor')) {
    return;
}

/**
 * Force edit capability for knowledge base posts
 */
function jotunheim_wiki_editor_force_edit_capability() {
    // Only apply for admin area
    if (!is_admin()) return;
    
    global $pagenow, $post;
    
    // Always give edit capability for knowledge base post type
    add_filter('user_has_cap', function($allcaps) {
        $allcaps['edit_others_posts'] = true;
        return $allcaps;
    }, 99999);
    
    // Direct override for edit_post meta capability
    add_filter('map_meta_cap', function($caps, $cap, $user_id, $args) {
        // Only handle edit_post for knowledge base
        if ($cap == 'edit_post' && !empty($args[0])) {
            $post_id = $args[0];
            if (get_post_type($post_id) == 'knowledgebase') {
                return array('read'); // Replace with minimal capability
            }
        }
        return $caps;
    }, 99999, 4);
}
add_action('init', 'jotunheim_wiki_editor_force_edit_capability');

/**
 * Modify post row actions to add edit links
 */
function jotunheim_wiki_editor_modify_row_actions($actions, $post) {
    if ($post->post_type !== 'knowledgebase') {
        return $actions;
    }
    
    // Add edit link for knowledge base posts
    $actions['edit'] = sprintf(
        '<a href="%s">%s</a>',
        admin_url('post.php?post=' . $post->ID . '&action=edit'),
        __('Edit')
    );
    
    return $actions;
}
add_filter('post_row_actions', 'jotunheim_wiki_editor_modify_row_actions', 99999, 2);

/**
 * Direct override of knowledge base post permissions check
 */
add_filter('post_protected', function($protected, $post) {
    if ($post->post_type == 'knowledgebase') {
        return false; // Not protected, anyone can edit
    }
    return $protected;
}, 99999, 2);

/**
 * Filter the post edit action handling
 */
add_filter('wp_insert_post_data', function($data, $postarr) {
    // If a wiki editor is editing a knowledge base post, bypass permission check
    if (current_user_can('wiki_editor') && $data['post_type'] == 'knowledgebase') {
        $data['edit_others_posts'] = true;
    }
    return $data;
}, 99999, 2);

/**
 * Force all knowledge base posts to be editable
 */
add_action('pre_get_posts', function($query) {
    // Only apply in admin when viewing knowledge base posts
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }
    
    // If on knowledge base post type screen, remove author restriction
    if (isset($_GET['post_type']) && $_GET['post_type'] == 'knowledgebase') {
        $query->set('author', ''); // Remove author restriction
    }
});