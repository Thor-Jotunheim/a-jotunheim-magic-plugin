<?php
// itemlist-add-new-item-interface.php

// Function to display the "Add New Item" interface
function jotunheim_magic_add_new_item_interface() {
    ob_start();
    ?>
    <div class="single-edit-section" style="margin-bottom: 40px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background: rgba(255, 255, 255, 0.8);">
        <h4 style="font-family: 'Roboto', sans-serif; font-weight: 700; color: #444;">Adding New Item</h4>
        <form class="item-details-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; align-items: center;">
            <input type="hidden" name="action" value="add_jotunheim_item">
            <?php wp_nonce_field('add_jotunheim_item_nonce', 'jotunheim_nonce'); ?>

            <!-- Item Name Field -->
            <label for="item-name" style="font-weight: bold;">Item Name:</label>
            <input type="text" name="item_name" value="" style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666;">

            <!-- Tech Name Field -->
            <label for="tech-name" style="font-weight: bold;">Tech Name:</label>
            <select name="tech_name" style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666;">
                <option value="N/A" selected>N/A</option>
                <option value="Meadow">Meadow</option>
                <option value="Forest">Forest</option>
                <option value="Ocean">Ocean</option>
                <option value="Swamp">Swamp</option>
                <option value="Mountain">Mountain</option>
                <option value="Plains">Plains</option>
                <option value="Mistlands">Mistlands</option>
                <option value="Ashlands">Ashlands</option>
                <option value="Deep North">Deep North</option>
            </select>

            <!-- Item Type Field -->
            <label for="item-type" style="font-weight: bold;">Item Type:</label>
            <select name="item_type" style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666;">
                <option value="Currency">Currency</option>
                <option value="Untradable">Untradable</option>
                <option value="Raw Food">Raw Food</option>
                <option value="Cooked Food">Cooked Food</option>
                <option value="Fish">Fish</option>
                <option value="Seeds">Seeds</option>
                <option value="Bait">Bait</option>
                <option value="Mead">Mead</option>
                <option value="Building & Crafting">Building & Crafting</option>
                <option value="Boss Summons">Boss Summons</option>
                <option value="Tamed Animals">Tamed Animals</option>
                <option value="Armor Sets">Armor Sets</option>
                <option value="Armor">Armor</option>
                <option value="Ammunition">Ammunition</option>
                <option value="Weapons">Weapons</option>
                <option value="Tools">Tools</option>
                <option value="Shields">Shields</option>
                <option value="Trophies">Trophies</option>
                <option value="Crafting Components">Crafting Components</option>
            </select>

            <!-- Stack Size Field -->
            <label for="stack-size" style="font-weight: bold;">Stack Size:</label>
            <input type="number" name="stack_size" value="" style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666;">

            <!-- Can Be Undercut Field -->
            <label for="undercut" style="font-weight: bold;">Can Be Undercut:</label>
            <input type="checkbox" name="undercut" style="transform: scale(1.8); margin-top: 5px;">

            <!-- Unit Price Field -->
            <label for="unit-price" style="font-weight: bold;">Unit Price:</label>
            <input type="number" step="0.01" name="unit_price" value="" style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666;">

            <!-- Lv 2 Price Field -->
            <label for="lv2-price" style="font-weight: bold;">Lv 2 Price:</label>
            <input type="number" step="0.01" name="lv2_price" value="" style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666;">

            <!-- Lv 3 Price Field -->
            <label for="lv3-price" style="font-weight: bold;">Lv 3 Price:</label>
            <input type="number" step="0.01" name="lv3_price" value="" style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666;">

            <!-- Lv 4 Price Field -->
            <label for="lv4-price" style="font-weight: bold;">Lv 4 Price:</label>
            <input type="number" step="0.01" name="lv4_price" value="" style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666;">

            <!-- Lv 5 Price Field -->
            <label for="lv5-price" style="font-weight: bold;">Lv 5 Price:</label>
            <input type="number" step="0.01" name="lv5_price" value="" style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666;">

            <!-- Prefab Name Field -->
            <label for="prefab-name" style="font-weight: bold;">Prefab Name:</label>
            <input type="text" name="prefab_name" value="" style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666;">

            <!-- Submit Button -->
            <input type="submit" name="submit" value="Add Item" style="grid-column: span 2; padding: 10px; background-color: #0073aa; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
        </form>
    </div>
    <?php
    return ob_get_clean();
}

// Shortcode to display the "Add New Item" form
add_shortcode('jotunheim_add_new_item', 'jotunheim_magic_add_new_item_interface');

// Handle form submission
function jotunheim_magic_handle_add_item() {
    // Verify nonce
    if (!isset($_POST['jotunheim_nonce']) || !wp_verify_nonce($_POST['jotunheim_nonce'], 'add_jotunheim_item_nonce')) {
        wp_die('Invalid nonce verification.');
    }

    // Check editor permissions
    if (!current_user_can('update_itemlist')) {
        wp_die('You do not have permission to add items.');
    }

    global $wpdb;
    $table_name = 'jotun_itemlist';

    // Ensure the correct table exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        error_log('Database table does not exist: ' . $table_name);
        wp_die('Database table does not exist. Please ensure the table is created.');
    }

    // Insert data into the table
    $result = $wpdb->insert(
        $table_name,
        array(
            'item_name' => sanitize_text_field($_POST['item_name']),
            'tech_name' => sanitize_text_field($_POST['tech_name']),
            'item_type' => sanitize_text_field($_POST['item_type']),
            'stack_size' => intval($_POST['stack_size']),
            'undercut' => isset($_POST['undercut']) ? 1 : 0,
            'unit_price' => floatval($_POST['unit_price']),
            'lv2_price' => floatval($_POST['lv2_price']),
            'lv3_price' => floatval($_POST['lv3_price']),
            'lv4_price' => floatval($_POST['lv4_price']),
            'lv5_price' => floatval($_POST['lv5_price']),
            'prefab_name' => sanitize_text_field($_POST['prefab_name'])
        )
    );

    if ($result) {
        error_log('New item added successfully.');
        wp_redirect(add_query_arg('message', 'success', wp_get_referer()));
    } else {
        error_log('Failed to add new item: ' . $wpdb->last_error);
        wp_redirect(add_query_arg('message', 'error', wp_get_referer()));
    }
    exit;
}

// Hooks to handle form submission
add_action('admin_post_nopriv_add_jotunheim_item', 'jotunheim_magic_handle_add_item');
add_action('admin_post_add_jotunheim_item', 'jotunheim_magic_handle_add_item');
?>