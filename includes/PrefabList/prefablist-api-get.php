<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register the REST API endpoint
add_action('rest_api_init', function () {
    // Public endpoint to fetch all prefabs
    register_rest_route('jotunheim-magic/v1', '/prefabs', array(
        'methods' => 'GET',
        'callback' => 'fetch_all_prefabs_rest',
        'permission_callback' => '__return_true', // Should allow public access
    ));
});

function verify_prefab_api_key($request) {
    $api_key = $request->get_param('api_key');

    if ($api_key && $api_key === PREFAB_API_KEY) {
        return true;
    }

    return new WP_Error('invalid_api_key', 'Invalid API Key', array('status' => 401));
}

function get_jotun_prefabs() {
    global $wpdb;
    $prefab_table = 'jotun_prefablist'; // Hardcoded table name

    // Check if the table exists
    if($wpdb->get_var("SHOW TABLES LIKE '$prefab_table'") != $prefab_table) {
        return new WP_Error('no_table', 'The jotun_prefablist table does not exist.', array('status' => 500));
    }

    // Fetch data from the jotun_prefablist table
    $results = $wpdb->get_results("SELECT * FROM $prefab_table");

    if (empty($results)) {
        return new WP_Error('no_data', 'No data found in the jotun_prefablist table.', array('status' => 404));
    }

    // Process results to include the full icon URL
    $items = array_map(function($item) {
        $item->icon_url = 'https://jotun.games/wp-content/uploads/Jotunheim-magic/icons/' . $item->icon_image;
        return $item;
    }, $results);

    return $items;
}