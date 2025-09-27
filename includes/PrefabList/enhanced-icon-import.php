<?php
// Enhanced icon import system for Jotunheim Magic Plugin
if (!defined('ABSPATH')) exit;

/**
 * Enhanced Icon Import Service
 * Imports icons from multiple sources:
 * 1. Existing Google Drive URLs (existing system)
 * 2. Jotunn prefab database
 * 3. Commands.gg Valheim characters/items
 */
class JotunheimEnhancedIconImporter {
    
    private $icons_dir;
    private $icons_url;
    
    public function __construct() {
        $upload_dir = wp_upload_dir();
        $this->icons_dir = $upload_dir['basedir'] . '/Jotunheim-magic/icons';
        $this->icons_url = $upload_dir['baseurl'] . '/Jotunheim-magic/icons';
        
        // Ensure icons directory exists
        if (!file_exists($this->icons_dir)) {
            mkdir($this->icons_dir, 0755, true);
        }
        
        // Add AJAX handlers
        add_action('wp_ajax_enhanced_icon_import_ajax', [$this, 'handle_ajax_request']);
        add_action('wp_ajax_nopriv_enhanced_icon_import_ajax', [$this, 'handle_ajax_request']);
    }
    
    public function handle_ajax_request() {
        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'enhanced_icon_import')) {
            wp_die('Security check failed');
        }
        
        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_die('Insufficient permissions');
        }
        
        $action = sanitize_text_field($_POST['import_action']);
        $batch_size = intval($_POST['batch_size'] ?? 10);
        $offset = intval($_POST['offset'] ?? 0);
        
        // Start output buffering to capture the output
        ob_start();
        
        // Handle different actions
        if ($action === 'check') {
            $this->update_missing_icons_for_existing_items();
        } elseif ($action === 'stats') {
            $this->show_import_stats();
        } elseif ($action === 'import') {
            $this->run_enhanced_import($batch_size, $offset);
        } else {
            echo '<p style="color: red;">Unknown action: ' . esc_html($action) . '</p>';
        }
        
        // Get the output and send it back
        $output = ob_get_clean();
        echo $output;
        wp_die(); // Important: End the AJAX request
    }
    
    /**
     * Main import function - runs all import sources
     */
    public function run_enhanced_import($batch_size = 50, $offset = 0) {
        global $wpdb;
        
        echo "<h2>Enhanced Icon Import Process</h2>";
        echo "Starting enhanced icon import from multiple sources...<br>";
        echo "Batch size: {$batch_size}, Offset: {$offset}<br><br>";
        
        // Get items that need icons
        $items_needing_icons = $this->get_items_needing_icons();
        $total_items = count($items_needing_icons);
        
        echo "Found {$total_items} total items that need icons.<br>";
        
        if (empty($items_needing_icons)) {
            echo "No items need icon imports at this time.<br>";
            return;
        }
        
        // Apply offset and batch size
        $batch_items = array_slice($items_needing_icons, $offset, $batch_size);
        $items_in_batch = count($batch_items);
        
        echo "Processing items {$offset} to " . ($offset + $items_in_batch - 1) . " of {$total_items} total items.<br><br>";
        
        if (empty($batch_items)) {
            echo "<p style='color: orange;'>No more items to process at offset {$offset}.</p>";
            return;
        }
        
        $success_count = 0;
        $error_count = 0;
        $total_to_process = $items_in_batch;
        $current_count = 0;
        
        foreach ($batch_items as $item) {
            $current_count++;
            echo "<strong>[{$current_count}/{$total_to_process}] Processing: {$item->prefab_name} (ID: {$item->id})</strong><br>";
            
            // Try multiple sources in priority order (existing URLs first!)
            $sources = [
                'existing_url' => [$this, 'import_from_existing_url'],
                'jotunn' => [$this, 'import_from_jotunn'],
                'commands_gg' => [$this, 'import_from_commands_gg']
            ];
            
            $imported = false;
            foreach ($sources as $source_name => $callback) {
                $result = call_user_func($callback, $item);
                if ($result['success']) {
                    echo "<span style='color: green;'>✓ Success from {$source_name}: {$result['message']}</span><br>";
                    $success_count++;
                    $imported = true;
                    break;
                }
            }
            
            if (!$imported) {
                echo "<span style='color: red;'>❌ Failed to import icon from any source</span><br>";
                $error_count++;
            }
            
            echo "<br>";
            ob_flush();
            flush();
        }
        
        echo "<h3>Import Summary</h3>";
        echo "✅ Successfully imported: {$success_count}<br>";
        echo "❌ Failed imports: {$error_count}<br>";
        
        if ($offset + $items_in_batch < $total_items) {
            $remaining = $total_items - ($offset + $items_in_batch);
            echo "<p style='color: blue;'>ℹ️ {$remaining} items remaining. Next offset: " . ($offset + $items_in_batch) . "</p>";
        } else {
            echo "<p style='color: green;'>✅ All items processed!</p>";
        }
        
        echo "Enhanced icon import batch completed.<br>";
    }
    
    /**
     * Get items that need icons (no icon_image or empty)
     * Filters out environmental objects and focuses on actual collectible items
     */
    private function get_items_needing_icons() {
        global $wpdb;
        
        // Patterns to exclude (environmental objects, spawners, etc.)
        $exclude_patterns = [
            'Spawner_%',
            'GraveStone_%', 
            '%_cliff_%',
            '%_ledge%',
            '%_rock%',
            '%Kit_%',
            'piece_%',
            'vfx_%',
            'sfx_%',
            'fx_%',
            'Broken_World%',
            'Location_%',
            '_event%',
            '_Elite%'
        ];
        
        // Build WHERE clause to exclude unwanted patterns
        $exclude_conditions = [];
        foreach ($exclude_patterns as $pattern) {
            $exclude_conditions[] = "prefab_name NOT LIKE '" . esc_sql($pattern) . "'";
        }
        $exclude_where = implode(' AND ', $exclude_conditions);
        
        // Also try to include only items that look like actual game items
        // Look for common item patterns or include items with certain characteristics
        $include_patterns = [
            "prefab_name LIKE '%Armor%'",
            "prefab_name LIKE '%Helmet%'", 
            "prefab_name LIKE '%Sword%'",
            "prefab_name LIKE '%Axe%'",
            "prefab_name LIKE '%Bow%'",
            "prefab_name LIKE '%Shield%'",
            "prefab_name LIKE '%Pickaxe%'",
            "prefab_name LIKE '%Hammer%'",
            "prefab_name LIKE '%Food%'",
            "prefab_name LIKE '%Meat%'",
            "prefab_name LIKE '%Fish%'",
            "prefab_name LIKE '%Berry%'",
            "prefab_name LIKE '%Mushroom%'",
            "prefab_name LIKE '%Wood%'",
            "prefab_name LIKE '%Stone%'",
            "prefab_name LIKE '%Iron%'",
            "prefab_name LIKE '%Silver%'",
            "prefab_name LIKE '%Bronze%'",
            "prefab_name LIKE '%Gold%'",
            "prefab_name LIKE '%Crystal%'",
            "prefab_name LIKE '%Gem%'",
            "prefab_name LIKE '%Trophy%'",
            "prefab_name LIKE '%Potion%'",
            "prefab_name LIKE '%Mead%'",
            "prefab_name LIKE '%Cape%'",
            "prefab_name LIKE '%Ring%'",
            "prefab_name LIKE '%Necklace%'",
            "prefab_name LIKE '%Torch%'",
            "prefab_name LIKE '%Arrow%'",
            "prefab_name LIKE '%Bomb%'",
            // Simple item names (less than 20 chars, no underscores suggesting world objects)
            "(CHAR_LENGTH(prefab_name) < 20 AND prefab_name NOT LIKE '%_%')",
            // Items that start with capital letters (common item naming)
            "(prefab_name REGEXP '^[A-Z][a-z]+$')"
        ];
        
        $include_where = '(' . implode(' OR ', $include_patterns) . ')';
        
        return $wpdb->get_results(
            "SELECT id, prefab_name, icon_prefab, image_url 
             FROM jotun_prefablist 
             WHERE (icon_image IS NULL OR icon_image = '') 
             AND prefab_name IS NOT NULL 
             AND prefab_name != ''
             AND {$exclude_where}
             AND {$include_where}
             ORDER BY prefab_name ASC
             LIMIT 200"
        );
    }
    
    /**
     * Import icon from Jotunn prefab database
     */
    private function import_from_jotunn($item) {
        $prefab_name = $item->prefab_name;
        
        // Try different variations of the prefab name for Jotunn
        $variations = [
            strtolower($prefab_name),
            $prefab_name,
            str_replace('_', '', strtolower($prefab_name)),
            ucfirst(strtolower($prefab_name))
        ];
        
        foreach ($variations as $variation) {
            // Try multiple Jotunn icon locations
            $jotunn_urls = [
                // GitHub raw URLs for different categories
                "https://raw.githubusercontent.com/Valheim-Modding/jotunn-docs/main/data/objects/icons/{$variation}.png",
                "https://raw.githubusercontent.com/Valheim-Modding/jotunn-docs/main/data/pieces/icons/{$variation}.png", 
                "https://raw.githubusercontent.com/Valheim-Modding/jotunn-docs/main/data/prefabs/icons/{$variation}.png",
                "https://raw.githubusercontent.com/Valheim-Modding/jotunn-docs/main/data/characters/icons/{$variation}.png",
                // Alternative paths
                "https://raw.githubusercontent.com/Valheim-Modding/jotunn-docs/main/assets/images/icons/{$variation}.png"
            ];
            
            foreach ($jotunn_urls as $jotunn_url) {
                $result = $this->download_and_save_icon($jotunn_url, $item, 'jotunn');
                if ($result['success']) {
                    return $result;
                }
            }
        }
        
        return ['success' => false, 'message' => 'Not found in Jotunn database'];
    }
    
    /**
     * Import icon from commands.gg
     */
    private function import_from_commands_gg($item) {
        $prefab_name = $item->prefab_name;
        
        // Commands.gg uses different URL patterns, try comprehensive variations
        $variations = [
            strtolower($prefab_name),
            str_replace('_', '-', strtolower($prefab_name)),
            str_replace(['_', ' '], '', strtolower($prefab_name)),
            str_replace('_', '', strtolower($prefab_name)),
            ucfirst(strtolower($prefab_name)),
            $prefab_name, // Keep original case
            // Handle common prefixes
            str_replace(['Spawner_', 'GraveStone_'], '', $prefab_name),
            // Handle underscores differently
            str_replace('_', '.', strtolower($prefab_name))
        ];
        
        foreach ($variations as $variation) {
            if (empty($variation)) continue;
            
            // Try comprehensive Commands.gg URL patterns
            $urls = [
                "https://commands.gg/images/valheim/items/{$variation}.png",
                "https://commands.gg/images/valheim/characters/{$variation}.png", 
                "https://commands.gg/images/valheim/prefabs/{$variation}.png",
                "https://commands.gg/images/valheim/objects/{$variation}.png",
                "https://commands.gg/images/valheim/creatures/{$variation}.png",
                "https://commands.gg/images/valheim/materials/{$variation}.png",
                "https://commands.gg/images/valheim/weapons/{$variation}.png",
                "https://commands.gg/images/valheim/armor/{$variation}.png",
                "https://commands.gg/images/valheim/food/{$variation}.png"
            ];
            
            foreach ($urls as $url) {
                $result = $this->download_and_save_icon($url, $item, 'commands.gg');
                if ($result['success']) {
                    return $result;
                }
            }
        }
        
        return ['success' => false, 'message' => 'Not found on commands.gg'];
    }
    
    /**
     * Import from existing image_url (legacy system)
     */
    private function import_from_existing_url($item) {
        if (empty($item->image_url)) {
            return ['success' => false, 'message' => 'No existing image URL'];
        }
        
        return $this->download_and_save_icon($item->image_url, $item, 'existing');
    }
    
    /**
     * Download and save icon from URL
     */
    private function download_and_save_icon($url, $item, $source) {
        global $wpdb;
        
        // Validate URL
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return ['success' => false, 'message' => 'Invalid URL'];
        }
        
        // Quick check if URL returns valid image (but don't be too verbose about failures)
        $response = wp_remote_head($url, [
            'timeout' => 5,
            'redirection' => 2,
            'sslverify' => false
        ]);
        
        if (is_wp_error($response)) {
            return ['success' => false, 'message' => ''];
        }
        
        $response_code = wp_remote_retrieve_response_code($response);
        if ($response_code !== 200) {
            return ['success' => false, 'message' => ''];
        }
        
        // Check content type
        $content_type = wp_remote_retrieve_header($response, 'content-type');
        if (!str_contains($content_type, 'image/')) {
            return ['success' => false, 'message' => ''];
        }
        
        // Download the image
        $image_response = wp_remote_get($url, [
            'timeout' => 15,
            'redirection' => 5,
            'sslverify' => false
        ]);
        
        if (is_wp_error($image_response)) {
            return ['success' => false, 'message' => 'Download failed'];
        }
        
        $image_data = wp_remote_retrieve_body($image_response);
        if (empty($image_data)) {
            return ['success' => false, 'message' => 'Empty image data'];
        }
        
        // Generate filename
        $sanitized_name = preg_replace('/[^a-zA-Z0-9_-]/', '', $item->prefab_name);
        if (empty($sanitized_name)) {
            $sanitized_name = 'prefab';
        }
        
        $file_extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'png';
        $file_name = $sanitized_name . '-' . $item->id . '-' . $source . '.' . $file_extension;
        $file_path = $this->icons_dir . '/' . $file_name;
        
        // Save image file
        $saved = file_put_contents($file_path, $image_data);
        if ($saved === false) {
            return ['success' => false, 'message' => 'File save failed'];
        }
        
        // Update database with icon path
        $relative_url = $this->icons_url . '/' . $file_name;
        $result = $wpdb->update(
            'jotun_prefablist',
            ['icon_image' => $relative_url],
            ['id' => $item->id],
            ['%s'],
            ['%d']
        );
        
        if ($result === false) {
            // Clean up file if database update failed
            unlink($file_path);
            return ['success' => false, 'message' => 'Database update failed'];
        }
        
        return [
            'success' => true, 
            'message' => "Saved as {$file_name}",
            'url' => $relative_url
        ];
    }
    
    /**
     * Batch process to check and update missing icons for existing items
     */
    public function update_missing_icons_for_existing_items() {
        global $wpdb;
        
        echo "<h3>Checking for items with missing icon files...</h3>";
        
        // Get items that have icon_image set but file doesn't exist
        $items_with_icons = $wpdb->get_results(
            "SELECT id, prefab_name, icon_image 
             FROM jotun_prefablist 
             WHERE icon_image IS NOT NULL 
             AND icon_image != ''"
        );
        
        $missing_count = 0;
        $fixed_count = 0;
        
        foreach ($items_with_icons as $item) {
            // Convert URL to file path
            $file_path = str_replace($this->icons_url, $this->icons_dir, $item->icon_image);
            
            if (!file_exists($file_path)) {
                $missing_count++;
                echo "Missing file for {$item->prefab_name}: {$item->icon_image}<br>";
                
                // Try to re-import
                $temp_item = (object)[
                    'id' => $item->id,
                    'prefab_name' => $item->prefab_name,
                    'icon_prefab' => $item->prefab_name,
                    'image_url' => null
                ];
                
                $sources = [
                    'jotunn' => [$this, 'import_from_jotunn'],
                    'commands_gg' => [$this, 'import_from_commands_gg']
                ];
                
                $imported = false;
                foreach ($sources as $source_name => $callback) {
                    $result = call_user_func($callback, $temp_item);
                    if ($result['success']) {
                        echo "- ✅ Re-imported from {$source_name}<br>";
                        $fixed_count++;
                        $imported = true;
                        break;
                    }
                }
                
                if (!$imported) {
                    echo "- ❌ Could not re-import<br>";
                }
            }
        }
        
        echo "<br><strong>Summary:</strong><br>";
        echo "Missing files found: {$missing_count}<br>";
        echo "Successfully re-imported: {$fixed_count}<br>";
    }
    
    /**
     * Show import statistics without doing any imports
     */
    public function show_import_stats() {
        global $wpdb;
        
        echo "<h3>Enhanced Icon Import Statistics</h3>";
        
        // Total items in prefablist
        $total_prefabs = $wpdb->get_var("SELECT COUNT(*) FROM jotun_prefablist");
        
        // Items with icons
        $with_icons = $wpdb->get_var("SELECT COUNT(*) FROM jotun_prefablist WHERE icon_image IS NOT NULL AND icon_image != ''");
        
        // Items without icons
        $without_icons = $wpdb->get_var("SELECT COUNT(*) FROM jotun_prefablist WHERE icon_image IS NULL OR icon_image = ''");
        
        // Items with existing URLs
        $with_urls = $wpdb->get_var("SELECT COUNT(*) FROM jotun_prefablist WHERE image_url IS NOT NULL AND image_url != '' AND (icon_image IS NULL OR icon_image = '')");
        
        // Items that exist in itemlist (potential icon sources)
        $in_itemlist = $wpdb->get_var(
            "SELECT COUNT(*) FROM jotun_prefablist p 
             LEFT JOIN jotun_itemlist i ON p.prefab_name = i.prefab_name OR p.prefab_name = i.item_name
             WHERE (p.icon_image IS NULL OR p.icon_image = '') 
             AND i.icon_image IS NOT NULL AND i.icon_image != ''"
        );
        
        echo "<table style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='border: 1px solid #ddd;'><td style='padding: 8px; font-weight: bold;'>Total Prefabs:</td><td style='padding: 8px;'>{$total_prefabs}</td></tr>";
        echo "<tr style='border: 1px solid #ddd; background: #f9f9f9;'><td style='padding: 8px;'>✅ With Icons:</td><td style='padding: 8px;'>{$with_icons} (" . round(($with_icons/$total_prefabs)*100, 1) . "%)</td></tr>";
        echo "<tr style='border: 1px solid #ddd;'><td style='padding: 8px;'>❌ Without Icons:</td><td style='padding: 8px;'>{$without_icons} (" . round(($without_icons/$total_prefabs)*100, 1) . "%)</td></tr>";
        echo "<tr style='border: 1px solid #ddd; background: #f0f8ff;'><td style='padding: 8px;'>🔗 With Existing URLs:</td><td style='padding: 8px;'>{$with_urls}</td></tr>";
        echo "<tr style='border: 1px solid #ddd; background: #f0fff0;'><td style='padding: 8px;'>📋 Available in ItemList:</td><td style='padding: 8px;'>{$in_itemlist}</td></tr>";
        echo "</table>";
        
        echo "<br><h4>Recommendations:</h4>";
        echo "<ul>";
        if ($with_urls > 0) {
            echo "<li>🟢 Start with existing URLs: <code>[enhanced_icon_import batch_size=\"10\"]</code></li>";
        }
        if ($in_itemlist > 0) {
            echo "<li>🟡 Copy from ItemList first (these will be processed automatically)</li>";
        }
        echo "<li>🔍 Use small batches (10-20) to avoid timeouts</li>";
        echo "<li>📊 Check progress with: <code>[enhanced_icon_import action=\"stats\"]</code></li>";
        echo "</ul>";
        
        // Add navigation buttons
        echo "<br><div style='background: #f0f8ff; padding: 15px; border: 1px solid #0073aa; margin: 15px 0;'>";
        echo "<strong>Actions:</strong><br>";
        echo "<a href='?icon_action=import&batch_size=10&offset=0' class='button button-primary' style='margin: 5px;'>Start Import (10 items)</a> ";
        echo "<a href='?icon_action=interface' class='button button-secondary' style='margin: 5px;'>Back to Control Panel</a>";
        echo "</div>";
    }
}

