<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Comprehensive API for all Jotunheim database tables
 * Provides CRUD operations for all major database tables
 */

// Ensure shop types table exists
add_action('init', 'jotun_ensure_shop_types_table');

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
        ]
    ];
    
    foreach ($default_types as $type) {
        $wpdb->insert('jotun_shop_types', $type);
    }
}

// Register all comprehensive REST API routes
add_action('rest_api_init', function() {
    error_log('DEBUG: REST API init hook called - registering jotun-api routes');
    
    // Debug endpoint to test API connectivity
    register_rest_route('jotun-api/v1', '/debug-test', [
        'methods' => 'GET',
        'callback' => function() {
            error_log('DEBUG: API endpoint test called successfully');
            return new WP_REST_Response(['message' => 'API is working!', 'timestamp' => current_time('mysql')], 200);
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
    
    error_log('DEBUG: Registering shops API endpoints');
    
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
    
    error_log('DEBUG: Finished registering shops API endpoints');
    
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
    
    // Update shop item
    register_rest_route('jotun-api/v1', '/shop-items/(?P<id>\d+)', [
        'methods' => 'PUT',
        'callback' => 'jotun_api_update_shop_item',
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
    
    // Delete shop item
    register_rest_route('jotun-api/v1', '/shop-items/(?P<id>\d+)', [
        'methods' => 'DELETE',
        'callback' => 'jotun_api_delete_shop_item',
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
});

// ============================================================================
// PLAYER LIST FUNCTIONS (jotun_playerlist)
// ============================================================================

function jotun_api_get_playerlist($request) {
    global $wpdb;
    
    $table_name = 'jotun_playerlist';
    $limit = $request->get_param('limit') ?: 100;
    $offset = $request->get_param('offset') ?: 0;
    $search = $request->get_param('search');
    
    $sql = "SELECT * FROM $table_name";
    $params = [];
    
    if ($search) {
        $sql .= " WHERE player_name LIKE %s";
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
        'shop_type' => sanitize_text_field($data['shop_type'] ?? 'player'),
        'owner_name' => $owner_name,
        'is_active' => isset($data['is_active']) ? (int)$data['is_active'] : 1,
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
        'shop_type' => sanitize_text_field($data['shop_type'] ?? 'player'),
        'is_active' => isset($data['is_active']) ? (int)$data['is_active'] : 1
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
    $limit = $request->get_param('limit') ?: 100;
    $offset = $request->get_param('offset') ?: 0;
    
    $sql = "SELECT * FROM $table_name";
    $params = [];
    
    if ($shop_id) {
        $sql .= " WHERE shop_id = %d";
        $params[] = (int)$shop_id;
    }
    
    $sql .= " ORDER BY item_name ASC LIMIT %d OFFSET %d";
    $params[] = $limit;
    $params[] = $offset;
    
    $results = $wpdb->get_results($wpdb->prepare($sql, $params));
    
    if ($wpdb->last_error) {
        return new WP_REST_Response(['error' => 'Database error: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['data' => $results], 200);
}

function jotun_api_add_shop_item($request) {
    global $wpdb;
    
    $data = $request->get_json_params();
    $table_name = 'jotun_shop_items';
    
    if (empty($data['shop_id']) || empty($data['item_name']) || empty($data['price'])) {
        return new WP_REST_Response(['error' => 'Shop ID, item name, and price are required'], 400);
    }
    
    $insert_data = [
        'shop_id' => (int)$data['shop_id'],
        'item_name' => sanitize_text_field($data['item_name']),
        'price' => floatval($data['price']),
        'quantity_available' => (int)($data['quantity_available'] ?? -1), // -1 for unlimited
        'description' => sanitize_textarea_field($data['description'] ?? ''),
        'is_active' => isset($data['is_active']) ? (bool)$data['is_active'] : true,
        'created_date' => current_time('mysql')
    ];
    
    $result = $wpdb->insert($table_name, $insert_data);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to add shop item: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['message' => 'Shop item added successfully', 'id' => $wpdb->insert_id], 201);
}

function jotun_api_update_shop_item($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $data = $request->get_json_params();
    $table_name = 'jotun_shop_items';
    
    if (empty($data['item_name']) || empty($data['price'])) {
        return new WP_REST_Response(['error' => 'Item name and price are required'], 400);
    }
    
    $update_data = [
        'item_name' => sanitize_text_field($data['item_name']),
        'price' => floatval($data['price']),
        'quantity_available' => (int)($data['quantity_available'] ?? -1),
        'description' => sanitize_textarea_field($data['description'] ?? ''),
        'is_active' => isset($data['is_active']) ? (bool)$data['is_active'] : true
    ];
    
    $result = $wpdb->update($table_name, $update_data, ['id' => $id]);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to update shop item: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['message' => 'Shop item updated successfully'], 200);
}

function jotun_api_delete_shop_item($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $table_name = 'jotun_shop_items';
    
    $result = $wpdb->delete($table_name, ['id' => $id]);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to delete shop item: ' . $wpdb->last_error], 500);
    }
    
    if ($result === 0) {
        return new WP_REST_Response(['error' => 'Shop item not found'], 404);
    }
    
    return new WP_REST_Response(['message' => 'Shop item deleted successfully'], 200);
}

// ============================================================================
// TRANSACTIONS FUNCTIONS (jotun_transactions)
// ============================================================================

function jotun_api_get_transactions($request) {
    global $wpdb;
    
    $table_name = 'jotun_transactions';
    $shop_name = $request->get_param('shop_name');
    $customer_name = $request->get_param('customer_name');
    $limit = $request->get_param('limit') ?: 100;
    $offset = $request->get_param('offset') ?: 0;
    $date_from = $request->get_param('date_from');
    $date_to = $request->get_param('date_to');
    
    $sql = "SELECT * FROM $table_name";
    $params = [];
    $conditions = [];
    
    if ($shop_name) {
        $conditions[] = "shop_name = %s";
        $params[] = $shop_name;
    }
    
    if ($customer_name) {
        $conditions[] = "customer_name LIKE %s";
        $params[] = '%' . $wpdb->esc_like($customer_name) . '%';
    }
    
    if ($date_from) {
        $conditions[] = "transaction_date >= %s";
        $params[] = $date_from;
    }
    
    if ($date_to) {
        $conditions[] = "transaction_date <= %s";
        $params[] = $date_to;
    }
    
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }
    
    $sql .= " ORDER BY transaction_date DESC LIMIT %d OFFSET %d";
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
    $table_name = 'jotun_transactions';
    
    if (empty($data['shop_name']) || empty($data['item_name']) || empty($data['customer_name'])) {
        return new WP_REST_Response(['error' => 'Shop name, item name, and customer name are required'], 400);
    }
    
    $insert_data = [
        'shop_name' => sanitize_text_field($data['shop_name']),
        'item_name' => sanitize_text_field($data['item_name']),
        'quantity' => (int)($data['quantity'] ?? 1),
        'total_amount' => floatval($data['total_amount'] ?? 0),
        'customer_name' => sanitize_text_field($data['customer_name']),
        'teller' => sanitize_text_field($data['teller'] ?? wp_get_current_user()->display_name),
        'transaction_date' => $data['transaction_date'] ?? current_time('mysql'),
        'transaction_type' => sanitize_text_field($data['transaction_type'] ?? 'general')
    ];
    
    $result = $wpdb->insert($table_name, $insert_data);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to add transaction: ' . $wpdb->last_error], 500);
    }
    
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

// ============================================================================
// ITEM LIST FUNCTIONS (jotun_itemlist)
// ============================================================================

function jotun_api_get_itemlist($request) {
    global $wpdb;
    
    $table_name = 'jotun_itemlist';
    $limit = $request->get_param('limit') ?: 100;
    $offset = $request->get_param('offset') ?: 0;
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
    
    $sql .= " ORDER BY item_name ASC LIMIT %d OFFSET %d";
    $params[] = $limit;
    $params[] = $offset;
    
    $results = $wpdb->get_results($wpdb->prepare($sql, $params));
    
    if ($wpdb->last_error) {
        return new WP_REST_Response(['error' => 'Database error: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['data' => $results], 200);
}

function jotun_api_add_item($request) {
    global $wpdb;
    
    $data = $request->get_json_params();
    $table_name = 'jotun_itemlist';
    
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
    $table_name = 'jotun_itemlist';
    
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
    $table_name = 'jotun_itemlist';
    
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
    $results = $wpdb->get_results("SELECT * FROM $table_name WHERE is_active = 1 ORDER BY type_name ASC");
    
    if ($wpdb->last_error) {
        return new WP_REST_Response(['error' => 'Database error: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['data' => $results], 200);
}

function jotun_api_add_shop_type($request) {
    global $wpdb;
    
    $data = $request->get_json_params();
    $table_name = 'jotun_shop_types';
    
    if (empty($data['type_name']) || empty($data['type_key'])) {
        return new WP_REST_Response(['error' => 'Type name and key are required'], 400);
    }
    
    $insert_data = [
        'type_name' => sanitize_text_field($data['type_name']),
        'type_key' => sanitize_key($data['type_key']),
        'description' => sanitize_textarea_field($data['description'] ?? ''),
        'default_permissions' => json_encode($data['default_permissions'] ?? []),
        'is_active' => 1,
        'created_at' => current_time('mysql')
    ];
    
    $result = $wpdb->insert($table_name, $insert_data);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to add shop type: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['message' => 'Shop type added successfully', 'id' => $wpdb->insert_id], 201);
}

function jotun_api_update_shop_type($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $data = $request->get_json_params();
    $table_name = 'jotun_shop_types';
    
    if (empty($data['type_name'])) {
        return new WP_REST_Response(['error' => 'Type name is required'], 400);
    }
    
    $update_data = [
        'type_name' => sanitize_text_field($data['type_name']),
        'description' => sanitize_textarea_field($data['description'] ?? ''),
        'default_permissions' => json_encode($data['default_permissions'] ?? []),
        'updated_at' => current_time('mysql')
    ];
    
    $result = $wpdb->update($table_name, $update_data, ['type_id' => $id]);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to update shop type: ' . $wpdb->last_error], 500);
    }
    
    return new WP_REST_Response(['message' => 'Shop type updated successfully'], 200);
}

function jotun_api_delete_shop_type($request) {
    global $wpdb;
    
    $id = (int) $request['id'];
    $table_name = 'jotun_shop_types';
    
    // Soft delete by setting is_active to 0
    $result = $wpdb->update($table_name, ['is_active' => 0], ['type_id' => $id]);
    
    if ($result === false) {
        return new WP_REST_Response(['error' => 'Failed to delete shop type: ' . $wpdb->last_error], 500);
    }
    
    if ($result === 0) {
        return new WP_REST_Response(['error' => 'Shop type not found'], 404);
    }
    
    return new WP_REST_Response(['message' => 'Shop type deleted successfully'], 200);
}