<?php

class Jotunheim_Dashboard_REST_API {
    private $normalized_db;
    private $namespace = 'jotunheim/v1';

    public function __construct() {
        $this->normalized_db = new Jotunheim_Dashboard_DB_Normalized();
        add_action('rest_api_init', [$this, 'register_routes']);
        
        // Ensure the dashboard config class is available
        if (!class_exists('JotunheimDashboardConfig')) {
            require_once(plugin_dir_path(__FILE__) . 'dashboard-config.php');
        }
    }

    public function register_routes() {
        // Get dashboard configuration
        register_rest_route($this->namespace, '/dashboard/config', [
            'methods' => 'GET',
            'callback' => [$this, 'get_dashboard_config'],
            'permission_callback' => [$this, 'check_permissions']
        ]);

        // Update full dashboard configuration
        register_rest_route($this->namespace, '/dashboard/config', [
            'methods' => 'POST',
            'callback' => [$this, 'update_dashboard_config'],
            'permission_callback' => [$this, 'check_permissions']
        ]);

        // Update single quick action
        register_rest_route($this->namespace, '/dashboard/quick-action', [
            'methods' => 'POST',
            'callback' => [$this, 'update_quick_action'],
            'permission_callback' => [$this, 'check_permissions']
        ]);

        // Get menu items
        register_rest_route($this->namespace, '/dashboard/menu-items', [
            'methods' => 'GET',
            'callback' => [$this, 'get_menu_items'],
            'permission_callback' => [$this, 'check_permissions']
        ]);

        // Debug endpoint
        register_rest_route($this->namespace, '/dashboard/debug', [
            'methods' => 'GET',
            'callback' => [$this, 'debug_info'],
            'permission_callback' => [$this, 'check_permissions']
        ]);
    }

    public function check_permissions() {
        return current_user_can('manage_options');
    }

    public function get_dashboard_config(WP_REST_Request $request) {
        try {
            $config = $this->normalized_db->get_full_configuration();
            
            return new WP_REST_Response([
                'success' => true,
                'data' => $config,
                'timestamp' => current_time('mysql')
            ], 200);
            
        } catch (Exception $e) {
            error_log("Dashboard REST API - Get Config Error: " . $e->getMessage());
            
            return new WP_REST_Response([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update_dashboard_config(WP_REST_Request $request) {
        try {
            $config_data = $request->get_json_params();
            
            if (empty($config_data)) {
                return new WP_REST_Response([
                    'success' => false,
                    'error' => 'No configuration data provided'
                ], 400);
            }

            $result = $this->normalized_db->save_full_configuration($config_data);
            
            return new WP_REST_Response([
                'success' => true,
                'data' => $result,
                'timestamp' => current_time('mysql')
            ], 200);
            
        } catch (Exception $e) {
            error_log("Dashboard REST API - Update Config Error: " . $e->getMessage());
            
            return new WP_REST_Response([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update_quick_action(WP_REST_Request $request) {
        try {
            $params = $request->get_json_params();
            $item_id = $params['item_id'] ?? '';
            $quick_action = $params['quick_action'] ?? false;
            
            if (empty($item_id)) {
                return new WP_REST_Response([
                    'success' => false,
                    'error' => 'item_id is required'
                ], 400);
            }

            $result = $this->normalized_db->update_item_quick_action($item_id, $quick_action);
            
            return new WP_REST_Response([
                'success' => true,
                'data' => [
                    'item_id' => $item_id,
                    'quick_action' => $quick_action,
                    'updated' => $result
                ],
                'timestamp' => current_time('mysql')
            ], 200);
            
        } catch (Exception $e) {
            error_log("Dashboard REST API - Update Quick Action Error: " . $e->getMessage());
            
            return new WP_REST_Response([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function get_menu_items(WP_REST_Request $request) {
        try {
            // Load the dashboard config to get merged menu items
            $dashboard_config = new JotunheimDashboardConfig();
            $menu_items = $dashboard_config->get_menu_items();
            
            return new WP_REST_Response([
                'success' => true,
                'data' => $menu_items,
                'timestamp' => current_time('mysql')
            ], 200);
            
        } catch (Exception $e) {
            error_log("Dashboard REST API - Get Menu Items Error: " . $e->getMessage());
            
            return new WP_REST_Response([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function debug_info(WP_REST_Request $request) {
        try {
            global $wpdb;
            
            $debug_data = [
                'database_tables' => [
                    'sections' => $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}jotun_dashboard_sections"),
                    'items' => $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}jotun_dashboard_items")
                ],
                'sample_items' => $wpdb->get_results("SELECT * FROM {$wpdb->prefix}jotun_dashboard_items LIMIT 5"),
                'wordpress_info' => [
                    'version' => get_bloginfo('version'),
                    'rest_url' => rest_url(),
                    'current_user' => wp_get_current_user()->user_login
                ]
            ];
            
            return new WP_REST_Response([
                'success' => true,
                'data' => $debug_data,
                'timestamp' => current_time('mysql')
            ], 200);
            
        } catch (Exception $e) {
            return new WP_REST_Response([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

// Initialize the REST API
new Jotunheim_Dashboard_REST_API();