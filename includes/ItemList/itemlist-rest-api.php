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

// Function to fetch all items from jotun_itemlist database table
function fetch_all_items_rest() {
    error_log('fetch_all_items_rest called - Database integration active');
    
    // Clear any previously sent output
    ob_clean();

    global $wpdb;
    $table_name = 'jotun_itemlist'; // Custom table without wp_ prefix
    
    error_log('fetch_all_items_rest: Querying table: ' . $table_name);

    // Fetch all items from database - try directly without table check
    $items = $wpdb->get_results("SELECT * FROM `$table_name` ORDER BY item_name ASC", ARRAY_A);

    if ($wpdb->last_error) {
        error_log('fetch_all_items_rest: Database error - ' . $wpdb->last_error);
        return new WP_Error('db_error', $wpdb->last_error, array('status' => 500));
    }

    if (empty($items)) {
        error_log('fetch_all_items_rest: No items found in database');
        return new WP_Error('no_items', 'No items found', array('status' => 404));
    }

    error_log('fetch_all_items_rest: Returning ' . count($items) . ' items from database');
    return rest_ensure_response($items);
}
?>