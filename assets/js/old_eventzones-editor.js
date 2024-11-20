/*
// assets/js/eventzones-editor.js

jQuery(document).ready(function ($) {
    const ajaxurl = eventzonesData.ajaxurl;

    function adjustContainerHeight() {
        const windowHeight = $(window).height();
        const containerHeight = windowHeight - $('#eventzones-editor-container').offset().top - 20;
        $('#eventzones-editor-container').css('min-height', containerHeight + 'px');
        $('#eventzones-container').css('max-height', containerHeight - 500 + 'px');
    }

    adjustContainerHeight();
    $(window).resize(adjustContainerHeight);

    function refreshZoneList() {
        $.post(ajaxurl, {
            action: 'fetch_all_eventzones'
        }, function (response) {
            if (response.success) {
                $('#eventzones-container').empty();
                response.data.forEach(function (zone) {
                    const checkbox = `<div><label style="display: flex; align-items: center;">
                        <input type="checkbox" class="zone-checkbox" data-id="${zone.id}" value="${zone.name}" 
                        style="margin-right: 10px; transform: scale(1.8); cursor: pointer;">${zone.name}
                        </label></div>`;
                    $('#eventzones-container').append(checkbox);
                });
            }
        });
    }

    refreshZoneList();

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
                        const checkbox = `<div><label style="display: flex; align-items: center;">
                            <input type="checkbox" class="zone-checkbox" data-id="${zone.id}" value="${zone.name}" 
                            style="margin-right: 10px; transform: scale(1.8); cursor: pointer;">${zone.name}
                            </label></div>`;
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

    $('#clear-selected-zones-btn').click(function () {
        $('.zone-checkbox:checked').prop('checked', false);
    });

    $('#load-zone-btn').click(function () {
        const selectedZones = [];
        $('.zone-checkbox:checked').each(function () {
            selectedZones.push($(this).data('id'));
        });

        if (selectedZones.length > 0) {
            $('#edit-sections-container').empty();
            $('#actions-container').show();

            selectedZones.forEach(function (zone_id) {
                $.post(ajaxurl, {
                    action: 'fetch_eventzone_details',
                    eventzone_id: zone_id
                }, function (response) {
                    if (response.success) {
                        const zone = response.data;
                        // Here we add the zone editor form dynamically as before
                        const editSection = `
                            <div class="single-edit-section" style="margin-bottom: 40px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background: rgba(255, 255, 255, 0.8);">
                                <h4 style="font-family: 'Roboto', sans-serif; font-weight: 700; color: #444;">Editing: ${zone.name || ''}</h4>
                                <!-- Add the form here as in your previous code -->
                            </div>
                        `;
                        $('#edit-sections-container').append(editSection);
                    } else {
                        alert('Failed to fetch zone details.');
                    }
                });
            });
        }
    });

    $('#save-zone-btn').click(function () {
        const zonesData = [];

        $('.single-edit-section').each(function () {
            const form = $(this).find('.zone-details-form');
            const zoneData = {
                id: form.data('zone-id'),
                name: form.find('.zone-name').val(),
                priority: parseFloat(form.find('.priority').val()) || 0,
                // and so on for other fields
            };
            zonesData.push(zoneData);
        });

        $.post(ajaxurl, { action: 'save_eventzone_details', zones_data: zonesData }, function (response) {
            if (response.success) {
                alert('Zones saved successfully.');
            } else {
                alert('Failed to save zones.');
            }
        });
    });

    $('#delete-zone-btn').click(function () {
        if (!$('#confirm-delete-checkbox').is(':checked')) {
            alert('Please confirm deletion by checking the box.');
            return;
        }

        const selectedZones = [];
        $('.zone-checkbox:checked').each(function () {
            selectedZones.push($(this).data('id'));
        });

        if (selectedZones.length === 0) {
            alert('No zones selected for deletion.');
            return;
        }

        if (confirm('Are you sure you want to delete the selected zones?')) {
            $.post(ajaxurl, {
                action: 'delete_eventzone_details',
                zone_ids: selectedZones
            }, function (response) {
                if (response.success) {
                    alert('Selected zones deleted successfully.');
                    refreshZoneList();
                    $('#edit-sections-container').empty();
                    $('#actions-container').hide();
                } else {
                    alert('Failed to delete zones.');
                }
            });
        }
    });
});

*/