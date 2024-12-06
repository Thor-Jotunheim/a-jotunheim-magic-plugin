<?php

if (!defined('ABSPATH')) exit; // Prevent direct access

function handle_trade_shops_get($request) {
    global $wpdb;

    $shop_id = $request->get_param('id');
    if ($shop_id) {
        $shop = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM jotun_shops WHERE shop_id = %d", absint($shop_id)),
            ARRAY_A
        );

        if ($shop) {
            return $shop;
        } else {
            return new WP_Error('not_found', 'Shop not found.', ['status' => 404]);
        }
    }

    $shops = $wpdb->get_results("SELECT * FROM jotun_shops", ARRAY_A);
    return $shops;
}

add_action('rest_api_init', function () {
    register_rest_route('trade/v1', '/shops', [
        'methods' => 'GET',
        'callback' => 'handle_trade_shops_get',
        'permission_callback' => 'validate_trade_api_key',
    ]);
});
