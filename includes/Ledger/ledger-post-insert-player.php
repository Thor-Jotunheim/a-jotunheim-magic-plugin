<?php
// Callback function to insert a new player into the ledger
function insert_new_player($request) {
    global $wpdb;
    $table_name = 'jotun_ledger';

    // Get player data from request
    $player_name = sanitize_text_field($request['playerName']);
    $active_player_name = sanitize_text_field($request['activePlayerName']);

    // Check if player already exists in the ledger
    $existing_player = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE playerName = %s OR activePlayerName = %s", $player_name, $active_player_name));

    if ($existing_player) {
        return new WP_REST_Response(['error' => 'Player already exists'], 409); // Conflict status
    }

    // Define default values for the new player
    $default_values = [
        'playerName' => $player_name,
        'activePlayerName' => $active_player_name,
        'vidar' => 0,
        'unbreakableoath' => 0,
        'eternalflame' => 0,
        'floatingrockbase' => 0,
        'rockpillar' => 0,
        'rockfingerthumb' => 0,
        'unbreakabletrees' => 0,
        'widestone' => 0,
        'greydwarfspawner' => 0,
        'pickablethistle' => 0,
        'cloudberrybush' => 0,
        'pickablemushroom' => 0,
        'blueberrybush' => 0,
        'raspberrybush' => 0,
        'bluemushroomsx50' => 0,
        'yuletree' => 0,
        'maypole' => 0,
        'jackoturnip' => 0,
        'flowercrown' => 0,
        'doorautoclose' => 0,
        'mistlandsrockgreen' => 0,
        'mistlandsrockyellow' => 0,
        'mistlandsrocksmall' => 0,
        'pickableyellowmushroom' => 0,
        'stonemarker' => 0,
        'deertrophy' => 0,
        'leechtrophy' => 0,
        'draugrelitetrophy' => 0,
        'growthtrophy' => 0,
        'seekertrophy' => 0,
        'ulvtrophy' => 0,
        'gierrahfatrophy' => 0,
        'fulingbeserkertrophy' => 0,
        'yagluthtrophy' => 0
    ];

    // Insert new player into the ledger
    $inserted = $wpdb->insert($table_name, $default_values, array_fill(0, count($default_values), '%s'));

    if ($inserted) {
        return new WP_REST_Response(['message' => 'Player added successfully'], 201); // Created status
    } else {
        return new WP_REST_Response(['error' => 'Failed to add player'], 500); // Server error status
    }
}

// Register the REST API route for inserting a new player
add_action('rest_api_init', function() {
    register_rest_route('player-api/v1', '/insert-player', [
        'methods' => 'POST',
        'callback' => 'insert_new_player',
        'args' => [
            'playerName' => [
                'required' => true,
                'validate_callback' => function($param) {
                    return is_string($param) && !empty($param);
                },
                'description' => 'The name of the player'
            ],
            'activePlayerName' => [
                'required' => true,
                'validate_callback' => function($param) {
                    return is_string($param) && !empty($param);
                },
                'description' => 'The active name of the player'
            ]
        ],
    ]);
});