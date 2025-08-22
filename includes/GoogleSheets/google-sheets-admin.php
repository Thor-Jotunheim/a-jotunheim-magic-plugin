<?php
// File: includes/GoogleSheets/google-sheets-admin.php

if (!defined('ABSPATH')) exit; // Prevent direct access

/**
 * Admin interface for Google Sheets integration
 */

// Add admin page for Google Sheets testing
add_action('admin_menu', 'add_google_sheets_admin_page');

function add_google_sheets_admin_page() {
    add_submenu_page(
        'tools.php',
        'Google Sheets Test',
        'Google Sheets Test',
        'manage_options',
        'google-sheets-test',
        'google_sheets_test_page'
    );
}

function google_sheets_test_page() {
    if (isset($_POST['test_fetch'])) {
        $sheets_service = new JotunheimGoogleSheetsService();
        $items = $sheets_service->fetch_items_from_sheets();
        
        echo '<div class="notice notice-info"><p>Test fetch completed. Check error logs for details.</p></div>';
        
        if (is_wp_error($items)) {
            echo '<div class="notice notice-error"><p>Error: ' . esc_html($items->get_error_message()) . '</p></div>';
        } else {
            echo '<div class="notice notice-success"><p>Successfully fetched ' . count($items) . ' items from Google Sheets.</p></div>';
            if (!empty($items)) {
                echo '<h3>Sample Items:</h3><ul>';
                foreach (array_slice($items, 0, 5) as $item) {
                    echo '<li>' . esc_html($item['item_name']) . ' (' . esc_html($item['item_type']) . ') - ' . esc_html($item['unit_price']) . 'g</li>';
                }
                echo '</ul>';
            }
        }
    }
    
    if (isset($_POST['clear_cache'])) {
        delete_transient('jotunheim_sheets_items');
        echo '<div class="notice notice-success"><p>Cache cleared successfully.</p></div>';
    }
    
    ?>
    <div class="wrap">
        <h1>Google Sheets Integration Test</h1>
        
        <h2>Current Status</h2>
        <p>This page allows you to test the Google Sheets integration and manage the cache.</p>
        
        <div class="card">
            <h3>Cache Status</h3>
            <?php
            $cached_items = get_transient('jotunheim_sheets_items');
            if ($cached_items !== false) {
                echo '<p><strong>Cache:</strong> Active (' . count($cached_items) . ' items cached)</p>';
                echo '<p><strong>Cache expires:</strong> ' . date('Y-m-d H:i:s', time() + get_option('_transient_timeout_jotunheim_sheets_items', 0) - time()) . '</p>';
            } else {
                echo '<p><strong>Cache:</strong> Empty</p>';
            }
            ?>
        </div>
        
        <div class="card">
            <h3>Actions</h3>
            <form method="post" style="display: inline-block; margin-right: 10px;">
                <input type="submit" name="test_fetch" value="Test Fetch from Google Sheets" class="button button-primary" />
            </form>
            
            <form method="post" style="display: inline-block;">
                <input type="submit" name="clear_cache" value="Clear Cache" class="button" />
            </form>
        </div>
        
        <div class="card">
            <h3>Integration Details</h3>
            <p><strong>Spreadsheet URL:</strong> https://docs.google.com/spreadsheets/d/1WzT8ivJZkdeSzwInT4cLl7Stw2p1K7vSmw9P4tjeciI</p>
            <p><strong>Range:</strong> AdminManager!A:R</p>
            <p><strong>API Endpoint:</strong> /wp-json/jotunheim-magic/v1/items</p>
            <p><strong>Cache Duration:</strong> 5 minutes</p>
        </div>
    </div>
    <?php
}
?>