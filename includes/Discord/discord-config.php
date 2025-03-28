<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

/**
 * Discord configuration settings
 */
class Jotunheim_Discord_Config {
    /**
     * Get the Discord client ID
     */
    public static function get_client_id() {
        return defined('DISCORD_CLIENT_ID') ? DISCORD_CLIENT_ID : '1297908076929613956';
    }
    
    /**
     * Get the Discord client secret
     */
    public static function get_client_secret() {
        if (defined('DISCORD_CLIENT_SECRET') && !empty(DISCORD_CLIENT_SECRET)) {
            return DISCORD_CLIENT_SECRET;
        } else {
            error_log('WARNING: Discord client secret is not defined or empty!');
            return '';
        }
    }
    
    /**
     * Get the appropriate Discord redirect URI based on environment
     */
    public static function get_redirect_uri() {
        if (is_local_environment()) {
            // Local environment redirect URI
            return 'http://localhost/wp-admin/admin-ajax.php?action=oauth2callback';
        }
        
        // Production environment redirect URI
        return JOTUNHEIM_BASE_URL . '/wp-admin/admin-ajax.php?action=oauth2callback';
    }
    
    /**
     * Get the Discord authorization URL
     */
    public static function get_auth_url() {
        $client_id = self::get_client_id();
        $redirect_uri = self::get_redirect_uri();
        
        error_log('Discord OAuth Redirect URL: ' . $redirect_uri);
        
        return "https://discord.com/api/oauth2/authorize?client_id={$client_id}&redirect_uri=" . 
               urlencode($redirect_uri) . "&response_type=code&scope=identify%20email";
    }
}
