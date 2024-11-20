<?php
// AJAX handler for fetching all items for the dropdown
function fetch_all_items() {
    global $wpdb;
    $table_name = 'jotun_itemlist';
    $items = $wpdb->get_results("SELECT id, item_name FROM $table_name", ARRAY_A); // Include ID and item_name

    if ($items) {
        wp_send_json_success($items);  // Send back the items
    } else {
        wp_send_json_error('No items found');
    }
}
add_action('wp_ajax_fetch_all_items', 'fetch_all_items');
add_action('wp_ajax_nopriv_fetch_all_items', 'fetch_all_items');

// AJAX handler for fetching item details
function fetch_item_details() {
    global $wpdb;

    // Check if item_id is present
    if (!isset($_POST['item_id'])) {
        wp_send_json_error('item_id not received');
        return;
    }

    $item_id = intval($_POST['item_id']);  // Sanitize and validate the item ID
    error_log('Received item_id: ' . $item_id);  // Log the received item_id for debugging

    if ($item_id <= 0) {
        wp_send_json_error('Invalid item_id');
        return;
    }

    // Fetch the item details from the database
    $table_name = 'jotun_itemlist';
    $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $item_id), ARRAY_A);

    if ($item) {
        wp_send_json_success($item);
    } else {
        wp_send_json_error('Item not found');
    }
}
add_action('wp_ajax_fetch_item_details', 'fetch_item_details');

// AJAX handler for searching items
function search_items() {
    global $wpdb;

    // Sanitize search value
    $search_value = sanitize_text_field($_POST['search_value']);
    
    $table_name = 'jotun_itemlist'; 
    $items = $wpdb->get_results($wpdb->prepare("SELECT id, item_name FROM $table_name WHERE item_name LIKE %s", '%' . $search_value . '%'), ARRAY_A);

    if ($items) {
        wp_send_json_success($items);
    } else {
        wp_send_json_error('No matching items found');
    }
}
add_action('wp_ajax_search_items', 'search_items');
add_action('wp_ajax_nopriv_search_items', 'search_items');

// AJAX handler for saving item details
function save_item_details() {
    global $wpdb;
    $items_data = $_POST['items_data'];

    // Sanitize and prepare data
    foreach ($items_data as $item_data) {
        $item_data = array_map('sanitize_text_field', $item_data);

        $table_name = 'jotun_itemlist';
        $result = $wpdb->update(
            $table_name,
            array(
                'item_name' => $item_data['item_name'],
                'tech_name' => $item_data['tech_name'],
                'item_type' => $item_data['item_type'],
                'stack_size' => intval($item_data['stack_size']),
                'undercut' => intval($item_data['undercut']),
                'unit_price' => floatval($item_data['unit_price']),
                'lv2_price' => floatval($item_data['lv2_price']),
                'lv3_price' => floatval($item_data['lv3_price']),
                'lv4_price' => floatval($item_data['lv4_price']),
                'lv5_price' => floatval($item_data['lv5_price']),
                'prefab_name' => $item_data['prefab_name']
            ),
            array('id' => intval($item_data['id']))  // Use item_id instead of item_name for updating
        );

        if ($result === false) {
            error_log('Failed to update item: ' . $item_data['item_name']); // Log error for debugging
            wp_send_json_error();
        }
    }

    wp_send_json_success();
}
add_action('wp_ajax_save_item_details', 'save_item_details');
add_action('wp_ajax_nopriv_save_item_details', 'save_item_details');

// AJAX handler for deleting item details
function delete_item_details() {
    global $wpdb;
    $item_id = intval($_POST['item_id']);
    
    $table_name = 'jotun_itemlist'; 
    $result = $wpdb->delete($table_name, array('id' => $item_id));

    if ($result !== false) {
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
}
add_action('wp_ajax_delete_item_details', 'delete_item_details');
add_action('wp_ajax_nopriv_delete_item_details', 'delete_item_details');