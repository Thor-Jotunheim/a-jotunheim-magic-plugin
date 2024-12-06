<?php

if (!defined('ABSPATH')) exit; // Prevent direct access

function handle_trade_transactions_post() {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['shop_name']) || !isset($data['item_name'])) {
        wp_send_json_error(['message' => 'Invalid request data.'], 400);
        return;
    }

    $shop_name = sanitize_text_field($data['shop_name']);
    $shop_type = isset($data['shop_type']) ? sanitize_text_field($data['shop_type']) : 'general';

    if (!user_can_manage_shop($shop_name, $shop_type)) {
        wp_send_json_error(['message' => 'You do not have permission to record transactions for this shop.'], 403);
        return;
    }

    global $wpdb;

    $result = $wpdb->insert(
        'jotun_transactions',
        [
            'shop_name' => $shop_name,
            'item_name' => sanitize_text_field($data['item_name']),
            'quantity' => absint($data['quantity']),
            'total_amount' => floatval($data['total_amount']),
            'customer_name' => sanitize_text_field($data['customer_name']),
            'teller' => sanitize_text_field($data['teller']),
            'transaction_date' => current_time('mysql')
        ],
        ['%s', '%s', '%d', '%f', '%s', '%s', '%s']
    );

    if ($result) {
        wp_send_json_success(['message' => 'Transaction recorded successfully.'], 201);
    } else {
        wp_send_json_error(['message' => 'Failed to record transaction.'], 500);
    }
}

add_action('rest_api_init', function () {
    register_rest_route('trade/v1', '/transactions', [
        'methods' => 'POST',
        'callback' => 'handle_trade_transactions_post',
        'permission_callback' => 'validate_trade_api_key',
    ]);
});
