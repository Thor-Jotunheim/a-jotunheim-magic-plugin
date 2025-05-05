<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Simple Wiki Editor Role Definition
 */

/**
 * Create the Wiki Editor role with needed capabilities
 */
function jotunheim_create_wiki_editor_role() {
    // Check if wiki editor role already exists
    $wiki_editor = get_role('wiki_editor');
    
    // Define capabilities for wiki editor
    $capabilities = array(
        // Basic capabilities
        'read' => true,
        'edit_posts' => true,
        'upload_files' => true,
        
        // Knowledge Base specific capabilities
        'edit_knowledgebase' => true,
        'edit_knowledgebases' => true,
        'edit_others_knowledgebases' => true,
        'edit_published_knowledgebases' => true,
        'edit_others_posts' => true, 
        'edit_private_knowledgebases' => true,
        'read_knowledgebase' => true,
        'read_private_knowledgebases' => true,
        'publish_knowledgebases' => true,
        'delete_knowledgebase' => true,
        'delete_knowledgebases' => true,
        'delete_published_knowledgebases' => true,
        'delete_others_knowledgebases' => true,
        'manage_categories' => true,
    );
    
    if (!$wiki_editor) {
        // Create the role if it doesn't exist
        add_role('wiki_editor', 'Wiki Editor', $capabilities);
    } else {
        // Update existing role with capabilities
        foreach ($capabilities as $cap => $grant) {
            $wiki_editor->add_cap($cap, $grant);
        }
    }
    
    // Add the custom capabilities that may be used by the BasePress Knowledge Base plugin
    $custom_caps = array(
        'basepress_view_others_sections',
        'basepress_edit_others_sections',
        'basepress_manage_sections',
        'basepress_manage_knowledgebases',
    );
    
    foreach ($custom_caps as $cap) {
        if ($wiki_editor) {
            $wiki_editor->add_cap($cap, true);
        }
    }
}
add_action('init', 'jotunheim_create_wiki_editor_role');

/**
 * Add capabilities for custom post types to wiki editors
 */
function jotunheim_add_wiki_editor_capabilities() {
    // Get the post type object
    $post_type_object = get_post_type_object('knowledgebase');
    
    if ($post_type_object) {
        // Add caps to the wiki editor role
        $role = get_role('wiki_editor');
        
        if ($role) {
            // Standard post capabilities
            $post_caps = array(
                'edit_post',
                'read_post',
                'delete_post',
                'edit_posts',
                'edit_others_posts',
                'publish_posts',
                'read_private_posts',
            );
            
            // Map standard caps to the post type
            foreach ($post_caps as $cap) {
                $role->add_cap(str_replace('post', $post_type_object->name, $cap));
                $role->add_cap(str_replace('post', $post_type_object->name . 's', $cap));
            }
            
            // Add taxonomy capabilities
            $role->add_cap('manage_knowledgebase_categories');
            $role->add_cap('edit_knowledgebase_categories');
            $role->add_cap('delete_knowledgebase_categories');
            $role->add_cap('assign_knowledgebase_categories');
        }
    }
}
add_action('init', 'jotunheim_add_wiki_editor_capabilities', 20);

/**
 * Allow wiki editors to access Knowledge Base related menus
 */
function jotunheim_set_kb_menu_access() {
    if (!current_user_can('wiki_editor')) return;
    
    // Give access to the Knowledge Base admin menu
    global $pagenow;
    
    // Add specific capability to access KB admin page
    if ($pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'knowledgebase') {
        add_filter('user_has_cap', function($allcaps) {
            $allcaps['edit_knowledgebase'] = true;
            $allcaps['edit_knowledgebases'] = true;
            $allcaps['read_knowledgebase'] = true;
            $allcaps['manage_knowledgebase_terms'] = true;
            $allcaps['edit_knowledgebase_terms'] = true;
            $allcaps['delete_knowledgebase_terms'] = true;
            $allcaps['assign_knowledgebase_terms'] = true;
            $allcaps['basepress_view_others_sections'] = true;
            $allcaps['basepress_edit_others_sections'] = true;
            $allcaps['basepress_manage_sections'] = true;
            $allcaps['basepress_manage_knowledgebases'] = true;
            return $allcaps;
        });
    }
}
add_action('admin_init', 'jotunheim_set_kb_menu_access');

