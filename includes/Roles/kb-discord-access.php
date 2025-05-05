<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Restrict Staff Knowledge Base access to Discord Moderators
 */
class JotunheimStaffKBAccess {

    public function __construct() {
        // Initialize hooks
        add_action('init', array($this, 'init_kb_access_control'));
        add_filter('the_content', array($this, 'filter_kb_content'), 999);
        add_action('template_redirect', array($this, 'restrict_kb_access'));
    }

    /**
     * Check if current user has Discord Moderator role
     */
    public function user_has_discord_moderator_role() {
        // If user is admin, always grant access
        if (current_user_can('administrator')) {
            return true;
        }
        
        // Get current user
        $current_user = wp_get_current_user();
        if (!$current_user || !$current_user->ID) {
            return false;
        }
        
        // Check for Discord role meta data
        $discord_roles = get_user_meta($current_user->ID, 'discord_roles', true);
        
        if (empty($discord_roles)) {
            return false;
        }
        
        // List of allowed role IDs - add the actual Discord Moderator role ID here
        $moderator_role_ids = array(
            'moderator', // Replace with actual role ID
            'admin',     // Replace with actual role ID
            'staff'      // Replace with actual role ID
        );
        
        // Check if user has any of the allowed roles
        foreach ($moderator_role_ids as $role_id) {
            if (in_array($role_id, $discord_roles)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Initialize access control for KB
     */
    public function init_kb_access_control() {
        // Filter KB queries to hide Staff KB from unauthorized users
        add_filter('pre_get_posts', array($this, 'filter_kb_queries'));
    }
    
    /**
     * Filter KB queries to restrict Staff KB access
     */
    public function filter_kb_queries($query) {
        // Only filter on front-end
        if (is_admin()) {
            return $query;
        }
        
        // Only filter KB queries
        if (!$query->is_main_query() || $query->get('post_type') !== 'knowledgebase') {
            return $query;
        }
        
        // If user doesn't have Discord Moderator role, exclude Staff KB
        if (!$this->user_has_discord_moderator_role()) {
            // Get the Staff KB ID - replace with actual ID
            $staff_kb_id = $this->get_staff_kb_id();
            
            // Get current tax query
            $tax_query = $query->get('tax_query');
            if (!is_array($tax_query)) {
                $tax_query = array();
            }
            
            // Add filter to exclude Staff KB
            $tax_query[] = array(
                'taxonomy' => 'kb_category', // Change to your actual taxonomy
                'field'    => 'term_id',
                'terms'    => $staff_kb_id,
                'operator' => 'NOT IN',
            );
            
            $query->set('tax_query', $tax_query);
        }
        
        return $query;
    }
    
    /**
     * Get the Staff KB ID
     * Replace this with your actual method to identify Staff KB
     */
    private function get_staff_kb_id() {
        // Get the Staff KB term ID
        // This is just an example - replace with your actual code
        $staff_term = get_term_by('slug', 'staff', 'kb_category');
        if ($staff_term) {
            return $staff_term->term_id;
        }
        return 0;
    }
    
    /**
     * Filter KB content to hide Staff KB content
     */
    public function filter_kb_content($content) {
        global $post;
        
        // Only filter KB content
        if (!$post || $post->post_type !== 'knowledgebase') {
            return $content;
        }
        
        // Check if this is Staff KB
        if ($this->is_staff_kb($post->ID)) {
            // If user doesn't have Moderator role, hide content
            if (!$this->user_has_discord_moderator_role()) {
                return '<div class="restricted-content">This content is only available to staff members.</div>';
            }
        }
        
        return $content;
    }
    
    /**
     * Check if a post belongs to Staff KB
     */
    private function is_staff_kb($post_id) {
        $staff_kb_id = $this->get_staff_kb_id();
        
        // If no Staff KB found, return false
        if (!$staff_kb_id) {
            return false;
        }
        
        // Check if post has Staff KB term
        $terms = wp_get_post_terms($post_id, 'kb_category', array('fields' => 'ids'));
        if (is_wp_error($terms)) {
            return false;
        }
        
        return in_array($staff_kb_id, $terms);
    }
    
    /**
     * Redirect unauthorized users trying to access Staff KB
     */
    public function restrict_kb_access() {
        global $post;
        
        // Only check on single KB pages
        if (!is_singular('knowledgebase') || !$post) {
            return;
        }
        
        // Check if this is Staff KB and user doesn't have access
        if ($this->is_staff_kb($post->ID) && !$this->user_has_discord_moderator_role()) {
            // Redirect to KB home or show error
            wp_redirect(home_url('/knowledge-base/'));
            exit;
        }
    }
}

// Initialize the class
new JotunheimStaffKBAccess();