<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include the database management classes
require_once(plugin_dir_path(__FILE__) . 'dashboard-db.php');
require_once(plugin_dir_path(__FILE__) . 'dashboard-db-normalized.php');

/**
 * Dashboard Menu Configuration System
 * Allows users to reorganize menu items, create sections, and customize the admin dashboard
 */

class JotunheimDashboardConfig {
    
    private $default_menu_items = [];
    private $menu_config = [];
    private $db;
    public $normalized_db;
    
    public function __construct() {
        // Initialize database handlers
        $this->db = new Jotunheim_Dashboard_DB();
        $this->normalized_db = new Jotunheim_Dashboard_DB_Normalized();
        
        // Check if we need to migrate to normalized structure
        if (!$this->normalized_db->tables_exist()) {
            error_log('Jotunheim Dashboard: Creating normalized tables and migrating data');
            $this->normalized_db->create_tables();
            $this->migrate_to_normalized();
        }
        
        // Initialize immediately instead of waiting for admin_init
        $this->init();
        
        add_action('wp_ajax_save_dashboard_config', [$this, 'save_dashboard_config']);
        add_action('wp_ajax_reset_dashboard_config', [$this, 'reset_dashboard_config']);
        add_action('wp_ajax_save_discord_roles', [$this, 'ajax_save_discord_roles']);
        add_action('wp_ajax_test_discord_connection', [$this, 'ajax_test_discord_connection']);
        add_action('wp_ajax_get_available_pages', [$this, 'ajax_get_available_pages']);
        add_action('wp_ajax_add_custom_page', [$this, 'ajax_add_custom_page']);
        add_action('wp_ajax_delete_dashboard_page', [$this, 'ajax_delete_dashboard_page']);
        add_action('wp_ajax_edit_dashboard_page', [$this, 'ajax_edit_dashboard_page']);
        add_action('wp_ajax_update_page_quick_action', [$this, 'ajax_update_page_quick_action']);
        
        // TEMPORARY: Force config reset for debugging (DISABLED after fixing duplicates)
        // delete_option('jotunheim_dashboard_config');
        // error_log('Jotunheim Dashboard: Forced config reset to clear any legacy dashboard overview items');
    }
    
    /**
     * Migrate from old serialized format to normalized database structure
     */
    private function migrate_to_normalized() {
        error_log('Jotunheim Dashboard: Starting migration to normalized database');
        
        // Ensure we have default menu items loaded
        $this->load_default_menu_items();
        
        // First ensure old table exists and migrate from options if needed
        if (!$this->db->table_exists()) {
            $this->db->create_table();
            $this->db->migrate_from_options();
        }
        
        // Get config from old format
        $old_config = $this->db->load_config('dashboard_config');
        
        if (!$old_config) {
            error_log('Jotunheim Dashboard: No old config found, creating default normalized structure');
            $this->load_default_menu_items();
            $old_config = $this->get_default_config();
        }
        
        if ($old_config && isset($old_config['sections']) && isset($old_config['items'])) {
            // Migrate sections
            foreach ($old_config['sections'] as $section_data) {
                $this->normalized_db->save_section(
                    $section_data['id'], 
                    $section_data['title'], 
                    $section_data['order'] ?? 0
                );
            }
            
            // Migrate items
            foreach ($old_config['items'] as $item) {
                if (isset($item['id'])) {
                    $item_data = array(
                        'section_key' => $item['section'] ?? 'system',
                        'item_key' => $item['id'],
                        'item_name' => $item['id'], // Will be updated below
                        'callback_function' => '', // Will be updated below
                        'quick_action' => $item['quick_action'] ?? false,
                        'display_order' => $item['order'] ?? 0
                    );
                    
                    // Find the actual menu item to get proper name and callback
                    foreach ($this->default_menu_items as $menu_item) {
                        if ($menu_item['id'] === $item['id']) {
                            $item_data['item_name'] = $menu_item['title'];
                            $item_data['callback_function'] = $menu_item['callback'];
                            break;
                        }
                    }
                    
                    $this->normalized_db->save_item($item_data);
                }
            }
            
            error_log('Jotunheim Dashboard: Successfully migrated ' . count($old_config['sections']) . ' sections and ' . count($old_config['items']) . ' items');
        }
    }
    
    public function init() {
        error_log('Jotunheim Dashboard: Starting init() with normalized database');
        
        // Load configuration from normalized database ONLY
        $this->menu_config = $this->normalized_db->get_full_configuration();
        
        if (empty($this->menu_config)) {
            error_log('Jotunheim Dashboard: No configuration found in normalized database, loading defaults');
            $this->load_default_menu_items();
            $default_config = $this->get_default_config();
            
            // Populate normalized database with defaults
            foreach ($default_config['sections'] as $section_data) {
                $this->normalized_db->save_section($section_data['id'], $section_data['title'], $section_data['order'] ?? 0);
            }
            
            foreach ($default_config['items'] as $item) {
                if (isset($item['id'])) {
                    $item_data = array(
                        'section_key' => $item['section'] ?? 'system',
                        'item_key' => $item['id'],
                        'item_name' => $item['id'], // We'll get the proper name from default_menu_items
                        'callback_function' => '', // We'll get this from default_menu_items
                        'quick_action' => false,
                        'display_order' => $item['order'] ?? 0
                    );
                    
                    // Find the actual menu item to get proper name and callback
                    foreach ($this->default_menu_items as $menu_item) {
                        if ($menu_item['id'] === $item['id']) {
                            $item_data['item_name'] = $menu_item['title'];
                            $item_data['callback_function'] = $menu_item['callback'];
                            break;
                        }
                    }
                    
                    $this->normalized_db->save_item($item_data);
                }
            }
        
        // Reload from database
        $this->menu_config = $this->normalized_db->get_full_configuration();
        
        // Reduced logging - only log once per page load, not every init
        static $logged = false;
        if (!$logged) {
            error_log('Jotunheim Dashboard: Config ready with ' . count($this->menu_config) . ' sections');
            foreach ($this->menu_config as $section_key => $section_data) {
                $item_count = isset($section_data['items']) ? count($section_data['items']) : 0;
                error_log('  - Section: ' . $section_key . ' (' . $item_count . ' items)');
            }
            $logged = true;
        }
    }
    }
    
