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

// Check if the logged-in user has the Discord "Wiki Editor" role
function user_has_discord_wiki_editor_role() {
    if (!is_user_logged_in()) {
        return false;
    }

    // Get the user's Discord roles from user meta
    $discord_roles = get_user_meta(get_current_user_id(), 'discord_roles', true);

    // Check if the "Wiki Editor" role ID exists in the user's roles
    return is_array($discord_roles) && in_array('1354867612324200599', $discord_roles);
}

// Grant BasePress capabilities to users with the "Wiki Editor" role
function grant_wiki_editor_capabilities() {
    if (user_has_discord_wiki_editor_role()) {
        $user = wp_get_current_user();

        // Add the necessary capability dynamically
        if ($user && !$user->has_cap('edit_basepress')) {
            $user->add_cap('edit_basepress');
        }
    }
}
add_action('init', 'grant_wiki_editor_capabilities');

// Ensure the Wiki Editor role exists
function create_wiki_editor_role() {
    if (!get_role('wiki_editor')) {
        add_role('wiki_editor', 'Wiki Editor', array(
            'read' => true,
            'edit_basepress' => true // Capability to edit BasePress
        ));
    }
}
add_action('init', 'create_wiki_editor_role');

// Ensure the Wiki Editor role has the correct capabilities
function ensure_wiki_editor_capabilities() {
    $role = get_role('wiki_editor');
    if ($role) {
        // Add the capability to edit BasePress if missing
        if (!$role->has_cap('edit_basepress')) {
            $role->add_cap('edit_basepress');
        }

        // Add other necessary capabilities for BasePress
        if (!$role->has_cap('edit_posts')) {
            $role->add_cap('edit_posts');
        }
        if (!$role->has_cap('publish_posts')) {
            $role->add_cap('publish_posts');
        }
    }
}
add_action('init', 'ensure_wiki_editor_capabilities');

// Ensure the Wiki Editor role has the correct capabilities for the Knowledge Base
function ensure_wiki_editor_knowledge_base_capabilities() {
    $role = get_role('wiki_editor');
    if ($role) {
        // Add capabilities specific to the Knowledge Base post type
        $role->add_cap('edit_knowledge_base');
        $role->add_cap('edit_others_knowledge_base');
        $role->add_cap('publish_knowledge_base');
        $role->add_cap('read_knowledge_base');
        $role->add_cap('delete_knowledge_base');
    }
}
add_action('init', 'ensure_wiki_editor_knowledge_base_capabilities');

// Handle multiple Discord roles and prioritize them
function assign_highest_priority_role($user_id, $discord_roles) {
    $role_hierarchy = [
        'administrator' => 'administrator',
        'editor' => 'editor',
        'wiki_editor' => 'wiki_editor',
        'subscriber' => 'subscriber'
    ];

    foreach ($role_hierarchy as $discord_role_id => $wp_role) {
        if (in_array($discord_role_id, $discord_roles)) {
            $user = new WP_User($user_id);
            $user->set_role($wp_role);
            break;
        }
    }
}

// Example usage during Discord login
function handle_discord_login($user_id, $discord_roles) {
    assign_highest_priority_role($user_id, $discord_roles);
}

// Restrict admin menu for the `wiki_editor` role
function restrict_admin_menu_for_wiki_editor() {
    if (current_user_can('wiki_editor')) {
        global $menu;

        // Allow only the Knowledge Base menu
        foreach ($menu as $key => $value) {
            if ($value[2] !== 'edit.php?post_type=knowledge_base') {
                unset($menu[$key]);
            }
        }
    }
}
add_action('admin_menu', 'restrict_admin_menu_for_wiki_editor', 999);

// Ensure the Knowledge Base menu is visible for the `wiki_editor` role
function ensure_knowledge_base_menu_for_wiki_editor() {
    if (current_user_can('wiki_editor')) {
        add_menu_page(
            'Knowledge Base',
            'Knowledge Base',
            'edit_basepress',
            'edit.php?post_type=knowledge_base',
            '',
            'dashicons-book',
            20
        );
    }
}
add_action('admin_menu', 'ensure_knowledge_base_menu_for_wiki_editor', 998);

// Restrict post access for the `wiki_editor` role
function restrict_post_access_for_wiki_editor($query) {
    if (is_admin() && $query->is_main_query() && current_user_can('wiki_editor')) {
        $query->set('post_type', 'knowledge_base');
    }
}
add_action('pre_get_posts', 'restrict_post_access_for_wiki_editor');
?>