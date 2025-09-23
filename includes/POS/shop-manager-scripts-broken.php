<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Shop Manager Scripts and Shortcodes
 */

// Register the shortcode handler
function shop_manager_scripts_shortcode($atts) {
    // Enqueue scripts and styles only when shortcode is used
    wp_enqueue_script(
        'jotun-comprehensive-api',
        plugin_dir_url(__FILE__) . '../../assets/js/jotun-comprehensive-api.js',
        ['jquery'],
        filemtime(plugin_dir_path(__FILE__) . '../../assets/js/jotun-comprehensive-api.js'),
        true
    );

    // Localize the comprehensive API script with necessary data
    wp_localize_script('jotun-comprehensive-api', 'jotun_api_vars', [
        'nonce' => wp_create_nonce('wp_rest'),
        'rest_url' => rest_url('jotun-api/v1/')
    ]);

    wp_enqueue_script(
        'shop-manager-js',
        plugin_dir_url(__FILE__) . '../../assets/js/shop-manager.js',
        ['jquery', 'jotun-comprehensive-api'],
        filemtime(plugin_dir_path(__FILE__) . '../../assets/js/shop-manager.js'),
        true
    );

    // Localize script with necessary data
    wp_localize_script('shop-manager-js', 'shopManagerAjax', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('shop_manager_nonce'),
        'rest_url' => rest_url('jotun-api/v1/'),
        'rest_nonce' => wp_create_nonce('wp_rest')
    ]);

    // Return the interface
    return shop_manager_interface();
}

// Register the shortcode
add_shortcode('shop_manager', 'shop_manager_scripts_shortcode');

/**
 * Turn-In Tracker Shortcode
 * Usage: [turn_in_tracker shop_name="Shop Name"]
 */
function turn_in_tracker_shortcode($atts) {
    $atts = shortcode_atts([
        'shop_name' => '',
        'shop_id' => ''
    ], $atts, 'turn_in_tracker');
    
    if (empty($atts['shop_name']) && empty($atts['shop_id'])) {
        return '<p><em>Error: Please specify shop_name or shop_id parameter.</em></p>';
    }
    
    // Get shop data
    global $wpdb;
    
    if (!empty($atts['shop_id'])) {
        $shop = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM jotun_shops WHERE shop_id = %d AND shop_type = 'turn-in-only'",
            (int)$atts['shop_id']
        ));
    } else {
        $shop = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM jotun_shops WHERE shop_name = %s AND shop_type = 'turn-in-only'",
            sanitize_text_field($atts['shop_name'])
        ));
    }
    
    if (!$shop) {
        return '<p><em>Turn-in shop not found or is not a Turn-In Only shop type.</em></p>';
    }
    
    // Get turn-in count
    $tracker = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM jotun_turn_in_trackers WHERE shop_id = %d",
        $shop->shop_id
    ));
    
    $total_count = 0;
    if ($tracker) {
        $total_count = $wpdb->get_var($wpdb->prepare(
            "SELECT COALESCE(SUM(quantity), 0) FROM jotun_turn_ins 
             WHERE shop_id = %d AND recorded_at >= %s",
            $shop->shop_id,
            $tracker->last_reset
        ));
    }
    
    $last_reset = $tracker ? $tracker->last_reset : 'Never';
    
    ob_start();
    ?>
    <div class="turn-in-tracker-widget" data-shop-id="<?php echo esc_attr($shop->shop_id); ?>">
        <div class="tracker-header">
            <h4><?php echo esc_html($shop->shop_name); ?> - Turn-In Tracker</h4>
        </div>
        <div class="tracker-stats">
            <div class="stat-item">
                <span class="stat-label">Total Items Turned In:</span>
                <span class="stat-value" id="tracker-count-<?php echo esc_attr($shop->shop_id); ?>"><?php echo esc_html($total_count); ?></span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Last Reset:</span>
                <span class="stat-value"><?php echo esc_html($last_reset !== 'Never' ? date('M j, Y g:i A', strtotime($last_reset)) : 'Never'); ?></span>
            </div>
        </div>
    </div>
    
    <style>
    .turn-in-tracker-widget {
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 16px;
        margin: 16px 0;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    
    .tracker-header h4 {
        margin: 0 0 12px 0;
        color: #333;
        font-size: 18px;
    }
    
    .tracker-stats {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }
    
    .stat-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    
    .stat-label {
        font-size: 12px;
        color: #666;
        text-transform: uppercase;
        font-weight: 500;
    }
    
    .stat-value {
        font-size: 20px;
        font-weight: bold;
        color: #2c5aa0;
    }
    
    @media (max-width: 600px) {
        .tracker-stats {
            flex-direction: column;
            gap: 12px;
        }
    }
    </style>
    <?php
    return ob_get_clean();
}

add_shortcode('turn_in_tracker', 'turn_in_tracker_shortcode');ABSPATH')) {
    exit;
}

/**
 * Register Shop Manager Scripts and Shortcodes
 */

// Register the shortcode handler
function shop_manager_scripts_shortcode($atts) {
    // Enqueue scripts and styles only when shortcode is used
    wp_enqueue_script(
        'jotun-comprehensive-api',
        plugin_dir_url(__FILE__) . '../../assets/js/jotun-comprehensive-api.js',
        ['jquery'],
        filemtime(plugin_dir_path(__FILE__) . '../../assets/js/jotun-comprehensive-api.js'),
        true
    );

    // Localize the comprehensive API script with necessary data
    wp_localize_script('jotun-comprehensive-api', 'jotun_api_vars', [
        'nonce' => wp_create_nonce('wp_rest'),
        'rest_url' => rest_url('jotun-api/v1/')
    ]);

    wp_enqueue_script(
        'shop-manager-js',
        plugin_dir_url(__FILE__) . '../../assets/js/shop-manager.js',
        ['jquery', 'jotun-comprehensive-api'],
        filemtime(plugin_dir_path(__FILE__) . '../../assets/js/shop-manager.js'),
        true
    );

    // Localize script with necessary data
    wp_localize_script('shop-manager-js', 'shopManagerAjax', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('shop_manager_nonce'),
        'rest_url' => rest_url('jotun-api/v1/'),
        'rest_nonce' => wp_create_nonce('wp_rest')
    ]);

    // Return the interface
    return shop_manager_interface();
}

// Register the shortcode
add_shortcode('shop_manager', 'shop_manager_scripts_shortcode');

/**
 * Conditional script loading based on page content
 */
function maybe_enqueue_shop_manager_scripts() {
    global $post;
    
    if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'shop_manager')) {
        wp_enqueue_script(
            'jotun-comprehensive-api',
            plugin_dir_url(__FILE__) . '../../assets/js/jotun-comprehensive-api.js',
            ['jquery'],
            '1.0.0',
            true
        );

        wp_enqueue_script(
            'shop-manager-js',
            plugin_dir_url(__FILE__) . '../../assets/js/shop-manager.js',
            ['jquery', 'jotun-comprehensive-api'],
            '1.0.0',
            true
        );

        // Localize script with necessary data
        wp_localize_script('shop-manager-js', 'shopManagerAjax', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('shop_manager_nonce'),
            'rest_url' => rest_url('jotun-api/v1/'),
            'rest_nonce' => wp_create_nonce('wp_rest')
        ]);
    }
}

add_action('wp_enqueue_scripts', 'maybe_enqueue_shop_manager_scripts');
?>