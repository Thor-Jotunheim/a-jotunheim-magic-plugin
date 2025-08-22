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

// Function to fetch all items from Google Sheets with database fallback
function fetch_all_items_rest() {
    error_log('fetch_all_items_rest called - Google Sheets integration active');
    
    // Clear any previously sent output
    ob_clean();

    // Initialize Google Sheets service
    $sheets_service = new JotunheimGoogleSheetsService();
    
    // Get items from Google Sheets with caching and fallback
    $items = $sheets_service->get_items_with_cache();
    
    if (empty($items)) {
        error_log('fetch_all_items_rest: No items found');
        return new WP_Error('no_items', 'No items found', array('status' => 404));
    }

    error_log('fetch_all_items_rest: Returning ' . count($items) . ' items');
    return rest_ensure_response($items);
}
?>