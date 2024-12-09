<?php
// Register Shortcode
function jotun_shop_creation_shortcode() {
    // Enqueue styles and scripts
    wp_enqueue_style('jotun-shop-styles', plugin_dir_url(__FILE__) . 'assets/css/shop-creation.css');
    wp_enqueue_script('jotun-shop-script', plugin_dir_url(__FILE__) . 'assets/js/shop-creation.js', array('jquery'), null, true);

    // Localize script for AJAX calls
    wp_localize_script('jotun-shop-script', 'jotunShopData', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'api_nonce' => wp_create_nonce('jotun_api_nonce'),
    ));

    // Output the UI container
    ob_start();
    ?>
    <div id="shop-creation-ui">
        <!-- Content populated by JavaScript -->
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('jotun_shop_creation', 'jotun_shop_creation_shortcode');
