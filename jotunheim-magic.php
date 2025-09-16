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

// Define API key for EventZones REST API
if (!defined('EVENTZONES_API_KEY')) {
    define('EVENTZONES_API_KEY', 'jotunheim-magic-api-key-2024');
}

// File: jotunheim-magic.php
require_once(plugin_dir_path(__FILE__) . 'includes/Utility/helpers.php');

// Include Utility files
include_once(plugin_dir_path(__FILE__) . 'includes/Utility/dark-mode.php');
// Include Valheim weather PHP utility (server-side generator)
include_once(plugin_dir_path(__FILE__) . 'includes/Utility/valheim-weather.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Utility/weather-rest.php');

// Enqueue Valheim Weather JavaScript
function jotunheim_magic_enqueue_scripts() {
    $weather_js_path = plugin_dir_path(__FILE__) . 'assets/js/valheim-weather.js';
    $weather_js_url = plugin_dir_url(__FILE__) . 'assets/js/valheim-weather.js';
    $script_version = '1.0.0';
    if (file_exists($weather_js_path)) {
        $script_version = filemtime($weather_js_path);
    }

    wp_enqueue_script(
        'valheim-weather',
        $weather_js_url,
        array(),
        $script_version,
        true
    );
    
    // Localize script to provide ajaxurl for weather configuration
    wp_localize_script('valheim-weather', 'weather_ajax', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'jotunheim_magic_enqueue_scripts');

// AJAX handler for weather configuration
function jotunheim_weather_config_ajax() {
    // Get weather configuration from WordPress options
    $config = array(
        'api_enabled' => get_option('weather_api_enabled', false),
        'api_endpoint' => get_option('weather_api_endpoint', ''),
        'manual_enabled' => get_option('weather_manual_enabled', false),
        'manual_start_day' => intval(get_option('weather_manual_start_day', 1)),
        'manual_start_date' => get_option('weather_manual_start_date', '2025-08-22T00:00'),
        'manual_progression' => get_option('weather_manual_progression', 'game-time'),
        'server_start_date' => get_option('weather_server_start_date', '2025-08-01T19:30')
    );
    
    wp_send_json_success($config);
}
add_action('wp_ajax_get_weather_config', 'jotunheim_weather_config_ajax');
add_action('wp_ajax_nopriv_get_weather_config', 'jotunheim_weather_config_ajax');

// Weather Calculator Shortcode
function jotunheim_weather_calculator_shortcode($atts) {
    // Ensure our weather script is enqueued
    wp_enqueue_script('valheim-weather');
    
    ob_start();
    ?>
    <div id="weatherApp" style="font-family: Arial, sans-serif; background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%); color: #ecf0f1; padding: 20px; border-radius: 10px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);">
        <!-- Weather Calculator will be inserted here by JavaScript -->
    </div>
    
    <script>
    // Initialize weather calculator when document is ready
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof initializeWeatherCalculator === 'function') {
            initializeWeatherCalculator();
        }
    });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('valheim_weather', 'jotunheim_weather_calculator_shortcode');

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

// Include Google Sheets service
include_once(plugin_dir_path(__FILE__) . 'includes/GoogleSheets/google-sheets-service.php');
include_once(plugin_dir_path(__FILE__) . 'includes/GoogleSheets/google-sheets-admin.php');

// Include the Discord OAuth token generation functions
//include_once plugin_dir_path(__FILE__) . 'includes/Discord/discord-oauth-generate-jwt-token.php';

// Include the custom Discord OAuth API endpoint
include_once(plugin_dir_path(__FILE__) . 'includes/Discord/discord-oauth-api.php');

// Include the Discord OAuth handler files
include_once(plugin_dir_path(__FILE__) . 'includes/Discord/discord-oauth-handler.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Discord/discord-role-access.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Discord/discord-auth-config.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Discord/page-permissions.php');

// Include the dashboard config file AFTER Discord functions are loaded
include_once(plugin_dir_path(__FILE__) . 'includes/Dashboard/dashboard-config.php');

// Include the dashboard REST API
include_once(plugin_dir_path(__FILE__) . 'includes/Dashboard/dashboard-rest-api.php');

// Initialize the REST API
global $jotunheim_dashboard_rest_api;
$jotunheim_dashboard_rest_api = new Jotunheim_Dashboard_REST_API();

// Include the dashboard menu file
include_once(plugin_dir_path(__FILE__) . 'includes/Dashboard/dashboard-menu.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Dashboard/dashboard-top.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Dashboard/editor-permissions.php');;

// Include test files
include_once(plugin_dir_path(__FILE__) . 'includes/Test/test-dashboard-page.php');

// Include PrefabList file(s)
include_once(plugin_dir_path(__FILE__) . 'includes/PrefabList/prefabdb-image-import.php');

// Include event zones editor files
include_once(plugin_dir_path(__FILE__) . 'includes/EventZone/eventzones-permission.php');
include_once(plugin_dir_path(__FILE__) . 'includes/EventZone/eventzones-field-generator.php');
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