/**
 * Shortcode function for enhanced icon import
 */
function enhanced_icon_import_shortcode($atts) {
    // Check permissions
    $permission_check = jotunheim_check_shortcode_permission('enhanced_icon_import');
    if ($permission_check !== null) {
        return $permission_check;
    }
    
    // Always show the interface
    ob_start();
    ?>
    <div style="max-width: 900px; margin: 20px 0;">
        <h2>Enhanced Icon Import Control Panel</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px; margin: 20px 0;">
            <button onclick="runIconAction('stats')" class="button button-secondary" style="padding: 10px;">
                📊 View Statistics
            </button>
            <button onclick="runIconAction('import', 5, 0)" class="button button-primary" style="padding: 10px;">
                🚀 Import 5 items
            </button>
            <button onclick="runIconAction('import', 10, 0)" class="button button-primary" style="padding: 10px;">
                🚀 Import 10 items
            </button>
            <button onclick="runIconAction('check')" class="button button-secondary" style="padding: 10px;">
                🔍 Check Missing Files
            </button>
        </div>
        
        <div style="background: #fff3cd; padding: 15px; border: 1px solid #ffeeba; margin: 20px 0;">
            <strong>Custom Batch:</strong>
            <div style="margin-top: 10px;">
                Batch Size: <input type="number" id="custom-batch-size" value="10" min="1" max="50" style="width: 60px;">
                Offset: <input type="number" id="custom-offset" value="0" min="0" style="width: 80px;">
                <button onclick="runCustomBatch()" class="button" style="margin-left: 10px;">Run Custom Batch</button>
            </div>
        </div>
        
        <!-- Loading indicator -->
        <div id="loading-indicator" style="display: none; text-align: center; padding: 20px;">
            <strong>Processing...</strong> Please wait.
        </div>
        
        <!-- Results area -->
        <div id="results-area" style="margin-top: 20px; padding: 15px; background: #f9f9f9; border: 1px solid #ddd; min-height: 100px;">
            <p><em>Click a button above to start. Results will appear here...</em></p>
        </div>
        
        <!-- Continue buttons area (appears after import) -->
        <div id="continue-buttons" style="display: none; margin-top: 15px; text-align: center;">
            <!-- Dynamic buttons will be inserted here -->
        </div>
    </div>

    <script>
    let currentOffset = 0;
    let currentBatchSize = 10;
    const ajaxUrl = '<?php echo admin_url('admin-ajax.php'); ?>';
    
    function runIconAction(action, batchSize = 10, offset = 0) {
        currentBatchSize = batchSize;
        currentOffset = offset;
        
        document.getElementById('loading-indicator').style.display = 'block';
        document.getElementById('results-area').innerHTML = '';
        document.getElementById('continue-buttons').style.display = 'none';
        
        // Create form data
        const formData = new FormData();
        formData.append('action', 'enhanced_icon_import_ajax');
        formData.append('import_action', action);
        formData.append('batch_size', batchSize);
        formData.append('offset', offset);
        formData.append('nonce', '<?php echo wp_create_nonce("enhanced_icon_import"); ?>');
        
        console.log('Making AJAX request to:', ajaxUrl);
        console.log('Action:', action, 'batch_size:', batchSize, 'offset:', offset);
        
        // Make AJAX request
        fetch(ajaxUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.status);
            }
            return response.text();
        })
        .then(data => {
            document.getElementById('loading-indicator').style.display = 'none';
            
            // Check if we got a proper response
            if (data.trim() === '' || data.includes('0')) {
                document.getElementById('results-area').innerHTML = '<p style="color: red;">Empty or invalid response from server. Check if you have proper permissions.</p>';
            } else {
                document.getElementById('results-area').innerHTML = data;
            }
            
            // If it was an import, show continue buttons
            if (action === 'import') {
                showContinueButtons(batchSize, offset + batchSize);
            }
        })
        .catch(error => {
            document.getElementById('loading-indicator').style.display = 'none';
            document.getElementById('results-area').innerHTML = '<p style="color: red;">AJAX Error: ' + error.message + '<br>Check browser console for more details.</p>';
            console.error('Enhanced Icon Import AJAX Error:', error);
        });
    }
    
    function runCustomBatch() {
        const batchSize = parseInt(document.getElementById('custom-batch-size').value);
        const offset = parseInt(document.getElementById('custom-offset').value);
        runIconAction('import', batchSize, offset);
    }
    
    function showContinueButtons(batchSize, nextOffset) {
        const buttonsHTML = `
            <button onclick="runIconAction('import', ${batchSize}, ${nextOffset})" class="button button-primary" style="margin: 5px;">
                Continue: Next ${batchSize} items (offset ${nextOffset})
            </button>
            <button onclick="runIconAction('stats')" class="button button-secondary" style="margin: 5px;">
                View Updated Statistics
            </button>
            <button onclick="document.getElementById('custom-offset').value=${nextOffset}" class="button button-secondary" style="margin: 5px;">
                Set Offset to ${nextOffset}
            </button>
        `;
        document.getElementById('continue-buttons').innerHTML = buttonsHTML;
        document.getElementById('continue-buttons').style.display = 'block';
    }
    </script>
    <?php
    return ob_get_clean();
}

