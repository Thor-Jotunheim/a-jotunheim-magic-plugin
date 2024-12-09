<?php
// Fetch items
function jotun_fetch_items() {
    check_ajax_referer('jotun_api_nonce', 'nonce');

    // Fetch items via REST API or mock data
    $items = array(
        array('id' => 1, 'name' => 'Sword', 'price' => 100),
        array('id' => 2, 'name' => 'Shield', 'price' => 150),
    );

    wp_send_json_success(array('items' => $items));
}
add_action('wp_ajax_jotun_fetch_items', 'jotun_fetch_items');

// Create shop
function jotun_create_shop() {
    check_ajax_referer('jotun_api_nonce', 'nonce');

    parse_str($_POST['form_data'], $form_data);

    // Use API for shop creation
    $response = jotun_shop_api_post($form_data);

    if ($response['success']) {
        wp_send_json_success();
    } else {
        wp_send_json_error(array('message' => $response['message']));
    }
}
add_action('wp_ajax_jotun_create_shop', 'jotun_create_shop');
