<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Dashboard Menu Configuration System
 * Allows users to reorganize menu items, create sections, and customize the admin dashboard
 */

class JotunheimDashboardConfig {
    
    private $default_menu_items = [];
    private $menu_config = [];
    
    public function __construct() {
        // Initialize immediately instead of waiting for admin_init
        $this->init();
        
        add_action('wp_ajax_save_dashboard_config', [$this, 'save_dashboard_config']);
        add_action('wp_ajax_reset_dashboard_config', [$this, 'reset_dashboard_config']);
        
        // TEMPORARY: Force config reset for debugging
        // delete_option('jotunheim_dashboard_config');
        // error_log('Jotunheim Dashboard: Forced config reset for debugging');
    }
    
    public function init() {
        error_log('Jotunheim Dashboard: Starting init()');
        $this->load_default_menu_items();
        
        // Check for reset parameter (for easy config regeneration)
        if (isset($_GET['reset_dashboard_config']) && $_GET['reset_dashboard_config'] === '1' && current_user_can('manage_options')) {
            delete_option('jotunheim_dashboard_config');
            error_log('Jotunheim Dashboard: Config reset via URL parameter');
        }
        
        // Get existing config or create default
        $stored_config = get_option('jotunheim_dashboard_config', false);
        
        if (!$stored_config) {
            // No config exists, create and save default
            error_log('Jotunheim Dashboard: No stored config, creating default');
            $this->menu_config = $this->get_default_config();
            update_option('jotunheim_dashboard_config', $this->menu_config);
            error_log('Jotunheim Dashboard: Created and saved default config');
        } else {
            $this->menu_config = $stored_config;
        }
        
        // Ensure config has required structure
        if (!isset($this->menu_config['sections']) || !isset($this->menu_config['items'])) {
            error_log('Jotunheim Dashboard: Invalid stored config, resetting to default');
            $this->menu_config = $this->get_default_config();
            update_option('jotunheim_dashboard_config', $this->menu_config);
        }
        
        error_log('Jotunheim Dashboard: Config ready with ' . count($this->menu_config['sections']) . ' sections and ' . count($this->menu_config['items']) . ' items');
    }
    
