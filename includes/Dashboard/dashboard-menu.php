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

    // Submenu for Image Import
    add_submenu_page(
        'jotunheim_magic_plugin',       // Parent slug
        'Prefab Image Import',          // Page title
        'Prefab Image Import',          // Menu title
        'manage_options',               // Capability required
        'prefab_image_import',          // Submenu slug
        'render_prefab_image_import_page' // Callback function for the page
    );

    // Add more submenu pages as needed
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

// Hook the menu function to WordPress admin menu
add_action('admin_menu', 'jotunheim_magic_plugin_menu');
?>
