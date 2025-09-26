<?php
/**
 * Emergency script to clear the dangerous daily cleanup that was deleting shops
 * Run this once to remove the scheduled event
 */

// Clear the scheduled event if it exists
if (wp_next_scheduled('jotun_daily_cleanup')) {
    wp_clear_scheduled_hook('jotun_daily_cleanup');
    echo "Cleared dangerous jotun_daily_cleanup scheduled event\n";
} else {
    echo "No jotun_daily_cleanup event found\n";
}

// Add this to your main plugin file temporarily and run it once
add_action('init', function() {
    if (wp_next_scheduled('jotun_daily_cleanup')) {
        wp_clear_scheduled_hook('jotun_daily_cleanup');
        error_log('EMERGENCY: Cleared dangerous jotun_daily_cleanup scheduled event that was deleting shops');
    }
});