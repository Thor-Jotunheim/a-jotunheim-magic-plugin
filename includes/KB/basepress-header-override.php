<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * BasePress Header Override - Force site editor header
 */
class JotunheimBasePressFSETemplates {
    
    public function __construct() {
        // Use priority 20 to ensure this runs after BasePress loads
        add_action('after_setup_theme', array($this, 'setup_overrides'), 20);
    }
    
    /**
     * Setup all the template overrides
     */
    public function setup_overrides() {
        // Only proceed if BasePress is active
        if (!function_exists('basepress_get_option')) {
            return;
        }
        
        // Replace the header/footer with WordPress core ones
        add_filter('basepress_get_header', array($this, 'use_wp_header'));
        add_filter('basepress_get_footer', array($this, 'use_wp_footer'));
        
        // Add CSS fixes to ensure proper display
        add_action('wp_head', array($this, 'add_header_css'), 999);
        
        // Add JavaScript to ensure the theme header is used
        add_action('wp_footer', array($this, 'add_header_js'), 999);
        
        // Remove any actions that might hide the header
        add_action('wp', array($this, 'remove_header_hiding_actions'));
    }
    
    /**
     * Use WordPress header instead of BasePress header
     */
    public function use_wp_header() {
        // This will cause get_header() to be called instead of including the BasePress header
        return false;
    }
    
    /**
     * Use WordPress footer instead of BasePress footer
     */
    public function use_wp_footer() {
        // This will cause get_footer() to be called instead of including the BasePress footer
        return false;
    }
    
    /**
     * Remove any actions that might hide the theme header
     */
    public function remove_header_hiding_actions() {
        // Remove BasePress header actions
        remove_all_actions('basepress_header');
        
        // Add WordPress core header function
        add_action('basepress_header', 'get_header', 1);
        add_action('basepress_footer', 'get_footer', 1);
    }
    
    /**
     * Add CSS to force theme header to display and hide BasePress header
     */
    public function add_header_css() {
        if (!function_exists('is_basepress') || !is_basepress()) {
            return;
        }
        ?>
        <style>
            /* Force hide BasePress header */
            .bpress-header, 
            div.bpress-header, 
            header.bpress-header {
                display: none !important;
                height: 0 !important;
                visibility: hidden !important;
                opacity: 0 !important;
                padding: 0 !important;
                margin: 0 !important;
                overflow: hidden !important;
                position: absolute !important;
                top: -9999px !important;
                left: -9999px !important;
            }
            
            /* Force theme header to display */
            body:not(.wp-admin) header:not(.bpress-header),
            body:not(.wp-admin) .wp-site-blocks header,
            body:not(.wp-admin) .site-header,
            body:not(.wp-admin) header.wp-block-template-part {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                height: auto !important;
                position: relative !important;
                z-index: 100 !important;
            }
            
            /* Fix spacing between header and content */
            .bpress-content-wrap {
                margin-top: 20px;
            }
        </style>
        <?php
    }
    
    /**
     * Add JavaScript to ensure theme header is used
     */
    public function add_header_js() {
        if (!function_exists('is_basepress') || !is_basepress()) {
            return;
        }
        ?>
        <script>
        jQuery(document).ready(function($) {
            // Override any BasePress header script functions
            if (typeof FixedSticky !== 'undefined') {
                FixedSticky.tests.sticky = false;
            }
            
            // Hide BasePress header
            $('.bpress-header').hide();
            
            // Make sure theme header is visible
            $('body:not(.wp-admin) header:not(.bpress-header), .wp-site-blocks header, .site-header, header.wp-block-template-part').show();
        });
        </script>
        <?php
    }
}

// Initialize our template handler
new JotunheimBasePressFSETemplates();