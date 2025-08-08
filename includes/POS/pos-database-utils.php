<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Database utilities for POS system
 * Handles safe database operations and schema compatibility
 */
class POS_Database_Utils {
    
    /**
     * Check if a column exists in a table
     */
    public static function column_exists($table_name, $column_name) {
        global $wpdb;
        
        $columns = $wpdb->get_col($wpdb->prepare(
            "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = %s AND TABLE_SCHEMA = DATABASE()",
            $table_name
        ));
        return in_array($column_name, $columns);
    }
    
    /**
     * Get table columns
     */
    public static function get_table_columns($table_name) {
        global $wpdb;
        
        return $wpdb->get_col($wpdb->prepare(
            "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = %s AND TABLE_SCHEMA = DATABASE()",
            $table_name
        ));
    }
    
    /**
     * Ensure transaction_type column exists in jotun_transactions table
     */
    public static function ensure_transaction_type_column() {
        global $wpdb;
        
        $table_name = 'jotun_transactions';
        
        if (!self::column_exists($table_name, 'transaction_type')) {
            $sql = "ALTER TABLE $table_name ADD COLUMN transaction_type VARCHAR(50) DEFAULT 'general'";
            $result = $wpdb->query($sql);
            
            if ($wpdb->last_error) {
                error_log("POS: Failed to add transaction_type column: " . $wpdb->last_error);
                return false;
            }
            
            error_log("POS: Added transaction_type column to $table_name");
        }
        
        return true;
    }
    
    /**
     * Validate ledger table structure
     */
    public static function validate_ledger_table() {
        global $wpdb;
        
        $table_name = 'jotun_ledger';
        $required_columns = ['playerName', 'activePlayerName'];
        $existing_columns = self::get_table_columns($table_name);
        
        foreach ($required_columns as $column) {
            if (!in_array($column, $existing_columns)) {
                error_log("POS: Missing required column '$column' in $table_name");
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Validate transactions table structure
     */
    public static function validate_transactions_table() {
        global $wpdb;
        
        $table_name = 'jotun_transactions';
        $required_columns = ['shop_name', 'item_name', 'quantity', 'total_amount', 'customer_name', 'teller', 'transaction_date'];
        $existing_columns = self::get_table_columns($table_name);
        
        foreach ($required_columns as $column) {
            if (!in_array($column, $existing_columns)) {
                error_log("POS: Missing required column '$column' in $table_name");
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Get safe insert format for transactions table
     */
    public static function get_transaction_insert_format($include_transaction_type = false) {
        $base_format = ['%s', '%s', '%d', '%f', '%s', '%s', '%s']; // shop_name, item_name, quantity, total_amount, customer_name, teller, transaction_date
        
        if ($include_transaction_type && self::column_exists('jotun_transactions', 'transaction_type')) {
            $base_format[] = '%s'; // transaction_type
        }
        
        return $base_format;
    }
    
    /**
     * Get default player values for ledger insertion
     */
    public static function get_default_player_values($player_name) {
        return [
            'playerName' => $player_name,
            'activePlayerName' => $player_name,
            'vidar' => 0,
            'unbreakableoath' => 0,
            'eternalflame' => 0,
            'floatingrockbase' => 0,
            'rockpillar' => 0,
            'rockfingerthumb' => 0,
            'unbreakabletrees' => 0,
            'widestone' => 0,
            'greydwarfspawner' => 0,
            'pickablethistle' => 0,
            'cloudberrybush' => 0,
            'pickablemushroom' => 0,
            'blueberrybush' => 0,
            'raspberrybush' => 0,
            'bluemushroomsx50' => 0,
            'yuletree' => 0,
            'maypole' => 0,
            'jackoturnip' => 0,
            'flowercrown' => 0,
            'doorautoclose' => 0,
            'mistlandsrockgreen' => 0,
            'mistlandsrockyellow' => 0,
            'mistlandsrocksmall' => 0,
            'pickableyellowmushroom' => 0,
            'stonemarker' => 0,
            'deertrophy' => 0,
            'leechtrophy' => 0,
            'draugrelitetrophy' => 0,
            'growthtrophy' => 0,
            'seekertrophy' => 0,
            'ulvtrophy' => 0,
            'gierrahfatrophy' => 0,
            'fulingbeserkertrophy' => 0,
            'yagluthtrophy' => 0
        ];
    }
}

// Initialize database checks on plugin load
add_action('init', function() {
    if (is_admin()) {
        POS_Database_Utils::ensure_transaction_type_column();
        POS_Database_Utils::validate_ledger_table();
        POS_Database_Utils::validate_transactions_table();
    }
});