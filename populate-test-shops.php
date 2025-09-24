<?php
/**
 * Test script to populate jotun_shops table with sample data
 * Run this once to ensure the unified teller has shops to display
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    // If not in WordPress context, include the WordPress bootstrap
    require_once(dirname(__FILE__) . '/../../../wp-load.php');
}

global $wpdb;

// First ensure the table exists
$shops_table = 'jotun_shops';
if ($wpdb->get_var("SHOW TABLES LIKE '$shops_table'") !== $shops_table) {
    echo "ERROR: Table $shops_table does not exist. Run the plugin activation first.\n";
    exit;
}

// Check if shops already exist
$existing_count = $wpdb->get_var("SELECT COUNT(*) FROM $shops_table");
if ($existing_count > 0) {
    echo "INFO: Found $existing_count existing shops in table.\n";
    
    // Show existing shops
    $existing_shops = $wpdb->get_results("SELECT shop_id, shop_name, shop_type, is_active FROM $shops_table ORDER BY shop_id");
    echo "Existing shops:\n";
    foreach ($existing_shops as $shop) {
        $status = $shop->is_active ? 'ACTIVE' : 'INACTIVE';
        echo "  - ID: {$shop->shop_id}, Name: {$shop->shop_name}, Type: {$shop->shop_type}, Status: $status\n";
    }
    echo "\n";
}

// Sample shops data
$sample_shops = [
    [
        'shop_name' => 'The Haldore Trading Post',
        'description' => 'General trading post for adventurers',
        'shop_type' => 'player',
        'staff_only' => 0,
        'auto_archive' => 0,
        'ledger_name' => 'Haldore Ledger',
        'owner_name' => 'Haldore',
        'is_active' => 1
    ],
    [
        'shop_name' => 'Beehive Marketplace',
        'description' => 'Community marketplace for rare items',
        'shop_type' => 'player',
        'staff_only' => 0,
        'auto_archive' => 0,
        'ledger_name' => 'Beehive Ledger',
        'owner_name' => 'Community',
        'is_active' => 1
    ],
    [
        'shop_name' => 'Staff Administrative Shop',
        'description' => 'Staff-only administrative transactions',
        'shop_type' => 'staff',
        'staff_only' => 1,
        'auto_archive' => 0,
        'ledger_name' => 'Admin Ledger',
        'owner_name' => 'Admin',
        'is_active' => 1
    ],
    [
        'shop_name' => 'Pop-up Event Shop',
        'description' => 'Temporary event-based shop',
        'shop_type' => 'event',
        'staff_only' => 0,
        'auto_archive' => 1,
        'ledger_name' => 'Event Ledger',
        'owner_name' => 'Event Manager',
        'is_active' => 1
    ],
    [
        'shop_name' => 'Inactive Test Shop',
        'description' => 'Test shop that is inactive',
        'shop_type' => 'player',
        'staff_only' => 0,
        'auto_archive' => 0,
        'ledger_name' => 'Test Ledger',
        'owner_name' => 'Tester',
        'is_active' => 0
    ]
];

echo "Populating sample shops...\n";

foreach ($sample_shops as $shop_data) {
    // Check if shop already exists
    $existing = $wpdb->get_var($wpdb->prepare(
        "SELECT shop_id FROM $shops_table WHERE shop_name = %s",
        $shop_data['shop_name']
    ));
    
    if ($existing) {
        echo "  - SKIP: '{$shop_data['shop_name']}' already exists (ID: $existing)\n";
        continue;
    }
    
    // Insert new shop
    $result = $wpdb->insert($shops_table, $shop_data);
    
    if ($result === false) {
        echo "  - ERROR: Failed to insert '{$shop_data['shop_name']}': " . $wpdb->last_error . "\n";
    } else {
        $new_id = $wpdb->insert_id;
        echo "  - SUCCESS: Created '{$shop_data['shop_name']}' (ID: $new_id)\n";
    }
}

// Final count
$final_count = $wpdb->get_var("SELECT COUNT(*) FROM $shops_table");
$active_count = $wpdb->get_var("SELECT COUNT(*) FROM $shops_table WHERE is_active = 1");

echo "\n";
echo "SUMMARY:\n";
echo "  Total shops: $final_count\n";
echo "  Active shops: $active_count\n";
echo "  Inactive shops: " . ($final_count - $active_count) . "\n";

// Test the API endpoint
echo "\n";
echo "Testing API endpoint...\n";

// Simulate the API call
$_SERVER['REQUEST_METHOD'] = 'GET';
$_GET = [];

// Include the API file to test
include_once(dirname(__FILE__) . '/includes/POS/pos-comprehensive-api.php');

// Create a mock request object
$mock_request = new stdClass();
$mock_request->get_param = function($param) { return null; };

try {
    $api_response = jotun_api_get_shops($mock_request);
    
    if ($api_response instanceof WP_REST_Response) {
        $response_data = $api_response->get_data();
        $status_code = $api_response->get_status();
        
        echo "  API Status: $status_code\n";
        
        if (isset($response_data['data']) && is_array($response_data['data'])) {
            $api_shop_count = count($response_data['data']);
            echo "  API returned $api_shop_count shops\n";
            
            foreach ($response_data['data'] as $shop) {
                $status = $shop->is_active ? 'ACTIVE' : 'INACTIVE';
                echo "    - {$shop->shop_name} ({$shop->shop_type}) - $status\n";
            }
        } else {
            echo "  ERROR: API response format unexpected\n";
            echo "  Response: " . json_encode($response_data) . "\n";
        }
    } else {
        echo "  ERROR: API did not return WP_REST_Response\n";
        echo "  Response: " . var_export($api_response, true) . "\n";
    }
} catch (Exception $e) {
    echo "  ERROR: Exception during API test: " . $e->getMessage() . "\n";
}

echo "\nDone!\n";
?>