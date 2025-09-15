<?php
// File: eventzones-add-new-zone-interface.php

function jotunheim_magic_add_new_zone_interface() {
    global $wpdb;
    $table_name = 'jotun_eventzones';

    // Check if table exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        echo '<p>Event zones table not found. Please check your database setup.</p>';
        return;
    }

    // Fetch columns from the event zones table
    $columns = $wpdb->get_results("DESCRIBE $table_name");

    ob_start(); // Start output buffering
    ?>
    <div class="single-edit-section" style="width: 100%; max-width: 1000px; margin: auto; background: url('https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.bhmpics.com%2Fdownloads%2FValheim-Wallpapers%2F77.3-mistlands-teaser-1bb74b243f7219098476.jpg&f=1&nofb=1&ipt=45065e8b7cc5ca3ae8824364501250a2b5b4cf1428e93cd817bd8671ce697ec2&ipo=images') no-repeat fixed center; background-size: cover; padding: 5px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); overflow: hidden; display: flex; gap: 20px; height: auto; min-height: calc(110vh - 50px);">
        <div style="flex: 1; background: rgba(255, 255, 255, 0.8); padding: 10px; border-radius: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);">
            <h4 style="font-family: 'Roboto', sans-serif; font-weight: 700; color: #444;">Adding New Event Zone</h4>
            <form id="add-new-zone-form" method="post" action="javascript:void(0);" style="display: block;">

                <?php 
                // Use the field generator to create form fields
                echo EventZoneFieldGenerator::generateFormFields($columns);
                ?>

                <!-- Submit Button -->
                <button type="button" id="add-zone-btn" style="padding: 10px; background-color: #0073aa; color: #fff; border: none; border-radius: 5px; cursor: pointer; width: 100%;">
                    Add Zone
                </button>
            </form>
        </div>    
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            <?php echo EventZoneFieldGenerator::generateConditionalFieldsJS(); ?>

            // AJAX call to add new event zone with proper checkbox values
            $('#add-zone-btn').click(function() {
                const formData = $('#add-new-zone-form').serializeArray();
                const data = {};

                // Convert form data to key-value pairs, setting checkboxes to 0 if unchecked
                formData.forEach(item => {
                    data[item.name] = item.value || '0'; // Default unchecked checkboxes to '0'
                });

                // Add unchecked checkboxes explicitly with a value of 0
                $('#add-new-zone-form input[type="checkbox"]').each(function() {
                    if (!$(this).is(':checked')) {
                        data[$(this).attr('name')] = '0';
                    }
                });

                $.ajax({
                    url: '/wp-json/jotunheim-magic/v1/eventzones',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    headers: {
                        'X-API-KEY': "<?php echo EVENTZONES_API_KEY; ?>"
                    },
                    success: function(response) {
                        alert('Zone added successfully');
                        location.reload();
                    },
                    error: function(error) {
                        alert('Failed to add zone');
                        console.error(error);
                    }
                });
            });
        });
    </script>
    <?php
    return ob_get_clean(); // Return the content
}

// Shortcode to display the "Add New Zone" form
add_shortcode('jotunheim_add_new_zone', 'jotunheim_magic_add_new_zone_interface');
?>