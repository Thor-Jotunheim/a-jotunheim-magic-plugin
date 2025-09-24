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
    <div id="unified-teller-interface" class="teller-container">
        <h1>Unified Teller System</h1>
        
        <!-- Shop Selection -->
        <div class="shop-selection-section">
            <h2>Select Shop</h2>
            <div class="shop-selector-row">
                <div class="form-group">
                    <label for="teller-shop-selector">Active Shop:</label>
                    <select id="teller-shop-selector">
                        <option value="">Select a shop to begin...</option>
                        <!-- Shops will be loaded here -->
                    </select>
                </div>
                <div class="shop-info" id="shop-info" style="display: none;">
                    <span id="shop-name-display"></span>
                    <span id="shop-type-display" class="shop-type-badge"></span>
                </div>
            </div>
        </div>

        <!-- Teller Interface (hidden until shop is selected) -->
        <div id="teller-main-interface" style="display: none;">
            
            <!-- Teller Information -->
            <div class="teller-info-section">
                <h3>Teller Information</h3>
                <div class="teller-form">
                    <div class="form-group">
                        <label for="teller-name">Shopkeeper/Teller:</label>
                        <input type="text" id="teller-name" placeholder="Enter teller name (e.g., Huginn, Muninn)" value="<?php echo esc_attr(wp_get_current_user()->display_name); ?>">
                    </div>
                </div>
            </div>

            <!-- Player Information -->
            <div class="player-section">
                <h3>Player</h3>
                <div class="player-form">
                    <div class="form-group">
                        <label for="customer-name">Player Name:</label>
                        <input type="text" id="customer-name" placeholder="Enter player name (e.g., Sephrm)">
                        <button id="validate-customer-btn" type="button">Validate Player</button>
                    </div>
                    <div class="form-group">
                        <button id="register-new-player-btn" type="button" class="register-btn" style="display: none;">
                            Register New Player
                        </button>
                    </div>
                    <div id="customer-status" class="customer-status"></div>
                    <div id="customer-info" class="customer-info" style="display: none;">
                        <div class="player-info-card">
                            <p><strong>Player:</strong> <span id="customer-display-name"></span></p>
                            <p><strong>Status:</strong> <span id="customer-active-status"></span></p>
                            <p><strong>Registered:</strong> <span id="customer-registration"></span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Player Payment Tracking -->
            <div class="player-payment-section">
                <h3>Player Payment</h3>
                <div class="payment-grid">
                    <div class="payment-item">
                        <label for="ymir-flesh-total">Ymir Flesh</label>
                        <input type="number" id="ymir-flesh-total" value="0" min="0">
                    </div>
                    <div class="payment-item">
                        <label for="gold-total">Gold</label>
                        <input type="number" id="gold-total" value="0" min="0">
                    </div>
                    <div class="payment-summary">
                        <div class="total-cost">
                            <strong>Item Total Cost: <span id="item-total-cost">0</span></strong>
                        </div>
                        <div class="payment-status">
                            <span id="payment-balance">Balanced</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shop Items Grid -->
            <div class="shop-items-section">
                <div class="items-controls">
                    <input type="text" id="item-search" placeholder="Search items..." class="item-search">
                    <button id="toggle-view-btn" class="btn btn-secondary">Toggle View</button>
                </div>
                
                <div id="shop-items-table" class="items-table-container">
                    <table class="shop-items-table">
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
                            <!-- Items will be loaded here in two-column layout -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Transaction Summary -->
            <div class="transaction-summary-section">
                <h3>Transaction Summary</h3>
                <div id="transaction-items" class="transaction-items">
                    <div class="transaction-header">
                        <span>Item</span>
                        <span>Type</span>
                        <span>Quantity</span>
                        <span>Value</span>
                        <span>Actions</span>
                    </div>
                    <div id="transaction-items-list" class="transaction-items-list">
                        <!-- Selected items will appear here -->
                    </div>
                </div>
                
                <div class="transaction-actions">
                    <button id="clear-transaction-btn" class="btn btn-secondary">
                        Clear Transaction
                    </button>
                    <button id="record-transaction-btn" class="btn btn-primary" disabled>
                        Clear & Record Transaction
                    </button>
                </div>
            </div>

            <!-- Transaction Notes -->
            <div class="transaction-notes-section">
                <h3>Transaction Notes</h3>
                <textarea id="transaction-notes" placeholder="Optional notes about this transaction..." rows="3"></textarea>
            </div>
        </div>

        <!-- Transaction History (always visible) -->
        <div class="transaction-history-section">
            <h2>Recent Transactions</h2>
            <div class="history-controls">
                <select id="history-filter">
                    <option value="">All Transactions</option>
                    <option value="buy">Purchases</option>
                    <option value="sell">Sales</option>
                    <option value="admin">Admin</option>
                </select>
                <input type="date" id="history-date-filter">
                <button id="refresh-history-btn" class="btn btn-secondary">Refresh</button>
            </div>
            <div id="transaction-history" class="transaction-history">
                <!-- Transaction history will be loaded here -->
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
    </style>
    <?php
    return ob_get_clean();
}

/**
 * Register the shortcode for unified teller
 */
add_shortcode('unified_teller', 'unified_teller_interface');
?>