<?php
// File: universal-api.php

add_action('rest_api_init', function () {
    register_rest_route('jotunheim-magic/v1', '/get-columns', array(
        'methods' => 'POST',
        'callback' => function (WP_REST_Request $request) {
            global $wpdb;
            $table = $request->get_param('table');
            $columns = $wpdb->get_results("DESCRIBE $table");
            return new WP_REST_Response(['columns' => $columns], 200);
        },
        'permission_callback' => '__return_true',
    ));

    register_rest_route('jotunheim-magic/v1', '/add-item', array(
        'methods' => 'POST',
        'callback' => function (WP_REST_Request $request) {
            global $wpdb;
            $table = $request->get_param('table_name');
            $data = $request->get_params();
            unset($data['table_name']); // Remove table_name from data

            $wpdb->insert($table, $data);

            return new WP_REST_Response(['message' => 'Item added successfully'], 200);
        },
        'permission_callback' => '__return_true',
    ));
});