<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Comprehensive API for all Jotunheim database tables
 * Provides CRUD operations for all major database tables
 */

// Database migration system
add_action('plugins_loaded', 'jotun_shop_migration_check');

function jotun_shop_migration_check() {
    $current_version = '1.3.0'; // Updated for buy/turnin daily limits
    $db_version = get_option('jotun_shop_db_version', '0.0.0');
    
    if (version_compare($db_version, $current_version, '<')) {
        jotun_ensure_shop_types_table();
        jotun_ensure_shops_table();
        jotun_ensure_shop_items_table();
        
        // Update the version to prevent future migrations
        update_option('jotun_shop_db_version', $current_version);
        error_log('Jotunheim POS: Database migration completed to version ' . $current_version);
    }
}

function jotun_ensure_shop_types_table() {
    global $wpdb;
    
    $shop_types_table = 'jotun_shop_types';
    
    // Check if table exists
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$shop_types_table'") == $shop_types_table;
    
    if (!$table_exists) {
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE $shop_types_table (
            type_id int(11) NOT NULL AUTO_INCREMENT,
            type_name varchar(100) NOT NULL,
            type_key varchar(50) NOT NULL,
            description text,
            default_permissions text COMMENT 'JSON array of default Discord roles',
            is_active tinyint(1) DEFAULT 1,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (type_id),
            UNIQUE KEY unique_type_key (type_key),
            KEY idx_is_active (is_active)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
        // Insert default shop types
        jotun_insert_default_shop_types();
        
        error_log('Jotunheim POS: Created jotun_shop_types table');
    }
}

function jotun_ensure_shops_table() {
    global $wpdb;
    
    // Create jotun_shops table if it doesn't exist
    $shops_table = 'jotun_shops';
    if ($wpdb->get_var("SHOW TABLES LIKE '$shops_table'") !== $shops_table) {
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE $shops_table (
            shop_id int(11) NOT NULL AUTO_INCREMENT,
            shop_name varchar(100) NOT NULL,
            description text,
            shop_type varchar(50) DEFAULT 'player',
            staff_only tinyint(1) DEFAULT 0,
            auto_archive tinyint(1) DEFAULT 0,
            ledger_name varchar(100),
            owner_name varchar(100),
            is_active tinyint(1) DEFAULT 1,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            created_date datetime DEFAULT CURRENT_TIMESTAMP,
            created_by int(11),
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (shop_id),
            UNIQUE KEY unique_shop_name (shop_name),
            KEY idx_shop_type (shop_type),
            KEY idx_is_active (is_active),
            KEY idx_owner_name (owner_name)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
        error_log('Jotunheim POS: Created jotun_shops table');
    }
    
    // Migration: Add is_active column if it doesn't exist
    $column_exists = $wpdb->get_results("SHOW COLUMNS FROM $shops_table LIKE 'is_active'");
    if (empty($column_exists)) {
        $wpdb->query("ALTER TABLE $shops_table ADD COLUMN is_active tinyint(1) DEFAULT 1 AFTER owner_name");
        error_log('Jotunheim POS: Added is_active column to jotun_shops table');
    }
    
    // Migration: Change shop_type from ENUM to VARCHAR to support dynamic types
    $shop_type_column = $wpdb->get_row("SHOW COLUMNS FROM $shops_table LIKE 'shop_type'");
    if ($shop_type_column && strpos($shop_type_column->Type, 'enum') !== false) {
        $wpdb->query("ALTER TABLE $shops_table MODIFY COLUMN shop_type varchar(50) NOT NULL DEFAULT 'general'");
        error_log('Jotunheim POS: Changed shop_type column from ENUM to VARCHAR for dynamic types');
    }
    
    // Migration: Add current_rotation column if it doesn't exist
    $rotation_column_exists = $wpdb->get_results("SHOW COLUMNS FROM $shops_table LIKE 'current_rotation'");
    if (empty($rotation_column_exists)) {
        $wpdb->query("ALTER TABLE $shops_table ADD COLUMN current_rotation int(11) DEFAULT 1 AFTER shop_type");
        error_log('Jotunheim POS: Added current_rotation column to jotun_shops table');
    }
}

function jotun_ensure_shop_items_table() {
    global $wpdb;
    
    $shop_items_table = 'jotun_shop_items';
    
    // Check if table exists
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$shop_items_table'") == $shop_items_table;
    
    if (!$table_exists) {
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE $shop_items_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            shop_id int(11) NOT NULL,
            item_id int(11) NULL COMMENT 'Reference to jotun_itemlist, NULL for custom items',
            item_name varchar(100) NOT NULL,
            custom_price decimal(10,2) DEFAULT NULL COMMENT 'Override price, NULL uses item default',
            stock_quantity int(11) DEFAULT -1 COMMENT '-1 for unlimited stock',
            rotation int(11) DEFAULT 1 COMMENT 'Rotation number for shop item sets',
            is_available tinyint(1) DEFAULT 1,
            added_date datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY idx_shop_id (shop_id),
            KEY idx_item_id (item_id),
            KEY idx_rotation (rotation),
            KEY idx_shop_rotation (shop_id, rotation),
            KEY idx_is_available (is_available)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
        error_log('Jotunheim POS: Created jotun_shop_items table with rotation support');
    } else {
        // Migration: Modify item_id column to allow NULL for custom items
        $item_id_column = $wpdb->get_row("SHOW COLUMNS FROM $shop_items_table LIKE 'item_id'");
        if ($item_id_column && strpos(strtolower($item_id_column->Null), 'no') !== false) {
            $wpdb->query("ALTER TABLE $shop_items_table MODIFY COLUMN item_id int(11) NULL COMMENT 'Reference to jotun_itemlist, NULL for custom items'");
            error_log('Jotunheim POS: Modified item_id column to allow NULL values for custom items');
        }
        
        // Migration: Add custom_price column if it doesn't exist
        $custom_price_column_exists = $wpdb->get_results("SHOW COLUMNS FROM $shop_items_table LIKE 'custom_price'");
        if (empty($custom_price_column_exists)) {
            $wpdb->query("ALTER TABLE $shop_items_table ADD COLUMN custom_price decimal(10,2) DEFAULT NULL COMMENT 'Override price, NULL uses item default' AFTER item_name");
            error_log('Jotunheim POS: Added custom_price column to jotun_shop_items table');
        }

        // Migration: Add stock_quantity column if it doesn't exist (needed for other migrations)
        $stock_quantity_column_exists = $wpdb->get_results("SHOW COLUMNS FROM $shop_items_table LIKE 'stock_quantity'");
        if (empty($stock_quantity_column_exists)) {
            // Check if custom_price exists to determine correct positioning
            $custom_price_exists = $wpdb->get_results("SHOW COLUMNS FROM $shop_items_table LIKE 'custom_price'");
            if (!empty($custom_price_exists)) {
                $wpdb->query("ALTER TABLE $shop_items_table ADD COLUMN stock_quantity int(11) DEFAULT -1 COMMENT '-1 for unlimited stock' AFTER custom_price");
            } else {
                $wpdb->query("ALTER TABLE $shop_items_table ADD COLUMN stock_quantity int(11) DEFAULT -1 COMMENT '-1 for unlimited stock' AFTER item_name");
            }
            error_log('Jotunheim POS: Added stock_quantity column to jotun_shop_items table');
        }
        
        // Migration: Add rotation column if it doesn't exist
        $rotation_column_exists = $wpdb->get_results("SHOW COLUMNS FROM $shop_items_table LIKE 'rotation'");
        if (empty($rotation_column_exists)) {
            // Try to add after stock_quantity first, fall back to add at end if stock_quantity doesn't exist
            $stock_exists = $wpdb->get_results("SHOW COLUMNS FROM $shop_items_table LIKE 'stock_quantity'");
            if (!empty($stock_exists)) {
                $wpdb->query("ALTER TABLE $shop_items_table ADD COLUMN rotation int(11) DEFAULT 1 COMMENT 'Rotation number for shop item sets' AFTER stock_quantity");
            } else {
                $wpdb->query("ALTER TABLE $shop_items_table ADD COLUMN rotation int(11) DEFAULT 1 COMMENT 'Rotation number for shop item sets'");
            }
            error_log('Jotunheim POS: Added rotation column to jotun_shop_items table');
        }
        
        // Migration: Add is_custom_item column if it doesn't exist
        $custom_item_column_exists = $wpdb->get_results("SHOW COLUMNS FROM $shop_items_table LIKE 'is_custom_item'");
        if (empty($custom_item_column_exists)) {
            // Try to add after rotation first, fall back to add at end if rotation doesn't exist
            $rotation_exists = $wpdb->get_results("SHOW COLUMNS FROM $shop_items_table LIKE 'rotation'");
            if (!empty($rotation_exists)) {
                $wpdb->query("ALTER TABLE $shop_items_table ADD COLUMN is_custom_item tinyint(1) DEFAULT 0 COMMENT 'Flag for custom items like Aesir spells' AFTER rotation");
            } else {
                $wpdb->query("ALTER TABLE $shop_items_table ADD COLUMN is_custom_item tinyint(1) DEFAULT 0 COMMENT 'Flag for custom items like Aesir spells'");
            }
            error_log('Jotunheim POS: Added is_custom_item column to jotun_shop_items table');
        }
        
        // Migration: Make item_id nullable for custom items
        $item_id_column = $wpdb->get_row("SHOW COLUMNS FROM $shop_items_table LIKE 'item_id'");
        if ($item_id_column && strpos(strtolower($item_id_column->Null), 'no') !== false) {
            $wpdb->query("ALTER TABLE $shop_items_table MODIFY COLUMN item_id int(11) NULL COMMENT 'Reference to jotun_itemlist, NULL for custom items'");
            error_log('Jotunheim POS: Made item_id column nullable for custom items');
        }

        // Migration: Add turn-in related columns for turn-in shop types
        $turn_in_quantity_exists = $wpdb->get_results("SHOW COLUMNS FROM $shop_items_table LIKE 'turn_in_quantity'");
        if (empty($turn_in_quantity_exists)) {
            $wpdb->query("ALTER TABLE $shop_items_table ADD COLUMN turn_in_quantity int(11) DEFAULT 0 COMMENT 'Current quantity turned in by players'");
            error_log('Jotunheim POS: Added turn_in_quantity column to jotun_shop_items table');
        }

        $turn_in_requirement_exists = $wpdb->get_results("SHOW COLUMNS FROM $shop_items_table LIKE 'turn_in_requirement'");
        if (empty($turn_in_requirement_exists)) {
            $wpdb->query("ALTER TABLE $shop_items_table ADD COLUMN turn_in_requirement int(11) DEFAULT 0 COMMENT 'Required quantity to complete turn-in event'");
            error_log('Jotunheim POS: Added turn_in_requirement column to jotun_shop_items table');
        }

        $unlimited_stock_exists = $wpdb->get_results("SHOW COLUMNS FROM $shop_items_table LIKE 'unlimited_stock'");
        if (empty($unlimited_stock_exists)) {
            $wpdb->query("ALTER TABLE $shop_items_table ADD COLUMN unlimited_stock tinyint(1) DEFAULT 0 COMMENT 'Whether item has unlimited stock'");
            error_log('Jotunheim POS: Added unlimited_stock column to jotun_shop_items table');
        }

        // Migration: Add is_available column if it doesn't exist
        $is_available_exists = $wpdb->get_results("SHOW COLUMNS FROM $shop_items_table LIKE 'is_available'");
        if (empty($is_available_exists)) {
            $wpdb->query("ALTER TABLE $shop_items_table ADD COLUMN is_available tinyint(1) DEFAULT 1 COMMENT 'Whether item is available for purchase'");
            error_log('Jotunheim POS: Added is_available column to jotun_shop_items table');
        }

        // Migration: Add added_date column if it doesn't exist
        $added_date_exists = $wpdb->get_results("SHOW COLUMNS FROM $shop_items_table LIKE 'added_date'");
        if (empty($added_date_exists)) {
            $wpdb->query("ALTER TABLE $shop_items_table ADD COLUMN added_date datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'When item was added to shop'");
            error_log('Jotunheim POS: Added added_date column to jotun_shop_items table');
        }

        // Migration: Add updated_at column if it doesn't exist  
        $updated_at_exists = $wpdb->get_results("SHOW COLUMNS FROM $shop_items_table LIKE 'updated_at'");
        if (empty($updated_at_exists)) {
            $wpdb->query("ALTER TABLE $shop_items_table ADD COLUMN updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'When item was last updated'");
            error_log('Jotunheim POS: Added updated_at column to jotun_shop_items table');
        }

        // Migration: Add sell checkbox column if it doesn't exist
        $sell_exists = $wpdb->get_results("SHOW COLUMNS FROM $shop_items_table LIKE 'sell'");
        if (empty($sell_exists)) {
            $wpdb->query("ALTER TABLE $shop_items_table ADD COLUMN sell tinyint(1) DEFAULT 1 COMMENT 'Whether item can be sold to customers'");
            error_log('Jotunheim POS: Added sell column to jotun_shop_items table');
        }

        // Migration: Add buy checkbox column if it doesn't exist  
        $buy_exists = $wpdb->get_results("SHOW COLUMNS FROM $shop_items_table LIKE 'buy'");
        if (empty($buy_exists)) {
            $wpdb->query("ALTER TABLE $shop_items_table ADD COLUMN buy tinyint(1) DEFAULT 0 COMMENT 'Whether item can be bought from customers'");
            error_log('Jotunheim POS: Added buy column to jotun_shop_items table');
        }

        // Migration: Add turn_in checkbox column if it doesn't exist
        $turn_in_exists = $wpdb->get_results("SHOW COLUMNS FROM $shop_items_table LIKE 'turn_in'");
        if (empty($turn_in_exists)) {
            $wpdb->query("ALTER TABLE $shop_items_table ADD COLUMN turn_in tinyint(1) DEFAULT 0 COMMENT 'Whether item can be turned in for rewards'");
            error_log('Jotunheim POS: Added turn_in column to jotun_shop_items table');
        }

        // Migration: Remove ALL problematic constraints if they exist
        // The constraint seems to be causing issues even when shop exists
        
        // 1. Remove foreign key constraints
        $foreign_keys = $wpdb->get_results("
            SELECT CONSTRAINT_NAME 
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
            WHERE TABLE_NAME = '$shop_items_table' 
            AND CONSTRAINT_NAME LIKE '%fk%' 
            AND TABLE_SCHEMA = DATABASE()
        ");
        
        foreach ($foreign_keys as $fk) {
            $wpdb->query("ALTER TABLE $shop_items_table DROP FOREIGN KEY {$fk->CONSTRAINT_NAME}");
            error_log("Jotunheim POS: Dropped foreign key constraint {$fk->CONSTRAINT_NAME} from jotun_shop_items table");
        }

        // 2. Remove auto-generated foreign keys that might exist
        $wpdb->query("ALTER TABLE $shop_items_table DROP FOREIGN KEY IF EXISTS `{$shop_items_table}_ibfk_1`");
        $wpdb->query("ALTER TABLE $shop_items_table DROP FOREIGN KEY IF EXISTS `{$shop_items_table}_ibfk_2`");
        
        // 3. Remove problematic unique constraint that conflicts with NULL item_id
        $wpdb->query("ALTER TABLE $shop_items_table DROP INDEX IF EXISTS unique_shop_item_rotation");
        error_log("Jotunheim POS: Dropped unique_shop_item_rotation constraint from jotun_shop_items table");
        
        // 4. Remove any CHECK constraints that might be validating shop_id
        // Use a more compatible approach for older MySQL versions
        $database_name = DB_NAME;
        
        // Try to get CHECK constraints - this might not work on all MySQL versions
        $check_constraints = $wpdb->get_results($wpdb->prepare("
            SELECT CONSTRAINT_NAME 
            FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS 
            WHERE TABLE_NAME = %s 
            AND CONSTRAINT_SCHEMA = %s 
            AND CONSTRAINT_TYPE = 'CHECK'
        ", $shop_items_table, $database_name));
        
        if ($wpdb->last_error) {
            error_log("Jotunheim POS: CHECK constraint query failed (this is normal for older MySQL): " . $wpdb->last_error);
        } else {
            foreach ($check_constraints as $check) {
                $wpdb->query("ALTER TABLE $shop_items_table DROP CHECK {$check->CONSTRAINT_NAME}");
                error_log("Jotunheim POS: Dropped check constraint {$check->CONSTRAINT_NAME} from jotun_shop_items table");
            }
        }
        
        // 5. Check for and remove any database triggers that might be validating shop_id
        // Use TRIGGER_SCHEMA instead of TABLE_SCHEMA for MySQL compatibility
        $triggers = $wpdb->get_results($wpdb->prepare("
            SELECT TRIGGER_NAME 
            FROM INFORMATION_SCHEMA.TRIGGERS 
            WHERE EVENT_OBJECT_TABLE = %s 
            AND TRIGGER_SCHEMA = %s
        ", $shop_items_table, $database_name));
        
        if ($wpdb->last_error) {
            error_log("Jotunheim POS: TRIGGER query failed (this is normal for older MySQL): " . $wpdb->last_error);
        } else {
            foreach ($triggers as $trigger) {
                $wpdb->query("DROP TRIGGER IF EXISTS {$trigger->TRIGGER_NAME}");
                error_log("Jotunheim POS: Dropped trigger {$trigger->TRIGGER_NAME} from jotun_shop_items table");
            }
        }
        
        // 6. AGGRESSIVE DEBUGGING: Show current table structure and constraints
        error_log("Jotunheim POS: === AGGRESSIVE DEBUGGING START ===");
        
        $table_info = $wpdb->get_results("SHOW CREATE TABLE $shop_items_table");
        if ($table_info) {
            error_log("Jotunheim POS: Current table structure: " . $table_info[0]->{'Create Table'});
        }
        
        // Check for any remaining constraints
        $all_constraints = $wpdb->get_results($wpdb->prepare("
            SELECT * FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS 
            WHERE TABLE_NAME = %s AND CONSTRAINT_SCHEMA = %s
        ", $shop_items_table, $database_name));
        
        if (!$wpdb->last_error && $all_constraints) {
            error_log("Jotunheim POS: Remaining constraints: " . json_encode($all_constraints));
        }
        
        error_log("Jotunheim POS: === AGGRESSIVE DEBUGGING END ===");
        
        // 7. Emergency fix: Temporarily disable foreign key checks during this migration
        $wpdb->query("SET FOREIGN_KEY_CHECKS = 0");
        error_log("Jotunheim POS: Temporarily disabled foreign key checks for migration");
        
        // 8. Re-enable foreign key checks at the end
        $wpdb->query("SET FOREIGN_KEY_CHECKS = 1");
        error_log("Jotunheim POS: Re-enabled foreign key checks after migration");
        
        // Migration: Add daily selling limit fields
        $daily_limit_enabled_exists = $wpdb->get_results("SHOW COLUMNS FROM $shop_items_table LIKE 'daily_limit_enabled'");
        if (empty($daily_limit_enabled_exists)) {
            $wpdb->query("ALTER TABLE $shop_items_table ADD COLUMN daily_limit_enabled tinyint(1) DEFAULT 0 COMMENT 'Whether this item has a daily selling limit per player'");
            error_log('Jotunheim POS: Added daily_limit_enabled column to jotun_shop_items table');
        }
        
        $max_daily_sell_quantity_exists = $wpdb->get_results("SHOW COLUMNS FROM $shop_items_table LIKE 'max_daily_sell_quantity'");
        if (empty($max_daily_sell_quantity_exists)) {
            $wpdb->query("ALTER TABLE $shop_items_table ADD COLUMN max_daily_sell_quantity int(11) DEFAULT 0 COMMENT 'Maximum quantity a player can sell per 24-hour period'");
            error_log('Jotunheim POS: Added max_daily_sell_quantity column to jotun_shop_items table');
        }
        
        // Migration: Add daily buying limit fields
        $buy_daily_limit_enabled_exists = $wpdb->get_results("SHOW COLUMNS FROM $shop_items_table LIKE 'buy_daily_limit_enabled'");
        if (empty($buy_daily_limit_enabled_exists)) {
            $wpdb->query("ALTER TABLE $shop_items_table ADD COLUMN buy_daily_limit_enabled tinyint(1) DEFAULT 0 COMMENT 'Whether this item has a daily buying limit per player'");
            error_log('Jotunheim POS: Added buy_daily_limit_enabled column to jotun_shop_items table');
        }
        
        $max_daily_buy_quantity_exists = $wpdb->get_results("SHOW COLUMNS FROM $shop_items_table LIKE 'max_daily_buy_quantity'");
        if (empty($max_daily_buy_quantity_exists)) {
            $wpdb->query("ALTER TABLE $shop_items_table ADD COLUMN max_daily_buy_quantity int(11) DEFAULT 0 COMMENT 'Maximum quantity a player can buy per 24-hour period'");
            error_log('Jotunheim POS: Added max_daily_buy_quantity column to jotun_shop_items table');
        }
        
        // Migration: Add daily turn-in limit fields
        $turnin_daily_limit_enabled_exists = $wpdb->get_results("SHOW COLUMNS FROM $shop_items_table LIKE 'turnin_daily_limit_enabled'");
        if (empty($turnin_daily_limit_enabled_exists)) {
            $wpdb->query("ALTER TABLE $shop_items_table ADD COLUMN turnin_daily_limit_enabled tinyint(1) DEFAULT 0 COMMENT 'Whether this item has a daily turn-in limit per player'");
            error_log('Jotunheim POS: Added turnin_daily_limit_enabled column to jotun_shop_items table');
        }
        
        $max_daily_turnin_quantity_exists = $wpdb->get_results("SHOW COLUMNS FROM $shop_items_table LIKE 'max_daily_turnin_quantity'");
        if (empty($max_daily_turnin_quantity_exists)) {
            $wpdb->query("ALTER TABLE $shop_items_table ADD COLUMN max_daily_turnin_quantity int(11) DEFAULT 0 COMMENT 'Maximum quantity a player can turn in per 24-hour period'");
            error_log('Jotunheim POS: Added max_daily_turnin_quantity column to jotun_shop_items table');
        }
    }
    
    // Create jotun_turn_ins table for tracking turn-ins
    $turn_ins_table = 'jotun_turn_ins';
    if ($wpdb->get_var("SHOW TABLES LIKE '$turn_ins_table'") !== $turn_ins_table) {
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE $turn_ins_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            shop_id int(11) NOT NULL,
            item_name varchar(255) NOT NULL,
            quantity int(11) DEFAULT 1,
            player_name varchar(100),
            recorded_at datetime DEFAULT CURRENT_TIMESTAMP,
            recorded_by int(11),
            PRIMARY KEY (id),
            KEY idx_shop_id (shop_id),
            KEY idx_recorded_at (recorded_at),
            FOREIGN KEY (shop_id) REFERENCES jotun_shops(shop_id) ON DELETE CASCADE
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
        error_log('Jotunheim POS: Created jotun_turn_ins table');
    }
    
    // Create jotun_turn_in_trackers table for reset tracking
    $trackers_table = 'jotun_turn_in_trackers';
    if ($wpdb->get_var("SHOW TABLES LIKE '$trackers_table'") !== $trackers_table) {
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE $trackers_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            shop_id int(11) NOT NULL,
            total_count int(11) DEFAULT 0,
            last_reset datetime DEFAULT CURRENT_TIMESTAMP,
            reset_by int(11),
            PRIMARY KEY (id),
            UNIQUE KEY unique_shop_tracker (shop_id),
            FOREIGN KEY (shop_id) REFERENCES jotun_shops(shop_id) ON DELETE CASCADE
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
        error_log('Jotunheim POS: Created jotun_turn_in_trackers table');
    }
    
    // Create jotun_player_daily_sales table for tracking daily selling limits
    $daily_sales_table = 'jotun_player_daily_sales';
    if ($wpdb->get_var("SHOW TABLES LIKE '$daily_sales_table'") !== $daily_sales_table) {
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE $daily_sales_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            player_name varchar(100) NOT NULL,
            shop_id int(11) NOT NULL,
            shop_item_id int(11) NOT NULL,
            quantity_sold int(11) DEFAULT 0,
            sale_date date NOT NULL COMMENT 'Date of sales (for 24-hour reset tracking)',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY unique_player_shop_item_date (player_name, shop_id, shop_item_id, sale_date),
            KEY idx_player_name (player_name),
            KEY idx_shop_id (shop_id),
            KEY idx_sale_date (sale_date),
            KEY idx_player_date (player_name, sale_date)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
        error_log('Jotunheim POS: Created jotun_player_daily_sales table for daily selling limits');
    }
    
    // Create jotun_player_daily_buys table for tracking daily buying limits
    $daily_buys_table = 'jotun_player_daily_buys';
    if ($wpdb->get_var("SHOW TABLES LIKE '$daily_buys_table'") !== $daily_buys_table) {
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE $daily_buys_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            player_name varchar(100) NOT NULL,
            shop_id int(11) NOT NULL,
            shop_item_id int(11) NOT NULL,
            quantity_bought int(11) DEFAULT 0,
            buy_date date NOT NULL COMMENT 'Date of purchases (for 24-hour reset tracking)',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY unique_player_shop_item_date (player_name, shop_id, shop_item_id, buy_date),
            KEY idx_player_name (player_name),
            KEY idx_shop_id (shop_id),
            KEY idx_buy_date (buy_date),
            KEY idx_player_date (player_name, buy_date)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
        error_log('Jotunheim POS: Created jotun_player_daily_buys table for daily buying limits');
    }
    
    // Create jotun_player_daily_turnins table for tracking daily turn-in limits
    $daily_turnins_table = 'jotun_player_daily_turnins';
    if ($wpdb->get_var("SHOW TABLES LIKE '$daily_turnins_table'") !== $daily_turnins_table) {
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE $daily_turnins_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            player_name varchar(100) NOT NULL,
            shop_id int(11) NOT NULL,
            shop_item_id int(11) NOT NULL,
            quantity_turned_in int(11) DEFAULT 0,
            turnin_date date NOT NULL COMMENT 'Date of turn-ins (for 24-hour reset tracking)',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY unique_player_shop_item_date (player_name, shop_id, shop_item_id, turnin_date),
            KEY idx_player_name (player_name),
            KEY idx_shop_id (shop_id),
            KEY idx_turnin_date (turnin_date),
            KEY idx_player_date (player_name, turnin_date)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
        error_log('Jotunheim POS: Created jotun_player_daily_turnins table for daily turn-in limits');
    }
}

function jotun_insert_default_shop_types() {
    global $wpdb;
    
    $default_types = [
        [
            'type_name' => 'Player Shop',
            'type_key' => 'player',
            'description' => 'Standard player-owned shop',
            'default_permissions' => json_encode(['all_members']),
            'is_active' => 1
        ],
        [
            'type_name' => 'Staff Shop',
            'type_key' => 'staff',
            'description' => 'Staff-only administrative shop',
            'default_permissions' => json_encode(['staff', 'admin', 'aesir']),
            'is_active' => 1
        ],
        [
            'type_name' => 'Admin Shop',
            'type_key' => 'admin',
            'description' => 'Administrator shop with special privileges',
            'default_permissions' => json_encode(['admin', 'aesir']),
            'is_active' => 1
        ],
        [
            'type_name' => 'Popup Shop',
            'type_key' => 'popup',
            'description' => 'Temporary event-based shop',
            'default_permissions' => json_encode(['staff', 'admin', 'aesir']),
            'is_active' => 1
        ],
        [
            'type_name' => 'Turn-In Only',
            'type_key' => 'turn-in-only',
            'description' => 'Shop for tracking item turn-ins with no purchases',
            'default_permissions' => json_encode(['staff', 'admin', 'aesir']),
            'is_active' => 1
        ]
    ];
    
    foreach ($default_types as $type) {
        $wpdb->insert('jotun_shop_types', $type);
    }
}

/**
 * Check if current user has access to a specific shop type based on Discord roles
 */
function jotun_user_can_access_shop_type($shop_type_key) {
    global $wpdb;
    
    // Admin users always have access
    if (current_user_can('administrator')) {
        return true;
    }
    
    // Get shop type permissions
    $shop_type = $wpdb->get_row($wpdb->prepare(
        "SELECT default_permissions FROM jotun_shop_types WHERE type_key = %s AND is_active = 1",
        $shop_type_key
    ));
    
    if (!$shop_type) {
        return false; // Shop type doesn't exist or is inactive
    }
    
    // Parse permissions
    $required_permissions = [];
    if (!empty($shop_type->default_permissions)) {
        $required_permissions = json_decode($shop_type->default_permissions, true);
        if (!is_array($required_permissions)) {
            $required_permissions = [];
        }
    }
    
    // If no permissions required, allow access
    if (empty($required_permissions)) {
        return true;
    }
    
    // Check if user has Discord authentication
    $current_user = wp_get_current_user();
    if (!$current_user->ID) {
        return false; // User not logged in
    }
    
    // Get user's Discord roles
    $user_discord_roles = get_user_meta($current_user->ID, 'discord_roles', true);
    if (!is_array($user_discord_roles)) {
        $user_discord_roles = [];
    }
    
    // Check if user has any of the required roles using hierarchy
    if (function_exists('user_has_access')) {
        foreach ($required_permissions as $required_role) {
            if (user_has_access($user_discord_roles, $required_role)) {
                return true;
            }
        }
    } else {
        // Fallback: direct role matching if hierarchy function not available
        foreach ($required_permissions as $required_role) {
            if (in_array($required_role, $user_discord_roles)) {
                return true;
            }
        }
    }
    
    return false; // User doesn't have required permissions
}

/**
 * Get all shop types that the current user can access
 */
function jotun_get_accessible_shop_types() {
    global $wpdb;
    
    $all_shop_types = $wpdb->get_results(
        "SELECT * FROM jotun_shop_types WHERE is_active = 1 ORDER BY type_name ASC"
    );
    
    $accessible_types = [];
    foreach ($all_shop_types as $shop_type) {
        if (jotun_user_can_access_shop_type($shop_type->type_key)) {
            $accessible_types[] = $shop_type;
        }
    }
    
    return $accessible_types;
}

// Register all comprehensive REST API routes
add_action('rest_api_init', function() {
    // Debug endpoint to test API connectivity
    register_rest_route('jotun-api/v1', '/debug-test', [
        'methods' => 'GET',
        'callback' => function() {
            error_log('DEBUG: API endpoint test called successfully');
            return new WP_REST_Response(['message' => 'API is working!', 'timestamp' => current_time('mysql')], 200);
        },
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Debug endpoint to check what shops exist
    register_rest_route('jotun-api/v1', '/debug-shops', [
        'methods' => 'GET',
        'callback' => function() {
            global $wpdb;
            $shops = $wpdb->get_results("SELECT shop_id, shop_name FROM jotun_shops ORDER BY shop_id");
            error_log('DEBUG: Found ' . count($shops) . ' shops in database: ' . json_encode($shops));
            return new WP_REST_Response(['shops' => $shops], 200);
        },
        'permission_callback' => '__return_true'
    ]);
    
    // ============================================================================
    // PLAYER LIST API ENDPOINTS (jotun_playerlist)
    // ============================================================================
    
    // Get all players
    register_rest_route('jotun-api/v1', '/playerlist', [
        'methods' => 'GET',
        'callback' => 'jotun_api_get_playerlist',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Add new player
    register_rest_route('jotun-api/v1', '/playerlist', [
        'methods' => 'POST',
        'callback' => 'jotun_api_add_player',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Get single player
    register_rest_route('jotun-api/v1', '/playerlist/(?P<id>\d+)', [
        'methods' => 'GET',
        'callback' => 'jotun_api_get_single_player',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Update player
    register_rest_route('jotun-api/v1', '/playerlist/(?P<id>\d+)', [
        'methods' => 'PUT',
        'callback' => 'jotun_api_update_player',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Delete player
    register_rest_route('jotun-api/v1', '/playerlist/(?P<id>\d+)', [
        'methods' => 'DELETE',
        'callback' => 'jotun_api_delete_player',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Rename player
    register_rest_route('jotun-api/v1', '/playerlist/(?P<id>\d+)/rename', [
        'methods' => 'POST',
        'callback' => 'jotun_api_rename_player',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // ============================================================================
    // PREFAB LIST API ENDPOINTS (jotun_prefablist)
    // ============================================================================
    
    // Get all prefabs
    register_rest_route('jotun-api/v1', '/prefablist', [
        'methods' => 'GET',
        'callback' => 'jotun_api_get_prefablist',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Add new prefab
    register_rest_route('jotun-api/v1', '/prefablist', [
        'methods' => 'POST',
        'callback' => 'jotun_api_add_prefab',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Update prefab
    register_rest_route('jotun-api/v1', '/prefablist/(?P<id>\d+)', [
        'methods' => 'PUT',
        'callback' => 'jotun_api_update_prefab',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Delete prefab
    register_rest_route('jotun-api/v1', '/prefablist/(?P<id>\d+)', [
        'methods' => 'DELETE',
        'callback' => 'jotun_api_delete_prefab',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // ============================================================================
    // PREFAB CATEGORY API ENDPOINTS (jotun_prefab_category)
    // ============================================================================
    
    // Get all prefab categories
    register_rest_route('jotun-api/v1', '/prefab-categories', [
        'methods' => 'GET',
        'callback' => 'jotun_api_get_prefab_categories',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Add new prefab category
    register_rest_route('jotun-api/v1', '/prefab-categories', [
        'methods' => 'POST',
        'callback' => 'jotun_api_add_prefab_category',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Update prefab category
    register_rest_route('jotun-api/v1', '/prefab-categories/(?P<id>\d+)', [
        'methods' => 'PUT',
        'callback' => 'jotun_api_update_prefab_category',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Delete prefab category
    register_rest_route('jotun-api/v1', '/prefab-categories/(?P<id>\d+)', [
        'methods' => 'DELETE',
        'callback' => 'jotun_api_delete_prefab_category',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // ============================================================================
    // PREFAB STATUS API ENDPOINTS (jotun_prefab_status)
    // ============================================================================
    
    // Get all prefab statuses
    register_rest_route('jotun-api/v1', '/prefab-status', [
        'methods' => 'GET',
        'callback' => 'jotun_api_get_prefab_status',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Add new prefab status
    register_rest_route('jotun-api/v1', '/prefab-status', [
        'methods' => 'POST',
        'callback' => 'jotun_api_add_prefab_status',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Update prefab status
    register_rest_route('jotun-api/v1', '/prefab-status/(?P<id>\d+)', [
        'methods' => 'PUT',
        'callback' => 'jotun_api_update_prefab_status',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Delete prefab status
    register_rest_route('jotun-api/v1', '/prefab-status/(?P<id>\d+)', [
        'methods' => 'DELETE',
        'callback' => 'jotun_api_delete_prefab_status',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // ============================================================================
    // SHOPS API ENDPOINTS (jotun_shops)
    // ============================================================================
    
    // Get all shops
    register_rest_route('jotun-api/v1', '/shops', [
        'methods' => 'GET',
        'callback' => 'jotun_api_get_shops',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Add new shop
    register_rest_route('jotun-api/v1', '/shops', [
        'methods' => 'POST',
        'callback' => 'jotun_api_add_shop',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Update shop
    register_rest_route('jotun-api/v1', '/shops/(?P<id>\d+)', [
        'methods' => 'PUT',
        'callback' => 'jotun_api_update_shop',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Delete shop
    register_rest_route('jotun-api/v1', '/shops/(?P<id>\d+)', [
        'methods' => 'DELETE',
        'callback' => 'jotun_api_delete_shop',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // ============================================================================
    // SHOP TYPES API ENDPOINTS (jotun_shop_types)
    // ============================================================================
    
    // Get all shop types
    register_rest_route('jotun-api/v1', '/shop-types', [
        'methods' => 'GET',
        'callback' => 'jotun_api_get_shop_types',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Add new shop type
    register_rest_route('jotun-api/v1', '/shop-types', [
        'methods' => 'POST',
        'callback' => 'jotun_api_add_shop_type',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Update shop type
    register_rest_route('jotun-api/v1', '/shop-types/(?P<id>\d+)', [
        'methods' => 'PUT',
        'callback' => 'jotun_api_update_shop_type',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Delete shop type
    register_rest_route('jotun-api/v1', '/shop-types/(?P<id>\d+)', [
        'methods' => 'DELETE',
        'callback' => 'jotun_api_delete_shop_type',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    register_rest_route('jotun-api/v1', '/shop-types', [
        'methods' => 'GET',
        'callback' => 'jotun_api_get_shop_types',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Add new shop type
    register_rest_route('jotun-api/v1', '/shop-types', [
        'methods' => 'POST',
        'callback' => 'jotun_api_add_shop_type',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Update shop type
    register_rest_route('jotun-api/v1', '/shop-types/(?P<id>\d+)', [
        'methods' => 'PUT',
        'callback' => 'jotun_api_update_shop_type',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Delete shop type
    register_rest_route('jotun-api/v1', '/shop-types/(?P<id>\d+)', [
        'methods' => 'DELETE',
        'callback' => 'jotun_api_delete_shop_type',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Get accessible shop types for current user (based on Discord roles)
    register_rest_route('jotun-api/v1', '/shop-types/accessible', [
        'methods' => 'GET',
        'callback' => 'jotun_api_get_accessible_shop_types',
        'permission_callback' => function() {
            return is_user_logged_in();
        }
    ]);
    
    // ============================================================================
    // SHOP ITEMS API ENDPOINTS (jotun_shop_items)
    // ============================================================================
    
    // Get all shop items or items for specific shop
    register_rest_route('jotun-api/v1', '/shop-items', [
        'methods' => 'GET',
        'callback' => 'jotun_api_get_shop_items',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Add new shop item
    register_rest_route('jotun-api/v1', '/shop-items', [
        'methods' => 'POST',
        'callback' => 'jotun_api_add_shop_item',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Update and delete shop item
    register_rest_route('jotun-api/v1', '/shop-items/(?P<id>\d+)', [
        [
            'methods' => 'PUT',
            'callback' => 'jotun_api_update_shop_item',
            'permission_callback' => function() {
                return current_user_can('edit_posts');
            }
        ],
        [
            'methods' => 'DELETE',
            'callback' => 'jotun_api_delete_shop_item',
            'permission_callback' => function() {
                return current_user_can('edit_posts');
            }
        ]
    ]);
    
    // ============================================================================
    // SHOP ROTATION ENDPOINTS
    // ============================================================================
    
    // Get available rotations for a shop
    register_rest_route('jotun-api/v1', '/shops/(?P<shop_id>\d+)/rotations', [
        'methods' => 'GET',
        'callback' => 'jotun_api_get_shop_rotations',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Update shop's current rotation
    register_rest_route('jotun-api/v1', '/shops/(?P<shop_id>\d+)/current-rotation', [
        'methods' => 'PUT',
        'callback' => 'jotun_api_update_shop_rotation',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // ============================================================================
    // TURN-IN TRACKING ENDPOINTS
    // ============================================================================
    
    // Get turn-in count for a shop
    register_rest_route('jotun-api/v1', '/shops/(?P<shop_id>\d+)/turn-in-count', [
        'methods' => 'GET',
        'callback' => 'jotun_api_get_turn_in_count',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Record a turn-in
    register_rest_route('jotun-api/v1', '/turn-ins', [
        'methods' => 'POST',
        'callback' => 'jotun_api_record_turn_in',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Reset turn-in tracker for a shop
    register_rest_route('jotun-api/v1', '/shops/(?P<shop_id>\d+)/reset-turn-in-tracker', [
        'methods' => 'POST',
        'callback' => 'jotun_api_reset_turn_in_tracker',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);

    // ============================================================================
    // TRANSACTIONS API ENDPOINTS (jotun_transactions)
    // ============================================================================
    
    // Get all transactions
    register_rest_route('jotun-api/v1', '/transactions', [
        'methods' => 'GET',
        'callback' => 'jotun_api_get_transactions',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Add new transaction
    register_rest_route('jotun-api/v1', '/transactions', [
        'methods' => 'POST',
        'callback' => 'jotun_api_add_transaction',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Update transaction
    register_rest_route('jotun-api/v1', '/transactions/(?P<id>\d+)', [
        'methods' => 'PUT',
        'callback' => 'jotun_api_update_transaction',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Delete transaction
    register_rest_route('jotun-api/v1', '/transactions/(?P<id>\d+)', [
        'methods' => 'DELETE',
        'callback' => 'jotun_api_delete_transaction',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Get event progress for item
    register_rest_route('jotun-api/v1', '/transactions/event-progress/(?P<item_name>[a-zA-Z0-9-_% ]+)', [
        'methods' => 'GET',
        'callback' => 'jotun_api_get_event_progress',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // ============================================================================
    // ITEM LIST API ENDPOINTS (jotun_itemlist)
    // ============================================================================
    
    // Get all items
    register_rest_route('jotun-api/v1', '/itemlist', [
        'methods' => 'GET',
        'callback' => 'jotun_api_get_itemlist',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Add new item
    register_rest_route('jotun-api/v1', '/itemlist', [
        'methods' => 'POST',
        'callback' => 'jotun_api_add_item',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Update item
    register_rest_route('jotun-api/v1', '/itemlist/(?P<id>\d+)', [
        'methods' => 'PUT',
        'callback' => 'jotun_api_update_item',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Delete item
    register_rest_route('jotun-api/v1', '/itemlist/(?P<id>\d+)', [
        'methods' => 'DELETE',
        'callback' => 'jotun_api_delete_item',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // ============================================================================
    // LEDGER API ENDPOINTS (jotun_ledger)
    // ============================================================================
    
    // Get all ledger entries
    register_rest_route('jotun-api/v1', '/ledger', [
        'methods' => 'GET',
        'callback' => 'jotun_api_get_ledger',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Add new ledger entry
    register_rest_route('jotun-api/v1', '/ledger', [
        'methods' => 'POST',
        'callback' => 'jotun_api_add_ledger_entry',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Update ledger entry
    register_rest_route('jotun-api/v1', '/ledger/(?P<id>\d+)', [
        'methods' => 'PUT',
        'callback' => 'jotun_api_update_ledger_entry',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Delete ledger entry
    register_rest_route('jotun-api/v1', '/ledger/(?P<id>\d+)', [
        'methods' => 'DELETE',
        'callback' => 'jotun_api_delete_ledger_entry',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Daily sales limit check endpoint (using jotunheim namespace to match frontend)
    register_rest_route('jotunheim/v1', '/daily-sales-check', [
        'methods' => 'POST',
        'callback' => 'jotun_api_daily_sales_check',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Record daily sale endpoint
    register_rest_route('jotunheim/v1', '/record-daily-sale', [
        'methods' => 'POST',
        'callback' => 'jotun_api_record_daily_sale',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Daily buy limit check endpoint
    register_rest_route('jotunheim/v1', '/daily-buys-check', [
        'methods' => 'POST',
        'callback' => 'jotun_api_daily_buys_check',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Record daily buy endpoint
    register_rest_route('jotunheim/v1', '/record-daily-buy', [
        'methods' => 'POST',
        'callback' => 'jotun_api_record_daily_buy',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Daily turn-in limit check endpoint
    register_rest_route('jotunheim/v1', '/daily-turnins-check', [
        'methods' => 'POST',
        'callback' => 'jotun_api_daily_turnins_check',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Record daily turn-in endpoint
    register_rest_route('jotunheim/v1', '/record-daily-turnin', [
        'methods' => 'POST',
        'callback' => 'jotun_api_record_daily_turnin',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
});

// ============================================================================
// PLAYER LIST FUNCTIONS (jotun_playerlist)
// ============================================================================

function jotun_api_get_playerlist($request) {
    global $wpdb;
    
    $table_name = 'jotun_playerlist';
    $limit = $request->get_param('limit') ?: 1000; // Increased from 100 to show more results
    $offset = $request->get_param('offset') ?: 0;
    $search = $request->get_param('search');
    
    $sql = "SELECT * FROM $table_name";
    $params = [];
    
    if ($search) {
        $sql .= " WHERE activePlayerName LIKE %s OR player_name LIKE %s";
        $params[] = '%' . $wpdb->esc_like($search) . '%';
        $params[] = '%' . $wpdb->esc_like($search) . '%';
    }
    
    $sql .= " ORDER BY id DESC LIMIT %d OFFSET %d";
    $params[] = $limit;
    $params[] = $offset;
    
    $results = $wpdb->get_results($wpdb->prepare($sql, $params));
    
    if ($wpdb->last_error) {
        return new WP_REST_Response(['error' => 'Database error: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['data' => $results], 200);
}

function jotun_api_get_single_player($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $table_name = 'jotun_playerlist';
    
    $player = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id));
    
    if (!$player) {
        return new WP_REST_Response(['error' => 'Player not found'], 404);
    }
    
    if ($wpdb->last_error) {
        return new WP_REST_Response(['error' => 'Database error: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response($player, 200);
}

function jotun_api_add_player($request) {
    global $wpdb;
    
    $data = $request->get_json_params();
    $table_name = 'jotun_playerlist';
    
    // Debug logging
    error_log('Player Import: Attempting to add player - ' . print_r($data, true));
    error_log('Player Import: Using table name - ' . $table_name);
    
    // Basic validation
    if (empty($data['player_name']) && empty($data['playerName'])) {
        error_log('Player Import: Missing player_name');
        return new WP_REST_Response(['error' => 'Player name is required'], 400);
    }
    
    // Support both old and new field names for backwards compatibility
    $player_name = sanitize_text_field($data['playerName'] ?? $data['player_name']);
    
    // Check for existing player to prevent duplicates
    $existing_player = $wpdb->get_row($wpdb->prepare(
        "SELECT id, playerName, activePlayerName FROM $table_name WHERE playerName = %s OR activePlayerName = %s",
        $player_name,
        $player_name
    ));
    
    if ($existing_player) {
        error_log('Player Import: Duplicate detected - Player "' . $player_name . '" already exists with ID ' . $existing_player->id);
        return new WP_REST_Response([
            'message' => 'Player already exists - skipped',
            'player_name' => $player_name,
            'existing_id' => $existing_player->id,
            'skipped' => true
        ], 200);
    }
    
    // Prepare data for insertion using the intended schema
    $insert_data = [
        'playerName' => $player_name,        // Original player name
        'activePlayerName' => $player_name,  // Current active name (same initially)
        'steam_id' => sanitize_text_field($data['steam_id'] ?? ''),
        'discord_id' => sanitize_text_field($data['discord_id'] ?? ''),
        'registration_date' => current_time('mysql'),
        'created_at' => current_time('mysql'), // Add created_at since it exists in your table
        'rename_count' => 0,
        'score' => 0, // Default score
        'level' => 1, // Default level
        'is_active' => isset($data['is_active']) ? (bool)$data['is_active'] : true
    ];
    
    // Enhanced logging for debugging
    error_log('Player Import: Attempting insert with data - ' . print_r($insert_data, true));
    error_log('Player Import: Table name - ' . $table_name);
    
    $result = $wpdb->insert($table_name, $insert_data);
    
    if ($result === false) {
        $error_msg = $wpdb->last_error ?: 'Unknown database error';
        error_log('Player Import: Database insert failed - ' . $error_msg);
        error_log('Player Import: Last query - ' . $wpdb->last_query);
        return new WP_REST_Response(['error' => 'Failed to add player: ' . $error_msg], 500);
    }
    
    error_log('Player Import: Successfully added player with ID - ' . $wpdb->insert_id);
    return new WP_REST_Response(['message' => 'Player added successfully', 'id' => $wpdb->insert_id, 'data' => $insert_data], 201);
}

function jotun_api_update_player($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $data = $request->get_json_params();
    $table_name = 'jotun_playerlist';
    
    // Support both old and new field names
    $player_name = $data['activePlayerName'] ?? $data['player_name'] ?? '';
    
    if (empty($player_name)) {
        return new WP_REST_Response(['error' => 'Player name is required'], 400);
    }
    
    $update_data = [
        'activePlayerName' => sanitize_text_field($player_name),
        'steam_id' => sanitize_text_field($data['steam_id'] ?? ''),
        'discord_id' => sanitize_text_field($data['discord_id'] ?? ''),
        'is_active' => isset($data['is_active']) ? (bool)$data['is_active'] : true
    ];
    
    $result = $wpdb->update($table_name, $update_data, ['id' => $id]);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to update player: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['message' => 'Player updated successfully'], 200);
}

function jotun_api_delete_player($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $table_name = 'jotun_playerlist';
    
    $result = $wpdb->delete($table_name, ['id' => $id]);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to delete player: ' . $wpdb->last_error], 500);
    }
    
    if ($result === 0) {
        return new WP_REST_Response(['error' => 'Player not found'], 404);
    }
    
    return new WP_REST_Response(['message' => 'Player deleted successfully'], 200);
}

function jotun_api_rename_player($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $data = $request->get_json_params();
    $table_name = 'jotun_playerlist';
    
    $new_name = $data['new_name'] ?? '';
    
    if (empty($new_name)) {
        return new WP_REST_Response(['error' => 'New player name is required'], 400);
    }
    
    // Get current player data
    $player = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id));
    
    if (!$player) {
        return new WP_REST_Response(['error' => 'Player not found'], 404);
    }
    
    // Check if new name is different from current active name
    if ($player->activePlayerName === $new_name) {
        return new WP_REST_Response(['error' => 'New name is the same as current name'], 400);
    }
    
    // Find the next available rename column
    $rename_count = (int)$player->rename_count + 1;
    $rename_column = "playerRename$rename_count";
    
    // Check if we need to add the rename column
    $columns = $wpdb->get_results("DESCRIBE $table_name");
    $existing_columns = array_column($columns, 'Field');
    
    if (!in_array($rename_column, $existing_columns)) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN $rename_column varchar(255) DEFAULT NULL");
        error_log("Added rename column: $rename_column");
    }
    
    $old_name = $player->activePlayerName;
    
    // Store the current active name in the rename history
    $update_data = [
        $rename_column => $old_name,
        'activePlayerName' => sanitize_text_field($new_name),
        'last_rename_date' => current_time('mysql'),
        'rename_count' => $rename_count
    ];
    
    $result = $wpdb->update($table_name, $update_data, ['id' => $id]);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to rename player: ' . $wpdb->last_error], 500);
    }
    
    // Update all historical transactions and ledger entries
    $update_results = [];
    
    // Update jotun_transactions table - player field
    $transactions_updated = $wpdb->update(
        'jotun_transactions',
        ['player' => $new_name],
        ['player' => $old_name]
    );
    if ($transactions_updated !== false) {
        $update_results['transactions'] = $transactions_updated;
    }
    
    // Update jotun_ledger table - both activePlayerName and playerName fields
    $ledger_active_updated = $wpdb->update(
        'jotun_ledger',
        ['activePlayerName' => $new_name],
        ['activePlayerName' => $old_name]
    );
    
    $ledger_player_updated = $wpdb->update(
        'jotun_ledger',
        ['playerName' => $new_name],
        ['playerName' => $old_name]
    );
    
    if ($ledger_active_updated !== false) {
        $update_results['ledger_active'] = $ledger_active_updated;
    }
    if ($ledger_player_updated !== false) {
        $update_results['ledger_player'] = $ledger_player_updated;
    }
    
    // Create rename history entry
    $history_result = $wpdb->insert(
        'jotun_player_rename_history',
        [
            'player_id' => $id,
            'old_name' => $old_name,
            'new_name' => $new_name,
            'renamed_by' => get_current_user_id(),
            'rename_date' => current_time('mysql')
        ]
    );
    
    // Log the comprehensive rename operation
    error_log("Player rename completed - Old: $old_name, New: $new_name, Updates: " . json_encode($update_results));
    
    return new WP_REST_Response([
        'message' => 'Player renamed successfully across all systems',
        'old_name' => $old_name,
        'new_name' => $new_name,
        'rename_count' => $rename_count,
        'updates' => $update_results
    ], 200);
}

// ============================================================================
// PREFAB LIST FUNCTIONS (jotun_prefablist)
// ============================================================================

function jotun_api_get_prefablist($request) {
    global $wpdb;
    
    $table_name = 'jotun_prefablist';
    $limit = $request->get_param('limit') ?: 100;
    $offset = $request->get_param('offset') ?: 0;
    $search = $request->get_param('search');
    $category = $request->get_param('category');
    
    $sql = "SELECT * FROM $table_name";
    $params = [];
    $conditions = [];
    
    if ($search) {
        $conditions[] = "prefab_name LIKE %s";
        $params[] = '%' . $wpdb->esc_like($search) . '%';
    }
    
    if ($category) {
        $conditions[] = "category_id = %d";
        $params[] = (int)$category;
    }
    
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }
    
    $sql .= " ORDER BY id DESC LIMIT %d OFFSET %d";
    $params[] = $limit;
    $params[] = $offset;
    
    $results = $wpdb->get_results($wpdb->prepare($sql, $params));
    
    if ($wpdb->last_error) {
        return new WP_REST_Response(['error' => 'Database error: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['data' => $results], 200);
}

function jotun_api_add_prefab($request) {
    global $wpdb;
    
    $data = $request->get_json_params();
    $table_name = 'jotun_prefablist';
    
    if (empty($data['prefab_name'])) {
        return new WP_REST_Response(['error' => 'Prefab name is required'], 400);
    }
    
    $insert_data = [
        'prefab_name' => sanitize_text_field($data['prefab_name']),
        'display_name' => sanitize_text_field($data['display_name'] ?? $data['prefab_name']),
        'category_id' => (int)($data['category_id'] ?? 1),
        'is_active' => isset($data['is_active']) ? (bool)$data['is_active'] : true,
        'created_date' => current_time('mysql')
    ];
    
    $result = $wpdb->insert($table_name, $insert_data);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to add prefab: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['message' => 'Prefab added successfully', 'id' => $wpdb->insert_id], 201);
}

function jotun_api_update_prefab($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $data = $request->get_json_params();
    $table_name = 'jotun_prefablist';
    
    if (empty($data['prefab_name'])) {
        return new WP_REST_Response(['error' => 'Prefab name is required'], 400);
    }
    
    $update_data = [
        'prefab_name' => sanitize_text_field($data['prefab_name']),
        'display_name' => sanitize_text_field($data['display_name'] ?? $data['prefab_name']),
        'category_id' => (int)($data['category_id'] ?? 1),
        'is_active' => isset($data['is_active']) ? (bool)$data['is_active'] : true
    ];
    
    $result = $wpdb->update($table_name, $update_data, ['id' => $id]);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to update prefab: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['message' => 'Prefab updated successfully'], 200);
}

function jotun_api_delete_prefab($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $table_name = 'jotun_prefablist';
    
    $result = $wpdb->delete($table_name, ['id' => $id]);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to delete prefab: ' . $wpdb->last_error], 500);
    }
    
    if ($result === 0) {
        return new WP_REST_Response(['error' => 'Prefab not found'], 404);
    }
    
    return new WP_REST_Response(['message' => 'Prefab deleted successfully'], 200);
}

// ============================================================================
// PREFAB CATEGORY FUNCTIONS (jotun_prefab_category)
// ============================================================================

function jotun_api_get_prefab_categories($request) {
    global $wpdb;
    
    $table_name = 'jotun_prefab_category';
    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY category_name ASC");
    
    if ($wpdb->last_error) {
        return new WP_REST_Response(['error' => 'Database error: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['data' => $results], 200);
}

function jotun_api_add_prefab_category($request) {
    global $wpdb;
    
    $data = $request->get_json_params();
    $table_name = 'jotun_prefab_category';
    
    if (empty($data['category_name'])) {
        return new WP_REST_Response(['error' => 'Category name is required'], 400);
    }
    
    $insert_data = [
        'category_name' => sanitize_text_field($data['category_name']),
        'description' => sanitize_textarea_field($data['description'] ?? ''),
        'is_active' => isset($data['is_active']) ? (bool)$data['is_active'] : true
    ];
    
    $result = $wpdb->insert($table_name, $insert_data);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to add category: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['message' => 'Category added successfully', 'id' => $wpdb->insert_id], 201);
}

function jotun_api_update_prefab_category($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $data = $request->get_json_params();
    $table_name = 'jotun_prefab_category';
    
    if (empty($data['category_name'])) {
        return new WP_REST_Response(['error' => 'Category name is required'], 400);
    }
    
    $update_data = [
        'category_name' => sanitize_text_field($data['category_name']),
        'description' => sanitize_textarea_field($data['description'] ?? ''),
        'is_active' => isset($data['is_active']) ? (bool)$data['is_active'] : true
    ];
    
    $result = $wpdb->update($table_name, $update_data, ['id' => $id]);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to update category: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['message' => 'Category updated successfully'], 200);
}

function jotun_api_delete_prefab_category($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $table_name = 'jotun_prefab_category';
    
    $result = $wpdb->delete($table_name, ['id' => $id]);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to delete category: ' . $wpdb->last_error], 500);
    }
    
    if ($result === 0) {
        return new WP_REST_Response(['error' => 'Category not found'], 404);
    }
    
    return new WP_REST_Response(['message' => 'Category deleted successfully'], 200);
}

// ============================================================================
// PREFAB STATUS FUNCTIONS (jotun_prefab_status)
// ============================================================================

function jotun_api_get_prefab_status($request) {
    global $wpdb;
    
    $table_name = 'jotun_prefab_status';
    $prefab_id = $request->get_param('prefab_id');
    
    $sql = "SELECT * FROM $table_name";
    $params = [];
    
    if ($prefab_id) {
        $sql .= " WHERE prefab_id = %d";
        $params[] = (int)$prefab_id;
    }
    
    $sql .= " ORDER BY id DESC";
    
    if (!empty($params)) {
        $results = $wpdb->get_results($wpdb->prepare($sql, $params));
    } else {
        $results = $wpdb->get_results($sql);
    }
    
    if ($wpdb->last_error) {
        return new WP_REST_Response(['error' => 'Database error: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['data' => $results], 200);
}

function jotun_api_add_prefab_status($request) {
    global $wpdb;
    
    $data = $request->get_json_params();
    $table_name = 'jotun_prefab_status';
    
    if (empty($data['prefab_id']) || empty($data['status'])) {
        return new WP_REST_Response(['error' => 'Prefab ID and status are required'], 400);
    }
    
    $insert_data = [
        'prefab_id' => (int)$data['prefab_id'],
        'status' => sanitize_text_field($data['status']),
        'notes' => sanitize_textarea_field($data['notes'] ?? ''),
        'tested_by' => wp_get_current_user()->display_name,
        'test_date' => current_time('mysql')
    ];
    
    $result = $wpdb->insert($table_name, $insert_data);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to add status: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['message' => 'Status added successfully', 'id' => $wpdb->insert_id], 201);
}

function jotun_api_update_prefab_status($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $data = $request->get_json_params();
    $table_name = 'jotun_prefab_status';
    
    if (empty($data['status'])) {
        return new WP_REST_Response(['error' => 'Status is required'], 400);
    }
    
    $update_data = [
        'status' => sanitize_text_field($data['status']),
        'notes' => sanitize_textarea_field($data['notes'] ?? ''),
        'tested_by' => wp_get_current_user()->display_name,
        'test_date' => current_time('mysql')
    ];
    
    $result = $wpdb->update($table_name, $update_data, ['id' => $id]);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to update status: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['message' => 'Status updated successfully'], 200);
}

function jotun_api_delete_prefab_status($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $table_name = 'jotun_prefab_status';
    
    $result = $wpdb->delete($table_name, ['id' => $id]);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to delete status: ' . $wpdb->last_error], 500);
    }
    
    if ($result === 0) {
        return new WP_REST_Response(['error' => 'Status not found'], 404);
    }
    
    return new WP_REST_Response(['message' => 'Status deleted successfully'], 200);
}

// ============================================================================
// SHOPS FUNCTIONS (jotun_shops)
// ============================================================================

function jotun_api_get_shops($request) {
    global $wpdb;
    
    $table_name = 'jotun_shops';
    $shop_type = $request->get_param('type'); // 'player' or 'staff'
    
    $sql = "SELECT * FROM $table_name";
    $params = [];
    
    if ($shop_type) {
        $sql .= " WHERE shop_type = %s";
        $params[] = $shop_type;
    }
    
    $sql .= " ORDER BY shop_name ASC";
    
    if (!empty($params)) {
        $results = $wpdb->get_results($wpdb->prepare($sql, $params));
    } else {
        $results = $wpdb->get_results($sql);
    }
    
    if ($wpdb->last_error) {
        return new WP_REST_Response(['error' => 'Database error: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['data' => $results], 200);
}

function jotun_api_add_shop($request) {
    global $wpdb;
    
    $data = $request->get_json_params();
    $table_name = 'jotun_shops';
    
    error_log('jotun_api_add_shop using table: ' . $table_name);
    
    // Debug logging
    error_log('jotun_api_add_shop received data: ' . print_r($data, true));
    error_log('jotun_api_add_shop shop_type value: ' . var_export($data['shop_type'] ?? 'NOT_SET', true));
    error_log('jotun_api_add_shop is_active value: ' . var_export($data['is_active'] ?? 'NOT_SET', true));
    
    if (empty($data['shop_name'])) {
        return new WP_REST_Response(['error' => 'Shop name is required'], 400);
    }
    
    // Check for duplicate shop names
    $existing_shop = $wpdb->get_var($wpdb->prepare(
        "SELECT shop_id FROM $table_name WHERE shop_name = %s",
        $data['shop_name']
    ));
    
    if ($existing_shop) {
        return new WP_REST_Response(['error' => 'A shop with this name already exists'], 400);
    }
    
    // Get current user info for owner_name
    $current_user = wp_get_current_user();
    $owner_name = $current_user->display_name ?: $current_user->user_login;
    
    $insert_data = [
        'shop_name' => sanitize_text_field($data['shop_name']),
        'shop_type' => sanitize_text_field($data['shop_type'] ?? 'general'),
        'owner_name' => $owner_name,
        'is_active' => intval($data['is_active'] ?? 1),
        'created_at' => current_time('mysql')
    ];
    
    error_log('jotun_api_add_shop insert_data: ' . print_r($insert_data, true));
    
    // Debug: Check table structure
    $table_structure = $wpdb->get_results("DESCRIBE $table_name");
    error_log('jotun_api_add_shop table structure: ' . print_r($table_structure, true));
    
    $result = $wpdb->insert($table_name, $insert_data);
    
    error_log('jotun_api_add_shop insert result: ' . var_export($result, true));
    error_log('jotun_api_add_shop wpdb->last_error: ' . $wpdb->last_error);
    
    if ($result === false) {
        $error_msg = 'Failed to add shop. Database error: ' . $wpdb->last_error;
        $error_msg .= '. Insert data was: ' . print_r($insert_data, true);
        error_log('jotun_api_add_shop ERROR: ' . $error_msg);
        return new WP_REST_Response(['error' => 'Failed to add shop: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['message' => 'Shop added successfully', 'id' => $wpdb->insert_id], 201);
}

function jotun_api_update_shop($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $data = $request->get_json_params();
    $table_name = 'jotun_shops';
    
    if (empty($data['shop_name'])) {
        return new WP_REST_Response(['error' => 'Shop name is required'], 400);
    }
    
    $update_data = [
        'shop_name' => sanitize_text_field($data['shop_name']),
        'shop_type' => sanitize_text_field($data['shop_type'] ?? 'general'),
        'is_active' => intval($data['is_active'] ?? 1)
    ];
    
    // If owner_name is provided, update it
    if (!empty($data['owner_name'])) {
        $update_data['owner_name'] = sanitize_text_field($data['owner_name']);
    }
    
    $result = $wpdb->update($table_name, $update_data, ['shop_id' => $id]);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to update shop: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['message' => 'Shop updated successfully'], 200);
}

function jotun_api_delete_shop($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $table_name = 'jotun_shops';
    
    $result = $wpdb->delete($table_name, ['shop_id' => $id]);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to delete shop: ' . $wpdb->last_error], 500);
    }
    
    if ($result === 0) {
        return new WP_REST_Response(['error' => 'Shop not found'], 404);
    }
    
    return new WP_REST_Response(['message' => 'Shop deleted successfully'], 200);
}

// ============================================================================
// SHOP ITEMS FUNCTIONS (jotun_shop_items)
// ============================================================================

function jotun_api_get_shop_items($request) {
    global $wpdb;
    
    $table_name = 'jotun_shop_items';
    $shop_id = $request->get_param('shop_id');
    $rotation = $request->get_param('rotation');
    $limit = $request->get_param('limit') ?: 100;
    $offset = $request->get_param('offset') ?: 0;
    
    error_log('jotun_api_get_shop_items: Called with shop_id=' . $shop_id . ', rotation=' . $rotation);
    
    $sql = "SELECT si.*, il.item_name as master_item_name, il.unit_price as default_price, il.icon_image 
            FROM $table_name si 
            LEFT JOIN jotun_itemlist il ON si.item_id = il.id";
    $params = [];
    $where_clauses = [];
    
    if ($shop_id) {
        $where_clauses[] = "si.shop_id = %d";
        $params[] = (int)$shop_id;
    }
    
    if ($rotation !== null) {
        $where_clauses[] = "si.rotation = %d";
        $params[] = (int)$rotation;
    }
    
    if (!empty($where_clauses)) {
        $sql .= " WHERE " . implode(" AND ", $where_clauses);
    }
    
    $sql .= " ORDER BY si.item_name ASC LIMIT %d OFFSET %d";
    $params[] = $limit;
    $params[] = $offset;
    
    error_log('jotun_api_get_shop_items: SQL query: ' . $sql);
    error_log('jotun_api_get_shop_items: Parameters: ' . print_r($params, true));
    
    $results = $wpdb->get_results($wpdb->prepare($sql, $params));
    
    error_log('jotun_api_get_shop_items: Found ' . count($results) . ' shop items');
    if ($wpdb->last_error) {
        error_log('jotun_api_get_shop_items: Database error: ' . $wpdb->last_error);
    }
    
    // Log detailed results for debugging
    foreach ($results as $index => $item) {
        error_log("jotun_api_get_shop_items: Item $index - name: {$item->item_name}, sell: {$item->sell}, buy: {$item->buy}, turn_in: {$item->turn_in}, icon_image: {$item->icon_image}");
    }
    
    if ($wpdb->last_error) {
        return new WP_REST_Response(['error' => 'Database error: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['data' => $results], 200);
}

function jotun_api_add_shop_item($request) {
    global $wpdb;
    
    $data = $request->get_json_params();
    $table_name = 'jotun_shop_items';
    
    // Debug logging
    error_log('DEBUG - Add shop item received data: ' . json_encode($data));
    
    if (empty($data['shop_id'])) {
        error_log('DEBUG - Missing shop_id');
        return new WP_REST_Response(['error' => 'Shop ID is required'], 400);
    }
    
    // Validate that the shop exists in jotun_shops table
    error_log('DEBUG - Checking if shop ID ' . $data['shop_id'] . ' exists in jotun_shops table');
    $shop_exists = $wpdb->get_var($wpdb->prepare(
        "SELECT shop_id FROM jotun_shops WHERE shop_id = %d",
        (int)$data['shop_id']
    ));
    
    error_log('DEBUG - Shop validation query result: ' . ($shop_exists ? 'FOUND' : 'NOT FOUND'));
    
    if (!$shop_exists) {
        error_log('DEBUG - Shop ID ' . $data['shop_id'] . ' does not exist in jotun_shops table');
        return new WP_REST_Response(['error' => 'Shop ID ' . $data['shop_id'] . ' does not exist'], 404);
    }
    
    error_log('DEBUG - Shop validation passed, proceeding with item creation');
    
    // Check if it's a custom item or regular item
    $is_custom_item = !empty($data['custom_item_name']);
    
    if (!$is_custom_item && empty($data['item_id'])) {
        error_log('DEBUG - Missing item_id for regular item');
        return new WP_REST_Response(['error' => 'Item ID is required for regular items'], 400);
    }
    
    // Get item details from master list for regular items
    $item_name = '';
    if (!$is_custom_item) {
        $item = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM jotun_itemlist WHERE id = %d", 
            (int)$data['item_id']
        ));
        
        if (!$item) {
            return new WP_REST_Response(['error' => 'Item not found in master list'], 404);
        }
        $item_name = $item->item_name;
    } else {
        $item_name = sanitize_text_field($data['custom_item_name']);
    }
    
    $insert_data = [
        'shop_id' => (int)$data['shop_id'],
        'item_id' => $is_custom_item ? null : (int)$data['item_id'],
        'item_name' => $item_name,
        'rotation' => (int)($data['rotation'] ?? 1), // Default to rotation 1
        'is_available' => isset($data['is_available']) ? (bool)$data['is_available'] : true,
        'added_date' => current_time('mysql')
    ];

    // Add stock_quantity if column exists
    $stock_quantity_exists = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'stock_quantity'");
    if (!empty($stock_quantity_exists)) {
        $insert_data['stock_quantity'] = (int)($data['stock_quantity'] ?? -1);
    }

    // Add unlimited_stock if column exists
    $unlimited_stock_exists = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'unlimited_stock'");
    if (!empty($unlimited_stock_exists)) {
        $insert_data['unlimited_stock'] = isset($data['unlimited_stock']) ? (bool)$data['unlimited_stock'] : false;
    }

    // Add turn_in_quantity if column exists
    $turn_in_quantity_exists = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'turn_in_quantity'");
    if (!empty($turn_in_quantity_exists)) {
        $insert_data['turn_in_quantity'] = (int)($data['turn_in_quantity'] ?? 0);
    }

    // Add turn_in_requirement if column exists
    $turn_in_requirement_exists = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'turn_in_requirement'");
    if (!empty($turn_in_requirement_exists)) {
        $insert_data['turn_in_requirement'] = (int)($data['turn_in_requirement'] ?? 0);
    }

    // Add custom_price if the column exists and value provided
    $custom_price_exists = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'custom_price'");
    if (!empty($custom_price_exists) && !empty($data['custom_price'])) {
        $insert_data['custom_price'] = floatval($data['custom_price']);
    }
    
    // Add is_custom_item if column exists
    $is_custom_item_exists = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'is_custom_item'");
    if (!empty($is_custom_item_exists) && $is_custom_item) {
        $insert_data['is_custom_item'] = 1;
    }

    // Add new checkbox fields if columns exist
    $sell_exists = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'sell'");
    if (!empty($sell_exists)) {
        $insert_data['sell'] = isset($data['sell']) ? (bool)$data['sell'] : true; // Default to sellable
    }

    $buy_exists = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'buy'");
    if (!empty($buy_exists)) {
        $insert_data['buy'] = isset($data['buy']) ? (bool)$data['buy'] : false; // Default not buyable
    }

    $turn_in_exists = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'turn_in'");
    if (!empty($turn_in_exists)) {
        $insert_data['turn_in'] = isset($data['turn_in']) ? (bool)$data['turn_in'] : false; // Default not turn-in
    }
    
    // Enhanced debug logging
    error_log('DEBUG - Final insert data: ' . json_encode($insert_data));
    
    // Check for existing duplicate before inserting (only if table has proper structure)
    $table_structure = $wpdb->get_results("SHOW COLUMNS FROM $table_name");
    $has_id_column = false;
    foreach ($table_structure as $column) {
        if ($column->Field === 'id') {
            $has_id_column = true;
            break;
        }
    }
    
    if ($has_id_column) {
        if ($is_custom_item) {
            // For custom items, check by shop_id, custom_item_name, and rotation
            $existing_check = $wpdb->get_row($wpdb->prepare(
                "SELECT id FROM $table_name WHERE shop_id = %d AND item_name = %s AND rotation = %d AND item_id IS NULL",
                $insert_data['shop_id'],
                $insert_data['item_name'],
                $insert_data['rotation']
            ));
        } else {
            // For regular items, check by shop_id, item_id, and rotation
            $existing_check = $wpdb->get_row($wpdb->prepare(
                "SELECT id FROM $table_name WHERE shop_id = %d AND item_id = %d AND rotation = %d",
                $insert_data['shop_id'],
                $insert_data['item_id'],
                $insert_data['rotation']
            ));
        }
        
        if ($existing_check) {
            error_log('DEBUG - Duplicate item found: shop_id=' . $insert_data['shop_id'] . ', item_name=' . $insert_data['item_name'] . ', rotation=' . $insert_data['rotation']);
            return new WP_REST_Response(['error' => 'Item already exists in this shop rotation'], 409);
        }
    }
    
    // AGGRESSIVE DEBUGGING: Show current table status before insert
    error_log("DEBUG - === PRE-INSERT DEBUGGING ===");
    $show_create = $wpdb->get_results("SHOW CREATE TABLE $table_name");
    if ($show_create) {
        error_log("DEBUG - Table structure: " . $show_create[0]->{'Create Table'});
    }
    
    // Check if shop still exists right before insert
    $shop_recheck = $wpdb->get_var($wpdb->prepare("SELECT shop_id FROM jotun_shops WHERE shop_id = %d", $insert_data['shop_id']));
    error_log("DEBUG - Shop recheck before insert: " . ($shop_recheck ? 'FOUND' : 'NOT FOUND'));
    
    // Disable ALL constraint checking
    $wpdb->query("SET FOREIGN_KEY_CHECKS = 0");
    $wpdb->query("SET UNIQUE_CHECKS = 0"); 
    $wpdb->query("SET sql_mode = ''");
    error_log("DEBUG - Disabled all constraint checking");
    
    // Try with wpdb->insert first
    $result = $wpdb->insert($table_name, $insert_data);
    
    if ($result === false) {
        error_log('DEBUG - wpdb->insert failed with error: ' . $wpdb->last_error);
        error_log('DEBUG - Query was: ' . $wpdb->last_query);
        
        // If wpdb->insert fails, try a raw INSERT statement
        error_log('DEBUG - Attempting raw INSERT statement as fallback');
        
        // Build raw INSERT statement manually
        $columns = array_keys($insert_data);
        $values = array_values($insert_data);
        $placeholders = array_fill(0, count($values), '%s');
        
        $raw_sql = sprintf(
            "INSERT INTO `%s` (`%s`) VALUES (%s)",
            $table_name,
            implode('`, `', $columns),
            implode(', ', $placeholders)
        );
        
        error_log('DEBUG - Raw SQL: ' . $raw_sql);
        error_log('DEBUG - Values: ' . json_encode($values));
        
        $result = $wpdb->query($wpdb->prepare($raw_sql, ...$values));
        
        if ($result === false) {
            error_log('DEBUG - Raw INSERT also failed with error: ' . $wpdb->last_error);
            error_log('DEBUG - Raw query was: ' . $wpdb->last_query);
            
            // Re-enable all checks
            $wpdb->query("SET FOREIGN_KEY_CHECKS = 1");
            $wpdb->query("SET UNIQUE_CHECKS = 1");
            
            return new WP_REST_Response(['error' => 'Failed to add shop item: ' . $wpdb->last_error], 500);
        } else {
            error_log('DEBUG - Raw INSERT succeeded');
        }
    } else {
        error_log('DEBUG - wpdb->insert succeeded');
    }
    
    // Re-enable all checks
    $wpdb->query("SET FOREIGN_KEY_CHECKS = 1");
    $wpdb->query("SET UNIQUE_CHECKS = 1");
    error_log("DEBUG - Re-enabled all constraint checking");
    
    return new WP_REST_Response(['message' => 'Shop item added successfully', 'id' => $wpdb->insert_id], 201);
}

function jotun_api_update_shop_item($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $data = $request->get_json_params();
    $table_name = 'jotun_shop_items';
    
    $update_data = [];
    
    // Check if custom_price column exists before trying to update it
    $custom_price_exists = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'custom_price'");
    if (!empty($custom_price_exists) && isset($data['custom_price'])) {
        $update_data['custom_price'] = !empty($data['custom_price']) ? floatval($data['custom_price']) : null;
    }
    
    if (isset($data['stock_quantity'])) {
        $update_data['stock_quantity'] = (int)$data['stock_quantity'];
    }
    
    if (isset($data['rotation'])) {
        $update_data['rotation'] = (int)$data['rotation'];
    }
    
    if (isset($data['is_available'])) {
        $update_data['is_available'] = (bool)$data['is_available'];
    }

    if (isset($data['unlimited_stock'])) {
        $update_data['unlimited_stock'] = (bool)$data['unlimited_stock'];
    }

    if (isset($data['turn_in_quantity'])) {
        $update_data['turn_in_quantity'] = (int)$data['turn_in_quantity'];
    }

    if (isset($data['turn_in_requirement'])) {
        $update_data['turn_in_requirement'] = (int)$data['turn_in_requirement'];
    }

    // Handle new checkbox fields
    if (isset($data['sell'])) {
        $update_data['sell'] = (bool)$data['sell'];
    }

    if (isset($data['buy'])) {
        $update_data['buy'] = (bool)$data['buy'];
    }

    if (isset($data['turn_in'])) {
        $update_data['turn_in'] = (bool)$data['turn_in'];
    }
    
    if (empty($update_data)) {
        return new WP_REST_Response(['error' => 'No valid fields to update'], 400);
    }
    
    $result = $wpdb->update($table_name, $update_data, ['shop_item_id' => $id]);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to update shop item: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['message' => 'Shop item updated successfully'], 200);
}

function jotun_api_delete_shop_item($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $table_name = 'jotun_shop_items';
    
    $result = $wpdb->delete($table_name, ['shop_item_id' => $id]);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to delete shop item: ' . $wpdb->last_error], 500);
    }
    
    if ($result === 0) {
        return new WP_REST_Response(['error' => 'Shop item not found'], 404);
    }
    
    return new WP_REST_Response(['message' => 'Shop item deleted successfully'], 200);
}

// ============================================================================
// SHOP ROTATION FUNCTIONS
// ============================================================================

function jotun_api_get_shop_rotations($request) {
    global $wpdb;
    
    $shop_id = (int) $request['shop_id'];
    
    // Get all unique rotations for this shop
    $rotations = $wpdb->get_results($wpdb->prepare(
        "SELECT DISTINCT rotation, COUNT(*) as item_count 
         FROM jotun_shop_items 
         WHERE shop_id = %d 
         GROUP BY rotation 
         ORDER BY rotation ASC",
        $shop_id
    ));
    
    // Get current rotation from shop
    $current_rotation = $wpdb->get_var($wpdb->prepare(
        "SELECT current_rotation FROM jotun_shops WHERE shop_id = %d",
        $shop_id
    ));
    
    return new WP_REST_Response([
        'rotations' => $rotations,
        'current_rotation' => (int)$current_rotation ?: 1
    ], 200);
}

function jotun_api_update_shop_rotation($request) {
    global $wpdb;
    
    $shop_id = (int) $request['shop_id'];
    $data = $request->get_json_params();
    $new_rotation = (int) $data['rotation'];
    
    if ($new_rotation < 1) {
        return new WP_REST_Response(['error' => 'Rotation must be 1 or greater'], 400);
    }
    
    // Verify this rotation exists for the shop
    $rotation_exists = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM jotun_shop_items WHERE shop_id = %d AND rotation = %d",
        $shop_id, $new_rotation
    ));
    
    if (!$rotation_exists) {
        return new WP_REST_Response(['error' => 'No items found for this rotation'], 400);
    }
    
    // Update shop's current rotation
    $result = $wpdb->update(
        'jotun_shops',
        ['current_rotation' => $new_rotation],
        ['shop_id' => $shop_id]
    );
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to update shop rotation: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['message' => 'Shop rotation updated successfully'], 200);
}

// ============================================================================
// TRANSACTIONS FUNCTIONS (jotun_transactions)
// ============================================================================

function jotun_api_get_transactions($request) {
    global $wpdb;
    
    // Determine table based on transaction type
    $transaction_type = $request->get_param('transaction_type');
    if ($transaction_type === 'turnin') {
        $table_name = 'jotun_turn_ins';
        $date_column = 'recorded_at';
        $customer_column = 'player_name';
    } else {
        $table_name = 'jotun_transactions';
        $date_column = 'transaction_date';
        $customer_column = 'customer_name';
    }
    
    $shop_name = $request->get_param('shop_name');
    $customer_name = $request->get_param('customer_name');
    $limit = $request->get_param('limit') ?: 100;
    $offset = $request->get_param('offset') ?: 0;
    $date_from = $request->get_param('date_from');
    $date_to = $request->get_param('date_to');
    $hours = $request->get_param('hours'); // For last X hours filtering
    
    $sql = "SELECT * FROM $table_name";
    $params = [];
    $conditions = [];
    
    if ($shop_name) {
        $conditions[] = "shop_name = %s";
        $params[] = $shop_name;
    }
    
    if ($customer_name) {
        $conditions[] = "$customer_column LIKE %s";
        $params[] = '%' . $wpdb->esc_like($customer_name) . '%';
    }

    // Handle hours parameter for last X hours filtering
    if ($hours) {
        $conditions[] = "$date_column >= DATE_SUB(NOW(), INTERVAL %d HOUR)";
        $params[] = (int)$hours;
    } elseif ($date_from) {
        $conditions[] = "$date_column >= %s";
        $params[] = $date_from;
    }

    if ($date_to) {
        $conditions[] = "$date_column <= %s";
        $params[] = $date_to;
    }    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }
    
    $sql .= " ORDER BY $date_column DESC LIMIT %d OFFSET %d";
    $params[] = $limit;
    $params[] = $offset;
    
    $results = $wpdb->get_results($wpdb->prepare($sql, $params));
    
    if ($wpdb->last_error) {
        return new WP_REST_Response(['error' => 'Database error: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['data' => $results], 200);
}

function jotun_api_add_transaction($request) {
    global $wpdb;
    
    $data = $request->get_json_params();
    
    // Determine table based on shop type
    $shop_type = sanitize_text_field($data['shop_type'] ?? '');
    $transaction_type = sanitize_text_field($data['transaction_type'] ?? 'general');
    
    // Route transactions to appropriate tables
    if ($shop_type === 'aesir') {
        $table_name = 'jotun_ledger';
    } elseif ($shop_type === 'turn-in-only' || $transaction_type === 'turnin') {
        $table_name = 'jotun_turn_ins';
    } else {
        $table_name = 'jotun_transactions';
    }
    
    if (empty($data['shop_name']) || empty($data['item_name']) || empty($data['customer_name'])) {
        return new WP_REST_Response(['error' => 'Shop name, item name, and customer name are required'], 400);
    }
    
    error_log("Transaction routing: shop_type='$shop_type', transaction_type='$transaction_type' -> table='$table_name'");
    
    $item_name = sanitize_text_field($data['item_name']);
    
    // Check if item exists in master itemlist, if not add it as a custom item
    $existing_item = $wpdb->get_row($wpdb->prepare(
        "SELECT id FROM jotun_itemlist WHERE item_name = %s",
        $item_name
    ));
    
    if (!$existing_item) {
        // Add custom item to master itemlist to satisfy database constraints
        error_log("Adding custom item '$item_name' to master itemlist for transaction recording");
        $item_insert = $wpdb->insert('jotun_itemlist', [
            'item_name' => $item_name,
            'unit_price' => 0.00, // Default price for custom items
            'is_custom' => 1, // Mark as custom item
            'created_date' => current_time('mysql'),
            'description' => 'Auto-generated custom item from shop transaction'
        ]);
        
        if ($item_insert === false) {
            error_log("Failed to add custom item '$item_name' to itemlist: " . $wpdb->last_error);
            // Continue anyway - maybe the constraint allows it
        } else {
            error_log("Successfully added custom item '$item_name' to itemlist with ID: " . $wpdb->insert_id);
        }
    }
    
    // Handle different data structures for different tables
    if ($table_name === 'jotun_ledger') {
        // Aesir ledger uses player-specific resource columns
        $customer_name = sanitize_text_field($data['customer_name']);
        $quantity = (int)($data['quantity'] ?? 1);
        
        // Find existing ledger record for this player
        $existing_record = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM jotun_ledger WHERE activePlayerName = %s LIMIT 1",
            $customer_name
        ));
        
        if (!$existing_record) {
            // Create new ledger record for player
            $insert_data = [
                'activePlayerName' => $customer_name,
                'playerName' => $customer_name, // Fallback if different
                'vidar' => 0, // Initialize all resources to 0
                'steamID' => '',
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
                'draugrellitetrophy' => 0,
                'growthtrophy' => 0,
                'seekertrophy' => 0,
                'ulvtrophy' => 0,
                'gjerrahfatrophy' => 0,
                'fulingbeserkertrophy' => 0,
                'yagluthtrophy' => 0,
                'player_id' => null
            ];
            
            $result = $wpdb->insert($table_name, $insert_data);
            if ($result === false) {
                error_log("Failed to create ledger record for player: " . $wpdb->last_error);
                return new WP_REST_Response(['error' => 'Failed to create ledger record: ' . $wpdb->last_error], 500);
            }
            error_log("Created new ledger record for player: $customer_name");
        }
        
        // For now, just log the transaction - full ledger integration would need item mapping
        error_log("Aesir transaction recorded in ledger for $customer_name: $item_name (qty: $quantity)");
        return new WP_REST_Response(['message' => 'Aesir transaction recorded in ledger', 'table' => 'jotun_ledger'], 201);
        
    } elseif ($table_name === 'jotun_turn_ins') {
        // Turn-in transactions table
        $shop_id = (int)($data['shop_id'] ?? 0);
        $customer_name = sanitize_text_field($data['customer_name']);
        $quantity = (int)($data['quantity'] ?? 1);
        $current_user = wp_get_current_user();
        
        $insert_data = [
            'shop_id' => $shop_id,
            'item_name' => $item_name,
            'quantity' => $quantity,
            'player_name' => $customer_name,
            'recorded_at' => current_time('mysql'),
            'recorded_by' => $current_user->ID
        ];
        
        error_log("Recording turn-in transaction: " . json_encode($insert_data));
        $result = $wpdb->insert($table_name, $insert_data);
        
        if ($result === false) {
            error_log("Turn-in transaction insert failed: " . $wpdb->last_error);
            return new WP_REST_Response(['error' => 'Failed to add turn-in transaction: ' . $wpdb->last_error], 500);
        }
        
        // Update turn-in tracker - ensure column exists for this item
        jotun_ensure_turnin_tracker_column($item_name);
        jotun_update_turnin_tracker($shop_id, $item_name, $quantity);
        
        error_log("Turn-in transaction added successfully with ID: " . $wpdb->insert_id);
        return new WP_REST_Response(['message' => 'Turn-in transaction recorded successfully', 'id' => $wpdb->insert_id, 'table' => 'jotun_turn_ins'], 201);
        
    } else {
        // Standard transactions table
        $insert_data = [
            'shop_name' => sanitize_text_field($data['shop_name']),
            'item_name' => $item_name,
            'quantity' => (int)($data['quantity'] ?? 1),
            'total_amount' => floatval($data['total_amount'] ?? 0),
            'customer_name' => sanitize_text_field($data['customer_name']),
            'teller' => sanitize_text_field($data['teller'] ?? wp_get_current_user()->display_name),
            'transaction_date' => $data['transaction_date'] ?? current_time('mysql'),
            'transaction_type' => sanitize_text_field($data['transaction_type'] ?? 'general')
        ];
        
        // Add player_id if the column exists and we can find the player
        if (POS_Database_Utils::column_exists($table_name, 'player_id')) {
            $customer_name = sanitize_text_field($data['customer_name']);
            $player_record = $wpdb->get_row($wpdb->prepare(
                "SELECT id FROM jotun_playerlist WHERE activePlayerName = %s OR player_name = %s LIMIT 1",
                $customer_name, $customer_name
            ));
            if ($player_record) {
                $insert_data['player_id'] = $player_record->id;
            }
        }
        
        // Add item_id if provided (for frontend compatibility)
        if (!empty($data['item_id'])) {
            $insert_data['item_id'] = (int)$data['item_id'];
        }
    }
    
    error_log("Attempting to insert transaction: " . json_encode($insert_data));
    
    $result = $wpdb->insert($table_name, $insert_data);
    
    if ($result === false) {
        error_log("Transaction insert failed: " . $wpdb->last_error);
        return new WP_REST_Response(['error' => 'Failed to add transaction: ' . $wpdb->last_error], 500);
    }
    
    error_log("Transaction added successfully with ID: " . $wpdb->insert_id);
    return new WP_REST_Response(['message' => 'Transaction added successfully', 'id' => $wpdb->insert_id], 201);
}

function jotun_api_update_transaction($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $data = $request->get_json_params();
    $table_name = 'jotun_transactions';
    
    if (empty($data['shop_name']) || empty($data['item_name']) || empty($data['customer_name'])) {
        return new WP_REST_Response(['error' => 'Shop name, item name, and customer name are required'], 400);
    }
    
    $update_data = [
        'shop_name' => sanitize_text_field($data['shop_name']),
        'item_name' => sanitize_text_field($data['item_name']),
        'quantity' => (int)($data['quantity'] ?? 1),
        'total_amount' => floatval($data['total_amount'] ?? 0),
        'customer_name' => sanitize_text_field($data['customer_name']),
        'teller' => sanitize_text_field($data['teller'] ?? wp_get_current_user()->display_name),
        'transaction_type' => sanitize_text_field($data['transaction_type'] ?? 'general')
    ];
    
    $result = $wpdb->update($table_name, $update_data, ['id' => $id]);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to update transaction: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['message' => 'Transaction updated successfully'], 200);
}

function jotun_api_delete_transaction($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $table_name = 'jotun_transactions';
    
    $result = $wpdb->delete($table_name, ['id' => $id]);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to delete transaction: ' . $wpdb->last_error], 500);
    }
    
    if ($result === 0) {
        return new WP_REST_Response(['error' => 'Transaction not found'], 404);
    }
    
    return new WP_REST_Response(['message' => 'Transaction deleted successfully'], 200);
}

function jotun_api_get_event_progress($request) {
    global $wpdb;
    
    $item_name = sanitize_text_field(urldecode($request['item_name']));
    
    // Get total turned in for this item from transactions where transaction_type = 'turn-in'
    $total_turned_in = $wpdb->get_var($wpdb->prepare(
        "SELECT COALESCE(SUM(quantity), 0) FROM jotun_transactions 
         WHERE item_name = %s AND transaction_type = 'turn-in'",
        $item_name
    ));
    
    if ($total_turned_in === null) {
        $total_turned_in = 0;
    }
    
    return new WP_REST_Response([
        'item_name' => $item_name,
        'total_turned_in' => (int) $total_turned_in
    ], 200);
}

// ============================================================================
// ITEM LIST FUNCTIONS (jotun_itemlist)
// ============================================================================

function jotun_api_get_itemlist($request) {
    global $wpdb;
    
    $table_name = "jotun_itemlist";
    $search = $request->get_param('search');
    $category = $request->get_param('category');
    
    $sql = "SELECT * FROM $table_name";
    $params = [];
    $conditions = [];
    
    if ($search) {
        $conditions[] = "item_name LIKE %s";
        $params[] = '%' . $wpdb->esc_like($search) . '%';
    }
    
    if ($category) {
        $conditions[] = "category = %s";
        $params[] = $category;
    }
    
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }
    
    $sql .= " ORDER BY item_name ASC";
    
    // Add debug logging
    error_log('jotun_api_get_itemlist: SQL = ' . $sql);
    if (!empty($params)) {
        error_log('jotun_api_get_itemlist: Params = ' . print_r($params, true));
    }
    
    if (!empty($params)) {
        $results = $wpdb->get_results($wpdb->prepare($sql, $params));
    } else {
        $results = $wpdb->get_results($sql);
    }
    
    error_log('jotun_api_get_itemlist: Retrieved ' . count($results) . ' items');
    if (!empty($results)) {
        error_log('jotun_api_get_itemlist: First item = ' . $results[0]->item_name);
        error_log('jotun_api_get_itemlist: Last item = ' . $results[count($results)-1]->item_name);
    }
    
    if ($wpdb->last_error) {
        return new WP_REST_Response(['error' => 'Database error: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['data' => $results], 200);
}

function jotun_api_add_item($request) {
    global $wpdb;
    
    $data = $request->get_json_params();
    $table_name = "jotun_itemlist";
    
    if (empty($data['item_name'])) {
        return new WP_REST_Response(['error' => 'Item name is required'], 400);
    }
    
    $insert_data = [
        'item_name' => sanitize_text_field($data['item_name']),
        'display_name' => sanitize_text_field($data['display_name'] ?? $data['item_name']),
        'cost' => floatval($data['cost'] ?? 0),
        'category' => sanitize_text_field($data['category'] ?? 'general'),
        'description' => sanitize_textarea_field($data['description'] ?? ''),
        'is_active' => isset($data['is_active']) ? (bool)$data['is_active'] : true
    ];
    
    $result = $wpdb->insert($table_name, $insert_data);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to add item: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['message' => 'Item added successfully', 'id' => $wpdb->insert_id], 201);
}

function jotun_api_update_item($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $data = $request->get_json_params();
    $table_name = "jotun_itemlist";
    
    if (empty($data['item_name'])) {
        return new WP_REST_Response(['error' => 'Item name is required'], 400);
    }
    
    $update_data = [
        'item_name' => sanitize_text_field($data['item_name']),
        'display_name' => sanitize_text_field($data['display_name'] ?? $data['item_name']),
        'cost' => floatval($data['cost'] ?? 0),
        'category' => sanitize_text_field($data['category'] ?? 'general'),
        'description' => sanitize_textarea_field($data['description'] ?? ''),
        'is_active' => isset($data['is_active']) ? (bool)$data['is_active'] : true
    ];
    
    $result = $wpdb->update($table_name, $update_data, ['id' => $id]);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to update item: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['message' => 'Item updated successfully'], 200);
}

function jotun_api_delete_item($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $table_name = "jotun_itemlist";
    
    $result = $wpdb->delete($table_name, ['id' => $id]);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to delete item: ' . $wpdb->last_error], 500);
    }
    
    if ($result === 0) {
        return new WP_REST_Response(['error' => 'Item not found'], 404);
    }
    
    return new WP_REST_Response(['message' => 'Item deleted successfully'], 200);
}

// ============================================================================
// LEDGER FUNCTIONS (jotun_ledger)
// ============================================================================

function jotun_api_get_ledger($request) {
    global $wpdb;
    
    $table_name = 'jotun_ledger';
    $limit = $request->get_param('limit') ?: 100;
    $offset = $request->get_param('offset') ?: 0;
    $search = $request->get_param('search');
    
    $sql = "SELECT * FROM $table_name";
    $params = [];
    
    if ($search) {
        $sql .= " WHERE activePlayerName LIKE %s OR playerName LIKE %s";
        $params[] = '%' . $wpdb->esc_like($search) . '%';
        $params[] = '%' . $wpdb->esc_like($search) . '%';
    }
    
    $sql .= " ORDER BY id DESC LIMIT %d OFFSET %d";
    $params[] = $limit;
    $params[] = $offset;
    
    $results = $wpdb->get_results($wpdb->prepare($sql, $params));
    
    if ($wpdb->last_error) {
        return new WP_REST_Response(['error' => 'Database error: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['data' => $results], 200);
}

function jotun_api_add_ledger_entry($request) {
    global $wpdb;
    
    $data = $request->get_json_params();
    $table_name = 'jotun_ledger';
    
    if (empty($data['playerName'])) {
        return new WP_REST_Response(['error' => 'Player name is required'], 400);
    }
    
    // Use the existing default values function
    $default_values = POS_Database_Utils::get_default_player_values($data['playerName']);
    
    // Override with any provided values
    foreach ($data as $key => $value) {
        if ($key !== 'playerName' && array_key_exists($key, $default_values)) {
            $default_values[$key] = is_numeric($value) ? (int)$value : sanitize_text_field($value);
        }
    }
    
    $result = $wpdb->insert($table_name, $default_values);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to add ledger entry: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['message' => 'Ledger entry added successfully', 'id' => $wpdb->insert_id], 201);
}

function jotun_api_update_ledger_entry($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $data = $request->get_json_params();
    $table_name = 'jotun_ledger';
    
    if (empty($data['playerName'])) {
        return new WP_REST_Response(['error' => 'Player name is required'], 400);
    }
    
    // Prepare update data - only include fields that exist in the default values
    $default_values = POS_Database_Utils::get_default_player_values('');
    $update_data = [];
    
    foreach ($data as $key => $value) {
        if (array_key_exists($key, $default_values)) {
            $update_data[$key] = is_numeric($value) ? (int)$value : sanitize_text_field($value);
        }
    }
    
    if (empty($update_data)) {
        return new WP_REST_Response(['error' => 'No valid fields to update'], 400);
    }
    
    $result = $wpdb->update($table_name, $update_data, ['id' => $id]);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to update ledger entry: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['message' => 'Ledger entry updated successfully'], 200);
}

function jotun_api_delete_ledger_entry($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $table_name = 'jotun_ledger';
    
    $result = $wpdb->delete($table_name, ['id' => $id]);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to delete ledger entry: ' . $wpdb->last_error], 500);
    }
    
    if ($result === 0) {
        return new WP_REST_Response(['error' => 'Ledger entry not found'], 404);
    }
    
    return new WP_REST_Response(['message' => 'Ledger entry deleted successfully'], 200);
}

// ============================================================================
// SHOP TYPES FUNCTIONS (jotun_shop_types)
// ============================================================================

function jotun_api_get_shop_types($request) {
    global $wpdb;
    
    $table_name = 'jotun_shop_types';
    
    // For admin management, show all shop types. For dropdowns, show only active ones.
    $show_all = $request->get_param('show_all');
    error_log('jotun_api_get_shop_types: show_all parameter = ' . ($show_all ? $show_all : 'null'));
    
    if ($show_all === 'true') {
        $query = "SELECT * FROM $table_name ORDER BY type_name ASC";
        error_log('jotun_api_get_shop_types: Using query for all types: ' . $query);
        $results = $wpdb->get_results($query);
    } else {
        $query = "SELECT * FROM $table_name WHERE is_active = 1 ORDER BY type_name ASC";
        error_log('jotun_api_get_shop_types: Using query for active only: ' . $query);
        $results = $wpdb->get_results($query);
    }
    
    error_log('jotun_api_get_shop_types: Found ' . count($results) . ' shop types');
    error_log('jotun_api_get_shop_types: Results: ' . print_r($results, true));
    
    if ($wpdb->last_error) {
        error_log('jotun_api_get_shop_types: Database error: ' . $wpdb->last_error);
        return new WP_REST_Response(['error' => 'Database error: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['data' => $results], 200);
}

function jotun_api_get_accessible_shop_types($request) {
    $accessible_types = jotun_get_accessible_shop_types();
    return new WP_REST_Response(['data' => $accessible_types], 200);
}

function jotun_api_add_shop_type($request) {
    global $wpdb;
    
    $data = $request->get_json_params();
    $table_name = 'jotun_shop_types';
    
    // Debug logging
    error_log('jotun_api_add_shop_type received data: ' . print_r($data, true));
    
    if (empty($data['type_name'])) {
        return new WP_REST_Response(['error' => 'Type name is required'], 400);
    }

    if (empty($data['type_key'])) {
        return new WP_REST_Response(['error' => 'Type key is required'], 400);
    }

    // Check if type_key already exists
    $existing_type = $wpdb->get_row($wpdb->prepare(
        "SELECT type_id, type_name FROM $table_name WHERE type_key = %s",
        sanitize_key($data['type_key'])
    ));
    
    if ($existing_type) {
        error_log('Shop type key already exists: ' . $data['type_key'] . ' (existing type: ' . $existing_type->type_name . ')');
        return new WP_REST_Response([
            'error' => 'A shop type with the key "' . $data['type_key'] . '" already exists (existing type: "' . $existing_type->type_name . '"). Please choose a different name.'
        ], 409);
    }    $insert_data = [
        'type_name' => sanitize_text_field($data['type_name']),
        'type_key' => sanitize_key($data['type_key']),
        'description' => sanitize_textarea_field($data['description'] ?? ''),
        'default_permissions' => json_encode($data['default_permissions'] ?? []),
        'is_active' => 1,
        'created_at' => current_time('mysql')
    ];
    
    $result = $wpdb->insert($table_name, $insert_data);
    
    if ($result === false) {
        $error_message = $wpdb->last_error;
        
        // Handle duplicate key error
        if (strpos($error_message, 'Duplicate entry') !== false && strpos($error_message, 'unique_type_key') !== false) {
            return new WP_REST_Response(['error' => 'A shop type with this key already exists. Please choose a different name.'], 409);
        }
        
        return new WP_REST_Response(['error' => 'Failed to add shop type: ' . $error_message], 500);
    }
    
    return new WP_REST_Response(['message' => 'Shop type added successfully', 'id' => $wpdb->insert_id], 201);
}

function jotun_api_update_shop_type($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $data = $request->get_json_params();
    $table_name = 'jotun_shop_types';
    
    error_log('jotun_api_update_shop_type: Updating shop type ID ' . $id);
    error_log('jotun_api_update_shop_type: Received data: ' . print_r($data, true));
    
    if (empty($data['type_name'])) {
        return new WP_REST_Response(['error' => 'Type name is required'], 400);
    }
    
    $update_data = [
        'type_name' => sanitize_text_field($data['type_name']),
        'description' => sanitize_textarea_field($data['description'] ?? ''),
        'is_active' => isset($data['is_active']) ? (int) $data['is_active'] : 1,
        'default_permissions' => json_encode($data['default_permissions'] ?? []),
        'updated_at' => current_time('mysql')
    ];
    
    error_log('jotun_api_update_shop_type: Update data: ' . print_r($update_data, true));
    
    $result = $wpdb->update($table_name, $update_data, ['type_id' => $id]);
    
    error_log('jotun_api_update_shop_type: Update result: ' . $result);
    if ($wpdb->last_error) {
        error_log('jotun_api_update_shop_type: Database error: ' . $wpdb->last_error);
    }
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to update shop type: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['message' => 'Shop type updated successfully'], 200);
}

function jotun_api_delete_shop_type($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $table_name = 'jotun_shop_types';
    
    // Check if this shop type is being used by any shops
    $shops_using_type = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM jotun_shops WHERE shop_type = (SELECT type_key FROM $table_name WHERE type_id = %d)",
        $id
    ));
    
    if ($shops_using_type > 0) {
        return new WP_REST_Response(['error' => 'Cannot delete shop type: it is currently being used by ' . $shops_using_type . ' shop(s). Please remove or change the shop type for those shops first.'], 400);
    }
    
    // Actually delete the record
    $result = $wpdb->delete($table_name, ['type_id' => $id]);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to delete shop type: ' . $wpdb->last_error], 500);
    }
    
    if ($result === 0) {
        return new WP_REST_Response(['error' => 'Shop type not found'], 404);
    }
    
    return new WP_REST_Response(['message' => 'Shop type deleted successfully'], 200);
}

// ============================================================================
// TURN-IN TRACKING FUNCTIONS
// ============================================================================

function jotun_api_get_turn_in_count($request) {
    global $wpdb;
    
    $shop_id = (int) $request['shop_id'];
    
    // Get or create tracker for this shop
    $tracker = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM jotun_turn_in_trackers WHERE shop_id = %d",
        $shop_id
    ));
    
    if (!$tracker) {
        // Create new tracker
        $wpdb->insert('jotun_turn_in_trackers', [
            'shop_id' => $shop_id,
            'total_count' => 0,
            'last_reset' => current_time('mysql')
        ]);
        $total_count = 0;
    } else {
        // Count turn-ins since last reset
        $total_count = $wpdb->get_var($wpdb->prepare(
            "SELECT COALESCE(SUM(quantity), 0) FROM jotun_turn_ins 
             WHERE shop_id = %d AND recorded_at >= %s",
            $shop_id,
            $tracker->last_reset
        ));
    }
    
    return new WP_REST_Response(['data' => ['total_count' => $total_count]], 200);
}

function jotun_api_record_turn_in($request) {
    global $wpdb;
    
    $data = $request->get_json_params();
    
    if (empty($data['shop_id']) || empty($data['item_name'])) {
        return new WP_REST_Response(['error' => 'Shop ID and item name are required'], 400);
    }
    
    $insert_data = [
        'shop_id' => (int)$data['shop_id'],
        'item_name' => sanitize_text_field($data['item_name']),
        'quantity' => (int)($data['quantity'] ?? 1),
        'player_name' => !empty($data['player_name']) ? sanitize_text_field($data['player_name']) : null,
        'recorded_at' => current_time('mysql'),
        'recorded_by' => get_current_user_id()
    ];
    
    $result = $wpdb->insert('jotun_turn_ins', $insert_data);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to record turn-in: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['message' => 'Turn-in recorded successfully', 'id' => $wpdb->insert_id], 201);
}

function jotun_api_reset_turn_in_tracker($request) {
    global $wpdb;
    
    $shop_id = (int) $request['shop_id'];
    
    // Update or create tracker
    $existing = $wpdb->get_var($wpdb->prepare(
        "SELECT id FROM jotun_turn_in_trackers WHERE shop_id = %d",
        $shop_id
    ));
    
    if ($existing) {
        $result = $wpdb->update(
            'jotun_turn_in_trackers',
            [
                'last_reset' => current_time('mysql'),
                'reset_by' => get_current_user_id()
            ],
            ['shop_id' => $shop_id]
        );
    } else {
        $result = $wpdb->insert('jotun_turn_in_trackers', [
            'shop_id' => $shop_id,
            'total_count' => 0,
            'last_reset' => current_time('mysql'),
            'reset_by' => get_current_user_id()
        ]);
    }
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to reset tracker: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['message' => 'Turn-in tracker reset successfully'], 200);
}

function jotun_api_daily_sales_check($request) {
    global $wpdb;
    
    // Verify nonce
    if (!wp_verify_nonce($request->get_header('X-WP-Nonce'), 'wp_rest')) {
        return new WP_Error('invalid_nonce', 'Invalid nonce', array('status' => 403));
    }
    
    $params = $request->get_json_params();
    $player_name = sanitize_text_field($params['player_name'] ?? '');
    $shop_id = intval($params['shop_id'] ?? 0);
    $shop_item_id = intval($params['shop_item_id'] ?? 0);
    $proposed_quantity = intval($params['proposed_quantity'] ?? 0);
    
    if (empty($player_name) || $shop_id <= 0 || $shop_item_id <= 0 || $proposed_quantity <= 0) {
        return new WP_Error('missing_params', 'Missing required parameters', array('status' => 400));
    }
    
    try {
        // Get the shop item to check if daily limits are enabled
        $shop_item = $wpdb->get_row($wpdb->prepare(
            "SELECT daily_limit_enabled, max_daily_sell_quantity 
             FROM jotun_shop_items 
             WHERE id = %d AND shop_id = %d",
            $shop_item_id, $shop_id
        ));
        
        if (!$shop_item) {
            return new WP_Error('item_not_found', 'Shop item not found', array('status' => 404));
        }
        
        // If daily limits aren't enabled, allow the sale
        if (!$shop_item->daily_limit_enabled || $shop_item->max_daily_sell_quantity <= 0) {
            return rest_ensure_response(array(
                'success' => true,
                'data' => array(
                    'can_sell' => true,
                    'sold_today' => 0,
                    'max_daily' => 0,
                    'remaining' => PHP_INT_MAX
                )
            ));
        }
        
        // Check today's sales for this player/item combination
        $today = current_time('Y-m-d');
        $sales_today = $wpdb->get_row($wpdb->prepare(
            "SELECT quantity_sold 
             FROM jotun_player_daily_sales 
             WHERE player_name = %s AND shop_id = %d AND shop_item_id = %d AND sale_date = %s",
            $player_name, $shop_id, $shop_item_id, $today
        ));
        
        $sold_today = $sales_today ? intval($sales_today->quantity_sold) : 0;
        $max_daily = intval($shop_item->max_daily_sell_quantity);
        $remaining = $max_daily - $sold_today;
        
        // Check if proposed quantity would exceed limit
        $can_sell = ($sold_today + $proposed_quantity) <= $max_daily;
        
        return rest_ensure_response(array(
            'success' => true,
            'data' => array(
                'can_sell' => $can_sell,
                'sold_today' => $sold_today,
                'max_daily' => $max_daily,
                'remaining' => max(0, $remaining),
                'proposed_quantity' => $proposed_quantity,
                'would_exceed' => !$can_sell
            )
        ));
        
    } catch (Exception $e) {
        error_log('Daily sales check error: ' . $e->getMessage());
        return new WP_Error('database_error', 'Database error occurred', array('status' => 500));
    }
}

function jotun_record_daily_sale($player_name, $shop_id, $shop_item_id, $quantity_sold) {
    global $wpdb;
    
    $today = current_time('Y-m-d');
    
    // Check if a record already exists for today
    $existing = $wpdb->get_row($wpdb->prepare(
        "SELECT id, quantity_sold 
         FROM jotun_player_daily_sales 
         WHERE player_name = %s AND shop_id = %d AND shop_item_id = %d AND sale_date = %s",
        $player_name, $shop_id, $shop_item_id, $today
    ));
    
    if ($existing) {
        // Update existing record
        $new_quantity = intval($existing->quantity_sold) + $quantity_sold;
        $result = $wpdb->update(
            'jotun_player_daily_sales',
            ['quantity_sold' => $new_quantity],
            ['id' => $existing->id]
        );
    } else {
        // Insert new record
        $result = $wpdb->insert(
            'jotun_player_daily_sales',
            [
                'player_name' => $player_name,
                'shop_id' => $shop_id,
                'shop_item_id' => $shop_item_id,
                'quantity_sold' => $quantity_sold,
                'sale_date' => $today
            ]
        );
    }
    
    if ($result === false) {
        error_log('Failed to record daily sale: ' . $wpdb->last_error);
        return false;
    }
    
    return true;
}

function jotun_api_record_daily_sale($request) {
    // Verify nonce
    if (!wp_verify_nonce($request->get_header('X-WP-Nonce'), 'wp_rest')) {
        return new WP_Error('invalid_nonce', 'Invalid nonce', array('status' => 403));
    }
    
    $params = $request->get_json_params();
    $player_name = sanitize_text_field($params['player_name'] ?? '');
    $shop_id = intval($params['shop_id'] ?? 0);
    $shop_item_id = intval($params['shop_item_id'] ?? 0);
    $quantity_sold = intval($params['quantity_sold'] ?? 0);
    
    if (empty($player_name) || $shop_id <= 0 || $shop_item_id <= 0 || $quantity_sold <= 0) {
        return new WP_Error('missing_params', 'Missing required parameters', array('status' => 400));
    }
    
    $success = jotun_record_daily_sale($player_name, $shop_id, $shop_item_id, $quantity_sold);
    
    if ($success) {
        return rest_ensure_response(array(
            'success' => true,
            'message' => 'Daily sale recorded successfully'
        ));
    } else {
        return new WP_Error('record_failed', 'Failed to record daily sale', array('status' => 500));
    }
}

// ============================================================================
// DAILY BUY LIMIT FUNCTIONS
// ============================================================================

function jotun_api_daily_buys_check($request) {
    global $wpdb;
    
    // Verify nonce
    if (!wp_verify_nonce($request->get_header('X-WP-Nonce'), 'wp_rest')) {
        return new WP_Error('invalid_nonce', 'Invalid nonce', array('status' => 403));
    }
    
    $params = $request->get_json_params();
    $player_name = sanitize_text_field($params['player_name'] ?? '');
    $shop_id = intval($params['shop_id'] ?? 0);
    $shop_item_id = intval($params['shop_item_id'] ?? 0);
    $proposed_quantity = intval($params['proposed_quantity'] ?? 0);
    
    if (empty($player_name) || $shop_id <= 0 || $shop_item_id <= 0 || $proposed_quantity <= 0) {
        return new WP_Error('missing_params', 'Missing required parameters', array('status' => 400));
    }
    
    try {
        // Get the shop item to check if daily limits are enabled
        $shop_item = $wpdb->get_row($wpdb->prepare(
            "SELECT buy_daily_limit_enabled, max_daily_buy_quantity 
             FROM jotun_shop_items 
             WHERE id = %d AND shop_id = %d",
            $shop_item_id, $shop_id
        ));
        
        if (!$shop_item) {
            return new WP_Error('item_not_found', 'Shop item not found', array('status' => 404));
        }
        
        // If daily limits aren't enabled, allow the purchase
        if (!$shop_item->buy_daily_limit_enabled || $shop_item->max_daily_buy_quantity <= 0) {
            return rest_ensure_response(array(
                'success' => true,
                'data' => array(
                    'can_buy' => true,
                    'bought_today' => 0,
                    'max_daily' => 0,
                    'remaining' => PHP_INT_MAX
                )
            ));
        }
        
        // Check today's purchases for this player/item combination
        $today = current_time('Y-m-d');
        $buys_today = $wpdb->get_row($wpdb->prepare(
            "SELECT quantity_bought 
             FROM jotun_player_daily_buys 
             WHERE player_name = %s AND shop_id = %d AND shop_item_id = %d AND buy_date = %s",
            $player_name, $shop_id, $shop_item_id, $today
        ));
        
        $bought_today = $buys_today ? intval($buys_today->quantity_bought) : 0;
        $max_daily = intval($shop_item->max_daily_buy_quantity);
        $remaining = $max_daily - $bought_today;
        
        // Check if proposed quantity would exceed limit
        $can_buy = ($bought_today + $proposed_quantity) <= $max_daily;
        
        return rest_ensure_response(array(
            'success' => true,
            'data' => array(
                'can_buy' => $can_buy,
                'bought_today' => $bought_today,
                'max_daily' => $max_daily,
                'remaining' => max(0, $remaining),
                'proposed_quantity' => $proposed_quantity,
                'would_exceed' => !$can_buy
            )
        ));
        
    } catch (Exception $e) {
        error_log('Daily buys check error: ' . $e->getMessage());
        return new WP_Error('database_error', 'Database error occurred', array('status' => 500));
    }
}

function jotun_record_daily_buy($player_name, $shop_id, $shop_item_id, $quantity_bought) {
    global $wpdb;
    
    $today = current_time('Y-m-d');
    
    // Check if a record already exists for today
    $existing = $wpdb->get_row($wpdb->prepare(
        "SELECT id, quantity_bought 
         FROM jotun_player_daily_buys 
         WHERE player_name = %s AND shop_id = %d AND shop_item_id = %d AND buy_date = %s",
        $player_name, $shop_id, $shop_item_id, $today
    ));
    
    if ($existing) {
        // Update existing record
        $new_quantity = intval($existing->quantity_bought) + $quantity_bought;
        $result = $wpdb->update(
            'jotun_player_daily_buys',
            ['quantity_bought' => $new_quantity],
            ['id' => $existing->id]
        );
    } else {
        // Insert new record
        $result = $wpdb->insert(
            'jotun_player_daily_buys',
            [
                'player_name' => $player_name,
                'shop_id' => $shop_id,
                'shop_item_id' => $shop_item_id,
                'quantity_bought' => $quantity_bought,
                'buy_date' => $today
            ]
        );
    }
    
    if ($result === false) {
        error_log('Failed to record daily buy: ' . $wpdb->last_error);
        return false;
    }
    
    return true;
}

function jotun_api_record_daily_buy($request) {
    // Verify nonce
    if (!wp_verify_nonce($request->get_header('X-WP-Nonce'), 'wp_rest')) {
        return new WP_Error('invalid_nonce', 'Invalid nonce', array('status' => 403));
    }
    
    $params = $request->get_json_params();
    $player_name = sanitize_text_field($params['player_name'] ?? '');
    $shop_id = intval($params['shop_id'] ?? 0);
    $shop_item_id = intval($params['shop_item_id'] ?? 0);
    $quantity_bought = intval($params['quantity_bought'] ?? 0);
    
    if (empty($player_name) || $shop_id <= 0 || $shop_item_id <= 0 || $quantity_bought <= 0) {
        return new WP_Error('missing_params', 'Missing required parameters', array('status' => 400));
    }
    
    $success = jotun_record_daily_buy($player_name, $shop_id, $shop_item_id, $quantity_bought);
    
    if ($success) {
        return rest_ensure_response(array(
            'success' => true,
            'message' => 'Daily buy recorded successfully'
        ));
    } else {
        return new WP_Error('record_failed', 'Failed to record daily buy', array('status' => 500));
    }
}

// ============================================================================
// DAILY TURN-IN LIMIT FUNCTIONS
// ============================================================================

function jotun_api_daily_turnins_check($request) {
    global $wpdb;
    
    // Verify nonce
    if (!wp_verify_nonce($request->get_header('X-WP-Nonce'), 'wp_rest')) {
        return new WP_Error('invalid_nonce', 'Invalid nonce', array('status' => 403));
    }
    
    $params = $request->get_json_params();
    $player_name = sanitize_text_field($params['player_name'] ?? '');
    $shop_id = intval($params['shop_id'] ?? 0);
    $shop_item_id = intval($params['shop_item_id'] ?? 0);
    $proposed_quantity = intval($params['proposed_quantity'] ?? 0);
    
    if (empty($player_name) || $shop_id <= 0 || $shop_item_id <= 0 || $proposed_quantity <= 0) {
        return new WP_Error('missing_params', 'Missing required parameters', array('status' => 400));
    }
    
    try {
        // Get the shop item to check if daily limits are enabled
        $shop_item = $wpdb->get_row($wpdb->prepare(
            "SELECT turnin_daily_limit_enabled, max_daily_turnin_quantity 
             FROM jotun_shop_items 
             WHERE id = %d AND shop_id = %d",
            $shop_item_id, $shop_id
        ));
        
        if (!$shop_item) {
            return new WP_Error('item_not_found', 'Shop item not found', array('status' => 404));
        }
        
        // If daily limits aren't enabled, allow the turn-in
        if (!$shop_item->turnin_daily_limit_enabled || $shop_item->max_daily_turnin_quantity <= 0) {
            return rest_ensure_response(array(
                'success' => true,
                'data' => array(
                    'can_turnin' => true,
                    'turned_in_today' => 0,
                    'max_daily' => 0,
                    'remaining' => PHP_INT_MAX
                )
            ));
        }
        
        // Check today's turn-ins for this player/item combination
        $today = current_time('Y-m-d');
        $turnins_today = $wpdb->get_row($wpdb->prepare(
            "SELECT quantity_turned_in 
             FROM jotun_player_daily_turnins 
             WHERE player_name = %s AND shop_id = %d AND shop_item_id = %d AND turnin_date = %s",
            $player_name, $shop_id, $shop_item_id, $today
        ));
        
        $turned_in_today = $turnins_today ? intval($turnins_today->quantity_turned_in) : 0;
        $max_daily = intval($shop_item->max_daily_turnin_quantity);
        $remaining = $max_daily - $turned_in_today;
        
        // Check if proposed quantity would exceed limit
        $can_turnin = ($turned_in_today + $proposed_quantity) <= $max_daily;
        
        return rest_ensure_response(array(
            'success' => true,
            'data' => array(
                'can_turnin' => $can_turnin,
                'turned_in_today' => $turned_in_today,
                'max_daily' => $max_daily,
                'remaining' => max(0, $remaining),
                'proposed_quantity' => $proposed_quantity,
                'would_exceed' => !$can_turnin
            )
        ));
        
    } catch (Exception $e) {
        error_log('Daily turnins check error: ' . $e->getMessage());
        return new WP_Error('database_error', 'Database error occurred', array('status' => 500));
    }
}

function jotun_record_daily_turnin($player_name, $shop_id, $shop_item_id, $quantity_turned_in) {
    global $wpdb;
    
    $today = current_time('Y-m-d');
    
    // Check if a record already exists for today
    $existing = $wpdb->get_row($wpdb->prepare(
        "SELECT id, quantity_turned_in 
         FROM jotun_player_daily_turnins 
         WHERE player_name = %s AND shop_id = %d AND shop_item_id = %d AND turnin_date = %s",
        $player_name, $shop_id, $shop_item_id, $today
    ));
    
    if ($existing) {
        // Update existing record
        $new_quantity = intval($existing->quantity_turned_in) + $quantity_turned_in;
        $result = $wpdb->update(
            'jotun_player_daily_turnins',
            ['quantity_turned_in' => $new_quantity],
            ['id' => $existing->id]
        );
    } else {
        // Insert new record
        $result = $wpdb->insert(
            'jotun_player_daily_turnins',
            [
                'player_name' => $player_name,
                'shop_id' => $shop_id,
                'shop_item_id' => $shop_item_id,
                'quantity_turned_in' => $quantity_turned_in,
                'turnin_date' => $today
            ]
        );
    }
    
    if ($result === false) {
        error_log('Failed to record daily turnin: ' . $wpdb->last_error);
        return false;
    }
    
    return true;
}

function jotun_api_record_daily_turnin($request) {
    // Verify nonce
    if (!wp_verify_nonce($request->get_header('X-WP-Nonce'), 'wp_rest')) {
        return new WP_Error('invalid_nonce', 'Invalid nonce', array('status' => 403));
    }
    
    $params = $request->get_json_params();
    $player_name = sanitize_text_field($params['player_name'] ?? '');
    $shop_id = intval($params['shop_id'] ?? 0);
    $shop_item_id = intval($params['shop_item_id'] ?? 0);
    $quantity_turned_in = intval($params['quantity_turned_in'] ?? 0);
    
    if (empty($player_name) || $shop_id <= 0 || $shop_item_id <= 0 || $quantity_turned_in <= 0) {
        return new WP_Error('missing_params', 'Missing required parameters', array('status' => 400));
    }
    
    $success = jotun_record_daily_turnin($player_name, $shop_id, $shop_item_id, $quantity_turned_in);
    
    if ($success) {
        return rest_ensure_response(array(
            'success' => true,
            'message' => 'Daily turnin recorded successfully'
        ));
    } else {
        return new WP_Error('record_failed', 'Failed to record daily turnin', array('status' => 500));
    }
}

/**
 * Ensure a column exists in jotun_turn_in_trackers for the given item
 * This creates dynamic columns for new turn-in items
 */
function jotun_ensure_turnin_tracker_column($item_name) {
    global $wpdb;
    
    // Sanitize item name for column usage
    $column_name = jotun_sanitize_item_column_name($item_name);
    $table_name = 'jotun_turn_in_trackers';
    
    // Check if column already exists
    $column_exists = $wpdb->get_results($wpdb->prepare(
        "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
         WHERE TABLE_SCHEMA = %s AND TABLE_NAME = %s AND COLUMN_NAME = %s",
        DB_NAME, $table_name, $column_name
    ));
    
    if (empty($column_exists)) {
        // Add the column
        $alter_query = "ALTER TABLE $table_name ADD COLUMN `$column_name` int(11) DEFAULT 0 COMMENT 'Turn-in count for $item_name'";
        $result = $wpdb->query($alter_query);
        
        if ($result === false) {
            error_log("Failed to add turn-in tracker column '$column_name': " . $wpdb->last_error);
        } else {
            error_log("Successfully added turn-in tracker column '$column_name' for item '$item_name'");
        }
    }
}

/**
 * Update the turn-in tracker for a shop and item
 */
function jotun_update_turnin_tracker($shop_id, $item_name, $quantity) {
    global $wpdb;
    
    $column_name = jotun_sanitize_item_column_name($item_name);
    $table_name = 'jotun_turn_in_trackers';
    
    // Find or create tracker record for this shop
    $existing_tracker = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE shop_id = %d",
        $shop_id
    ));
    
    if (!$existing_tracker) {
        // Create new tracker record
        $insert_data = [
            'shop_id' => $shop_id,
            'total_count' => $quantity,
            'last_reset' => current_time('mysql'),
            'reset_by' => wp_get_current_user()->ID,
            $column_name => $quantity
        ];
        
        $result = $wpdb->insert($table_name, $insert_data);
        if ($result === false) {
            error_log("Failed to create turn-in tracker for shop $shop_id: " . $wpdb->last_error);
        } else {
            error_log("Created new turn-in tracker for shop $shop_id");
        }
    } else {
        // Update existing tracker
        $current_item_count = (int)($existing_tracker->{$column_name} ?? 0);
        $new_item_count = $current_item_count + $quantity;
        $new_total_count = (int)$existing_tracker->total_count + $quantity;
        
        $update_data = [
            'total_count' => $new_total_count,
            $column_name => $new_item_count
        ];
        
        $result = $wpdb->update($table_name, $update_data, ['shop_id' => $shop_id]);
        if ($result === false) {
            error_log("Failed to update turn-in tracker for shop $shop_id: " . $wpdb->last_error);
        } else {
            error_log("Updated turn-in tracker for shop $shop_id: $item_name count now $new_item_count");
        }
    }
}

/**
 * Sanitize item name for use as database column name
 */
function jotun_sanitize_item_column_name($item_name) {
    // Convert to lowercase, replace spaces and special chars with underscores
    $column_name = strtolower($item_name);
    $column_name = preg_replace('/[^a-z0-9_]/', '_', $column_name);
    // Remove consecutive underscores
    $column_name = preg_replace('/_+/', '_', $column_name);
    // Remove leading/trailing underscores
    $column_name = trim($column_name, '_');
    
    // Ensure it starts with a letter (MySQL requirement)
    if (preg_match('/^[0-9]/', $column_name)) {
        $column_name = 'item_' . $column_name;
    }
    
    // Limit length (MySQL column names max 64 chars)
    if (strlen($column_name) > 60) {
        $column_name = substr($column_name, 0, 60);
    }
    
    return $column_name;
}