// Initialize the importer class globally to ensure AJAX handlers are registered
global $jotunheim_enhanced_icon_importer;
$jotunheim_enhanced_icon_importer = new JotunheimEnhancedIconImporter();

// Register shortcode
add_shortcode('enhanced_icon_import', 'enhanced_icon_import_shortcode');

/**
 * Add admin menu for enhanced icon import
 */
function add_enhanced_icon_import_menu() {
    add_submenu_page(
        'jotunheim-magic-settings',
        'Enhanced Icon Import',
        'Enhanced Icon Import', 
        'manage_options',
        'enhanced-icon-import',
        'enhanced_icon_import_admin_page'
    );
}
add_action('admin_menu', 'add_enhanced_icon_import_menu');

/**
 * Admin page for enhanced icon import
 */
function enhanced_icon_import_admin_page() {
    if (!current_user_can('manage_options')) {
        wp_die('Insufficient permissions');
    }
    
    echo '<div class="wrap">';
    echo '<h1>Enhanced Icon Import</h1>';
    echo '<p>Import icons from multiple sources for prefab items that don\'t have icons yet.</p>';
    
    echo '<h2>Import Sources (Priority Order)</h2>';
    echo '<ol>';
    echo '<li><strong>Existing URLs:</strong> Your original Google Drive or other URLs (FIRST PRIORITY)</li>';
    echo '<li><strong>Jotunn Database:</strong> https://valheim-modding.github.io/Jotunn/data/prefabs/</li>';
    echo '<li><strong>Commands.gg:</strong> https://commands.gg/valheim/characters</li>';
    echo '</ol>';
    
    echo '<h2>Usage</h2>';
    echo '<p>Use these shortcodes on any page:</p>';
    echo '<ul>';
    echo '<li><code>[enhanced_icon_import]</code> - Import icons (default batch: 20 items)</li>';
    echo '<li><code>[enhanced_icon_import batch_size="10"]</code> - Smaller batch for testing</li>';
    echo '<li><code>[enhanced_icon_import offset="40"]</code> - Start from a specific position</li>';
    echo '<li><code>[enhanced_icon_import action="stats"]</code> - Show import statistics</li>';
    echo '<li><code>[enhanced_icon_import action="check"]</code> - Check and fix missing icon files</li>';
    echo '</ul>';
    echo '<p><strong>Pro Tip:</strong> Use smaller batch sizes (10-20) for better performance and to avoid timeouts.</p>';
    
    echo '<h2>Manual Trigger</h2>';
    
    if (isset($_POST['run_import'])) {
        echo '<div style="background: #f0f0f0; padding: 15px; margin: 20px 0; border-left: 4px solid #0073aa;">';
        $importer = new JotunheimEnhancedIconImporter();
        $batch_size = intval($_POST['batch_size']) ?: 50;
        $importer->run_enhanced_import($batch_size);
        echo '</div>';
    }
    
    if (isset($_POST['check_missing'])) {
        echo '<div style="background: #f0f0f0; padding: 15px; margin: 20px 0; border-left: 4px solid #0073aa;">';
        $importer = new JotunheimEnhancedIconImporter();
        $importer->update_missing_icons_for_existing_items();
        echo '</div>';
    }
    
    echo '<form method="post">';
    echo '<table class="form-table">';
    echo '<tr><th>Batch Size</th><td><input type="number" name="batch_size" value="50" min="1" max="200"></td></tr>';
    echo '</table>';
    echo '<p class="submit">';
    echo '<input type="submit" name="run_import" class="button-primary" value="Run Enhanced Import">';
    echo ' <input type="submit" name="check_missing" class="button-secondary" value="Check Missing Files">';
    echo '</p>';
    echo '</form>';
    
    echo '</div>';
}
?>