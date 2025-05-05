<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Force BasePress to use our custom full template and site editor header block
 */
class JotunheimBasePressFSETemplates {
    
    public function __construct() {
        // Higher priority to override BasePress templates
        add_filter('template_include', array($this, 'use_custom_template'), 99999);
        
        // Remove BasePress's default header and footer actions
        add_action('init', array($this, 'remove_basepress_template_parts'), 20);
        
        // Override the BasePress header and footer filters
        add_filter('basepress_get_header', array($this, 'custom_header'), 99999);
        add_filter('basepress_get_footer', array($this, 'custom_footer'), 99999);
        
        // Add styling fixes
        add_action('wp_head', array($this, 'add_header_styles'));
        
        // Prevent BasePress from using its own templates
        add_filter('basepress_override_templates', '__return_true', 99999);
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
            // Force-disable BasePress's own template handling
            remove_all_filters('template_include', 20);
            return $custom_template;
        }
        
        return $template;
    }
    
    /**
     * Remove BasePress template parts
     */
    public function remove_basepress_template_parts() {
        // Only run if BasePress is active
        if (!function_exists('is_basepress')) {
            return;
        }
        
        // Remove BasePress header and footer actions
        remove_all_actions('basepress_header');
        remove_all_actions('basepress_footer');
        
        // Add our own empty actions that will defer to WordPress core
        add_action('basepress_header', array($this, 'output_nothing'), 1);
        add_action('basepress_footer', array($this, 'output_nothing'), 1);
    }
    
    /**
     * Empty output function
     */
    public function output_nothing() {
        // Intentionally empty
    }
    
    /**
     * Custom header template path
     */
    public function custom_header() {
        // Always use our custom header that forces WordPress headers
        return plugin_dir_path(dirname(dirname(__FILE__))) . 'templates/header-block-basepress.php';
    }
    
    /**
     * Custom footer template path
     */
    public function custom_footer() {
        return plugin_dir_path(dirname(dirname(__FILE__))) . 'templates/footer-basepress.php';
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
            
            /* Hide any BasePress headers that might still appear */
            .bpress-header,
            div[class*="bpress"] > header:not(.wp-block-template-part) {
                display: none !important;
                height: 0 !important;
                visibility: hidden !important;
                overflow: hidden !important;
            }
            
            /* Fix content spacing */
            .basepress-main {
                margin-top: 20px;
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