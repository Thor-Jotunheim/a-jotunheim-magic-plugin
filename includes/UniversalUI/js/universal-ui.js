jQuery(document).ready(function ($) {
    // Fetch tables dynamically
    function fetchTables(callback) {
        $.ajax({
            url: JotunheimAPI.root + 'get-tables',
            method: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-Nonce', JotunheimAPI.nonce);
            },
            success: function (response) {
                if (response.success && response.data.tables) {
                    callback(response.data.tables);
                } else {
                    alert('Failed to fetch tables.');
                }
            },
            error: function (err) {
                console.error('Error fetching tables:', err);
            }
        });
    }

    // Populate table selector
    $('#table-selector').on('change', function () {
        const selectedTable = $(this).val();
        if (selectedTable) {
            fetchRecords(selectedTable);
        }
    });

    // Fetch records dynamically
    function fetchRecords(table) {
        $.ajax({
            url: JotunheimAPI.root + 'get-records',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ table }),
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-Nonce', JotunheimAPI.nonce);
            },
            success: function (response) {
                const recordsContainer = $('#records-list-container');
                recordsContainer.empty();
                if (response.success && response.data.records.length > 0) {
                    response.data.records.forEach(record => {
                        recordsContainer.append(
                            `<div class="record-row" data-id="${record.id}" style="cursor: pointer;">
                                ${record.name || `Record ${record.id}`}
                            </div>`
                        );
                    });
                } else {
                    recordsContainer.html('<p>No records found for this table.</p>');
                }
            },
            error: function (err) {
                console.error('Error fetching records:', err);
            }
        });
    }

    // Fetch record details dynamically
    $('#records-list-container').on('click', '.record-row', function () {
        const recordId = $(this).data('id');
        const table = $('#table-selector').val();

        if (recordId) {
            $.ajax({
                url: JotunheimAPI.root + 'get-record',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ table, id: recordId }),
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-WP-Nonce', JotunheimAPI.nonce);
                },
                success: function (response) {
                    const formFieldsContainer = $('#form-fields-container');
                    formFieldsContainer.empty();
                    if (response.success && response.data.record) {
                        for (const [key, value] of Object.entries(response.data.record)) {
                            formFieldsContainer.append(
                                `<div class="field-row">
                                    <label for="${key}">${key}:</label>
                                    <input type="text" id="${key}" name="${key}" value="${value}">
                                </div>`
                            );
                        }
                        $('#update-item-btn, #delete-item-btn').prop('disabled', false);
                    } else {
                        formFieldsContainer.html('<p>No fields found for this record.</p>');
                        $('#update-item-btn, #delete-item-btn').prop('disabled', true);
                    }
                },
                error: function (err) {
                    console.error('Error fetching record details:', err);
                }
            });
        }
    });

    // Update record
    $('#update-item-btn').on('click', function () {
        const table = $('#table-selector').val();
        const recordId = $('#form-fields-container input[name="id"]').val();
        const formData = $('#universal-editor-form').serializeArray();
        const recordData = { id: recordId };

        formData.forEach(field => {
            recordData[field.name] = field.value;
        });

        $.ajax({
            url: JotunheimAPI.root + 'update-record',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ table, record: recordData }),
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-Nonce', JotunheimAPI.nonce);
            },
            success: function (response) {
                if (response.success) {
                    alert('Record updated successfully.');
                    fetchRecords(table);
                } else {
                    alert('Failed to update record.');
                }
            },
            error: function (err) {
                console.error('Error updating record:', err);
            }
        });
    });

    // Delete record
    $('#delete-item-btn').on('click', function () {
        const table = $('#table-selector').val();
        const recordId = $('#form-fields-container input[name="id"]').val();

        if (confirm('Are you sure you want to delete this record?')) {
            $.ajax({
                url: JotunheimAPI.root + 'delete-record',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ table, id: recordId }),
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-WP-Nonce', JotunheimAPI.nonce);
                },
                success: function (response) {
                    if (response.success) {
                        alert('Record deleted successfully.');
                        fetchRecords(table);
                        $('#form-fields-container').empty();
                        $('#update-item-btn, #delete-item-btn').prop('disabled', true);
                    } else {
                        alert('Failed to delete record.');
                    }
                },
                error: function (err) {
                    console.error('Error deleting record:', err);
                }
            });
        }
    });
});