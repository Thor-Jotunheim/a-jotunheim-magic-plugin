/**
 * Shop Manager JavaScript
 * Handles shop creation, editing, and item management
 */

class ShopManager {
    constructor() {
        this.currentEditingShop = null;
        this.selectedShop = null;
        this.initializeEventListeners();
        this.loadInitialData();
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

        // Cancel edit button
        document.getElementById('cancel-edit-shop').addEventListener('click', () => this.cancelShopEdit());
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
        }
    }

    async loadInitialData() {
        await this.loadShops();
        await this.loadShopsForSelector();
        await this.loadMasterItemList();
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

        shops.forEach(shop => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${this.escapeHtml(shop.shop_name)}</td>
                <td><span class="shop-type-badge ${shop.shop_type}">${shop.shop_type}</span></td>
                <td><span class="status-badge ${shop.is_active == 1 ? 'active' : 'inactive'}">${shop.is_active == 1 ? 'Active' : 'Inactive'}</span></td>
                <td>${this.formatDate(shop.created_date)}</td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="shopManager.editShop(${shop.id})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="shopManager.deleteShop(${shop.id}, '${this.escapeHtml(shop.shop_name)}')">Delete</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    populateShopSelector(shops) {
        const selector = document.getElementById('items-shop-selector');
        selector.innerHTML = '<option value="">Select a shop...</option>';

        shops.forEach(shop => {
            if (shop.is_active == 1) { // Only show active shops
                const option = document.createElement('option');
                option.value = shop.id;
                option.textContent = `${shop.shop_name} (${shop.shop_type})`;
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
            is_active: true
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
            const response = await JotunAPI.getShops({ id: shopId });
            const shop = response.data && response.data[0];
            
            if (shop) {
                // Populate form with shop data
                document.getElementById('shop-name').value = shop.shop_name;
                document.getElementById('shop-type').value = shop.shop_type;
                
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
            row.innerHTML = `
                <td>${this.escapeHtml(item.item_name)}</td>
                <td>$${item.default_price || '0.00'}</td>
                <td>$${item.price || item.default_price || '0.00'}</td>
                <td>${item.stock_quantity || 0}</td>
                <td><span class="status-badge ${item.is_available == 1 ? 'active' : 'inactive'}">${item.is_available == 1 ? 'Yes' : 'No'}</span></td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="shopManager.editShopItem(${item.id})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="shopManager.deleteShopItem(${item.id}, '${this.escapeHtml(item.item_name)}')">Remove</button>
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
        
        if (!itemId) {
            this.showStatus('Please select an item', 'error');
            return;
        }

        const shopItemData = {
            shop_id: this.selectedShop,
            item_id: itemId,
            stock_quantity: formData.get('stock_quantity') || 0,
            is_available: formData.get('is_available') === '1'
        };

        if (customPrice && customPrice.trim() !== '') {
            shopItemData.price = parseFloat(customPrice);
        }

        try {
            await JotunAPI.addShopItem(shopItemData);
            this.showStatus('Item added to shop successfully', 'success');
            
            // Reset form and reload shop items
            e.target.reset();
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
`;

// Inject the additional CSS
const style = document.createElement('style');
style.textContent = additionalCSS;
document.head.appendChild(style);