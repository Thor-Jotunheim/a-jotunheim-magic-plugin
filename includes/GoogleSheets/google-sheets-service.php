<?php
// File: includes/GoogleSheets/google-sheets-service.php

if (!defined('ABSPATH')) exit; // Prevent direct access

/**
 * Google Sheets Service for fetching item data
 */
class JotunheimGoogleSheetsService {
    
    private $spreadsheet_url = 'https://docs.google.com/spreadsheets/d/1WzT8ivJZkdeSzwInT4cLl7Stw2p1K7vSmw9P4tjeciI/export?format=csv&range=AdminManager!A:R';
    
    /**
     * Fetch items from Google Sheets
     * 
     * @return array|WP_Error Array of items or WP_Error on failure
     */
    public function fetch_items_from_sheets() {
        // Use WordPress HTTP API to fetch data
        $response = wp_remote_get($this->spreadsheet_url, array(
            'timeout' => 30,
            'headers' => array(
                'User-Agent' => 'Jotunheim Magic Plugin/1.0'
            )
        ));
        
        if (is_wp_error($response)) {
            error_log('Google Sheets fetch error: ' . $response->get_error_message());
            return $response;
        }
        
        $response_code = wp_remote_retrieve_response_code($response);
        if ($response_code !== 200) {
            error_log('Google Sheets fetch failed with response code: ' . $response_code);
            return new WP_Error('sheets_fetch_failed', 'Failed to fetch data from Google Sheets', array('status' => $response_code));
        }
        
        $csv_data = wp_remote_retrieve_body($response);
        
        if (empty($csv_data)) {
            error_log('Google Sheets returned empty data');
            return new WP_Error('sheets_empty_data', 'Google Sheets returned empty data', array('status' => 500));
        }
        
        return $this->parse_csv_data($csv_data);
    }
    
    /**
     * Parse CSV data into items array
     * 
     * @param string $csv_data Raw CSV data
     * @return array Array of items
     */
    protected function parse_csv_data($csv_data) {
        $lines = explode("\n", $csv_data);
        $items = array();
        
        // Skip if no data
        if (empty($lines)) {
            return $items;
        }
        
        // Get headers from first row
        $headers = str_getcsv(array_shift($lines));
        
        // Map expected column names (adjust based on actual spreadsheet structure)
        $column_map = array(
            'item_name' => $this->find_column_index($headers, ['item_name', 'name', 'item']),
            'item_type' => $this->find_column_index($headers, ['item_type', 'type', 'category']),
            'unit_price' => $this->find_column_index($headers, ['unit_price', 'price', 'cost']),
            'lv2_price' => $this->find_column_index($headers, ['lv2_price', 'level_2_price', 'tier_2_price']),
            'lv3_price' => $this->find_column_index($headers, ['lv3_price', 'level_3_price', 'tier_3_price']),
            'lv4_price' => $this->find_column_index($headers, ['lv4_price', 'level_4_price', 'tier_4_price']),
            'lv5_price' => $this->find_column_index($headers, ['lv5_price', 'level_5_price', 'tier_5_price']),
            'tech_tier' => $this->find_column_index($headers, ['tech_tier', 'tier', 'level']),
            'undercut' => $this->find_column_index($headers, ['undercut', 'discount', 'reduced_price'])
        );
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }
            
            $row = str_getcsv($line);
            
            // Skip if row doesn't have enough columns or item name is empty
            if (count($row) < 2 || empty($row[$column_map['item_name']])) {
                continue;
            }
            
            $item = array();
            
            // Map columns to item properties
            foreach ($column_map as $property => $column_index) {
                if ($column_index !== false && isset($row[$column_index])) {
                    $value = trim($row[$column_index]);
                    
                    // Convert numeric fields
                    if (in_array($property, ['unit_price', 'lv2_price', 'lv3_price', 'lv4_price', 'lv5_price', 'tech_tier', 'undercut'])) {
                        $item[$property] = is_numeric($value) ? floatval($value) : 0;
                    } else {
                        $item[$property] = sanitize_text_field($value);
                    }
                } else {
                    // Set default values for missing columns
                    if (in_array($property, ['unit_price', 'lv2_price', 'lv3_price', 'lv4_price', 'lv5_price', 'tech_tier', 'undercut'])) {
                        $item[$property] = 0;
                    } else {
                        $item[$property] = '';
                    }
                }
            }
            
            // Only add items with valid names
            if (!empty($item['item_name'])) {
                $items[] = $item;
            }
        }
        
        return $items;
    }
    
    /**
     * Find column index by searching for possible column names
     * 
     * @param array $headers Array of header names
     * @param array $possible_names Array of possible column names to search for
     * @return int|false Column index or false if not found
     */
    protected function find_column_index($headers, $possible_names) {
        foreach ($possible_names as $name) {
            $index = array_search(strtolower($name), array_map('strtolower', $headers));
            if ($index !== false) {
                return $index;
            }
        }
        return false;
    }
    
    /**
     * Get cached items with fallback to Google Sheets
     * 
     * @return array Array of items
     */
    public function get_items_with_cache() {
        error_log('JotunheimGoogleSheetsService: get_items_with_cache called');
        
        // Try to get cached data first
        $cached_items = get_transient('jotunheim_sheets_items');
        
        if ($cached_items !== false && !empty($cached_items)) {
            error_log('JotunheimGoogleSheetsService: Using cached items (' . count($cached_items) . ' items)');
            return $cached_items;
        }
        
        // Fetch fresh data from Google Sheets
        error_log('JotunheimGoogleSheetsService: Fetching fresh data from Google Sheets');
        $items = $this->fetch_items_from_sheets();
        
        if (is_wp_error($items)) {
            // If Google Sheets fails, try to get from local database as fallback
            error_log('Google Sheets failed, falling back to local database: ' . $items->get_error_message());
            return $this->get_items_from_database();
        }
        
        // Cache the results for 5 minutes
        set_transient('jotunheim_sheets_items', $items, 5 * MINUTE_IN_SECONDS);
        error_log('JotunheimGoogleSheetsService: Cached ' . count($items) . ' items from Google Sheets');
        
        return $items;
    }
    
    /**
     * Fallback: Get items from local database
     * 
     * @return array Array of items from database
     */
    protected function get_items_from_database() {
        global $wpdb;
        $table_name = 'jotun_itemlist';
        
        $query = "SELECT * FROM $table_name";
        $items = $wpdb->get_results($query, ARRAY_A);
        
        if ($items === false) {
            error_log("Database query error: " . $wpdb->last_error);
            return array();
        }
        
        return $items ?: array();
    }
}