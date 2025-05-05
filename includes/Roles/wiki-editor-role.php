<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Wiki Editor Role Management
 * 
 * This file handles all functionality related to the wiki_editor role,
 * including permissions, capabilities, and admin UI restrictions.
 */

/**
 * Setup wiki editor role with all necessary capabilities for BasePress
 */
function setup_wiki_editor_role() {
    // Find the actual post type used by BasePress
    $post_types = get_post_types([], 'objects');
    $basepress_post_type = '';
    
    foreach ($post_types as $pt) {
        if (strpos(strtolower($pt->name), 'knowledge') !== false || 
            strpos(strtolower($pt->name), 'basepress') !== false) {
            $basepress_post_type = $pt->name;
            error_log('Found BasePress post type: ' . $basepress_post_type);
            break;
        }
    }
    
    if (empty($basepress_post_type)) {
        $basepress_post_type = 'knowledgebase'; // Fallback default
        error_log('Using default BasePress post type: ' . $basepress_post_type);
    }
    
    // Create the role if it doesn't exist
    if (!get_role('wiki_editor')) {
        add_role('wiki_editor', 'Wiki Editor', array(
            'read' => true,
            'level_0' => true
        ));
    }
    
    $role = get_role('wiki_editor');
    
    // First, remove access to regular posts
    $role->remove_cap('edit_posts');
    $role->remove_cap('publish_posts');
    $role->remove_cap('delete_posts');
    
    // Then add ALL possible BasePress capabilities
    $capabilities = array(
        // WordPress base capabilities that BasePress might require
        'read' => true,
        'upload_files' => true,
        
        // Standard post type capabilities with dynamic BasePress post type
        "edit_{$basepress_post_type}" => true,
        "edit_{$basepress_post_type}s" => true,
        "edit_others_{$basepress_post_type}s" => true,
        "publish_{$basepress_post_type}s" => true,
        "read_{$basepress_post_type}" => true,
        "read_private_{$basepress_post_type}s" => true,
        "delete_{$basepress_post_type}" => true,
        "delete_{$basepress_post_type}s" => true,
        "delete_published_{$basepress_post_type}s" => true,
        "edit_published_{$basepress_post_type}s" => true,
        
        // BasePress specific capabilities
        'edit_basepress' => true,
        'basepress_edit_articles' => true,
        'basepress_edit_knowledgebases' => true,
        'basepress_manage_options' => true,
        'basepress_manage_sections' => true,  // Added for Sections access
        'basepress_manage_products' => true,  // Added for Manage KBs access
        'manage_basepress' => true,          // General BasePress management
        
        // Variations of post capabilities that BasePress might use
        'edit_knowledge_base' => true,
        'edit_knowledgebase' => true,
        'edit_knowledgebases' => true,
        'publish_knowledgebases' => true,
        'edit_others_knowledgebases' => true,
        
        // WordPress admin capabilities needed
        'manage_options' => true,           // Often needed to access settings pages
    );
    
    // Add each capability to the role
    foreach ($capabilities as $cap => $grant) {
        $role->add_cap($cap);
    }
    
    error_log('Wiki Editor role configured with ' . count($capabilities) . ' capabilities');
    
    return $basepress_post_type;
}

/**
 * Assign the Wiki Editor role to users with the Discord Wiki Editor role
 */
