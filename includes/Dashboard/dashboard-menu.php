<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Function to add the main menu item and submenu items
function jotunheim_magic_plugin_menu() {
    // Main Menu Page for Jotunheim Magic Plugin
    add_menu_page(
        'Jotunheim Magic',              // Page title
        'Jotunheim Magic',              // Menu title in admin sidebar
        'manage_options',               // Capability required (restricted to admins by default)
        'jotunheim_magic',              // Menu slug
        'jotunheim_magic_dashboard',    // Callback function for main page
        'dashicons-hammer',             // Icon URL or Dashicon
        6                               // Position in the menu order
    );

    // Define submenu items and their callback functions
    $submenus = [
        [
            'title'       => 'Prefab Image Import',
            'menu_title'  => 'Prefab Image Import',
            'slug'        => 'prefab_image_import',
            'callback'    => 'render_prefab_image_import_page',
        ],
        [
            'title'       => 'Item List Editor',
            'menu_title'  => 'Item List Editor',
            'slug'        => 'item_list_editor',
            'callback'    => 'render_item_list_editor_page',
        ],
        [
            'title'       => 'Item List Add New Item',
            'menu_title'  => 'Item List Add New Item',
            'slug'        => 'item_list_add_new_item',
            'callback'    => 'render_item_list_add_new_item_page',
        ],
        [
            'title'       => 'Event Zone Editor',
            'menu_title'  => 'Event Zone Editor',
            'slug'        => 'event_zone_editor',
            'callback'    => 'render_event_zone_editor_page',
        ],
        [
            'title'       => 'Add Event Zone',
            'menu_title'  => 'Add Event Zone',
            'slug'        => 'add_event_zone',
            'callback'    => 'render_add_event_zone_page',
        ],
        [
            'title'       => 'Trade',
            'menu_title'  => 'Trade',
            'slug'        => 'trade',
            'callback'    => 'render_trade_page',
        ],
        [
            'title'       => 'Barter',
            'menu_title'  => 'Barter',
            'slug'        => 'barter',
            'callback'    => 'render_barter_page',
        ],
        [
            'title'       => 'Universal UI Table Config',
            'menu_title'  => 'Universal UI Table Config',
            'slug'        => 'universal_ui_table_config',
            'callback'    => 'render_universal_ui_table_config_page',
        ],
        [
            'title'       => 'Point of Sale',
            'menu_title'  => 'Point of Sale',
            'slug'        => 'pos_interface',
            'callback'    => 'render_pos_interface_page',
        ],
        [
            'title'       => 'Player List Management',
            'menu_title'  => 'Player List',
            'slug'        => 'jotun-playerlist',
            'callback'    => 'jotun_playerlist_interface',
        ],
        [
            'title'       => 'Weather Calendar Config',
            'menu_title'  => 'Weather Calendar Config',
            'slug'        => 'weather_calendar_config',
            'callback'    => 'render_weather_calendar_config_page',
        ],
        [
            'title'       => 'EventZone Field Config',
            'menu_title'  => 'EventZone Field Config',
            'slug'        => 'eventzone_field_config',
            'callback'    => 'render_eventzone_field_config_page',
        ],
        [
            'title'       => 'Dashboard Configuration',
            'menu_title'  => 'Dashboard Config',
            'slug'        => 'dashboard_config',
            'callback'    => 'render_dashboard_config_page',
        ],
    ];

    // Check if we should use organized menu structure
    global $jotunheim_dashboard_config;
    $use_organized_menu = get_option('jotunheim_use_organized_menu', false);
    
    // Debug logging
    error_log('Jotunheim Dashboard: use_organized_menu = ' . ($use_organized_menu ? 'true' : 'false'));
    error_log('Jotunheim Dashboard: jotunheim_dashboard_config exists = ' . (isset($jotunheim_dashboard_config) ? 'true' : 'false'));
    
    // IMPORTANT: Ensure main menu always goes to dashboard overview
    // We need to ensure this happens BEFORE any other submenu registration
    global $submenu;
    
    // DO NOT remove the main menu item - WordPress needs it for routing
    // The first submenu item [0] is what makes the main menu clickable
    // Removing it breaks the main menu navigation
    
    // Safety check: only use organized menu if we have valid config
    if ($use_organized_menu && isset($jotunheim_dashboard_config)) {
        $organized_success = register_organized_menu($jotunheim_dashboard_config);
        
        // If organized menu failed, fall back to legacy mode
        if (!$organized_success) {
            error_log('Jotunheim Dashboard: Organized menu failed, falling back to legacy mode');
            $use_organized_menu = false;
        } else {
            error_log('Jotunheim Dashboard: Organized menu registered successfully');
        }
    }
    
    // Use legacy mode if organized mode is disabled or failed
    if (!$use_organized_menu) {
        error_log('Jotunheim Dashboard: Using legacy menu mode');
        
        // Add Overview submenu first (this will replace the auto-generated first submenu)
        add_submenu_page(
            'jotunheim_magic',          // Parent slug
            'Overview',                 // Page title
            'Overview',                 // Menu title
            'manage_options',           // Capability required
            'jotunheim_magic',          // Same slug as parent to make it the default
            'jotunheim_magic_dashboard' // Callback function
        );
        
        // Register each submenu (legacy mode)
        foreach ($submenus as $submenu) {
            add_submenu_page(
                'jotunheim_magic',          // Parent slug
                $submenu['title'],          // Page title
                $submenu['menu_title'],     // Menu title
                'manage_options',           // Capability required (restricted to admins by default)
                $submenu['slug'],           // Submenu slug
                $submenu['callback']        // Callback function
            );
        }
    }

    // IMPORTANT: Do NOT add a submenu with the same slug as the parent menu
    // WordPress will automatically create the first submenu item that points to the main menu callback
    // Adding a submenu with the same slug will override the main menu behavior
}

/**
 * Register organized menu structure based on dashboard configuration
 */
