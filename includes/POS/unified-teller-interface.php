<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render the Unified Teller interface with shop selection
 */
function unified_teller_interface() {
    if (!is_user_logged_in()) {
        return do_shortcode('[discord_login_button]');
    }

    // Check Discord permissions
    if (!jotunheim_user_can_access_page('unified_teller')) {
        return '<div class="teller-error">You do not have permission to access the Teller system.</div>';
    }

    ob_start();
    ?>
    <div id="unified-teller-interface" class="teller-app">
        <!-- Header with Shop Selection, Dynamic Title, and Teller Info -->
        <div class="teller-header">
            <div class="header-shop-selection">
                <div class="shop-selection-box">
                    <div class="form-field">
                        <label for="teller-shop-selector" class="field-label">Shop Selection</label>
                        <select id="teller-shop-selector" class="field-select">
                            <option value="">Select a shop to begin...</option>
                            <!-- Shops will be loaded here -->
                        </select>
                    </div>
                </div>
            </div>
            <div class="header-main">
                <h1 id="dynamic-shop-title" class="teller-title">Transaction Manager</h1>
                <p id="dynamic-shop-subtitle" class="teller-subtitle">Process player transactions and manage shop operations</p>
            </div>
            <div class="header-teller">
                <div class="teller-info">
                    <span class="teller-label">Teller:</span>
                    <span id="header-teller-name" class="teller-name"><?php 
                        // Try to get Discord name first, fallback to display name
                        $discord_name = get_user_meta(get_current_user_id(), 'discord_username', true);
                        echo esc_attr($discord_name ?: wp_get_current_user()->display_name); 
                    ?></span>
                </div>
            </div>
        </div>
        
        <!-- Customer, Payment, and Actions Row -->
        <div class="customer-payment-actions-row">
            <!-- Customer Selection -->
            <div class="teller-card customer-card">
                <div class="card-header">
                    <h2 class="card-title">Customer Name</h2>
                </div>
                <div class="card-content">
                    <div class="form-field">
                        <div class="customer-search-container">
                            <div class="input-group">
                                <input 
                                    type="text" 
                                    id="customer-name" 
                                    class="field-input" 
                                    placeholder="Start typing player name... (auto-validates)"
                                    autocomplete="off"
                                >
                                <div class="validation-icon-container">
                                    <div id="validation-success-icon" class="validation-icon success-icon" style="display: none;">✓</div>
                                    <div id="validation-error-icon" class="validation-icon error-icon" style="display: none;">✗</div>
                                </div>
                            </div>
                            <div id="customer-suggestions" class="customer-suggestions" style="display: none;"></div>
                        </div>
                        
                        <!-- Always Visible Registration Button -->
                        <div class="registration-button-container">
                            <button id="register-new-player-btn" class="register-new-player-btn">Register New Player</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Tracking / Turn-in Tracking -->
            <div class="teller-card payment-card">
                <div class="card-header">
                    <h2 id="tracking-title" class="card-title">Payment Tracking</h2>
                </div>
                <div class="card-content">
                    <!-- Payment Tracking (Default) -->
                    <div id="payment-tracking-content" class="tracking-content">
                        <div class="payment-grid-compact">
                            <div class="form-field">
                                <label for="ymir-flesh-total" class="field-label">Ymir Flesh</label>
                                <input type="number" id="ymir-flesh-total" class="field-input" min="0" step="1" placeholder="0">
                            </div>
                            <div class="form-field">
                                <label for="gold-total" class="field-label">Gold</label>
                                <input type="number" id="gold-total" class="field-input" min="0" step="1" placeholder="0">
                            </div>
                        </div>
                    </div>

                    <!-- Turn-in Tracking (Turn-in Only Shops) -->
                    <div id="turnin-tracking-content" class="tracking-content" style="display: none;">
                        <div class="turnin-summary-grid">
                            <div class="turnin-summary-item">
                                <div class="summary-label">Event Progress</div>
                                <div id="event-progress-display" class="summary-value">Loading...</div>
                            </div>
                            <div class="turnin-summary-item">
                                <div class="summary-label">Current Transaction</div>
                                <div id="current-transaction-display" class="summary-value">0 items</div>
                            </div>
                            <div class="turnin-summary-item">
                                <div class="summary-label">After Transaction</div>
                                <div id="projected-progress-display" class="summary-value">0 / 0</div>
                            </div>
                        </div>
                        
                        <div class="turnin-items-summary" id="turnin-items-summary">
                            <!-- Individual turn-in item progress will be populated here -->
                        </div>
                    </div>
                    
                    <div id="payment-summary-section" class="payment-summary-compact">
                        <div class="summary-row">
                            <span class="summary-label">Cost:</span>
                            <span id="item-total-cost" class="summary-value">0</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Paid:</span>
                            <span id="amount-paid-display" class="summary-value">0</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Diff:</span>
                            <span id="payment-difference" class="summary-value">0</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Status:</span>
                            <span id="payment-status" class="payment-status pending">Pending</span>
                        </div>
                    </div>

                    <!-- Payment Status Warnings and Change Due -->
                    <div id="payment-warnings" class="payment-warnings" style="display: none;">
                        <div id="overpaid-warning" class="payment-warning overpaid" style="display: none;">
                            <div class="warning-icon">⚠️</div>
                            <div class="warning-content">
                                <div class="warning-title">Overpaid</div>
                                <div class="warning-message">Change due</div>
                            </div>
                        </div>
                        
                        <div id="underpaid-warning" class="payment-warning underpaid" style="display: none;">
                            <div class="warning-icon">❌</div>
                            <div class="warning-content">
                                <div class="warning-title">Underpaid</div>
                                <div class="warning-message">More payment needed</div>
                            </div>
                        </div>
                        
                        <div id="balanced-confirmation" class="payment-warning balanced" style="display: none;">
                            <div class="warning-icon">✅</div>
                            <div class="warning-content">
                                <div class="warning-title">Balanced</div>
                                <div class="warning-message">Ready to record</div>
                            </div>
                        </div>
                    </div>

                    <!-- Change Due Section (only shows when overpaid) -->
                    <div id="change-due-section" class="change-due-section" style="display: none;">
                        <div class="change-due-header">
                            <h4>Change Due</h4>
                        </div>
                        <div class="change-due-grid">
                            <div class="form-field">
                                <label for="change-ymir-flesh" class="field-label">Ymir Flesh</label>
                                <input type="number" id="change-ymir-flesh" class="field-input" min="0" step="1" placeholder="0">
                            </div>
                            <div class="form-field">
                                <label for="change-gold" class="field-label">Gold</label>
                                <input type="number" id="change-gold" class="field-input" min="0" step="1" placeholder="0">
                            </div>
                        </div>
                        <div class="change-summary">
                            <div class="summary-row">
                                <span class="summary-label">Change Given:</span>
                                <span id="total-change-given" class="summary-value">0</span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">Remaining:</span>
                                <span id="remaining-change-due" class="summary-value">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction Actions -->
            <div class="teller-card customer-card">
                <div class="card-header">
                    <h2 class="card-title">Transaction Actions</h2>
                </div>
                <div class="card-content">
                    <div class="form-field">
                        <div class="customer-search-container">
                            <div class="input-group">
                                <button id="clear-transaction-btn" class="field-input clear-transaction-btn" onclick="if(window.unifiedTeller) { console.log('🚨 DEBUG: Clear button onclick fired'); window.unifiedTeller.clearCart(); } else { console.log('ERROR: unifiedTeller not found'); }">Clear Transaction</button>
                            </div>
                            <div id="customer-suggestions" class="customer-suggestions" style="display: none;"></div>
                        </div>
                        
                        <!-- Cart View Toggle Button / Record Transaction Button -->
                        <div class="registration-button-container">
                                <button id="view-cart-btn" class="register-new-player-btn" disabled>View Cart</button>
                                <button id="record-transaction-btn" class="register-new-player-btn record-transaction-btn" disabled style="display: none;">Record Transaction</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Transaction Interface (hidden until shop is selected) -->
        <div id="teller-main-interface" class="teller-main" style="display: none;">

            <!-- Shop Items -->
            <div class="teller-card items-card">
                <div class="card-header">
                    <h2 class="card-title">Shop Inventory</h2>
                    <p class="card-description">Browse and select items for transaction</p>
                </div>
                <div class="card-content">
                    <div class="items-controls">
                        <div class="search-field">
                            <input type="text" id="item-search" class="field-input" placeholder="Search items...">
                        </div>
                        <button id="toggle-view-btn" class="btn btn-outline">Toggle View</button>
                    </div>
                    
                    <div id="shop-items-table" class="items-container">
                        <div class="items-grid" id="items-grid-view">
                            <!-- Items will be loaded here as cards -->
                        </div>
                        <div class="items-table-wrapper" id="items-table-view" style="display: none;">
                            <table class="items-table">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Buy</th>
                                        <th>Claim</th>
                                        <th>Value</th>
                                        <th>Item Name</th>
                                        <th>Buy</th>
                                        <th>Claim</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody id="items-table-body">
                                    <!-- Items will be loaded here in table format -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction Summary -->
            <div class="teller-card summary-card">
                <div class="card-header">
                    <div class="card-header-left">
                        <h2 class="card-title">Transaction Summary</h2>
                        <p class="card-description">Review selected items and complete transaction</p>
                    </div>
                    <div class="card-header-right">
                        <button id="back-to-shop-btn" class="action-btn back-to-shop-btn" style="display: none;">Back to Shop</button>
                    </div>
                </div>
                <div class="card-content">
                    <div id="transaction-items" class="transaction-list">
                        <div class="transaction-header">
                            <span class="header-item">Item</span>
                            <span class="header-type">Type</span>
                            <span class="header-qty">Qty</span>
                            <span class="header-value">Value</span>
                            <span class="header-actions">Actions</span>
                        </div>
                        <div id="transaction-items-list" class="transaction-items-list">
                            <!-- Selected items will appear here -->
                        </div>
                    </div>
                    
                    <div class="form-field">
                        <label for="transaction-notes" class="field-label">Transaction Notes</label>
                        <textarea 
                            id="transaction-notes" 
                            class="field-textarea" 
                            placeholder="Optional notes about this transaction..." 
                            rows="3"
                        ></textarea>
                    </div>
                    

                </div>
            </div>




        </div>

        <!-- Turn-in Only Shop Interface (hidden until turn-in shop is selected) -->
        <div id="teller-turnin-interface" class="teller-main" style="display: none;">
            
            <!-- Turn-in Transaction Form -->
            <div class="teller-card transaction-form-card">
                <div class="card-header">
                    <h2 class="card-title">Turn-in Transaction</h2>
                    <p class="card-description">Process item turn-ins for event collection</p>
                </div>
                <div class="card-content">
                    <div class="form-grid">
                        <div class="form-field">
                            <label for="turnin-teller-name" class="field-label">Teller/Shopkeeper</label>
                            <input 
                                type="text" 
                                id="turnin-teller-name" 
                                class="field-input field-readonly" 
                                value="<?php 
                                    $discord_name = get_user_meta(get_current_user_id(), 'discord_username', true);
                                    echo esc_attr($discord_name ?: wp_get_current_user()->display_name); 
                                ?>"
                                readonly
                            >
                        </div>
                        <div class="form-field">
                            <label for="turnin-customer-name" class="field-label">Customer Name</label>
                            <div class="customer-search-container">
                                <div class="input-group">
                                    <input 
                                        type="text" 
                                        id="turnin-customer-name" 
                                        class="field-input" 
                                        placeholder="Start typing player name..."
                                        autocomplete="off"
                                    >
                                    <button id="turnin-validate-customer-btn" type="button" class="btn btn-secondary">
                                        Validate
                                    </button>
                                </div>
                                <div id="turnin-customer-suggestions" class="customer-suggestions" style="display: none;">
                                    <!-- Player suggestions will appear here -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="turnin-customer-status" class="status-message"></div>
                    
                    <div id="turnin-customer-info" class="customer-info-card" style="display: none;">
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Player</span>
                                <span id="turnin-customer-display-name" class="info-value"></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Status</span>
                                <span id="turnin-customer-active-status" class="info-value"></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Registered</span>
                                <span id="turnin-customer-registration" class="info-value"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Turn-in Items -->
            <div class="teller-card items-card">
                <div class="card-header">
                    <h2 class="card-title">Turn-in Items</h2>
                    <p class="card-description">Select items to turn in for event collection</p>
                </div>
                <div class="card-content">
                    <div class="items-controls">
                        <div class="search-field">
                            <input type="text" id="turnin-item-search" class="field-input" placeholder="Search turn-in items...">
                        </div>
                    </div>
                    
                    <div id="turnin-shop-items" class="items-container">
                        <div class="items-grid" id="turnin-items-grid">
                            <!-- Turn-in items will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Turn-in Summary -->
            <div class="teller-card summary-card">
                <div class="card-header">
                    <h2 class="card-title">Turn-in Summary</h2>
                    <p class="card-description">Review items being turned in</p>
                </div>
                <div class="card-content">
                    <div id="turnin-items-list" class="transaction-list">
                        <div class="transaction-header">
                            <span class="header-item">Item</span>
                            <span class="header-qty">Quantity</span>
                            <span class="header-points">Event Points</span>
                            <span class="header-actions">Actions</span>
                        </div>
                        <div id="turnin-selected-items" class="transaction-items-list">
                            <!-- Selected turn-in items will appear here -->
                        </div>
                    </div>
                    
                    <div class="form-field">
                        <label for="turnin-notes" class="field-label">Turn-in Notes</label>
                        <textarea 
                            id="turnin-notes" 
                            class="field-textarea" 
                            placeholder="Optional notes about this turn-in..." 
                            rows="3"
                        ></textarea>
                    </div>
                    
                    <div class="card-actions">
                        <button id="clear-turnin-btn" class="btn btn-outline">
                            Clear Turn-in
                        </button>
                        <button id="record-turnin-btn" class="btn btn-primary" disabled>
                            Record Turn-in
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction History -->
        <div class="teller-card history-card">
            <div class="card-header">
                <h2 class="card-title">Recent Transactions</h2>
                <p class="card-description">View and filter transaction history</p>
            </div>
            <div class="card-content">
                <div class="history-controls">
                    <div class="filters-grid">
                        <div class="form-field">
                            <label for="history-filter" class="field-label">Filter by Type</label>
                            <select id="history-filter" class="field-select">
                                <option value="">All Transactions</option>
                                <option value="buy">Purchases</option>
                                <option value="sell">Sales</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="form-field">
                            <label for="history-date-filter" class="field-label">Filter by Date</label>
                            <input type="date" id="history-date-filter" class="field-input">
                        </div>
                        <div class="form-field">
                            <label class="field-label">&nbsp;</label>
                            <button id="refresh-history-btn" class="btn btn-secondary">Refresh</button>
                        </div>
                    </div>
                </div>
                <div id="transaction-history" class="history-list">
                    <!-- Transaction history will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Status Messages -->
    <div id="teller-status" class="status-message" style="display: none;"></div>

    <!-- Transaction Confirmation Modal -->
    <div id="transaction-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Confirm Transaction</h3>
                <span class="close" onclick="closeTellerModal()">&times;</span>
            </div>
            <div class="modal-body">
                <div id="transaction-summary">
                    <!-- Transaction summary will be populated here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="confirmTransaction()">Confirm Transaction</button>
                <button type="button" class="btn btn-secondary" onclick="closeTellerModal()">Cancel</button>
            </div>
        </div>
    </div>

    <style>
    .teller-container {
        max-width: 1400px;
        margin: 20px auto;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .shop-selection-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        border-left: 4px solid #0073aa;
    }

    .shop-selector-row {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .shop-info {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 500;
    }

    .transaction-type-section {
        margin-bottom: 20px;
    }

    .transaction-type-buttons {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }

    .transaction-type-btn {
        padding: 12px 20px;
        border: 2px solid #e1e1e1;
        background: white;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 14px;
        font-weight: 500;
    }

    .transaction-type-btn.active {
        border-color: #0073aa;
        background: #0073aa;
        color: white;
    }

    .transaction-type-btn:hover:not(.active) {
        border-color: #0073aa;
    }

    .player-section, .shop-items-section, .shopping-cart-section, .transaction-notes-section {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .player-form {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .items-controls {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
    }

    .item-search, .item-filter {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .items-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
        max-height: 400px;
        overflow-y: auto;
        border: 1px solid #e1e1e1;
        padding: 15px;
        border-radius: 4px;
        background: white;
    }

    .item-card {
        border: 1px solid #e1e1e1;
        border-radius: 8px;
        padding: 15px;
        background: white;
        transition: box-shadow 0.3s ease;
        cursor: pointer;
    }

    .item-card:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .item-card.out-of-stock {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .item-name {
        font-weight: 600;
        margin-bottom: 5px;
    }

    .item-price {
        color: #0073aa;
        font-weight: 500;
        font-size: 16px;
    }

    .item-stock {
        font-size: 12px;
        color: #666;
        margin-top: 5px;
    }

    .shopping-cart {
        border: 1px solid #e1e1e1;
        border-radius: 8px;
        overflow: hidden;
        background: white;
    }

    .cart-header {
        display: grid;
        grid-template-columns: 2fr 1fr 80px 1fr 100px;
        gap: 10px;
        padding: 15px;
        background: #f8f9fa;
        font-weight: 600;
        border-bottom: 1px solid #e1e1e1;
    }

    .cart-items {
        max-height: 300px;
        overflow-y: auto;
    }

    .cart-item {
        display: grid;
        grid-template-columns: 2fr 1fr 80px 1fr 100px;
        gap: 10px;
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        align-items: center;
    }

    .cart-footer {
        padding: 15px;
        background: #f8f9fa;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .cart-total {
        font-size: 18px;
    }

    .cart-actions {
        display: flex;
        gap: 10px;
    }

    .quantity-input {
        width: 60px;
        padding: 4px 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-align: center;
    }

    .transaction-history {
        border: 1px solid #e1e1e1;
        border-radius: 8px;
        overflow: hidden;
        background: white;
        max-height: 400px;
        overflow-y: auto;
    }

    .history-controls {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
        align-items: center;
    }

    .history-controls select,
    .history-controls input {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .transaction-item {
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .transaction-info {
        flex: 1;
    }

    .transaction-amount {
        font-weight: 600;
        color: #0073aa;
    }

    .customer-status {
        padding: 10px;
        border-radius: 4px;
        margin-top: 10px;
    }

    .customer-status.valid {
        background: #e8f5e8;
        color: #2e7d32;
        border: 1px solid #c8e6c8;
    }

    .customer-status.invalid {
        background: #ffebee;
        color: #c62828;
        border: 1px solid #ffcdd2;
    }

    .customer-info {
        background: #e3f2fd;
        padding: 15px;
        border-radius: 4px;
        margin-top: 10px;
    }

    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        margin-right: 10px;
        transition: background-color 0.3s ease;
    }

    .btn-primary {
        background: #0073aa;
        color: white;
    }

    .btn-primary:hover {
        background: #005a87;
    }

    .btn-primary:disabled {
        background: #ccc;
        cursor: not-allowed;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #545b62;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background: #c82333;
    }

    .btn-sm {
        padding: 4px 8px;
        font-size: 12px;
    }

    .form-group {
        margin-bottom: 15px;
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

    .shop-type-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
    }

    .shop-type-badge.player {
        background: #e3f2fd;
        color: #1976d2;
    }

    .shop-type-badge.staff {
        background: #f3e5f5;
        color: #7b1fa2;
    }

    /* Transaction Actions Card Alignment - Updated styles */
    .actions-card .card-content {
        display: flex;
        flex-direction: column;
        gap: 10px;
        min-height: 140px; /* Match the customer card height */
        justify-content: space-between; /* Distribute buttons evenly */
        padding: 15px 25px; /* Add more horizontal padding (was 15px all around) */
    }

    .action-buttons-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
        height: 100%;
        justify-content: space-between;
    }

    /* Alternative approach if you want to match the exact padding of the customer input field */
    .actions-card .action-buttons-container {
        padding: 0 10px; /* This adds inner padding to match the customer field */
    }

    .action-btn {
        width: 100%;
        padding: 10px 16px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        min-height: 38px; /* Match input field height */
    }

    /* Record Transaction Button - Red */
    .record-transaction-btn {
        background: #dc3545 !important;
        color: white !important;
        border-color: #dc3545 !important;
    }

    .record-transaction-btn:hover:not(:disabled) {
        background: #c82333 !important;
        border-color: #bd2130 !important;
    }

    .record-transaction-btn:disabled {
        background: #ccc !important;
        border-color: #ccc !important; 
        color: #666 !important;
        cursor: not-allowed;
        opacity: 0.6;
    }

    /* Clear Transaction Button - Orange */
    .clear-transaction-btn {
        background: #fd7e14 !important;
        color: white !important;
        border-color: #fd7e14 !important;
    }

    .clear-transaction-btn:hover {
        background: #e8650e !important;
        border-color: #dc5f0a !important;
    }



    /* Back to Shop Button */
    .back-to-shop-btn {
        background: #6c757d;
        color: white;
        border-color: #6c757d;
        margin-right: 10px;
    }

    .back-to-shop-btn:hover {
        background: #5a6268;
        border-color: #5a6268;
    }

    /* Card Header Layout */
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 15px 20px;
        border-bottom: 1px solid #e9ecef;
        background-color: #f8f9fa;
    }

    .card-header-left {
        flex: 1;
    }

    .card-header-right {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Item Action Buttons */
    .item-btn {
        min-width: 57px;
        padding: 6px 12px;
        border: 1px solid;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        margin: 2px;
        text-align: center;
    }

    /* Buy/Sell button - Green for Sell (teller sells to customer) */
    .buy-btn {
        background-color: #28a745;
        color: white;
        border-color: #28a745;
    }

    .buy-btn:hover {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    /* Sell/Buy button - Red for Buy (teller buys from customer) */  
    .sell-btn {
        background-color: #dc3545;
        color: white;
        border-color: #dc3545;
    }

    .sell-btn:hover {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    /* Turn In button - Blue (already correct) */
    .turnin-btn {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .turnin-btn:hover {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    /* Update button state */
    .item-btn.update-btn {
        background-color: #6c757d;
        border-color: #6c757d;
        color: white;
    }

    .item-btn.update-btn:hover {
        background-color: #5a6268;
        border-color: #5a6268;
    }

    /* Ensure consistent card heights and alignment */
    .customer-payment-actions-row {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
        align-items: stretch;
    }

    .customer-payment-actions-row .teller-card .customer-card{
        flex: 1;
    }

    .customer-payment-actions-row .card-content {
        padding: 15px;
        min-height: 140px; /* Ensure consistent minimum height */
    }

    /* Match the customer name input container structure */
    .form-field {
        display: flex;
        flex-direction: column;
        gap: 10px;
        height: 100%;
        justify-content: space-between;
    }

    /* Ensure registration button aligns with Record Transaction button */
    .customer-card .registration-button-container {
        margin-top: auto; /* Push to bottom */
    }

    .customer-card .register-new-player-btn,
    .actions-card .action-btn, {
        width: 100%;
        padding: 10px 16px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        min-height: 38px;
    }

    .register-new-player-btn {
        background: #fff;
        color: #333;
        border-color: #ddd;
    }

    .register-new-player-btn:hover {
        background: #f8f9fa;
        border-color: #999;
    }

    .register-new-player-btn:disabled {
        background: #ccc;
        border-color: #ccc;
        color: #666;
        cursor: not-allowed;
        opacity: 0.6;
    }

    /* View Cart Button - Green styling */
    #view-cart-btn {
        background: #28a745;
        color: white;
        border-color: #28a745;
        cursor: pointer !important; /* Override any inherited cursor styles */
    }

    #view-cart-btn:hover:not(:disabled) {
        background: #218838;
        border-color: #1e7e34;
        cursor: pointer !important; /* Override any inherited cursor styles */
    }

    #view-cart-btn:not(:disabled) {
        cursor: pointer !important; /* Ensure pointer cursor when not disabled */
    }

    #view-cart-btn:disabled {
        background: #6c757d;
        border-color: #6c757d;
        color: white;
        cursor: not-allowed !important; /* Only show not-allowed when actually disabled */
        opacity: 0.6;
    }
    </style>
    
    <?php
    return ob_get_clean();
}

/**
 * Register the shortcode for unified teller
 */
add_shortcode('unified_teller', 'unified_teller_interface');
?>