/**
 * Hide all admin menu items except Knowledge Base and Profile for wiki editors
 */
function jotunheim_hide_admin_menu_items() {
    // Only apply to wiki_editor role (not for admins)
    if (!current_user_can('wiki_editor') || current_user_can('administrator')) {
        return;
    }
    
    global $menu, $submenu;
    
    // Define allowed pages
    $allowed_top_pages = array(
        'profile.php',
        'edit.php?post_type=knowledgebase'
    );
    
    // Remove menu items
    if (is_array($menu)) {
        foreach ($menu as $key => $item) {
            if (!isset($item[2])) {
                continue;
            }
            
            // Keep only allowed pages
            if (!in_array($item[2], $allowed_top_pages)) {
                remove_menu_page($item[2]);
            }
        }
    }
    
    // Make sure Knowledge Base submenu items are accessible
    if (isset($submenu['edit.php?post_type=knowledgebase'])) {
        // Keep all KB submenu items visible - no need to restrict them
    }
}
add_action('admin_menu', 'jotunheim_hide_admin_menu_items', 999);

/**
 * Redirect wiki editors to knowledge base page after login
 */
function jotunheim_redirect_wiki_editors_after_login($redirect_to, $request, $user) {
    if (isset($user->roles) && is_array($user->roles)) {
        if (in_array('wiki_editor', $user->roles) && !in_array('administrator', $user->roles)) {
            return admin_url('edit.php?post_type=knowledgebase');
        }
    }
    return $redirect_to;
}
add_filter('login_redirect', 'jotunheim_redirect_wiki_editors_after_login', 10, 3);

/**
 * Filter admin bar nodes to ensure wiki editors see only relevant items
 */
function jotunheim_filter_admin_bar_for_wiki_editors($wp_admin_bar) {
    if (!current_user_can('wiki_editor') || current_user_can('administrator')) {
        return;
    }
    
    // Keep only specific admin bar nodes
    $keep_nodes = array('top-secondary', 'my-account', 'user-actions', 
        'user-info', 'edit-profile', 'logout', 'menu-toggle', 
        'site-name', 'view-site', 'wiki-editor-kb', 'wiki-editor-kb-all', 
        'wiki-editor-kb-add', 'wiki-editor-kb-manage', 'wiki-editor-kb-sections');
        
    // Get all nodes
    $all_nodes = $wp_admin_bar->get_nodes();
    
    if ($all_nodes) {
        foreach ($all_nodes as $node) {
            if (!in_array($node->id, $keep_nodes)) {
                $wp_admin_bar->remove_node($node->id);
            }
        }
    }
}
add_action('admin_bar_menu', 'jotunheim_filter_admin_bar_for_wiki_editors', 999);

/**
 * Allow wiki editors to edit any knowledge base post regardless of author
 */
function jotunheim_allow_wiki_editors_edit_any_kb_post() {
    // Only run this for wiki editors
    if (!is_user_logged_in() || !current_user_can('wiki_editor')) {
        return;
    }
    
    // Direct override for edit_post capability
    add_filter('map_meta_cap', function($caps, $cap, $user_id, $args) {
        // These are the capabilities we want to modify
        $edit_caps = array(
            'edit_post',
            'edit_others_posts',
            'edit_published_posts',
            'edit_others_knowledgebases'
        );
        
        if (in_array($cap, $edit_caps) && isset($args[0])) {
            $post_id = $args[0];
            $post = get_post($post_id);
            
            // Only modify for knowledge base post type
            if ($post && $post->post_type === 'knowledgebase') {
                return array('edit_knowledgebases');  // Replace with a capability they already have
            }
        }
        
        return $caps;
    }, 999, 4);  // High priority to override other filters
    
    // Show edit links for all knowledgebase posts in admin
    add_filter('post_row_actions', function($actions, $post) {
        if ($post->post_type === 'knowledgebase') {
            if (!isset($actions['edit'])) {
                $actions['edit'] = sprintf(
                    '<a href="%s">%s</a>',
                    get_edit_post_link($post->ID),
                    __('Edit')
                );
            }
        }
        return $actions;
    }, 999, 2);
}
add_action('init', 'jotunheim_allow_wiki_editors_edit_any_kb_post', 999);  // Very high priority

