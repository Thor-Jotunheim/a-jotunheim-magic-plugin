<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Force BasePress to use WordPress theme templates
 */
class JotunheimBasePressFSETemplates {
    
    public function __construct() {
        // Direct template override with highest priority
        add_filter('theme_compat_template', array($this, 'override_theme_compat_template'), 999999);
        add_filter('template_include', array($this, 'override_template_include'), 999999);
        
        // Force use of WordPress theme parts
        add_filter('basepress_get_header', '__return_false', 999999);
        add_filter('basepress_get_footer', '__return_false', 999999);
        
        // Replace BasePress template functions
        add_action('init', array($this, 'replace_template_functions'), 999999);
        
        // Add CSS to hide unwanted elements
        add_action('wp_head', array($this, 'add_header_css'), 999999);
    }
    
    /**
     * Replace BasePress template functions
     */
    public function replace_template_functions() {
        // Only if BasePress is active
        if (!function_exists('basepress_get_option')) {
            return;
        }
        
        // Remove all BasePress header/footer actions
        remove_all_actions('basepress_header');
        remove_all_actions('basepress_footer');
        
        // Add core WordPress header/footer actions
        add_action('basepress_header', 'get_header', 1);
        add_action('basepress_footer', 'get_footer', 1);
    }
    
    /**
     * Override BasePress theme_compat_template
     */
    public function override_theme_compat_template($template) {
        // Only for BasePress pages
        if (!function_exists('is_basepress') || !is_basepress()) {
            return $template;
        }
        
        // Force normal theme template
        $template = get_template_directory() . '/index.php';
        
        return $template;
    }
    
    /**
     * Override template_include in BasePress
     */
    public function override_template_include($template) {
        // Only for BasePress pages
        if (!function_exists('is_basepress') || !is_basepress()) {
            return $template;
        }
        
        // Create a global to flag that we are using core theme
        global $jotunheim_using_core_theme;
        $jotunheim_using_core_theme = true;
        
        // Return the theme's singular template or default to index
        $singular_template = get_template_directory() . '/singular.php';
        if (file_exists($singular_template)) {
            return $singular_template;
        }

        return get_template_directory() . '/index.php';
    }
    
    /**
     * Add CSS to forcefully hide BasePress header
     */
    public function add_header_css() {
        // Only for BasePress pages
        if (!function_exists('is_basepress') || !is_basepress()) {
            return;
        }
        ?>
        <style>
            /* Force hide BasePress header */
            .bpress-header, 
            div.bpress-header, 
            header.bpress-header,
            .bpress-page-header {
                display: none !important;
            }
            
            /* Fix BasePress content container */
            .bpress-content-wrap {
                width: 100%;
                max-width: 100%;
                margin-top: 1rem;
            }
        </style>
        <?php
    }
}

// Initialize BasePress template override
new JotunheimBasePressFSETemplates();