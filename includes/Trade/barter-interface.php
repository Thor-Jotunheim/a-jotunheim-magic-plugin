<?php
if (!defined('ABSPATH')) exit;

// Shortcode function to output Barter Page HTML
function jotunheim_barter_page_shortcode() {
    // Check permissions using Discord system
    $permission_check = jotunheim_check_shortcode_permission('jotunheim_barter_page');
    if ($permission_check !== null) {
        return $permission_check;
    }
    
    ob_start();
    include plugin_dir_path(__FILE__) . 'barter-page.html';
    return ob_get_clean();
}
add_shortcode('jotunheim_barter_page', 'jotunheim_barter_page_shortcode');

// Add alternative shortcode name for dashboard menu compatibility
function jotunheim_barter_shortcode() {
    return jotunheim_barter_page_shortcode();
}
add_shortcode('barter', 'jotunheim_barter_shortcode');

// Conditionally enqueue the Barter Page scripts
function jotunheim_enqueue_barter_scripts() {
    global $post;

    // Check if the Barter Page shortcode is used in the content
    if (isset($post->post_content) && has_shortcode($post->post_content, 'jotunheim_barter_page')) {
        wp_enqueue_script(
            'jotunheim-barter-script',
            plugin_dir_url(__FILE__) . 'trade-barter-utils.js',
            array('trade-barter-utils'), // Dependency on shared utility
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