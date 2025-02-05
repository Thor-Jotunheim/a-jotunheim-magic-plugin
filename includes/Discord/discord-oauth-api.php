<?php
// Prevent direct access to the file
if (!defined('ABSPATH')) exit;

// Include the JWT token generation file
//include_once plugin_dir_path(__FILE__) . 'discord-oauth-generate-jwt-token.php';

// Register a custom REST API route for the Discord OAuth flow
// add_action('rest_api_init', function() {
//     register_rest_route('custom-auth/v1', '/discord-login', array(
//         'methods' => 'POST',
//         'callback' => 'custom_discord_oauth_login',
//         'args' => array(
//             'code' => array(
//                 'required' => true,
//                 'validate_callback' => function($param) {
//                     return is_string($param);
//                 }
//             )
//         ),
//     ));
// });


function custom_discord_oauth_login($request) {
    $code = sanitize_text_field($request['code']);
    $client_id = '1297908076929613956';
    $client_secret = 'WzapYHJlj3P0XgwsBC9GATzrSs1kwi4z';
    $redirect_uri = 'https://JOTUNHEIM_BASE_URL/wp-admin/admin-ajax.php?action=oauth2callback';

    // Exchange the authorization code for an access token
    $response = wp_remote_post('https://discord.com/api/oauth2/token', array(
        'body' => array(
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirect_uri,
        ),
    ));

    if (is_wp_error($response)) {
        return new WP_REST_Response('Failed to communicate with Discord.', 500);
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);
    if (!isset($body['access_token'])) {
        return new WP_REST_Response('Failed to get access token.', 500);
    }

    $access_token = sanitize_text_field($body['access_token']);

    // Get user information from Discord
    $user_response = wp_remote_get('https://discord.com/api/users/@me', array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $access_token,
        ),
    ));

    if (is_wp_error($user_response)) {
        return new WP_REST_Response('Failed to get user information from Discord.', 500);
    }

    $user_data = json_decode(wp_remote_retrieve_body($user_response), true);
    if (!isset($user_data['id'])) {
        return new WP_REST_Response('Failed to get user information.', 500);
    }

    $discord_user_id = sanitize_text_field($user_data['id']);
    $discord_email = isset($user_data['email']) ? sanitize_email($user_data['email']) : '';
    $discord_display_name = sanitize_text_field($user_data['username']);

    // Check if a user with this display name or email exists
    $user_id = username_exists($discord_display_name);

    if (!$user_id && email_exists($discord_email)) {
        $user = get_user_by('email', $discord_email);
        if ($user) {
            $user_id = $user->ID;
        }
    }

    if (!$user_id) {
        $random_password = wp_generate_password(12, false);
        $user_id = wp_create_user($discord_display_name, $random_password, $discord_email);

        if (is_wp_error($user_id)) {
            return new WP_REST_Response('User creation failed.', 500);
        }
    }

    // Get the WordPress user object and set role if necessary
    $user = new WP_User($user_id);

    // Check if the user has the required role (Administrator or Editor)
    if (!in_array('administrator', $user->roles) && !in_array('editor', $user->roles)) {
        return new WP_REST_Response('User does not have permission to access this API.', 403);
    }

    // Generate the JWT token
    $jwt_token = generate_jwt_token($user_id);

    if (is_wp_error($jwt_token)) {
        return new WP_REST_Response('Failed to generate JWT token.', 500);
    }

    // Return the token in the response
    return new WP_REST_Response(array(
        'token' => $jwt_token,
        'user_display_name' => $discord_display_name,
    ), 200);
}