function assign_wiki_editor_role() {
    if (!is_user_logged_in()) return;
    
    $user = wp_get_current_user();
    $discord_roles = get_user_meta($user->ID, 'discord_roles', true);
    
    // Detect if user has the Wiki Editor Discord role
    $has_wiki_editor_discord = is_array($discord_roles) && in_array('1354867612324200599', $discord_roles);
    
    if ($has_wiki_editor_discord) {
        // Get BasePress post type
        $basepress_post_type = setup_wiki_editor_role();
        
        // Add wiki_editor role but don't replace existing roles
        if (!in_array('wiki_editor', $user->roles)) {
            $user->add_role('wiki_editor');
            error_log('Added wiki_editor role to user ' . $user->ID);
        }
        
        // Force required core capabilities for post editing
        $core_caps = [
            'read',
            'edit_posts', // Core capability often required
            'upload_files'
        ];
        
        foreach ($core_caps as $cap) {
            $user->add_cap($cap);
        }
        
        // Add comprehensive list of potential BasePress capabilities
        $caps = array(
            // BasePress specific caps - All variations
            'edit_basepress',
            'edit_knowledgebase',
            'edit_knowledgebases',
            'publish_knowledgebases',
            'read_knowledgebase',
            'delete_knowledgebase',
            'edit_others_knowledgebases',
            'read_private_knowledgebases',
            'basepress_edit_articles',
            'basepress_edit_knowledgebases',
            
            // Dynamic capabilities based on detected post type
            "edit_{$basepress_post_type}",
            "edit_{$basepress_post_type}s",
            "edit_published_{$basepress_post_type}s",
            "publish_{$basepress_post_type}s",
            "edit_others_{$basepress_post_type}s",
            "read_private_{$basepress_post_type}s",
            "delete_{$basepress_post_type}s",
            
            // Essential WP edit caps for the specific post type
            "create_{$basepress_post_type}s", // Important for creation
            "edit_published_{$basepress_post_type}s"
        );
        
        foreach ($caps as $cap) {
            $user->add_cap($cap);
        }
        
        error_log('User ' . $user->ID . ' capabilities updated with complete BasePress edit permissions');
    }
}

/**
 * Hide posts UI for wiki editors
 */
function hide_post_ui_for_wiki_editors() {
    if (current_user_can('wiki_editor') && !current_user_can('administrator')) {
        // Hide ALL admin menu items to keep the interface clean
        global $menu;
        
        if (!empty($menu)) {
            foreach ($menu as $key => $item) {
                remove_menu_page($item[2]);
            }
        }
        
        // Hide post creation UI elements
        echo '<style>
            #wp-admin-bar-new-post, 
            #wp-admin-bar-new-content,
            .page-title-action { 
                display: none !important; 
            }
        </style>';
    }
}

/**
 * Restrict wiki editors from accessing post-related admin pages
 */
function restrict_wiki_editor_admin_access() {
    if (current_user_can('wiki_editor') && !current_user_can('administrator')) {
        global $pagenow;
        
        // Detect BasePress post type
        $basepress_post_type = 'knowledgebase'; // Default
        if (post_type_exists('basepress_knowledgebase')) {
            $basepress_post_type = 'basepress_knowledgebase';
        } elseif (post_type_exists('knowledgebase')) {
            $basepress_post_type = 'knowledgebase';
        }
        
        // Block access to post creation/editing screens
        $restricted_pages = array('post-new.php', 'edit.php');
        
        if (in_array($pagenow, $restricted_pages) && 
            (!isset($_GET['post_type']) || $_GET['post_type'] !== $basepress_post_type)) {
            wp_redirect(admin_url("edit.php?post_type={$basepress_post_type}"));
            exit;
        }
    }
}

/**
 * Add BasePress role capabilities for the wiki_editor role
 */
function add_basepress_capabilities_for_wiki_editor($basepress_roles) {
    // Add wiki_editor to the list of roles that can edit BasePress content
    $basepress_roles[] = 'wiki_editor';
    return $basepress_roles;
}

/**
 * Allow wiki editors to access BasePress admin settings pages
 */
function allow_wiki_editor_basepress_settings_access($capability) {
    if (current_user_can('wiki_editor')) {
        // Check if we're on a BasePress settings page
        $is_basepress_admin = false;
        if (isset($_GET['post_type']) && $_GET['post_type'] === 'knowledgebase' && 
            isset($_GET['page']) && $_GET['page'] === 'basepress_settings') {
            $is_basepress_admin = true;
        }
        
        if ($is_basepress_admin) {
            return 'read'; // Change required capability to one the wiki editor has
        }
    }
    
    return $capability;
}
add_filter('basepress_settings_capability', 'allow_wiki_editor_basepress_settings_access');
add_filter('option_page_capability_basepress_settings', 'allow_wiki_editor_basepress_settings_access');

/**
 * Allow wiki editors to access sections admin page
 */
