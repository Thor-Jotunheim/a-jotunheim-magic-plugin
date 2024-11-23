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
?>

<?php
function eventzones_editor_interface() {
    $apiUrl = esc_url(rest_url('jotunheim-magic/v1/eventzones'));
    $apiKey = esc_js($api_key);
    ?>
    <div class="wrap eventzones-editor-container" id="eventzones-editor-container" style="width: 100%; max-width: 1000px; margin: auto; background: url('https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.bhmpics.com%2Fdownloads%2FValheim-Wallpapers%2F77.3-mistlands-teaser-1bb74b243f7219098476.jpg&f=1&nofb=1&ipt=45065e8b7cc5ca3ae8824364501250a2b5b4cf1428e93cd817bd8671ce697ec2&ipo=images') no-repeat fixed center; background-size: cover; padding: 5px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); overflow: hidden; display: flex; gap: 20px; height: auto; min-height: calc(110vh - 50px);">
        
        <div style="flex: 1; background: rgba(255, 255, 255, 0.8); padding: 10px; border-radius: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);">
            <h1 class="eventzones-title" style="font-family: 'MedievalSharp', cursive; font-size: 36px; color: #fff; text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7); text-align: center;">Jotunheim Event Zones Editor</h1>
            <div class="search-section" style="margin-bottom: 5px;">
                <input type="text" id="eventzones-search" placeholder="Search for an event zone..." style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666; font-size: 16px;">
                <button id="load-zone-btn" style="width: 100%; background: #444; color: #fff; padding: 12px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; margin-top: 10px;">Load Selected Zones</button>
                <button id="clear-zone-btn" style="width: 100%; background: #888; color: #fff; padding: 12px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; margin-top: 10px; margin-bottom: 10px;">Clear Selected</button>
                <div id="eventzones-container" style="height: auto; max-height: calc(90vh - 140px); overflow-y: auto; background: rgba(255, 255, 255, 0.9); padding: 10px; border-radius: 5px;">
                    <!-- Dynamically added checkboxes for event zones -->
                </div>
            </div>
        </div>

        <div style="flex: 2; overflow-y: auto; height: auto; min-height: calc(110vh - 50px);">
            <div id="edit-sections-container" class="edit-section" style="background: rgba(255, 255, 255, 0.7); padding: 10px; border-radius: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);">
                <h3 style="font-family: 'Roboto', sans-serif; font-weight: 700; color: #222; text-align: center;">Edit Zone Details</h3>
                <!-- Edit sections will be dynamically added here -->
            </div>
        </div>
    </div>

    <script type="text/javascript">
        const apiUrl = "<?php echo $apiUrl; ?>";
        const apiKey = "<?php echo $apiKey; ?>";
        let checkedZones = new Set();

        function trackCheckedState() {
            document.querySelectorAll('.zone-selection-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    if (checkbox.checked) {
                        checkedZones.add(checkbox.dataset.id);
                    } else {
                        checkedZones.delete(checkbox.dataset.id);
                    }
                });
            });
        }

    function restoreCheckedState() {
    document.querySelectorAll('.zone-selection-checkbox').forEach(checkbox => {
        checkbox.checked = checkedZones.has(checkbox.dataset.id);
    });
}
    
        function capitalizeEditorFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

function refreshZoneList() {
    fetch(apiUrl, {
        headers: { 'X-API-KEY': apiKey }
    })
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('eventzones-container');
        container.innerHTML = '';
        data.forEach(zone => {
            const checkbox = `<div><label><input type="checkbox" class="zone-selection-checkbox" data-id="${zone.id}" value="${zone.name}">${zone.name}</label></div>`;
            container.insertAdjacentHTML('beforeend', checkbox);
        });
        restoreCheckedState(); // Restore checked state
        trackCheckedState(); // Track changes
    })
    .catch(error => console.error('Error fetching zones:', error));
}

function searchEventZones(searchValue) {
    fetch(`${apiUrl}?search=${encodeURIComponent(searchValue)}`, {
        headers: { 'X-API-KEY': apiKey }
    })
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('eventzones-container');
        container.innerHTML = '';
        data.forEach(zone => {
            const checkbox = `<div><label><input type="checkbox" class="zone-selection-checkbox" data-id="${zone.id}" value="${zone.name}">${zone.name}</label></div>`;
            container.insertAdjacentHTML('beforeend', checkbox);
        });
        restoreCheckedState(); // Restore checked state
        trackCheckedState(); // Track changes
    })
    .catch(error => console.error('Error searching zones:', error));
}

