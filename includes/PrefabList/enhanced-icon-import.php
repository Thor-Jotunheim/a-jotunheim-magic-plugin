<?php
/**
 * Enhanced Icon Import
 * Advanced icon import system with AJAX interface and progress tracking
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enhanced Icon Import AJAX Handler
 */
class EnhancedIconImport {
    
    public function __construct() {
        add_action('wp_ajax_enhanced_icon_import_start', [$this, 'ajax_start_import']);
        add_action('wp_ajax_enhanced_icon_import_batch', [$this, 'ajax_process_batch']);
        add_action('wp_ajax_enhanced_icon_import_status', [$this, 'ajax_get_status']);
        add_action('wp_ajax_enhanced_icon_import_reset_failed', [$this, 'ajax_reset_failed_items']);
    }
    
    /**
     * Start the import process
     */
    public function ajax_start_import() {
        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized access');
            return;
        }
        
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'enhanced_icon_import_nonce')) {
            wp_send_json_error('Invalid security token');
            return;
        }
        
        global $wpdb;
        
        // Get count from both tables that need icons
        // Count items that need icons (NULL/empty OR file doesn't exist)
        $itemlist_items = $wpdb->get_results("
            SELECT id, icon_image FROM jotun_itemlist 
            WHERE item_name IS NOT NULL AND item_name != ''
        ");
        
        $prefablist_items = $wpdb->get_results("
            SELECT id, icon_image FROM jotun_prefablist 
            WHERE prefab_name IS NOT NULL AND prefab_name != ''
        ");
        
        // Check which items actually need processing
        $itemlist_count = 0;
        $prefablist_count = 0;
        
        foreach ($itemlist_items as $item) {
            if ($this->needs_icon_processing($item->icon_image)) {
                $itemlist_count++;
            }
        }
        
        foreach ($prefablist_items as $item) {
            if ($this->needs_icon_processing($item->icon_image)) {
                $prefablist_count++;
            }
        }
        
        $count = $itemlist_count + $prefablist_count;
        
        error_log("Enhanced Icon Import: Found $itemlist_count items + $prefablist_count prefabs = $count total that need icons");
        
        if (!$count) {
            wp_send_json_success([
                'message' => 'No items found that need icon import.',
                'total' => 0,
                'started' => false
            ]);
            return;
        }
        
        // Initialize import session
        $import_id = 'enhanced_import_' . time();
        set_transient($import_id . '_status', [
            'total' => intval($count),
            'processed' => 0,
            'errors' => 0,
            'started' => time(),
            'status' => 'running'
        ], HOUR_IN_SECONDS);
        
        wp_send_json_success([
            'message' => "Starting import of $count items...",
            'total' => intval($count),
            'import_id' => $import_id,
            'started' => true
        ]);
    }
    
    /**
     * Process a batch of imports
     */
    public function ajax_process_batch() {
        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized access');
            return;
        }
        
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'enhanced_icon_import_nonce')) {
            wp_send_json_error('Invalid security token');
            return;
        }
        
        $import_id = sanitize_text_field($_POST['import_id'] ?? '');
        $batch_size = intval($_POST['batch_size'] ?? 5);
        
        if (!$import_id) {
            wp_send_json_error('Missing import ID');
            return;
        }
        
        // Get current status
        $status = get_transient($import_id . '_status');
        if (!$status) {
            wp_send_json_error('Import session not found');
            return;
        }
        
        global $wpdb;
        
        // Get next batch using a simpler approach - union both tables and use single offset
        $offset = $status['processed'];
        error_log("Enhanced Icon Import: Batch processing - offset: $offset, batch_size: $batch_size");
        
        // Get all items and filter them properly
        $all_items = $wpdb->get_results("
            (SELECT id, item_name as search_name, item_name as file_name, icon_image, 'itemlist' as table_type 
             FROM jotun_itemlist 
             WHERE item_name IS NOT NULL AND item_name != '')
            UNION ALL
            (SELECT id, prefab_name as search_name, prefab_name as file_name, icon_image, 'prefablist' as table_type 
             FROM jotun_prefablist 
             WHERE prefab_name IS NOT NULL AND prefab_name != '')
            ORDER BY table_type, id
        ");
        
        // Filter items that need processing and apply offset/limit
        $items_needing_processing = [];
        foreach ($all_items as $item) {
            if ($this->needs_icon_processing($item->icon_image)) {
                $items_needing_processing[] = $item;
            }
        }
        
        // Apply offset and limit to filtered results
        $items = array_slice($items_needing_processing, $offset, $batch_size);
        
        error_log("Enhanced Icon Import: Found " . count($items) . " total items from union query");
        
        if (empty($items)) {
            // Import complete
            $status['status'] = 'completed';
            set_transient($import_id . '_status', $status, HOUR_IN_SECONDS);
            
            wp_send_json_success([
                'completed' => true,
                'message' => "Import completed! Processed {$status['processed']} items with {$status['errors']} errors.",
                'status' => $status
            ]);
            return;
        }
        
        // Process batch
        $processed = 0;
        $errors = 0;
        $results = [];
        
        // Create upload directory
        $upload_dir = wp_upload_dir();
        $icons_dir = $upload_dir['basedir'] . '/Jotunheim-magic/icons';
        if (!file_exists($icons_dir)) {
            mkdir($icons_dir, 0755, true);
        }
        
        foreach ($items as $item) {
            $result = $this->process_single_icon($item, $icons_dir, $upload_dir['baseurl']);
            $results[] = $result;
            
            if ($result['success']) {
                $processed++;
            } else {
                $errors++;
            }
        }
        
        // Update status - add TOTAL items processed (successful + failed) to advance offset
        $total_processed_this_batch = count($items);
        $status['processed'] += $total_processed_this_batch;
        $status['errors'] += $errors;
        
        error_log("Enhanced Icon Import: Processed $total_processed_this_batch items this batch. Total processed now: " . $status['processed']);
        set_transient($import_id . '_status', $status, HOUR_IN_SECONDS);
        
        wp_send_json_success([
            'completed' => false,
            'batch_processed' => $processed,
            'batch_errors' => $errors,
            'results' => $results,
            'status' => $status
        ]);
    }
    
    /**
     * Check if an item needs icon processing
     */
    private function needs_icon_processing($icon_image) {
        // If null, empty, or 'null' - definitely needs processing
        if (empty($icon_image) || $icon_image === 'null') {
            return true;
        }
        
        // If marked as 'not_found' with timestamp - check if it's time to retry (30 days)
        if (strpos($icon_image, 'not_found_') === 0) {
            $date_part = substr($icon_image, 10); // Remove 'not_found_' prefix
            $failed_date = DateTime::createFromFormat('Y-m-d', $date_part);
            if ($failed_date) {
                $now = new DateTime();
                $days_since_failed = $now->diff($failed_date)->days;
                return $days_since_failed >= 30; // Retry after 30 days
            }
            return false; // Invalid date format, skip
        }
        
        // Legacy 'not_found' without timestamp - convert to timestamped version
        if ($icon_image === 'not_found') {
            return false; // Skip for now, but should be converted
        }
        
        // If has a URL, check if the file actually exists
        if (filter_var($icon_image, FILTER_VALIDATE_URL)) {
            // Convert URL to local file path
            $upload_dir = wp_upload_dir();
            $base_url = $upload_dir['baseurl'];
            
            // Check if URL starts with our upload URL
            if (strpos($icon_image, $base_url) === 0) {
                // Convert URL to local file path
                $relative_path = str_replace($base_url, '', $icon_image);
                $file_path = $upload_dir['basedir'] . $relative_path;
                
                // Return true if file doesn't exist (needs reprocessing)
                return !file_exists($file_path);
            }
        }
        
        // If we have some other non-URL value, assume it needs processing
        return true;
    }
    
    /**
     * Process a single icon by searching external sources
     */
    private function process_single_icon($item, $icons_dir, $base_url) {
        global $wpdb;
        
        $item_id = $item->id;
        $search_name = $item->search_name;  // Name to search for on external sites
        $file_name = $item->file_name;      // Name to use for the file (as-is from database)
        $table_type = $item->table_type;    // 'itemlist' or 'prefablist'
        
        // Search sources in order of preference
        $sources = [
            'jotunn_items' => 'https://valheim-modding.github.io/Jotunn/data/objects/item-list.html',
            'jotunn_pieces' => 'https://valheim-modding.github.io/Jotunn/data/pieces/piece-list.html',
            'commands_gg' => 'https://commands.gg/valheim/characters'
        ];
        
        $found_url = null;
        $source_used = '';
        
        // Try Jotunn sources first
        foreach (['jotunn_items', 'jotunn_pieces'] as $source_key) {
            $found_url = $this->search_jotunn_source($search_name, $sources[$source_key]);
            if ($found_url) {
                $source_used = $source_key;
                break;
            }
        }
        
        // If not found in Jotunn, try commands.gg
        if (!$found_url) {
            $found_url = $this->search_commands_gg($search_name);
            if ($found_url) {
                $source_used = 'commands_gg';
            }
        }
        
        // If no URL found, return failure
        if (!$found_url) {
            return [
                'success' => false,
                'id' => $item_id,
                'name' => $search_name,
                'table' => $table_type,
                'error' => 'No icon found in any source (Jotunn items, Jotunn pieces, commands.gg)'
            ];
        }
        
        // Download and save the icon (use file_name for the actual filename)
        $download_result = $this->download_and_save_icon($found_url, $file_name, $item_id, $icons_dir, $base_url);
        
        if ($download_result['success']) {
            // Update the correct database table
            $table_name = ($table_type === 'itemlist') ? 'jotun_itemlist' : 'jotun_prefablist';
            
            $result = $wpdb->update(
                $table_name,
                ['icon_image' => $download_result['saved_url']],
                ['id' => $item_id],
                ['%s'],
                ['%d']
            );
            
            if ($result === false) {
                return [
                    'success' => false,
                    'id' => $item_id,
                    'name' => $search_name,
                    'table' => $table_type,
                    'error' => 'Database update failed: ' . $wpdb->last_error
                ];
            }
            
            return [
                'success' => true,
                'id' => $item_id,
                'name' => $search_name,
                'table' => $table_type,
                'file' => $download_result['filename'],
                'source' => $source_used
            ];
        } else {
            // Mark as processed (failed) with timestamp so it can be retried later
            $table_name = ($table_type === 'itemlist') ? 'jotun_itemlist' : 'jotun_prefablist';
            $timestamp = date('Y-m-d');
            $wpdb->update(
                $table_name,
                ['icon_image' => 'not_found_' . $timestamp],  // Mark with date for future retry
                ['id' => $item_id],
                ['%s'],
                ['%d']
            );
            
            return [
                'success' => false,
                'id' => $item_id,
                'name' => $search_name,
                'table' => $table_type,
                'error' => $download_result['error']
            ];
        }
    }
    
    /**
     * Search Jotunn source for prefab icon
     */
    private function search_jotunn_source($prefab_name, $source_url) {
        $response = wp_remote_get($source_url, [
            'timeout' => 10,
            'sslverify' => false
        ]);
        
        if (is_wp_error($response)) {
            return false;
        }
        
        $html = wp_remote_retrieve_body($response);
        if (empty($html)) {
            return false;
        }
        
        // Parse HTML to find the prefab
        // Look for table rows containing the prefab name
        preg_match_all('/<tr[^>]*>.*?<\/tr>/is', $html, $rows);
        
        foreach ($rows[0] as $row) {
            // Check if this row contains our prefab name
            if (stripos($row, $prefab_name) !== false) {
                // Extract image URL from this row
                preg_match('/<img[^>]*src=["\']([^"\']+)["\'][^>]*>/i', $row, $img_matches);
                if (!empty($img_matches[1])) {
                    $img_url = $img_matches[1];
                    // Make sure it's a full URL
                    if (strpos($img_url, 'http') !== 0) {
                        $base_jotunn = 'https://valheim-modding.github.io/Jotunn/';
                        $img_url = $base_jotunn . ltrim($img_url, './');
                    }
                    return $img_url;
                }
            }
        }
        
        return false;
    }
    
    /**
     * Search commands.gg for prefab icon  
     */
    private function search_commands_gg($prefab_name) {
        // Commands.gg has a different structure - would need to be implemented based on their actual HTML
        // For now, return false as we'd need to analyze their page structure
        return false;
    }
    
    /**
     * Download and save icon from URL
     */
    private function download_and_save_icon($image_url, $file_name, $item_id, $icons_dir, $base_url) {
        // Fetch image
        $response = wp_remote_get($image_url, [
            'timeout' => 15,
            'redirection' => 5,
            'sslverify' => false,
        ]);
        
        if (is_wp_error($response)) {
            return [
                'success' => false,
                'error' => 'Failed to download: ' . $response->get_error_message()
            ];
        }
        
        $image_data = wp_remote_retrieve_body($response);
        if (empty($image_data)) {
            return [
                'success' => false,
                'error' => 'No image data retrieved'
            ];
        }
        
        // Use the database filename as-is (should be clean already like "MashedMeat")
        error_log("Enhanced Icon Import: Using filename from database: '$file_name'");
        $sanitized_name = $file_name; // Use database value directly
        
        // Only fallback if truly empty
        if (empty($sanitized_name)) {
            $sanitized_name = 'item_' . $item_id;
            error_log("Enhanced Icon Import: Used fallback: '$sanitized_name'");
        }
        
        $file_extension = pathinfo(parse_url($image_url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'png';
        $final_filename = $sanitized_name . '.' . $file_extension;
        $file_path = $icons_dir . '/' . $final_filename;
        
        // Save file
        if (!file_put_contents($file_path, $image_data)) {
            return [
                'success' => false,
                'error' => 'Failed to save file to: ' . $file_path
            ];
        }
        
        // Return success with file info
        $relative_file_path = $base_url . '/Jotunheim-magic/icons/' . $final_filename;
        
        return [
            'success' => true,
            'filename' => $final_filename,
            'saved_url' => $relative_file_path
        ];
    }
    
    /**
     * Get import status
     */
    public function ajax_get_status() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized access');
            return;
        }
        
        $import_id = sanitize_text_field($_GET['import_id'] ?? '');
        if (!$import_id) {
            wp_send_json_error('Missing import ID');
            return;
        }
        
        $status = get_transient($import_id . '_status');
        if (!$status) {
            wp_send_json_error('Import session not found');
            return;
        }
        
        wp_send_json_success($status);
    }
    
    /**
     * Reset failed items to allow retry
     */
    public function ajax_reset_failed_items() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized access');
            return;
        }
        
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'enhanced_icon_import_nonce')) {
            wp_send_json_error('Invalid security token');
            return;
        }
        
        global $wpdb;
        
        // Reset failed items in both tables
        $itemlist_reset = $wpdb->query("
            UPDATE jotun_itemlist 
            SET icon_image = NULL 
            WHERE icon_image LIKE 'not_found%'
        ");
        
        $prefablist_reset = $wpdb->query("
            UPDATE jotun_prefablist 
            SET icon_image = NULL 
            WHERE icon_image LIKE 'not_found%'
        ");
        
        $total_reset = ($itemlist_reset !== false ? $itemlist_reset : 0) + 
                       ($prefablist_reset !== false ? $prefablist_reset : 0);
        
        wp_send_json_success([
            'message' => "Reset $total_reset failed items for retry",
            'itemlist_reset' => $itemlist_reset !== false ? $itemlist_reset : 0,
            'prefablist_reset' => $prefablist_reset !== false ? $prefablist_reset : 0,
            'total_reset' => $total_reset
        ]);
    }
}

