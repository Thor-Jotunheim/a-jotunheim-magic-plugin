<?php

/**
 * Dashboard Database Management
 * Handles the dashboard configuration database table
 */

class Jotunheim_Dashboard_DB {
    private $table_name;
    
    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'jotun_dashboard_config';
    }
    
    /**
     * Create the dashboard configuration table
     */
    public function create_table() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE {$this->table_name} (
            id int(11) NOT NULL AUTO_INCREMENT,
            config_key varchar(100) NOT NULL,
            config_value longtext NOT NULL,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY config_key (config_key)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $result = dbDelta($sql);
        
        error_log('Jotunheim Dashboard DB: Created/updated table: ' . $this->table_name);
        error_log('Jotunheim Dashboard DB: dbDelta result: ' . print_r($result, true));
        
        return $result;
    }
    
    /**
     * Save configuration data
     */
    public function save_config($key, $data) {
        global $wpdb;
        
        $serialized_data = maybe_serialize($data);
        
        $result = $wpdb->replace(
            $this->table_name,
            array(
                'config_key' => $key,
                'config_value' => $serialized_data,
                'updated_at' => current_time('mysql')
            ),
            array('%s', '%s', '%s')
        );
        
        if ($result === false) {
            error_log('Jotunheim Dashboard DB: Failed to save config for key: ' . $key);
            error_log('Jotunheim Dashboard DB: MySQL error: ' . $wpdb->last_error);
            return false;
        }
        
        error_log('Jotunheim Dashboard DB: Successfully saved config for key: ' . $key);
        return true;
    }
    
    /**
     * Load configuration data
     */
    public function load_config($key, $default = null) {
        global $wpdb;
        
        $result = $wpdb->get_var($wpdb->prepare(
            "SELECT config_value FROM {$this->table_name} WHERE config_key = %s",
            $key
        ));
        
        if ($result === null) {
            error_log('Jotunheim Dashboard DB: No config found for key: ' . $key . ', using default');
            return $default;
        }
        
        $unserialized = maybe_unserialize($result);
        error_log('Jotunheim Dashboard DB: Loaded config for key: ' . $key);
        
        return $unserialized;
    }
    
    /**
     * Delete configuration data
     */
    public function delete_config($key) {
        global $wpdb;
        
        $result = $wpdb->delete(
            $this->table_name,
            array('config_key' => $key),
            array('%s')
        );
        
        error_log('Jotunheim Dashboard DB: Deleted config for key: ' . $key . ' (affected rows: ' . $result . ')');
        
        return $result !== false;
    }
    
    /**
     * Check if table exists
     */
    public function table_exists() {
        global $wpdb;
        
        $table_exists = $wpdb->get_var("SHOW TABLES LIKE '{$this->table_name}'") === $this->table_name;
        
        return $table_exists;
    }
    
    /**
     * Get all configuration keys
     */
    public function get_all_config_keys() {
        global $wpdb;
        
        $keys = $wpdb->get_col("SELECT config_key FROM {$this->table_name} ORDER BY config_key");
        
        return $keys ?: array();
    }
    
    /**
     * Migrate data from WordPress options to database table
     */
    public function migrate_from_options() {
        $option_data = get_option('jotunheim_dashboard_config', null);
        
        if ($option_data !== null) {
            error_log('Jotunheim Dashboard DB: Migrating data from WordPress options');
            
            $success = $this->save_config('dashboard_config', $option_data);
            
            if ($success) {
                // Don't delete the option yet, keep as backup
                error_log('Jotunheim Dashboard DB: Successfully migrated data from options');
                return true;
            } else {
                error_log('Jotunheim Dashboard DB: Failed to migrate data from options');
                return false;
            }
        }
        
        error_log('Jotunheim Dashboard DB: No existing options data to migrate');
        return true;
    }
}