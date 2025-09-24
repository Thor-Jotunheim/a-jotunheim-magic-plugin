/**
 * Shop Manager JavaScript
 * Handles shop creation, editing, and item management
 */

class ShopManager {
    constructor() {
        this.currentEditingShop = null;
        this.currentEditingShopType = null;
        this.currentEditingShopItem = null;
        this.selectedShop = null;
        this.selectedShopData = null;
        this.shopTypes = [];
        this.allItems = [];
        this.turnInTrackers = {};
        this.loadedRotations = new Set(); // Track which shops have rotations loaded
        this.initializeEventListeners();
        this.loadInitialData();
    }

    getShopTypeLabel(shopTypeKey) {
        const shopType = this.shopTypes.find(type => type.type_key === shopTypeKey);
        return shopType ? shopType.type_name : shopTypeKey;
    }

    initializeEventListeners() {
        // Tab switching
        document.querySelectorAll('.shop-tab-button').forEach(button => {
            button.addEventListener('click', (e) => this.switchTab(e.target.dataset.tab));
        });

        // Shop form submission
        document.getElementById('add-shop-form').addEventListener('submit', (e) => this.handleAddShop(e));

        // Shop filters
        document.getElementById('shop-type-filter').addEventListener('change', () => this.filterShops());
        document.getElementById('shop-search').addEventListener('input', () => this.filterShops());

        // Shop selection for items management
        document.getElementById('items-shop-selector').addEventListener('change', (e) => this.selectShop(e.target.value));

        // Shop item form submission
        document.getElementById('add-shop-item-form').addEventListener('submit', (e) => this.handleAddShopItem(e));

        // Turn-in form submission
        document.getElementById('record-turn-in-form').addEventListener('submit', (e) => this.handleRecordTurnIn(e));
        
        // Reset turn-in tracker
        document.getElementById('reset-turn-in-tracker').addEventListener('click', () => this.resetTurnInTracker());
        
        // Item autocomplete
        this.setupItemAutocomplete();

        // Shop types form submission
        document.getElementById('add-shop-type-form').addEventListener('submit', (e) => this.handleAddShopType(e));

        // Auto-generate type key from type name
        document.getElementById('type-name').addEventListener('input', (e) => this.generateTypeKey(e.target.value));

        // Cancel edit buttons
        document.getElementById('cancel-edit-shop').addEventListener('click', () => this.cancelShopEdit());
        document.getElementById('cancel-edit-type').addEventListener('click', () => this.cancelShopTypeEdit());
        
        // Handle unlimited stock checkbox
        document.getElementById('unlimited-stock').addEventListener('change', (e) => {
            const stockInput = document.getElementById('stock-quantity');
            if (e.target.checked) {
                stockInput.disabled = true;
                stockInput.value = -1;
            } else {
                stockInput.disabled = false;
                stockInput.value = 0;
            }
        });
    }

    switchTab(tabName) {
        // Update tab buttons
        document.querySelectorAll('.shop-tab-button').forEach(btn => btn.classList.remove('active'));
        document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');

        // Update tab content
        document.querySelectorAll('.shop-tab-content').forEach(content => content.classList.remove('active'));
        document.getElementById(`${tabName}-tab`).classList.add('active');

        // Load data for the active tab
        if (tabName === 'shops') {
            this.loadShops();
        } else if (tabName === 'items') {
            this.loadShopsForSelector();
            this.loadMasterItemList();
        } else if (tabName === 'types') {
            this.loadShopTypesTable();
            // Ensure the form is ready for new type creation
            this.resetShopTypeForm();
        }
    }

    async loadInitialData() {
        await this.loadShopTypes();
        await this.loadShops();
        await this.loadShopsForSelector();
        await this.loadMasterItemList();
    }

    async loadShopTypes() {
        try {
            const response = await JotunAPI.getShopTypes();
            this.shopTypes = response.data || [];
            this.populateShopTypeSelectors();
        } catch (error) {
            console.error('Error loading shop types:', error);
            this.showStatus('Failed to load shop types', 'error');
        }
    }

    populateShopTypeSelectors() {
        // Populate the add/edit form shop type selector
        const shopTypeSelect = document.getElementById('shop-type');
        if (shopTypeSelect) {
            shopTypeSelect.innerHTML = '';
            this.shopTypes.forEach(type => {
                const option = document.createElement('option');
                option.value = type.type_key;
                option.textContent = type.type_name;
                shopTypeSelect.appendChild(option);
            });
        }

        // Populate the filter dropdown
        const filterSelect = document.getElementById('shop-type-filter');
        if (filterSelect) {
            // Keep the "All Shop Types" option
            const allOption = filterSelect.querySelector('option[value=""]');
            filterSelect.innerHTML = '';
            if (allOption) filterSelect.appendChild(allOption);
            
            this.shopTypes.forEach(type => {
                const option = document.createElement('option');
                option.value = type.type_key;
                option.textContent = type.type_name;
                filterSelect.appendChild(option);
            });
        }
    }

    async loadShops() {
        try {
            const response = await JotunAPI.getShops();
            const shops = response.data || [];
            this.renderShopsTable(shops);
        } catch (error) {
            console.error('Error loading shops:', error);
            this.showStatus('Failed to load shops', 'error');
        }
    }

    async loadShopsForSelector() {
        try {
            const response = await JotunAPI.getShops();
            const shops = response.data || [];
            this.populateShopSelector(shops);
        } catch (error) {
            console.error('Error loading shops for selector:', error);
        }
    }

    async loadMasterItemList() {
        try {
            const response = await JotunAPI.getItemlist();
            const items = response.data || [];
            this.allItems = items;
            this.populateItemSelector(items);
        } catch (error) {
            console.error('Error loading item list:', error);
        }
    }

