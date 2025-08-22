<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Function to add the main menu item and submenu items
function jotunheim_magic_plugin_menu() {
    // Main Menu Page for Jotunheim Magic Plugin
    add_menu_page(
        'Jotunheim Magic',              // Page title
        'Jotunheim Magic',              // Menu title in admin sidebar
        'manage_options',               // Capability required (restricted to admins by default)
        'jotunheim_magic',              // Menu slug
        'jotunheim_magic_dashboard',    // Callback function for main page
        'dashicons-hammer',             // Icon URL or Dashicon
        6                               // Position in the menu order
    );

    // Define submenu items and their callback functions
    $submenus = [
        [
            'title'       => 'Prefab Image Import',
            'menu_title'  => 'Prefab Image Import',
            'slug'        => 'prefab_image_import',
            'callback'    => 'render_prefab_image_import_page',
        ],
        [
            'title'       => 'Item List Editor',
            'menu_title'  => 'Item List Editor',
            'slug'        => 'item_list_editor',
            'callback'    => 'render_item_list_editor_page',
        ],
        [
            'title'       => 'Item List Add New Item',
            'menu_title'  => 'Item List Add New Item',
            'slug'        => 'item_list_add_new_item',
            'callback'    => 'render_item_list_add_new_item_page',
        ],
        [
            'title'       => 'Event Zone Editor',
            'menu_title'  => 'Event Zone Editor',
            'slug'        => 'event_zone_editor',
            'callback'    => 'render_event_zone_editor_page',
        ],
        [
            'title'       => 'Add Event Zone',
            'menu_title'  => 'Add Event Zone',
            'slug'        => 'add_event_zone',
            'callback'    => 'render_add_event_zone_page',
        ],
        [
            'title'       => 'Trade',
            'menu_title'  => 'Trade',
            'slug'        => 'trade',
            'callback'    => 'render_trade_page',
        ],
        [
            'title'       => 'Barter',
            'menu_title'  => 'Barter',
            'slug'        => 'barter',
            'callback'    => 'render_barter_page',
        ],
        [
            'title'       => 'Universal UI Table Config',
            'menu_title'  => 'Universal UI Table Config',
            'slug'        => 'universal_ui_table_config',
            'callback'    => 'render_universal_ui_table_config_page',
        ],
        [
            'title'       => 'Point of Sale',
            'menu_title'  => 'Point of Sale',
            'slug'        => 'pos_interface',
            'callback'    => 'render_pos_interface_page',
        ],
        [
            'title'       => 'Weather Calendar Config',
            'menu_title'  => 'Weather Calendar Config',
            'slug'        => 'weather_calendar_config',
            'callback'    => 'render_weather_calendar_config_page',
        ],
    ];

    // Register each submenu
    foreach ($submenus as $submenu) {
        add_submenu_page(
            'jotunheim_magic',   // Parent slug
            $submenu['title'],          // Page title
            $submenu['menu_title'],     // Menu title
            'manage_options',           // Capability required (restricted to admins by default)
            $submenu['slug'],           // Submenu slug
            $submenu['callback']        // Callback function
        );
    }

    // Remove the default submenu created by WordPress
    remove_submenu_page('jotunheim_magic', 'jotunheim_magic');
}

// Main dashboard page for Jotunheim Magic Plugin
function jotunheim_magic_dashboard() {
    echo '<h1>Welcome to Jotunheim Magic Plugin</h1>';
    echo '<p>Use the available tools to manage the plugin functionalities.</p>';
}

// Universal UI Table Config Page
function render_universal_ui_table_config_page() {
    global $wpdb;

    // Fetch all jotun_ tables
    $tables = $wpdb->get_col("SHOW TABLES LIKE 'jotun_%'");

    // Retrieve saved options
    $enabled_tables = get_option('jotunheim_enabled_universal_ui_tables', []);

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['jotun_universal_ui_config_nonce'])) {
        if (wp_verify_nonce($_POST['jotun_universal_ui_config_nonce'], 'save_universal_ui_config')) {
            $enabled_tables = isset($_POST['enabled_tables']) ? array_map('sanitize_text_field', $_POST['enabled_tables']) : [];
            update_option('jotunheim_enabled_universal_ui_tables', $enabled_tables);
            echo '<div class="updated notice"><p>Configuration updated successfully.</p></div>';
        }
    }
    ?>

    <div class="wrap">
        <h1>Universal UI Table Configuration</h1>
        <p>Select which tables should appear in the Universal UI dropdown menu.</p>
        <form method="POST" action="">
            <?php wp_nonce_field('save_universal_ui_config', 'jotun_universal_ui_config_nonce'); ?>
            <table class="widefat fixed" style="max-width: 600px;">
                <thead>
                    <tr>
                        <th>Table Name</th>
                        <th>Include in Universal UI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tables as $table): ?>
                        <tr>
                            <td><?php echo esc_html($table); ?></td>
                            <td>
                                <input type="checkbox" name="enabled_tables[]" value="<?php echo esc_attr($table); ?>"
                                    <?php echo in_array($table, $enabled_tables) ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p>
                <input type="submit" class="button-primary" value="Save Configuration">
            </p>
        </form>
    </div>
    <?php
}

