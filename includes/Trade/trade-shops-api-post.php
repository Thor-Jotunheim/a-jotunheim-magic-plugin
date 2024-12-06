<?php

if (!defined('ABSPATH')) exit; // Prevent direct access

function handle_trade_shops_post() {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['shop_name'])) {
        wp_send_json_error(['message' => 'Invalid request data.'], 400);
        return;
    }

    $shop_name = sanitize_text_field($data['shop_name']);
    $shop_type = isset($data['shop_type']) ? sanitize_text_field($data['shop_type']) : 'general';

    // Validate shop type
    $valid_shop_types = ['general', 'staff-only', 'admin-only'];
    if (!in_array($shop_type, $valid_shop_types)) {
        wp_send_json_error(['message' => 'Invalid shop type.'], 400);
        return;
    }

    if (!user_can_manage_shop($shop_name, $shop_type)) {
        wp_send_json_error(['message' => 'You do not have permission to create this shop.'], 403);
        return;
    }

    global $wpdb;

    $result = $wpdb->insert(
        'jotun_shops',
        [
            'shop_name' => $shop_name,
            'shop_type' => $shop_type
        ],
        ['%s', '%s']
    );

    if ($result) {
        wp_send_json_success(['message' => 'Shop created successfully.'], 201);
    } else {
        wp_send_json_error(['message' => 'Failed to create shop.'], 500);
    }
}

add_action('rest_api_init', function () {
    register_rest_route('trade/v1', '/shops', [
        'methods' => 'POST',
        'callback' => 'handle_trade_shops_post',
        'permission_callback' => 'validate_trade_api_key',
    ]);
});
