<?php
// Fetch available items via API
function jotun_fetch_items() {
    check_ajax_referer('jotun_api_nonce', 'nonce');

    // Make API call to fetch items
    $response = wp_remote_get(rest_url('jotunheim-magic/v1/items'));

    if (is_wp_error($response)) {
        wp_send_json_error(['message' => 'Failed to fetch items.'], 500);
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if ($data && $data['success']) {
        wp_send_json_success(['items' => $data['data']]);
    } else {
        wp_send_json_error(['message' => $data['message'] ?? 'Unknown error'], 500);
    }
}
add_action('wp_ajax_jotun_fetch_items', 'jotun_fetch_items');


// Handle shop creation with items
function jotun_create_shop_with_items() {
    check_ajax_referer('jotun_api_nonce', 'nonce');

    parse_str($_POST['form_data'], $form_data);

    // Create shop
    $shop_response = wp_remote_post(rest_url('trade/v1/shops'), [
        'body' => json_encode([
            'shop_name' => sanitize_text_field($form_data['shop_name']),
            'shop_type' => 'general' // Set a default or use user input if provided
        ]),
        'headers' => ['Content-Type' => 'application/json']
    ]);

    if (is_wp_error($shop_response)) {
        wp_send_json_error(['message' => 'Failed to create shop.'], 500);
    }

    $shop_body = json_decode(wp_remote_retrieve_body($shop_response), true);
    if (!isset($shop_body['success']) || !$shop_body['success']) {
        wp_send_json_error(['message' => $shop_body['message'] ?? 'Unknown error'], 500);
    }

    // Add items to the shop
    if (!empty($form_data['items'])) {
        foreach ($form_data['items'] as $item_id) {
            $item_response = wp_remote_post(rest_url('trade/v1/shop-items'), [
                'body' => json_encode([
                    'shop_name' => $form_data['shop_name'],
                    'item_name' => $item_id, // Replace with the correct item data
                    'quantity' => 1, // Default or user input
                    'price' => 10.0 // Default or user input
                ]),
                'headers' => ['Content-Type' => 'application/json']
            ]);

            if (is_wp_error($item_response)) {
                wp_send_json_error(['message' => "Failed to add item $item_id."], 500);
            }

            $item_body = json_decode(wp_remote_retrieve_body($item_response), true);
            if (!isset($item_body['success']) || !$item_body['success']) {
                wp_send_json_error(['message' => $item_body['message'] ?? "Unknown error for item $item_id"], 500);
            }
        }
    }

    wp_send_json_success(['message' => 'Shop and items created successfully.']);
}
add_action('wp_ajax_jotun_create_shop_with_items', 'jotun_create_shop_with_items');

