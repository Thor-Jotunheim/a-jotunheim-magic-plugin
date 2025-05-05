<?php
// File: jotunheim-magic.php

/*
Plugin Name: A Jotunheim Magic Plugin
Description: A plugin to manage the item list and editor for Jotunheim.
Version: 0.9.0
Author: Thor
*/

// Prevent direct access
if (!defined('ABSPATH')) exit;

// File: jotunheim-magic.php
require_once(plugin_dir_path(__FILE__) . 'includes/Utility/helpers.php');

// Include Utility files
include_once(plugin_dir_path(__FILE__) . 'includes/Utility/dark-mode.php');

// Include ItemList files
include_once(plugin_dir_path(__FILE__) . 'includes/ItemList/itemlist-editor-scripts.php');
include_once(plugin_dir_path(__FILE__) . 'includes/ItemList/itemlist-editor-interface.php');
//include_once(plugin_dir_path(__FILE__) . 'includes/ItemList/itemlist-editor-ajax.php');
include_once(plugin_dir_path(__FILE__) . 'includes/ItemList/itemlist-rest-api.php');
include_once(plugin_dir_path(__FILE__) . 'includes/ItemList/itemlist-add-new-item-interface.php');

// Include prefablist files
require_once(plugin_dir_path(__FILE__) . 'includes/PrefabList/prefablist-api-get.php');

// Include pricelist file
include_once(plugin_dir_path(__FILE__) . 'includes/PriceList/pricelist.php');

// Include the dashboard menu file
include_once(plugin_dir_path(__FILE__) . 'includes/Dashboard/dashboard-menu.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Dashboard/dashboard-top.php');

// Include PrefabList file(s)
include_once(plugin_dir_path(__FILE__) . 'includes/PrefabList/prefabdb-image-import.php');

// Include the Discord OAuth token generation functions
//include_once plugin_dir_path(__FILE__) . 'includes/Discord/discord-oauth-generate-jwt-token.php';

// Include the custom Discord OAuth API endpoint
include_once(plugin_dir_path(__FILE__) . 'includes/Discord/discord-oauth-api.php');

// Include the Discord OAuth handler files
include_once(plugin_dir_path(__FILE__) . 'includes/Discord/discord-oauth-handler.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Discord/discord-role-access.php');

// Include event zones editor files
include_once(plugin_dir_path(__FILE__) . 'includes/EventZone/eventzones-permission.php');
include_once(plugin_dir_path(__FILE__) . 'includes/EventZone/eventzones-rest-api.php');
include_once(plugin_dir_path(__FILE__) . 'includes/EventZone/eventzones-post-api.php');
include_once(plugin_dir_path(__FILE__) . 'includes/EventZone/eventzones-put-api.php');
include_once(plugin_dir_path(__FILE__) . 'includes/EventZone/eventzones-delete-api.php');
include_once(plugin_dir_path(__FILE__) . 'includes/EventZone/eventzones-code-output.php');
include_once(plugin_dir_path(__FILE__) . 'includes/EventZone/eventzones-editor-scripts.php');
include_once(plugin_dir_path(__FILE__) . 'includes/EventZone/eventzones-editor-interface.php');
include_once(plugin_dir_path(__FILE__) . 'includes/EventZone/eventzones-add-new-zone-interface.php');
include_once(plugin_dir_path(__FILE__) . 'includes/EventZone/eventzones-goto-output.php');
//include_once(plugin_dir_path(__FILE__) . 'includes/EventZone/eventzones-interface-shortcodes.php');

// Include Trade and Barter files
include_once(plugin_dir_path(__FILE__) . 'includes/Trade/trade-api-get.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Trade/barter-interface.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Trade/trade-interface.php');

// Include Trade APIs
include_once(plugin_dir_path(__FILE__) . 'includes/Trade/trade-permissions.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Trade/trade-shops-api-post.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Trade/trade-shops-api-put.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Trade/trade-shops-api-rest.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Trade/trade-shops-cleanup.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Trade/trade-shops-items-api-post.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Trade/trade-shops-items-api-put.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Trade/trade-shops-items-api-rest.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Trade/trade-transactions-api-post.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Trade/trade-transactions-api-put.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Trade/trade-transactions-api-rest.php');

// Shops
include_once(plugin_dir_path(__FILE__) . 'includes/Trade/shop-creation-ui.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Trade/trade-ajax-handlers.php');

// Include ledger files
include_once(plugin_dir_path(__FILE__) . 'includes/Ledger/ledger-rest-api.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Ledger/ledger-get.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Ledger/ledger-put.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Ledger/ledger-post-claim.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Ledger/ledger-post-insert-player.php');

// Include UniversalUI components
require_once plugin_dir_path(__FILE__) . 'includes/UniversalUI/universal-ui-scripts.php';
require_once plugin_dir_path(__FILE__) . 'includes/UniversalUI/universal-editor-ui.php';
require_once plugin_dir_path(__FILE__) . 'includes/UniversalUI/universal-add-ui.php';
if (defined('DOING_AJAX') && DOING_AJAX && isset($_REQUEST['action']) && !in_array($_REQUEST['action'], ['heartbeat', 'wp_ajax_heartbeat'])) {
    require_once plugin_dir_path(__FILE__) . 'includes/UniversalUI/universal-endpoint-handler.php';
}