/**
 * Force-add editing capabilities for Wiki Editors when in admin
 */
function jotunheim_force_kb_edit_capabilities() {
    // Only run in admin and for wiki editors
    if (!is_admin() || !current_user_can('wiki_editor')) {
        return;
    }
    
    global $pagenow;
    
    // When viewing or editing a post
    if (($pagenow === 'post.php' || $pagenow === 'post-new.php') && isset($_GET['post_type']) && $_GET['post_type'] === 'knowledgebase') {
        // Add all possible editing caps
        add_filter('user_has_cap', function($allcaps) {
            $allcaps['edit_others_knowledgebases'] = true;
            $allcaps['edit_others_posts'] = true;
            $allcaps['edit_published_knowledgebases'] = true;
            $allcaps['edit_published_posts'] = true;
            $allcaps['edit_knowledgebase'] = true;
            $allcaps['edit_knowledgebases'] = true;
            return $allcaps;
        }, 999);
    }
    
    // When editing an existing post
    if ($pagenow === 'post.php' && isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['post'])) {
        $post_id = intval($_GET['post']);
        $post_type = get_post_type($post_id);
        
        if ($post_type === 'knowledgebase') {
            // Add all possible editing caps
            add_filter('user_has_cap', function($allcaps) {
                $allcaps['edit_others_knowledgebases'] = true;
                $allcaps['edit_others_posts'] = true;
                $allcaps['edit_published_knowledgebases'] = true;
                $allcaps['edit_published_posts'] = true;
                $allcaps['edit_knowledgebase'] = true;
                $allcaps['edit_knowledgebases'] = true;
                return $allcaps;
            }, 999);
        }
    }
    
    // In the posts list
    if ($pagenow === 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] === 'knowledgebase') {
        add_filter('user_has_cap', function($allcaps) {
            $allcaps['edit_others_knowledgebases'] = true;
            $allcaps['edit_others_posts'] = true;
            return $allcaps;
        }, 999);
    }
}
add_action('admin_init', 'jotunheim_force_kb_edit_capabilities');

/**
 * Modify edit post link for knowledgebase post type
 */
function jotunheim_modify_edit_post_link($url, $post_id, $context) {
    if (current_user_can('wiki_editor') && get_post_type($post_id) === 'knowledgebase') {
        // Force the edit link to work by adding a special parameter
        return add_query_arg('wiki_editor_override', '1', $url);
    }
    
    return $url;
}
add_filter('get_edit_post_link', 'jotunheim_modify_edit_post_link', 10, 3);

/**
 * Directly modify post row actions to ensure edit links for Wiki Editors
 */
function jotunheim_force_kb_row_edit_links($actions, $post) {
    // Only apply to knowledge base posts and Wiki Editors
    if ($post->post_type !== 'knowledgebase' || !current_user_can('wiki_editor')) {
        return $actions;
    }
    
    // Add edit action regardless of author
    $actions['edit'] = sprintf(
        '<a href="%s" aria-label="%s">%s</a>',
        get_edit_post_link($post->ID),
        /* translators: %s: post title */
        esc_attr(sprintf(__('Edit &#8220;%s&#8221;'), $post->post_title)),
        __('Edit')
    );
    
    // Add view action
    if (!isset($actions['view'])) {
        $actions['view'] = sprintf(
            '<a href="%s" rel="bookmark" aria-label="%s">%s</a>',
            get_permalink($post->ID),
            /* translators: %s: post title */
            esc_attr(sprintf(__('View &#8220;%s&#8221;'), $post->post_title)),
            __('View')
        );
    }
    
    return $actions;
}
// Use priority 99999 to ensure our function runs last
add_filter('post_row_actions', 'jotunheim_force_kb_row_edit_links', 99999, 2);

