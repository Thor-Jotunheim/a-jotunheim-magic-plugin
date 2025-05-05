<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

/**
 * Defines a role hierarchy where higher roles can access permissions of lower roles.
 */
function get_role_hierarchy() {
    return [
        'admin'     => ['moderator', 'valkyrie', 'vithar'], // Admin has all permissions
        'moderator' => ['valkyrie', 'vithar'],              // Moderator can access Valkyrie and Vithar pages
        'valkyrie'  => ['vithar'],                         // Valkyrie can access Vithar pages
        'vithar'    => []                                  // Vithar has no additional permissions
    ];
}

/**
 * Checks if a user's role matches or exceeds the required role in the hierarchy.
 */
function user_has_access($user_roles, $required_role) {
    $role_hierarchy = get_role_hierarchy();
    
    // If the user has the exact required role, grant access
    if (in_array($required_role, $user_roles)) {
        return true;
    }

    // Check if the user has a higher role that includes the required role
    foreach ($user_roles as $user_role) {
        if (isset($role_hierarchy[$user_role]) && in_array($required_role, $role_hierarchy[$user_role])) {
            return true;
        }
    }

    return false; // Access denied
}

/**
 * Page access control based on Discord roles mapped to WordPress roles
 */
function jotunheim_magic_staff_page_access() {
    if (!is_user_logged_in()) {
        //error_log("User is not logged in.");
        return; // Only logged-in users are checked
    }

    global $post;

    // Check if $post is set and has the post_name property
    if (!isset($post) || !property_exists($post, 'post_name')) {
        error_log("No valid post object found or 'post_name' property missing.");
        return;
    }

    $user_id = get_current_user_id();
    $discord_roles = get_user_meta($user_id, 'discord_roles', true);

    // Fetch user data based on the user ID
    $user_data = get_userdata($user_id);

    if ($user_data) {
        // Log the username and display name
        error_log("Display Name: " . $user_data->display_name);
    } else {
        error_log("Error: Unable to retrieve user data for User ID: " . $user_id);
    }

    // Log the Discord roles retrieved from user meta
    error_log("Discord roles retrieved from user meta: " . print_r($discord_roles, true));

    // Define mappings for pages to required roles
    $staff_pages_roles = [
        'admin'     => '816462309274419250', // Admin Discord role ID
        'moderator' => '816452821208793128', // Moderator Discord role ID
        'valkyrie'  => '963502767173931039', // Valkyrie Discord role ID
        'vithar'    => '1104073178495602751' // Vithar Discord role ID
    ];

    // Check if the current page is a staff page and user has the required role
    if (array_key_exists($post->post_name, $staff_pages_roles)) {
        $required_role = $staff_pages_roles[$post->post_name];
        error_log("Page being accessed: " . $post->post_name);
        error_log("Required role for this page: " . $required_role);

        // Allow access if the user has the required role or a higher role
        if (current_user_can('administrator') || (is_array($discord_roles) && user_has_access($discord_roles, $required_role))) {
            error_log("Access granted to page: " . $post->post_name);
            add_filter('post_password_required', '__return_false'); // Disable password for the page
        } else {
            error_log("Access denied to page: " . $post->post_name);
        }
    } else {
        //error_log("Page " . $post->post_name . " does not require special access.");
    }
}

/**
 * Checks if the current user has the Discord Moderator role
 * @return bool True if user has moderator role or higher
 */
function user_has_discord_moderator_role() {
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
    
    if (empty($discord_roles) || !is_array($discord_roles)) {
        return false;
    }
    
    // Check for moderator role ID (816452821208793128)
    if (in_array('816452821208793128', $discord_roles)) {
        return true;
    }
    
    // Check for admin role ID (816462309274419250)
    if (in_array('816462309274419250', $discord_roles)) {
        return true;
    }
    
    return false;
}

/**
 * Control access to staff knowledge base content based on Discord roles
 */
