/**
 * Unified Teller JavaScript
 * Handles shop-based point of sale operations
 */

class UnifiedTeller {
    constructor() {
        console.log('UnifiedTeller constructor called');
        this.selectedShop = null;
        this.currentCustomer = null;
        this.transactionMode = 'buy'; // buy, sell, admin
        this.cart = [];
        this.shopItems = [];
        this.isTableView = false; // Track current view state
        this.isCartView = false; // Track cart view state
        
        this.initializeEventListeners();
        this.loadInitialData();
        console.log('UnifiedTeller constructor completed, preventOverLimit method:', typeof this.preventOverLimit);
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

        // Shop refresh button
        const refreshShopBtn = document.getElementById('refresh-shop-btn');
        if (refreshShopBtn) {
            refreshShopBtn.addEventListener('click', () => this.refreshCurrentShopData());
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
        this.setupRegisterButton();

        // Item search
        const itemSearch = document.getElementById('item-search');
        if (itemSearch) {
            itemSearch.addEventListener('input', () => this.filterItems());
        }

        // Turn-in item search
        const turninItemSearch = document.getElementById('turnin-item-search');
        if (turninItemSearch) {
            turninItemSearch.addEventListener('input', () => this.filterTurninItems());
        }

        // Toggle view button
        const toggleViewBtn = document.getElementById('toggle-view-btn');
        if (toggleViewBtn) {
            toggleViewBtn.addEventListener('click', () => this.toggleItemsView());
        }

        // Transaction actions
        const clearTransactionBtn = document.getElementById('clear-transaction-btn');
        console.log('DEBUG: Clear transaction button found:', clearTransactionBtn);
        if (clearTransactionBtn) {
            clearTransactionBtn.addEventListener('click', () => {
                console.log('DEBUG: Clear transaction button clicked!');
                console.log('DEBUG: typeof this.clearCart:', typeof this.clearCart);
                console.log('DEBUG: this:', this);
                try {
                    console.log('🚨 ABOUT TO CALL clearCart()');
                    this.clearCart();
                    console.log('🚨 clearCart() CALL COMPLETED');
                } catch (error) {
                    console.error('🚨 ERROR calling clearCart():', error);
                    console.error('🚨 Error stack:', error.stack);
                }
            });
            console.log('DEBUG: Clear transaction event listener attached');
        } else {
            console.log('ERROR: Clear transaction button not found!');
        }
        
        const recordTransactionBtn = document.getElementById('record-transaction-btn');
        if (recordTransactionBtn) {
            recordTransactionBtn.addEventListener('click', () => this.showTransactionModal());
        }

        // Cart view toggle
        const viewCartBtn = document.getElementById('view-cart-btn');
        if (viewCartBtn) {
            viewCartBtn.addEventListener('click', () => this.showCartView());
        }

        const backToShopBtn = document.getElementById('back-to-shop-btn');
        if (backToShopBtn) {
            backToShopBtn.addEventListener('click', () => this.showShopView());
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

        // Change due tracking
        const changeYmirInput = document.getElementById('change-ymir-flesh');
        if (changeYmirInput) {
            changeYmirInput.addEventListener('input', () => this.updateChangeCalculation());
        }

        const changeGoldInput = document.getElementById('change-gold');
        if (changeGoldInput) {
            changeGoldInput.addEventListener('input', () => this.updateChangeCalculation());
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
                    'X-WP-Nonce': tellerAjax.nonce
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
                
            } else if (response.status === 403) {
                console.warn('User endpoint access denied - using fallback');
                // Fallback for permission issues
                const tellerNameField = document.getElementById('teller-name');
                const turninTellerNameField = document.getElementById('turnin-teller-name');
                
                if (tellerNameField) tellerNameField.value = 'Teller';
                if (turninTellerNameField) turninTellerNameField.value = 'Teller';
                
                this.currentTeller = { name: 'Teller', user_id: null, discord_id: null };
            } else {
                console.error('Failed to load current user info');
                this.showStatus('Could not load teller information', 'warning');
            }
        } catch (error) {
            console.error('Error loading current user info:', error);
            // Continue without user info - don't block the interface
            const tellerNameField = document.getElementById('teller-name');
            const turninTellerNameField = document.getElementById('turnin-teller-name');
            
            if (tellerNameField) tellerNameField.value = 'Teller';
            if (turninTellerNameField) turninTellerNameField.value = 'Teller';
            
            this.currentTeller = { name: 'Teller', user_id: null, discord_id: null };
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
                this.displayPlayerSuggestions(this.playerList.slice(0, 50), suggestionsContainer, customerNameInput);
            }
        });
        
        customerNameInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            
            if (query.length === 0) {
                // Show all players when empty
                this.displayPlayerSuggestions(this.playerList.slice(0, 50), suggestionsContainer, customerNameInput);
                return;
            }
            
            if (query.length < 1) {
                suggestionsContainer.style.display = 'none';
                return;
            }
            
