<?php
/*
Plugin Name: Jotunheim Trade API
Description: Provides a REST API for accessing trade items in jotun_itemlist.
Version: 1.0
Author: Your Name
*/

// Prevent direct access
if (!defined('ABSPATH')) exit;

// Function to validate API key (API key should be set in wp-config.php)
if (!function_exists('validate_trade_api_key')) {
    function validate_trade_api_key($request) {
        $api_key = $request->get_header('x-api-key');
        if (!defined('TRADE_API_KEY') || $api_key !== TRADE_API_KEY) {
            return new WP_Error('rest_forbidden', __('Invalid API key.'), array('status' => 403));
        }
        return true;
    }
}

// Fetch all items for trade
if (!function_exists('fetch_all_trade_items_rest')) {
    function fetch_all_trade_items_rest($request) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'jotun_itemlist';

        $search = $request->get_param('search');
        $query = "SELECT * FROM $table_name";

        // Add search filtering if provided
        if (!empty($search)) {
            $query .= $wpdb->prepare(" WHERE item_name LIKE %s", '%' . $wpdb->esc_like($search) . '%');
        }

        $items = $wpdb->get_results($query, ARRAY_A);

        if ($wpdb->last_error) {
            return new WP_Error('db_error', $wpdb->last_error, array('status' => 500));
        }

        if (empty($items)) {
            return new WP_Error('no_items', 'No items found', array('status' => 404));
        }

        ob_clean(); // Clear any previous output
        wp_send_json_success($items); // Send clean JSON response
    }
}

// Fetch single item by ID
if (!function_exists('fetch_single_item_rest')) {
    function fetch_single_item_rest($request) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'jotun_itemlist';
        $item_id = intval($request['id']);

        $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $item_id), ARRAY_A);

        if ($wpdb->last_error) {
            return new WP_Error('db_error', $wpdb->last_error, array('status' => 500));
        }

        if (!$item) {
            return new WP_Error('item_not_found', 'Item not found', array('status' => 404));
        }

        ob_clean(); // Clear any previous output
        wp_send_json_success($item); // Send clean JSON response
    }
}

// Fetch single item by name
if (!function_exists('fetch_item_by_name_rest')) {
    function fetch_item_by_name_rest($request) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'jotun_itemlist';
        $item_name = sanitize_text_field($request['name']);

        $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE item_name = %s", $item_name), ARRAY_A);

        if ($wpdb->last_error) {
            return new WP_Error('db_error', $wpdb->last_error, array('status' => 500));
        }

        if (!$item) {
            return new WP_Error('item_not_found', 'Item not found', array('status' => 404));
        }

        ob_clean(); // Clear any previous output
        wp_send_json_success($item); // Send clean JSON response
    }
}

// Register REST API routes
add_action('rest_api_init', function () {
    // Public endpoint to fetch all items from database (renamed to avoid conflict)
    register_rest_route('jotunheim-magic/v1', '/trade-items', array(
        'methods' => 'GET',
        'callback' => 'fetch_all_trade_items_rest',
        'permission_callback' => '__return_true', // No authentication required
    ));

    // Public endpoint to fetch a specific item by ID
    register_rest_route('jotunheim-magic/v1', '/items/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'fetch_single_item_rest',
        'permission_callback' => '__return_true', // No authentication required
        'args' => array(
            'id' => array(
                'required' => true,
                'validate_callback' => function($param) {
                    return is_numeric($param);
                }
            ),
        ),
    ));

    // Private endpoint to fetch a specific item by name, requires API key validation
    register_rest_route('jotunheim-magic/v1', '/items/name/(?P<name>[a-zA-Z0-9_-]+)', array(
        'methods' => 'GET',
        'callback' => 'fetch_item_by_name_rest',
        'permission_callback' => 'validate_api_key', // Requires API key
        'args' => array(
            'name' => array(
                'required' => true,
                'validate_callback' => function($param) {
                    return is_string($param);
                }
            ),
        ),
    ));
});
?>