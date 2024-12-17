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
function enqueue_universal_ui_scripts() {
    global $wpdb;

    // Fetch API endpoints dynamically
    $api_endpoints = $wpdb->get_results(
        "SELECT name, table_name, CONCAT(base_url, endpoint) AS full_url FROM jotun_api_endpoints WHERE enabled = 1",
        OBJECT_K
    );

    // Inline script logic
    ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            const apiKey = "<?php echo JOTUN_API_KEY; ?>";
            const apiEndpoints = <?php echo json_encode($api_endpoints); ?>;
            let checkedRecords = new Set();

            const tableSelector = document.getElementById('table-selector');
            const recordsContainer = document.getElementById('universal-editor-container');
            const editContainer = document.getElementById('edit-sections-container');
            const searchField = document.getElementById('record-search');

            // Function to refresh the list of records
            function universalRefreshRecordList(table) {
                const endpointEntry = Object.values(apiEndpoints).find(entry => entry.table_name === table);

                if (!endpointEntry) {
                    console.error(`No API endpoint mapped for table '${table}'`);
                    recordsContainer.innerHTML = `<p>No API endpoint mapped for table: <b>${table}</b></p>`;
                    return;
                }

                fetch(endpointEntry.full_url, {
                    headers: { 'X-API-KEY': apiKey }
                })
                .then(response => response.json())
                .then(data => {
                    recordsContainer.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(record => {
                            const recordName = record.name || record.prefab_name || record.item_name || record.activePlayerName || `Record ID: ${record.id}`;
                            const checkbox = `
                                <div>
                                    <label>
                                        <input type="checkbox" class="record-selection-checkbox" data-id="${record.id}" value="${recordName}">
                                        ${recordName}
                                    </label>
                                </div>`;
                            recordsContainer.insertAdjacentHTML('beforeend', checkbox);
                        });
                        universalTrackCheckedState();
                    } else {
                        recordsContainer.innerHTML = '<p>No records found for this table.</p>';
                    }
                })
                .catch(error => console.error('Error fetching records:', error));
            }

            // Function to load details for selected records
            function universalLoadRecordDetails(table) {
                const selectedRecords = Array.from(document.querySelectorAll('.record-selection-checkbox:checked')).map(checkbox => checkbox.dataset.id);
                if (selectedRecords.length === 0) return;

                editContainer.innerHTML = '';
                const endpointEntry = Object.values(apiEndpoints).find(entry => entry.table_name === table);

                if (!endpointEntry) {
                    console.error(`No API endpoint mapped for table '${table}'`);
                    return;
                }

                selectedRecords.forEach(recordId => {
                    fetch(`${endpointEntry.full_url}/${recordId}`, {
                        headers: { 'X-API-KEY': apiKey }
                    })
                    .then(response => response.json())
                    .then(record => {
                        if (record) {
                            const formHtml = universalGenerateEditForm(record);
                            editContainer.insertAdjacentHTML('beforeend', formHtml);
                        } else {
                            console.error(`No data returned for record ID: ${recordId}`);
                        }
                    })
                    .catch(error => console.error('Error fetching record details:', error));
                });
            }

            // Function to clear selected records
            function universalClearRecords() {
                document.querySelectorAll('.record-selection-checkbox').forEach(checkbox => checkbox.checked = false);
                checkedRecords.clear();
                searchField.value = '';
                editContainer.innerHTML = '';
                recordsContainer.innerHTML = '<p>Cleared selection. Refresh to load records.</p>';
            }

            // Track checkbox states
            function universalTrackCheckedState() {
                document.querySelectorAll('.record-selection-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', () => {
                        if (checkbox.checked) {
                            checkedRecords.add(checkbox.dataset.id);
                        } else {
                            checkedRecords.delete(checkbox.dataset.id);
                        }
                    });
                });
            }

            // Attach event listeners
            tableSelector.addEventListener('change', () => {
                const selectedTable = tableSelector.value;
                if (selectedTable) {
                    universalRefreshRecordList(selectedTable);
                }
            });

            document.getElementById('load-zone-btn').addEventListener('click', () => {
                const selectedTable = tableSelector.value;
                if (selectedTable) universalLoadRecordDetails(selectedTable);
            });

            document.getElementById('clear-zone-btn').addEventListener('click', () => {
                universalClearRecords();
            });

            searchField.addEventListener('input', () => {
                const searchValue = searchField.value;
                const selectedTable = tableSelector.value;

                if (searchValue.length >= 2 && selectedTable) {
                    universalSearchRecords(selectedTable, searchValue);
                } else if (selectedTable) {
                    universalRefreshRecordList(selectedTable);
                }
            });
        });

        // Function to generate edit form (simplified version)
        function universalGenerateEditForm(record) {
            let formHtml = `<div class="single-edit-section" style="margin-bottom: 40px;">
                                <h4>Editing: ${record.name || `Record ID: ${record.id}`}</h4>
                                <form>`;
            Object.keys(record).forEach(key => {
                formHtml += `
                    <div style="margin-bottom: 10px;">
                        <label style="font-weight: bold;">${key.replace('_', ' ')}:</label>
                        <input type="text" value="${record[key]}" style="width: 100%; padding: 5px;">
                    </div>`;
            });
            formHtml += `</form></div>`;
            return formHtml;
        }
    </script>
    <?php
}
add_action('admin_footer', 'enqueue_universal_ui_scripts');
jotunheim_register_universal_editor_shortcode();
jotunheim_register_universal_add_shortcode();
?>