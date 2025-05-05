<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Simple function to use our custom BasePress header and footer templates
 * Based on official BasePress documentation
 */
function jotunheim_basepress_custom_template() {
    // Only add on frontend
    if (!is_admin()) {
        // Tell BasePress to use our custom header and footer files
        add_filter('basepress_get_header', 'jotunheim_basepress_custom_header');
        add_filter('basepress_get_footer', 'jotunheim_basepress_custom_footer');
    }
}
add_action('init', 'jotunheim_basepress_custom_template');

/**
 * Return the path to our custom header template
 */
function jotunheim_basepress_custom_header() {
    return plugin_dir_path(dirname(dirname(__FILE__))) . 'templates/header-basepress.php';
}

/**
 * Return the path to our custom footer template
 */
function jotunheim_basepress_custom_footer() {
    return plugin_dir_path(dirname(dirname(__FILE__))) . 'templates/footer-basepress.php';
}

/**
 * Add some minimal CSS fixes for any styling issues
 */
function jotunheim_add_basepress_header_styles() {
    if (function_exists('is_basepress') && is_basepress()) {
        ?>
        <style>
            /* Hide any built-in BasePress headers */
            .bpress-header {
                display: none !important;
            }
        </style>
        <?php
    }
}
add_action('wp_head', 'jotunheim_add_basepress_header_styles');