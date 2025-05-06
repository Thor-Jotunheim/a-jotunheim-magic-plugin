<?php
/**
 * Direct BasePress Header and Footer Override
 * This file contains aggressive overrides to force BasePress to use the theme header and footer
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Completely override BasePress templates
 */
add_action('init', 'jotunheim_basepress_complete_override', 999);
function jotunheim_basepress_complete_override() {
    // Force removal of any template actions BasePress might add
    remove_all_filters('template_include');
    remove_all_actions('get_header');
    remove_all_actions('get_footer');
    
    // Re-add our template include filter with highest priority
    add_filter('template_include', 'jotunheim_force_basepress_templates', 9999);
    
    // Force BasePress to use the default headers and footers
    if (function_exists('basepress_is_knowledge_base')) {
        remove_all_filters('basepress_get_header');
        remove_all_filters('basepress_get_footer');
        add_filter('basepress_get_header', 'jotunheim_basepress_force_theme_header', 9999);
        add_filter('basepress_get_footer', 'jotunheim_basepress_force_theme_footer', 9999);
    }
}

/**
 * Force normal theme header for BasePress
 */
function jotunheim_basepress_force_theme_header($name) {
    // This directly outputs the theme header
    get_header();
    
    // Add our wrapper for styling
    echo '<div id="jotunheim-kb-wrapper" class="jotunheim-kb-wrapper">';
    echo '<div class="jotunheim-kb-inner">';
    
    // Return empty to prevent BasePress from adding another header
    return '';
}

/**
 * Force normal theme footer for BasePress
 */
function jotunheim_basepress_force_theme_footer($name) {
    // Close our wrapper
    echo '</div>'; // .jotunheim-kb-inner
    echo '</div>'; // .jotunheim-kb-wrapper
    
    // This directly outputs the theme footer
    get_footer();
    
    // Return empty to prevent BasePress from adding another footer
    return '';
}

/**
 * Force our BasePress template files
 */
function jotunheim_force_basepress_templates($template) {
    if (!function_exists('basepress_is_knowledge_base')) {
        return $template;
    }
    
    // Only apply on BasePress pages
    if (basepress_is_knowledge_base()) {
        if (is_single()) {
            return plugin_dir_path(dirname(__DIR__)) . 'templates/basepress-direct-single.php';
        } elseif (is_search() && (isset($_GET['bp_search']) || isset($_GET['bp_post_type']))) {
            return plugin_dir_path(dirname(__DIR__)) . 'templates/basepress-direct-search.php';
        } elseif (is_tax('knowledgebase_cat')) {
            return plugin_dir_path(dirname(__DIR__)) . 'templates/basepress-direct-category.php';
        } elseif (basepress_is_knowledge_base_page()) {
            return plugin_dir_path(dirname(__DIR__)) . 'templates/basepress-direct-home.php';
        }
    }
    
    return $template;
}

/**
 * Add our custom CSS for BasePress with high priority
 */
add_action('wp_enqueue_scripts', 'jotunheim_kb_direct_styles', 9999);
function jotunheim_kb_direct_styles() {
    if (!function_exists('basepress_is_knowledge_base')) {
        return;
    }
    
    if (basepress_is_knowledge_base()) {
        // Remove any BasePress styles that might conflict
        wp_dequeue_style('basepress-style');
        wp_dequeue_style('basepress-theme-style');
        wp_dequeue_style('bpress-theme-style');
        wp_dequeue_style('bpress-style');
        
        // Add our custom styles with high priority
        wp_enqueue_style(
            'jotunheim-kb-direct-styles', 
            plugin_dir_url(dirname(__DIR__)) . 'assets/css/jotunheim-kb-direct.css',
            array(),
            time() // Force reload on each page load during development
        );
    }
}

/**
 * Add custom body class for easier styling
 */
add_filter('body_class', 'jotunheim_kb_direct_body_class');
function jotunheim_kb_direct_body_class($classes) {
    if (function_exists('basepress_is_knowledge_base') && basepress_is_knowledge_base()) {
        $classes[] = 'jotunheim-kb';
        $classes[] = 'jotunheim-kb-direct';
    }
    return $classes;
}