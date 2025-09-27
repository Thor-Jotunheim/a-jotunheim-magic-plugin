<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class JotunheimPagePermissions {
    
    public function __construct() {
        add_action('wp_ajax_save_page_permissions', [$this, 'ajax_save_page_permissions']);
        add_action('wp_ajax_get_page_permissions', [$this, 'ajax_get_page_permissions']);
        add_action('wp_ajax_scan_new_pages', [$this, 'ajax_scan_new_pages']);
        add_action('wp_ajax_remove_pages', [$this, 'ajax_remove_pages']);
        
        // Add admin capability management
        add_action('init', [$this, 'manage_admin_capabilities'], 1);
    }
    
    /**
     * Manage admin page capabilities based on Discord permissions
     */
    public function manage_admin_capabilities() {
        if (is_admin()) {
            add_action('admin_init', [$this, 'check_admin_page_access']);
        }

        $current_user = wp_get_current_user();
        
        // Don't interfere with administrators at all
        if (in_array('administrator', $current_user->roles)) {
            return;
        }
        
        // Only apply to users with editor role (but not administrator)
        if (!in_array('editor', $current_user->roles)) {
            return;
        }

        // Get the current admin page being accessed
        $current_page = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : '';
        
        if (!$current_page) {
            return;
        }

        // Check if user has Discord permission for this admin page
        $user_id = $current_user->ID;
        if (self::user_can_access_page($current_page, $user_id)) {
            // Grant manage_options capability for this specific page
            add_filter('user_has_cap', function($allcaps, $caps, $args, $user) use ($current_user, $current_page) {
                // Only modify capabilities for the current user
                if ($user->ID === $current_user->ID) {
                    // Check if we're requesting manage_options capability
                    if (isset($caps[0]) && $caps[0] === 'manage_options') {
                        $allcaps['manage_options'] = true;
                        error_log("Jotunheim Page Permissions: Granted manage_options to user {$current_user->user_login} for page {$current_page}");
                    }
                }
                return $allcaps;
            }, 10, 4);
        }
    }
    }
    
    /**
     * Check access to admin pages
     */
    public function check_admin_page_access() {
        global $pagenow;
        
        // Skip for AJAX requests
        if (wp_doing_ajax()) {
            return;
        }
        
        // Skip for WordPress core pages
        $core_pages = ['index.php', 'update-core.php', 'plugins.php', 'themes.php', 'users.php', 'options-general.php'];
        if (in_array($pagenow, $core_pages)) {
            return;
        }
        
        $current_page = isset($_GET['page']) ? $_GET['page'] : '';
        
        if ($current_page && !$this->user_can_access_page($current_page)) {
            wp_die('You do not have permission to access this page.');
        }
    }
    
    /**
     * Get all available pages - includes shortcodes like dashboard config
     */
    public function get_all_available_pages() {
        global $wpdb;
        
        $all_pages = [];
        
        // Get admin menu pages
        global $admin_page_hooks, $submenu;
        
        if (!empty($admin_page_hooks)) {
            foreach ($admin_page_hooks as $page => $hook) {
                $all_pages["page_{$page}"] = [
                    'title' => $page,
                    'type' => 'admin_page',
                    'source' => 'WordPress Admin'
                ];
            }
        }
        
        // Get submenu pages
        if (!empty($submenu)) {
            foreach ($submenu as $parent => $items) {
                if (is_array($items)) {
                    foreach ($items as $item) {
                        if (isset($item[2])) {
                            $page_slug = $item[2];
                            $all_pages["page_{$page_slug}"] = [
                                'title' => isset($item[0]) ? $item[0] : $page_slug,
                                'type' => 'admin_submenu',
                                'source' => 'WordPress Admin'
                            ];
                        }
                    }
                }
            }
        }
        
        // Get all posts and pages with content
        $posts = $wpdb->get_results("
            SELECT ID, post_title, post_content, post_name, post_type 
            FROM {$wpdb->posts} 
            WHERE post_status = 'publish' 
            AND post_type IN ('page', 'post')
            AND post_content LIKE '%[%'
        ");
        
        foreach ($posts as $post) {
            // Add page itself
            $all_pages["page_id_{$post->ID}"] = [
                'title' => $post->post_title,
                'type' => 'wordpress_page',
                'source' => 'WordPress Page'
            ];
            
            // Extract shortcodes using same logic as dashboard config
            $shortcode_pattern = '/\[([^\]\/\s]+)(?:[^\]]*)\]/';
            if (preg_match_all($shortcode_pattern, $post->post_content, $matches)) {
                foreach ($matches[1] as $shortcode_name) {
                    $shortcode_name = trim($shortcode_name);
                    
                    // Skip common WordPress shortcodes
                    $wp_shortcodes = ['gallery', 'audio', 'video', 'embed', 'caption'];
                    if (!in_array($shortcode_name, $wp_shortcodes)) {
                        $all_pages["shortcode_{$shortcode_name}"] = [
                            'title' => "[{$shortcode_name}] Shortcode",
                            'type' => 'shortcode',
                            'source' => "Page: {$post->post_title}",
                            'post_id' => $post->ID
                        ];
                    }
                }
            }
        }
        
        // Get registered shortcodes that might not be in content
        global $shortcode_tags;
        if (!empty($shortcode_tags)) {
            foreach ($shortcode_tags as $tag => $function) {
                // Skip WordPress core shortcodes
                $wp_shortcodes = ['gallery', 'audio', 'video', 'embed', 'caption', 'wp_caption'];
                if (!in_array($tag, $wp_shortcodes)) {
                    if (!isset($all_pages["shortcode_{$tag}"])) {
                        $all_pages["shortcode_{$tag}"] = [
                            'title' => "[{$tag}] Shortcode",
                            'type' => 'shortcode',
                            'source' => 'Registered Shortcode'
                        ];
                    }
                }
            }
        }
        
        // Sort by title
        uasort($all_pages, function($a, $b) {
            return strcmp($a['title'], $b['title']);
        });
        
        return $all_pages;
    }
    
    /**
     * Get configured page permissions
     */
    public function get_page_permissions() {
        return get_option('jotunheim_page_permissions', []);
    }
    
    /**
     * AJAX handler for saving page permissions
     */
    public function ajax_save_page_permissions() {
        try {
            if (!current_user_can('manage_options')) {
                wp_send_json_error('Unauthorized access');
                return;
            }
            
            if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'page_permissions_nonce')) {
                wp_send_json_error('Invalid security token');
                return;
            }
            
            $permissions = isset($_POST['permissions']) ? $_POST['permissions'] : [];
            
            // Sanitize permissions data
            $sanitized_permissions = [];
            foreach ($permissions as $page_key => $roles) {
                $page_key = sanitize_key($page_key);
                foreach ($roles as $role_key => $value) {
                    $role_key = sanitize_key($role_key);
                    $sanitized_permissions[$page_key][$role_key] = (bool) $value;
                }
            }
            
            // Save permissions
            update_option('jotunheim_page_permissions', $sanitized_permissions);
            
            wp_send_json_success('Page permissions saved successfully');
            
        } catch (Exception $e) {
            wp_send_json_error('Unexpected error: ' . $e->getMessage());
        }
    }
    
    /**
     * AJAX handler for getting page permissions
     */
    public function ajax_get_page_permissions() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized access');
            return;
        }
        
        $permissions = $this->get_page_permissions();
        wp_send_json_success($permissions);
    }
    
    /**
     * AJAX handler for scanning new pages
     */
    public function ajax_scan_new_pages() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized access');
            return;
        }
        
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'page_permissions_nonce')) {
            wp_send_json_error('Invalid security token');
            return;
        }
        
        // Get currently configured pages
        $current_permissions = $this->get_page_permissions();
        $configured_pages = array_keys($current_permissions);
        
        // Get all available pages (including newly detected ones)
        $all_pages = $this->get_all_available_pages();
        $all_page_keys = array_keys($all_pages);
        
        // Find new pages
        $new_pages = array_diff($all_page_keys, $configured_pages);
        
        if (empty($new_pages)) {
            wp_send_json_success([
                'new_count' => 0,
                'message' => 'No new pages found. All available pages are already configured.',
                'new_pages' => []
            ]);
            return;
        }
        
        // Prepare new pages data
        $new_pages_data = [];
        foreach ($new_pages as $page_key) {
            $new_pages_data[$page_key] = $all_pages[$page_key];
        }
        
        wp_send_json_success([
            'new_count' => count($new_pages),
            'message' => count($new_pages) . ' new page(s) found and ready to configure.',
            'new_pages' => $new_pages_data
        ]);
    }
    
    /**
     * AJAX handler for removing pages
     */
    public function ajax_remove_pages() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized access');
            return;
        }
        
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'page_permissions_nonce')) {
            wp_send_json_error('Invalid security token');
            return;
        }
        
        $pages_to_remove = isset($_POST['pages']) ? (array) $_POST['pages'] : [];
        
        if (empty($pages_to_remove)) {
            wp_send_json_error('No pages selected for removal');
            return;
        }
        
        // Get current permissions
        $current_permissions = $this->get_page_permissions();
        
        // Remove selected pages
        $removed_count = 0;
        foreach ($pages_to_remove as $page_key) {
            if (isset($current_permissions[$page_key])) {
                unset($current_permissions[$page_key]);
                $removed_count++;
            }
        }
        
        // Save updated permissions
        update_option('jotunheim_page_permissions', $current_permissions);
        
        wp_send_json_success([
            'removed_count' => $removed_count,
            'message' => $removed_count . ' page(s) removed from permissions configuration.'
        ]);
    }
    
    /**
     * Check if a user has permission to access a specific page
     */
    public static function user_can_access_page($page_slug, $user_id = null) {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }
        
        // Admins can ALWAYS access everything - don't even check Discord permissions
        if (user_can($user_id, 'manage_options')) {
            return true;
        }
        
        // Get page permissions configuration
        $page_permissions = get_option('jotunheim_page_permissions', []);
        
        // If this page isn't configured, use WordPress permissions as fallback
        if (!isset($page_permissions[$page_slug])) {
            // Get user Discord roles for fallback check
            $user_discord_roles = get_user_meta($user_id, 'discord_roles', true);
            if (!is_array($user_discord_roles)) {
                $user_discord_roles = [];
            }
            
            // If page not configured, fall back to WordPress permissions
            error_log("Jotunheim Page Permissions: Page {$page_slug} not configured, checking WordPress fallback permissions for user {$user_id}");
            
            // First check if user has high-level Discord role as fallback
            $high_level_roles = ['norn', 'aesir'];
            foreach ($user_discord_roles as $role_key) {
                if (in_array($role_key, $high_level_roles)) {
                    error_log("Jotunheim Page Permissions: Granting access to unconfigured page {$page_slug} for high-level role {$role_key}");
                    return true;
                }
            }
            
            // Fall back to WordPress capabilities
            // Admin pages should require manage_options
            // Shortcode pages should allow manage_options or edit_posts (editors)
            if (user_can($user_id, 'manage_options')) {
                error_log("Jotunheim Page Permissions: Granting access to unconfigured page {$page_slug} via manage_options capability");
                return true;
            }
            
            // For shortcode pages, also allow editors
            if (user_can($user_id, 'edit_posts')) {
                error_log("Jotunheim Page Permissions: Granting access to unconfigured shortcode {$page_slug} via edit_posts capability");
                return true;
            }
            
            error_log("Jotunheim Page Permissions: Denying access to unconfigured page {$page_slug} - no WordPress fallback permissions");
            return false; // Page not configured and no WordPress permissions = no access
        }
        
        // Check Discord permissions for configured pages
        $user_discord_roles = get_user_meta($user_id, 'discord_roles', true);
        if (!is_array($user_discord_roles)) {
            $user_discord_roles = [];
        }
        
        $required_roles = $page_permissions[$page_slug];
        
        // Check if user has any of the required roles
        foreach ($required_roles as $role => $required) {
            if ($required && in_array($role, $user_discord_roles)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Render the page permissions configuration page
     */
    public function render() {
        // Enqueue scripts and styles
        wp_enqueue_script(
            'page-permissions-js',
            plugin_dir_url(__FILE__) . '../../assets/js/page-permissions.js',
            ['jquery'],
            '1.0.0',
            true
        );
        
        // Localize script with AJAX data
        wp_localize_script('page-permissions-js', 'page_permissions_config', [
            'nonce' => wp_create_nonce('page_permissions_nonce'),
            'ajax_url' => admin_url('admin-ajax.php')
        ]);
        
        // Add custom CSS for larger checkboxes
        ?>
        <style>
        .permission-checkbox {
            width: 20px !important;
            height: 20px !important;
            transform: scale(1.5);
            margin: 8px !important;
            cursor: pointer;
        }
        
        .wp-list-table td {
            vertical-align: middle !important;
        }
        
        .page-permissions-config .wp-list-table th {
            text-align: center;
            padding: 15px 8px;
        }
        
        .page-permissions-config .wp-list-table td {
            padding: 15px 8px;
        }
        </style>
        <?php
        
        // Get Discord roles
        $discord_roles = $this->get_discord_roles();
        
        // Get plugin pages for display
        $plugin_pages = $this->get_plugin_pages();
        
        // Display the interface
        ?>
        <div class="wrap page-permissions-config">
            <h1>Discord Role-Based Page Access Control</h1>
            <p>Configure which Discord roles can access specific pages and shortcodes. Unconfigured pages use WordPress permissions as fallback.</p>
            
            <div style="margin-bottom: 20px;">
                <button type="button" id="scan-new-pages-btn" class="button button-primary">🔍 Scan for New Pages</button>
                <button type="button" id="remove-pages-btn" class="button button-secondary">🗑️ Remove Selected Pages</button>
                <button type="button" id="save-permissions-btn" class="button button-primary">💾 Save Permissions</button>
            </div>
            
            <div id="scan-results" style="margin-bottom: 20px;"></div>
            
            <form id="permissions-form">
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th style="width: 40px;"><input type="checkbox" id="select-all"></th>
                            <th style="width: 300px;">Page/Shortcode</th>
                            <th style="width: 200px;">Type</th>
                            <?php foreach ($discord_roles as $role): ?>
                                <th style="text-align: center;"><?php echo esc_html(ucfirst($role)); ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($plugin_pages as $page_key => $page_info): ?>
                            <tr>
                                <td><input type="checkbox" name="selected_pages[]" value="<?php echo esc_attr($page_key); ?>" class="page-selector"></td>
                                <td>
                                    <strong><?php echo esc_html($page_info['title']); ?></strong>
                                    <?php if (isset($page_info['description'])): ?>
                                        <br><small><?php echo esc_html($page_info['description']); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="page-type-badge"><?php echo esc_html($page_info['type'] ?? 'Unknown'); ?></span>
                                </td>
                                <?php foreach ($discord_roles as $role): ?>
                                    <td style="text-align: center;">
                                        <input 
                                            type="checkbox" 
                                            name="permissions[<?php echo esc_attr($page_key); ?>][<?php echo esc_attr($role); ?>]" 
                                            value="1" 
                                            class="permission-checkbox"
                                            <?php 
                                            $permissions = $this->get_page_permissions();
                                            echo isset($permissions[$page_key][$role]) && $permissions[$page_key][$role] ? 'checked' : ''; 
                                            ?>
                                        >
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </form>
            
            <p><em>Note: Administrators can always access all pages regardless of Discord role settings.</em></p>
        </div>
        <?php
    }
    
    /**
     * Get plugin pages for display (shows configured pages plus admin pages)
     */
    private function get_plugin_pages() {
        $current_permissions = $this->get_page_permissions();
        $configured_page_keys = array_keys($current_permissions);
        
        // Always include admin pages (they should always be visible)
        $admin_pages = $this->get_admin_pages();
        $pages = $admin_pages;
        
        // Add shortcode pages that are configured in permissions
        $all_available = $this->get_all_available_pages();
        foreach ($configured_page_keys as $page_key) {
            if (isset($all_available[$page_key]) && !isset($admin_pages[$page_key])) {
                $pages[$page_key] = $all_available[$page_key];
            }
        }
        
        return $pages;
    }
    
    /**
     * Get admin pages (always shown in interface)
     */
    private function get_admin_pages() {
        return [
            'jotunheim_magic' => [
                'title' => 'Overview Dashboard',
                'description' => 'Main dashboard overview page',
                'type' => 'admin_page'
            ],
            'dashboard_config' => [
                'title' => 'Dashboard Configuration',
                'description' => 'Configure dashboard layout',
                'type' => 'admin_page'
            ],
            'discord_auth_config' => [
                'title' => 'Discord Auth Configuration',
                'description' => 'Configure Discord authentication',
                'type' => 'admin_page'
            ],
            'page_permissions_config' => [
                'title' => 'Page Permissions Config',
                'description' => 'Configure Discord role-based page access permissions',
                'type' => 'admin_page'
            ]
        ];
    }
    
    /**
     * Get Discord roles from configuration
     */
    private function get_discord_roles() {
        $roles = get_option('jotunheim_discord_roles', [
            'norn', 'aesir', 'admin', 'staff', 'valkyrie', 'vithar', 'chosen'
        ]);
        
        // Ensure it's an array
        if (!is_array($roles)) {
            $roles = ['norn', 'aesir', 'admin', 'staff', 'valkyrie', 'vithar', 'chosen'];
        }
        
        return $roles;
    }
}

/**
 * Check shortcode permissions - used by other parts of the plugin
 */
function jotunheim_check_shortcode_permission($shortcode_name, $return_login_button = true) {
    // Check if user is logged in
    if (!is_user_logged_in()) {
        if ($return_login_button) {
            return do_shortcode('[discord_login_button]');
        }
        return '<div class="jotunheim-error">Please log in to access this feature.</div>';
    }
    
    // Check Discord permissions using the page permissions system
    if (!JotunheimPagePermissions::user_can_access_page("shortcode_{$shortcode_name}")) {
        return '<div class="jotunheim-error">You do not have permission to access this feature. Please contact an administrator if you believe this is an error.</div>';
    }
    
    return null; // Permission granted
}

/**
 * Helper function for compatibility
 */
function jotunheim_user_can_access_page($page_slug) {
    return JotunheimPagePermissions::user_can_access_page($page_slug);
}

/**
 * Function to render the page permissions config page
 */
function render_page_permissions_config_page() {
    $page_permissions = new JotunheimPagePermissions();
    $page_permissions->render();
}

// Initialize the permissions system
global $jotunheim_page_permissions;
$jotunheim_page_permissions = new JotunheimPagePermissions();