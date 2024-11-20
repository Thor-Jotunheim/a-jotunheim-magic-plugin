<?php
// File: itemlist-rest-api.php

// Prevent direct access
if (!defined('ABSPATH')) exit;

// Register REST API route for fetching items
add_action('rest_api_init', function () {
    register_rest_route('jotunheim-magic/v1', '/items', array(
        'methods' => 'GET',
        'callback' => 'fetch_all_items_rest',
        'permission_callback' => '__return_true', // No authentication required
    ));
});

// Function to fetch all items from the database
function fetch_all_items_rest() {
    global $wpdb;

    // Clear any previously sent output
    ob_clean();

    $table_name = 'jotun_itemlist'; // Ensure table name matches your setup

    // Run a basic SELECT query
    $query = "SELECT * FROM $table_name";
    $items = $wpdb->get_results($query, ARRAY_A);

    if ($items === false) {
        error_log("Database query error: " . $wpdb->last_error);
        return new WP_Error('db_error', 'Database query error', array('status' => 500));
    }

    if (empty($items)) {
        return new WP_Error('no_items', 'No items found', array('status' => 404));
    }

    return rest_ensure_response($items);
}
?>