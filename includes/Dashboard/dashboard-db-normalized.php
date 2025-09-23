<?php

/**
 * Normalized Dashboard Database Management
 * Better structure for dashboard configuration
 */

class Jotunheim_Dashboard_DB_Normalized {
    private $sections_table;
    private $items_table;
    
    public function __construct() {
        // Use jotun_ prefix like the existing table
        $this->sections_table = 'jotun_dashboard_sections';
        $this->items_table = 'jotun_dashboard_items';
        
        // Run migration if tables exist
        if ($this->tables_exist()) {
            $this->migrate_sections_table();
        }
    }
    
    public function get_items_table_name() {
        return $this->items_table;
    }
    
    /**
     * Create the normalized dashboard tables
     */
    public function create_tables() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        // Sections table
        $sections_sql = "CREATE TABLE {$this->sections_table} (
            id int(11) NOT NULL AUTO_INCREMENT,
            section_key varchar(100) NOT NULL,
            section_name varchar(255) NOT NULL,
            display_order int(11) DEFAULT 0,
            is_active tinyint(1) DEFAULT 1,
            icon varchar(100) DEFAULT NULL,
            description text DEFAULT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY section_key (section_key),
            KEY display_order (display_order)
        ) $charset_collate;";
        
        // Items table
        $items_sql = "CREATE TABLE {$this->items_table} (
            id int(11) NOT NULL AUTO_INCREMENT,
            section_id int(11) NOT NULL,
            item_key varchar(100) NOT NULL,
            item_name varchar(255) NOT NULL,
            callback_function varchar(255) NOT NULL,
            quick_action tinyint(1) DEFAULT 0,
            display_order int(11) DEFAULT 0,
            is_active tinyint(1) DEFAULT 1,
            icon varchar(100) DEFAULT NULL,
            description text DEFAULT NULL,
            permissions varchar(255) DEFAULT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY item_key (item_key),
            KEY section_id (section_id),
            KEY display_order (display_order),
            KEY quick_action (quick_action),
            FOREIGN KEY (section_id) REFERENCES {$this->sections_table}(id) ON DELETE CASCADE
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        
        $sections_result = dbDelta($sections_sql);
        $items_result = dbDelta($items_sql);
        
        error_log('Jotunheim Dashboard DB: Created sections table: ' . print_r($sections_result, true));
        error_log('Jotunheim Dashboard DB: Created items table: ' . print_r($items_result, true));
        
        return array('sections' => $sections_result, 'items' => $items_result);
    }
    
    /**
     * Update quick action for a specific item
     */
    public function update_item_quick_action($item_key, $quick_action) {
        global $wpdb;
        
        $result = $wpdb->update(
            $this->items_table,
            array(
                'quick_action' => $quick_action ? 1 : 0,
                'updated_at' => current_time('mysql')
            ),
            array('item_key' => $item_key),
            array('%d', '%s'),
            array('%s')
        );
        
        if ($result === false) {
            error_log('Jotunheim Dashboard DB: Failed to update quick_action for item: ' . $item_key);
            error_log('Jotunheim Dashboard DB: MySQL error: ' . $wpdb->last_error);
            return false;
        }
        
        error_log('Jotunheim Dashboard DB: Updated quick_action for item: ' . $item_key . ' to: ' . ($quick_action ? 'true' : 'false'));
        return true;
    }
    
    /**
     * Check if tables exist
     */
    public function tables_exist() {
        global $wpdb;
        
        $sections_exists = $wpdb->get_var("SHOW TABLES LIKE '{$this->sections_table}'") === $this->sections_table;
        $items_exists = $wpdb->get_var("SHOW TABLES LIKE '{$this->items_table}'") === $this->items_table;
        
        return $sections_exists && $items_exists;
    }
    
    /**
     * Check if sections table has description and icon columns, and add them if missing
     */
    public function migrate_sections_table() {
        global $wpdb;
        
        // Check if icon column exists
        $icon_column = $wpdb->get_results("SHOW COLUMNS FROM {$this->sections_table} LIKE 'icon'");
        if (empty($icon_column)) {
            $wpdb->query("ALTER TABLE {$this->sections_table} ADD COLUMN icon varchar(100) DEFAULT NULL AFTER is_active");
            error_log('Jotunheim Dashboard DB: Added icon column to sections table');
        }
        
        // Check if description column exists
        $desc_column = $wpdb->get_results("SHOW COLUMNS FROM {$this->sections_table} LIKE 'description'");
        if (empty($desc_column)) {
            $wpdb->query("ALTER TABLE {$this->sections_table} ADD COLUMN description text DEFAULT NULL AFTER icon");
            error_log('Jotunheim Dashboard DB: Added description column to sections table');
        }
        
        return true;
    }
    
    /**
     * Get all configuration keys
     */
    public function get_full_configuration() {
        global $wpdb;
        
        // Debug: Check if tables exist and have data
        $sections_count = $wpdb->get_var("SELECT COUNT(*) FROM {$this->sections_table}");
        $items_count = $wpdb->get_var("SELECT COUNT(*) FROM {$this->items_table}");
        
        // EMERGENCY: If we have sections but no items, this is a critical failure - auto-restore
        // TEMPORARILY DISABLED - this was causing saved settings to be overwritten with defaults
        if (false && $sections_count > 0 && $items_count == 0) {
            error_log("Jotunheim Dashboard DB: CRITICAL - Found sections but no items. Auto-restoring...");
            $this->emergency_restore_items();
            // Re-check after restore
            $items_count = $wpdb->get_var("SELECT COUNT(*) FROM {$this->items_table}");
            error_log("Jotunheim Dashboard DB: After emergency restore, found {$items_count} items");
        }
        
        $sql = "
            SELECT 
                s.section_key,
                s.section_name,
                s.display_order as section_order,
                s.is_active as section_enabled,
                s.icon as section_icon,
                s.description as section_description,
                i.item_key,
                i.item_name,
                i.callback_function,
                i.quick_action,
                i.display_order as item_order,
                i.icon,
                i.description,
                i.permissions,
                i.is_active as item_enabled
            FROM {$this->sections_table} s
            LEFT JOIN {$this->items_table} i ON s.id = i.section_id
            WHERE s.is_active = 1 AND (i.is_active = 1 OR i.is_active IS NULL)
            ORDER BY s.display_order, i.display_order
        ";
        
        $results = $wpdb->get_results($sql);
        
        if ($wpdb->last_error) {
            error_log("Jotunheim Dashboard DB: SQL Error: " . $wpdb->last_error);
        }
        
        // Group by sections
        $config = array();
        foreach ($results as $row) {
            if (!isset($config[$row->section_key])) {
                $config[$row->section_key] = array(
                    'title' => $row->section_name,
                    'description' => $row->section_description ?: '', // Use database value or empty string
                    'icon' => $row->section_icon ?: '', // Use database value or empty string
                    'order' => $row->section_order,
                    'enabled' => (bool)$row->section_enabled, // Use actual database value
                    'items' => array()
                );
            }
            
            if ($row->item_key) {
                $config[$row->section_key]['items'][] = array(
                    'item_id' => $row->item_key,
                    'title' => $row->item_name,
                    'callback' => $row->callback_function,
                    'enabled' => (bool)$row->item_enabled, // Use actual database value
                    'quick_action' => (bool)$row->quick_action, // Add back the quick_action field
                    'order' => $row->item_order,
                    'icon' => $row->icon,
                    'description' => $row->description,
                    'permissions' => $row->permissions
                );
            }
        }
        
        return $config;
    }

    /**
     * Get FULL configuration including disabled sections (for config interface)
     */
    public function get_full_configuration_for_admin() {
        global $wpdb;
        
        // Get ALL sections (no filtering)
        $sections_sql = "SELECT * FROM {$this->sections_table} ORDER BY display_order";
        $sections = $wpdb->get_results($sections_sql);
        
        // Get ALL items (no filtering) 
        $items_sql = "SELECT i.*, s.section_key 
                     FROM {$this->items_table} i 
                     LEFT JOIN {$this->sections_table} s ON i.section_id = s.id 
                     ORDER BY i.display_order";
        $items = $wpdb->get_results($items_sql);
        
        // Group by sections
        $config = array();
        
        // First, create all sections
        foreach ($sections as $section) {
            $config[$section->section_key] = array(
                'title' => $section->section_name,
                'description' => $section->description ?: '', // Use database value or empty string
                'icon' => $section->icon ?: '', // Use database value or empty string
                'order' => $section->display_order,
                'enabled' => (bool)$section->is_active,
                'items' => array()
            );
        }
        
        // Then, add all items to their sections
        foreach ($items as $item) {
            if ($item->section_key && isset($config[$item->section_key])) {
                $config[$item->section_key]['items'][] = array(
                    'item_id' => $item->item_key,
                    'title' => $item->item_name,
                    'callback' => $item->callback_function,
                    'enabled' => (bool)$item->is_active,
                    'quick_action' => (bool)$item->quick_action,
                    'order' => $item->display_order,
                    'icon' => $item->icon,
                    'description' => $item->description,
                    'permissions' => $item->permissions
                );
            }
        }
        
        return $config;
    }
    
    /**
     * Add or update a section
     */
    public function save_section($section_key, $section_name, $display_order = 0, $description = '', $icon = '', $enabled = 1) {
        global $wpdb;
        
        $result = $wpdb->replace(
            $this->sections_table,
            array(
                'section_key' => $section_key,
                'section_name' => $section_name,
                'display_order' => $display_order,
                'is_active' => $enabled ? 1 : 0,
                'icon' => $icon,
                'description' => $description,
                'updated_at' => current_time('mysql')
            ),
            array('%s', '%s', '%d', '%d', '%s', '%s', '%s')
        );
        
        return $result !== false;
    }

    /**
     * Update section enabled status
     */
    public function update_section_enabled($section_key, $enabled) {
        global $wpdb;
        
        $result = $wpdb->update(
            $this->sections_table,
            array(
                'is_active' => $enabled ? 1 : 0,
                'updated_at' => current_time('mysql')
            ),
            array('section_key' => $section_key),
            array('%d', '%s'),
            array('%s')
        );
        
        if ($result === false) {
            error_log('Jotunheim Dashboard DB: Failed to update section enabled status for: ' . $section_key);
            return false;
        }
        
        error_log('Jotunheim Dashboard DB: Updated section ' . $section_key . ' enabled to: ' . ($enabled ? 'true' : 'false'));
        return true;
    }
    
    /**
     * Add or update an item
     */
    public function save_item($item_data) {
        global $wpdb;
        
        // Get section ID
        $section_id = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM {$this->sections_table} WHERE section_key = %s",
            $item_data['section_key']
        ));
        
        if (!$section_id) {
            error_log('Jotunheim Dashboard DB: Section not found: ' . $item_data['section_key']);
            return false;
        }
        
        error_log('Jotunheim Dashboard DB: Saving item ' . $item_data['item_key'] . ' to section_id ' . $section_id);
        
        $result = $wpdb->replace(
            $this->items_table,
            array(
                'section_id' => $section_id,
                'item_key' => $item_data['item_key'],
                'item_name' => $item_data['item_name'],
                'callback_function' => $item_data['callback_function'],
                'quick_action' => isset($item_data['quick_action']) ? ($item_data['quick_action'] ? 1 : 0) : 0,
                'display_order' => isset($item_data['display_order']) ? $item_data['display_order'] : 0,
                'is_active' => isset($item_data['enabled']) ? ($item_data['enabled'] ? 1 : 0) : 1,
                'icon' => isset($item_data['icon']) ? $item_data['icon'] : null,
                'description' => isset($item_data['description']) ? $item_data['description'] : null,
                'permissions' => isset($item_data['permissions']) ? $item_data['permissions'] : null,
                'updated_at' => current_time('mysql')
            ),
            array('%d', '%s', '%s', '%s', '%d', '%d', '%d', '%s', '%s', '%s', '%s')
        );
        
        if ($result === false) {
            error_log('Jotunheim Dashboard DB: Failed to save item ' . $item_data['item_key'] . ': ' . $wpdb->last_error);
        } else {
            error_log('Jotunheim Dashboard DB: Successfully saved item ' . $item_data['item_key']);
        }
        
        return $result !== false;
    }
    
    /**
     * Add a new menu item (wrapper for save_item with proper data transformation)
     */
    public function add_menu_item($item_data) {
        // Handle additional metadata (like shortcode) by storing in description as JSON
        $description = $item_data['description'] ?? '';
        $metadata = [];
        
        if (!empty($item_data['shortcode'])) {
            $metadata['shortcode'] = $item_data['shortcode'];
            $metadata['description'] = $description;
            $description = json_encode($metadata);
        }
        
        // Transform the data to match what save_item expects
        $normalized_data = array(
            'section_key' => $item_data['section'] ?? 'main',
            'item_key' => $item_data['id'],
            'item_name' => $item_data['menu_title'] ?? $item_data['title'],
            'callback_function' => $item_data['callback'],
            'quick_action' => $item_data['quick_action'] ?? false,
            'display_order' => $item_data['order'] ?? 0,
            'enabled' => $item_data['enabled'] ?? true,
            'description' => $description,
            'icon' => $item_data['icon'] ?? null
        );
        
        return $this->save_item($normalized_data);
    }
    
    /**
     * Delete a menu item by its key
     */
    public function delete_menu_item($item_key) {
        global $wpdb;
        
        $result = $wpdb->delete(
            $this->items_table,
            array('item_key' => $item_key),
            array('%s')
        );
        
        if ($result === false) {
            error_log('Jotunheim Dashboard DB: Failed to delete item ' . $item_key . ': ' . $wpdb->last_error);
            return false;
        } else {
            error_log('Jotunheim Dashboard DB: Successfully deleted item ' . $item_key);
            return true;
        }
    }
    
    /**
     * Migrate from old serialized format
     */
    public function migrate_from_serialized() {
        $old_db = new Jotunheim_Dashboard_DB();
        $old_config = $old_db->load_config('dashboard_config');
        
        if (!$old_config || !isset($old_config['sections'])) {
            error_log('Jotunheim Dashboard DB: No old config to migrate');
            return false;
        }
        
        error_log('Jotunheim Dashboard DB: Starting migration from serialized format');
        
        // Migrate sections
        foreach ($old_config['sections'] as $section_key => $section_data) {
            $this->save_section($section_key, $section_data['name'], $section_data['order'] ?? 0);
        }
        
        // Migrate items
        if (isset($old_config['items'])) {
            foreach ($old_config['items'] as $item) {
                if (isset($item['id'])) {
                    $item_data = array(
                        'section_key' => $item['section'] ?? 'System Configuration',
                        'item_key' => $item['id'],
                        'item_name' => $item['name'] ?? $item['id'],
                        'callback_function' => $item['callback'] ?? '',
                        'quick_action' => $item['quick_action'] ?? false,
                        'display_order' => $item['order'] ?? 0
                    );
                    
                    $this->save_item($item_data);
                }
            }
        }
        
        error_log('Jotunheim Dashboard DB: Migration completed');
        return true;
    }
    
    /**
     * Clear all data from normalized database tables
     */
    public function clear_all_data() {
        global $wpdb;
        
        // Clear items first (due to foreign key constraint)
        $wpdb->query("DELETE FROM {$this->items_table}");
        
        // Then clear sections
        $wpdb->query("DELETE FROM {$this->sections_table}");
        
        error_log('Jotunheim Dashboard DB: Cleared all data from normalized tables');
    }
    
    /**
     * Emergency restore of default menu items when items table is empty
     */
    public function emergency_restore_items() {
        error_log('Jotunheim Dashboard DB: EMERGENCY RESTORE - Rebuilding default menu items');
        
        // Default menu items structure
        $default_items = [
            // Core Management
            [
                'section_key' => 'core',
                'item_key' => 'prefab_image_import',
                'item_name' => 'Prefab Image Import',
                'callback_function' => 'render_prefab_image_import_page',
                'display_order' => 1,
                'quick_action' => 0
            ],
            
            // Item Management
            [
                'section_key' => 'items',
                'item_key' => 'item_list_editor',
                'item_name' => 'Item List Editor',
                'callback_function' => 'render_item_list_editor_page',
                'display_order' => 2,
                'quick_action' => 1
            ],
            [
                'section_key' => 'items',
                'item_key' => 'item_list_add_new_item',
                'item_name' => 'Add New Item',
                'callback_function' => 'render_item_list_add_new_item_page',
                'display_order' => 3,
                'quick_action' => 0
            ],
            
            // Event Management
            [
                'section_key' => 'events',
                'item_key' => 'event_zone_editor',
                'item_name' => 'Event Zone Editor',
                'callback_function' => 'render_event_zone_editor_page',
                'display_order' => 4,
                'quick_action' => 1
            ],
            [
                'section_key' => 'events',
                'item_key' => 'add_event_zone',
                'item_name' => 'Add Event Zone',
                'callback_function' => 'render_add_event_zone_page',
                'display_order' => 5,
                'quick_action' => 0
            ],
            [
                'section_key' => 'events',
                'item_key' => 'eventzone_field_config',
                'item_name' => 'EventZone Field Config',
                'callback_function' => 'render_eventzone_field_config_page',
                'display_order' => 6,
                'quick_action' => 0
            ],
            
            // Commerce & Trading
            [
                'section_key' => 'commerce',
                'item_key' => 'trade',
                'item_name' => 'Trade',
                'callback_function' => 'render_trade_page',
                'display_order' => 7,
                'quick_action' => 0
            ],
            [
                'section_key' => 'commerce',
                'item_key' => 'barter',
                'item_name' => 'Barter',
                'callback_function' => 'render_barter_page',
                'display_order' => 8,
                'quick_action' => 0
            ],
            [
                'section_key' => 'commerce',
                'item_key' => 'point_of_sale',
                'item_name' => 'Point of Sale',
                'callback_function' => 'render_pos_interface_page',
                'display_order' => 9,
                'quick_action' => 1
            ],
            [
                'section_key' => 'commerce',
                'item_key' => 'player_list_management',
                'item_name' => 'Player List Management',
                'callback_function' => 'jotun_playerlist_interface',
                'display_order' => 10,
                'quick_action' => 0
            ],
            
            // System Configuration
            [
                'section_key' => 'system',
                'item_key' => 'dashboard_config',
                'item_name' => 'Dashboard Configuration',
                'callback_function' => 'render_dashboard_config_page',
                'display_order' => 11,
                'quick_action' => 1
            ],
            [
                'section_key' => 'system',
                'item_key' => 'discord_auth_config',
                'item_name' => 'Discord Auth Configuration',
                'callback_function' => 'render_discord_auth_config_page',
                'display_order' => 12,
                'quick_action' => 0
            ],
            [
                'section_key' => 'system',
                'item_key' => 'page_permissions',
                'item_name' => 'Page Permissions',
                'callback_function' => 'render_page_permissions_config_page',
                'display_order' => 13,
                'quick_action' => 0
            ],
            [
                'section_key' => 'system',
                'item_key' => 'universal_ui_table_config',
                'item_name' => 'Universal UI Table Config',
                'callback_function' => 'render_universal_ui_table_config_page',
                'display_order' => 14,
                'quick_action' => 0
            ],
            [
                'section_key' => 'system',
                'item_key' => 'weather_calendar_config',
                'item_name' => 'Weather Calendar Config',
                'callback_function' => 'render_weather_calendar_config_page',
                'display_order' => 15,
                'quick_action' => 0
            ]
        ];
        
        $restored_count = 0;
        foreach ($default_items as $item) {
            if ($this->save_item($item)) {
                $restored_count++;
            }
        }
        
        error_log("Jotunheim Dashboard DB: Emergency restore completed - restored {$restored_count} items");
        return $restored_count;
    }
    
    /**
     * Save full configuration from frontend format
     */
    public function save_full_configuration($config_data) {
        global $wpdb;
        
        error_log('Jotunheim Dashboard DB: Starting save_full_configuration');
        error_log('Jotunheim Dashboard DB: Config data: ' . print_r($config_data, true));
        
        // Start transaction
        $wpdb->query('START TRANSACTION');
        
        try {
            $saved_sections = 0;
            $saved_items = 0;
            
            // Process each section in the config
            if (isset($config_data['sections']) && is_array($config_data['sections'])) {
                foreach ($config_data['sections'] as $section_key => $section_data) {
                    // Save section
                    $section_result = $this->save_section(
                        $section_key,
                        $section_data['title'] ?? $section_key,
                        $section_data['order'] ?? 0,
                        $section_data['description'] ?? '',
                        $section_data['icon'] ?? '',
                        $section_data['enabled'] ?? true
                    );
                    
                    if ($section_result) {
                        $saved_sections++;
                    }
                    
                    // Save items in this section
                    if (isset($section_data['items']) && is_array($section_data['items'])) {
                        foreach ($section_data['items'] as $item) {
                            $item_data = [
                                'section_key' => $section_key,
                                'item_key' => $item['id'] ?? $item['item_id'] ?? '',
                                'item_name' => $item['title'] ?? $item['name'] ?? '',
                                'callback_function' => $item['callback'] ?? '',
                                'quick_action' => $item['quick_action'] ?? false,
                                'display_order' => $item['order'] ?? 0,
                                'enabled' => $item['enabled'] ?? true,
                                'icon' => $item['icon'] ?? null,
                                'description' => $item['description'] ?? null,
                                'permissions' => $item['permissions'] ?? null
                            ];
                            
                            if ($this->save_item($item_data)) {
                                $saved_items++;
                            }
                        }
                    }
                }
            }
            
            // Commit transaction
            $wpdb->query('COMMIT');
            
            error_log("Jotunheim Dashboard DB: Saved {$saved_sections} sections and {$saved_items} items");
            
            return [
                'success' => true,
                'sections_saved' => $saved_sections,
                'items_saved' => $saved_items
            ];
            
        } catch (Exception $e) {
            // Rollback on error
            $wpdb->query('ROLLBACK');
            
            error_log('Jotunheim Dashboard DB: Save configuration error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}