    /**
     * Sync new items to existing configuration
     */
    private function sync_new_items_to_config() {
        // Ensure menu_config has the required structure
        if (!isset($this->menu_config['items']) || !is_array($this->menu_config['items'])) {
            $this->menu_config['items'] = [];
        }
        
        $existing_item_ids = array_column($this->menu_config['items'], 'id');
        $new_items_added = false;
        
        // Find new items that aren't in the stored config
        foreach ($this->default_menu_items as $default_item) {
            if (!in_array($default_item['id'], $existing_item_ids)) {
                // Add new item to System Configuration section by default
                $new_item = [
                    'id' => $default_item['id'],
                    'section' => 'system',
                    'order' => count($this->menu_config['items']) + 1,
                    'enabled' => 1
                ];
                
                $this->menu_config['items'][] = $new_item;
                $new_items_added = true;
                error_log('Jotunheim Dashboard: Added new item to config: ' . $default_item['id']);
            }
        }
        
        if ($new_items_added) {
            update_option('jotunheim_dashboard_config', $this->menu_config);
            error_log('Jotunheim Dashboard: Updated stored config with new items');
        }
    }
    
    private function load_default_menu_items() {
        error_log('Jotunheim Dashboard: Loading default menu items...');
        
        // Check if Discord function exists
        if (function_exists('render_discord_auth_config_page')) {
            error_log('Jotunheim Dashboard: Discord function exists');
        } else {
            error_log('Jotunheim Dashboard: Discord function NOT found');
        }
        
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
                'quick_action' => false  // Changed from true to false to allow user control
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
                'quick_action' => false  // Changed from true to false to allow user control
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
                'quick_action' => false  // Changed from true to false to allow user control
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
                'id' => 'page_permissions_config',
                'title' => 'Page Permissions',
                'menu_title' => 'Page Permissions',
                'callback' => 'render_page_permissions_config_page',
                'category' => 'system',
                'description' => 'Configure Discord role-based page access permissions',
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
        
        error_log('Jotunheim Dashboard: Scanning for available pages...');
        
        // First, ensure all our plugin files are loaded
        $this->load_all_plugin_files();
        
        // Include all default menu items in the available pages
        // This way users can see everything that's available
        foreach ($this->default_menu_items as $item) {
            $available_pages[] = [
                'id' => $item['id'],
                'title' => $item['title'],
                'menu_title' => $item['menu_title'],
                'callback' => $item['callback'],
                'category' => $item['category'] ?? 'default',
                'description' => $item['description'] ?? 'Default plugin page',
                'is_default' => true
            ];
            error_log('Jotunheim Dashboard: Added default item: ' . $item['id']);
        }
        
        // Scan for functions that match render_*_page pattern
        $functions = get_defined_functions()['user'];
        
        error_log('Jotunheim Dashboard: Found ' . count($functions) . ' user functions');
        
        foreach ($functions as $function) {
            if (preg_match('/^render_(.+)_page$/', $function, $matches)) {
                $page_id = $matches[1];
                $page_title = ucwords(str_replace('_', ' ', $page_id));
                
                error_log('Jotunheim Dashboard: Found render function: ' . $function . ' -> ' . $page_id);
                
                // Skip if already in our default menu items
                $exists = false;
                foreach ($this->default_menu_items as $item) {
                    if ($item['id'] === $page_id || $item['callback'] === $function) {
                        $exists = true;
                        error_log('  - Skipping ' . $page_id . ' (already in default items)');
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
                        'description' => 'Auto-detected plugin page',
                        'is_default' => false
                    ];
                    error_log('  - Added ' . $page_id . ' to available pages');
                }
            }
        }
        
        // Also scan includes directory for PHP files that might contain page renders
        $plugin_dir = plugin_dir_path(__FILE__) . '../';
        error_log('Jotunheim Dashboard: Scanning directory: ' . $plugin_dir);
        $this->scan_directory_for_pages($plugin_dir, $available_pages);
        
        // Add some hardcoded pages that might not be auto-detected
        $hardcoded_pages = [
            // Note: Don't add pages that are already in default_menu_items
            // Only add pages that are truly missing or have different function names
            // Temporarily removing hardcoded entries to test page detection
        ];
        
        foreach ($hardcoded_pages as $page) {
            // Check if already exists in default items OR available pages
            $exists = false;
            foreach ($this->default_menu_items as $item) {
                if ($item['id'] === $page['id'] || $item['callback'] === $page['callback']) {
                    $exists = true;
                    break;
                }
            }
            foreach ($available_pages as $existing) {
                if ($existing['id'] === $page['id'] || $existing['callback'] === $page['callback']) {
                    $exists = true;
                    break;
                }
            }
            
            if (!$exists && function_exists($page['callback'])) {
                $page['is_default'] = false;
                $available_pages[] = $page;
                error_log('Jotunheim Dashboard: Added hardcoded page: ' . $page['id']);
            }
        }
        
        error_log('Jotunheim Dashboard: Final page count: ' . count($available_pages));
        
        return $available_pages;
    }
    
