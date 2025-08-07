<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render the Point of Sale interface
 */
function pos_interface_shortcode() {
    if (!is_user_logged_in()) {
        return do_shortcode('[discord_login_button]');
    }

    if (!current_user_can('edit_posts')) {
        return '<div class="pos-error">You do not have permission to access the Point of Sale system.</div>';
    }

    ob_start();
    ?>
    <div id="pos-interface" class="pos-container">
        <h1>Point of Sale System</h1>
        
        <!-- Tab Navigation -->
        <div class="pos-tabs">
            <button class="pos-tab-button active" data-tab="admin">Admin Transactions</button>
            <button class="pos-tab-button" data-tab="spell">Spell Transactions</button>
        </div>

        <!-- Admin Tab -->
        <div id="admin-tab" class="pos-tab-content active">
            <h2>Admin Transactions</h2>
            
            <!-- Player Registration Section -->
            <div class="pos-section">
                <h3>Player Registration</h3>
                <div class="pos-form-group">
                    <label for="admin-register-player">Player Name:</label>
                    <input type="text" id="admin-register-player" placeholder="Enter player name">
                    <button id="admin-register-btn" type="button">Register Player</button>
                </div>
                <div id="admin-register-status" class="pos-status"></div>
            </div>

            <!-- Player Validation Section -->
            <div class="pos-section">
                <h3>Transaction</h3>
                <div class="pos-form-group">
                    <label for="admin-player-name">Player Name:</label>
                    <input type="text" id="admin-player-name" placeholder="Enter player name">
                    <button id="admin-validate-btn" type="button">Validate Player</button>
                </div>
                <div id="admin-player-status" class="pos-status"></div>
            </div>

            <!-- Transaction Options -->
            <div class="pos-section">
                <h3>Transaction Type</h3>
                <div class="pos-form-group">
                    <label>
                        <input type="checkbox" id="admin-no-buys"> No Buys (Claims Only)
                    </label>
                </div>
                <div class="pos-form-group">
                    <label>
                        <input type="checkbox" id="admin-no-claims"> No Claims (Buys Only)
                    </label>
                </div>
            </div>

            <!-- Transaction Data -->
            <div class="pos-section">
                <h3>Transaction Items</h3>
                <div class="pos-transaction-data">
                    <div class="pos-item-header">
                        <span>Item Name</span>
                        <span>Quantity</span>
                        <span>Amount</span>
                        <span>Action</span>
                    </div>
                    <div id="admin-transaction-items" class="pos-item-list">
                        <!-- Transaction items will be added here -->
                    </div>
                    <button id="admin-add-item" type="button">Add Item</button>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pos-section">
                <button id="admin-record-btn" type="button" class="pos-primary-btn">Record Transaction</button>
                <button id="admin-clear-btn" type="button" class="pos-secondary-btn">Clear All</button>
            </div>
        </div>

        <!-- Spell Tab -->
        <div id="spell-tab" class="pos-tab-content">
            <h2>Spell Transactions</h2>
            
            <!-- Player Validation Section -->
            <div class="pos-section">
                <h3>Player Information</h3>
                <div class="pos-form-group">
                    <label for="spell-player-name">Player Name:</label>
                    <input type="text" id="spell-player-name" placeholder="Enter player name">
                    <button id="spell-validate-btn" type="button">Validate Player</button>
                </div>
                <div id="spell-player-status" class="pos-status"></div>
            </div>

            <!-- Transaction Data -->
            <div class="pos-section">
                <h3>Spell Items</h3>
                <div class="pos-transaction-data">
                    <div class="pos-item-header">
                        <span>Spell Name</span>
                        <span>Quantity</span>
                        <span>Mana Cost</span>
                        <span>Action</span>
                    </div>
                    <div id="spell-transaction-items" class="pos-item-list">
                        <!-- Spell items will be added here -->
                    </div>
                    <button id="spell-add-item" type="button">Add Spell</button>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pos-section">
                <button id="spell-record-btn" type="button" class="pos-primary-btn">Record Transaction</button>
                <button id="spell-clear-btn" type="button" class="pos-secondary-btn">Clear All</button>
            </div>
        </div>

        <!-- Status Messages -->
        <div id="pos-messages" class="pos-messages"></div>
    </div>

    <style>
        .pos-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .pos-tabs {
            display: flex;
            border-bottom: 2px solid #ddd;
            margin-bottom: 20px;
        }

        .pos-tab-button {
            padding: 12px 24px;
            border: none;
            background: #f5f5f5;
            cursor: pointer;
            font-size: 16px;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .pos-tab-button.active {
            background: #007cba;
            color: white;
            border-bottom-color: #005a87;
        }

        .pos-tab-content {
            display: none;
        }

        .pos-tab-content.active {
            display: block;
        }

        .pos-section {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .pos-section h3 {
            margin-top: 0;
            color: #333;
            border-bottom: 2px solid #007cba;
            padding-bottom: 10px;
        }

        .pos-form-group {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            gap: 10px;
        }

        .pos-form-group label {
            min-width: 120px;
            font-weight: 600;
        }

        .pos-form-group input[type="text"],
        .pos-form-group input[type="number"] {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .pos-form-group button {
            padding: 8px 16px;
            background: #007cba;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s ease;
        }

        .pos-form-group button:hover {
            background: #005a87;
        }

        .pos-transaction-data {
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }

        .pos-item-header {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 100px;
            gap: 10px;
            padding: 12px;
            background: #f9f9f9;
            font-weight: 600;
            border-bottom: 1px solid #ddd;
        }

        .pos-item-list {
            max-height: 300px;
            overflow-y: auto;
        }

        .pos-item {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 100px;
            gap: 10px;
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
            align-items: center;
        }

        .pos-item input {
            padding: 6px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 13px;
        }

        .pos-item button {
            padding: 6px 12px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
        }

        .pos-item button:hover {
            background: #c82333;
        }

        .pos-primary-btn {
            background: #28a745;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            margin-right: 10px;
            transition: background 0.3s ease;
        }

        .pos-primary-btn:hover {
            background: #218838;
        }

        .pos-secondary-btn {
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        .pos-secondary-btn:hover {
            background: #5a6268;
        }

        .pos-status {
            padding: 10px;
            border-radius: 4px;
            margin-top: 10px;
            font-weight: 600;
        }

        .pos-status.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .pos-status.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .pos-status.warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .pos-messages {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .pos-message {
            padding: 12px 20px;
            margin-bottom: 10px;
            border-radius: 4px;
            max-width: 300px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            animation: slideIn 0.3s ease;
        }

        .pos-message.success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .pos-message.error {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .pos-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            padding: 20px;
            text-align: center;
            font-weight: 600;
        }
    </style>

    <script>
        (function($) {
            $(document).ready(function() {
                // Tab switching
                $('.pos-tab-button').click(function() {
                    const tab = $(this).data('tab');
                    $('.pos-tab-button').removeClass('active');
                    $('.pos-tab-content').removeClass('active');
                    $(this).addClass('active');
                    $('#' + tab + '-tab').addClass('active');
                });

                // Prevent checkbox conflicts
                $('#admin-no-buys').change(function() {
                    if ($(this).is(':checked')) {
                        $('#admin-no-claims').prop('checked', false);
                    }
                });

                $('#admin-no-claims').change(function() {
                    if ($(this).is(':checked')) {
                        $('#admin-no-buys').prop('checked', false);
                    }
                });

                // Add item functionality
                $('#admin-add-item').click(function() {
                    addTransactionItem('admin');
                });

                $('#spell-add-item').click(function() {
                    addTransactionItem('spell');
                });

                // Player registration
                $('#admin-register-btn').click(function() {
                    registerPlayer();
                });

                // Player validation
                $('#admin-validate-btn').click(function() {
                    validatePlayer('admin');
                });

                $('#spell-validate-btn').click(function() {
                    validatePlayer('spell');
                });

                // Record transactions
                $('#admin-record-btn').click(function() {
                    recordTransaction('admin');
                });

                $('#spell-record-btn').click(function() {
                    recordTransaction('spell');
                });

                // Clear functionality
                $('#admin-clear-btn').click(function() {
                    clearTab('admin');
                });

                $('#spell-clear-btn').click(function() {
                    clearTab('spell');
                });

                // Initialize with one item row for each tab
                addTransactionItem('admin');
                addTransactionItem('spell');
            });

            function addTransactionItem(tab) {
                const itemHtml = `
                    <div class="pos-item">
                        <input type="text" placeholder="${tab === 'spell' ? 'Spell name' : 'Item name'}" class="item-name">
                        <input type="number" placeholder="Quantity" class="item-quantity" min="0">
                        <input type="number" placeholder="${tab === 'spell' ? 'Mana cost' : 'Amount'}" class="item-amount" min="0" step="0.01">
                        <button type="button" onclick="removeItem(this)">Remove</button>
                    </div>
                `;
                $('#' + tab + '-transaction-items').append(itemHtml);
            }

            window.removeItem = function(button) {
                $(button).closest('.pos-item').remove();
            };

            function showMessage(message, type = 'success') {
                const messageHtml = `<div class="pos-message ${type}">${message}</div>`;
                $('#pos-messages').append(messageHtml);
                
                setTimeout(function() {
                    $('#pos-messages .pos-message').first().fadeOut(function() {
                        $(this).remove();
                    });
                }, 5000);
            }

            function showStatus(elementId, message, type = 'success') {
                const statusEl = $('#' + elementId);
                statusEl.removeClass('success error warning').addClass(type).text(message).show();
            }

            function registerPlayer() {
                const playerName = $('#admin-register-player').val().trim();
                
                if (!playerName) {
                    showStatus('admin-register-status', 'Player name cannot be empty', 'error');
                    return;
                }

                $.ajax({
                    url: (window.wpApiSettings ? wpApiSettings.root : '/wp-json/') + 'pos/v1/register-player',
                    method: 'POST',
                    beforeSend: function(xhr) {
                        if (window.wpApiSettings && wpApiSettings.nonce) {
                            xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);
                        }
                    },
                    data: {
                        playerName: playerName
                    },
                    success: function(response) {
                        showStatus('admin-register-status', response.message, 'success');
                        showMessage(response.message, 'success');
                        $('#admin-register-player').val('');
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        const message = response && response.error ? response.error : 'Registration failed';
                        showStatus('admin-register-status', message, 'error');
                        showMessage(message, 'error');
                    }
                });
            }

            function validatePlayer(tab) {
                const playerName = $('#' + tab + '-player-name').val().trim();
                
                if (!playerName) {
                    showStatus(tab + '-player-status', 'Player name cannot be empty', 'error');
                    return;
                }

                $.ajax({
                    url: (window.wpApiSettings ? wpApiSettings.root : '/wp-json/') + 'pos/v1/validate-player',
                    method: 'POST',
                    beforeSend: function(xhr) {
                        if (window.wpApiSettings && wpApiSettings.nonce) {
                            xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);
                        }
                    },
                    data: {
                        playerName: playerName
                    },
                    success: function(response) {
                        if (response.status === 1) {
                            showStatus(tab + '-player-status', 'Player found - ready for transaction', 'success');
                        } else if (response.status === 0) {
                            showStatus(tab + '-player-status', 'Player not found - please register first', 'warning');
                        } else {
                            showStatus(tab + '-player-status', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        const message = response && response.error ? response.error : 'Validation failed';
                        showStatus(tab + '-player-status', message, 'error');
                    }
                });
            }

            function recordTransaction(tab) {
                const playerName = $('#' + tab + '-player-name').val().trim();
                
                if (!playerName) {
                    showMessage('Player name is required', 'error');
                    return;
                }

                // Collect transaction data
                const transactionData = [];
                $('#' + tab + '-transaction-items .pos-item').each(function() {
                    const name = $(this).find('.item-name').val().trim();
                    const quantity = parseInt($(this).find('.item-quantity').val()) || 0;
                    const amount = parseFloat($(this).find('.item-amount').val()) || 0;
                    
                    if (name && quantity > 0) {
                        transactionData.push({
                            name: name,
                            quantity: quantity,
                            amount: amount
                        });
                    }
                });

                if (transactionData.length === 0) {
                    showMessage('Please add at least one item with quantity > 0', 'error');
                    return;
                }

                const data = {
                    playerName: playerName,
                    transactionData: transactionData
                };

                if (tab === 'admin') {
                    data.noBuys = $('#admin-no-buys').is(':checked');
                    data.noClaims = $('#admin-no-claims').is(':checked');
                }

                const endpoint = tab === 'admin' ? 'admin-record' : 'spell-record';

                $.ajax({
                    url: (window.wpApiSettings ? wpApiSettings.root : '/wp-json/') + 'pos/v1/' + endpoint,
                    method: 'POST',
                    beforeSend: function(xhr) {
                        if (window.wpApiSettings && wpApiSettings.nonce) {
                            xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);
                        }
                    },
                    data: data,
                    success: function(response) {
                        showMessage(response.message, 'success');
                        clearTab(tab);
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        const message = response && response.error ? response.error : 'Transaction failed';
                        showMessage(message, 'error');
                    }
                });
            }

            function clearTab(tab) {
                $('#' + tab + '-player-name').val('');
                $('#' + tab + '-transaction-items').empty();
                $('#' + tab + '-player-status').hide();
                
                if (tab === 'admin') {
                    $('#admin-register-player').val('');
                    $('#admin-register-status').hide();
                    $('#admin-no-buys').prop('checked', false);
                    $('#admin-no-claims').prop('checked', false);
                }
                
                // Add one empty item row
                addTransactionItem(tab);
            }
        })(jQuery);
    </script>
    <?php
    return ob_get_clean();
}

// Register the shortcode
add_shortcode('pos_interface', 'pos_interface_shortcode');