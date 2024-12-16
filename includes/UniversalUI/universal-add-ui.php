<?php
// File: universal-add-item.php

function jotunheim_magic_universal_add_item_interface() {
    global $wpdb;

    // Fetch tables starting with jotun_
    $tables = $wpdb->get_col("SHOW TABLES LIKE 'jotun_%'");

    ob_start(); // Start output buffering
    ?>
    <div class="universal-edit-section" style="width: 100%; max-width: 1000px; margin: auto; background: url('https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.bhmpics.com%2Fdownloads%2FValheim-Wallpapers%2F77.3-mistlands-teaser-1bb74b243f7219098476.jpg&f=1&nofb=1&ipt=45065e8b7cc5ca3ae8824364501250a2b5b4cf1428e93cd817bd8671ce697ec2&ipo=images') no-repeat fixed center; background-size: cover; padding: 5px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); overflow: hidden; display: flex; gap: 20px; height: auto; min-height: calc(110vh - 50px);">
        <div style="flex: 1; background: rgba(255, 255, 255, 0.8); padding: 10px; border-radius: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);">
            <h4 style="font-family: 'Roboto', sans-serif; font-weight: 700; color: #444;">Add Item to Table</h4>
            <form id="universal-add-item-form" method="post" action="javascript:void(0);" style="display: block;">
                <!-- Table Selection -->
                <div class="field-row" style="margin-bottom: 20px;">
                    <label for="table-selector" style="font-weight: bold; font-size: 16px;">Select Table:</label>
                    <select id="table-selector" name="table_name" style="padding: 10px; border-radius: 5px; border: 2px solid #666; width: 100%; margin-top: 5px;">
                        <option value="">-- Select a Table --</option>
                        <?php foreach ($tables as $table): ?>
                            <option value="<?php echo esc_attr($table); ?>"><?php echo esc_html($table); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

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
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            // Fetch columns dynamically when a table is selected
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

                            if (response.columns && response.columns.length > 0) {
                                response.columns.forEach(column => {
                                    const field = createField(column);
                                    container.append(field);
                                });

                                $('#add-item-btn').prop('disabled', false);
                            } else {
                                container.html('<p>No fields found for this table.</p>');
                                $('#add-item-btn').prop('disabled', true);
                            }
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

            // Submit form dynamically via AJAX
            $('#add-item-btn').click(function() {
                const formData = $('#universal-add-item-form').serializeArray();
                const data = {};

                formData.forEach(item => {
                    data[item.name] = item.value || '0'; // Default unchecked checkboxes to '0'
                });

                // Include unchecked checkboxes explicitly with a value of 0
                $('#universal-add-item-form input[type="checkbox"]').each(function() {
                    if (!$(this).is(':checked')) {
                        data[$(this).attr('name')] = '0';
                    }
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

            // Helper function to create dynamic input fields
            function createField(column) {
                const fieldName = column.Field;
                const fieldType = column.Type;
                const isCheckbox = fieldType.includes('tinyint(1)');
                const inputType = isCheckbox ? 'checkbox' : 'text';

                return `<div class="field-row" style="margin-bottom: 10px;">
                    <label for="${fieldName}" style="font-weight: bold; display: block;">${ucfirst(fieldName.replace('_', ' '))}:</label>
                    <input type="${inputType}" id="${fieldName}" name="${fieldName}" style="padding: 10px; border-radius: 5px; border: 2px solid #666; width: 100%;">
                </div>`;
            }
        });
    </script>
    <?php
    return ob_get_clean(); // Return the content
}

// Shortcode to display the universal form
add_shortcode('magic_universal_add_ui', 'jotunheim_magic_universal_add_item_interface');
?>