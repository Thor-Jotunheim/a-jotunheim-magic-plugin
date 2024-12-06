<?php

if (!defined('ABSPATH')) exit; // Prevent direct access

function handle_trade_shop_items_get($request) {
    global $wpdb;

    $item_id = $request->get_param('id');

    if ($item_id) {
        $item = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM jotun_shop_items WHERE item_id = %d", absint($item_id)),
            ARRAY_A
        );

        if ($item) {
            return $item;
        } else {
            return new WP_Error('not_found', 'Shop item not found.', ['status' => 404]);
        }
    }

    $items = $wpdb->get_results("SELECT * FROM jotun_shop_items", ARRAY_A);
    return $items;
}

add_action('rest_api_init', function () {
    register_rest_route('trade/v1', '/shop-items', [
        'methods' => 'GET',
        'callback' => 'handle_trade_shop_items_get',
        'permission_callback' => 'validate_api_key',
    ]);
});
