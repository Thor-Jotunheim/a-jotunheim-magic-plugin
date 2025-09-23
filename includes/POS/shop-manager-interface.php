<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render the Shop Manager interface
 */
function shop_manager_interface() {
    if (!is_user_logged_in()) {
        return do_shortcode('[discord_login_button]');
    }

    if (!current_user_can('edit_posts')) {
        return '<div class="shop-manager-error">You do not have permission to access the Shop Manager.</div>';
    }

    ob_start();
    ?>
    <div id="shop-manager-interface" class="shop-manager-container">
        <h1>Shop Manager</h1>
        
        <!-- Tab Navigation -->
        <div class="shop-manager-tabs">
            <button class="shop-tab-button active" data-tab="shops">Shop Management</button>
            <button class="shop-tab-button" data-tab="items">Shop Items</button>
        </div>

        <!-- Shop Management Tab -->
        <div id="shops-tab" class="shop-tab-content active">
            <div class="shop-management-section">
                <h2>Shop Management</h2>
                
                <!-- Add New Shop -->
                <div class="add-shop-section">
                    <h3>Add New Shop</h3>
                    <form id="add-shop-form" class="shop-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="shop-name">Shop Name *</label>
                                <input type="text" id="shop-name" name="shop_name" required>
                            </div>
                            <div class="form-group">
                                <label for="shop-type">Shop Type</label>
                                <select id="shop-type" name="shop_type">
                                    <option value="player">Player Shop</option>
                                    <option value="staff">Staff Shop</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="shop-status">Status</label>
                                <select id="shop-status" name="is_active">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Add Shop</button>
                            <button type="button" id="cancel-edit-shop" class="btn btn-secondary" style="display: none;">Cancel Edit</button>
                        </div>
                    </form>
                </div>

                <!-- Shop List -->
                <div class="shop-list-section">
                    <h3>Existing Shops</h3>
                    <div class="shop-filters">
                        <select id="shop-type-filter">
                            <option value="">All Shop Types</option>
                            <option value="player">Player Shops</option>
                            <option value="staff">Staff Shops</option>
                        </select>
                        <input type="text" id="shop-search" placeholder="Search shops...">
                    </div>
                    <div id="shops-table-container">
                        <table id="shops-table" class="shop-table">
                            <thead>
                                <tr>
                                    <th>Shop Name</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="shops-table-body">
                                <!-- Shops will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shop Items Tab -->
        <div id="items-tab" class="shop-tab-content">
            <div class="shop-items-section">
                <h2>Shop Items Management</h2>
                
                <!-- Shop Selection -->
                <div class="shop-selection">
                    <h3>Select Shop</h3>
                    <select id="items-shop-selector">
                        <option value="">Select a shop...</option>
                        <!-- Shops will be loaded here -->
                    </select>
                </div>

                <!-- Add Items to Shop -->
                <div id="add-item-section" class="add-item-section" style="display: none;">
                    <h3>Add Items to Shop</h3>
                    <form id="add-shop-item-form" class="shop-item-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="item-selector">Select Item from Master List</label>
                                <select id="item-selector" name="item_id">
                                    <option value="">Select an item...</option>
                                    <!-- Items from jotun_itemlist will be loaded here -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="custom-price">Custom Price (optional)</label>
                                <input type="number" id="custom-price" name="custom_price" step="0.01" placeholder="Leave empty for default price">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="stock-quantity">Stock Quantity</label>
                                <input type="number" id="stock-quantity" name="stock_quantity" value="0" min="0">
                            </div>
                            <div class="form-group">
                                <label for="item-available">Available</label>
                                <select id="item-available" name="is_available">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Add Item to Shop</button>
                        </div>
                    </form>
                </div>

                <!-- Shop Items List -->
                <div id="shop-items-list" class="shop-items-list" style="display: none;">
                    <h3>Items in Selected Shop</h3>
                    <div id="shop-items-table-container">
                        <table id="shop-items-table" class="shop-table">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Default Price</th>
                                    <th>Shop Price</th>
                                    <th>Stock</th>
                                    <th>Available</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="shop-items-table-body">
                                <!-- Shop items will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Messages -->
    <div id="shop-manager-status" class="status-message" style="display: none;"></div>

    <!-- Edit Shop Modal -->
    <div id="edit-shop-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Shop</h3>
                <span class="close" onclick="closeEditShopModal()">&times;</span>
            </div>
            <div class="modal-body">
                <form id="edit-shop-form">
                    <input type="hidden" id="edit-shop-id" name="shop_id">
                    <div class="form-group">
                        <label for="edit-shop-name">Shop Name *</label>
                        <input type="text" id="edit-shop-name" name="shop_name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-shop-type">Shop Type</label>
                        <select id="edit-shop-type" name="shop_type">
                            <option value="player">Player Shop</option>
                            <option value="staff">Staff Shop</option>
                        </select>
                    </div>
                    <div class="form-group">
                    <div class="form-group">
                        <label for="edit-shop-active">Status</label>
                        <select id="edit-shop-active" name="is_active">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="saveShopEdit()">Save Changes</button>
                <button type="button" class="btn btn-secondary" onclick="closeEditShopModal()">Cancel</button>
            </div>
        </div>
    </div>

    <style>
    .shop-manager-container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .shop-manager-tabs {
        border-bottom: 2px solid #e1e1e1;
        margin-bottom: 20px;
    }

    .shop-tab-button {
        background: none;
        border: none;
        padding: 12px 24px;
        cursor: pointer;
        border-bottom: 3px solid transparent;
        font-weight: 500;
    }

    .shop-tab-button.active {
        border-bottom-color: #0073aa;
        color: #0073aa;
    }

    .shop-tab-content {
        display: none;
    }

    .shop-tab-content.active {
        display: block;
    }

    .shop-form, .shop-item-form {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 15px;
    }

    .form-group {
        flex: 1;
    }

    .form-group label {
        display: block;
        font-weight: 500;
        margin-bottom: 5px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .shop-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    .shop-table th,
    .shop-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #e1e1e1;
    }

    .shop-table th {
        background: #f8f9fa;
        font-weight: 600;
    }

    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        margin-right: 10px;
    }

    .btn-primary {
        background: #0073aa;
        color: white;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-sm {
        padding: 4px 8px;
        font-size: 12px;
    }

    .shop-filters {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
    }

    .shop-filters input,
    .shop-filters select {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .status-message {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 5px;
        color: white;
        font-weight: 500;
        z-index: 1000;
    }

    .status-message.success {
        background: #28a745;
    }

    .status-message.error {
        background: #dc3545;
    }

    .modal {
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 0;
        border: none;
        width: 80%;
        max-width: 600px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .modal-header {
        padding: 20px;
        border-bottom: 1px solid #e1e1e1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        padding: 20px;
        border-top: 1px solid #e1e1e1;
        text-align: right;
    }

    .close {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover {
        color: #000;
    }
    </style>
    <?php
    return ob_get_clean();
}

/**
 * Register the shortcode for shop manager
 */
add_shortcode('shop_manager', 'shop_manager_interface');
?>