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
    if (!$wiki_editor) {
        add_role('wiki_editor', 'Wiki Editor', array('read' => true));
    }
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