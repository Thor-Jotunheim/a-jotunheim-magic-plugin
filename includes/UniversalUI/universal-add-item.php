<?php
// File: universal-add-item-interface.php

function jotunheim_magic_universal_add_item_interface() {
    global $wpdb;

    ob_start(); // Start output buffering

    // Fetch all tables in the database
    $tables = $wpdb->get_col("SHOW TABLES");

    ?>
    <div class="universal-edit-section" style="width: 100%; max-width: 1000px; margin: auto;">
        <h4>Select a Table</h4>
        <form id="universal-add-item-form" method="post" action="javascript:void(0);" style="display: block;">
            <!-- Table Selection -->
            <select id="table-selector" name="table_name" style="width: 100%; padding: 10px; margin-bottom: 20px;">
                <option value="">-- Select a Table --</option>
                <?php foreach ($tables as $table): ?>
                    <option value="<?php echo $table; ?>"><?php echo $table; ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Dynamic Fields Container -->
            <div id="form-fields-container">
                <p>Select a table to load its fields.</p>
            </div>

            <!-- Submit Button -->
            <button type="button" id="add-item-btn" style="padding: 10px; background-color: #0073aa; color: #fff; border: none; border-radius: 5px; cursor: pointer; width: 100%;" disabled>
                Add Item
            </button>
        </form>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            // Handle table selection
            $('#table-selector').change(function() {
                const selectedTable = $(this).val();

                if (selectedTable) {
                    $.ajax({
                        url: '/wp-json/jotunheim-magic/v1/get-columns',
                        method: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify({ table: selectedTable }),
                        success: function(response) {
                            const container = $('#form-fields-container');
                            container.empty();

                            response.columns.forEach(column => {
                                const field = createField(column);
                                container.append(field);
                            });

                            $('#add-item-btn').prop('disabled', false);
                        },
                        error: function(error) {
                            alert('Failed to fetch columns');
                            console.error(error);
                        }
                    });
                } else {
                    $('#form-fields-container').html('<p>Select a table to load its fields.</p>');
                    $('#add-item-btn').prop('disabled', true);
                }
            });

            // Submit form
            $('#add-item-btn').click(function() {
                const formData = $('#universal-add-item-form').serializeArray();
                const data = {};

                formData.forEach(item => {
                    data[item.name] = item.value || '0';
                });

                $.ajax({
                    url: '/wp-json/jotunheim-magic/v1/add-item',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: function(response) {
                        alert('Item added successfully');
                        location.reload();
                    },
                    error: function(error) {
                        alert('Failed to add item');
                        console.error(error);
                    }
                });
            });

            // Helper function to create fields dynamically
            function createField(column) {
                const fieldName = column.name;
                const fieldType = column.type;
                const isCheckbox = fieldType.includes('tinyint(1)');
                const inputType = isCheckbox ? 'checkbox' : 'text';

                return `<div class="field-row" style="margin-bottom: 10px;">
                    <label for="${fieldName}" style="display: block; font-weight: bold;">${fieldName}</label>
                    <input type="${inputType}" name="${fieldName}" id="${fieldName}" style="width: 100%; padding: 8px;">
                </div>`;
            }
        });
    </script>
    <?php

    return ob_get_clean(); // Return the content
}

// Shortcode to display the universal form
add_shortcode('jotunheim_universal_add_item', 'jotunheim_magic_universal_add_item_interface');