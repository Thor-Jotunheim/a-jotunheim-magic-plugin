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
        return new WP_REST_Response(['error' => 'Player name must not be blank'], 400);
    }

    $table_name = 'jotun_ledger';
    
    // Check if player already exists
    $existing_player = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE activePlayerName = %s OR playerName = %s",
        $player_name, $player_name
    ));
    
    if ($existing_player) {
        return new WP_REST_Response(['error' => 'Name already exists'], 409);
    }
    
    // Define default values for the new player
    $default_values = [
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
    
    $inserted = $wpdb->insert($table_name, $default_values, array_fill(0, count($default_values), '%s'));
    
    if ($inserted) {
        return new WP_REST_Response(['message' => "Successfully added player '$player_name'"], 201);
    } else {
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
            
            // Check if transaction_type column exists before adding it
            $columns = $wpdb->get_col("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$transaction_table' AND TABLE_SCHEMA = DATABASE()");
            if (in_array('transaction_type', $columns)) {
                $transaction_data_to_insert['transaction_type'] = $no_buys ? 'claim' : ($no_claims ? 'buy' : 'buy_and_claim');
                $format = ['%s', '%s', '%d', '%f', '%s', '%s', '%s', '%s'];
            } else {
                $format = ['%s', '%s', '%d', '%f', '%s', '%s', '%s'];
            }
            
            $result = $wpdb->insert($transaction_table, $transaction_data_to_insert, $format);
            
            if (!$result) {
                error_log("Failed to record transaction for item: " . $item['name']);
            }
        }
    }
    
    return new WP_REST_Response(['message' => "Transaction with '$player_name' recorded successfully!"], 200);
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
            
            // Check if transaction_type column exists before adding it
            $columns = $wpdb->get_col("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$transaction_table' AND TABLE_SCHEMA = DATABASE()");
            if (in_array('transaction_type', $columns)) {
                $transaction_data_to_insert['transaction_type'] = 'spell';
                $format = ['%s', '%s', '%d', '%f', '%s', '%s', '%s', '%s'];
            } else {
                $format = ['%s', '%s', '%d', '%f', '%s', '%s', '%s'];
            }
            
            $result = $wpdb->insert($transaction_table, $transaction_data_to_insert, $format);
            
            if (!$result) {
                error_log("Failed to record spell transaction for item: " . $item['name']);
            }
        }
    }
    
    return new WP_REST_Response(['message' => "Transaction with '$player_name' recorded successfully!"], 200);
}