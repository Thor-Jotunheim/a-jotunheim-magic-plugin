<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Unified Teller Scripts and Shortcodes
 */

// Register the shortcode handler
function unified_teller_scripts_shortcode($atts) {
    // Enqueue styles for unified teller - Spark Design System
    wp_enqueue_style(
        'unified-teller-css',
        plugin_dir_url(__FILE__) . '../../assets/css/unified-teller-spark.css',
        [],
        '2.2.1'
    );

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
        'unified-teller-js',
        plugin_dir_url(__FILE__) . '../../assets/js/unified-teller.js',
        ['jquery', 'jotun-comprehensive-api'],
        '1.9.5',
        true
    );

    // Localize script with necessary data
    wp_localize_script('unified-teller-js', 'tellerAjax', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('teller_nonce'),
        'rest_url' => rest_url('jotun-api/v1/'),
        'rest_nonce' => wp_create_nonce('wp_rest'),
        'pos_rest_url' => rest_url('pos/v1/'),
        'pos_rest_nonce' => wp_create_nonce('wp_rest')
    ]);

    // Return the interface
    return unified_teller_interface();
}

// Register the shortcode
add_shortcode('unified_teller', 'unified_teller_scripts_shortcode');

/**
 * Conditional script loading based on page content
 */
function maybe_enqueue_teller_scripts() {
    global $post;
    
    if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'unified_teller')) {
        // Enqueue styles for unified teller
        wp_enqueue_style(
            'unified-teller-css-fallback',
            plugin_dir_url(__FILE__) . '../../assets/css/unified-teller.css',
            [],
            '2.1.1'
        );

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
            'unified-teller-js',
            plugin_dir_url(__FILE__) . '../../assets/js/unified-teller.js',
            ['jquery', 'jotun-comprehensive-api'],
            '1.9.5',
            true
        );

        // Localize script with necessary data
        wp_localize_script('unified-teller-js', 'tellerAjax', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('teller_nonce'),
            'rest_url' => rest_url('jotun-api/v1/'),
            'rest_nonce' => wp_create_nonce('wp_rest'),
            'pos_rest_url' => rest_url('pos/v1/'),
            'pos_rest_nonce' => wp_create_nonce('wp_rest')
        ]);
    }
}

add_action('wp_enqueue_scripts', 'maybe_enqueue_teller_scripts');
?>