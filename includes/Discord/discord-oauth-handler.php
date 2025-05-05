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
    $client_id = DISCORD_CLIENT_ID;
    $client_secret = DISCORD_CLIENT_SECRET;
    $redirect_uri = DISCORD_REDIRECT_URI;
    $guild_id = DISCORD_GUILD_ID;

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

    // Check for Wiki Editor role
    if (in_array('1354867612324200599', $roles)) { // Wiki Editor role ID
        error_log('Wiki Editor role detected for user: ' . $discord_user_id);
        setup_wiki_editor_role();  // Ensure the role exists with proper capabilities
        $wp_role = 'wiki_editor';
        
        // Directly add capabilities to the user object that will be used for this session
        $user = new WP_User($user_id);
        $user->add_role('wiki_editor');
        
        // BasePress capabilities - get the actual post type
        $post_types = get_post_types([], 'objects');
        $basepress_post_type = 'knowledgebase'; // Default
        
        foreach ($post_types as $pt) {
            if (strpos(strtolower($pt->name), 'knowledge') !== false || 
                strpos(strtolower($pt->name), 'basepress') !== false) {
                $basepress_post_type = $pt->name;
                break;
            }
        }
        
        // Add all normal post-type editing capabilities
        $user->add_cap('edit_posts');
        $user->add_cap('publish_posts');
        $user->add_cap('edit_published_posts');
        
        // Add BasePress specific capabilities directly to user
        $user->add_cap('edit_basepress');
        $user->add_cap('basepress_edit_articles');
        $user->add_cap('basepress_edit_knowledgebases');
        $user->add_cap("edit_{$basepress_post_type}");
        $user->add_cap("edit_{$basepress_post_type}s");
        $user->add_cap("publish_{$basepress_post_type}s");
        $user->add_cap("edit_published_{$basepress_post_type}s");
        $user->add_cap("edit_others_{$basepress_post_type}s");
        
        // IMPORTANT: Article creation capability
        $user->add_cap("create_{$basepress_post_type}s");
        
        error_log('Added BasePress editing capabilities to user: ' . $discord_user_id);
    }

    // For Thor and Odin, assign administrator
    if ($discord_user_id === '859390316410306560' || $discord_user_id === '190645182235017217') {
        $wp_role = 'administrator';
    }

    // Log the final WordPress role being assigned
    error_log('Assigning WordPress role: ' . $wp_role . ' to user: ' . $discord_user_id);

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
