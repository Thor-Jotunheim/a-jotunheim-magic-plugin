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
        
        // Apply our admin menu overrides
        add_action('admin_menu', array($this, 'restore_kb_admin_menu'), 999);
        add_action('admin_head', array($this, 'hide_unwanted_admin_items'), 999);
        
        // Check if we're accessing BasePress settings
        if (!isset($_GET['post_type']) || $_GET['post_type'] !== 'knowledgebase' ||
            !isset($_GET['page']) || $_GET['page'] !== 'basepress_settings') {
            return;
        }
        
        // Override WordPress and BasePress permissions for settings pages
        $this->apply_permission_overrides();
    }
    
    /**
     * Restore only the KB menu for wiki editors
     */
    public function restore_kb_admin_menu() {
        if (!current_user_can('wiki_editor') || current_user_can('administrator')) {
            return;
        }
        
        global $menu, $submenu;
        
        // First, save the KB menu and submenu
        $kb_menu = null;
        $kb_submenu = null;
        
        if (!empty($menu)) {
            foreach ($menu as $key => $item) {
                if (isset($item[2]) && $item[2] === 'edit.php?post_type=knowledgebase') {
                    $kb_menu = $item;
                    break;
                }
            }
        }
        
        if (!empty($submenu) && isset($submenu['edit.php?post_type=knowledgebase'])) {
            $kb_submenu = $submenu['edit.php?post_type=knowledgebase'];
        }
        
        // Now clear all menus first
        $menu = array();
        $submenu = array();
        
        // Then restore only the KB menu and submenu
        if ($kb_menu) {
            $menu[10] = $kb_menu;
        }
        
        if ($kb_submenu) {
            $submenu['edit.php?post_type=knowledgebase'] = $kb_submenu;
        }
    }
    
    /**
     * Hide unwanted admin elements via CSS
     */
    public function hide_unwanted_admin_items() {
        if (!current_user_can('wiki_editor') || current_user_can('administrator')) {
            return;
        }
        
        echo '<style>
            /* Hide all unwanted menu items */
            #adminmenumain > #adminmenuwrap > #adminmenu > li:not(:has(a[href*="edit.php?post_type=knowledgebase"])) {
                display: none !important;
            }
            
            /* But ensure Knowledge Base menu is visible */
            #adminmenumain > #adminmenuwrap > #adminmenu > li:has(a[href*="edit.php?post_type=knowledgebase"]) {
                display: block !important;
            }
            
            /* Hide unwanted notices that might interfere with the page content */
            .update-nag, 
            .update-plugins,
            .update-message,
            .updated:not(.notice-info),
            #wpfooter {
                display: none !important;
            }
        </style>';
    }
    
    private function apply_permission_overrides() {
        // Add admin capabilities directly to user temporarily
        global $current_user;
        $current_user->allcaps['manage_options'] = true;
        $current_user->allcaps['activate_plugins'] = true;
        $current_user->allcaps['edit_theme_options'] = true;
        
        // Override specific BasePress checks
        add_filter('basepress_settings_capability', array($this, 'bypass_capability_check'));
        add_filter('basepress_sections_capability', array($this, 'bypass_capability_check'));
        add_filter('basepress_products_capability', array($this, 'bypass_capability_check'));
        add_filter('option_page_capability_basepress_settings', array($this, 'bypass_capability_check'));
        
        // Override core capability mapping
        add_filter('map_meta_cap', array($this, 'override_meta_cap'), 999, 4);
        
        // Direct capability bypass
        add_filter('user_has_cap', array($this, 'force_specific_capability'), 999, 4);
    }
    
    /**
     * Force specific capabilities for wiki editors
     */
    public function force_specific_capability($allcaps, $caps, $args, $user) {
        if (!in_array('wiki_editor', (array) $user->roles)) {
            return $allcaps;
        }
        
        // Always grant access to these specific capabilities
        $grant_caps = array(
            'manage_options',
            'manage_categories', 
            'edit_theme_options',
            'edit_plugins',
            'activate_plugins',
            'install_plugins',
            'edit_dashboard', 
            'update_plugins'
        );
        
        foreach ($grant_caps as $cap) {
            $allcaps[$cap] = true;
        }
        
        // If specifically checking a capability, grant it
        if (isset($caps[0])) {
            $allcaps[$caps[0]] = true;
        }
        
        return $allcaps;
    }
    
    /**
     * Bypass standard capability checks
     */
    public function bypass_capability_check($cap) {
        return 'read';
    }
    
    /**
     * Override meta cap mapping
     */
    public function override_meta_cap($caps, $cap, $user_id, $args) {
        $user = get_user_by('id', $user_id);
        if (!$user || !in_array('wiki_editor', (array) $user->roles)) {
            return $caps;
        }
        
        // Bypass common admin capabilities
        $admin_caps = array(
            'manage_options',
            'edit_plugins',
            'activate_plugins',
            'administrator',
            'update_core',
            'install_plugins',
            'edit_theme_options',
            'manage_categories',
        );
        
        if (in_array($cap, $admin_caps)) {
            return array('read');
        }
        
        return $caps;
    }
}

// Initialize the access class
KB_Wiki_Editor_Access::get_instance();

/**
 * Direct BasePress settings content delivery for wiki editors
 * This helps prevent blank pages due to permissions
 */
function kb_wiki_editor_access_basepress_settings() {
    // Only run for wiki editors
    if (!is_user_logged_in() || !current_user_can('wiki_editor') || current_user_can('administrator')) {
        return;
    }
    
    // Only run on BasePress settings pages
    if (!isset($_GET['post_type']) || $_GET['post_type'] !== 'knowledgebase' ||
        !isset($_GET['page']) || $_GET['page'] !== 'basepress_settings') {
        return;
    }
    
    // Force BasePress settings page to load properly
    add_filter('basepress_settings_capability', function($cap) {
        return 'read';
    }, 9999);
    
    // Get the current tab
    $tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : '';
    
    // Ensure the tab is loaded properly
    if ($tab === 'sections' || $tab === 'products') {
        add_filter("basepress_{$tab}_capability", function() {
            return 'read';
        }, 9999);
    }
}