function register_organized_menu($config) {
    // Safety checks
    if (!$config || !is_object($config)) {
        error_log('Jotunheim Dashboard: Invalid config object for organized menu - ' . gettype($config));
        return false;
    }
    
    // Get the config data
    if (!method_exists($config, 'get_config') || !method_exists($config, 'get_menu_items')) {
        error_log('Jotunheim Dashboard: Config object missing required methods');
        return false;
    }
    
    // DO NOT interfere with the main menu page - let it stay as dashboard overview
    // The main menu page callback is already set to 'jotunheim_magic_dashboard'
    
    // REMOVED: Dashboard Overview submenu item - it was interfering with main menu routing
    // WordPress automatically handles the main menu page, no need for duplicate submenu item
    // The main menu already points to 'jotunheim_magic_dashboard' callback
    
    $menu_config = $config->get_config();
    $menu_items = $config->get_menu_items();
    
    error_log('Jotunheim Dashboard: menu_config structure - ' . print_r($menu_config, true));
    
    if (!isset($menu_config['sections']) || !isset($menu_config['items'])) {
        error_log('Jotunheim Dashboard: Invalid menu config structure - missing sections or items');
        return false;
    }
    
    error_log('Jotunheim Dashboard: Found ' . count($menu_config['sections']) . ' sections and ' . count($menu_config['items']) . ' item assignments');
    
    // Create a map of items by section
    $items_by_section = [];
    foreach ($menu_config['items'] as $item_assignment) {
        if (!$item_assignment['enabled']) continue;
        
        $section_id = $item_assignment['section'];
        if (!isset($items_by_section[$section_id])) {
            $items_by_section[$section_id] = [];
        }
        
        // Find the actual menu item
        foreach ($menu_items as $menu_item) {
            if ($menu_item['id'] === $item_assignment['id']) {
                $items_by_section[$section_id][] = [
                    'slug' => $menu_item['id'],
                    'title' => $menu_item['title'],
                    'menu_title' => $menu_item['menu_title'],
                    'callback' => $menu_item['callback'],
                    'order' => $item_assignment['order']
                ];
                break;
            }
        }
    }
    
    error_log('Jotunheim Dashboard: Items by section - ' . print_r($items_by_section, true));
    
    // Sort sections by order
    $sections = $menu_config['sections'];
    usort($sections, function($a, $b) {
        return $a['order'] <=> $b['order'];
    });

    // Add Overview submenu first (this will replace the auto-generated first submenu)
    add_submenu_page(
        'jotunheim_magic',          // Parent slug
        'Overview',                 // Page title
        'Overview',                 // Menu title
        'manage_options',           // Capability required
        'jotunheim_magic',          // Same slug as parent to make it the default
        'jotunheim_magic_dashboard' // Callback function
    );

    // Register menu items by section
    foreach ($sections as $section) {
        if (!$section['enabled']) continue;
        
        $section_id = $section['id'];
        error_log('Jotunheim Dashboard: Processing section - ' . $section['title']);
        
        // Add section separator
        add_submenu_page(
            'jotunheim_magic',
            $section['title'],
            '<strong>' . $section['title'] . '</strong>',
            'manage_options',
            'section_' . $section_id,
            function() use ($section) { 
                echo '<div class="wrap"><h1>' . esc_html($section['title']) . '</h1>';
                echo '<p>' . esc_html($section['description']) . '</p>';
                echo '<p><em>This is a section header. Please select a specific tool from the menu.</em></p></div>';
            }
        );
        
        // Add items in this section
        if (isset($items_by_section[$section_id])) {
            // Sort items by order
            $items = $items_by_section[$section_id];
            usort($items, function($a, $b) {
                return $a['order'] <=> $b['order'];
            });
            
            foreach ($items as $item) {
                // Debug: Log all item details for analysis
                error_log('Jotunheim Dashboard: Processing item details - ' . print_r($item, true));
                
                // Validate item has required keys
                if (!isset($item['id']) || empty($item['id'])) {
                    error_log('Jotunheim Dashboard: SKIPPING item with missing or empty ID - ' . print_r($item, true));
                    continue;
                }
                
                // Skip any item that might conflict with the main dashboard overview
                if ($item['id'] === 'dashboard_overview' || 
                    (isset($item['callback']) && $item['callback'] === 'jotunheim_magic_dashboard') ||
                    (isset($item['title']) && $item['title'] === 'Dashboard Overview') ||
                    (isset($item['menu_title']) && $item['menu_title'] === 'Dashboard Overview') ||
                    (isset($item['slug']) && $item['slug'] === 'jotunheim_magic') ||
                    (isset($item['title']) && strpos($item['title'], 'Dashboard Overview') !== false) ||
                    (isset($item['menu_title']) && strpos($item['menu_title'], 'Dashboard Overview') !== false)) {
                    error_log('Jotunheim Dashboard: SKIPPING conflicting dashboard item - ' . (isset($item['title']) ? $item['title'] : 'Unknown') . ' (ID: ' . $item['id'] . ', Callback: ' . (isset($item['callback']) ? $item['callback'] : 'Unknown') . ')');
                    continue;
                }
                
                error_log('Jotunheim Dashboard: Adding item - ' . $item['title'] . ' with callback ' . $item['callback']);
                if (function_exists($item['callback'])) {
                    add_submenu_page(
                        'jotunheim_magic',
                        $item['title'],
                        $item['menu_title'],
                        'manage_options',
                        $item['slug'],
                        $item['callback']
                    );
                } else {
                    error_log('Jotunheim Dashboard: Function does not exist - ' . $item['callback']);
                }
            }
        } else {
            error_log('Jotunheim Dashboard: No items found for section - ' . $section_id);
        }
    }
    
    error_log('Jotunheim Dashboard: Organized menu registration completed');
    return true;
}

// Main dashboard page for Jotunheim Magic Plugin
function jotunheim_magic_dashboard() {
    error_log('Jotunheim Dashboard: jotunheim_magic_dashboard() function called');
    global $jotunheim_dashboard_config;
    
    // Get organized menu structure if available
    $organized_menu = [];
    if ($jotunheim_dashboard_config) {
        $organized_menu = $jotunheim_dashboard_config->get_organized_menu();
    }
    
    // Fallback sections if no organized menu
    if (empty($organized_menu)) {
        $organized_menu = [
            'core' => [
                'title' => 'Core Management',
                'description' => 'Essential game management tools',
                'icon' => 'dashicons-admin-settings',
                'items' => [
                    ['id' => 'prefab_image_import', 'title' => 'Prefab Image Import', 'description' => 'Import and manage prefab images']
                ]
            ],
            'items' => [
                'title' => 'Item Management', 
                'description' => 'Manage game items and inventory',
                'icon' => 'dashicons-products',
                'items' => [
                    ['id' => 'item_list_editor', 'title' => 'Item List Editor', 'description' => 'Edit and manage game items'],
                    ['id' => 'item_list_add_new_item', 'title' => 'Add New Item', 'description' => 'Add new items to the game']
                ]
            ],
            'events' => [
                'title' => 'Event Management',
                'description' => 'Create and manage game events', 
                'icon' => 'dashicons-calendar-alt',
                'items' => [
                    ['id' => 'event_zone_editor', 'title' => 'Event Zone Editor', 'description' => 'Edit and manage event zones'],
                    ['id' => 'add_event_zone', 'title' => 'Add Event Zone', 'description' => 'Create new event zones']
                ]
            ],
            'commerce' => [
                'title' => 'Commerce & Trading',
                'description' => 'Player shops, trading, and transactions',
                'icon' => 'dashicons-money-alt', 
                'items' => [
                    ['id' => 'pos_interface', 'title' => 'Point of Sale', 'description' => 'Point of sale transaction system'],
                    ['id' => 'jotun-playerlist', 'title' => 'Player List', 'description' => 'Manage registered players']
                ]
            ],
            'system' => [
                'title' => 'System Configuration',
                'description' => 'Advanced system settings and configuration',
                'icon' => 'dashicons-admin-tools',
                'items' => [
                    ['id' => 'weather_calendar_config', 'title' => 'Weather Calendar', 'description' => 'Configure weather calendar settings'],
                    ['id' => 'dashboard_config', 'title' => 'Dashboard Config', 'description' => 'Configure dashboard menu organization']
                ]
            ]
        ];
    }
    ?>
    
    <div class="wrap jotunheim-dashboard-main">
        <h1 class="jotunheim-main-title">
            <span class="dashicons dashicons-hammer"></span>
            Jotunheim Magic Dashboard
        </h1>
        
        <div class="jotunheim-welcome">
            <p class="jotunheim-intro">Welcome to Jotunheim Magic! This comprehensive plugin provides tools for managing your Valheim server including items, events, trading systems, and much more.</p>
        </div>
        
        <div class="jotunheim-quick-actions">
            <h3>Quick Actions</h3>
            <div class="quick-actions-grid">
                <?php
                // Get quick action items dynamically
                if ($jotunheim_dashboard_config) {
                    $menu_items = $jotunheim_dashboard_config->get_menu_items();
                    foreach ($menu_items as $item) {
                        if (isset($item['quick_action']) && $item['quick_action']) {
                            $icon = 'dashicons-admin-generic'; // Default icon
                            switch($item['id']) {
                                case 'item_list_editor':
                                    $icon = 'dashicons-products';
                                    break;
                                case 'pos_interface':
                                    $icon = 'dashicons-money-alt';
                                    break;
                                case 'event_zone_editor':
                                    $icon = 'dashicons-calendar-alt';
                                    break;
                            }
                            echo '<a href="' . esc_url(admin_url('admin.php?page=' . $item['id'])) . '" class="quick-action">';
                            echo '<span class="dashicons ' . $icon . '"></span>';
                            echo '<span>' . esc_html($item['menu_title']) . '</span>';
                            echo '</a>';
                        }
                    }
                }
                
                // Always include Dashboard Config as a quick action
                ?>
                <a href="<?php echo esc_url(admin_url('admin.php?page=dashboard_config')); ?>" class="quick-action">
                    <span class="dashicons dashicons-admin-appearance"></span>
                    <span>Configure Dashboard</span>
                </a>
            </div>
        </div>
        
        <div class="jotunheim-sections-grid">
            <?php foreach ($organized_menu as $section_id => $section): ?>
                <div class="jotunheim-section-card">
                    <div class="section-header">
                        <h2>
                            <span class="dashicons <?php echo esc_attr($section['icon'] ?? 'dashicons-admin-generic'); ?>"></span>
                            <?php echo esc_html($section['title']); ?>
                        </h2>
                        <p class="section-description"><?php echo esc_html($section['description']); ?></p>
                    </div>
                    
                    <div class="section-items">
                        <?php if (!empty($section['items'])): ?>
                            <?php foreach ($section['items'] as $item): ?>
                                <div class="dashboard-item">
                                    <a href="<?php echo esc_url(admin_url('admin.php?page=' . $item['id'])); ?>" class="item-link">
                                        <div class="item-content">
                                            <h4><?php echo esc_html($item['title'] ?? $item['menu_title']); ?></h4>
                                            <p><?php echo esc_html($item['description'] ?? ''); ?></p>
                                        </div>
                                        <span class="item-arrow">&rarr;</span>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="no-items">No items configured for this section.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <style>
    .jotunheim-dashboard-main {
        margin-top: 0 !important;
        padding-top: 0 !important;
        max-width: 1200px;
    }
    
    .jotunheim-main-title {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #1d2327;
        margin-bottom: 30px;
        font-size: 28px;
        margin-top: 0 !important;
        padding-top: 0 !important;
    }
    
    .jotunheim-welcome {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px;
        border-radius: 12px;
        margin-bottom: 40px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    
    .jotunheim-intro {
        font-size: 18px;
        line-height: 1.6;
        margin: 0;
        opacity: 0.95;
    }
    
    .jotunheim-sections-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
    }
    
    .jotunheim-section-card {
        background: white;
        border: 1px solid #c3c4c7;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        min-height: 200px;
    }
    
    .jotunheim-section-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }
    
    .section-header h2 {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #1d2327;
        margin-top: 0;
        margin-bottom: 12px;
        font-size: 20px;
        font-weight: 600;
    }
    
    .section-description {
        color: #646970;
        margin-bottom: 25px;
        font-style: italic;
        font-size: 14px;
        line-height: 1.5;
    }
    
    .section-items {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .dashboard-item {
        border: 1px solid #dcdcde;
        border-radius: 8px;
        transition: all 0.2s ease;
        background: #f9f9f9;
    }
    
    .dashboard-item:hover {
        border-color: #0073aa;
        box-shadow: 0 2px 8px rgba(0,115,170,0.1);
        background: white;
    }
    
    .item-link {
        display: flex;
        align-items: flex-start;
        padding: 18px;
        text-decoration: none;
        color: inherit;
        position: relative;
        gap: 15px;
    }
    
    .item-link:hover {
        color: inherit;
    }
    
    .item-content {
        flex: 1;
    }
    
    .item-link h4 {
        margin: 0 0 8px 0;
        color: #0073aa;
        font-size: 15px;
        font-weight: 600;
        line-height: 1.3;
    }
    
    .item-link p {
        margin: 0;
        color: #646970;
        font-size: 13px;
        line-height: 1.4;
    }
    
    .item-arrow {
        color: #0073aa;
        font-weight: bold;
        font-size: 18px;
        opacity: 0.7;
        transition: all 0.2s ease;
        margin-top: 2px;
    }
    
    .dashboard-item:hover .item-arrow {
        opacity: 1;
        transform: translateX(3px);
    }
    
    .no-items {
        color: #646970;
        font-style: italic;
        text-align: center;
        padding: 30px 20px;
        background: #f9f9f9;
        border-radius: 8px;
    }
    
    .jotunheim-quick-actions {
        background: #f6f7f7;
        padding: 30px;
        border-radius: 12px;
        border: 1px solid #dcdcde;
        margin-top: 20px;
        margin-bottom: 30px; /* Add spacing after quick actions */
    }
    
    .jotunheim-quick-actions h3 {
        margin-top: 0;
        margin-bottom: 25px;
        color: #1d2327;
        font-size: 20px;
    }
    
    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }
    
    .quick-action {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 18px 20px;
        background: white;
        border: 1px solid #c3c4c7;
        border-radius: 8px;
        text-decoration: none;
        color: #1d2327;
        transition: all 0.2s ease;
        font-weight: 500;
    }
    
    .quick-action:hover {
        background: #0073aa;
        color: white;
        border-color: #0073aa;
        text-decoration: none;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,115,170,0.25);
    }
    
    .quick-action .dashicons {
        font-size: 20px;
    }
    
    @media (max-width: 1024px) {
        .jotunheim-sections-grid {
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 25px;
        }
    }
    
    @media (max-width: 768px) {
        .jotunheim-sections-grid {
            grid-template-columns: 1fr;
        }
        
        .quick-actions-grid {
            grid-template-columns: 1fr;
        }
        
        .jotunheim-section-card {
            padding: 25px;
        }
        
        .jotunheim-welcome {
            padding: 30px;
        }
    }
    </style>
    <?php
}

