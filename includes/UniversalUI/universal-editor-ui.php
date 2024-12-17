<?php
// File: universal-editor-ui.php

function jotunheim_magic_universal_editor_interface() {
    global $wpdb;

    // Fetch tables starting with jotun_
    $tables = $wpdb->get_col("SHOW TABLES LIKE 'jotun_%'");

    // Fetch API endpoints dynamically
    $api_endpoints = $wpdb->get_results("SELECT name, CONCAT(base_url, endpoint) AS full_url FROM jotun_api_endpoints WHERE enabled = 1", OBJECT_K);

    // Load the API key securely
    $apiKey = defined('JOTUN_API_KEY') ? JOTUN_API_KEY : '';

    ob_start(); ?>
    <div class="wrap universal-editor-container" style="display: flex; gap: 20px; width: 100%; max-width: 1200px; margin: auto; padding: 10px; background: #f9f9f9; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

        <!-- Left Section: Table and Records -->
        <div style="flex: 1; background: #fff; padding: 10px; border-radius: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);">
            <h3 style="text-align: center; margin-bottom: 10px;">Select Table</h3>
            <select id="table-selector" style="width: 100%; padding: 8px; margin-bottom: 10px; border-radius: 5px; border: 1px solid #666;">
                <option value="">-- Select a Table --</option>
                <?php foreach ($tables as $table): ?>
                    <option value="<?php echo esc_attr($table); ?>"><?php echo esc_html($table); ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Records List -->
            <div id="records-list-container" style="height: calc(100vh - 250px); overflow-y: auto; padding: 10px; background: #f9f9f9; border-radius: 5px;">
                <p>Select a table to load records.</p>
            </div>
        </div>

        <!-- Right Section: Editor -->
        <div style="flex: 2; background: #fff; padding: 10px; border-radius: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); overflow-y: auto;">
            <h3 style="text-align: center; margin-bottom: 10px;">Edit Record</h3>
            <div id="form-fields-container" style="height: calc(100vh - 150px); overflow-y: auto;">
                <p>Select a record to load its fields.</p>
            </div>
        </div>
    </div>

    <script>
        const JotunheimEditor = {
            apiKey: "<?php echo esc_js($apiKey); ?>",
            apiEndpoints: '<?php echo json_encode($api_endpoints); ?>'
        };
    </script>
    <?php
    return ob_get_clean();
}

add_shortcode('universal_editor_ui', 'jotunheim_magic_universal_editor_interface');
?>