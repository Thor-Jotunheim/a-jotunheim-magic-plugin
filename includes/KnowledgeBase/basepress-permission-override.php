<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * BasePress Permission Override
 * 
 * This file directly modifies BasePress's permission system to grant wiki editors full access.
 */

/**
 * Initialize the permission overrides
 */
function jotunheim_init_basepress_permission_override() {
    // We need to run before BasePress loads
    if (current_user_can('wiki_editor')) {
        // Attack the problem from multiple angles
        
        // 1. Modify the $submenu global directly to ensure menu items appear
        add_action('admin_menu', 'jotunheim_force_basepress_menu_items', 9999);
        
        // 2. Modify capability checks
        add_filter('user_has_cap', 'jotunheim_force_basepress_capabilities', 0, 4);
        
        // 3. Remove and recreate the Sections page class
        add_action('admin_menu', 'jotunheim_recreate_basepress_sections_page', 5);
        
        // 4. Run a script to force-add menu items via JavaScript
        add_action('admin_footer', 'jotunheim_inject_basepress_menu_items');
    }
}
add_action('admin_init', 'jotunheim_init_basepress_permission_override', 1);

/**
 * Force BasePress menu items to appear for wiki editors
 */
function jotunheim_force_basepress_menu_items() {
    global $submenu;
    
    // Only apply to wiki editor
    if (!current_user_can('wiki_editor') || current_user_can('administrator')) {
        return;
    }
    
    // Get KB post type
    $kb_post_type = function_exists('basepress_get_post_type') ? basepress_get_post_type() : 'knowledgebase';
    $parent = 'edit.php?post_type=' . $kb_post_type;
    
    // Check if the parent menu exists
    if (!isset($submenu[$parent])) {
        return;
    }
    
    // Find if the sections and manage KBs items already exist
    $sections_exists = false;
    $manage_kb_exists = false;
    
    foreach ($submenu[$parent] as $item) {
        if (isset($item[2]) && $item[2] === 'basepress_sections') {
            $sections_exists = true;
        }
        if (isset($item[2]) && $item[2] === 'basepress_manage_kbs') {
            $manage_kb_exists = true;
        }
    }
    
    // Add the sections menu item if it doesn't exist
    if (!$sections_exists) {
        $submenu[$parent][] = array(
            'Sections',
            'read',
            'basepress_sections',
            'Sections'
        );
    }
    
    // Add the manage KBs menu item if it doesn't exist
    if (!$manage_kb_exists) {
        $submenu[$parent][] = array(
            'Manage KBs',
            'read',
            'basepress_manage_kbs',
            'Manage KBs'
        );
    }
}

/**
 * Force BasePress capabilities for wiki editor
 */
function jotunheim_force_basepress_capabilities($allcaps, $caps, $args, $user) {
    // Only apply to wiki editor role
    if (!in_array('wiki_editor', $user->roles) || in_array('administrator', $user->roles)) {
        return $allcaps;
    }
    
    // Grant all capabilities related to BasePress
    $allcaps['manage_categories'] = true;
    $allcaps['manage_options'] = true;
    $allcaps['basepress_manage_sections'] = true;
    $allcaps['basepress_manage_kbs'] = true;
    $allcaps['basepress_manage_options'] = true;
    $allcaps['manage_basepress'] = true;
    $allcaps['edit_knowledgebase'] = true;
    $allcaps['edit_knowledgebases'] = true;
    $allcaps['edit_others_knowledgebases'] = true;
    $allcaps['edit_published_knowledgebases'] = true;
    $allcaps['edit_private_knowledgebases'] = true;
    
    return $allcaps;
}

/**
 * Recreate the BasePress sections page with different permission check
 */
function jotunheim_recreate_basepress_sections_page() {
    // Only apply to wiki editor
    if (!current_user_can('wiki_editor') || current_user_can('administrator')) {
        return;
    }
    
    // Remove standard admin menu actions from BasePress and add our own
    remove_action('admin_menu', array('Basepress_Sections_Page', 'add_sections_page'), 10);
    
    // Get KB post type
    $kb_post_type = function_exists('basepress_get_post_type') ? basepress_get_post_type() : 'knowledgebase';
    
    // Add our own sections page
    add_submenu_page(
        'edit.php?post_type=' . $kb_post_type,
        'BasePress Sections',
        'Sections',
        'read',
        'basepress_sections',
        'jotunheim_render_basepress_sections_page'
    );
    
    // Add our own manage KBs page
    add_submenu_page(
        'edit.php?post_type=' . $kb_post_type,
        'Manage KBs',
        'Manage KBs',
        'read',
        'basepress_manage_kbs',
        'jotunheim_render_basepress_manage_kbs_page'
    );
}

/**
 * Render the BasePress sections page by redirecting to the original handler
 */
function jotunheim_render_basepress_sections_page() {
    if (class_exists('Basepress_Sections_Page')) {
        $sections_page = new Basepress_Sections_Page();
        $sections_page->display_screen();
    } else {
        echo '<div class="wrap"><h1>Sections</h1><p>BasePress Sections functionality is not available.</p></div>';
    }
}

/**
 * Render the BasePress manage KBs page by redirecting to the original handler
 */
function jotunheim_render_basepress_manage_kbs_page() {
    if (class_exists('Basepress_Manage_Kbs')) {
        $manage_kbs_page = new Basepress_Manage_Kbs();
        $manage_kbs_page->display_screen();
    } else {
        echo '<div class="wrap"><h1>Manage KBs</h1><p>BasePress Manage KBs functionality is not available.</p></div>';
    }
}

/**
 * Use JavaScript to inject menu items 
 */
function jotunheim_inject_basepress_menu_items() {
    // Only apply to wiki editor
    if (!current_user_can('wiki_editor') || current_user_can('administrator')) {
        return;
    }
    
    // Get KB post type
    $kb_post_type = function_exists('basepress_get_post_type') ? basepress_get_post_type() : 'knowledgebase';
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Get the KB menu
        var $kbMenu = $('#menu-posts-<?php echo esc_js($kb_post_type); ?> .wp-submenu');
        
        // Check if menu exists
        if ($kbMenu.length > 0) {
            // Check if Sections already exists
            var hasSections = false;
            var hasManageKbs = false;
            
            $kbMenu.find('a').each(function() {
                var href = $(this).attr('href');
                if (href && href.indexOf('basepress_sections') > -1) {
                    hasSections = true;
                }
                if (href && href.indexOf('basepress_manage_kbs') > -1) {
                    hasManageKbs = true;
                }
            });
            
            // Add Sections if needed
            if (!hasSections) {
                $kbMenu.append('<li><a href="edit.php?post_type=<?php echo esc_js($kb_post_type); ?>&page=basepress_sections">Sections</a></li>');
            }
            
            // Add Manage KBs if needed
            if (!hasManageKbs) {
                $kbMenu.append('<li><a href="edit.php?post_type=<?php echo esc_js($kb_post_type); ?>&page=basepress_manage_kbs">Manage KBs</a></li>');
            }
        }
    });
    </script>
    <?php
}