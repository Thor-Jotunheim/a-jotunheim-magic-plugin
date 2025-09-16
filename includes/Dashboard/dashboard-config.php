<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Dashboard Menu Configuration System
 * Allows users to reorganize menu items, create sections, and customize the admin dashboard
 */

class JotunheimDashboardConfig {
    
    private $default_menu_items = [];
    private $menu_config = [];
    
    public function __construct() {
        // Initialize immediately instead of waiting for admin_init
        $this->init();
        
        add_action('wp_ajax_save_dashboard_config', [$this, 'save_dashboard_config']);
        add_action('wp_ajax_reset_dashboard_config', [$this, 'reset_dashboard_config']);
        add_action('wp_ajax_save_discord_roles', [$this, 'ajax_save_discord_roles']);
        add_action('wp_ajax_test_discord_connection', [$this, 'ajax_test_discord_connection']);
        add_action('wp_ajax_get_available_pages', [$this, 'ajax_get_available_pages']);
        add_action('wp_ajax_add_custom_page', [$this, 'ajax_add_custom_page']);
        
        // TEMPORARY: Force config reset for debugging (DISABLED after fixing duplicates)
        // delete_option('jotunheim_dashboard_config');
        // error_log('Jotunheim Dashboard: Forced config reset to clear any legacy dashboard overview items');
    }
    
    public function init() {
        error_log('Jotunheim Dashboard: Starting init()');
        $this->load_default_menu_items();
        
        // Check for reset parameter (for easy config regeneration)
        if (isset($_GET['reset_dashboard_config']) && $_GET['reset_dashboard_config'] === '1' && current_user_can('manage_options')) {
            delete_option('jotunheim_dashboard_config');
            error_log('Jotunheim Dashboard: Config reset via URL parameter');
        }
        
        // Get existing config or create default
        $stored_config = get_option('jotunheim_dashboard_config', false);
        
        if (!$stored_config) {
            // No config exists, create and save default
            error_log('Jotunheim Dashboard: No stored config, creating default');
            $this->menu_config = $this->get_default_config();
            update_option('jotunheim_dashboard_config', $this->menu_config);
            error_log('Jotunheim Dashboard: Created and saved default config');
        } else {
            $this->menu_config = $stored_config;
        }
        
        // Ensure config has required structure
        if (!isset($this->menu_config['sections']) || !isset($this->menu_config['items'])) {
            error_log('Jotunheim Dashboard: Invalid stored config, resetting to default');
            $this->menu_config = $this->get_default_config();
            update_option('jotunheim_dashboard_config', $this->menu_config);
        }
        
        error_log('Jotunheim Dashboard: Config ready with ' . count($this->menu_config['sections']) . ' sections and ' . count($this->menu_config['items']) . ' items');
    }
    
    private function load_default_menu_items() {
        $this->default_menu_items = [
            // Core Management
            [
                'id' => 'prefab_image_import',
                'title' => 'Prefab Image Import',
                'menu_title' => 'Prefab Image Import',
                'callback' => 'render_prefab_image_import_page',
                'category' => 'core',
                'description' => 'Import and manage prefab images',
                'quick_action' => false
            ],
            [
                'id' => 'item_list_editor',
                'title' => 'Item List Editor',
                'menu_title' => 'Item List Editor',
                'callback' => 'render_item_list_editor_page',
                'category' => 'items',
                'description' => 'Edit and manage game items',
                'quick_action' => true
            ],
            [
                'id' => 'item_list_add_new_item',
                'title' => 'Item List Add New Item',
                'menu_title' => 'Add New Item',
                'callback' => 'render_item_list_add_new_item_page',
                'category' => 'items',
                'description' => 'Add new items to the game',
                'quick_action' => false
            ],
            
            // Event Management
            [
                'id' => 'event_zone_editor',
                'title' => 'Event Zone Editor',
                'menu_title' => 'Event Zone Editor',
                'callback' => 'render_event_zone_editor_page',
                'category' => 'events',
                'description' => 'Edit and manage event zones',
                'quick_action' => true
            ],
            [
                'id' => 'add_event_zone',
                'title' => 'Add Event Zone',
                'menu_title' => 'Add Event Zone',
                'callback' => 'render_add_event_zone_page',
                'category' => 'events',
                'description' => 'Create new event zones',
                'quick_action' => false
            ],
            [
                'id' => 'eventzone_field_config',
                'title' => 'EventZone Field Config',
                'menu_title' => 'EventZone Field Config',
                'callback' => 'render_eventzone_field_config_page',
                'category' => 'events',
                'description' => 'Configure event zone fields',
                'quick_action' => false
            ],
            
            // Commerce & Trading
            [
                'id' => 'trade',
                'title' => 'Trade',
                'menu_title' => 'Trade',
                'callback' => 'render_trade_page',
                'category' => 'commerce',
                'description' => 'Manage trading systems',
                'quick_action' => false
            ],
            [
                'id' => 'barter',
                'title' => 'Barter',
                'menu_title' => 'Barter',
                'callback' => 'render_barter_page',
                'category' => 'commerce',
                'description' => 'Manage bartering systems',
                'quick_action' => false
            ],
            [
                'id' => 'pos_interface',
                'title' => 'Point of Sale',
                'menu_title' => 'Point of Sale',
                'callback' => 'render_pos_interface_page',
                'category' => 'commerce',
                'description' => 'Point of sale transaction system',
                'quick_action' => true
            ],
            [
                'id' => 'jotun-playerlist',
                'title' => 'Player List Management',
                'menu_title' => 'Player List',
                'callback' => 'jotun_playerlist_interface',
                'category' => 'commerce',
                'description' => 'Manage registered players and customer database',
                'quick_action' => false
            ],
            
            // System Configuration
            [
                'id' => 'dashboard_config',
                'title' => 'Dashboard Configuration',
                'menu_title' => 'Dashboard Config',
                'callback' => 'render_dashboard_config_page',
                'category' => 'system',
                'description' => 'Configure dashboard layout and organization',
                'quick_action' => false
            ],
            [
                'id' => 'discord_auth_config',
                'title' => 'Discord Auth Configuration',
                'menu_title' => 'Discord Auth Config',
                'callback' => 'render_discord_auth_config_page',
                'category' => 'system',
                'description' => 'Configure Discord OAuth and role permissions',
                'quick_action' => false
            ],
            [
                'id' => 'universal_ui_table_config',
                'title' => 'Universal UI Table Config',
                'menu_title' => 'Universal UI Config',
                'callback' => 'render_universal_ui_table_config_page',
                'category' => 'system',
                'description' => 'Configure universal UI table settings',
                'quick_action' => false
            ],
            [
                'id' => 'weather_calendar_config',
                'title' => 'Weather Calendar Config',
                'menu_title' => 'Weather Calendar',
                'callback' => 'render_weather_calendar_config_page',
                'category' => 'system',
                'description' => 'Configure weather calendar settings',
                'quick_action' => false
            ]
        ];
    }
    