function allow_wiki_editor_sections_access($capability) {
    if (current_user_can('wiki_editor') && isset($_GET['tab']) && $_GET['tab'] === 'sections') {
        return 'read';
    }
    return $capability;
}
add_filter('basepress_sections_capability', 'allow_wiki_editor_sections_access');

/**
 * Allow wiki editors to access products admin page
 */
function allow_wiki_editor_products_access($capability) {
    if (current_user_can('wiki_editor') && isset($_GET['tab']) && $_GET['tab'] === 'products') {
        return 'read';
    }
    return $capability;
}
add_filter('basepress_products_capability', 'allow_wiki_editor_products_access');

/**
 * Direct override of user capabilities check for wiki editors
 * This is a more direct approach to bypass WordPress capability checks
 */
function wiki_editor_map_meta_cap($caps, $cap, $user_id, $args) {
    // Only process for wiki editors
    $user = get_user_by('id', $user_id);
    if (!$user || !in_array('wiki_editor', $user->roles)) {
        return $caps;
    }

    // Check for BasePress settings pages
    $is_basepress_admin = false;
    if (isset($_GET['post_type']) && $_GET['post_type'] === 'knowledgebase' && 
        isset($_GET['page']) && $_GET['page'] === 'basepress_settings') {
        $is_basepress_admin = true;
    }
    
    if ($is_basepress_admin) {
        // These are capabilities commonly checked for admin pages
        $admin_caps = [
            'manage_options',
            'edit_plugins',
            'activate_plugins',
            'administrator',
            'manage_categories',
        ];
        
        if (in_array($cap, $admin_caps)) {
            return ['read']; // Replace with a capability wiki editors have
        }
    }
    
    return $caps;
}
add_filter('map_meta_cap', 'wiki_editor_map_meta_cap', 10, 4);

/**
 * Fix specific admin page access for wiki editors
 * This runs early to intercept and modify capability checks
 */
function wiki_editor_admin_page_access() {
    // Only run for wiki editors
    if (!current_user_can('wiki_editor') || current_user_can('administrator')) {
        return;
    }
    
    // Check if we're on a BasePress settings page
    $is_basepress_admin = false;
    if (isset($_GET['post_type']) && $_GET['post_type'] === 'knowledgebase' && 
        isset($_GET['page']) && $_GET['page'] === 'basepress_settings') {
        $is_basepress_admin = true;
    }
    
    if ($is_basepress_admin) {
        // Direct override for BasePress pages
        add_filter('user_has_cap', function($allcaps, $caps, $args, $user) {
            if (isset($caps[0])) {
                $allcaps[$caps[0]] = true;
            }
            
            // Add required capabilities for settings pages
            $admin_caps = [
                'manage_options',
                'edit_plugins',
                'activate_plugins',
                'administrator',
                'manage_categories',
            ];
            
            foreach ($admin_caps as $admin_cap) {
                $allcaps[$admin_cap] = true;
            }
            
            return $allcaps;
        }, 10, 4);
        
        // Enable access to specific tabs
        if (isset($_GET['tab'])) {
            $tab = $_GET['tab'];
            if ($tab === 'sections' || $tab === 'products') {
                add_filter('basepress_' . $tab . '_capability', function() {
                    return 'read';
                });
            }
        }
    }
}
add_action('admin_init', 'wiki_editor_admin_page_access', 1); // Run very early

/**
 * Hook all wiki editor role functions
 */
function initialize_wiki_editor_role() {
    // Setup and assign roles
    add_action('wp_loaded', 'assign_wiki_editor_role');
    
    // UI restrictions
    add_action('admin_menu', 'hide_post_ui_for_wiki_editors');
    add_action('admin_head', 'hide_post_ui_for_wiki_editors');
    add_action('admin_init', 'restrict_wiki_editor_admin_access');
    
    // BasePress integration
    add_filter('basepress_editor_roles', 'add_basepress_capabilities_for_wiki_editor');
    add_filter('basepress_allowed_roles', 'add_basepress_capabilities_for_wiki_editor');
}
initialize_wiki_editor_role();