<?php

if (!defined('ABSPATH')) exit; // Prevent direct access

function handle_trade_shop_items_put() {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['item_id'])) {
        wp_send_json_error(['message' => 'Invalid request data.'], 400);
        return;
    }

    $item_id = absint($data['item_id']);

    global $wpdb;

    $update_data = [];
    $update_format = [];

    if (isset($data['quantity'])) {
        $update_data['quantity'] = absint($data['quantity']);
        $update_format[] = '%d';
    }

    if (isset($data['price'])) {
        $update_data['price'] = floatval($data['price']);
        $update_format[] = '%f';
    }

    $result = $wpdb->update(
        'jotun_shop_items',
        $update_data,
        ['item_id' => $item_id],
        $update_format,
        ['%d']
    );

    if ($result !== false) {
        wp_send_json_success(['message' => 'Shop item updated successfully.'], 200);
    } else {
        wp_send_json_error(['message' => 'Failed to update shop item.'], 500);
    }
}

add_action('rest_api_init', function () {
    register_rest_route('trade/v1', '/shop-items', [
        'methods' => 'PUT',
        'callback' => 'handle_trade_shop_items_put',
        'permission_callback' => 'validate_api_key',
    ]);
});
