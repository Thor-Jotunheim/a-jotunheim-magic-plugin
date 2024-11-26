<?php
if (!defined('ABSPATH')) exit;

// Shortcode function to output Trade Page HTML
function jotunheim_trade_page_shortcode() {
    ob_start();
    include plugin_dir_path(__FILE__) . 'trade-page.html';
    return ob_get_clean();
}
add_shortcode('jotunheim_trade_page', 'jotunheim_trade_page_shortcode');

// Conditionally enqueue the Trade Page scripts
function jotunheim_enqueue_trade_scripts() {
    global $post;

    // Check if the Trade Page shortcode is used in the content
    if (isset($post->post_content) && has_shortcode($post->post_content, 'jotunheim_trade_page')) {
        wp_enqueue_script(
            'jotunheim-trade-script',
            plugin_dir_url(__FILE__) . 'trade-barter-utils.js',
            array('trade-barter-utils'), // Dependency on shared utility
            null,
            true
        );

        // Localize script to pass the API URL to the JavaScript file
        wp_localize_script('jotunheim-trade-script', 'jotunheimApi', array(
            'apiUrl' => rest_url('jotunheim-magic/v1/items'),
        ));
    }
}
add_action('wp_enqueue_scripts', 'jotunheim_enqueue_trade_scripts');