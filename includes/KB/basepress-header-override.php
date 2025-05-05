<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Force BasePress to use Zeever theme header
 */
function jotunheim_force_basepress_theme_header() {
    // Only apply on frontend BasePress pages
    if (is_admin() || !function_exists('is_basepress') || !is_basepress()) {
        return;
    }
    
    // Remove the default BasePress header render function
    remove_action('basepress_header', 'basepress_header_content');
    
    // Override the BasePress header with the Zeever theme header
    add_action('basepress_header', 'jotunheim_render_zeever_header');
}
add_action('template_redirect', 'jotunheim_force_basepress_theme_header');

/**
 * Render the Zeever theme header in place of BasePress header
 */
function jotunheim_render_zeever_header() {
    // We'll use output buffering to render the template part
    ob_start();
    
    // Render the Zeever theme header template part
    echo '<!-- wp:template-part {"slug":"header","theme":"zeever"} /-->';
    
    // Execute the template rendering via do_blocks
    echo do_blocks(ob_get_clean());
    
    // Add a wrapper div after the header for styling purposes
    echo '<div class="jotunheim-kb-after-header" style="margin-top: 20px;"></div>';
}