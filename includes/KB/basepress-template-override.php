<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Complete override for BasePress templates to force theme templates
 */
class JotunheimBasePress_Template_Override {
    
    /**
     * Constructor
     */
    public function __construct() {
        // Early hook to catch BasePress before it loads templates
        add_action('plugins_loaded', array($this, 'init'), 5);
    }
    
    /**
     * Initialize hooks
     */
    public function init() {
        // Only if BasePress exists
        if (!class_exists('BasePress') && !function_exists('is_basepress')) {
            return;
        }
        
        // Hook very early to reroute template loading
        add_filter('template_redirect', array($this, 'override_basepress_template'), 1);
        
        // Also hook into template_include to be safe
        add_filter('template_include', array($this, 'force_theme_template'), 999999);
        
        // Add inline style to hide BasePress headers
        add_action('wp_head', array($this, 'add_inline_styles'), 999);
    }
    
    /**
     * Override BasePress template loading
     */
    public function override_basepress_template() {
        // Only on BasePress pages
        if (!function_exists('is_basepress') || !is_basepress()) {
            return;
        }
        
        // Remove all template related hooks that BasePress might add
        global $wp_filter;
        if (isset($wp_filter['template_include'])) {
            foreach ($wp_filter['template_include']->callbacks as $priority => $callbacks) {
                foreach ($callbacks as $key => $callback) {
                    // Check if this callback belongs to BasePress
                    if (is_array($callback['function']) && is_object($callback['function'][0])) {
                        $obj = $callback['function'][0];
                        $class = get_class($obj);
                        if (strpos($class, 'BasePress') !== false) {
                            remove_filter('template_include', $callback['function'], $priority);
                        }
                    }
                }
            }
        }
        
        // Remove all header/footer action hooks
        remove_all_actions('basepress_header');
        remove_all_actions('basepress_footer');
        
        // Add WordPress core header/footer
        add_action('basepress_header', 'get_header', 1);
        add_action('basepress_footer', 'get_footer', 1);
    }
    
    /**
     * Force theme template by returning main index/singular template
     */
    public function force_theme_template($template) {
        // Only on BasePress pages
        if (!function_exists('is_basepress') || !is_basepress()) {
            return $template;
        }
        
        // Use singular.php or index.php from current theme
        $singular = get_template_directory() . '/singular.php';
        if (file_exists($singular)) {
            return $singular;
        }
        
        $index = get_template_directory() . '/index.php';
        if (file_exists($index)) {
            return $index;
        }
        
        return $template;
    }
    
    /**
     * Add inline styles to hide BasePress headers
     */
    public function add_inline_styles() {
        // Only on BasePress pages
        if (!function_exists('is_basepress') || !is_basepress()) {
            return;
        }
        ?>
        <style type="text/css">
            /* Hide BasePress header elements */
            .bpress-header, .bpress-page-header {
                display: none !important;
                height: 0 !important;
                overflow: hidden !important;
                visibility: hidden !important;
            }
            
            /* Ensure theme header is visible */
            body .site-header, 
            body header.wp-block-template-part,
            body .wp-site-blocks header {
                display: block !important; 
                visibility: visible !important;
            }
        </style>
        <?php
    }
}

// Initialize the class
new JotunheimBasePress_Template_Override();