/**
 * Add a pre_get_posts filter to ensure wiki editors see all knowledge base posts
 */
function jotunheim_show_all_kb_posts_to_wiki_editors($query) {
    // Only modify admin queries for wiki editors
    if (!is_admin() || !current_user_can('wiki_editor') || !$query->is_main_query()) {
        return;
    }
    
    // Check if we're on the knowledgebase post type screen
    $screen = get_current_screen();
    if (!$screen || $screen->post_type !== 'knowledgebase') {
        return;
    }
    
    // Remove author restriction for wiki editors
    $query->set('author', '');
}
add_action('pre_get_posts', 'jotunheim_show_all_kb_posts_to_wiki_editors');

/**
 * Override post type capability check for wiki editors
 */
function jotunheim_override_post_edit_capability() {
    // Only apply for wiki editors
    if (!current_user_can('wiki_editor')) {
        return;
    }
    
    // This directly modifies the post type object to give edit access to wiki editors
    add_filter('register_post_type_args', function($args, $post_type) {
        if ($post_type === 'knowledgebase') {
            // Modify capability type to use something wiki editors can access
            $args['capability_type'] = 'post';
            
            // Set specific capabilities
            $args['capabilities'] = array(
                'edit_post' => 'edit_posts',
                'read_post' => 'read',
                'delete_post' => 'edit_posts',
                'edit_posts' => 'edit_posts',
                'edit_others_posts' => 'edit_posts',  // Use edit_posts instead of edit_others_posts
                'publish_posts' => 'edit_posts',
                'read_private_posts' => 'read',
            );
        }
        return $args;
    }, 99999, 2);
}
add_action('init', 'jotunheim_override_post_edit_capability', 5); // Run early to affect registration

/**
 * Emergency override to ensure Wiki Editors can edit any knowledge base post
 */
