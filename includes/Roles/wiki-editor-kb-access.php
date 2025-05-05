<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * This file provides direct edit access for Wiki Editor role to knowledge base posts
 * regardless of the post author
 */

class JotunheimWikiEditorKnowledgeBaseAccess {
    
    /**
     * Initialize the class
     */
    public static function init() {
        $instance = new self();
        $instance->hooks();
    }
    
    /**
     * Register all hooks
     */
    public function hooks() {
        // Run early to override post type registration
        add_action('init', array($this, 'override_knowledgebase_post_type'), 1);
        
        // Add specific capabilities to the role
        add_action('admin_init', array($this, 'force_wiki_editor_capabilities'));
        
        // Modify post row actions to ensure edit links appear
        add_filter('post_row_actions', array($this, 'modify_kb_row_actions'), 999, 2);
        
        // Direct DB query modification to remove author restrictions
        add_filter('posts_where', array($this, 'remove_author_restrictions'), 999, 2);
        
        // Direct object modification for post editing
        add_action('pre_get_posts', array($this, 'allow_any_author_posts'), 999);
        
        // Inject edit links via JavaScript
        add_action('admin_footer', array($this, 'inject_edit_links_js'));
        
        // Override capability checks at the lowest level
        add_filter('map_meta_cap', array($this, 'override_edit_caps'), 999, 4);
        
        // Lock all filters from further modifications
        add_action('wp_loaded', array($this, 'lock_filters'));
        
        // For BasePress plugin compatibility
        add_filter('basepress_user_can_edit_section', array($this, 'force_basepress_section_edit'), 9999, 2);
        add_filter('basepress_user_can_edit_article', array($this, 'force_basepress_article_edit'), 9999, 3);
    }
    
    /**
     * Override the knowledgebase post type registration
     */
    public function override_knowledgebase_post_type() {
        if (!current_user_can('wiki_editor')) {
            return;
        }
        
        // Modify the post type capabilities
        add_filter('register_post_type_args', function($args, $post_type) {
            if ($post_type !== 'knowledgebase') {
                return $args;
            }
            
            // Set capabilities to something wiki editors can do
            $args['capabilities'] = array(
                'edit_post'             => 'edit_posts',
                'edit_posts'            => 'edit_posts',
                'edit_others_posts'     => 'edit_posts',
                'publish_posts'         => 'edit_posts',
                'read_post'             => 'read',
                'read_private_posts'    => 'read',
                'delete_post'           => 'edit_posts',
                'delete_posts'          => 'edit_posts',
            );
            
            return $args;
        }, 999, 2);
    }
    
    /**
     * Force wiki editor capabilities for knowledge base posts
     */
    public function force_wiki_editor_capabilities() {
        if (!current_user_can('wiki_editor')) {
            return;
        }
        
        // Ensure wiki editors have the capability to edit any post
        add_filter('user_has_cap', function($allcaps) {
            global $post;
            
            // Only modify for knowledge base
            if (!empty($_GET['post_type']) && $_GET['post_type'] === 'knowledgebase' || 
                (!empty($post) && $post->post_type === 'knowledgebase')) {
                
                // These are the edit capabilities
                $edit_caps = array(
                    'edit_post',
                    'edit_posts',
                    'edit_others_posts',
                    'edit_published_posts',
                    'edit_knowledgebase',
                    'edit_knowledgebases',
                    'edit_others_knowledgebases',
                    'edit_published_knowledgebases',
                    'publish_knowledgebases',
                );
                
                // Add all edit capabilities
                foreach ($edit_caps as $cap) {
                    $allcaps[$cap] = true;
                }
            }
            
            return $allcaps;
        }, 9999);
    }
    
    /**
     * Modify row actions for knowledge base posts
     */
    public function modify_kb_row_actions($actions, $post) {
        if (!current_user_can('wiki_editor') || $post->post_type !== 'knowledgebase') {
            return $actions;
        }
        
        // Always include an edit link
        $actions['edit'] = sprintf(
            '<a href="%s">%s</a>',
            get_edit_post_link($post->ID),
            __('Edit')
        );
        
        return $actions;
    }
    
    /**
     * Remove author restrictions from database queries
     */
    public function remove_author_restrictions($where, $wp_query) {
        global $wpdb, $pagenow;
        
        if (!is_admin() || !current_user_can('wiki_editor')) {
            return $where;
        }
        
        // Only apply to knowledge base post type
        if ((isset($_GET['post_type']) && $_GET['post_type'] === 'knowledgebase') || 
            ($wp_query->get('post_type') === 'knowledgebase')) {
            
            // Remove the author clause from the WHERE statement
            $author_pattern = "/{$wpdb->posts}.post_author\s*=\s*[0-9]+\s*AND/i";
            $where = preg_replace($author_pattern, '', $where);
        }
        
        return $where;
    }
    
