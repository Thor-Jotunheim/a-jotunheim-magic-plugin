<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

class Jotunheim_Wiki_Core {
    public function __construct() {
        // Register post type
        add_action('init', array($this, 'register_wiki_post_type'));
        
        // Register shortcodes
        add_shortcode('jotunheim_wiki', array($this, 'wiki_shortcode'));
        add_shortcode('jotunheim_wiki_editor', array($this, 'wiki_editor_shortcode'));
        
        // Register styles and scripts
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
    }
    
    /**
     * Register wiki post type
     */
    public function register_wiki_post_type() {
        $labels = array(
            'name'               => _x('Wiki Pages', 'post type general name'),
            'singular_name'      => _x('Wiki Page', 'post type singular name'),
            'menu_name'          => _x('Wiki', 'admin menu'),
            'name_admin_bar'     => _x('Wiki Page', 'add new on admin bar'),
            'add_new'            => _x('Add New', 'wiki page'),
            'add_new_item'       => __('Add New Wiki Page'),
            'new_item'           => __('New Wiki Page'),
            'edit_item'          => __('Edit Wiki Page'),
            'view_item'          => __('View Wiki Page'),
            'all_items'          => __('All Wiki Pages'),
            'search_items'       => __('Search Wiki Pages'),
            'not_found'          => __('No wiki pages found.'),
            'not_found_in_trash' => __('No wiki pages found in Trash.')
        );
        
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'wiki'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions')
        );
        
        register_post_type('jotunheim_wiki', $args);
    }
    
    /**
     * Main wiki shortcode to display wiki pages
     */
    public function wiki_shortcode($atts) {
        $atts = shortcode_atts(array(
            'page' => '',
            'view' => 'index' // index, single, edit, create
        ), $atts);
        
        // Enqueue assets
        $this->enqueue_assets();
        
        ob_start();
        
        // Check the view parameter
        switch ($atts['view']) {
            case 'edit':
                include(plugin_dir_path(dirname(__DIR__)) . 'templates/wiki-edit.php');
                break;
                
            case 'create':
                include(plugin_dir_path(dirname(__DIR__)) . 'templates/wiki-create.php');
                break;
                
            case 'single':
                if (!empty($atts['page'])) {
                    // Set up the query for a specific page
                    $wiki_query = new WP_Query(array(
                        'post_type' => 'jotunheim_wiki',
                        'name' => $atts['page'],
                        'posts_per_page' => 1
                    ));
                    
                    if ($wiki_query->have_posts()) {
                        while ($wiki_query->have_posts()) {
                            $wiki_query->the_post();
                            include(plugin_dir_path(dirname(__DIR__)) . 'templates/wiki-single.php');
                        }
                        wp_reset_postdata();
                    } else {
                        echo '<div class="jotunheim-wiki-notice error">Wiki page not found.</div>';
                    }
                } else {
                    echo '<div class="jotunheim-wiki-notice error">No wiki page specified.</div>';
                }
                break;
                
            case 'index':
            default:
                include(plugin_dir_path(dirname(__DIR__)) . 'templates/wiki-index.php');
                break;
        }
        
        return ob_get_clean();
    }
    
    /**
     * Wiki editor shortcode - special shortcode for editing
     */
    public function wiki_editor_shortcode($atts) {
        $atts = shortcode_atts(array(
            'page' => ''
        ), $atts);
        
        // Check if user has wiki editor role
        if (!Jotunheim_Wiki_Permissions::current_user_can_edit_wiki()) {
            return '<div class="jotunheim-wiki-notice error">You do not have permission to edit the wiki. You need the "Wiki Editor" role on Discord.</div>';
        }
        
        // Add the edit view parameter
        $atts['view'] = empty($atts['page']) ? 'create' : 'edit';
        
        // Use the main wiki shortcode to render the editor
        return $this->wiki_shortcode($atts);
    }
    
    /**
     * Enqueue styles and scripts
     */
    public function enqueue_assets() {
        wp_enqueue_style(
            'jotunheim-wiki-style',
            plugin_dir_url(dirname(__DIR__)) . 'assets/css/wiki.css',
            array(),
            '1.0.0'
        );
        
        wp_enqueue_script(
            'jotunheim-wiki-script',
            plugin_dir_url(dirname(__DIR__)) . 'assets/js/wiki.js',
            array('jquery'),
            '1.0.0',
            true
        );
        
        // Pass ajax url to script
        wp_localize_script(
            'jotunheim-wiki-script',
            'jotunheimWiki',
            array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('jotunheim_wiki_nonce')
            )
        );
    }
}

// Initialize the class
new Jotunheim_Wiki_Core();
