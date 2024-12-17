<?php
// File: universal-editor-ui.php

function jotunheim_magic_universal_editor_interface() {
    global $wpdb;

    // Fetch tables starting with jotun_
    $tables = $wpdb->get_col("SHOW TABLES LIKE 'jotun_%'");

    // Fetch API endpoints dynamically
    $api_endpoints = $wpdb->get_results("SELECT name, CONCAT(base_url, endpoint) AS full_url FROM jotun_api_endpoints WHERE enabled = 1", OBJECT_K);

    ob_start(); ?>
    <div class="wrap universal-editor-container" style="display: flex; gap: 20px; background: url('https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.bhmpics.com%2Fdownloads%2FValheim-Wallpapers%2F77.3-mistlands-teaser-1bb74b243f7219098476.jpg&f=1&nofb=1&ipt=45065e8b7cc5ca3ae8824364501250a2b5b4cf1428e93cd817bd8671ce697ec2&ipo=images') no-repeat center; background-size: cover; padding: 10px; border-radius: 10px;">
        
        <!-- Left-hand side: List of Records -->
        <div style="flex: 1; background: rgba(255, 255, 255, 0.8); padding: 10px; border-radius: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.5); height: calc(110vh - 50px); overflow-y: auto;">
            <h4 style="font-family: 'Roboto', sans-serif; font-size: 18px; margin-bottom: 10px;">Select Table:</h4>
            <select id="table-selector" style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 5px; border: 2px solid #666;">
                <option value="">-- Select a Table --</option>
                <?php foreach ($tables as $table): ?>
                    <option value="<?php echo esc_attr($table); ?>"><?php echo esc_html($table); ?></option>
                <?php endforeach; ?>
            </select>

            <div id="records-list-container" style="height: calc(100% - 80px); overflow-y: auto;">
                <p>Select a table to load its records.</p>
            </div>
        </div>

        <!-- Right-hand side: Record Editor -->
        <div style="flex: 2; background: rgba(255, 255, 255, 0.8); padding: 10px; border-radius: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);">
            <h4 style="font-family: 'Roboto', sans-serif; font-size: 18px; text-align: center; margin-bottom: 10px;">Edit Record</h4>
            <div id="form-fields-container">
                <p>Select a record to load its fields.</p>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        const apiEndpoints = <?php echo json_encode($api_endpoints); ?>;

        jQuery(document).ready(function($) {
            // Fetch records dynamically for the selected table
            $('#table-selector').change(function() {
                const selectedTable = $(this).val();
                const recordsContainer = $('#records-list-container');
                const formContainer = $('#form-fields-container');

                recordsContainer.html('<p>Loading records...</p>');
                formContainer.html('<p>Select a record to load its fields.</p>');

                if (selectedTable) {
                    $.ajax({
                        url: apiEndpoints['list_records'].full_url,
                        method: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify({ table: selectedTable }),
                        success: function(response) {
                            recordsContainer.empty();

                            if (response && response.length > 0) {
                                response.forEach(record => {
                                    const recordItem = `<div style="margin-bottom: 5px;">
                                        <button class="load-record-btn" data-id="${record.id}" style="width: 100%; padding: 5px; background-color: #0073aa; color: #fff; border: none; border-radius: 5px; text-align: left;">
                                            ${record.name || 'Record ID: ' + record.id}
                                        </button>
                                    </div>`;
                                    recordsContainer.append(recordItem);
                                });
                            } else {
                                recordsContainer.html('<p>No records found for this table.</p>');
                            }
                        },
                        error: function(error) {
                            console.error('Error fetching records:', error);
                            recordsContainer.html('<p>Failed to fetch records. Check the console for details.</p>');
                        }
                    });
                } else {
                    recordsContainer.html('<p>Select a table to load its records.</p>');
                }
            });

            // Load fields for a selected record
            $('#records-list-container').on('click', '.load-record-btn', function() {
                const recordId = $(this).data('id');
                const selectedTable = $('#table-selector').val();
                const formContainer = $('#form-fields-container');

                formContainer.html('<p>Loading record fields...</p>');

                $.ajax({
                    url: apiEndpoints['get_record'].full_url,
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ table: selectedTable, id: recordId }),
                    success: function(response) {
                        if (response && Object.keys(response).length > 0) {
                            formContainer.empty();

                            for (const [key, value] of Object.entries(response)) {
                                formContainer.append(`
                                    <div style="margin-bottom: 10px;">
                                        <label style="font-weight: bold;">${key.replace('_', ' ')}:</label>
                                        <input type="text" name="${key}" value="${value}" style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #666;">
                                    </div>
                                `);
                            }

                            formContainer.append(`
                                <button type="button" id="save-btn" style="padding: 10px; background-color: #28a745; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Save Changes</button>
                            `);
                        } else {
                            formContainer.html('<p>No fields found for this record.</p>');
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching record fields:', error);
                        formContainer.html('<p>Failed to load record fields.</p>');
                    }
                });
            });
        });
    </script>
    <?php
    return ob_get_clean();
}

add_shortcode('universal_editor_ui', 'jotunheim_magic_universal_editor_interface');
?>