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
    
    // Add CSS and JS fixes
    add_action('wp_head', 'jotunheim_basepress_header_css');
    add_action('wp_footer', 'jotunheim_basepress_js_fixes', 99);
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
        
        /* Ensure theme header is visible */
        .site-header, 
        header.wp-block-template-part {
            display: block !important;
            visibility: visible !important;
        }
        
        /* Fix main content area spacing */
        .bpress-wrap {
            margin-top: 20px;
        }
        
        /* Make sure sidebar doesn't conflict with theme elements */
        .bpress-sidebar.fixedsticky-on {
            z-index: 50;
        }
    </style>
    <?php
}

/**
 * Add JavaScript fixes to counter BasePress JS that might interfere with theme header
 */
function jotunheim_basepress_js_fixes() {
    if (!function_exists('is_basepress') || !is_basepress()) {
        return;
    }
    ?>
    <script>
    jQuery(document).ready(function($) {
        // Ensure FixedSticky doesn't apply to the header
        if (typeof FixedSticky !== 'undefined') {
            // Override the fixedsticky initialization for non-sidebar elements
            var originalFixedSticky = $.fn.fixedsticky;
            $.fn.fixedsticky = function() {
                if ($(this).hasClass('bpress-sidebar')) {
                    return originalFixedSticky.apply(this, arguments);
                }
                return this;
            };
        }
        
        // Make sure the theme header remains visible
        $('.site-header, header.wp-block-template-part').css({
            'display': 'block',
            'visibility': 'visible'
        });
        
        // Hide BasePress header if it still exists
        $('.bpress-header').hide();
    });
    </script>
    <?php
}

// Hook early to override BasePress template parts
add_action('template_redirect', 'jotunheim_basepress_use_wp_theme_parts', 1);