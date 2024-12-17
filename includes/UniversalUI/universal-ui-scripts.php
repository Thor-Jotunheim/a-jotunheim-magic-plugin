<?php
// File: universal-ui-scripts.php

// Register Shortcode for Universal Editor UI
function jotunheim_register_universal_editor_shortcode() {
    add_shortcode('universal_editor_ui', 'jotunheim_magic_universal_editor_interface');
}

// Register Shortcode for Universal Add UI (if this exists in your file)
function jotunheim_register_universal_add_shortcode() {
    add_shortcode('universal_add_ui', 'jotunheim_magic_universal_add_interface');
}

// Enqueue and Pass Inline Script
function jotunheim_enqueue_universal_ui_scripts() {
    global $wpdb;

    // Fetch API endpoints dynamically
    $api_endpoints = $wpdb->get_results(
        "SELECT name, CONCAT(base_url, endpoint) AS full_url FROM jotun_api_endpoints WHERE enabled = 1",
        OBJECT_K
    );

    // Load the API key securely
    $apiKey = defined('JOTUN_API_KEY') ? JOTUN_API_KEY : '';

    // Add Inline JavaScript Logic
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            const apiKey = "<?php echo esc_js($apiKey); ?>";
            const apiEndpoints = <?php echo json_encode($api_endpoints); ?>;

            const tableSelector = $('#table-selector');
            const recordsContainer = $('#records-list-container');
            const formFieldsContainer = $('#form-fields-container');

            // Load Records when a table is selected
            tableSelector.on('change', function () {
                const table = $(this).val();
                if (!table) {
                    resetUI();
                    return;
                }
                fetchRecords(table);
            });

            // Fetch Records
            function fetchRecords(table) {
                recordsContainer.html('<p>Loading records...</p>');

                $.ajax({
                    url: apiEndpoints['list_records'] ? apiEndpoints['list_records'].full_url : '',
                    method: 'POST',
                    headers: { 'X-API-KEY': apiKey, 'Content-Type': 'application/json' },
                    data: JSON.stringify({ table: table }),
                    success: function (data) {
                        recordsContainer.empty();
                        if (data.length > 0) {
                            data.forEach(record => {
                                recordsContainer.append(`
                                    <button class="record-btn" data-id="${record.id}" style="width: 100%; margin-bottom: 5px; padding: 8px; background: #0073aa; color: #fff; border-radius: 5px;">
                                        ${record.name || `Record ID: ${record.id}`}
                                    </button>
                                `);
                            });
                        } else {
                            recordsContainer.html('<p>No records found.</p>');
                        }
                    },
                    error: function () {
                        recordsContainer.html('<p>Failed to load records.</p>');
                    }
                });
            }

            // Fetch Record Details
            recordsContainer.on('click', '.record-btn', function () {
                const recordId = $(this).data('id');
                const table = tableSelector.val();

                formFieldsContainer.html('<p>Loading record...</p>');

                $.ajax({
                    url: apiEndpoints['get_record'] ? apiEndpoints['get_record'].full_url : '',
                    method: 'POST',
                    headers: { 'X-API-KEY': apiKey, 'Content-Type': 'application/json' },
                    data: JSON.stringify({ table: table, id: recordId }),
                    success: function (data) {
                        formFieldsContainer.empty();
                        for (const [key, value] of Object.entries(data)) {
                            formFieldsContainer.append(`
                                <div style="margin-bottom: 10px;">
                                    <label style="font-weight: bold;">${key.replace('_', ' ')}:</label>
                                    <input type="text" name="${key}" value="${value}" style="width: 100%; padding: 8px; border: 1px solid #666; border-radius: 5px;">
                                </div>
                            `);
                        }
                    },
                    error: function () {
                        formFieldsContainer.html('<p>Failed to load record details.</p>');
                    }
                });
            });

            // Reset UI
            function resetUI() {
                recordsContainer.html('<p>Select a table to load records.</p>');
                formFieldsContainer.html('<p>Select a record to load its fields.</p>');
            }
        });
    </script>
    <?php
}

// Hook Shortcodes and Scripts
add_action('wp_enqueue_scripts', 'jotunheim_enqueue_universal_ui_scripts');
jotunheim_register_universal_editor_shortcode();
jotunheim_register_universal_add_shortcode();
?>