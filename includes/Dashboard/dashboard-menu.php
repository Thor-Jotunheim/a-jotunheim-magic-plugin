<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Function to add the main menu item and submenu items
function jotunheim_magic_plugin_menu() {
    // Main Menu Page for Jotunheim Magic Plugin
    add_menu_page(
        'Jotunheim Magic Plugin',       // Page title
        'Jotunheim Magic Plugin',       // Menu title in admin sidebar
        'manage_options',               // Capability required
        'jotunheim_magic_plugin',       // Menu slug
        'jotunheim_magic_dashboard',    // Callback function for main page
        'dashicons-hammer',             // Icon URL or Dashicon (hammer for example)
        6                               // Position in the menu order
    );

    // Define submenu items and their callback functions
    $submenus = [
        [
            'title'       => 'Prefab Image Import',
            'menu_title'  => 'Prefab Image Import',
            'slug'        => 'prefab_image_import',
            'callback'    => 'render_prefab_image_import_page',
        ],
        [
            'title'       => 'Item List Editor',
            'menu_title'  => 'Item List Editor',
            'slug'        => 'item list_editor',
            'callback'    => 'render_item_list_editor_page',
        ],
        [
            'title'       => 'Item List Add New Item',
            'menu_title'  => 'Item List Add New Item',
            'slug'        => 'item list_add_new_item',
            'callback'    => 'render_item_list_add_new_item_page',
        ],
        [
            'title'       => 'EventZone Editor',
            'menu_title'  => 'EventZone Editor',
            'slug'        => 'eventzone_editor',
            'callback'    => 'render_event_zone_editor_page',
        ],
        [
            'title'       => 'Add Event Zone',
            'menu_title'  => 'Add Event Zone',
            'slug'        => 'add_event_zone',
            'callback'    => 'render_add_event_zone_page',
        ],
        [
            'title'       => 'Trade',
            'menu_title'  => 'Trade',
            'slug'        => 'trade',
            'callback'    => 'render_trade_page',
        ],
        [
            'title'       => 'Barter',
            'menu_title'  => 'Barter',
            'slug'        => 'barter',
            'callback'    => 'render_barter_page',
        ],
    ];

    // Register each submenu
    foreach ($submenus as $submenu) {
        add_submenu_page(
            'jotunheim_magic_plugin',   // Parent slug
            $submenu['title'],          // Page title
            $submenu['menu_title'],     // Menu title
            'manage_options',           // Capability required
            $submenu['slug'],           // Submenu slug
            $submenu['callback']        // Callback function
        );
    }

    // Remove the default submenu created by WordPress
    remove_submenu_page('jotunheim_magic_plugin', 'jotunheim_magic_plugin');
}

// Main dashboard page for Jotunheim Magic Plugin
function jotunheim_magic_dashboard() {
    echo '<h1>Welcome to Jotunheim Magic Plugin</h1>';
    echo '<p>Use the available tools to manage the plugin functionalities.</p>';
}

// Prefab Icon Image Import Page
function render_prefab_image_import_page() {
    echo '<h1>Prefab Image Import</h1>';
    echo '<p>Use this tool to import prefab images for the plugin.</p>';
    echo do_shortcode('[prefabdb_image_import]');
}

// ItemList Editor Page (Shortcode Render)
function render_item_list_editor_page() {
    echo '<h1>Item List Editor</h1>';
    echo do_shortcode('[itemlist_editor]');
}

// ItemList Editor Page (Shortcode Render)
function render_item_list_add_new_item_page() {
    echo '<h1>Item List Editor</h1>';
    echo do_shortcode('[jotunheim_add_new_item]');
}

// EventZone Editor Page (Shortcode Render)
function render_event_zone_editor_page() {
    echo '<h1>Event Zone Editor</h1>';
    echo do_shortcode('[eventzones_editor]');
}

// Add Event Zone Page (Shortcode Render)
function render_add_event_zone_page() {
    echo '<h1>Add Event Zone</h1>';
    echo do_shortcode('[jotunheim_add_new_zone]');
}

// Trade Page (Shortcode Render)
function render_trade_page() {
    echo '<h1>Trade</h1>';
    echo do_shortcode('[jotunheim_trade_page]');
}

// Barter Page (Shortcode Render)
function render_barter_page() {
    echo '<h1>Barter</h1>';
    echo do_shortcode('[jotunheim_barter_page]');
}

// Hook the menu function to WordPress admin menu
add_action('admin_menu', 'jotunheim_magic_plugin_menu');
?>
