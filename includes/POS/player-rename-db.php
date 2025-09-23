<?php
/**
 * Player Rename Database Management
 * Creates and manages the jotun_player_rename_history table for tracking all player name changes
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class JotunPlayerRenameDB {
    
    public static function create_table() {
        global $wpdb;
        
        $table_name = 'jotun_player_rename_history';
        
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE $table_name (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            player_id bigint(20) NOT NULL,
            old_name varchar(255) NOT NULL,
            new_name varchar(255) NOT NULL,
            renamed_by bigint(20) DEFAULT NULL,
            rename_date datetime NOT NULL,
            notes text DEFAULT NULL,
            PRIMARY KEY (id),
            KEY player_id (player_id),
            KEY old_name (old_name),
            KEY new_name (new_name),
            KEY rename_date (rename_date)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
        error_log("Created/Updated jotun_player_rename_history table");
    }
    
    public static function get_rename_history($player_id) {
        global $wpdb;
        
        $table_name = 'jotun_player_rename_history';
        
        return $wpdb->get_results($wpdb->prepare(
            "SELECT rh.*, u.display_name as renamed_by_name 
             FROM $table_name rh 
             LEFT JOIN {$wpdb->users} u ON rh.renamed_by = u.ID 
             WHERE rh.player_id = %d 
             ORDER BY rh.rename_date DESC",
            $player_id
        ));
    }
    
    public static function get_all_renames_for_name($name) {
        global $wpdb;
        
        $table_name = 'jotun_player_rename_history';
        
        return $wpdb->get_results($wpdb->prepare(
            "SELECT rh.*, u.display_name as renamed_by_name 
             FROM $table_name rh 
             LEFT JOIN {$wpdb->users} u ON rh.renamed_by = u.ID 
             WHERE rh.old_name = %s OR rh.new_name = %s 
             ORDER BY rh.rename_date DESC",
            $name, $name
        ));
    }
    
    public static function validate_rename_chain($old_name, $new_name) {
        global $wpdb;
        
        // Check if new name is already in use by another player
        $existing_player = $wpdb->get_row($wpdb->prepare(
            "SELECT id, activePlayerName FROM jotun_playerlist WHERE activePlayerName = %s",
            $new_name
        ));
        
        if ($existing_player) {
            return ['valid' => false, 'error' => 'Name already in use by another player'];
        }
        
        // Check if this would create a circular rename
        $rename_history = self::get_all_renames_for_name($old_name);
        foreach ($rename_history as $rename) {
            if ($rename->old_name === $new_name) {
                return ['valid' => false, 'error' => 'Cannot rename to a previously used name in the rename chain'];
            }
        }
        
        return ['valid' => true];
    }
}

// Create table on plugin activation
register_activation_hook(__FILE__, ['JotunPlayerRenameDB', 'create_table']);

// Also create when this file is loaded if table doesn't exist
add_action('init', function() {
    global $wpdb;
    $table_name = 'jotun_player_rename_history';
    
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        JotunPlayerRenameDB::create_table();
    }
});