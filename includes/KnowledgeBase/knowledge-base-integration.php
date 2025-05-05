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
 * Direct override to ensure wiki_editors have full BasePress permissions
 */
function jotunheim_force_wiki_editor_basepress_access() {
    // Force wiki_editor into BasePress's allowed roles
    global $basepress_utils;
    if (!empty($basepress_utils) && isset($basepress_utils->allowed_roles)) {
        if (!in_array('wiki_editor', $basepress_utils->allowed_roles)) {
            $basepress_utils->allowed_roles[] = 'wiki_editor';
        }
    }
    
    // Make wiki_editor role have all necessary permissions
    if (current_user_can('wiki_editor')) {
        // Force manage categories capability for Sections page
        add_filter('map_meta_cap', function($caps, $cap, $user_id, $args) {
            if ($cap === 'manage_categories' || $cap === 'manage_options' || 
                strpos($cap, 'basepress_') === 0 || strpos($cap, 'manage_') === 0) {
                return array(); // Empty array passes the capability check
            }
            return $caps;
        }, 0, 4);
        
        // Ensure wiki_editor can edit all BasePress posts
        add_filter('user_has_cap', function($allcaps, $caps, $args, $user) {
            foreach ($caps as $cap) {
                if (strpos($cap, 'edit_') === 0 || 
                    strpos($cap, 'publish_') === 0 || 
                    strpos($cap, 'delete_') === 0) {
                    $allcaps[$cap] = true;
                }
                
                // Grant all BasePress-specific caps
                if (strpos($cap, 'basepress_') === 0 || 
                    $cap === 'manage_categories' || 
                    $cap === 'manage_options') {
                    $allcaps[$cap] = true;
                }
            }
            return $allcaps;
        }, 0, 4);
        
        // Direct override of BasePress permission checks
        add_filter('basepress_user_can_manage_sections', '__return_true');
        add_filter('basepress_user_can_manage_kbs', '__return_true');
        add_filter('basepress_user_can_manage_options', '__return_true');
        
        // Force access to the BasePress menu items in admin
        add_action('admin_menu', function() {
            if (function_exists('basepress_get_post_type')) {
                $kb_post_type = basepress_get_post_type();
                $parent_menu = 'edit.php?post_type=' . $kb_post_type;
                
                // Add Sections menu
                add_submenu_page(
                    $parent_menu,
                    'Sections',
                    'Sections',
                    'read', // Use a capability wiki_editor definitely has
                    'basepress_sections',
                    null // Let BasePress handle the actual callback
                );
                
                // Add Manage KBs menu
                add_submenu_page(
                    $parent_menu,
                    'Manage KBs',
                    'Manage KBs',
                    'read', // Use a capability wiki_editor definitely has
                    'basepress_manage_kbs',
                    null // Let BasePress handle the actual callback
                );
            }
        }, 9999); // Very late priority to ensure this runs after BasePress
    }
}
// Run early to ensure our hooks are in place before BasePress loads
add_action('plugins_loaded', 'jotunheim_force_wiki_editor_basepress_access', 1);

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