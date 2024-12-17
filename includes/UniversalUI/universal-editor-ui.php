<?php
// File: universal-editor-ui.php

function jotunheim_magic_universal_editor_interface() {
    global $wpdb;

    // Fetch tables starting with jotun_
    $tables = $wpdb->get_col("SHOW TABLES LIKE 'jotun_%'");

    // Fetch API endpoints dynamically
    $api_endpoints = $wpdb->get_results("SELECT name, CONCAT(base_url, endpoint) AS full_url FROM jotun_api_endpoints WHERE enabled = 1", OBJECT_K);

    ob_start(); // Start output buffering
    ?>
    <div class="universal-editor-section" style="width: 100%; max-width: 1000px; margin: auto;">
        <h4 style="margin-bottom: 20px;">Edit Item in Table</h4>
        <form id="universal-editor-form" method="post" action="javascript:void(0);">
            <!-- Table Selection -->
            <div class="field-row" style="margin-bottom: 20px;">
                <label for="table-selector" style="font-weight: bold;">Select Table:</label>
                <select id="table-selector" name="table_name" style="width: 100%; padding: 10px;">
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
            <div id="form-fields-container" style="margin-bottom: 20px;">
                <p>Select a record to load its fields.</p>
            </div>

            <!-- Submit Buttons -->
            <button type="button" id="update-item-btn" disabled style="background-color: #0073aa; color: #fff; padding: 10px; border: none; border-radius: 5px; width: 100%; margin-bottom: 10px;">
                Update Item
            </button>
            <button type="button" id="delete-item-btn" disabled style="background-color: #dc3545; color: #fff; padding: 10px; border: none; border-radius: 5px; width: 100%;">
                Delete Item
            </button>
        </form>
    </div>

    <!-- Pass API endpoints to JavaScript -->
    <script type="text/javascript">
        const apiEndpoints = <?php echo json_encode($api_endpoints); ?>;

        jQuery(document).ready(function($) {
            $('#table-selector').change(function() {
                const selectedTable = $(this).val();

                if (selectedTable) {
                    // Fetch table records
                    $.ajax({
                        url: apiEndpoints['list_records'].full_url,
                        method: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify({ table: selectedTable }),
                        success: function(response) {
                            const recordsContainer = $('#records-list-container');
                            recordsContainer.empty();

                            if (response && response.length > 0) {
                                response.forEach((record, index) => {
                                    recordsContainer.append(
                                        `<div style="padding: 5px; cursor: pointer;" class="record-row" data-index="${index}">
                                            ${JSON.stringify(record)}
                                        </div>`
                                    );
                                });
                            } else {
                                recordsContainer.html('<p>No records found for this table.</p>');
                            }
                        },
                        error: function(error) {
                            console.error('Failed to fetch records:', error);
                        }
                    });

                    // Fetch table columns (fields)
                    $.ajax({
                        url: apiEndpoints['get_columns'].full_url,
                        method: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify({ table: selectedTable }),
                        success: function(response) {
                            const fieldsContainer = $('#form-fields-container');
                            fieldsContainer.empty();

                            if (response.columns && response.columns.length > 0) {
                                response.columns.forEach(column => {
                                    fieldsContainer.append(createField(column));
                                });
                                $('#update-item-btn, #delete-item-btn').prop('disabled', false);
                            } else {
                                fieldsContainer.html('<p>No fields found for this table.</p>');
                                $('#update-item-btn, #delete-item-btn').prop('disabled', true);
                            }
                        },
                        error: function(error) {
                            console.error('Failed to fetch table fields:', error);
                        }
                    });
                } else {
                    $('#records-list-container, #form-fields-container').html('<p>Select a table to load its data.</p>');
                    $('#update-item-btn, #delete-item-btn').prop('disabled', true);
                }
            });

            // Helper function to create input fields dynamically
            function createField(column) {
                const fieldName = column.Field;
                return `
                    <div class="field-row" style="margin-bottom: 10px;">
                        <label for="${fieldName}" style="font-weight: bold;">${fieldName.replace('_', ' ')}:</label>
                        <input type="text" id="${fieldName}" name="${fieldName}" style="width: 100%; padding: 8px;">
                    </div>
                `;
            }
        });
    </script>
    <?php
    return ob_get_clean();
}

// Register the shortcode for Universal Editor UI
add_shortcode('universal_editor_ui', 'jotunheim_magic_universal_editor_interface');