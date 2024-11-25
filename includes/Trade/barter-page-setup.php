<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

// Shortcode function to output Barter Page HTML
function jotunheim_barter_page_shortcode() {
    // Start output buffering
    ob_start();
    include plugin_dir_path(__FILE__) . 'barter-page.html';
    return ob_get_clean();
}

// Shortcode function to output Barter Page HTML
function jotunheim_barter_page_half_screenshortcode() {
    // Start output buffering
    ob_start();
    include plugin_dir_path(__FILE__) . 'barter-page-half-screen.html';
    return ob_get_clean();
}

// Register Barter Page shortcode
add_shortcode('jotunheim_barter_page', 'jotunheim_barter_page_shortcode');
add_shortcode('jotunheim_barter_page_half_screen', 'jotunheim_barter_page_half_screenshortcode');

// Conditionally enqueue the JavaScript file for the Barter Page
function jotunheim_enqueue_barter_scripts() {
    global $post;

    // Check if the Barter Page shortcode is used in the content
    if (isset($post->post_content) && has_shortcode($post->post_content, 'jotunheim_barter_page')) {
        wp_enqueue_script(
            'jotunheim-barter-script',
            plugin_dir_url(__FILE__) . 'barter-interface.js',
            array(),
            null,
            true
        );

        // Localize script to pass the API URL to the JavaScript file
        wp_localize_script('jotunheim-barter-script', 'jotunheimApi', array(
            'apiUrl' => rest_url('jotunheim-magic/v1/items'),
        ));
    }
}
add_action('wp_enqueue_scripts', 'jotunheim_enqueue_barter_scripts');

// Search Bar Shortcode (Handles both search bar and sidebar accordion)
function render_search_bar_with_sidebar($atts) {
    $atts = shortcode_atts([
        'id' => 'item-search', // ID of the search bar
        'placeholder' => 'Search items...', // Placeholder for the search bar
        'target' => 'item-list-accordion', // ID of the accordion target
        'accordion_id' => 'item-list-accordion', // ID of the accordion div
    ], $atts);

    // Render the search bar and the accordion container
    return '
        <div class="item-list-sidebar-container">
            <input type="text" id="' . esc_attr($atts['id']) . '" class="search-bar" 
                placeholder="' . esc_attr($atts['placeholder']) . '" 
                oninput="filterItems(\'' . esc_attr($atts['target']) . '\')">
            <div class="item-list-sidebar" id="' . esc_attr($atts['accordion_id']) . '">
                <!-- JavaScript will populate this accordion dynamically -->
            </div>
        </div>';
}

// Register the shortcode
add_shortcode('search_bar_with_sidebar', 'render_search_bar_with_sidebar');

// Selected Items Container Shortcode
function render_selected_items_container($atts) {
    $atts = shortcode_atts([
        'id' => 'selected-items-container',
        'background' => '/wp-content/uploads/Jotunheim-magic/icons/container-background.png'
    ], $atts);

    return '<div id="' . esc_attr($atts['id']) . '" class="selected-items-panel" style="background: url(' . esc_url($atts['background']) . ') no-repeat center center; background-size: contain;">
                <!-- Items will be added dynamically via JavaScript -->
            </div>';
}
add_shortcode('selected_items_container', 'render_selected_items_container');

// Calculation Panel Shortcode
function render_calculation_panel() {
    return '<div class="calculation-panel">
                <div class="trader-total trader1-total">
                    <div>Total for Trader 1:</div>
                    <div><span id="trader1-total-display">
                        <div style="text-align: center;">
                            Coins<br>
                            <small>or</small><br>
                            Ymir Flesh & Coins
                        </div>
                    </span></div>
                </div>
                <div class="trade-difference">
                    <div>Trade Difference:</div>
                    <div><span id="trade-difference">
                        <div style="text-align: center;">
                            Coins<br>
                            <small>or</small><br>
                            Ymir Flesh & Coins
                        </div>
                    </span></div>
                </div>
                <div class="trader-total trader2-total">
                    <div>Total for Trader 2:</div>
                    <div><span id="trader2-total-display">
                        <div style="text-align: center;">
                            Coins<br>
                            <small>or</small><br>
                            Ymir Flesh & Coins
                        </div>
                    </span></div>
                </div>
            </div>';
}
add_shortcode('calculation_panel', 'render_calculation_panel');