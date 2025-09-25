<?php
// itemlist-quick-add-interface.php
// Modern inline interface for adding new items to the master itemlist

// Prevent direct access
if (!defined('ABSPATH')) exit;

// Function to render the quick add item modal interface
function jotunheim_quick_add_item_modal() {
    ob_start();
    ?>
    <!-- Quick Add Item Modal -->
    <div id="quick-add-item-modal" class="quick-add-modal" style="display: none;">
        <div class="quick-add-overlay"></div>
        <div class="quick-add-content">
            <div class="quick-add-header">
                <h3>Add New Item to Master List</h3>
                <button id="quick-add-close" class="quick-add-close">&times;</button>
            </div>
            
            <div class="quick-add-body">
                <p class="quick-add-intro">
                    This item doesn't exist in the master item list. Add it now to complete your transaction.
                </p>
                
                <form id="quick-add-item-form" class="quick-add-form">
                    <?php wp_nonce_field('quick_add_item_nonce', 'quick_add_nonce'); ?>
                    
                    <!-- Pre-filled item name -->
                    <div class="form-group">
                        <label for="quick-item-name">Item Name:</label>
                        <input type="text" id="quick-item-name" name="item_name" readonly class="form-control readonly">
                    </div>
                    
                    <!-- Item Type -->
                    <div class="form-group">
                        <label for="quick-item-type">Item Type:</label>
                        <select id="quick-item-type" name="item_type" class="form-control" required>
                            <option value="">Select Type...</option>
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
                            <option value="Trophies" selected>Trophies</option>
                            <option value="Crafting Components">Crafting Components</option>
                        </select>
                    </div>
                    
                    <!-- Tech Level -->
                    <div class="form-group">
                        <label for="quick-tech-name">Tech Level:</label>
                        <select id="quick-tech-name" name="tech_name" class="form-control">
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
                    </div>
                    
                    <!-- Stack Size -->
                    <div class="form-group">
                        <label for="quick-stack-size">Stack Size:</label>
                        <input type="number" id="quick-stack-size" name="stack_size" value="1" min="1" max="999" class="form-control">
                    </div>
                    
                    <!-- Unit Price -->
                    <div class="form-group">
                        <label for="quick-unit-price">Unit Price:</label>
                        <input type="number" id="quick-unit-price" name="unit_price" value="0.00" step="0.01" min="0" class="form-control">
                    </div>
                    
                    <!-- Can Be Undercut -->
                    <div class="form-group checkbox-group">
                        <label for="quick-undercut" class="checkbox-label">
                            <input type="checkbox" id="quick-undercut" name="undercut" value="1">
                            Can Be Undercut
                        </label>
                    </div>
                    
                    <!-- Prefab Name (Optional) -->
                    <div class="form-group">
                        <label for="quick-prefab-name">Prefab Name (Optional):</label>
                        <input type="text" id="quick-prefab-name" name="prefab_name" class="form-control">
                    </div>
                </form>
            </div>
            
            <div class="quick-add-footer">
                <button type="button" id="quick-add-cancel" class="btn btn-secondary">Cancel Transaction</button>
                <button type="button" id="quick-add-submit" class="btn btn-primary">Add Item & Continue</button>
            </div>
        </div>
    </div>

    <style>
    /* Quick Add Item Modal Styles */
    .quick-add-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 10001;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .quick-add-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(2px);
    }
    
    .quick-add-content {
        position: relative;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        width: 90%;
        max-width: 500px;
        max-height: 80vh;
        overflow: hidden;
        animation: quickAddSlideIn 0.3s ease-out;
    }
    
    @keyframes quickAddSlideIn {
        0% {
            opacity: 0;
            transform: scale(0.9) translateY(-20px);
        }
        100% {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }
    
    .quick-add-header {
        background: var(--primary-blue, #1e40af);
        color: white;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .quick-add-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }
    
    .quick-add-close {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background-color 0.2s;
    }
    
    .quick-add-close:hover {
        background: rgba(255,255,255,0.2);
    }
    
    .quick-add-body {
        padding: 20px;
        max-height: 60vh;
        overflow-y: auto;
    }
    
    .quick-add-intro {
        background: #f8f9fa;
        border-left: 4px solid var(--accent-amber, #f59e0b);
        padding: 12px 16px;
        margin: 0 0 20px 0;
        font-size: 14px;
        color: #374151;
        border-radius: 0 6px 6px 0;
    }
    
    .quick-add-form {
        display: grid;
        gap: 16px;
    }
    
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    
    .form-group label {
        font-weight: 600;
        color: #374151;
        font-size: 14px;
    }
    
    .form-control {
        padding: 10px 12px;
        border: 2px solid #d1d5db;
        border-radius: 6px;
        font-size: 14px;
        transition: border-color 0.2s;
        font-family: inherit;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary-blue, #1e40af);
        box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
    }
    
    .form-control.readonly {
        background: #f9fafb;
        color: #6b7280;
        cursor: not-allowed;
    }
    
    .checkbox-group {
        flex-direction: row;
        align-items: center;
        gap: 8px;
    }
    
    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        font-weight: 500;
        margin: 0;
    }
    
    .checkbox-label input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: var(--primary-blue, #1e40af);
    }
    
    .quick-add-footer {
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
        padding: 16px 20px;
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }
    
    .btn {
        padding: 10px 20px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-secondary {
        background: #6b7280;
        color: white;
    }
    
    .btn-secondary:hover {
        background: #4b5563;
    }
    
    .btn-primary {
        background: var(--primary-blue, #1e40af);
        color: white;
    }
    
    .btn-primary:hover {
        background: var(--primary-blue-dark, #1e3a8a);
    }
    
    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    </style>
    <?php
    return ob_get_clean();
}

// AJAX handler for quick add item
function handle_quick_add_item() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'quick_add_item_nonce')) {
        wp_send_json_error('Invalid nonce verification.');
        return;
    }

    // Check permissions
    if (!current_user_can('edit_posts')) {
        wp_send_json_error('You do not have permission to add items.');
        return;
    }

    global $wpdb;
    $table_name = 'jotun_itemlist';

    // Validate required fields
    if (empty($_POST['item_name']) || empty($_POST['item_type'])) {
        wp_send_json_error('Item name and type are required.');
        return;
    }

    // Check if item already exists
    $existing_item = $wpdb->get_row($wpdb->prepare(
        "SELECT id FROM $table_name WHERE item_name = %s",
        sanitize_text_field($_POST['item_name'])
    ));

    if ($existing_item) {
        wp_send_json_success([
            'message' => 'Item already exists in master list.',
            'item_id' => $existing_item->id,
            'item_name' => sanitize_text_field($_POST['item_name'])
        ]);
        return;
    }

    // Insert new item
    $result = $wpdb->insert(
        $table_name,
        [
            'item_name' => sanitize_text_field($_POST['item_name']),
            'tech_name' => sanitize_text_field($_POST['tech_name'] ?? 'N/A'),
            'item_type' => sanitize_text_field($_POST['item_type']),
            'stack_size' => intval($_POST['stack_size'] ?? 1),
            'undercut' => isset($_POST['undercut']) ? 1 : 0,
            'unit_price' => floatval($_POST['unit_price'] ?? 0),
            'lv2_price' => floatval($_POST['lv2_price'] ?? 0),
            'lv3_price' => floatval($_POST['lv3_price'] ?? 0),
            'lv4_price' => floatval($_POST['lv4_price'] ?? 0),
            'lv5_price' => floatval($_POST['lv5_price'] ?? 0),
            'prefab_name' => sanitize_text_field($_POST['prefab_name'] ?? ''),
            'is_custom' => 1,
            'created_date' => current_time('mysql'),
            'description' => 'Added via quick-add during transaction'
        ]
    );

    if ($result === false) {
        error_log('Quick add item failed: ' . $wpdb->last_error);
        wp_send_json_error('Failed to add item: ' . $wpdb->last_error);
        return;
    }

    wp_send_json_success([
        'message' => 'Item added successfully to master list.',
        'item_id' => $wpdb->insert_id,
        'item_name' => sanitize_text_field($_POST['item_name'])
    ]);
}

// Register AJAX handlers
add_action('wp_ajax_quick_add_item', 'handle_quick_add_item');
add_action('wp_ajax_nopriv_quick_add_item', 'handle_quick_add_item');

// Function to include the modal in teller interfaces
function include_quick_add_item_modal() {
    return jotunheim_quick_add_item_modal();
}
?>