<?php
// popup-shop.php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Enqueue additional scripts and styles specific to Popup Shop if necessary
function jotunheim_magic_popup_shop_enqueue() {
    // Example: Enqueue scripts specific to the Popup Shop
    // wp_enqueue_script('popup-shop-specific-js', plugin_dir_url(__FILE__) . 'assets/js/popup-shop-specific.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'jotunheim_magic_popup_shop_enqueue');

// Function to display the Popup Shop interface
function popup_shop_interface() {
    ?>
    <div class="wrap">
        <h1>Popup Shop</h1>
        <div class="shop-section">
            <div class="player-section">Player</div>
            <div class="player-input-container">
                <input type="text" id="player" class="player-input" placeholder="Enter player name">
                <button id="register-player-btn">Register New Player</button>
            </div>
            <div class="ymir-gold-container">
                <label for="ymir-flesh">Ymir Flesh:</label>
                <input type="number" id="ymir-flesh" placeholder="Enter Ymir Flesh amount">
                <label for="gold">Gold:</label>
                <input type="number" id="gold" placeholder="Enter Gold amount">
                <button id="save-shop-btn">Save</button>
            </div>
            <div class="status-box"></div>
        </div>
    </div>
    <?php
}

// Handle AJAX registration of a new player
function register_player() {
    global $wpdb;
    $player_name = sanitize_text_field($_POST['player_name']);

    $table_name = $wpdb->prefix . 'popup_shop_players'; // Adjust to match your actual table name
    $wpdb->insert($table_name, array('name' => $player_name));

    if ($wpdb->insert_id) {
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
}
add_action('wp_ajax_register_player', 'register_player');

// Handle AJAX saving of Ymir Flesh and Gold values
function save_shop_data() {
    // Placeholder for handling Ymir Flesh and Gold saving logic
    // Here you would typically save these values to the appropriate database table

    wp_send_json_success(); // Return success if the data is saved successfully
}
add_action('wp_ajax_save_shop_data', 'save_shop_data');