function jotunheim_restrict_staff_kb_access() {
    // Only filter on front-end
    if (is_admin()) {
        return;
    }
    
    // Redirect from main KB page to Chosen section
    jotunheim_redirect_to_chosen_kb();
    
    // Immediately block direct access to staff KB URLs
    jotunheim_block_direct_staff_kb_access();
    
    // Filter KB queries
    add_filter('pre_get_posts', 'jotunheim_filter_kb_queries');
    
    // Filter KB content
    add_filter('the_content', 'jotunheim_filter_kb_content', 999);
    
    // Hide the staff section from KB navigation
    add_filter('basepress_sections_list', 'jotunheim_filter_section_list', 999);
    
    // Hide the staff section from breadcrumbs
    add_filter('basepress_breadcrumbs', 'jotunheim_filter_breadcrumbs', 999);
    
    // Remove staff section links
    add_filter('basepress_articles_list', 'jotunheim_filter_articles_list', 999);
}
add_action('wp', 'jotunheim_restrict_staff_kb_access');

/**
 * Redirect from main KB page to the Chosen section
 */
function jotunheim_redirect_to_chosen_kb() {
    // Check if we're on the main KB page without any section specified
    $current_url = $_SERVER['REQUEST_URI'];
    
    // Match exactly /knowledge-base/ with trailing slash
    if ($current_url == '/knowledge-base/' || $current_url == '/knowledge-base') {
        // Don't redirect admins and moderators
        if (!user_has_discord_moderator_role()) {
            wp_redirect(home_url('/knowledge-base/chosen/'));
            exit;
        }
    }
}

/**
 * Block direct access to Staff KB URLs
 */
function jotunheim_block_direct_staff_kb_access() {
    // Check if this is a Knowledge Base URL with "staff" in it
    $current_url = $_SERVER['REQUEST_URI'];
    
    // If URL contains both 'knowledge-base' and 'staff', check access
    if (strpos($current_url, 'knowledge-base/staff') !== false || 
        strpos($current_url, 'knowledge-base/staff/') !== false) {
        
        // Block access if not a moderator
        if (!user_has_discord_moderator_role()) {
            wp_redirect(home_url('/knowledge-base/'));
            exit;
        }
    }
}

/**
 * Filter KB queries to restrict Staff KB access
 */
function jotunheim_filter_kb_queries($query) {
    // Only filter KB queries
    if (!$query->is_main_query() || $query->get('post_type') !== 'knowledgebase') {
        return $query;
    }
    
    // If user doesn't have Discord Moderator role, exclude Staff KB
    if (!user_has_discord_moderator_role()) {
        // Get the Staff KB ID
        $staff_kb_id = jotunheim_get_staff_kb_id();
        
        // Get current tax query
        $tax_query = $query->get('tax_query');
        if (!is_array($tax_query)) {
            $tax_query = array();
        }
        
        // Add filter to exclude Staff KB
        $tax_query[] = array(
            'taxonomy' => 'kb_category', // Change if your taxonomy is different
            'field'    => 'term_id',
            'terms'    => $staff_kb_id,
            'operator' => 'NOT IN',
        );
        
        $query->set('tax_query', $tax_query);
    }
    
    return $query;
}

/**
 * Filter KB content to hide Staff KB content
 */
function jotunheim_filter_kb_content($content) {
    global $post;
    
    // Only filter KB content
    if (!$post || $post->post_type !== 'knowledgebase') {
        return $content;
    }
    
    // Check if this is Staff KB
    if (jotunheim_is_staff_kb($post->ID)) {
        // If user doesn't have Moderator role, hide content
        if (!user_has_discord_moderator_role()) {
            return '<div class="restricted-content">This content is only available to staff members.</div>';
        }
    }
    
    return $content;
}

/**
 * Filter KB sections list to remove Staff section
 */
function jotunheim_filter_section_list($sections) {
    // If user doesn't have moderator role, remove Staff section
    if (!user_has_discord_moderator_role()) {
        $staff_kb_id = jotunheim_get_staff_kb_id();
        
        if ($staff_kb_id) {
            foreach ($sections as $key => $section) {
                // Check if section ID or parent ID matches Staff KB ID
                if ((isset($section->term_id) && $section->term_id == $staff_kb_id) || 
                    (isset($section->parent) && $section->parent == $staff_kb_id)) {
                    unset($sections[$key]);
                }
            }
        }
    }
    
    return $sections;
}

/**
 * Filter breadcrumbs to remove Staff KB elements
 */
