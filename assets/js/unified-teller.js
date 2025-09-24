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
        const shopSelector = document.getElementById('teller-shop-selector');
        if (shopSelector) {
            shopSelector.addEventListener('change', (e) => this.selectShop(e.target.value));
        }

        // Customer validation
        const validateBtn = document.getElementById('validate-customer-btn');
        if (validateBtn) {
            validateBtn.addEventListener('click', () => this.validateCustomer());
        }
        
        const customerNameInput = document.getElementById('customer-name');
        if (customerNameInput) {
            customerNameInput.addEventListener('input', (e) => this.handleCustomerSearch(e.target.value));
            customerNameInput.addEventListener('keydown', (e) => this.handleCustomerKeydown(e));
            customerNameInput.addEventListener('blur', () => {
                // Delay hiding suggestions to allow clicks
                setTimeout(() => this.hideCustomerSuggestions(), 200);
            });
        }

        const turninCustomerNameInput = document.getElementById('turnin-customer-name');
        if (turninCustomerNameInput) {
            turninCustomerNameInput.addEventListener('input', (e) => this.handleTurninCustomerSearch(e.target.value));
            turninCustomerNameInput.addEventListener('keydown', (e) => this.handleTurninCustomerKeydown(e));
            turninCustomerNameInput.addEventListener('blur', () => {
                setTimeout(() => this.hideTurninCustomerSuggestions(), 200);
            });
        }

        // Register new player button
        const registerBtn = document.getElementById('register-new-player-btn');
        if (registerBtn) {
            registerBtn.addEventListener('click', () => this.registerNewPlayer());
        }

        // Item search
        const itemSearch = document.getElementById('item-search');
        if (itemSearch) {
            itemSearch.addEventListener('input', () => this.filterItems());
        }

        // Toggle view button
        const toggleViewBtn = document.getElementById('toggle-view-btn');
        if (toggleViewBtn) {
            toggleViewBtn.addEventListener('click', () => this.toggleItemsView());
        }

        // Transaction actions
        const clearTransactionBtn = document.getElementById('clear-transaction-btn');
        if (clearTransactionBtn) {
            clearTransactionBtn.addEventListener('click', () => this.clearCart());
        }
        
        const recordTransactionBtn = document.getElementById('record-transaction-btn');
        if (recordTransactionBtn) {
            recordTransactionBtn.addEventListener('click', () => this.showTransactionModal());
        }

        // History controls
        const historyFilter = document.getElementById('history-filter');
        if (historyFilter) {
            historyFilter.addEventListener('change', () => this.loadTransactionHistory());
        }
        
        const historyDateFilter = document.getElementById('history-date-filter');
        if (historyDateFilter) {
            historyDateFilter.addEventListener('change', () => this.loadTransactionHistory());
        }
        
        const refreshHistoryBtn = document.getElementById('refresh-history-btn');
        if (refreshHistoryBtn) {
            refreshHistoryBtn.addEventListener('click', () => this.loadTransactionHistory());
        }

        // Payment tracking
        const ymirFleshInput = document.getElementById('ymir-flesh-total');
        if (ymirFleshInput) {
            ymirFleshInput.addEventListener('input', () => this.updatePaymentCalculations());
        }

        const goldInput = document.getElementById('gold-total');
        if (goldInput) {
            goldInput.addEventListener('input', () => this.updatePaymentCalculations());
        }

        // Turn-in specific event listeners
        const turninValidateBtn = document.getElementById('turnin-validate-customer-btn');
        if (turninValidateBtn) {
            turninValidateBtn.addEventListener('click', () => this.validateTurninCustomer());
        }

        const clearTurninBtn = document.getElementById('clear-turnin-btn');
        if (clearTurninBtn) {
            clearTurninBtn.addEventListener('click', () => this.clearTurnin());
        }

        const recordTurninBtn = document.getElementById('record-turnin-btn');
        if (recordTurninBtn) {
            recordTurninBtn.addEventListener('click', () => this.recordTurnin());
        }
    }

    async loadInitialData() {
        console.log('UnifiedTeller: Starting to load initial data...');
        
        // Wait for JotunAPI to be available
        let attempts = 0;
        while (typeof JotunAPI === 'undefined' && attempts < 10) {
            console.log('Waiting for JotunAPI to be available...');
            await new Promise(resolve => setTimeout(resolve, 100));
            attempts++;
        }
        
        if (typeof JotunAPI === 'undefined') {
            console.error('JotunAPI is still not available after waiting');
            this.showStatus('API initialization failed. Please refresh the page.', 'error');
            return;
        }
        
        console.log('JotunAPI is available, loading data...');
        await this.loadShopsForSelector();
        await this.loadPlayerList();
        await this.loadTransactionHistory();
        await this.loadCurrentUserInfo();
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

    async loadCurrentUserInfo() {
        try {
            // Get current user info to populate teller name
            const response = await fetch('/wp-json/jotunheim-magic/v1/user/current', {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'X-WP-Nonce': jotunAjax.nonce
                }
            });
            
            if (response.ok) {
                const userData = await response.json();
                console.log('Current user data:', userData);
                
                // Populate teller name fields with Discord username
                const tellerNameField = document.getElementById('teller-name');
                const turninTellerNameField = document.getElementById('turnin-teller-name');
                
                const discordName = userData.data?.discord_username || userData.data?.display_name || 'Unknown User';
                
                if (tellerNameField) {
                    tellerNameField.value = discordName;
                }
                if (turninTellerNameField) {
                    turninTellerNameField.value = discordName;
                }
                
                this.currentTeller = {
                    name: discordName,
                    user_id: userData.data?.ID,
                    discord_id: userData.data?.discord_id
                };
                
            } else {
                console.error('Failed to load current user info');
                this.showStatus('Could not load teller information', 'warning');
            }
        } catch (error) {
            console.error('Error loading current user info:', error);
            this.showStatus('Error loading teller information', 'warning');
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
            console.log('JotunAPI status:', typeof JotunAPI);
            console.log('jotun_api_vars:', typeof jotun_api_vars !== 'undefined' ? jotun_api_vars : 'undefined');
            
            if (typeof JotunAPI === 'undefined') {
                throw new Error('JotunAPI is not available');
            }
            
            // Test the API endpoint directly first
            const testUrl = '/wp-json/jotun-api/v1/shops';
            console.log('Testing direct API call to:', testUrl);
            
            const response = await JotunAPI.getShops();
            console.log('Shop API response:', response);
            
            if (response && response.data) {
                console.log('Shops data received:', response.data);
                const shops = response.data;
                this.populateShopSelector(shops);
                
                if (shops.length === 0) {
                    this.showStatus('No shops found in database. Contact admin to add shops.', 'info');
                }
            } else {
                console.error('Unexpected API response format:', response);
                throw new Error('API returned unexpected format');
            }
        } catch (error) {
            console.error('Error loading shops:', error);
            this.showStatus('Failed to load shops: ' + error.message, 'error');
            
            // Show error in dropdown
            const selector = document.getElementById('teller-shop-selector');
            if (selector) {
                selector.innerHTML = '<option value="">Error loading shops - check console</option>';
            } else {
                console.error('Shop selector element not found!');
            }
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

            // Check if this is a turn-in only shop
            const shopType = selectedOption.dataset.shopType;
            if (shopType === 'turn-in-only') {
                // Show turn-in interface
                document.getElementById('teller-turnin-interface').style.display = 'block';
                document.getElementById('teller-main-interface').style.display = 'none';
                await this.loadTurninItems(shopId);
            } else {
                // Show regular shop interface
                document.getElementById('teller-main-interface').style.display = 'block';
                document.getElementById('teller-turnin-interface').style.display = 'none';
                await this.loadShopItems(shopId);
            }
        } else {
            // Hide all interfaces
            document.getElementById('shop-info').style.display = 'none';
            document.getElementById('teller-main-interface').style.display = 'none';
            document.getElementById('teller-turnin-interface').style.display = 'none';
            this.clearCart();
        }
    }

    async loadShopItems(shopId) {
        try {
            console.log('Loading shop items for shop ID:', shopId);
            
            // Load shop items from jotun_shop_items table
            const shopItemsResponse = await JotunAPI.getShopItems({ shop_id: shopId });
            console.log('Shop items response:', shopItemsResponse);
            const shopItems = shopItemsResponse.data || [];
            
            // Load master item list from jotun_item_list table for pricing and details
            const itemListResponse = await JotunAPI.getItemlist();
            console.log('Item list response:', itemListResponse);
            const masterItems = itemListResponse.data || [];
            
            // Enrich shop items with master item data including pricing from jotun_item_list
            this.shopItems = shopItems.map(shopItem => {
                const masterItem = masterItems.find(item => 
                    item.item_name === shopItem.item_name || 
                    item.id == shopItem.item_id ||
                    item.prefab_name === shopItem.prefab_name
                );
                
                if (masterItem) {
                    return {
                        ...shopItem,
                        item_name: masterItem.item_name || shopItem.item_name || 'Unknown Item',
                        unit_price: masterItem.unit_price || 0,
                        stack_size: masterItem.stack_size || 1,
                        stack_price: (masterItem.unit_price || 0) * (masterItem.stack_size || 1),
                        tech_tier: masterItem.tech_tier || 0,
                        tech_name: masterItem.tech_name || 'N/A',
                        item_type: masterItem.item_type || 'Unknown',
                        prefab_name: masterItem.prefab_name || shopItem.prefab_name,
                        undercut: masterItem.undercut || false,
                        description: masterItem.description || ''
                    };
                } else {
                    console.warn('No master item found for shop item:', shopItem);
                    return {
                        ...shopItem,
                        item_name: shopItem.item_name || 'Unknown Item',
                        unit_price: 0,
                        stack_size: 1,
                        stack_price: 0,
                        tech_tier: 0,
                        tech_name: 'N/A',
                        item_type: 'Unknown',
                        undercut: false,
                        description: ''
                    };
                }
            });

            console.log('Enriched shop items:', this.shopItems);
            this.displayShopItems();
        } catch (error) {
            console.error('Error loading shop items:', error);
            this.showStatus('Failed to load shop items', 'error');
        }
    }

    async loadTurninItems(shopId) {
        try {
            console.log('Loading turn-in items for shop ID:', shopId);
            // Load turn-in items from jotun_shop_items table
            const response = await JotunAPI.getShopItems({ shop_id: shopId });
            console.log('Turn-in items response:', response);
            this.turninItems = response.data || [];
            
            // Also load master item list for reference
            const itemsResponse = await JotunAPI.getItemlist();
            const masterItems = itemsResponse.data || [];
            
            // Enrich turn-in items with master item data
            this.turninItems = this.turninItems.map(shopItem => {
                const masterItem = masterItems.find(item => item.id == shopItem.item_id);
                return {
                    ...shopItem,
                    item_name: masterItem?.item_name || shopItem.item_name || 'Unknown Item',
                    event_points: shopItem.event_points || 0,
                    category: masterItem?.category || 'Uncategorized',
                    description: masterItem?.description || ''
                };
            });

            this.displayTurninItems();
        } catch (error) {
            console.error('Error loading turn-in items:', error);
            this.showStatus('Failed to load turn-in items', 'error');
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

    toggleItemsView() {
        const gridView = document.getElementById('items-grid-view');
        const tableView = document.getElementById('items-table-view');
        const toggleBtn = document.getElementById('toggle-view-btn');
        
        if (gridView && tableView && toggleBtn) {
            if (gridView.style.display === 'none') {
                // Switch to grid view
                gridView.style.display = 'grid';
                tableView.style.display = 'none';
                toggleBtn.textContent = 'Table View';
            } else {
                // Switch to table view
                gridView.style.display = 'none';
                tableView.style.display = 'block';
                toggleBtn.textContent = 'Grid View';
            }
        }
    }

    registerNewPlayer() {
        const customerName = document.getElementById('customer-name')?.value?.trim();
        if (!customerName) {
            this.showStatus('Please enter a customer name first', 'error');
            return;
        }
        
        // This would typically open a modal or form for player registration
        console.log('Register new player:', customerName);
        this.showStatus('Player registration functionality to be implemented', 'info');
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

    // Customer search functionality
    async handleCustomerSearch(searchTerm) {
        if (searchTerm.length < 2) {
            this.hideCustomerSuggestions();
            return;
        }

        try {
            const response = await JotunAPI.getPlayers();
            const players = response.data || [];
            
            const filteredPlayers = players.filter(player => 
                player.player_name.toLowerCase().includes(searchTerm.toLowerCase())
            );

            this.showCustomerSuggestions(filteredPlayers, 'customer-suggestions');
        } catch (error) {
            console.error('Error searching customers:', error);
        }
    }

    async handleTurninCustomerSearch(searchTerm) {
        if (searchTerm.length < 2) {
            this.hideTurninCustomerSuggestions();
            return;
        }

        try {
            const response = await JotunAPI.getPlayers();
            const players = response.data || [];
            
            const filteredPlayers = players.filter(player => 
                player.player_name.toLowerCase().includes(searchTerm.toLowerCase())
            );

            this.showCustomerSuggestions(filteredPlayers, 'turnin-customer-suggestions');
        } catch (error) {
            console.error('Error searching turnin customers:', error);
        }
    }

    showCustomerSuggestions(players, containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;

        if (players.length === 0) {
            container.style.display = 'none';
            return;
        }

        container.innerHTML = '';
        players.slice(0, 10).forEach((player, index) => {
            const suggestion = document.createElement('div');
            suggestion.className = 'customer-suggestion';
            suggestion.innerHTML = `
                <span class="customer-suggestion-name">${player.player_name}</span>
                <span class="customer-suggestion-status ${player.is_active ? 'active' : 'inactive'}">
                    ${player.is_active ? 'Active' : 'Inactive'}
                </span>
            `;
            suggestion.addEventListener('click', () => {
                if (containerId === 'customer-suggestions') {
                    this.selectCustomer(player);
                } else {
                    this.selectTurninCustomer(player);
                }
            });
            container.appendChild(suggestion);
        });

        container.style.display = 'block';
    }

    selectCustomer(player) {
        document.getElementById('customer-name').value = player.player_name;
        this.currentCustomer = player;
        this.hideCustomerSuggestions();
        this.displayCustomerInfo(player, 'customer');
    }

    selectTurninCustomer(player) {
        document.getElementById('turnin-customer-name').value = player.player_name;
        this.currentTurninCustomer = player;
        this.hideTurninCustomerSuggestions();
        this.displayCustomerInfo(player, 'turnin');
    }

    displayCustomerInfo(player, type) {
        const prefix = type === 'turnin' ? 'turnin-' : '';
        
        document.getElementById(`${prefix}customer-display-name`).textContent = player.player_name;
        document.getElementById(`${prefix}customer-active-status`).textContent = player.is_active ? 'Active' : 'Inactive';
        document.getElementById(`${prefix}customer-registration`).textContent = this.formatDate(player.created_at);
        document.getElementById(`${prefix}customer-info`).style.display = 'block';
        document.getElementById(`${prefix}customer-status`).style.display = 'none';
    }

    hideCustomerSuggestions() {
        const container = document.getElementById('customer-suggestions');
        if (container) container.style.display = 'none';
    }

    hideTurninCustomerSuggestions() {
        const container = document.getElementById('turnin-customer-suggestions');
        if (container) container.style.display = 'none';
    }

    handleCustomerKeydown(e) {
        // Handle arrow keys and enter for suggestion navigation
        const suggestions = document.querySelectorAll('#customer-suggestions .customer-suggestion');
        // Implementation for keyboard navigation would go here
    }

    handleTurninCustomerKeydown(e) {
        // Handle arrow keys and enter for suggestion navigation
        const suggestions = document.querySelectorAll('#turnin-customer-suggestions .customer-suggestion');
        // Implementation for keyboard navigation would go here
    }

    // Payment calculations
    updatePaymentCalculations() {
        const ymirFlesh = parseFloat(document.getElementById('ymir-flesh-total')?.value || 0);
        const gold = parseFloat(document.getElementById('gold-total')?.value || 0);
        const totalCost = parseFloat(document.getElementById('item-total-cost')?.textContent || 0);

        // Calculate total amount paid (assuming some conversion rate if needed)
        const amountPaid = ymirFlesh + gold; // Simplistic calculation
        const changeDue = amountPaid - totalCost;

        // Update display
        document.getElementById('amount-paid-display').textContent = amountPaid.toFixed(0);
        const changeDueElement = document.getElementById('change-due');
        changeDueElement.textContent = changeDue.toFixed(0);
        changeDueElement.className = `summary-value change-amount ${changeDue < 0 ? 'negative' : ''}`;

        // Update status
        const statusElement = document.getElementById('payment-balance');
        if (changeDue === 0) {
            statusElement.textContent = 'Balanced';
            statusElement.className = 'summary-status balanced';
        } else if (changeDue > 0) {
            statusElement.textContent = 'Overpaid';
            statusElement.className = 'summary-status overpaid';
        } else {
            statusElement.textContent = 'Underpaid';
            statusElement.className = 'summary-status underpaid';
        }
    }

    // Turn-in shop methods
    displayTurninItems() {
        const container = document.getElementById('turnin-items-grid');
        if (!container) return;

        container.innerHTML = '';

        if (this.turninItems.length === 0) {
            container.innerHTML = '<div class="no-items">No turn-in items available for this shop.</div>';
            return;
        }

        this.turninItems.forEach(item => {
            const itemCard = document.createElement('div');
            itemCard.className = 'item-card';
            itemCard.innerHTML = `
                <div class="item-name">${item.item_name}</div>
                <div class="item-points">Points: ${item.event_points || 0}</div>
                <div class="item-actions">
                    <button class="btn btn-secondary item-btn" onclick="window.unifiedTeller.addTurninItem(${item.shop_item_id})">
                        Turn In
                    </button>
                </div>
            `;
            container.appendChild(itemCard);
        });
    }

    addTurninItem(shopItemId) {
        const item = this.turninItems.find(i => i.shop_item_id == shopItemId);
        if (!item) return;

        // Add to turn-in list (simplified - would need quantity handling)
        if (!this.turninList) this.turninList = [];
        
        const existingItem = this.turninList.find(i => i.shop_item_id == shopItemId);
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            this.turninList.push({
                ...item,
                quantity: 1
            });
        }

        this.updateTurninDisplay();
    }

    updateTurninDisplay() {
        const container = document.getElementById('turnin-selected-items');
        if (!container) return;

        container.innerHTML = '';

        if (!this.turninList || this.turninList.length === 0) {
            container.innerHTML = '<div class="no-items">No items selected for turn-in.</div>';
            document.getElementById('record-turnin-btn').disabled = true;
            return;
        }

        this.turninList.forEach(item => {
            const itemRow = document.createElement('div');
            itemRow.className = 'transaction-item';
            itemRow.innerHTML = `
                <span>${item.item_name}</span>
                <span>${item.quantity}</span>
                <span>${item.event_points * item.quantity}</span>
                <button class="btn btn-outline btn-sm" onclick="window.unifiedTeller.removeTurninItem(${item.shop_item_id})">
                    Remove
                </button>
            `;
            container.appendChild(itemRow);
        });

        document.getElementById('record-turnin-btn').disabled = false;
    }

    removeTurninItem(shopItemId) {
        if (!this.turninList) return;
        this.turninList = this.turninList.filter(item => item.shop_item_id != shopItemId);
        this.updateTurninDisplay();
    }

    clearTurnin() {
        this.turninList = [];
        this.updateTurninDisplay();
        document.getElementById('turnin-notes').value = '';
    }

    validateTurninCustomer() {
        const customerName = document.getElementById('turnin-customer-name').value.trim();
        if (!customerName) {
            this.showStatus('Please enter a customer name', 'error');
            return;
        }
        // Would validate against player list
        this.showStatus('Turn-in customer validation to be implemented', 'info');
    }

    async recordTurnin() {
        if (!this.currentTurninCustomer) {
            this.showStatus('Please validate a customer first', 'error');
            return;
        }

        if (!this.turninList || this.turninList.length === 0) {
            this.showStatus('Please add items to turn in', 'error');
            return;
        }

        // Would record the turn-in transaction
        this.showStatus('Turn-in recording functionality to be implemented', 'info');
        console.log('Recording turn-in:', {
            customer: this.currentTurninCustomer,
            items: this.turninList,
            notes: document.getElementById('turnin-notes').value
        });
    }

    displayShopItems() {
        // Update the existing method to use the new structure
        const gridContainer = document.getElementById('items-grid-view');
        const tableContainer = document.getElementById('items-table-view');
        
        if (gridContainer) {
            this.renderItemsGrid(gridContainer);
        }
        
        if (tableContainer) {
            this.renderItemsTable(tableContainer);
        }
    }

    renderItemsGrid(container) {
        container.innerHTML = '';

        if (this.shopItems.length === 0) {
            container.innerHTML = '<div class="no-items">No items available for this shop.</div>';
            return;
        }

        this.shopItems.forEach(item => {
            const itemCard = document.createElement('div');
            itemCard.className = 'item-card';
            
            // Check if this is a turn-in only shop
            const isTurninShop = this.selectedShopData && this.selectedShopData.shop_type === 'turnin_only';
            
            if (isTurninShop) {
                itemCard.innerHTML = `
                    <div class="item-header">
                        <div class="item-name">${item.item_name}</div>
                        <div class="item-type">${item.item_type}</div>
                    </div>
                    <div class="item-details">
                        <div class="item-points">Event Points: ${item.event_points || 0}</div>
                        <div class="item-tech">Tech: ${item.tech_name} (Tier ${item.tech_tier})</div>
                    </div>
                    <div class="item-actions">
                        <div class="quantity-controls">
                            <input type="number" class="quantity-input" id="qty-${item.shop_item_id}" min="1" value="1" placeholder="Qty">
                        </div>
                        <button class="btn btn-secondary item-btn" onclick="window.unifiedTeller.addToTurnin(${item.shop_item_id})">
                            Turn In
                        </button>
                    </div>
                `;
            } else {
                itemCard.innerHTML = `
                    <div class="item-header">
                        <div class="item-name">${item.item_name}</div>
                        <div class="item-type">${item.item_type}</div>
                    </div>
                    <div class="item-pricing">
                        <div class="price-row">
                            <span class="price-label">Unit:</span>
                            <span class="price-value">${item.unit_price || 0}</span>
                        </div>
                        <div class="price-row">
                            <span class="price-label">Stack (${item.stack_size || 1}):</span>
                            <span class="price-value">${item.stack_price || 0}</span>
                        </div>
                        <div class="item-tech">Tech: ${item.tech_name} (Tier ${item.tech_tier})</div>
                    </div>
                    <div class="item-actions">
                        <div class="quantity-controls">
                            <input type="number" class="quantity-input" id="qty-${item.shop_item_id}" min="1" value="1" placeholder="Qty">
                            <button class="btn btn-sm btn-outline qty-btn" onclick="window.unifiedTeller.setStackQuantity(${item.shop_item_id})">
                                Stack
                            </button>
                        </div>
                        <div class="action-buttons">
                            <button class="btn btn-secondary item-btn" onclick="window.unifiedTeller.addToCart(${item.shop_item_id}, 'buy')">
                                Buy
                            </button>
                            <button class="btn btn-outline item-btn" onclick="window.unifiedTeller.addToCart(${item.shop_item_id}, 'sell')">
                                Sell
                            </button>
                        </div>
                    </div>
                `;
            }
            
            container.appendChild(itemCard);
        });
    }

    renderItemsTable(container) {
        const tableBody = container.querySelector('#items-table-body');
        if (!tableBody) return;

        tableBody.innerHTML = '';

        if (this.shopItems.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="8">No items available for this shop.</td></tr>';
            return;
        }

        const isTurninShop = this.selectedShopData && this.selectedShopData.shop_type === 'turnin_only';

        // Update table headers for turn-in shops
        const tableHeader = container.querySelector('thead tr');
        if (tableHeader && isTurninShop) {
            tableHeader.innerHTML = `
                <th>Item</th>
                <th>Qty</th>
                <th>Turn In</th>
                <th>Points</th>
                <th>Item</th>
                <th>Qty</th>
                <th>Turn In</th>
                <th>Points</th>
            `;
        } else if (tableHeader && !isTurninShop) {
            tableHeader.innerHTML = `
                <th>Item</th>
                <th>Buy</th>
                <th>Sell</th>
                <th>Price</th>
                <th>Item</th>
                <th>Buy</th>
                <th>Sell</th>
                <th>Price</th>
            `;
        }

        // Render items in pairs for two-column layout
        for (let i = 0; i < this.shopItems.length; i += 2) {
            const item1 = this.shopItems[i];
            const item2 = this.shopItems[i + 1];

            const row = document.createElement('tr');
            
            if (isTurninShop) {
                row.innerHTML = `
                    <td>${item1.item_name}</td>
                    <td><input type="number" class="table-qty-input" id="table-qty-${item1.shop_item_id}" min="1" value="1"></td>
                    <td><button class="btn btn-sm btn-secondary" onclick="window.unifiedTeller.addToTurnin(${item1.shop_item_id})">Turn In</button></td>
                    <td>${item1.event_points || 0}</td>
                    ${item2 ? `
                        <td>${item2.item_name}</td>
                        <td><input type="number" class="table-qty-input" id="table-qty-${item2.shop_item_id}" min="1" value="1"></td>
                        <td><button class="btn btn-sm btn-secondary" onclick="window.unifiedTeller.addToTurnin(${item2.shop_item_id})">Turn In</button></td>
                        <td>${item2.event_points || 0}</td>
                    ` : '<td colspan="4"></td>'}
                `;
            } else {
                row.innerHTML = `
                    <td>${item1.item_name}</td>
                    <td><button class="btn btn-sm btn-secondary" onclick="window.unifiedTeller.addToCart(${item1.shop_item_id}, 'buy')">Buy</button></td>
                    <td><button class="btn btn-sm btn-outline" onclick="window.unifiedTeller.addToCart(${item1.shop_item_id}, 'sell')">Sell</button></td>
                    <td>${item1.unit_price || 0}</td>
                    ${item2 ? `
                        <td>${item2.item_name}</td>
                        <td><button class="btn btn-sm btn-secondary" onclick="window.unifiedTeller.addToCart(${item2.shop_item_id}, 'buy')">Buy</button></td>
                        <td><button class="btn btn-sm btn-outline" onclick="window.unifiedTeller.addToCart(${item2.shop_item_id}, 'sell')">Sell</button></td>
                        <td>${item2.unit_price || 0}</td>
                    ` : '<td colspan="4"></td>'}
                `;
            }
            tableBody.appendChild(row);
        }
    }

    // Cart and transaction methods
    setStackQuantity(shopItemId) {
        const item = this.shopItems.find(i => i.shop_item_id == shopItemId);
        if (!item) return;
        
        const qtyInput = document.getElementById(`qty-${shopItemId}`);
        if (qtyInput) {
            qtyInput.value = item.stack_size || 1;
        }
    }

    addToCart(shopItemId, action = 'buy') {
        const item = this.shopItems.find(i => i.shop_item_id == shopItemId);
        if (!item) {
            this.showStatus('Item not found', 'error');
            return;
        }

        // Get quantity from input
        const qtyInput = document.getElementById(`qty-${shopItemId}`) || document.getElementById(`table-qty-${shopItemId}`);
        const quantity = qtyInput ? parseInt(qtyInput.value) || 1 : 1;

        if (quantity <= 0) {
            this.showStatus('Invalid quantity', 'error');
            return;
        }

        // Calculate price based on quantity and unit price
        const unitPrice = item.unit_price || 0;
        const totalPrice = unitPrice * quantity;

        // Add to cart or update existing cart item
        const existingItem = this.cart.find(cartItem => 
            cartItem.shop_item_id === shopItemId && cartItem.action === action
        );

        if (existingItem) {
            existingItem.quantity += quantity;
            existingItem.total_price = existingItem.unit_price * existingItem.quantity;
        } else {
            this.cart.push({
                shop_item_id: shopItemId,
                item_name: item.item_name,
                action: action,
                quantity: quantity,
                unit_price: unitPrice,
                total_price: totalPrice,
                stack_size: item.stack_size || 1
            });
        }

        this.updateCartDisplay();
        this.updatePaymentCalculations();
        this.showStatus(`Added ${quantity} ${item.item_name} to cart (${action})`, 'success');

        // Reset quantity input
        if (qtyInput) {
            qtyInput.value = 1;
        }
    }

    addToTurnin(shopItemId) {
        const item = this.shopItems.find(i => i.shop_item_id == shopItemId);
        if (!item) {
            this.showStatus('Item not found', 'error');
            return;
        }

        // Get quantity from input
        const qtyInput = document.getElementById(`qty-${shopItemId}`) || document.getElementById(`table-qty-${shopItemId}`);
        const quantity = qtyInput ? parseInt(qtyInput.value) || 1 : 1;

        if (quantity <= 0) {
            this.showStatus('Invalid quantity', 'error');
            return;
        }

        // Initialize turnin list if not exists
        if (!this.turninList) this.turninList = [];

        // Add to turnin list or update existing
        const existingItem = this.turninList.find(turninItem => 
            turninItem.shop_item_id === shopItemId
        );

        if (existingItem) {
            existingItem.quantity += quantity;
            existingItem.total_points = (item.event_points || 0) * existingItem.quantity;
        } else {
            this.turninList.push({
                shop_item_id: shopItemId,
                item_name: item.item_name,
                quantity: quantity,
                event_points: item.event_points || 0,
                total_points: (item.event_points || 0) * quantity
            });
        }

        this.updateTurninDisplay();
        this.showStatus(`Added ${quantity} ${item.item_name} to turn-in list`, 'success');

        // Reset quantity input
        if (qtyInput) {
            qtyInput.value = 1;
        }
    }

    updateCartDisplay() {
        const container = document.getElementById('transaction-items');
        if (!container) return;

        container.innerHTML = '';

        if (this.cart.length === 0) {
            container.innerHTML = '<div class="no-items">No items in cart.</div>';
            document.getElementById('record-transaction-btn').disabled = true;
            return;
        }

        let totalCost = 0;

        this.cart.forEach((cartItem, index) => {
            const itemRow = document.createElement('div');
            itemRow.className = 'transaction-item';
            itemRow.innerHTML = `
                <div class="item-info">
                    <span class="item-name">${cartItem.item_name}</span>
                    <span class="item-action ${cartItem.action}">${cartItem.action.toUpperCase()}</span>
                </div>
                <div class="item-quantity">
                    <input type="number" class="cart-qty-input" value="${cartItem.quantity}" 
                           min="1" onchange="window.unifiedTeller.updateCartItemQuantity(${index}, this.value)">
                    <span class="stack-info">/ ${cartItem.stack_size}</span>
                </div>
                <div class="item-pricing">
                    <span class="unit-price">${cartItem.unit_price} each</span>
                    <span class="total-price">${cartItem.total_price} total</span>
                </div>
                <button class="btn btn-sm btn-danger" onclick="window.unifiedTeller.removeFromCart(${index})">
                    Remove
                </button>
            `;
            container.appendChild(itemRow);

            // Calculate total (buy adds to cost, sell subtracts)
            if (cartItem.action === 'buy') {
                totalCost += cartItem.total_price;
            } else if (cartItem.action === 'sell') {
                totalCost -= cartItem.total_price;
            }
        });

        // Update total cost display
        document.getElementById('item-total-cost').textContent = totalCost.toFixed(0);
        document.getElementById('record-transaction-btn').disabled = false;
    }

    updateCartItemQuantity(cartIndex, newQuantity) {
        const quantity = parseInt(newQuantity) || 1;
        if (quantity <= 0) return;

        if (this.cart[cartIndex]) {
            this.cart[cartIndex].quantity = quantity;
            this.cart[cartIndex].total_price = this.cart[cartIndex].unit_price * quantity;
            this.updateCartDisplay();
            this.updatePaymentCalculations();
        }
    }

    removeFromCart(cartIndex) {
        if (this.cart[cartIndex]) {
            this.cart.splice(cartIndex, 1);
            this.updateCartDisplay();
            this.updatePaymentCalculations();
        }
    }

    clearCart() {
        this.cart = [];
        this.updateCartDisplay();
        this.updatePaymentCalculations();
        this.showStatus('Cart cleared', 'info');
    }
    
    // Debug method to create test shops
    async debugCreateTestShops() {
        console.log('Creating test shops...');
        
        const testShops = [
            {
                shop_name: 'Haldore Trading Post',
                description: 'General trading post',
                shop_type: 'player',
                staff_only: 0,
                auto_archive: 0,
                ledger_name: 'Haldore Ledger',
                owner_name: 'Haldore',
                is_active: 1
            },
            {
                shop_name: 'Beehive Marketplace',
                description: 'Community marketplace',
                shop_type: 'player',
                staff_only: 0,
                auto_archive: 0,
                ledger_name: 'Beehive Ledger',
                owner_name: 'Community',
                is_active: 1
            },
            {
                shop_name: 'Staff Admin Shop',
                description: 'Administrative transactions',
                shop_type: 'staff',
                staff_only: 1,
                auto_archive: 0,
                ledger_name: 'Admin Ledger',
                owner_name: 'Admin',
                is_active: 1
            }
        ];
        
        for (const shopData of testShops) {
            try {
                console.log('Creating shop:', shopData.shop_name);
                const result = await JotunAPI.addShop(shopData);
                console.log('Shop created:', result);
            } catch (error) {
                console.error('Error creating shop:', shopData.shop_name, error);
            }
        }
        
        console.log('Test shops creation complete. Reloading shops...');
        await this.loadShopsForSelector();
    }
    
    // Debug method to test API endpoints
    async debugTestAPI() {
        console.log('Testing API endpoints...');
        
        try {
            console.log('Testing getShops...');
            const shopsResult = await JotunAPI.getShops();
            console.log('Shops result:', shopsResult);
            
            console.log('Testing getPlayers...');
            const playersResult = await JotunAPI.getPlayers();
            console.log('Players result:', playersResult);
            
            console.log('Testing getTransactions...');
            const transactionsResult = await JotunAPI.getTransactions();
            console.log('Transactions result:', transactionsResult);
            
        } catch (error) {
            console.error('API test error:', error);
        }
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