/**
 * Legacy Shop Teller JavaScript
 * Replicates the Google Sheets workflow for Admin, Popup, Haldore, and Beehive shops
 */

class LegacyShopTeller {
    constructor() {
        this.currentShop = 'admin';
        this.selectedPlayer = null;
        this.currentTransaction = {
            admin: { buys: [], claims: [], totals: { cost: 0, ymir: 0, gold: 0 } },
            popup: { items: [], totals: { cost: 0, ymir: 0 } },
            haldore: { items: [], totals: { cost: 0 } },
            beehive: { items: [], totals: { cost: 0 } }
        };
        this.availableItems = [];
        this.players = [];
        
        this.init();
    }
    
    init() {
        this.bindEvents();
        this.loadPlayers();
        this.loadItems();
        this.setActiveShop('admin');
    }
    
    bindEvents() {
        // Shop tab switching
        $(document).on('click', '.shop-tab', (e) => {
            const shopType = $(e.target).data('shop');
            this.setActiveShop(shopType);
        });
        
        // Player registration
        $('#register-player-btn').on('click', () => this.registerPlayer());
        $('#new-player-name').on('keypress', (e) => {
            if (e.which === 13) this.registerPlayer();
        });
        
        // Player selection
        $('#transaction-player').on('change', (e) => {
            this.selectedPlayer = e.target.value;
            this.validatePlayer();
        });
        
        // Transaction actions
        $('#validate-transaction').on('click', () => this.validateTransaction());
        $('#record-transaction').on('click', () => this.recordTransaction());
        $('#clear-transaction').on('click', () => this.clearTransaction());
        
        // Admin shop specific
        $('#admin-no-buys').on('change', () => this.toggleAdminSections());
        $('#admin-no-claims').on('change', () => this.toggleAdminSections());
        
        // Add item buttons
        $(document).on('click', '.add-item-btn', (e) => {
            const type = $(e.target).data('type') || 'item';
            this.openItemSelectionModal(type);
        });
        
        // Item selection modal
        $('#select-item-btn').on('click', () => this.selectItem());
        $('#item-search-input').on('input', () => this.filterItems());
        $(document).on('click', '.available-item', (e) => {
            $('.available-item').removeClass('selected');
            $(e.currentTarget).addClass('selected');
            $('#select-item-btn').prop('disabled', false);
        });
        
        // Admin tools
        $('#player-rename-tool').on('click', () => this.openPlayerRenameModal());
        $('#world-reset-tool').on('click', () => this.openWorldResetModal());
        $('#confirm-rename-btn').on('click', () => this.confirmPlayerRename());
        $('#confirm-world-reset-btn').on('click', () => this.confirmWorldReset());
        
        // Modal management
        $('.jotun-modal-close').on('click', (e) => {
            $(e.target).closest('.jotun-modal').hide();
        });
        
        // Remove item buttons
        $(document).on('click', '.remove-item-btn', (e) => {
            const itemId = $(e.target).data('item-id');
            const type = $(e.target).data('type');
            this.removeItem(itemId, type);
        });
    }
    
    setActiveShop(shopType) {
        this.currentShop = shopType;
        
        // Update tabs
        $('.shop-tab').removeClass('active');
        $(`.shop-tab[data-shop="${shopType}"]`).addClass('active');
        
        // Update transaction forms
        $('.shop-transaction-form').removeClass('active');
        $(`#${shopType}-transaction`).addClass('active');
        
        // Load shop-specific items
        this.loadShopItems(shopType);
        
        // Clear current selection
        this.selectedPlayer = null;
        $('#transaction-player').val('');
        this.clearTransaction();
    }
    
    async loadPlayers() {
        try {
            const response = await JotunAPI.getPlayers();
            this.players = response.data || [];
            
            const playerDropdowns = $('.player-dropdown');
            playerDropdowns.empty().append('<option value="">-- Select Player --</option>');
            
            this.players.forEach(player => {
                const option = `<option value="${player.activePlayerName}">${player.activePlayerName}</option>`;
                playerDropdowns.append(option);
            });
        } catch (error) {
            console.error('Failed to load players:', error);
            this.showStatus('error', 'Failed to load players');
        }
    }
    
    async loadItems() {
        try {
            const response = await JotunAPI.getItems();
            this.availableItems = response.data || [];
        } catch (error) {
            console.error('Failed to load items:', error);
        }
    }
    
    async loadShopItems(shopType) {
        try {
            // Get shop by type
            const shopsResponse = await JotunAPI.getShops();
            const shop = shopsResponse.data.find(s => s.shop_type === shopType);
            
            if (shop) {
                // Get items for this shop
                const itemsResponse = await JotunAPI.getShopItems(shop.id);
                const shopItems = itemsResponse.data || [];
                
                // Display available items for this shop
                this.displayShopItems(shopType, shopItems);
            }
        } catch (error) {
            console.error(`Failed to load ${shopType} shop items:`, error);
        }
    }
    
