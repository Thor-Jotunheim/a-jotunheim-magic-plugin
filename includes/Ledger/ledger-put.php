<?php
// Prevent direct access to the file
if (!defined('ABSPATH')) exit;

// Callback function for PUT /player/{name}/update
function update_player_data_by_name($request) {
    global $wpdb;
    $table_name = 'jotun_ledger';
    $input_name = sanitize_text_field($request['name']);

    // Fetch all column names from the ledger table to verify the fields that can be updated
    $columns = $wpdb->get_col("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name' AND TABLE_SCHEMA = DATABASE()");

    // Attempt to find the player by activePlayerName or playerName
    $player_record = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE activePlayerName = %s OR playerName = %s", $input_name, $input_name));

    // If no player is found, return an error
    if (!$player_record) {
        return new WP_REST_Response(['error' => 'Player not found'], 404);
    }

    // Prepare data for updating the player's record
    $data = [];
    foreach ($columns as $column) {
        if (isset($request[$column]) && $column != 'id') { // Ensure 'id' is not updated
            // Sanitize numeric values for integer columns
            $data[$column] = is_numeric($request[$column]) ? intval($request[$column]) : sanitize_text_field($request[$column]);
        }
    }

    // If no valid fields are provided in the request, return an error
    if (empty($data)) {
        return new WP_REST_Response(['error' => 'No valid fields provided to update'], 400);
    }

    // Execute the update in the database
    $update = $wpdb->update(
        $table_name,
        $data,
        ['activePlayerName' => $player_record->activePlayerName],
        array_fill(0, count($data), '%s'), // Format each field as a string for safety
        ['%s']
    );

    // Check if the update was successful
    if ($update === false) {
        return new WP_REST_Response(['error' => 'Failed to update player data'], 500);
    }

    return new WP_REST_Response(['message' => 'Player data updated successfully'], 200);
}

// Register the PUT endpoint
add_action('rest_api_init', function() {
    register_rest_route('player-api/v1', '/player/(?P<name>[a-zA-Z0-9\s]+)/update', [
        'methods' => 'PUT',
        'callback' => 'update_player_data_by_name',
        'args' => [
            'name' => [
                'required' => true,
                'validate_callback' => function($param) {
                    return is_string($param);
                }
            ]
        ],
        'permission_callback' => '__return_true', // Temporarily bypass permissions for testing
    ]);
});