/**
 * Unified Teller JavaScript
 * Handles shop-based point of sale operations
 */

class UnifiedTeller {
    constructor() {
        this.selectedShop = null;
        this.currentCustomer = null;
        this.transactionMode = 'buy'; // buy, sell, admin
        this.cart = [];
        this.shopItems = [];
        
        this.initializeEventListeners();
        this.loadInitialData();
    }

    initializeEventListeners() {
        // Shop selection
        document.getElementById('teller-shop-selector').addEventListener('change', (e) => this.selectShop(e.target.value));

        // Transaction mode selection
        document.querySelectorAll('.transaction-type-btn').forEach(btn => {
            btn.addEventListener('click', (e) => this.setTransactionMode(e.target.dataset.mode));
        });

        // Customer validation
        document.getElementById('validate-customer-btn').addEventListener('click', () => this.validateCustomer());
        document.getElementById('customer-name').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') this.validateCustomer();
        });

        // Item search and filter
        document.getElementById('item-search').addEventListener('input', () => this.filterItems());
        document.getElementById('item-category-filter').addEventListener('change', () => this.filterItems());

        // Cart actions
        document.getElementById('clear-cart-btn').addEventListener('click', () => this.clearCart());
        document.getElementById('process-transaction-btn').addEventListener('click', () => this.showTransactionModal());

        // History controls
        document.getElementById('history-filter').addEventListener('change', () => this.loadTransactionHistory());
        document.getElementById('history-date-filter').addEventListener('change', () => this.loadTransactionHistory());
        document.getElementById('refresh-history-btn').addEventListener('click', () => this.loadTransactionHistory());
    }

    async loadInitialData() {
        await this.loadShopsForSelector();
        await this.loadPlayerList();
        await this.loadTransactionHistory();
        this.setupPlayerAutocomplete();
    }
    
    async loadPlayerList() {
        try {
            const response = await JotunAPI.getPlayers();
            this.playerList = response.data || [];
            console.log('DEBUG - Loaded player list:', this.playerList);
        } catch (error) {
            console.error('Error loading player list:', error);
            this.playerList = [];
        }
    }
    
    setupPlayerAutocomplete() {
        const customerNameInput = document.getElementById('customer-name');
        const suggestionsContainer = document.createElement('div');
        suggestionsContainer.id = 'player-suggestions';
        suggestionsContainer.className = 'player-suggestions';
        suggestionsContainer.style.display = 'none';
        
        // Insert suggestions container after the input
        customerNameInput.parentNode.insertBefore(suggestionsContainer, customerNameInput.nextSibling);
        
        let currentSuggestionIndex = -1;
        
        // Show all players when input is focused and empty
        customerNameInput.addEventListener('focus', (e) => {
            if (e.target.value.trim() === '' && this.playerList.length > 0) {
                this.displayPlayerSuggestions(this.playerList.slice(0, 10), suggestionsContainer, customerNameInput);
            }
        });
        
        customerNameInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            
            if (query.length === 0) {
                // Show all players when empty
                this.displayPlayerSuggestions(this.playerList.slice(0, 10), suggestionsContainer, customerNameInput);
                return;
            }
            
            if (query.length < 1) {
                suggestionsContainer.style.display = 'none';
                return;
            }
            
            const filteredPlayers = this.playerList.filter(player => 
                player.player_name.toLowerCase().includes(query)
            ).slice(0, 10); // Show max 10 suggestions
            
            this.displayPlayerSuggestions(filteredPlayers, suggestionsContainer, customerNameInput);
        });
        
        customerNameInput.addEventListener('keydown', (e) => {
            const suggestions = suggestionsContainer.querySelectorAll('.player-suggestion-item');
            
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                currentSuggestionIndex = Math.min(currentSuggestionIndex + 1, suggestions.length - 1);
                this.highlightPlayerSuggestion(suggestions, currentSuggestionIndex);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                currentSuggestionIndex = Math.max(currentSuggestionIndex - 1, -1);
                this.highlightPlayerSuggestion(suggestions, currentSuggestionIndex);
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (currentSuggestionIndex >= 0 && suggestions[currentSuggestionIndex]) {
                    suggestions[currentSuggestionIndex].click();
                }
            } else if (e.key === 'Escape') {
                suggestionsContainer.style.display = 'none';
                currentSuggestionIndex = -1;
            }
        });
        
        // Hide suggestions when clicking outside
        document.addEventListener('click', (e) => {
            if (!customerNameInput.contains(e.target) && !suggestionsContainer.contains(e.target)) {
                suggestionsContainer.style.display = 'none';
            }
        });
    }
    
    displayPlayerSuggestions(players, container, input) {
        if (players.length === 0) {
            container.style.display = 'none';
            return;
        }
        
        container.innerHTML = '';
        
        players.forEach(player => {
            const div = document.createElement('div');
            div.className = 'player-suggestion-item';
            div.innerHTML = `
                <div class="player-name">${player.player_name}</div>
                <div class="player-status ${player.is_active ? 'active' : 'inactive'}">${player.is_active ? 'Active' : 'Inactive'}</div>
            `;
            
            div.addEventListener('click', () => {
                input.value = player.player_name;
                container.style.display = 'none';
                
                // Automatically validate the selected customer
                this.validateCustomer();
            });
            
            container.appendChild(div);
        });
        
        container.style.display = 'block';
    }
    
    highlightPlayerSuggestion(suggestions, index) {
        suggestions.forEach((s, i) => {
            s.classList.toggle('highlighted', i === index);
        });
    }

    async loadShopsForSelector() {
        try {
            console.log('Loading shops for selector...');
            if (typeof JotunAPI === 'undefined') {
                throw new Error('JotunAPI is not available');
            }
            
            const response = await JotunAPI.getShops();
            console.log('Shop API response:', response);
            const shops = response.data || [];
            this.populateShopSelector(shops);
        } catch (error) {
            console.error('Error loading shops:', error);
            this.showStatus('Failed to load shops: ' + error.message, 'error');
            
            // Show error in dropdown
            const selector = document.getElementById('teller-shop-selector');
            selector.innerHTML = '<option value="">Error loading shops - check console</option>';
        }
    }

    populateShopSelector(shops) {
        console.log('DEBUG - Populating unified teller shop selector with:', shops);
        const selector = document.getElementById('teller-shop-selector');
        selector.innerHTML = '<option value="">Select a shop to begin...</option>';

        shops.forEach(shop => {
            console.log('DEBUG - Processing shop:', shop);
            if (shop.is_active == 1) {
                const option = document.createElement('option');
                option.value = shop.shop_id; // Fixed: was shop.id, should be shop.shop_id
                option.textContent = `${shop.shop_name} (${shop.shop_type})`;
                option.dataset.shopName = shop.shop_name;
                option.dataset.shopType = shop.shop_type;
                selector.appendChild(option);
                console.log('DEBUG - Added shop option:', option.textContent);
            } else {
                console.log('DEBUG - Skipping inactive shop:', shop.shop_name);
            }
        });
        
        console.log('DEBUG - Shop selector populated with', selector.options.length - 1, 'active shops');
    }

    async selectShop(shopId) {
        this.selectedShop = shopId;
        
        if (shopId) {
            // Show shop info
            const selectedOption = document.querySelector(`#teller-shop-selector option[value="${shopId}"]`);
            document.getElementById('shop-name-display').textContent = selectedOption.dataset.shopName;
            document.getElementById('shop-type-display').textContent = selectedOption.dataset.shopType;
            document.getElementById('shop-type-display').className = `shop-type-badge ${selectedOption.dataset.shopType}`;
            document.getElementById('shop-info').style.display = 'flex';

            // Show main interface
            document.getElementById('teller-main-interface').style.display = 'block';

            // Load shop items
            await this.loadShopItems(shopId);
        } else {
            // Hide interface
            document.getElementById('shop-info').style.display = 'none';
            document.getElementById('teller-main-interface').style.display = 'none';
            this.clearCart();
        }
    }

    async loadShopItems(shopId) {
        try {
            // Load shop items with joined item data
            const response = await JotunAPI.getShopItems({ shop_id: shopId });
            this.shopItems = response.data || [];
            
            // Also load master item list for reference
            const itemsResponse = await JotunAPI.getItemlist();
            const masterItems = itemsResponse.data || [];
            
            // Enrich shop items with master item data
            this.shopItems = this.shopItems.map(shopItem => {
                const masterItem = masterItems.find(item => item.id == shopItem.item_id);
                return {
                    ...shopItem,
                    item_name: masterItem?.item_name || shopItem.item_name || 'Unknown Item',
                    default_price: masterItem?.price || 0,
                    category: masterItem?.category || 'Uncategorized',
                    description: masterItem?.description || ''
                };
            });

            this.renderShopItems();
            this.populateItemCategories();
        } catch (error) {
            console.error('Error loading shop items:', error);
            this.showStatus('Failed to load shop items', 'error');
        }
    }

    renderShopItems() {
        const container = document.getElementById('shop-items-grid');
        container.innerHTML = '';

        this.shopItems.forEach(item => {
            if (item.is_available == 1) {
                const itemCard = this.createItemCard(item);
                container.appendChild(itemCard);
            }
        });
    }

    createItemCard(item) {
        const card = document.createElement('div');
        card.className = `item-card ${item.stock_quantity <= 0 ? 'out-of-stock' : ''}`;
        card.dataset.itemId = item.id;
        
        const price = item.price || item.default_price || 0;
        
        card.innerHTML = `
            <div class="item-name">${this.escapeHtml(item.item_name)}</div>
            <div class="item-price">$${parseFloat(price).toFixed(2)}</div>
            <div class="item-stock">Stock: ${item.stock_quantity || 0}</div>
            ${item.description ? `<div class="item-description">${this.escapeHtml(item.description)}</div>` : ''}
        `;

        if (item.stock_quantity > 0) {
            card.addEventListener('click', () => this.addToCart(item));
        }

        return card;
    }

    populateItemCategories() {
        const categories = [...new Set(this.shopItems.map(item => item.category))];
        const filter = document.getElementById('item-category-filter');
        
        filter.innerHTML = '<option value="">All Categories</option>';
        categories.forEach(category => {
            const option = document.createElement('option');
            option.value = category;
            option.textContent = category;
            filter.appendChild(option);
        });
    }

    filterItems() {
        const searchTerm = document.getElementById('item-search').value.toLowerCase();
        const categoryFilter = document.getElementById('item-category-filter').value;
        
        const cards = document.querySelectorAll('.item-card');
        
        this.shopItems.forEach((item, index) => {
            const card = cards[index];
            if (!card) return;
            
            const matchesSearch = !searchTerm || item.item_name.toLowerCase().includes(searchTerm);
            const matchesCategory = !categoryFilter || item.category === categoryFilter;
            
            card.style.display = matchesSearch && matchesCategory ? 'block' : 'none';
        });
    }

    setTransactionMode(mode) {
        this.transactionMode = mode;
        
        // Update button states
        document.querySelectorAll('.transaction-type-btn').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.mode === mode);
        });

        // Update interface based on mode
        this.updateInterfaceForMode(mode);
    }

    updateInterfaceForMode(mode) {
        const customerSection = document.querySelector('.player-section h3');
        
        switch (mode) {
            case 'buy':
                customerSection.textContent = 'Customer Information (Purchase)';
                break;
            case 'sell':
                customerSection.textContent = 'Customer Information (Sale to Customer)';
                break;
            case 'admin':
                customerSection.textContent = 'Player Information (Admin Transaction)';
                break;
        }
    }

    async validateCustomer() {
        const customerName = document.getElementById('customer-name').value.trim();
        if (!customerName) {
            this.showStatus('Please enter a customer name', 'error');
            return;
        }

        try {
            // Use the player validation API
            const response = await fetch('/wp-json/pos/v1/validate-player', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': typeof posAjax !== 'undefined' ? posAjax.nonce : ''
                },
                body: JSON.stringify({ player_name: customerName })
            });

            const result = await response.json();
            
            if (result.success) {
                this.currentCustomer = result.player;
                this.displayCustomerInfo(result.player);
                this.showCustomerStatus('Customer validated successfully', 'valid');
                document.getElementById('process-transaction-btn').disabled = this.cart.length === 0;
            } else {
                this.currentCustomer = null;
                this.showCustomerStatus(result.message || 'Customer not found', 'invalid');
                document.getElementById('customer-info').style.display = 'none';
                document.getElementById('process-transaction-btn').disabled = true;
            }
        } catch (error) {
            console.error('Error validating customer:', error);
            this.showCustomerStatus('Error validating customer', 'invalid');
            this.currentCustomer = null;
        }
    }

    displayCustomerInfo(customer) {
        document.getElementById('customer-id').textContent = customer.id;
        document.getElementById('customer-active-status').textContent = customer.is_active ? 'Active' : 'Inactive';
        document.getElementById('customer-registration').textContent = this.formatDate(customer.registration_date);
        document.getElementById('customer-info').style.display = 'block';
    }

    showCustomerStatus(message, type) {
        const statusDiv = document.getElementById('customer-status');
        statusDiv.textContent = message;
        statusDiv.className = `customer-status ${type}`;
        statusDiv.style.display = 'block';
    }

    addToCart(item) {
        if (!this.selectedShop) {
            this.showStatus('Please select a shop first', 'error');
            return;
        }

        // Check if item already in cart
        const existingCartItem = this.cart.find(cartItem => cartItem.id === item.id);
        
        if (existingCartItem) {
            // Increase quantity if stock allows
            if (existingCartItem.quantity < item.stock_quantity) {
                existingCartItem.quantity++;
                this.updateCartDisplay();
            } else {
                this.showStatus('Cannot add more - insufficient stock', 'error');
            }
        } else {
            // Add new item to cart
            const price = item.price || item.default_price || 0;
            this.cart.push({
                id: item.id,
                item_id: item.item_id,
                item_name: item.item_name,
                price: parseFloat(price),
                quantity: 1,
                max_stock: item.stock_quantity
            });
            this.updateCartDisplay();
        }
    }

    updateCartDisplay() {
        const cartItemsContainer = document.getElementById('cart-items');
        cartItemsContainer.innerHTML = '';

        let total = 0;

        this.cart.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;

            const cartItem = document.createElement('div');
            cartItem.className = 'cart-item';
            cartItem.innerHTML = `
                <div class="item-name">${this.escapeHtml(item.item_name)}</div>
                <div class="item-price">$${item.price.toFixed(2)}</div>
                <div class="item-quantity">
                    <input type="number" class="quantity-input" value="${item.quantity}" 
                           min="1" max="${item.max_stock}" 
                           onchange="unifiedTeller.updateCartItemQuantity(${index}, this.value)">
                </div>
                <div class="item-total">$${itemTotal.toFixed(2)}</div>
                <div class="item-actions">
                    <button class="btn btn-danger btn-sm" onclick="unifiedTeller.removeFromCart(${index})">Remove</button>
                </div>
            `;
            cartItemsContainer.appendChild(cartItem);
        });

        document.getElementById('cart-total-amount').textContent = total.toFixed(2);
        
        // Update process button state
        const canProcess = this.cart.length > 0 && this.currentCustomer;
        document.getElementById('process-transaction-btn').disabled = !canProcess;
    }

    updateCartItemQuantity(cartIndex, newQuantity) {
        const quantity = parseInt(newQuantity);
        const cartItem = this.cart[cartIndex];
        
        if (quantity > 0 && quantity <= cartItem.max_stock) {
            cartItem.quantity = quantity;
            this.updateCartDisplay();
        } else if (quantity > cartItem.max_stock) {
            this.showStatus(`Maximum quantity available: ${cartItem.max_stock}`, 'error');
            this.updateCartDisplay(); // Reset display
        }
    }

    removeFromCart(cartIndex) {
        this.cart.splice(cartIndex, 1);
        this.updateCartDisplay();
    }

    clearCart() {
        this.cart = [];
        this.updateCartDisplay();
    }

    showTransactionModal() {
        if (!this.currentCustomer) {
            this.showStatus('Please validate a customer first', 'error');
            return;
        }

        if (this.cart.length === 0) {
            this.showStatus('Please add items to cart', 'error');
            return;
        }

        // Generate transaction summary
        const summary = this.generateTransactionSummary();
        document.getElementById('transaction-summary').innerHTML = summary;
        document.getElementById('transaction-modal').style.display = 'block';
    }

    generateTransactionSummary() {
        const total = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const notes = document.getElementById('transaction-notes').value;

        let summary = `
            <div class="transaction-summary">
                <h4>Transaction Details</h4>
                <p><strong>Shop:</strong> ${document.getElementById('shop-name-display').textContent}</p>
                <p><strong>Customer:</strong> ${this.currentCustomer.playerName || this.currentCustomer.player_name}</p>
                <p><strong>Type:</strong> ${this.transactionMode.charAt(0).toUpperCase() + this.transactionMode.slice(1)}</p>
                
                <h5>Items:</h5>
                <ul>
        `;

        this.cart.forEach(item => {
            summary += `<li>${item.item_name} x${item.quantity} @ $${item.price.toFixed(2)} = $${(item.price * item.quantity).toFixed(2)}</li>`;
        });

        summary += `
                </ul>
                <p><strong>Total Amount: $${total.toFixed(2)}</strong></p>
                ${notes ? `<p><strong>Notes:</strong> ${this.escapeHtml(notes)}</p>` : ''}
            </div>
        `;

        return summary;
    }

    async confirmTransaction() {
        try {
            const transactionData = {
                shop_id: this.selectedShop,
                player_id: this.currentCustomer.id,
                player_name: this.currentCustomer.playerName || this.currentCustomer.player_name,
                transaction_type: this.transactionMode,
                items: this.cart,
                total_amount: this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0),
                notes: document.getElementById('transaction-notes').value,
                transaction_date: new Date().toISOString()
            };

            // Record transaction
            const response = await JotunAPI.addTransaction(transactionData);
            
            if (response.success !== false) {
                this.showStatus('Transaction completed successfully', 'success');
                
                // Clear cart and customer
                this.clearCart();
                this.currentCustomer = null;
                document.getElementById('customer-name').value = '';
                document.getElementById('customer-info').style.display = 'none';
                document.getElementById('customer-status').style.display = 'none';
                document.getElementById('transaction-notes').value = '';
                
                // Reload shop items (to update stock) and transaction history
                await this.loadShopItems(this.selectedShop);
                await this.loadTransactionHistory();
                
                this.closeTellerModal();
            } else {
                throw new Error(response.error || 'Transaction failed');
            }
        } catch (error) {
            console.error('Error processing transaction:', error);
            this.showStatus('Transaction failed: ' + error.message, 'error');
        }
    }

    async loadTransactionHistory() {
        try {
            const params = {};
            
            const typeFilter = document.getElementById('history-filter').value;
            if (typeFilter) params.transaction_type = typeFilter;
            
            const dateFilter = document.getElementById('history-date-filter').value;
            if (dateFilter) params.date_from = dateFilter;
            
            // Limit to recent transactions
            params.limit = 50;
            
            const response = await JotunAPI.getTransactions(params);
            const transactions = response.data || [];
            
            this.renderTransactionHistory(transactions);
        } catch (error) {
            console.error('Error loading transaction history:', error);
        }
    }

    renderTransactionHistory(transactions) {
        const container = document.getElementById('transaction-history');
        container.innerHTML = '';

        if (transactions.length === 0) {
            container.innerHTML = '<div class="transaction-item">No transactions found</div>';
            return;
        }

        transactions.forEach(transaction => {
            const transactionItem = document.createElement('div');
            transactionItem.className = 'transaction-item';
            transactionItem.innerHTML = `
                <div class="transaction-info">
                    <strong>${this.escapeHtml(transaction.player_name || 'Unknown')}</strong> - 
                    ${transaction.transaction_type || 'Unknown'} - 
                    ${this.formatDate(transaction.transaction_date)}
                    ${transaction.notes ? `<br><small>${this.escapeHtml(transaction.notes)}</small>` : ''}
                </div>
                <div class="transaction-amount">$${parseFloat(transaction.total_amount || 0).toFixed(2)}</div>
            `;
            container.appendChild(transactionItem);
        });
    }

    closeTellerModal() {
        document.getElementById('transaction-modal').style.display = 'none';
    }

    showStatus(message, type) {
        const statusDiv = document.getElementById('teller-status');
        statusDiv.textContent = message;
        statusDiv.className = `status-message ${type}`;
        statusDiv.style.display = 'block';

        setTimeout(() => {
            statusDiv.style.display = 'none';
        }, 3000);
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    formatDate(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
    }
}

