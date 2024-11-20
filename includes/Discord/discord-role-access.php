<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

/**
 * Page access control based on Discord roles mapped to WordPress roles
 */
function jotunheim_magic_staff_page_access() {
    if (!is_user_logged_in()) {
        error_log("User is not logged in.");
        return; // Only logged-in users are checked
    }

    global $post;

    // Check if $post is set and has the post_name property
    if (!isset($post) || !property_exists($post, 'post_name')) {
        error_log("No valid post object found or 'post_name' property missing.");
        return;
    }

    $user_id = get_current_user_id();
    $discord_roles = get_user_meta($user_id, 'discord_roles', true);

    error_log("User ID: " . $user_id);
    error_log("Discord roles retrieved from user meta: " . print_r($discord_roles, true));

    // Define mappings for pages to required roles
    $staff_pages_roles = [
        'admin'     => '816462309274419250', // Admin Discord role ID
        'moderator' => '816452821208793128', // Moderator Discord role ID
        'valkyrie'  => '963502767173931039', // Valkyrie Discord role ID
        'vithar'    => '1104073178495602751' // Vithar Discord role ID
    ];

    // Check if the current page is a staff page and user has the required role
    if (array_key_exists($post->post_name, $staff_pages_roles)) {
        $required_role = $staff_pages_roles[$post->post_name];
        error_log("Page being accessed: " . $post->post_name);
        error_log("Required role for this page: " . $required_role);

        // Allow access if the user has the required Discord role or is an administrator
        if (current_user_can('administrator') || (is_array($discord_roles) && in_array($required_role, $discord_roles))) {
            error_log("Access granted to page: " . $post->post_name);
            add_filter('post_password_required', '__return_false'); // Disable password for the page
        } else {
            error_log("Access denied to page: " . $post->post_name);
        }
    } else {
        error_log("Page " . $post->post_name . " does not require special access.");
    }
}
add_action('wp', 'jotunheim_magic_staff_page_access');