    /**
     * Auto-detect available plugin pages by scanning render functions
     */
    public function get_available_plugin_pages() {
        $available_pages = [];
        
        // Scan for functions that match render_*_page pattern
        $functions = get_defined_functions()['user'];
        
        foreach ($functions as $function) {
            if (preg_match('/^render_(.+)_page$/', $function, $matches)) {
                $page_id = $matches[1];
                $page_title = ucwords(str_replace('_', ' ', $page_id));
                
                // Skip if already in our default menu items
                $exists = false;
                foreach ($this->default_menu_items as $item) {
                    if ($item['id'] === $page_id) {
                        $exists = true;
                        break;
                    }
                }
                
                if (!$exists) {
                    $available_pages[] = [
                        'id' => $page_id,
                        'title' => $page_title,
                        'menu_title' => $page_title,
                        'callback' => $function,
                        'category' => 'discovered',
                        'description' => 'Auto-detected plugin page'
                    ];
                }
            }
        }
        
        // Also scan includes directory for PHP files that might contain page renders
        $plugin_dir = plugin_dir_path(__FILE__) . '../';
        $this->scan_directory_for_pages($plugin_dir, $available_pages);
        
        return $available_pages;
    }
    
    /**
     * Recursively scan directory for potential page files
     */
    private function scan_directory_for_pages($dir, &$available_pages) {
        if (!is_dir($dir)) return;
        
        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;
            
            $full_path = $dir . $file;
            
            if (is_dir($full_path)) {
                // Recursively scan subdirectories
                $this->scan_directory_for_pages($full_path . '/', $available_pages);
            } elseif (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                // Check if this file contains a render function
                $content = file_get_contents($full_path);
                if (preg_match_all('/function\s+(render_[a-zA-Z_]+_page)\s*\(/', $content, $matches)) {
                    foreach ($matches[1] as $function_name) {
                        $page_id = preg_replace('/^render_(.+)_page$/', '$1', $function_name);
                        $page_title = ucwords(str_replace('_', ' ', $page_id));
                        
                        // Check if already exists
                        $exists = false;
                        foreach ($this->default_menu_items as $item) {
                            if ($item['id'] === $page_id) {
                                $exists = true;
                                break;
                            }
                        }
                        
                        foreach ($available_pages as $existing) {
                            if ($existing['id'] === $page_id) {
                                $exists = true;
                                break;
                            }
                        }
                        
                        if (!$exists) {
                            $available_pages[] = [
                                'id' => $page_id,
                                'title' => $page_title,
                                'menu_title' => $page_title,
                                'callback' => $function_name,
                                'category' => 'discovered',
                                'description' => 'Auto-detected from ' . basename($file),
                                'file_path' => $full_path
                            ];
                        }
                    }
                }
            }
        }
    }
    
    private function get_default_config() {
        return [
            'sections' => [
                [
                    'id' => 'core',
                    'title' => 'Core Management',
                    'description' => 'Essential game management tools',
                    'icon' => 'dashicons-admin-settings',
                    'order' => 1,
                    'enabled' => true
                ],
                [
                    'id' => 'items',
                    'title' => 'Item Management',
                    'description' => 'Manage game items and inventory',
                    'icon' => 'dashicons-products',
                    'order' => 2,
                    'enabled' => true
                ],
                [
                    'id' => 'events',
                    'title' => 'Event Management',
                    'description' => 'Create and manage game events',
                    'icon' => 'dashicons-calendar-alt',
                    'order' => 3,
                    'enabled' => true
                ],
                [
                    'id' => 'commerce',
                    'title' => 'Commerce & Trading',
                    'description' => 'Player shops, trading, and transactions',
                    'icon' => 'dashicons-money-alt',
                    'order' => 4,
                    'enabled' => true
                ],
                [
                    'id' => 'system',
                    'title' => 'System Configuration',
                    'description' => 'Advanced system settings and configuration',
                    'icon' => 'dashicons-admin-tools',
                    'order' => 5,
                    'enabled' => true
                ]
            ],
            'items' => $this->get_default_item_assignments()
        ];
    }
    
    private function get_default_item_assignments() {
        error_log('Jotunheim Dashboard: Creating default item assignments from ' . count($this->default_menu_items) . ' menu items');
        $assignments = [];
        foreach ($this->default_menu_items as $index => $item) {
            $assignments[] = [
                'id' => $item['id'],
                'section' => $item['category'],
                'order' => $index + 1,
                'enabled' => true
            ];
        }
        error_log('Jotunheim Dashboard: Created ' . count($assignments) . ' item assignments');
        return $assignments;
    }
    
    public function get_menu_items() {
        return $this->default_menu_items;
    }
    
    public function get_config() {
        return $this->menu_config;
    }
    
    public function get_organized_menu() {
        $organized = [];
        $config = $this->get_config();
        
        // Get enabled sections sorted by order
        $sections = $config['sections'];
        usort($sections, function($a, $b) {
            return $a['order'] <=> $b['order'];
        });
        
        foreach ($sections as $section) {
            if (!$section['enabled']) continue;
            
            $organized[$section['id']] = [
                'title' => $section['title'],
                'description' => $section['description'],
                'icon' => $section['icon'],
                'items' => []
            ];
        }
        
        // Get items sorted by order within each section
        $items = $config['items'];
        usort($items, function($a, $b) {
            return $a['order'] <=> $b['order'];
        });
        
        foreach ($items as $item_config) {
            if (!$item_config['enabled']) continue;
            
            $item = $this->find_menu_item($item_config['id']);
            if ($item && isset($organized[$item_config['section']])) {
                $organized[$item_config['section']]['items'][] = $item;
            }
        }
        
        return $organized;
    }
    
    private function find_menu_item($id) {
        foreach ($this->default_menu_items as $item) {
            if ($item['id'] === $id) {
                return $item;
            }
        }
        return null;
    }
    
    public function save_dashboard_config() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        if (!wp_verify_nonce($_POST['nonce'], 'dashboard_config_nonce')) {
            wp_die('Invalid nonce');
        }
        
        // Handle organized menu toggle
        if (isset($_POST['use_organized_menu'])) {
            update_option('jotunheim_use_organized_menu', (bool)$_POST['use_organized_menu']);
            wp_send_json_success('Menu mode updated successfully');
            return;
        }
        
        // Handle full configuration save
        $config = [
            'sections' => json_decode(stripslashes($_POST['sections']), true),
            'items' => json_decode(stripslashes($_POST['items']), true)
        ];
        
        update_option('jotunheim_dashboard_config', $config);
        
        wp_send_json_success('Configuration saved successfully');
    }
    
    public function reset_dashboard_config() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        if (!wp_verify_nonce($_POST['nonce'], 'dashboard_config_nonce')) {
            wp_die('Invalid nonce');
        }
        
        delete_option('jotunheim_dashboard_config');
        $this->menu_config = $this->get_default_config();
        
        wp_send_json_success('Configuration reset to defaults');
    }
    
    /**
     * AJAX handler for saving Discord roles
     */
    public function ajax_save_discord_roles() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        if (!wp_verify_nonce($_POST['nonce'], 'dashboard_config_nonce')) {
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
     * AJAX handler for testing Discord connection
     */
    public function ajax_test_discord_connection() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        if (!wp_verify_nonce($_POST['nonce'], 'dashboard_config_nonce')) {
            wp_die('Invalid nonce');
        }
        
        // Test Discord connection by checking if Discord OAuth is available
        if (function_exists('jotunheim_magic_discord_oauth_handler')) {
            wp_send_json_success('Discord OAuth integration is available');
        } else {
            wp_send_json_error('Discord OAuth integration not found');
        }
    }
    
    /**
     * AJAX handler to get available plugin pages
     */
    public function ajax_get_available_pages() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        if (!wp_verify_nonce($_POST['nonce'], 'dashboard_config_nonce')) {
            wp_die('Invalid nonce');
        }
        
        $available_pages = $this->get_available_plugin_pages();
        wp_send_json_success($available_pages);
    }
    
    /**
     * AJAX handler to add a custom page to the dashboard
     */
    public function ajax_add_custom_page() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        if (!wp_verify_nonce($_POST['nonce'], 'dashboard_config_nonce')) {
            wp_die('Invalid nonce');
        }
        
        $page_data = $_POST['page_data'];
        
        // Validate required fields
        if (empty($page_data['id']) || empty($page_data['title']) || empty($page_data['callback'])) {
            wp_send_json_error('Missing required fields');
            return;
        }
        
        // Sanitize input
        $new_page = [
            'id' => sanitize_key($page_data['id']),
            'title' => sanitize_text_field($page_data['title']),
            'menu_title' => sanitize_text_field($page_data['menu_title'] ?: $page_data['title']),
            'callback' => sanitize_text_field($page_data['callback']),
            'category' => sanitize_text_field($page_data['category'] ?: 'custom'),
            'description' => sanitize_text_field($page_data['description'] ?: 'Custom added page'),
            'quick_action' => (bool)($page_data['quick_action'] ?: false)
        ];
        
        // Check if page already exists
        foreach ($this->get_menu_items() as $existing) {
            if ($existing['id'] === $new_page['id']) {
                wp_send_json_error('Page with this ID already exists');
                return;
            }
        }
        
        // Add to config
        $config = $this->get_config();
        $config['items'][] = $new_page;
        
        if (update_option('jotunheim_dashboard_config', $config)) {
            wp_send_json_success($new_page);
        } else {
            wp_send_json_error('Failed to save configuration');
        }
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
     * Add Discord role permissions section to config page
     */
    public function render_discord_permissions_section() {
        $discord_roles = $this->get_discord_roles();
        ?>
        
        <div class="discord-permissions-section">
            <h3>Discord Role Permissions</h3>
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
                <button type="button" class="button" id="test-discord-connection">
                    Test Discord Connection
                </button>
            </div>
        </div>
        
        <?php
    }
}

