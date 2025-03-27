<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

class Jotunheim_Wiki_REST_API {
    public function __construct() {
        // Register REST API endpoints
        add_action('rest_api_init', array($this, 'register_rest_routes'));
        
        // Register AJAX handlers
        add_action('wp_ajax_jotunheim_save_wiki_page', array($this, 'ajax_save_wiki_page'));
        add_action('wp_ajax_jotunheim_delete_wiki_page', array($this, 'ajax_delete_wiki_page'));
    }
    
    /**
     * Register REST API routes
     */
    public function register_rest_routes() {
        register_rest_route('jotunheim/v1', '/wiki', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_wiki_pages'),
            'permission_callback' => '__return_true'
        ));
        
        register_rest_route('jotunheim/v1', '/wiki/(?P<slug>[\w-]+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_wiki_page'),
            'permission_callback' => '__return_true'
        ));
        
        register_rest_route('jotunheim/v1', '/wiki', array(
            'methods' => 'POST',
            'callback' => array($this, 'create_wiki_page'),
            'permission_callback' => array($this, 'check_wiki_edit_permission')
        ));
        
        register_rest_route('jotunheim/v1', '/wiki/(?P<id>[\d]+)', array(
            'methods' => 'PUT',
            'callback' => array($this, 'update_wiki_page'),
            'permission_callback' => array($this, 'check_wiki_edit_permission')
        ));
        
        register_rest_route('jotunheim/v1', '/wiki/(?P<id>[\d]+)', array(
            'methods' => 'DELETE',
            'callback' => array($this, 'delete_wiki_page'),
            'permission_callback' => array($this, 'check_wiki_edit_permission')
        ));
    }
    
    /**
     * Check if user has permission to edit wiki
     */
    public function check_wiki_edit_permission() {
        return Jotunheim_Wiki_Permissions::current_user_can_edit_wiki();
    }
    
    /**
     * Get all wiki pages
     */
    public function get_wiki_pages() {
        $args = array(
            'post_type' => 'jotunheim_wiki',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        );
        
        $posts = get_posts($args);
        $pages = array();
        
        foreach ($posts as $post) {
            $pages[] = $this->format_wiki_page($post);
        }
        
        return rest_ensure_response($pages);
    }
    
    /**
     * Get a single wiki page by slug
     */
    public function get_wiki_page($request) {
        $slug = $request['slug'];
        
        $post = get_page_by_path($slug, OBJECT, 'jotunheim_wiki');
        
        if (empty($post)) {
            return new WP_Error('not_found', 'Wiki page not found', array('status' => 404));
        }
        
        return rest_ensure_response($this->format_wiki_page($post));
    }
    
    /**
     * Create a new wiki page
     */
    public function create_wiki_page($request) {
        $params = $request->get_params();
        
        // Validate required fields
        if (empty($params['title']) || empty($params['content'])) {
            return new WP_Error('missing_required', 'Title and content are required', array('status' => 400));
        }
        
        $post_data = array(
            'post_title' => sanitize_text_field($params['title']),
            'post_content' => wp_kses_post($params['content']),
            'post_status' => 'publish',
            'post_type' => 'jotunheim_wiki',
            'post_author' => get_current_user_id()
        );
        
        $post_id = wp_insert_post($post_data);
        
        if (is_wp_error($post_id)) {
            return $post_id;
        }
        
        $post = get_post($post_id);
        
        return rest_ensure_response($this->format_wiki_page($post));
    }
    
    /**
     * Update an existing wiki page
     */
    public function update_wiki_page($request) {
        $post_id = $request['id'];
        $params = $request->get_params();
        
        // Check if post exists
        $post = get_post($post_id);
        if (empty($post) || $post->post_type !== 'jotunheim_wiki') {
            return new WP_Error('not_found', 'Wiki page not found', array('status' => 404));
        }
        
        $post_data = array(
            'ID' => $post_id
        );
        
        if (!empty($params['title'])) {
            $post_data['post_title'] = sanitize_text_field($params['title']);
        }
        
        if (!empty($params['content'])) {
            $post_data['post_content'] = wp_kses_post($params['content']);
        }
        
        $updated = wp_update_post($post_data);
        
        if (is_wp_error($updated)) {
            return $updated;
        }
        
        $post = get_post($post_id);
        
        return rest_ensure_response($this->format_wiki_page($post));
    }
    
    /**
     * Delete a wiki page
     */
    public function delete_wiki_page($request) {
        $post_id = $request['id'];
        
        // Check if post exists
        $post = get_post($post_id);
        if (empty($post) || $post->post_type !== 'jotunheim_wiki') {
            return new WP_Error('not_found', 'Wiki page not found', array('status' => 404));
        }
        
        $result = wp_delete_post($post_id, true);
        
        if (!$result) {
            return new WP_Error('delete_failed', 'Failed to delete wiki page', array('status' => 500));
        }
        
        return rest_ensure_response(array(
            'deleted' => true,
            'id' => $post_id
        ));
    }
    
    /**
     * Format wiki page for API response
     */
    private function format_wiki_page($post) {
        return array(
            'id' => $post->ID,
            'title' => $post->post_title,
            'slug' => $post->post_name,
            'content' => $post->post_content,
            'author' => get_the_author_meta('display_name', $post->post_author),
            'date_created' => $post->post_date,
            'date_modified' => $post->post_modified
        );
    }
    
    /**
     * AJAX handler for saving wiki page
     */
    public function ajax_save_wiki_page() {
        // Check nonce
        check_ajax_referer('jotunheim_wiki_nonce', 'nonce');
        
        // Check permissions
        if (!Jotunheim_Wiki_Permissions::current_user_can_edit_wiki()) {
            wp_send_json_error('You do not have permission to edit the wiki');
            return;
        }
        
        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
        $title = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
        $content = isset($_POST['content']) ? wp_kses_post($_POST['content']) : '';
        
        // Validate input
        if (empty($title) || empty($content)) {
            wp_send_json_error('Title and content are required');
            return;
        }
        
        $post_data = array(
            'post_title' => $title,
            'post_content' => $content,
            'post_status' => 'publish',
            'post_type' => 'jotunheim_wiki'
        );
        
        if ($post_id > 0) {
            // Update existing post
            $post_data['ID'] = $post_id;
            $result = wp_update_post($post_data);
        } else {
            // Create new post
            $post_data['post_author'] = get_current_user_id();
            $result = wp_insert_post($post_data);
        }
        
        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
            return;
        }
        
        wp_send_json_success(array(
            'post_id' => $result,
            'permalink' => get_permalink($result)
        ));
    }
    
    /**
     * AJAX handler for deleting wiki page
     */
    public function ajax_delete_wiki_page() {
        // Check nonce
        check_ajax_referer('jotunheim_wiki_nonce', 'nonce');
        
        // Check permissions
        if (!Jotunheim_Wiki_Permissions::current_user_can_edit_wiki()) {
            wp_send_json_error('You do not have permission to delete wiki pages');
            return;
        }
        
        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
        
        if ($post_id <= 0) {
            wp_send_json_error('Invalid post ID');
            return;
        }
        
        // Check if post exists and is a wiki page
        $post = get_post($post_id);
        if (empty($post) || $post->post_type !== 'jotunheim_wiki') {
            wp_send_json_error('Wiki page not found');
            return;
        }
        
        $result = wp_delete_post($post_id, true);
        
        if (!$result) {
            wp_send_json_error('Failed to delete wiki page');
            return;
        }
        
        wp_send_json_success(array(
            'deleted' => true,
            'redirect' => get_post_type_archive_link('jotunheim_wiki')
        ));
    }
}

// Initialize the class
new Jotunheim_Wiki_REST_API();
