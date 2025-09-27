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
        
        // Get count of items needing import
        $table_name = 'jotun_prefablist';
        
        // Debug: Check total items in table
        $total_items = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
        error_log("Enhanced Icon Import: Total items in table: $total_items");
        
        // Debug: Check items with image_url
        $items_with_image_url = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE image_url IS NOT NULL AND image_url != ''");
        error_log("Enhanced Icon Import: Items with image_url: $items_with_image_url");
        
        // Debug: Check items without icon_image
        $items_without_icon = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE (icon_image IS NULL OR icon_image = '')");
        error_log("Enhanced Icon Import: Items without icon_image: $items_without_icon");
        
        // Debug: Show some sample data
        $sample_data = $wpdb->get_results("SELECT icon_prefab, image_url, icon_image FROM $table_name WHERE icon_prefab LIKE '%Bear%' OR icon_prefab LIKE '%bear%' LIMIT 5");
        error_log("Enhanced Icon Import: Sample Bear items: " . print_r($sample_data, true));
        
        $count = $wpdb->get_var("
            SELECT COUNT(*) FROM $table_name 
            WHERE image_url IS NOT NULL 
            AND image_url != '' 
            AND (icon_image IS NULL OR icon_image = '')
        ");
        
        error_log("Enhanced Icon Import: Items needing import: $count");
        
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
        
        // Get next batch
        $table_name = 'jotun_prefablist';
        $offset = $status['processed'];
        
        $prefabs = $wpdb->get_results($wpdb->prepare(
            "SELECT id, icon_prefab, image_url FROM $table_name 
             WHERE image_url IS NOT NULL 
             AND image_url != '' 
             AND (icon_image IS NULL OR icon_image = '') 
             LIMIT %d OFFSET %d",
            $batch_size, $offset
        ));
        
        if (empty($prefabs)) {
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
        
        foreach ($prefabs as $prefab) {
            $result = $this->process_single_icon($prefab, $icons_dir, $upload_dir['baseurl']);
            $results[] = $result;
            
            if ($result['success']) {
                $processed++;
            } else {
                $errors++;
            }
        }
        
        // Update status
        $status['processed'] += $processed;
        $status['errors'] += $errors;
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
     * Process a single icon
     */
    private function process_single_icon($prefab, $icons_dir, $base_url) {
        global $wpdb;
        
        $image_url = $prefab->image_url;
        $prefab_id = $prefab->id;
        $prefab_name = $prefab->icon_prefab;
        
        // Validate URL
        if (!filter_var($image_url, FILTER_VALIDATE_URL)) {
            return [
                'success' => false,
                'id' => $prefab_id,
                'name' => $prefab_name,
                'error' => 'Invalid URL'
            ];
        }
        
        // Fetch image
        $response = wp_remote_get($image_url, [
            'timeout' => 15,
            'redirection' => 5,
            'sslverify' => false,
        ]);
        
        if (is_wp_error($response)) {
            return [
                'success' => false,
                'id' => $prefab_id,
                'name' => $prefab_name,
                'error' => $response->get_error_message()
            ];
        }
        
        $image_data = wp_remote_retrieve_body($response);
        if (empty($image_data)) {
            return [
                'success' => false,
                'id' => $prefab_id,
                'name' => $prefab_name,
                'error' => 'No image data retrieved'
            ];
        }
        
        // Generate filename
        $sanitized_name = preg_replace('/[^a-zA-Z0-9_-]/', '', $prefab_name);
        if (empty($sanitized_name)) {
            $sanitized_name = 'prefab';
        }
        
        $file_extension = pathinfo(parse_url($image_url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
        $file_name = $sanitized_name . '-' . $prefab_id . '-' . md5($image_url) . '.' . $file_extension;
        $file_path = $icons_dir . '/' . $file_name;
        
        // Save file
        if (!file_put_contents($file_path, $image_data)) {
            return [
                'success' => false,
                'id' => $prefab_id,
                'name' => $prefab_name,
                'error' => 'Failed to save file'
            ];
        }
        
        // Update database
        $relative_file_path = $base_url . '/Jotunheim-magic/icons/' . $file_name;
        $result = $wpdb->update(
            'jotun_prefablist',
            ['icon_image' => $relative_file_path],
            ['id' => $prefab_id],
            ['%s'],
            ['%d']
        );
        
        if ($result === false) {
            return [
                'success' => false,
                'id' => $prefab_id,
                'name' => $prefab_name,
                'error' => 'Database update failed: ' . $wpdb->last_error
            ];
        }
        
        return [
            'success' => true,
            'id' => $prefab_id,
            'name' => $prefab_name,
            'file' => $file_name
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