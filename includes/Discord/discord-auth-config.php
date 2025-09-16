<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Discord Authentication Configuration System
 * Manages Discord OAuth integration and role-based access control
 */

class JotunheimDiscordAuthConfig {
    
    public function __construct() {
        add_action('wp_ajax_save_discord_roles', [$this, 'ajax_save_discord_roles']);
        add_action('wp_ajax_test_discord_connection', [$this, 'ajax_test_discord_connection']);
        add_action('wp_ajax_save_discord_oauth_settings', [$this, 'ajax_save_discord_oauth_settings']);
        add_action('wp_ajax_add_discord_role', [$this, 'ajax_add_discord_role']);
        add_action('wp_ajax_remove_discord_role', [$this, 'ajax_remove_discord_role']);
        add_action('wp_ajax_get_discord_roles', [$this, 'ajax_get_discord_roles']);
        add_action('wp_ajax_update_discord_role_level', [$this, 'ajax_update_discord_role_level']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }
    
    /**
     * Enqueue admin CSS and JavaScript files for Discord Auth Config
     */
    public function enqueue_admin_assets($hook) {
        // Only load on our Discord Auth Config page
        if ($hook !== 'jotunheim-magic_page_discord_auth_config') {
            return;
        }
        
        // Enqueue CSS
        wp_enqueue_style(
            'discord-auth-config-css',
            plugin_dir_url(__FILE__) . '../../assets/css/discord-auth-config.css',
            [],
            '1.0.0'
        );
        
        // Enqueue JavaScript
        wp_enqueue_script(
            'discord-auth-config-js',
            plugin_dir_url(__FILE__) . '../../assets/js/discord-auth-config.js',
            ['jquery'],
            '1.0.0',
            true
        );
        
        // Localize script with AJAX data
        wp_localize_script('discord-auth-config-js', 'discord_auth_config', [
            'nonce' => wp_create_nonce('discord_auth_config_nonce'),
            'ajaxurl' => admin_url('admin-ajax.php')
        ]);
    }
    
    /**
     * Get Discord role configurations
     */
    public function get_discord_roles() {
        return get_option('jotunheim_discord_roles', $this->get_default_discord_roles());
    }
    
    /**
     * Get default Discord role configurations
     */
    private function get_default_discord_roles() {
        return [
            'norn' => [
                'name' => 'Norn',
                'id' => '',
                'description' => 'Highest administrative role'
            ],
            'aesir' => [
                'name' => 'Aesir',
                'id' => '',
                'description' => 'Senior administrative role'
            ],
            'all_staff' => [
                'name' => 'All Staff',
                'id' => '',
                'description' => 'General staff access role'
            ],
            'admin' => [
                'name' => 'Admin',
                'id' => '816462309274419250',
                'description' => 'Administrator role'
            ],
            'staff' => [
                'name' => 'Staff',
                'id' => '1390490815054221414',
                'description' => 'Staff member role'
            ],
            'valkyrie' => [
                'name' => 'Valkyrie',
                'id' => '963502767173931039',
                'description' => 'Valkyrie team member'
            ],
            'vithar' => [
                'name' => 'Vithar',
                'id' => '1104073178495602751',
                'description' => 'Vithar team member'
            ],
            'chosen' => [
                'name' => 'Chosen',
                'id' => '',
                'description' => 'Special community member role'
            ]
        ];
    }
    
    /**
     * Save Discord role configurations
     */
    public function save_discord_roles($roles) {
        return update_option('jotunheim_discord_roles', $roles);
    }
    
    /**
     * Get Discord OAuth settings
     */
    public function get_discord_oauth_settings() {
        return get_option('jotunheim_discord_oauth_settings', $this->get_default_oauth_settings());
    }
    
    /**
     * Get default Discord OAuth settings
     */
    private function get_default_oauth_settings() {
        return [
            'client_id' => defined('DISCORD_CLIENT_ID') ? DISCORD_CLIENT_ID : '1297908076929613956', // Fallback to wp-config constant
            'client_secret' => defined('DISCORD_CLIENT_SECRET') ? DISCORD_CLIENT_SECRET : 'WzapYHJlj3P0XgwsBC9GATzrSs1kwi4z', // Fallback to wp-config constant
            'redirect_uri' => defined('DISCORD_REDIRECT_URI') ? DISCORD_REDIRECT_URI : 'https://jotun.games/wp-admin/admin-ajax.php?action=oauth2callback', // Fallback to wp-config constant
            'bot_token' => defined('DISCORD_BOT_TOKEN') ? DISCORD_BOT_TOKEN : '',
            'guild_id' => defined('DISCORD_GUILD_ID') ? DISCORD_GUILD_ID : '',
            'enabled' => false,
            'require_discord_auth' => false
        ];
    }
    
    /**
     * Save Discord OAuth settings
     */
    public function save_discord_oauth_settings($settings) {
        return update_option('jotunheim_discord_oauth_settings', $settings);
    }
    
    /**
     * AJAX handler for saving Discord roles
     */
    public function ajax_save_discord_roles() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        if (!wp_verify_nonce($_POST['nonce'], 'discord_auth_config_nonce')) {
            wp_die('Invalid nonce');
        }
        
        if (!isset($_POST['roles']) || !is_array($_POST['roles'])) {
            wp_send_json_error('Invalid roles data');
            return;
        }
        
        $roles = [];
        foreach ($_POST['roles'] as $role_key => $role_data) {
            $roles[sanitize_key($role_key)] = [
                'name' => sanitize_text_field($role_data['name']),
                'id' => sanitize_text_field($role_data['id']),
                'description' => sanitize_text_field($role_data['description'])
            ];
        }
        
        if ($this->save_discord_roles($roles)) {
            wp_send_json_success('Discord roles saved successfully');
        } else {
            wp_send_json_error('Failed to save Discord roles');
        }
    }
    
