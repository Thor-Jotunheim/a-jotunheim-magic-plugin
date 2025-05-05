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