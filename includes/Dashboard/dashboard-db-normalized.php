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
     * Get all configuration keys
     */
    public function get_full_configuration() {
        global $wpdb;
        
        // Debug: Check if tables exist and have data
        $sections_count = $wpdb->get_var("SELECT COUNT(*) FROM {$this->sections_table}");
        $items_count = $wpdb->get_var("SELECT COUNT(*) FROM {$this->items_table}");
        error_log("Jotunheim Dashboard DB: Found {$sections_count} sections and {$items_count} items in normalized tables");
        
        $sql = "
            SELECT 
                s.section_key,
                s.section_name,
                s.display_order as section_order,
                i.item_key,
                i.item_name,
                i.callback_function,
                i.quick_action,
                i.display_order as item_order,
                i.icon,
                i.description,
                i.permissions
            FROM {$this->sections_table} s
            LEFT JOIN {$this->items_table} i ON s.id = i.section_id
            WHERE s.is_active = 1 AND (i.is_active = 1 OR i.is_active IS NULL)
            ORDER BY s.display_order, i.display_order
        ";
        
        $results = $wpdb->get_results($sql);
        error_log("Jotunheim Dashboard DB: SQL query returned " . count($results) . " rows");
        
        if ($wpdb->last_error) {
            error_log("Jotunheim Dashboard DB: SQL Error: " . $wpdb->last_error);
        }
        
        // Group by sections
        $config = array();
        foreach ($results as $row) {
            if (!isset($config[$row->section_key])) {
                $config[$row->section_key] = array(
                    'title' => $row->section_name,
                    'description' => 'No description available', // Default description
                    'order' => $row->section_order,
                    'enabled' => true, // Sections from DB are enabled
                    'items' => array()
                );
            }
            
            if ($row->item_key) {
                $config[$row->section_key]['items'][] = array(
                    'item_id' => $row->item_key,
                    'title' => $row->item_name,
                    'callback' => $row->callback_function,
                    'enabled' => true, // Items from DB are enabled
                    'quick_action' => (bool)$row->quick_action, // Add back the quick_action field
                    'order' => $row->item_order,
                    'icon' => $row->icon,
                    'description' => $row->description,
                    'permissions' => $row->permissions
                );
            }
        }
        
        error_log("Jotunheim Dashboard DB: Returning config with " . count($config) . " sections");
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
                'description' => $description,
                'icon' => $icon,
                'display_order' => $display_order,
                'enabled' => $enabled ? 1 : 0,
                'updated_at' => current_time('mysql')
            ),
            array('%s', '%s', '%s', '%s', '%d', '%d', '%s')
        );
        
        return $result !== false;
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
                'icon' => isset($item_data['icon']) ? $item_data['icon'] : null,
                'description' => isset($item_data['description']) ? $item_data['description'] : null,
                'permissions' => isset($item_data['permissions']) ? $item_data['permissions'] : null,
                'updated_at' => current_time('mysql')
            ),
            array('%d', '%s', '%s', '%s', '%d', '%d', '%s', '%s', '%s', '%s')
        );
        
        if ($result === false) {
            error_log('Jotunheim Dashboard DB: Failed to save item ' . $item_data['item_key'] . ': ' . $wpdb->last_error);
        } else {
            error_log('Jotunheim Dashboard DB: Successfully saved item ' . $item_data['item_key']);
        }
        
        return $result !== false;
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
}