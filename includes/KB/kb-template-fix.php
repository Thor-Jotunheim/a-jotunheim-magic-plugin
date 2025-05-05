<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Simple fixes for BasePress templates to use the theme header and footer
 */
function jotunheim_fix_kb_templates() {
    // Only run on frontend
    if (is_admin()) {
        return;
    }

    // Remove BasePress actions that might be overriding the header
    add_action('wp_head', 'jotunheim_remove_basepress_template_actions', 1);
    
    // Add theme header and footer to BasePress templates
    add_action('basepress_before_main_content', 'jotunheim_add_theme_header', 1);
    add_action('basepress_after_main_content', 'jotunheim_add_theme_footer', 999);
}
add_action('wp', 'jotunheim_fix_kb_templates');

/**
 * Remove BasePress template actions that might override theme templates
 */
function jotunheim_remove_basepress_template_actions() {
    // Check if we're on a KB page
    if (!jotunheim_is_kb_page()) {
        return;
    }
    
    // Remove any actions that might be overriding the header
    remove_all_actions('basepress_header');
}

/**
 * Add theme header to BasePress templates
 */
function jotunheim_add_theme_header() {
    // Only for KB pages
    if (!jotunheim_is_kb_page()) {
        return;
    }
    
    // Output theme header
    get_header();
    
    // Add a wrapper to apply custom styling
    echo '<div class="jotunheim-kb-wrapper">';
}

/**
 * Add theme footer to BasePress templates
 */
function jotunheim_add_theme_footer() {
    // Only for KB pages
    if (!jotunheim_is_kb_page()) {
        return;
    }
    
    // Close wrapper div
    echo '</div><!-- .jotunheim-kb-wrapper -->';
    
    // Output theme footer
    get_footer();
}

/**
 * Check if current page is a KB page
 */
function jotunheim_is_kb_page() {
    return (
        is_singular('knowledgebase') || 
        is_post_type_archive('knowledgebase') || 
        is_tax('kb_category') ||
        (function_exists('is_basepress') && is_basepress())
    );
}

/**
 * Add KB-specific CSS for styling
 */
function jotunheim_add_kb_styling() {
    if (!jotunheim_is_kb_page()) {
        return;
    }
    
    // Add basic CSS to integrate KB with theme
    ?>
    <style type="text/css">
        .jotunheim-kb-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        body.knowledgebase-template-default #main-header,
        body.knowledgebase-template-default #main-footer {
            display: block !important;
        }
    </style>
    <?php
}
add_action('wp_head', 'jotunheim_add_kb_styling');