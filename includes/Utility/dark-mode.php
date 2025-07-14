<?php
// File: includes/Utilities/dark-mode.php

// Prevent direct access
if (!defined('ABSPATH')) exit;

// Include the exclusions configuration
require_once plugin_dir_path(__FILE__) . '../Config/dark-mode-exclusions.php';

// Enqueue dark mode toggle JavaScript and CSS
function jotunheim_magic_dark_mode_assets() {
    // Adjust the paths to the JavaScript and CSS files
    wp_enqueue_script('jotunheim-dark-mode-js', plugin_dir_url(__FILE__) . '../../assets/js/dark-mode-toggle.js', array(), '1.0', true);
    wp_enqueue_style('jotunheim-dark-mode-css', plugin_dir_url(__FILE__) . '../../assets/css/dark-mode.css');
}
add_action('wp_enqueue_scripts', 'jotunheim_magic_dark_mode_assets');

// Add dark mode toggle button in the footer (with exclusions check)
function jotunheim_magic_dark_mode_button() {
    // Check if current page should exclude the dark mode button
    if (jotunheim_should_exclude_dark_mode_button()) {
        return; // Don't show button on excluded pages
    }
    
    echo '<button id="dark-mode-toggle" style="position: fixed; bottom: 20px; right: 20px; padding: 10px 20px; cursor: pointer;">Toggle Dark Mode</button>';
}
add_action('wp_footer', 'jotunheim_magic_dark_mode_button');