    renderShopsTable(shops) {
        const tbody = document.getElementById('shops-table-body');
        tbody.innerHTML = '';
        this.loadedRotations.clear(); // Clear the set when table is recreated

        shops.forEach(shop => {
            const row = document.createElement('tr');
            const rotationDropdownId = `rotation-${shop.shop_id}`;
            
            row.innerHTML = `
                <td>${this.escapeHtml(shop.shop_name)}</td>
                <td><span class="shop-type-badge ${shop.shop_type}">${this.getShopTypeLabel(shop.shop_type)}</span></td>
                <td>
                    <select id="${rotationDropdownId}" class="rotation-selector" data-shop-id="${shop.shop_id}">
                        <option value="">Loading...</option>
                    </select>
                </td>
                <td><span class="status-badge ${shop.is_active == 1 ? 'active' : 'inactive'}">${shop.is_active == 1 ? 'Active' : 'Inactive'}</span></td>
                <td>${this.formatDate(shop.created_at)}</td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="shopManager.editShop(${shop.shop_id})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="shopManager.deleteShop(${shop.shop_id}, '${this.escapeHtml(shop.shop_name)}')">Delete</button>
                </td>
            `;
            tbody.appendChild(row);
            
            // Load rotations for this shop (only once)
            if (!this.loadedRotations.has(shop.shop_id)) {
                this.loadedRotations.add(shop.shop_id);
                this.loadShopRotations(shop.shop_id, rotationDropdownId);
            }
        });
    }

