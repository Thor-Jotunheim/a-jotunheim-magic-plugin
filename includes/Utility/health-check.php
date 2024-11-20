<?php
    // health-check.php

    if (!defined('ABSPATH')) exit; // Exit if accessed directly

    function jotunheim_magic_health_check() {
     // Check for required features or configurations
     $issues = [];

    // Check: Verify if the database table exists
    global $wpdb;
    $itemlist_table = $wpdb->prefix . 'itemlist'; // Adjust as necessary
    if ($wpdb->get_var("SHOW TABLES LIKE '$itemlist_table'") != $itemlist_table) {
        $issues[] = "The ItemList table does not exist.";
    }

    // Check for minimum PHP version
    if (version_compare(PHP_VERSION, '7.4', '<')) {
        $issues[] = "PHP version is below 7.4. Please upgrade to a supported version.";
    }

    // Check for required WordPress version
    if (version_compare(get_bloginfo('version'), '5.0', '<')) {
        $issues[] = "WordPress version is below 5.0. Please upgrade to a supported version.";
    }

    // Log any issues found
    if (!empty($issues)) {
        foreach ($issues as $issue) {
            error_log("Jotunheim Magic Health Check: " . $issue);
        }
    }
    }

    // Run health check on plugin activation
    register_activation_hook(__FILE__, 'jotunheim_magic_health_check');