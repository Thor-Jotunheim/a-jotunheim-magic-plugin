<?php
// File: eventzones-delete-api.php

// Prevent direct access
if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'eventzones-permission.php';

add_action('rest_api_init', function () {
    // DELETE endpoint for deleting an existing event zone by ID
    register_rest_route('jotunheim-magic/v1', '/eventzones/(?P<id>\d+)', array(
        'methods' => 'DELETE',
        'callback' => 'delete_eventzone_rest',
        'permission_callback' => 'can_manage_eventzones',
        'args' => array(
            'id' => array(
                'required' => true,
                'validate_callback' => function($param, $request, $key) {
                    return is_numeric($param);
                }
            ),
        ),
    ));
});

// Callback function for deleting an existing event zone by ID
function delete_eventzone_rest($request) {
    global $wpdb;
    $table_name = 'jotun_eventzones';
    $zone_id = intval($request['id']); // Get the ID from the request parameters

    // Attempt to delete the event zone from the database
    $result = $wpdb->delete($table_name, array('id' => $zone_id));
    
    if ($result === false) {
        error_log("Delete failed for ID $zone_id: " . $wpdb->last_error);
        return new WP_Error('delete_failed', 'Failed to delete event zone', array('status' => 500));
    }

    return rest_ensure_response(array('status' => 'deleted', 'zone_id' => $zone_id, 'message' => 'Event zone deleted successfully.'));
}
?>