function jotunheim_filter_breadcrumbs($breadcrumbs) {
    // If user doesn't have moderator role and breadcrumbs contain Staff elements
    if (!user_has_discord_moderator_role()) {
        $staff_kb_id = jotunheim_get_staff_kb_id();
        
        if ($staff_kb_id && is_array($breadcrumbs)) {
            foreach ($breadcrumbs as $key => $crumb) {
                // Look for staff element in the URL or ID
                if (isset($crumb['url']) && strpos($crumb['url'], 'staff') !== false) {
                    // Remove this and all subsequent breadcrumbs
                    for ($i = $key; $i < count($breadcrumbs); $i++) {
                        unset($breadcrumbs[$i]);
                    }
                    break;
                }
            }
        }
    }
    
    return $breadcrumbs;
}

/**
 * Filter article list to remove Staff KB articles
 */
function jotunheim_filter_articles_list($articles) {
    // If user doesn't have moderator role, filter articles
    if (!user_has_discord_moderator_role()) {
        $staff_kb_id = jotunheim_get_staff_kb_id();
        
        if ($staff_kb_id && is_array($articles)) {
            foreach ($articles as $key => $article) {
                if (jotunheim_is_staff_kb($article->ID)) {
                    unset($articles[$key]);
                }
            }
        }
    }
    
    return $articles;
}

/**
 * Redirect unauthorized users trying to access Staff KB
 */
function jotunheim_check_kb_access() {
    global $post;
    
    // Only check on single KB pages
    if (!is_singular('knowledgebase') || !$post) {
        return;
    }
    
    // Check if this is Staff KB and user doesn't have access
    if (jotunheim_is_staff_kb($post->ID) && !user_has_discord_moderator_role()) {
        // Redirect to KB home or show error
        wp_redirect(home_url('/knowledge-base/'));
        exit;
    }
}

/**
 * Get the Staff KB ID - more robust version
 */
function jotunheim_get_staff_kb_id() {
    // First try by slug
    $staff_term = get_term_by('slug', 'staff', 'kb_category');
    if ($staff_term) {
        return $staff_term->term_id;
    }
    
    // Try by name
    $staff_term = get_term_by('name', 'Staff', 'kb_category');
    if ($staff_term) {
        return $staff_term->term_id;
    }
    
    // Try by word matching in name
    $args = array(
        'taxonomy' => 'kb_category',
        'hide_empty' => false,
    );
    
    $terms = get_terms($args);
    
    if (!is_wp_error($terms) && is_array($terms)) {
        foreach ($terms as $term) {
            // Look for terms containing 'staff' in the name
            if (stripos($term->name, 'staff') !== false) {
                return $term->term_id;
            }
        }
    }
    
    return 0;
}

/**
 * Modified check if a post belongs to Staff KB - more thorough
 */
function jotunheim_is_staff_kb($post_id) {
    $staff_kb_id = jotunheim_get_staff_kb_id();
    
    // If no Staff KB found, return false
    if (!$staff_kb_id) {
        return false;
    }
    
    // Check if post has Staff KB term
    $terms = wp_get_post_terms($post_id, 'kb_category', array('fields' => 'ids'));
    if (is_wp_error($terms)) {
        return false;
    }
    
    if (in_array($staff_kb_id, $terms)) {
        return true;
    }
    
    // Check the post's ancestors to see if any belong to Staff KB
    $ancestors = get_ancestors($post_id, 'knowledgebase');
    foreach ($ancestors as $ancestor_id) {
        $ancestor_terms = wp_get_post_terms($ancestor_id, 'kb_category', array('fields' => 'ids'));
        if (!is_wp_error($ancestor_terms) && in_array($staff_kb_id, $ancestor_terms)) {
            return true;
        }
    }
    
    return false;
}

function assign_roles_from_permissions($user_id, $permissions_csv) {
    $permissions = explode(',', $permissions_csv); // Assuming permissions are comma-separated
    $wp_role = 'subscriber'; // Default role

    if (in_array('admin', $permissions)) {
        $wp_role = 'administrator';
    } elseif (in_array('editor', $permissions)) {
        $wp_role = 'editor';
    }

    // Assign WordPress role
    $user = new WP_User($user_id);
    $user->set_role($wp_role);
}

add_action('wp', 'jotunheim_magic_staff_page_access');