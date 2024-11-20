jQuery(document).ready(function($) {
    // Initially hide square-related fields container
    $('[data-field="squareXRadius"], [data-field="squareZRadius"]').hide();
    // Initially hide respawn location fields container
    $('[data-field="respawnLocation_x"], [data-field="respawnLocation_y"], [data-field="respawnLocation_z"]').hide();

    // Show/hide square radius fields based on shape selection
    $('#shape').change(function() {
        const isSquare = $(this).val() === 'Square';
        $('[data-field="squareXRadius"], [data-field="squareZRadius"]').toggle(isSquare);
    });

    // Only "RespawnAtLocation" checkbox controls visibility of respawn location fields
    $('#respawnAtLocation').change(function() {
        const isChecked = $(this).is(':checked');
        $('[data-field="respawnLocation_x"], [data-field="respawnLocation_y"], [data-field="respawnLocation_z"]').toggle(isChecked);
    });

    // When OnlyLeaveViaTeleport is checked, automatically check RespawnAtLocation without changing its visibility control
    $('#onlyLeaveViaTeleport').change(function() {
        if ($(this).is(':checked')) {
            $('#respawnAtLocation').prop('checked', true).trigger('change'); // Check and trigger change on RespawnAtLocation
        }
    });
});