// Include POS files
include_once(plugin_dir_path(__FILE__) . 'includes/POS/pos-database-utils.php');
include_once(plugin_dir_path(__FILE__) . 'includes/POS/pos-api.php');
include_once(plugin_dir_path(__FILE__) . 'includes/POS/pos-comprehensive-api.php');
include_once(plugin_dir_path(__FILE__) . 'includes/POS/pos-interface.php');
include_once(plugin_dir_path(__FILE__) . 'includes/POS/pos-playerlist-interface.php');
include_once(plugin_dir_path(__FILE__) . 'includes/POS/pos-scripts.php');

// Include UniversalUI components
//require_once plugin_dir_path(__FILE__) . 'includes/UniversalUI/universal-ui-scripts.php';
//require_once plugin_dir_path(__FILE__) . 'includes/UniversalUI/universal-editor-ui.php';
//require_once plugin_dir_path(__FILE__) . 'includes/UniversalUI/universal-add-ui.php';
//if (defined('DOING_AJAX') && DOING_AJAX && isset($_REQUEST['action']) && !in_array($_REQUEST['action'], ['heartbeat', 'wp_ajax_heartbeat'])) {
//    require_once plugin_dir_path(__FILE__) . 'includes/UniversalUI/universal-endpoint-handler.php';
//}

// Include Gallery Submission components
require_once(plugin_dir_path(__FILE__) . 'includes/Gallery/gallery-submission-form.php');
require_once(plugin_dir_path(__FILE__) . 'includes/Gallery/gallery-submission-scripts.php');

// Include Role Management files
include_once(plugin_dir_path(__FILE__) . 'includes/Roles/wiki-editor-role.php');
include_once(plugin_dir_path(__FILE__) . 'includes/Roles/kb-discord-access.php');

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
    jotunheim_magic_create_tables();
    error_log('Plugin activated, capabilities assigned, and tables created.');
}

function jotunheim_magic_create_tables() {
    global $wpdb;
    
    $charset_collate = $wpdb->get_charset_collate();
    
    // Create jotun_playerlist table with enhanced rename tracking
    $table_name = $wpdb->prefix . 'jotun_playerlist';
    $sql = "CREATE TABLE $table_name (
        id int(11) NOT NULL AUTO_INCREMENT,
        playerName varchar(255) NOT NULL,
        activePlayerName varchar(255) NOT NULL,
        steam_id varchar(255) DEFAULT '',
        discord_id varchar(255) DEFAULT '',
        registration_date datetime DEFAULT CURRENT_TIMESTAMP,
        last_rename_date datetime DEFAULT NULL,
        rename_count int(11) DEFAULT 0,
        is_active tinyint(1) DEFAULT 1,
        PRIMARY KEY (id),
        KEY idx_active_name (activePlayerName),
        KEY idx_original_name (playerName)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    
    // Check if we need to add rename columns dynamically
    jotunheim_magic_check_rename_columns($table_name);
    
    error_log('Created/updated table: ' . $table_name);
}

function jotunheim_magic_check_rename_columns($table_name) {
    global $wpdb;
    
    // Get existing columns
    $columns = $wpdb->get_results("DESCRIBE $table_name");
    $existing_columns = array_column($columns, 'Field');
    
    // Check for rename columns and add if needed (up to 10 renames should be enough)
    for ($i = 1; $i <= 10; $i++) {
        $column_name = "playerRename$i";
        if (!in_array($column_name, $existing_columns)) {
            // Only add the first rename column initially, others will be added as needed
            if ($i === 1) {
                $wpdb->query("ALTER TABLE $table_name ADD COLUMN $column_name varchar(255) DEFAULT NULL");
                error_log("Added rename column: $column_name");
            }
            break;
        }
    }
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

// JotunheimMagic class
class JotunheimMagic {
    public function __construct() {
        add_action('admin_menu', array($this, 'setup_admin_menu'));
        
        // This should run after the admin menu is set up
        add_action('admin_init', array($this, 'restrict_admin_access'), 100);
    }

    public function setup_admin_menu() {
        // Setup admin menu logic
    }

    public function restrict_admin_access() {
        if (!current_user_can('jotunheim_magic_access') && !current_user_can('administrator')) {
            // Remove menu pages that require special access
            remove_submenu_page('jotunheim-magic', 'jotunheim-magic-settings');
            remove_submenu_page('jotunheim-magic', 'jotunheim-magic-advanced');
            
            // Check if user is trying to access restricted pages
            global $pagenow;
            if ($pagenow == 'admin.php' && isset($_GET['page'])) {
                $page = $_GET['page'];
                if (in_array($page, array('jotunheim-magic-settings', 'jotunheim-magic-advanced'))) {
                    wp_die(__('Sorry, you are not allowed to access this page.', 'jotunheim-magic'), 403);
                }
            }
        }
    }
}

// Enqueue admin styles for organized menu
function jotunheim_magic_admin_enqueue_styles($hook) {
    // Load admin menu styles on all admin pages to style the sidebar menu
    wp_enqueue_style(
        'jotunheim-admin-menu',
        plugin_dir_url(__FILE__) . 'assets/css/admin-menu.css',
        array(),
        '1.0.0'
    );
}
add_action('admin_enqueue_scripts', 'jotunheim_magic_admin_enqueue_styles');

?>