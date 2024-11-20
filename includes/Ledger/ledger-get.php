<?php
// Callback function for GET /players
function get_all_players_data() {
    global $wpdb;

    // Explicitly define table name (no prefix)
    $table_name = 'jotun_ledger';

    // Query all rows from the table
    $results = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

    // Check if results are empty
    if (empty($results)) {
        return new WP_REST_Response(['message' => 'No data found or table inaccessible'], 404);
    }

    // Return the retrieved data
    return new WP_REST_Response($results, 200);
}
// Register the GET endpoint to retrieve all player data
add_action('rest_api_init', function() {
    register_rest_route('jotunheim-magic/v1', '/players', [
        'methods' => 'GET',
        'callback' => 'get_all_players_data',
        'permission_callback' => '__return_true',
    ]);
});