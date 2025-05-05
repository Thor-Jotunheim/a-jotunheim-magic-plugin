<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Direct Core Override for Wiki Editors
 */

// Hook before WordPress checks permissions
add_action('init', 'jot_wiki_core_override', 1);
add_action('admin_init', 'jot_wiki_admin_override', 1);
add_action('current_screen', 'jot_wiki_screen_override', 1);
add_filter('user_has_cap', 'jot_wiki_bypass_caps', 999999, 4);

/**
 * Core capability override on init
 */
function jot_wiki_core_override() {
    // Only for logged in users
    if (!is_user_logged_in()) return;
    
    // Check if user is a wiki editor
    $user = wp_get_current_user();
    if (!in_array('wiki_editor', (array)$user->roles)) return;
    
    // Direct capability overrides
    global $current_user;
    $current_user->allcaps['manage_options'] = true;
    $current_user->allcaps['edit_theme_options'] = true;
    $current_user->allcaps['administrator'] = true;
    $current_user->allcaps['basepress_settings_capability'] = true;
    $current_user->allcaps['basepress_sections_capability'] = true;
    $current_user->allcaps['basepress_products_capability'] = true;
    
    // BasePress direct override
    if (isset($_GET['post_type']) && $_GET['post_type'] === 'knowledgebase' && 
        isset($_GET['page']) && $_GET['page'] === 'basepress_settings') {
            
        // Force set user as admin temporarily
        $current_user->caps['administrator'] = true;
        $current_user->roles[] = 'administrator';
            
        // Override BasePress capability checks
        add_filter('basepress_settings_capability', '__return_empty_string', 99999);
        add_filter('basepress_sections_capability', '__return_empty_string', 99999);
        add_filter('basepress_products_capability', '__return_empty_string', 99999);
        
        // Short-circuit all capability checks
        add_filter('map_meta_cap', function($caps, $cap) {
            return array('exist'); // 'exist' is a cap that all users have
        }, 999999, 2);
        
        // Add debug notice
        add_action('admin_notices', function() {
            echo '<div class="notice notice-success"><p><strong>Wiki Access:</strong> Core override active.</p></div>';
        });
    }
}

/**
 * Admin capability override
 */
function jot_wiki_admin_override() {
    // Only for wiki editors
    if (!current_user_can('wiki_editor')) return;
    
    // Only on BasePress settings pages
    if (!isset($_GET['post_type']) || $_GET['post_type'] !== 'knowledgebase' || 
        !isset($_GET['page']) || $_GET['page'] !== 'basepress_settings') {
        return;
    }
    
    // Global variable overrides
    global $pagenow;
    add_filter('option_page_capability_basepress_settings', '__return_empty_string');
    
    // Direct capability functions override
    if (!function_exists('current_user_can_original')) {
        function current_user_can_original($capability) {
            // Always return true for wiki editors on these pages
            return true;
        }
        
        // Override the current_user_can function
        if (!function_exists('override_function')) {
            function override_function($function_name, $new_function) {
                runkit_function_rename($function_name, $function_name . '_original');
                runkit_function_add($function_name, '', $new_function);
            }
            
            // Try to override if runkit is available
            if (function_exists('runkit_function_rename')) {
                override_function('current_user_can', 'return true;');
            }
        }
    }
    
    // Direct JavaScript override (last resort)
    add_action('admin_head', function() {
        echo '<script type="text/javascript">
            // Force visibility of all form elements
            document.addEventListener("DOMContentLoaded", function() {
                var forms = document.querySelectorAll("form"); 
                forms.forEach(function(form) {
                    form.style.display = "block";
                    form.style.visibility = "visible";
                    form.style.opacity = "1";
                    
                    var elements = form.elements;
                    for (var i = 0; i < elements.length; i++) {
                        elements[i].style.display = "inline-block";
                        elements[i].style.visibility = "visible";
                    }
                });
                
                // Force BasePress content visibility
                var basepress = document.querySelectorAll(".basepress-settings, .basepress-sections-wrapper, .basepress-tabs"); 
                basepress.forEach(function(elem) {
                    elem.style.display = "block";
                    elem.style.visibility = "visible";
                });
                
                // Force BasePress tabs to work
                var tabs = document.querySelectorAll(".nav-tab-wrapper .nav-tab");
                tabs.forEach(function(tab) {
                    tab.style.display = "inline-block";
                    tab.style.visibility = "visible";
                    tab.style.opacity = "1";
                });
            });
        </script>';
    }, 999999);
}

/**
 * Screen setup override for wiki editors
 */
function jot_wiki_screen_override($screen) {
    if (!current_user_can('wiki_editor')) return;
    
    // Only when editing BasePress settings
    if (!isset($_GET['post_type']) || $_GET['post_type'] !== 'knowledgebase' ||
        !isset($_GET['page']) || $_GET['page'] !== 'basepress_settings') {
        return;
    }
    
    // Special handling for sections and products tabs
    if (isset($_GET['tab']) && ($_GET['tab'] === 'sections' || $_GET['tab'] === 'products')) {
        // Force WordPress to treat user as admin on this page
        global $current_user;
        $current_user->allcaps['administrator'] = true;
    }
}

/**
 * Direct capability bypass for wiki editors
 */
function jot_wiki_bypass_caps($allcaps, $caps, $args, $user) {
    // Only process for wiki editors
    if (!in_array('wiki_editor', (array)$user->roles)) {
        return $allcaps;
    }
    
    // Only on BasePress settings pages
    if (!isset($_GET['post_type']) || $_GET['post_type'] !== 'knowledgebase' ||
        !isset($_GET['page']) || $_GET['page'] !== 'basepress_settings') {
        return $allcaps;
    }
    
    // Grant ALL capabilities on these pages
    foreach ($caps as $cap) {
        $allcaps[$cap] = true;
    }
    
    // Add specific admin capabilities
    $admin_caps = array(
        'manage_options',
        'administrator',
        'edit_theme_options',
        'manage_categories',
        'edit_plugins',
        'activate_plugins',
        'basepress_settings_capability',
        'basepress_sections_capability', 
        'basepress_products_capability',
    );
    
    foreach ($admin_caps as $cap) {
        $allcaps[$cap] = true;
    }
    
    return $allcaps;
}

// Initialize immediately
jot_wiki_core_override();