<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Shop Manager Scripts and Shortcodes
 */

// Register the shortcode handler
function shop_manager_scripts_shortcode($atts) {
    // Enqueue scripts and styles only when shortcode is used
    wp_enqueue_script(
        'jotun-comprehensive-api',
        plugin_dir_url(__FILE__) . '../../assets/js/jotun-comprehensive-api.js',
        ['jquery'],
        '1.0.0',
        true
    );

    // Localize the comprehensive API script with necessary data
    wp_localize_script('jotun-comprehensive-api', 'jotun_api_vars', [
        'nonce' => wp_create_nonce('wp_rest'),
        'rest_url' => rest_url('jotun-api/v1/')
    ]);

    wp_enqueue_script(
        'shop-manager-js',
        plugin_dir_url(__FILE__) . '../../assets/js/shop-manager.js',
        ['jquery', 'jotun-comprehensive-api'],
        '1.0.0',
        true
    );

    // Localize script with necessary data
    wp_localize_script('shop-manager-js', 'shopManagerAjax', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('shop_manager_nonce'),
        'rest_url' => rest_url('jotun-api/v1/'),
        'rest_nonce' => wp_create_nonce('wp_rest')
    ]);

    // Return the interface
    return shop_manager_interface();
}

// Register the shortcode
add_shortcode('shop_manager', 'shop_manager_scripts_shortcode');

/**
 * Conditional script loading based on page content
 */
function maybe_enqueue_shop_manager_scripts() {
    global $post;
    
    if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'shop_manager')) {
        wp_enqueue_script(
            'jotun-comprehensive-api',
            plugin_dir_url(__FILE__) . '../../assets/js/jotun-comprehensive-api.js',
            ['jquery'],
            '1.0.0',
            true
        );

        wp_enqueue_script(
            'shop-manager-js',
            plugin_dir_url(__FILE__) . '../../assets/js/shop-manager.js',
            ['jquery', 'jotun-comprehensive-api'],
            '1.0.0',
            true
        );

        // Localize script with necessary data
        wp_localize_script('shop-manager-js', 'shopManagerAjax', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('shop_manager_nonce'),
            'rest_url' => rest_url('jotun-api/v1/'),
            'rest_nonce' => wp_create_nonce('wp_rest')
        ]);
    }
}

add_action('wp_enqueue_scripts', 'maybe_enqueue_shop_manager_scripts');
?>