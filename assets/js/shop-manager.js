/**
 * Shop Manager JavaScript
 * Handles shop creation, editing, and item management
 */

class ShopManager {
    constructor() {
        this.currentEditingShop = null;
        this.currentEditingShopType = null;
        this.selectedShop = null;
        this.shopTypes = [];
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

        // Shop types form submission
        document.getElementById('add-shop-type-form').addEventListener('submit', (e) => this.handleAddShopType(e));

        // Auto-generate type key from type name
        document.getElementById('type-name').addEventListener('input', (e) => this.generateTypeKey(e.target.value));

        // Cancel edit buttons
        document.getElementById('cancel-edit-shop').addEventListener('click', () => this.cancelShopEdit());
        document.getElementById('cancel-edit-type').addEventListener('click', () => this.cancelShopTypeEdit());
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

    populateShopSelector(shops) {
        const selector = document.getElementById('items-shop-selector');
        selector.innerHTML = '<option value="">Select a shop...</option>';

        shops.forEach(shop => {
            if (shop.is_active == 1) { // Only show active shops
                const option = document.createElement('option');
                option.value = shop.shop_id;
                option.textContent = `${shop.shop_name} (${this.getShopTypeLabel(shop.shop_type)})`;
                selector.appendChild(option);
            }
        });
    }

    populateItemSelector(items) {
        const selector = document.getElementById('item-selector');
        selector.innerHTML = '<option value="">Select an item...</option>';

        items.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = `${item.item_name} - $${item.price || '0.00'}`;
            option.dataset.defaultPrice = item.price || '0.00';
            selector.appendChild(option);
        });

        // Update custom price when item is selected
        selector.addEventListener('change', (e) => {
            const selectedOption = e.target.selectedOptions[0];
            const customPriceInput = document.getElementById('custom-price');
            if (selectedOption && selectedOption.dataset.defaultPrice) {
                customPriceInput.placeholder = `Default: $${selectedOption.dataset.defaultPrice}`;
            } else {
                customPriceInput.placeholder = 'Leave empty for default price';
            }
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
            document.getElementById('add-item-section').style.display = 'block';
            document.getElementById('shop-items-list').style.display = 'block';
            await this.loadShopItems(shopId);
        } else {
            this.hideShopItemsSection();
        }
    }

    hideShopItemsSection() {
        document.getElementById('add-item-section').style.display = 'none';
        document.getElementById('shop-items-list').style.display = 'none';
    }

    async loadShopItems(shopId) {
        try {
            const response = await JotunAPI.getShopItems({ shop_id: shopId });
            const shopItems = response.data || [];
            this.renderShopItemsTable(shopItems);
        } catch (error) {
            console.error('Error loading shop items:', error);
            this.showStatus('Failed to load shop items', 'error');
        }
    }

    renderShopItemsTable(shopItems) {
        const tbody = document.getElementById('shop-items-table-body');
        tbody.innerHTML = '';

        shopItems.forEach(item => {
            const row = document.createElement('tr');
            const defaultPrice = item.default_price || 0;
            const shopPrice = item.custom_price || defaultPrice;
            
            row.innerHTML = `
                <td>${this.escapeHtml(item.master_item_name || item.item_name)}</td>
                <td>$${defaultPrice.toFixed(2)}</td>
                <td>$${shopPrice.toFixed(2)}</td>
                <td>${item.stock_quantity || 0}</td>
                <td><span class="rotation-badge">${item.rotation || 1}</span></td>
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
        const customPrice = formData.get('custom_price');
        const rotation = formData.get('rotation') || 1;
        
        if (!itemId) {
            this.showStatus('Please select an item', 'error');
            return;
        }

        const shopItemData = {
            shop_id: this.selectedShop,
            item_id: itemId,
            stock_quantity: formData.get('stock_quantity') || 0,
            rotation: parseInt(rotation),
            is_available: formData.get('is_available') === '1'
        };

        if (customPrice && customPrice.trim() !== '') {
            shopItemData.custom_price = parseFloat(customPrice);
        }

        console.log('DEBUG - Shop item data being sent:', shopItemData);

        try {
            await JotunAPI.addShopItem(shopItemData);
            this.showStatus('Item added to shop successfully', 'success');
            
            // Reset form and reload shop items
            e.target.reset();
            document.getElementById('item-rotation').value = '1'; // Reset rotation to 1
            await this.loadShopItems(this.selectedShop);
        } catch (error) {
            console.error('Error adding item to shop:', error);
            this.showStatus('Failed to add item to shop', 'error');
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
            const response = await JotunAPI.getShopTypes({ show_all: 'true' });
            const shopTypes = response.data || [];
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
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${this.escapeHtml(type.type_name)}</td>
                <td>${this.escapeHtml(type.description || '')}</td>
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
        const typeData = {
            type_name: formData.get('type_name'),
            type_key: formData.get('type_key'),
            description: formData.get('description') || '',
            is_active: parseInt(formData.get('is_active') || '1')
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
            const response = await JotunAPI.getShopTypes();
            const shopType = response.data.find(type => type.type_id == typeId);
            
            if (shopType) {
                this.currentEditingShopType = typeId;
                
                // Populate form
                document.getElementById('type-name').value = shopType.type_name;
                document.getElementById('type-key').value = shopType.type_key;
                document.getElementById('type-description').value = shopType.description || '';
                document.getElementById('type-status').value = shopType.is_active || '1';
                
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