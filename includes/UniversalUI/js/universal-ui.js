jQuery(document).ready(function ($) {
    const apiKey = JotunheimEditor.apiKey;
    const apiEndpoints = JotunheimEditor.apiEndpoints;

    const tableSelector = $('#table-selector');
    const recordsContainer = $('#records-list-container');
    const formFieldsContainer = $('#form-fields-container');

    // Load records when a table is selected
    tableSelector.on('change', function () {
        const table = $(this).val();

        if (!table) {
            recordsContainer.html('<p>Select a table to load records.</p>');
            formFieldsContainer.html('<p>Select a record to load its fields.</p>');
            return;
        }

        fetchRecords(table);
    });

    function fetchRecords(table) {
        recordsContainer.html('<p>Loading records...</p>');

        $.ajax({
            url: apiEndpoints['list_records'].full_url,
            method: 'POST',
            headers: { 'X-API-KEY': apiKey },
            contentType: 'application/json',
            data: JSON.stringify({ table }),
            success: function (data) {
                recordsContainer.empty();
                if (data.length > 0) {
                    data.forEach(record => {
                        recordsContainer.append(`
                            <button class="record-btn" data-id="${record.id}" style="width: 100%; margin-bottom: 5px;">
                                ${record.name || `Record ID: ${record.id}`}
                            </button>
                        `);
                    });
                } else {
                    recordsContainer.html('<p>No records found.</p>');
                }
            }
        });
    }

    // Load record details
    recordsContainer.on('click', '.record-btn', function () {
        const recordId = $(this).data('id');
        const table = tableSelector.val();

        formFieldsContainer.html('<p>Loading record...</p>');

        $.ajax({
            url: apiEndpoints['get_record'].full_url,
            method: 'POST',
            headers: { 'X-API-KEY': apiKey },
            contentType: 'application/json',
            data: JSON.stringify({ table, id: recordId }),
            success: function (data) {
                formFieldsContainer.empty();
                for (const [key, value] of Object.entries(data)) {
                    formFieldsContainer.append(`
                        <div>
                            <label>${key.replace('_', ' ')}</label>
                            <input type="text" value="${value}" style="width: 100%; margin-bottom: 10px;">
                        </div>
                    `);
                }
            }
        });
    });
});