// Universal UI Table Config Page
function render_universal_ui_table_config_page() {
    global $wpdb;

    // Fetch all jotun_ tables
    $tables = $wpdb->get_col("SHOW TABLES LIKE 'jotun_%'");

    // Retrieve saved options
    $enabled_tables = get_option('jotunheim_enabled_universal_ui_tables', []);

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['jotun_universal_ui_config_nonce'])) {
        if (wp_verify_nonce($_POST['jotun_universal_ui_config_nonce'], 'save_universal_ui_config')) {
            $enabled_tables = isset($_POST['enabled_tables']) ? array_map('sanitize_text_field', $_POST['enabled_tables']) : [];
            update_option('jotunheim_enabled_universal_ui_tables', $enabled_tables);
            echo '<div class="updated notice"><p>Configuration updated successfully.</p></div>';
        }
    }
    ?>

    <div class="wrap">
        <h1>Universal UI Table Configuration</h1>
        <p>Select which tables should appear in the Universal UI dropdown menu.</p>
        <form method="POST" action="">
            <?php wp_nonce_field('save_universal_ui_config', 'jotun_universal_ui_config_nonce'); ?>
            <table class="widefat fixed" style="max-width: 600px;">
                <thead>
                    <tr>
                        <th>Table Name</th>
                        <th>Include in Universal UI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tables as $table): ?>
                        <tr>
                            <td><?php echo esc_html($table); ?></td>
                            <td>
                                <input type="checkbox" name="enabled_tables[]" value="<?php echo esc_attr($table); ?>"
                                    <?php echo in_array($table, $enabled_tables) ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p>
                <input type="submit" class="button-primary" value="Save Configuration">
            </p>
        </form>
    </div>
    <?php
}

// Helper function to fetch enabled tables
function jotunheim_get_enabled_universal_ui_tables() {
    return get_option('jotunheim_enabled_universal_ui_tables', []);
}

// Prefab Icon Image Import Page
function render_prefab_image_import_page() {
    echo '<h1>Prefab Image Import</h1>';
    echo '<p>Use this tool to import prefab images for the plugin.</p>';
    echo do_shortcode('[prefabdb_image_import]');
}

// ItemList Editor Page
function render_item_list_editor_page() {
    echo '<h1>Item List Editor</h1>';
    echo do_shortcode('[itemlist_editor]');
}

// ItemList Add New Item Page
function render_item_list_add_new_item_page() {
    echo '<h1>Item List Editor</h1>';
    echo do_shortcode('[jotunheim_add_new_item]');
}

// EventZone Editor Page
function render_event_zone_editor_page() {
    echo '<h1>Event Zone Editor</h1>';
    echo do_shortcode('[eventzones_editor]');
}

// Add Event Zone Page
function render_add_event_zone_page() {
    echo '<h1>Add Event Zone</h1>';
    echo do_shortcode('[jotunheim_add_new_zone]');
}

// Trade Page
function render_trade_page() {
    echo '<h1>Trade</h1>';
    echo do_shortcode('[jotunheim_trade_page]');
}

// Barter Page
function render_barter_page() {
    echo '<h1>Barter</h1>';
    echo do_shortcode('[jotunheim_barter_page]');
}

// Point of Sale interface page
function render_pos_interface_page() {
    echo '<div class="wrap">';
    echo '<h1>Point of Sale System</h1>';
    echo do_shortcode('[pos_interface]');
    echo '</div>';
}

