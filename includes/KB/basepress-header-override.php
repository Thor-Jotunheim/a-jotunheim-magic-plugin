<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Force BasePress to use our custom full template
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
        return plugin_dir_path(dirname(dirname(__FILE__))) . 'templates/header-basepress.php';
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
            }
            
            /* Hide BasePress header */
            .bpress-header {
                display: none !important;
            }
        </style>
        <?php
    }
}

// Initialize our custom template handler
new JotunheimBasePressFSETemplates();