function jotunheim_emergency_kb_edit_override() {
    // Only apply for wiki editors
    if (!is_user_logged_in() || !current_user_can('wiki_editor')) {
        return;
    }
    
    global $pagenow;
    
    // Extreme capability override - add ALL capabilities for knowledgebase
    add_filter('user_has_cap', function($allcaps, $caps, $args, $user) {
        // For ALL knowledgebase related capabilities
        if (is_admin() && isset($_GET['post_type']) && $_GET['post_type'] === 'knowledgebase') {
            // Grant ALL capabilities for knowledge base post type
            $kb_caps = array(
                'edit_knowledgebase',
                'edit_knowledgebases',
                'edit_others_knowledgebases', 
                'edit_published_knowledgebases',
                'edit_private_knowledgebases',
                'delete_knowledgebase',
                'delete_knowledgebases',
                'delete_others_knowledgebases',
                'delete_published_knowledgebases',
                'delete_private_knowledgebases',
                'read_knowledgebase',
                'read_private_knowledgebases',
                'publish_knowledgebases',
                'edit_others_posts',
                'edit_post',
                'edit_posts'
            );
            
            foreach ($kb_caps as $cap) {
                $allcaps[$cap] = true;
            }
        }
        
        // When editing a specific post
        if ($pagenow === 'post.php' && isset($_GET['post'])) {
            $post_id = $_GET['post'];
            $post_type = get_post_type($post_id);
            
            if ($post_type === 'knowledgebase') {
                // Grant all edit capabilities
                $allcaps['edit_post'] = true;
                $allcaps['edit_posts'] = true;
                $allcaps['edit_others_posts'] = true;
                $allcaps['edit_published_posts'] = true;
                $allcaps['edit_knowledgebase'] = true;
                $allcaps['edit_knowledgebases'] = true;
                $allcaps['edit_others_knowledgebases'] = true;
                $allcaps['edit_published_knowledgebases'] = true;
            }
        }
        
        return $allcaps;
    }, 99999, 4); // Very high priority
    
    // Direct intervention for meta capability mapping
    add_filter('map_meta_cap', function($caps, $cap, $user_id, $args) {
        // Check if we're dealing with a knowledgebase post
        if (!empty($args) && isset($args[0])) {
            $post = get_post($args[0]);
            if ($post && $post->post_type === 'knowledgebase') {
                // For edit actions, return a capability the user has
                if ($cap === 'edit_post' || $cap === 'edit_others_posts' || $cap === 'edit_published_posts') {
                    return array('edit_posts');
                }
            }
        }
        return $caps;
    }, 99999, 4);
    
    // Force the post row actions to include edit for knowledge base
    add_filter('post_row_actions', function($actions, $post) {
        if ($post->post_type === 'knowledgebase') {
            // Replace the view link with an edit link if needed
            if (isset($actions['view']) && !isset($actions['edit'])) {
                $actions['edit'] = sprintf(
                    '<a href="%s">%s</a>',
                    admin_url('post.php?post=' . $post->ID . '&action=edit'),
                    __('Edit')
                );
            }
        }
        return $actions;
    }, 99999, 2);
}
add_action('init', 'jotunheim_emergency_kb_edit_override', 1); // Run very early

/**
 * Completely unlock post editing screen for wiki editors
 */
function jotunheim_unlock_kb_edit_screen() {
    if (!is_admin() || !current_user_can('wiki_editor')) {
        return;
    }
    
    global $pagenow, $post;
    
    if ($pagenow === 'post.php' && isset($_GET['action']) && $_GET['action'] === 'edit') {
        if (isset($_GET['post'])) {
            $post_id = intval($_GET['post']);
            $post_type = get_post_type($post_id);
            
            if ($post_type === 'knowledgebase') {
                // Remove all capability checks for this post
                add_filter('user_has_cap', function($allcaps) {
                    return array_merge($allcaps, array(
                        'edit_post' => true,
                        'edit_posts' => true, 
                        'edit_others_posts' => true,
                        'edit_knowledgebase' => true,
                        'edit_knowledgebases' => true,
                        'edit_others_knowledgebases' => true,
                        'edit_published_knowledgebases' => true
                    ));
                }, 99999);
                
                // Make the post editable
                add_filter('post_protected_meta', function($protected, $meta_key) {
                    return false;  // Remove "protected" restrictions
                }, 99999, 2);
            }
        }
    }
}
add_action('admin_init', 'jotunheim_unlock_kb_edit_screen', 1);

/**
 * Add edit links directly to the post type list for wiki editors
 */
function jotunheim_add_admin_inline_js() {
    if (!is_admin() || !current_user_can('wiki_editor')) {
        return;
    }
    
    global $pagenow;
    
    if ($pagenow === 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] === 'knowledgebase') {
        // Add custom JavaScript to transform view links to edit links
        ?>
        <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Find all row actions with only view links
            var rows = document.querySelectorAll('.wp-list-table tbody tr');
            rows.forEach(function(row) {
                var actions = row.querySelector('.row-actions');
                if (actions && actions.textContent.indexOf('Edit') === -1) {
                    // Get the post ID from the checkbox
                    var checkbox = row.querySelector('th.check-column input');
                    if (checkbox && checkbox.value) {
                        var postId = checkbox.value;
                        var editLink = document.createElement('a');
                        editLink.href = '<?php echo admin_url('post.php?action=edit&post='); ?>' + postId;
                        editLink.textContent = 'Edit';
                        
                        // Add the edit span
                        var editSpan = document.createElement('span');
                        editSpan.className = 'edit';
                        editSpan.appendChild(editLink);
                        editSpan.innerHTML += ' | ';
                        
                        // Add at the beginning of actions
                        actions.insertBefore(editSpan, actions.firstChild);
                    }
                }
            });
        });
        </script>
        <?php
    }
}
add_action('admin_footer', 'jotunheim_add_admin_inline_js');

