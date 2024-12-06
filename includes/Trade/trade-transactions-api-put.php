<?php

if (!defined('ABSPATH')) exit; // Prevent direct access

function handle_trade_transactions_put() {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['transaction_id'])) {
        wp_send_json_error(['message' => 'Invalid request data.'], 400);
        return;
    }

    $transaction_id = absint($data['transaction_id']);

    global $wpdb;

    $update_data = [];
    $update_format = [];

    if (isset($data['quantity'])) {
        $update_data['quantity'] = absint($data['quantity']);
        $update_format[] = '%d';
    }

    if (isset($data['total_amount'])) {
        $update_data['total_amount'] = floatval($data['total_amount']);
        $update_format[] = '%f';
    }

    if (isset($data['customer_name'])) {
        $update_data['customer_name'] = sanitize_text_field($data['customer_name']);
        $update_format[] = '%s';
    }

    if (isset($data['teller'])) {
        $update_data['teller'] = sanitize_text_field($data['teller']);
        $update_format[] = '%s';
    }

    if (empty($update_data)) {
        wp_send_json_error(['message' => 'No valid fields to update.'], 400);
        return;
    }

    $result = $wpdb->update(
        'jotun_transactions',
        $update_data,
        ['id' => $transaction_id],
        $update_format,
        ['%d']
    );

    if ($result !== false) {
        wp_send_json_success(['message' => 'Transaction updated successfully.'], 200);
    } else {
        wp_send_json_error(['message' => 'Failed to update transaction.'], 500);
    }
}

add_action('rest_api_init', function () {
    register_rest_route('trade/v1', '/transactions', [
        'methods' => 'PUT',
        'callback' => 'handle_trade_transactions_put',
        'permission_callback' => 'validate_api_key',
    ]);
});
