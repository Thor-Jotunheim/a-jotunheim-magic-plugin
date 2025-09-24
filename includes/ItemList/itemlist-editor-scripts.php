<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

// Include the item list editor scripts, interface, and AJAX handlers
require_once plugin_dir_path(__FILE__) . 'itemlist-editor-scripts.php';
require_once plugin_dir_path(__FILE__) . 'itemlist-editor-interface.php';
require_once plugin_dir_path(__FILE__) . 'itemlist-editor-ajax.php';

// Register shortcode for ItemList Editor
if (!function_exists('itemlist_editor_shortcode')) {
    function itemlist_editor_shortcode() {
        // Check permissions using Discord system
        $permission_check = jotunheim_check_shortcode_permission('itemlist_editor');
        if ($permission_check !== null) {
            return $permission_check;
        }
        
        ob_start();
        itemlist_editor_interface();
        return ob_get_clean();
    }
    add_shortcode('itemlist_editor', 'itemlist_editor_shortcode');
}