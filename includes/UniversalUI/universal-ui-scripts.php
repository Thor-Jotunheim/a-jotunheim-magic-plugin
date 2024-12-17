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
        "SELECT name, table_name, CONCAT(base_url, endpoint) AS full_url FROM jotun_api_endpoints WHERE enabled = 1",
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

        document.getElementById('load-record-btn').addEventListener('click', function () {
    const selectedRecords = Array.from(document.querySelectorAll('.record-selection-checkbox:checked')).map(checkbox => checkbox.dataset.id);
    const editContainer = document.getElementById('edit-sections-container');
    const table = document.getElementById('table-selector').value;

    if (selectedRecords.length === 0) {
        alert('Please select at least one record to load.');
        return;
    }

    editContainer.innerHTML = ''; // Clear existing content

    // Find the endpoint for fetching record details
    const endpointEntry = Object.values(apiEndpoints).find(entry => entry.table_name === table);
    if (!endpointEntry) {
        console.error(`No API endpoint mapped for table '${table}'`);
        return;
    }

    // Fetch details for each selected record
    selectedRecords.forEach(recordId => {
        fetch(`${endpointEntry.full_url}/${recordId}`, {
            headers: { 'X-API-KEY': apiKey }
        })
        .then(response => response.json())
        .then(record => {
            const formHtml = `
                <div style="margin-bottom: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background: #f9f9f9;">
                    <h4>Editing Record ID: ${record.id}</h4>
                    ${Object.keys(record).map(key => `
                        <label style="font-weight: bold;">${key.replace('_', ' ')}:</label>
                        <input type="text" value="${record[key]}" style="width: 100%; margin-bottom: 10px;">
                    `).join('')}
                </div>`;
            editContainer.insertAdjacentHTML('beforeend', formHtml);
        })
        .catch(error => console.error(`Error fetching details for record ID: ${recordId}`, error));
    });
});

document.getElementById('clear-record-btn').addEventListener('click', function () {
    // Uncheck all checkboxes
    document.querySelectorAll('.record-selection-checkbox').forEach(checkbox => checkbox.checked = false);

    // Clear the edit container
    document.getElementById('edit-sections-container').innerHTML = '';

    // Clear the search field
    document.getElementById('record-search').value = '';

    // Optionally refresh the list
    const table = document.getElementById('table-selector').value;
    if (table) {
        universalRefreshRecordList(table);
    }
});

        // Fetch and refresh the record list for a selected table
        function universalRefreshRecordList(table) {
            // Find the endpoint for the selected table
            const endpointEntry = Object.values(apiEndpoints).find(entry => entry.table_name === table);

            if (!endpointEntry) {
                console.error(`Error: No API endpoint found for table '${table}'`);
                recordsContainer.innerHTML = `<p>No API endpoint mapped for table: ${table}</p>`;
                return;
            }

            const fullUrl = endpointEntry.full_url; // Use the mapped API URL
            console.log(`Fetching records for table: ${table}`);
            console.log(`API URL: ${fullUrl}`);

            fetch(fullUrl, {
                method: 'GET',
                headers: {
                    'X-API-KEY': apiKey
                }
            })
            .then(response => response.json())
            .then(data => {
                recordsContainer.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(record => {
                        // Dynamically find the first string column as the name (fallback to ID)
                        data.forEach(record => {
                            let displayName;

                            // Table-specific logic for jotun_itemlist
                            if (table === 'jotun_itemlist') {
                                displayName = record.item_name || record.prefab_name || `Record ID: ${record.id}`;
                            } else {
                                // General dynamic detection for other tables
                                displayName = record.name || record.title || record.username || record.display_name || 
                                            record.activePlayerName || record._name || `Record ID: ${record.id}`;
                            }

                            const checkbox = `
                                <div>
                                    <label>
                                        <input type="checkbox" class="record-selection-checkbox" data-id="${record.id}" value="${displayName}">
                                        ${displayName}
                                    </label>
                                </div>`;
                            recordsContainer.insertAdjacentHTML('beforeend', checkbox);
                        });

                        const checkbox = `
                            <div>
                                <label>
                                    <input type="checkbox" class="record-selection-checkbox" data-id="${record.id}" value="${displayName}">
                                    ${displayName}
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
            // Find the endpoint for the selected table
            const endpointEntry = Object.values(apiEndpoints).find(entry => entry.table_name === table);

            if (!endpointEntry) {
                console.error(`Error: No API endpoint found for table '${table}'`);
                return;
            }

            const fullUrl = `${endpointEntry.full_url}?search=${encodeURIComponent(searchValue)}`;
            console.log(`Searching records for table: ${table}`);
            console.log(`API URL: ${fullUrl}`);

            fetch(fullUrl, {
                method: 'GET',
                headers: {
                    'X-API-KEY': apiKey
                }
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