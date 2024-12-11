<?php
// File: universal-api.php

add_action('rest_api_init', function () {
    // Endpoint to fetch columns
    register_rest_route('jotunheim-magic/v1', '/get-columns', array(
        'methods' => 'POST',
        'callback' => function (WP_REST_Request $request) {
            global $wpdb;
            $table = sanitize_text_field($request->get_param('table'));

            if (strpos($table, 'jotun_') !== 0) {
                return new WP_REST_Response(['error' => 'Invalid table selected.'], 400);
            }

            $columns = $wpdb->get_results("DESCRIBE $table");
            return new WP_REST_Response(['columns' => $columns], 200);
        },
        'permission_callback' => '__return_true',
    ));
});

// Endpoint to fetch table names starting with 'jotun_'
add_action('rest_api_init', function () {
    register_rest_route('jotunheim-magic/v1', '/get-tables', array(
        'methods' => 'GET',
        'callback' => function () {
            global $wpdb;
            $tables = $wpdb->get_col("SHOW TABLES LIKE 'jotun_%'");
            return new WP_REST_Response(['tables' => $tables], 200);
        },
        'permission_callback' => '__return_true',
    ));
});
?>