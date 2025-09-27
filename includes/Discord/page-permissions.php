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
        add_action('wp_ajax_add_selected_pages', [$this, 'ajax_add_selected_pages']);
        add_action('wp_ajax_remove_pages', [$this, 'ajax_remove_pages']);
        
        // Add admin capability management
        add_action('init', [$this, 'manage_admin_capabilities'], 1);
    }
    
    /**
     * Manage admin page capabilities based on Discord permissions
     */
    public function manage_admin_capabilities() {
        // Only run in admin area for logged-in users
        if (!is_admin() || !is_user_logged_in()) {
            return;
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
        
        // Get plugin pages
        $plugin_pages = $this->get_plugin_pages();
        
        // Get current permissions
        $current_permissions = $this->get_page_permissions();
        
        ?>
        <div class="wrap">
            <h1>Page Permissions Configuration</h1>
            <div class="page-permissions-config">
                
                <div class="description">
                    <p>Configure which Discord roles can access specific plugin pages. Check the boxes to grant access to each role.</p>
                </div>
                
                <!-- Action buttons at the top -->
                <div class="permissions-actions" style="margin: 20px 0; padding: 15px; background: #f9f9f9; border: 1px solid #ddd;">
                    <button type="button" class="button" id="select-all-permissions">Select All</button>
                    <button type="button" class="button" id="clear-all-permissions">Clear All</button>
                    <button type="button" class="button" id="scan-new-pages">🔍 Scan for New Pages</button>
                    <button type="button" class="button" id="remove-pages">🗑️ Remove Pages</button>
                    <button type="button" class="button button-primary" id="save-page-permissions">Save Permissions</button>
                </div>
                
                <?php if (empty($discord_roles)): ?>
                    <div class="notice notice-warning">
                        <p><strong>No Discord roles configured.</strong> Please configure Discord roles first in the <a href="<?php echo admin_url('admin.php?page=discord_auth_config'); ?>">Discord Auth Configuration</a> page.</p>
                    </div>
                <?php else: ?>
                    
                    <form id="page-permissions-form">
                        <table class="wp-list-table widefat fixed striped">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">
                                        <input type="checkbox" id="select-all-pages" title="Select All Pages">
                                    </th>
                                    <th style="width: 300px;"><strong>Plugin Page</strong></th>
                                    <?php foreach ($discord_roles as $role_key => $role_data): ?>
                                        <?php if (!empty($role_data['name']) && !empty($role_data['id'])): ?>
                                            <th style="text-align: center; width: 120px;">
                                                <strong><?php echo esc_html($role_data['name']); ?></strong>
                                                <br><small>ID: <?php echo esc_html($role_data['id']); ?></small>
                                            </th>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($plugin_pages as $page_key => $page_data): ?>
                                    <tr>
                                        <td style="text-align: center;">
                                            <input type="checkbox" class="page-select-checkbox" value="<?php echo esc_attr($page_key); ?>" name="selected_pages[]">
                                        </td>
                                        <td>
                                            <strong><?php echo esc_html($page_data['title']); ?></strong>
                                            <br><small><?php echo esc_html($page_data['description']); ?></small>
                                            <br><em>Slug: <?php echo esc_html($page_key); ?></em>
                                        </td>
                                        <?php foreach ($discord_roles as $role_key => $role_data): ?>
                                            <?php if (!empty($role_data['name']) && !empty($role_data['id'])): ?>
                                                <td style="text-align: center;">
                                                    <?php 
                                                    $is_checked = isset($current_permissions[$page_key][$role_key]) ? $current_permissions[$page_key][$role_key] : false;
                                                    ?>
                                                    <input 
                                                        type="checkbox" 
                                                        name="permissions[<?php echo esc_attr($page_key); ?>][<?php echo esc_attr($role_key); ?>]"
                                                        value="1"
                                                        <?php checked($is_checked, true); ?>
                                                        class="permission-checkbox"
                                                        data-page="<?php echo esc_attr($page_key); ?>"
                                                        data-role="<?php echo esc_attr($role_key); ?>"
                                                    />
                                                </td>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </form>
                    
                <?php endif; ?>
                
            </div>
        </div>
        <?php
    }
    
    /**
     * Get Discord roles from the auth config
     */
    private function get_discord_roles() {
        $discord_roles = get_option('jotunheim_discord_roles', []);
        
        // Filter out empty roles
        $valid_roles = [];
        foreach ($discord_roles as $key => $role) {
            if (!empty($role['name']) && !empty($role['id'])) {
                $valid_roles[$key] = $role;
            }
        }
        
        return $valid_roles;
    }
    
    /**
     * Comprehensive page scan using dashboard config methodology
     */
    private function comprehensive_page_scan() {
        global $wpdb;
        
        $all_pages = [];
        
        error_log('Jotunheim Page Permissions: Starting comprehensive page scan...');
        
        // Get admin menu pages
        global $admin_page_hooks, $submenu;
        
        if (!empty($admin_page_hooks)) {
            foreach ($admin_page_hooks as $page => $hook) {
                $all_pages["page_{$page}"] = [
                    'title' => ucwords(str_replace('-', ' ', $page)),
                    'description' => 'WordPress admin page',
                    'type' => 'admin_page'
                ];
            }
            error_log('Jotunheim Page Permissions: Found ' . count($admin_page_hooks) . ' admin page hooks');
        }
        
        // Get submenu pages
        if (!empty($submenu)) {
            $submenu_count = 0;
            foreach ($submenu as $parent => $items) {
                if (is_array($items)) {
                    foreach ($items as $item) {
                        if (isset($item[2])) {
                            $page_slug = $item[2];
                            $all_pages["page_{$page_slug}"] = [
                                'title' => isset($item[0]) ? $item[0] : ucwords(str_replace('-', ' ', $page_slug)),
                                'description' => 'WordPress admin submenu page',
                                'type' => 'admin_submenu'
                            ];
                            $submenu_count++;
                        }
                    }
                }
            }
            error_log('Jotunheim Page Permissions: Found ' . $submenu_count . ' submenu items');
        }
        
        // Scan for render functions like dashboard config does
        $functions = get_defined_functions()['user'];
        $render_count = 0;
        
        foreach ($functions as $function) {
            if (preg_match('/^render_(.+)_page$/', $function, $matches)) {
                $page_id = $matches[1];
                $page_title = ucwords(str_replace('_', ' ', $page_id));
                
                if (!isset($all_pages["render_{$page_id}"])) {
                    $all_pages["render_{$page_id}"] = [
                        'title' => $page_title,
                        'description' => "Render function: {$function}",
                        'type' => 'render_function'
                    ];
                    $render_count++;
                }
            }
        }
        error_log('Jotunheim Page Permissions: Found ' . $render_count . ' render functions');
        
        // Get all posts and pages with content
        $posts = $wpdb->get_results("
            SELECT ID, post_title, post_content, post_name, post_type 
            FROM {$wpdb->posts} 
            WHERE post_status = 'publish' 
            AND post_type IN ('page', 'post')
            AND post_content LIKE '%[%'
        ");
        
        $shortcode_count = 0;
        foreach ($posts as $post) {
            // Extract shortcodes using same logic as dashboard config
            $shortcode_pattern = '/\[([^\]\/\s]+)(?:[^\]]*)\]/';
            if (preg_match_all($shortcode_pattern, $post->post_content, $matches)) {
                foreach ($matches[1] as $shortcode_name) {
                    $shortcode_name = trim($shortcode_name);
                    
                    // Skip common WordPress shortcodes
                    $wp_shortcodes = ['gallery', 'audio', 'video', 'embed', 'caption'];
                    if (!in_array($shortcode_name, $wp_shortcodes)) {
                        if (!isset($all_pages["shortcode_{$shortcode_name}"])) {
                            $all_pages["shortcode_{$shortcode_name}"] = [
                                'title' => "[{$shortcode_name}] Shortcode",
                                'description' => "Found on page: {$post->post_title}",
                                'type' => 'shortcode'
                            ];
                            $shortcode_count++;
                        }
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
                            'description' => 'Registered shortcode',
                            'type' => 'shortcode'
                        ];
                        $shortcode_count++;
                    }
                }
            }
        }
        
        error_log('Jotunheim Page Permissions: Found ' . $shortcode_count . ' shortcodes');
        error_log('Jotunheim Page Permissions: Total pages detected: ' . count($all_pages));
        
        // Sort by title
        uasort($all_pages, function($a, $b) {
            return strcmp($a['title'], $b['title']);
        });
        
        return $all_pages;
    }
    
    /**
     * Get all plugin pages that can have permissions
     * Now dynamically pulls from Dashboard Manager's shortcode detection + hardcoded admin pages
     */
    private function get_plugin_pages() {
        $pages = [];
        
        // First add core admin pages (non-shortcode)
        $admin_pages = [
            'jotunheim_magic' => [
                'title' => 'Overview Dashboard',
                'description' => 'Main dashboard overview page'
            ],
            'dashboard_config' => [
                'title' => 'Dashboard Configuration',
                'description' => 'Configure dashboard layout'
            ],
            'discord_auth_config' => [
                'title' => 'Discord Auth Configuration',
                'description' => 'Configure Discord authentication'
            ],
            'page_permissions_config' => [
                'title' => 'Page Permissions Config',
                'description' => 'Configure Discord role-based page access permissions'
            ],
            'universal_ui_table_config' => [
                'title' => 'Universal UI Table Config',
                'description' => 'Configure UI table settings'
            ],
            'weather_calendar_config' => [
                'title' => 'Weather Calendar Config',
                'description' => 'Configure weather and calendar'
            ],
            'eventzone_field_config' => [
                'title' => 'EventZone Field Config',
                'description' => 'Configure event zone fields'
            ]
        ];
        
        // Add admin pages
        $pages = array_merge($pages, $admin_pages);
        
        // Now dynamically add all detected shortcode pages
        // Use the same predefined shortcodes as Dashboard Manager
        $predefined_shortcodes = [
            'shop_manager' => [
                'title' => 'Shop Manager',
                'description' => 'Manage shop inventory and pricing',
                'category' => 'commerce'
            ],
            'unified_teller' => [
                'title' => 'Unified Teller',
                'description' => 'Point of sale and transaction interface',
                'category' => 'commerce'
            ],
            'itemlist_editor' => [
                'title' => 'Item List Editor',
                'description' => 'Edit and manage game items',
                'category' => 'content'
            ],
            'item_list_editor' => [
                'title' => 'Item List Editor (Alt)',
                'description' => 'Alternative item list editor interface',
                'category' => 'content'
            ],
            'item_list_add_new_item' => [
                'title' => 'Add New Item',
                'description' => 'Add new items to the game',
                'category' => 'content'
            ],
            'eventzones_editor' => [
                'title' => 'Event Zones Editor',
                'description' => 'Edit and manage event zones',
                'category' => 'content'
            ],
            'event_zone_editor' => [
                'title' => 'Event Zone Editor (Alt)',
                'description' => 'Alternative event zone editor interface',
                'category' => 'content'
            ],
            'add_event_zone' => [
                'title' => 'Add Event Zone',
                'description' => 'Create new event zones',
                'category' => 'content'
            ],
            'pos_interface' => [
                'title' => 'Point of Sale Interface',
                'description' => 'POS interface for transactions',
                'category' => 'commerce'
            ],
            'jotunheim_trade_page' => [
                'title' => 'Trade Management',
                'description' => 'Manage trading system',
                'category' => 'commerce'
            ],
            'trade' => [
                'title' => 'Trade System (Alt)',
                'description' => 'Alternative trade system interface',
                'category' => 'commerce'
            ],
            'jotunheim_barter_page' => [
                'title' => 'Barter System',
                'description' => 'Manage barter and exchange system',
                'category' => 'commerce'
            ],
            'barter' => [
                'title' => 'Barter System (Alt)',
                'description' => 'Alternative barter system interface',
                'category' => 'commerce'
            ],
            'universal_editor_ui' => [
                'title' => 'Universal Editor UI',
                'description' => 'Universal content editing interface',
                'category' => 'content'
            ],
            'eventzones_code_output' => [
                'title' => 'Event Zones Code Output',
                'description' => 'Event zone code generation and output',
                'category' => 'utility'
            ],
            'section2_items' => [
                'title' => 'Section 2 Items',
                'description' => 'Manage section 2 item collections',
                'category' => 'content'
            ],
            'prefabdb_image_import' => [
                'title' => 'Prefab Database Image Import',
                'description' => 'Import and manage prefab images',
                'category' => 'content'
            ],
            'prefab_image_import' => [
                'title' => 'Prefab Image Import (Alt)',
                'description' => 'Alternative prefab image import interface',
                'category' => 'content'
            ],
            'valheim_weather' => [
                'title' => 'Valheim Weather System',
                'description' => 'Weather prediction and calendar system',
                'category' => 'utility'
            ],
            'jotunheim_kb' => [
                'title' => 'Knowledge Base',
                'description' => 'Knowledge base and documentation system',
                'category' => 'content'
            ],
            'jotunheim_kb_direct' => [
                'title' => 'Direct Knowledge Base',
                'description' => 'Direct access knowledge base interface',
                'category' => 'content'
            ],
            'popup_shop' => [
                'title' => 'Popup Shop',
                'description' => 'Popup shop interface for quick purchases',
                'category' => 'commerce'
            ],
            'legacy_shop_teller' => [
                'title' => 'Legacy Shop Teller',
                'description' => 'Legacy shop and teller interface',
                'category' => 'commerce'
            ],
            'playerlist_interface' => [
                'title' => 'Player List Interface',
                'description' => 'Manage registered players and user data',
                'category' => 'content'
            ],
            'jotun-playerlist' => [
                'title' => 'Jotun Player List',
                'description' => 'Jotun player list management',
                'category' => 'content'
            ]
        ];
        
        // Only add shortcodes that are actually registered
        foreach ($predefined_shortcodes as $shortcode => $definition) {
            if (shortcode_exists($shortcode)) {
                $pages[$shortcode] = [
                    'title' => $definition['title'],
                    'description' => $definition['description'],
                    'is_shortcode' => true,
                    'registered' => true
                ];
            }
        }
        
        error_log('Jotunheim Page Permissions: Detected ' . count($pages) . ' total pages for permissions');
        error_log('Jotunheim Page Permissions: Admin pages: ' . count($admin_pages));
        error_log('Jotunheim Page Permissions: Shortcode pages: ' . (count($pages) - count($admin_pages)));
        
        return $pages;
    }
    
    /**
     * Get current page permissions
     */
    private function get_page_permissions() {
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
     * AJAX handler for scanning new pages - comprehensive like dashboard config
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
        
        error_log('Jotunheim Page Permissions: Starting comprehensive scan...');
        
        // Get currently configured pages
        $current_permissions = $this->get_page_permissions();
        $configured_pages = array_keys($current_permissions);
        
        // Do comprehensive scan using dashboard config logic
        $all_pages = $this->comprehensive_page_scan();
        $all_page_keys = array_keys($all_pages);
        
        // Find new pages
        $new_pages = array_diff($all_page_keys, $configured_pages);
        
        if (empty($new_pages)) {
            wp_send_json_success([
                'new_count' => 0,
                'message' => 'No new pages found. All available pages are already configured.',
                'new_pages' => [],
                'total_scanned' => count($all_pages),
                'already_configured' => count($configured_pages)
            ]);
            return;
        }
        
        // Prepare new pages data with comprehensive info
        $new_pages_data = [];
        foreach ($new_pages as $page_key) {
            $new_pages_data[$page_key] = $all_pages[$page_key];
        }
        
        error_log('Jotunheim Page Permissions: Found ' . count($new_pages) . ' new pages out of ' . count($all_pages) . ' total');
        
        // Return pages for selection like Dashboard Config does - DON'T auto-add
        wp_send_json_success([
            'new_count' => count($new_pages),
            'message' => count($new_pages) . ' new page(s) found! Select which ones to add to permissions.',
            'new_pages' => $new_pages_data,
            'total_scanned' => count($all_pages),
            'already_configured' => count($configured_pages),
            'show_selection' => true
        ]);
    }
    
    /**
     * AJAX handler for adding selected pages to permissions
     */
    public function ajax_add_selected_pages() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized access');
            return;
        }
        
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'page_permissions_nonce')) {
            wp_send_json_error('Invalid security token');
            return;
        }
        
        $selected_pages = isset($_POST['selected_pages']) ? (array) $_POST['selected_pages'] : [];
        
        if (empty($selected_pages)) {
            wp_send_json_error('No pages selected');
            return;
        }
        
        // Get current permissions
        $current_permissions = $this->get_page_permissions();
        
        // Add selected pages with no roles (user will need to configure them)
        $added_count = 0;
        foreach ($selected_pages as $page_key) {
            if (!isset($current_permissions[$page_key])) {
                $current_permissions[$page_key] = []; // Empty = no roles have access yet
                $added_count++;
            }
        }
        
        // Save updated permissions
        update_option('jotunheim_page_permissions', $current_permissions);
        
        wp_send_json_success([
            'added_count' => $added_count,
            'message' => $added_count . ' page(s) added to permissions configuration! You can now set role access for them.',
            'refresh_needed' => true
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
        
        // Get user's Discord roles from stored metadata
        $user_discord_roles = self::get_user_discord_roles($user_id);
        
        // If user has no Discord roles, check if they have editor role as fallback
        if (empty($user_discord_roles)) {
            // Allow editors access to core Jotunheim pages as fallback
            if (user_can($user_id, 'edit_posts')) {
                $allowed_pages_for_editors = [
                    'jotunheim_magic',
                    'item_list_editor',
                    'eventzones_editor', 
                    'event_zone_editor',
                    'pos_interface',
                    'jotun-playerlist',
                    'jotunheim_barter_page',
                    'barter'
                ];
                return in_array($page_slug, $allowed_pages_for_editors);
            }
            return false; // No Discord roles and not editor = no access
        }
        
        // Get page permissions
        $page_permissions = get_option('jotunheim_page_permissions', []);
        
        if (!isset($page_permissions[$page_slug])) {
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
        
        // Check if user has any role that grants access to this page
        foreach ($user_discord_roles as $role_key) {
            if (isset($page_permissions[$page_slug][$role_key]) && $page_permissions[$page_slug][$role_key]) {
                error_log("Jotunheim Page Permissions: Granting access to page {$page_slug} for Discord role {$role_key}");
                return true;
            }
        }
        
        error_log("Jotunheim Page Permissions: Denying access to page {$page_slug} for user {$user_id} with roles: " . implode(', ', $user_discord_roles));
        return false;
    }
    
    /**
     * Get user's Discord roles from stored user meta
     */
    private static function get_user_discord_roles($user_id) {
        // Get stored Discord roles from user meta
        $discord_roles = get_user_meta($user_id, 'discord_roles', true);
        
        if (empty($discord_roles) || !is_array($discord_roles)) {
            return [];
        }
        
        // Get configured Discord roles to map IDs to role keys
        $configured_roles = get_option('jotunheim_discord_roles', []);
        $user_role_keys = [];
        
        // Map Discord role IDs to our role keys
        foreach ($configured_roles as $role_key => $role_data) {
            if (isset($role_data['id']) && in_array($role_data['id'], $discord_roles)) {
                $user_role_keys[] = $role_key;
            }
        }
        
        error_log("Jotunheim Page Permissions: User {$user_id} has Discord role IDs: " . implode(', ', $discord_roles));
        error_log("Jotunheim Page Permissions: Mapped to role keys: " . implode(', ', $user_role_keys));
        
        return $user_role_keys;
    }
}

// Helper function for easy permission checking throughout the plugin
function jotunheim_user_can_access_page($page_slug, $user_id = null) {
    return JotunheimPagePermissions::user_can_access_page($page_slug, $user_id);
}

/**
 * Universal shortcode permission check
 * Use this in all shortcodes to enforce Discord-based permissions
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
    if (!jotunheim_user_can_access_page($shortcode_name)) {
        return '<div class="jotunheim-error">You do not have permission to access this feature. Please contact an administrator if you believe this is an error.</div>';
    }
    
    return null; // Permission granted
}

// Function to render the page permissions config page
function render_page_permissions_config_page() {
    $page_permissions = new JotunheimPagePermissions();
    $page_permissions->render();
}

// Initialize the class
new JotunheimPagePermissions();