// Weather Calendar Configuration Page
function render_weather_calendar_config_page() {
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['weather_config_nonce'])) {
        if (wp_verify_nonce($_POST['weather_config_nonce'], 'save_weather_config')) {
            // Save API settings
            update_option('weather_api_enabled', isset($_POST['api_enabled']));
            update_option('weather_api_endpoint', sanitize_url($_POST['api_endpoint']));
            
            // Save Manual Override settings
            update_option('weather_manual_enabled', isset($_POST['manual_enabled']));
            update_option('weather_manual_start_day', intval($_POST['manual_start_day']));
            update_option('weather_manual_start_date', sanitize_text_field($_POST['manual_start_date']));
            update_option('weather_manual_progression', sanitize_text_field($_POST['manual_progression']));
            
            // Save Server Start Date
            update_option('weather_server_start_date', sanitize_text_field($_POST['server_start_date']));
            // Save World Seed (optional)
            if (isset($_POST['world_seed'])) {
                update_option('jotunheim_world_seed', sanitize_text_field($_POST['world_seed']));
            }
            
            echo '<div class="updated notice"><p>Weather Calendar configuration updated successfully!</p></div>';
        }
    }
    
    // Get current settings
    $api_enabled = get_option('weather_api_enabled', false);
    $api_endpoint = get_option('weather_api_endpoint', '');
    $manual_enabled = get_option('weather_manual_enabled', false);
    $manual_start_day = get_option('weather_manual_start_day', 1);
    $manual_start_date = get_option('weather_manual_start_date', '2025-08-22T00:00');
    $manual_progression = get_option('weather_manual_progression', 'static');
    $server_start_date = get_option('weather_server_start_date', '2025-08-01T19:30');
    $world_seed = get_option('jotunheim_world_seed', '');
    
    ?>
    <div class="wrap">
        <h1>🌦️ Valheim Weather Calendar Configuration</h1>
        <p>Configure how the weather calendar determines the current in-game day. Settings are applied in priority order.</p>
        
        <form method="POST" action="">
            <?php wp_nonce_field('save_weather_config', 'weather_config_nonce'); ?>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 20px; margin-bottom: 20px;">
                
                <!-- API Override Configuration -->
                <div class="postbox">
                    <div class="postbox-header">
                        <h2>🔗 API Override (Priority 1 - Highest)</h2>
                    </div>
                    <div class="inside">
                        <table class="form-table">
                            <tr>
                                <th scope="row">Enable API Override</th>
                                <td>
                                    <input type="checkbox" name="api_enabled" value="1" <?php checked($api_enabled); ?>>
                                    <p class="description">Use external API to get current day</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">API Endpoint URL</th>
                                <td>
                                    <input type="url" name="api_endpoint" value="<?php echo esc_attr($api_endpoint); ?>" 
                                           class="regular-text" placeholder="https://your-api.com/current-day">
                                    <p class="description">API should return JSON: {"currentDay": 123}<br>
                                    <strong>Cached for 4 hours</strong> to reduce API calls</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <!-- Manual Day Override Configuration -->
                <div class="postbox">
                    <div class="postbox-header">
                        <h2>📅 Manual Day Override (Priority 2)</h2>
                    </div>
                    <div class="inside">
                        <table class="form-table">
                            <tr>
                                <th scope="row">Enable Manual Override</th>
                                <td>
                                    <input type="checkbox" name="manual_enabled" value="1" <?php checked($manual_enabled); ?>>
                                    <p class="description">Manually set current in-game day</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Starting In-Game Day</th>
                                <td>
                                    <input type="number" name="manual_start_day" value="<?php echo esc_attr($manual_start_day); ?>" 
                                           min="1" class="small-text">
                                    <p class="description">What day number to start from</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Date/Time for That Day</th>
                                <td>
                                    <input type="datetime-local" name="manual_start_date" value="<?php echo esc_attr($manual_start_date); ?>" 
                                           class="regular-text">
                                    <p class="description">When that day occurred in real time</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Progression Type</th>
                                <td>
                                    <select name="manual_progression">
                                        <option value="static" <?php selected($manual_progression, 'static'); ?>>Static (no progression)</option>
                                        <option value="real-days" <?php selected($manual_progression, 'real-days'); ?>>Real Days (1 real day = 1 game day)</option>
                                        <option value="game-time" <?php selected($manual_progression, 'game-time'); ?>>Game Time (30 min = 1 game day)</option>
                                    </select>
                                    <p class="description">How the day should progress over time</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <!-- Server Start Date Configuration -->
                <div class="postbox">
                    <div class="postbox-header">
                        <h2>🕐 Server Start Date (Priority 3 - Default)</h2>
                    </div>
                    <div class="inside">
                        <table class="form-table">
                            <tr>
                                <th scope="row">Server Start Date</th>
                                <td>
                                    <input type="datetime-local" name="server_start_date" value="<?php echo esc_attr($server_start_date); ?>" 
                                           class="regular-text">
                                    <p class="description">When your Valheim world started (Day 1)<br>
                                    Day counting progresses based on in-game time (30 min = 1 day)</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">World Seed (optional)</th>
                                <td>
                                    <input type="text" name="world_seed" value="<?php echo esc_attr($world_seed); ?>" class="regular-text" placeholder="e.g. 9BCp6a4KQo">
                                    <p class="description">Optional: store your Valheim world seed here so the plugin can deterministically generate weather/wind for your world.</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <p class="submit">
                <input type="submit" class="button-primary" value="Save Configuration">
                <a href="javascript:void(0)" onclick="clearWeatherCache()" class="button">Clear API Cache</a>
            </p>
        </form>
        
        <div class="postbox" style="margin-top: 20px;">
            <div class="postbox-header">
                <h2>📊 Current Status</h2>
            </div>
            <div class="inside">
                <p><strong>Priority System:</strong></p>
                <ol>
                    <li><strong>API Override</strong> - If enabled and working, uses external API data</li>
                    <li><strong>Manual Override</strong> - If enabled, uses your manual day settings</li>
                    <li><strong>Server Start Date</strong> - Default method, calculates from server start</li>
                </ol>
                <p><em>The system automatically falls back to the next priority if a higher one fails.</em></p>
            </div>
        </div>
        
        <div class="postbox" style="margin-top: 20px;">
            <div class="postbox-header"><h2>🔎 Seed Preview</h2></div>
            <div class="inside">
                <p>Sample weather and wind computed using the saved world seed (<strong><?php echo esc_html($world_seed ?: 'none'); ?></strong>).</p>
                <?php
                // Show a small preview using server-side generator if available
                if (function_exists('\Jotunheim\Utility\getWeathersAt') && function_exists('\Jotunheim\Utility\getGlobalWind')) {
                    echo '<table class="widefat"><thead><tr><th>Day Index</th><th>Wind (angle,int)</th><th>Biome[0]</th><th>Biome[1]</th></tr></thead><tbody>';
                    for ($d = 0; $d < 3; $d++) {
                        $idx = $d * 3600; // sample tick for day
                        $wind = \Jotunheim\Utility\getGlobalWind($idx);
                        $weathers = \Jotunheim\Utility\getWeathersAt($idx);
                        $wa = isset($wind['angle']) ? round($wind['angle']) : 'n/a';
                        $wi = isset($wind['intensity']) ? round($wind['intensity']*100)."%" : 'n/a';
                        $b0 = isset($weathers[0]) ? esc_html($weathers[0]) : 'n/a';
                        $b1 = isset($weathers[1]) ? esc_html($weathers[1]) : 'n/a';
                        echo "<tr><td>{$d}</td><td>{$wa}°, {$wi}</td><td>{$b0}</td><td>{$b1}</td></tr>";
                    }
                    echo '</tbody></table>';
                } else {
                    echo '<p><em>Server-side weather generator not available.</em></p>';
                }
                ?>
            </div>
        </div>
        
        <script>
        function clearWeatherCache() {
            if (confirm('Clear the weather API cache? This will force a fresh API call on next page load.')) {
                // This would need to be implemented via AJAX if needed
                alert('Cache clearing would be implemented via AJAX call to your API cache clearing function.');
            }
        }
        </script>
    </div>
    <?php
}