    private function load_default_menu_items() {
        $this->default_menu_items = [
            // Core Management
            [
                'id' => 'prefab_image_import',
                'title' => 'Prefab Image Import',
                'menu_title' => 'Prefab Image Import',
                'callback' => 'render_prefab_image_import_page',
                'category' => 'core',
                'description' => 'Import and manage prefab images'
            ],
            [
                'id' => 'item_list_editor',
                'title' => 'Item List Editor',
                'menu_title' => 'Item List Editor',
                'callback' => 'render_item_list_editor_page',
                'category' => 'items',
                'description' => 'Edit and manage game items'
            ],
            [
                'id' => 'item_list_add_new_item',
                'title' => 'Item List Add New Item',
                'menu_title' => 'Add New Item',
                'callback' => 'render_item_list_add_new_item_page',
                'category' => 'items',
                'description' => 'Add new items to the game'
            ],
            
            // Event Management
            [
                'id' => 'event_zone_editor',
                'title' => 'Event Zone Editor',
                'menu_title' => 'Event Zone Editor',
                'callback' => 'render_event_zone_editor_page',
                'category' => 'events',
                'description' => 'Edit and manage event zones'
            ],
            [
                'id' => 'add_event_zone',
                'title' => 'Add Event Zone',
                'menu_title' => 'Add Event Zone',
                'callback' => 'render_add_event_zone_page',
                'category' => 'events',
                'description' => 'Create new event zones'
            ],
            [
                'id' => 'eventzone_field_config',
                'title' => 'EventZone Field Config',
                'menu_title' => 'EventZone Field Config',
                'callback' => 'render_eventzone_field_config_page',
                'category' => 'events',
                'description' => 'Configure event zone fields'
            ],
            
            // Commerce & Trading
            [
                'id' => 'trade',
                'title' => 'Trade',
                'menu_title' => 'Trade',
                'callback' => 'render_trade_page',
                'category' => 'commerce',
                'description' => 'Manage trading systems'
            ],
            [
                'id' => 'barter',
                'title' => 'Barter',
                'menu_title' => 'Barter',
                'callback' => 'render_barter_page',
                'category' => 'commerce',
                'description' => 'Manage bartering systems'
            ],
            [
                'id' => 'pos_interface',
                'title' => 'Point of Sale',
                'menu_title' => 'Point of Sale',
                'callback' => 'render_pos_interface_page',
                'category' => 'commerce',
                'description' => 'Point of sale transaction system'
            ],
            [
                'id' => 'jotun-playerlist',
                'title' => 'Player List Management',
                'menu_title' => 'Player List',
                'callback' => 'jotun_playerlist_interface',
                'category' => 'commerce',
                'description' => 'Manage registered players and customer database'
            ],
            
            // System Configuration
            [
                'id' => 'universal_ui_table_config',
                'title' => 'Universal UI Table Config',
                'menu_title' => 'Universal UI Config',
                'callback' => 'render_universal_ui_table_config_page',
                'category' => 'system',
                'description' => 'Configure universal UI table settings'
            ],
            [
                'id' => 'weather_calendar_config',
                'title' => 'Weather Calendar Config',
                'menu_title' => 'Weather Calendar',
                'callback' => 'render_weather_calendar_config_page',
                'category' => 'system',
                'description' => 'Configure weather calendar settings'
            ],
            [
                'id' => 'dashboard_config',
                'title' => 'Dashboard Configuration',
                'menu_title' => 'Dashboard Config',
                'callback' => 'render_dashboard_config_page',
                'category' => 'system',
                'description' => 'Configure dashboard menu organization and layout'
            ]
        ];
    }
    
    private function get_default_config() {
        return [
            'sections' => [
                [
                    'id' => 'core',
                    'title' => 'Core Management',
                    'description' => 'Essential game management tools',
                    'icon' => 'dashicons-admin-settings',
                    'order' => 1,
                    'enabled' => true
                ],
                [
                    'id' => 'items',
                    'title' => 'Item Management',
                    'description' => 'Manage game items and inventory',
                    'icon' => 'dashicons-products',
                    'order' => 2,
                    'enabled' => true
                ],
                [
                    'id' => 'events',
                    'title' => 'Event Management',
                    'description' => 'Create and manage game events',
                    'icon' => 'dashicons-calendar-alt',
                    'order' => 3,
                    'enabled' => true
                ],
                [
                    'id' => 'commerce',
                    'title' => 'Commerce & Trading',
                    'description' => 'Player shops, trading, and transactions',
                    'icon' => 'dashicons-money-alt',
                    'order' => 4,
                    'enabled' => true
                ],
                [
                    'id' => 'system',
                    'title' => 'System Configuration',
                    'description' => 'Advanced system settings and configuration',
                    'icon' => 'dashicons-admin-tools',
                    'order' => 5,
                    'enabled' => true
                ]
            ],
            'items' => $this->get_default_item_assignments()
        ];
    }
    
    private function get_default_item_assignments() {
        error_log('Jotunheim Dashboard: Creating default item assignments from ' . count($this->default_menu_items) . ' menu items');
        $assignments = [];
        foreach ($this->default_menu_items as $index => $item) {
            $assignments[] = [
                'id' => $item['id'],
                'section' => $item['category'],
                'order' => $index + 1,
                'enabled' => true
            ];
        }
        error_log('Jotunheim Dashboard: Created ' . count($assignments) . ' item assignments');
        return $assignments;
    }
    
    public function get_menu_items() {
        return $this->default_menu_items;
    }
    
    public function get_config() {
        return $this->menu_config;
    }
    