// Helper function to fetch enabled tables
function jotunheim_get_enabled_universal_ui_tables() {
    return get_option('jotunheim_enabled_universal_ui_tables', []);
}

// Prefab Icon Image Import Page
function render_prefab_image_import_page() {
    echo '<h1>Prefab Image Import</h1>';
    echo '<p>Use this tool to import prefab images for the plugin.</p>';
    echo do_shortcode('[prefabdb_image_import]');
}

// ItemList Editor Page
function render_item_list_editor_page() {
    echo '<h1>Item List Editor</h1>';
    echo do_shortcode('[itemlist_editor]');
}

// ItemList Add New Item Page
function render_item_list_add_new_item_page() {
    echo '<h1>Item List Editor</h1>';
    echo do_shortcode('[jotunheim_add_new_item]');
}

// EventZone Editor Page
function render_event_zone_editor_page() {
    echo '<h1>Event Zone Editor</h1>';
    echo do_shortcode('[eventzones_editor]');
}

// Add Event Zone Page
function render_add_event_zone_page() {
    echo '<h1>Add Event Zone</h1>';
    echo do_shortcode('[jotunheim_add_new_zone]');
}

// Trade Page
function render_trade_page() {
    echo '<h1>Trade</h1>';
    echo do_shortcode('[jotunheim_trade_page]');
}

// Barter Page
function render_barter_page() {
    echo '<h1>Barter</h1>';
    echo do_shortcode('[jotunheim_barter_page]');
}

// Point of Sale interface page
function render_pos_interface_page() {
    echo '<div class="wrap">';
    echo '<h1>Point of Sale System</h1>';
    echo do_shortcode('[pos_interface]');
    echo '</div>';
}

