<?php
// Register the REST routes for player data
function register_player_api_routes() {
    // Route to get all players
    register_rest_route('player-api/v1', '/players', array(
        'methods' => 'GET',
        'callback' => 'get_all_players',
        'permission_callback' => '__return_true', // Allow public access
    ));

    // Route to claim a player character
    register_rest_route('player-api/v1', '/player/(?P<name>[a-zA-Z0-9\s]+)/claim', array(
        'methods' => 'POST',
        'callback' => 'claim_player_character',
        'permission_callback' => '__return_true', // Allow public access
    ));

    // Route to insert a new player
    register_rest_route('player-api/v1', '/insert-player', array(
        'methods' => 'POST',
        'callback' => 'insert_player',
        'permission_callback' => '__return_true', // Allow public access
    ));

    // Route to update fields for a specific player by name
    register_rest_route('player-api/v1', '/player/(?P<name>[a-zA-Z0-9\s]+)/update', array(
        'methods' => 'PUT',
        'callback' => 'update_player_data_by_name',
        'args' => array(
            'name' => array(
                'required' => true,
                'validate_callback' => function($param) {
                    return is_string($param);
                }
            )
        ),
        'permission_callback' => '__return_true' // Adjust this for production
    ));
}
add_action('rest_api_init', 'register_player_api_routes');

// Include the individual endpoint functionality
include_once plugin_dir_path(__FILE__) . 'ledger-get.php';        // For GET functionality
include_once plugin_dir_path(__FILE__) . 'ledger-post-claim.php';  // For POST claim functionality
include_once plugin_dir_path(__FILE__) . 'ledger-post-insert-player.php';  // For POST insert functionality
include_once plugin_dir_path(__FILE__) . 'ledger-put.php';         // For PUT functionality