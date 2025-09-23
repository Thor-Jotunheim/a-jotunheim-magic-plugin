<?php
/**
 * World Reset REST API Endpoint
 * Handles world reset operations through REST API
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

add_action('rest_api_init', function() {
    register_rest_route('jotunheim-magic/v1', '/world-reset', [
        'methods' => 'POST',
        'callback' => 'jotun_api_world_reset',
        'permission_callback' => function() {
            // Only allow users with administrator role or specific Discord roles
            return current_user_can('administrator') || current_user_can('manage_options');
        }
    ]);
    
    register_rest_route('jotunheim-magic/v1', '/legacy-items/(?P<player_id>\d+)', [
        'methods' => 'GET',
        'callback' => 'jotun_api_get_legacy_items',
        'permission_callback' => '__return_true'
    ]);
    
    register_rest_route('jotunheim-magic/v1', '/legacy-items/(?P<item_id>\d+)/claim', [
        'methods' => 'POST',
        'callback' => 'jotun_api_claim_legacy_item',
        'permission_callback' => '__return_true'
    ]);
});

function jotun_api_world_reset($request) {
    $data = $request->get_json_params();
    
    $reset_name = sanitize_text_field($data['reset_name'] ?? '');
    $preserve_legacy = isset($data['preserve_legacy_items']) ? (bool)$data['preserve_legacy_items'] : true;
    
    if (empty($reset_name)) {
        return new WP_REST_Response(['error' => 'Reset name is required'], 400);
    }
    
    // Include the ledger archival class
    require_once plugin_dir_path(__FILE__) . 'ledger-archival.php';
    
    $result = JotunLedgerArchival::initiate_world_reset($reset_name, $preserve_legacy);
    
    if ($result['success']) {
        return new WP_REST_Response([
            'success' => true,
            'message' => 'World reset completed successfully',
            'data' => $result
        ], 200);
    } else {
        return new WP_REST_Response([
            'success' => false,
            'error' => $result['error']
        ], 500);
    }
}

function jotun_api_get_legacy_items($request) {
    $player_id = (int) $request['player_id'];
    
    require_once plugin_dir_path(__FILE__) . 'ledger-archival.php';
    
    $legacy_items = JotunLedgerArchival::get_legacy_items_for_player($player_id);
    
    return new WP_REST_Response([
        'success' => true,
        'data' => $legacy_items
    ], 200);
}

function jotun_api_claim_legacy_item($request) {
    $item_id = (int) $request['item_id'];
    $data = $request->get_json_params();
    $player_id = (int) ($data['player_id'] ?? 0);
    
    if (!$player_id) {
        return new WP_REST_Response(['error' => 'Player ID is required'], 400);
    }
    
    require_once plugin_dir_path(__FILE__) . 'ledger-archival.php';
    
    $result = JotunLedgerArchival::claim_legacy_item($item_id, $player_id);
    
    if ($result['success']) {
        return new WP_REST_Response([
            'success' => true,
            'message' => 'Legacy item claimed successfully',
            'data' => $result
        ], 200);
    } else {
        return new WP_REST_Response([
            'success' => false,
            'error' => $result['error']
        ], 400);
    }
}