/**
 * Enhanced Icon Import Interface
 */
function enhanced_icon_import_interface() {
    // Check permissions using Discord system
    $permission_check = jotunheim_check_shortcode_permission('enhanced_icon_import');
    if ($permission_check !== null) {
        return $permission_check;
    }
    
    // Enqueue scripts and styles
    wp_enqueue_script(
        'enhanced-icon-import-js',
        plugin_dir_url(__FILE__) . '../../assets/js/enhanced-icon-import.js',
        ['jquery'],
        '1.0.0',
        true
    );
    
    // Localize script
    wp_localize_script('enhanced-icon-import-js', 'enhanced_icon_import_config', [
        'nonce' => wp_create_nonce('enhanced_icon_import_nonce'),
        'ajax_url' => admin_url('admin-ajax.php')
    ]);
    
    ob_start();
    ?>
    <div class="wrap enhanced-icon-import">
        <h2>Enhanced Icon Import</h2>
        <p>Advanced icon import system with progress tracking and error handling.</p>
        
        <div class="import-controls" style="margin: 20px 0; padding: 20px; background: #f9f9f9; border: 1px solid #ddd;">
            <button type="button" id="start-import-btn" class="button button-primary">
                🚀 Start Enhanced Import
            </button>
            <button type="button" id="stop-import-btn" class="button" style="display: none;">
                ⏹️ Stop Import
            </button>
            <button type="button" id="reset-failed-btn" class="button" style="margin-left: 10px;">
                🔄 Reset Failed Items
            </button>
        </div>
        
        <div class="reset-info" style="margin: 10px 0; padding: 10px; background: #e7f3ff; border: 1px solid #b3d9ff; border-radius: 4px;">
            <p><strong>Smart Retry Logic:</strong></p>
            <ul style="margin: 5px 0 0 20px;">
                <li>Failed items are automatically retried after 30 days</li>
                <li>Use "Reset Failed Items" to immediately retry all failed items</li>
                <li>Deleted image files are automatically detected and reprocessed</li>
            </ul>
        </div>
        
        <div id="import-status" class="import-status" style="display: none;">
            <h3>Import Progress</h3>
            <div class="progress-bar" style="width: 100%; height: 20px; background: #f0f0f0; border: 1px solid #ccc; margin: 10px 0;">
                <div class="progress-fill" style="height: 100%; background: #0073aa; width: 0%; transition: width 0.3s;"></div>
            </div>
            <div class="progress-text">
                <span id="progress-processed">0</span> / <span id="progress-total">0</span> processed
                (<span id="progress-percent">0%</span>)
            </div>
            <div class="progress-errors" style="margin-top: 10px;">
                <strong>Errors:</strong> <span id="progress-errors-count">0</span>
            </div>
        </div>
        
        <div id="import-results" class="import-results" style="margin-top: 20px;">
            <h3>Import Results</h3>
            <div id="results-container"></div>
        </div>
    </div>
    
    <style>
    .enhanced-icon-import .import-status {
        background: #fff;
        border: 1px solid #ccc;
        padding: 20px;
        margin: 20px 0;
    }
    
    .enhanced-icon-import .result-item {
        padding: 5px 10px;
        margin: 2px 0;
        border-left: 3px solid #0073aa;
        background: #f9f9f9;
    }
    
    .enhanced-icon-import .result-item.error {
        border-left-color: #dc3232;
        background: #fef7f7;
    }
    
    .enhanced-icon-import .result-item.success {
        border-left-color: #46b450;
        background: #f7fff7;
    }
    </style>
    <?php
    
    return ob_get_clean();
}

/**
 * Register shortcode
 */
function enhanced_icon_import_shortcode() {
    return enhanced_icon_import_interface();
}
add_shortcode('enhanced_icon_import', 'enhanced_icon_import_shortcode');

// Initialize the AJAX handler
global $enhanced_icon_import;
$enhanced_icon_import = new EnhancedIconImport();
?>