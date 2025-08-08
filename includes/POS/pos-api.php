<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Register all POS REST API routes
add_action('rest_api_init', function() {
    // Player registration endpoint
    register_rest_route('pos/v1', '/register-player', [
        'methods' => 'POST',
        'callback' => 'pos_register_player',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        },
        'args' => [
            'playerName' => [
                'required' => true,
                'validate_callback' => function($param) {
                    return is_string($param) && !empty(trim($param));
                }
            ]
        ]
    ]);

    // Admin transaction recording endpoint
    register_rest_route('pos/v1', '/admin-record', [
        'methods' => 'POST',
        'callback' => 'pos_admin_record',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);

    // Spell transaction recording endpoint
    register_rest_route('pos/v1', '/spell-record', [
        'methods' => 'POST',
        'callback' => 'pos_spell_record',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);

    // Player validation endpoint
    register_rest_route('pos/v1', '/validate-player', [
        'methods' => 'POST',
        'callback' => 'pos_validate_player',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        },
        'args' => [
            'playerName' => [
                'required' => true,
                'validate_callback' => function($param) {
                    return is_string($param) && !empty(trim($param));
                }
            ]
        ]
    ]);
});

/**
 * Register a new player
 */
function pos_register_player($request) {
    global $wpdb;
    
    $player_name = sanitize_text_field(trim($request['playerName']));
    
    if (empty($player_name)) {
        error_log("POS: Player registration failed - empty player name");
        return new WP_REST_Response(['error' => 'Player name must not be blank'], 400);
    }

    $table_name = 'jotun_ledger';
    
    // Check if player already exists
    $existing_player = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE activePlayerName = %s OR playerName = %s",
        $player_name, $player_name
    ));
    
    if ($existing_player) {
        error_log("POS: Player registration failed - player '$player_name' already exists");
        return new WP_REST_Response(['error' => 'Name already exists'], 409);
    }
    
    // Get default values from database utilities
    $default_values = POS_Database_Utils::get_default_player_values($player_name);
    
    $inserted = $wpdb->insert($table_name, $default_values, array_fill(0, count($default_values), '%s'));
    
    if ($inserted) {
        error_log("POS: Successfully registered new player: $player_name");
        return new WP_REST_Response(['message' => "Successfully added player '$player_name'"], 201);
    } else {
        error_log("POS: Database error while registering player '$player_name': " . $wpdb->last_error);
        return new WP_REST_Response(['error' => 'Failed to add player'], 500);
    }
}

/**
 * Validate if a player exists
 */
function pos_validate_player($request) {
    global $wpdb;
    
    $player_name = sanitize_text_field(trim($request['playerName']));
    
    if (empty($player_name)) {
        return new WP_REST_Response(['status' => -1, 'message' => 'Player name cannot be blank'], 200);
    }
    
    $table_name = 'jotun_ledger';
    
    // Check if player exists
    $existing_player = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE activePlayerName = %s OR playerName = %s",
        $player_name, $player_name
    ));
    
    if ($existing_player) {
        return new WP_REST_Response(['status' => 1, 'message' => 'Player found'], 200);
    } else {
        return new WP_REST_Response(['status' => 0, 'message' => 'Player not found'], 200);
    }
}

/**
 * Record admin transaction
 */
