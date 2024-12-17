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
    <div class="wrap universal-editor-container" id="universal-editor-container" style="display: flex; gap: 20px; width: 100%; max-width: 1200px; margin: auto; background: url('https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.bhmpics.com%2Fdownloads%2FValheim-Wallpapers%2F77.3-mistlands-teaser-1bb74b243f7219098476.jpg&f=1&nofb=1&ipt=45065e8b7cc5ca3ae8824364501250a2b5b4cf1428e93cd817bd8671ce697ec2&ipo=images') no-repeat fixed center; background-size: cover; padding: 5px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); min-height: calc(110vh - 50px);">
        
        <!-- Left-hand side: Record List -->
        <div style="flex: 1; background: rgba(255, 255, 255, 0.9); padding: 10px; border-radius: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);">
            <h2 style="text-align: center; font-family: 'Roboto', sans-serif;">Universal Editor</h2>
            <div>
                <!-- Table Dropdown -->
                <label for="table-selector" style="font-weight: bold;">Select Table:</label>
                <select id="table-selector" style="width: 100%; padding: 8px; margin-bottom: 10px; border-radius: 5px; border: 1px solid #666;">
                    <option value="">-- Select a Table --</option>
                    <?php foreach ($tables as $table): ?>
                        <option value="<?php echo esc_attr($table); ?>"><?php echo esc_html($table); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Search Bar -->
            <input type="text" id="record-search" placeholder="Search records..." style="width: 100%; padding: 8px; margin-bottom: 10px; border-radius: 5px; border: 1px solid #666;">

            <!-- Load/Clear Buttons -->
            <div>
                <button id="load-records-btn" style="padding: 8px; width: 48%; background: #0073aa; color: #fff; border-radius: 5px; border: none;">Load</button>
                <button id="clear-records-btn" style="padding: 8px; width: 48%; background: #dc3545; color: #fff; border-radius: 5px; border: none;">Clear</button>
            </div>

            <!-- Records List -->
            <div id="records-list-container" style="margin-top: 10px; height: calc(100% - 150px); overflow-y: auto; background: #fff; border-radius: 5px; padding: 10px;">
                <p>Select a table and click Load to view records.</p>
            </div>
        </div>

        <!-- Right-hand side: Record Editor -->
        <div style="flex: 2; background: rgba(255, 255, 255, 0.9); padding: 10px; border-radius: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.5); overflow-y: auto;">
            <h3 style="text-align: center; font-family: 'Roboto', sans-serif; margin-bottom: 10px;">Edit Record</h3>
            <div id="form-fields-container">
                <p>Select a record to load its fields.</p>
            </div>
        </div>
    </div>

    <script>
        const apiKey = "<?php echo $apiKey; ?>";
        const apiEndpoints = <?php echo json_encode($api_endpoints); ?>;

        jQuery(document).ready(function($) {
            $('#load-records-btn').click(function() {
                const selectedTable = $('#table-selector').val();
                const searchValue = $('#record-search').val();
                const recordsContainer = $('#records-list-container');

                recordsContainer.html('<p>Loading records...</p>');

                $.ajax({
                    url: apiEndpoints['list_records'].full_url,
                    method: 'POST',
                    headers: { 'X-API-KEY': apiKey },
                    contentType: 'application/json',
                    data: JSON.stringify({ table: selectedTable, search: searchValue }),
                    success: function(response) {
                        recordsContainer.empty();

                        if (response.length) {
                            response.forEach(record => {
                                recordsContainer.append(`
                                    <div>
                                        <button class="record-btn" data-id="${record.id}" style="width: 100%; margin-bottom: 5px; padding: 8px; background: #0073aa; color: #fff; border-radius: 5px; text-align: left;">
                                            ${record.name || 'Record ID: ' + record.id}
                                        </button>
                                    </div>
                                `);
                            });
                        } else {
                            recordsContainer.html('<p>No records found.</p>');
                        }
                    }
                });
            });

            $('#records-list-container').on('click', '.record-btn', function() {
                const recordId = $(this).data('id');
                const selectedTable = $('#table-selector').val();

                $('#form-fields-container').html('<p>Loading record...</p>');

                $.ajax({
                    url: apiEndpoints['get_record'].full_url,
                    method: 'POST',
                    headers: { 'X-API-KEY': apiKey },
                    contentType: 'application/json',
                    data: JSON.stringify({ table: selectedTable, id: recordId }),
                    success: function(response) {
                        $('#form-fields-container').html('');
                        Object.entries(response).forEach(([key, value]) => {
                            $('#form-fields-container').append(`
                                <div>
                                    <label>${key}</label>
                                    <input type="text" value="${value}" style="width: 100%; margin-bottom: 10px;">
                                </div>
                            `);
                        });
                    }
                });
            });

            $('#clear-records-btn').click(function() {
                $('#records-list-container').html('<p>Cleared records.</p>');
                $('#form-fields-container').html('<p>Select a record to load its fields.</p>');
            });
        });
    </script>
    <?php
    return ob_get_clean();
}

add_shortcode('universal_editor_ui', 'jotunheim_magic_universal_editor_interface');
?>