// Weather Calendar Configuration Page
function render_weather_calendar_config_page() {
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['weather_config_nonce'])) {
        if (wp_verify_nonce($_POST['weather_config_nonce'], 'save_weather_config')) {
            // Save API settings
            update_option('weather_api_enabled', isset($_POST['api_enabled']));
            update_option('weather_api_endpoint', sanitize_url($_POST['api_endpoint']));
            
            // Save Manual Override settings
            update_option('weather_manual_enabled', isset($_POST['manual_enabled']));
            update_option('weather_manual_start_day', intval($_POST['manual_start_day']));
            update_option('weather_manual_start_date', sanitize_text_field($_POST['manual_start_date']));
            update_option('weather_manual_progression', sanitize_text_field($_POST['manual_progression']));
            
            // Save Server Start Date
            update_option('weather_server_start_date', sanitize_text_field($_POST['server_start_date']));
            
            echo '<div class="updated notice"><p>Weather Calendar configuration updated successfully!</p></div>';
        }
    }
    
    // Get current settings
    $api_enabled = get_option('weather_api_enabled', false);
    $api_endpoint = get_option('weather_api_endpoint', '');
    $manual_enabled = get_option('weather_manual_enabled', false);
    $manual_start_day = get_option('weather_manual_start_day', 1);
    $manual_start_date = get_option('weather_manual_start_date', '2025-08-22T00:00');
    $manual_progression = get_option('weather_manual_progression', 'static');
    $server_start_date = get_option('weather_server_start_date', '2025-08-01T19:30');
    
    ?>
    <div class="wrap">
        <h1>🌦️ Valheim Weather Calendar Configuration</h1>
        <p>Configure how the weather calendar determines the current in-game day. Settings are applied in priority order.</p>
        
        <form method="POST" action="">
            <?php wp_nonce_field('save_weather_config', 'weather_config_nonce'); ?>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 20px; margin-bottom: 20px;">
                
                <!-- API Override Configuration -->
                <div class="postbox">
                    <div class="postbox-header">
                        <h2>🔗 API Override (Priority 1 - Highest)</h2>
                    </div>
                    <div class="inside">
                        <table class="form-table">
                            <tr>
                                <th scope="row">Enable API Override</th>
                                <td>
                                    <input type="checkbox" name="api_enabled" value="1" <?php checked($api_enabled); ?>>
                                    <p class="description">Use external API to get current day</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">API Endpoint URL</th>
                                <td>
                                    <input type="url" name="api_endpoint" value="<?php echo esc_attr($api_endpoint); ?>" 
                                           class="regular-text" placeholder="https://your-api.com/current-day">
                                    <p class="description">API should return JSON: {"currentDay": 123}<br>
                                    <strong>Cached for 4 hours</strong> to reduce API calls</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <!-- Manual Day Override Configuration -->
                <div class="postbox">
                    <div class="postbox-header">
                        <h2>📅 Manual Day Override (Priority 2)</h2>
                    </div>
                    <div class="inside">
                        <table class="form-table">
                            <tr>
                                <th scope="row">Enable Manual Override</th>
                                <td>
                                    <input type="checkbox" name="manual_enabled" value="1" <?php checked($manual_enabled); ?>>
                                    <p class="description">Manually set current in-game day</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Starting In-Game Day</th>
                                <td>
                                    <input type="number" name="manual_start_day" value="<?php echo esc_attr($manual_start_day); ?>" 
                                           min="1" class="small-text">
                                    <p class="description">What day number to start from</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Date/Time for That Day</th>
                                <td>
                                    <input type="datetime-local" name="manual_start_date" value="<?php echo esc_attr($manual_start_date); ?>" 
                                           class="regular-text">
                                    <p class="description">When that day occurred in real time</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Progression Type</th>
                                <td>
                                    <select name="manual_progression">
                                        <option value="static" <?php selected($manual_progression, 'static'); ?>>Static (no progression)</option>
                                        <option value="real-days" <?php selected($manual_progression, 'real-days'); ?>>Real Days (1 real day = 1 game day)</option>
                                        <option value="game-time" <?php selected($manual_progression, 'game-time'); ?>>Game Time (30 min = 1 game day)</option>
                                    </select>
                                    <p class="description">How the day should progress over time</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <!-- Server Start Date Configuration -->
                <div class="postbox">
                    <div class="postbox-header">
                        <h2>🕐 Server Start Date (Priority 3 - Default)</h2>
                    </div>
                    <div class="inside">
                        <table class="form-table">
                            <tr>
                                <th scope="row">Server Start Date</th>
                                <td>
                                    <input type="datetime-local" name="server_start_date" value="<?php echo esc_attr($server_start_date); ?>" 
                                           class="regular-text">
                                    <p class="description">When your Valheim world started (Day 1)<br>
                                    Day counting progresses based on in-game time (30 min = 1 day)</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <p class="submit">
                <input type="submit" class="button-primary" value="Save Configuration">
                <a href="javascript:void(0)" onclick="clearWeatherCache()" class="button">Clear API Cache</a>
            </p>
        </form>
        
        <div class="postbox" style="margin-top: 20px;">
            <div class="postbox-header">
                <h2>📊 Current Status</h2>
            </div>
            <div class="inside">
                <p><strong>Priority System:</strong></p>
                <ol>
                    <li><strong>API Override</strong> - If enabled and working, uses external API data</li>
                    <li><strong>Manual Override</strong> - If enabled, uses your manual day settings</li>
                    <li><strong>Server Start Date</strong> - Default method, calculates from server start</li>
                </ol>
                <p><em>The system automatically falls back to the next priority if a higher one fails.</em></p>
            </div>
        </div>
        
        <script>
        function clearWeatherCache() {
            if (confirm('Clear the weather API cache? This will force a fresh API call on next page load.')) {
                // This would need to be implemented via AJAX if needed
                alert('Cache clearing would be implemented via AJAX call to your API cache clearing function.');
            }
        }
        </script>
    </div>
    <?php
}

// Hook the menu function to WordPress admin menu
add_action('admin_menu', 'jotunheim_magic_plugin_menu');
?>