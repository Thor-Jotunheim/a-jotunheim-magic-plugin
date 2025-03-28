<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

/**
 * This file handles integration with other parts of the plugin
 * and provides utility functions for the wiki system
 */
class Jotunheim_Wiki_Integration {
    
    public function __construct() {
        // Add wiki to the dashboard menu
        add_action('admin_menu', array($this, 'add_wiki_admin_menu'));
        
        // Add capability for wiki editors
        add_action('admin_init', array($this, 'add_wiki_capabilities'));
        
        // Add rewrite rules for pretty URLs
        add_action('init', array($this, 'add_wiki_rewrite_rules'));
        
        // Filter single template for wiki pages
        add_filter('single_template', array($this, 'load_wiki_template'));
        
        // Register activation hook to create wiki pages
        register_activation_hook(plugin_basename(dirname(dirname(dirname(__FILE__)))) . '/jotunheim-magic.php', 
            array($this, 'create_wiki_pages'));
    }
    
    /**
     * Add wiki to admin menu
     */
    public function add_wiki_admin_menu() {
        add_menu_page(
            'Jotunheim Wiki',
            'Wiki',
            'edit_posts',
            'jotunheim-wiki',
            array($this, 'wiki_admin_page'),
            'dashicons-book',
            25
        );
        
        add_submenu_page(
            'jotunheim-wiki',
            'All Wiki Pages',
            'All Pages',
            'edit_posts',
            'edit.php?post_type=jotunheim_wiki'
        );
        
        add_submenu_page(
            'jotunheim-wiki',
            'Add New Wiki Page',
            'Add New',
            'edit_posts',
            'post-new.php?post_type=jotunheim_wiki'
        );
    }
    
    /**
     * Wiki admin page
     */
    public function wiki_admin_page() {
        ?>
        <div class="wrap">
            <h1>Jotunheim Wiki</h1>
            
            <h2>How to Use the Wiki</h2>
            <p>The Jotunheim Wiki system allows users with proper Discord roles to create and edit wiki pages.</p>
            
            <h3>Shortcodes</h3>
            <ul>
                <li><code>[jotunheim_wiki]</code> - Displays the wiki index page listing all wiki articles</li>
                <li><code>[jotunheim_wiki page="page-slug"]</code> - Displays a specific wiki page</li>
                <li><code>[jotunheim_wiki view="create"]</code> - Shows the page creation form (for authorized users only)</li>
                <li><code>[jotunheim_wiki_editor]</code> - For Discord role-based editing functionality</li>
            </ul>
            
            <h3>Discord Integration</h3>
            <p>Only users with the "Wiki Editor" role on your Discord server can edit wiki pages.</p>
            <p>Set up the Discord bot token and guild ID in your plugin settings to enable role checking.</p>
            
            <h3>Permissions</h3>
            <p>By default, all users can view wiki pages, but only those with the correct Discord role can edit them.</p>
        </div>
        <?php
    }
    
    /**
     * Add capabilities for wiki editors
     */
    public function add_wiki_capabilities() {
        // Add wiki editor capabilities to administrator
        $admin = get_role('administrator');
        if ($admin) {
            $admin->add_cap('edit_wiki_pages');
            $admin->add_cap('publish_wiki_pages');
            $admin->add_cap('delete_wiki_pages');
        }
    }
    
    /**
     * Add rewrite rules for pretty URLs
     */
    public function add_wiki_rewrite_rules() {
        add_rewrite_rule(
            'wiki/edit/([^/]+)/?$',
            'index.php?jotunheim_wiki=$matches[1]&wiki_action=edit',
            'top'
        );
        
        add_rewrite_rule(
            'wiki/create/?$',
            'index.php?wiki_action=create',
            'top'
        );
        
        add_rewrite_tag('%wiki_action%', '([^&]+)');
    }
    
    /**
     * Load custom template for wiki pages
     */
    public function load_wiki_template($template) {
        global $post;
        
        if ($post->post_type == 'jotunheim_wiki') {
            $custom_template = plugin_dir_path(dirname(dirname(__FILE__))) . 'templates/single-jotunheim_wiki.php';
            
            if (file_exists($custom_template)) {
                return $custom_template;
            }
        }
        
        return $template;
    }
    
    /**
     * Create initial wiki pages on plugin activation
     */
    public function create_wiki_pages() {
        // Check if the welcome page already exists
        $existing = get_page_by_path('welcome-to-wiki', OBJECT, 'jotunheim_wiki');
        
        if (!$existing) {
            // Create a welcome page
            wp_insert_post(array(
                'post_title' => 'Welcome to the Jotunheim Wiki',
                'post_name' => 'welcome-to-wiki',
                'post_content' => "# Welcome to the Jotunheim Wiki\n\nThis is the main wiki page for Jotunheim. You can edit this page to add your own content or create new pages.\n\n## How to Use This Wiki\n\n1. Browse existing pages using the wiki index\n2. Create new pages if you have the Wiki Editor role on Discord\n3. Edit existing pages to contribute information\n\nEnjoy using the wiki!",
                'post_status' => 'publish',
                'post_type' => 'jotunheim_wiki',
                'post_author' => 1,
            ));
        }
    }
}

// Initialize the integration
new Jotunheim_Wiki_Integration();
