<?php
// File: universal-editor-ui.php

function jotunheim_magic_universal_editor_interface() {
    global $wpdb;

    // Fetch tables starting with jotun_
    $tables = $wpdb->get_col("SHOW TABLES LIKE 'jotun_%'");

    ob_start(); // Start output buffering
    ?>
    <div class="universal-editor-section" style="width: 100%; max-width: 1000px; margin: auto; background: url('https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.bhmpics.com%2Fdownloads%2FValheim-Wallpapers%2F77.3-mistlands-teaser-1bb74b243f7219098476.jpg&f=1&nofb=1&ipt=45065e8b7cc5ca3ae8824364501250a2b5b4cf1428e93cd817bd8671ce697ec2&ipo=images') no-repeat fixed center; background-size: cover; padding: 5px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); overflow: hidden; display: flex; gap: 20px; height: auto; min-height: calc(110vh - 50px);">
        <div style="flex: 1; background: rgba(255, 255, 255, 0.8); padding: 10px; border-radius: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);">
            <h4 style="font-family: 'Roboto', sans-serif; font-weight: 700; color: #444;">Edit Item in Table</h4>
            <form id="universal-editor-form" method="post" action="javascript:void(0);" style="display: block;">
                <!-- Table Selection -->
                <div class="field-row" style="margin-bottom: 20px;">
                    <label for="table-selector" style="font-weight: bold; font-size: 16px;">Select Table:</label>
                    <select id="table-selector" name="table_name" style="padding: 10px; border-radius: 5px; border: 2px solid #666; width: 100%; margin-top: 5px;">
                        <option value="">-- Select a Table --</option>
                        <?php foreach ($tables as $table): ?>
                            <option value="<?php echo esc_attr($table); ?>"><?php echo esc_html($table); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Records List -->
                <div id="records-list-container" style="margin-bottom: 20px;">
                    <p>Select a table to load its records.</p>
                </div>

                <!-- Dynamic Fields Container -->
                <div id="form-fields-container">
                    <p>Select a record to load its fields.</p>
                </div>

                <!-- Submit Button -->
                <button type="button" id="update-item-btn" style="padding: 10px; background-color: #0073aa; color: #fff; border: none; border-radius: 5px; cursor: pointer; width: 100%;" disabled>
                    Update Item
                </button>
                <button type="button" id="delete-item-btn" style="padding: 10px; background-color: #dc3545; color: #fff; border: none; border-radius: 5px; cursor: pointer; width: 100%; margin-top: 10px;" disabled>
                    Delete Item
                </button>
            </form>
        </div>
    </div>
    <?php
    return ob_get_clean(); // Return the content
}

// Register the shortcode for Universal Editor UI
add_shortcode('universal_editor_ui', 'jotunheim_magic_universal_editor_interface');