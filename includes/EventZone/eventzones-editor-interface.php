<?php
function eventzones_editor_interface() {
    $apiUrl = esc_url(rest_url('jotunheim-magic/v1/eventzones'));
    $apiKey = EVENTZONES_API_KEY;
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
                <button id="save-all-btn" style="width: 100%; background: #28a745; color: #fff; padding: 12px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; margin-bottom: 20px; display: none;">Save All Changes</button>
                <div id="forms-container">
                    <!-- Edit sections will be dynamically added here -->
                </div>
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
            console.log('Refreshing zone list...');
            fetch(apiUrl, {
                headers: { 'X-API-KEY': apiKey }
            })
            .then(response => {
                console.log('API Response:', response);
                return response.json();
            })
            .then(data => {
                console.log('Zone data:', data);
                const container = document.getElementById('eventzones-container');
                container.innerHTML = '';
                
                if (data && data.length > 0) {
                    data.forEach(zone => {
                        const checkbox = `<div><label><input type="checkbox" class="zone-selection-checkbox" data-id="${zone.id}" value="${zone.name}">${zone.name}</label></div>`;
                        container.insertAdjacentHTML('beforeend', checkbox);
                    });
                    restoreCheckedState();
                    trackCheckedState();
                } else {
                    container.innerHTML = '<p>No zones found.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching zones:', error);
                document.getElementById('eventzones-container').innerHTML = '<p>Error loading zones. Check console.</p>';
            });
        }

        function searchEventZones(searchValue) {
            console.log('Searching zones for:', searchValue);
            fetch(`${apiUrl}?search=${encodeURIComponent(searchValue)}`, {
                headers: { 'X-API-KEY': apiKey }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Search results:', data);
                const container = document.getElementById('eventzones-container');
                container.innerHTML = '';
                
                if (data && data.length > 0) {
                    data.forEach(zone => {
                        const checkbox = `<div><label><input type="checkbox" class="zone-selection-checkbox" data-id="${zone.id}" value="${zone.name}">${zone.name}</label></div>`;
                        container.insertAdjacentHTML('beforeend', checkbox);
                    });
                    restoreCheckedState();
                    trackCheckedState();
                } else {
                    container.innerHTML = '<p>No zones found for search.</p>';
                }
            })
            .catch(error => {
                console.error('Error searching zones:', error);
                document.getElementById('eventzones-container').innerHTML = '<p>Error searching zones. Check console.</p>';
            });
        }

        // Initialize everything when DOM is ready
        jQuery(document).ready(function($) {
            console.log('DOM ready, initializing...');
            
            // Load zones initially
            refreshZoneList();

            // Search functionality
            $('#eventzones-search').on('input', function() {
                const searchValue = $(this).val();
                if (searchValue.length >= 2) {
                    searchEventZones(searchValue);
                } else {
                    refreshZoneList();
                }
            });

            // Load selected zones button
            $('#load-zone-btn').click(function() {
                const selectedZones = [];
                $('.zone-selection-checkbox:checked').each(function() {
                    selectedZones.push($(this).data('id'));
                });

                console.log('Loading zones:', selectedZones);

                if (selectedZones.length > 0) {
                    $('#forms-container').empty();

                    selectedZones.forEach(zone_id => {
                        // Use AJAX to generate form HTML with proper field configuration
                        $.post('<?php echo admin_url('admin-ajax.php'); ?>', {
                            action: 'jotunheim_generate_edit_zone_form',
                            zone_id: zone_id
                        })
                        .done(function(response) {
                            console.log('Form response:', response);
                            if (response.success) {
                                $('#forms-container').append(response.data.html);
                                
                                // Execute the conditional fields JavaScript
                                if (response.data.js) {
                                    eval(response.data.js);
                                }
                                
                                initializeConditionalFieldBehavior();
                                
                                // Explicitly bind click events to newly added buttons
                                bindFormButtonEvents();
                                
                                // Show Save All button if multiple zones are loaded
                                if (selectedZones.length > 1) {
                                    console.log('Showing Save All button, zones loaded:', selectedZones.length);
                                    $('#save-all-btn').show();
                                } else {
                                    $('#save-all-btn').hide();
                                }
                            } else {
                                console.error('Error generating form:', response);
                            }
                        })
                        .fail(function(error) {
                            console.error('AJAX error:', error);
                        });
                    });
                } else {
                    alert('Please select at least one zone to load.');
                }
            });

            // Clear selected zones
            $('#clear-zone-btn').click(function() {
                $('.zone-selection-checkbox').prop('checked', false);
                checkedZones.clear();
                $('#eventzones-search').val('');
                $('#forms-container').empty();
                $('#save-all-btn').hide();
                refreshZoneList();
            });

            // Save All button functionality
            $('#save-all-btn').click(function() {
                const forms = $('.zone-details-form');
                let savePromises = [];
                let successCount = 0;
                let errorCount = 0;

                if (forms.length === 0) {
                    alert('No forms to save');
                    return;
                }

                $(this).prop('disabled', true).text('Saving...');

                forms.each(function() {
                    const form = $(this);
                    const zoneId = form.data('zone-id');
                    
                    // Use jQuery serialize for consistency with individual save
                    const formArray = form.serializeArray();
                    const jsonData = {};
                    
                    // Convert form array to object
                    $.each(formArray, function(i, field) {
                        jsonData[field.name] = field.value;
                    });
                    
                    // Handle unchecked checkboxes
                    form.find('input[type="checkbox"]').each(function() {
                        if (!$(this).is(':checked') && !jsonData.hasOwnProperty($(this).attr('name'))) {
                            jsonData[$(this).attr('name')] = '0';
                        }
                    });

                    const savePromise = fetch(`${apiUrl}/${zoneId}`, {
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
                            successCount++;
                            console.log(`Zone ${zoneId} saved successfully`);
                        } else {
                            errorCount++;
                            console.error(`Error saving zone ${zoneId}:`, data);
                        }
                    })
                    .catch(error => {
                        errorCount++;
                        console.error(`Error saving zone ${zoneId}:`, error);
                    });

                    savePromises.push(savePromise);
                });

                Promise.all(savePromises).then(() => {
                    $('#save-all-btn').prop('disabled', false).text('Save All Changes');
                    
                    if (errorCount === 0) {
                        alert(`All ${successCount} zones saved successfully!`);
                        $('#forms-container').empty();
                        $('#save-all-btn').hide();
                    } else {
                        alert(`${successCount} zones saved successfully, ${errorCount} failed. Check console for details.`);
                    }
                });
            });

            function initializeConditionalFieldBehavior() {
                // Execute dynamic conditional field JavaScript
                <?php echo EventZoneFieldGenerator::generateConditionalFieldsJS(); ?>
                
                // Legacy hardcoded conditional fields (these should be migrated to the configuration system)
                $('[data-field="squareXRadius"], [data-field="squareZRadius"]').hide();
                $('[data-field="respawnLocation"]').hide();

                $('.zone-details-form').each(function() {
                    const form = $(this);
                    const shapeField = form.find('#shape');
                    const isSquare = shapeField.val() === 'Square';
                    form.find('[data-field="squareXRadius"], [data-field="squareZRadius"]').toggle(isSquare);

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

                $('.zone-details-form').on('change', '.respawn-at-location, .only-leave-via-teleport', function() {
                    const form = $(this).closest('.zone-details-form');
                    const respawnAtLocationChecked = form.find('.respawn-at-location').is(':checked');
                    const onlyLeaveViaTeleportChecked = form.find('.only-leave-via-teleport').is(':checked');

                    if (onlyLeaveViaTeleportChecked || respawnAtLocationChecked) {
                        form.find('[data-field="respawnLocation"]').show();
                    } else {
                        form.find('[data-field="respawnLocation"]').hide();
                        if (!respawnAtLocationChecked && !onlyLeaveViaTeleportChecked) {
                            form.find('[data-field="respawnLocation"] input').val('');
                        }
                    }
                });
            }
            
            function bindFormButtonEvents() {
                console.log('Binding form button events...');
                
                // Remove any existing event handlers to avoid duplicates
                $('.save-zone-btn').off('click');
                $('.delete-zone-btn').off('click');
                
                // Bind save button events
                $('.save-zone-btn').on('click', function(event) {
                    event.preventDefault();
                    console.log('Individual save button clicked directly');
                    handleSaveButtonClick($(this));
                });
                
                // Bind delete button events
                $('.delete-zone-btn').on('click', function(event) {
                    event.preventDefault();
                    console.log('Individual delete button clicked directly');
                    handleDeleteButtonClick($(this));
                });
            }
            
            function handleSaveButtonClick(button) {
                const form = button.closest('.zone-details-form');
                const zoneId = form.data('zone-id');
                
                console.log('Save button clicked for zone:', zoneId);
                console.log('Form found:', form.length > 0);
                console.log('Form HTML:', form.length > 0 ? form[0].outerHTML.substring(0, 200) + '...' : 'No form found');
                
                if (form.length === 0) {
                    alert('Error: Could not find form element');
                    return;
                }
                
                if (!zoneId) {
                    alert('Error: No zone ID found');
                    return;
                }
                
                // Use jQuery serialize instead of FormData for better compatibility
                const formArray = form.serializeArray();
                const jsonData = {};
                
                console.log('Form array before processing:', formArray);
                
                // Convert form array to object
                $.each(formArray, function(i, field) {
                    jsonData[field.name] = field.value;
                });
                
                // Handle unchecked checkboxes (they won't appear in serializeArray)
                form.find('input[type="checkbox"]').each(function() {
                    if (!$(this).is(':checked') && !jsonData.hasOwnProperty($(this).attr('name'))) {
                        jsonData[$(this).attr('name')] = '0';
                    }
                });

                console.log('Final JSON data to send:', jsonData);
                console.log('API URL:', `${apiUrl}/${zoneId}`);
                console.log('API Key:', apiKey);

                fetch(`${apiUrl}/${zoneId}`, {
                    method: 'PUT',
                    headers: {
                        'X-API-KEY': apiKey,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(jsonData)
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('API Response:', data);
                    if (data.status === 'updated') {
                        alert('Event zone updated successfully');
                        // Remove the form section after successful save
                        form.closest('.single-edit-section').remove();
                        
                        // Hide Save All button if no more forms
                        if ($('.zone-details-form').length === 0) {
                            $('#save-all-btn').hide();
                        }
                    } else {
                        console.error('Error:', data);
                        alert('Failed to update event zone: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Save Error:', error);
                    alert('Failed to save event zone. Check console for details.');
                });
            }
            
            function handleDeleteButtonClick(button) {
                const form = button.closest('.zone-details-form');
                const zoneId = form.data('zone-id');
                const confirmDelete = form.find('.confirm-delete-checkbox').is(':checked');

                console.log('Delete button clicked for zone:', zoneId);
                console.log('Confirm checked:', confirmDelete);

                if (confirmDelete) {
                    if (confirm(`Are you sure you want to delete zone ${zoneId}? This action cannot be undone.`)) {
                        fetch(`${apiUrl}/${zoneId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-API-KEY': apiKey,
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => {
                            console.log('Delete response status:', response.status);
                            return response.json();
                        })
                        .then(data => {
                            console.log('Delete API Response:', data);
                            if (data.status === 'deleted') {
                                alert(`Event zone ${zoneId} deleted successfully`);
                                form.closest('.single-edit-section').remove();
                                refreshZoneList(); // Refresh the list since a zone was deleted
                                
                                // Hide Save All button if no more forms
                                if ($('.zone-details-form').length === 0) {
                                    $('#save-all-btn').hide();
                                }
                            } else {
                                console.error('Error:', data);
                                alert(`Failed to delete event zone ${zoneId}: ` + (data.message || 'Unknown error'));
                            }
                        })
                        .catch(error => {
                            console.error('Delete Request Error:', error);
                            alert('Failed to delete event zone. Please check the console for more details.');
                        });
                    }
                } else {
                    alert('Please confirm delete by checking the checkbox.');
                }
            }
        });
    </script>
    <?php
}

// AJAX handler to generate edit zone form using field generator
function jotunheim_generate_edit_zone_form() {
    global $wpdb;
    
    error_log('AJAX handler called for zone form generation');
    
    if (!isset($_POST['zone_id'])) {
        error_log('Zone ID not provided');
        wp_die('Zone ID required');
    }
    
    $zone_id = intval($_POST['zone_id']);
    error_log('Generating form for zone ID: ' . $zone_id);
    $table_name = 'jotun_eventzones';
    
    // Get zone data
    $zone = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $zone_id), ARRAY_A);
    
    if (!$zone) {
        error_log('Zone not found for ID: ' . $zone_id);
        wp_die('Zone not found');
    }
    
    // Check if EventZoneFieldGenerator class exists
    if (!class_exists('EventZoneFieldGenerator')) {
        error_log('EventZoneFieldGenerator class not found, including file...');
        require_once plugin_dir_path(__FILE__) . 'eventzones-field-generator.php';
    }
    
    // Get table columns
    $columns = $wpdb->get_results("DESCRIBE $table_name");
    
    // Generate form HTML using field generator
    $form_html = '<div class="single-edit-section" style="margin-bottom: 40px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background: rgba(255, 255, 255, 0.8);">';
    $form_html .= '<h4>Editing: ' . esc_html($zone['name'] ?? '') . '</h4>';
    $form_html .= '<form class="zone-details-form" data-zone-id="' . $zone_id . '">';
    
    $form_html .= EventZoneFieldGenerator::generateFormFields(null, $zone, 'edit-zone-form-' . $zone_id);
    
    // Add Save and Delete buttons - moved above the form closing tag
    $form_html .= '<div style="margin-top: 20px; padding: 15px; background: rgba(240,240,240,0.9); border-radius: 5px;">';
    $form_html .= '<button type="button" class="save-zone-btn" style="padding: 12px; background-color: #0073aa; color: #fff; border: none; border-radius: 5px; cursor: pointer; width: 100%; margin-bottom: 10px; font-size: 16px; font-weight: bold;">💾 Save Changes</button>';
    $form_html .= '<button type="button" class="delete-zone-btn" style="padding: 12px; background-color: #d9534f; color: #fff; border: none; border-radius: 5px; cursor: pointer; width: 100%; margin-top: 10px; font-size: 16px; font-weight: bold;">🗑️ Delete Record</button>';
    $form_html .= '<label style="display: block; margin-top: 10px; font-weight: bold;">';
    $form_html .= '<input type="checkbox" class="confirm-delete-checkbox" style="margin-right: 10px; transform: scale(1.2);">Confirm Delete';
    $form_html .= '</label>';
    $form_html .= '</div>';
    $form_html .= '</form></div>';
    
    // Also return the conditional fields JavaScript
    $js_code = EventZoneFieldGenerator::generateConditionalFieldsJS();
    
    error_log('Form HTML generated successfully, length: ' . strlen($form_html));
    
    wp_send_json_success([
        'html' => $form_html,
        'js' => $js_code
    ]);
}
add_action('wp_ajax_jotunheim_generate_edit_zone_form', 'jotunheim_generate_edit_zone_form');
?>