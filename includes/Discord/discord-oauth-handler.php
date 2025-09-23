<?php
// Prevent direct access to the file
if (!defined('ABSPATH')) exit;

// Hook into AJAX to handle the Discord OAuth2 callback
add_action('wp_ajax_oauth2callback', 'jotunheim_magic_handle_discord_oauth2_callback');
add_action('wp_ajax_nopriv_oauth2callback', 'jotunheim_magic_handle_discord_oauth2_callback');

function jotunheim_magic_handle_discord_oauth2_callback() {
    if (!isset($_GET['code'])) {
        wp_die('Invalid request');
    }

    $code = sanitize_text_field($_GET['code']);
    
    // Get Discord OAuth settings from configuration
    $oauth_settings = get_option('jotunheim_discord_oauth_settings', []);
    
    if (empty($oauth_settings['client_id']) || empty($oauth_settings['client_secret']) || 
        empty($oauth_settings['redirect_uri']) || empty($oauth_settings['bot_token']) || 
        empty($oauth_settings['guild_id'])) {
        wp_die('Discord OAuth is not properly configured. Please configure it in the admin panel.');
    }
    
    $client_id = $oauth_settings['client_id'];
    $client_secret = $oauth_settings['client_secret'];
    $redirect_uri = $oauth_settings['redirect_uri'];
    $guild_id = $oauth_settings['guild_id'];
    $bot_token = $oauth_settings['bot_token'];

    // Instead of using the user token to fetch roles, use a bot token and standard guild member endpoint.
    // Make sure you have a BOT token with the necessary privileges defined as DISCORD_BOT_TOKEN.
    // Your bot must have the "Server Members Intent" enabled for this to work.

    // Exchange the authorization code for an access token (just for user identity & email)
    $response = wp_remote_post('https://discord.com/api/oauth2/token', array(
        'body' => array(
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirect_uri,
            'scope' => 'identify email'
        ),
    ));

    if (is_wp_error($response)) {
        wp_die('Failed to communicate with Discord.');
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);
    if (!isset($body['access_token'])) {
        wp_die('Failed to get access token.');
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
        'user_login' => $discord_display_name, // Also update the username
    ));

    // Assign roles based on Discord roles using configurable system
    $roles = $guild_member_data['roles'] ?? [];
    error_log('Discord Roles from Guild Data: ' . print_r($roles, true));
    
    // Get configured Discord roles with levels
    $configured_roles = get_configured_discord_roles_with_levels();
    error_log('Configured Discord Roles with Levels: ' . print_r($configured_roles, true));

    $wp_role = 'view_only';  // Default role
    $highest_level = 0; // Track the highest level role assigned

    // Check against configured roles and assign based on level
    foreach ($configured_roles as $role_key => $role_info) {
        if (in_array($role_info['id'], $roles)) {
            $level = $role_info['level'];
            
            if ($level > $highest_level) {
                $highest_level = $level;
                
                // Assign WordPress roles based on Discord role level
                switch ($level) {
                    case 8: // Norn - Highest administrative role
                        $wp_role = 'administrator';
                        break;
                    case 7: // Aesir - Senior administrative role  
                    case 5: // Admin (combination of Norn/Aesir)
                        $wp_role = 'editor';
                        break;
                    case 6: // All Staff - General staff access role
                    case 4: // Staff
                    case 3: // Valkyrie
                    case 2: // Vithar
                        $wp_role = 'contributor';
                        break;
                    case 1: // Chosen - Basic/Member
                    default:
                        $wp_role = 'subscriber';
                        break;
                }
            }
        }
    }

    // Special hardcoded users for Thor and Odin (keep these as backup)
    if ($discord_user_id === '859390316410306560' || $discord_user_id === '190645182235017217') {
        $wp_role = 'administrator';
    }

    error_log("Assigned WordPress role: {$wp_role} based on highest Discord level: {$highest_level}");

    $user = new WP_User($user_id);
    $user->set_role($wp_role);

    // Note: Removed additional role assignment to prevent users from getting multiple WordPress roles
    // Only the single highest-priority role should be assigned based on Discord role hierarchy

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
