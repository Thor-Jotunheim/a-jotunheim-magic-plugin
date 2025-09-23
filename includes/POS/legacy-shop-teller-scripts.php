<?php
/**
 * Legacy Shop Teller Scripts Registration
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

function legacy_shop_teller_scripts() {
    // Check if we're on a page that contains the shortcode
    global $post;
    if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'legacy_shop_teller')) {
        
        // Enqueue CSS
        wp_enqueue_style(
            'legacy-shop-teller-css',
            plugin_dir_url(__FILE__) . '../../assets/css/legacy-shop-teller.css',
            [],
            '1.0.0'
        );
        
        // Enqueue JavaScript
        wp_enqueue_script(
            'legacy-shop-teller-js',
            plugin_dir_url(__FILE__) . '../../assets/js/legacy-shop-teller.js',
            ['jquery', 'jotun-comprehensive-api'],
            '1.0.0',
            true
        );
        
        // Localize script with data
        wp_localize_script('legacy-shop-teller-js', 'legacyShopTellerData', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('legacy_shop_teller_nonce'),
            'restUrl' => rest_url('jotunheim-magic/v1/'),
            'currentUser' => wp_get_current_user()->display_name
        ]);
    }
}

add_action('wp_enqueue_scripts', 'legacy_shop_teller_scripts');