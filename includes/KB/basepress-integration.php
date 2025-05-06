<?php
/**
 * Complete BasePress Integration for Jotunheim Magic
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class Jotunheim_BasePress_Integration {

    /**
     * Initialize the integration
     */
    public static function init() {
        define('BASEPRESS_DIR', plugin_dir_path(dirname(__DIR__)) . 'includes/basepress/');
        define('BASEPRESS_URI', plugin_dir_url(dirname(__DIR__)) . 'includes/basepress/');
        
        // Make sure we have BasePress constants available
        if (!defined('BASEPRESS_VER')) {
            define('BASEPRESS_VER', '2.17.0.1');
        }
        
        if (!defined('BASEPRESS_DB_VER')) {
            define('BASEPRESS_DB_VER', 2.1);
        }
        
        if (!defined('BASEPRESS_PLAN')) {
            define('BASEPRESS_PLAN', 'lite');
        }
        
        // Set up template directories
        add_filter('basepress_template_paths', array(__CLASS__, 'add_template_path'), 1);
        
        // Force specific template inclusion
        add_filter('basepress_theme_file', array(__CLASS__, 'force_template_files'), 1, 2);
        
        // Add custom CSS with high priority
        add_action('wp_enqueue_scripts', array(__CLASS__, 'add_custom_styles'), 999);
        
        // CRITICAL: Force normal theme header/footer instead of BasePress ones
        remove_all_filters('basepress_get_header');
        remove_all_filters('basepress_get_footer');
        add_filter('basepress_get_header', array(__CLASS__, 'override_get_header'), 1);
        add_filter('basepress_get_footer', array(__CLASS__, 'override_get_footer'), 1);
        
        // IMPORTANT: Completely remove the basepress_theme_wrapper
        remove_all_filters('template_include');
        add_filter('template_include', array(__CLASS__, 'force_theme_template'), 1);
        
        // Register update function hooks to ensure update.php can run
        add_filter('basepress_update_function', array(__CLASS__, 'provide_update_function'));
        
        // Add language support
        add_filter('load_textdomain_mofile', array(__CLASS__, 'load_basepress_textdomain'), 10, 2);
        
        // Add body class for BasePress pages
        add_filter('body_class', array(__CLASS__, 'add_body_class'));
        
        // If user is trying to access basepress directly, redirect to our custom implementation
        if (isset($_GET['bpress_template'])) {
            add_action('template_redirect', array(__CLASS__, 'redirect_from_basepress_template'));
        }
    }

    /**
     * Redirect from direct BasePress template access
     */
    public static function redirect_from_basepress_template() {
        global $wp;
        wp_redirect(home_url($wp->request), 301);
        exit;
    }

    /**
     * Add a custom body class for BasePress pages
     */
    public static function add_body_class($classes) {
        if (function_exists('basepress_is_knowledge_base') && basepress_is_knowledge_base()) {
            $classes[] = 'jotunheim-kb';
        }
        return $classes;
    }

    /**
     * Add our template directory with highest priority
     */
    public static function add_template_path($paths) {
        // Add our path as the first one (highest priority)
        array_unshift($paths, plugin_dir_path(dirname(__DIR__)) . 'templates/basepress/');
        return $paths;
    }

    /**
     * Force our template files over BasePress
     */
    public static function force_template_files($file, $template) {
        $our_template = plugin_dir_path(dirname(__DIR__)) . 'templates/basepress/' . $template . '.php';
        
        if (file_exists($our_template)) {
            return $our_template;
        }
        
        return $file;
    }

    /**
     * Add custom CSS for BasePress
     */
    public static function add_custom_styles() {
        if (function_exists('basepress_is_knowledge_base') && basepress_is_knowledge_base()) {
            // First dequeue any BasePress theme styles if needed
            wp_dequeue_style('basepress-style');
            wp_dequeue_style('basepress-theme-style');
            
            // Then enqueue our styles with high priority
            wp_enqueue_style(
                'jotunheim-kb-styles', 
                plugin_dir_url(dirname(__DIR__)) . 'assets/css/jotunheim-kb.css',
                array(),
                '1.0.1'
            );
        }
    }

    /**
     * Override the get_header function in BasePress
     * Force the use of the regular theme header
     */
    public static function override_get_header($name) {
        // Use null to allow the normal header to be used
        return null;
    }

    /**
     * Override the get_footer function in BasePress
     * Force the use of the regular theme footer
     */
    public static function override_get_footer($name) {
        // Use null to allow the normal footer to be used
        return null;
    }

    /**
     * Force using our template file that will properly include the theme header
     */
    public static function force_theme_template($template) {
        // Only apply on BasePress pages
        if (function_exists('basepress_is_knowledge_base') && basepress_is_knowledge_base()) {
            if (is_single()) {
                return plugin_dir_path(dirname(__DIR__)) . 'templates/basepress-single.php';
            } elseif (is_search() && isset($_GET['bp_search'])) {
                return plugin_dir_path(dirname(__DIR__)) . 'templates/basepress-search.php';
            } elseif (is_tax('knowledgebase_cat')) {
                return plugin_dir_path(dirname(__DIR__)) . 'templates/basepress-category.php';
            } elseif (basepress_is_knowledge_base_page()) {
                return plugin_dir_path(dirname(__DIR__)) . 'templates/basepress-home.php';
            }
        }
        
        return $template;
    }

    /**
     * Load BasePress text domain from our plugin directory
     */
    public static function load_basepress_textdomain($mofile, $domain) {
        if ($domain === 'basepress') {
            $locale = determine_locale();
            $mofile_local = plugin_dir_path(dirname(__DIR__)) . 'includes/basepress/languages/basepress-' . $locale . '.mo';
            
            if (file_exists($mofile_local)) {
                return $mofile_local;
            }
        }
        
        return $mofile;
    }

    /**
     * Provide our update function to BasePress 
     */
    public static function provide_update_function($function) {
        if (!function_exists('basepress_update')) {
            function basepress_update($old_ver, $old_db_ver, $old_plan, $current_ver, $current_db_ver, $current_plan) {
                // Update settings if coming from older version or from free to premium
                if (!empty($old_ver) 
                    && version_compare($old_ver, $current_ver, '<')
                    || ($old_plan != 'premium' && 'premium' == $current_plan)) {

                    $new_options = array();

                    // Upgrade settings from free to premium
                    if (($old_plan != 'premium' && 'premium' == $current_plan)) {
                        $premium_options = include_once BASEPRESS_DIR . 'premium-options.php';
                        $new_options = array_merge($new_options, $premium_options);
                    }
                    
                    // Update options for version 1.9.0
                    if (function_exists('basepress_update_1_9_0')) {
                        $new_options = array_merge($new_options, basepress_update_1_9_0($old_ver, $current_ver));
                    }

                    $current_options = get_option('basepress_settings');
                    foreach ($new_options as $new_option => $value) {
                        if (!isset($current_options[$new_option])) {
                            $current_options[$new_option] = $value;
                        }
                    }

                    // Save updated options
                    update_option('basepress_settings', $current_options);
                    
                    // Update version information
                    update_option('basepress_ver', $current_ver);
                    update_option('basepress_db_ver', $current_db_ver);
                    update_option('basepress_plan', $current_plan);
                }
            }
        }
        
        return 'basepress_update';
    }
}

// Initialize the integration
Jotunheim_BasePress_Integration::init();