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

    // Submenu for Prefab Image Import
    add_submenu_page(
        'jotunheim_magic_plugin',       // Parent slug
        'Prefab Image Import',          // Page title
        'Prefab Image Import',          // Menu title
        'manage_options',               // Capability required
        'prefab_image_import',          // Submenu slug
        'render_prefab_image_import_page' // Callback function for the page
    );

    // Submenu for ItemList Editor
    add_submenu_page(
        'jotunheim_magic_plugin',       // Parent slug
        'ItemList Editor',              // Page title
        'ItemList Editor',              // Menu title
        'manage_options',               // Capability required
        'itemlist_editor',              // Submenu slug
        'render_itemlist_editor_page'   // Callback function for the page
    );

    // Submenu for EventZone Editor
    add_submenu_page(
        'jotunheim_magic_plugin',       // Parent slug
        'EventZone Editor',             // Page title
        'EventZone Editor',             // Menu title
        'manage_options',               // Capability required
        'eventzones_editor',             // Submenu slug
        'render_eventzone_editor_page'  // Callback function for the page
    );

    // Submenu for Add Event Zone
    add_submenu_page(
        'jotunheim_magic_plugin',       // Parent slug
        'Add Event Zone',               // Page title
        'Add Event Zone',               // Menu title
        'manage_options',               // Capability required
        'add_event_zone',               // Submenu slug
        'render_add_event_zone_page'    // Callback function for the page
    );

    // Submenu for Trade
    add_submenu_page(
        'jotunheim_magic_plugin',       // Parent slug
        'Trade',                       // Page title
        'Trade',                       // Menu title
        'manage_options',               // Capability required
        'Trade',                       // Submenu slug
        'render_trade_page'            // Callback function for the page
    );

    // Submenu for Barter
    add_submenu_page(
        'jotunheim_magic_plugin',       // Parent slug
        'Barter',                       // Page title
        'Barter',                       // Menu title
        'manage_options',               // Capability required
        'barter',                       // Submenu slug
        'render_barter_page'            // Callback function for the page
    );

    // Remove the default submenu created by WordPress
    remove_submenu_page('jotunheim_magic_plugin', 'jotunheim_magic_plugin');
}

// Main dashboard page for Jotunheim Magic Plugin
function jotunheim_magic_dashboard() {
    echo '<h1>Welcome to Jotunheim Magic Plugin</h1>';
    echo '<p>Use the available tools to manage the plugin functionalities.</p>';
}

// Prefab Image Import Page
function render_prefab_image_import_page() {
    echo '<h1>Prefab Image Import</h1>';
    echo '<p>Use this tool to import prefab images for the plugin.</p>';
}

// ItemList Editor Page (Shortcode Render)
function render_itemlist_editor_page() {
    echo '<h1>ItemList Editor</h1>';
    echo do_shortcode('[itemlist_editor]'); // Replace with your actual shortcode
}

// EventZone Editor Page (Shortcode Render)
function render_eventzone_editor_page() {
    echo '<h1>EventZone Editor</h1>';
    echo do_shortcode('[eventzones_editor]'); // Replace with your actual shortcode
}

// Add Event Zone Page (Shortcode Render)
function render_add_event_zone_page() {
    echo '<h1>Add Event Zone</h1>';
    echo do_shortcode('[eventzones_add_new_zone]'); // Replace with your actual shortcode
}

// Trade Page (Shortcode Render)
function render_trade_page() {
    echo '<h1>Trade</h1>';
    echo do_shortcode('[jotunheim_trade_page]'); // Replace with your actual shortcode
}

// Barter Page (Shortcode Render)
function render_barter_page() {
    echo '<h1>Barter</h1>';
    echo do_shortcode('[jotunheim_barter_page]'); // Replace with your actual shortcode
}

// Hook the menu function to WordPress admin menu
add_action('admin_menu', 'jotunheim_magic_plugin_menu');
?>