function pos_admin_record($request) {
    global $wpdb;
    
    $player_name = sanitize_text_field(trim($request['playerName']));
    $transaction_data = $request['transactionData'] ?? [];
    $no_buys = isset($request['noBuys']) ? (bool)$request['noBuys'] : false;
    $no_claims = isset($request['noClaims']) ? (bool)$request['noClaims'] : false;
    
    // Validate player exists
    $table_name = 'jotun_ledger';
    $existing_player = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE activePlayerName = %s OR playerName = %s",
        $player_name, $player_name
    ));
    
    if (!$existing_player) {
        return new WP_REST_Response(['error' => 'Player not found'], 404);
    }
    
    if (empty($transaction_data)) {
        return new WP_REST_Response(['error' => 'No transaction data provided'], 400);
    }
    
    // Record transaction in transactions table
    $transaction_table = 'jotun_transactions';
    $teller = wp_get_current_user()->display_name;
    $recorded_count = 0;
    
    foreach ($transaction_data as $item) {
        if (isset($item['name']) && isset($item['quantity']) && $item['quantity'] > 0) {
            $transaction_data_to_insert = [
                'shop_name' => 'POS_Admin',
                'item_name' => sanitize_text_field($item['name']),
                'quantity' => absint($item['quantity']),
                'total_amount' => floatval($item['amount'] ?? 0),
                'customer_name' => $player_name,
                'teller' => $teller,
                'transaction_date' => current_time('mysql')
            ];
            
            // Use database utilities for safe column handling
            $include_transaction_type = POS_Database_Utils::column_exists('jotun_transactions', 'transaction_type');
            if ($include_transaction_type) {
                $transaction_data_to_insert['transaction_type'] = $no_buys ? 'claim' : ($no_claims ? 'buy' : 'buy_and_claim');
            }
            
            $format = POS_Database_Utils::get_transaction_insert_format($include_transaction_type);
            $result = $wpdb->insert($transaction_table, $transaction_data_to_insert, $format);
            
            if ($result) {
                $recorded_count++;
            } else {
                error_log("POS: Failed to record transaction for item: " . $item['name']);
            }
        }
    }
    
    if ($recorded_count > 0) {
        return new WP_REST_Response(['message' => "Transaction with '$player_name' recorded successfully! ($recorded_count items)"], 200);
    } else {
        return new WP_REST_Response(['error' => 'No valid transactions were recorded'], 400);
    }
}

/**
 * Record spell transaction
 */
function pos_spell_record($request) {
    global $wpdb;
    
    $player_name = sanitize_text_field(trim($request['playerName']));
    $transaction_data = $request['transactionData'] ?? [];
    
    // Validate player exists
    $table_name = 'jotun_ledger';
    $existing_player = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE activePlayerName = %s OR playerName = %s",
        $player_name, $player_name
    ));
    
    if (!$existing_player) {
        return new WP_REST_Response(['error' => 'Player not found'], 404);
    }
    
    if (empty($transaction_data)) {
        return new WP_REST_Response(['error' => 'No transaction data provided'], 400);
    }
    
    // Record transaction in transactions table
    $transaction_table = 'jotun_transactions';
    $teller = wp_get_current_user()->display_name;
    $recorded_count = 0;
    
    foreach ($transaction_data as $item) {
        if (isset($item['name']) && isset($item['quantity']) && $item['quantity'] > 0) {
            $transaction_data_to_insert = [
                'shop_name' => 'POS_Spell',
                'item_name' => sanitize_text_field($item['name']),
                'quantity' => absint($item['quantity']),
                'total_amount' => floatval($item['amount'] ?? 0),
                'customer_name' => $player_name,
                'teller' => $teller,
                'transaction_date' => current_time('mysql')
            ];
            
            // Use database utilities for safe column handling
            $include_transaction_type = POS_Database_Utils::column_exists('jotun_transactions', 'transaction_type');
            if ($include_transaction_type) {
                $transaction_data_to_insert['transaction_type'] = 'spell';
            }
            
            $format = POS_Database_Utils::get_transaction_insert_format($include_transaction_type);
            $result = $wpdb->insert($transaction_table, $transaction_data_to_insert, $format);
            
            if ($result) {
                $recorded_count++;
            } else {
                error_log("POS: Failed to record spell transaction for item: " . $item['name']);
            }
        }
    }
    
    if ($recorded_count > 0) {
        return new WP_REST_Response(['message' => "Spell transaction with '$player_name' recorded successfully! ($recorded_count spells)"], 200);
    } else {
        return new WP_REST_Response(['error' => 'No valid spell transactions were recorded'], 400);
    }
}