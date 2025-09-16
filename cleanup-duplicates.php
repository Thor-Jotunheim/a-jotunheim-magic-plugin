<?php
/**
 * Cleanup Script for Duplicate Dashboard Entries
 * 
 * This script removes duplicate "test_dashboard" entries from the jotunheim_dashboard_config 
 * option that were causing the dashboard to malfunction.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    // If this is being run directly (not from WordPress), we'll assume it's for cleanup
    define('CLEANUP_MODE', true);
}

function cleanup_dashboard_duplicates() {
    global $wpdb;
    
    echo "=== Jotunheim Dashboard Cleanup Script ===\n";
    echo "Cleaning up duplicate test_dashboard entries...\n\n";
    
    // Get the current config
    $config = get_option('jotunheim_dashboard_config', []);
    
    if (empty($config)) {
        echo "No dashboard config found.\n";
        return;
    }
    
    echo "Original config structure:\n";
    if (isset($config['items'])) {
        echo "Total items: " . count($config['items']) . "\n";
        
        // Count test_dashboard entries
        $test_dashboard_count = 0;
        foreach ($config['items'] as $item) {
            if (isset($item['id']) && $item['id'] === 'test_dashboard') {
                $test_dashboard_count++;
            }
        }
        echo "test_dashboard duplicates found: " . $test_dashboard_count . "\n\n";
        
        if ($test_dashboard_count > 1) {
            echo "Removing duplicate test_dashboard entries...\n";
            
            // Keep track of items we've seen
            $seen_items = [];
            $cleaned_items = [];
            
            foreach ($config['items'] as $item) {
                $item_id = $item['id'] ?? 'unknown';
                
                // Skip test_dashboard entries entirely - they're bogus
                if ($item_id === 'test_dashboard') {
                    continue;
                }
                
                // For other items, only keep the first occurrence
                if (!isset($seen_items[$item_id])) {
                    $seen_items[$item_id] = true;
                    $cleaned_items[] = $item;
                } else {
                    echo "Removed duplicate: " . $item_id . "\n";
                }
            }
            
            // Update the config
            $config['items'] = $cleaned_items;
            
            echo "\nAfter cleanup:\n";
            echo "Total items: " . count($cleaned_items) . "\n";
            
            // Save the cleaned config
            $result = update_option('jotunheim_dashboard_config', $config);
            
            if ($result) {
                echo "✅ Successfully cleaned up dashboard config!\n";
            } else {
                echo "❌ Failed to save cleaned config.\n";
            }
        } else {
            echo "No duplicates found to clean up.\n";
        }
    } else {
        echo "Config doesn't have items array.\n";
    }
    
    echo "\n=== Cleanup Complete ===\n";
}

// If this is being run from WordPress admin or via WP-CLI
if (defined('ABSPATH') || defined('WP_CLI')) {
    cleanup_dashboard_duplicates();
}
// If being run directly for testing
elseif (defined('CLEANUP_MODE')) {
    echo "This script should be run from WordPress admin or WP-CLI.\n";
    echo "You can also delete the jotunheim_dashboard_config option directly from the database.\n";
}
?>