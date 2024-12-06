<?php

if (!defined('ABSPATH')) exit; // Prevent direct access

function handle_trade_shops_put() {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['shop_id']) || !isset($data['shop_name'])) {
        wp_send_json_error(['message' => 'Invalid request data.'], 400);
        return;
    }

    $shop_id = absint($data['shop_id']);
    $shop_name = sanitize_text_field($data['shop_name']);
    $shop_type = isset($data['shop_type']) ? sanitize_text_field($data['shop_type']) : 'general';

    // Validate shop type
    $valid_shop_types = ['general', 'staff-only', 'admin-only'];
    if (!in_array($shop_type, $valid_shop_types)) {
        wp_send_json_error(['message' => 'Invalid shop type.'], 400);
        return;
    }

    if (!user_can_manage_shop($shop_name, $shop_type)) {
        wp_send_json_error(['message' => 'You do not have permission to update this shop.'], 403);
        return;
    }

    global $wpdb;

    $result = $wpdb->update(
        'jotun_shops',
        [
            'shop_name' => $shop_name,
            'shop_type' => $shop_type
        ],
        ['shop_id' => $shop_id],
        ['%s', '%s'],
        ['%d']
    );

    if ($result !== false) {
        wp_send_json_success(['message' => 'Shop updated successfully.'], 200);
    } else {
        wp_send_json_error(['message' => 'Failed to update shop.'], 500);
    }
}

add_action('rest_api_init', function () {
    register_rest_route('trade/v1', '/shops', [
        'methods' => 'PUT',
        'callback' => 'handle_trade_shops_put',
        'permission_callback' => 'validate_trade_api_key',
    ]);
});