// Include Gallery Submission components
require_once(plugin_dir_path(__FILE__) . 'includes/Gallery/gallery-submission-form.php');
require_once(plugin_dir_path(__FILE__) . 'includes/Gallery/gallery-submission-scripts.php');

// Register shortcode for EventZones Editor
add_shortcode('eventzones_editor', 'eventzones_editor_shortcode');

// Register shortcode for EventZones Add New Zone
add_shortcode('eventzones_add_new_zone', 'eventzones_add_new_zone_shortcode');

// Function to assign capabilities to administrator and editor roles
function jotunheim_magic_assign_capabilities() {
    $roles = ['administrator', 'editor'];
    foreach ($roles as $role_name) {
        $role = get_role($role_name);
        
        if ($role) {
            // Adding 'update_itemlist' and 'update_eventzones' capabilities if missing
            if (!$role->has_cap('update_itemlist')) {
                $role->add_cap('update_itemlist');
                error_log("Capability 'update_itemlist' added to {$role_name}.");
            }
            if (!$role->has_cap('update_eventzones')) {
                $role->add_cap('update_eventzones');
                error_log("Capability 'update_eventzones' added to {$role_name}.");
            }
        } else {
            error_log("Role '{$role_name}' does not exist.");
        }
    }
    //error_log('Capabilities check complete for administrator and editor.');
}

register_activation_hook(__FILE__, 'jotunheim_magic_assign_capabilities');
add_action('admin_init', 'jotunheim_magic_assign_capabilities');

// Temporarily elevate editor capabilities on specific editor pages
function jotunheim_magic_temp_elevate_editor_capabilities() {
    if (!is_admin()) {
        // Get the current page slug
        global $pagenow;
        $current_page_slug = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        // Check if user is an editor and is on either the Item List Editor or Event Zone Editor page
        if ((is_page('item-list-editor') || is_page('event-zone-editor')) && current_user_can('editor')) {
            $editor = get_role('editor');
            $admin_caps = get_role('administrator')->capabilities;

            // Grant all administrator capabilities to editor temporarily
            foreach ($admin_caps as $cap => $value) {
                if (!$editor->has_cap($cap)) {
                    $editor->add_cap($cap);
                }
            }
            error_log("Editor temporarily given administrator capabilities on {$current_page_slug} page.");
        }
    }
}
add_action('wp', 'jotunheim_magic_temp_elevate_editor_capabilities');

// Restore editor capabilities when leaving specific editor pages
function jotunheim_magic_restore_editor_capabilities() {
    if (!is_admin() && !(is_page('item-list-editor') || is_page('event-zone-editor')) && current_user_can('editor')) {
        $editor = get_role('editor');
        $admin_caps = get_role('administrator')->capabilities;

        // Remove all administrator capabilities from editor when not on specific editor pages
        foreach ($admin_caps as $cap => $value) {
            if ($editor->has_cap($cap)) {
                $editor->remove_cap($cap);
            }
        }
        error_log('Editor administrator capabilities removed after leaving specific editor pages.');
    }
}
add_action('wp', 'jotunheim_magic_restore_editor_capabilities');

function is_user_logged_in_ajax() {
    if (is_user_logged_in()) {
        wp_send_json_success();
    } else {
        wp_send_json_error('User is not logged in');
    }
}
add_action('wp_ajax_is_user_logged_in', 'is_user_logged_in_ajax');

// Plugin activation
function jotunheim_magic_activate() {
    jotunheim_magic_assign_capabilities();
    error_log('Plugin activated and capabilities assigned.');
}
register_activation_hook(__FILE__, 'jotunheim_magic_activate');

// Plugin deactivation
function jotunheim_magic_deactivate() {}
register_deactivation_hook(__FILE__, 'jotunheim_magic_deactivate');

// Function to render Discord Login Button as a shortcode
function jotunheim_magic_discord_login_button() {
    ob_start();
    ?>
    <a href="https://discord.com/api/oauth2/authorize?client_id=1297908076929613956&redirect_uri=https%3A%2F%2Fjotun.games%2Fwp-admin%2Fadmin-ajax.php%3Faction%3Doauth2callback&response_type=code&scope=identify%20email" class="discord-login-button" style="display: inline-block; padding: 10px 20px; background-color: #7289da; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold; text-align: center;">
        Login with Discord
    </a>
    <?php
    return ob_get_clean();
}
add_shortcode('discord_login_button', 'jotunheim_magic_discord_login_button');

// Add Discord button to login form
function jotunheim_magic_add_discord_button_to_login() {
    echo do_shortcode('[discord_login_button]');
}
add_action('login_form', 'jotunheim_magic_add_discord_button_to_login');

