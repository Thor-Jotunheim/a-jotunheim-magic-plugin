<?php
// File: includes/PriceList/pricelist.php

// Prevent direct access
if (!defined('ABSPATH')) exit;

// Enqueue pricelist.css
function enqueue_pricelist_styles() {
    // Adjust the CSS path to account for new directory structure
    wp_enqueue_style('pricelist-css', plugin_dir_url(__FILE__) . '../../assets/css/pricelist.css');
}
add_action('wp_enqueue_scripts', 'enqueue_pricelist_styles');

global $wpdb;
$table_name = 'jotun_itemlist';

// Get all item types for Sections
$item_types_section1 = $wpdb->get_col("SELECT DISTINCT item_type FROM $table_name WHERE item_type = 'Untradable'");
$item_types_section2 = $wpdb->get_col("SELECT DISTINCT item_type FROM $table_name WHERE undercut = 0 AND item_type != 'Untradable'");
$item_types_section3 = $wpdb->get_col("SELECT DISTINCT item_type FROM $table_name WHERE undercut = 1 AND item_type != 'Untradable'");

// Function to generate shortcode for Section 1 items
function section1_items_shortcode() {
    global $wpdb;
    $table_name = 'jotun_itemlist';

    $items = $wpdb->get_results("SELECT item_name FROM $table_name WHERE item_type = 'Untradable'");

    ob_start();
    echo '<div class="section1-items">';
    echo '<div class="item-grid">';
    foreach ($items as $item) {
        echo '<div class="item-box">' . esc_html($item->item_name) . '</div>';
    }
    echo '</div></div>';

    return ob_get_clean();
}
add_shortcode('section1_items', 'section1_items_shortcode');

// Function to generate shortcode for Section 2 items
function section2_items_shortcode() {
    global $wpdb;
    $table_name = 'jotun_itemlist';

    $items = $wpdb->get_results("SELECT item_name, item_type, unit_price, lv2_price, lv3_price, lv4_price, lv5_price FROM $table_name WHERE undercut = 0 AND item_type != 'Untradable' ORDER BY tech_tier");

    $types = [];
    foreach ($items as $item) {
        $types[$item->item_type][] = $item;
    }

    ob_start();

    echo '<div class="section2-items-container">';
    foreach ($types as $type => $items) {
        echo '<div class="section2-items">';
        echo '<h2>' . esc_html($type) . '</h2>';
        echo '<div class="tabs">';
        $tiers = [
            'Tier 1' => 'unit_price',
            'Tier 2' => 'lv2_price',
            'Tier 3' => 'lv3_price',
            'Tier 4' => 'lv4_price',
            'Tier 5' => 'lv5_price'
        ];
        foreach ($tiers as $tier_name => $tier_column) {
            $show_tier = false;
            foreach ($items as $item) {
                if ($item->$tier_column > 0) {
                    $show_tier = true;
                    break;
                }
            }
            if ($show_tier) {
                echo '<button class="tier-tab" onclick="showTier(event, \'' . esc_attr($type . '-' . $tier_name) . '\')">' . esc_html($tier_name) . '</button>';
            }
        }
        echo '</div>';

        foreach ($tiers as $tier_name => $tier_column) {
            echo '<div id="' . esc_attr($type . '-' . $tier_name) . '" class="tier-content" style="display: ' . ($tier_name === 'Tier 1' ? 'block' : 'none') . ';">';
            echo '<div class="item-grid">';
            foreach ($items as $item) {
                if ($item->$tier_column > 0) {
                    echo '<div class="item-box">';
                    echo '<span>' . esc_html($item->item_name) . '</span><br>';
                    echo '<span>' . esc_html($item->$tier_column) . ' g</span>';
                    echo '</div>';
                }
            }
            echo '</div></div>';
        }
        echo '</div>';
    }
    echo '</div>';

    // Inline JavaScript for the tab functionality
    echo '<script>
    function showTier(evt, tierName) {
        var parentContainer = evt.currentTarget.closest(".section2-items, .section3-items");
        var tierContent = parentContainer.getElementsByClassName("tier-content");
        for (var i = 0; i < tierContent.length; i++) {
            tierContent[i].style.display = "none";
        }
        var tierTabs = parentContainer.getElementsByClassName("tier-tab");
        for (var i = 0; i < tierTabs.length; i++) {
            tierTabs[i].classList.remove("active");
        }
        document.getElementById(tierName).style.display = "block";
        evt.currentTarget.classList.add("active");
    }
    </script>';

    return ob_get_clean();
}
add_shortcode('section2_items', 'section2_items_shortcode');

// Function to generate shortcode for Section 3 items
function section3_items_shortcode() {
    global $wpdb;
    $table_name = 'jotun_itemlist';

    $items = $wpdb->get_results("SELECT item_name, item_type, unit_price, lv2_price, lv3_price, lv4_price, lv5_price FROM $table_name WHERE undercut = 1 AND item_type != 'Untradable' ORDER BY tech_tier");

    $types = [];
    foreach ($items as $item) {
        $types[$item->item_type][] = $item;
    }

    ob_start();

    echo '<div class="section3-items-container">';
    foreach ($types as $type => $items) {
        echo '<div class="section3-items">';
        echo '<h2>' . esc_html($type) . '</h2>';
        echo '<div class="tabs">';
        $tiers = [
            'Tier 1' => 'unit_price',
            'Tier 2' => 'lv2_price',
            'Tier 3' => 'lv3_price',
            'Tier 4' => 'lv4_price',
            'Tier 5' => 'lv5_price'
        ];
        foreach ($tiers as $tier_name => $tier_column) {
            $show_tier = false;
            foreach ($items as $item) {
                if ($item->$tier_column > 0) {
                    $show_tier = true;
                    break;
                }
            }
            if ($show_tier) {
                echo '<button class="tier-tab" onclick="showTier(event, \'' . esc_attr($type . '-' . $tier_name) . '\')">' . esc_html($tier_name) . '</button>';
            }
        }
        echo '</div>';

        foreach ($tiers as $tier_name => $tier_column) {
            echo '<div id="' . esc_attr($type . '-' . $tier_name) . '" class="tier-content" style="display: ' . ($tier_name === 'Tier 1' ? 'block' : 'none') . ';">';
            echo '<div class="item-grid">';
            foreach ($items as $item) {
                if ($item->$tier_column > 0) {
                    echo '<div class="item-box">';
                    echo '<span>' . esc_html($item->item_name) . '</span><br>';
                    echo '<span>' . esc_html($item->$tier_column) . ' g</span>';
                    echo '</div>';
                }
            }
            echo '</div></div>';
        }
        echo '</div>';
    }
    echo '</div>';

    return ob_get_clean();
}
add_shortcode('section3_items', 'section3_items_shortcode');