/**
 * Direct JavaScript solution to force edit links for knowledge base items
 */
function jotunheim_direct_kb_edit_access_js() {
    // Only for Wiki Editors in admin area
    if (!is_admin() || !current_user_can('wiki_editor')) {
        return;
    }
    
    global $pagenow;
    
    // Add the JavaScript for the KB list page
    if (isset($_GET['post_type']) && $_GET['post_type'] === 'knowledgebase') {
        // Add backend JavaScript to modify all "View" links to "Edit" or add Edit links
        ?>
        <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Force add edit links everywhere in the admin interface
            function addEditLinks() {
                // Process the main table rows
                document.querySelectorAll('.wp-list-table tbody tr').forEach(function(row) {
                    var title = row.querySelector('.row-title');
                    var rowActions = row.querySelector('.row-actions');
                    
                    if (!rowActions || !title) return;
                    
                    // Check if this row is missing an edit link
                    if (!rowActions.innerHTML.includes('post.php?post=') && !rowActions.innerHTML.includes('action=edit')) {
                        // Extract the post ID from title href or try to find it elsewhere
                        var postId = null;
                        
                        if (title && title.href) {
                            var matches = title.href.match(/post=(\d+)/);
                            if (matches && matches[1]) {
                                postId = matches[1];
                            }
                        }
                        
                        // If we still don't have a post ID, look for the checkbox
                        if (!postId) {
                            var checkbox = row.querySelector('input[type="checkbox"][name="post[]"]');
                            if (checkbox) {
                                postId = checkbox.value;
                            }
                        }
                        
                        // As a last resort, try to find post ID in any link in the row
                        if (!postId) {
                            var allLinks = row.querySelectorAll('a');
                            for (var i = 0; i < allLinks.length; i++) {
                                var matches = allLinks[i].href.match(/post=(\d+)/);
                                if (matches && matches[1]) {
                                    postId = matches[1];
                                    break;
                                }
                            }
                        }
                        
                        if (postId) {
                            // Create the edit link element
                            var editLink = document.createElement('a');
                            editLink.href = '<?php echo admin_url('post.php?action=edit&post='); ?>' + postId;
                            editLink.textContent = 'Edit';
                            
                            // Create container span
                            var editSpan = document.createElement('span');
                            editSpan.className = 'edit';
                            editSpan.appendChild(editLink);
                            
                            // If row actions exists, add at the beginning
                            if (rowActions.firstChild) {
                                // Add separator if we're prepending
                                editSpan.appendChild(document.createTextNode(' | '));
                                rowActions.insertBefore(editSpan, rowActions.firstChild);
                            } else {
                                // Just append if empty
                                rowActions.appendChild(editSpan);
                            }
                        }
                        
                        // Also make the title link go to edit screen
                        if (title && postId) {
                            title.href = '<?php echo admin_url('post.php?action=edit&post='); ?>' + postId;
                        }
                    }
                });
                
                // Also convert any "View" links to "Edit" links
                document.querySelectorAll('.row-actions .view a').forEach(function(viewLink) {
                    var postUrl = viewLink.href;
                    var matches = postUrl.match(/p=(\d+)/) || postUrl.match(/post=(\d+)/);
                    
                    if (matches && matches[1]) {
                        viewLink.href = '<?php echo admin_url('post.php?action=edit&post='); ?>' + matches[1];
                        viewLink.textContent = 'Edit';
                    }
                });
            }
            
            // Run immediately and again after a brief delay to catch any dynamic elements
            addEditLinks();
            setTimeout(addEditLinks, 500);
            
            // Also listen for DOM changes to apply to dynamically added content
            if (MutationObserver) {
                var observer = new MutationObserver(function(mutations) {
                    addEditLinks();
                });
                
                var config = { childList: true, subtree: true };
                observer.observe(document.getElementById('wpbody'), config);
            }
        });
        </script>
        <?php
    }
}
add_action('admin_footer', 'jotunheim_direct_kb_edit_access_js');

