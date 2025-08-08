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