<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Knowledge Base Integration
 * 
 * This file handles the integration of the Knowledge Base functionality with WordPress
 * and includes functionality to ensure wiki editors have proper access.
 */

/**
 * Register knowledge base shortcode
 */
function jotunheim_register_knowledge_base_shortcode() {
    add_shortcode('jotunheim_knowledge_base', 'jotunheim_knowledge_base_shortcode');
}
add_action('init', 'jotunheim_register_knowledge_base_shortcode');

/**
 * Knowledge Base shortcode callback
 */
function jotunheim_knowledge_base_shortcode($atts) {
    // Include the interface file
    require_once(plugin_dir_path(__FILE__) . 'knowledge-base-interface.php');
    
    // Return the knowledge base interface
    return jotunheim_knowledge_base_interface();
}

/**
 * Ensure the wiki_editor role has proper permissions for the knowledge base
 */
function jotunheim_ensure_wiki_editor_kb_permissions() {
    // Only run if BasePress is active
    if (!function_exists('basepress_get_post_type') && !post_type_exists('knowledgebase')) {
        return;
    }
    
    // Get the proper knowledge base post type
    $kb_post_type = function_exists('basepress_get_post_type') ? basepress_get_post_type() : 'knowledgebase';
    error_log("BasePress post type detected: " . $kb_post_type);
    
    // Create or get the wiki_editor role
    if (!get_role('wiki_editor')) {
        add_role('wiki_editor', 'Wiki Editor', array('read' => true));
    }
    
    $wiki_role = get_role('wiki_editor');
    
    // Add media upload capabilities
    $wiki_role->add_cap('upload_files');
    $wiki_role->add_cap('read');
    
    // Add knowledge base specific capabilities
    $wiki_role->add_cap('edit_' . $kb_post_type);
    $wiki_role->add_cap('edit_' . $kb_post_type . 's');
    $wiki_role->add_cap('publish_' . $kb_post_type . 's');
    $wiki_role->add_cap('edit_published_' . $kb_post_type . 's');
    $wiki_role->add_cap('edit_others_' . $kb_post_type . 's');
}
add_action('init', 'jotunheim_ensure_wiki_editor_kb_permissions', 20);

/**
 * Add the Wiki Editor role to BasePress editors
 */
function jotunheim_add_wiki_editor_to_basepress_editors($roles) {
    $roles[] = 'wiki_editor';
    return $roles;
}
add_filter('basepress_editor_roles', 'jotunheim_add_wiki_editor_to_basepress_editors');
add_filter('basepress_allowed_roles', 'jotunheim_add_wiki_editor_to_basepress_editors');

/**
 * Add New+ button to admin interface for knowledge base
 */
function jotunheim_add_kb_new_button() {
    global $current_screen;
    
    // Only add button on knowledge base listing page
    if (!$current_screen || !property_exists($current_screen, 'post_type')) {
        return;
    }
    
    // Get the proper knowledge base post type
    $kb_post_type = function_exists('basepress_get_post_type') ? basepress_get_post_type() : 'knowledgebase';
    
    if ($current_screen->post_type === $kb_post_type && current_user_can('edit_' . $kb_post_type . 's')) {
        // Add the New+ button via JS
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                // Check if the add new button is missing
                if ($('.page-title-action').length === 0) {
                    // Add the New+ button
                    var button = $('<a>').attr({
                        'href': '<?php echo esc_url(admin_url("post-new.php?post_type=" . $kb_post_type)); ?>',
                        'class': 'page-title-action'
                    }).text('New+');
                    
                    // Add the button after the title
                    $('.wp-heading-inline').after(button);
                }
            });
        </script>
        <?php
    }
}
add_action('admin_head', 'jotunheim_add_kb_new_button');