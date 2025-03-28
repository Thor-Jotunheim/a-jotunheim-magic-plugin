<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

/**
 * Controls development environment settings
 */
function jotunheim_configure_dev_environment() {
    // Only run in local environment
    if (!is_local_environment()) return;
    
    // Disable Xdebug if it's active
    if (extension_loaded('xdebug')) {
        ini_set('xdebug.remote_enable', 'Off');
        ini_set('xdebug.profiler_enable', 'Off');
        ini_set('xdebug.default_enable', 'Off');
        if (function_exists('xdebug_disable')) {
            xdebug_disable();
        }
    }
}

// Run early in the WordPress execution cycle
add_action('plugins_loaded', 'jotunheim_configure_dev_environment', 5);
