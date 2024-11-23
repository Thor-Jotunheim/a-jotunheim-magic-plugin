<?php
function eventzones_editor_interface() {
    $apiUrl = esc_url(rest_url('jotunheim-magic/v1/eventzones'));
    $apiKey = EVENTZONES_API_KEY;
    ?>
    <div class="wrap eventzones-editor-container" id="eventzones-editor-container" style="width: 100%; max-width: 1000px; margin: auto; background: url('https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.bhmpics.com%2Fdownloads%2FValheim-Wallpapers%2F77.3-mistlands-teaser-1bb74b243f7219098476.jpg&f=1&nofb=1&ipt=45065e8b7cc5ca3ae8824364501250a2b5b4cf1428e93cd817bd8671ce697ec2&ipo=images') no-repeat fixed center; background-size: cover; padding: 5px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); overflow: hidden; display: flex; gap: 20px; height: auto; min-height: calc(100vh - 50px);">
        
        <div style="flex: 1; background: rgba(255, 255, 255, 0.8); padding: 10px; border-radius: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);">
            <h1 class="eventzones-title" style="font-family: 'MedievalSharp', cursive; font-size: 36px; color: #fff; text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7); text-align: center;">Jotunheim Event Zones Editor</h1>
            <div class="search-section" style="margin-bottom: 5px;">
                <input type="text" id="eventzones-search" placeholder="Search for an event zone..." style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666; margin-bottom: 10px; font-size: 16px;">
                <div id="eventzones-container" style="max-height: calc(100vh - 700px); overflow-y: auto; background: rgba(255, 255, 255, 0.9); padding: 10px; border-radius: 5px;">
                    <!-- Dynamically added checkboxes for event zones -->
                </div>
                <button id="load-zone-btn" style="width: 100%; background: #444; color: #fff; padding: 12px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; margin-top: 10px;">Load Selected Zones</button>
                <button id="clear-zone-btn" style="width: 100%; background: #888; color: #fff; padding: 12px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; margin-top: 10px;">Clear Selected</button>
            </div>
        </div>

        <div style="flex: 2; overflow-y: auto; max-height: calc(100vh - 50px);">
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

        function refreshZoneList() {
            fetch(apiUrl, {
                headers: { 'X-API-KEY': apiKey }
            })
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('eventzones-container');
                container.innerHTML = '';
                data.forEach(zone => {
                    const checkbox = <div><label><input type="checkbox" class="zone-selection-checkbox" data-id="${zone.id}" value="${zone.name}">${zone.name}</label></div>;
                    container.insertAdjacentHTML('beforeend', checkbox);
                });
                restoreCheckedState(); // Restore checked state
                trackCheckedState(); // Track changes
            })
            .catch(error => console.error('Error fetching zones:', error));
        }

        function searchEventZones(searchValue) {
            fetch(${apiUrl}?search=${encodeURIComponent(searchValue)}, {
                headers: { 'X-API-KEY': apiKey }
            })
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('eventzones-container');
                container.innerHTML = '';
                data.forEach(zone => {
                    const checkbox = <div><label><input type="checkbox" class="zone-selection-checkbox" data-id="${zone.id}" value="${zone.name}">${zone.name}</label></div>;
                    container.insertAdjacentHTML('beforeend', checkbox);
                });
                restoreCheckedState(); // Restore checked state
                trackCheckedState(); // Track changes
            })
            .catch(error => console.error('Error searching zones:', error));
        }

        function loadZoneDetails(zoneId) {
            const editContainer = document.getElementById('edit-sections-container');
            editContainer.innerHTML = '';

            fetch(${apiUrl}/${zoneId}, {
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

            document.getElementById('eventzones-search').addEventListener('input', function () {
                const searchValue = this.value;
                if (searchValue.length >= 2) {
                    searchEventZones(searchValue);
                } else {
                    refreshZoneList();
                }
            });
        });

        function generateEditZoneForm(zone, columns) {
            const booleanFields = ['forcePvp', 'godMode', 'ghostMode', 'iceZone', 'noItemLoss', 'noStatLoss', 'noStatGain', 'disableDrops', 'noBuild', 'noShipDamage', 'onlyLeaveViaTeleport', 'respawnOnCorpse', 'respawnAtLocation', 'allowSignUse'];
            let formHtml = <div class="single-edit-section" style="margin-bottom: 40px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background: rgba(255, 255, 255, 0.8);">
                            <h4>Editing: ${zone.name || ''}</h4>
                            <form class="zone-details-form" data-zone-id="${zone.id}">;

            columns.forEach(column => {
                const field_name = column.Field;

                if (field_name === 'id') return;

                formHtml += <div class='field-row' style='display: flex; align-items: center; margin-bottom: 10px;' data-field='${field_name}'>
                                <label for='${field_name}' style='flex: 1; font-weight: bold;'>${capitalizeEditorFirstLetter(field_name.replace('_', ' '))}:</label>
                                <div style='flex: 2;'>;

                if (field_name === 'shape') {
                    formHtml += <select id='${field_name}' name='${field_name}' style='padding: 10px; border-radius: 5px; border: 2px solid #666; width: 100%;'>
                                    <option value='Circle' ${zone[field_name] === 'Circle' ? 'selected' : ''}>Circle</option>
                                    <option value='Square' ${zone[field_name] === 'Square' ? 'selected' : ''}>Square</option>
                                 </select>;
                } else if (field_name === 'eventzone_status') {
                    formHtml += <select id='${field_name}' name='${field_name}' style='padding: 10px; border-radius: 5px; border: 2px solid #666; width: 100%;'>
                                    <option value='enabled' ${zone[field_name] === 'enabled' ? 'selected' : ''}>Enabled</option>
                                    <option value='disabled' ${zone[field_name] === 'disabled' ? 'selected' : ''}>Disabled</option>
                                 </select>;
                } else if (field_name === 'zone_type') {
                    formHtml += <select id='${field_name}' name='${field_name}' style='padding: 10px; border-radius: 5px; border: 2px solid #666; width: 100%;'>
                                    <option value='Server Infrastructure' ${zone[field_name] === 'Server Infrastructure' ? 'selected' : ''}>Server Infrastructure</option>
                                    <option value='Quest' ${zone[field_name] === 'Quest' ? 'selected' : ''}>Quest</option>
                                    <option value='Event' ${zone[field_name] === 'Event' ? 'selected' : ''}>Event</option>
                                    <option value='Boss Power' ${zone[field_name] === 'Boss Power' ? 'selected' : ''}>Boss Power</option>
                                    <option value='Boss Fight' ${zone[field_name] === 'Boss Fight' ? 'selected' : ''}>Boss Fight</option>
                                    <option value='NPC' ${zone[field_name] === 'NPC' ? 'selected' : ''}>NPC</option>
                                 </select>;
                } 
                else if (field_name === 'respawnLocation_x' || field_name === 'respawnLocation_y' || field_name === 'respawnLocation_z') {
                    formHtml += <label for="respawnLocation" style="font-weight: bold;">Respawn Location (x, y, z):</label>
                                <input type="text" id="respawnLocation" name="respawnLocation" placeholder="e.g., 10.5, 20.3, 15.7" style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666;">
                                <input type="hidden" name="respawnLocation_x" class="respawn-location-hidden">
                                <input type="hidden" name="respawnLocation_y" class="respawn-location-hidden">
                                <input type="hidden" name="respawnLocation_z" class="respawn-location-hidden">;
                    return; 
                } else if (booleanFields.includes(field_name)) {
                    const isChecked = zone[field_name] == 1;
                    const checkboxClass = field_name === 'respawnAtLocation' ? 'respawn-at-location' : 
                                          field_name === 'onlyLeaveViaTeleport' ? 'only-leave-via-teleport' : '';

                    formHtml += <input type="hidden" name="${field_name}" value="0">
                                 <input type="checkbox" class="${checkboxClass}" name="${field_name}" ${isChecked ? 'checked' : ''} value="1" style="transform: scale(1.8); margin-top: 5px;">;
                } else {
                    formHtml += <input type='text' id='${field_name}' name='${field_name}' value='${zone[field_name] || ''}' style='padding: 10px; border-radius: 5px; border: 2px solid #666; width: 100%;'>;
                }

                formHtml += </div></div>;
            });

            formHtml += </form></div>;
            return formHtml;
        }

        jQuery(document).ready(function ($) {
            refreshZoneList();

            $('#clear-zone-btn').click(function () {
                $('.zone-selection-checkbox').prop('checked', false);
                checkedZones.clear();
                $('#eventzones-search').val('');
                $('#edit-sections-container').empty();
                refreshZoneList();
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('.zone-details-form').addEventListener('submit', function(event) {
                event.preventDefault();
                const respawnLocationInput = document.getElementById('respawnLocation').value;
                const [x, y, z] = respawnLocationInput.split(',').map(coord => coord.trim());
                document.querySelector('input[name="respawnLocation_x"]').value = x || '';
                document.querySelector('input[name="respawnLocation_y"]').value = y || '';
                document.querySelector('input[name="respawnLocation_z"]').value = z || '';
                event.target.submit();
            });
        });
    </script>
    <?php
}
?>