// Remove WordPress logo from admin bar for all users
function jotunheim_magic_remove_wp_logo($wp_admin_bar) {
    $wp_admin_bar->remove_node('wp-logo');
}
add_action('admin_bar_menu', 'jotunheim_magic_remove_wp_logo', 999);

function jotunheim_magic_remove_dashboard_widgets() {
    if (!current_user_can('administrator')) {
        remove_meta_box('e-dashboard-overview', 'dashboard', 'normal');
        remove_meta_box('dashboard_primary', 'dashboard', 'side');
    }
}
add_action('wp_dashboard_setup', 'jotunheim_magic_remove_dashboard_widgets');

// Enhanced function to set up Wiki Editor role with proper capabilities
function setup_wiki_editor_role() {
    // Detect BasePress post type - it may not be 'knowledge_base'
    $basepress_post_type = 'knowledgebase'; // Default BasePress post type
    
    if (post_type_exists('basepress_knowledgebase')) {
        $basepress_post_type = 'basepress_knowledgebase';
    } elseif (post_type_exists('knowledgebase')) {
        $basepress_post_type = 'knowledgebase';
    }
    
    // Log the detected post type
    error_log('Detected BasePress post type: ' . $basepress_post_type);
    
    // Create the role if it doesn't exist
    if (!get_role('wiki_editor')) {
        add_role('wiki_editor', 'Wiki Editor', array(
            'read' => true,
            'level_0' => true
        ));
    }
    
    $role = get_role('wiki_editor');
    
    // Remove ALL regular post capabilities
    $post_caps_to_remove = array(
        'edit_posts',
        'publish_posts',
        'edit_published_posts',
        'delete_posts',
        'edit_others_posts',
        'delete_others_posts',
        'delete_published_posts',
        'edit_private_posts',
        'read_private_posts'
    );
    
    // Remove capabilities for regular posts
    foreach ($post_caps_to_remove as $cap) {
        $role->remove_cap($cap);
    }
    
    // BasePress specific capabilities - using detected post type
    $basepress_caps = array(
        'edit_basepress',
        'edit_knowledgebase',
        'edit_knowledgebases',
        'edit_published_knowledgebases',
        'publish_knowledgebases',
        'read_knowledgebase',
        'delete_knowledgebase',
        'edit_others_knowledgebases',
        'read_private_knowledgebases',
        'delete_knowledgebases',
        // Add capability variations for different post type names
        "edit_{$basepress_post_type}",
        "edit_{$basepress_post_type}s",
        "edit_published_{$basepress_post_type}s",
        "publish_{$basepress_post_type}s",
        "read_{$basepress_post_type}",
        "delete_{$basepress_post_type}",
        "edit_others_{$basepress_post_type}s",
        "read_private_{$basepress_post_type}s",
        "delete_{$basepress_post_type}s",
    );
    
    // Add BasePress capabilities
    foreach ($basepress_caps as $cap) {
        $role->add_cap($cap);
    }
    
    // Ensure basic capabilities
    $role->add_cap('read');
    $role->add_cap('level_0');
    
    error_log('Wiki Editor role capabilities: ' . print_r($role->capabilities, true));
    
    return $basepress_post_type;
}

// Assign the Wiki Editor role to users with the Discord Wiki Editor role
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
        
        // Add comprehensive list of potential BasePress capabilities
        $caps = array(
            // Standard WordPress editing caps
            'edit_posts',
            'publish_posts',
            'edit_published_posts',
            
            // BasePress specific caps
            'edit_basepress',
            'edit_knowledgebase',
            'edit_knowledgebases',
            'publish_knowledgebases',
            'read_knowledgebase',
            'delete_knowledgebase',
            'edit_others_knowledgebases',
            'read_private_knowledgebases',
            
            // Dynamic capabilities based on detected post type
            "edit_{$basepress_post_type}",
            "edit_{$basepress_post_type}s",
            "edit_published_{$basepress_post_type}s",
            "publish_{$basepress_post_type}s",
            "edit_others_{$basepress_post_type}s",
            "read_private_{$basepress_post_type}s",
            "delete_{$basepress_post_type}s",
            
            // BasePress plugin specific caps (if any)
            'basepress_edit_articles',
            'basepress_edit_knowledgebases'
        );
        
        foreach ($caps as $cap) {
            $user->add_cap($cap);
        }
        
        error_log('User ' . $user->ID . ' capabilities updated with complete BasePress edit permissions');
    }
}
add_action('wp_loaded', 'assign_wiki_editor_role');

// Hide posts UI for wiki editors
function hide_post_ui_for_wiki_editors() {
    if (current_user_can('wiki_editor') && !current_user_can('administrator')) {
        // Remove Posts menu
        remove_menu_page('edit.php');
        
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
add_action('admin_menu', 'hide_post_ui_for_wiki_editors');
add_action('admin_head', 'hide_post_ui_for_wiki_editors');

// Restrict wiki editors from accessing post-related admin pages
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
add_action('admin_init', 'restrict_wiki_editor_admin_access');
?>