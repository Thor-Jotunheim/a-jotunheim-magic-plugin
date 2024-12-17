<?php
function jotunheim_magic_universal_editor_interface() {
    global $wpdb;

    // Fetch tables dynamically
    $tables = $wpdb->get_col("SHOW TABLES LIKE 'jotun_%'");

    ob_start(); ?>
    <div class="wrap universal-editor-container" style="display: flex; gap: 20px; width: 100%; max-width: 1200px; margin: auto; padding: 10px;">
        
        <!-- Left Section: Table and Records -->
        <div style="flex: 1; background: #fff; padding: 10px; border-radius: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);">
            <h3 style="text-align: center; margin-bottom: 10px;">Select Table</h3>
            <select id="table-selector" style="width: 100%; padding: 8px; margin-bottom: 10px; border-radius: 5px;">
                <option value="">-- Select a Table --</option>
                <?php foreach ($tables as $table): ?>
                    <option value="<?php echo esc_attr($table); ?>"><?php echo esc_html($table); ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Records List -->
            <div id="records-list-container" style="height: calc(100vh - 220px); overflow-y: auto; background: #f9f9f9; padding: 10px; border-radius: 5px;">
                <p>Select a table to load records.</p>
            </div>
        </div>

        <!-- Right Section: Editor -->
        <div style="flex: 2; background: #fff; padding: 10px; border-radius: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);">
            <h3 style="text-align: center;">Edit Record</h3>
            <div id="form-fields-container">
                <p>Select a record to load its fields.</p>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('universal_editor_ui', 'jotunheim_magic_universal_editor_interface');
?>