    displayShopItems(shopType, shopItems) {
        const container = $(`#${shopType}-items`);
        container.empty();
        
        shopItems.forEach(shopItem => {
            const item = this.availableItems.find(i => i.id === shopItem.item_id);
            if (item) {
                const price = shopItem.custom_price || item.unit_price;
                const itemHtml = `
                    <div class="shop-item" data-item-id="${item.id}" data-price="${price}">
                        <div class="item-name">${item.item_name}</div>
                        <div class="item-price">${price} coins</div>
                        <div class="item-controls">
                            <input type="number" class="item-quantity" min="1" value="1">
                            <button class="add-to-transaction-btn btn btn-sm">Add</button>
                        </div>
                    </div>
                `;
                container.append(itemHtml);
            }
        });
        
        // Bind add to transaction events
        container.find('.add-to-transaction-btn').on('click', (e) => {
            const itemElement = $(e.target).closest('.shop-item');
            const itemId = itemElement.data('item-id');
            const price = itemElement.data('price');
            const quantity = parseInt(itemElement.find('.item-quantity').val()) || 1;
            
            this.addItemToTransaction(itemId, quantity, price, 'buy');
        });
    }
    
    async registerPlayer() {
        const playerName = $('#new-player-name').val().trim();
        
        if (!playerName) {
            this.showStatus('error', 'Please enter a player name', 'registration-status');
            return;
        }
        
        try {
            await JotunAPI.createPlayer({ activePlayerName: playerName });
            this.showStatus('success', `Player "${playerName}" registered successfully!`, 'registration-status');
            $('#new-player-name').val('');
            this.loadPlayers();
        } catch (error) {
            this.showStatus('error', `Failed to register player: ${error.message}`, 'registration-status');
        }
    }
    
    async validatePlayer() {
        if (!this.selectedPlayer) {
            $('#player-status').html('');
            return;
        }
        
        try {
            const response = await JotunAPI.validatePlayer(this.selectedPlayer);
            if (response.exists) {
                this.showStatus('success', 'Player found and validated', 'player-status');
                $('#validate-transaction').prop('disabled', false);
            } else {
                this.showStatus('error', 'Player not found in system', 'player-status');
                $('#validate-transaction').prop('disabled', true);
            }
        } catch (error) {
            this.showStatus('error', 'Failed to validate player', 'player-status');
        }
    }
    
    toggleAdminSections() {
        const noBuys = $('#admin-no-buys').is(':checked');
        const noClaims = $('#admin-no-claims').is(':checked');
        
        $('.buy-section').toggle(!noBuys);
        $('.claim-section').toggle(!noClaims);
        
        if (noBuys) {
            this.currentTransaction.admin.buys = [];
            this.updateTransactionDisplay('admin');
        }
        
        if (noClaims) {
            this.currentTransaction.admin.claims = [];
            this.updateTransactionDisplay('admin');
        }
    }
    
    openItemSelectionModal(type) {
        this.currentSelectionType = type;
        
        const modal = $('#item-selection-modal');
        const container = $('#available-items');
        
        container.empty();
        
        this.availableItems.forEach(item => {
            const itemHtml = `
                <div class="available-item" data-item-id="${item.id}">
                    <div class="item-name">${item.item_name}</div>
                    <div class="item-type">${item.item_type}</div>
                    <div class="item-price">${item.unit_price} coins</div>
                </div>
            `;
            container.append(itemHtml);
        });
        
        modal.show();
        $('#item-search-input').focus();
    }
    
