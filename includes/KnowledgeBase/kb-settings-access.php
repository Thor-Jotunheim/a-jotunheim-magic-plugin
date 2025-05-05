<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * BasePress Settings Access Override
 * 
 * This file contains a direct bypass for BasePress settings page permissions
 * to ensure wiki editors can access these pages.
 */

/**
 * Add an admin notice to show we're in override mode
 */
function kb_settings_override_notice() {
    if (current_user_can('wiki_editor') && !current_user_can('administrator')) {
        // Only show on BasePress settings pages
        if (isset($_GET['post_type']) && $_GET['post_type'] === 'knowledgebase' &&
            isset($_GET['page']) && $_GET['page'] === 'basepress_settings') {
            
            echo '<div class="notice notice-info">
                <p><strong>Wiki Editor Access:</strong> You have special access to these BasePress settings.</p>
            </div>';
        }
    }
}
add_action('admin_notices', 'kb_settings_override_notice');

/**
 * Direct permission override for wiki editors on BasePress settings
 */
class KB_Wiki_Editor_Access {
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    
    private function __construct() {
        // Run very early in the request lifecycle
        add_action('plugins_loaded', array($this, 'init'), 1);
    }
    
    public function init() {
        // Only run for logged in users
        if (!function_exists('wp_get_current_user')) {
            return;
        }
        
        // Check if user is a wiki editor
        $user = wp_get_current_user();
        if (!in_array('wiki_editor', (array) $user->roles)) {
            return;
        }
        
        // Check if we're accessing BasePress settings
        if (!isset($_GET['post_type']) || $_GET['post_type'] !== 'knowledgebase' ||
            !isset($_GET['page']) || $_GET['page'] !== 'basepress_settings') {
            return;
        }
        
        // Override WordPress and BasePress permissions for settings pages
        $this->apply_permission_overrides();
    }
    
    private function apply_permission_overrides() {
        // Override core WordPress capability check
        add_filter('user_has_cap', array($this, 'override_user_caps'), 999, 4);
        
        // Override specific BasePress checks
        add_filter('basepress_settings_capability', array($this, 'return_read_capability'));
        add_filter('basepress_sections_capability', array($this, 'return_read_capability'));  
        add_filter('basepress_products_capability', array($this, 'return_read_capability'));
        
        // Generic settings page access
        add_filter('option_page_capability_basepress_settings', array($this, 'return_read_capability'));
        
        // Override core capability mapping
        add_filter('map_meta_cap', array($this, 'override_meta_cap'), 999, 4);
    }
    
    /**
     * Override user capabilities check
     */
    public function override_user_caps($allcaps, $caps, $args, $user) {
        // Add all caps possibly needed for settings pages
        $required_caps = array(
            'manage_options',
            'edit_theme_options', 
            'install_plugins',
            'activate_plugins',
            'edit_plugins',
            'update_plugins',
            'delete_plugins',
            'manage_categories',
            'edit_categories',
            'delete_categories',
            'manage_network',
            'manage_network_options',
            'manage_network_plugins',
        );
        
        foreach ($required_caps as $cap) {
            $allcaps[$cap] = true;
        }
        
        // Add specific capability being checked
        if (!empty($caps) && isset($caps[0])) {
            $allcaps[$caps[0]] = true;
        }
        
        // BasePress specific capabilities
        if (isset($_GET['tab'])) {
            $tab = sanitize_text_field($_GET['tab']);
            $allcaps["basepress_{$tab}_capability"] = true;
            $allcaps["basepress_manage_{$tab}"] = true;
        }
        
        return $allcaps;
    }
    
    /**
     * Directly modify capability mapping
     */
    public function override_meta_cap($caps, $cap, $user_id, $args) {
        // Replace admin capabilities with 'read'
        $admin_caps = array(
            'manage_options',
            'edit_plugins',
            'activate_plugins',
            'administrator',
            'update_core',
            'update_plugins',
            'update_themes',
            'install_plugins',
            'install_themes',
            'delete_themes',
            'delete_plugins',
            'edit_theme_options',
            'manage_categories',
        );
        
        if (in_array($cap, $admin_caps)) {
            return array('read');
        }
        
        return $caps;
    }
    
    /**
     * Return 'read' capability for specific checks
     */
    public function return_read_capability() {
        return 'read';
    }
}

// Initialize the access class
KB_Wiki_Editor_Access::get_instance();

// Add special handling for BasePress menu access
function kb_add_basepress_settings_menu_for_wiki_editors() {
    if (!current_user_can('wiki_editor')) {
        return;
    }
    
    // Get the BasePress menu item
    global $submenu;
    if (!isset($submenu['edit.php?post_type=knowledgebase'])) {
        return;
    }
    
    // Make sure wiki editors can see the settings menu item
    add_submenu_page(
        'edit.php?post_type=knowledgebase',
        'Knowledge Base Settings',
        'Settings',
        'read',
        'basepress_settings',
        function() {
            // This just redirects to the actual settings page
            wp_redirect(admin_url('edit.php?post_type=knowledgebase&page=basepress_settings'));
            exit;
        }
    );
}
add_action('admin_menu', 'kb_add_basepress_settings_menu_for_wiki_editors', 999);