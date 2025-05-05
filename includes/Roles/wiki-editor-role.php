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
        
        // Variations of post capabilities that BasePress might use
        'edit_knowledge_base' => true,
        'edit_knowledgebase' => true,
        'edit_knowledgebases' => true,
        'publish_knowledgebases' => true,
        'edit_others_knowledgebases' => true
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