    setupItemAutocomplete() {
        const searchInput = document.getElementById('item-selector');
        const hiddenSelect = document.getElementById('item-selector-hidden');
        const suggestionsDiv = document.getElementById('item-suggestions');
        let currentSuggestionIndex = -1;
        
        // Show all items when input is focused and empty
        searchInput.addEventListener('focus', (e) => {
            if (e.target.value.trim() === '' && this.allItems.length > 0) {
                this.displaySuggestions(this.allItems.slice(0, 20), suggestionsDiv, searchInput, hiddenSelect);
            }
        });
        
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            
            if (query.length === 0) {
                // Show all items when empty
                this.displaySuggestions(this.allItems.slice(0, 20), suggestionsDiv, searchInput, hiddenSelect);
                hiddenSelect.value = '';
                return;
            }
            
            if (query.length < 1) {
                suggestionsDiv.style.display = 'none';
                hiddenSelect.value = '';
                return;
            }
            
            const filteredItems = this.allItems.filter(item => 
                item.item_name.toLowerCase().includes(query) ||
                (item.prefab_name && item.prefab_name.toLowerCase().includes(query))
            ).slice(0, 20); // Show max 20 suggestions
            
            this.displaySuggestions(filteredItems, suggestionsDiv, searchInput, hiddenSelect);
        });
        
        searchInput.addEventListener('keydown', (e) => {
            const suggestions = suggestionsDiv.querySelectorAll('.suggestion-item');
            
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                currentSuggestionIndex = Math.min(currentSuggestionIndex + 1, suggestions.length - 1);
                this.highlightSuggestion(suggestions, currentSuggestionIndex);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                currentSuggestionIndex = Math.max(currentSuggestionIndex - 1, -1);
                this.highlightSuggestion(suggestions, currentSuggestionIndex);
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (currentSuggestionIndex >= 0 && suggestions[currentSuggestionIndex]) {
                    suggestions[currentSuggestionIndex].click();
                }
            } else if (e.key === 'Escape') {
                suggestionsDiv.style.display = 'none';
                currentSuggestionIndex = -1;
            }
        });
        
        // Hide suggestions when clicking outside
        document.addEventListener('click', (e) => {
            if (!searchInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
                suggestionsDiv.style.display = 'none';
            }
        });
    }
    
    displaySuggestions(items, container, searchInput, hiddenSelect) {
        if (items.length === 0) {
            container.style.display = 'none';
            return;
        }
        
        container.innerHTML = '';
        
        items.forEach(item => {
            const div = document.createElement('div');
            div.className = 'suggestion-item';
            div.innerHTML = `
                <div class="item-name">${item.item_name}</div>
                <div class="item-price">${this.formatPrice(item.unit_price || 0)}</div>
            `;
            
            div.addEventListener('click', () => {
                searchInput.value = item.item_name;
                hiddenSelect.value = item.id;
                container.style.display = 'none';
                
                // Update price placeholder
                const customPriceInput = document.getElementById('custom-price');
                if (customPriceInput) {
                    customPriceInput.placeholder = `Default: ${this.formatPrice(item.unit_price || 0)}`;
                }
            });
            
            container.appendChild(div);
        });
        
        container.style.display = 'block';
    }
    
    highlightSuggestion(suggestions, index) {
        suggestions.forEach((s, i) => {
            s.classList.toggle('highlighted', i === index);
        });
    }
    
    formatPrice(price, currency = 'coins', showBothFormats = true) {
        const numPrice = parseFloat(price) || 0;
        
        // For legacy support - if currency is ymir, convert from ymir to coins display
        if (currency === 'ymir') {
            return `${(numPrice / 120).toFixed(2)} Ymir Flesh`;
        }
        
        // Always show both formats when price is 120+ coins (1+ Ymir)
        if (numPrice >= 120) {
            const ymirWholeAmount = Math.floor(numPrice / 120);
            const remainingCoins = numPrice % 120;
            
            if (remainingCoins === 0) {
                return `${ymirWholeAmount} Ymir`;
            } else {
                return `${ymirWholeAmount} Ymir ${remainingCoins} Coins`;
            }
        }
        
        // For small amounts, just show coins
        return `${numPrice} Coins`;
    }

    populateShopSelector(shops) {
        console.log('populateShopSelector called with shops:', shops);
        const selector = document.getElementById('items-shop-selector');
        if (!selector) {
            console.error('Shop selector element not found');
            return;
        }
        
        selector.innerHTML = '<option value="">Select a shop...</option>';

        shops.forEach(shop => {
            console.log('Processing shop:', shop);
            if (shop.is_active == 1) { // Only show active shops
                const option = document.createElement('option');
                option.value = shop.shop_id;
                option.textContent = `${shop.shop_name} (${this.getShopTypeLabel(shop.shop_type)})`;
                selector.appendChild(option);
                console.log('Added shop option:', option.textContent);
            } else {
                console.log('Skipping inactive shop:', shop.shop_name);
            }
        });
        
        console.log('Shop selector populated with', selector.options.length - 1, 'shops');
    }

    populateItemSelector(items) {
        const hiddenSelector = document.getElementById('item-selector-hidden');
        if (!hiddenSelector) return;
        
        hiddenSelector.innerHTML = '<option value="">Select an item...</option>';

        items.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = `${item.item_name} - ${this.formatPrice(item.unit_price || 0)}`;
            option.dataset.defaultPrice = item.unit_price || '0';
            hiddenSelector.appendChild(option);
        });
    }

    async handleAddShop(e) {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        const shopData = {
            shop_name: formData.get('shop_name'),
            shop_type: formData.get('shop_type'),
            is_active: parseInt(formData.get('is_active') || '1')
        };

        try {
            if (this.currentEditingShop) {
                // Update existing shop
                await JotunAPI.updateShop(this.currentEditingShop, shopData);
                this.showStatus('Shop updated successfully', 'success');
                this.cancelShopEdit();
            } else {
                // Add new shop
                await JotunAPI.addShop(shopData);
                this.showStatus('Shop added successfully', 'success');
            }

            // Reset form and reload data
            e.target.reset();
            await this.loadShops();
            await this.loadShopsForSelector();
        } catch (error) {
            console.error('Error saving shop:', error);
            this.showStatus('Failed to save shop', 'error');
        }
    }

    async editShop(shopId) {
        try {
            const response = await JotunAPI.getShops();
            const shop = response.data && response.data.find(s => s.shop_id == shopId);
            
            if (shop) {
                // Populate form with shop data
                document.getElementById('shop-name').value = shop.shop_name;
                document.getElementById('shop-type').value = shop.shop_type;
                document.getElementById('shop-status').value = shop.is_active || '1';
                
                // Update form state
                this.currentEditingShop = shopId;
                document.querySelector('#add-shop-form button[type="submit"]').textContent = 'Update Shop';
                document.getElementById('cancel-edit-shop').style.display = 'inline-block';
                
                // Scroll to form
                document.getElementById('add-shop-form').scrollIntoView({ behavior: 'smooth' });
            }
        } catch (error) {
            console.error('Error loading shop for edit:', error);
            this.showStatus('Failed to load shop data', 'error');
        }
    }

    cancelShopEdit() {
        this.currentEditingShop = null;
        document.getElementById('add-shop-form').reset();
        document.querySelector('#add-shop-form button[type="submit"]').textContent = 'Add Shop';
        document.getElementById('cancel-edit-shop').style.display = 'none';
    }

    async deleteShop(shopId, shopName) {
        if (confirm(`Are you sure you want to delete "${shopName}"? This will also remove all items from this shop.`)) {
            try {
                await JotunAPI.deleteShop(shopId);
                this.showStatus('Shop deleted successfully', 'success');
                await this.loadShops();
                await this.loadShopsForSelector();
                
                // If this was the selected shop, clear the selection
                if (this.selectedShop == shopId) {
                    this.selectedShop = null;
                    document.getElementById('items-shop-selector').value = '';
                    this.hideShopItemsSection();
                }
            } catch (error) {
                console.error('Error deleting shop:', error);
                this.showStatus('Failed to delete shop', 'error');
            }
        }
    }

    async selectShop(shopId) {
        this.selectedShop = shopId;
        
        if (shopId) {
            // Get shop data to check if it's a Turn-In Only shop
            try {
                const shops = await JotunAPI.getShops();
                this.selectedShopData = shops.data.find(shop => shop.shop_id == shopId);
                
                console.log('DEBUG - Selected shop data:', this.selectedShopData);
                const isTurnInOnly = this.selectedShopData && this.selectedShopData.shop_type === 'turn-in_only';
                console.log('DEBUG - Shop type:', this.selectedShopData?.shop_type, 'isTurnInOnly:', isTurnInOnly);
                
                // Show add item section for all shops
                document.getElementById('add-item-section').style.display = 'block';
                
                // Show/hide fields based on shop type
                this.toggleFieldsForShopType(isTurnInOnly);
                
                // Show/hide appropriate sections
                if (isTurnInOnly) {
                    // For Turn-In Only shops, show BOTH the items grid and turn-in controls
                    document.getElementById('shop-items-table-container').style.display = 'block';
                    document.getElementById('turn-in-controls').style.display = 'block';
                    this.loadTurnInTracker(shopId);
                    await this.loadShopItems(shopId); // Also load items for editing/deleting
                } else {
                    // For regular shops, show only items grid
                    document.getElementById('shop-items-table-container').style.display = 'block';
                    document.getElementById('turn-in-controls').style.display = 'none';
                    await this.loadShopItems(shopId);
                }
                
                document.getElementById('shop-items-list').style.display = 'block';
            } catch (error) {
                console.error('Error getting shop data:', error);
                this.hideShopItemsSection();
            }
        } else {
            this.hideShopItemsSection();
        }
    }

    hideShopItemsSection() {
        document.getElementById('add-item-section').style.display = 'none';
        document.getElementById('shop-items-list').style.display = 'none';
    }

    toggleFieldsForShopType(isTurnInOnly) {
        console.log('DEBUG - toggleFieldsForShopType called with isTurnInOnly:', isTurnInOnly);
        
        // Get form sections - using more reliable selectors
        const priceRow = document.getElementById('custom-price')?.closest('.form-row');
        const stockRow = document.getElementById('stock-quantity')?.closest('.form-row');
        const turnInFields = document.querySelectorAll('.turn-in-fields');
        const turnInRequirementField = document.getElementById('turn-in-requirement');
        const addItemSection = document.getElementById('add-item-section');
        const addItemTitle = addItemSection?.querySelector('h3');
        const submitButton = document.querySelector('#add-shop-item-form button[type="submit"]');
        
        console.log('DEBUG - Found elements:', {
            priceRow: !!priceRow,
            stockRow: !!stockRow,
            turnInFields: turnInFields.length,
            addItemTitle: !!addItemTitle,
            submitButton: !!submitButton
        });
        
        if (isTurnInOnly) {
            console.log('DEBUG - Configuring for Turn-In Only shop');
            // Update the interface for Turn-In Only shops
            if (addItemTitle) {
                addItemTitle.textContent = 'Add Turn-In Event Items';
            }
            if (submitButton) {
                submitButton.textContent = 'Add Turn-In Event';
            }
            
            // Hide price and stock fields for turn-in shops
            if (priceRow) priceRow.style.display = 'none';
            if (stockRow) stockRow.style.display = 'none';
            
            // Show turn-in fields
            turnInFields.forEach(field => field.style.display = 'flex');
            
            // Set min=1 for turn-in requirement when visible
            if (turnInRequirementField) {
                turnInRequirementField.setAttribute('min', '1');
                if (turnInRequirementField.value === '0') {
                    turnInRequirementField.value = '1';
                }
            }
            
            // Ensure item selector row is visible for turn-in shops
            const itemSelectorRow = document.getElementById('item-selector')?.closest('.form-row');
            if (itemSelectorRow) {
                itemSelectorRow.style.display = 'flex';
            }
            
            // Update field labels for turn-in context  
            const itemSelectorLabel = document.querySelector('label[for="item-selector"]');
            if (itemSelectorLabel) {
                itemSelectorLabel.textContent = 'Select Turn-In Item from Master List';
            }
            
            const customItemLabel = document.querySelector('label[for="custom-item-name"]');
            if (customItemLabel) {
                customItemLabel.textContent = 'Custom Turn-In Event Name';
                const customItemInput = document.getElementById('custom-item-name');
                if (customItemInput) {
                    customItemInput.placeholder = 'e.g., "Dragon Egg Collection Event"';
                }
            }
        } else {
            // Regular shop interface
            if (addItemTitle) {
                addItemTitle.textContent = 'Add Items to Shop';
            }
            if (submitButton) {
                submitButton.textContent = 'Add Item to Shop';
            }
            
            // Show price and stock fields for regular shops
            if (priceRow) priceRow.style.display = 'flex';
            if (stockRow) stockRow.style.display = 'flex';
            
            // Hide turn-in fields
            turnInFields.forEach(field => field.style.display = 'none');
            
            // Remove min constraint when hidden to prevent validation errors
            if (turnInRequirementField) {
                turnInRequirementField.setAttribute('min', '0');
                turnInRequirementField.value = '0';
            }
            
            // Restore original field labels
            const itemSelectorLabel = document.querySelector('label[for="item-selector"]');
            if (itemSelectorLabel) {
                itemSelectorLabel.textContent = 'Select Item from Master List';
            }
            
            const customItemLabel = document.querySelector('label[for="custom-item-name"]');
            if (customItemLabel) {
                customItemLabel.textContent = 'Custom Item Name (for Aesir Spells)';
                const customItemInput = document.getElementById('custom-item-name');
                if (customItemInput) {
                    customItemInput.placeholder = 'Enter custom item name for spells/special items';
                }
            }
        }
    }

    async loadTurnInTracker(shopId) {
        try {
            // Load turn-in count for this shop
            const response = await JotunAPI.getTurnInCount(shopId);
            const count = response.data?.total_count || 0;
            document.getElementById('turn-in-count').textContent = count;
        } catch (error) {
            console.error('Error loading turn-in tracker:', error);
            document.getElementById('turn-in-count').textContent = '0';
        }
    }

    async handleRecordTurnIn(e) {
        e.preventDefault();
        
        if (!this.selectedShop) {
            this.showStatus('No shop selected', 'error');
            return;
        }
        
        const formData = new FormData(e.target);
        const turnInData = {
            shop_id: this.selectedShop,
            item_name: formData.get('item_name'),
            quantity: parseInt(formData.get('quantity') || '1'),
            player_name: formData.get('player_name') || null
        };
        
        try {
            await JotunAPI.recordTurnIn(turnInData);
            this.showStatus('Turn-in recorded successfully', 'success');
            e.target.reset();
            // Reload tracker count
            await this.loadTurnInTracker(this.selectedShop);
        } catch (error) {
            console.error('Error recording turn-in:', error);
            this.showStatus('Failed to record turn-in', 'error');
        }
    }

    async resetTurnInTracker() {
        if (!this.selectedShop) {
            this.showStatus('No shop selected', 'error');
            return;
        }
        
        if (!confirm('Are you sure you want to reset the turn-in tracker for this shop? This action cannot be undone.')) {
            return;
        }
        
        try {
            await JotunAPI.resetTurnInTracker(this.selectedShop);
            this.showStatus('Turn-in tracker reset successfully', 'success');
            await this.loadTurnInTracker(this.selectedShop);
        } catch (error) {
            console.error('Error resetting turn-in tracker:', error);
            this.showStatus('Failed to reset turn-in tracker', 'error');
        }
    }

    async loadShopItems(shopId) {
        console.log('loadShopItems called with shopId:', shopId);
        try {
            if (!shopId) {
                console.warn('No shopId provided to loadShopItems');
                this.renderShopItemsTable([]);
                return;
            }
            
            console.log('Making API call to getShopItems with params:', { shop_id: shopId });
            const response = await JotunAPI.getShopItems({ shop_id: shopId });
            console.log('Shop items API response:', response);
            const shopItems = response.data || [];
            console.log('Shop items data:', shopItems);
            this.renderShopItemsTable(shopItems);
        } catch (error) {
            console.error('Error loading shop items:', error);
            this.showStatus('Failed to load shop items: ' + error.message, 'error');
        }
    }

    renderShopItemsTable(shopItems) {
        const tbody = document.getElementById('shop-items-table-body');
        tbody.innerHTML = '';

        shopItems.forEach(item => {
            const row = document.createElement('tr');
            const defaultPrice = item.default_price || 0;
            const shopPrice = item.custom_price || defaultPrice;
            const isCustomItem = item.is_custom_item == 1;
            
            row.innerHTML = `
                <td>
                    ${this.escapeHtml(item.master_item_name || item.item_name)}
                    ${isCustomItem ? '<span class="custom-item-badge">Custom</span>' : ''}
                </td>
                <td>${this.formatPrice(defaultPrice)}</td>
                <td>${this.formatPrice(shopPrice)}</td>
                <td>${item.stock_quantity || 0}</td>
                <td><span class="rotation-badge">${item.rotation || 1}</span></td>
                <td><span class="checkbox-display ${item.sell == 1 ? 'checked' : ''}">${item.sell == 1 ? '✓' : '✗'}</span></td>
                <td><span class="checkbox-display ${item.buy == 1 ? 'checked' : ''}">${item.buy == 1 ? '✓' : '✗'}</span></td>
                <td><span class="checkbox-display ${item.turn_in == 1 ? 'checked' : ''}">${item.turn_in == 1 ? '✓' : '✗'}</span></td>
                <td><span class="status-badge ${item.is_available == 1 ? 'active' : 'inactive'}">${item.is_available == 1 ? 'Yes' : 'No'}</span></td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="shopManager.editShopItem(${item.id})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="shopManager.deleteShopItem(${item.id}, '${this.escapeHtml(item.master_item_name || item.item_name)}')">Remove</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    async handleAddShopItem(e) {
        e.preventDefault();
        
        if (!this.selectedShop) {
            this.showStatus('Please select a shop first', 'error');
            return;
        }

        const formData = new FormData(e.target);
        const itemId = formData.get('item_id');
        const customItemName = formData.get('custom_item_name');
        let customPrice = formData.get('custom_price');
        const rotation = formData.get('rotation') || 1;
        
        // For editing, we don't need to check item selection again
        if (!this.currentEditingShopItem) {
            // Check if we have either an item selection or custom item name for new items
            if (!itemId && !customItemName) {
                this.showStatus('Please select an item or enter a custom item name', 'error');
                return;
            }
        }

        // Price is always in Coins (no conversion needed)
        if (customPrice) {
            customPrice = parseFloat(customPrice);
        }

        const shopItemData = {
            shop_id: this.selectedShop,
            stock_quantity: formData.get('unlimited_stock') === 'on' ? -1 : (formData.get('stock_quantity') || 0),
            rotation: parseInt(rotation),
            is_available: formData.get('is_available') === '1',
            unlimited_stock: formData.get('unlimited_stock') === 'on',
            turn_in_quantity: formData.get('turn_in_quantity') || 0,
            turn_in_requirement: formData.get('turn_in_requirement') || 0,
            // Add checkbox data
            sell: document.getElementById('sell-checkbox')?.checked || false,
            buy: document.getElementById('buy-checkbox')?.checked || false,
            turn_in: document.getElementById('turn-in-checkbox')?.checked || false
        };

        // Handle custom items vs regular items (only for new items, not edits)
        if (!this.currentEditingShopItem) {
            if (customItemName) {
                shopItemData.custom_item_name = customItemName;
                shopItemData.item_id = null; // No item_id for custom items
            } else {
                shopItemData.item_id = itemId;
            }
        }

        if (customPrice && customPrice.toString().trim() !== '') {
            shopItemData.custom_price = parseFloat(customPrice);
        } else {
            shopItemData.custom_price = null; // Clear price if empty
        }

        console.log('DEBUG - Shop item data being sent:', shopItemData);

        try {
            if (this.currentEditingShopItem) {
                // Update existing item
                await JotunAPI.updateShopItem(this.currentEditingShopItem, shopItemData);
                this.showStatus('Item updated successfully', 'success');
                
                // Reset form state and UI after successful update
                this.cancelShopItemEdit();
                
                // Reload shop items to show the updates
                await this.loadShopItems(this.selectedShop);
            } else {
                // Add new item
                await JotunAPI.addShopItem(shopItemData);
                this.showStatus('Item added to shop successfully', 'success');
                
                // Reset form and reload shop items for new additions
                e.target.reset();
                document.getElementById('item-rotation').value = '1'; // Reset rotation to 1
                document.getElementById('item-selector').value = ''; // Clear search field
                document.getElementById('item-selector-hidden').value = ''; // Clear hidden field
                
                // Clear the price placeholder
                const customPriceInput = document.getElementById('custom-price');
                if (customPriceInput) {
                    customPriceInput.placeholder = 'Enter custom price';
                }
                
                // Reset checkboxes to defaults for new items
                const sellCheckbox = document.getElementById('sell-checkbox');
                const buyCheckbox = document.getElementById('buy-checkbox');
                const turnInCheckbox = document.getElementById('turn-in-checkbox');
                
                if (sellCheckbox) sellCheckbox.checked = true; // Default to sellable
                if (buyCheckbox) buyCheckbox.checked = false;  // Default not buyable  
                if (turnInCheckbox) turnInCheckbox.checked = false; // Default not turn-in
                
                await this.loadShopItems(this.selectedShop);
            }
        } catch (error) {
            console.error('Error saving item to shop:', error);
            this.showStatus(this.currentEditingShopItem ? 'Failed to update item' : 'Failed to add item to shop', 'error');
        }
    }

    async deleteShopItem(shopItemId, itemName) {
        if (confirm(`Are you sure you want to remove "${itemName}" from this shop?`)) {
            try {
                await JotunAPI.deleteShopItem(shopItemId);
                this.showStatus('Item removed from shop successfully', 'success');
                await this.loadShopItems(this.selectedShop);
            } catch (error) {
                console.error('Error removing item from shop:', error);
                this.showStatus('Failed to remove item from shop', 'error');
            }
        }
    }

    async editShopItem(shopItemId) {
        try {
            // Get the current shop items and find the one being edited
            const response = await JotunAPI.getShopItems({ shop_id: this.selectedShop });
            const shopItems = response.data || [];
            const item = shopItems.find(item => item.id == shopItemId);
            
            if (!item) {
                this.showStatus('Shop item not found', 'error');
                return;
            }

            // Populate the form with current item data
            this.currentEditingShopItem = shopItemId;
            
            // Clear form first
            document.getElementById('add-shop-item-form').reset();
            
            // If it's a custom item, populate custom item name
            if (item.is_custom_item == 1) {
                document.getElementById('custom-item-name').value = item.item_name || '';
                document.getElementById('item-selector').value = '';
                document.getElementById('item-selector-hidden').value = '';
            } else {
                // For regular items, set the item selector
                if (item.item_id) {
                    document.getElementById('item-selector-hidden').value = item.item_id;
                    document.getElementById('item-selector').value = item.master_item_name || item.item_name || '';
                }
                document.getElementById('custom-item-name').value = '';
            }
            
            // Populate other fields
            document.getElementById('custom-price').value = item.custom_price || '';
            document.getElementById('stock-quantity').value = item.stock_quantity || 0;
            document.getElementById('unlimited-stock').checked = item.unlimited_stock == 1;
            document.getElementById('item-rotation').value = item.rotation || 1;
            document.getElementById('item-available').value = item.is_available || '1';
            
            // Populate checkbox fields if they exist
            const sellCheckbox = document.getElementById('sell-checkbox');
            const buyCheckbox = document.getElementById('buy-checkbox');
            const turnInCheckbox = document.getElementById('turn-in-checkbox');
            
            if (sellCheckbox) sellCheckbox.checked = item.sell == 1;
            if (buyCheckbox) buyCheckbox.checked = item.buy == 1;
            if (turnInCheckbox) turnInCheckbox.checked = item.turn_in == 1;
            
            // Update form button
            const submitButton = document.querySelector('#add-shop-item-form button[type="submit"]');
            submitButton.textContent = 'Update Item';
            
            // Show cancel button
            this.showCancelEditItemButton();
            
            // Scroll to form
            document.getElementById('add-shop-item-form').scrollIntoView({ behavior: 'smooth' });
            
        } catch (error) {
            console.error('Error loading shop item for edit:', error);
            this.showStatus('Failed to load item data', 'error');
        }
    }

    showCancelEditItemButton() {
        // Create cancel button if it doesn't exist
        let cancelButton = document.getElementById('cancel-edit-item');
        if (!cancelButton) {
            cancelButton = document.createElement('button');
            cancelButton.id = 'cancel-edit-item';
            cancelButton.type = 'button';
            cancelButton.className = 'btn btn-secondary';
            cancelButton.textContent = 'Cancel Edit';
            cancelButton.style.display = 'none';
            
            // Add click handler
            cancelButton.addEventListener('click', () => this.cancelShopItemEdit());
            
            // Add after the submit button
            const formActions = document.querySelector('#add-shop-item-form .form-actions');
            if (formActions) {
                formActions.appendChild(cancelButton);
            }
        }
        cancelButton.style.display = 'inline-block';
    }

    cancelShopItemEdit() {
        this.currentEditingShopItem = null;
        
        // Reset the entire form
        const form = document.getElementById('add-shop-item-form');
        form.reset();
        
        // Clear specific fields that might not be handled by reset()
        document.getElementById('item-rotation').value = '1'; // Reset to default
        document.getElementById('item-selector').value = '';
        document.getElementById('item-selector-hidden').value = '';
        document.getElementById('custom-item-name').value = '';
        document.getElementById('custom-price').value = '';
        
        // Clear price placeholder
        const customPriceInput = document.getElementById('custom-price');
        if (customPriceInput) {
            customPriceInput.placeholder = 'Enter custom price';
        }
        
        // Reset unlimited stock checkbox and enable stock input
        const unlimitedCheckbox = document.getElementById('unlimited-stock');
        const stockInput = document.getElementById('stock-quantity');
        if (unlimitedCheckbox) {
            unlimitedCheckbox.checked = false;
        }
        if (stockInput) {
            stockInput.disabled = false;
            stockInput.value = '0';
        }
        
        // Reset checkboxes to their default states
        const sellCheckbox = document.getElementById('sell-checkbox');
        const buyCheckbox = document.getElementById('buy-checkbox');
        const turnInCheckbox = document.getElementById('turn-in-checkbox');
        
        if (sellCheckbox) sellCheckbox.checked = true; // Default to sellable
        if (buyCheckbox) buyCheckbox.checked = false;  // Default not buyable  
        if (turnInCheckbox) turnInCheckbox.checked = false; // Default not turn-in
        
        // Reset form button text and state
        const submitButton = document.querySelector('#add-shop-item-form button[type="submit"]');
        if (submitButton) {
            submitButton.textContent = 'Add Item to Shop';
        }
        
        // Hide cancel button
        const cancelButton = document.getElementById('cancel-edit-item');
        if (cancelButton) {
            cancelButton.style.display = 'none';
        }
        
        // Clear any item suggestions
        const suggestionsDiv = document.getElementById('item-suggestions');
        if (suggestionsDiv) {
            suggestionsDiv.style.display = 'none';
        }
    }

    filterShops() {
        const typeFilter = document.getElementById('shop-type-filter').value;
        const searchTerm = document.getElementById('shop-search').value.toLowerCase();
        const rows = document.querySelectorAll('#shops-table-body tr');

        rows.forEach(row => {
            const shopName = row.cells[0].textContent.toLowerCase();
            const shopType = row.cells[1].textContent.toLowerCase();
            
            const matchesType = !typeFilter || shopType.includes(typeFilter);
            const matchesSearch = !searchTerm || shopName.includes(searchTerm);
            
            row.style.display = matchesType && matchesSearch ? '' : 'none';
        });
    }

    showStatus(message, type) {
        const statusDiv = document.getElementById('shop-manager-status');
        statusDiv.textContent = message;
        statusDiv.className = `status-message ${type}`;
        statusDiv.style.display = 'block';

        setTimeout(() => {
            statusDiv.style.display = 'none';
        }, 3000);
    }

    // ============================================================================
    // SHOP TYPES METHODS
    // ============================================================================

    generateTypeKey(typeName, force = false) {
        // Only auto-generate if not editing an existing type (unless forced)
        if (!force && this.currentEditingShopType) return;
        
        if (!typeName || typeName.trim() === '') {
            document.getElementById('type-key').value = '';
            return;
        }
        
        const typeKey = typeName
            .toLowerCase()
            .trim()
            .replace(/\s+/g, '_')  // Replace spaces with underscores
            .replace(/[^a-z0-9_-]/g, '')  // Remove any characters that aren't letters, numbers, underscores, or dashes
            .replace(/_+/g, '_')  // Replace multiple underscores with single underscore
            .replace(/^_|_$/g, ''); // Remove leading/trailing underscores
            
        // Ensure we have a valid key - fallback to 'custom_type' if empty
        const finalKey = typeKey || 'custom_type';
        document.getElementById('type-key').value = finalKey;
        
        console.log('Generated type key:', finalKey, 'from type name:', typeName);
        return finalKey;
    }

    async loadShopTypesTable() {
        try {
            console.log('Loading shop types table with show_all=true');
            const response = await JotunAPI.getShopTypes({ show_all: 'true' });
            console.log('Shop types response:', response);
            const shopTypes = response.data || [];
            console.log('Shop types data:', shopTypes);
            this.renderShopTypesTable(shopTypes);
        } catch (error) {
            console.error('Error loading shop types for table:', error);
            this.showStatus('Failed to load shop types', 'error');
        }
    }

    renderShopTypesTable(shopTypes) {
        const tbody = document.getElementById('shop-types-table-body');
        if (!tbody) return;

        tbody.innerHTML = '';

        shopTypes.forEach(type => {
            // Parse Discord permissions
            let permissionsDisplay = 'None';
            if (type.default_permissions) {
                try {
                    const permissions = JSON.parse(type.default_permissions);
                    if (permissions && permissions.length > 0) {
                        permissionsDisplay = permissions.join(', ');
                    }
                } catch (e) {
                    console.warn('Could not parse permissions for type:', type.type_name, type.default_permissions);
                }
            }
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${this.escapeHtml(type.type_name)}</td>
                <td>${this.escapeHtml(type.description || '')}</td>
                <td><span class="permissions-list">${this.escapeHtml(permissionsDisplay)}</span></td>
                <td><span class="status-badge ${type.is_active == 1 ? 'active' : 'inactive'}">${type.is_active == 1 ? 'Active' : 'Inactive'}</span></td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="shopManager.editShopType(${type.type_id})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="shopManager.deleteShopType(${type.type_id}, '${this.escapeHtml(type.type_name)}')">Delete</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    async handleAddShopType(e) {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        
        // Collect Discord permissions
        const permissionCheckboxes = document.querySelectorAll('#type-permissions input[type="checkbox"]:checked');
        const defaultPermissions = Array.from(permissionCheckboxes).map(cb => cb.value);
        
        const typeData = {
            type_name: formData.get('type_name'),
            type_key: formData.get('type_key'),
            description: formData.get('description') || '',
            is_active: parseInt(formData.get('is_active') || '1'),
            default_permissions: defaultPermissions
        };

        console.log('Submitting shop type data:', typeData);

        // Ensure we have a type name
        if (!typeData.type_name || typeData.type_name.trim() === '') {
            this.showStatus('Type name is required', 'error');
            return;
        }

        // Ensure we have a type key - generate if missing
        if (!typeData.type_key || typeData.type_key.trim() === '') {
            console.log('Type key is empty, generating from type name:', typeData.type_name);
            typeData.type_key = this.generateTypeKey(typeData.type_name, true); // Force generation
            console.log('Generated type key:', typeData.type_key);
        }

        // Final validation
        if (!typeData.type_key || typeData.type_key.trim() === '') {
            this.showStatus('Failed to generate valid type key', 'error');
            return;
        }

        try {
            if (this.currentEditingShopType) {
                // Update existing shop type
                await JotunAPI.updateShopType(this.currentEditingShopType, typeData);
                this.showStatus('Shop type updated successfully', 'success');
                this.cancelShopTypeEdit();
            } else {
                // Add new shop type
                await JotunAPI.addShopType(typeData);
                this.showStatus('Shop type added successfully', 'success');
                e.target.reset();
                document.getElementById('type-key').value = ''; // Clear hidden field
            }
            
            await this.loadShopTypesTable();
            await this.loadShopTypes(); // Refresh dropdowns
        } catch (error) {
            console.error('Error managing shop type:', error);
            
            // Try to extract the error message from the API response
            let errorMessage = 'Failed to save shop type';
            if (error.message && error.message !== 'HTTP error! status: 409' && error.message !== 'HTTP error! status: 400') {
                errorMessage = error.message;
            } else {
                // For HTTP errors, we need to check if there's a response with error details
                // This might need to be enhanced based on how the API client handles errors
                errorMessage = 'Failed to save shop type. Please check that the shop type name is unique.';
            }
            
            this.showStatus(errorMessage, 'error');
        }
    }

    async editShopType(typeId) {
        try {
            const response = await JotunAPI.getShopTypes({ show_all: 'true' });
            const shopType = response.data.find(type => type.type_id == typeId);
            
            if (shopType) {
                console.log('Editing shop type:', shopType);
                this.currentEditingShopType = typeId;
                
                // Populate form
                document.getElementById('type-name').value = shopType.type_name;
                document.getElementById('type-key').value = shopType.type_key;
                document.getElementById('type-description').value = shopType.description || '';
                document.getElementById('type-status').value = shopType.is_active || '1';
                
                // Handle Discord permissions
                const permissionsContainer = document.getElementById('type-permissions');
                if (permissionsContainer) {
                    // Clear all checkboxes first
                    const checkboxes = permissionsContainer.querySelectorAll('input[type="checkbox"]');
                    checkboxes.forEach(cb => cb.checked = false);
                    
                    // Set permissions from shop type
                    if (shopType.default_permissions) {
                        let permissions = [];
                        try {
                            permissions = JSON.parse(shopType.default_permissions);
                        } catch (e) {
                            console.warn('Could not parse permissions:', shopType.default_permissions);
                            permissions = [];
                        }
                        
                        permissions.forEach(perm => {
                            const checkbox = permissionsContainer.querySelector(`input[value="${perm}"]`);
                            if (checkbox) {
                                checkbox.checked = true;
                            }
                        });
                    }
                }
                
                // Update form UI
                document.querySelector('#add-shop-type-form button[type="submit"]').textContent = 'Update Shop Type';
                document.getElementById('cancel-edit-type').style.display = 'inline-block';
            }
        } catch (error) {
            console.error('Error loading shop type for edit:', error);
            this.showStatus('Failed to load shop type', 'error');
        }
    }

    cancelShopTypeEdit() {
        this.currentEditingShopType = null;
        this.resetShopTypeForm();
        document.querySelector('#add-shop-type-form button[type="submit"]').textContent = 'Add Shop Type';
        document.getElementById('cancel-edit-type').style.display = 'none';
    }

    resetShopTypeForm() {
        document.getElementById('add-shop-type-form').reset();
        document.getElementById('type-key').value = '';
        this.currentEditingShopType = null;
        
        // Clear Discord permissions checkboxes
        const permissionCheckboxes = document.querySelectorAll('#type-permissions input[type="checkbox"]');
        permissionCheckboxes.forEach(cb => cb.checked = false);
        
        // Trigger type key generation if there's already text in the name field
        const typeNameField = document.getElementById('type-name');
        if (typeNameField && typeNameField.value.trim()) {
            this.generateTypeKey(typeNameField.value);
        }
    }

    async deleteShopType(typeId, typeName) {
        if (!confirm(`Are you sure you want to delete the shop type "${typeName}"? This action cannot be undone.`)) {
            return;
        }

        try {
            await JotunAPI.deleteShopType(typeId);
            this.showStatus('Shop type deleted successfully', 'success');
            await this.loadShopTypesTable();
            await this.loadShopTypes(); // Refresh dropdowns
        } catch (error) {
            console.error('Error deleting shop type:', error);
            this.showStatus('Failed to delete shop type', 'error');
        }
    }

    async loadShopRotations(shopId, dropdownId) {
        try {
            const response = await JotunAPI.getShopRotations(shopId);
            const rotations = response.rotations || [];
            const currentRotation = response.current_rotation || 1;
            
            const dropdown = document.getElementById(dropdownId);
            if (!dropdown) return;
            
            dropdown.innerHTML = '';
            
            if (rotations.length === 0) {
                dropdown.innerHTML = '<option value="">No items</option>';
                dropdown.disabled = true;
                return;
            }
            
            rotations.forEach(rotation => {
                const option = document.createElement('option');
                option.value = rotation.rotation;
                option.textContent = `Rotation ${rotation.rotation} (${rotation.item_count} items)`;
                option.selected = rotation.rotation == currentRotation;
                dropdown.appendChild(option);
            });
            
            dropdown.disabled = false;
            
            // Add change event listener
            dropdown.addEventListener('change', async (e) => {
                const newRotation = parseInt(e.target.value);
                if (newRotation && newRotation !== currentRotation) {
                    await this.updateShopRotation(shopId, newRotation);
                }
            });
            
        } catch (error) {
            console.error(`Error loading rotations for shop ${shopId}:`, error);
            const dropdown = document.getElementById(dropdownId);
            if (dropdown) {
                dropdown.innerHTML = '<option value="">Error loading</option>';
                dropdown.disabled = true;
            }
        }
    }

    async updateShopRotation(shopId, rotation) {
        try {
            await JotunAPI.updateShopRotation(shopId, rotation);
            this.showStatus(`Shop rotation updated to ${rotation}`, 'success');
        } catch (error) {
            console.error('Error updating shop rotation:', error);
            this.showStatus('Failed to update shop rotation', 'error');
            // Reload the shops table to reset the dropdown
            this.loadShops();
        }
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    formatDate(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        return date.toLocaleDateString();
    }
}

// Initialize shop manager when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('shop-manager-interface')) {
        window.shopManager = new ShopManager();
    }
});

// Add some additional CSS for badges
const additionalCSS = `
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

    .status-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
    }

    .status-badge.active {
        background: #e8f5e8;
        color: #2e7d32;
    }

    .status-badge.inactive {
        background: #ffebee;
        color: #c62828;
    }

    .rotation-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
        background: #fff3e0;
        color: #f57c00;
        border: 1px solid #ffcc02;
    }

    .rotation-selector {
        padding: 4px 8px;
        border-radius: 4px;
        border: 1px solid #ddd;
        font-size: 12px;
        background: white;
        min-width: 120px;
    }

    .rotation-selector:disabled {
        background: #f5f5f5;
        color: #999;
    }
`;

// Inject the additional CSS
const style = document.createElement('style');
style.textContent = additionalCSS;
document.head.appendChild(style);