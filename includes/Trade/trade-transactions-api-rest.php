<?php

if (!defined('ABSPATH')) exit; // Prevent direct access

function handle_trade_transactions_get($request) {
    global $wpdb;

    $transaction_id = $request->get_param('id');

    if ($transaction_id) {
        $transaction = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM jotun_transactions WHERE id = %d", absint($transaction_id)),
            ARRAY_A
        );

        if ($transaction) {
            return $transaction;
        } else {
            return new WP_Error('not_found', 'Transaction not found.', ['status' => 404]);
        }
    }

    $transactions = $wpdb->get_results("SELECT * FROM jotun_transactions", ARRAY_A);
    return $transactions;
}

add_action('rest_api_init', function () {
    register_rest_route('trade/v1', '/transactions', [
        'methods' => 'GET',
        'callback' => 'handle_trade_transactions_get',
        'permission_callback' => 'validate_trade_api_key',
    ]);
});
