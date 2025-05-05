<?php
// Register all REST API routes for the ledger functionality
add_action('rest_api_init', function() {
    // Register the GET endpoint to fetch all players' data
    register_rest_route('player-api/v1', '/players', [
        'methods' => 'GET',
        'callback' => 'get_all_players_data',
    ]);

    // Register the POST endpoint to update fields for a specific player by name
    register_rest_route('player-api/v1', '/player/(?P<name>[a-zA-Z0-9\s]+)/claim', [
        'methods' => 'POST',
        'callback' => 'update_player_data_by_name',
        'args' => [
            'name' => [
                'required' => true,
                'validate_callback' => function($param) {
                    return is_string($param);
                }
            ]
        ],
    ]);

    // Register the POST endpoint to insert a new player
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

    // Register the PUT endpoint to update fields for a specific player by name
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
        'permission_callback' => '__return_true' // Adjust this for production
    ]);
});

// Include the individual endpoint functionality
include_once plugin_dir_path(__FILE__) . 'ledger-get.php';        // For GET functionality
include_once plugin_dir_path(__FILE__) . 'ledger-post-claim.php';  // For POST claim functionality
include_once plugin_dir_path(__FILE__) . 'ledger-post-insert-player.php';  // For POST insert functionality
include_once plugin_dir_path(__FILE__) . 'ledger-put.php';         // For PUT functionality