    public function get_organized_menu() {
        $organized = [];
        $config = $this->get_config();
        
        // Get enabled sections sorted by order
        $sections = $config['sections'];
        usort($sections, function($a, $b) {
            return $a['order'] <=> $b['order'];
        });
        
        foreach ($sections as $section) {
            if (!$section['enabled']) continue;
            
            $organized[$section['id']] = [
                'title' => $section['title'],
                'description' => $section['description'],
                'icon' => $section['icon'],
                'items' => []
            ];
        }
        
        // Get items sorted by order within each section
        $items = $config['items'];
        usort($items, function($a, $b) {
            return $a['order'] <=> $b['order'];
        });
        
        foreach ($items as $item_config) {
            if (!$item_config['enabled']) continue;
            
            $item = $this->find_menu_item($item_config['id']);
            if ($item && isset($organized[$item_config['section']])) {
                $organized[$item_config['section']]['items'][] = $item;
            }
        }
        
        return $organized;
    }
    
    private function find_menu_item($id) {
        foreach ($this->default_menu_items as $item) {
            if ($item['id'] === $id) {
                return $item;
            }
        }
        return null;
    }
    
    public function save_dashboard_config() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        if (!wp_verify_nonce($_POST['nonce'], 'dashboard_config_nonce')) {
            wp_die('Invalid nonce');
        }
        
        // Handle organized menu toggle
        if (isset($_POST['use_organized_menu'])) {
            update_option('jotunheim_use_organized_menu', (bool)$_POST['use_organized_menu']);
            wp_send_json_success('Menu mode updated successfully');
            return;
        }
        
        // Handle full configuration save
        $config = [
            'sections' => json_decode(stripslashes($_POST['sections']), true),
            'items' => json_decode(stripslashes($_POST['items']), true)
        ];
        
        update_option('jotunheim_dashboard_config', $config);
        
        wp_send_json_success('Configuration saved successfully');
    }
    
    public function reset_dashboard_config() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        if (!wp_verify_nonce($_POST['nonce'], 'dashboard_config_nonce')) {
            wp_die('Invalid nonce');
        }
        
        delete_option('jotunheim_dashboard_config');
        $this->menu_config = $this->get_default_config();
        
        wp_send_json_success('Configuration reset to defaults');
    }
}

// Initialize the dashboard config system
global $jotunheim_dashboard_config;
$jotunheim_dashboard_config = new JotunheimDashboardConfig();

/**
 * Render the dashboard configuration page
 */