// Initialize the dashboard config system
global $jotunheim_dashboard_config;
$jotunheim_dashboard_config = new JotunheimDashboardConfig();

/**
 * Render the dashboard configuration page
 */
function render_dashboard_config_page() {
    global $jotunheim_dashboard_config;
    
    $menu_items = $jotunheim_dashboard_config->get_menu_items();
    $config = $jotunheim_dashboard_config->get_config();
    
    // Enqueue necessary scripts and styles
    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script('dashboard-config-js', plugin_dir_url(__FILE__) . '../../assets/js/dashboard-config.js', ['jquery', 'jquery-ui-sortable'], '1.0.0', true);
    wp_enqueue_style('dashboard-config-css', plugin_dir_url(__FILE__) . '../../assets/css/dashboard-config.css', [], '1.0.0');

    wp_localize_script('dashboard-config-js', 'dashboardConfig', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('dashboard_config_nonce'),
        'config' => $config,
        'menuItems' => $menu_items
    ]);
    
    // Force remove top spacing with aggressive CSS and JavaScript
    ?>
    <style>
    /* Aggressive top spacing removal */
    body.wp-admin #wpwrap {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }
    
    body.wp-admin #wpcontent {
        padding-left: 0;
        margin-top: 0 !important;
        padding-top: 0 !important;
    }
    
    body.wp-admin #wpbody {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }
    
    body.wp-admin #wpbody-content {
        padding-top: 0 !important;
        margin-top: 0 !important;
    }
    
    /* Hide and reset screen meta (options dropdown) that might cause spacing */
    #screen-meta,
    #screen-meta-links {
        display: none !important;
        margin-top: 0 !important;
        height: 0 !important;
    }
    
    /* Remove admin bar spacing */
    html.wp-toolbar {
        padding-top: 0 !important;
    }
    
    body.wp-admin {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }
    
    /* Target the specific dashboard config wrapper */
    .dashboard-config-wrap {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }
    
    body.wp-admin .wrap.dashboard-config-wrap,
    body.wp-admin .dashboard-config-wrap,
    #wpbody-content .dashboard-config-wrap,
    .wp-admin #wpbody-content .wrap {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }
    
    /* Remove any admin notices that cause spacing */
    .notice, .update-nag, .updated, .error, .is-dismissible {
        display: none !important;
    }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        // Force remove any top spacing via JavaScript
        $('body, #wpwrap, #wpcontent, #wpbody, #wpbody-content, .wrap').css({
            'margin-top': '0',
            'padding-top': '0'
        });
        
        // Remove screen meta elements completely
        $('#screen-meta, #screen-meta-links').remove();
        
        // Remove any admin notices that might be causing spacing
        $('.notice, .updated, .error, .update-nag').remove();
        
        // Force the wrapper to have no top spacing
        $('.dashboard-config-wrap').css({
            'margin-top': '0',
            'padding-top': '0'
        });
        
        // Additional aggressive removal of WordPress admin spacing
        setTimeout(function() {
            $('body').removeClass('wp-toolbar');
            $('#wpbody-content').css('padding-top', '0');
        }, 100);
    });
    </script>
    
    <div class="wrap">
        <div class="dashboard-config-wrap">
            <h1 class="dashboard-config-title">
                <span class="dashicons dashicons-admin-appearance"></span>
                Dashboard Configuration
            </h1>
            
            <div class="dashboard-config-description">
                <p>Customize your Jotunheim Magic dashboard by organizing menu items into sections, reordering them, and enabling/disabling features as needed.</p>
            </div>
        
        <div class="dashboard-config-actions">
            <button type="button" class="button button-primary" id="save-config">
                <span class="dashicons dashicons-saved"></span>
                Save Configuration
            </button>
            <button type="button" class="button button-secondary" id="preview-config">
                <span class="dashicons dashicons-visibility"></span>
                Preview Changes
            </button>
            <button type="button" class="button button-secondary" id="reset-config">
                <span class="dashicons dashicons-undo"></span>
                Reset to Defaults
            </button>
            <button type="button" class="button button-secondary" id="add-section">
                <span class="dashicons dashicons-plus-alt"></span>
                Add Section
            </button>
        </div>
        
        <div class="dashboard-config-container">
            <!-- Sections Management -->
            <div class="config-sections">
                <h2>
                    <span class="dashicons dashicons-category"></span>
                    Menu Sections
                </h2>
                <p class="section-description">Organize your menu items into logical sections. Drag to reorder.</p>
                
                <div id="sections-container" class="sections-list sortable">
                    <!-- Sections will be populated by JavaScript -->
                </div>
            </div>
            
            <!-- Items Management -->
            <div class="config-items">
                <h2>
                    <span class="dashicons dashicons-menu-alt"></span>
                    Menu Items
                </h2>
                <p class="section-description">Assign menu items to sections and control their visibility. Drag to reorder within sections.</p>
                
                <div class="items-filter">
                    <label for="section-filter">Filter by section:</label>
                    <select id="section-filter">
                        <option value="">All Sections</option>
                    </select>
                    <label for="status-filter">Filter by status:</label>
                    <select id="status-filter">
                        <option value="">All Items</option>
                        <option value="enabled">Enabled Only</option>
                        <option value="disabled">Disabled Only</option>
                    </select>
                </div>
                
                <div id="items-container" class="items-list">
                    <!-- Items will be populated by JavaScript -->
                </div>
            </div>
            
            <!-- Page Management -->
            <div class="config-pages">
                <h2>
                    <span class="dashicons dashicons-plus-alt"></span>
                    Add Pages
                </h2>
                <p class="section-description">Add new pages to your dashboard from auto-detected plugin pages or create custom entries.</p>
                
                <div class="page-management-tabs">
                    <button type="button" class="tab-button active" data-tab="auto-detect">Auto-Detect Pages</button>
                    <button type="button" class="tab-button" data-tab="manual">Manual Entry</button>
                </div>
                
                <div class="tab-content" id="auto-detect-tab">
                    <div class="auto-detect-controls">
                        <button type="button" class="button" id="scan-pages">
                            <span class="dashicons dashicons-search"></span>
                            Scan for Available Pages
                        </button>
                        <div id="scan-status" class="scan-status"></div>
                    </div>
                    
                    <div id="available-pages-list" class="available-pages-list">
                        <!-- Available pages will be populated by JavaScript -->
                    </div>
                </div>
                
                <div class="tab-content" id="manual-tab" style="display: none;">
                    <form id="manual-page-form" class="manual-page-form">
                        <div class="form-group">
                            <label for="manual-page-id">Page ID <span class="required">*</span></label>
                            <input type="text" id="manual-page-id" name="page_id" required 
                                   placeholder="e.g., custom_reports" pattern="[a-z0-9_]+" 
                                   title="Lowercase letters, numbers, and underscores only">
                            <p class="description">Unique identifier for the page (lowercase, underscores allowed)</p>
                        </div>
                        
                        <div class="form-group">
                            <label for="manual-page-title">Page Title <span class="required">*</span></label>
                            <input type="text" id="manual-page-title" name="page_title" required 
                                   placeholder="e.g., Custom Reports">
                        </div>
                        
                        <div class="form-group">
                            <label for="manual-page-menu-title">Menu Title</label>
                            <input type="text" id="manual-page-menu-title" name="menu_title" 
                                   placeholder="Leave empty to use Page Title">
                        </div>
                        
                        <div class="form-group">
                            <label for="manual-page-callback">Callback Function <span class="required">*</span></label>
                            <input type="text" id="manual-page-callback" name="callback" required 
                                   placeholder="e.g., render_custom_reports_page">
                            <p class="description">PHP function name that renders this page</p>
                        </div>
                        
                        <div class="form-group">
                            <label for="manual-page-section">Section</label>
                            <select id="manual-page-section" name="section">
                                <!-- Will be populated by JavaScript -->
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="manual-page-description">Description</label>
                            <textarea id="manual-page-description" name="description" 
                                      placeholder="Brief description of what this page does"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>
                                <input type="checkbox" id="manual-page-quick-action" name="quick_action">
                                Show in Quick Actions
                            </label>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="button button-primary">
                                <span class="dashicons dashicons-plus-alt"></span>
                                Add Page
                            </button>
                            <button type="button" class="button" id="clear-manual-form">Clear Form</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Preview Panel -->
        <div id="preview-panel" class="preview-panel" style="display: none;">
            <div class="preview-header">
                <h3>
                    <span class="dashicons dashicons-visibility"></span>
                    Dashboard Preview
                </h3>
                <button type="button" class="button button-small" id="close-preview">
                    <span class="dashicons dashicons-no-alt"></span>
                    Close
                </button>
            </div>
            <div class="preview-content">
                <div id="preview-menu" class="preview-menu">
                    <!-- Preview will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </div>
    
    <!-- Section Edit Modal -->
    <div id="section-modal" class="dashboard-modal" style="display: none;">
        <div class="dashboard-modal-content">
            <div class="dashboard-modal-header">
                <h3 id="section-modal-title">Edit Section</h3>
                <button type="button" class="dashboard-modal-close" id="close-section-modal">
                    <span class="dashicons dashicons-no-alt"></span>
                </button>
            </div>
            <div class="dashboard-modal-body">
                <form id="section-form">
                    <input type="hidden" id="section-id" name="section_id">
                    
                    <div class="form-group">
                        <label for="section-title">Section Title</label>
                        <input type="text" id="section-title" name="section_title" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="section-description">Description</label>
                        <textarea id="section-description" name="section_description" class="form-control" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="section-icon">Icon (Dashicon class)</label>
                        <select id="section-icon" name="section_icon" class="form-control">
                            <option value="dashicons-admin-settings">Settings</option>
                            <option value="dashicons-products">Products</option>
                            <option value="dashicons-calendar-alt">Calendar</option>
                            <option value="dashicons-money-alt">Money</option>
                            <option value="dashicons-admin-tools">Tools</option>
                            <option value="dashicons-category">Category</option>
                            <option value="dashicons-admin-users">Users</option>
                            <option value="dashicons-chart-area">Charts</option>
                            <option value="dashicons-database">Database</option>
                            <option value="dashicons-hammer">Hammer</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <input type="checkbox" id="section-enabled" name="section_enabled">
                            Enable this section
                        </label>
                    </div>
                </form>
            </div>
            <div class="dashboard-modal-footer">
                <button type="button" class="button button-secondary" id="cancel-section">Cancel</button>
                <button type="button" class="button button-primary" id="save-section">Save Section</button>
            </div>
        </div>
    </div>
    
    <style>
        /* Fix positioning to prevent admin bar interference */
        #wpadminbar {
            position: relative !important;
        }
        
        .dashboard-config-wrap {
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            clear: both;
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
        
        /* Ensure all floating elements stay within content area */
        .dashboard-config-wrap * {
            position: relative;
        }
        
        /* Prevent any absolute positioning from escaping */
        .wrap {
            position: relative;
            overflow: visible;
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
        
        /* Fix the main heading spacing */
        .dashboard-config-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #1d2327;
            margin-bottom: 10px;
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
        
        /* Ensure the first element has no top margin */
        .wrap > .dashboard-config-wrap > h1:first-child,
        .wrap > h1:first-child {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
        
        .dashboard-config-description {
            background: #f0f6fc;
            border-left: 4px solid #0073aa;
            padding: 15px;
            margin-bottom: 30px;
            border-radius: 4px;
        }
        
        .dashboard-config-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .dashboard-config-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .config-sections,
        .config-items {
            background: white;
            border: 1px solid #c3c4c7;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .config-sections h2,
        .config-items h2 {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 0;
            margin-bottom: 10px;
            color: #1d2327;
        }
        
        .section-description {
            color: #646970;
            margin-bottom: 20px;
        }
        
        .sections-list,
        .items-list {
            min-height: 400px;
        }
        
        .section-item,
        .menu-item {
            background: #f6f7f7;
            border: 1px solid #c3c4c7;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 10px;
            cursor: move;
            transition: all 0.2s ease;
        }
        
        .section-item:hover,
        .menu-item:hover {
            background: #f0f0f1;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .section-item.ui-sortable-placeholder,
        .menu-item.ui-sortable-placeholder {
            background: #ddd;
            border: 2px dashed #999;
            height: 80px;
        }
        
        .section-header,
        .item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }
        
        .section-title,
        .item-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #1d2327;
        }
        
        .section-controls,
        .item-controls {
            display: flex;
            gap: 5px;
        }
        
        .control-btn {
            padding: 4px 8px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }
        
        .control-btn.edit {
            background: #0073aa;
            color: white;
        }
        
        .control-btn.toggle {
            background: #00a32a;
            color: white;
        }
        
        .control-btn.toggle.disabled {
            background: #d63638;
        }
        
        .control-btn.delete {
            background: #d63638;
            color: white;
        }
        
        .item-description {
            color: #646970;
            font-size: 13px;
            margin-bottom: 8px;
        }
        
        .item-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #646970;
        }
        
        .item-section {
            background: #0073aa;
            color: white;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 11px;
        }
        
        .item-status {
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 500;
        }
        
        .item-status.enabled {
            background: #00a32a;
            color: white;
        }
        
        .item-status.disabled {
            background: #d63638;
            color: white;
        }
        
        .items-filter {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px;
            background: #f6f7f7;
            border-radius: 4px;
            position: relative;
            z-index: 10;
        }
        
        .items-filter select {
            position: relative;
            z-index: 15;
        }
        
        .organized-menu-toggle {
            background: #e7f3ff;
            border: 1px solid #0073aa;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .organized-menu-toggle label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .organized-menu-toggle .description {
            margin: 0;
            color: #646970;
            font-size: 13px;
        }
        
        .items-filter label {
            font-weight: 500;
            color: #1d2327;
        }
        
        .items-filter select {
            padding: 5px 8px;
            border: 1px solid #8c8f94;
            border-radius: 3px;
            position: relative;
            z-index: 15;
        }
        
        /* Fix dropdown positioning */
        .config-items {
            position: relative;
            z-index: 5;
        }
        
        .items-list {
            position: relative;
            z-index: 1;
        }
        
        .preview-panel {
            background: white;
            border: 1px solid #c3c4c7;
            border-radius: 8px;
            margin-top: 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .preview-header {
            padding: 15px 20px;
            border-bottom: 1px solid #c3c4c7;
            background: #f6f7f7;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .preview-header h3 {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            color: #1d2327;
        }
        
        .preview-content {
            padding: 20px;
        }
        
        .preview-menu {
            max-height: 400px;
            overflow-y: auto;
        }
        
        .preview-section {
            margin-bottom: 25px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            overflow: hidden;
        }
        
        .preview-section-header {
            background: #f6f7f7;
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #1d2327;
        }
        
        .preview-section-items {
            padding: 10px;
        }
        
        .preview-item {
            padding: 8px 12px;
            margin-bottom: 5px;
            background: #f9f9f9;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .preview-item:last-child {
            margin-bottom: 0;
        }
        
        .preview-item-title {
            font-weight: 500;
            color: #1d2327;
        }
        
        .preview-item-description {
            font-size: 12px;
            color: #646970;
        }
        
        /* Modal Styles */
        .dashboard-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .dashboard-modal-content {
            background: white;
            border-radius: 8px;
            min-width: 500px;
            max-width: 90vw;
            max-height: 90vh;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        
        .dashboard-modal-header {
            padding: 20px;
            border-bottom: 1px solid #c3c4c7;
            background: #f6f7f7;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .dashboard-modal-header h3 {
            margin: 0;
            color: #1d2327;
        }
        
        .dashboard-modal-close {
            background: none;
            border: none;
            color: #646970;
            cursor: pointer;
            padding: 5px;
            border-radius: 3px;
            font-size: 16px;
        }
        
        .dashboard-modal-close:hover {
            background: #f0f0f1;
        }
        
        .dashboard-modal-body {
            padding: 20px;
            max-height: 60vh;
            overflow-y: auto;
        }
        
        .dashboard-modal-footer {
            padding: 20px;
            border-top: 1px solid #c3c4c7;
            background: #f6f7f7;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #1d2327;
        }
        
        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #8c8f94;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .form-control:focus {
            border-color: #0073aa;
            box-shadow: 0 0 0 1px #0073aa;
            outline: none;
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .dashboard-config-container {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .dashboard-config-wrap {
                padding: 10px;
            }
            
            .dashboard-config-actions {
                flex-direction: column;
            }
            
            .items-filter {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }
            
            .dashboard-modal-content {
                min-width: 0;
                width: 95vw;
            }
        }
        
        /* Page Management Styles */
        .config-pages {
            margin: 30px 0;
            padding: 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .config-pages h2 {
            margin-top: 0;
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        
        .page-management-tabs {
            display: flex;
            gap: 10px;
            margin: 20px 0;
            border-bottom: 1px solid #ddd;
        }
        
        .tab-button {
            background: none;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            color: #666;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
        }
        
        .tab-button:hover {
            color: #3498db;
        }
        
        .tab-button.active {
            color: #3498db;
            border-bottom-color: #3498db;
            font-weight: 600;
        }
        
        .tab-content {
            margin: 20px 0;
        }
        
        .auto-detect-controls {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .scan-status {
            font-style: italic;
            color: #666;
        }
        
        .scan-status.loading {
            color: #3498db;
        }
        
        .scan-status.success {
            color: #27ae60;
        }
        
        .scan-status.error {
            color: #e74c3c;
        }
        
        .available-pages-list {
            border: 1px solid #ddd;
            border-radius: 5px;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .available-page-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #eee;
            transition: background-color 0.2s ease;
        }
        
        .available-page-item:last-child {
            border-bottom: none;
        }
        
        .available-page-item:hover {
            background-color: #f8f9fa;
        }
        
        .page-info h4 {
            margin: 0 0 5px 0;
            color: #2c3e50;
        }
        
        .page-info .page-meta {
            font-size: 12px;
            color: #666;
            margin: 2px 0;
        }
        
        .page-info .page-description {
            font-size: 13px;
            color: #777;
            margin: 5px 0 0 0;
            font-style: italic;
        }
        
        .page-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .manual-page-form {
            max-width: 600px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
            color: #2c3e50;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        
        .form-group .description {
            font-size: 12px;
            color: #666;
            margin: 5px 0 0 0;
            font-style: italic;
        }
        
        .required {
            color: #e74c3c;
        }
        
        .form-group input[type="checkbox"] {
            width: auto;
            margin-right: 8px;
        }
        
        .no-pages-found {
            text-align: center;
            padding: 40px 20px;
            color: #666;
            font-style: italic;
        }
    </style>

    <!-- Toggle for Organized Menu Mode - Moved to bottom -->
    <div class="organized-menu-toggle" style="margin-top: 40px; padding: 20px; background: #f6f7f7; border-radius: 8px; border: 1px solid #dcdcde;">
        <h3 style="margin-top: 0; color: #1d2327;">
            <span class="dashicons dashicons-admin-settings" style="margin-right: 8px;"></span>
            Menu Display Mode
        </h3>
        <label style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
            <input type="checkbox" id="use-organized-menu" <?php echo get_option('jotunheim_use_organized_menu', false) ? 'checked' : ''; ?>>
            <strong>Enable Organized Menu Mode</strong>
        </label>
        <p class="description" style="margin: 0; color: #646970;">Switch between organized sections (recommended) and the traditional flat menu structure. Changes take effect after saving.</p>
    </div>

    </div> <!-- Close .wrap -->
    
    <script>
    jQuery(document).ready(function($) {
        // Handle organized menu toggle
        $('#use-organized-menu').on('change', function() {
            var isEnabled = $(this).is(':checked');
            
            // Save the setting via AJAX
            $.post(ajaxurl, {
                action: 'save_dashboard_config',
                nonce: '<?php echo wp_create_nonce('dashboard_config_nonce'); ?>',
                use_organized_menu: isEnabled ? 1 : 0
            }, function(response) {
                if (response.success) {
                    // Show success message
                    $('.dashboard-config-description').after(
                        '<div class="notice notice-success is-dismissible"><p>' +
                        (isEnabled ? 'Organized menu mode enabled! Your menu will now use sections.' : 'Legacy menu mode enabled! Your menu will use the traditional flat structure.') +
                        '</p></div>'
                    );
                    
                    // Auto-remove notice after 3 seconds
                    setTimeout(function() {
                        $('.notice').fadeOut();
                    }, 3000);
                } else {
                    alert('Error saving setting: ' + (response.data || 'Unknown error'));
                }
            });
        });
        
        // Page Management Functionality
        
        // Tab switching
        $('.tab-button').on('click', function() {
            const tabId = $(this).data('tab');
            
            // Update tab buttons
            $('.tab-button').removeClass('active');
            $(this).addClass('active');
            
            // Show/hide tab content
            $('.tab-content').hide();
            $('#' + tabId + '-tab').show();
        });
        
        // Scan for available pages
        $('#scan-pages').on('click', function() {
            const $button = $(this);
            const $status = $('#scan-status');
            const $list = $('#available-pages-list');
            
            $button.prop('disabled', true);
            $status.removeClass('success error').addClass('loading').text('Scanning for available pages...');
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'ajax_get_available_pages',
                    nonce: '<?php echo wp_create_nonce("dashboard_config_nonce"); ?>'
                },
                success: function(response) {
                    if (response.success && response.data.pages) {
                        const pages = response.data.pages;
                        let html = '';
                        
                        if (pages.length === 0) {
                            html = '<div class="no-pages-found">No additional pages found to add.</div>';
                        } else {
                            pages.forEach(function(page) {
                                html += '<div class="available-page-item" data-page-id="' + page.id + '">';
                                html += '<div class="page-info">';
                                html += '<h4>' + page.title + '</h4>';
                                html += '<div class="page-meta">ID: ' + page.id + ' | Function: ' + page.callback + '</div>';
                                if (page.description) {
                                    html += '<div class="page-description">' + page.description + '</div>';
                                }
                                html += '</div>';
                                html += '<div class="page-actions">';
                                html += '<select class="page-section-select">';
                                // Populate sections dynamically
                                const sections = Object.keys(dashboardConfig);
                                sections.forEach(function(section) {
                                    html += '<option value="' + section + '">' + section.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) + '</option>';
                                });
                                html += '</select>';
                                html += '<button type="button" class="button button-primary add-detected-page">Add Page</button>';
                                html += '</div>';
                                html += '</div>';
                            });
                        }
                        
                        $list.html(html);
                        $status.removeClass('loading').addClass('success').text('Found ' + pages.length + ' available pages');
                    } else {
                        $status.removeClass('loading').addClass('error').text('Error: ' + (response.data || 'Failed to scan pages'));
                    }
                },
                error: function() {
                    $status.removeClass('loading').addClass('error').text('Error: Failed to communicate with server');
                },
                complete: function() {
                    $button.prop('disabled', false);
                }
            });
        });
        
        // Add detected page
        $(document).on('click', '.add-detected-page', function() {
            const $item = $(this).closest('.available-page-item');
            const pageId = $item.data('page-id');
            const section = $item.find('.page-section-select').val();
            const $button = $(this);
            
            $button.prop('disabled', true).text('Adding...');
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'ajax_add_custom_page',
                    nonce: '<?php echo wp_create_nonce("dashboard_config_nonce"); ?>',
                    page_id: pageId,
                    section: section
                },
                success: function(response) {
                    if (response.success) {
                        // Remove from available list
                        $item.fadeOut(300, function() {
                            $(this).remove();
                        });
                        
                        // Show success message
                        const $successMsg = $('<div class="notice notice-success"><p>Page "' + pageId + '" added successfully!</p></div>');
                        $('.config-pages').before($successMsg);
                        setTimeout(function() {
                            $successMsg.fadeOut();
                        }, 3000);
                        
                        // Refresh the dashboard config
                        location.reload();
                    } else {
                        alert('Error adding page: ' + (response.data || 'Unknown error'));
                        $button.prop('disabled', false).text('Add Page');
                    }
                },
                error: function() {
                    alert('Error: Failed to communicate with server');
                    $button.prop('disabled', false).text('Add Page');
                }
            });
        });
        
        // Manual page form
        $('#manual-page-form').on('submit', function(e) {
            e.preventDefault();
            
            const formData = {
                action: 'ajax_add_custom_page',
                nonce: '<?php echo wp_create_nonce("dashboard_config_nonce"); ?>',
                page_id: $('#manual-page-id').val(),
                page_title: $('#manual-page-title').val(),
                menu_title: $('#manual-page-menu-title').val() || $('#manual-page-title').val(),
                callback: $('#manual-page-callback').val(),
                section: $('#manual-page-section').val(),
                description: $('#manual-page-description').val(),
                quick_action: $('#manual-page-quick-action').is(':checked'),
                is_manual: true
            };
            
            const $submitBtn = $(this).find('button[type="submit"]');
            $submitBtn.prop('disabled', true).html('<span class="dashicons dashicons-update-alt"></span> Adding...');
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Clear form
                        $('#manual-page-form')[0].reset();
                        
                        // Show success message
                        const $successMsg = $('<div class="notice notice-success"><p>Page "' + formData.page_title + '" added successfully!</p></div>');
                        $('.config-pages').before($successMsg);
                        setTimeout(function() {
                            $successMsg.fadeOut();
                        }, 3000);
                        
                        // Refresh the dashboard config
                        location.reload();
                    } else {
                        alert('Error adding page: ' + (response.data || 'Unknown error'));
                    }
                },
                error: function() {
                    alert('Error: Failed to communicate with server');
                },
                complete: function() {
                    $submitBtn.prop('disabled', false).html('<span class="dashicons dashicons-plus-alt"></span> Add Page');
                }
            });
        });
        
        // Clear manual form
        $('#clear-manual-form').on('click', function() {
            $('#manual-page-form')[0].reset();
        });
        
        // Populate manual form section dropdown
        function populateManualSectionDropdown() {
            const $select = $('#manual-page-section');
            $select.empty();
            
            const sections = Object.keys(dashboardConfig);
            sections.forEach(function(section) {
                const displayName = section.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                $select.append('<option value="' + section + '">' + displayName + '</option>');
            });
        }
        
        // Initialize manual form
        populateManualSectionDropdown();
    });
    </script>
    
    <?php
}