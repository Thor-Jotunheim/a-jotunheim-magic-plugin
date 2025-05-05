<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Override BasePress KB templates to use the site's main header
 */
class JotunheimKBTemplateOverride {
    
    public function __construct() {
        // Hook into template include to modify which template is used
        add_filter('template_include', array($this, 'override_kb_templates'), 99);
        
        // Filter the BasePress template parts
        add_filter('basepress_template_path', array($this, 'modify_template_parts'), 99);
        
        // Add custom body class to knowledge base pages
        add_filter('body_class', array($this, 'add_kb_body_class'));
    }
    
    /**
     * Override KB templates to use main theme header/footer
     */
    public function override_kb_templates($template) {
        // Only apply to knowledge base templates
        if (!$this->is_kb_page()) {
            return $template;
        }
        
        // Force use of theme's header and footer
        add_action('basepress_before_main_content', array($this, 'open_theme_wrapper'), 0);
        add_action('basepress_after_main_content', array($this, 'close_theme_wrapper'), 999);
        
        return $template;
    }
    
    /**
     * Open theme wrapper - include theme header
     */
    public function open_theme_wrapper() {
        // Remove the default KB header
        remove_action('basepress_header', 'basepress_header_content');
        
        // Output theme header
        get_header();
        
        // Add any additional wrapper HTML needed
        echo '<div class="jotunheim-kb-content-wrapper">';
    }
    
    /**
     * Close theme wrapper - include theme footer
     */
    public function close_theme_wrapper() {
        // Close any wrapper divs
        echo '</div><!-- .jotunheim-kb-content-wrapper -->';
        
        // Output theme footer
        get_footer();
    }
    
    /**
     * Add custom body class to KB pages
     */
    public function add_kb_body_class($classes) {
        if ($this->is_kb_page()) {
            $classes[] = 'jotunheim-kb-page';
        }
        return $classes;
    }
    
    /**
     * Check if current page is a KB page
     */
    private function is_kb_page() {
        return (
            is_singular('knowledgebase') || 
            is_post_type_archive('knowledgebase') || 
            is_tax('kb_category') ||
            (function_exists('is_basepress') && is_basepress())
        );
    }
    
    /**
     * Modify BasePress template paths if needed
     */
    public function modify_template_parts($template_path) {
        // If you want to use custom template parts, modify the path here
        return $template_path;
    }
}

// Initialize the class
new JotunheimKBTemplateOverride();