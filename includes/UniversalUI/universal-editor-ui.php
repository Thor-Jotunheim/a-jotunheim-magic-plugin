<?php
// File: universal-editor-ui.php

function jotunheim_magic_universal_editor_interface() {
    global $wpdb;

    // Fetch tables starting with jotun_
    $tables = $wpdb->get_col("SHOW TABLES LIKE 'jotun_%'");

    // Fetch API endpoints dynamically
    $api_endpoints = $wpdb->get_results("SELECT name, CONCAT(base_url, endpoint) AS full_url FROM jotun_api_endpoints WHERE enabled = 1", OBJECT_K);

    ob_start(); ?>
    <div class="wrap universal-editor-container" style="display: flex; gap: 20px; background: url('https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.bhmpics.com%2Fdownloads%2FValheim-Wallpapers%2F77.3-mistlands-teaser-1bb74b243f7219098476.jpg&f=1&nofb=1&ipt=45065e8b7cc5ca3ae8824364501250a2b5b4cf1428e93cd817bd8671ce697ec2&ipo=images') no-repeat center; background-size: cover; padding: 10px; border-radius: 10px; width: 100%; max-width: 1200px; margin: auto;">
        
        <!-- Left-hand side: Record List -->
        <div style="flex: 1; background: rgba(255, 255, 255, 0.9); padding: 10px; border-radius: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.5); height: calc(110vh - 50px); overflow-y: auto;">
            <h4 style="font-family: 'Roboto', sans-serif; font-size: 18px; margin-bottom: 10px;">Select Table:</h4>
            <select id="table-selector" style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 5px; border: 2px solid #666;">
                <option value="">-- Select a Table --</option>
                <?php foreach ($tables as $table): ?>
                    <option value="<?php echo esc_attr($table); ?>"><?php echo esc_html($table); ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Search bar -->
            <input type="text" id="search-bar" placeholder="Search records..." style="width: 100%; padding: 8px; margin-bottom: 10px; border-radius: 5px; border: 1px solid #666;">
            
            <!-- Load/Clear buttons -->
            <div style="margin-bottom: 10px;">
                <button id="load-btn" style="padding: 8px; background-color: #0073aa; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Load</button>
                <button id="clear-btn" style="padding: 8px; background-color: #dc3545; color: #fff; border: none; border-radius: 5px; cursor: pointer; margin-left: 5px;">Clear</button>
            </div>

            <div id="records-list-container" style="height: calc(100% - 150px); overflow-y: auto;">
                <p>Select a table and click Load to view records.</p>
            </div>
        </div>

        <!-- Right-hand side: Record Editor -->
        <div style="flex: 2; background: rgba(255, 255, 255, 0.9); padding: 10px; border-radius: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);">
            <h4 style="font-family: 'Roboto', sans-serif; font-size: 18px; text-align: center; margin-bottom: 10px;">Edit Record</h4>
            <div id="form-fields-container">
                <p>Select a record from the list to load its fields.</p>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        const apiEndpoints = <?php echo json_encode($api_endpoints); ?>;
        const apiHeaders = { 'Authorization': 'Bearer <?php echo getenv('API_SECRET_KEY'); ?>' }; // Load API key from wp-config.php

        jQuery(document).ready(function($) {
            // Load records
            $('#load-btn').click(function() {
                const selectedTable = $('#table-selector').val();
                const searchTerm = $('#search-bar').val();
                const recordsContainer = $('#records-list-container');

                if (!selectedTable) {
                    alert('Please select a table first.');
                    return;
                }

                recordsContainer.html('<p>Loading records...</p>');

                $.ajax({
                    url: apiEndpoints['list_records'].full_url,
                    method: 'POST',
                    headers: apiHeaders,
                    contentType: 'application/json',
                    data: JSON.stringify({ table: selectedTable, search: searchTerm }),
                    success: function(response) {
                        recordsContainer.empty();

                        if (response && response.length > 0) {
                            response.forEach(record => {
                                recordsContainer.append(`
                                    <div>
                                        <button class="load-record-btn" data-id="${record.id}" style="width: 100%; margin-bottom: 5px; padding: 8px; background: #0073aa; color: #fff; border: none; border-radius: 5px; text-align: left;">
                                            ${record.name || 'Record ID: ' + record.id}
                                        </button>
                                    </div>
                                `);
                            });
                        } else {
                            recordsContainer.html('<p>No records found.</p>');
                        }
                    },
                    error: function(error) {
                        console.error('Error loading records:', error);
                        recordsContainer.html('<p>Failed to load records.</p>');
                    }
                });
            });

            // Clear records
            $('#clear-btn').click(function() {
                $('#records-list-container').html('<p>Cleared records.</p>');
            });

            // Load fields for a record
            $('#records-list-container').on('click', '.load-record-btn', function() {
                const recordId = $(this).data('id');
                const selectedTable = $('#table-selector').val();

                $('#form-fields-container').html('<p>Loading record...</p>');

                $.ajax({
                    url: apiEndpoints['get_record'].full_url,
                    method: 'POST',
                    headers: apiHeaders,
                    contentType: 'application/json',
                    data: JSON.stringify({ table: selectedTable, id: recordId }),
                    success: function(response) {
                        const formContainer = $('#form-fields-container');
                        formContainer.empty();

                        for (const [key, value] of Object.entries(response)) {
                            formContainer.append(`
                                <div style="margin-bottom: 10px;">
                                    <label style="font-weight: bold;">${key.replace('_', ' ')}:</label>
                                    <input type="text" name="${key}" value="${value}" style="width: 100%; padding: 8px; border: 1px solid #666; border-radius: 5px;">
                                </div>
                            `);
                        }
                    },
                    error: function(error) {
                        console.error('Error loading record:', error);
                        $('#form-fields-container').html('<p>Failed to load record.</p>');
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