            const filteredPlayers = this.playerList.filter(player => 
                (player.activePlayerName && player.activePlayerName.toLowerCase().includes(query)) ||
                (player.playerName && player.playerName.toLowerCase().includes(query))
            ).slice(0, 50); // Show max 50 suggestions
            
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
                <div class="player-name">${player.activePlayerName}</div>
                <div class="player-status ${player.is_active ? 'active' : 'inactive'}">${player.is_active ? 'Active' : 'Inactive'}</div>
            `;
            
            div.addEventListener('click', () => {
                input.value = player.activePlayerName;
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
                // Show only the shop name in the dropdown
                option.textContent = shop.shop_name;
                option.dataset.shopName = shop.shop_name;
                option.dataset.shopType = shop.shop_type;
                option.dataset.currentRotation = shop.current_rotation || 1; // Store current rotation
                selector.appendChild(option);
                console.log('DEBUG - Added shop option:', option.textContent, 'with rotation:', shop.current_rotation);
            } else {
                console.log('DEBUG - Skipping inactive shop:', shop.shop_name);
            }
        });
        
        console.log('DEBUG - Shop selector populated with', selector.options.length - 1, 'active shops');
    }

    async refreshCurrentShopData() {
        if (!this.selectedShop) {
            console.log('No shop selected to refresh');
            return;
        }

        console.log('Refreshing shop data for current shop:', this.selectedShop);
        
        try {
            // Reload shops to get updated rotation data
            const response = await JotunAPI.getShops();
            if (response && response.data) {
                const shops = response.data;
                const currentShop = shops.find(shop => shop.shop_id == this.selectedShop);
                
                if (currentShop) {
                    // Update the current shop option with new rotation data
                    const selectedOption = document.querySelector(`#teller-shop-selector option[value="${this.selectedShop}"]`);
                    if (selectedOption) {
                        selectedOption.dataset.currentRotation = currentShop.current_rotation || 1;
                        console.log('Updated current shop rotation to:', currentShop.current_rotation);
                        
                        // Reload items with new rotation
                        const shopType = selectedOption.dataset.shopType;
                        const isTurnInOnly = shopType === 'turn-in_only';
                        const currentRotation = currentShop.current_rotation || 1;
                        
                        if (isTurnInOnly) {
                            await this.loadTurninItems(this.selectedShop, currentRotation);
                        } else {
                            await this.loadShopItems(this.selectedShop, currentRotation);
                        }
                        
                        this.showStatus('Shop data refreshed successfully!', 'success');
                    }
                }
            }
        } catch (error) {
            console.error('Error refreshing shop data:', error);
            this.showStatus('Failed to refresh shop data: ' + error.message, 'error');
        }
    }

    async selectShop(shopId) {
        this.selectedShop = shopId;
        
        // Clear transaction summary when shop changes
        this.clearCart();
        
        if (shopId) {
            // Update dynamic header with shop info
            const selectedOption = document.querySelector(`#teller-shop-selector option[value="${shopId}"]`);
            const shopName = selectedOption ? selectedOption.dataset.shopName : 'Unknown Shop';
            const shopType = selectedOption ? selectedOption.dataset.shopType : 'unknown';
            
            // Format shop type for display
            const formattedShopType = this.formatShopType(shopType);
            
            document.getElementById('dynamic-shop-title').textContent = shopName;
            document.getElementById('dynamic-shop-subtitle').textContent = formattedShopType;

            // Check if this is a turn-in only shop
            const isTurnInOnly = shopType === 'turn-in_only';
            
            // Always show main interface, but hide payment tracking for turn-in only shops
            document.getElementById('teller-main-interface').style.display = 'block';
            document.getElementById('teller-turnin-interface').style.display = 'none';
            
            // Switch between Payment Tracking and Turn-in Tracking
            this.setupTrackingInterface(isTurnInOnly);
            
            // Get current rotation from selected option
            const currentRotation = selectedOption.dataset.currentRotation || 1;

            
            // Load appropriate items
            if (isTurnInOnly) {
                await this.loadTurninItems(shopId, currentRotation);
            } else {
                await this.loadShopItems(shopId, currentRotation);
            }
            
            // Initialize button states after shop selection
            this.updateViewCartButton();
            this.updateRecordTransactionButton();
            
            // Ensure we're in shop view mode and hide transaction summary
            this.isCartView = false;
            const transactionSummaryCard = document.querySelector('.summary-card');
            if (transactionSummaryCard) {
                transactionSummaryCard.style.display = 'none';
            }
        } else {
            // Reset dynamic header to default
            document.getElementById('dynamic-shop-title').textContent = 'Transaction Manager';
            document.getElementById('dynamic-shop-subtitle').textContent = 'Process player transactions and manage shop operations';
            
            // Hide all interfaces and reset payment tracking visibility
            document.getElementById('teller-main-interface').style.display = 'none';
            document.getElementById('teller-turnin-interface').style.display = 'none';
            
            // Show payment tracking section (default state)
            const paymentCard = document.querySelector('.payment-card');
            if (paymentCard) {
                paymentCard.style.display = 'block';
            }
            
            this.clearCart();
        }
    }

    formatShopType(shopType) {
        switch(shopType) {
            case 'turn-in_only':
                return 'Turn-In Only';
            case 'aesir':
                return 'Aesir Shop';
            case 'staff':
                return 'Staff Shop';
            default:
                return shopType.charAt(0).toUpperCase() + shopType.slice(1);
        }
    }

    async loadShopItems(shopId, rotation = 1) {
        try {
            console.log('Loading shop items for shop ID:', shopId, 'rotation:', rotation);
            
            // Load shop items from jotun_shop_items table with rotation filter
            const shopItemsResponse = await JotunAPI.getShopItems({ shop_id: shopId, rotation: rotation });
            const shopItems = shopItemsResponse.data || [];
            console.log('Raw shop items from API:', shopItems);
            
            // Load Item Database from jotun_item_list table for pricing and details
            const itemListResponse = await JotunAPI.getItemlist();
            console.log('Item list response:', itemListResponse);
            const masterItems = itemListResponse.data || [];
            
            // Enrich shop items with Item Database data including pricing from jotun_item_list
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
                        unit_price: masterItem.unit_price || masterItem.price || masterItem.default_price || shopItem.custom_price || 0,
                        stack_size: masterItem.stack_size || 1,
                        stack_price: (masterItem.unit_price || masterItem.price || masterItem.default_price || shopItem.custom_price || 0) * (masterItem.stack_size || 1),
                        tech_tier: masterItem.tech_tier || 0,
                        tech_name: masterItem.tech_name || 'N/A',
                        item_type: masterItem.item_type || 'Unknown',
                        prefab_name: masterItem.prefab_name || shopItem.prefab_name,
                        undercut: masterItem.undercut || false,
                        description: masterItem.description || '',
                        // Preserve the icon_image from the API response (it comes from LEFT JOIN with jotun_itemlist)
                        icon_image: shopItem.icon_image || masterItem.icon_image,
                        // Ensure we preserve the database flags for conditional buttons
                        sell: shopItem.sell,
                        buy: shopItem.buy,
                        turn_in: shopItem.turn_in
                    };
                } else {
                    console.warn('No master item found for shop item:', shopItem);
                    return {
                        ...shopItem,
                        item_name: shopItem.item_name || 'Unknown Item',
                        unit_price: shopItem.custom_price || 0,
                        stack_size: 1,
                        stack_price: shopItem.custom_price || 0,
                        tech_tier: 0,
                        tech_name: 'N/A',
                        item_type: 'Unknown',
                        undercut: false,
                        description: '',
                        // Preserve the icon_image and button flags from the database
                        icon_image: shopItem.icon_image,
                        sell: shopItem.sell,
                        buy: shopItem.buy,
                        turn_in: shopItem.turn_in
                    };
                }
            });

            console.log('Enriched shop items:', this.shopItems);
            this.displayShopItems();
            
            // Set up tracking interface based on shop type
            const shopType = this.getCurrentShopType();
            const isTurnInOnly = shopType === 'turn-in_only';
            console.log('Setting up tracking interface:', {
                selectedShop: this.selectedShop,
                shopType: shopType,
                isTurnInOnly: isTurnInOnly
            });
            this.setupTrackingInterface(isTurnInOnly);
        } catch (error) {
            console.error('Error loading shop items:', error);
            console.error('Error stack:', error.stack);
            this.showStatus('Failed to load shop items: ' + error.message, 'error');
        }
    }

    setupTrackingInterface(isTurnInOnly) {
        const trackingTitle = document.getElementById('tracking-title');
        const paymentContent = document.getElementById('payment-tracking-content');
        const turninContent = document.getElementById('turnin-tracking-content');
        const paymentSummary = document.getElementById('payment-summary-section');
        
        if (isTurnInOnly) {
            // Switch to Turn-in Tracking
            if (trackingTitle) trackingTitle.textContent = 'Turn-in Tracking';
            if (paymentContent) paymentContent.style.display = 'none';
            if (turninContent) turninContent.style.display = 'block';
            if (paymentSummary) paymentSummary.style.display = 'none';
            
            // Initialize turn-in tracking
            this.initializeTurninTracking();
        } else {
            // Switch to Payment Tracking
            if (trackingTitle) trackingTitle.textContent = 'Payment Tracking';
            if (paymentContent) paymentContent.style.display = 'block';
            if (turninContent) turninContent.style.display = 'none';
            // Don't automatically show payment summary - only show in cart view
            if (paymentSummary) paymentSummary.style.display = 'none';
        }
    }

    getCurrentShopType() {
        if (!this.selectedShop) {
            console.log('getCurrentShopType: No selectedShop');
            return '';
        }
        const selectedOption = document.querySelector(`#teller-shop-selector option[value="${this.selectedShop}"]`);
        const shopType = selectedOption ? selectedOption.dataset.shopType : '';
        console.log('getCurrentShopType:', {
            selectedShop: this.selectedShop,
            selectedOption: selectedOption,
            shopType: shopType
        });
        return shopType;
    }

    async initializeTurninTracking() {
        // Initialize turn-in tracking displays
        this.updateTurninTracking();
    }

    updateTurninTracking() {
        if (!this.turninItems || this.turninItems.length === 0) {
            const container = document.getElementById('turnin-tracking-content');
            if (container) {
                container.innerHTML = '<div class="no-turnin-items">No turn-in items available</div>';
            }
            return;
        }

        // Generate individual progress displays for each item
        const progressDisplays = [];
        
        this.turninItems.forEach(item => {
            const qtyInput = document.getElementById(`turnin-qty-${item.shop_item_id}`);
            const currentTransactionQty = qtyInput ? parseInt(qtyInput.value) || 0 : 0;
            
            const dailyCollected = this.getDailyTurninTotal(item.item_name) || 0;
            const requirement = parseInt(item.turn_in_requirement) || 0;
            const projected = dailyCollected + currentTransactionQty;
            
            // DEBUG: Track turnin compact display calculation
            console.log('DEBUG - Turnin compact display:', {
                itemName: item.item_name,
                dailyCollected,
                currentTransactionQty,
                projected,
                requirement,
                qtyInputValue: qtyInput ? qtyInput.value : 'NO_INPUT'
            });
            
            // Calculate progress percentage
            const progressPercent = requirement > 0 ? Math.min((dailyCollected / requirement) * 100, 100) : 0;
            const projectedPercent = requirement > 0 ? Math.min((projected / requirement) * 100, 100) : 0;
            
            // Create compact progress display for this item
            const progressHtml = `
                <div class="turnin-compact-item">
                    <div class="turnin-compact-name">${item.item_name}</div>
                    <div class="turnin-compact-progress">
                        <div class="turnin-compact-bar">
                            <div class="turnin-compact-fill" style="width: ${progressPercent}%"></div>
                        </div>
                    </div>
                    <div class="turnin-compact-counts">${projected}/${requirement}</div>
                    <div class="turnin-compact-percent">${progressPercent.toFixed(0)}%</div>
                </div>
            `;
            
            progressDisplays.push(progressHtml);
        });
        
        // Update the turn-in tracking container with compact table display
        const container = document.getElementById('turnin-tracking-content');
        if (container) {
            // Calculate dynamic font size based on number of items
            const itemCount = progressDisplays.length;
            let fontSize;
            
            if (itemCount <= 3) {
                fontSize = 16; // Conservative size for few items
            } else if (itemCount <= 6) {
                fontSize = 17; // Slightly smaller than before for 4-6 items
            } else if (itemCount === 7) {
                fontSize = 18; // Perfect baseline for 7 items
            } else if (itemCount === 8) {
                fontSize = 15; // Scale down more for 8
            } else if (itemCount === 9) {
                fontSize = 14; // Much smaller for 9 to prevent scrollbar
            } else if (itemCount >= 10) {
                fontSize = Math.max(12, 16 - (itemCount - 8)); // Scale down aggressively, minimum 12px
            }
            
            container.innerHTML = `
                <div class="turnin-compact-table" style="--dynamic-font-size: ${fontSize}px;">
                    ${progressDisplays.join('')}
                </div>
            `;
        }
    }

    handleQuantityChange(inputId) {
        // Handle both turn-in quantity changes and regular shop quantity changes
        if (inputId.includes('turnin-')) {
            this.updateProgressFromInput(inputId);
        }
        
        // Also handle cart updates if this is a regular shop item
        if (!inputId.includes('turnin-')) {
            this.updateCartDisplay();
        }
    }





    async loadTurninItems(shopId, rotation = 1) {
        try {
            console.log('Loading turn-in items for shop ID:', shopId, 'rotation:', rotation);
            // Load turn-in items from jotun_shop_items table with rotation filter
            const response = await JotunAPI.getShopItems({ shop_id: shopId, rotation: rotation });
            console.log('Turn-in items response:', response);
            this.turninItems = response.data || [];
            
            // The shop items already contain turn_in_quantity field with current daily totals
            // No need to make separate API calls - data is already embedded
            
            // Also load Item Database for reference
            const itemsResponse = await JotunAPI.getItemlist();
            const masterItems = itemsResponse.data || [];
            
            // Enrich turn-in items with master item data
            this.turninItems = this.turninItems.map(shopItem => {
                const masterItem = masterItems.find(item => item.id == shopItem.item_id);
                return {
                    ...shopItem,
                    item_name: masterItem?.item_name || shopItem.item_name || 'Unknown Item',
                    item_type: masterItem?.item_type || 'Turn-In Item',
                    tech_name: masterItem?.tech_name || 'Unknown',
                    tech_tier: masterItem?.tech_tier || 0,
                    event_points: shopItem.event_points || 0,
                    category: masterItem?.category || 'Uncategorized',
                    description: masterItem?.description || '',
                    unit_price: 0, // Turn-in items don't have prices
                    stack_price: 0,
                    is_available: 1, // Make sure they show as available
                    icon_image: masterItem?.icon_image || shopItem.icon_image || null,
                    stack_size: masterItem?.stack_size || shopItem.stack_size || 1 // Include stack_size from master item data
                };
            });

            // Set shopItems to turninItems so they display in main interface
            this.shopItems = this.turninItems;
            this.renderShopItems();
            
            // Set up tracking interface for turn-in items
            console.log('Setting up turn-in tracking after loading items');
            this.setupTrackingInterface(true);
        } catch (error) {
            console.error('Error loading turn-in items:', error);
            this.showStatus('Failed to load turn-in items', 'error');
        }
    }

    async loadDailyTurninData(playerName) {
        try {
            // Load turn-in transactions from last 24 hours for this player
            const response = await JotunAPI.getTransactions({
                customer_name: playerName,
                transaction_type: 'turnin',
                hours: 24
            });
            
            this.dailyTurninData = {};
            if (response.data) {
                response.data.forEach(transaction => {
                    const itemName = transaction.item_name;
                    if (!this.dailyTurninData[itemName]) {
                        this.dailyTurninData[itemName] = 0;
                    }
                    this.dailyTurninData[itemName] += parseInt(transaction.quantity) || 0;
                });
            }
            console.log('Daily turn-in data loaded:', this.dailyTurninData);
            
            // Refresh the display to show updated remaining amounts
            if (this.currentShop && this.currentShop.shop_type === 'turn-in') {
                this.renderShopItems();
            }
        } catch (error) {
            console.error('Error loading daily turn-in data:', error);
            this.dailyTurninData = {};
        }
    }

    async loadOverallDailyTurninData() {
        try {
            console.log('Attempting to load overall daily turn-in data...');
            
            // Load all turn-in transactions from last 24 hours (all players)
            const response = await JotunAPI.getTransactions({
                transaction_type: 'turnin',
                hours: 24
            });
            
            this.dailyTurninData = {};
            if (response && response.data) {
                response.data.forEach(transaction => {
                    const itemName = transaction.item_name;
                    if (!this.dailyTurninData[itemName]) {
                        this.dailyTurninData[itemName] = 0;
                    }
                    this.dailyTurninData[itemName] += parseInt(transaction.quantity) || 0;
                });
            }
            console.log('Overall daily turn-in data loaded:', this.dailyTurninData);
        } catch (error) {
            console.error('Error loading overall daily turn-in data (403 Forbidden likely due to permissions):', error);
            console.log('Falling back to empty daily data - progress will show 0 until customer is selected');
            this.dailyTurninData = {};
        }
    }

    renderShopItems() {
        // Respect current view mode when re-rendering
        if (this.isTableView) {
            const tableContainer = document.getElementById('items-table-view');
            if (tableContainer) {
                this.renderItemsTable(tableContainer);
            }
        } else {
            const gridContainer = document.getElementById('items-grid-view');
            if (gridContainer) {
                this.renderItemsGrid(gridContainer);
            }
        }
    }

    createItemCard(item) {
        const card = document.createElement('div');
        // Only mark as out-of-stock if stock_quantity exists and is exactly 0 (not null, undefined, or -1 for infinite)
        const isOutOfStock = item.stock_quantity !== null && item.stock_quantity !== undefined && item.stock_quantity === 0;
        const isTurnInItem = item.event_points !== undefined && item.event_points !== null;
        card.className = `item-card ${isOutOfStock ? 'out-of-stock' : ''}`;
        card.dataset.itemId = item.id;
        
        // Use unit_price from the enriched data
        const unitPrice = item.unit_price || item.price || item.default_price || 0;
        const stackPrice = item.stack_price || (unitPrice * (item.stack_size || 1));
        
        // Generate item image URL - prioritize database icon_image, then prefab-based path
        const itemImageUrl = item.icon_image || 
            (item.prefab_name ? `/wp-content/uploads/Jotunheim-magic/icons/${item.prefab_name.toLowerCase()}.png` : 
            '/wp-content/uploads/Jotunheim-magic/icons/default-item.png');
        
        const biomeName = item.tech_name && item.tech_name !== 'N/A' && item.tech_name !== 'null' ? item.tech_name : 'Unknown';
        const biomeClass = `biome-${biomeName.toLowerCase().replace(/\s+/g, '')}`;
        
        // Use unified layout for all items
        card.innerHTML = `
            <div class="item-header">
                <div class="item-name">${this.escapeHtml(item.item_name)}</div>
                <div class="item-tags">
                    <div class="item-type">${item.item_type || (isTurnInItem ? 'Trophies' : 'Item')}</div>
                    <div class="item-biome ${biomeClass}">${biomeName}</div>
                </div>
            </div>
            <div class="item-main-content">
                <div class="item-icon-container">
                    ${item.icon_image ? `
                        <img src="${item.icon_image}" alt="${this.escapeHtml(item.item_name)}" class="item-image" 
                             onerror="this.style.display='none'">
                    ` : ''}
                </div>
                <div class="item-quantity-section">
                    ${this.generateQuantityControls(item, isTurnInItem)}
                </div>
            </div>
            <div class="item-bottom-section">
                <div class="item-info-display" id="info-${item.shop_item_id}">
                    ${this.generateItemInfoDisplay(item, isTurnInItem)}
                </div>
                <div class="item-actions">
                    ${this.generateUnifiedItemActions(item, isTurnInItem)}
                </div>
            </div>
        `;
        
        // Add event listeners for all items
        if (!isTurnInItem) {
            this.addItemCardEventListeners(card, item, unitPrice, stackPrice);
        }

        return card;
    }

    generateItemActionButtons(item) {
        console.log('Generating buttons for item:', item.item_name, 'sell:', item.sell, 'buy:', item.buy, 'turn_in:', item.turn_in);
        
        const unitPrice = item.unit_price || item.price || item.default_price || 0;
        const stackSize = parseInt(item.stack_size) || 1;
        const stackPrice = item.stack_price || (unitPrice * stackSize);
        const isStackable = stackSize > 1 && !item.is_custom_item;
        
        let buttonsHTML = '';
        
        // Generate Sell button and unit controls (buy=1 means customers can buy from shop, so teller sells)
        if (item.buy == 1 || item.buy === true) {
            buttonsHTML += `
                <div class="quantity-controls buy-section">
                    <label>Unit(s):</label>
                    <input type="number" class="quantity-input" id="qty-individual-${item.shop_item_id}" value="1" min="1" max="${item.stock_quantity === -1 ? 999 : item.stock_quantity}">
                    <button class="btn purchase-button individual-buy" data-type="individual" style="background-color: #28a745 !important; color: white !important; border: 1px solid #28a745 !important;">Sell</button>
                </div>`;
            
            // Add stack controls only if item is stackable
            if (isStackable) {
                buttonsHTML += `
                    <div class="quantity-controls buy-section">
                        <label>Stack (${stackSize}):</label>
                        <input type="number" class="stack-input" id="qty-stack-${item.shop_item_id}" value="1" min="1" max="${item.stock_quantity === -1 ? 999 : Math.floor(item.stock_quantity / stackSize)}">
                        <button class="btn purchase-button stack-buy" data-type="stack" style="background-color: #28a745 !important; color: white !important; border: 1px solid #28a745 !important;">Sell</button>
                    </div>`;
            }
        }
        
        // Generate Buy button (sell=1 means shop will buy from customers, so teller buys)
        if (item.sell == 1 || item.sell === true) {
            buttonsHTML += `
                <div class="quantity-controls sell-section">
                    <label>Unit(s):</label>
                    <input type="number" class="sell-quantity-input" id="qty-individual-${item.shop_item_id}" value="1" min="1" max="999">
                    <button class="btn btn-danger sell-to-shop" data-type="sell">Buy</button>
                </div>`;
        }
        
        // Generate Turn-in button
        if (item.turn_in == 1 || item.turn_in === true) {
            buttonsHTML += `
                <div class="quantity-controls turn-in-section">
                    <label>Unit(s):</label>
                    <input type="number" class="turn-in-quantity-input" value="1" min="1" max="999">
                    <button class="btn btn-default-gray turn-in-item" data-type="turn-in">Turn In</button>
                </div>`;
            
            // Add stack turn-in controls only if item is stackable AND turn-in requirement is >= stack size
            const turnInRequirement = parseInt(item.turn_in_requirement) || 0;
            if (isStackable && turnInRequirement >= stackSize) {
                buttonsHTML += `
                    <div class="quantity-controls turn-in-section">
                        <label>Stack (${stackSize}):</label>
                        <input type="number" class="turn-in-stack-input" value="1" min="1" max="999">
                        <button class="btn btn-default-gray turn-in-stack" data-type="turn-in-stack">Turn In</button>
                    </div>`;
            }
        }
        
        return buttonsHTML;
    }

    addItemCardEventListeners(card, item, unitPrice, stackPrice) {
        const stackSize = item.stack_size || 1;
        
        // Buy button (individual)
        const individualBtn = card.querySelector('.individual-buy');
        const quantityInput = card.querySelector('.quantity-input');
        if (individualBtn && quantityInput) {
            console.log('Found individual buy button for item:', item.item_name);
            if (item.stock_quantity !== 0) {
                individualBtn.addEventListener('click', (e) => {
                    console.log('Individual buy button clicked for:', item.item_name);
                    e.stopPropagation();
                    // Use the proper addToCart method that handles buy/sell actions
                    this.addToCart(item.shop_item_id, 'buy', 'individual');
                });
            } else {
                individualBtn.disabled = true;
                quantityInput.disabled = true;
            }
        } else {
            console.log('No individual buy button found for item:', item.item_name);
        }

        // Buy button (stack)
        const stackBtn = card.querySelector('.stack-buy');
        const stackInput = card.querySelector('.stack-input');
        if (stackBtn && stackInput) {
            if (item.stock_quantity !== 0) {
                stackBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    // Use the proper addToCart method that handles stack purchases
                    this.addToCart(item.shop_item_id, 'buy', 'stack');
                });
            } else {
                stackBtn.disabled = true;
                stackInput.disabled = true;
            }
        }

        // Sell button (player selling to shop)
        const sellBtn = card.querySelector('.sell-to-shop');
        const sellInput = card.querySelector('.sell-quantity-input');
        if (sellBtn && sellInput) {
            console.log('Found sell button for item:', item.item_name);
            sellBtn.addEventListener('click', (e) => {
                console.log('Sell button clicked for:', item.item_name);
                e.stopPropagation();
                // Use the proper addToCart method that handles sell actions
                this.addToCart(item.shop_item_id, 'sell', 'individual');
            });
        } else {
            console.log('No sell button found for item:', item.item_name);
        }

        // Turn-in button
        const turnInBtn = card.querySelector('.turn-in-item');
        const turnInInput = card.querySelector('.turn-in-quantity-input');
        if (turnInBtn && turnInInput) {
            console.log('Found turn-in button for item:', item.item_name);
            turnInBtn.addEventListener('click', (e) => {
                console.log('Turn-in button clicked for:', item.item_name);
                e.stopPropagation();
                // Use the proper turn-in method
                this.addTurninItem(item.shop_item_id);
            });
        } else {
            console.log('No turn-in button found for item:', item.item_name);
        }

        // Turn-in stack button (for stackable items)
        const turnInStackBtn = card.querySelector('.turn-in-stack');
        const turnInStackInput = card.querySelector('.turn-in-stack-input');
        if (turnInStackBtn && turnInStackInput) {
            console.log('Found turn-in stack button for item:', item.item_name);
            turnInStackBtn.addEventListener('click', (e) => {
                console.log('Turn-in stack button clicked for:', item.item_name);
                e.stopPropagation();
                // Turn in a full stack quantity
                const stackQuantity = parseInt(turnInStackInput.value) || 1;
                const stackSize = item.stack_size || 1;
                const totalQuantity = stackQuantity * stackSize;
                this.addTurninItemWithQuantity(item.shop_item_id, totalQuantity);
            });
        }
    }

    generateQuantityControls(item, isTurnInItem) {
        if (isTurnInItem) {
            // Turn-in quantity controls
            return `
                <div class="quantity-control-group">
                    <div class="quantity-label">Unit(s):</div>
                    <div class="quantity-controls">
                        <button type="button" class="qty-btn qty-decrease" onclick="window.unifiedTeller.decreaseQuantity('turnin-qty-${item.shop_item_id}')">−</button>
                        <input type="number" id="turnin-qty-${item.shop_item_id}" min="0" value="0" max="${this.getMaxAllowedTurnin(item)}"
                               class="turnin-large-quantity-input" 
                               data-debug="preventOverLimit-attached"
                               oninput="window.unifiedTeller.enforceQuantityLimits(this)"
                               onchange="window.unifiedTeller.updateProgressDisplay('${item.shop_item_id}', ${item.turn_in_requirement || 0})"
                               onkeydown="console.log('🔥 KEYDOWN FIRED on', this.id, 'event:', event); window.unifiedTeller.preventOverLimit(event, this)"
                               onblur="window.unifiedTeller.handleQuantityBlur(this)">
                        <button type="button" class="qty-btn qty-increase" onclick="window.unifiedTeller.increaseQuantity('turnin-qty-${item.shop_item_id}', ${this.getMaxAllowedTurnin(item)})">+</button>
                    </div>
                </div>
                ${(item.stack_size && parseInt(item.stack_size) > 1) ? `
                <div class="quantity-control-group">
                    <div class="quantity-label">Stack(s) (${item.stack_size}):</div>
                    <div class="quantity-controls">
                        <button type="button" class="qty-btn qty-decrease" onclick="window.unifiedTeller.decreaseQuantity('turnin-stack-qty-${item.shop_item_id}')">−</button>
                        <input type="number" id="turnin-stack-qty-${item.shop_item_id}" min="0" value="0" max="${Math.floor(this.getMaxAllowedTurnin(item) / parseInt(item.stack_size))}"
                               class="turnin-large-quantity-input" 
                               data-debug="preventOverLimit-attached"
                               oninput="window.unifiedTeller.enforceQuantityLimits(this)"
                               onchange="window.unifiedTeller.updateProgressDisplay('${item.shop_item_id}', ${item.turn_in_requirement || 0})"
                               onkeydown="console.log('🔥 KEYDOWN FIRED on', this.id, 'event:', event); window.unifiedTeller.preventOverLimit(event, this)"
                               onblur="window.unifiedTeller.handleQuantityBlur(this)">
                        <button type="button" class="qty-btn qty-increase" onclick="window.unifiedTeller.increaseQuantity('turnin-stack-qty-${item.shop_item_id}', ${Math.floor(this.getMaxAllowedTurnin(item) / parseInt(item.stack_size))})">+</button>
                    </div>
                </div>
                ` : ''}
            `;
        } else {
            // Regular shop item quantity controls - simplified single control for each action
            let controlsHTML = '';
            
            // Add controls for each available action
            if (item.buy == 1 || item.buy === true) {
                controlsHTML += `
                    <div class="quantity-control-group">
                        <div class="quantity-label">Unit(s):</div>
                        <div class="quantity-controls">
                            <button type="button" class="qty-btn qty-decrease" onclick="window.unifiedTeller.decreaseQuantity('buy-qty-${item.shop_item_id}')">−</button>
                            <input type="number" id="buy-qty-${item.shop_item_id}" min="1" value="1" max="${item.stock_quantity === -1 ? 999 : item.stock_quantity}"
                                   class="large-quantity-input" onchange="window.unifiedTeller.updateTransactionDisplay('${item.shop_item_id}', 'buy')"
                                   onkeypress="window.unifiedTeller.handleQuantityKeyPress(event, this)" onblur="window.unifiedTeller.handleQuantityBlur(this)">
                            <button type="button" class="qty-btn qty-increase" onclick="window.unifiedTeller.increaseQuantity('buy-qty-${item.shop_item_id}', ${item.stock_quantity === -1 ? 999 : item.stock_quantity})">+</button>
                        </div>
                    </div>`;
                
                // Add stack controls if stackable
                if (item.stack_size && parseInt(item.stack_size) > 1) {
                    controlsHTML += `
                        <div class="quantity-control-group">
                            <div class="quantity-label">Stack(s) (${item.stack_size}):</div>
                            <div class="quantity-controls">
                                <button type="button" class="qty-btn qty-decrease" onclick="window.unifiedTeller.decreaseQuantity('buy-stack-qty-${item.shop_item_id}')">−</button>
                                <input type="number" id="buy-stack-qty-${item.shop_item_id}" min="1" value="1" max="${item.stock_quantity === -1 ? 999 : Math.floor(item.stock_quantity / parseInt(item.stack_size))}"
                                       class="large-quantity-input" onchange="window.unifiedTeller.updateTransactionDisplay('${item.shop_item_id}', 'buy')"
                                       onkeypress="window.unifiedTeller.handleQuantityKeyPress(event, this)" onblur="window.unifiedTeller.handleQuantityBlur(this)">
                                <button type="button" class="qty-btn qty-increase" onclick="window.unifiedTeller.increaseQuantity('buy-stack-qty-${item.shop_item_id}', ${item.stock_quantity === -1 ? 999 : Math.floor(item.stock_quantity / parseInt(item.stack_size))})">+</button>
                            </div>
                        </div>`;
                }
            } else if (item.sell == 1 || item.sell === true) {
                controlsHTML += `
                    <div class="quantity-control-group">
                        <div class="quantity-label">Unit(s):</div>
                        <div class="quantity-controls">
                            <button type="button" class="qty-btn qty-decrease" onclick="window.unifiedTeller.decreaseQuantity('sell-qty-${item.shop_item_id}')">−</button>
                            <input type="number" id="sell-qty-${item.shop_item_id}" min="1" value="1" max="999"
                                   class="large-quantity-input" onchange="window.unifiedTeller.updateTransactionDisplay('${item.shop_item_id}', 'sell')"
                                   onkeypress="window.unifiedTeller.handleQuantityKeyPress(event, this)" onblur="window.unifiedTeller.handleQuantityBlur(this)">
                            <button type="button" class="qty-btn qty-increase" onclick="window.unifiedTeller.increaseQuantity('sell-qty-${item.shop_item_id}', 999)">+</button>
                        </div>
                    </div>`;
            } else if (item.turn_in == 1 || item.turn_in === true) {
                controlsHTML += `
                    <div class="quantity-control-group">
                        <div class="quantity-label">Unit(s):</div>
                        <div class="quantity-controls">
                            <button type="button" class="qty-btn qty-decrease" onclick="window.unifiedTeller.decreaseQuantity('turnin-reg-qty-${item.shop_item_id}')">−</button>
                            <input type="number" id="turnin-reg-qty-${item.shop_item_id}" min="1" value="1" max="999"
                                   class="large-quantity-input" onchange="window.unifiedTeller.updateTransactionDisplay('${item.shop_item_id}', 'turn_in')"
                                   onkeypress="window.unifiedTeller.handleQuantityKeyPress(event, this)" onblur="window.unifiedTeller.handleQuantityBlur(this)">
                            <button type="button" class="qty-btn qty-increase" onclick="window.unifiedTeller.increaseQuantity('turnin-reg-qty-${item.shop_item_id}', 999)">+</button>
                        </div>
                    </div>`;
            }
            
            return controlsHTML;
        }
    }

    generateItemInfoDisplay(item, isTurnInItem) {
        if (isTurnInItem) {
            // For turn-in items, show live transaction progress (use original ID for compatibility)
            return `
                <div class="turnin-progress" id="progress-${item.shop_item_id}">
                    ${this.generateProgressText(item, false)}
                </div>
            `;
        } else {
            // Show transaction information based on what type of transaction is available
            const unitPrice = item.unit_price || item.price || item.default_price || 0;
            const stackPrice = item.stack_price || (unitPrice * (item.stack_size || 1));
            
            if (item.buy == 1 || item.buy === true) {
                // Show amount customer will pay to shop
                return `
                    <div class="transaction-info buy-info">
                        <div class="info-label">Amount Due to Shop:</div>
                        <div class="info-value" id="buy-total-${item.shop_item_id}">$${unitPrice}</div>
                        <div class="info-details">
                            <span class="unit-price">Unit: $${unitPrice}</span>
                            ${item.stack_size && parseInt(item.stack_size) > 1 ? `<span class="stack-price">Stack: $${stackPrice}</span>` : ''}
                        </div>
                    </div>
                `;
            } else if (item.sell == 1 || item.sell === true) {
                // Show amount shop will pay to customer  
                return `
                    <div class="transaction-info sell-info">
                        <div class="info-label">Amount Due to Customer:</div>
                        <div class="info-value" id="sell-total-${item.shop_item_id}">$${unitPrice}</div>
                        <div class="info-details">
                            <span class="unit-price">Unit: $${unitPrice}</span>
                        </div>
                    </div>
                `;
            } else if (item.turn_in == 1 || item.turn_in === true) {
                // Show turn-in information
                const turnInReq = item.turn_in_requirement || 1;
                return `
                    <div class="transaction-info turnin-info">
                        <div class="info-label">Turn-in Progress:</div>
                        <div class="info-value" id="turnin-progress-${item.shop_item_id}">0 / ${turnInReq}</div>
                        <div class="info-details">
                            <span class="requirement">Required: ${turnInReq}</span>
                        </div>
                    </div>
                `;
            }
            
            return `
                <div class="transaction-info no-actions">
                    <div class="info-label">No actions available</div>
                </div>
            `;
        }
    }

    generateUnifiedItemActions(item, isTurnInItem) {
        if (isTurnInItem) {
            // Check if item is already in cart for turn-in
            const inCart = this.cart.some(cartItem => cartItem.shop_item_id === item.shop_item_id && cartItem.action === 'turnin');
            const buttonText = inCart ? 'Update' : 'Turn In';
            const buttonClass = inCart ? 'btn item-btn turnin-btn update-btn' : 'btn item-btn turnin-btn';
            
            // Debug logging
            console.log(`Generating button for item ${item.shop_item_id}: inCart=${inCart}, buttonText=${buttonText}, cartSize=${this.cart.length}`);
            
            return `<button class="${buttonClass}" onclick="window.unifiedTeller.addTurninItemWithQuantity(${item.shop_item_id})">${buttonText}</button>`;
        } else {
            let actionsHTML = '';
            
            if (item.buy == 1 || item.buy === true) {
                // Check if item is already in cart for buy action
                const inCart = this.cart.some(cartItem => cartItem.shop_item_id === item.shop_item_id && cartItem.action === 'buy');
                const buttonText = inCart ? 'Update' : 'Sell';
                const buttonClass = inCart ? 'btn item-btn buy-btn update-btn' : 'btn item-btn buy-btn';
                actionsHTML += `<button class="${buttonClass}" onclick="window.unifiedTeller.addToCart(${item.shop_item_id}, 'buy', 'individual')">${buttonText}</button>`;
            }
            
            if (item.sell == 1 || item.sell === true) {
                // Check if item is already in cart for sell action
                const inCart = this.cart.some(cartItem => cartItem.shop_item_id === item.shop_item_id && cartItem.action === 'sell');
                const buttonText = inCart ? 'Update' : 'Buy';
                const buttonClass = inCart ? 'btn item-btn sell-btn update-btn' : 'btn item-btn sell-btn';
                actionsHTML += `<button class="${buttonClass}" onclick="window.unifiedTeller.addToCart(${item.shop_item_id}, 'sell', 'individual')">${buttonText}</button>`;
            }
            
            if (item.turn_in == 1 || item.turn_in === true) {
                // Check if item is already in cart for turn-in action
                const inCart = this.cart.some(cartItem => cartItem.shop_item_id === item.shop_item_id && cartItem.action === 'turnin');
                const buttonText = inCart ? 'Update' : 'Turn In';
                const buttonClass = inCart ? 'btn item-btn turnin-btn update-btn' : 'btn item-btn turnin-btn';
                actionsHTML += `<button class="${buttonClass}" onclick="window.unifiedTeller.addTurninItem(${item.shop_item_id})">${buttonText}</button>`;
            }
            
            return actionsHTML || '<span class="text-muted">No actions available</span>';
        }
    }

    // Method to update transaction display when quantities change
    updateTransactionDisplay(shopItemId, transactionType) {
        const item = this.shopItems.find(i => i.shop_item_id == shopItemId);
        if (!item) return;
        
        const unitPrice = item.unit_price || item.price || item.default_price || 0;
        const stackPrice = item.stack_price || (unitPrice * (item.stack_size || 1));
        
        if (transactionType === 'buy') {
            const unitQty = parseInt(document.getElementById(`buy-qty-${shopItemId}`)?.value) || 1;
            const stackQty = parseInt(document.getElementById(`buy-stack-qty-${shopItemId}`)?.value) || 0;
            const totalCost = (unitQty * unitPrice) + (stackQty * stackPrice);
            
            const totalElement = document.getElementById(`buy-total-${shopItemId}`);
            if (totalElement) {
                totalElement.textContent = `$${totalCost}`;
            }
        } else if (transactionType === 'sell') {
            const unitQty = parseInt(document.getElementById(`sell-qty-${shopItemId}`)?.value) || 1;
            const totalPayout = unitQty * unitPrice;
            
            const totalElement = document.getElementById(`sell-total-${shopItemId}`);
            if (totalElement) {
                totalElement.textContent = `$${totalPayout}`;
            }
        } else if (transactionType === 'turn_in') {
            // Update turn-in progress display with full progress text
            this.updateTurninProgressDisplay(shopItemId);
        }
    }




    sellToShop(item, quantity) {
        // Placeholder for sell functionality
        console.log('Sell to shop:', item.item_name, 'quantity:', quantity);
        this.showStatus(`Selling ${quantity} ${item.item_name} to shop - functionality coming soon!`, 'info');
    }

    turnInItem(item, quantity) {
        // Placeholder for turn-in functionality
        console.log('Turn in item:', item.item_name, 'quantity:', quantity);
        this.showStatus(`Turning in ${quantity} ${item.item_name} - functionality coming soon!`, 'info');
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
        const searchInput = document.getElementById('item-search');
        if (!searchInput) return;
        
        const searchTerm = searchInput.value.toLowerCase();
        console.log('DEBUG: Filtering items with search term:', searchTerm);
        
        // Filter both grid and table view items
        const gridCards = document.querySelectorAll('#items-grid-view .item-card');
        const tableRows = document.querySelectorAll('#items-table-view .item-row');
        
        // Filter grid view
        gridCards.forEach(card => {
            const itemName = card.querySelector('.item-name')?.textContent?.toLowerCase() || '';
            const itemDescription = card.querySelector('.item-description')?.textContent?.toLowerCase() || '';
            const matches = !searchTerm || itemName.includes(searchTerm) || itemDescription.includes(searchTerm);
            card.style.display = matches ? 'block' : 'none';
        });
        
        // Filter table view
        tableRows.forEach(row => {
            const itemName = row.querySelector('.item-name')?.textContent?.toLowerCase() || '';
            const itemDescription = row.querySelector('.item-description')?.textContent?.toLowerCase() || '';
            const matches = !searchTerm || itemName.includes(searchTerm) || itemDescription.includes(searchTerm);
            row.style.display = matches ? 'table-row' : 'none';
        });
        
        console.log('DEBUG: Item filtering completed');
    }

    filterTurninItems() {
        const searchInput = document.getElementById('turnin-item-search');
        if (!searchInput) return;
        
        const searchTerm = searchInput.value.toLowerCase();
        console.log('DEBUG: Filtering turn-in items with search term:', searchTerm);
        
        // Filter turn-in items
        const turninCards = document.querySelectorAll('#turnin-shop-items .item-card');
        
        turninCards.forEach(card => {
            const itemName = card.querySelector('.item-name')?.textContent?.toLowerCase() || '';
            const itemDescription = card.querySelector('.item-description')?.textContent?.toLowerCase() || '';
            const matches = !searchTerm || itemName.includes(searchTerm) || itemDescription.includes(searchTerm);
            card.style.display = matches ? 'block' : 'none';
        });
        
        console.log('DEBUG: Turn-in item filtering completed');
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
            // Search for player using the comprehensive API
            console.log('Validating customer:', customerName);
            
            // Try search first
            const searchResponse = await JotunAPI.getPlayers({ search: customerName });
            console.log('Search API response:', searchResponse);
            let players = searchResponse.data || [];
            console.log('Players found from search:', players);
            
            // If no results from search, try getting all players (as fallback)
            if (players.length === 0) {
                console.log('No search results, trying to get all players...');
                const allResponse = await JotunAPI.getPlayers();
                console.log('All players response:', allResponse);
                const allPlayers = allResponse.data || [];
                console.log('All players count:', allPlayers.length);
                
                // Filter manually for exact matches
                players = allPlayers.filter(p => {
                    const activeMatch = p.activePlayerName && p.activePlayerName.toLowerCase() === customerName.toLowerCase();
                    const nameMatch = p.activePlayerName && p.activePlayerName.toLowerCase() === customerName.toLowerCase();
                    return activeMatch || nameMatch;
                });
                console.log('Filtered players:', players);
            }
            
            // Find exact match by activePlayerName (case-insensitive)
            const player = players.find(p => {
                const activeMatch = p.activePlayerName && p.activePlayerName.toLowerCase() === customerName.toLowerCase();
                const nameMatch = p.activePlayerName && p.activePlayerName.toLowerCase() === customerName.toLowerCase();
                console.log(`Checking player: ${p.activePlayerName}, activeMatch: ${activeMatch}, nameMatch: ${nameMatch}`);
                return activeMatch || nameMatch;
            });
            
            console.log('Player found result:', player);
            if (player) {
                console.log('Validation successful for:', player.activePlayerName);
                this.currentCustomer = player;
                this.showValidationIcon('valid');
                
                // Clear any customer name field highlighting
                this.clearCustomerNameHighlight();
                
                // Update all button states when customer is validated
                this.updateViewCartButton();
                this.updateRecordTransactionButton();
                
                const turninBtn = document.getElementById('record-turnin-btn');
                if (turninBtn) {
                    turninBtn.disabled = false; // Turn-in button should be enabled when customer is valid
                }
                
                // Load daily turn-in data for this customer
                await this.loadDailyTurninData(this.currentCustomer.playerName || this.currentCustomer.player_name);
                
                // Re-render items to update limits, but preserve current quantities
                if (this.selectedShop && this.shopItems.length > 0) {
                    this.preserveQuantitiesAndRerender();
                }
            } else {
                // Show register option for new customers
                console.log('No player found for:', customerName);
                this.currentCustomer = null;
                this.showValidationIcon('register');
                
                // Update button states when customer validation fails
                this.updateViewCartButton();
                this.updateRecordTransactionButton();
                
                const turninBtn = document.getElementById('record-turnin-btn');
                if (turninBtn) turninBtn.disabled = true;
            }
        } catch (error) {
            console.error('Error validating customer:', error);
            this.showValidationIcon('invalid');
            this.currentCustomer = null;
        }
    }

    setupRegisterButton() {
        const registerBtn = document.getElementById('register-new-player-btn');
        if (registerBtn) {
            registerBtn.addEventListener('click', () => {
                if (!registerBtn.disabled && registerBtn.classList.contains('enabled')) {
                    this.registerNewPlayer();
                }
            });
        }
    }

    // Customer validation helpers
    validateCustomerForAction() {
        if (!this.currentCustomer) {
            this.highlightCustomerNameFieldAsRequired();
            this.showStatus('Please enter a customer name before adding items to cart.', 'error');
            return false;
        }
        this.clearCustomerNameHighlight();
        return true;
    }

    highlightCustomerNameFieldAsRequired() {
        const customerNameInput = document.getElementById('customer-name');
        const turninCustomerNameInput = document.getElementById('turnin-customer-name');
        
        if (customerNameInput) {
            customerNameInput.style.borderColor = '#dc3545';
            customerNameInput.style.backgroundColor = '#fff5f5';
            customerNameInput.style.boxShadow = '0 0 0 3px rgba(220, 53, 69, 0.1)';
        }
        
        if (turninCustomerNameInput) {
            turninCustomerNameInput.style.borderColor = '#dc3545';
            turninCustomerNameInput.style.backgroundColor = '#fff5f5';
            turninCustomerNameInput.style.boxShadow = '0 0 0 3px rgba(220, 53, 69, 0.1)';
        }
        
        // Auto-focus the customer name field to guide user
        if (customerNameInput && customerNameInput.offsetParent !== null) {
            customerNameInput.focus();
        } else if (turninCustomerNameInput && turninCustomerNameInput.offsetParent !== null) {
            turninCustomerNameInput.focus();
        }
    }

    clearCustomerNameHighlight() {
        const customerNameInput = document.getElementById('customer-name');
        const turninCustomerNameInput = document.getElementById('turnin-customer-name');
        
        if (customerNameInput) {
            customerNameInput.style.borderColor = '';
            customerNameInput.style.backgroundColor = '';
            customerNameInput.style.boxShadow = '';
        }
        
        if (turninCustomerNameInput) {
            turninCustomerNameInput.style.borderColor = '';
            turninCustomerNameInput.style.backgroundColor = '';
            turninCustomerNameInput.style.boxShadow = '';
        }
    }

    async registerNewPlayer() {
        const customerName = document.getElementById('customer-name')?.value?.trim();
        if (!customerName) {
            this.showStatus('Please enter a customer name first', 'error');
            return;
        }

        try {
            const playerData = {
                playerName: customerName,
                activePlayerName: customerName,
                is_active: true
            };
            
            await JotunAPI.addPlayer(playerData);
            this.showStatus(`Customer "${customerName}" registered successfully!`, 'success');
            
            // Reload player list and validate the newly registered customer
            this.playerList = null; // Clear cache
            await this.validateCustomer();
            
        } catch (error) {
            console.error('Error registering customer:', error);
            this.showStatus('Error registering customer', 'error');
            this.showValidationIcon('invalid');
        }
    }



    showValidationIcon(type) {
        // Hide both icons first
        const successIcon = document.getElementById('validation-success-icon');
        const errorIcon = document.getElementById('validation-error-icon');
        const registerBtn = document.getElementById('register-new-player-btn');
        
        if (successIcon) successIcon.style.display = 'none';
        if (errorIcon) errorIcon.style.display = 'none';
        
        // Always show register button but control its enabled state
        if (registerBtn) {
            registerBtn.classList.remove('enabled');
            registerBtn.disabled = true;
        }
        
        // Show appropriate icon and handle button state
        if (type === 'valid' && successIcon) {
            successIcon.style.display = 'flex';
        } else if (type === 'invalid' && errorIcon) {
            errorIcon.style.display = 'flex';
        } else if (type === 'register') {
            if (errorIcon) errorIcon.style.display = 'flex';
            if (registerBtn) {
                registerBtn.classList.add('enabled');
                registerBtn.disabled = false;
            }
        }
    }

    hideValidationIcon() {
        const successIcon = document.getElementById('validation-success-icon');
        const errorIcon = document.getElementById('validation-error-icon');
        const registerContainer = document.getElementById('register-new-player-container');
        
        if (successIcon) successIcon.style.display = 'none';
        if (errorIcon) errorIcon.style.display = 'none';
        if (registerContainer) registerContainer.style.display = 'none';
    }

    addToCart(item, quantity = 1, price = null) {
        console.log('addToCart called with:', item.item_name, 'quantity:', quantity, 'price:', price);
        
        // Validate customer first
        if (!this.validateCustomerForAction()) {
            return;
        }

        if (!this.selectedShop) {
            this.showStatus('Please select a shop first', 'error');
            return;
        }

        // Use provided price or fallback to item pricing
        const itemPrice = price || item.unit_price || item.price || item.default_price || 0;
        
        // Check if item already in cart
        const existingCartItem = this.cart.find(cartItem => cartItem.id === item.id);
        
        if (existingCartItem) {
            // Increase quantity if stock allows
            const newQuantity = existingCartItem.quantity + quantity;
            if (item.stock_quantity === -1 || newQuantity <= item.stock_quantity) {
                existingCartItem.quantity = newQuantity;
                this.updateCartDisplay();
            } else {  
                this.showStatus('Cannot add more - insufficient stock', 'error');
            }
        } else {
            // Add new item to cart
            this.cart.push({
                id: item.id,
                item_id: item.item_id,
                item_name: item.item_name,
                price: parseFloat(itemPrice),
                unit_price: parseFloat(itemPrice),
                quantity: quantity,
                max_stock: item.stock_quantity
            });
            this.updateCartDisplay();
        }
    }

    getDailyTurninTotal(itemName) {
        // Use the same data source as Transaction Summary - check turn-in items for existing turn_in_quantity
        const item = this.turninItems.find(i => i.item_name === itemName);
        const turnInQuantity = item ? parseInt(item.turn_in_quantity || 0) : 0;
        
        console.log('DEBUG getDailyTurninTotal (using turn_in_quantity from item):', {
            itemName,
            item: item,
            turn_in_quantity: item?.turn_in_quantity,
            parsed: turnInQuantity,
            oldMethod: this.dailyTurninData ? (this.dailyTurninData[itemName] || 0) : 0
        });
        
        return turnInQuantity;
    }

    getMaxAllowedTurnin(item) {
        const dailyTotal = this.getDailyTurninTotal(item.item_name);
        const turnInRequirement = parseInt(item.turn_in_requirement) || 0;
        
        console.log('DEBUG - getMaxAllowedTurnin:', {
            itemName: item.item_name,
            dailyTotal,
            turnInRequirement,
            remaining: turnInRequirement > 0 ? Math.max(0, turnInRequirement - dailyTotal) : 999,
            dailyTurninDataExists: !!this.dailyTurninData
        });
        
        if (turnInRequirement > 0) {
            return Math.max(0, turnInRequirement - dailyTotal);
        }
        return 999; // No limit set
    }

    checkTurninLimits(item, requestedQuantity) {
        const dailyTotal = this.getDailyTurninTotal(item.item_name);
        const turnInRequirement = parseInt(item.turn_in_requirement) || 0;
        
        // Check if there's a limit at all
        if (turnInRequirement <= 0) {
            return { allowed: true, message: 'No limit set' };
        }
        
        // Check current cart for this item
        const existingCartItem = this.cart.find(cartItem => 
            cartItem.item_name === item.item_name && cartItem.action === 'turnin'
        );
        const cartQuantity = existingCartItem ? existingCartItem.quantity : 0;
        
        // Calculate projected total after this transaction
        const projectedTotal = dailyTotal + requestedQuantity;
        
        console.log('DEBUG - checkTurninLimits:', {
            itemName: item.item_name,
            dailyTotal,
            cartQuantity,
            requestedQuantity,
            projectedTotal,
            turnInRequirement,
            wouldExceed: projectedTotal > turnInRequirement
        });
        
        if (projectedTotal > turnInRequirement) {
            const remaining = Math.max(0, turnInRequirement - dailyTotal);
            return {
                allowed: false,
                message: `Cannot turn in ${requestedQuantity} ${item.item_name}. Would exceed daily limit! (${dailyTotal}/${turnInRequirement} already reached, ${remaining} remaining)`
            };
        }
        
        return { allowed: true, message: 'Within limits' };
    }

    preventOverLimit(event, inputElement) {
        
        // Allow navigation keys
        const allowedKeys = ['Backspace', 'Delete', 'Tab', 'Escape', 'Enter', 'Home', 'End', 'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown'];
        if (allowedKeys.includes(event.key) || (event.key >= '0' && event.key <= '9')) {
            
            // For number keys, check if the resulting value would exceed max
            if (event.key >= '0' && event.key <= '9') {
                const currentValue = inputElement.value;
                const cursorPos = inputElement.selectionStart;
                const newValue = currentValue.slice(0, cursorPos) + event.key + currentValue.slice(cursorPos);
                const numericValue = parseInt(newValue) || 0;
                
                // For turn-in items, check combined total
                if (inputElement.id.includes('turnin-qty-') || inputElement.id.includes('turnin-stack-qty-')) {
                    const shopItemId = inputElement.id.replace(/^turnin-(stack-)?qty-/, '');
                    const item = this.turninItems?.find(i => i.shop_item_id == shopItemId) || this.shopItems?.find(i => i.shop_item_id == shopItemId);
                    if (item) {
                        const dynamicMax = this.getMaxAllowedTurnin(item);
                        
                        // Get both inputs
                        const unitsInput = document.getElementById(`turnin-qty-${shopItemId}`);
                        const stacksInput = document.getElementById(`turnin-stack-qty-${shopItemId}`);
                        
                        // Calculate what the total would be with the new value
                        let totalUnits = 0;
                        if (inputElement.id.includes('turnin-qty-')) {
                            // This is the units input
                            totalUnits = numericValue + (stacksInput ? (parseInt(stacksInput.value) || 0) * parseInt(item.stack_size) : 0);
                        } else {
                            // This is the stacks input
                            totalUnits = (unitsInput ? parseInt(unitsInput.value) || 0 : 0) + numericValue * parseInt(item.stack_size);
                        }
                        
                        if (totalUnits > dynamicMax) {
                            event.preventDefault();
                            return false;
                        }
                    }
                } else {
                    // For non-turnin inputs, use the simple max check
                    let max = parseInt(inputElement.max) || 999;
                    if (numericValue > max) {
                        event.preventDefault();
                        return false;
                    }
                }
            }
            return true;
        }
        
        // Block all other keys
        event.preventDefault();
        return false;
    }

    generateLimitStatusDisplay(projectedDaily, turnInLimit, dailyTotal) {
        const percentage = (projectedDaily / turnInLimit) * 100;
        let cssClass = 'daily-limit-enhanced';
        
        if (projectedDaily >= turnInLimit) {
            cssClass += ' at-limit';
        } else if (percentage >= 90) {
            cssClass += ' near-limit';
        }
        
        return `<span class="${cssClass}">Last 24h: ${projectedDaily} / ${turnInLimit}</span>`;
    }

    updateCartDisplay() {
        const cartItemsContainer = document.getElementById('cart-items');
        cartItemsContainer.innerHTML = '';

        let total = 0;

        this.cart.forEach((item, index) => {
            const itemPrice = item.price || item.unit_price || 0;
            const itemTotal = itemPrice * item.quantity;
            total += itemTotal;

            const cartItem = document.createElement('div');
            cartItem.className = 'cart-item';
            cartItem.innerHTML = `
                <div class="item-name">${this.escapeHtml(item.item_name)}</div>
                <div class="item-price">$${itemPrice.toFixed(2)}</div>
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
        const recordBtn = document.getElementById('record-transaction-btn');
        const turninBtn = document.getElementById('record-turnin-btn');
        if (recordBtn) recordBtn.disabled = !canProcess || !this.isCartView;
        if (turninBtn) turninBtn.disabled = !canProcess;
        
        // Update view cart button
        this.updateViewCartButton();
        this.updateRecordTransactionButton();
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
        console.log('🚨🚨🚨 DEBUG: clearCart() method ENTRY - CART CLEARING STARTED');
        console.log('🚨 DEBUG: Current cart length before clearing:', this.cart.length);
        console.log('🚨 DEBUG: Current cart contents:', this.cart);
        
        this.cart = [];
        console.log('🚨 DEBUG: Cart array set to empty. New length:', this.cart.length);
        
        this.updateCartDisplay();
        console.log('🚨 DEBUG: updateCartDisplay() called');
        
        // Explicitly update button states after clearing cart
        this.updateViewCartButton();
        console.log('🚨 DEBUG: updateViewCartButton() called');
        
        this.updateRecordTransactionButton();
        console.log('🚨 DEBUG: updateRecordTransactionButton() called');
        
        // Reset item display without preserving quantities
        this.resetItemDisplay();
        console.log('🚨 DEBUG: resetItemDisplay() called');
        
        // Go back to shop view after clearing cart
        this.showShopView();
        console.log('🚨 DEBUG: showShopView() called');
        
        console.log('🚨🚨🚨 DEBUG: clearCart() completed - CART CLEARING FINISHED');
    }

    resetItemDisplay() {
        console.log(`DEBUG: resetItemDisplay() called. Cart length: ${this.cart.length}`);
        
        const gridView = document.getElementById('items-grid-view');
        const tableView = document.getElementById('items-table-view');
        
        if (!gridView || !tableView) return;
        
        // Clear all input fields first
        const allInputs = document.querySelectorAll([
            'input[id^="turnin-qty-"]',
            'input[id^="turnin-stack-qty-"]',
            'input[id^="qty-individual-"]',
            'input[id^="qty-stack-"]',
            'input[id^="table-qty-"]'
        ].join(', '));
        
        console.log(`DEBUG: Clearing ${allInputs.length} input fields`);
        allInputs.forEach(input => {
            input.value = '';
        });
        
        // Re-render the currently visible view to reset button states
        if (this.isTableView) {
            this.renderItemsTable(tableView);
        } else {
            this.renderItemsGrid(gridView);
        }
        
        // Force button state update to ensure all buttons show default text
        setTimeout(() => {
            console.log(`DEBUG: About to force button state update. Cart length: ${this.cart.length}`);
            this.forceButtonStateUpdate();
        }, 100);
    }

    toggleItemsView() {
        const gridView = document.getElementById('items-grid-view');
        const tableView = document.getElementById('items-table-view');
        const toggleBtn = document.getElementById('toggle-view-btn');
        
        if (gridView && tableView && toggleBtn) {
            // Use flag to track state instead of DOM inspection
            if (this.isTableView) {
                // Currently showing table, switch back to grid view
                gridView.style.display = 'flex'; // Use flex, not grid!
                tableView.style.display = 'none';
                this.isTableView = false;
                // Ensure grid is populated
                this.renderItemsGrid(gridView);
            } else {
                // Currently showing grid, switch to table view
                gridView.style.display = 'none';
                tableView.style.display = 'block';
                this.isTableView = true;
                // Ensure table is populated
                this.renderItemsTable(tableView);
            }
            // Button text never changes - always "Toggle View"
            toggleBtn.textContent = 'Toggle View';
        }
    }

    refreshItemDisplay() {
        const gridView = document.getElementById('items-grid-view');
        const tableView = document.getElementById('items-table-view');
        
        if (!gridView || !tableView) return;
        
        // Save current quantities from all input fields before re-rendering
        const quantities = {};
        const allInputs = document.querySelectorAll([
            'input[id^="turnin-qty-"]',
            'input[id^="turnin-stack-qty-"]',
            'input[id^="qty-individual-"]',
            'input[id^="qty-stack-"]',
            'input[id^="table-qty-"]'
        ].join(', '));
        
        allInputs.forEach(input => {
            if (input.value && parseInt(input.value) > 0) {
                quantities[input.id] = input.value;
            }
        });
        
        // Re-render the currently visible view to update button states
        if (this.isTableView) {
            this.renderItemsTable(tableView);
        } else {
            this.renderItemsGrid(gridView);
        }
        
        // Restore quantities after re-rendering
        setTimeout(() => {
            Object.keys(quantities).forEach(inputId => {
                const input = document.getElementById(inputId);
                if (input) {
                    input.value = quantities[inputId];
                }
            });
            
            // Force a second button state update after quantities are restored
            console.log('DEBUG: Forcing button state update after quantity restoration');
            this.forceButtonStateUpdate();
        }, 100);
    }

    forceButtonStateUpdate() {
        console.log('🚨 DEBUG: forceButtonStateUpdate() called, cart length:', this.cart.length);
        console.log('🚨 DEBUG: Cart contents:', this.cart);
        
        // Find all turn-in buttons and update their text/class based on cart state
        const turninButtons = document.querySelectorAll([
            'button[onclick*="addTurninItemWithQuantity"]',
            'button[onclick*="addTurninItem"]', 
            'button[onclick*="addToTurnin"]',
            'button.turn-in-item',
            'button.turn-in-stack',
            'button.table-action-btn[onclick*="addTurninItemWithQuantity"]',
            'button.table-action-btn[onclick*="addToTurnin"]'
        ].join(', '));
        
        console.log(`🚨 DEBUG: Found ${turninButtons.length} turn-in buttons to update`);
        
        turninButtons.forEach(button => {
            const onclickAttr = button.getAttribute('onclick');
            if (!onclickAttr) return;
            
            // Extract shop item ID from onclick attribute
            const shopItemIdMatch = onclickAttr.match(/\((\d+)\)/);
            
            if (shopItemIdMatch) {
                const shopItemId = parseInt(shopItemIdMatch[1]);
                const inCart = this.cart.some(cartItem => cartItem.shop_item_id === shopItemId && cartItem.action === 'turnin');
                
                console.log(`🚨 DEBUG: Button for item ${shopItemId}: inCart=${inCart}, current text="${button.textContent.trim()}", cart.length=${this.cart.length}`);
                
                if (inCart && button.textContent.trim() === 'Turn In') {
                    button.textContent = 'Update';
                    button.classList.add('update-btn');
                    console.log(`🚨 DEBUG: Updated button text to "Update" for item ${shopItemId}`);
                } else if (!inCart && button.textContent.trim() === 'Update') {
                    button.textContent = 'Turn In';
                    button.classList.remove('update-btn');
                    console.log(`🚨 DEBUG: Updated button text to "Turn In" for item ${shopItemId}`);
                }
            }
        });
        
        console.log('🚨 DEBUG: forceButtonStateUpdate() completed');
    }

    showTransactionModal() {
        if (!this.currentCustomer) {
            this.showStatus('Please validate a customer first', 'error', false);
            return;
        }

        if (this.cart.length === 0) {
            this.showStatus('Please add items to cart', 'error', false);
            return;
        }

        // Generate transaction summary
        const summary = this.generateTransactionSummary();
        document.getElementById('transaction-summary').innerHTML = summary;
        document.getElementById('transaction-modal').style.display = 'block';
    }

    generateTransactionSummary() {
        const notes = document.getElementById('transaction-notes').value;
        const isTurnIn = this.cart.some(item => item.action === 'turnin');

        let summary = `
            <div class="transaction-summary">
                <h4>Transaction Details</h4>
                <p><strong>Shop:</strong> ${document.getElementById('dynamic-shop-title').textContent}</p>
                <p><strong>Customer:</strong> ${this.currentCustomer.playerName || this.currentCustomer.player_name}</p>
                <p><strong>Type:</strong> ${isTurnIn ? 'Turn-In' : this.transactionMode.charAt(0).toUpperCase() + this.transactionMode.slice(1)}</p>
                
                <h5>Items:</h5>
                <ul>
        `;

        if (isTurnIn) {
            // Turn-in summary - show quantities and progress
            this.cart.forEach(item => {
                const currentTurnedIn = item.turn_in_quantity || 0;
                const requirement = item.turn_in_requirement || 0;
                const newTotal = currentTurnedIn + item.quantity;
                const progress = requirement > 0 ? Math.min(100, (newTotal / requirement) * 100) : 0;
                
                // Debug logging to track the 10x issue
                console.log('DEBUG - Turn-in summary:', {
                    item_name: item.item_name,
                    raw_turn_in_quantity: item.turn_in_quantity,
                    currentTurnedIn: currentTurnedIn,
                    quantity: item.quantity,
                    requirement: requirement,
                    newTotal: newTotal
                });
                
                summary += `<li>${item.item_name}: Turning in ${item.quantity}`;
                if (requirement > 0) {
                    summary += ` (${newTotal}/${requirement} - ${progress.toFixed(1)}% complete)`;
                }
                summary += `</li>`;
            });
            
            const totalTurningIn = this.cart.reduce((sum, item) => sum + item.quantity, 0);
            summary += `
                    </ul>
                    <p><strong>Total Items Turning In: ${totalTurningIn}</strong></p>
                    ${notes ? `<p><strong>Notes:</strong> ${this.escapeHtml(notes)}</p>` : ''}
                </div>`;
        } else {
            // Regular transaction - show prices
            const total = this.cart.reduce((sum, item) => sum + ((item.price || item.unit_price || 0) * item.quantity), 0);
            
            this.cart.forEach(item => {
                const itemPrice = item.price || item.unit_price || 0;
                const totalPrice = item.total_price || (itemPrice * item.quantity);
                summary += `<li>${item.item_name} x${item.quantity} @ $${itemPrice.toFixed(2)} = $${totalPrice.toFixed(2)}</li>`;
            });

            summary += `
                    </ul>
                    <p><strong>Total Amount: $${total.toFixed(2)}</strong></p>
                    ${notes ? `<p><strong>Notes:</strong> ${this.escapeHtml(notes)}</p>` : ''}
                </div>`;
        }

        return summary;
    }

    async confirmTransaction() {
        try {
            // Validate daily limits before processing transaction
            if (this.transactionMode === 'sell') {
                const dailyLimitValidation = await this.validateDailySellingLimits();
                if (!dailyLimitValidation.valid) {
                    this.showStatus(dailyLimitValidation.error, 'error');
                    return;
                }
            } else if (this.transactionMode === 'buy') {
                const dailyBuyValidation = await this.validateDailyBuyingLimits();
                if (!dailyBuyValidation.valid) {
                    this.showStatus(dailyBuyValidation.error, 'error');
                    return;
                }
            } else if (this.transactionMode === 'turnin') {
                const dailyTurninValidation = await this.validateDailyTurninLimits();
                if (!dailyTurninValidation.valid) {
                    this.showStatus(dailyTurninValidation.error, 'error');
                    return;
                }
            }
            
            // Get shop and customer names for legacy API
            const shopName = document.getElementById('dynamic-shop-title').textContent;
            const customerName = this.currentCustomer.playerName || this.currentCustomer.player_name;
            
            // Detect transaction type from cart items
            const isTurnIn = this.cart.some(item => item.action === 'turnin');
            const transactionType = isTurnIn ? 'turnin' : this.transactionMode;
            
            // Record each cart item as individual transaction (legacy API format)
            let allSuccessful = true;
            const responses = [];
            
            for (const cartItem of this.cart) {
                const itemTransactionType = cartItem.action === 'turnin' ? 'turnin' : transactionType;
                
                // Get shop type for proper transaction routing
                const selectedOption = document.querySelector(`#teller-shop-selector option[value="${this.selectedShop}"]`);
                const shopType = selectedOption ? selectedOption.dataset.shopType : null;
                
                const individualTransactionData = {
                    shop_id: this.selectedShop, // Include shop_id for foreign key constraint
                    shop_name: shopName,
                    shop_type: shopType, // Add shop type for backend routing
                    item_name: cartItem.item_name,
                    item_id: cartItem.item_id, // Include item_id (null for custom items)
                    quantity: cartItem.quantity,
                    total_amount: itemTransactionType === 'turnin' ? 0 : (cartItem.price || cartItem.unit_price || 0) * cartItem.quantity,
                    customer_name: customerName,
                    transaction_type: itemTransactionType,
                    notes: document.getElementById('transaction-notes').value,
                    transaction_date: new Date().toISOString()
                };
                
                console.log('Recording individual transaction:', individualTransactionData);
                try {
                    const response = await JotunAPI.addTransaction(individualTransactionData);
                    console.log('Individual transaction response:', response);
                    responses.push(response);
                    
                    if (response.success === false) {
                        allSuccessful = false;
                        console.error('Transaction failed for item:', cartItem.item_name, response.error);
                        
                        // Check if this is a missing item error
                        if (response.error && response.error.includes('Invalid item_name: no matching item_id found')) {
                            this.showStatus(`Item "${cartItem.item_name}" not found in Item Database. Please use Shop Manager to add new items first.`, 'error', true);
                            return; // Exit early - cannot process transaction for unknown items
                        }
                    }
                } catch (error) {
                    allSuccessful = false;
                    console.error('Error recording transaction for item:', cartItem.item_name, error);
                    responses.push({ success: false, error: error.message });
                }
            }
            
            if (allSuccessful) {
                // Record daily activity for transactions with limits
                if (transactionType === 'sell') {
                    await this.recordDailySales();
                } else if (transactionType === 'buy') {
                    await this.recordDailyBuys();
                } else if (transactionType === 'turnin') {
                    await this.recordDailyTurnins();
                }
                
                this.showStatus(`Transaction completed successfully (${responses.length} items)`, 'success');
                
                // Clear cart and customer
                this.clearCart();
                this.currentCustomer = null;
                document.getElementById('customer-name').value = '';
                this.hideValidationIcon();
                document.getElementById('transaction-notes').value = '';
                
                // Reload shop items based on shop type
                const selectedOption = document.querySelector(`#teller-shop-selector option[value="${this.selectedShop}"]`);
                const shopType = selectedOption ? selectedOption.dataset.shopType : null;
                const currentRotation = selectedOption ? selectedOption.dataset.currentRotation || 1 : 1;
                
                if (shopType === 'turn-in_only') {
                    await this.loadTurninItems(this.selectedShop, currentRotation);
                    // Reload daily turn-in data to update counts
                    if (this.currentCustomer) {
                        await this.loadDailyTurninData(this.currentCustomer.playerName || this.currentCustomer.player_name);
                    }
                } else {
                    await this.loadShopItems(this.selectedShop, currentRotation);
                }
                await this.loadTransactionHistory();
                
                this.closeTellerModal();
            } else {
                const failedItems = responses.filter(r => r.success === false).length;
                throw new Error(`Transaction failed for ${failedItems} items`);
            }
        } catch (error) {
            console.error('Error processing transaction:', error);
            this.showStatus('Transaction failed: ' + error.message, 'error', true);
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

    async validateDailySellingLimits() {
        try {
            const playerName = this.currentCustomer.playerName || this.currentCustomer.player_name;
            
            // Check each item in cart for daily limits
            for (const cartItem of this.cart) {
                if (cartItem.action !== 'sell') continue;
                
                // Skip if item doesn't have daily limits enabled
                if (!cartItem.daily_limit_enabled || cartItem.max_daily_sell_quantity <= 0) {
                    continue;
                }
                
                // Check current daily sales for this player/item combination
                const dailyCheckResponse = await fetch('/wp-json/jotunheim/v1/daily-sales-check', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': window.jotunheim_ajax.nonce
                    },
                    body: JSON.stringify({
                        player_name: playerName,
                        shop_id: this.selectedShop,
                        shop_item_id: cartItem.shop_item_id,
                        proposed_quantity: cartItem.quantity
                    })
                });
                
                const checkResult = await dailyCheckResponse.json();
                
                if (!checkResult.success) {
                    return {
                        valid: false,
                        error: `Daily limit validation failed for ${cartItem.item_name}: ${checkResult.error}`
                    };
                }
                
                if (!checkResult.data.can_sell) {
                    const soldToday = checkResult.data.sold_today || 0;
                    const maxDaily = cartItem.max_daily_sell_quantity;
                    const remaining = Math.max(0, maxDaily - soldToday);
                    
                    return {
                        valid: false,
                        error: `${playerName} has reached daily selling limit for ${cartItem.item_name}. Sold today: ${soldToday}/${maxDaily}. Remaining: ${remaining}`
                    };
                }
            }
            
            return { valid: true };
            
        } catch (error) {
            console.error('Daily limit validation error:', error);
            return {
                valid: false,
                error: 'Failed to validate daily selling limits. Please try again.'
            };
        }
    }

    async validateDailyBuyingLimits() {
        try {
            const playerName = this.currentCustomer.playerName || this.currentCustomer.player_name;
            
            // Check each item in cart for daily buy limits
            for (const cartItem of this.cart) {
                if (cartItem.action !== 'buy') continue;
                
                // Skip if item doesn't have daily buy limits enabled
                if (!cartItem.buy_daily_limit_enabled || cartItem.max_daily_buy_quantity <= 0) {
                    continue;
                }
                
                // Check current daily buys for this player/item combination
                const dailyCheckResponse = await fetch('/wp-json/jotunheim/v1/daily-buys-check', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': window.jotunheim_ajax.nonce
                    },
                    body: JSON.stringify({
                        player_name: playerName,
                        shop_id: this.selectedShop,
                        shop_item_id: cartItem.shop_item_id,
                        proposed_quantity: cartItem.quantity
                    })
                });
                
                const checkResult = await dailyCheckResponse.json();
                
                if (!checkResult.success) {
                    return {
                        valid: false,
                        error: `Daily buy limit validation failed for ${cartItem.item_name}: ${checkResult.error}`
                    };
                }
                
                if (!checkResult.data.can_buy) {
                    const boughtToday = checkResult.data.bought_today || 0;
                    const maxDaily = cartItem.max_daily_buy_quantity;
                    const remaining = Math.max(0, maxDaily - boughtToday);
                    
                    return {
                        valid: false,
                        error: `${playerName} has reached daily buying limit for ${cartItem.item_name}. Bought today: ${boughtToday}/${maxDaily}. Remaining: ${remaining}`
                    };
                }
            }
            
            return { valid: true };
            
        } catch (error) {
            console.error('Daily buy limit validation error:', error);
            return {
                valid: false,
                error: 'Failed to validate daily buying limits. Please try again.'
            };
        }
    }

    async validateDailyTurninLimits() {
        try {
            const playerName = this.currentCustomer.playerName || this.currentCustomer.player_name;
            
            // Check each item in cart for daily turn-in limits
            for (const cartItem of this.cart) {
                if (cartItem.action !== 'turnin') continue;
                
                // Skip if item doesn't have daily turn-in limits enabled
                if (!cartItem.turnin_daily_limit_enabled || cartItem.max_daily_turnin_quantity <= 0) {
                    continue;
                }
                
                // Check current daily turn-ins for this player/item combination
                const dailyCheckResponse = await fetch('/wp-json/jotunheim/v1/daily-turnins-check', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': window.jotunheim_ajax.nonce
                    },
                    body: JSON.stringify({
                        player_name: playerName,
                        shop_id: this.selectedShop,
                        shop_item_id: cartItem.shop_item_id,
                        proposed_quantity: cartItem.quantity
                    })
                });
                
                const checkResult = await dailyCheckResponse.json();
                
                if (!checkResult.success) {
                    return {
                        valid: false,
                        error: `Daily turn-in limit validation failed for ${cartItem.item_name}: ${checkResult.error}`
                    };
                }
                
                if (!checkResult.data.can_turnin) {
                    const turnedInToday = checkResult.data.turned_in_today || 0;
                    const maxDaily = cartItem.max_daily_turnin_quantity;
                    const remaining = Math.max(0, maxDaily - turnedInToday);
                    
                    return {
                        valid: false,
                        error: `${playerName} has reached daily turn-in limit for ${cartItem.item_name}. Turned in today: ${turnedInToday}/${maxDaily}. Remaining: ${remaining}`
                    };
                }
            }
            
            return { valid: true };
            
        } catch (error) {
            console.error('Daily turn-in limit validation error:', error);
            return {
                valid: false,
                error: 'Failed to validate daily turn-in limits. Please try again.'
            };
        }
    }

    async recordDailySales() {
        try {
            const playerName = this.currentCustomer.playerName || this.currentCustomer.player_name;
            
            // Record daily sales for each sell item in the cart
            for (const cartItem of this.cart) {
                if (cartItem.action !== 'sell') continue;
                
                // Only record if the item has daily limits enabled
                if (cartItem.daily_limit_enabled && cartItem.max_daily_sell_quantity > 0) {
                    const recordResponse = await fetch('/wp-json/jotunheim/v1/record-daily-sale', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-WP-Nonce': window.jotunheim_ajax.nonce
                        },
                        body: JSON.stringify({
                            player_name: playerName,
                            shop_id: this.selectedShop,
                            shop_item_id: cartItem.shop_item_id,
                            quantity_sold: cartItem.quantity
                        })
                    });
                    
                    if (!recordResponse.ok) {
                        console.error('Failed to record daily sale for item:', cartItem.item_name);
                    }
                }
            }
        } catch (error) {
            console.error('Error recording daily sales:', error);
            // Don't fail the transaction for this - it's already completed
        }
    }

    async recordDailyBuys() {
        try {
            const playerName = this.currentCustomer.playerName || this.currentCustomer.player_name;
            
            // Record daily buys for each buy item in the cart
            for (const cartItem of this.cart) {
                if (cartItem.action !== 'buy') continue;
                
                // Only record if the item has daily buy limits enabled
                if (cartItem.buy_daily_limit_enabled && cartItem.max_daily_buy_quantity > 0) {
                    const recordResponse = await fetch('/wp-json/jotunheim/v1/record-daily-buy', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-WP-Nonce': window.jotunheim_ajax.nonce
                        },
                        body: JSON.stringify({
                            player_name: playerName,
                            shop_id: this.selectedShop,
                            shop_item_id: cartItem.shop_item_id,
                            quantity_bought: cartItem.quantity
                        })
                    });
                    
                    if (!recordResponse.ok) {
                        console.error('Failed to record daily buy for item:', cartItem.item_name);
                    }
                }
            }
        } catch (error) {
            console.error('Error recording daily buys:', error);
            // Don't fail the transaction for this - it's already completed
        }
    }

    async recordDailyTurnins() {
        try {
            const playerName = this.currentCustomer.playerName || this.currentCustomer.player_name;
            
            // Record daily turn-ins for each turn-in item in the cart
            for (const cartItem of this.cart) {
                if (cartItem.action !== 'turnin') continue;
                
                // Only record if the item has daily turn-in limits enabled
                if (cartItem.turnin_daily_limit_enabled && cartItem.max_daily_turnin_quantity > 0) {
                    const recordResponse = await fetch('/wp-json/jotunheim/v1/record-daily-turnin', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-WP-Nonce': window.jotunheim_ajax.nonce
                        },
                        body: JSON.stringify({
                            player_name: playerName,
                            shop_id: this.selectedShop,
                            shop_item_id: cartItem.shop_item_id,
                            quantity_turned_in: cartItem.quantity
                        })
                    });
                    
                    if (!recordResponse.ok) {
                        console.error('Failed to record daily turn-in for item:', cartItem.item_name);
                    }
                }
            }
        } catch (error) {
            console.error('Error recording daily turn-ins:', error);
            // Don't fail the transaction for this - it's already completed
        }
    }

    showStatus(message, type, isCritical = false) {
        const statusDiv = document.getElementById('teller-status');
        statusDiv.innerHTML = `${message}${isCritical ? '<button id="status-close-btn" style="margin-left: 15px; padding: 5px 10px; background: rgba(255,255,255,0.3); border: none; border-radius: 3px; cursor: pointer;">✕</button>' : ''}`;
        statusDiv.className = `status-message ${type}${isCritical ? ' critical' : ''}`;
        statusDiv.style.display = 'block';
        
        let overlay = document.getElementById('status-overlay');
        
        if (isCritical) {
            // Critical messages: show overlay
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.id = 'status-overlay';
                overlay.style.position = 'fixed';
                overlay.style.top = '0';
                overlay.style.left = '0';
                overlay.style.width = '100%';
                overlay.style.height = '100%';
                overlay.style.backgroundColor = 'rgba(0,0,0,0.5)';
                overlay.style.zIndex = '9999';
                overlay.style.display = 'none';
                document.body.appendChild(overlay);
            }
            overlay.style.display = 'block';
        } else {
            // Regular messages: hide overlay
            if (overlay) {
                overlay.style.display = 'none';
            }
        }

        // Add close button functionality
        const closeBtn = document.getElementById('status-close-btn');
        if (closeBtn) {
            closeBtn.onclick = () => this.hideStatus();
        }

        // Auto-hide timeout
        const timeout = isCritical ? 8000 : 3000; // Critical messages stay longer
        setTimeout(() => {
            this.hideStatus();
        }, timeout);
    }

    hideStatus() {
        const statusDiv = document.getElementById('teller-status');
        const overlay = document.getElementById('status-overlay');
        
        statusDiv.style.display = 'none';
        statusDiv.className = ''; // Reset all classes
        if (overlay) {
            overlay.style.display = 'none';
        }
    }

    showCartView() {
        console.log('Switching to cart view');
        this.isCartView = true;
        
        // Hide shop inventory section
        const shopInventoryCard = document.querySelector('.items-card');
        if (shopInventoryCard) {
            shopInventoryCard.style.display = 'none';
        }
        
        // Show transaction summary section
        const transactionSummaryCard = document.querySelector('.summary-card');
        if (transactionSummaryCard) {
            transactionSummaryCard.style.display = 'block';
        }
        
        // Switch buttons: hide View Cart, show Record Transaction
        const viewCartBtn = document.getElementById('view-cart-btn');
        const recordBtn = document.getElementById('record-transaction-btn');
        const backBtn = document.getElementById('back-to-shop-btn');
        
        if (viewCartBtn) viewCartBtn.style.display = 'none';
        if (recordBtn) recordBtn.style.display = 'inline-block';
        if (backBtn) backBtn.style.display = 'inline-block';
        
        // Show payment summary in cart view
        const paymentSummary = document.getElementById('payment-summary-section');
        if (paymentSummary && this.getCurrentShopType() !== 'turn-in_only') {
            paymentSummary.style.display = 'block';
        }
        
        // Enable/disable record transaction button based on cart contents
        this.updateRecordTransactionButton();
    }

    showShopView() {
        console.log('🚨 DEBUG: showShopView() called');
        console.log('🚨 DEBUG: Setting isCartView to false');
        this.isCartView = false;
        
        // Show shop inventory section
        const shopInventoryCard = document.querySelector('.items-card');
        console.log('🚨 DEBUG: shopInventoryCard found:', !!shopInventoryCard);
        if (shopInventoryCard) {
            shopInventoryCard.style.display = 'block';
        }
        
        // Hide transaction summary section
        const transactionSummaryCard = document.querySelector('.summary-card');
        console.log('🚨 DEBUG: transactionSummaryCard found:', !!transactionSummaryCard);
        if (transactionSummaryCard) {
            transactionSummaryCard.style.display = 'none';
        }
        
        // Switch buttons: show View Cart, hide Record Transaction
        const viewCartBtn = document.getElementById('view-cart-btn');
        const recordBtn = document.getElementById('record-transaction-btn');
        const backBtn = document.getElementById('back-to-shop-btn');
        
        console.log('🚨 DEBUG: Buttons found - viewCart:', !!viewCartBtn, 'record:', !!recordBtn, 'back:', !!backBtn);
        
        if (viewCartBtn) viewCartBtn.style.display = 'inline-block';
        if (recordBtn) recordBtn.style.display = 'none';
        if (backBtn) backBtn.style.display = 'none';
        
        // Hide payment summary when leaving cart view
        const paymentSummary = document.getElementById('payment-summary-section');
        if (paymentSummary) {
            paymentSummary.style.display = 'none';
        }
        
        // Update view cart button state
        this.updateViewCartButton();
    }

    updateViewCartButton() {
        const viewCartBtn = document.getElementById('view-cart-btn');
        console.log('🚨 DEBUG: updateViewCartButton() called');
        console.log('🚨 DEBUG: viewCartBtn found:', !!viewCartBtn);
        console.log('🚨 DEBUG: cart length:', this.cart ? this.cart.length : 'undefined');
        console.log('🚨 DEBUG: cart contents:', this.cart);
        
        if (viewCartBtn) {
            const hasItems = this.cart && this.cart.length > 0;
            console.log('🚨 DEBUG: Updating View Cart button:', { hasItems, cartLength: this.cart ? this.cart.length : 'undefined' });
            
            // Force remove disabled state and update regardless of visibility
            viewCartBtn.disabled = !hasItems;
            viewCartBtn.textContent = hasItems ? `View Cart (${this.cart.length})` : 'View Cart';
            
            // Update button styling based on cart state
            if (hasItems) {
                viewCartBtn.style.backgroundColor = '#28a745';
                viewCartBtn.style.borderColor = '#28a745';
                viewCartBtn.style.color = 'white';
            } else {
                viewCartBtn.style.backgroundColor = '#6c757d';
                viewCartBtn.style.borderColor = '#6c757d';
                viewCartBtn.style.color = 'white';
            }
            
            console.log('🚨 DEBUG: View Cart button updated - disabled:', viewCartBtn.disabled, 'text:', viewCartBtn.textContent);
        } else {
            console.log('🚨 ERROR: View Cart button not found');
        }
    }

    updateRecordTransactionButton() {
        const recordBtn = document.getElementById('record-transaction-btn');
        if (recordBtn) {
            const hasItems = this.cart.length > 0;
            const hasCustomer = this.currentCustomer !== null;
            recordBtn.disabled = !hasItems || !hasCustomer || !this.isCartView;
        }
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    preserveAndRestoreCartState(callback) {
        // Save current state of all quantity inputs
        const cartState = {};
        
        // Find all quantity inputs with the specific ID patterns used in the shop
        const quantityInputs = document.querySelectorAll([
            '.turnin-large-quantity-input',  // Turn-in quantity inputs
            '.large-quantity-input',         // Buy/sell quantity inputs
            'input[id^="turnin-qty-"]',      // Turn-in unit inputs
            'input[id^="turnin-stack-qty-"]', // Turn-in stack inputs
            'input[id^="buy-qty-"]',         // Buy unit inputs
            'input[id^="buy-stack-qty-"]',   // Buy stack inputs
            'input[id^="sell-qty-"]',        // Sell unit inputs
            'input[id^="turnin-reg-qty-"]'   // Regular turn-in inputs
        ].join(', '));
        
        quantityInputs.forEach(input => {
            if (input.value && input.value !== '0' && input.value !== '1') { // Save if not default values
                cartState[input.id] = input.value;
            }
        });
        
        console.log('Preserving cart state:', cartState);
        
        // Execute the callback (which will re-render items)
        callback();
        
        // Restore the saved values after re-rendering
        setTimeout(() => {
            Object.keys(cartState).forEach(inputId => {
                const input = document.getElementById(inputId);
                if (input) {
                    input.value = cartState[inputId];
                    console.log(`Restored ${inputId} to value:`, cartState[inputId]);
                    
                    // Update progress display for turn-in items (check for "turnin" without hyphen)
                    if (inputId.includes('turnin')) {
                        this.updateProgressFromInput(inputId);
                    }
                }
            });
            
            // Also trigger a general update of all visible progress displays to ensure consistency
            this.updateAllProgressDisplays();
        }, 100); // Small delay to ensure DOM is updated
    }

    increaseQuantity(inputId, maxValue) {
        const input = document.getElementById(inputId);
        if (!input) return;
        
        const currentValue = parseInt(input.value) || 0;
        
        // For turn-in items, check combined total limits
        if (inputId.includes('turnin-qty-') || inputId.includes('turnin-stack-qty-')) {
            const shopItemId = inputId.replace(/^turnin-(stack-)?qty-/, '');
            const item = this.turninItems?.find(i => i.shop_item_id == shopItemId) || this.shopItems?.find(i => i.shop_item_id == shopItemId);
            
            if (item) {
                const dynamicMax = this.getMaxAllowedTurnin(item);
                
                // Get both inputs
                const unitsInput = document.getElementById(`turnin-qty-${shopItemId}`);
                const stacksInput = document.getElementById(`turnin-stack-qty-${shopItemId}`);
                
                // Calculate what the total would be after incrementing
                let newTotalUnits = 0;
                if (inputId.includes('turnin-qty-')) {
                    // This is the units input - increment it
                    const newUnitsValue = currentValue + 1;
                    newTotalUnits = newUnitsValue + (stacksInput ? (parseInt(stacksInput.value) || 0) * parseInt(item.stack_size) : 0);
                } else {
                    // This is the stacks input - increment it
                    const newStacksValue = currentValue + 1;
                    newTotalUnits = (unitsInput ? parseInt(unitsInput.value) || 0 : 0) + newStacksValue * parseInt(item.stack_size);
                }
                
                // Check if the new total would exceed the limit
                if (newTotalUnits > dynamicMax) {
                    return; // Don't increment
                }
            }
        }
        
        // Standard check against individual max
        if (currentValue < maxValue) {
            input.value = currentValue + 1;
            // Update progress display when quantity changes
            this.updateProgressFromInput(inputId);
        }
    }

    decreaseQuantity(inputId) {
        const input = document.getElementById(inputId);
        if (input) {
            const currentValue = parseInt(input.value) || 0;
            if (currentValue > 0) {
                input.value = currentValue - 1;
                
                // Update progress display when quantity changes
                this.updateProgressFromInput(inputId);
            }
        }
    }

    syncQuantityInputs(inputId) {
        // Extract item ID and type from input ID
        const itemId = inputId.match(/\d+$/)?.[0];
        if (!itemId) return;
        
        // Find the item to get stack size
        const item = this.turninItems.find(i => i.shop_item_id == itemId) || 
                    this.shopItems.find(i => i.shop_item_id == itemId);
        if (!item || !item.stack_size || parseInt(item.stack_size) <= 1) return;
        
        const stackSize = parseInt(item.stack_size);
        
        // Determine which type of input was changed and sync the other
        if (inputId.includes('stack-qty')) {
            // Stack input changed, update unit input
            const stackInput = document.getElementById(inputId);
            const unitInputId = inputId.replace('stack-qty-', 'qty-').replace('turnin-stack-qty-', 'turnin-qty-');
            const unitInput = document.getElementById(unitInputId);
            
            if (stackInput && unitInput) {
                const stackValue = parseInt(stackInput.value) || 1;
                unitInput.value = stackValue * stackSize;
            }
        } else if (inputId.includes('qty-')) {
            // Unit input changed, update stack input if it exists
            const unitInput = document.getElementById(inputId);
            const stackInputId = inputId.replace('qty-', 'stack-qty-').replace('turnin-qty-', 'turnin-stack-qty-');
            const stackInput = document.getElementById(stackInputId);
            
            if (unitInput && stackInput) {
                const unitValue = parseInt(unitInput.value) || 1;
                stackInput.value = Math.floor(unitValue / stackSize);
            }
        }
    }

    updateProgressFromInput(inputId) {
        // Extract shop item id from input id (works with both "turnin-qty-123" and "turnin-stack-qty-123")
        const shopItemId = inputId.replace('turnin-qty-', '').replace('turnin-stack-qty-', '');
        const progressElement = document.getElementById(`progress-${shopItemId}`);
        if (progressElement) {
            const item = this.turninItems.find(i => i.shop_item_id == shopItemId) || 
                        this.shopItems.find(i => i.shop_item_id == shopItemId);
            if (item) {
                progressElement.innerHTML = this.generateProgressText(item, true);
            }
        }
        
        // Update turn-in tracking if in turn-in mode
        if (this.getCurrentShopType() === 'turn-in_only') {
            this.updateTurninTracking();
        }
    }

    updateProgressDisplay(shopItemId, turnInRequirement) {
        const progressElement = document.getElementById(`progress-${shopItemId}`);
        if (progressElement) {
            const item = this.turninItems.find(i => i.shop_item_id == shopItemId) || 
                        this.shopItems.find(i => i.shop_item_id == shopItemId);
            if (item) {
                progressElement.innerHTML = this.generateProgressText(item, true);
            }
        }
        
        // Update turn-in tracking if in turn-in mode
        if (this.getCurrentShopType() === 'turn-in_only') {
            this.updateTurninTracking();
        }
    }

    updateAllProgressDisplays() {
        // Update all visible progress displays to reflect current quantity inputs
        const progressElements = document.querySelectorAll('[id^="progress-"]');
        progressElements.forEach(progressElement => {
            const shopItemId = progressElement.id.replace('progress-', '');
            const item = this.turninItems.find(i => i.shop_item_id == shopItemId) || 
                        this.shopItems.find(i => i.shop_item_id == shopItemId);
            if (item) {
                progressElement.innerHTML = this.generateProgressText(item, true);
            }
        });
        
        // Update turn-in tracking if in turn-in mode
        if (this.getCurrentShopType() === 'turn-in_only') {
            this.updateTurninTracking();
        }
    }

    preserveQuantitiesAndRerender() {
        console.log('Preserving quantities and re-rendering items...');
        
        // Save current quantities from all input fields
        const quantities = {};
        const allInputs = document.querySelectorAll([
            'input[id^="turnin-qty-"]',
            'input[id^="turnin-stack-qty-"]',
            'input[id^="buy-qty-"]',
            'input[id^="buy-stack-qty-"]',
            'input[id^="sell-qty-"]'
        ].join(', '));
        
        allInputs.forEach(input => {
            if (input.value && parseInt(input.value) > 0) {
                quantities[input.id] = input.value;
                console.log(`Saved ${input.id}: ${input.value}`);
            }
        });
        
        // Re-render the items
        this.renderShopItems();
        
        // Restore quantities and recalculate progress
        setTimeout(() => {
            Object.keys(quantities).forEach(inputId => {
                const input = document.getElementById(inputId);
                if (input) {
                    input.value = quantities[inputId];
                    console.log(`Restored ${inputId}: ${quantities[inputId]}`);
                }
            });
            
            // Recalculate all progress displays
            this.recalculateAllProgressDisplays();
        }, 100);
    }

    recalculateAllProgressDisplays() {
        console.log('Recalculating all progress displays based on current input values...');
        
        // Find all turn-in quantity inputs and trigger their progress calculations
        const turninInputs = document.querySelectorAll([
            'input[id^="turnin-qty-"]',
            'input[id^="turnin-stack-qty-"]'
        ].join(', '));
        
        turninInputs.forEach(input => {
            if (input.value && parseInt(input.value) > 0) {
                // Extract shop item ID and trigger progress update
                const shopItemId = input.id.replace('turnin-qty-', '').replace('turnin-stack-qty-', '');
                const item = this.turninItems.find(i => i.shop_item_id == shopItemId) || 
                            this.shopItems.find(i => i.shop_item_id == shopItemId);
                
                if (item) {
                    console.log(`Recalculating progress for item ${item.item_name} (ID: ${shopItemId})`);
                    this.updateProgressDisplay(shopItemId, item.turn_in_requirement || 0);
                }
            }
        });
        
        console.log('Progress recalculation complete.');
    }

    handleQuantityKeyPress(event, inputElement) {
        if (event.key === 'Enter') {
            event.preventDefault();
            inputElement.blur(); // Trigger blur event to validate and sync
        }
    }

    enforceQuantityLimits(inputElement) {
        const min = parseInt(inputElement.min) || 0;
        let max = parseInt(inputElement.max) || 999;
        let value = parseInt(inputElement.value) || 0;
        
        // For turn-in items, recalculate max dynamically to account for cart changes
        if (inputElement.id.includes('turnin-qty-') || inputElement.id.includes('turnin-stack-qty-')) {
            const shopItemId = inputElement.id.replace(/^turnin-(stack-)?qty-/, '');
            const item = this.turninItems?.find(i => i.shop_item_id == shopItemId) || this.shopItems?.find(i => i.shop_item_id == shopItemId);
            if (item) {
                const dynamicMax = this.getMaxAllowedTurnin(item);
                max = inputElement.id.includes('turnin-stack-qty-') ? 
                    Math.floor(dynamicMax / parseInt(item.stack_size)) : 
                    dynamicMax;
                    
                // Update the max attribute so it's consistent
                inputElement.setAttribute('max', max);
                    
                console.log('DEBUG - enforceQuantityLimits for turn-in:', {
                    itemName: item.item_name,
                    inputId: inputElement.id,
                    originalMax: inputElement.max,
                    dynamicMax: max,
                    currentValue: value,
                    willClamp: value > max
                });
            }
        }
        
        // Store cursor position to preserve it
        const cursorPosition = inputElement.selectionStart;
        
        // Enforce limits in real-time - prevent typing beyond max
        if (value < min) value = min;
        if (value > max) value = max;
        
        // Only update if the value actually changed to prevent cursor jumping
        if (parseInt(inputElement.value) !== value) {
            inputElement.value = value;
            // Restore cursor position
            setTimeout(() => {
                inputElement.setSelectionRange(cursorPosition, cursorPosition);
            }, 0);
        }
        
        // Update progress display if this is a turn-in item
        if (inputElement.id.includes('turnin-qty-') || inputElement.id.includes('turnin-stack-qty-')) {
            const shopItemId = inputElement.id.replace(/^turnin-(stack-)?qty-/, '');
            const item = this.turninItems?.find(i => i.shop_item_id == shopItemId) || this.shopItems?.find(i => i.shop_item_id == shopItemId);
            if (item) {
                this.updateProgressDisplay(shopItemId, item.turn_in_requirement || 0);
            }
        }
    }

    handleQuantityBlur(inputElement) {
        const min = parseInt(inputElement.min) || 0;
        const max = parseInt(inputElement.max) || 999;
        let value = parseInt(inputElement.value) || 0;
        
        // Validate and constrain the value
        if (value < min) value = min;
        if (value > max) value = max;
        
        inputElement.value = value;
        
        // Sync with related inputs and update progress
        this.syncQuantityInputs(inputElement.id);
        
        // Update progress display if this is a turn-in item
        if (inputElement.id.includes('turnin-qty-') || inputElement.id.includes('turnin-stack-qty-')) {
            const shopItemId = inputElement.id.replace(/^turnin-(stack-)?qty-/, '');
            const item = this.turninItems?.find(i => i.shop_item_id == shopItemId) || this.shopItems?.find(i => i.shop_item_id == shopItemId);
            if (item) {
                this.updateProgressDisplay(shopItemId, item.turn_in_requirement || 0);
            }
        }
    }

    generateProgressText(item, includeCurrent = false) {
        const dailyTotal = this.getDailyTurninTotal(item.item_name);
        const playerDailyTotal = this.getPlayerDailyTurninTotal(item.item_name);
        const turnInRequirement = parseInt(item.turn_in_requirement) || 0;
        
        let currentlySelected = 0;
        if (includeCurrent) {
            // Always check input values first for live updates
            const unitsInput = document.getElementById(`turnin-qty-${item.shop_item_id}`);
            const units = unitsInput ? parseInt(unitsInput.value) || 0 : 0;
            
            const stacksInput = document.getElementById(`turnin-stack-qty-${item.shop_item_id}`);
            const stacks = stacksInput ? parseInt(stacksInput.value) || 0 : 0;
            const stackSize = parseInt(item.stack_size) || 1;
            
            const inputTotal = units + (stacks * stackSize);
            
            // If there are input values, use them (for live updates)
            if (inputTotal > 0) {
                currentlySelected = inputTotal;
            } else {
                // If no input values, check if item is in cart
                const cartItem = this.cart.find(cartItem => 
                    cartItem.shop_item_id == item.shop_item_id && cartItem.action === 'turnin'
                );
                
                if (cartItem) {
                    // Item is in cart but no input values - use cart quantity
                    currentlySelected = cartItem.quantity;
                }
            }
        }
        
        const progressLines = [];
        
        // Always show: Current transaction quantity
        if (currentlySelected > 0) {
            progressLines.push(`<div class="progress-line transaction-progress">${currentlySelected} turned in this transaction</div>`);
        }
        
        // Conditional: Player's 24h total (only if player has turned items in)
        if (playerDailyTotal > 0) {
            progressLines.push(`<div class="progress-line player-progress">${playerDailyTotal} turned in last 24h by player</div>`);
        }
        
        // Always show: Server total progress (including current transaction)
        const projectedTotal = dailyTotal + currentlySelected;
        
        // DEBUG: Add debugging info for turn-in progress calculation
        console.log('DEBUG - Turn-in progress calculation:', {
            itemName: item.item_name,
            dailyTotal,
            currentlySelected,
            projectedTotal,
            turnInRequirement,
            includeCurrent
        });
        
        if (turnInRequirement > 0) {
            progressLines.push(`<div class="progress-line server-progress">${projectedTotal} / ${turnInRequirement} collected</div>`);
        } else {
            progressLines.push(`<div class="progress-line server-progress">${projectedTotal} collected</div>`);
        }
        
        return progressLines.join('');
    }

    getPlayerDailyTurninTotal(itemName) {
        // This would need to be implemented based on your data structure
        // For now, return 0 until we can implement proper player-specific tracking
        // TODO: Implement player-specific daily turnin tracking
        return 0;
    }

    formatDate(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
    }

    // Customer search functionality
    async handleCustomerSearch(searchTerm) {
        console.log('handleCustomerSearch called with:', searchTerm);
        
        // Don't clear validation or show suggestions if we're in the middle of selecting a customer
        if (this.isSelectingCustomer || this.suppressDropdown) {
            console.log('Skipping search - customer being selected or dropdown suppressed');
            return;
        }
        
        // Only clear validation if no exact match will be found - we'll check this later in the function
        
        if (searchTerm.length < 2) {
            this.hideCustomerSuggestions();
            return;
        }

        try {
            // Use cached player list if available, otherwise fetch
            let players = this.playerList;
            if (!players || players.length === 0) {
                console.log('Fetching players for search...');
                const response = await JotunAPI.getPlayers();
                players = response.data || [];
                this.playerList = players; // Cache for future use
                console.log('Fetched players:', players);
            }
            
            const filteredPlayers = players.filter(player => 
                player.activePlayerName && player.activePlayerName.toLowerCase().includes(searchTerm.toLowerCase())
            );

            console.log('Filtered players:', filteredPlayers);
            
            // Check for exact match and auto-validate
            const exactMatch = filteredPlayers.find(player => 
                player.activePlayerName && player.activePlayerName.toLowerCase() === searchTerm.toLowerCase()
            );
            
            if (exactMatch) {
                console.log('Exact match found:', exactMatch.activePlayerName);
                this.currentCustomer = exactMatch;
                this.showValidationIcon('valid');
                this.hideCustomerSuggestions();
                
                // Enable transaction processing if cart has items
                const recordBtn = document.getElementById('record-transaction-btn');
                const turninBtn = document.getElementById('record-turnin-btn');
                if (recordBtn) recordBtn.disabled = this.cart.length === 0;
                if (turninBtn) turninBtn.disabled = this.cart.length === 0;
            } else {
                // Check if we should show register option (no matches at all)
                if (filteredPlayers.length === 0) {
                    console.log('No players match search term, showing register option');
                    this.hideValidationIcon();
                    this.currentCustomer = null;
                    this.showValidationIcon('register');
                } else {
                    // Show suggestions for partial matches
                    this.hideValidationIcon();
                    this.currentCustomer = null;
                    this.showCustomerSuggestions(filteredPlayers, 'customer-suggestions');
                }
            }
        } catch (error) {
            console.error('Error searching customers:', error);
            this.showStatus('Error searching for customers', 'error');
        }
        
        // Also validate after a delay if no exact match was found
        if (!this.currentCustomer && searchTerm.trim().length >= 2) {
            clearTimeout(this.validateTimeout);
            this.validateTimeout = setTimeout(() => {
                this.validateCustomer(searchTerm.trim());
            }, 500);
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
                player.activePlayerName && player.activePlayerName.toLowerCase().includes(searchTerm.toLowerCase())
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

        // Remove force-hidden class and reset styles when showing
        container.classList.remove('force-hidden');
        container.style.display = 'block';
        container.style.visibility = 'visible';
        container.style.opacity = '1';
        container.style.height = 'auto';
        container.style.maxHeight = '300px';
        container.style.overflow = 'auto';

        container.innerHTML = '';
        players.slice(0, 50).forEach((player, index) => {
            const suggestion = document.createElement('div');
            suggestion.className = 'customer-suggestion';
            suggestion.innerHTML = `
                <span class="customer-suggestion-name">${player.activePlayerName}</span>
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
        // Set flag to prevent handleCustomerSearch from clearing validation
        this.isSelectingCustomer = true;
        
        document.getElementById('customer-name').value = player.activePlayerName;
        this.currentCustomer = player;
        this.hideCustomerSuggestions();
        this.showValidationIcon('valid');
        
        // Enable transaction processing if cart has items
        const recordBtn = document.getElementById('record-transaction-btn');
        const turninBtn = document.getElementById('record-turnin-btn');
        if (recordBtn) recordBtn.disabled = this.cart.length === 0;
        if (turninBtn) turninBtn.disabled = this.cart.length === 0;
        
        // Clear the flag after a short delay to allow input event to process
        setTimeout(() => {
            this.isSelectingCustomer = false;
        }, 100);
    }

    selectTurninCustomer(player) {
        document.getElementById('turnin-customer-name').value = player.activePlayerName;
        this.currentTurninCustomer = player;
        this.hideTurninCustomerSuggestions();
        this.displayCustomerInfo(player, 'turnin');
    }

    displayCustomerInfo(player, type) {
        const prefix = type === 'turnin' ? 'turnin-' : '';
        
        document.getElementById(`${prefix}customer-display-name`).textContent = player.activePlayerName;
        document.getElementById(`${prefix}customer-active-status`).textContent = player.is_active ? 'Active' : 'Inactive';
        document.getElementById(`${prefix}customer-registration`).textContent = this.formatDate(player.created_at);
        document.getElementById(`${prefix}customer-info`).style.display = 'block';
        document.getElementById(`${prefix}customer-status`).style.display = 'none';
    }

    hideCustomerSuggestions() {
        // Hide both suggestion containers
        const containers = [
            document.getElementById('customer-suggestions'),
            document.getElementById('player-suggestions')
        ];
        
        containers.forEach(container => {
            if (container) {
                container.style.display = 'none';
                container.style.visibility = 'hidden';
                container.style.opacity = '0';
                container.style.height = '0';
                container.style.maxHeight = '0';
                container.style.overflow = 'hidden';
                container.classList.add('force-hidden');
            }
        });
    }

    hideTurninCustomerSuggestions() {
        const container = document.getElementById('turnin-customer-suggestions');
        if (container) container.style.display = 'none';
    }

    handleCustomerKeydown(e) {
        const suggestions = document.querySelectorAll('#customer-suggestions .customer-suggestion');
        
        if (e.key === 'Enter') {
            e.preventDefault();
            
            // Get current input value
            const customerName = e.target.value.trim();
            
            // Suppress dropdown for a period after Enter is pressed
            this.suppressDropdown = true;
            setTimeout(() => {
                this.suppressDropdown = false;
            }, 300);
            
            if (customerName) {
                // First check for exact match in our player list
                let exactMatch = null;
                if (this.playerList && this.playerList.length > 0) {
                    exactMatch = this.playerList.find(p => 
                        p.activePlayerName && p.activePlayerName.toLowerCase() === customerName.toLowerCase()
                    );
                }
                
                if (exactMatch) {
                    console.log('Enter key - exact match found:', exactMatch.activePlayerName);
                    // Set the customer directly
                    this.currentCustomer = exactMatch;
                    this.showValidationIcon('valid');
                    
                    // Aggressively hide dropdown and prevent it from showing again
                    this.hideCustomerSuggestions();
                    this.isSelectingCustomer = true;
                    
                    // Force hide dropdown multiple times to ensure it stays hidden
                    setTimeout(() => this.hideCustomerSuggestions(), 10);
                    setTimeout(() => this.hideCustomerSuggestions(), 50);
                    setTimeout(() => this.hideCustomerSuggestions(), 100);
                    
                    // Clear the flag after a delay
                    setTimeout(() => {
                        this.isSelectingCustomer = false;
                    }, 200);
                } else {
                    console.log('Enter key - no exact match, triggering validation');
                    // No exact match, trigger full validation
                    this.validateCustomer(customerName);
                }
                
                // Always hide dropdown when Enter is pressed - multiple times
                this.hideCustomerSuggestions();
                setTimeout(() => this.hideCustomerSuggestions(), 10);
                setTimeout(() => this.hideCustomerSuggestions(), 50);
            }
            
            return false;
        }
        
        // Handle arrow keys for suggestion navigation
        if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
            e.preventDefault();
            // Implementation for keyboard navigation would go here
        }
        
        if (e.key === 'Escape') {
            this.hideCustomerSuggestions();
        }
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
        const rawTotalCost = parseFloat(document.getElementById('item-total-cost')?.textContent || 0);
        
        // For payment tracking, we always want the absolute cost that customer needs to pay
        const absoluteCost = Math.abs(rawTotalCost);
        
        // Determine transaction type based on cost sign
        const isSelling = rawTotalCost < 0; // Negative cost means shop is selling to customer
        const isBuying = rawTotalCost > 0;  // Positive cost means shop is buying from customer
        
        // Calculate Ymir Flesh equivalent (120 gold = 1 Ymir Flesh)
        const ymirRate = 120;
        const totalYmirEquivalent = Math.floor(absoluteCost / ymirRate);
        const remainingGold = absoluteCost % ymirRate;
        
        // Update cost display with both formats
        const costElement = document.getElementById('item-total-cost');
        if (costElement) {
            let costDisplay = `${absoluteCost}g`;
            if (totalYmirEquivalent > 0) {
                costDisplay += ` or ${totalYmirEquivalent} Ymir & ${remainingGold}g`;
            }
            costElement.textContent = costDisplay;
        }

        // Calculate total amount paid (Ymir Flesh * 120 + Gold)
        const amountPaid = (ymirFlesh * ymirRate) + gold;
        const difference = amountPaid - absoluteCost;

        // Update amount paid display
        const amountPaidDisplay = document.getElementById('amount-paid-display');
        if (amountPaidDisplay) {
            amountPaidDisplay.textContent = amountPaid.toFixed(0) + 'g';
        }
        
        // Update difference display
        const differenceElement = document.getElementById('payment-difference');
        if (differenceElement) {
            differenceElement.textContent = difference.toFixed(0) + 'g';
            differenceElement.className = `summary-value ${difference < 0 ? 'negative' : difference > 0 ? 'positive' : ''}`;
        }

        // Update payment status
        const statusElement = document.getElementById('payment-status');
        if (statusElement) {
            if (difference === 0) {
                statusElement.textContent = 'Fair Trade! ✓';
                statusElement.className = 'payment-status balanced';
                this.hidePaymentWarnings();
            } else if (difference > 0) {
                statusElement.textContent = `Overpaid: ${difference.toFixed(0)}g`;
                statusElement.className = 'payment-status overpaid';
                this.showPaymentWarning('overpaid', difference);
            } else {
                statusElement.textContent = `Underpaid: ${Math.abs(difference).toFixed(0)}g`;
                statusElement.className = 'payment-status underpaid';
                this.showPaymentWarning('underpaid', Math.abs(difference));
            }
        }
    }

    showPaymentWarning(type, amount) {
        // Hide all warnings first
        this.hidePaymentWarnings();
        
        const warningsContainer = document.getElementById('payment-warnings');
        if (warningsContainer) {
            warningsContainer.style.display = 'block';
            
            if (type === 'overpaid') {
                const overpaidWarning = document.getElementById('overpaid-warning');
                if (overpaidWarning) {
                    overpaidWarning.style.display = 'block';
                }
                // Show change due section
                this.showChangeDueSection(amount);
            } else if (type === 'underpaid') {
                const underpaidWarning = document.getElementById('underpaid-warning');
                if (underpaidWarning) {
                    underpaidWarning.style.display = 'block';
                }
                this.hideChangeDueSection();
            }
        }
    }

    hidePaymentWarnings() {
        const warningsContainer = document.getElementById('payment-warnings');
        if (warningsContainer) {
            warningsContainer.style.display = 'none';
        }
        
        ['overpaid-warning', 'underpaid-warning', 'balanced-confirmation'].forEach(id => {
            const element = document.getElementById(id);
            if (element) element.style.display = 'none';
        });
        
        this.hideChangeDueSection();
    }

    showChangeDueSection(changeDue) {
        const changeDueSection = document.getElementById('change-due-section');
        if (changeDueSection) {
            changeDueSection.style.display = 'block';
            
            // Calculate suggested change
            const ymirRate = 120;
            const suggestedYmir = Math.floor(changeDue / ymirRate);
            const suggestedGold = changeDue % ymirRate;
            
            // Pre-fill suggested amounts
            const ymirInput = document.getElementById('change-ymir-flesh');
            const goldInput = document.getElementById('change-gold');
            
            if (ymirInput) ymirInput.value = suggestedYmir;
            if (goldInput) goldInput.value = suggestedGold;
            
            this.updateChangeCalculation();
        }
    }

    hideChangeDueSection() {
        const changeDueSection = document.getElementById('change-due-section');
        if (changeDueSection) {
            changeDueSection.style.display = 'none';
        }
    }

    updateChangeCalculation() {
        const changeYmir = parseFloat(document.getElementById('change-ymir-flesh')?.value || 0);
        const changeGold = parseFloat(document.getElementById('change-gold')?.value || 0);
        const ymirRate = 120;
        
        const totalChangeGiven = (changeYmir * ymirRate) + changeGold;
        const difference = parseFloat(document.getElementById('payment-difference')?.textContent || 0);
        const remainingChange = difference - totalChangeGiven;
        
        const totalChangeElement = document.getElementById('total-change-given');
        const remainingChangeElement = document.getElementById('remaining-change-due');
        
        if (totalChangeElement) {
            totalChangeElement.textContent = totalChangeGiven.toFixed(0) + 'g';
        }
        
        if (remainingChangeElement) {
            remainingChangeElement.textContent = remainingChange.toFixed(0) + 'g';
            remainingChangeElement.className = `summary-value ${remainingChange > 0 ? 'positive' : remainingChange < 0 ? 'negative' : ''}`;
        }
    }

    // Turn-in shop methods
    displayTurninItems() {
        const container = document.getElementById('turnin-items-grid');
        if (!container) return;

        // Ensure consistent display property
        container.style.display = 'flex';
        container.innerHTML = '';

        if (this.turninItems.length === 0) {
            container.innerHTML = '<div class="no-items">No turn-in items available for this shop.</div>';
            return;
        }

        this.turninItems.forEach(item => {
            // Use the existing createItemCard method which has proper stack support and styling
            const itemCard = this.createItemCard(item);
            container.appendChild(itemCard);
            
            // Update progress display now that the card is in the DOM
            setTimeout(() => {
                this.updateProgressDisplay(item.shop_item_id, item.turn_in_requirement || 0);
            }, 0);
        });
    }



    addTurninItem(shopItemId) {
        // Validate customer first
        if (!this.validateCustomerForAction()) {
            return;
        }

        // Get units input
        const unitsInput = document.getElementById(`turnin-qty-${shopItemId}`);
        const units = unitsInput ? parseInt(unitsInput.value) || 0 : 0;
        
        // Get stacks input if it exists
        const stacksInput = document.getElementById(`turnin-stack-qty-${shopItemId}`);
        const stacks = stacksInput ? parseInt(stacksInput.value) || 0 : 0;
        
        // Initialize turninItems if not loaded
        if (!this.turninItems) {
            this.turninItems = this.shopItems || [];
        }
        
        const item = this.turninItems.find(i => i.shop_item_id == shopItemId) || this.shopItems.find(i => i.shop_item_id == shopItemId);
        if (!item) {
            console.log('Item not found for turn-in:', shopItemId);
            return;
        }
        
        // Get stack size for calculation
        const stackSize = parseInt(item?.stack_size || 1);
        
        // Calculate total quantity: units + (stacks * stackSize)
        const quantity = units + (stacks * stackSize);
        
        if (quantity <= 0) {
            this.showStatus('Please enter a quantity to turn in', 'error');
            return;
        }

        // Add to main cart with 'turnin' action type
        const existingItem = this.cart.find(cartItem => 
            cartItem.shop_item_id === shopItemId && cartItem.action === 'turnin'
        );

        if (existingItem) {
            // Replace quantity instead of adding (for update functionality)
            existingItem.quantity = quantity;
            existingItem.total_price = existingItem.unit_price * existingItem.quantity;
        } else {
            // Debug logging to track the 10x issue
            console.log('DEBUG - Adding turn-in item to cart:', {
                item_name: item.item_name,
                raw_item_data: item,
                turn_in_quantity_from_item: item.turn_in_quantity,
                turn_in_requirement_from_item: item.turn_in_requirement
            });
            
            this.cart.push({
                shop_item_id: shopItemId,
                item_name: item.item_name,
                action: 'turnin',
                quantity: quantity,
                price: item.event_points || 0,
                unit_price: item.event_points || 0,
                total_price: item.event_points || 0,
                stack_size: item.stack_size || 1,
                turn_in_quantity: parseInt(item.turn_in_quantity || 0),
                turn_in_requirement: parseInt(item.turn_in_requirement || 0),
                item: item,
                shop_id: this.selectedShop // Make sure shop_id is included
            });
        }

        console.log('Added turn-in item to cart:', item.item_name, 'Cart now has', this.cart.length, 'items');
        this.updateCartDisplay();
        
        // Explicitly update cart view buttons
        this.updateViewCartButton();
        this.updateRecordTransactionButton();
        
        const actionText = existingItem ? 'Updated' : 'Added';
        this.showStatus(`${actionText} ${item.item_name} in turn-in cart`, 'success');
        
        // Refresh display to update button states
        this.refreshItemDisplay();
        
        // Recalculate progress displays after adding to cart
        this.updateAllProgressDisplays();
    }

    addTurninItemWithQuantity(shopItemId) {
        // Validate customer first
        if (!this.validateCustomerForAction()) {
            return;
        }

        // Get units input (check both turnin and table inputs)
        const unitsInput = document.getElementById(`turnin-qty-${shopItemId}`) || document.getElementById(`table-qty-${shopItemId}`);
        const units = unitsInput ? parseInt(unitsInput.value) || 0 : 0;
        
        // Get stacks input if it exists (only exists in turnin view, not table)
        const stacksInput = document.getElementById(`turnin-stack-qty-${shopItemId}`);
        const stacks = stacksInput ? parseInt(stacksInput.value) || 0 : 0;
        
        // Initialize turninItems if not loaded
        if (!this.turninItems) {
            this.turninItems = this.shopItems || [];
        }
        
        const item = this.turninItems.find(i => i.shop_item_id == shopItemId) || this.shopItems.find(i => i.shop_item_id == shopItemId);
        
        // Get stack size for calculation
        const stackSize = parseInt(item?.stack_size || 1);
        
        // Calculate total quantity: units + (stacks * stackSize)
        const quantity = units + (stacks * stackSize);
        
        if (!item) {
            console.log('Item not found for turn-in:', shopItemId);
            return;
        }
        
        if (quantity <= 0) {
            this.showStatus('Please enter a quantity to turn in', 'error');
            return;
        }

        // Enhanced limit checking - consider existing cart items
        const limitCheck = this.checkTurninLimits(item, quantity);
        if (!limitCheck.allowed) {
            this.showStatus(limitCheck.message, 'error');
            return;
        }

        console.log(`DEBUG: addTurninItemWithQuantity - shopItemId=${shopItemId}, quantity=${quantity}, cartBefore=${this.cart.length}`);

        // Add to main cart with 'turnin' action type
        const existingItem = this.cart.find(cartItem => 
            cartItem.shop_item_id === shopItemId && cartItem.action === 'turnin'
        );

        if (existingItem) {
            // Replace quantity instead of adding (for update functionality)
            existingItem.quantity = quantity;
            existingItem.total_price = existingItem.unit_price * existingItem.quantity;
        } else {
            this.cart.push({
                shop_item_id: shopItemId,
                item_name: item.item_name,
                action: 'turnin',
                quantity: quantity,
                price: 0, // Turn-in items don't have prices
                unit_price: 0,
                total_price: 0,
                stack_size: item.stack_size || 1,
                turn_in_quantity: parseInt(item.turn_in_quantity || 0),
                turn_in_requirement: parseInt(item.turn_in_requirement || 0),
                item: item,
                shop_id: this.selectedShop // Make sure shop_id is included
            });
        }

        console.log('DEBUG: Added turn-in item to cart:', item.item_name, 'quantity:', quantity, 'Cart now has', this.cart.length, 'items', 'existingItem:', !!existingItem);
        console.log('DEBUG: Cart contents:', this.cart.map(c => ({id: c.shop_item_id, action: c.action, qty: c.quantity})));
        this.updateCartDisplay();
        
        // Explicitly update cart view buttons
        this.updateViewCartButton();
        this.updateRecordTransactionButton();
        
        const actionText = existingItem ? 'Updated' : 'Added';
        this.showStatus(`${actionText} ${quantity} ${item.item_name} in turn-in cart`, 'success');
        
        // Refresh display to update button states
        this.refreshItemDisplay();
        
        // Recalculate progress displays after adding to cart
        this.updateAllProgressDisplays();
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
            this.showStatus('Please validate a customer first', 'error', true);
            return;
        }

        if (!this.turninList || this.turninList.length === 0) {
            this.showStatus('Please add items to turn in', 'error', true);
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
        const toggleBtn = document.getElementById('toggle-view-btn');
        
        // Initialize view state - grid view should be default (when button shows "Toggle View")
        if (gridContainer && tableContainer && toggleBtn) {
            gridContainer.style.display = 'flex'; // Use flex to match CSS
            tableContainer.style.display = 'none';
            toggleBtn.textContent = 'Toggle View';
            this.isTableView = false; // Reset to grid view
        }
        
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
    
            
            // Use the existing createItemCard method which has proper conditional buttons and icons
            const itemCard = this.createItemCard(item);
            container.appendChild(itemCard);
        });
    }

    renderItemsTable(container) {
        // EXACT DUPLICATE of renderItemsGrid - preserve ALL working functionality
        container.innerHTML = '';

        if (this.shopItems.length === 0) {
            container.innerHTML = '<div class="no-items">No items available for this shop.</div>';
            return;
        }

        // Create table structure but fill with WORKING CARDS
        container.innerHTML = `
            <table class="items-table">
                <thead>
                    <tr>
                        <th class="icon-column">Icon</th>
                        <th>Item</th>
                        <th>Quantity Controls</th>
                        <th>Progress/Calculations</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-body-cards">
                </tbody>
            </table>
        `;

        const tableBody = container.querySelector('.table-body-cards');

        // Use EXACT same logic as renderItemsGrid
        this.shopItems.forEach(item => {
            if (item.is_available == 1) {
                // Use the existing createItemCard method - IDENTICAL to grid
                const itemCard = this.createItemCard(item);
                
                // Create table row wrapper but insert the COMPLETE working card
                const tableRow = document.createElement('tr');
                tableRow.className = 'table-row-card-wrapper';
                
                // Insert the entire working card into a single table cell that spans all columns
                const cardCell = document.createElement('td');
                cardCell.colSpan = 4;
                cardCell.className = 'card-cell';
                cardCell.appendChild(itemCard);
                
                tableRow.appendChild(cardCell);
                tableBody.appendChild(tableRow);
            }
        });
    }

    generateTableItemActions(item) {
        let actionsHTML = '';
        
        // Check for Buy button (buy=1 means customers can buy from shop, so teller sells)
        if (item.buy == 1 || item.buy === true) {
            actionsHTML += `<button class="btn btn-sm btn-success table-action-btn" onclick="window.unifiedTeller.addToCart(${item.shop_item_id}, 'buy', 'individual')" title="Sell to customer">Sell</button> `;
        }
        
        // Check for Sell button (sell=1 means shop will buy from customers, so teller buys)
        if (item.sell == 1 || item.sell === true) {
            actionsHTML += `<button class="btn btn-sm btn-warning table-action-btn" onclick="window.unifiedTeller.addToCart(${item.shop_item_id}, 'sell', 'individual')" title="Buy from customer">Buy</button> `;
        }
        
        // Check for Turn In button
        if (item.turn_in == 1 || item.turn_in === true) {
            if (item.event_points !== undefined && item.event_points !== null && item.event_points > 0) {
                actionsHTML += `<button class="btn btn-sm btn-info table-action-btn" onclick="window.unifiedTeller.addTurninItemWithQuantity(${item.shop_item_id})" title="Turn in for ${item.event_points} points">Turn In</button> `;
            } else {
                actionsHTML += `<button class="btn btn-sm btn-info table-action-btn" onclick="window.unifiedTeller.addToTurnin(${item.shop_item_id})" title="Turn in for points">Turn In</button> `;
            }
        }
        
        return actionsHTML || '<span class="text-muted">No actions</span>';
    }

    getItemPriceDisplay(item) {
        // Check if this is a turn-in item
        if (item.turn_in == 1 || item.turn_in === true) {
            // For turn-in items, show event points if available, otherwise show reward info
            if (item.event_points !== undefined && item.event_points !== null && item.event_points > 0) {
                return `${item.event_points} pts`;
            } else {
                return 'Reward'; // Generic reward text for turn-in items without specific points
            }
        }
        
        // For regular buy/sell items, show unit price
        const unitPrice = item.unit_price || item.price || item.default_price || 0;
        return `${unitPrice}`;
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

    addToCart(shopItemId, action = 'buy', quantityType = 'individual') {
        // Validate customer first
        if (!this.validateCustomerForAction()) {
            return;
        }

        const item = this.shopItems.find(i => i.shop_item_id == shopItemId);
        if (!item) {
            this.showStatus('Item not found', 'error');
            return;
        }

        // Get quantity from appropriate input
        let qtyInput, quantity, unitPrice;
        
        if (quantityType === 'stack') {
            qtyInput = document.getElementById(`qty-stack-${shopItemId}`);
            const stackQuantity = qtyInput ? parseInt(qtyInput.value) || 1 : 1;
            quantity = stackQuantity * (item.stack_size || 1); // Total items
            unitPrice = item.unit_price || 0; // Still price per individual item
        } else {
            qtyInput = document.getElementById(`qty-individual-${shopItemId}`) || document.getElementById(`table-qty-${shopItemId}`);
            quantity = qtyInput ? parseInt(qtyInput.value) || 1 : 1;
            unitPrice = item.unit_price || 0;
        }

        if (quantity <= 0) {
            this.showStatus('Invalid quantity', 'error');
            return;
        }

        // Calculate total price
        const totalPrice = unitPrice * quantity;

        // Add to cart or update existing cart item
        const existingItem = this.cart.find(cartItem => 
            cartItem.shop_item_id === shopItemId && cartItem.action === action
        );

        if (existingItem) {
            // Replace quantity instead of adding (for update functionality)
            existingItem.quantity = quantity;
            existingItem.total_price = existingItem.unit_price * existingItem.quantity;
        } else {
            this.cart.push({
                shop_item_id: shopItemId,
                item_name: item.item_name,
                action: action,
                quantity: quantity,
                price: unitPrice,
                unit_price: unitPrice,
                total_price: totalPrice,
                stack_size: item.stack_size || 1,
                quantity_type: quantityType
            });
        }

        this.updateCartDisplay();
        this.updatePaymentCalculations();
        
        // Update button states when items are added to cart
        this.updateViewCartButton();
        this.updateRecordTransactionButton();
        
        const quantityDesc = quantityType === 'stack' ? 
            `${qtyInput.value} stack(s) (${quantity} items)` : 
            `${quantity} item(s)`;
        const actionText = existingItem ? 'Updated' : 'Added';
        this.showStatus(`${actionText} ${quantityDesc} of ${item.item_name} in cart (${action})`, 'success');

        // Don't reset quantity input - keep values for update functionality
        
        // Refresh display to update button states
        this.refreshItemDisplay();
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

        // Don't reset quantity input - keep values for update functionality
        
        // Refresh display to update button states
        this.refreshItemDisplay();
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
            
            // Different display for turn-in vs buy/sell items
            let pricingSection;
            if (cartItem.action === 'turnin') {
                console.log('DEBUG - Turn-in progress calculation:', {
                    turn_in_quantity: cartItem.turn_in_quantity,
                    turn_in_quantity_type: typeof cartItem.turn_in_quantity,
                    quantity: cartItem.quantity,
                    quantity_type: typeof cartItem.quantity,
                    raw_addition: (cartItem.turn_in_quantity || 0) + cartItem.quantity
                });
                
                // Fix double-counting: dailyTotal already includes turn_in_quantity from database
                const dailyTotal = this.getDailyTurninTotal(cartItem.item_name);
                const cartQuantity = parseInt(cartItem.quantity || 0);
                const projectedTotal = dailyTotal + cartQuantity;
                const required = parseInt(cartItem.turn_in_requirement || 0);
                const remaining = Math.max(0, required - dailyTotal);
                
                console.log('DEBUG - Fixed progress calculation (no double-counting):', {
                    dailyTotal,
                    cartQuantity,
                    projectedTotal,
                    required,
                    remaining,
                    oldDoubleCountMethod: parseInt(cartItem.turn_in_quantity || 0) + parseInt(cartItem.quantity || 0)
                });
                
                pricingSection = `
                    <div class="item-pricing">
                        <span class="unit-price">${remaining} remaining</span>
                        <span class="total-price">${projectedTotal} / ${required}</span>
                    </div>
                `;
            } else {
                pricingSection = `
                    <div class="item-pricing">
                        <span class="unit-price">${cartItem.unit_price} each</span>
                        <span class="total-price">${cartItem.total_price} total</span>
                    </div>
                `;
            }
            
            // Enhanced cart display with better space utilization and turn-in limit tracking
            const dailyTotal = cartItem.action === 'turnin' ? this.getDailyTurninTotal(cartItem.item_name) : 0;
            const turnInLimit = cartItem.action === 'turnin' ? parseInt(cartItem.turn_in_requirement || 0) : 0;
            const projectedDaily = dailyTotal + parseInt(cartItem.quantity || 0);
            
            itemRow.innerHTML = `
                <div class="item-info">
                    <span class="item-name">${cartItem.item_name}</span>
                    <span class="item-action ${cartItem.action}" style="background-color: ${cartItem.action === 'sell' ? '#dc3545' : cartItem.action === 'buy' ? '#28a745' : cartItem.action === 'turnin' ? '#6c757d' : '#6c757d'}; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; text-transform: uppercase; display: inline-block;">${cartItem.action.toUpperCase()}</span>
                </div>
                <div class="item-quantity">
                    <input type="number" class="cart-qty-input" value="${cartItem.quantity}" 
                           min="1" readonly style="background-color: #f8f9fa; cursor: not-allowed;" 
                           title="Go back to Shop Inventory to change quantity">
                    ${cartItem.action === 'turnin' && turnInLimit > 0 ? 
                        `<span class="daily-limit-info">Last 24h: ${projectedDaily} / ${turnInLimit}</span>` : 
                        cartItem.action === 'turnin' ? 
                            `<span class="daily-limit-info">Last 24h: ${projectedDaily}</span>` :
                            `<span class="stack-info">/ ${cartItem.stack_size}</span>`}
                </div>
                ${pricingSection}
                <button class="btn btn-sm btn-danger" onclick="window.unifiedTeller.removeFromCart(${index})">
                    Remove
                </button>
            `;
            container.appendChild(itemRow);

            // Calculate total (buy adds to cost, sell subtracts, turnin is neutral)
            if (cartItem.action === 'buy') {
                totalCost += cartItem.total_price;
            } else if (cartItem.action === 'sell') {
                totalCost -= cartItem.total_price;
            } else if (cartItem.action === 'turnin') {
                // Turn-in items don't affect monetary cost, only event points
            }
        });

        // Update total cost display
        document.getElementById('item-total-cost').textContent = totalCost.toFixed(0);
        document.getElementById('record-transaction-btn').disabled = false;
        
        // Update payment calculations
        this.updatePaymentCalculations();
        
        // Update turn-in tracking if in turn-in mode
        if (this.getCurrentShopType() === 'turn-in_only') {
            this.updateTurninTracking();
        }
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
                console.log('window.unifiedTeller assigned:', typeof window.unifiedTeller);
                console.log('preventOverLimit method accessible:', typeof window.unifiedTeller.preventOverLimit);
            } else {
                console.log('JotunAPI not ready, waiting...');
                setTimeout(checkAPI, 100);
            }
        };
        checkAPI();
        
        // Input validation system is now active

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