function loadZoneDetails(zoneId) {
    // Clear out existing form before loading new details
    const editContainer = document.getElementById('edit-sections-container');
    editContainer.innerHTML = '';

    fetch(`${apiUrl}/${zoneId}`, {
        headers: { 'X-API-KEY': apiKey }
    })
    .then(response => response.json())
    .then(zone => {
        if (zone) {
            const columns = Object.keys(zone).map(field => ({
                Field: field,
                Type: typeof zone[field]
            }));
            // Ensure numeric values retain their precision
            for (let key in zone) {
                if (typeof zone[key] === 'number') {
                    zone[key] = parseFloat(zone[key].toFixed(2)); // Preserve 2 decimal places (adjust as needed)
                }
            }
            const formHtml = generateEditZoneForm(zone, columns);
            editContainer.insertAdjacentHTML('beforeend', formHtml);
            initializeConditionalFieldBehavior();
        } else {
            console.error("No data returned for zone ID:", zoneId);
        }
    })
    .catch(error => console.error('Error fetching zone details:', error));
}


        document.addEventListener('DOMContentLoaded', function () {
            refreshZoneList();

            // Search functionality
            document.getElementById('eventzones-search').addEventListener('input', function () {
                const searchValue = this.value;
                if (searchValue.length >= 2) {
                    searchEventZones(searchValue);
                } else {
                    refreshZoneList();
                }
            });
        });

