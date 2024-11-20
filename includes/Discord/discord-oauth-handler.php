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
    $client_id = '1297908076929613956';
    $client_secret = 'WzapYHJlj3P0XgwsBC9GATzrSs1kwi4z';
    $redirect_uri = 'https://jotun.games/wp-admin/admin-ajax.php?action=oauth2callback';

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
    
    // Fetch the user's guild (server) specific nickname (this stays as-is)
    $guild_id = '816387080334737436';  // Your Discord server (guild) ID
    $guild_member_response = wp_remote_get("https://discord.com/api/guilds/{$guild_id}/members/{$discord_user_id}", array(
        'headers' => array(
            'Authorization' => 'Bot MTI5NzkwODA3NjkyOTYxMzk1Ng.GrCF_s.Alz6b563skzSJIHDIwoKlR3bTok4S6W1dvIcMc',
        ),
    ));
    
    $guild_member_data = null;
    if (!is_wp_error($guild_member_response)) {
        $guild_member_data = json_decode(wp_remote_retrieve_body($guild_member_response), true);
    }
    
    // Fetch user API key and cache login state
        global $wpdb;
        $table_name = 'jotun_user_api_key';

        // Check if user exists in the jotun_user_api_key table
        $user_api_key_data = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table_name WHERE discord_user_id = %s",
            $discord_user_id
        ));

        if ($user_api_key_data) {
            // Cache user login state
            update_user_meta($user_id, 'logged_in_user', array(
                'discord_user_id' => $discord_user_id,
                'api_key' => $user_api_key_data->api_key,
                'permissions' => $user_api_key_data->permissions
            ));

            // Assign roles based on permissions using role-access logic
            if (function_exists('assign_roles_from_permissions')) {
                assign_roles_from_permissions($user_id, $user_api_key_data->permissions);
            }
            
            // Log the user in
            wp_set_auth_cookie($user_id);

        } else {
            wp_die('User not authorized. Please contact an administrator.');
    }
    
    // Continue with the rest of your code...
    
    // Ensure we log the guild member data for debugging purposes
    error_log('Guild Member Data: ' . print_r($guild_member_data, true));

    // Use guild nickname if available, otherwise fallback to global name or username
    $discord_display_name = '';
    if (isset($guild_member_data['nick']) && !empty($guild_member_data['nick'])) {
        $discord_display_name = sanitize_text_field($guild_member_data['nick']);
    } else {
        // Fallback to Discord's global_name or username
        $discord_display_name = !empty($user_data['global_name']) ? sanitize_text_field($user_data['global_name']) : sanitize_text_field($user_data['username']);
    }

    error_log('Final Discord Display Name Used: ' . $discord_display_name);  // Debugging log

    // Check if a user with this display name or email exists
    $user_id = username_exists($discord_display_name);

    if (!$user_id && email_exists($discord_email)) {
        // If username doesn't exist but the email exists, get the user by email
        $user = get_user_by('email', $discord_email);
        if ($user) {
            $user_id = $user->ID;
        }
    }

    // If user doesn't exist by username or email, create the user
    if (!$user_id) {
        $random_password = wp_generate_password(12, false);
        $user_id = wp_create_user($discord_display_name, $random_password, $discord_email);

        // Check for error in user creation
        if (is_wp_error($user_id)) {
            wp_die('User creation failed.');
        }
    }

    // Update the display name in WordPress to match Discord display name
    wp_update_user(array(
        'ID' => $user_id,
        'display_name' => $discord_display_name,
    ));

    // Assign roles based on Discord server roles
    $roles = $guild_member_data['roles'] ?? [];
    error_log('Discord Roles from Guild Data: ' . print_r($roles, true));  // Debugging roles

    $wp_role = 'view_only';  // Default role if no other roles match

    if (in_array('816462309274419250', $roles)) { // Admin role ID
        $wp_role = 'editor';
    } elseif (in_array('816452821208793128', $roles)) { // Moderator role ID
        $wp_role = 'moderator';
    } elseif (in_array('888273935282626580', $roles)) { // Chosen role ID
        $wp_role = 'subscriber';
    } elseif (in_array('895810058439491634', $roles) || in_array('816460882372460566', $roles)) { // Thrall or Banned role
        $wp_role = 'view_only';
   }

    // For Thor and Odin, assign administrator role
    if ($discord_user_id === '859390316410306560' || $discord_user_id === '190645182235017217') {
        $wp_role = 'administrator';
    }

    // Assign WordPress role
    $user = new WP_User($user_id);
    $user->set_role($wp_role);

    // Additional roles for Valkyrie and Vithar
    if (in_array('895810058439491635', $roles)) { // Valkyrie Discord role ID
        $user->add_role('valkyrie');
    }

    if (in_array('816460882372460567', $roles)) { // Vithar Discord role ID
        $user->add_role('vithar');
    }

    // Save Discord roles in user meta
    update_user_meta($user_id, 'discord_roles', $roles);

    // Store the Discord user ID and access token in user meta
    update_user_meta($user_id, 'discord_user_id', $discord_user_id);
    update_user_meta($user_id, 'discord_access_token', $access_token);

    // Log the user in
    wp_set_auth_cookie($user_id);

    // Redirect to the homepage or the intended page
    $return_to = isset($_GET['return_to']) ? sanitize_text_field($_GET['return_to']) : home_url();
    wp_redirect($return_to);
    exit;
}

// Create the custom roles if they don't exist
function create_custom_roles() {
    if (!get_role('view_only')) {
        add_role('view_only', 'View Only', array(
            'read' => true,
        ));
    }

    if (!get_role('moderator')) {
        add_role('moderator', 'Moderator', array(
            'read' => true,
        ));
    }

    if (!get_role('valkyrie')) {
        add_role('valkyrie', 'Valkyrie', array(
            'read' => true,
        ));
    }

    if (!get_role('vithar')) {
        add_role('vithar', 'Vithar', array(
            'read' => true,
        ));
    }
}
add_action('init', 'create_custom_roles');