<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Override BasePress KB templates to use the site's main header
 */
class JotunheimKBTemplateOverride {
    
    public function __construct() {
        // Force template override at plugin init
        add_action('plugins_loaded', array($this, 'init_template_overrides'));
    }

    /**
     * Initialize all template overrides
     */
    public function init_template_overrides() {
        // Direct template override with high priority
        add_filter('template_include', array($this, 'override_kb_templates'), 999);
        
        // Remove BasePress headers and footers completely
        add_action('wp_head', array($this, 'remove_basepress_template_parts'), 1);
        
        // Disable BasePress template wrapper
        $this->disable_basepress_template_wrapper();
        
        // Add body classes to KB pages
        add_filter('body_class', array($this, 'add_kb_body_classes'));
    }
    
    /**
     * Remove BasePress template parts and hooks
     */
    public function remove_basepress_template_parts() {
        if ($this->is_kb_page()) {
            // Remove BasePress header actions
            remove_all_actions('basepress_header');
            
            // Remove BasePress footer actions
            remove_all_actions('basepress_footer');
            
            // Ensure BasePress doesn't override our template
            remove_filter('template_include', 'basepress_template_include', 99);
        }
    }
    
    /**
     * Override KB templates to use theme templates
     */
    public function override_kb_templates($template) {
        // Only apply to knowledge base pages
        if (!$this->is_kb_page()) {
            return $template;
        }
        
        // Force the theme's templates instead of BasePress templates
        if (is_singular('knowledgebase')) {
            // Force single.php or page.php for single KB articles
            $single_template = locate_template(array('single-knowledgebase.php', 'single.php', 'page.php'));
            if (!empty($single_template)) {
                // Insert our content modifications 
                $this->insert_content_filters();
                return $single_template;
            }
        } elseif (is_tax('kb_category') || is_post_type_archive('knowledgebase')) {
            // Force archive.php or index.php for KB archives
            $archive_template = locate_template(array('archive-knowledgebase.php', 'archive.php', 'index.php'));
            if (!empty($archive_template)) {
                // Insert our content modifications
                $this->insert_content_filters();
                return $archive_template;
            }
        }
        
        return $template;
    }
    
    /**
     * Insert filters to modify the content in theme templates
     */
    private function insert_content_filters() {
        // Filter the page content to include BasePress content
        add_filter('the_content', array($this, 'replace_with_kb_content'), 999);
        
        // Force correct KB title
        add_filter('the_title', array($this, 'kb_title_filter'), 10, 2);
        
        // Add BasePress classes to the body
        add_filter('body_class', array($this, 'add_basepress_body_class'));
    }
    
    /**
     * Replace page content with KB content
     */
    public function replace_with_kb_content($content) {
        global $post;
        
        // Only modify KB content
        if (!$post || $post->post_type !== 'knowledgebase') {
            return $content;
        }
        
        // Capture BasePress output
        ob_start();
        echo '<div class="jotunheim-kb-content">';
        
        if (is_singular('knowledgebase')) {
            // Get single KB article content
            $this->get_kb_single_content();
        } elseif (is_tax('kb_category') || is_post_type_archive('knowledgebase')) {
            // Get KB archive content
            $this->get_kb_archive_content();
        }
        
        echo '</div>';
        $kb_content = ob_get_clean();
        
        return $kb_content;
    }
    
    /**
     * Get content for single KB article
     */
    private function get_kb_single_content() {
        if (function_exists('basepress_get_template_part')) {
            basepress_get_template_part('single', 'knowledgebase');
        } else {
            // Fallback to original content if function doesn't exist
            the_content();
        }
    }
    
    /**
     * Get content for KB archives
     */
    private function get_kb_archive_content() {
        if (function_exists('basepress_get_template_part')) {
            basepress_get_template_part('archive', 'knowledgebase');
        } else {
            // Fallback
            echo '<div class="basepress-fallback">';
            if (have_posts()) {
                while (have_posts()) {
                    the_post();
                    the_title('<h2>', '</h2>');
                    the_excerpt();
                }
            }
            echo '</div>';
        }
    }
    
    /**
     * Filter for KB titles
     */
    public function kb_title_filter($title, $id = null) {
        if ($id && get_post_type($id) === 'knowledgebase') {
            // Get the original KB title
            $kb_title = get_post($id)->post_title;
            if (!empty($kb_title)) {
                return $kb_title;
            }
        }
        return $title;
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
     * Add BasePress body classes
     */
    public function add_basepress_body_class($classes) {
        if ($this->is_kb_page()) {
            $classes[] = 'basepress';
            $classes[] = 'basepress-force-theme';
        }
        return $classes;
    }
    
    /**
     * Add KB specific body classes
     */
    public function add_kb_body_classes($classes) {
        if ($this->is_kb_page()) {
            $classes[] = 'knowledge-base-page';
            $classes[] = 'jotunheim-kb';
            
            if (is_singular('knowledgebase')) {
                $classes[] = 'kb-single';
            } elseif (is_tax('kb_category')) {
                $classes[] = 'kb-category';
            } elseif (is_post_type_archive('knowledgebase')) {
                $classes[] = 'kb-archive';
            }
        }
        return $classes;
    }
    
    /**
     * Disable BasePress template wrapper
     */
    private function disable_basepress_template_wrapper() {
        // Remove template wrapper filters
        if (class_exists('Basepress_Templates')) {
            global $basepress;
            if ($basepress && isset($basepress->templates)) {
                remove_filter('template_include', array($basepress->templates, 'template_loader'));
                remove_action('basepress_content', array($basepress->templates, 'get_template_part'));
            }
        }
        
        // Alternatively, try to remove filters by priority
        remove_all_filters('template_include', 99);
    }
}

// Initialize the class
new JotunheimKBTemplateOverride();