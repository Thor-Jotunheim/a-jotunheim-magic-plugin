<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue scripts and styles for POS interface
 */
function pos_enqueue_scripts() {
    // Only enqueue on admin pages with POS interface
    $screen = get_current_screen();
    if ($screen && strpos($screen->id, 'pos_interface') !== false) {
        // Enqueue jQuery (WordPress core)
        wp_enqueue_script('jquery');
        
        // Enqueue WordPress REST API utilities
        wp_enqueue_script('wp-api');
        
        // Localize script with REST API settings
        wp_localize_script('wp-api', 'wpApiSettings', array(
            'root' => esc_url_raw(rest_url()),
            'nonce' => wp_create_nonce('wp_rest')
        ));
    }
}
add_action('admin_enqueue_scripts', 'pos_enqueue_scripts');

/**
 * Enqueue scripts for frontend POS interface (when used via shortcode)
 */
function pos_enqueue_frontend_scripts() {
    // Only enqueue when POS shortcode is present
    global $post;
    if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'pos_interface')) {
        // Enqueue jQuery (WordPress core)
        wp_enqueue_script('jquery');
        
        // Localize script with REST API settings
        wp_localize_script('jquery', 'wpApiSettings', array(
            'root' => esc_url_raw(rest_url()),
            'nonce' => wp_create_nonce('wp_rest')
        ));
    }
}
add_action('wp_enqueue_scripts', 'pos_enqueue_frontend_scripts');