// EventZone Field Configuration Page
function render_eventzone_field_config_page() {
    global $wpdb;
    
    // Get existing database columns for reference first
    $table_name = 'jotun_eventzones';
    $db_columns = [];
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
        $columns = $wpdb->get_results("DESCRIBE $table_name");
        foreach ($columns as $column) {
            $db_columns[] = $column->Field;
        }
    }
    
    // Get current field configurations and clean up orphaned ones
    $field_configs = get_option('jotunheim_eventzone_field_config', []);
    
    // Clean up orphaned field configurations (configs for deleted columns)
    $cleaned_configs = [];
    $orphaned_count = 0;
    foreach ($field_configs as $config_field => $config) {
        if (in_array($config_field, $db_columns)) {
            $cleaned_configs[$config_field] = $config;
        } else {
            $orphaned_count++;
        }
    }
    
    // Update the saved configurations if we cleaned any orphaned ones
    if ($orphaned_count > 0) {
        update_option('jotunheim_eventzone_field_config', $cleaned_configs);
        $field_configs = $cleaned_configs;
        echo '<div class="updated notice"><p>Cleaned up ' . $orphaned_count . ' orphaned field configuration(s) for deleted database columns.</p></div>';
    }
    
    // Auto-generate configurations for database fields that don't have them
    // OR update existing text fields that should be checkboxes
    $needs_save = false;
    foreach ($db_columns as $column) {
        if (!in_array($column, ['id', 'string_name'])) {
            // Generate default configuration based on field name
            $default_config = [
                'type' => 'text',
                'label' => ucfirst(str_replace('_', ' ', $column)),
                'placeholder' => '',
                'dropdown_options' => '',
                'is_conditional' => false,
                'conditional_field' => '',
                'conditional_value' => '',
                'is_custom' => false
            ];
            
            // Detect checkbox fields based on naming patterns
            $checkbox_patterns = [
                '/^no[A-Z]/', // noSnapCopy, noStatLoss, etc.
                '/^allow[A-Z]/', // allowSignUse, allowItemStandUse, etc.
                '/^disable[A-Z]/', // disableDrops, etc.
                '/^enable[A-Z]/', // enableSomething, etc.
                '/^is[A-Z]/', // isActive, isEnabled, etc.
                '/^has[A-Z]/', // hasAccess, etc.
                '/Loss$/', // noStatLoss, noItemLoss, etc.
                '/Gain$/', // noStatGain, etc.
                '/Drop/', // disableDrops, noBuild, etc.
                '/Invisible/', // invisiblePlayers, etc.
                '/Damage$/', // noBuildDamage, etc.
                '/Placement$/', // allowSignPlacement, allowCarPlacement, etc.
            ];
            
            $is_checkbox = false;
            foreach ($checkbox_patterns as $pattern) {
                if (preg_match($pattern, $column)) {
                    $is_checkbox = true;
                    break;
                }
            }
            
            if ($is_checkbox) {
                $default_config['type'] = 'checkbox';
            }
            // Set specific defaults for known field types
            elseif (in_array($column, ['shape', 'eventzone_status', 'zone_type'])) {
                $default_config['type'] = 'dropdown';
                if ($column === 'shape') {
                    $default_config['dropdown_options'] = "Circle\nSquare";
                } elseif ($column === 'eventzone_status') {
                    $default_config['dropdown_options'] = "enabled\ndisabled";
                } elseif ($column === 'zone_type') {
                    $default_config['dropdown_options'] = "Server Infrastructure\nQuest\nEvent\nBoss Power\nBoss Fight\nNPC";
                }
            } elseif ($column === 'priority') {
                $default_config['type'] = 'number';
                $default_config['placeholder'] = '10';
            }
            
            // If field doesn't exist, create it with default configuration
            if (!isset($field_configs[$column])) {
                $field_configs[$column] = $default_config;
                $needs_save = true;
            }
            // DO NOT modify existing field configurations - let users manage them manually
        }
    }
    
    // Save updated configurations
    if ($needs_save) {
        update_option('jotunheim_eventzone_field_config', $field_configs);
    }
    
    // Save the initial auto-configurations
    update_option('jotunheim_eventzone_field_config', $field_configs);
    
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {        
        if (isset($_POST['eventzone_field_config_nonce'])) {
            if (wp_verify_nonce($_POST['eventzone_field_config_nonce'], 'save_eventzone_field_config')) {
            
            // Handle adding new field configuration
            if (isset($_POST['action']) && $_POST['action'] === 'add_field') {
                $field_source = sanitize_text_field($_POST['field_source'] ?? 'existing');
                $field_name = '';
                $is_custom_field = false;
                
                if ($field_source === 'custom') {
                    $field_name = sanitize_text_field($_POST['custom_field_name']);
                    $is_custom_field = true;
                    
                    // Add new column to database table
                    $table_name = 'jotun_eventzones';
                    $field_type = sanitize_text_field($_POST['field_type']);
                    
                    // Map field types to SQL column types
                    $sql_type = 'TEXT';
                    switch ($field_type) {
                        case 'checkbox':
                            $sql_type = 'TINYINT(1) DEFAULT 0';
                            break;
                        case 'number':
                            $sql_type = 'INT DEFAULT 0';
                            break;
                        case 'text':
                        case 'dropdown':
                            $sql_type = 'VARCHAR(255) DEFAULT ""';
                            break;
                        case 'textarea':
                            $sql_type = 'TEXT';
                            break;
                    }
                    
                    // Check if column already exists
                    $column_exists = $wpdb->get_var($wpdb->prepare(
                        "SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
                         WHERE TABLE_SCHEMA = DATABASE() 
                         AND TABLE_NAME = %s 
                         AND COLUMN_NAME = %s",
                        $table_name,
                        $field_name
                    ));
                    
                    if (!$column_exists) {
                        $alter_sql = "ALTER TABLE $table_name ADD COLUMN `$field_name` $sql_type";
                        $result = $wpdb->query($alter_sql);
                        
                        if ($result === false) {
                            echo '<div class="error notice"><p>Failed to add database column: ' . $wpdb->last_error . '</p></div>';
                            return;
                        } else {
                            echo '<div class="updated notice"><p>Successfully added new database column: ' . $field_name . '</p></div>';
                            
                            // Refresh database columns list after adding new column
                            $db_columns = [];
                            if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
                                $columns = $wpdb->get_results("DESCRIBE $table_name");
                                foreach ($columns as $column) {
                                    $db_columns[] = $column->Field;
                                }
                            }
                        }
                    } else {
                        echo '<div class="notice notice-warning"><p>Database column already exists: ' . $field_name . '</p></div>';
                    }
                    
                } else {
                    $field_name = sanitize_text_field($_POST['field_name']);
                    $is_custom_field = false;
                }
                
                // Validate that we have a field name
                if (empty($field_name)) {
                    echo '<div class="error notice"><p>Please provide a field name.</p></div>';
                    return;
                }
                
                $field_type = sanitize_text_field($_POST['field_type']);
                $field_label = sanitize_text_field($_POST['field_label']);
                $field_placeholder = sanitize_text_field($_POST['field_placeholder']);
                $dropdown_options = sanitize_textarea_field($_POST['dropdown_options']);
                $is_conditional = isset($_POST['is_conditional']) ? 1 : 0;
                
                // Handle multiple conditions
                $conditions = [];
                if ($is_conditional && isset($_POST['conditional_field']) && isset($_POST['conditional_value'])) {
                    $conditional_fields = $_POST['conditional_field'];
                    $conditional_values = $_POST['conditional_value'];
                    
                    for ($i = 0; $i < count($conditional_fields); $i++) {
                        if (!empty($conditional_fields[$i]) && !empty($conditional_values[$i])) {
                            $conditions[] = [
                                'field' => sanitize_text_field($conditional_fields[$i]),
                                'value' => sanitize_text_field($conditional_values[$i])
                            ];
                        }
                    }
                }
                
                $existing_config = get_option('jotunheim_eventzone_field_config', []);
                $existing_config[$field_name] = [
                    'type' => $field_type,
                    'label' => $field_label,
                    'placeholder' => $field_placeholder,
                    'dropdown_options' => $dropdown_options,
                    'is_conditional' => $is_conditional,
                    'conditions' => $conditions, // New: array of conditions
                    // Keep old format for backward compatibility
                    'conditional_field' => !empty($conditions) ? $conditions[0]['field'] : '',
                    'conditional_value' => !empty($conditions) ? $conditions[0]['value'] : '',
                    'is_custom' => false  // All fields are database columns now
                ];
                
                update_option('jotunheim_eventzone_field_config', $existing_config);
                
                $is_modification = isset($_POST['is_modification']) && $_POST['is_modification'] === '1';
                if ($is_modification) {
                    echo '<div class="updated notice"><p>Field configuration updated successfully!</p></div>';
                } else {
                    echo '<div class="updated notice"><p>Field configuration added successfully!</p></div>';
                }
            }
            
            // Handle deleting database variable (column)
            if (isset($_POST['action']) && $_POST['action'] === 'delete_variable') {
                $variable_to_delete = sanitize_text_field($_POST['variable_to_delete']);
                $table_name = 'jotun_eventzones';
                
                // Security check - don't allow deleting core columns
                $protected_columns = ['id', 'string_name', 'name', 'zone_type', 'shape', 'eventzone_status'];
                
                if (in_array($variable_to_delete, $protected_columns)) {
                    echo '<div class="error notice"><p>Cannot delete protected system column: ' . $variable_to_delete . '</p></div>';
                } else {
                    // Check if column exists
                    $column_exists = $wpdb->get_var($wpdb->prepare(
                        "SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
                         WHERE TABLE_SCHEMA = DATABASE() 
                         AND TABLE_NAME = %s 
                         AND COLUMN_NAME = %s",
                        $table_name,
                        $variable_to_delete
                    ));
                    
                    if ($column_exists) {
                        // Drop the column
                        $drop_sql = "ALTER TABLE $table_name DROP COLUMN `$variable_to_delete`";
                        $result = $wpdb->query($drop_sql);
                        
                        if ($result === false) {
                            echo '<div class="error notice"><p>Failed to delete database column: ' . $wpdb->last_error . '</p></div>';
                        } else {
                            // Also remove any field configuration
                            $existing_config = get_option('jotunheim_eventzone_field_config', []);
                            if (isset($existing_config[$variable_to_delete])) {
                                unset($existing_config[$variable_to_delete]);
                                update_option('jotunheim_eventzone_field_config', $existing_config);
                            }
                            
                            echo '<div class="updated notice"><p>Successfully deleted database column and configuration: ' . $variable_to_delete . '</p></div>';
                        }
                    } else {
                        echo '<div class="error notice"><p>Database column does not exist: ' . $variable_to_delete . '</p></div>';
                    }
                }
            }
        }
        } // Close nonce check
    }
    
    // Debug: Add some debugging info
    if (isset($_GET['debug']) && $_GET['debug'] === '1') {
        echo '<div class="notice notice-info"><p><strong>Debug Info:</strong></p>';
        echo '<pre>' . print_r($field_configs, true) . '</pre></div>';
    }
    
    ?>
    <div class="wrap">
        <h1>⚙️ EventZone Field Configuration</h1>
        <p>Configure how fields appear in the EventZone add/edit interfaces. All fields correspond to database columns.</p>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            
            <!-- LEFT: Add New Variable -->
            <div class="postbox">
                <div class="postbox-header">
                    <h2>➕ Add New Variable</h2>
                </div>
                <div class="inside">
                    <form method="POST" action="">
                        <?php wp_nonce_field('save_eventzone_field_config', 'eventzone_field_config_nonce'); ?>
                        <input type="hidden" name="action" value="add_field">
                        <input type="hidden" name="field_source" value="custom">
                        
                        <table class="form-table">
                            <tr>
                                <th scope="row">Variable Name</th>
                                <td>
                                    <input type="text" name="custom_field_name" class="regular-text" placeholder="noSnapCopy" required>
                                    <p class="description">Enter new variable name (camelCase format). This will create a new database column.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Field Input Type</th>
                                <td>
                                    <select name="field_type" id="add-field-type" required>
                                        <option value="text">Text Input</option>
                                        <option value="checkbox">Checkbox</option>
                                        <option value="dropdown">Dropdown</option>
                                        <option value="number">Number Input</option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="placeholder-row-add">
                                <th scope="row">Placeholder Text</th>
                                <td>
                                    <input type="text" name="field_placeholder" class="regular-text" placeholder="Placeholder text">
                                    <p class="description">Only applies to text/number inputs</p>
                                </td>
                            </tr>
                            <tr class="dropdown-options-row-add" style="display: none;">
                                <th scope="row">Dropdown Options</th>
                                <td>
                                    <textarea name="dropdown_options" rows="4" cols="50" placeholder="Option1&#10;Option2&#10;Option3"></textarea>
                                    <p class="description">One option per line. Only used for dropdown fields.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Conditional Display</th>
                                <td>
                                    <label>
                                        <input type="checkbox" name="is_conditional" value="1"> This field should only show conditionally
                                    </label>
                                </td>
                            </tr>
                            <tr class="conditional-settings" style="display: none;">
                                <th scope="row">Show When</th>
                                <td>
                                    <div id="conditions-container-add">
                                        <div class="condition-row" style="margin-bottom: 10px;">
                                            <select name="conditional_field[]">
                                                <option value="">Select Field</option>
                                                <?php foreach ($db_columns as $column): ?>
                                                    <?php if (!in_array($column, ['id', 'string_name'])): ?>
                                                        <option value="<?php echo esc_attr($column); ?>"><?php echo esc_html($column); ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                            <span> equals </span>
                                            <input type="text" name="conditional_value[]" placeholder="value" style="width: 100px;">
                                            <button type="button" class="button remove-condition" style="margin-left: 10px;">Remove</button>
                                        </div>
                                    </div>
                                    <button type="button" class="button add-condition" style="margin-top: 10px;">Add Another Condition (OR)</button>
                                    <p class="description">Field will show when ANY of these conditions are met</p>
                                </td>
                            </tr>
                        </table>
                        
                        <p class="submit">
                            <input type="submit" class="button-primary" value="Add New Variable">
                        </p>
                    </form>
                </div>
            </div>

            <!-- RIGHT: Modify Existing Variables -->
            <div class="postbox">
                <div class="postbox-header">
                    <h2>⚙️ Modify Existing Variables</h2>
                </div>
                <div class="inside">
                    <form method="POST" action="">
                        <?php wp_nonce_field('save_eventzone_field_config', 'eventzone_field_config_nonce'); ?>
                        <input type="hidden" name="action" value="add_field">
                        <input type="hidden" name="field_source" value="existing">
                        <input type="hidden" name="is_modification" value="1">
                        
                        <table class="form-table">
                            <tr>
                                <th scope="row">Select Variable</th>
                                <td>
                                    <select name="field_name" required>
                                        <option value="">Select Database Field</option>
                                        <?php foreach ($db_columns as $column): ?>
                                            <?php if (!in_array($column, ['id', 'string_name'])): ?>
                                                <option value="<?php echo esc_attr($column); ?>"><?php echo esc_html($column); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <p class="description">Select any database field to modify its configuration</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Field Input Type</th>
                                <td>
                                    <select name="field_type" id="modify-field-type" required>
                                        <option value="text">Text Input</option>
                                        <option value="checkbox">Checkbox</option>
                                        <option value="dropdown">Dropdown</option>
                                        <option value="number">Number Input</option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="placeholder-row-modify">
                                <th scope="row">Placeholder Text</th>
                                <td>
                                    <input type="text" name="field_placeholder" class="regular-text" placeholder="Placeholder text">
                                    <p class="description">Only applies to text/number inputs</p>
                                </td>
                            </tr>
                            <tr class="dropdown-options-row-modify" style="display: none;">
                                <th scope="row">Dropdown Options</th>
                                <td>
                                    <textarea name="dropdown_options" rows="4" cols="50" placeholder="Option1&#10;Option2&#10;Option3"></textarea>
                                    <p class="description">One option per line. Only used for dropdown fields.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Conditional Display</th>
                                <td>
                                    <label>
                                        <input type="checkbox" name="is_conditional" value="1"> This field should only show conditionally
                                    </label>
                                </td>
                            </tr>
                            <tr class="conditional-settings" style="display: none;">
                                <th scope="row">Show When</th>
                                <td>
                                    <div id="conditions-container-modify">
                                        <div class="condition-row" style="margin-bottom: 10px;">
                                            <select name="conditional_field[]">
                                                <option value="">Select Field</option>
                                                <?php foreach ($db_columns as $column): ?>
                                                    <?php if (!in_array($column, ['id', 'string_name'])): ?>
                                                        <option value="<?php echo esc_attr($column); ?>"><?php echo esc_html($column); ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                            <span> equals </span>
                                            <input type="text" name="conditional_value[]" placeholder="value" style="width: 100px;">
                                            <button type="button" class="button remove-condition" style="margin-left: 10px;">Remove</button>
                                        </div>
                                    </div>
                                    <button type="button" class="button add-condition" style="margin-top: 10px;">Add Another Condition (OR)</button>
                                    <p class="description">Field will show when ANY of these conditions are met</p>
                                </td>
                            </tr>
                        </table>
                        
                        <p class="submit">
                            <input type="submit" class="button-primary" value="Save Changes" onclick="return confirm('Are you sure you want to update this field configuration? This will affect how the field appears in all EventZone forms.');">
                        </p>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Variable Deletion Section -->
        <div class="postbox" style="border-left: 4px solid #dc3545;">
            <div class="postbox-header">
                <h2 style="color: #dc3545;">🗑️ Delete Variable</h2>
            </div>
            <div class="inside">
                <div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                    <p style="margin: 0; color: #856404;"><strong>⚠️ Warning:</strong> This will permanently delete the database column and all its data. This action cannot be undone!</p>
                </div>
                
                <form method="POST" action="" onsubmit="return confirmVariableDeletion();">
                    <?php wp_nonce_field('save_eventzone_field_config', 'eventzone_field_config_nonce'); ?>
                    <input type="hidden" name="action" value="delete_variable">
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">Select Variable to Delete</th>
                            <td>
                                <select name="variable_to_delete" required style="width: 300px;">
                                    <option value="">Select Variable to Delete</option>
                                    <?php 
                                    $protected_columns = ['id', 'string_name', 'name', 'zone_type', 'shape', 'eventzone_status'];
                                    foreach ($db_columns as $column): 
                                        if (!in_array($column, $protected_columns)):
                                    ?>
                                        <option value="<?php echo esc_attr($column); ?>">
                                            <?php echo esc_html($column); ?>
                                        </option>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </select>
                                <p class="description">
                                    Protected columns (id, string_name, name, zone_type, shape, eventzone_status) cannot be deleted.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Safety Confirmation</th>
                            <td>
                                <label>
                                    <input type="checkbox" id="delete-safety-check" required>
                                    <strong style="color: #dc3545;">I understand this will permanently delete the database column and all its data</strong>
                                </label>
                            </td>
                        </tr>
                    </table>
                    
                    <p class="submit">
                        <input type="submit" class="button" value="Delete Variable" style="background: #dc3545; color: white; border-color: #dc3545;" disabled id="delete-variable-btn">
                    </p>
                </form>
            </div>
        </div>
        
        <!-- Current Field Configurations - Only shown when editing -->
        <div class="postbox" id="current-configurations" style="display: none;">
            <div class="postbox-header">
                <h2>📋 Current Configuration</h2>
            </div>
            <div class="inside">
                <div id="current-config-display">
                    <p><em>Select a field from the "Modify Existing Variables" section to see its current configuration.</em></p>
                </div>
            </div>
        </div>
            
            <!-- Current Field Configurations -->
        </div>
        
        <div class="postbox">
            <div class="postbox-header">
                <h2>📋 All Field Configurations</h2>
            </div>
            <div class="inside">
                <?php if (empty($field_configs)): ?>
                    <p><em>No field configurations yet. Add some using the forms above!</em></p>
                <?php else: ?>
                    <table class="widefat fixed">
                        <thead>
                            <tr>
                                <th>Field Name</th>
                                <th>Source</th>
                                <th>Type</th>
                                <th>Label</th>
                                <th>Conditional</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $protected_columns = ['id', 'string_name', 'name', 'zone_type', 'shape', 'eventzone_status'];
                            foreach ($field_configs as $field_name => $config): 
                            ?>
                                <tr>
                                    <td><code><?php echo esc_html($field_name); ?></code></td>
                                    <td>
                                        <span style="color: green; font-weight: bold;">Database</span>
                                    </td>
                                    <td><?php echo esc_html(ucfirst($config['type'])); ?></td>
                                    <td><?php echo esc_html($config['label'] ?: ucfirst(str_replace('_', ' ', $field_name))); ?></td>
                                    <td>
                                        <?php if ($config['is_conditional']): ?>
                                            <span style="color: green;">✓</span> 
                                            <?php echo esc_html($config['conditional_field'] . ' = ' . $config['conditional_value']); ?>
                                        <?php else: ?>
                                            <span style="color: #999;">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <?php if (!in_array($field_name, $protected_columns)): ?>
                                                <div style="display: flex; align-items: center; gap: 5px;">
                                                    <input type="checkbox" id="safety-<?php echo esc_attr($field_name); ?>" onchange="toggleDeleteButton('<?php echo esc_js($field_name); ?>')">
                                                    <form method="POST" style="display: inline;" onsubmit="return confirmVariableDeletion('<?php echo esc_js($field_name); ?>');">
                                                        <?php wp_nonce_field('save_eventzone_field_config', 'eventzone_field_config_nonce'); ?>
                                                        <input type="hidden" name="action" value="delete_variable">
                                                        <input type="hidden" name="variable_to_delete" value="<?php echo esc_attr($field_name); ?>">
                                                        <input type="submit" class="button button-small" value="Delete Variable" style="background: #dc3545; color: white; border-color: #dc3545;" disabled id="delete-btn-<?php echo esc_attr($field_name); ?>">
                                                    </form>
                                                </div>
                                            <?php else: ?>
                                                <span style="color: #999; font-size: 11px;">(protected)</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="postbox">
            <div class="postbox-header">
                <h2>ℹ️ Fields Reference</h2>
            </div>
            <div class="inside">
                <p><strong>Database fields in <?php echo esc_html($table_name); ?>:</strong></p>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px; margin-bottom: 20px;">
                    <?php foreach ($db_columns as $column): ?>
                        <code style="background: #f0f0f0; padding: 5px; border-radius: 3px; display: block;">
                            <?php echo esc_html($column); ?>
                            <?php if (isset($field_configs[$column])): ?>
                                <span style="color: green; font-weight: bold;"> ✓</span>
                            <?php endif; ?>
                        </code>
                    <?php endforeach; ?>
                </div>
                
                <p><em>Database fields with ✓ have configurations.</em></p>
            </div>
        </div>
        
        <script>
        // Store field configurations for JavaScript access
        const fieldConfigs = <?php echo json_encode($field_configs); ?>;
        
        function confirmVariableDeletion(variableName = null) {
            // If no variable name provided, get it from the select dropdown
            if (!variableName) {
                const select = document.querySelector('select[name="variable_to_delete"]');
                variableName = select ? select.value : null;
            }
            
            if (!variableName) {
                alert('Please select a variable to delete.');
                return false;
            }
            
            const confirmMessage = `⚠️ PERMANENT DELETION WARNING ⚠️\n\n` +
                `You are about to permanently delete the database column "${variableName}" and ALL its data.\n\n` +
                `This will:\n` +
                `• Remove the column from the database\n` +
                `• Delete all stored data in this column\n` +
                `• Remove any field configuration\n` +
                `• Cannot be undone\n\n` +
                `Type "${variableName}" below to confirm deletion:`;
                
            const userInput = prompt(confirmMessage);
            
            if (userInput === variableName) {
                return confirm(`Final confirmation: Delete "${variableName}" permanently?`);
            } else {
                alert('Deletion cancelled. Variable name did not match.');
                return false;
            }
        }
        
        function toggleDeleteButton(fieldName) {
            const checkbox = document.getElementById('safety-' + fieldName);
            const button = document.getElementById('delete-btn-' + fieldName);
            if (checkbox && button) {
                button.disabled = !checkbox.checked;
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const conditionalCheckboxes = document.querySelectorAll('input[name="is_conditional"]');
            const existingFieldSelect = document.querySelector('select[name="field_name"]');
            const currentConfigDiv = document.getElementById('current-configurations');
            const currentConfigDisplay = document.getElementById('current-config-display');
            const deleteSafetyCheck = document.getElementById('delete-safety-check');
            const deleteVariableBtn = document.getElementById('delete-variable-btn');
            
            // Handle delete safety checkbox
            if (deleteSafetyCheck && deleteVariableBtn) {
                deleteSafetyCheck.addEventListener('change', function() {
                    deleteVariableBtn.disabled = !this.checked;
                });
            }
            
            // Handle conditional display checkboxes
            conditionalCheckboxes.forEach(checkbox => {
                const conditionalSettings = checkbox.closest('table').querySelector('.conditional-settings');
                
                checkbox.addEventListener('change', function() {
                    conditionalSettings.style.display = this.checked ? 'table-row' : 'none';
                });
            });
            
            // Handle field type dependent rows visibility
            function updateFieldTypeVisibility(fieldTypeSelect, prefix) {
                const placeholderRow = document.querySelector('.placeholder-row-' + prefix);
                const dropdownOptionsRow = document.querySelector('.dropdown-options-row-' + prefix);
                
                if (!placeholderRow || !dropdownOptionsRow) return;
                
                const selectedType = fieldTypeSelect.value;
                
                // Show/hide rows based on field type
                if (selectedType === 'dropdown') {
                    // Dropdown: show dropdown options, hide placeholder
                    dropdownOptionsRow.style.display = 'table-row';
                    placeholderRow.style.display = 'none';
                } else if (selectedType === 'checkbox') {
                    // Checkbox: hide both
                    dropdownOptionsRow.style.display = 'none';
                    placeholderRow.style.display = 'none';
                } else {
                    // Text/Number: show placeholder, hide dropdown options
                    dropdownOptionsRow.style.display = 'none';
                    placeholderRow.style.display = 'table-row';
                }
            }
            
            // Add New Variable field type handling
            const addFieldType = document.getElementById('add-field-type');
            if (addFieldType) {
                // Initial state
                updateFieldTypeVisibility(addFieldType, 'add');
                
                // On change
                addFieldType.addEventListener('change', function() {
                    updateFieldTypeVisibility(this, 'add');
                });
            }
            
            // Modify Existing Variable field type handling
            const modifyFieldType = document.getElementById('modify-field-type');
            if (modifyFieldType) {
                // Initial state
                updateFieldTypeVisibility(modifyFieldType, 'modify');
                
                // On change
                modifyFieldType.addEventListener('change', function() {
                    updateFieldTypeVisibility(this, 'modify');
                });
            }
            
            // Handle existing field selection
            if (existingFieldSelect) {
                existingFieldSelect.addEventListener('change', function() {
                    const selectedField = this.value;
                    
                    if (selectedField && fieldConfigs[selectedField]) {
                        // Show current configuration
                        showCurrentConfig(selectedField, fieldConfigs[selectedField]);
                        
                        // Populate the form with current values
                        populateExistingFieldForm(fieldConfigs[selectedField]);
                    } else {
                        // Hide current configuration
                        currentConfigDiv.style.display = 'none';
                        clearExistingFieldForm();
                    }
                });
            }
            
            function showCurrentConfig(fieldName, config) {
                const html = `
                    <h4>Current Configuration for: <code>${fieldName}</code></h4>
                    <table class="form-table">
                        <tr><th>Field Type:</th><td>${config.type}</td></tr>
                        <tr><th>Placeholder:</th><td>${config.placeholder || 'None'}</td></tr>
                        <tr><th>Dropdown Options:</th><td>${config.dropdown_options || 'N/A'}</td></tr>
                        <tr><th>Conditional:</th><td>${config.is_conditional ? 'Yes (' + config.conditional_field + ' = ' + config.conditional_value + ')' : 'No'}</td></tr>
                    </table>
                `;
                currentConfigDisplay.innerHTML = html;
                currentConfigDiv.style.display = 'block';
            }
            
            function populateExistingFieldForm(config) {
                const form = existingFieldSelect.closest('form');
                if (!form) return;
                
                // Populate form fields
                const fieldType = form.querySelector('select[name="field_type"]');
                const fieldLabel = form.querySelector('input[name="field_label"]');
                const fieldPlaceholder = form.querySelector('input[name="field_placeholder"]');
                const dropdownOptions = form.querySelector('textarea[name="dropdown_options"]');
                const isConditional = form.querySelector('input[name="is_conditional"]');
                
                if (fieldType) {
                    fieldType.value = config.type || 'text';
                    // Update field type dependent rows visibility
                    updateFieldTypeVisibility(fieldType, 'modify');
                }
                if (fieldLabel) fieldLabel.value = config.label || '';
                if (fieldPlaceholder) fieldPlaceholder.value = config.placeholder || '';
                if (dropdownOptions) dropdownOptions.value = config.dropdown_options || '';
                if (isConditional) {
                    isConditional.checked = config.is_conditional || false;
                    // Trigger the conditional display
                    const conditionalSettings = form.querySelector('.conditional-settings');
                    if (conditionalSettings) {
                        conditionalSettings.style.display = isConditional.checked ? 'table-row' : 'none';
                    }
                }
                
                // Handle multiple conditions (new format) or fallback to legacy single condition
                const conditionsContainer = form.querySelector('#conditions-container-modify');
                if (conditionsContainer && config.is_conditional) {
                    // Clear existing conditions
                    conditionsContainer.innerHTML = '';
                    
                    if (config.conditions && config.conditions.length > 0) {
                        // New format: multiple conditions
                        config.conditions.forEach((condition, index) => {
                            const conditionRow = createConditionRow(condition.field, condition.value, index === 0);
                            conditionsContainer.appendChild(conditionRow);
                        });
                    } else if (config.conditional_field && config.conditional_value) {
                        // Legacy format: single condition
                        const conditionRow = createConditionRow(config.conditional_field, config.conditional_value, true);
                        conditionsContainer.appendChild(conditionRow);
                    } else {
                        // No conditions, create empty row
                        const conditionRow = createConditionRow('', '', true);
                        conditionsContainer.appendChild(conditionRow);
                    }
                }
            }
            
            function createConditionRow(fieldValue, valueValue, isFirst) {
                const conditionRow = document.createElement('div');
                conditionRow.className = 'condition-row';
                conditionRow.style.marginBottom = '10px';
                
                // Get field options from the database columns
                const fieldOptions = Array.from(document.querySelectorAll('#conditions-container-modify select option, #conditions-container-add select option'))
                    .map(option => `<option value="${option.value}" ${option.value === fieldValue ? 'selected' : ''}>${option.textContent}</option>`)
                    .join('');
                
                conditionRow.innerHTML = `
                    <select name="conditional_field[]">
                        ${fieldOptions}
                    </select>
                    <span> equals </span>
                    <input type="text" name="conditional_value[]" placeholder="value" value="${valueValue}" style="width: 100px;">
                    ${!isFirst ? '<button type="button" class="button remove-condition" style="margin-left: 10px;">Remove</button>' : ''}
                `;
                
                return conditionRow;
            }
            
            function clearExistingFieldForm() {
                const form = existingFieldSelect.closest('form');
                if (!form) return;
                
                // Clear form fields
                const inputs = form.querySelectorAll('input[type="text"], textarea, select:not([name="field_name"])');
                inputs.forEach(input => {
                    if (input.type === 'checkbox') {
                        input.checked = false;
                    } else {
                        input.value = '';
                    }
                });
                
                // Hide conditional settings
                const conditionalSettings = form.querySelector('.conditional-settings');
                if (conditionalSettings) {
                    conditionalSettings.style.display = 'none';
                }
            }
            
            // Handle multiple conditions functionality
            function setupMultipleConditions() {
                // Add condition functionality
                document.addEventListener('click', function(e) {
                    if (e.target.classList.contains('add-condition')) {
                        const container = e.target.previousElementSibling;
                        const newCondition = document.createElement('div');
                        newCondition.className = 'condition-row';
                        newCondition.style.marginBottom = '10px';
                        
                        // Get the field options from the first condition row
                        const firstSelect = container.querySelector('select');
                        const fieldOptions = firstSelect ? firstSelect.innerHTML : '';
                        
                        newCondition.innerHTML = `
                            <select name="conditional_field[]">
                                ${fieldOptions}
                            </select>
                            <span> equals </span>
                            <input type="text" name="conditional_value[]" placeholder="value" style="width: 100px;">
                            <button type="button" class="button remove-condition" style="margin-left: 10px;">Remove</button>
                        `;
                        
                        container.appendChild(newCondition);
                    }
                    
                    // Remove condition functionality
                    if (e.target.classList.contains('remove-condition')) {
                        const container = e.target.closest('.condition-row').parentNode;
                        if (container.children.length > 1) {
                            e.target.closest('.condition-row').remove();
                        } else {
                            alert('You must have at least one condition');
                        }
                    }
                });
            }
            
            setupMultipleConditions();
        });
        </script>
    </div>
    <?php
}

