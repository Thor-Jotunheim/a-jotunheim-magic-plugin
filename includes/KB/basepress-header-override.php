<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Force BasePress to use our custom full template and site editor header block
 */
class JotunheimBasePressFSETemplates {
    
    public function __construct() {
        // Register our custom template for BasePress
        add_filter('template_include', array($this, 'use_custom_template'), 999);
        
        // Add custom header and footer fallbacks
        add_filter('basepress_get_header', array($this, 'custom_header'));
        add_filter('basepress_get_footer', array($this, 'custom_footer'));
        
        // Add styling fixes
        add_action('wp_head', array($this, 'add_header_styles'));
        
        // Force site editor header to be used
        add_action('init', array($this, 'force_site_editor_header'));
    }
    
    /**
     * Use our full custom template for BasePress pages
     */
    public function use_custom_template($template) {
        // Only for BasePress pages
        if (!function_exists('is_basepress') || !is_basepress()) {
            return $template;
        }
        
        $custom_template = plugin_dir_path(dirname(dirname(__FILE__))) . 'templates/basepress-template.php';
        
        if (file_exists($custom_template)) {
            return $custom_template;
        }
        
        return $template;
    }
    
    /**
     * Custom header template path
     */
    public function custom_header() {
        // Use WordPress site editor header
        if (current_theme_supports('block-templates')) {
            // Just return a minimal template that will allow the block-based header to load
            return plugin_dir_path(dirname(dirname(__FILE__))) . 'templates/header-block-basepress.php';
        }
        
        // Fallback to our custom header
        return plugin_dir_path(dirname(dirname(__FILE__))) . 'templates/header-basepress.php';
    }
    
    /**
     * Custom footer template path
     */
    public function custom_footer() {
        return plugin_dir_path(dirname(dirname(__FILE__))) . 'templates/footer-basepress.php';
    }
    
    /**
     * Force the site editor header to be used
     */
    public function force_site_editor_header() {
        // Only for BasePress pages
        if (!function_exists('is_basepress')) {
            return;
        }
        
        // Remove any BasePress header actions
        remove_action('basepress_header', 'basepress_header', 10);
        
        // Add our custom action that will ensure the site editor header is displayed
        add_action('basepress_header', array($this, 'output_site_editor_header'), 10);
    }
    
    /**
     * Output the site editor header
     */
    public function output_site_editor_header() {
        // This is intentionally left empty as we want to use the site's block template header
        // The header will be added by WordPress core when using block templates
    }
    
    /**
     * Add CSS fixes for FSE themes in BasePress
     */
    public function add_header_styles() {
        if (!function_exists('is_basepress') || !is_basepress()) {
            return;
        }
        ?>
        <style>
            /* Force FSE theme headers to display */
            .wp-site-blocks header,
            header.wp-block-template-part {
                display: block !important;
                visibility: visible !important;
                position: relative !important;
            }
            
            /* Hide BasePress header */
            .bpress-header {
                display: none !important;
            }
            
            /* Ensure proper stacking */
            .wp-site-blocks {
                position: relative;
                z-index: 10;
            }
        </style>
        <?php
    }
}

// Initialize our custom template handler
new JotunheimBasePressFSETemplates();