// Global functions for modal and cart management
function closeTellerModal() {
    if (window.unifiedTeller) {
        window.unifiedTeller.closeTellerModal();
    }
}

function confirmTransaction() {
    if (window.unifiedTeller) {
        window.unifiedTeller.confirmTransaction();
    }
}

// Initialize unified teller when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('unified-teller-interface')) {
        // Wait for JotunAPI to be available
        const checkAPI = () => {
            if (typeof JotunAPI !== 'undefined' && JotunAPI) {
                console.log('JotunAPI is available, initializing UnifiedTeller');
                window.unifiedTeller = new UnifiedTeller();
            } else {
                console.log('JotunAPI not ready, waiting...');
                setTimeout(checkAPI, 100);
            }
        };
        checkAPI();
        
        // Add CSS for player suggestions
        const style = document.createElement('style');
        style.textContent = `
            .player-suggestions {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                border: 1px solid #ddd;
                border-radius: 4px;
                max-height: 200px;
                overflow-y: auto;
                z-index: 1000;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }
            
            .player-suggestion-item {
                padding: 8px 12px;
                cursor: pointer;
                border-bottom: 1px solid #eee;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            
            .player-suggestion-item:last-child {
                border-bottom: none;
            }
            
            .player-suggestion-item:hover,
            .player-suggestion-item.highlighted {
                background-color: #f5f5f5;
            }
            
            .player-name {
                font-weight: 500;
                color: #333;
            }
            
            .player-status {
                font-size: 12px;
                padding: 2px 6px;
                border-radius: 10px;
                text-transform: uppercase;
                font-weight: 500;
            }
            
            .player-status.active {
                background: #e8f5e8;
                color: #2e7d32;
            }
            
            .player-status.inactive {
                background: #ffebee;
                color: #c62828;
            }
            
            #customer-name {
                position: relative;
            }
        `;
        document.head.appendChild(style);
    }
});