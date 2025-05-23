<?php
// File: eventzones-editor-scripts.php

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'eventzones-editor-interface.php';

if (!function_exists('eventzones_editor_shortcode')) {
    function eventzones_editor_shortcode() {
        ob_start();
        eventzones_editor_interface();
        return ob_get_clean();
    }
    add_shortcode('eventzones_editor', 'eventzones_editor_shortcode');
}

if (!function_exists('eventzones_add_new_zone_shortcode')) {
    function eventzones_add_new_zone_shortcode() {
        ob_start();
        jotunheim_magic_add_new_zone_interface();
        return ob_get_clean();
    }
    add_shortcode('eventzones_add_new_zone', 'eventzones_add_new_zone_shortcode');
}

function enqueue_eventzones_editor_scripts() {
    ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
            const apiBase = "/wp-json/jotunheim-magic/v1/eventzones";
            const apiKey = "<?php echo EVENTZONES_API_KEY; ?>";

            // Search functionality with call to external refreshZoneList() in interface file
            document.getElementById('eventzones-search').addEventListener('input', function () {
                const searchValue = this.value;
                if (searchValue.length >= 2) {
                    searchEventZones(searchValue);
                } else {
                    refreshZoneList();  // Calls refreshZoneList() from the interface file
                }
            });

            // Load selected zones and display their details
            document.getElementById('load-zone-btn').addEventListener('click', function () {
                const selectedZones = Array.from(document.querySelectorAll('.zone-selection-checkbox:checked')).map(checkbox => checkbox.dataset.id);
                if (selectedZones.length > 0) {
                    document.getElementById('edit-sections-container').innerHTML = '';
                    selectedZones.forEach(zoneId => fetchEventZoneDetails(zoneId));
                }
            });

            // Save the modified zone details
            document.getElementById('save-zone-btn').addEventListener('click', function () {
                const zonesData = Array.from(document.querySelectorAll('.zone-details-form')).map(form => {
                    const formData = {};

                    Array.from(form.elements).forEach(input => {
                        if (input.name) {
                            formData[input.name] = input.type === 'checkbox' ? (input.checked ? 1 : 0) : input.value;
                        }
                    });

                    formData.id = form.dataset.zoneId;
                    return formData;
                });

                saveEventZoneDetails(zonesData);
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'enqueue_eventzones_editor_scripts');
?>