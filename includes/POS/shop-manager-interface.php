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
    
    // Check Discord permissions
    if (!jotunheim_user_can_access_page('shop_manager')) {
        return '<div class="shop-error">You do not have permission to access the Shop Manager system.</div>';
    }
        ?>
        <style>
        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 10px;
            margin-top: 8px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
        }
        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: normal;
            cursor: pointer;
            padding: 5px 8px;
            border-radius: 3px;
            transition: background-color 0.2s;
        }
        .checkbox-label:hover {
            background-color: #e9e9e9;
        }
        .checkbox-label input[type="checkbox"] {
            margin: 0;
            width: 16px;
            height: 16px;
        }
        .checkbox-label span {
            font-size: 14px;
            color: #333;
        }
        .no-roles-message {
            font-style: italic;
            color: #666;
            padding: 15px;
            text-align: center;
            background-color: #f0f0f0;
            border-radius: 4px;
        }
        
        /* Item selector autocomplete styles */
        .item-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-top: none;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .suggestion-item {
            padding: 8px 12px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }
        
        .suggestion-item:hover, .suggestion-item.highlighted {
            background-color: #f0f7ff;
        }
        
        .suggestion-item .item-name {
            font-weight: bold;
        }
        
        .suggestion-item .item-price {
            color: #666;
            font-size: 0.9em;
        }
        
        /* Item not found notice */
        .item-not-found-notice {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-top: none;
            padding: 12px;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .item-not-found-notice p {
            margin: 0 0 10px 0;
            color: #856404;
            font-weight: 500;
        }
        
        .item-not-found-notice .btn {
            background: #007cba;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
        }
        
        .item-not-found-notice .btn:hover {
            background: #005a87;
        }
        
        /* Price input group */
        .price-input-group {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        
        .price-input-group input {
            flex: 1;
        }
        
        .price-unit {
            flex: 0 0 auto;
            padding: 8px 12px;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-weight: 500;
            color: #555;
        }
        
        .price-conversion {
            display: block;
            margin-top: 4px;
            color: #666;
            font-style: italic;
        }
        
        /* Transaction type help text */
        .form-help-text {
            display: block;
            margin-top: 4px;
            margin-bottom: 8px;
            color: #666;
            font-style: italic;
            font-size: 12px;
        }
        
        .checkbox-help {
            display: block;
            margin-top: 2px;
            margin-left: 20px;
            color: #888;
            font-size: 11px;
            font-style: italic;
        }
        
        /* Custom item badge */
        .custom-item-badge {
            display: inline-block;
            background: #e74c3c;
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 3px;
            margin-left: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        /* Stock quantity input styling */
        input#stock-quantity {
            margin-top: 13px;
            font-size: 16px;
            padding: 12px 16px;
        }
        
        /* Rotation quantity input styling */
        input#item-rotation {
            margin-top: 13px;
            font-size: 16px;
            padding: 12px 16px;
        }

        /* Availability quantity input styling */
        select#item-available {
            margin-top: 13px;
            font-size: 16px;
            padding: 12px 16px;
        }

        /* Daily Selling Limit quantity input styling */
        input#max-daily-sell-quantity {
            margin-top: 13px;
            font-size: 16px;
            padding: 12px 16px;
        }

        /* Daily Buying Limit quantity input styling */
        input#max-daily-buy-quantity {
            margin-top: 13px;
            font-size: 16px;
            padding: 12px 16px;
        }

        /* Daily Turn In Limit quantity input styling */
        input#max-daily-turnin-quantity {
            margin-top: 13px;
            font-size: 16px;
            padding: 12px 16px;
        }


        /* Relative positioning for autocomplete */
        .form-group {
            position: relative;
        }
        .permissions-list {
            font-size: 12px;
            color: #555;
            max-width: 200px;
            word-wrap: break-word;
        }
        
        /* Checkbox display styles */
        .checkbox-display {
            font-weight: bold;
            font-size: 16px;
            text-align: center;
            display: inline-block;
            width: 20px;
        }
        
        .checkbox-display.checked {
            color: #28a745;
        }
        
        .checkbox-display:not(.checked) {
            color: #dc3545;
        }
        
        /* Shop items table responsive styling */
        #shop-items-table {
            table-layout: fixed;
            width: 100%;
        }
        
        #shop-items-table th:nth-child(1) { width: 60px; } /* Rotation */
        #shop-items-table th:nth-child(2) { width: 120px; } /* Item Name */
        #shop-items-table th:nth-child(3) { width: 80px; } /* Default Price */
        #shop-items-table th:nth-child(4) { width: 80px; } /* Shop Price */
        #shop-items-table th:nth-child(5) { width: 50px; } /* Stock */
        #shop-items-table th:nth-child(6) { width: 40px; } /* Sell */
        #shop-items-table th:nth-child(7) { width: 40px; } /* Buy */
        #shop-items-table th:nth-child(8) { width: 50px; } /* Turn-In */
        #shop-items-table th:nth-child(9) { width: 60px; } /* Turn-In Progress */
        #shop-items-table th:nth-child(10) { width: 60px; } /* Turn-In Goal */
        #shop-items-table th:nth-child(11) { width: 60px; } /* Daily Sell Limit */
        #shop-items-table th:nth-child(12) { width: 60px; } /* Daily Buy Limit */
        #shop-items-table th:nth-child(13) { width: 65px; } /* Daily Turn-in Limit */
        #shop-items-table th:nth-child(14) { width: 65px; } /* Available */
        #shop-items-table th:nth-child(15) { width: 100px; } /* Actions */
        
        /* Ensure text doesn't overflow in cells */
        #shop-items-table td {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        /* Allow actions column to show buttons properly */
        #shop-items-table td:nth-child(15) {
            white-space: normal;
        }
        </style>
        <?php

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
            <button class="shop-tab-button" data-tab="types">Shop Types</button>
            <button class="shop-tab-button" data-tab="shortcodes">Shop Shortcodes</button>
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
                                    <!-- Options will be loaded dynamically -->
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
                            <!-- Options will be loaded dynamically -->
                        </select>
                        <input type="text" id="shop-search" placeholder="Search shops...">
                    </div>
                    <div id="shops-table-container">
                        <table id="shops-table" class="shop-table">
                            <thead>
                                <tr>
                                    <th>Shop Name</th>
                                    <th>Type</th>
                                    <th>Current Rotation</th>
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
                                <label for="item-selector">Search Items from Master List</label>
                                <input type="text" id="item-selector" name="item_search" placeholder="Type to search items... (If not found, you can add new items)" autocomplete="off">
                                <select id="item-selector-hidden" name="item_id" style="display: none;">
                                    <option value="">Select an item...</option>
                                </select>
                                <div id="item-suggestions" class="item-suggestions" style="display: none;"></div>
                                <div id="item-not-found-notice" class="item-not-found-notice" style="display: none;">
                                    <p>Item not found in Item Database.</p>
                                    <button type="button" id="add-new-item-btn" class="btn btn-primary">Add to Database</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="custom-price">Custom Price (Coins)</label>
                                <div class="price-input-group">
                                    <input type="number" id="custom-price" name="custom_price" step="1" placeholder="Enter price in Coins (leave empty for default)">
                                    <span class="price-unit">Coins</span>
                                </div>
                                <small class="price-conversion">Display will show both Coins and Ymir Flesh equivalent (1 Ymir = 120 Coins)</small>
                            </div>
                        </div>
                        
                        <!-- Transaction Type Checkboxes (moved above advanced settings) -->
                        <div class="form-row">
                            <div class="form-group">
                                <label>Transaction Types</label>
                                <small class="form-help-text">Configure what actions appear in the Unified Teller (from teller's perspective)</small>
                                <div class="checkbox-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" id="sell-checkbox" name="sell" checked>
                                        <span>Shop will buy from customers</span>
                                        <small class="checkbox-help">(Shows "Buy" button in teller)</small>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" id="buy-checkbox" name="buy">
                                        <span>Customers can buy from shop</span>
                                        <small class="checkbox-help">(Shows "Sell" button in teller)</small>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" id="turn-in-checkbox" name="turn_in">
                                        <span>Turn-In</span>
                                        <small class="checkbox-help">(Community collection event)</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Advanced Item Settings Collapsible Section -->
                        <div class="advanced-settings-section">
                            <div class="advanced-settings-header" onclick="toggleAdvancedSettings()">
                                <h4 class="advanced-settings-title">
                                    <span class="toggle-icon collapsed" id="advanced-toggle-icon">▶</span>
                                    Advanced Item Configuration
                                </h4>
                                <small class="advanced-settings-subtitle">Stock limits, rotation, availability, and daily transaction limits</small>
                            </div>
                            
                            <div class="advanced-settings-content collapsed" id="advanced-settings-content">
                                <!-- Stock Management -->
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Stock Management</label>
                                        <div class="checkbox-group">
                                            <label class="checkbox-label">
                                                <input type="checkbox" id="custom-stock-enabled" name="custom_stock_enabled">
                                                <span>Set Stock Quantity</span>
                                            </label>
                                        </div>
                                        <small style="display: block; color: #666; margin-top: 4px;">
                                            If unchecked, item will have unlimited stock
                                        </small>
                                    </div>
                                    <div class="form-group" id="stock-quantity-group" style="display: none;">
                                        <label for="stock-quantity">Stock Quantity</label>
                                        <input type="number" id="stock-quantity" name="stock_quantity" value="0">
                                        <small style="display: block; color: #666; margin-top: 4px;">
                                            Enter 0 or positive number for limited stock
                                        </small>
                                    </div>
                                </div>
                                
                                <!-- Rotation Settings -->
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Rotation Settings</label>
                                        <div class="checkbox-group">
                                            <label class="checkbox-label">
                                                <input type="checkbox" id="custom-rotation-enabled" name="custom_rotation_enabled">
                                                <span>Set Rotation</span>
                                            </label>
                                        </div>
                                        <small style="display: block; color: #666; margin-top: 4px;">
                                            If unchecked, item will use default rotation (1)
                                        </small>
                                    </div>
                                    <div class="form-group" id="rotation-group" style="display: none;">
                                        <label for="item-rotation">Rotation</label>
                                        <input type="number" id="item-rotation" name="rotation" value="1" min="1" title="Rotation number for grouping items">
                                    </div>
                                </div>
                                
                                <!-- Availability Settings -->
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Availability Settings</label>
                                        <div class="checkbox-group">
                                            <label class="checkbox-label">
                                                <input type="checkbox" id="custom-availability-enabled" name="custom_availability_enabled">
                                                <span>Set Availability</span>
                                            </label>
                                        </div>
                                        <small style="display: block; color: #666; margin-top: 4px;">
                                            If unchecked, item will be available by default
                                        </small>
                                    </div>
                                    <div class="form-group" id="availability-group" style="display: none;">
                                        <label for="item-available">Available</label>
                                        <select id="item-available" name="is_available">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Turn-In Only Fields -->
                                <div class="form-row turn-in-fields" style="display: none;">
                                    <div class="form-group">
                                        <label for="turn-in-quantity">Current Turn-In Quantity</label>
                                        <input type="number" id="turn-in-quantity" name="turn_in_quantity" value="0" min="0" title="Current amount turned in by players">
                                    </div>
                                    <div class="form-group">
                                        <label for="turn-in-requirement">Turn-In Goal</label>
                                        <input type="number" id="turn-in-requirement" name="turn_in_requirement" value="0" min="0" title="Total amount needed to complete this turn-in event">
                                    </div>
                                </div>
                                
                                <!-- Daily Selling Limit Fields -->
                                <div class="form-row daily-limit-fields">
                                    <div class="form-group">
                                        <label>Daily Selling Limits</label>
                                        <div class="checkbox-group">
                                            <label class="checkbox-label">
                                                <input type="checkbox" id="daily-limit-enabled" name="daily_limit_enabled">
                                                <span>Enable Daily Sell Limit</span>
                                            </label>
                                        </div>
                                        <small style="display: block; color: #666; margin-top: 4px;">
                                            Limit how much each player can sell per 24-hour period
                                        </small>
                                    </div>
                                    <div class="form-group" id="max-daily-quantity-group" style="display: none;">
                                        <label for="max-daily-sell-quantity">Max Daily Sell Quantity</label>
                                        <input type="number" id="max-daily-sell-quantity" name="max_daily_sell_quantity" value="0" min="0" title="Maximum quantity each player can sell per day (resets every 24 hours)">
                                        <small style="display: block; color: #666; margin-top: 4px;">
                                            0 = no limit. Example: if set to 5, each player can only sell up to 5 of this item per day
                                        </small>
                                    </div>
                                </div>
                                
                                <!-- Daily Buying Limit Fields -->
                                <div class="form-row daily-buy-limit-fields">
                                    <div class="form-group">
                                        <label>Daily Buying Limits</label>
                                        <div class="checkbox-group">
                                            <label class="checkbox-label">
                                                <input type="checkbox" id="buy-daily-limit-enabled" name="buy_daily_limit_enabled">
                                                <span>Enable Daily Buy Limit</span>
                                            </label>
                                        </div>
                                        <small style="display: block; color: #666; margin-top: 4px;">
                                            Limit how much each player can buy per 24-hour period
                                        </small>
                                    </div>
                                    <div class="form-group" id="max-daily-buy-quantity-group" style="display: none;">
                                        <label for="max-daily-buy-quantity">Max Daily Buy Quantity</label>
                                        <input type="number" id="max-daily-buy-quantity" name="max_daily_buy_quantity" value="0" min="0" title="Maximum quantity each player can buy per day (resets every 24 hours)">
                                        <small style="display: block; color: #666; margin-top: 4px;">
                                            0 = no limit. Example: if set to 3, each player can only buy up to 3 of this item per day
                                        </small>
                                    </div>
                                </div>
                                
                                <!-- Daily Turn-in Limit Fields -->
                                <div class="form-row daily-turnin-limit-fields">
                                    <div class="form-group">
                                        <label>Daily Turn-in Limits</label>
                                        <div class="checkbox-group">
                                            <label class="checkbox-label">
                                                <input type="checkbox" id="turnin-daily-limit-enabled" name="turnin_daily_limit_enabled">
                                                <span>Enable Daily Turn-in Limit</span>
                                            </label>
                                        </div>
                                        <small style="display: block; color: #666; margin-top: 4px;">
                                            Limit how much each player can turn in per 24-hour period
                                        </small>
                                    </div>
                                    <div class="form-group" id="max-daily-turnin-quantity-group" style="display: none;">
                                        <label for="max-daily-turnin-quantity">Max Daily Turn-in Quantity</label>
                                        <input type="number" id="max-daily-turnin-quantity" name="max_daily_turnin_quantity" value="0" min="0" title="Maximum quantity each player can turn in per day (resets every 24 hours)">
                                        <small style="display: block; color: #666; margin-top: 4px;">
                                            0 = no limit. Example: if set to 10, each player can only turn in up to 10 of this item per day
                                        </small>
                                    </div>
                                </div>
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
                    
                    <!-- Turn-In Shortcode Display -->
                    <div id="turn-in-shortcode-display" class="shortcode-display" style="display: none;">
                        <div class="shortcode-box">
                            <h4>Turn-In Progress Shortcode</h4>
                            <p>Use this shortcode to display turn-in progress for this shop:</p>
                            <div class="shortcode-container">
                                <code id="turn-in-shortcode-text"></code>
                                <button type="button" id="copy-shortcode-btn" class="copy-btn">Copy</button>
                            </div>
                            <small>Place this shortcode on any page or post to show the turn-in progress tracker.</small>
                        </div>
                    </div>
                    
                    <!-- Shop Items Table -->
                    <div id="shop-items-table-container">
                        <table id="shop-items-table" class="shop-table">
                            <thead>
                                <tr>
                                    <th>Rotation</th>
                                    <th>Item Name</th>
                                    <th>Default Price (Coins)</th>
                                    <th>Shop Price (Coins)</th>
                                    <th>Stock</th>
                                    <th>Sell</th>
                                    <th>Buy</th>
                                    <th>Turn-In</th>
                                    <th>Turn-In Progress</th>
                                    <th>Turn-In Goal</th>
                                    <th>Daily Sell Limit</th>
                                    <th>Daily Buy Limit</th>
                                    <th>Daily Turn-in Limit</th>
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

        <!-- Shop Types Tab -->
        <div id="types-tab" class="shop-tab-content">
            <div class="shop-types-section">
                <h2>Shop Types Management</h2>
                
                <!-- Add New Shop Type -->
                <div class="add-shop-type-section">
                    <h3>Add New Shop Type</h3>
                    <form id="add-shop-type-form" class="shop-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="type-name">Type Name *</label>
                                <input type="text" id="type-name" name="type_name" required placeholder="e.g., VIP Only Shop">
                            </div>
                            <div class="form-group">
                                <label for="type-description">Description</label>
                                <textarea id="type-description" name="description" placeholder="Optional description of this shop type"></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="type-status">Status</label>
                                <select id="type-status" name="is_active">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="type-permissions">Discord Permissions</label>
                                <div class="checkbox-group" id="type-permissions">
                                    <?php
                                    $discord_roles = get_option('jotunheim_discord_roles', []);
                                    if (!empty($discord_roles)) {
                                        foreach ($discord_roles as $role_key => $role_data) {
                                            if (!empty($role_data['name'])) {
                                                echo '<label class="checkbox-label">';
                                                echo '<input type="checkbox" name="default_permissions[]" value="' . esc_attr($role_key) . '">';
                                                echo '<span>' . esc_html($role_data['name']) . '</span>';
                                                echo '</label>';
                                            }
                                        }
                                    } else {
                                        echo '<p class="no-roles-message">No Discord roles configured. <a href="' . admin_url('admin.php?page=discord_auth_config') . '">Configure Discord roles first</a>.</p>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!-- Hidden field for auto-generated type key -->
                        <input type="hidden" id="type-key" name="type_key">
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Add Shop Type</button>
                            <button type="button" id="cancel-edit-type" class="btn btn-secondary" style="display: none;">Cancel Edit</button>
                        </div>
                    </form>
                </div>

                <!-- Shop Types List -->
                <div class="shop-types-list-section">
                    <h3>Existing Shop Types</h3>
                    <div id="shop-types-table-container">
                        <table id="shop-types-table" class="shop-table">
                            <thead>
                                <tr>
                                    <th>Type Name</th>
                                    <th>Description</th>
                                    <th>Discord Permissions</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="shop-types-table-body">
                                <!-- Shop types will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shop Shortcodes Tab -->
        <div id="shortcodes-tab" class="shop-tab-content">
            <div class="shortcode-reference">
                <h3>Universal Turn-In Tracker Shortcode</h3>
                <p>Use this shortcode to display turn-in progress for specific shops anywhere on your site:</p>
                
                <div class="shortcode-example">
                    <h4>Basic Usage:</h4>
                    <div class="shortcode-copy-container">
                        <code>[universal_turn_in_tracker shops="1,2,3"]</code>
                        <button class="copy-shortcode-btn" type="button" title="Copy to clipboard">📋</button>
                    </div>
                </div>

                <div class="shortcode-attributes">
                    <h4>Available Attributes:</h4>
                    <ul class="shortcode-attr-list">
                        <li><strong>shops</strong> - Comma-separated list of shop IDs (required)</li>
                        <li><strong>columns</strong> - Layout: 1, 2, or 3 columns (default: 1)</li>
                        <li><strong>show_completed</strong> - Show completed items: true/false (default: true)</li>
                        <li><strong>title</strong> - Custom title for the tracker (default: "Turn-In Progress")</li>
                    </ul>
                </div>

                <div class="shortcode-examples">
                    <h4>Example Variations:</h4>
                    
                    <div class="shortcode-example">
                        <h5>Two-column layout without completed items:</h5>
                        <div class="shortcode-copy-container">
                            <code>[universal_turn_in_tracker shops="1,2,3" columns="2" show_completed="false"]</code>
                            <button class="copy-shortcode-btn" type="button" title="Copy to clipboard">📋</button>
                        </div>
                    </div>

                    <div class="shortcode-example">
                        <h5>Three-column layout with custom title:</h5>
                        <div class="shortcode-copy-container">
                            <code>[universal_turn_in_tracker shops="1,2,3" columns="3" title="My Progress Tracker"]</code>
                            <button class="copy-shortcode-btn" type="button" title="Copy to clipboard">📋</button>
                        </div>
                    </div>

                    <div class="shortcode-example">
                        <h5>Single shop with custom settings:</h5>
                        <div class="shortcode-copy-container">
                            <code>[universal_turn_in_tracker shops="1" columns="1" show_completed="false" title="Blacksmith Progress"]</code>
                            <button class="copy-shortcode-btn" type="button" title="Copy to clipboard">📋</button>
                        </div>
                    </div>
                </div>

                <div class="shortcode-notes">
                    <h4>Notes:</h4>
                    <ul>
                        <li>Shop IDs can be found in the Shops tab above</li>
                        <li>The tracker automatically updates when players complete items</li>
                        <li>Use multiple shortcodes on the same page for different shop groups</li>
                        <li>Column layouts automatically adjust for mobile devices</li>
                    </ul>
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
    
    /* Rotation Grouping Styles */
    .rotation-header-row {
        background: #f0f8ff;
        border-left: 4px solid #0073aa;
    }
    
    .rotation-header {
        padding: 12px 15px !important;
        font-weight: bold;
        color: #0073aa;
        background: #f0f8ff;
    }
    
    .rotation-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .rotation-title {
        font-size: 16px;
        font-weight: 600;
    }
    
    .rotation-count {
        font-size: 12px;
        font-weight: normal;
        color: #666;
        background: #fff;
        padding: 4px 8px;
        border-radius: 12px;
        border: 1px solid #ddd;
    }
    
    /* Drag and Drop Styles */
    .drag-handle {
        cursor: move;
        padding: 8px 12px !important;
        text-align: center;
        position: relative;
    }
    
    .drag-icon {
        color: #666;
        font-size: 14px;
        margin-right: 8px;
        vertical-align: middle;
    }
    
    .sortable-item {
        transition: all 0.2s ease;
    }
    
    .sortable-item:hover {
        background-color: #f8f9fa;
    }
    
    .sortable-item.dragging {
        opacity: 0.5;
        transform: rotate(2deg);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
    
    .drag-placeholder {
        background: #e3f2fd;
        border: 2px dashed #1976d2;
        height: 60px;
    }
    
    .placeholder-content {
        text-align: center;
        color: #1976d2;
        font-style: italic;
        padding: 20px 0;
    }
    
    .rotation-group {
        background: #fafafa;
        border-left: 3px solid #e0e0e0;
    }
    
    .rotation-group .sortable-item:hover {
        background-color: #fff;
        border-left: 3px solid #0073aa;
    }
    
    /* Enhanced rotation badge in drag handle */
    .drag-handle .rotation-badge {
        display: block;
        margin-top: 4px;
        font-size: 10px;
    }
    
    /* Collapsible Rotation Styles */
    .rotation-header.clickable {
        cursor: pointer;
        user-select: none;
        transition: background-color 0.2s ease;
    }
    
    .rotation-header.clickable:hover {
        background: #e3f2fd !important;
    }
    
    .rotation-toggle {
        display: inline-block;
        margin-right: 8px;
        font-size: 14px;
        font-weight: bold;
        color: #0073aa;
        transition: transform 0.2s ease;
    }
    
    .rotation-header-row.collapsed .rotation-toggle {
        transform: rotate(-90deg);
    }
    
    .rotation-header-row.collapsed {
        background: #f5f5f5;
        border-left-color: #999;
    }
    
    .rotation-header-row.collapsed .rotation-title {
        color: #666;
    }
    
    /* Empty message styling */
    .empty-message {
        text-align: center;
        padding: 40px 20px;
        color: #666;
        font-style: italic;
        background: #f9f9f9;
    }
    </style>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Daily Sell Limit checkbox functionality
        const dailyLimitCheckbox = document.getElementById('daily-limit-enabled');
        const quantityGroup = document.getElementById('max-daily-quantity-group');
        
        if (dailyLimitCheckbox && quantityGroup) {
            function toggleQuantityField() {
                if (dailyLimitCheckbox.checked) {
                    quantityGroup.style.display = 'block';
                } else {
                    quantityGroup.style.display = 'none';
                    document.getElementById('max-daily-sell-quantity').value = '0';
                }
            }
            dailyLimitCheckbox.addEventListener('change', toggleQuantityField);
            toggleQuantityField();
        }
        
        // Daily Buy Limit checkbox functionality
        const buyDailyLimitCheckbox = document.getElementById('buy-daily-limit-enabled');
        const buyQuantityGroup = document.getElementById('max-daily-buy-quantity-group');
        
        if (buyDailyLimitCheckbox && buyQuantityGroup) {
            function toggleBuyQuantityField() {
                if (buyDailyLimitCheckbox.checked) {
                    buyQuantityGroup.style.display = 'block';
                } else {
                    buyQuantityGroup.style.display = 'none';
                    document.getElementById('max-daily-buy-quantity').value = '0';
                }
            }
            buyDailyLimitCheckbox.addEventListener('change', toggleBuyQuantityField);
            toggleBuyQuantityField();
        }
        
        // Daily Turn-in Limit checkbox functionality
        const turninDailyLimitCheckbox = document.getElementById('turnin-daily-limit-enabled');
        const turninQuantityGroup = document.getElementById('max-daily-turnin-quantity-group');
        
        if (turninDailyLimitCheckbox && turninQuantityGroup) {
            function toggleTurninQuantityField() {
                if (turninDailyLimitCheckbox.checked) {
                    turninQuantityGroup.style.display = 'block';
                } else {
                    turninQuantityGroup.style.display = 'none';
                    document.getElementById('max-daily-turnin-quantity').value = '0';
                }
            }
            turninDailyLimitCheckbox.addEventListener('change', toggleTurninQuantityField);
            toggleTurninQuantityField();
        }
        
        // Stock Quantity checkbox functionality
        const stockCheckbox = document.getElementById('custom-stock-enabled');
        const stockGroup = document.getElementById('stock-quantity-group');
        
        if (stockCheckbox && stockGroup) {
            function toggleStockField() {
                if (stockCheckbox.checked) {
                    stockGroup.style.display = 'block';
                } else {
                    stockGroup.style.display = 'none';
                    document.getElementById('stock-quantity').value = '0';
                }
            }
            stockCheckbox.addEventListener('change', toggleStockField);
            toggleStockField();
        }
        
        // Rotation checkbox functionality
        const rotationCheckbox = document.getElementById('custom-rotation-enabled');
        const rotationGroup = document.getElementById('rotation-group');
        
        if (rotationCheckbox && rotationGroup) {
            function toggleRotationField() {
                if (rotationCheckbox.checked) {
                    rotationGroup.style.display = 'block';
                } else {
                    rotationGroup.style.display = 'none';
                    document.getElementById('item-rotation').value = '1';
                }
            }
            rotationCheckbox.addEventListener('change', toggleRotationField);
            toggleRotationField();
        }
        
        // Availability checkbox functionality
        const availabilityCheckbox = document.getElementById('custom-availability-enabled');
        const availabilityGroup = document.getElementById('availability-group');
        
        if (availabilityCheckbox && availabilityGroup) {
            function toggleAvailabilityField() {
                if (availabilityCheckbox.checked) {
                    availabilityGroup.style.display = 'block';
                } else {
                    availabilityGroup.style.display = 'none';
                    document.getElementById('item-available').value = '1';
                }
            }
            availabilityCheckbox.addEventListener('change', toggleAvailabilityField);
            toggleAvailabilityField();
        }
    });
    </script>
    
    <?php
    // Include the quick add item modal
    include_once(plugin_dir_path(__FILE__) . '../ItemList/itemlist-quick-add-interface.php');
    echo include_quick_add_item_modal();
    ?>
    
    <?php
    return ob_get_clean();
}

/**
 * Register the shortcode for shop manager
 */
add_shortcode('shop_manager', 'shop_manager_interface');
?>