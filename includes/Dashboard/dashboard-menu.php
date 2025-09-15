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
        [
            'title'       => 'EventZone Field Config',
            'menu_title'  => 'EventZone Field Config',
            'slug'        => 'eventzone_field_config',
            'callback'    => 'render_eventzone_field_config_page',
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
            // Save World Seed (optional)
            if (isset($_POST['world_seed'])) {
                update_option('jotunheim_world_seed', sanitize_text_field($_POST['world_seed']));
            }
            
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
    $world_seed = get_option('jotunheim_world_seed', '');
    
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
                            <tr>
                                <th scope="row">World Seed (optional)</th>
                                <td>
                                    <input type="text" name="world_seed" value="<?php echo esc_attr($world_seed); ?>" class="regular-text" placeholder="e.g. 9BCp6a4KQo">
                                    <p class="description">Optional: store your Valheim world seed here so the plugin can deterministically generate weather/wind for your world.</p>
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
        
        <div class="postbox" style="margin-top: 20px;">
            <div class="postbox-header"><h2>🔎 Seed Preview</h2></div>
            <div class="inside">
                <p>Sample weather and wind computed using the saved world seed (<strong><?php echo esc_html($world_seed ?: 'none'); ?></strong>).</p>
                <?php
                // Show a small preview using server-side generator if available
                if (function_exists('\Jotunheim\Utility\getWeathersAt') && function_exists('\Jotunheim\Utility\getGlobalWind')) {
                    echo '<table class="widefat"><thead><tr><th>Day Index</th><th>Wind (angle,int)</th><th>Biome[0]</th><th>Biome[1]</th></tr></thead><tbody>';
                    for ($d = 0; $d < 3; $d++) {
                        $idx = $d * 3600; // sample tick for day
                        $wind = \Jotunheim\Utility\getGlobalWind($idx);
                        $weathers = \Jotunheim\Utility\getWeathersAt($idx);
                        $wa = isset($wind['angle']) ? round($wind['angle']) : 'n/a';
                        $wi = isset($wind['intensity']) ? round($wind['intensity']*100)."%" : 'n/a';
                        $b0 = isset($weathers[0]) ? esc_html($weathers[0]) : 'n/a';
                        $b1 = isset($weathers[1]) ? esc_html($weathers[1]) : 'n/a';
                        echo "<tr><td>{$d}</td><td>{$wa}°, {$wi}</td><td>{$b0}</td><td>{$b1}</td></tr>";
                    }
                    echo '</tbody></table>';
                } else {
                    echo '<p><em>Server-side weather generator not available.</em></p>';
                }
                ?>
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

// EventZone Field Configuration Page
function render_eventzone_field_config_page() {
    global $wpdb;
    
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eventzone_field_config_nonce'])) {
        if (wp_verify_nonce($_POST['eventzone_field_config_nonce'], 'save_eventzone_field_config')) {
            
            // Handle adding new field configuration
            if (isset($_POST['action']) && $_POST['action'] === 'add_field') {
                $field_name = sanitize_text_field($_POST['field_name']);
                $field_type = sanitize_text_field($_POST['field_type']);
                $field_label = sanitize_text_field($_POST['field_label']);
                $field_placeholder = sanitize_text_field($_POST['field_placeholder']);
                $dropdown_options = sanitize_textarea_field($_POST['dropdown_options']);
                $is_conditional = isset($_POST['is_conditional']) ? 1 : 0;
                $conditional_field = sanitize_text_field($_POST['conditional_field']);
                $conditional_value = sanitize_text_field($_POST['conditional_value']);
                
                $existing_config = get_option('jotunheim_eventzone_field_config', []);
                $existing_config[$field_name] = [
                    'type' => $field_type,
                    'label' => $field_label,
                    'placeholder' => $field_placeholder,
                    'dropdown_options' => $dropdown_options,
                    'is_conditional' => $is_conditional,
                    'conditional_field' => $conditional_field,
                    'conditional_value' => $conditional_value
                ];
                
                update_option('jotunheim_eventzone_field_config', $existing_config);
                echo '<div class="updated notice"><p>Field configuration added successfully!</p></div>';
            }
            
            // Handle deleting field configuration
            if (isset($_POST['action']) && $_POST['action'] === 'delete_field') {
                $field_to_delete = sanitize_text_field($_POST['field_to_delete']);
                $existing_config = get_option('jotunheim_eventzone_field_config', []);
                
                if (isset($existing_config[$field_to_delete])) {
                    unset($existing_config[$field_to_delete]);
                    update_option('jotunheim_eventzone_field_config', $existing_config);
                    echo '<div class="updated notice"><p>Field configuration deleted successfully!</p></div>';
                } else {
                    echo '<div class="error notice"><p>Field not found!</p></div>';
                }
            }
        }
    }
    
    // Get current field configurations
    $field_configs = get_option('jotunheim_eventzone_field_config', []);
    
    // Get existing database columns for reference
    $table_name = 'jotun_eventzones';
    $db_columns = [];
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
        $columns = $wpdb->get_results("DESCRIBE $table_name");
        foreach ($columns as $column) {
            $db_columns[] = $column->Field;
        }
    }
    
    ?>
    <div class="wrap">
        <h1>⚙️ EventZone Field Configuration</h1>
        <p>Configure how fields appear in the EventZone add/edit interfaces. This allows you to customize field types, labels, and conditional visibility.</p>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            
            <!-- Add New Field Configuration -->
            <div class="postbox">
                <div class="postbox-header">
                    <h2>➕ Add Field Configuration</h2>
                </div>
                <div class="inside">
                    <form method="POST" action="">
                        <?php wp_nonce_field('save_eventzone_field_config', 'eventzone_field_config_nonce'); ?>
                        <input type="hidden" name="action" value="add_field">
                        
                        <table class="form-table">
                            <tr>
                                <th scope="row">Field Name</th>
                                <td>
                                    <select name="field_name" required>
                                        <option value="">Select Database Field</option>
                                        <?php foreach ($db_columns as $column): ?>
                                            <?php if (!in_array($column, ['id', 'string_name']) && !isset($field_configs[$column])): ?>
                                                <option value="<?php echo esc_attr($column); ?>"><?php echo esc_html($column); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <p class="description">Select a database field that doesn't have configuration yet</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Field Type</th>
                                <td>
                                    <select name="field_type" required>
                                        <option value="text">Text Input</option>
                                        <option value="checkbox">Checkbox</option>
                                        <option value="dropdown">Dropdown</option>
                                        <option value="textarea">Textarea</option>
                                        <option value="number">Number Input</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Display Label</th>
                                <td>
                                    <input type="text" name="field_label" class="regular-text" placeholder="Human-readable label">
                                    <p class="description">Leave empty to auto-generate from field name</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Placeholder Text</th>
                                <td>
                                    <input type="text" name="field_placeholder" class="regular-text" placeholder="Placeholder text">
                                    <p class="description">Only applies to text/number inputs</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Dropdown Options</th>
                                <td>
                                    <textarea name="dropdown_options" rows="4" cols="50" placeholder="Option1&#10;Option2&#10;Option3"></textarea>
                                    <p class="description">One option per line. Only used for dropdown fields.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Conditional Display</th>
                                <td>
                                    <label>
                                        <input type="checkbox" name="is_conditional" value="1"> This field should only show conditionally
                                    </label>
                                </td>
                            </tr>
                            <tr class="conditional-settings" style="display: none;">
                                <th scope="row">Show When</th>
                                <td>
                                    <select name="conditional_field">
                                        <option value="">Select Field</option>
                                        <?php foreach ($db_columns as $column): ?>
                                            <?php if (!in_array($column, ['id', 'string_name'])): ?>
                                                <option value="<?php echo esc_attr($column); ?>"><?php echo esc_html($column); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    equals
                                    <input type="text" name="conditional_value" placeholder="value">
                                </td>
                            </tr>
                        </table>
                        
                        <p class="submit">
                            <input type="submit" class="button-primary" value="Add Field Configuration">
                        </p>
                    </form>
                </div>
            </div>
            
            <!-- Current Field Configurations -->
            <div class="postbox">
                <div class="postbox-header">
                    <h2>📋 Current Field Configurations</h2>
                </div>
                <div class="inside">
                    <?php if (empty($field_configs)): ?>
                        <p><em>No custom field configurations yet. Add some using the form on the left!</em></p>
                    <?php else: ?>
                        <table class="widefat fixed">
                            <thead>
                                <tr>
                                    <th>Field Name</th>
                                    <th>Type</th>
                                    <th>Label</th>
                                    <th>Conditional</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($field_configs as $field_name => $config): ?>
                                    <tr>
                                        <td><code><?php echo esc_html($field_name); ?></code></td>
                                        <td><?php echo esc_html(ucfirst($config['type'])); ?></td>
                                        <td><?php echo esc_html($config['label'] ?: ucfirst(str_replace('_', ' ', $field_name))); ?></td>
                                        <td>
                                            <?php if ($config['is_conditional']): ?>
                                                <span style="color: green;">✓</span> 
                                                <?php echo esc_html($config['conditional_field'] . ' = ' . $config['conditional_value']); ?>
                                            <?php else: ?>
                                                <span style="color: #999;">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this field configuration?');">
                                                <?php wp_nonce_field('save_eventzone_field_config', 'eventzone_field_config_nonce'); ?>
                                                <input type="hidden" name="action" value="delete_field">
                                                <input type="hidden" name="field_to_delete" value="<?php echo esc_attr($field_name); ?>">
                                                <input type="submit" class="button button-small" value="Delete" style="color: red;">
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="postbox">
            <div class="postbox-header">
                <h2>ℹ️ Database Fields Reference</h2>
            </div>
            <div class="inside">
                <p><strong>Available database fields in <?php echo esc_html($table_name); ?>:</strong></p>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px;">
                    <?php foreach ($db_columns as $column): ?>
                        <code style="background: #f0f0f0; padding: 5px; border-radius: 3px; display: block;">
                            <?php echo esc_html($column); ?>
                            <?php if (isset($field_configs[$column])): ?>
                                <span style="color: green; font-weight: bold;"> ✓</span>
                            <?php endif; ?>
                        </code>
                    <?php endforeach; ?>
                </div>
                <p><em>Fields with ✓ already have custom configurations.</em></p>
            </div>
        </div>
        
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const conditionalCheckbox = document.querySelector('input[name="is_conditional"]');
            const conditionalSettings = document.querySelector('.conditional-settings');
            
            conditionalCheckbox.addEventListener('change', function() {
                conditionalSettings.style.display = this.checked ? 'table-row' : 'none';
            });
        });
        </script>
    </div>
    <?php
}

// Hook the menu function to WordPress admin menu
add_action('admin_menu', 'jotunheim_magic_plugin_menu');
?>