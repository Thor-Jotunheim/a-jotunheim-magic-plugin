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

    // Inline JavaScript Logic
    ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            const apiKey = "<?php echo esc_js($apiKey); ?>";
            const apiEndpoints = <?php echo json_encode($api_endpoints); ?>;

            const tableSelector = document.getElementById('table-selector');
            const recordsContainer = document.getElementById('universal-editor-container');
            const searchField = document.getElementById('record-search');

            // Fetch and refresh the record list for a selected table
            function universalRefreshRecordList(table) {
                const listRecordsEndpoint = apiEndpoints['list_records'] ? apiEndpoints['list_records'].full_url : null;

                if (!listRecordsEndpoint) {
                    console.error('Error: list_records API endpoint not found.');
                    return;
                }

                fetch(listRecordsEndpoint, {
                    method: 'POST',
                    headers: {
                        'X-API-KEY': apiKey,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ table: table })
                })
                .then(response => response.json())
                .then(data => {
                    recordsContainer.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(record => {
                            const checkbox = `
                                <div>
                                    <label>
                                        <input type="checkbox" class="record-selection-checkbox" data-id="${record.id}" value="${record.name}">
                                        ${record.name || `Record ID: ${record.id}`}
                                    </label>
                                </div>`;
                            recordsContainer.insertAdjacentHTML('beforeend', checkbox);
                        });
                    } else {
                        recordsContainer.innerHTML = '<p>No records found for this table.</p>';
                    }
                })
                .catch(error => console.error('Error fetching records:', error));
            }

            // Search records dynamically
            function universalSearchRecords(table, searchValue) {
                const listRecordsEndpoint = apiEndpoints['list_records'] ? apiEndpoints['list_records'].full_url : null;

                if (!listRecordsEndpoint) {
                    console.error('Error: list_records API endpoint not found.');
                    return;
                }

                fetch(`${listRecordsEndpoint}?search=${encodeURIComponent(searchValue)}`, {
                    method: 'POST',
                    headers: {
                        'X-API-KEY': apiKey,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ table: table })
                })
                .then(response => response.json())
                .then(data => {
                    recordsContainer.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(record => {
                            const checkbox = `
                                <div>
                                    <label>
                                        <input type="checkbox" class="record-selection-checkbox" data-id="${record.id}" value="${record.name}">
                                        ${record.name || `Record ID: ${record.id}`}
                                    </label>
                                </div>`;
                            recordsContainer.insertAdjacentHTML('beforeend', checkbox);
                        });
                    } else {
                        recordsContainer.innerHTML = '<p>No matching records found.</p>';
                    }
                })
                .catch(error => console.error('Error searching records:', error));
            }

            // Event Listeners
            tableSelector.addEventListener('change', () => {
                const table = tableSelector.value;
                if (table) {
                    universalRefreshRecordList(table);
                } else {
                    recordsContainer.innerHTML = '<p>Select a table to load records.</p>';
                }
            });

            searchField.addEventListener('input', () => {
                const table = tableSelector.value;
                const searchValue = searchField.value;

                if (table) {
                    if (searchValue.length >= 2) {
                        universalSearchRecords(table, searchValue);
                    } else {
                        universalRefreshRecordList(table);
                    }
                }
            });
        });
    </script>
    <?php
}

// Hook for enqueueing the script
add_action('wp_footer', 'jotunheim_enqueue_universal_ui_scripts');
jotunheim_register_universal_editor_shortcode();
jotunheim_register_universal_add_shortcode();
?>