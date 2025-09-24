<?php
// File: itemlist-rest-api.php

// Prevent direct access
if (!defined('ABSPATH')) exit;

// Register REST API route for fetching items
add_action('rest_api_init', function () {
    register_rest_route('jotunheim-magic/v1', '/items', array(
        'methods' => 'GET',
        'callback' => 'fetch_all_itemlist_items_rest',
        'permission_callback' => '__return_true', // No authentication required
    ));
});

// Function to fetch all items from jotun_itemlist database table
function fetch_all_itemlist_items_rest() {
    error_log('fetch_all_itemlist_items_rest called - ITEMLIST VERSION 2024 - Database integration active');
    
    global $wpdb;
    $table_name = 'jotun_itemlist';
    
    try {
        // Try to query the table directly
        $items = $wpdb->get_results("SELECT * FROM `$table_name` ORDER BY item_name ASC LIMIT 10", ARRAY_A);
        
        if ($wpdb->last_error) {
            error_log('fetch_all_itemlist_items_rest: Database error - ' . $wpdb->last_error);
            return new WP_Error('db_error', 'Database error: ' . $wpdb->last_error, array('status' => 500));
        }
        
        if (empty($items)) {
            error_log('fetch_all_itemlist_items_rest: No items found in table');
            return new WP_Error('no_items', 'No items found in table', array('status' => 404));
        }
        
        error_log('fetch_all_itemlist_items_rest: Successfully retrieved ' . count($items) . ' items');
        return rest_ensure_response($items);
        
    } catch (Exception $e) {
        error_log('fetch_all_itemlist_items_rest: Exception - ' . $e->getMessage());
        return new WP_Error('exception', 'Exception: ' . $e->getMessage(), array('status' => 500));
    }
}
?>