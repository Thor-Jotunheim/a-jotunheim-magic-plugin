<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universal Editor</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: url('your-background-image.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        h1 {
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            color: #fff;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
        }

        select, input[type="text"], button {
            margin-top: 5px;
            padding: 8px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        select {
            width: 100%;
            max-width: 300px;
        }

        form {
            margin-top: 20px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            padding: 15px;
            border-radius: 5px;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
        }

        #form-fields > div {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Universal Editor</h1>
    
    <!-- Dropdown for table selection -->
    <label for="table-select">Select Table:</label>
    <select id="table-select">
        <option value="">-- Select a Table --</option>
    </select>

    <!-- Form for table data -->
    <form id="table-form">
        <div id="form-fields">
            <!-- Fields will be dynamically added here -->
        </div>
        <button type="submit">Save</button>
    </form>

    <script>
        $(document).ready(function () {
            // Fetch tables and populate dropdown
            $.post('universal-api.php', { action: 'get_tables' }, function (data) {
                const tableSelect = $('#table-select');
                data.forEach(table => {
                    tableSelect.append(`<option value="${table}">${table}</option>`);
                });
            });

            // Handle table selection
            $('#table-select').on('change', function () {
                const selectedTable = $(this).val();
                if (!selectedTable) {
                    $('#form-fields').html('');
                    return;
                }

                // Fetch table schema and generate fields
                $.post('universal-api.php', { action: 'get_table_schema', table: selectedTable }, function (schema) {
                    const formFields = $('#form-fields');
                    formFields.empty();

                    schema.forEach(column => {
                        const fieldHTML = `
                            <div>
                                <label for="${column.Field}">${column.Field} (${column.Type}):</label>
                                <input type="text" id="${column.Field}" name="${column.Field}" />
                            </div>
                        `;
                        formFields.append(fieldHTML);
                    });
                });
            });

            // Handle form submission
            $('#table-form').on('submit', function (e) {
                e.preventDefault();
                const formData = $(this).serialize();
                const selectedTable = $('#table-select').val();

                // Post data to save changes
                $.post(`universal-api.php?action=save&table=${selectedTable}`, formData, function (response) {
                    alert('Data saved successfully!');
                }).fail(function () {
                    alert('Error saving data.');
                });
            });
        });
    </script>
</body>
</html>
