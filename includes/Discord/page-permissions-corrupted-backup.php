<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class JotunheimPagePermissions {
    
    public function __construct() {
        add_action('wp_ajax_save_page_permissions', [$this, 'ajax_save_page_permissions']);
        add_action('wp_ajax_get_page_permissions', [$this, 'ajax_get_page_permissions']);
        add_action('wp_ajax_scan_new_pages', [$this, 'ajax_scan_new_pages']);
        add_action('wp_ajax_remove_pages', [$this, 'ajax_remove_pages']);
        
        // Add admin capability management
        add_action('init', [$this, 'manage_admin_capabilities'], 1);
    }
    
    /**
     * Manage admin page capabilities based on Discord permissions
     */
    public function manage_admin_capabilities() {
        // Only run in admin area for logged-in users
        if (!is_admin() || !is_user_logged_in()) {
            return;
        }

        $current_user = wp_get_current_user();
        
        // Don't interfere with administrators at all
        if (in_array('administrator', $current_user->roles)) {
            return;
        }
        
        // Only apply to users with editor role (but not administrator)
        if (!in_array('editor', $current_user->roles)) {
            return;
        }

        // Get the current admin page being accessed
        $current_page = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : '';
        
        if (!$current_page) {
            return;
        }

        // Check if user has Discord permission for this admin page
        $user_id = $current_user->ID;
        if (self::user_can_access_page($current_page, $user_id)) {
            // Grant manage_options capability for this specific page
            add_filter('user_has_cap', function($allcaps, $caps, $args, $user) use ($current_user, $current_page) {
                // Only modify capabilities for the current user
                if ($user->ID === $current_user->ID) {
                    // Check if we're requesting manage_options capability
                    if (isset($caps[0]) && $caps[0] === 'manage_options') {
                        $allcaps['manage_options'] = true;
                        error_log("Jotunheim Page Permissions: Granted manage_options to user {$current_user->user_login} for page {$current_page}");
                    }
                }
                return $allcaps;
            }, 10, 4);
        }
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
        
        // Add custom CSS for larger checkboxes
        ?>
        <style>
        .permission-checkbox {
            width: 20px !important;
            height: 20px !important;
            transform: scale(1.5);
            margin: 8px !important;
            cursor: pointer;
        }
        
        .wp-list-table td {
            vertical-align: middle !important;
        }
        
        .page-permissions-config .wp-list-table th {
            text-align: center;
            padding: 15px 8px;
        }
        
        .page-permissions-config .wp-list-table td {
            padding: 15px 8px;
        }
        </style>
        <?php
        
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
                
                <!-- Action buttons at the top -->
                <div class="permissions-actions" style="margin: 20px 0; padding: 15px; background: #f9f9f9; border: 1px solid #ddd;">
                    <button type="button" class="button" id="select-all-permissions">Select All</button>
                    <button type="button" class="button" id="clear-all-permissions">Clear All</button>
                    <button type="button" class="button" id="scan-new-pages">🔍 Scan for New Pages</button>
                    <button type="button" class="button" id="remove-pages">🗑️ Remove Pages</button>
                    <button type="button" class="button button-primary" id="save-page-permissions">Save Permissions</button>
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
                                    <th style="width: 50px;">
                                        <input type="checkbox" id="select-all-pages" title="Select All Pages">
                                    </th>
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
                                        <td style="text-align: center;">
                                            <input type="checkbox" class="page-select-checkbox" value="<?php echo esc_attr($page_key); ?>" name="selected_pages[]">
                                        </td>
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
     * Get currently configured plugin pages for the UI table
     * This only shows pages that are already in the permissions system
     */
    private function get_plugin_pages() {
        $current_permissions = $this->get_page_permissions();
        $configured_page_keys = array_keys($current_permissions);
        
        // Always include admin pages (they should always be visible)
        $admin_pages = $this->get_admin_pages();
        $pages = $admin_pages;
        
        // Add shortcode pages that are configured in permissions
        $all_available = $this->get_all_available_pages();
        foreach ($configured_page_keys as $page_key) {
            if (isset($all_available[$page_key]) && !isset($admin_pages[$page_key])) {
                $pages[$page_key] = $all_available[$page_key];
            }
        }
        
        return $pages;
    }
    
    /**
     * Get all admin pages (always shown)
     */
    private function get_admin_pages() {
        return [
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
    }
    
    /**
     * Get all available pages that CAN have permissions (for scanning)
     * Uses comprehensive detection like Dashboard Manager
     */
    private function get_all_available_pages() {
        global $shortcode_tags;
        
        // Start with admin pages
        $pages = $this->get_admin_pages();
        
        // Use comprehensive shortcode detection like Dashboard Manager
        $predefined_shortcodes = [
            'shop_manager' => [
                'title' => 'Shop Manager',
                'description' => 'Complete shop management interface for all Jotunheim shops'
            ],
            'unified_teller' => [
                'title' => 'Unified Teller',
                'description' => 'Unified point of sale interface for transactions'
            ],
            'legacy_shop_teller' => [
                'title' => 'Legacy Shop Teller',
                'description' => 'Google Sheets replacement shop interface'
            ],
            'pos_interface' => [
                'title' => 'Point of Sale Interface',
                'description' => 'Point of sale system for transaction processing'
            ],
            'itemlist_editor' => [
                'title' => 'Item List Editor',
                'description' => 'Edit and manage game item database'
            ],
            'eventzones_editor' => [
                'title' => 'Event Zones Editor',
                'description' => 'Edit and manage event zones'
            ],
            'eventzones_add_new_zone' => [
                'title' => 'Add New Event Zone',
                'description' => 'Create new event zones'
            ],
            'jotunheim_add_new_zone' => [
                'title' => 'Add New Zone',
                'description' => 'Add new zones to the system'
            ],
            'jotunheim_add_new_item' => [
                'title' => 'Add New Item',
                'description' => 'Add new items to the game database'
            ],
            'jotunheim_item_types' => [
                'title' => 'Item Types Manager',
                'description' => 'Manage item types and price multipliers'
            ],
            'jotunheim_trade_page' => [
                'title' => 'Trade Page',
                'description' => 'Trading interface for players'
            ],
            'jotunheim_barter_page' => [
                'title' => 'Barter Page',
                'description' => 'Barter system interface'
            ],
            'barter' => [
                'title' => 'Barter System (Alt)',
                'description' => 'Alternative barter interface'
            ],
            'jotun_shop_creation' => [
                'title' => 'Shop Creation UI',
                'description' => 'Interface for creating new shops'
            ],
            'universal_editor_ui' => [
                'title' => 'Universal Editor UI',
                'description' => 'Universal editing interface'
            ],
            'universal_add_ui' => [
                'title' => 'Universal Add UI',
                'description' => 'Universal add interface'
            ],
            'eventzones_code_output' => [
                'title' => 'Event Zones Code Output',
                'description' => 'Generate code output for event zones'
            ],
            'eventzone_goto_output' => [
                'title' => 'Event Zone Goto Output',
                'description' => 'Generate goto commands for event zones'
            ],
            'section2_items' => [
                'title' => 'Section 2 Items',
                'description' => 'Display section 2 items from pricelist'
            ],
            'section2and3_items' => [
                'title' => 'Section 2 & 3 Items',
                'description' => 'Display section 2 and 3 items from pricelist'
            ],
            'prefabdb_image_import' => [
                'title' => 'Prefab Image Import',
                'description' => 'Import prefab images into the database'
            ],
            'enhanced_icon_import' => [
                'title' => 'Enhanced Icon Import',
                'description' => 'Import icons from multiple sources (Jotunn, Commands.gg, existing URLs)'
            ],
            'valheim_weather' => [
                'title' => 'Valheim Weather System',
                'description' => 'Weather prediction and calendar system'
            ],
            'jotun-playerlist' => [
                'title' => 'Jotun Player List',
                'description' => 'Player list management and display'
            ]
        ];
        
        // Auto-detect ALL shortcodes, with intelligent filtering (same as dashboard)
        foreach ($shortcode_tags as $shortcode_tag => $callback) {
            // Skip WordPress core shortcodes and common third-party plugin shortcodes
            $skip_patterns = [
                'gallery', 'audio', 'video', 'playlist', 'embed', 'wp_caption', 'caption',
                'contact-form-7', 'cf7', 'gravityform', 'wpforms', 'elementor-template',
                'woocommerce', 'wc_', 'vc_', 'et_pb_', 'fusion_'
            ];
            
            $should_skip = false;
            foreach ($skip_patterns as $pattern) {
                if (strpos($shortcode_tag, $pattern) !== false) {
                    $should_skip = true;
                    break;
                }
            }
            
            // Additional check: skip very short shortcodes (likely core WP)
            if (strlen($shortcode_tag) < 3) {
                $should_skip = true;
            }
            
            if ($should_skip) continue;
            
            // If not already defined, auto-detect ALL remaining shortcodes
            if (!isset($predefined_shortcodes[$shortcode_tag])) {
                // Enhanced detection: include ALL non-core shortcodes, with special handling for plugin shortcodes
                $is_plugin_shortcode = (
                    strpos($shortcode_tag, 'jotun') !== false || 
                    strpos($shortcode_tag, 'eventzones') !== false ||
                    strpos($shortcode_tag, '_editor') !== false ||
                    strpos($shortcode_tag, '_interface') !== false ||
                    strpos($shortcode_tag, '_ui') !== false ||
                    strpos($shortcode_tag, 'section') !== false ||
                    strpos($shortcode_tag, 'shop') !== false ||
                    strpos($shortcode_tag, 'trade') !== false ||
                    strpos($shortcode_tag, 'barter') !== false ||
                    strpos($shortcode_tag, 'prefab') !== false ||
                    strpos($shortcode_tag, 'icon') !== false ||
                    strpos($shortcode_tag, 'import') !== false ||
                    strpos($shortcode_tag, 'enhanced') !== false ||
                    strpos($shortcode_tag, 'weather') !== false ||
                    strpos($shortcode_tag, 'valheim') !== false ||
                    strpos($shortcode_tag, 'pos') !== false ||
                    strpos($shortcode_tag, 'legacy') !== false ||
                    strpos($shortcode_tag, 'unified') !== false ||
                    strpos($shortcode_tag, 'universal') !== false
                );
                
                // For plugin shortcodes, add them automatically
                if ($is_plugin_shortcode) {
                    $predefined_shortcodes[$shortcode_tag] = [
                        'title' => ucwords(str_replace(['_', '-'], ' ', $shortcode_tag)),
                        'description' => 'Plugin shortcode interface (auto-detected)'
                    ];
                } else {
                    // For other shortcodes, add them but mark as third-party
                    $predefined_shortcodes[$shortcode_tag] = [
                        'title' => ucwords(str_replace(['_', '-'], ' ', $shortcode_tag)),
                        'description' => 'Third-party shortcode (auto-detected)'
                    ];
                }
            }
        }
        
        // Add all detected shortcodes to pages (but only if they actually exist)
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
        
        $admin_count = count($this->get_admin_pages());
        $shortcode_count = count($pages) - $admin_count;
        error_log('Jotunheim Page Permissions: Available pages scan - ' . count($pages) . ' total (' . $admin_count . ' admin, ' . $shortcode_count . ' shortcodes)');
        
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
        
        // Auto-detect ALL shortcodes, with intelligent filtering (same as dashboard)
        foreach ($shortcode_tags as $shortcode_tag => $callback) {
            // Skip WordPress core shortcodes and common third-party plugin shortcodes
            $skip_patterns = [
                'gallery', 'audio', 'video', 'playlist', 'embed', 'wp_caption', 'caption',
                'contact-form-7', 'cf7', 'gravityform', 'wpforms', 'elementor-template',
                'woocommerce', 'wc_', 'vc_', 'et_pb_', 'fusion_'
            ];
            
            $should_skip = false;
            foreach ($skip_patterns as $pattern) {
                if (strpos($shortcode_tag, $pattern) !== false) {
                    $should_skip = true;
                    break;
                }
            }
            
            // Additional check: skip very short shortcodes (likely core WP)
            if (strlen($shortcode_tag) < 3) {
                $should_skip = true;
            }
            
            if ($should_skip) continue;
            
            // If not already defined, auto-detect ALL remaining shortcodes
            if (!isset($predefined_shortcodes[$shortcode_tag])) {
                // Enhanced detection: include ALL non-core shortcodes, with special handling for plugin shortcodes
                $is_plugin_shortcode = (
                    strpos($shortcode_tag, 'jotun') !== false || 
                    strpos($shortcode_tag, 'eventzones') !== false ||
                    strpos($shortcode_tag, '_editor') !== false ||
                    strpos($shortcode_tag, '_interface') !== false ||
                    strpos($shortcode_tag, '_ui') !== false ||
                    strpos($shortcode_tag, 'section') !== false ||
                    strpos($shortcode_tag, 'shop') !== false ||
                    strpos($shortcode_tag, 'trade') !== false ||
                    strpos($shortcode_tag, 'barter') !== false ||
                    strpos($shortcode_tag, 'prefab') !== false ||
                    strpos($shortcode_tag, 'icon') !== false ||
                    strpos($shortcode_tag, 'import') !== false ||
                    strpos($shortcode_tag, 'enhanced') !== false ||
                    strpos($shortcode_tag, 'weather') !== false ||
                    strpos($shortcode_tag, 'valheim') !== false ||
                    strpos($shortcode_tag, 'pos') !== false ||
                    strpos($shortcode_tag, 'legacy') !== false ||
                    strpos($shortcode_tag, 'unified') !== false ||
                    strpos($shortcode_tag, 'universal') !== false
                );
                
                // For plugin shortcodes, add them automatically
                if ($is_plugin_shortcode) {
                    $predefined_shortcodes[$shortcode_tag] = [
                        'title' => ucwords(str_replace(['_', '-'], ' ', $shortcode_tag)),
                        'description' => 'Plugin shortcode interface (auto-detected)'
                    ];
                } else {
                    // For other shortcodes, add them but mark as third-party
                    $predefined_shortcodes[$shortcode_tag] = [
                        'title' => ucwords(str_replace(['_', '-'], ' ', $shortcode_tag)),
                        'description' => 'Third-party shortcode (auto-detected)'
                    ];
                }
            }
        }
        
        // Add all detected shortcodes to pages (but only if they actually exist)
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
        
        $admin_count = count($this->get_admin_pages());
        $shortcode_count = count($pages) - $admin_count;
        error_log('Jotunheim Page Permissions: Available pages scan - ' . count($pages) . ' total (' . $admin_count . ' admin, ' . $shortcode_count . ' shortcodes)');
        
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
     * AJAX handler for scanning new pages
     */
    public function ajax_scan_new_pages() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized access');
            return;
        }
        
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'page_permissions_nonce')) {
            wp_send_json_error('Invalid security token');
            return;
        }
        
        // Get currently configured pages
        $current_permissions = $this->get_page_permissions();
        $configured_pages = array_keys($current_permissions);
        
        // Get all available pages (including newly detected ones)
        $all_pages = $this->get_all_available_pages();
        $all_page_keys = array_keys($all_pages);
        
        // Find new pages
        $new_pages = array_diff($all_page_keys, $configured_pages);
        
        if (empty($new_pages)) {
            wp_send_json_success([
                'new_count' => 0,
                'message' => 'No new pages found. All available pages are already configured.',
                'new_pages' => []
            ]);
            return;
        }
        
        // Prepare new pages data
        $new_pages_data = [];
        foreach ($new_pages as $page_key) {
            $new_pages_data[$page_key] = $all_pages[$page_key];
        }
        
        wp_send_json_success([
            'new_count' => count($new_pages),
            'message' => count($new_pages) . ' new page(s) found and ready to configure.',
            'new_pages' => $new_pages_data
        ]);
    }
    
    /**
     * AJAX handler for removing pages
     */
    public function ajax_remove_pages() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized access');
            return;
        }
        
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'page_permissions_nonce')) {
            wp_send_json_error('Invalid security token');
            return;
        }
        
        $pages_to_remove = isset($_POST['pages']) ? (array) $_POST['pages'] : [];
        
        if (empty($pages_to_remove)) {
            wp_send_json_error('No pages selected for removal');
            return;
        }
        
        // Get current permissions
        $current_permissions = $this->get_page_permissions();
        
        // Remove selected pages
        $removed_count = 0;
        foreach ($pages_to_remove as $page_key) {
            if (isset($current_permissions[$page_key])) {
                unset($current_permissions[$page_key]);
                $removed_count++;
            }
        }
        
        // Save updated permissions
        update_option('jotunheim_page_permissions', $current_permissions);
        
        wp_send_json_success([
            'removed_count' => $removed_count,
            'message' => $removed_count . ' page(s) removed from permissions configuration.'
        ]);
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
        
        // Get user's Discord roles from stored metadata
        $user_discord_roles = self::get_user_discord_roles($user_id);
        
        // If user has no Discord roles, check if they have editor role as fallback
        if (empty($user_discord_roles)) {
            // Allow editors access to core Jotunheim pages as fallback
            if (user_can($user_id, 'edit_posts')) {
                $allowed_pages_for_editors = [
                    'jotunheim_magic',
                    'item_list_editor',
                    'eventzones_editor', 
                    'event_zone_editor',
                    'pos_interface',
                    'jotun-playerlist',
                    'jotunheim_barter_page',
                    'barter'
                ];
                return in_array($page_slug, $allowed_pages_for_editors);
            }
            return false; // No Discord roles and not editor = no access
        }
        
        // Get page permissions
        $page_permissions = get_option('jotunheim_page_permissions', []);
        
        if (!isset($page_permissions[$page_slug])) {
            // If page not configured, fall back to WordPress permissions
            error_log("Jotunheim Page Permissions: Page {$page_slug} not configured, checking WordPress fallback permissions for user {$user_id}");
            
            // First check if user has high-level Discord role as fallback
            $high_level_roles = ['norn', 'aesir'];
            foreach ($user_discord_roles as $role_key) {
                if (in_array($role_key, $high_level_roles)) {
                    error_log("Jotunheim Page Permissions: Granting access to unconfigured page {$page_slug} for high-level role {$role_key}");
                    return true;
                }
            }
            
            // Fall back to WordPress capabilities
            // Admin pages should require manage_options
            // Shortcode pages should allow manage_options or edit_posts (editors)
            if (user_can($user_id, 'manage_options')) {
                error_log("Jotunheim Page Permissions: Granting access to unconfigured page {$page_slug} via manage_options capability");
                return true;
            }
            
            // For shortcode pages, also allow editors
            if (user_can($user_id, 'edit_posts')) {
                error_log("Jotunheim Page Permissions: Granting access to unconfigured shortcode {$page_slug} via edit_posts capability");
                return true;
            }
            
            error_log("Jotunheim Page Permissions: Denying access to unconfigured page {$page_slug} - no WordPress fallback permissions");
            return false; // Page not configured and no WordPress permissions = no access
        }
        
        // Check if user has any role that grants access to this page
        foreach ($user_discord_roles as $role_key) {
            if (isset($page_permissions[$page_slug][$role_key]) && $page_permissions[$page_slug][$role_key]) {
                error_log("Jotunheim Page Permissions: Granting access to page {$page_slug} for Discord role {$role_key}");
                return true;
            }
        }
        
        error_log("Jotunheim Page Permissions: Denying access to page {$page_slug} for user {$user_id} with roles: " . implode(', ', $user_discord_roles));
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
        $configured_roles = get_option('jotunheim_discord_roles', []);
        $user_role_keys = [];
        
        // Map Discord role IDs to our role keys
        foreach ($configured_roles as $role_key => $role_data) {
            if (isset($role_data['id']) && in_array($role_data['id'], $discord_roles)) {
                $user_role_keys[] = $role_key;
            }
        }
        
        error_log("Jotunheim Page Permissions: User {$user_id} has Discord role IDs: " . implode(', ', $discord_roles));
        error_log("Jotunheim Page Permissions: Mapped to role keys: " . implode(', ', $user_role_keys));
        
        return $user_role_keys;
    }
}

// Helper function for easy permission checking throughout the plugin
function jotunheim_user_can_access_page($page_slug, $user_id = null) {
    return JotunheimPagePermissions::user_can_access_page($page_slug, $user_id);
}

/**
 * Universal shortcode permission check
 * Use this in all shortcodes to enforce Discord-based permissions
 */
function jotunheim_check_shortcode_permission($shortcode_name, $return_login_button = true) {
    // Check if user is logged in
    if (!is_user_logged_in()) {
        if ($return_login_button) {
            return do_shortcode('[discord_login_button]');
        }
        return '<div class="jotunheim-error">Please log in to access this feature.</div>';
    }
    
    // Check Discord permissions using the page permissions system
    if (!jotunheim_user_can_access_page($shortcode_name)) {
        return '<div class="jotunheim-error">You do not have permission to access this feature. Please contact an administrator if you believe this is an error.</div>';
    }
    
    return null; // Permission granted
}

// Function to render the page permissions config page
function render_page_permissions_config_page() {
    $page_permissions = new JotunheimPagePermissions();
    $page_permissions->render();
}

// Initialize the class
new JotunheimPagePermissions();