// Hook the menu function to WordPress admin menu
add_action('admin_menu', 'jotunheim_magic_plugin_menu');

// Ensure proper submenu order after all menus are registered
add_action('admin_menu', function() {
    global $submenu;
    
    if (isset($submenu['jotunheim_magic'])) {
        // Remove any duplicate of the main item that WordPress automatically creates
        foreach ($submenu['jotunheim_magic'] as $key => $item) {
            if ($item[2] === 'jotunheim_magic' && $item[0] === 'Jotunheim Magic') {
                error_log('Jotunheim Dashboard: Removing WordPress auto-generated duplicate - ' . $item[0]);
                unset($submenu['jotunheim_magic'][$key]);
            }
        }
        
        // Remove any extra Dashboard Overview duplicates that might have been added
        $dashboard_count = 0;
        foreach ($submenu['jotunheim_magic'] as $key => $item) {
            if ($item[0] === 'Dashboard Overview') {
                $dashboard_count++;
                if ($dashboard_count > 1) {
                    error_log('Jotunheim Dashboard: Removing duplicate Dashboard Overview entry');
                    unset($submenu['jotunheim_magic'][$key]);
                }
            }
        }
        
        // Re-index the array
        $submenu['jotunheim_magic'] = array_values($submenu['jotunheim_magic']);
        
        error_log('Jotunheim Dashboard: Final submenu structure - ' . print_r($submenu['jotunheim_magic'], true));
    }
}, 999); // Run very late to ensure we override everything
?>