<?php

if (!defined('ABSPATH')) exit; // Prevent direct access

function handle_trade_shop_items_post() {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['shop_name']) || !isset($data['item_name'])) {
        wp_send_json_error(['message' => 'Invalid request data.'], 400);
        return;
    }

    $shop_name = sanitize_text_field($data['shop_name']);
    $shop_type = isset($data['shop_type']) ? sanitize_text_field($data['shop_type']) : 'general';

    if (!user_can_manage_shop($shop_name, $shop_type)) {
        wp_send_json_error(['message' => 'You do not have permission to add items to this shop.'], 403);
        return;
    }

    global $wpdb;

    $shop_id = $wpdb->get_var($wpdb->prepare(
        "SELECT shop_id FROM jotun_shops WHERE shop_name = %s LIMIT 1",
        $shop_name
    ));

    if (!$shop_id) {
        wp_send_json_error(['message' => 'Shop not found.'], 404);
        return;
    }

    $result = $wpdb->insert(
        'jotun_shop_items',
        [
            'shop_id' => $shop_id,
            'item_name' => sanitize_text_field($data['item_name']),
            'quantity' => absint($data['quantity']),
            'price' => floatval($data['price'])
        ],
        ['%d', '%s', '%d', '%f']
    );

    if ($result) {
        wp_send_json_success(['message' => 'Shop item added successfully.'], 201);
    } else {
        wp_send_json_error(['message' => 'Failed to add shop item.'], 500);
    }
}

add_action('rest_api_init', function () {
    register_rest_route('trade/v1', '/shop-items', [
        'methods' => 'POST',
        'callback' => 'handle_trade_shop_items_post',
        'permission_callback' => 'validate_api_key',
    ]);
});
