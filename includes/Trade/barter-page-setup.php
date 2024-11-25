<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

// Shortcode function to output Barter Page HTML
function jotunheim_barter_page_shortcode() {
    // Start output buffering
    ob_start();
    include plugin_dir_path(__FILE__) . 'barter-page.html';
    return ob_get_clean();
}

// Shortcode function to output Barter Page HTML
function jotunheim_barter_page_half_screenshortcode() {
    // Start output buffering
    ob_start();
    include plugin_dir_path(__FILE__) . 'barter-page-half-screen.html';
    return ob_get_clean();
}

// Register Barter Page shortcode
add_shortcode('jotunheim_barter_page', 'jotunheim_barter_page_shortcode');
add_shortcode('jotunheim_barter_page_half_screen', 'jotunheim_barter_page_half_screenshortcode');

// Conditionally enqueue the JavaScript file for the Barter Page
function jotunheim_enqueue_barter_scripts() {
    global $post;

    // Check if the Barter Page shortcode is used in the content
    if (isset($post->post_content) && has_shortcode($post->post_content, 'jotunheim_barter_page')) {
        wp_enqueue_script(
            'jotunheim-barter-script',
            plugin_dir_url(__FILE__) . 'barter-interface.js',
            array(),
            null,
            true
        );

        // Localize script to pass the API URL to the JavaScript file
        wp_localize_script('jotunheim-barter-script', 'jotunheimApi', array(
            'apiUrl' => rest_url('jotunheim-magic/v1/items'),
        ));
    }
}
add_action('wp_enqueue_scripts', 'jotunheim_enqueue_barter_scripts');