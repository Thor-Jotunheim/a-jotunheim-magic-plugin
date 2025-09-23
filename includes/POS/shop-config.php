<?php
/**
 * Jotunheim Shop Configuration System
 * Sets up the predefined shops based on Google Sheets workflow: Admin, Popup, Haldore, Beehive
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class JotunShopConfig {
    
    const SHOP_TYPES = [
        'admin' => [
            'name' => 'Admin Shop',
            'description' => 'Administrative shop for staff transactions and special items',
            'shop_type' => 'admin',
            'staff_only' => true,
            'auto_archive' => true,
            'ledger_name' => 'Admin Ledger'
        ],
        'popup' => [
            'name' => 'Popup Shop',
            'description' => 'Mobile popup shop for events and temporary sales',
            'shop_type' => 'popup',
            'staff_only' => false,
            'auto_archive' => true,
            'ledger_name' => 'Popup Ledger'
        ],
        'haldore' => [
            'name' => 'Haldore Shop',
            'description' => 'Haldore trading post for rare and valuable items',
            'shop_type' => 'haldore',
            'staff_only' => false,
            'auto_archive' => true,
            'ledger_name' => 'HaldORE Ledger'
        ],
        'beehive' => [
            'name' => 'Beehive Shop',
            'description' => 'Beehive outpost for food, consumables, and basic supplies',
            'shop_type' => 'beehive',
            'staff_only' => false,
            'auto_archive' => true,
            'ledger_name' => 'Beehive Ledger'
        ]
    ];
    
    public static function initialize_shops() {
        global $wpdb;
        
        $shops_table = 'jotun_shops';
        $created_shops = [];
        
        foreach (self::SHOP_TYPES as $shop_key => $shop_config) {
            // Check if shop already exists
            $existing_shop = $wpdb->get_row($wpdb->prepare(
                "SELECT * FROM $shops_table WHERE shop_type = %s",
                $shop_config['shop_type']
            ));
            
            if (!$existing_shop) {
                // Create the shop
                $result = $wpdb->insert($shops_table, [
                    'shop_name' => $shop_config['name'],
                    'description' => $shop_config['description'],
                    'shop_type' => $shop_config['shop_type'],
                    'staff_only' => $shop_config['staff_only'] ? 1 : 0,
                    'auto_archive' => $shop_config['auto_archive'] ? 1 : 0,
                    'ledger_name' => $shop_config['ledger_name'],
                    'is_active' => 1,
                    'created_date' => current_time('mysql'),
                    'created_by' => get_current_user_id()
                ]);
                
                if ($result !== false) {
                    $shop_id = $wpdb->insert_id;
                    $created_shops[] = [
                        'id' => $shop_id,
                        'name' => $shop_config['name'],
                        'type' => $shop_config['shop_type']
                    ];
                    error_log("Created shop: " . $shop_config['name'] . " (ID: $shop_id)");
                }
            } else {
                error_log("Shop already exists: " . $shop_config['name'] . " (ID: " . $existing_shop->id . ")");
            }
        }
        
        return $created_shops;
    }
    
    public static function get_shop_by_type($shop_type) {
        global $wpdb;
        
        $shops_table = 'jotun_shops';
        
        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $shops_table WHERE shop_type = %s AND is_active = 1",
            $shop_type
        ));
    }
    
    public static function get_all_configured_shops() {
        global $wpdb;
        
        $shops_table = 'jotun_shops';
        
        return $wpdb->get_results(
            "SELECT * FROM $shops_table WHERE shop_type IN ('admin', 'popup', 'haldore', 'beehive') AND is_active = 1 ORDER BY shop_type"
        );
    }
    
    public static function assign_default_items_to_shops() {
        global $wpdb;
        
        $shops = self::get_all_configured_shops();
        $items_table = 'jotun_itemlist';
        $shop_items_table = 'jotun_shop_items';
        
        // Get some default items to assign
        $default_items = $wpdb->get_results(
            "SELECT * FROM $items_table WHERE item_type IN ('tool', 'weapon', 'armor', 'material') LIMIT 20"
        );
        
        if (empty($default_items)) {
            error_log("No items found to assign to shops");
            return [];
        }
        
        $assignments = [];
        
        foreach ($shops as $shop) {
            // Assign different item sets based on shop type
            $items_to_assign = [];
            
            switch ($shop->shop_type) {
                case 'admin':
                    // Admin gets all items
                    $items_to_assign = $default_items;
                    break;
                case 'popup':
                    // Popup gets tools and weapons
                    $items_to_assign = array_filter($default_items, function($item) {
                        return in_array($item->item_type, ['tool', 'weapon']);
                    });
                    break;
                case 'haldore':
                    // Haldore gets weapons and armor
                    $items_to_assign = array_filter($default_items, function($item) {
                        return in_array($item->item_type, ['weapon', 'armor']);
                    });
                    break;
                case 'beehive':
                    // Beehive gets materials and consumables
                    $items_to_assign = array_filter($default_items, function($item) {
                        return in_array($item->item_type, ['material', 'consumable']);
                    });
                    break;
            }
            
            foreach ($items_to_assign as $item) {
                // Check if assignment already exists
                $existing = $wpdb->get_row($wpdb->prepare(
                    "SELECT * FROM $shop_items_table WHERE shop_id = %d AND item_id = %d",
                    $shop->id, $item->id
                ));
                
                if (!$existing) {
                    $result = $wpdb->insert($shop_items_table, [
                        'shop_id' => $shop->id,
                        'item_id' => $item->id,
                        'custom_price' => null, // Use default item price
                        'stock_quantity' => -1, // Unlimited stock
                        'is_available' => 1,
                        'added_date' => current_time('mysql')
                    ]);
                    
                    if ($result !== false) {
                        $assignments[] = [
                            'shop' => $shop->shop_name,
                            'item' => $item->item_name
                        ];
                    }
                }
            }
        }
        
        return $assignments;
    }
    
    public static function setup_complete_system() {
        $results = [
            'shops_created' => self::initialize_shops(),
            'items_assigned' => self::assign_default_items_to_shops()
        ];
        
        error_log("Jotunheim shop configuration complete: " . json_encode($results));
        
        return $results;
    }
}

// Auto-initialize shops when this file is loaded
add_action('init', function() {
    // Only run once per day to avoid repeated setup
    $last_setup = get_option('jotun_shop_config_last_setup', 0);
    $today = date('Y-m-d');
    
    if ($last_setup !== $today) {
        JotunShopConfig::initialize_shops();
        update_option('jotun_shop_config_last_setup', $today);
    }
});