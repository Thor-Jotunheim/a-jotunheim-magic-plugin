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
            const columns = Object.keys(record).map(key => ({ Field: key, Type: typeof record[key] }));
            const formHtml = universalGenerateEditForm(record, columns);
            editContainer.insertAdjacentHTML('beforeend', formHtml);
            universalInitializeFieldBehavior();
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

        function universalGenerateEditForm(record, columns) {
            const booleanFields = [
                'forcePvp', 'godMode', 'ghostMode', 'iceZone', 'noItemLoss', 'noStatLoss', 
                'noStatGain', 'disableDrops', 'noBuild', 'noShipDamage', 'onlyLeaveViaTeleport', 
                'respawnOnCorpse', 'respawnAtLocation', 'allowSignUse', 'allowItemStandUse', 
                'allowShipPlacement', 'allowCartPlacement', 'invisiblePlayers'
            ];

            let formHtml = `<div class="single-edit-section" style="margin-bottom: 40px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background: rgba(255, 255, 255, 0.8);">
                                <h4>Editing: ${record.name || ''}</h4>
                                <form class="record-details-form" data-record-id="${record.id}">`;

            columns.forEach(column => {
                const field_name = column.Field;

                if (['id', 'string_name'].includes(field_name)) return;  // Skip ID and string_name fields

                formHtml += `<div class='field-row' style='display: flex; align-items: center; margin-bottom: 10px;' data-field='${field_name}'>
                                <label for='${field_name}' style='flex: 1; font-weight: bold;'>${capitalizeFirstLetter(field_name.replace('_', ' '))}:</label>
                                <div style='flex: 2;'>`;

                // Handle dropdowns for specific fields
                if (field_name === 'shape') {
                    formHtml += `<select id='${field_name}' name='${field_name}' style='padding: 10px; border-radius: 5px; border: 2px solid #666; width: 100%;'>
                                    <option value='Circle' ${record[field_name] === 'Circle' ? 'selected' : ''}>Circle</option>
                                    <option value='Square' ${record[field_name] === 'Square' ? 'selected' : ''}>Square</option>
                                </select>`;
                } else if (field_name === 'eventzone_status') {
                    formHtml += `<select id='${field_name}' name='${field_name}' style='padding: 10px; border-radius: 5px; border: 2px solid #666; width: 100%;'>
                                    <option value='enabled' ${record[field_name] === 'enabled' ? 'selected' : ''}>Enabled</option>
                                    <option value='disabled' ${record[field_name] === 'disabled' ? 'selected' : ''}>Disabled</option>
                                </select>`;
                } else if (booleanFields.includes(field_name)) {
                    const isChecked = record[field_name] == 1;
                    formHtml += `<input type="hidden" name="${field_name}" value="0">
                                <input type="checkbox" name="${field_name}" ${isChecked ? 'checked' : ''} value="1" style="transform: scale(1.5); margin-top: 5px;">`;
                } else {
                    // Default to text input for other fields
                    formHtml += `<input type='text' id='${field_name}' name='${field_name}' value='${record[field_name] || ''}' style='padding: 10px; border-radius: 5px; border: 2px solid #666; width: 100%;'>`;
                }

                formHtml += `</div></div>`;
            });

            formHtml += `</form></div>`;
            return formHtml;
        }

        function universalCapitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        function universalInitializeFieldBehavior() {
            $('[data-field="squareXRadius"], [data-field="squareZRadius"]').hide();
            $('[data-field="respawnLocation"]').hide();

            // Handling the shape selection change to show/hide square radius fields
            $('.record-details-form').each(function () {
                const form = $(this);
                const shapeField = form.find('#shape');
                const isSquare = shapeField.val() === 'Square';
                form.find('[data-field="squareXRadius"], [data-field="squareZRadius"]').toggle(isSquare);

                // Show respawnLocation if respawnAtLocation or onlyLeaveViaTeleport is checked when form loads
                const respawnAtLocationChecked = form.find('[name="respawnAtLocation"]').is(':checked');
                const onlyLeaveViaTeleportChecked = form.find('[name="onlyLeaveViaTeleport"]').is(':checked');

                if (respawnAtLocationChecked || onlyLeaveViaTeleportChecked) {
                    form.find('[data-field="respawnLocation"]').show();
                }
            });

            // Event listener for shape selection
            $('.record-details-form').on('change', '#shape', function () {
                const form = $(this).closest('.record-details-form');
                const isSquare = $(this).val() === 'Square';
                form.find('[data-field="squareXRadius"], [data-field="squareZRadius"]').toggle(isSquare);
            });

            // Event listener for respawn and teleport checkboxes
            $('.record-details-form').on('change', '[name="respawnAtLocation"], [name="onlyLeaveViaTeleport"]', function () {
                const form = $(this).closest('.record-details-form');
                const respawnAtLocationChecked = form.find('[name="respawnAtLocation"]').is(':checked');
                const onlyLeaveViaTeleportChecked = form.find('[name="onlyLeaveViaTeleport"]').is(':checked');

                if (respawnAtLocationChecked || onlyLeaveViaTeleportChecked) {
                    form.find('[data-field="respawnLocation"]').show();
                } else {
                    form.find('[data-field="respawnLocation"]').hide();
                    form.find('[data-field="respawnLocation"] input').val('');
                }
            });
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