<?php
// main.php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Enqueue scripts and styles specific to ItemList Editor
require_once plugin_dir_path(__FILE__) . 'includes/itemlist-editor-scripts.php';

// ItemList Editor interface function
require_once plugin_dir_path(__FILE__) . 'includes/itemlist-editor-interface.php';

// Register shortcode for ItemList Editor
add_shortcode('itemlist_editor', 'itemlist_editor_interface');

// AJAX handlers for the item list operations
require_once plugin_dir_path(__FILE__) . 'includes/itemlist-editor-ajax.php';

// Function to create the admin menu
if (!function_exists('jotunheim_magic_admin_menu')) {
    function jotunheim_magic_admin_menu() {
        add_menu_page(
            'Jotunheim Magic',
            'Jotunheim Magic',
            'manage_options',
            'jotunheim-magic',
            'jotunheim_magic_admin_page',
            'dashicons-admin-generic'
        );
    }
    add_action('admin_menu', 'jotunheim_magic_admin_menu');
}

// Admin page callback
if (!function_exists('jotunheim_magic_admin_page')) {
    function jotunheim_magic_admin_page() {
        ?>
        <div class="wrap">
            <h1>Welcome to Jotunheim Magic</h1>
            <p>Manage your item list and editor.</p>
            <p>[itemlist_editor] - Use this shortcode to display the item list editor.</p>
        </div>
        <?php
    }
}