<?php
// Register shortcode for Universal Editor UI
function universal_editor_ui_shortcode() {
    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Universal Editor UI</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }

            .container {
                display: flex;
                flex-direction: row;
                height: 100vh;
            }

            .list-container {
                width: 30%;
                background-color: #fff;
                border-right: 1px solid #ccc;
                overflow-y: auto;
            }

            .list-container ul {
                list-style-type: none;
                padding: 0;
                margin: 0;
            }

            .list-container li {
                padding: 10px;
                border-bottom: 1px solid #eee;
                cursor: pointer;
            }

            .list-container li:hover {
                background-color: #f0f0f0;
            }

            .editor-container {
                flex-grow: 1;
                padding: 20px;
                overflow-y: auto;
            }

            form {
                background-color: #fff;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            form div {
                margin-bottom: 15px;
            }

            form label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
            }

            form input, form select {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            button {
                padding: 10px 20px;
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            button:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="list-container">
                <ul id="record-list">
                    <!-- Dynamic list of records -->
                </ul>
            </div>
            <div class="editor-container">
                <form id="editor-form">
                    <div id="form-fields">
                        <!-- Dynamic form fields -->
                    </div>
                    <button type="submit">Save</button>
                    <button type="button" id="delete-record">Delete</button>
                </form>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                const tableName = "your_table_name_here"; // Replace dynamically based on selected table

                // Load records into the list
                function loadRecords() {
                    $.post('universal-api.php', { action: 'list_records', table: tableName }, function (data) {
                        const list = $('#record-list');
                        list.empty();
                        data.forEach(record => {
                            list.append(`<li data-id="${record.id}">${record.name || 'Record ' + record.id}</li>`);
                        });
                    });
                }

                // Load record details into the form
                $('#record-list').on('click', 'li', function () {
                    const recordId = $(this).data('id');
                    $.post('universal-api.php', { action: 'get_record', table: tableName, id: recordId }, function (data) {
                        const formFields = $('#form-fields');
                        formFields.empty();
                        for (const key in data) {
                            formFields.append(`
                                <div>
                                    <label for="${key}">${key}</label>
                                    <input type="text" id="${key}" name="${key}" value="${data[key]}" />
                                </div>
                            `);
                        }
                    });
                });

                // Save the record
                $('#editor-form').on('submit', function (e) {
                    e.preventDefault();
                    const formData = $(this).serialize();
                    $.post('universal-api.php?action=update_record&table=' + tableName, formData, function (response) {
                        alert(response.message);
                        loadRecords();
                    });
                });

                // Delete the record
                $('#delete-record').on('click', function () {
                    const recordId = $('#form-fields input[name="id"]').val();
                    if (confirm('Are you sure you want to delete this record?')) {
                        $.post('universal-api.php?action=delete_record&table=' + tableName, { id: recordId }, function (response) {
                            alert(response.message);
                            loadRecords();
                            $('#form-fields').empty();
                        });
                    }
                });

                // Initial load
                loadRecords();
            });
        </script>
    </body>
    </html>
    <?php
    return ob_get_clean();
}
add_shortcode('universal_editor_ui', 'universal_editor_ui_shortcode');
?>