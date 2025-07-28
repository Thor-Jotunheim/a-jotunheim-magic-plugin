<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Function to add the main menu item and submenu items
function jotunheim_magic_plugin_menu() {
    // Debug current user info during menu registration
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        error_log("Menu registration - User: {$current_user->user_login}, Roles: " . implode(', ', $current_user->roles));
        error_log("User has manage_options: " . (current_user_can('manage_options') ? 'Yes' : 'No'));
        error_log("User has editor capability: " . (current_user_can('editor') ? 'Yes' : 'No'));
    }

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
    ];

    // Register each submenu
    foreach ($submenus as $submenu) {
        add_submenu_page(
            'jotunheim_magic',   // Parent slug
            $submenu['title'],          // Page title
            $submenu['menu_title'],     // Menu title
            'manage_options',           // Capability required (restricted to admins by default)
            $submenu['slug'],           // Submenu slug
            $submenu['callback']        // Callback function
        );
    }

    // Remove the default submenu created by WordPress
    remove_submenu_page('jotunheim_magic', 'jotunheim_magic');
}

// Main dashboard page for Jotunheim Magic Plugin
function jotunheim_magic_dashboard() {
    echo '<h1>Welcome to Jotunheim Magic Plugin</h1>';
    echo '<p>Use the available tools to manage the plugin functionalities.</p>';
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

// Hook the menu function to WordPress admin menu
add_action('admin_menu', 'jotunheim_magic_plugin_menu');
?>