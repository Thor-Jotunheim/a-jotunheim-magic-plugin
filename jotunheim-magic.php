<?php
// File: jotunheim-magic.php

/*
Plugin Name: A Jotunheim Magic Plugin
Description: A plugin to manage the item list and editor for Jotunheim.
Version: 0.9
Author: Thor
*/

// Prevent direct access
if (!defined('ABSPATH')) exit;

// Determine if the site is running locally or on the live server
function is_local_environment() {
    return strpos($_SERVER['HTTP_HOST'], 'devtunnels.ms') !== false || 
           strpos($_SERVER['HTTP_HOST'], 'localhost') !== false ||
           strpos($_SERVER['HTTP_HOST'], '.local') !== false;
}

// Define base URL constant and plugin constants
define('JOTUNHEIM_BASE_URL', is_local_environment() ? 'https://2p69j0g7-80.usw3.devtunnels.ms' : 'https://JOTUNHEIM_BASE_URL');
define('JOTUNHEIM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('JOTUNHEIM_PLUGIN_URL', plugin_dir_url(__FILE__));
define('JOTUNHEIM_PLUGIN_FILE', __FILE__);

// Include utility files first
require_once(JOTUNHEIM_PLUGIN_DIR . 'includes/Utility/helpers.php');
include_once(JOTUNHEIM_PLUGIN_DIR . 'includes/Utility/dev-environment.php');
include_once(JOTUNHEIM_PLUGIN_DIR . 'includes/Utility/dark-mode.php');

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

// Include ledger files
include_once(plugin_dir_path(__FILE__) . 'includes/Ledger/ledger-rest-api.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Ledger/ledger-get.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Ledger/ledger-put.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Ledger/ledger-post-claim.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Ledger/ledger-post-insert-player.php');

// Include Wiki files
include_once(plugin_dir_path(__FILE__) . 'includes/Wiki/wiki-permissions.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Wiki/wiki-core.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Wiki/wiki-rest-api.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Wiki/wiki-integration.php');

// Include POS files
include_once(plugin_dir_path(__FILE__) . 'includes/POS/pos-database-utils.php');
include_once(plugin_dir_path(__FILE__) . 'includes/POS/pos-api.php');
include_once(plugin_dir_path(__FILE__) . 'includes/POS/pos-interface.php');
include_once(plugin_dir_path(__FILE__) . 'includes/POS/pos-scripts.php');

// Register shortcode for EventZones Editor
add_shortcode('eventzones_editor', 'eventzones_editor_shortcode');

// Register shortcode for EventZones Add New Zone
add_shortcode('eventzones_add_new_zone', 'eventzones_add_new_zone_shortcode');

// Register shortcode for Wiki
add_shortcode('wiki', 'wiki_shortcode');

// Register shortcode for POS
add_shortcode('pos_interface', 'pos_interface_shortcode');

// Ensure the Wiki core outputs content
function wiki_shortcode() {
    if (!is_user_logged_in()) {
        return do_shortcode('[discord_login_button]');
    }

    // Start output buffering
    ob_start();

    // Include the Wiki core functionality
    include_once(JOTUNHEIM_PLUGIN_DIR . 'includes/Wiki/wiki-core.php');

    // Capture and return the output
    return ob_get_clean();
}

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
    error_log('Capabilities check complete for administrator and editor.');
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

// Add Discord button to login form with environment-specific URL
function jotunheim_magic_add_discord_button_to_login() {
    // Load Discord configuration class
    include_once(JOTUNHEIM_PLUGIN_DIR . 'includes/Discord/discord-config.php');
    
    $discord_login_url = Jotunheim_Discord_Config::get_auth_url();
    ?>
    <a href="<?php echo esc_url($discord_login_url); ?>" class="discord-login-button" style="display: inline-block; padding: 10px 20px; background-color: #7289da; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold; text-align: center;">
        Login with Discord
    </a>
    <?php
}
add_action('login_form', 'jotunheim_magic_add_discord_button_to_login');

// Discord login button shortcode - reuses the same button rendering code
function discord_login_button_shortcode($atts) {
    ob_start();
    jotunheim_magic_add_discord_button_to_login();
    return ob_get_clean();
}
add_shortcode('discord_login_button', 'discord_login_button_shortcode');

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
?>