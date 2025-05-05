<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Knowledge Base Integration
 * 
 * This file handles the integration of the Knowledge Base functionality with WordPress
 * and includes functionality to ensure wiki editors have proper access.
 */

// Include the KB settings access override for wiki editors
require_once(plugin_dir_path(__FILE__) . 'kb-settings-access.php');

// Include direct access override for wiki editors
require_once(plugin_dir_path(__FILE__) . 'wiki-editor-basepress-access.php');

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

/**
 * Ensure edit links are visible in admin for wiki editors
 */
function jotunheim_ensure_kb_edit_links() {
    $screen = get_current_screen();
    if (!$screen) return;
    
    // Get the proper knowledge base post type
    $kb_post_type = function_exists('basepress_get_post_type') ? basepress_get_post_type() : 'knowledgebase';
    
    // Only run on knowledge base listing page
    if ($screen->post_type !== $kb_post_type) return;
    
    // Add JavaScript to ensure edit links and row actions are visible
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            // PRIORITY: Add the Add New button if missing (with higher visibility)
            if ($('.page-title-action').length === 0) {
                // Add prominent Add New button
                var addNewBtn = $('<a>').attr({
                    'href': '<?php echo esc_url(admin_url("post-new.php?post_type=" . $kb_post_type)); ?>',
                    'class': 'page-title-action'
                }).text('Add New');
                
                // Add the button after the title
                $('.wp-heading-inline').after(addNewBtn);
                
                // Also add a more prominent button at the top if the standard one might be hidden
                var prominentBtn = $('<div>').css({
                    'margin': '10px 0 20px',
                    'text-align': 'center'
                }).append(
                    $('<a>').attr({
                        'href': '<?php echo esc_url(admin_url("post-new.php?post_type=" . $kb_post_type)); ?>',
                        'class': 'button button-primary button-large'
                    }).text('Create New Knowledge Base Article').css({
                        'padding': '8px 20px',
                        'font-size': '16px'
                    })
                );
                
                // Add the prominent button at the top of the page
                $('.wp-header-end').after(prominentBtn);
            }
            
            // Make sure row actions are visible
            $('.row-actions').css('left', 'auto').css('position', 'relative');
            
            // Add edit buttons to rows if missing
            $('tbody tr').each(function() {
                var $row = $(this);
                var postId = $row.attr('id') ? $row.attr('id').replace('post-', '') : null;
                
                if (postId && $row.find('.row-actions .edit').length === 0) {
                    var editUrl = '<?php echo esc_url(admin_url("post.php?action=edit&post=")); ?>' + postId;
                    var editLink = '<span class="edit"><a href="' + editUrl + '">Edit</a> | </span>';
                    
                    if ($row.find('.row-actions').length === 0) {
                        $row.find('.title').append('<div class="row-actions">' + editLink + '</div>');
                    } else {
                        $row.find('.row-actions').prepend(editLink);
                    }
                }
            });
            
            // If the post rows use a different structure, add our custom buttons
            if ($('.wp-list-table tbody tr').length > 0 && $('.row-actions .edit').length === 0) {
                $('.wp-list-table tbody tr').each(function() {
                    var $row = $(this);
                    var $titleCell = $row.find('td.title, td.column-title');
                    
                    if ($titleCell.length > 0) {
                        var title = $titleCell.find('a').first().text();
                        var href = $titleCell.find('a').first().attr('href');
                        var postId = href ? href.match(/post=(\d+)/) : null;
                        
                        if (postId && postId[1]) {
                            var editUrl = '<?php echo esc_url(admin_url("post.php?action=edit&post=")); ?>' + postId[1];
                            var editButton = '<a href="' + editUrl + '" class="button button-small" style="margin-left: 10px;">Edit</a>';
                            $titleCell.append(editButton);
                        }
                    }
                });
            }
        });
    </script>
    
    <style>
    /* Custom CSS to ensure the Add New button is visible */
    .wrap h1.wp-heading-inline + a.page-title-action {
        display: inline-block !important;
        visibility: visible !important;
    }
    </style>
    <?php
}
add_action('admin_head', 'jotunheim_ensure_kb_edit_links');

/**
 * Add Edit Article button for wiki editors on the frontend
 */
function jotunheim_kb_add_frontend_edit_button() {
    // Only continue for logged in users
    if (!is_user_logged_in()) return;
    
    // Only run on singular pages
    if (!is_singular()) return;
    
    // Get the current post
    global $post;
    if (!$post) return;
    
    // Check if current post is a BasePress KB article
    $kb_post_type = function_exists('basepress_get_post_type') ? basepress_get_post_type() : 'knowledgebase';
    
    // Check if current post is a KB article or if we're on a BasePress template
    $is_kb_article = ($post->post_type === $kb_post_type) || 
                    (function_exists('is_basepress') && is_basepress());
    
    if (!$is_kb_article) return;
    
    // Check if user has permission to edit this post
    if (!current_user_can('edit_post', $post->ID) && 
        !current_user_can('edit_' . $kb_post_type) && 
        !current_user_can('edit_' . $kb_post_type . 's')) {
        return;
    }
    
    // Get edit link - try multiple methods
    $edit_link = '';
    
    // Try standard WordPress function
    if (function_exists('get_edit_post_link')) {
        $edit_link = get_edit_post_link($post->ID);
    }
    
    // If no link, create a manual link
    if (!$edit_link) {
        $edit_link = admin_url('post.php?post=' . $post->ID . '&action=edit');
    }
    
    // Output the edit button with enhanced styling and visibility
    ?>
    <style>
        .jotunheim-kb-edit-button {
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 999999;
            background-color: #2271b1;
            color: #fff;
            padding: 10px 15px;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none !important;
            border-radius: 3px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            border: 2px solid white;
        }
        
        .jotunheim-kb-edit-button:hover,
        .jotunheim-kb-edit-button:focus,
        .jotunheim-kb-edit-button:active {
            background-color: #135e96;
            color: #fff !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            text-decoration: none !important;
        }
        
        .jotunheim-kb-edit-button svg {
            width: 16px;
            height: 16px;
        }
        
        @media (max-width: 768px) {
            .jotunheim-kb-edit-button {
                top: auto;
                bottom: 20px;
                right: 20px;
            }
        }
    </style>
    
    <a href="<?php echo esc_url($edit_link); ?>" class="jotunheim-kb-edit-button">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
        </svg>
        Edit Article
    </a>
    <?php
}
// Hook into both wp_footer and basepress specific hooks
add_action('wp_footer', 'jotunheim_kb_add_frontend_edit_button', 999);
add_action('basepress_after_content', 'jotunheim_kb_add_frontend_edit_button', 999);

/**
 * Restore header styling for wiki editors
 */
function restore_header_styling_for_wiki_editors() {
    if (current_user_can('wiki_editor')) {
        ?>
        <style>
            /* Ensure header elements are visible */
            .site-header,
            .site-header img,
            .site-branding,
            .site-logo,
            .custom-logo-link,
            .custom-logo,
            .header-image {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                max-height: none !important;
            }
            
            /* Fix admin bar positioning if needed */
            html {
                margin-top: 32px !important;
            }
            
            /* Additional fixes for BasePress settings pages */
            .basepress-settings input[type="submit"],
            .basepress-settings .button-primary {
                display: inline-block !important;
            }
            
            /* Ensure all header elements load correctly */
            img.header-image {
                max-width: 100% !important;
                height: auto !important;
            }
        </style>
        <?php
    }
}
add_action('wp_head', 'restore_header_styling_for_wiki_editors');
add_action('admin_head', 'restore_header_styling_for_wiki_editors');