    /**
     * Load all plugin files to ensure functions are available for scanning
     */
    private function load_all_plugin_files() {
        $plugin_dir = plugin_dir_path(__FILE__) . '../';
        $this->load_files_from_directory($plugin_dir);
    }
    
    /**
     * Recursively load PHP files from a directory
     */
    private function load_files_from_directory($dir) {
        if (!is_dir($dir)) return;
        
        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;
            
            $full_path = $dir . $file;
            
            if (is_dir($full_path)) {
                // Recursively load subdirectories
                $this->load_files_from_directory($full_path . '/');
            } elseif (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                // Include PHP file if not already included
                if (!in_array($full_path, get_included_files())) {
                    @include_once($full_path);
                }
            }
        }
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
                                'file_path' => $full_path,
                                'is_default' => false
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
        // Just return the database data directly - no complex merging
        $db_config = $this->normalized_db->get_full_configuration();
        $menu_items = [];
        
        foreach ($db_config as $section_key => $section_data) {
            if (isset($section_data['items'])) {
                foreach ($section_data['items'] as $item) {
                    $menu_items[] = [
                        'id' => $item['item_id'],
                        'title' => $item['title'],
                        'menu_title' => $item['title'], // Add menu_title for JavaScript compatibility
                        'callback' => $item['callback'],
                        'enabled' => $item['enabled'],
                        'quick_action' => $item['quick_action'], // Direct from database
                        'order' => $item['order'],
                        'icon' => $item['icon'],
                        'description' => $item['description'],
                        'permissions' => $item['permissions'],
                        'section' => $section_key
                    ];
                }
            }
        }
        