document.addEventListener('DOMContentLoaded', function () {
    // Event listener for saving updated zone details
    document.getElementById('edit-sections-container').addEventListener('click', function (event) {
        if (event.target.classList.contains('save-zone-btn')) {
            const form = event.target.closest('.zone-details-form');
            const zoneId = form.dataset.zoneId;
            const formData = new FormData(form);
            const jsonData = {};

            formData.forEach((value, key) => {
                jsonData[key] = value;
            });

            // Make PUT request to update event zone
            fetch(`${apiUrl}/${zoneId}`, {
                method: 'PUT',
                headers: {
                    'X-API-KEY': apiKey,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(jsonData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'updated') {
                    alert('Event zone updated successfully');
                    form.parentElement.remove(); // Remove the form container from the DOM
                } else {
                    console.error('Error:', data);
                    alert('Failed to update event zone');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Event listener for deleting zone details
        if (event.target.classList.contains('delete-zone-btn')) {
            const form = event.target.closest('.zone-details-form');
            const zoneId = form.dataset.zoneId;
            const confirmDelete = form.querySelector('.confirm-delete-checkbox').checked;

            if (confirmDelete) {
                // Make DELETE request to delete event zone
                fetch(`${apiUrl}/${zoneId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-API-KEY': apiKey,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'deleted') {
                        alert(`Event zone ${zoneId} deleted successfully`);
                        form.parentElement.remove(); // Remove the form container from the DOM
                    } else {
                        console.error('Error:', data);
                        alert(`Failed to delete event zone ${zoneId}`);
                    }
                })
                .catch(error => {
                    console.error('Delete Request Error:', error);
                    alert('Failed to delete event zone. Please check the console for more details.');
                });
            } else {
                alert('Please confirm delete by checking the checkbox.');
            }
        }
    });
});

function generateEditZoneForm(zone, columns) {
    const booleanFields = ['forcePvp', 'godMode', 'ghostMode', 'iceZone', 'noItemLoss', 'noStatLoss', 'noStatGain', 'disableDrops', 'noBuild', 'noShipDamage', 'onlyLeaveViaTeleport', 'respawnOnCorpse', 'respawnAtLocation', 'allowSignUse', 'allowItemStandUse', 'allowShipPlacement', 'allowCartPlacement', 'invisiblePlayers'];
    let formHtml = `<div class="single-edit-section" style="margin-bottom: 40px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background: rgba(255, 255, 255, 0.8);">
                    <h4>Editing: ${zone.name || ''}</h4>
                    <form class="zone-details-form" data-zone-id="${zone.id}">`;

    columns.forEach(column => {
        const field_name = column.Field;

        if (field_name === 'id') return;

        formHtml += `<div class='field-row' style='display: flex; align-items: center; margin-bottom: 10px;' data-field='${field_name}'>
                        <label for='${field_name}' style='flex: 1; font-weight: bold;'>${capitalizeEditorFirstLetter(field_name.replace('_', ' '))}:</label>
                        <div style='flex: 2;'>`;

        // Handle dropdowns for specific fields
        if (field_name === 'shape') {
            formHtml += `<select id='${field_name}' name='${field_name}' style='padding: 10px; border-radius: 5px; border: 2px solid #666; width: 100%;'>
                            <option value='Circle' ${zone[field_name] === 'Circle' ? 'selected' : ''}>Circle</option>
                            <option value='Square' ${zone[field_name] === 'Square' ? 'selected' : ''}>Square</option>
                         </select>`;
        } else if (field_name === 'eventzone_status') {
            formHtml += `<select id='${field_name}' name='${field_name}' style='padding: 10px; border-radius: 5px; border: 2px solid #666; width: 100%;'>
                            <option value='enabled' ${zone[field_name] === 'enabled' ? 'selected' : ''}>Enabled</option>
                            <option value='disabled' ${zone[field_name] === 'disabled' ? 'selected' : ''}>Disabled</option>
                         </select>`;
        } else if (field_name === 'zone_type') {
            formHtml += `<select id='${field_name}' name='${field_name}' style='padding: 10px; border-radius: 5px; border: 2px solid #666; width: 100%;'>
                            <option value='Server Infrastructure' ${zone[field_name] === 'Server Infrastructure' ? 'selected' : ''}>Server Infrastructure</option>
                            <option value='Quest' ${zone[field_name] === 'Quest' ? 'selected' : ''}>Quest</option>
                            <option value='Event' ${zone[field_name] === 'Event' ? 'selected' : ''}>Event</option>
                            <option value='Boss Power' ${zone[field_name] === 'Boss Power' ? 'selected' : ''}>Boss Power</option>
                            <option value='Boss Fight' ${zone[field_name] === 'Boss Fight' ? 'selected' : ''}>Boss Fight</option>
                            <option value='NPC' ${zone[field_name] === 'NPC' ? 'selected' : ''}>NPC</option>
                         </select>`;
        } 
        // Handle boolean fields as checkboxes
        else if (booleanFields.includes(field_name)) {
            const isChecked = zone[field_name] == 1;
            const checkboxClass = field_name === 'respawnAtLocation' ? 'respawn-at-location' : 
                                  field_name === 'onlyLeaveViaTeleport' ? 'only-leave-via-teleport' : '';

            formHtml += `<input type="hidden" name="${field_name}" value="0">
                         <input type="checkbox" class="${checkboxClass}" name="${field_name}" ${isChecked ? 'checked' : ''} value="1" style="transform: scale(1.8); margin-top: 5px;">`;
        } 
        // Default to text input for other fields
        else {
            formHtml += `<input type='text' id='${field_name}' name='${field_name}' value='${zone[field_name] || ''}' style='padding: 10px; border-radius: 5px; border: 2px solid #666; width: 100%;'>`;
        }

        formHtml += `</div></div>`;
    });

    // Add the Save button
    formHtml += `<button type="button" class="save-zone-btn" style="padding: 10px; background-color: #0073aa; color: #fff; border: none; border-radius: 5px; cursor: pointer; width: 100%; margin-bottom: 10px;">Save Changes</button>`;

    // Add the Delete button and Confirm Delete checkbox
    formHtml += `<button type="button" class="delete-zone-btn" style="padding: 10px; background-color: #d9534f; color: #fff; border: none; border-radius: 5px; cursor: pointer; width: 100%; margin-top: 10px;">Delete Record</button>
                 <label style="display: block; margin-top: 10px; font-weight: bold;">
                    <input type="checkbox" class="confirm-delete-checkbox" style="margin-right: 10px; transform: scale(1.2);">
                    Confirm Delete
                 </label>`;
    
    formHtml += `</form></div>`;
    return formHtml;
}

        jQuery(document).ready(function ($) {
            refreshZoneList();

            // Search functionality
            $('#eventzones-search').on('input', function () {
                const searchValue = $(this).val();
                if (searchValue.length >= 2) {
                    $.post(ajaxurl, {
                        action: 'search_eventzones',
                        search_value: searchValue
                    }, function (response) {
                        if (response.success) {
                            $('#eventzones-container').empty();
                            response.data.forEach(function (zone) {
                                const checkbox = `<div><label style="display: flex; align-items: center;"><input type="checkbox" class="zone-checkbox" data-id="${zone.id}" value="${zone.name}" style="margin-right: 10px; transform: scale(1.8); cursor: pointer;">${zone.name}</label></div>`;
                                $('#eventzones-container').append(checkbox);
                            });
                        } else {
                            $('#eventzones-container').empty();
                        }
                    });
                } else {
                    refreshZoneList();
                }
            });

            $('#load-zone-btn').click(function () {
                const selectedZones = [];
                $('.zone-selection-checkbox:checked').each(function () {
                    selectedZones.push($(this).data('id'));
                });

                if (selectedZones.length > 0) {
                    $('#edit-sections-container').empty();

                    selectedZones.forEach(zone_id => {
                        fetch(`${apiUrl}/${zone_id}`, {
                            headers: { 'X-API-KEY': apiKey }
                        })
                        .then(response => response.json())
                        .then(zone => {
                            if (zone) {
                                const columns = Object.keys(zone).map(field => ({
                                    Field: field,
                                    Type: typeof zone[field]
                                }));

                                const formHtml = generateEditZoneForm(zone, columns);
                                $('#edit-sections-container').append(formHtml);

                                initializeConditionalFieldBehavior();
                            } else {
                                console.error("No data returned for zone ID:", zone_id);
                            }
                        })
                        .catch(error => console.error('Error fetching zone details:', error));
                    });
                }
            });

            function initializeConditionalFieldBehavior() {
                $('[data-field="squareXRadius"], [data-field="squareZRadius"]').hide();
                $('[data-field="respawnLocation"]').hide();

                // Handling the shape selection change to show/hide square radius fields
                $('.zone-details-form').each(function() {
                    const form = $(this);
                    const shapeField = form.find('#shape');
                    const isSquare = shapeField.val() === 'Square';
                    form.find('[data-field="squareXRadius"], [data-field="squareZRadius"]').toggle(isSquare);

                    // Show respawnLocation if respawnAtLocation is checked when form loads
                    const respawnAtLocationChecked = form.find('.respawn-at-location').is(':checked');
                    const onlyLeaveViaTeleportChecked = form.find('.only-leave-via-teleport').is(':checked');
                    if (respawnAtLocationChecked || onlyLeaveViaTeleportChecked) {
                        form.find('[data-field="respawnLocation"]').show();
                    }
                });

                $('.zone-details-form').on('change', '#shape', function() {
                    const form = $(this).closest('.zone-details-form');
                    const isSquare = $(this).val() === 'Square';
                    form.find('[data-field="squareXRadius"], [data-field="squareZRadius"]').toggle(isSquare);
                });

                // Event listener for changing "respawn-at-location" and "only-leave-via-teleport"
                $('.zone-details-form').on('change', '.respawn-at-location, .only-leave-via-teleport', function() {
                    const form = $(this).closest('.zone-details-form');
                    const respawnAtLocationChecked = form.find('.respawn-at-location').is(':checked');
                    const onlyLeaveViaTeleportChecked = form.find('.only-leave-via-teleport').is(':checked');

                    // Show the respawnLocation field if either checkbox is checked
                    if (onlyLeaveViaTeleportChecked || respawnAtLocationChecked) {
                        form.find('[data-field="respawnLocation"]').show();
                    } else {
                        form.find('[data-field="respawnLocation"]').hide();
                        // Only clear the value of respawnLocation field if both checkboxes are unchecked
                        if (!respawnAtLocationChecked && !onlyLeaveViaTeleportChecked) {
                            form.find('[data-field="respawnLocation"] input').val('');
                        }
                    }
                });
            }

            // Clear selected zones
$('#clear-zone-btn').click(function () {
    // Uncheck all checkboxes
    $('.zone-selection-checkbox').prop('checked', false);

    // Clear the Set that tracks checked checkboxes
    checkedZones.clear();

    // Clear search input
    $('#eventzones-search').val('');

    // Clear edit sections container
    $('#edit-sections-container').empty();

    // Refresh the zone list if necessary
    refreshZoneList();
});

        });
    </script>
    <?php
}
?>