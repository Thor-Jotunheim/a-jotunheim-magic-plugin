<?php
/**
 * Temporary script to fix missing Player List menu item
 * Run this once to add the Player List back to the dashboard menu
 */

// Include WordPress
require_once(dirname(__FILE__) . '/../../../wp-config.php');
require_once(dirname(__FILE__) . '/includes/Dashboard/dashboard-config.php');
require_once(dirname(__FILE__) . '/includes/Dashboard/dashboard-db-normalized.php');

echo "=== Fixing Player List Menu Item ===\n";

global $jotunheim_dashboard_config;

if (!$jotunheim_dashboard_config) {
    $jotunheim_dashboard_config = new JotunheimDashboardConfig();
}

$normalized_db = $jotunheim_dashboard_config->normalized_db;

// Check if Player List exists
echo "Checking if Player List menu item exists...\n";

global $wpdb;

// Check if the item exists in dashboard items
$existing_item = $wpdb->get_row(
    "SELECT * FROM jotun_dashboard_items WHERE item_key = 'player_list_management' OR item_key = 'jotun-playerlist'"
);

if ($existing_item) {
    echo "Player List item found: " . $existing_item->item_name . " (ID: " . $existing_item->id . ")\n";
    echo "No action needed.\n";
} else {
    echo "Player List item NOT found. Adding it...\n";
    
    // Get the commerce section ID
    $commerce_section = $wpdb->get_row(
        "SELECT * FROM jotun_dashboard_sections WHERE section_key = 'commerce'"
    );
    
    if (!$commerce_section) {
        echo "Commerce section not found! Creating it...\n";
        
        $wpdb->insert('jotun_dashboard_sections', [
            'section_key' => 'commerce',
            'section_name' => 'Commerce & Trading',
            'display_order' => 2,
            'is_active' => 1
        ]);
        
        $commerce_section_id = $wpdb->insert_id;
        echo "Created commerce section with ID: $commerce_section_id\n";
    } else {
        $commerce_section_id = $commerce_section->id;
        echo "Found commerce section with ID: $commerce_section_id\n";
    }
    
    // Add the Player List item
    $result = $wpdb->insert('jotun_dashboard_items', [
        'section_id' => $commerce_section_id,
        'item_key' => 'jotun-playerlist',
        'item_name' => 'Player List',
        'callback_function' => 'jotun_playerlist_interface',
        'display_order' => 10,
        'quick_action' => 0,
        'is_active' => 1
    ]);
    
    if ($result) {
        echo "Successfully added Player List menu item with ID: " . $wpdb->insert_id . "\n";
    } else {
        echo "ERROR: Failed to add Player List menu item: " . $wpdb->last_error . "\n";
    }
}

echo "\n=== Current Dashboard Items ===\n";

// Show all current items
$items = $wpdb->get_results("
    SELECT i.*, s.section_name 
    FROM jotun_dashboard_items i 
    LEFT JOIN jotun_dashboard_sections s ON i.section_id = s.id 
    WHERE i.is_active = 1 
    ORDER BY s.display_order, i.display_order
");

foreach ($items as $item) {
    echo "- {$item->section_name}: {$item->item_name} ({$item->item_key})\n";
}

echo "\nDone! The Player List should now appear in your dashboard.\n";
?>