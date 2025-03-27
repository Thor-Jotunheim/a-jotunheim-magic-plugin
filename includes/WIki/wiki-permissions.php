<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

class Jotunheim_Wiki_Permissions {
    /**
     * Check if current user can edit wiki
     */
    public static function current_user_can_edit_wiki() {
        // Always allow administrators to edit
        if (current_user_can('administrator')) {
            return true;
        }
        
        // Check if user is logged in
        if (!is_user_logged_in()) {
            return false;
        }
        
        // Get current user
        $user = wp_get_current_user();
        
        // Check if the user has Discord ID (Use your existing meta key)
        $discord_id = get_user_meta($user->ID, 'discord_id', true);
        if (empty($discord_id)) {
            return false;
        }
        
        // Check Discord roles
        return self::user_has_wiki_editor_role($discord_id);
    }
    
    /**
     * Check if user has the Wiki Editor role on Discord
     */
    public static function user_has_wiki_editor_role($discord_id) {
        try {
            // Get Discord client using your existing setup
            // This assumes you have a bot token in your options
            $discord_bot_token = get_option('jotunheim_discord_bot_token');
            $discord_guild_id = get_option('jotunheim_discord_guild_id');
            
            if (empty($discord_bot_token) || empty($discord_guild_id)) {
                error_log('Discord bot token or guild ID not configured');
                return false;
            }
            
            // Initialize Discord client
            $discord = new \RestCord\DiscordClient(['token' => $discord_bot_token]);
            
            // Get user's roles in the guild
            $member = $discord->guild->getGuildMember([
                'guild.id' => (int) $discord_guild_id,
                'user.id' => (int) $discord_id
            ]);
            
            // Get all guild roles
            $guild_roles = $discord->guild->getGuildRoles(['guild.id' => (int) $discord_guild_id]);
            
            // Find Wiki Editor role ID
            $wiki_editor_role_id = null;
            foreach ($guild_roles as $role) {
                if ($role->name === 'Wiki Editor') {
                    $wiki_editor_role_id = $role->id;
                    break;
                }
            }
            
            // Check if user has Wiki Editor role
            if (!$wiki_editor_role_id || !in_array($wiki_editor_role_id, $member->roles)) {
                return false;
            }
            
            return true;
            
        } catch (\Exception $e) {
            error_log('Discord role check error: ' . $e->getMessage());
            return false;
        }
    }
}
