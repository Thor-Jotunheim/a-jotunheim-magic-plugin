<?php
// Prevent direct access to the file
if (!defined('ABSPATH')) exit;

// Callback function for POST /player/{name}/claim to add new records only
function add_new_player_record($request) {
    global $wpdb;
    $table_name = 'jotun_ledger';
    $input_name = sanitize_text_field($request['name']);

    // Check if the player already exists in the database
    $existing_player = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE activePlayerName = %s OR playerName = %s",
        $input_name, $input_name
    ));

    if ($existing_player) {
        // Return error if player already exists
        return new WP_REST_Response(['error' => 'Player already exists'], 409);
    }

    // Fetch column names for the ledger table to construct the insert query
    $columns = $wpdb->get_col("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name' AND TABLE_SCHEMA = DATABASE()");
    if (empty($columns)) {
        return new WP_REST_Response(['error' => 'Failed to retrieve table columns'], 500);
    }

    // Prepare data for inserting a new record
    $data = [];
    foreach ($columns as $column) {
        if (isset($request[$column]) && $column != 'id') { // Ensure 'id' is not included
            // Sanitize numeric values for integer columns
            $data[$column] = is_numeric($request[$column]) ? intval($request[$column]) : sanitize_text_field($request[$column]);
        }
    }

    // Add the player's name fields to the data if not already provided
    if (!isset($data['activePlayerName'])) {
        $data['activePlayerName'] = $input_name;
    }
    if (!isset($data['playerName'])) {
        $data['playerName'] = $input_name;
    }

    // If no valid fields are provided in the request, return an error
    if (empty($data)) {
        return new WP_REST_Response(['error' => 'No valid fields provided for creating a player record'], 400);
    }

    // Insert the new record into the database
    $inserted = $wpdb->insert(
        $table_name,
        $data,
        array_fill(0, count($data), '%s') // Treat all fields as strings for safety
    );

    // Check if the insert was successful
    if ($inserted === false) {
        error_log("Insert error: " . $wpdb->last_error);
        return new WP_REST_Response(['error' => 'Failed to add new player record'], 500);
    }

    return new WP_REST_Response(['message' => 'Player record created successfully'], 201);
}

// Register the REST API route for adding a new player
add_action('rest_api_init', function() {
    register_rest_route('player-api/v1', '/player/(?P<name>[a-zA-Z0-9\s]+)/claim', [
        'methods' => 'POST',
        'callback' => 'add_new_player_record',
        'args' => [
            'name' => [
                'required' => true,
                'validate_callback' => function($param) {
                    return is_string($param);
                }
            ]
        ],
    ]);
});