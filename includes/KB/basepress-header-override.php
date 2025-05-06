<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Force BasePress to use WordPress headers and footers
 */
function jotunheim_basepress_use_wp_theme_parts() {
    // Only apply on BasePress pages
    if (!function_exists('is_basepress') || !is_basepress()) {
        return;
    }
    
    // Remove BasePress header/footer actions
    remove_all_actions('basepress_header');
    remove_all_actions('basepress_footer');
    
    // Use WordPress core header/footer instead
    add_action('basepress_header', 'get_header', 1);
    add_action('basepress_footer', 'get_footer', 1);
    
    // Add CSS to hide any BasePress headers that might still appear
    add_action('wp_head', 'jotunheim_basepress_header_css');
}

/**
 * Add CSS to hide BasePress headers and fix layout
 */
function jotunheim_basepress_header_css() {
    if (!function_exists('is_basepress') || !is_basepress()) {
        return;
    }
    ?>
    <style>
        /* Hide any BasePress headers */
        .bpress-header {
            display: none !important;
        }
    </style>
    <?php
}

// Hook early to override BasePress template parts
add_action('template_redirect', 'jotunheim_basepress_use_wp_theme_parts', 1);