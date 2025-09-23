<?php
/**
 * Legacy Shop Teller Interface
 * Replicates the Google Sheets workflows for Admin, Popup, Haldore, and Beehive shops
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

function legacy_shop_teller_interface() {
    ?>
    <div id="legacy-shop-teller" class="jotun-legacy-interface">
        <!-- Shop Type Selection -->
        <div class="shop-type-selector">
            <h2>Jotunheim Shop Teller System</h2>
            <div class="shop-tabs">
                <button class="shop-tab active" data-shop="admin">Admin Shop</button>
                <button class="shop-tab" data-shop="popup">Popup Shop</button>
                <button class="shop-tab" data-shop="haldore">Haldore Shop</button>
                <button class="shop-tab" data-shop="beehive">Beehive Shop</button>
            </div>
        </div>

        <!-- Player Registration Section -->
        <div class="player-registration-section">
            <div class="registration-panel">
                <h3>Player Registration</h3>
                <div class="player-input-group">
                    <input type="text" id="new-player-name" placeholder="Enter player name">
                    <button id="register-player-btn" class="btn btn-primary">Register Player</button>
                </div>
                <div id="registration-status" class="status-message"></div>
            </div>
        </div>

        <!-- Transaction Section -->
        <div class="transaction-section">
            <!-- Player Selection -->
            <div class="player-selection">
                <h3>Select Player</h3>
                <select id="transaction-player" class="player-dropdown">
                    <option value="">-- Select Player --</option>
                </select>
                <div id="player-status" class="status-message"></div>
            </div>

            <!-- Transaction Form -->
            <div class="transaction-form">
                <h3>Transaction Details</h3>
                
                <!-- Shop-specific transaction data -->
                <div id="admin-transaction" class="shop-transaction-form active">
                    <div class="transaction-options">
                        <label>
                            <input type="checkbox" id="admin-no-buys"> No Purchases (Claims Only)
                        </label>
                        <label>
                            <input type="checkbox" id="admin-no-claims"> No Claims (Purchases Only)
                        </label>
                    </div>
                    
                    <div class="transaction-grid">
                        <div class="buy-section">
                            <h4>Purchases</h4>
                            <div id="admin-buy-items" class="item-grid"></div>
                            <button class="add-item-btn" data-type="buy">Add Item</button>
                        </div>
                        <div class="claim-section">
                            <h4>Claims</h4>
                            <div id="admin-claim-items" class="item-grid"></div>
                            <button class="add-item-btn" data-type="claim">Add Claim</button>
                        </div>
                    </div>
                    
                    <div class="transaction-summary">
                        <div class="summary-totals">
                            <span>Total Cost: <span id="admin-total-cost">0</span></span>
                            <span>Ymir Flesh: <span id="admin-ymir-flesh">0</span></span>
                            <span>Gold: <span id="admin-gold">0</span></span>
                        </div>
                    </div>
                </div>

                <div id="popup-transaction" class="shop-transaction-form">
                    <div class="item-selection">
                        <h4>Popup Shop Items</h4>
                        <div id="popup-items" class="item-grid"></div>
                        <button class="add-item-btn">Add Item</button>
                    </div>
                    
                    <div class="transaction-summary">
                        <div class="summary-totals">
                            <span>Total Cost: <span id="popup-total-cost">0</span></span>
                            <span>Ymir Flesh: <span id="popup-ymir-flesh">0</span></span>
                        </div>
                    </div>
                </div>

                <div id="haldore-transaction" class="shop-transaction-form">
                    <div class="item-selection">
                        <h4>Haldore Trading Post</h4>
                        <div id="haldore-items" class="item-grid"></div>
                        <button class="add-item-btn">Add Item</button>
                    </div>
                    
                    <div class="transaction-summary">
                        <div class="summary-totals">
                            <span>Total Cost: <span id="haldore-total-cost">0</span></span>
                        </div>
                    </div>
                </div>

                <div id="beehive-transaction" class="shop-transaction-form">
                    <div class="item-selection">
                        <h4>Beehive Outpost</h4>
                        <div id="beehive-items" class="item-grid"></div>
                        <button class="add-item-btn">Add Item</button>
                    </div>
                    
                    <div class="transaction-summary">
                        <div class="summary-totals">
                            <span>Total Cost: <span id="beehive-total-cost">0</span></span>
                        </div>
                    </div>
                </div>

                <!-- Transaction Actions -->
                <div class="transaction-actions">
                    <button id="validate-transaction" class="btn btn-secondary">Validate Transaction</button>
                    <button id="record-transaction" class="btn btn-primary" disabled>Record Transaction</button>
                    <button id="clear-transaction" class="btn btn-warning">Clear Form</button>
                </div>
                
                <div id="transaction-status" class="status-message"></div>
            </div>
        </div>

        <!-- Administration Tools -->
        <div class="admin-tools-section">
            <h3>Administrative Tools</h3>
            <div class="admin-tools-grid">
                <div class="tool-panel">
                    <h4>Player Management</h4>
                    <button id="player-rename-tool" class="btn btn-secondary">Rename Player</button>
                    <button id="view-player-history" class="btn btn-secondary">View Player History</button>
                </div>
                
                <div class="tool-panel">
                    <h4>Ledger Management</h4>
                    <button id="clear-ledger-tool" class="btn btn-warning">Clear Current Ledger</button>
                    <button id="archive-ledger-tool" class="btn btn-warning">Archive & Reset</button>
                    <button id="world-reset-tool" class="btn btn-danger">World Reset</button>
                </div>
                
                <div class="tool-panel">
                    <h4>Reports</h4>
                    <button id="transaction-report" class="btn btn-secondary">Transaction Report</button>
                    <button id="legacy-items-report" class="btn btn-secondary">Legacy Items</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Item Selection Modal -->
    <div id="item-selection-modal" class="jotun-modal">
        <div class="jotun-modal-content">
            <div class="jotun-modal-header">
                <h3>Select Item</h3>
                <button class="jotun-modal-close">&times;</button>
            </div>
            <div class="jotun-modal-body">
                <div class="item-search">
                    <input type="text" id="item-search-input" placeholder="Search items...">
                </div>
                <div id="available-items" class="available-items-grid"></div>
            </div>
            <div class="jotun-modal-footer">
                <button id="select-item-btn" class="btn btn-primary" disabled>Select Item</button>
                <button class="btn btn-secondary jotun-modal-close">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Player Rename Modal -->
    <div id="player-rename-modal" class="jotun-modal">
        <div class="jotun-modal-content">
            <div class="jotun-modal-header">
                <h3>Rename Player</h3>
                <button class="jotun-modal-close">&times;</button>
            </div>
            <div class="jotun-modal-body">
                <div class="form-group">
                    <label>Current Player</label>
                    <select id="rename-current-player" class="player-dropdown">
                        <option value="">-- Select Player --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>New Name</label>
                    <input type="text" id="rename-new-name" placeholder="Enter new player name">
                </div>
                <div id="rename-status" class="status-message"></div>
            </div>
            <div class="jotun-modal-footer">
                <button id="confirm-rename-btn" class="btn btn-primary">Rename Player</button>
                <button class="btn btn-secondary jotun-modal-close">Cancel</button>
            </div>
        </div>
    </div>

    <!-- World Reset Modal -->
    <div id="world-reset-modal" class="jotun-modal">
        <div class="jotun-modal-content">
            <div class="jotun-modal-header">
                <h3>World Reset</h3>
                <button class="jotun-modal-close">&times;</button>
            </div>
            <div class="jotun-modal-body">
                <div class="warning-panel">
                    <p><strong>WARNING:</strong> This will archive all current transactions and reset all ledger values.</p>
                    <p>Legacy items (Vidar's Hammer, Unbreakable Oath, Eternal Flame) will be preserved for players.</p>
                </div>
                <div class="form-group">
                    <label>Reset Name</label>
                    <input type="text" id="world-reset-name" placeholder="Enter reset name (e.g., 'World 3 Reset')">
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" id="preserve-legacy-items" checked>
                        Preserve legacy items for players
                    </label>
                </div>
                <div id="world-reset-status" class="status-message"></div>
            </div>
            <div class="jotun-modal-footer">
                <button id="confirm-world-reset-btn" class="btn btn-danger">Confirm World Reset</button>
                <button class="btn btn-secondary jotun-modal-close">Cancel</button>
            </div>
        </div>
    </div>
    <?php
}

// Register shortcode
add_shortcode('legacy_shop_teller', 'legacy_shop_teller_interface');