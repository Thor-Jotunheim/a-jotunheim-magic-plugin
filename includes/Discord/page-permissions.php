<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class JotunheimPagePermissions {
    
    public function __construct() {
        add_action('wp_ajax_save_page_permissions', [$this, 'ajax_save_page_permissions']);
        add_action('wp_ajax_get_page_permissions', [$this, 'ajax_get_page_permissions']);
    }
    
    /**
     * Render the page permissions configuration page
     */
    public function render() {
        // Enqueue scripts and styles
        wp_enqueue_script(
            'page-permissions-js',
            plugin_dir_url(__FILE__) . '../../assets/js/page-permissions.js',
            ['jquery'],
            '1.0.0',
            true
        );
        
        // Localize script with AJAX data
        wp_localize_script('page-permissions-js', 'page_permissions_config', [
            'nonce' => wp_create_nonce('page_permissions_nonce'),
            'ajax_url' => admin_url('admin-ajax.php')
        ]);
        
        // Get Discord roles
        $discord_roles = $this->get_discord_roles();
        
        // Get plugin pages
        $plugin_pages = $this->get_plugin_pages();
        
        // Get current permissions
        $current_permissions = $this->get_page_permissions();
        
        ?>
        <div class="wrap">
            <h1>Page Permissions Configuration</h1>
            <div class="page-permissions-config">
                
                <div class="description">
                    <p>Configure which Discord roles can access specific plugin pages. Check the boxes to grant access to each role.</p>
                </div>
                
                <?php if (empty($discord_roles)): ?>
                    <div class="notice notice-warning">
                        <p><strong>No Discord roles configured.</strong> Please configure Discord roles first in the <a href="<?php echo admin_url('admin.php?page=discord_auth_config'); ?>">Discord Auth Configuration</a> page.</p>
                    </div>
                <?php else: ?>
                    
                    <form id="page-permissions-form">
                        <table class="wp-list-table widefat fixed striped">
                            <thead>
                                <tr>
                                    <th style="width: 300px;"><strong>Plugin Page</strong></th>
                                    <?php foreach ($discord_roles as $role_key => $role_data): ?>
                                        <?php if (!empty($role_data['name']) && !empty($role_data['id'])): ?>
                                            <th style="text-align: center; width: 120px;">
                                                <strong><?php echo esc_html($role_data['name']); ?></strong>
                                                <br><small>ID: <?php echo esc_html($role_data['id']); ?></small>
                                            </th>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($plugin_pages as $page_key => $page_data): ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo esc_html($page_data['title']); ?></strong>
                                            <br><small><?php echo esc_html($page_data['description']); ?></small>
                                            <br><em>Slug: <?php echo esc_html($page_key); ?></em>
                                        </td>
                                        <?php foreach ($discord_roles as $role_key => $role_data): ?>
                                            <?php if (!empty($role_data['name']) && !empty($role_data['id'])): ?>
                                                <td style="text-align: center;">
                                                    <?php 
                                                    $is_checked = isset($current_permissions[$page_key][$role_key]) ? $current_permissions[$page_key][$role_key] : false;
                                                    ?>
                                                    <input 
                                                        type="checkbox" 
                                                        name="permissions[<?php echo esc_attr($page_key); ?>][<?php echo esc_attr($role_key); ?>]"
                                                        value="1"
                                                        <?php checked($is_checked, true); ?>
                                                        class="permission-checkbox"
                                                        data-page="<?php echo esc_attr($page_key); ?>"
                                                        data-role="<?php echo esc_attr($role_key); ?>"
                                                    />
                                                </td>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        
                        <div class="permissions-actions" style="margin-top: 20px;">
                            <button type="button" class="button" id="select-all-permissions">Select All</button>
                            <button type="button" class="button" id="clear-all-permissions">Clear All</button>
                            <button type="button" class="button button-primary" id="save-page-permissions">Save Permissions</button>
                        </div>
                    </form>
                    
                <?php endif; ?>
                
            </div>
        </div>
        <?php
    }
    
    /**
     * Get Discord roles from the auth config
     */
    private function get_discord_roles() {
        $discord_roles = get_option('jotunheim_discord_roles', []);
        
        // Filter out empty roles
        $valid_roles = [];
        foreach ($discord_roles as $key => $role) {
            if (!empty($role['name']) && !empty($role['id'])) {
                $valid_roles[$key] = $role;
            }
        }
        
        return $valid_roles;
    }
    
    /**
     * Get all plugin pages that can have permissions
     * Now dynamically pulls from Dashboard Manager's shortcode detection + hardcoded admin pages
     */
    private function get_plugin_pages() {
        $pages = [];
        
        // First add core admin pages (non-shortcode)
        $admin_pages = [
            'jotunheim_magic' => [
                'title' => 'Overview Dashboard',
                'description' => 'Main dashboard overview page'
            ],
            'dashboard_config' => [
                'title' => 'Dashboard Configuration',
                'description' => 'Configure dashboard layout'
            ],
            'discord_auth_config' => [
                'title' => 'Discord Auth Configuration',
                'description' => 'Configure Discord authentication'
            ],
            'page_permissions_config' => [
                'title' => 'Page Permissions Config',
                'description' => 'Configure Discord role-based page access permissions'
            ],
            'universal_ui_table_config' => [
                'title' => 'Universal UI Table Config',
                'description' => 'Configure UI table settings'
            ],
            'weather_calendar_config' => [
                'title' => 'Weather Calendar Config',
                'description' => 'Configure weather and calendar'
            ],
            'eventzone_field_config' => [
                'title' => 'EventZone Field Config',
                'description' => 'Configure event zone fields'
            ]
        ];
        
        // Add admin pages
        $pages = array_merge($pages, $admin_pages);
        
        // Now dynamically add all detected shortcode pages
        // Use the same predefined shortcodes as Dashboard Manager
        $predefined_shortcodes = [
            'shop_manager' => [
                'title' => 'Shop Manager',
                'description' => 'Manage shop inventory and pricing',
                'category' => 'commerce'
            ],
            'unified_teller' => [
                'title' => 'Unified Teller',
                'description' => 'Point of sale and transaction interface',
                'category' => 'commerce'
            ],
            'itemlist_editor' => [
                'title' => 'Item List Editor',
                'description' => 'Edit and manage game items',
                'category' => 'content'
            ],
            'item_list_editor' => [
                'title' => 'Item List Editor (Alt)',
                'description' => 'Alternative item list editor interface',
                'category' => 'content'
            ],
            'item_list_add_new_item' => [
                'title' => 'Add New Item',
                'description' => 'Add new items to the game',
                'category' => 'content'
            ],
            'eventzones_editor' => [
                'title' => 'Event Zones Editor',
                'description' => 'Edit and manage event zones',
                'category' => 'content'
            ],
            'event_zone_editor' => [
                'title' => 'Event Zone Editor (Alt)',
                'description' => 'Alternative event zone editor interface',
                'category' => 'content'
            ],
            'add_event_zone' => [
                'title' => 'Add Event Zone',
                'description' => 'Create new event zones',
                'category' => 'content'
            ],
            'pos_interface' => [
                'title' => 'Point of Sale Interface',
                'description' => 'POS interface for transactions',
                'category' => 'commerce'
            ],
            'jotunheim_trade_page' => [
                'title' => 'Trade Management',
                'description' => 'Manage trading system',
                'category' => 'commerce'
            ],
            'trade' => [
                'title' => 'Trade System (Alt)',
                'description' => 'Alternative trade system interface',
                'category' => 'commerce'
            ],
            'jotunheim_barter_page' => [
                'title' => 'Barter System',
                'description' => 'Manage barter and exchange system',
                'category' => 'commerce'
            ],
            'barter' => [
                'title' => 'Barter System (Alt)',
                'description' => 'Alternative barter system interface',
                'category' => 'commerce'
            ],
            'universal_editor_ui' => [
                'title' => 'Universal Editor UI',
                'description' => 'Universal content editing interface',
                'category' => 'content'
            ],
            'eventzones_code_output' => [
                'title' => 'Event Zones Code Output',
                'description' => 'Event zone code generation and output',
                'category' => 'utility'
            ],
            'section2_items' => [
                'title' => 'Section 2 Items',
                'description' => 'Manage section 2 item collections',
                'category' => 'content'
            ],
            'prefabdb_image_import' => [
                'title' => 'Prefab Database Image Import',
                'description' => 'Import and manage prefab images',
                'category' => 'content'
            ],
            'prefab_image_import' => [
                'title' => 'Prefab Image Import (Alt)',
                'description' => 'Alternative prefab image import interface',
                'category' => 'content'
            ],
            'valheim_weather' => [
                'title' => 'Valheim Weather System',
                'description' => 'Weather prediction and calendar system',
                'category' => 'utility'
            ],
            'jotunheim_kb' => [
                'title' => 'Knowledge Base',
                'description' => 'Knowledge base and documentation system',
                'category' => 'content'
            ],
            'jotunheim_kb_direct' => [
                'title' => 'Direct Knowledge Base',
                'description' => 'Direct access knowledge base interface',
                'category' => 'content'
            ],
            'popup_shop' => [
                'title' => 'Popup Shop',
                'description' => 'Popup shop interface for quick purchases',
                'category' => 'commerce'
            ],
            'legacy_shop_teller' => [
                'title' => 'Legacy Shop Teller',
                'description' => 'Legacy shop and teller interface',
                'category' => 'commerce'
            ],
            'playerlist_interface' => [
                'title' => 'Player List Interface',
                'description' => 'Manage registered players and user data',
                'category' => 'content'
            ],
            'jotun-playerlist' => [
                'title' => 'Jotun Player List',
                'description' => 'Jotun player list management',
                'category' => 'content'
            ]
        ];
        
        // Only add shortcodes that are actually registered
        foreach ($predefined_shortcodes as $shortcode => $definition) {
            if (shortcode_exists($shortcode)) {
                $pages[$shortcode] = [
                    'title' => $definition['title'],
                    'description' => $definition['description'],
                    'is_shortcode' => true,
                    'registered' => true
                ];
            }
        }
        
        error_log('Jotunheim Page Permissions: Detected ' . count($pages) . ' total pages for permissions');
        error_log('Jotunheim Page Permissions: Admin pages: ' . count($admin_pages));
        error_log('Jotunheim Page Permissions: Shortcode pages: ' . (count($pages) - count($admin_pages)));
        
        return $pages;
    }
    
    /**
     * Get current page permissions
     */
    private function get_page_permissions() {
        return get_option('jotunheim_page_permissions', []);
    }
    
    /**
     * AJAX handler for saving page permissions
     */
    public function ajax_save_page_permissions() {
        try {
            if (!current_user_can('manage_options')) {
                wp_send_json_error('Unauthorized access');
                return;
            }
            
            if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'page_permissions_nonce')) {
                wp_send_json_error('Invalid security token');
                return;
            }
            
            $permissions = isset($_POST['permissions']) ? $_POST['permissions'] : [];
            
            // Sanitize permissions data
            $sanitized_permissions = [];
            foreach ($permissions as $page_key => $roles) {
                $page_key = sanitize_key($page_key);
                foreach ($roles as $role_key => $value) {
                    $role_key = sanitize_key($role_key);
                    $sanitized_permissions[$page_key][$role_key] = (bool) $value;
                }
            }
            
            // Save permissions
            update_option('jotunheim_page_permissions', $sanitized_permissions);
            
            wp_send_json_success('Page permissions saved successfully');
            
        } catch (Exception $e) {
            wp_send_json_error('Unexpected error: ' . $e->getMessage());
        }
    }
    
    /**
     * AJAX handler for getting page permissions
     */
    public function ajax_get_page_permissions() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized access');
            return;
        }
        
        $permissions = $this->get_page_permissions();
        wp_send_json_success($permissions);
    }
    
    /**
     * Check if a user has permission to access a specific page
     */
    public static function user_can_access_page($page_slug, $user_id = null) {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }
        
        // Admins can ALWAYS access everything - don't even check Discord permissions
        if (user_can($user_id, 'manage_options')) {
            return true;
        }
        
        // For now, also allow editors to access everything until Discord integration is fully set up
        if (user_can($user_id, 'edit_posts')) {
            return true;
        }
        
        // Get user's Discord roles (this would need to be implemented based on your Discord integration)
        $user_discord_roles = self::get_user_discord_roles($user_id);
        
        if (empty($user_discord_roles)) {
            return false; // No Discord roles = no access
        }
        
        // Get page permissions
        $page_permissions = get_option('jotunheim_page_permissions', []);
        
        if (!isset($page_permissions[$page_slug])) {
            return false; // Page not configured = no access
        }
        
        // Check if user has any role that grants access to this page
        foreach ($user_discord_roles as $role_key) {
            if (isset($page_permissions[$page_slug][$role_key]) && $page_permissions[$page_slug][$role_key]) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Get user's Discord roles from stored user meta
     */
    private static function get_user_discord_roles($user_id) {
        // Get stored Discord roles from user meta
        $discord_roles = get_user_meta($user_id, 'discord_roles', true);
        
        if (empty($discord_roles) || !is_array($discord_roles)) {
            return [];
        }
        
        // Get configured Discord roles to map IDs to role keys
        $configured_roles = get_configured_discord_roles();
        $user_role_keys = [];
        
        // Map Discord role IDs to our role keys
        foreach ($configured_roles as $role_key => $role_data) {
            if (in_array($role_data['id'], $discord_roles)) {
                $user_role_keys[] = $role_key;
            }
        }
        
        return $user_role_keys;
    }
}

// Helper function for easy permission checking throughout the plugin
function jotunheim_user_can_access_page($page_slug, $user_id = null) {
    return JotunheimPagePermissions::user_can_access_page($page_slug, $user_id);
}

// Function to render the page permissions config page
function render_page_permissions_config_page() {
    $page_permissions = new JotunheimPagePermissions();
    $page_permissions->render();
}

// Initialize the class
new JotunheimPagePermissions();