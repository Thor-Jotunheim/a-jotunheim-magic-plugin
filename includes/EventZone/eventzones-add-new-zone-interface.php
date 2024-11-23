<?php
if (!defined('ABSPATH')) exit;

// Hook to initialize user and API key handling after WordPress is ready
add_action('init', function() {
    global $wpdb, $api_key;
    $current_user = wp_get_current_user();
    
    if ($current_user && $current_user->ID) {
        $user_data = $wpdb->get_row($wpdb->prepare(
            "SELECT api_key FROM jotun_user_api_keys WHERE user_id = %d",
            $current_user->ID
        ));
        $api_key = $user_data ? $user_data->api_key : '';
    } else {
        $api_key = '';
    }
    
});

// Prepare the API key for use in JavaScript
$apiKey = esc_js($api_key);

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

    if (!$columns) {
        error_log("Failed to fetch columns for table: $table_name");
        $columns = []; // Default to an empty array
    }

    ob_start(); // Start output buffering
    ?>
    <div class="single-edit-section" style="width: 100%; max-width: 1000px; margin: auto; background: url('https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.bhmpics.com%2Fdownloads%2FValheim-Wallpapers%2F77.3-mistlands-teaser-1bb74b243f7219098476.jpg&f=1&nofb=1&ipt=45065e8b7cc5ca3ae8824364501250a2b5b4cf1428e93cd817bd8671ce697ec2&ipo=images') no-repeat fixed center; background-size: cover; padding: 5px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); overflow: hidden; display: flex; gap: 20px; height: auto; min-height: calc(110vh - 50px);">
        <div style="flex: 1; background: rgba(255, 255, 255, 0.8); padding: 10px; border-radius: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);">
            <h4 style="font-family: 'Roboto', sans-serif; font-weight: 700; color: #444;">Adding New Event Zone</h4>
            <form id="add-new-zone-form" method="post" action="javascript:void(0);" style="display: block;">

                <?php foreach ($columns as $column) :
                    $field_name = $column->Field;
                    $field_type = $column->Type;

                    // Skip 'id' field as it's usually the primary key and auto-incremented
                    if ($field_name == 'id') continue;

                    echo "<div class='field-row' style='display: flex; align-items: center; margin-bottom: 10px;' data-field='$field_name'>";
                    echo "<label for='$field_name' style='flex: 1; font-weight: bold;'>".ucfirst(str_replace('_', ' ', $field_name)).":</label>";
                    echo "<div style='flex: 2;'>";

                    if ($field_name == 'shape') {
                        echo "<select id='$field_name' name='$field_name' style='padding: 10px; border-radius: 5px; border: 2px solid #666; width: 100%;'>
                                <option value='Circle'>Circle</option>
                                <option value='Square'>Square</option>
                              </select>";
                    } elseif (strpos($field_type, 'tinyint(1)') !== false) {
                        echo "<input type='checkbox' id='$field_name' name='$field_name' style='transform: scale(1.2); margin-top: 5px;' value='1'>";
                    } elseif ($field_name == 'eventzone_status') {
                        echo "<select id='$field_name' name='$field_name' style='padding: 10px; border-radius: 5px; border: 2px solid #666; width: 100%;'>
                                <option value='enabled'>Enabled</option>
                                <option value='disabled'>Disabled</option>
                              </select>";
                    } elseif ($field_name == 'zone_type') {
                        echo "<select id='$field_name' name='$field_name' style='padding: 10px; border-radius: 5px; border: 2px solid #666; width: 100%;'>
                                <option value='Server Infrastructure'>Server Infrastructure</option>
                                <option value='Quest'>Quest</option>
                                <option value='Event'>Event</option>
                                <option value='Boss Power'>Boss Power</option>
                                <option value='Boss Fight'>Boss Fight</option>
                                <option value='NPC'>NPC</option>
                              </select>";
                    } else {
                        echo "<input type='text' id='$field_name' name='$field_name' style='padding: 10px; border-radius: 5px; border: 2px solid #666; width: 100%;'>";
                    }

                    echo "</div></div>";
                endforeach; ?>

                <button type="button" id="add-zone-btn" style="padding: 10px; background-color: #0073aa; color: #fff; border: none; border-radius: 5px; cursor: pointer; width: 100%;">
                    Add Zone
                </button>
            </form>
        </div>    
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            const apiKey = "<?php echo $apiKey; ?>"; // Use prepared API key
            if (!apiKey) {
                console.error("API key is missing or invalid.");
                return;
            }

            $('#add-zone-btn').click(function() {
                const formData = new FormData($('#add-new-zone-form')[0]);
                const data = {};

                for (const [key, value] of formData.entries()) {
                    data[key] = value || '0'; // Default unchecked checkboxes to '0'
                }

                fetch('/wp-json/jotunheim-magic/v1/eventzones', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-API-KEY': apiKey
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    alert('Zone added successfully');
                    location.reload();
                })
                .catch(error => {
                    alert('Failed to add zone');
                    console.error(error);
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