    /**
     * AJAX handler for saving Discord OAuth settings
     */
    public function ajax_save_discord_oauth_settings() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        if (!wp_verify_nonce($_POST['nonce'], 'discord_auth_config_nonce')) {
            wp_die('Invalid nonce');
        }
        
        if (!isset($_POST['settings']) || !is_array($_POST['settings'])) {
            wp_send_json_error('Invalid settings data');
            return;
        }
        
        $settings = [
            'client_id' => sanitize_text_field($_POST['settings']['client_id']),
            'client_secret' => sanitize_text_field($_POST['settings']['client_secret']),
            'redirect_uri' => esc_url_raw($_POST['settings']['redirect_uri']),
            'bot_token' => sanitize_text_field($_POST['settings']['bot_token']),
            'guild_id' => sanitize_text_field($_POST['settings']['guild_id']),
            'enabled' => isset($_POST['settings']['enabled']) ? (bool)$_POST['settings']['enabled'] : false,
            'require_discord_auth' => isset($_POST['settings']['require_discord_auth']) ? (bool)$_POST['settings']['require_discord_auth'] : false
        ];
        
        if ($this->save_discord_oauth_settings($settings)) {
            wp_send_json_success('Discord OAuth settings saved successfully');
        } else {
            wp_send_json_error('Failed to save Discord OAuth settings');
        }
    }
    
    /**
     * AJAX handler for testing Discord connection
     */
    public function ajax_test_discord_connection() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        if (!wp_verify_nonce($_POST['nonce'], 'discord_auth_config_nonce')) {
            wp_die('Invalid nonce');
        }
        
        $oauth_settings = $this->get_discord_oauth_settings();
        
        // Check if required settings are configured
        if (empty($oauth_settings['bot_token']) || empty($oauth_settings['guild_id'])) {
            wp_send_json_error('Bot token and Guild ID are required for connection testing');
            return;
        }
        
        // Test Discord API connection
        $api_url = 'https://discord.com/api/guilds/' . $oauth_settings['guild_id'];
        $response = wp_remote_get($api_url, [
            'headers' => [
                'Authorization' => 'Bot ' . $oauth_settings['bot_token'],
                'Content-Type' => 'application/json'
            ],
            'timeout' => 10
        ]);
        
        if (is_wp_error($response)) {
            wp_send_json_error('Connection failed: ' . $response->get_error_message());
            return;
        }
        
        $response_code = wp_remote_retrieve_response_code($response);
        if ($response_code === 200) {
            $body = json_decode(wp_remote_retrieve_body($response), true);
            $guild_name = isset($body['name']) ? $body['name'] : 'Unknown Guild';
            wp_send_json_success('Successfully connected to Discord guild: ' . $guild_name);
        } elseif ($response_code === 401) {
            wp_send_json_error('Invalid bot token - check your bot token configuration');
        } elseif ($response_code === 403) {
            wp_send_json_error('Bot does not have access to the specified guild');
        } else {
            wp_send_json_error('Connection failed with status code: ' . $response_code);
        }
    }
    
    /**
     * AJAX handler for adding a Discord role
     */
    public function ajax_add_discord_role() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        if (!wp_verify_nonce($_POST['nonce'], 'discord_auth_config_nonce')) {
            wp_die('Invalid nonce');
        }
        
        $role_name = sanitize_text_field($_POST['role_name']);
        $role_id = sanitize_text_field($_POST['role_id']);
        $role_level = intval($_POST['role_level']);
        
        if (empty($role_name) || empty($role_id)) {
            wp_send_json_error('Role name and ID are required');
            return;
        }
        
        $roles = $this->get_discord_roles();
        $role_key = sanitize_key($role_name);
        
        $roles[$role_key] = [
            'name' => $role_name,
            'id' => $role_id,
            'level' => $role_level,
            'description' => 'Added via configuration'
        ];
        
        if ($this->save_discord_roles($roles)) {
            wp_send_json_success('Role added successfully');
        } else {
            wp_send_json_error('Failed to add role');
        }
    }
    
    /**
     * AJAX handler for removing a Discord role
     */
    public function ajax_remove_discord_role() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        if (!wp_verify_nonce($_POST['nonce'], 'discord_auth_config_nonce')) {
            wp_die('Invalid nonce');
        }
        
        $role_id = sanitize_text_field($_POST['role_id']);
        if (empty($role_id)) {
            wp_send_json_error('Role ID is required');
            return;
        }
        
        $roles = $this->get_discord_roles();
        
        // Find and remove the role by ID
        foreach ($roles as $key => $role) {
            if ($role['id'] === $role_id) {
                unset($roles[$key]);
                break;
            }
        }
        
        if ($this->save_discord_roles($roles)) {
            wp_send_json_success('Role removed successfully');
        } else {
            wp_send_json_error('Failed to remove role');
        }
    }
    
    /**
     * AJAX handler for getting Discord roles
     */
    public function ajax_get_discord_roles() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        if (!wp_verify_nonce($_POST['nonce'], 'discord_auth_config_nonce')) {
            wp_die('Invalid nonce');
        }
        
        $roles = $this->get_discord_roles();
        $formatted_roles = [];
        
        foreach ($roles as $role) {
            $formatted_roles[] = [
                'name' => $role['name'],
                'id' => $role['id'],
                'level' => isset($role['level']) ? $role['level'] : 1
            ];
        }
        
        wp_send_json_success($formatted_roles);
    }
    
    /**
     * AJAX handler for updating Discord role level
     */
    public function ajax_update_discord_role_level() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        if (!wp_verify_nonce($_POST['nonce'], 'discord_auth_config_nonce')) {
            wp_die('Invalid nonce');
        }
        
        $role_id = sanitize_text_field($_POST['role_id']);
        $role_level = intval($_POST['role_level']);
        
        if (empty($role_id)) {
            wp_send_json_error('Role ID is required');
            return;
        }
        
        $roles = $this->get_discord_roles();
        
        // Find and update the role by ID
        foreach ($roles as $key => $role) {
            if ($role['id'] === $role_id) {
                $roles[$key]['level'] = $role_level;
                break;
            }
        }
        
        if ($this->save_discord_roles($roles)) {
            wp_send_json_success('Role level updated successfully');
        } else {
            wp_send_json_error('Failed to update role level');
        }
    }
}