function render_dashboard_config_page() {
    global $jotunheim_dashboard_config;
    
    $menu_items = $jotunheim_dashboard_config->get_menu_items();
    $config = $jotunheim_dashboard_config->get_config();
    
    // Enqueue necessary scripts and styles
    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script('dashboard-config-js', plugin_dir_url(__FILE__) . '../../assets/js/dashboard-config.js', ['jquery', 'jquery-ui-sortable'], '1.0.0', true);
    wp_enqueue_style('dashboard-config-css', plugin_dir_url(__FILE__) . '../../assets/css/dashboard-config.css', [], '1.0.0');
    
    wp_localize_script('dashboard-config-js', 'dashboardConfig', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('dashboard_config_nonce'),
        'config' => $config,
        'menuItems' => $menu_items
    ]);
    ?>
    
    <div class="wrap">
        <div class="dashboard-config-wrap">
            <h1 class="dashboard-config-title">
                <span class="dashicons dashicons-admin-appearance"></span>
                Dashboard Configuration
            </h1>
            
            <div class="dashboard-config-description">
                <p>Customize your Jotunheim Magic dashboard by organizing menu items into sections, reordering them, and enabling/disabling features as needed.</p>
            </div>
            
            <!-- Toggle for Organized Menu Mode -->
            <div class="organized-menu-toggle">
                <label>
                    <input type="checkbox" id="use-organized-menu" <?php echo get_option('jotunheim_use_organized_menu', false) ? 'checked' : ''; ?>>
                    <strong>Enable Organized Menu Mode</strong> - Switch from flat menu to organized sections
                </label>
                <p class="description">When enabled, your menu will be organized into sections. When disabled, uses the traditional flat menu structure.</p>
            </div>
        
        <div class="dashboard-config-actions">
            <button type="button" class="button button-primary" id="save-config">
                <span class="dashicons dashicons-saved"></span>
                Save Configuration
            </button>
            <button type="button" class="button button-secondary" id="preview-config">
                <span class="dashicons dashicons-visibility"></span>
                Preview Changes
            </button>
            <button type="button" class="button button-secondary" id="reset-config">
                <span class="dashicons dashicons-undo"></span>
                Reset to Defaults
            </button>
            <button type="button" class="button button-secondary" id="add-section">
                <span class="dashicons dashicons-plus-alt"></span>
                Add Section
            </button>
        </div>
        
        <div class="dashboard-config-container">
            <!-- Sections Management -->
            <div class="config-sections">
                <h2>
                    <span class="dashicons dashicons-category"></span>
                    Menu Sections
                </h2>
                <p class="section-description">Organize your menu items into logical sections. Drag to reorder.</p>
                
                <div id="sections-container" class="sections-list sortable">
                    <!-- Sections will be populated by JavaScript -->
                </div>
            </div>
            
            <!-- Items Management -->
            <div class="config-items">
                <h2>
                    <span class="dashicons dashicons-menu-alt"></span>
                    Menu Items
                </h2>
                <p class="section-description">Assign menu items to sections and control their visibility. Drag to reorder within sections.</p>
                
                <div class="items-filter">
                    <label for="section-filter">Filter by section:</label>
                    <select id="section-filter">
                        <option value="">All Sections</option>
                    </select>
                    <label for="status-filter">Filter by status:</label>
                    <select id="status-filter">
                        <option value="">All Items</option>
                        <option value="enabled">Enabled Only</option>
                        <option value="disabled">Disabled Only</option>
                    </select>
                </div>
                
                <div id="items-container" class="items-list">
                    <!-- Items will be populated by JavaScript -->
                </div>
            </div>
        </div>
        
        <!-- Preview Panel -->
        <div id="preview-panel" class="preview-panel" style="display: none;">
            <div class="preview-header">
                <h3>
                    <span class="dashicons dashicons-visibility"></span>
                    Dashboard Preview
                </h3>
                <button type="button" class="button button-small" id="close-preview">
                    <span class="dashicons dashicons-no-alt"></span>
                    Close
                </button>
            </div>
            <div class="preview-content">
                <div id="preview-menu" class="preview-menu">
                    <!-- Preview will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </div>
    
    <!-- Section Edit Modal -->
    <div id="section-modal" class="dashboard-modal" style="display: none;">
        <div class="dashboard-modal-content">
            <div class="dashboard-modal-header">
                <h3 id="section-modal-title">Edit Section</h3>
                <button type="button" class="dashboard-modal-close" id="close-section-modal">
                    <span class="dashicons dashicons-no-alt"></span>
                </button>
            </div>
            <div class="dashboard-modal-body">
                <form id="section-form">
                    <input type="hidden" id="section-id" name="section_id">
                    
                    <div class="form-group">
                        <label for="section-title">Section Title</label>
                        <input type="text" id="section-title" name="section_title" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="section-description">Description</label>
                        <textarea id="section-description" name="section_description" class="form-control" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="section-icon">Icon (Dashicon class)</label>
                        <select id="section-icon" name="section_icon" class="form-control">
                            <option value="dashicons-admin-settings">Settings</option>
                            <option value="dashicons-products">Products</option>
                            <option value="dashicons-calendar-alt">Calendar</option>
                            <option value="dashicons-money-alt">Money</option>
                            <option value="dashicons-admin-tools">Tools</option>
                            <option value="dashicons-category">Category</option>
                            <option value="dashicons-admin-users">Users</option>
                            <option value="dashicons-chart-area">Charts</option>
                            <option value="dashicons-database">Database</option>
                            <option value="dashicons-hammer">Hammer</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <input type="checkbox" id="section-enabled" name="section_enabled">
                            Enable this section
                        </label>
                    </div>
                </form>
            </div>
            <div class="dashboard-modal-footer">
                <button type="button" class="button button-secondary" id="cancel-section">Cancel</button>
                <button type="button" class="button button-primary" id="save-section">Save Section</button>
            </div>
        </div>
    </div>
    
    <style>
        /* Fix positioning to prevent admin bar interference */
        #wpadminbar {
            position: relative !important;
        }
        
        .dashboard-config-wrap {
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            clear: both;
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
        
        /* Ensure all floating elements stay within content area */
        .dashboard-config-wrap * {
            position: relative;
        }
        
        /* Prevent any absolute positioning from escaping */
        .wrap {
            position: relative;
            overflow: visible;
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
        
        .dashboard-config-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #1d2327;
            margin-bottom: 10px;
            margin-top: 0;
        }
        
        .dashboard-config-description {
            background: #f0f6fc;
            border-left: 4px solid #0073aa;
            padding: 15px;
            margin-bottom: 30px;
            border-radius: 4px;
        }
        
        .dashboard-config-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .dashboard-config-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .config-sections,
        .config-items {
            background: white;
            border: 1px solid #c3c4c7;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .config-sections h2,
        .config-items h2 {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 0;
            margin-bottom: 10px;
            color: #1d2327;
        }
        
        .section-description {
            color: #646970;
            margin-bottom: 20px;
        }
        
        .sections-list,
        .items-list {
            min-height: 400px;
        }
        
        .section-item,
        .menu-item {
            background: #f6f7f7;
            border: 1px solid #c3c4c7;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 10px;
            cursor: move;
            transition: all 0.2s ease;
        }
        
        .section-item:hover,
        .menu-item:hover {
            background: #f0f0f1;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .section-item.ui-sortable-placeholder,
        .menu-item.ui-sortable-placeholder {
            background: #ddd;
            border: 2px dashed #999;
            height: 80px;
        }
        
        .section-header,
        .item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }
        
        .section-title,
        .item-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #1d2327;
        }
        
        .section-controls,
        .item-controls {
            display: flex;
            gap: 5px;
        }
        
        .control-btn {
            padding: 4px 8px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }
        
        .control-btn.edit {
            background: #0073aa;
            color: white;
        }
        
        .control-btn.toggle {
            background: #00a32a;
            color: white;
        }
        
        .control-btn.toggle.disabled {
            background: #d63638;
        }
        
        .control-btn.delete {
            background: #d63638;
            color: white;
        }
        
        .item-description {
            color: #646970;
            font-size: 13px;
            margin-bottom: 8px;
        }
        
        .item-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #646970;
        }
        
        .item-section {
            background: #0073aa;
            color: white;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 11px;
        }
        
        .item-status {
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 500;
        }
        
        .item-status.enabled {
            background: #00a32a;
            color: white;
        }
        
        .item-status.disabled {
            background: #d63638;
            color: white;
        }
        
        .items-filter {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px;
            background: #f6f7f7;
            border-radius: 4px;
            position: relative;
            z-index: 10;
        }
        
        .items-filter select {
            position: relative;
            z-index: 15;
        }
        
        .organized-menu-toggle {
            background: #e7f3ff;
            border: 1px solid #0073aa;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .organized-menu-toggle label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .organized-menu-toggle .description {
            margin: 0;
            color: #646970;
            font-size: 13px;
        }
        
        .items-filter label {
            font-weight: 500;
            color: #1d2327;
        }
        
        .items-filter select {
            padding: 5px 8px;
            border: 1px solid #8c8f94;
            border-radius: 3px;
            position: relative;
            z-index: 15;
        }
        
        /* Fix dropdown positioning */
        .config-items {
            position: relative;
            z-index: 5;
        }
        
        .items-list {
            position: relative;
            z-index: 1;
        }
        
        .preview-panel {
            background: white;
            border: 1px solid #c3c4c7;
            border-radius: 8px;
            margin-top: 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .preview-header {
            padding: 15px 20px;
            border-bottom: 1px solid #c3c4c7;
            background: #f6f7f7;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .preview-header h3 {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            color: #1d2327;
        }
        
        .preview-content {
            padding: 20px;
        }
        
        .preview-menu {
            max-height: 400px;
            overflow-y: auto;
        }
        
        .preview-section {
            margin-bottom: 25px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            overflow: hidden;
        }
        
        .preview-section-header {
            background: #f6f7f7;
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #1d2327;
        }
        
        .preview-section-items {
            padding: 10px;
        }
        
        .preview-item {
            padding: 8px 12px;
            margin-bottom: 5px;
            background: #f9f9f9;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .preview-item:last-child {
            margin-bottom: 0;
        }
        
        .preview-item-title {
            font-weight: 500;
            color: #1d2327;
        }
        
        .preview-item-description {
            font-size: 12px;
            color: #646970;
        }
        
        /* Modal Styles */
        .dashboard-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .dashboard-modal-content {
            background: white;
            border-radius: 8px;
            min-width: 500px;
            max-width: 90vw;
            max-height: 90vh;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        
        .dashboard-modal-header {
            padding: 20px;
            border-bottom: 1px solid #c3c4c7;
            background: #f6f7f7;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .dashboard-modal-header h3 {
            margin: 0;
            color: #1d2327;
        }
        
        .dashboard-modal-close {
            background: none;
            border: none;
            color: #646970;
            cursor: pointer;
            padding: 5px;
            border-radius: 3px;
            font-size: 16px;
        }
        
        .dashboard-modal-close:hover {
            background: #f0f0f1;
        }
        
        .dashboard-modal-body {
            padding: 20px;
            max-height: 60vh;
            overflow-y: auto;
        }
        
        .dashboard-modal-footer {
            padding: 20px;
            border-top: 1px solid #c3c4c7;
            background: #f6f7f7;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #1d2327;
        }
        
        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #8c8f94;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .form-control:focus {
            border-color: #0073aa;
            box-shadow: 0 0 0 1px #0073aa;
            outline: none;
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .dashboard-config-container {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .dashboard-config-wrap {
                padding: 10px;
            }
            
            .dashboard-config-actions {
                flex-direction: column;
            }
            
            .items-filter {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }
            
            .dashboard-modal-content {
                min-width: 0;
                width: 95vw;
            }
        }
    </style>

    </div> <!-- Close .wrap -->
    
    <script>
    jQuery(document).ready(function($) {
        // Handle organized menu toggle
        $('#use-organized-menu').on('change', function() {
            var isEnabled = $(this).is(':checked');
            
            // Save the setting via AJAX
            $.post(ajaxurl, {
                action: 'save_dashboard_config',
                nonce: '<?php echo wp_create_nonce('dashboard_config_nonce'); ?>',
                use_organized_menu: isEnabled ? 1 : 0
            }, function(response) {
                if (response.success) {
                    // Show success message
                    $('.dashboard-config-description').after(
                        '<div class="notice notice-success is-dismissible"><p>' +
                        (isEnabled ? 'Organized menu mode enabled! Your menu will now use sections.' : 'Legacy menu mode enabled! Your menu will use the traditional flat structure.') +
                        '</p></div>'
                    );
                    
                    // Auto-remove notice after 3 seconds
                    setTimeout(function() {
                        $('.notice').fadeOut();
                    }, 3000);
                } else {
                    alert('Error saving setting: ' + (response.data || 'Unknown error'));
                }
            });
        });
    });
    </script>
    
    <?php
}