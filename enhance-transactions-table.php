<?php
/**
 * Add player_id column to jotun_transactions table for foreign key relationship
 * Run this script once to enhance the transaction tracking system
 */

if (!defined('ABSPATH')) {
    // If not in WordPress context, include WordPress bootstrap
    require_once('../../../wp-config.php');
}

global $wpdb;

echo "=== Enhancing jotun_transactions Table ===\n";

// Check if player_id column already exists
$player_id_exists = $wpdb->get_results("SHOW COLUMNS FROM jotun_transactions LIKE 'player_id'");

if (empty($player_id_exists)) {
    echo "Adding player_id column to jotun_transactions table...\n";
    
    // Add player_id column with foreign key constraint
    $result = $wpdb->query("
        ALTER TABLE jotun_transactions 
        ADD COLUMN player_id int(11) DEFAULT NULL COMMENT 'Foreign key to jotun_playerlist.id' 
        AFTER customer_name
    ");
    
    if ($result !== false) {
        echo "✅ Successfully added player_id column\n";
        
        // Add foreign key constraint
        $fk_result = $wpdb->query("
            ALTER TABLE jotun_transactions 
            ADD CONSTRAINT fk_transactions_player 
            FOREIGN KEY (player_id) REFERENCES jotun_playerlist(id) 
            ON DELETE SET NULL ON UPDATE CASCADE
        ");
        
        if ($fk_result !== false) {
            echo "✅ Successfully added foreign key constraint\n";
        } else {
            echo "⚠️  Warning: Could not add foreign key constraint: " . $wpdb->last_error . "\n";
        }
        
        // Populate existing records with player_id where possible
        echo "Populating existing transaction records with player_id...\n";
        
        $update_result = $wpdb->query("
            UPDATE jotun_transactions t 
            INNER JOIN jotun_playerlist p ON (t.customer_name = p.activePlayerName OR t.customer_name = p.player_name)
            SET t.player_id = p.id 
            WHERE t.player_id IS NULL
        ");
        
        if ($update_result !== false) {
            echo "✅ Updated $update_result existing transaction records with player_id\n";
        } else {
            echo "⚠️  Warning: Could not update existing records: " . $wpdb->last_error . "\n";
        }
        
    } else {
        echo "❌ Failed to add player_id column: " . $wpdb->last_error . "\n";
    }
} else {
    echo "✅ player_id column already exists in jotun_transactions table\n";
    
    // Check if any records need updating
    $missing_player_ids = $wpdb->get_var("
        SELECT COUNT(*) FROM jotun_transactions t 
        INNER JOIN jotun_playerlist p ON (t.customer_name = p.activePlayerName OR t.customer_name = p.player_name)
        WHERE t.player_id IS NULL
    ");
    
    if ($missing_player_ids > 0) {
        echo "Found $missing_player_ids transaction records missing player_id. Updating...\n";
        
        $update_result = $wpdb->query("
            UPDATE jotun_transactions t 
            INNER JOIN jotun_playerlist p ON (t.customer_name = p.activePlayerName OR t.customer_name = p.player_name)
            SET t.player_id = p.id 
            WHERE t.player_id IS NULL
        ");
        
        if ($update_result !== false) {
            echo "✅ Updated $update_result transaction records with player_id\n";
        } else {
            echo "⚠️  Warning: Could not update records: " . $wpdb->last_error . "\n";
        }
    } else {
        echo "✅ All transaction records already have proper player_id relationships\n";
    }
}

// Show final table structure
echo "\n=== Final jotun_transactions Table Structure ===\n";
$columns = $wpdb->get_results("DESCRIBE jotun_transactions");
foreach ($columns as $column) {
    echo "- {$column->Field}: {$column->Type}" . ($column->Key ? " ({$column->Key})" : "") . "\n";
}

echo "\n=== Foreign Key Relationships ===\n";
$foreign_keys = $wpdb->get_results("
    SELECT 
        CONSTRAINT_NAME,
        COLUMN_NAME,
        REFERENCED_TABLE_NAME,
        REFERENCED_COLUMN_NAME
    FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
    WHERE CONSTRAINT_SCHEMA = DATABASE() 
    AND TABLE_NAME = 'jotun_transactions'
    AND REFERENCED_TABLE_NAME IS NOT NULL
");

if (!empty($foreign_keys)) {
    foreach ($foreign_keys as $fk) {
        echo "- {$fk->COLUMN_NAME} -> {$fk->REFERENCED_TABLE_NAME}.{$fk->REFERENCED_COLUMN_NAME} ({$fk->CONSTRAINT_NAME})\n";
    }
} else {
    echo "- No foreign key relationships found\n";
}

echo "\n=== Enhancement Complete! ===\n";
echo "The jotun_transactions table now supports proper player relationships via player_id foreign key.\n";
echo "All new transactions will automatically include player_id when recorded.\n";
?>