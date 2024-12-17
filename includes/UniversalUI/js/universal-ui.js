jQuery(document).ready(function ($) {
    const apiKey = JotunheimEditor.apiKey;
    const apiEndpoints = JSON.parse(JotunheimEditor.apiEndpoints);

    // DOM Elements
    const tableSelector = $('#table-selector');
    const recordsContainer = $('#records-list-container');
    const formContainer = $('#form-fields-container');
    const searchField = $('#record-search');
    const clearBtn = $('#clear-records-btn');
    const loadBtn = $('#load-records-btn');

    // Event: Table Selection Changes
    tableSelector.on('change', function () {
        const selectedTable = $(this).val();
        if (!selectedTable) {
            resetUI();
            return;
        }
        fetchRecords(selectedTable);
    });

    // Fetch Records for a Selected Table
    function fetchRecords(table) {
        recordsContainer.html('<p>Loading records...</p>');

        $.ajax({
            url: apiEndpoints['list_records'].full_url,
            method: 'POST',
            headers: { 'X-API-KEY': apiKey, 'Content-Type': 'application/json' },
            data: JSON.stringify({ table: table }),
            success: function (response) {
                recordsContainer.empty();
                if (response && response.length > 0) {
                    response.forEach(record => {
                        const recordButton = `
                            <button class="record-btn" data-id="${record.id}" style="width: 100%; margin-bottom: 5px; padding: 8px; background: #0073aa; color: #fff; border-radius: 5px; text-align: left;">
                                ${record.name || `Record ID: ${record.id}`}
                            </button>`;
                        recordsContainer.append(recordButton);
                    });
                } else {
                    recordsContainer.html('<p>No records found.</p>');
                }
            },
            error: function (err) {
                console.error('Error fetching records:', err);
                recordsContainer.html('<p>Failed to load records.</p>');
            }
        });
    }

    // Event: Record Click to Fetch Details
    recordsContainer.on('click', '.record-btn', function () {
        const recordId = $(this).data('id');
        const selectedTable = tableSelector.val();

        formContainer.html('<p>Loading record...</p>');

        $.ajax({
            url: apiEndpoints['get_record'].full_url,
            method: 'POST',
            headers: { 'X-API-KEY': apiKey, 'Content-Type': 'application/json' },
            data: JSON.stringify({ table: selectedTable, id: recordId }),
            success: function (response) {
                formContainer.empty();
                if (response && Object.keys(response).length > 0) {
                    for (const [key, value] of Object.entries(response)) {
                        formContainer.append(`
                            <div style="margin-bottom: 10px;">
                                <label style="font-weight: bold;">${key.replace('_', ' ')}:</label>
                                <input type="text" name="${key}" value="${value}" style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #666;">
                            </div>
                        `);
                    }
                } else {
                    formContainer.html('<p>No fields found for this record.</p>');
                }
            },
            error: function (err) {
                console.error('Error fetching record details:', err);
                formContainer.html('<p>Failed to load record details.</p>');
            }
        });
    });

    // Event: Clear Button
    clearBtn.on('click', function () {
        resetUI();
    });

    // Reset UI
    function resetUI() {
        recordsContainer.html('<p>No records loaded.</p>');
        formContainer.html('<p>Select a record to load its fields.</p>');
    }
});