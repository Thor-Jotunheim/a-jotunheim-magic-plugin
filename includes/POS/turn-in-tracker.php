<?php
// File: includes/POS/turn-in-tracker.php

// Prevent direct access
if (!defined('ABSPATH')) exit;

class TurnInTracker {
    
    public function __construct() {
        add_action('init', array($this, 'register_shortcodes'));
        add_action('wp_ajax_reset_turn_in_progress', array($this, 'ajax_reset_turn_in_progress'));
        add_action('wp_ajax_nopriv_reset_turn_in_progress', array($this, 'ajax_reset_turn_in_progress'));
    }
    
    public function register_shortcodes() {
        add_shortcode('turn_in_progress', array($this, 'display_turn_in_progress'));
    }
    
    /**
     * Generate shortcode for a turn-in shop
     */
    public static function generate_shortcode_for_shop($shop_id) {
        global $wpdb;
        
        // Get shop details
        $shop = $wpdb->get_row($wpdb->prepare(
            "SELECT shop_name, shop_type FROM jotun_shops WHERE shop_id = %d",
            $shop_id
        ));
        
        if (!$shop || $shop->shop_type !== 'turn-in_only') {
            return false;
        }
        
        // Generate clean shortcode name from shop name
        $shortcode_name = sanitize_title($shop->shop_name);
        $shortcode_name = str_replace('-', '_', $shortcode_name);
        
        return "[turn_in_progress shop_id=\"{$shop_id}\" shop_name=\"{$shortcode_name}\"]";
    }
    
    /**
     * Display turn-in progress for a specific shop
     */
    public function display_turn_in_progress($atts) {
        $atts = shortcode_atts(array(
            'shop_id' => '',
            'shop_name' => '',
            'show_completed' => 'true'
        ), $atts);
        
        if (empty($atts['shop_id'])) {
            return '<p>Error: No shop ID specified</p>';
        }
        
        global $wpdb;
        
        // Get shop details and items
        $shop = $wpdb->get_row($wpdb->prepare(
            "SELECT shop_name, shop_type FROM jotun_shops WHERE shop_id = %d",
            $atts['shop_id']
        ));
        
        if (!$shop || $shop->shop_type !== 'turn-in_only') {
            return '<p>Error: Invalid turn-in shop</p>';
        }
        
        // Get turn-in items for this shop
        $items = $wpdb->get_results($wpdb->prepare("
            SELECT si.*, ml.item_name as master_item_name
            FROM jotun_shop_items si
            LEFT JOIN jotun_itemlist ml ON si.item_id = ml.id
            WHERE si.shop_id = %d 
            AND si.turn_in = 1 
            AND si.turn_in_requirement > 0
            ORDER BY ml.item_name ASC
        ", $atts['shop_id']));
        
        if (empty($items)) {
            return '<p>No turn-in items found for this shop.</p>';
        }
        
        // Enqueue styles and scripts
        wp_enqueue_style('turn-in-tracker', plugin_dir_url(__FILE__) . '../../assets/css/turn-in-tracker.css', array(), '1.0.0');
        wp_enqueue_script('turn-in-tracker', plugin_dir_url(__FILE__) . '../../assets/js/turn-in-tracker.js', array('jquery'), '1.0.0', true);
        
        // Localize script for AJAX
        wp_localize_script('turn-in-tracker', 'turnInTracker', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('turn_in_tracker_nonce'),
            'shop_id' => $atts['shop_id']
        ));
        
        ob_start();
        ?>
        <div class="turn-in-tracker" data-shop-id="<?php echo esc_attr($atts['shop_id']); ?>">
            <div class="tracker-header">
                <h3><?php echo esc_html($shop->shop_name); ?> - Turn-In Progress</h3>
            </div>
            
            <div class="turn-in-items">
                <?php foreach ($items as $item): 
                    $item_name = $item->master_item_name ?: $item->item_name;
                    $progress = intval($item->turn_in_quantity);
                    $goal = intval($item->turn_in_requirement);
                    $percentage = $goal > 0 ? min(100, ($progress / $goal) * 100) : 0;
                    $is_completed = $progress >= $goal;
                    
                    if (!$atts['show_completed'] && $is_completed) continue;
                ?>
                    <div class="turn-in-item <?php echo $is_completed ? 'completed' : ''; ?>">
                        <div class="item-info">
                            <span class="item-name"><?php echo esc_html($item_name); ?></span>
                            <span class="progress-text"><?php echo $progress; ?> / <?php echo $goal; ?></span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?php echo $percentage; ?>%"></div>
                        </div>
                        <?php if ($is_completed): ?>
                            <span class="completion-badge">✓ Complete</span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    /**
     * AJAX handler to reset turn-in progress
     */
    public function ajax_reset_turn_in_progress() {
        // Accept both shop manager nonce and turn-in tracker nonce
        $nonce_valid = false;
        if (wp_verify_nonce($_POST['nonce'] ?? '', 'shop_manager_nonce')) {
            $nonce_valid = true;
        } elseif (wp_verify_nonce($_POST['nonce'] ?? '', 'turn_in_tracker_nonce')) {
            $nonce_valid = true;
        }
        
        if (!$nonce_valid) {
            wp_die('Invalid nonce');
        }
        
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $shop_id = intval($_POST['shop_id']);
        
        if (!$shop_id) {
            wp_send_json_error('Invalid shop ID');
            return;
        }
        
        global $wpdb;
        
        // Reset all turn-in quantities for this shop
        $result = $wpdb->update(
            "jotun_shop_items",
            array('turn_in_quantity' => 0),
            array('shop_id' => $shop_id, 'turn_in' => 1),
            array('%d'),
            array('%d', '%d')
        );
        
        if ($result !== false) {
            wp_send_json_success(array(
                'message' => 'Turn-in progress reset successfully',
                'reset_count' => $result
            ));
        } else {
            wp_send_json_error('Failed to reset progress');
        }
    }
}

// Initialize the turn-in tracker
new TurnInTracker();
?>