/**
 * Directly modify the database query permissions check for wiki editors
 */
function jotunheim_modify_posts_request_for_wiki_editors($request) {
    global $wpdb, $current_user;
    
    // Only apply for wiki editors in admin
    if (!is_admin() || !current_user_can('wiki_editor') || empty($current_user)) {
        return $request;
    }
    
    // Only modify for knowledge base post type
    if (isset($_GET['post_type']) && $_GET['post_type'] === 'knowledgebase') {
        // This completely removes the author restriction from the SQL query for knowledgebase posts
        $request = str_replace(
            "AND {$wpdb->posts}.post_author = {$current_user->ID}",
            "",
            $request
        );
    }
    
    return $request;
}
add_filter('posts_request', 'jotunheim_modify_posts_request_for_wiki_editors');

/**
 * Force edit capabilities at the lowest level possible
 */
function jotunheim_kb_edit_permissions_override() {
    // Only apply for wiki editors
    if (!current_user_can('wiki_editor')) {
        return;
    }
    
    // Direct meta capability mapping hack
    add_filter('map_meta_cap', function($caps, $cap, $user_id, $args) {
        // Check if we're mapping a capability related to editing
        $edit_caps = array(
            'edit_post',
            'edit_others_posts',
            'edit_published_posts',
            'edit_knowledgebase',
            'edit_knowledgebases',
            'edit_others_knowledgebases'
        );
        
        if (in_array($cap, $edit_caps)) {
            // Check if we have a post ID
            if (!empty($args) && isset($args[0])) {
                $post_id = $args[0];
                $post_type = get_post_type($post_id);
                
                // Only override for knowledge base post type
                if ($post_type === 'knowledgebase') {
                    // Replace with basic reading capability
                    return array('read');
                }
            }
        }
        
        return $caps;
    }, 99999, 4);
    
    // Direct access to edit page
    if (isset($_GET['post']) && isset($_GET['action']) && $_GET['action'] === 'edit') {
        $post_id = intval($_GET['post']);
        $post_type = get_post_type($post_id);
        
        if ($post_type === 'knowledgebase') {
            // Add edit capability directly through the current_user_can filter
            add_filter('user_has_cap', function($allcaps) {
                $allcaps['edit_post'] = true;
                $allcaps['edit_others_posts'] = true;
                $allcaps['edit_published_posts'] = true;
                $allcaps['edit_knowledgebase'] = true;
                $allcaps['edit_knowledgebases'] = true;
                $allcaps['edit_others_knowledgebases'] = true;
                return $allcaps;
            }, 99999);
        }
    }
}
add_action('init', 'jotunheim_kb_edit_permissions_override');

/**
 * Plugin-specific compatibility code for BasePress plugin
 */
function jotunheim_basepress_compatibility() {
    if (!current_user_can('wiki_editor')) {
        return;
    }
    
    // This specifically targets BasePress capabilities
    add_filter('basepress_user_can_edit_section', function($can_edit, $user_id) {
        return true; // Force permission
    }, 99999, 2);
    
    add_filter('basepress_user_can_edit_article', function($can_edit, $user_id, $post_id) {
        return true; // Force permission
    }, 99999, 3);
    
    // Remove author restrictions from BasePress queries
    add_filter('basepress_author_clause', function($author_clause) {
        return ''; // Remove author restrictions
    }, 99999);
}
add_action('init', 'jotunheim_basepress_compatibility');