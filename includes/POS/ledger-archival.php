<?php
/**
 * Jotunheim Ledger Archival System
 * Handles world resets, legacy item tracking, and ledger archival operations
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class JotunLedgerArchival {
    
    public static function create_archive_tables() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        // Archive transactions table
        $archive_transactions_sql = "CREATE TABLE jotun_transactions_archive (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            original_id bigint(20) NOT NULL,
            shop_type varchar(50) NOT NULL,
            shop_id bigint(20) DEFAULT NULL,
            teller varchar(255) NOT NULL,
            player varchar(255) NOT NULL,
            transaction_date datetime NOT NULL,
            total_cost decimal(10,2) DEFAULT 0.00,
            ymir_flesh int(11) DEFAULT 0,
            gold int(11) DEFAULT 0,
            vidars_hammer int(11) DEFAULT 0,
            archived_date datetime NOT NULL,
            archived_by bigint(20) DEFAULT NULL,
            world_reset_id bigint(20) DEFAULT NULL,
            PRIMARY KEY (id),
            KEY original_id (original_id),
            KEY shop_type (shop_type),
            KEY player (player),
            KEY archived_date (archived_date),
            KEY world_reset_id (world_reset_id)
        ) $charset_collate;";
        
        // Archive ledger table
        $archive_ledger_sql = "CREATE TABLE jotun_ledger_archive (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            original_id bigint(20) NOT NULL,
            playerName varchar(255) NOT NULL,
            activePlayerName varchar(255) NOT NULL,
            vidar int(11) DEFAULT 0,
            unbreakableoath int(11) DEFAULT 0,
            eternalflame int(11) DEFAULT 0,
            archived_date datetime NOT NULL,
            archived_by bigint(20) DEFAULT NULL,
            world_reset_id bigint(20) DEFAULT NULL,
            PRIMARY KEY (id),
            KEY original_id (original_id),
            KEY playerName (playerName),
            KEY activePlayerName (activePlayerName),
            KEY archived_date (archived_date),
            KEY world_reset_id (world_reset_id)
        ) $charset_collate;";
        
        // World resets tracking table
        $world_resets_sql = "CREATE TABLE jotun_world_resets (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            reset_name varchar(255) NOT NULL,
            reset_date datetime NOT NULL,
            reset_by bigint(20) DEFAULT NULL,
            transactions_archived int(11) DEFAULT 0,
            ledger_entries_archived int(11) DEFAULT 0,
            legacy_items_preserved text DEFAULT NULL,
            notes text DEFAULT NULL,
            PRIMARY KEY (id),
            KEY reset_date (reset_date),
            KEY reset_by (reset_by)
        ) $charset_collate;";
        
        // Legacy items tracking table
        $legacy_items_sql = "CREATE TABLE jotun_legacy_items (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            player_id bigint(20) NOT NULL,
            item_name varchar(255) NOT NULL,
            item_type varchar(100) DEFAULT NULL,
            quantity int(11) DEFAULT 1,
            original_transaction_id bigint(20) DEFAULT NULL,
            world_reset_id bigint(20) NOT NULL,
            preserved_date datetime NOT NULL,
            claimed_date datetime DEFAULT NULL,
            is_claimed tinyint(1) DEFAULT 0,
            notes text DEFAULT NULL,
            PRIMARY KEY (id),
            KEY player_id (player_id),
            KEY item_name (item_name),
            KEY world_reset_id (world_reset_id),
            KEY is_claimed (is_claimed)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        
        dbDelta($archive_transactions_sql);
        dbDelta($archive_ledger_sql);
        dbDelta($world_resets_sql);
        dbDelta($legacy_items_sql);
        
        error_log("Created/Updated ledger archival tables");
    }
    
    public static function initiate_world_reset($reset_name, $preserve_legacy_items = true) {
        global $wpdb;
        
        $reset_id = null;
        
        // Start transaction
        $wpdb->query('START TRANSACTION');
        
        try {
            // Create world reset record
            $result = $wpdb->insert('jotun_world_resets', [
                'reset_name' => sanitize_text_field($reset_name),
                'reset_date' => current_time('mysql'),
                'reset_by' => get_current_user_id(),
                'notes' => 'World reset initiated'
            ]);
            
            if ($result === false) {
                throw new Exception('Failed to create world reset record');
            }
            
            $reset_id = $wpdb->insert_id;
            
            // Archive all transactions
            $transactions_archived = self::archive_transactions($reset_id);
            
            // Archive all ledger entries
            $ledger_archived = self::archive_ledger($reset_id);
            
            // Preserve legacy items if requested
            $legacy_items = [];
            if ($preserve_legacy_items) {
                $legacy_items = self::preserve_legacy_items($reset_id);
            }
            
            // Update reset record with counts
            $wpdb->update('jotun_world_resets', [
                'transactions_archived' => $transactions_archived,
                'ledger_entries_archived' => $ledger_archived,
                'legacy_items_preserved' => json_encode($legacy_items),
                'notes' => "World reset completed. Archived $transactions_archived transactions and $ledger_archived ledger entries."
            ], ['id' => $reset_id]);
            
            // Clear active data
            self::clear_active_data();
            
            // Commit transaction
            $wpdb->query('COMMIT');
            
            error_log("World reset '$reset_name' completed successfully (ID: $reset_id)");
            
            return [
                'success' => true,
                'reset_id' => $reset_id,
                'transactions_archived' => $transactions_archived,
                'ledger_entries_archived' => $ledger_archived,
                'legacy_items_preserved' => count($legacy_items)
            ];
            
        } catch (Exception $e) {
            // Rollback on error
            $wpdb->query('ROLLBACK');
            error_log("World reset failed: " . $e->getMessage());
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    private static function archive_transactions($reset_id) {
        global $wpdb;
        
        // Copy all transactions to archive
        $result = $wpdb->query($wpdb->prepare("
            INSERT INTO jotun_transactions_archive 
            (original_id, shop_type, shop_id, teller, player, transaction_date, total_cost, ymir_flesh, gold, vidars_hammer, archived_date, archived_by, world_reset_id)
            SELECT id, shop_type, shop_id, teller, player, transaction_date, total_cost, ymir_flesh, gold, vidars_hammer, %s, %d, %d
            FROM jotun_transactions
        ", current_time('mysql'), get_current_user_id(), $reset_id));
        
        return $wpdb->rows_affected;
    }
    
    private static function archive_ledger($reset_id) {
        global $wpdb;
        
        // Copy all ledger entries to archive
        $result = $wpdb->query($wpdb->prepare("
            INSERT INTO jotun_ledger_archive 
            (original_id, playerName, activePlayerName, vidar, unbreakableoath, eternalflame, archived_date, archived_by, world_reset_id)
            SELECT id, playerName, activePlayerName, vidar, unbreakableoath, eternalflame, %s, %d, %d
            FROM jotun_ledger
        ", current_time('mysql'), get_current_user_id(), $reset_id));
        
        return $wpdb->rows_affected;
    }
    
    private static function preserve_legacy_items($reset_id) {
        global $wpdb;
        
        // Get all players with unclaimed items (Vidar's Hammer > 0)
        $players_with_legacy = $wpdb->get_results("
            SELECT pl.id as player_id, pl.activePlayerName, l.vidar, l.unbreakableoath, l.eternalflame
            FROM jotun_playerlist pl
            JOIN jotun_ledger l ON pl.activePlayerName = l.activePlayerName
            WHERE l.vidar > 0 OR l.unbreakableoath > 0 OR l.eternalflame > 0
        ");
        
        $legacy_items = [];
        
        foreach ($players_with_legacy as $player) {
            // Preserve Vidar's Hammer
            if ($player->vidar > 0) {
                $wpdb->insert('jotun_legacy_items', [
                    'player_id' => $player->player_id,
                    'item_name' => 'Vidar\'s Hammer',
                    'item_type' => 'legacy_currency',
                    'quantity' => $player->vidar,
                    'world_reset_id' => $reset_id,
                    'preserved_date' => current_time('mysql'),
                    'notes' => 'Preserved from world reset'
                ]);
                $legacy_items[] = ['player' => $player->activePlayerName, 'item' => 'Vidar\'s Hammer', 'quantity' => $player->vidar];
            }
            
            // Preserve Unbreakable Oath
            if ($player->unbreakableoath > 0) {
                $wpdb->insert('jotun_legacy_items', [
                    'player_id' => $player->player_id,
                    'item_name' => 'Unbreakable Oath',
                    'item_type' => 'legacy_currency',
                    'quantity' => $player->unbreakableoath,
                    'world_reset_id' => $reset_id,
                    'preserved_date' => current_time('mysql'),
                    'notes' => 'Preserved from world reset'
                ]);
                $legacy_items[] = ['player' => $player->activePlayerName, 'item' => 'Unbreakable Oath', 'quantity' => $player->unbreakableoath];
            }
            
            // Preserve Eternal Flame
            if ($player->eternalflame > 0) {
                $wpdb->insert('jotun_legacy_items', [
                    'player_id' => $player->player_id,
                    'item_name' => 'Eternal Flame',
                    'item_type' => 'legacy_currency',
                    'quantity' => $player->eternalflame,
                    'world_reset_id' => $reset_id,
                    'preserved_date' => current_time('mysql'),
                    'notes' => 'Preserved from world reset'
                ]);
                $legacy_items[] = ['player' => $player->activePlayerName, 'item' => 'Eternal Flame', 'quantity' => $player->eternalflame];
            }
        }
        
        return $legacy_items;
    }
    
    private static function clear_active_data() {
        global $wpdb;
        
        // Clear transactions (but keep transaction structure)
        $wpdb->query("DELETE FROM jotun_transactions");
        
        // Reset ledger values but keep players
        $wpdb->query("UPDATE jotun_ledger SET vidar = 0, unbreakableoath = 0, eternalflame = 0");
    }
    
    public static function get_legacy_items_for_player($player_id) {
        global $wpdb;
        
        return $wpdb->get_results($wpdb->prepare("
            SELECT li.*, wr.reset_name, wr.reset_date
            FROM jotun_legacy_items li
            JOIN jotun_world_resets wr ON li.world_reset_id = wr.id
            WHERE li.player_id = %d AND li.is_claimed = 0
            ORDER BY li.preserved_date DESC
        ", $player_id));
    }
    
    public static function claim_legacy_item($legacy_item_id, $player_id) {
        global $wpdb;
        
        // Verify the item belongs to the player
        $item = $wpdb->get_row($wpdb->prepare("
            SELECT * FROM jotun_legacy_items 
            WHERE id = %d AND player_id = %d AND is_claimed = 0
        ", $legacy_item_id, $player_id));
        
        if (!$item) {
            return ['success' => false, 'error' => 'Legacy item not found or already claimed'];
        }
        
        // Mark as claimed
        $result = $wpdb->update('jotun_legacy_items', [
            'is_claimed' => 1,
            'claimed_date' => current_time('mysql')
        ], ['id' => $legacy_item_id]);
        
        if ($result !== false) {
            // Add the item back to the player's ledger
            $column_map = [
                'Vidar\'s Hammer' => 'vidar',
                'Unbreakable Oath' => 'unbreakableoath',
                'Eternal Flame' => 'eternalflame'
            ];
            
            if (isset($column_map[$item->item_name])) {
                $column = $column_map[$item->item_name];
                $wpdb->query($wpdb->prepare("
                    UPDATE jotun_ledger 
                    SET $column = $column + %d 
                    WHERE id = (SELECT id FROM jotun_playerlist WHERE id = %d LIMIT 1)
                ", $item->quantity, $player_id));
            }
            
            return [
                'success' => true,
                'item' => $item->item_name,
                'quantity' => $item->quantity
            ];
        }
        
        return ['success' => false, 'error' => 'Failed to claim legacy item'];
    }
}

// Create tables when this file is loaded
add_action('init', function() {
    global $wpdb;
    
    $tables_to_check = [
        'jotun_transactions_archive',
        'jotun_ledger_archive', 
        'jotun_world_resets',
        'jotun_legacy_items'
    ];
    
    $tables_exist = true;
    foreach ($tables_to_check as $table) {
        if ($wpdb->get_var("SHOW TABLES LIKE '$table'") != $table) {
            $tables_exist = false;
            break;
        }
    }
    
    if (!$tables_exist) {
        JotunLedgerArchival::create_archive_tables();
    }
});