    filterItems() {
        const searchTerm = $('#item-search-input').val().toLowerCase();
        
        $('.available-item').each(function() {
            const itemName = $(this).find('.item-name').text().toLowerCase();
            const itemType = $(this).find('.item-type').text().toLowerCase();
            
            if (itemName.includes(searchTerm) || itemType.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
    
    selectItem() {
        const selectedItem = $('.available-item.selected');
        if (selectedItem.length === 0) return;
        
        const itemId = selectedItem.data('item-id');
        const item = this.availableItems.find(i => i.id === itemId);
        
        if (item) {
            const quantity = 1; // Default quantity
            const price = item.unit_price;
            
            this.addItemToTransaction(itemId, quantity, price, this.currentSelectionType);
        }
        
        $('#item-selection-modal').hide();
        $('.available-item').removeClass('selected');
        $('#select-item-btn').prop('disabled', true);
        $('#item-search-input').val('');
    }
    
    addItemToTransaction(itemId, quantity, price, type) {
        const item = this.availableItems.find(i => i.id === itemId);
        if (!item) return;
        
        const transactionItem = {
            id: itemId,
            name: item.item_name,
            quantity: quantity,
            price: price,
            total: quantity * price
        };
        
        if (this.currentShop === 'admin') {
            if (type === 'buy') {
                this.currentTransaction.admin.buys.push(transactionItem);
            } else if (type === 'claim') {
                this.currentTransaction.admin.claims.push(transactionItem);
            }
        } else {
            this.currentTransaction[this.currentShop].items.push(transactionItem);
        }
        
        this.updateTransactionDisplay(this.currentShop);
    }
    
    removeItem(itemId, type) {
        if (this.currentShop === 'admin') {
            if (type === 'buy') {
                this.currentTransaction.admin.buys = this.currentTransaction.admin.buys.filter(item => item.id !== itemId);
            } else if (type === 'claim') {
                this.currentTransaction.admin.claims = this.currentTransaction.admin.claims.filter(item => item.id !== itemId);
            }
        } else {
            this.currentTransaction[this.currentShop].items = this.currentTransaction[this.currentShop].items.filter(item => item.id !== itemId);
        }
        
        this.updateTransactionDisplay(this.currentShop);
    }
    
    updateTransactionDisplay(shopType) {
        if (shopType === 'admin') {
            this.updateAdminTransactionDisplay();
        } else {
            this.updateGenericTransactionDisplay(shopType);
        }
    }
    
    updateAdminTransactionDisplay() {
        const transaction = this.currentTransaction.admin;
        
        // Update buy items
        const buyContainer = $('#admin-buy-items');
        buyContainer.empty();
        transaction.buys.forEach(item => {
            const itemHtml = `
                <div class="transaction-item">
                    <span>${item.name} x${item.quantity}</span>
                    <span>${item.total} coins</span>
                    <button class="remove-item-btn" data-item-id="${item.id}" data-type="buy">Remove</button>
                </div>
            `;
            buyContainer.append(itemHtml);
        });
        
        // Update claim items
        const claimContainer = $('#admin-claim-items');
        claimContainer.empty();
        transaction.claims.forEach(item => {
            const itemHtml = `
                <div class="transaction-item">
                    <span>${item.name} x${item.quantity}</span>
                    <span>Claim</span>
                    <button class="remove-item-btn" data-item-id="${item.id}" data-type="claim">Remove</button>
                </div>
            `;
            claimContainer.append(itemHtml);
        });
        
        // Update totals
        const totalCost = transaction.buys.reduce((sum, item) => sum + item.total, 0);
        transaction.totals = { cost: totalCost, ymir: 0, gold: 0 };
        
        $('#admin-total-cost').text(totalCost);
        $('#admin-ymir-flesh').text(transaction.totals.ymir);
        $('#admin-gold').text(transaction.totals.gold);
    }
    
    updateGenericTransactionDisplay(shopType) {
        const transaction = this.currentTransaction[shopType];
        const container = $(`#${shopType}-items`);
        
        // Clear and rebuild transaction items display
        const transactionContainer = container.find('.transaction-items');
        if (transactionContainer.length === 0) {
            container.append('<div class="transaction-items"></div>');
        }
        
        const displayContainer = container.find('.transaction-items');
        displayContainer.empty();
        
        transaction.items.forEach(item => {
            const itemHtml = `
                <div class="transaction-item">
                    <span>${item.name} x${item.quantity}</span>
                    <span>${item.total} coins</span>
                    <button class="remove-item-btn" data-item-id="${item.id}" data-type="item">Remove</button>
                </div>
            `;
            displayContainer.append(itemHtml);
        });
        
        // Update totals
        const totalCost = transaction.items.reduce((sum, item) => sum + item.total, 0);
        transaction.totals = { cost: totalCost };
        
        $(`#${shopType}-total-cost`).text(totalCost);
    }
    
    validateTransaction() {
        if (!this.selectedPlayer) {
            this.showStatus('error', 'Please select a player first', 'transaction-status');
            return;
        }
        
        const transaction = this.currentTransaction[this.currentShop];
        let hasItems = false;
        
        if (this.currentShop === 'admin') {
            hasItems = transaction.buys.length > 0 || transaction.claims.length > 0;
        } else {
            hasItems = transaction.items.length > 0;
        }
        
        if (!hasItems) {
            this.showStatus('error', 'Please add at least one item to the transaction', 'transaction-status');
            return;
        }
        
        this.showStatus('success', 'Transaction validated successfully', 'transaction-status');
        $('#record-transaction').prop('disabled', false);
    }
    
    async recordTransaction() {
        if (!this.selectedPlayer) {
            this.showStatus('error', 'No player selected', 'transaction-status');
            return;
        }
        
        try {
            $('#record-transaction').prop('disabled', true).text('Recording...');
            
            const transactionData = this.buildTransactionData();
            
            // Record using the comprehensive API
            await JotunAPI.recordTransaction(transactionData);
            
            this.showStatus('success', `Transaction with ${this.selectedPlayer} recorded successfully!`, 'transaction-status');
            this.clearTransaction();
            
        } catch (error) {
            this.showStatus('error', `Failed to record transaction: ${error.message}`, 'transaction-status');
        } finally {
            $('#record-transaction').prop('disabled', false).text('Record Transaction');
        }
    }
    
    buildTransactionData() {
        const transaction = this.currentTransaction[this.currentShop];
        
        let items = [];
        if (this.currentShop === 'admin') {
            items = [...transaction.buys, ...transaction.claims];
        } else {
            items = transaction.items;
        }
        
        return {
            shop_type: this.currentShop,
            player: this.selectedPlayer,
            items: items.map(item => ({
                item_id: item.id,
                item_name: item.name,
                quantity: item.quantity,
                unit_price: item.price,
                total_price: item.total
            })),
            total_cost: transaction.totals.cost,
            transaction_date: new Date().toISOString()
        };
    }
    
    clearTransaction() {
        // Reset current transaction
        this.currentTransaction[this.currentShop] = this.currentShop === 'admin' 
            ? { buys: [], claims: [], totals: { cost: 0, ymir: 0, gold: 0 } }
            : { items: [], totals: { cost: 0 } };
        
        // Clear form elements
        $('#admin-no-buys, #admin-no-claims').prop('checked', false);
        this.toggleAdminSections();
        
        // Update displays
        this.updateTransactionDisplay(this.currentShop);
        
        // Reset validation
        $('#record-transaction').prop('disabled', true);
        $('#transaction-status').html('');
    }
    
    openPlayerRenameModal() {
        $('#player-rename-modal').show();
    }
    
    async confirmPlayerRename() {
        const currentPlayer = $('#rename-current-player').val();
        const newName = $('#rename-new-name').val().trim();
        
        if (!currentPlayer || !newName) {
            this.showStatus('error', 'Please select a player and enter a new name', 'rename-status');
            return;
        }
        
        try {
            const player = this.players.find(p => p.activePlayerName === currentPlayer);
            if (!player) {
                this.showStatus('error', 'Player not found', 'rename-status');
                return;
            }
            
            await JotunAPI.renamePlayer(player.id, { new_name: newName });
            
            this.showStatus('success', `Player renamed from "${currentPlayer}" to "${newName}"`, 'rename-status');
            $('#player-rename-modal').hide();
            this.loadPlayers();
            
        } catch (error) {
            this.showStatus('error', `Failed to rename player: ${error.message}`, 'rename-status');
        }
    }
    
    openWorldResetModal() {
        $('#world-reset-modal').show();
    }
    
    async confirmWorldReset() {
        const resetName = $('#world-reset-name').val().trim();
        const preserveLegacy = $('#preserve-legacy-items').is(':checked');
        
        if (!resetName) {
            this.showStatus('error', 'Please enter a reset name', 'world-reset-status');
            return;
        }
        
        if (!confirm(`This will permanently archive all current data and reset the system. Are you sure you want to proceed with "${resetName}"?`)) {
            return;
        }
        
        try {
            $('#confirm-world-reset-btn').prop('disabled', true).text('Processing...');
            
            // Call the world reset API endpoint
            const response = await fetch('/wp-json/jotunheim-magic/v1/world-reset', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': jotunAjax.nonce
                },
                body: JSON.stringify({
                    reset_name: resetName,
                    preserve_legacy_items: preserveLegacy
                })
            });
            
            const result = await response.json();
            
            if (result.success) {
                this.showStatus('success', `World reset "${resetName}" completed successfully!`, 'world-reset-status');
                $('#world-reset-modal').hide();
                
                // Refresh the interface
                window.location.reload();
            } else {
                throw new Error(result.error || 'World reset failed');
            }
            
        } catch (error) {
            this.showStatus('error', `World reset failed: ${error.message}`, 'world-reset-status');
        } finally {
            $('#confirm-world-reset-btn').prop('disabled', false).text('Confirm World Reset');
        }
    }
    
    showStatus(type, message, containerId = 'transaction-status') {
        const container = $(`#${containerId}`);
        container.removeClass('success error warning').addClass(type);
        container.html(message);
        
        // Auto-clear success messages after 5 seconds
        if (type === 'success') {
            setTimeout(() => {
                if (container.hasClass('success')) {
                    container.html('');
                }
            }, 5000);
        }
    }
}

// Initialize when document is ready
$(document).ready(function() {
    if ($('#legacy-shop-teller').length > 0) {
        window.legacyShopTeller = new LegacyShopTeller();
    }
});