<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Knowledge Base Integration
 * 
 * This file handles the integration of the Knowledge Base functionality with WordPress
 * and includes functionality to ensure wiki editors have proper access.
 */

// Include the wiki editor role definition with all BasePress access functionality
require_once(plugin_dir_path(dirname(__FILE__)) . 'Roles/wiki-editor-role.php');

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
 * Add the Wiki Editor role to BasePress editors
 * This ensures wiki editors are recognized by BasePress
 */
function jotunheim_add_wiki_editor_to_basepress($roles) {
    if (!in_array('wiki_editor', $roles)) {
        $roles[] = 'wiki_editor';
    }
    return $roles;
}
add_filter('basepress_editor_roles', 'jotunheim_add_wiki_editor_to_basepress');
add_filter('basepress_allowed_roles', 'jotunheim_add_wiki_editor_to_basepress');

/**
 * Add required scripts and styles for front-end
 */
function jotunheim_enqueue_knowledge_base_scripts() {
    if (has_shortcode(get_the_content(), 'jotunheim_knowledge_base')) {
        wp_enqueue_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'jotunheim_enqueue_knowledge_base_scripts');

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