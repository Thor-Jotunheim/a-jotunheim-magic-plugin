<?php
// Prevent direct access to the file
if (!defined('ABSPATH')) exit;

// Hook into AJAX to handle the Discord OAuth2 callback
add_action('wp_ajax_oauth2callback', 'discord_oauth_callback');
add_action('wp_ajax_nopriv_oauth2callback', 'discord_oauth_callback');

function discord_oauth_callback() {
    include_once(JOTUNHEIM_PLUGIN_DIR . 'includes/Discord/discord-config.php');

    if (!isset($_GET['code'])) {
        wp_die('Invalid request - No code parameter found');
    }

    $code = sanitize_text_field($_GET['code']);
    $client_id = Jotunheim_Discord_Config::get_client_id();
    $client_secret = Jotunheim_Discord_Config::get_client_secret();
    $redirect_uri = Jotunheim_Discord_Config::get_redirect_uri();
    $guild_id = DISCORD_GUILD_ID;

    // Debug info
    error_log('OAuth Callback - Code received: ' . substr($code, 0, 10) . '...');
    error_log('Client ID: ' . $client_id);
    error_log('Redirect URI: ' . $redirect_uri);
    error_log('Client Secret length: ' . (strlen($client_secret) > 0 ? strlen($client_secret) : 'EMPTY!'));

    // Exchange the authorization code for an access token (just for user identity & email)
    $token_request_data = array(
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => $redirect_uri,
        'scope' => 'identify email'
    );

    error_log('Token request data: ' . json_encode($token_request_data));

    $response = wp_remote_post('https://discord.com/api/oauth2/token', array(
        'method' => 'POST',
        'timeout' => 45,
        'redirection' => 5,
        'httpversion' => '1.1',
        'blocking' => true,
        'headers' => array('Content-Type' => 'application/x-www-form-urlencoded'),
        'body' => $token_request_data,
    ));

    if (is_wp_error($response)) {
        error_log('Discord token request failed: ' . $response->get_error_message());
        wp_die('Failed to communicate with Discord: ' . $response->get_error_message());
    }

    $status_code = wp_remote_retrieve_response_code($response);
    $body = json_decode(wp_remote_retrieve_body($response), true);

    error_log('Discord token response status: ' . $status_code);
    error_log('Discord token response: ' . json_encode($body));

    if ($status_code !== 200 || !isset($body['access_token'])) {
        $error_description = isset($body['error_description']) ? $body['error_description'] : 'Unknown error';
        error_log('Failed to get access token. Error: ' . $error_description);
        wp_die('Failed to get access token. Error: ' . $error_description);
    }

    $access_token = sanitize_text_field($body['access_token']);

    // Get user information from Discord
    $user_response = wp_remote_get('https://discord.com/api/users/@me', array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $access_token,
        ),
    ));

    if (is_wp_error($user_response)) {
        wp_die('Failed to get user information from Discord.');
    }

    $user_data = json_decode(wp_remote_retrieve_body($user_response), true);

    if (!isset($user_data['id'])) {
        wp_die('Failed to get user information.');
    }

    $discord_user_id = sanitize_text_field($user_data['id']);
    $discord_email = isset($user_data['email']) ? sanitize_email($user_data['email']) : '';

    // Use the bot token to fetch the user's guild roles
    $bot_token = DISCORD_BOT_TOKEN;
    $guild_member_response = wp_remote_get("https://discord.com/api/guilds/{$guild_id}/members/{$discord_user_id}", array(
        'headers' => array(
            'Authorization' => 'Bot ' . $bot_token,
        ),
    ));

    $guild_member_data = null;
    if (!is_wp_error($guild_member_response)) {
        $guild_member_data = json_decode(wp_remote_retrieve_body($guild_member_response), true);
    }

    error_log('Guild Member Data: ' . print_r($guild_member_data, true));

    // Use guild nickname if available, otherwise fallback to global or username
    $discord_display_name = '';
    if (isset($guild_member_data['nick']) && !empty($guild_member_data['nick'])) {
        $discord_display_name = sanitize_text_field($guild_member_data['nick']);
    } else {
        $discord_display_name = !empty($user_data['global_name']) ? sanitize_text_field($user_data['global_name']) : sanitize_text_field($user_data['username']);
    }

    error_log('Final Discord Display Name Used: ' . $discord_display_name);

    // Check if a user with this display name or email exists
    $user_id = username_exists($discord_display_name);

    if (!$user_id && email_exists($discord_email)) {
        $user = get_user_by('email', $discord_email);
        if ($user) {
            $user_id = $user->ID;
        }
    }

    // If user doesn't exist, create one
    if (!$user_id) {
        $random_password = wp_generate_password(12, false);
        $user_id = wp_create_user($discord_display_name, $random_password, $discord_email);

        if (is_wp_error($user_id)) {
            wp_die('User creation failed.');
        }
    }

    // Update display name to match Discord display name
    wp_update_user(array(
        'ID' => $user_id,
        'display_name' => $discord_display_name,
    ));

    // Assign roles based on Discord roles
    $roles = $guild_member_data['roles'] ?? [];
    error_log('Discord Roles from Guild Data: ' . print_r($roles, true));

    $wp_role = 'view_only';  // Default role

    if (in_array('816462309274419250', $roles)) { // Admin role ID
        $wp_role = 'editor';
    } elseif (in_array('816452821208793128', $roles)) { // Moderator role ID
        $wp_role = 'moderator';
    } elseif (in_array('888273935282626580', $roles)) { // Chosen role ID
        $wp_role = 'subscriber';
    } elseif (in_array('895810058439491634', $roles) || in_array('816460882372460566', $roles)) { // Thrall or Banned
        $wp_role = 'view_only';
    }

    // For Thor and Odin, assign administrator
    if ($discord_user_id === '859390316410306560' || $discord_user_id === '190645182235017217') {
        $wp_role = 'administrator';
    }

    $user = new WP_User($user_id);
    $user->set_role($wp_role);

    // Additional custom roles
    if (in_array('895810058439491635', $roles)) { // Valkyrie
        $user->add_role('valkyrie');
    }

    if (in_array('816460882372460567', $roles)) { // Vithar
        $user->add_role('vithar');
    }

    // Save roles and Discord info
    update_user_meta($user_id, 'discord_roles', $roles);
    update_user_meta($user_id, 'discord_user_id', $discord_user_id);
    update_user_meta($user_id, 'discord_access_token', $access_token);

    // Log user in
    wp_set_auth_cookie($user_id);

    // Redirect
    $return_to = isset($_GET['return_to']) ? sanitize_text_field($_GET['return_to']) : home_url();
    wp_redirect($return_to);
    exit;
}

function create_custom_roles() {
    if (!get_role('view_only')) {
        add_role('view_only', 'View Only', array('read' => true));
    }
    if (!get_role('moderator')) {
        add_role('moderator', 'Moderator', array('read' => true));
    }
    if (!get_role('valkyrie')) {
        add_role('valkyrie', 'Valkyrie', array('read' => true));
    }
    if (!get_role('vithar')) {
        add_role('vithar', 'Vithar', array('read' => true));
    }
}
add_action('init', 'create_custom_roles');