    /**
     * Allow wiki editors to view any posts regardless of author
     */
    public function allow_any_author_posts($query) {
        global $pagenow;
        
        if (!is_admin() || !current_user_can('wiki_editor')) {
            return;
        }
        
        // Apply only to knowledge base post type
        if ($pagenow === 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] === 'knowledgebase') {
            $query->set('author', '');  // Remove author restriction
        }
    }
    
    /**
     * Inject JavaScript to ensure edit links appear
     */
    public function inject_edit_links_js() {
        if (!is_admin() || !current_user_can('wiki_editor')) {
            return;
        }
        
        global $pagenow;
        
        if ($pagenow === 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] === 'knowledgebase') {
            ?>
            <script type="text/javascript">
            (function() {
                // Direct DOM manipulation to ensure edit links
                function addEditLinks() {
                    // For each row in the table
                    document.querySelectorAll('.wp-list-table tbody tr').forEach(function(row) {
                        // Get the post ID
                        var postId = null;
                        var cb = row.querySelector('input[name="post[]"]');
                        if (cb) {
                            postId = cb.value;
                        }
                        
                        if (!postId) return;
                        
                        // Get row actions
                        var actions = row.querySelector('.row-actions');
                        if (!actions) return;
                        
                        // Check if edit link exists
                        if (actions.textContent.indexOf('Edit') === -1) {
                            // Create edit link
                            var editSpan = document.createElement('span');
                            editSpan.className = 'edit';
                            
                            var editLink = document.createElement('a');
                            editLink.href = '<?php echo admin_url('post.php?action=edit&post='); ?>' + postId;
                            editLink.textContent = 'Edit';
                            
                            editSpan.appendChild(editLink);
                            editSpan.innerHTML += ' | ';
                            
                            // Add at beginning of row actions
                            if (actions.firstChild) {
                                actions.insertBefore(editSpan, actions.firstChild);
                            } else {
                                actions.appendChild(editSpan);
                            }
                        }
                        
                        // Convert title link to edit link
                        var title = row.querySelector('.row-title');
                        if (title) {
                            title.href = '<?php echo admin_url('post.php?action=edit&post='); ?>' + postId;
                        }
                    });
                    
                    // Convert view links to edit links
                    document.querySelectorAll('.row-actions .view a').forEach(function(link) {
                        var href = link.getAttribute('href');
                        var postId = null;
                        
                        // Extract post ID from permalink
                        var match = href.match(/\?p=(\d+)/) || href.match(/\/(\d+)\/$/);
                        if (match && match[1]) {
                            postId = match[1];
                            link.href = '<?php echo admin_url('post.php?action=edit&post='); ?>' + postId;
                            link.textContent = 'Edit';
                        }
                    });
                }
                
                // Run when DOM is ready and again after a delay
                document.addEventListener('DOMContentLoaded', function() {
                    addEditLinks();
                    setTimeout(addEditLinks, 500);
                });
            })();
            </script>
            <?php
        }
    }
    
    /**
     * Override capabilities for editing posts
     */
    public function override_edit_caps($caps, $cap, $user_id, $args) {
        if (!current_user_can('wiki_editor')) {
            return $caps;
        }
        
        // Editing related capabilities
        $edit_caps = array(
            'edit_post',
            'edit_others_posts',
            'edit_published_posts',
            'edit_others_knowledgebases'
        );
        
        if (in_array($cap, $edit_caps) && isset($args[0])) {
            $post_id = $args[0];
            $post_type = get_post_type($post_id);
            
            // Only for knowledge base post type
            if ($post_type === 'knowledgebase') {
                return array('read'); // Replace with a capability they have
            }
        }
        
        return $caps;
    }
    
    /**
     * Lock filters to prevent other plugins from removing our capabilities
     */
    public function lock_filters() {
        if (current_user_can('wiki_editor')) {
            // This ensures nobody can remove our capabilities
            global $wp_filter;
            
            // Lock critical filters at their current state
            $critical_filters = array(
                'map_meta_cap',
                'user_has_cap'
            );
            
            foreach ($critical_filters as $filter) {
                if (isset($wp_filter[$filter])) {
                    // Make a copy of the current filter state
                    $backup = $wp_filter[$filter];
                    
                    // Restore our filters if they get modified later
                    add_action('admin_init', function() use ($filter, $backup) {
                        global $wp_filter;
                        $wp_filter[$filter] = $backup;
                    }, 99999);
                }
            }
        }
    }
    
    /**
     * Force BasePress section edit permission
     */
    public function force_basepress_section_edit($can_edit, $user_id) {
        if (current_user_can('wiki_editor')) {
            return true;
        }
        
        return $can_edit;
    }
    
    /**
     * Force BasePress article edit permission
     */
    public function force_basepress_article_edit($can_edit, $user_id, $post_id) {
        if (current_user_can('wiki_editor')) {
            return true;
        }
        
        return $can_edit;
    }
}

// Initialize the class
add_action('plugins_loaded', array('JotunheimWikiEditorKnowledgeBaseAccess', 'init'));