        return $menu_items;
    }
    
    public function get_config() {
        // Use ONLY normalized database - no more old database calls
        return $this->normalized_db->get_full_configuration();
    }
    
    /**
     * Get configuration in format expected by frontend dashboard config page
     */
    public function get_config_for_frontend() {
        // Use the admin version that includes disabled sections AND items
        $normalized_config = $this->normalized_db->get_full_configuration_for_admin();
        
        // Default icons for sections
        $default_section_icons = [
            'core' => 'dashicons-admin-settings',
            'items' => 'dashicons-products',
            'events' => 'dashicons-calendar-alt',
            'pos' => 'dashicons-cart',
            'trading' => 'dashicons-money-alt',
            'commerce' => 'dashicons-money-alt',
            'moderation' => 'dashicons-admin-users',
            'kb' => 'dashicons-book-alt',
            'wiki' => 'dashicons-media-document',
            'gallery' => 'dashicons-format-gallery',
            'ledger' => 'dashicons-analytics',
            'google_sheets' => 'dashicons-media-spreadsheet',
            'discord' => 'dashicons-admin-links',
            'system' => 'dashicons-admin-generic'
        ];
        
        // Convert to format expected by frontend
        $frontend_config = [
            'sections' => [],
            'items' => []
        ];
        
        // Convert sections
        foreach ($normalized_config as $section_key => $section_data) {
            $frontend_config['sections'][] = [
                'id' => $section_key,
                'title' => $section_data['title'],
                'description' => $section_data['description'] ?? 'No description available',
                'order' => $section_data['order'],
                'enabled' => $section_data['enabled'],
                'icon' => $default_section_icons[$section_key] ?? 'dashicons-admin-generic'
            ];
            
            // Convert items in this section
            if (isset($section_data['items']) && is_array($section_data['items'])) {
                foreach ($section_data['items'] as $item_data) {
                    $frontend_config['items'][] = [
                        'id' => $item_data['item_id'],
                        'title' => $item_data['title'],
                        'section' => $section_key,
                        'order' => $item_data['order'],
                        'enabled' => $item_data['enabled'],
                        'quick_action' => $item_data['quick_action'] ?? false,
                        'callback' => $item_data['callback'],
                        'description' => $item_data['description'] ?? ''
                    ];
                }
            }
        }
        
        return $frontend_config;
    }
    
    /**
     * Validate and clean configuration data to prevent corruption
     */
    private function validate_and_clean_config($config) {
        error_log('DEBUG: Validating and cleaning config data');
        
        // Ensure config has required structure
        if (!is_array($config)) {
            error_log('DEBUG: Config is not an array, creating default structure');
            $config = $this->get_default_config();
        }
        
        // Ensure sections exist and are valid
        if (!isset($config['sections']) || !is_array($config['sections'])) {
            error_log('DEBUG: Sections missing or invalid, using defaults');
            $config['sections'] = $this->get_default_sections();
        }
        
        // Ensure items exist and are valid
        if (!isset($config['items']) || !is_array($config['items'])) {
            error_log('DEBUG: Items missing or invalid, using defaults');
            $config['items'] = [];
        }
        
        // Clean and validate items - be more permissive
        $cleaned_items = [];
        foreach ($config['items'] as $index => $item) {
            if (!is_array($item)) {
                error_log('DEBUG: Skipping non-array item at index ' . $index);
                continue;
            }
            
            // Only skip items that are completely malformed
            if (!isset($item['id']) && !isset($item['slug'])) {
                error_log('DEBUG: Skipping item with missing ID and slug at index ' . $index . ': ' . print_r($item, true));
                continue;
            }
            
            // Ensure required fields exist with reasonable defaults
            if (!isset($item['id']) && isset($item['slug'])) {
                $item['id'] = $item['slug'];
            }
            $item['section'] = $item['section'] ?? 'system';
            $item['order'] = $item['order'] ?? 999;
            $item['enabled'] = $item['enabled'] ?? true;
            
            $cleaned_items[] = $item;
        }
        
        $config['items'] = $cleaned_items;
        error_log('DEBUG: Cleaned config: kept ' . count($cleaned_items) . ' valid items out of original ' . count($config['items'] ?? []));
        
        return $config;
    }
    
    /**
     * Sync memory config with database to ensure consistency
     */
    private function sync_memory_config_with_database() {
        $db_config = $this->db->load_config('dashboard_config', null);
        
        if ($db_config !== null) {
            error_log('DEBUG: Syncing memory config with database');
            $this->menu_config = $db_config;
        } else {
            error_log('DEBUG: No database config found during sync');
        }
    }
    
    public function get_organized_menu() {
        $organized = [];
        
        // Get configuration from normalized database
        $config = $this->normalized_db->get_full_configuration();
        
        if (empty($config)) {
            error_log('Jotunheim Dashboard: No configuration found in normalized database for organized menu');
            return [];
        }
        
        // Build organized menu structure from normalized config
        foreach ($config as $section_key => $section_data) {
            $organized[$section_key] = [
                'title' => $section_data['name'],
                'description' => '',
                'icon' => '',
                'items' => []
            ];
            
            // Add items to this section
            if (isset($section_data['items']) && is_array($section_data['items'])) {
                foreach ($section_data['items'] as $item) {
                    $organized[$section_key]['items'][] = [
                        'id' => $item['id'],
                        'title' => $item['name'],
                        'callback' => $item['callback'],
                        'quick_action' => $item['quick_action']
                    ];
                }
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

        // Handle full configuration save using normalized database
        // CRITICAL: Ensure default menu items are loaded for validation
        $this->load_default_menu_items();
        
        error_log('Dashboard Config Save: Raw $_POST sections: ' . $_POST['sections']);
        error_log('Dashboard Config Save: Raw $_POST items: ' . $_POST['items']);
        
        $config = [
            'sections' => json_decode(stripslashes($_POST['sections']), true),
            'items' => json_decode(stripslashes($_POST['items']), true)
        ];
        
        error_log('Dashboard Config Save: Decoded sections count: ' . (is_array($config['sections']) ? count($config['sections']) : 'NOT ARRAY'));
        error_log('Dashboard Config Save: Decoded items count: ' . (is_array($config['items']) ? count($config['items']) : 'NOT ARRAY'));
        error_log('Dashboard Config Save: Items empty check: ' . (empty($config['items']) ? 'TRUE' : 'FALSE'));
        
        // SAFETY CHECK: Don't proceed if we have no items (this would break everything)
        if (empty($config['items'])) {
            error_log('Dashboard Config: Refusing to save empty items configuration');
            wp_send_json_error('Configuration appears to be empty. Save cancelled to prevent data loss.');
            return;
        }
        
        // Save sections to normalized database
        error_log('Dashboard Config Save: Starting to save ' . count($config['sections']) . ' sections');
        foreach ($config['sections'] as $section) {
            error_log('Dashboard Config Save: Saving section ' . $section['id']);
            $this->normalized_db->save_section(
                $section['id'],
                $section['title'],
                $section['order'],
                $section['description'],
                $section['icon'] ?? '',
                $section['enabled']
            );
        }
        error_log('Dashboard Config Save: Finished saving sections');
        
        // Save items to normalized database
        error_log('Dashboard Config Save: Starting to save ' . count($config['items']) . ' items');
        error_log('Dashboard Config Save: default_menu_items contains ' . count($this->default_menu_items) . ' items');
        error_log('Dashboard Config Save: default_menu_items structure: ' . print_r(array_slice($this->default_menu_items, 0, 2), true));
        
        foreach ($config['items'] as $item) {
            error_log('Dashboard Config Save: Processing item ' . $item['id']);
            // Find the menu item to get callback info
            $menu_item = null;
            foreach ($this->default_menu_items as $default_item) {
                if ($default_item['id'] === $item['id']) {
                    $menu_item = $default_item;
                    break;
                }
            }
            
            if ($menu_item) {
                error_log('Dashboard Config Save: Found menu item for ' . $item['id'] . ', saving to database');
                $item_data = [
                    'item_key' => $item['id'],
                    'section_key' => $item['section'],
                    'item_name' => $item['title'],
                    'callback_function' => $menu_item['callback'],
                    'display_order' => $item['order'],
                    'enabled' => $item['enabled'] ? 1 : 0,
                    'quick_action' => $item['quick_action'] ? 1 : 0
                ];
                $this->normalized_db->save_item($item_data);
                error_log('Dashboard Config Save: Successfully saved item ' . $item['id']);
            } else {
                error_log('Dashboard Config Save: WARNING - Could not find menu item for ' . $item['id']);
            }
        }
        error_log('Dashboard Config Save: Finished saving all items');

        // DEBUG: Check what's actually in the database
        global $wpdb;
        $items_table = $this->normalized_db->get_items_table_name();
        $all_items = $wpdb->get_results("SELECT item_key, item_name, is_active, quick_action FROM {$items_table}");
        error_log('Dashboard Config Save: Items in database after save: ' . print_r($all_items, true));

        error_log('Dashboard Config Save: Sending success response');
        wp_send_json_success('Configuration saved successfully');
    }
    
    /**
     * Emergency method to restore database if items get lost
     */
    public function restore_dashboard_items() {
        error_log('Dashboard Config: EMERGENCY RESTORE - Rebuilding menu items');
        
        // Clear and rebuild the normalized database
        $this->normalized_db->clear_all_data();
        
        // Reinitialize with default configuration
        $this->init_config();
        
        error_log('Dashboard Config: Emergency restore completed');
    }    public function reset_dashboard_config() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }

        if (!wp_verify_nonce($_POST['nonce'], 'dashboard_config_nonce')) {
            wp_die('Invalid nonce');
        }

        // Clear normalized database tables
        $this->normalized_db->clear_all_data();
        
        // Reload default configuration into normalized database
        $this->init_config();

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
        
        error_log('Jotunheim Dashboard: Starting page scan...');
        
        $available_pages = $this->get_available_plugin_pages();
        
        error_log('Jotunheim Dashboard: Found ' . count($available_pages) . ' pages');
        foreach ($available_pages as $page) {
            error_log('  - ' . $page['id'] . ': ' . $page['title'] . ' (callback: ' . $page['callback'] . ')');
        }
        
        // Also log what we're returning to the frontend
        error_log('Jotunheim Dashboard: Returning ' . count($available_pages) . ' pages to frontend');
        
        wp_send_json_success(['pages' => $available_pages]);
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
        
        // Get current config
        $config = $this->get_config();
        
        // Sanitize input
        $new_page = [
            'id' => sanitize_key($page_data['id']),
            'title' => sanitize_text_field($page_data['title']),
            'menu_title' => sanitize_text_field($page_data['menu_title'] ?: $page_data['title']),
            'callback' => sanitize_text_field($page_data['callback']),
            'category' => sanitize_text_field($page_data['category'] ?: 'custom'),
            'description' => sanitize_text_field($page_data['description'] ?: 'Custom added page'),
            'section' => sanitize_text_field($page_data['section'] ?: 'main'),
            'enabled' => (bool)($page_data['enabled'] ?: true),
            'quick_action' => (bool)($page_data['quick_action'] ?: false),
            'order' => count($config['items'] ?: []) + 1
        ];
        
        // Check if page already exists
        foreach ($this->get_menu_items() as $existing) {
            if ($existing['id'] === $new_page['id']) {
                wp_send_json_error('Page with this ID already exists');
                return;
            }
        }
        
        // Add to config
        $config['items'][] = $new_page;
        
        if (update_option('jotunheim_dashboard_config', $config)) {
            wp_send_json_success($new_page);
        } else {
            wp_send_json_error('Failed to save configuration');
        }
    }
    
    /**
     * AJAX handler to delete a page from the dashboard
     */
    public function ajax_delete_dashboard_page() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        if (!wp_verify_nonce($_POST['nonce'], 'dashboard_config_nonce')) {
            wp_die('Invalid nonce');
        }
        
        $page_id = sanitize_key($_POST['page_id']);
        if (empty($page_id)) {
            wp_send_json_error('Page ID is required');
            return;
        }
        
        $config = $this->get_config();
        $found = false;
        
        // Remove from items array
        foreach ($config['items'] as $key => $item) {
            if ($item['id'] === $page_id) {
                unset($config['items'][$key]);
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            wp_send_json_error('Page not found in configuration');
            return;
        }
        
        // Re-index array
        $config['items'] = array_values($config['items']);
        
        if (update_option('jotunheim_dashboard_config', $config)) {
            wp_send_json_success('Page deleted successfully');
        } else {
            wp_send_json_error('Failed to save configuration');
        }
    }
    
    /**
     * AJAX handler to edit a page in the dashboard
     */
    public function ajax_edit_dashboard_page() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        if (!wp_verify_nonce($_POST['nonce'], 'dashboard_config_nonce')) {
            wp_die('Invalid nonce');
        }
        
        $page_id = sanitize_key($_POST['page_id']);
        $page_data = $_POST['page_data'];
        
        if (empty($page_id)) {
            wp_send_json_error('Page ID is required');
            return;
        }
        
        // Update directly in normalized database instead of trying to work with config structure
        $update_data = [];
        
        if (isset($page_data['title'])) {
            $update_data['item_name'] = sanitize_text_field($page_data['title']);
        }
        if (isset($page_data['menu_title'])) {
            $update_data['item_name'] = sanitize_text_field($page_data['menu_title']);
        }
        if (isset($page_data['description'])) {
            $update_data['description'] = sanitize_text_field($page_data['description']);
        }
        if (isset($page_data['quick_action'])) {
            $update_data['quick_action'] = (bool)$page_data['quick_action'] ? 1 : 0;
        }
        if (isset($page_data['enabled'])) {
            $update_data['is_active'] = (bool)$page_data['enabled'] ? 1 : 0;
        }
        if (isset($page_data['display_order'])) {
            $update_data['display_order'] = (int)$page_data['display_order'];
        }
        if (isset($page_data['section_key'])) {
            $update_data['section_key'] = sanitize_key($page_data['section_key']);
        }
        
        if (empty($update_data)) {
            wp_send_json_error('No valid data to update');
            return;
        }
        
        // Update in normalized database
        global $wpdb;
        $result = $wpdb->update(
            'jotun_dashboard_items',
            array_merge($update_data, ['updated_at' => current_time('mysql')]),
            array('item_key' => $page_id),
            array_fill(0, count($update_data) + 1, '%s'),
            array('%s')
        );
        
        if ($result === false) {
            wp_send_json_error('Failed to update page data');
            return;
        }
        
        wp_send_json_success('Page updated successfully');
    }

    /**
    
    /**
     * AJAX handler to update quick action status for a page
     */
    public function ajax_update_page_quick_action() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        if (!wp_verify_nonce($_POST['nonce'], 'dashboard_config_nonce')) {
            wp_die('Invalid nonce');
        }
        
        error_log('DEBUG: ajax_update_page_quick_action called with POST data: ' . print_r($_POST, true));
        
        $page_id = sanitize_key($_POST['page_id']);
        $quick_action = (bool)$_POST['quick_action'];
        
        error_log('DEBUG: Sanitized page_id: ' . $page_id);
        error_log('DEBUG: Quick action value: ' . ($quick_action ? 'true' : 'false'));
        
        if (empty($page_id)) {
            error_log('DEBUG: Page ID is empty, sending error response');
            wp_send_json_error('Page ID is required');
            return;
        }
        
        // Use normalized database for direct update
        $update_result = $this->normalized_db->update_item_quick_action($page_id, $quick_action);
        
        if ($update_result) {
            error_log('DEBUG: Successfully updated quick action in normalized database');
            wp_send_json_success('Quick action setting updated');
        } else {
            error_log('DEBUG: Failed to update quick action in normalized database');
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
    
    // Convert normalized database structure to format expected by frontend
    $config = $jotunheim_dashboard_config->get_config_for_frontend();
    
    // Enqueue necessary scripts and styles
    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script('wp-api'); // WordPress REST API
    
    // Use the original dashboard config JavaScript (AJAX version works fine with our fix)
    wp_enqueue_script('dashboard-config-js', plugin_dir_url(__FILE__) . '../../assets/js/dashboard-config.js', ['jquery', 'jquery-ui-sortable'], '1.0.0', true);
    
    wp_enqueue_style('dashboard-config-css', plugin_dir_url(__FILE__) . '../../assets/css/dashboard-config.css', [], '1.0.0');

    // Provide configuration to JavaScript
    wp_localize_script('dashboard-config-js', 'dashboardConfig', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('dashboard_config_nonce'),
        'config' => $config,
        'menuItems' => $menu_items
    ]);
    
    ?>
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
            <button type="button" class="button button-secondary" id="add-pages">
                <span class="dashicons dashicons-admin-page"></span>
                Add Pages
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
    
    <!-- Add Pages Modal -->
    <div id="add-pages-modal" class="dashboard-modal" style="display: none;">
        <div class="dashboard-modal-content">
            <div class="dashboard-modal-header">
                <h3>Add Pages</h3>
                <button type="button" class="dashboard-modal-close" id="close-add-pages-modal">
                    <span class="dashicons dashicons-no-alt"></span>
                </button>
            </div>
            <div class="dashboard-modal-body">
                <div class="page-management-tabs">
                    <button type="button" class="tab-button active" data-tab="auto-detect">Auto-Detect Pages</button>
                    <button type="button" class="tab-button" data-tab="manual">Manual Entry</button>
                </div>
                
                <div class="tab-content active" id="auto-detect-tab" data-tab="auto-detect">
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
                
                <div class="tab-content" id="manual-tab" data-tab="manual" style="display: none;">
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
        
        /* Tab CSS for modal */
        .page-management-tabs {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            gap: 0;
        }

        .tab-button {
            background: none;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            color: #646970;
            border-bottom: 2px solid transparent;
            transition: all 0.2s ease;
        }

        .tab-button:hover {
            color: #2271b1;
            background: #f6f7f7;
        }

        .tab-button.active {
            color: #2271b1;
            border-bottom-color: #2271b1;
            background: #f6f7f7;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
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
        
        /* Page Management Buttons */
        .page-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        
        .edit-page-btn, .delete-page-btn {
            padding: 4px 8px;
            font-size: 12px;
            border-radius: 3px;
            text-decoration: none;
            cursor: pointer;
        }
        
        .edit-page-btn {
            background: #0073aa;
            color: white;
            border: 1px solid #005177;
        }
        
        .edit-page-btn:hover {
            background: #005177;
            color: white;
        }
        
        .delete-page-btn {
            background: #d63638;
            color: white;
            border: 1px solid #b32d2e;
        }
        
        .delete-page-btn:hover {
            background: #b32d2e;
            color: white;
        }
        
        .quick-action-checkbox {
            margin-right: 5px;
        }
        
        .success-indicator {
            font-weight: bold;
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .page-edit-form {
            border-radius: 4px;
        }
        
        .page-edit-form .form-group {
            margin-bottom: 10px;
        }
        
        .page-edit-form label {
            font-weight: 600;
            display: block;
            margin-bottom: 3px;
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
        
        // Add Pages button handler
        $('#add-pages').on('click', function() {
            $('#add-pages-modal').show();
        });
        
        // Close Add Pages modal
        $('#close-add-pages-modal').on('click', function() {
            $('#add-pages-modal').hide();
        });
        
        // Close modal when clicking outside
        $(document).on('click', function(e) {
            if ($(e.target).is('#add-pages-modal')) {
                $('#add-pages-modal').hide();
            }
        });
        
        // Page Management Functionality
        
        // Tab switching
        $('.tab-button').on('click', function() {
            const tabId = $(this).data('tab');
            
            // Update tab buttons
            $('.tab-button').removeClass('active');
            $(this).addClass('active');
            
            // Show/hide tab content based on data-tab attribute
            $('.tab-content').hide().removeClass('active');
            $('.tab-content[data-tab="' + tabId + '"]').show().addClass('active');
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
                    action: 'get_available_pages',
                    nonce: '<?php echo wp_create_nonce("dashboard_config_nonce"); ?>'
                },
                success: function(response) {
                    if (response.success && response.data.pages) {
                        const pages = response.data.pages;
                        let html = '';
                        
                        if (pages.length === 0) {
                            html = '<div class="no-pages-found">No additional pages found to add.</div>';
                        } else {
                            // Separate default and discovered pages
                            const defaultPages = pages.filter(page => page.is_default);
                            const discoveredPages = pages.filter(page => !page.is_default);
                            
                            if (defaultPages.length > 0) {
                                html += '<div class="page-category">';
                                html += '<h3><span class="dashicons dashicons-admin-tools"></span> Default Plugin Pages</h3>';
                                html += '<p class="category-description">These are the main plugin pages that are available by default.</p>';
                                
                                defaultPages.forEach(function(page) {
                                    html += '<div class="available-page-item default-page" data-page-id="' + page.id + '">';
                                    html += '<div class="page-info">';
                                    html += '<h4 class="page-title">' + page.title + '</h4>';
                                    html += '<div class="page-meta">ID: ' + page.id + ' | Function: ' + page.callback + '</div>';
                                    if (page.description) {
                                        html += '<div class="page-description">' + page.description + '</div>';
                                    }
                                    html += '</div>';
                                    html += '<div class="page-actions">';
                                    html += '<select class="page-section-select">';
                                    // Populate sections dynamically from config.sections
                                    if (dashboardConfig.config && dashboardConfig.config.sections) {
                                        dashboardConfig.config.sections.forEach(function(section) {
                                            if (section.enabled) {
                                                html += '<option value="' + section.id + '">' + section.title + '</option>';
                                            }
                                        });
                                    }
                                    html += '</select>';
                                    html += '<button type="button" class="button add-detected-page">Add Page</button>';
                                    html += '</div>';
                                    html += '</div>';
                                });
                                html += '</div>';
                            }
                            
                            if (discoveredPages.length > 0) {
                                html += '<div class="page-category">';
                                html += '<h3><span class="dashicons dashicons-search"></span> Auto-Detected Pages</h3>';
                                html += '<p class="category-description">These pages were automatically discovered by scanning your plugin files.</p>';
                                
                                discoveredPages.forEach(function(page) {
                                    html += '<div class="available-page-item discovered-page" data-page-id="' + page.id + '">';
                                    html += '<div class="page-info">';
                                    html += '<h4 class="page-title">' + page.title + '</h4>';
                                    html += '<div class="page-meta">ID: ' + page.id + ' | Function: ' + page.callback + '</div>';
                                    if (page.description) {
                                        html += '<div class="page-description">' + page.description + '</div>';
                                    }
                                    html += '</div>';
                                    html += '<div class="page-actions">';
                                    html += '<select class="page-section-select">';
                                    // Populate sections dynamically from config.sections
                                    if (dashboardConfig.config && dashboardConfig.config.sections) {
                                        dashboardConfig.config.sections.forEach(function(section) {
                                            if (section.enabled) {
                                                html += '<option value="' + section.id + '">' + section.title + '</option>';
                                            }
                                        });
                                    }
                                    html += '</select>';
                                    html += '<button type="button" class="button add-detected-page">Add Page</button>';
                                    html += '</div>';
                                    html += '</div>';
                                });
                                html += '</div>';
                            }
                            
                            if (defaultPages.length === 0 && discoveredPages.length === 0) {
                                html = '<div class="no-pages-found">No additional pages found to add.</div>';
                            }
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
            
            // Get page data from the item
            const pageTitle = $item.find('.page-title').text().trim();
            const pageMeta = $item.find('.page-meta').text().trim();
            const pageDescription = $item.find('.page-description').text().trim() || 'Auto-detected plugin page';
            
            // Extract callback from meta text (format: "ID: xxx | Function: yyy")
            const callbackMatch = pageMeta.match(/Function:\s*(.+)/);
            const callback = callbackMatch ? callbackMatch[1] : 'render_' + pageId + '_page';
            
            $button.prop('disabled', true).text('Adding...');
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'add_custom_page',
                    nonce: '<?php echo wp_create_nonce("dashboard_config_nonce"); ?>',
                    page_data: {
                        id: pageId,
                        title: pageTitle,
                        menu_title: pageTitle,
                        callback: callback,
                        category: 'auto-detected',
                        description: pageDescription,
                        section: section,
                        enabled: true,
                        quick_action: false
                    }
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
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    console.error('Response:', xhr.responseText);
                    alert('Failed to communicate with server: ' + error + '\n\nPlease check the console for more details.');
                    $button.prop('disabled', false).text('Add Page');
                }
            });
        });
        
        // Manual page form
        $('#manual-page-form').on('submit', function(e) {
            e.preventDefault();
            
            const formData = {
                action: 'add_custom_page',
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
            
            // Use actual sections from config
            if (dashboardConfig.config && dashboardConfig.config.sections) {
                dashboardConfig.config.sections.forEach(function(section) {
                    if (section.enabled) {
                        $select.append('<option value="' + section.id + '">' + section.title + '</option>');
                    }
                });
            }
        }
        
        // Initialize manual form
        populateManualSectionDropdown();
        
        // Handle page deletion
        $(document).on('click', '.delete-page-btn', function() {
            const pageId = $(this).data('page-id');
            const pageTitle = $(this).data('page-title');
            
            if (!confirm('Are you sure you want to delete the page "' + pageTitle + '"?')) {
                return;
            }
            
            const $button = $(this);
            const originalText = $button.html();
            $button.prop('disabled', true).html('<span class="dashicons dashicons-update-alt"></span> Deleting...');
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'delete_dashboard_page',
                    nonce: '<?php echo wp_create_nonce("dashboard_config_nonce"); ?>',
                    page_id: pageId
                },
                success: function(response) {
                    if (response.success) {
                        // Remove the item from the interface
                        $button.closest('.item-row, .page-item, .available-page-item').fadeOut(300, function() {
                            $(this).remove();
                        });
                        
                        // Show success message
                        const $successMsg = $('<div class="notice notice-success"><p>Page "' + pageTitle + '" deleted successfully!</p></div>');
                        $('.wrap > h1').after($successMsg);
                        setTimeout(function() {
                            $successMsg.fadeOut();
                        }, 3000);
                    } else {
                        alert('Error deleting page: ' + (response.data || 'Unknown error'));
                        $button.prop('disabled', false).html(originalText);
                    }
                },
                error: function() {
                    alert('Error: Failed to communicate with server');
                    $button.prop('disabled', false).html(originalText);
                }
            });
        });
        
        // Handle page editing
        $(document).on('click', '.edit-page-btn', function() {
            const pageId = $(this).data('page-id');
            const $row = $(this).closest('.item-row, .page-item');
            
            // Create edit form
            const currentTitle = $row.find('.page-title').text();
            const currentMenuTitle = $row.find('.page-menu-title').text() || currentTitle;
            const currentDescription = $row.find('.page-description').text();
            const isQuickAction = $row.find('.quick-action-checkbox').is(':checked');
            
            const editHtml = `
                <div class="page-edit-form" style="padding: 15px; background: #f9f9f9; border: 1px solid #ddd; margin: 10px 0;">
                    <h4>Edit Page Settings</h4>
                    <div class="form-group">
                        <label>Title:</label>
                        <input type="text" class="edit-title" value="${currentTitle}" style="width: 100%; margin: 5px 0;">
                    </div>
                    <div class="form-group">
                        <label>Menu Title:</label>
                        <input type="text" class="edit-menu-title" value="${currentMenuTitle}" style="width: 100%; margin: 5px 0;">
                    </div>
                    <div class="form-group">
                        <label>Description:</label>
                        <textarea class="edit-description" style="width: 100%; margin: 5px 0; height: 60px;">${currentDescription}</textarea>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" class="edit-quick-action" ${isQuickAction ? 'checked' : ''}>
                            Show in Quick Actions
                        </label>
                    </div>
                    <div class="form-group" style="margin-top: 15px;">
                        <button type="button" class="button button-primary save-page-edit" data-page-id="${pageId}">Save Changes</button>
                        <button type="button" class="button cancel-page-edit">Cancel</button>
                    </div>
                </div>
            `;
            
            // Hide the normal row and show edit form
            $row.hide().after(editHtml);
        });
        
        // Handle save page edit
        $(document).on('click', '.save-page-edit', function() {
            const pageId = $(this).data('page-id');
            const $form = $(this).closest('.page-edit-form');
            const $button = $(this);
            
            const pageData = {
                title: $form.find('.edit-title').val(),
                menu_title: $form.find('.edit-menu-title').val(),
                description: $form.find('.edit-description').val(),
                quick_action: $form.find('.edit-quick-action').is(':checked')
            };
            
            $button.prop('disabled', true).text('Saving...');
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'edit_dashboard_page',
                    nonce: '<?php echo wp_create_nonce("dashboard_config_nonce"); ?>',
                    page_id: pageId,
                    page_data: pageData
                },
                success: function(response) {
                    if (response.success) {
                        // Update the display and remove edit form
                        const $row = $form.prev();
                        $row.find('.page-title').text(pageData.title);
                        $row.find('.page-menu-title').text(pageData.menu_title);
                        $row.find('.page-description').text(pageData.description);
                        $row.find('.quick-action-checkbox').prop('checked', pageData.quick_action);
                        
                        $form.remove();
                        $row.show();
                        
                        // Show success message
                        const $successMsg = $('<div class="notice notice-success"><p>Page settings updated successfully!</p></div>');
                        $('.wrap > h1').after($successMsg);
                        setTimeout(function() {
                            $successMsg.fadeOut();
                        }, 3000);
                    } else {
                        alert('Error saving changes: ' + (response.data || 'Unknown error'));
                        $button.prop('disabled', false).text('Save Changes');
                    }
                },
                error: function() {
                    alert('Error: Failed to communicate with server');
                    $button.prop('disabled', false).text('Save Changes');
                }
            });
        });
        
        // Handle cancel page edit
        $(document).on('click', '.cancel-page-edit', function() {
            const $form = $(this).closest('.page-edit-form');
            const $row = $form.prev();
            $form.remove();
            $row.show();
        });
    });
    </script>
    
    <?php
}