// Initialize the Discord auth config system
global $jotunheim_discord_auth_config;
$jotunheim_discord_auth_config = new JotunheimDiscordAuthConfig();

/**
 * Render the Discord Authentication Configuration page
 */
function render_discord_auth_config_page() {
    global $jotunheim_discord_auth_config;
    
    $discord_roles = $jotunheim_discord_auth_config->get_discord_roles();
    $oauth_settings = $jotunheim_discord_auth_config->get_discord_oauth_settings();
    ?>
    
    <div class="wrap">
        <div class="discord-auth-config-wrap">
            <h1>Discord Authentication Configuration</h1>
            <p class="description">Configure Discord OAuth integration and role-based access control for your server.</p>
            
            <!-- Discord OAuth Settings -->
            <div class="discord-oauth-section">
                <h2>Discord OAuth Settings</h2>
                <p class="description">Configure your Discord application settings for OAuth integration.</p>
                
                <form id="discord-oauth-form">
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="discord_client_id">Client ID</label>
                            </th>
                            <td>
                                <input type="text" id="discord_client_id" name="client_id" value="<?php echo esc_attr($oauth_settings['client_id']); ?>" class="regular-text" />
                                <p class="description">Your Discord application's Client ID</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="discord_client_secret">Client Secret</label>
                            </th>
                            <td>
                                <input type="password" id="discord_client_secret" name="client_secret" value="<?php echo esc_attr($oauth_settings['client_secret']); ?>" class="regular-text" />
                                <p class="description">Your Discord application's Client Secret</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="discord_redirect_uri">Redirect URI</label>
                            </th>
                            <td>
                                <input type="url" id="discord_redirect_uri" name="redirect_uri" value="<?php echo esc_attr($oauth_settings['redirect_uri']); ?>" class="regular-text" />
                                <p class="description">The redirect URI configured in your Discord application</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="discord_bot_token">Bot Token</label>
                            </th>
                            <td>
                                <input type="password" id="discord_bot_token" name="bot_token" value="<?php echo esc_attr($oauth_settings['bot_token']); ?>" class="regular-text" />
                                <p class="description">Your Discord bot's token (required for role fetching)</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="discord_guild_id">Guild ID (Server ID)</label>
                            </th>
                            <td>
                                <input type="text" id="discord_guild_id" name="guild_id" value="<?php echo esc_attr($oauth_settings['guild_id']); ?>" class="regular-text" />
                                <p class="description">Your Discord server's Guild ID</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Enable Discord OAuth</th>
                            <td>
                                <label>
                                    <input type="checkbox" id="discord_enabled" name="enabled" <?php checked($oauth_settings['enabled']); ?> />
                                    Enable Discord OAuth integration
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Require Discord Authentication</th>
                            <td>
                                <label>
                                    <input type="checkbox" id="discord_require_auth" name="require_discord_auth" <?php checked($oauth_settings['require_discord_auth']); ?> />
                                    Require Discord authentication for access
                                </label>
                            </td>
                        </tr>
                    </table>
                    
                    <p class="submit">
                        <button type="button" class="button button-primary" id="save-discord-oauth">Save OAuth Settings</button>
                        <button type="button" class="button" id="test-discord-connection">Test Connection</button>
                    </p>
                    
                    <div id="test-result" class="notice" style="display: none; margin-top: 10px; padding: 10px;">
                        <p></p>
                    </div>
                </form>
            </div>
            
            <!-- Discord Role Permissions -->
            <div class="discord-permissions-section">
                <h2>Discord Role Permissions</h2>
                <p class="description">Configure Discord role IDs for access control. Leave ID empty to disable a role.</p>
                
                <div class="discord-roles-container">
                    <?php foreach ($discord_roles as $role_key => $role_data): ?>
                        <div class="discord-role-item">
                            <div class="role-info">
                                <label for="discord_role_<?php echo esc_attr($role_key); ?>">
                                    <strong><?php echo esc_html($role_data['name']); ?></strong>
                                </label>
                                <p class="role-description"><?php echo esc_html($role_data['description']); ?></p>
                            </div>
                            <div class="role-input">
                                <input 
                                    type="text" 
                                    id="discord_role_<?php echo esc_attr($role_key); ?>"
                                    name="discord_roles[<?php echo esc_attr($role_key); ?>][id]"
                                    value="<?php echo esc_attr($role_data['id']); ?>"
                                    placeholder="Discord Role ID"
                                    class="discord-role-id-input"
                                />
                                <input 
                                    type="hidden" 
                                    name="discord_roles[<?php echo esc_attr($role_key); ?>][name]"
                                    value="<?php echo esc_attr($role_data['name']); ?>"
                                />
                                <input 
                                    type="hidden" 
                                    name="discord_roles[<?php echo esc_attr($role_key); ?>][description]"
                                    value="<?php echo esc_attr($role_data['description']); ?>"
                                />
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="discord-permissions-actions">
                    <button type="button" class="button button-primary" id="save-discord-roles">
                        Save Discord Roles
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <?php
}
?>