<?php
// File: universal-ui-scripts.php

// Shared Shortcode Logic for Add and Editor Interfaces
function jotunheim_register_shortcodes() {
    // Universal Add UI Shortcode
    add_shortcode('universal_add_ui', 'jotunheim_magic_universal_add_item_interface');

    // Universal Editor UI Shortcode
    add_shortcode('universal_editor_ui', 'jotunheim_magic_universal_editor_interface');
}
add_action('init', 'jotunheim_register_shortcodes');

// Enqueue Shared Scripts
function jotunheim_enqueue_scripts() {
    wp_enqueue_script(
        'jotunheim-universal-ui',
        plugin_dir_url(__FILE__) . 'js/universal-ui.js', // Adjust to point to your shared JS file
        ['jquery'],
        '1.0',
        true
    );

    // Localize script for REST API endpoints
    wp_localize_script('jotunheim-universal-ui', 'JotunheimAPI', [
        'root' => esc_url_raw(rest_url('jotunheim-magic/v1/')),
        'nonce' => wp_create_nonce('wp_rest')
    ]);
}
add_action('wp_enqueue_scripts', 'jotunheim_enqueue_scripts');

// Shared Functions for AJAX Requests
function jotunheim_universal_get_tables() {
    global $wpdb;
    $tables = $wpdb->get_col("SHOW TABLES LIKE 'jotun_%'");
    wp_send_json_success(['tables' => $tables]);
}
add_action('wp_ajax_jotunheim_get_tables', 'jotunheim_universal_get_tables');

function jotunheim_enqueue_universal_ui_scripts() {
    global $wpdb;

    // Fetch API endpoints dynamically from the table
    $api_endpoints = $wpdb->get_results(
        "SELECT name, CONCAT(base_url, endpoint) AS full_url FROM jotun_api_endpoints WHERE enabled = 1", 
        OBJECT_K
    );

    // Ensure API key is securely loaded
    $apiKey = defined('JOTUN_API_KEY') ? JOTUN_API_KEY : '';

    // Enqueue the JavaScript file
    wp_enqueue_script(
        'universal-ui-js',
        plugin_dir_url(__FILE__) . '../js/universal-ui.js',
        ['jquery'],
        '1.0',
        true
    );

    // Pass API key and endpoints dynamically to the script
    wp_localize_script('universal-ui-js', 'JotunheimEditor', [
        'apiKey' => $apiKey,
        'apiEndpoints' => $api_endpoints
    ]);
}
add_action('wp_enqueue_scripts', 'jotunheim_enqueue_universal_ui_scripts');