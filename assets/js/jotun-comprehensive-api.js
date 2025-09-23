/**
 * Jotunheim Comprehensive API JavaScript Client
 * Provides easy-to-use functions for interacting with all database tables
 */

class JotunheimAPI {
    constructor() {
        this.baseUrl = '/wp-json/jotun-api/v1';
        this.nonce = jotun_api_vars?.nonce || '';
    }

    /**
     * Generic API request method
     */
    async request(endpoint, method = 'GET', data = null) {
        const url = this.baseUrl + endpoint;
        console.log('Making API request:', method, url, data);
        
        const config = {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': this.nonce
            }
        };

        if (data && (method === 'POST' || method === 'PUT')) {
            config.body = JSON.stringify(data);
        }

        console.log('Request config:', config);

        try {
            console.log('Sending fetch request...');
            const response = await fetch(url, config);
            console.log('Response received:', response.status, response.statusText);
            
            const result = await response.json();
            console.log('Response data:', result);
            
            if (!response.ok) {
                throw new Error(result.message || `HTTP error! status: ${response.status}`);
            }
            
            return result;
        } catch (error) {
            console.error('API Request failed:', error);
            throw error;
        }
    }

    // ============================================================================
    // PLAYER LIST API METHODS (jotun_playerlist)
    // ============================================================================

    async getPlayers(params = {}) {
        const queryString = new URLSearchParams(params).toString();
        return this.request(`/playerlist${queryString ? '?' + queryString : ''}`);
    }

    async addPlayer(playerData) {
        return this.request('/playerlist', 'POST', playerData);
    }

    async updatePlayer(id, playerData) {
        return this.request(`/playerlist/${id}`, 'PUT', playerData);
    }

    async deletePlayer(id) {
        return this.request(`/playerlist/${id}`, 'DELETE');
    }

    async getPlayer(id) {
        return this.request(`/playerlist/${id}`);
    }

    async renamePlayer(id, renameData) {
        return this.request(`/playerlist/${id}/rename`, 'POST', renameData);
    }

    // ============================================================================
    // PREFAB LIST API METHODS (jotun_prefablist)
    // ============================================================================

    async getPrefabs(params = {}) {
        const queryString = new URLSearchParams(params).toString();
        return this.request(`/prefablist${queryString ? '?' + queryString : ''}`);
    }

    async addPrefab(prefabData) {
        return this.request('/prefablist', 'POST', prefabData);
    }

    async updatePrefab(id, prefabData) {
        return this.request(`/prefablist/${id}`, 'PUT', prefabData);
    }

    async deletePrefab(id) {
        return this.request(`/prefablist/${id}`, 'DELETE');
    }

    // ============================================================================
    // PREFAB CATEGORY API METHODS (jotun_prefab_category)
    // ============================================================================

    async getPrefabCategories() {
        return this.request('/prefab-categories');
    }

    async addPrefabCategory(categoryData) {
        return this.request('/prefab-categories', 'POST', categoryData);
    }

    async updatePrefabCategory(id, categoryData) {
        return this.request(`/prefab-categories/${id}`, 'PUT', categoryData);
    }

    async deletePrefabCategory(id) {
        return this.request(`/prefab-categories/${id}`, 'DELETE');
    }

    // ============================================================================
    // PREFAB STATUS API METHODS (jotun_prefab_status)
    // ============================================================================

    async getPrefabStatus(params = {}) {
        const queryString = new URLSearchParams(params).toString();
        return this.request(`/prefab-status${queryString ? '?' + queryString : ''}`);
    }

    async addPrefabStatus(statusData) {
        return this.request('/prefab-status', 'POST', statusData);
    }

    async updatePrefabStatus(id, statusData) {
        return this.request(`/prefab-status/${id}`, 'PUT', statusData);
    }

    async deletePrefabStatus(id) {
        return this.request(`/prefab-status/${id}`, 'DELETE');
    }

    // ============================================================================
    // SHOPS API METHODS (jotun_shops)
    // ============================================================================

    async getShops(params = {}) {
        const queryString = new URLSearchParams(params).toString();
        return this.request(`/shops${queryString ? '?' + queryString : ''}`);
    }

    async addShop(shopData) {
        return this.request('/shops', 'POST', shopData);
    }

    async updateShop(id, shopData) {
        return this.request(`/shops/${id}`, 'PUT', shopData);
    }

    async deleteShop(id) {
        return this.request(`/shops/${id}`, 'DELETE');
    }

    // ============================================================================
    // SHOP TYPES API METHODS (jotun_shop_types)
    // ============================================================================

    async getShopTypes(params = {}) {
        const queryString = new URLSearchParams(params).toString();
        return this.request(`/shop-types${queryString ? '?' + queryString : ''}`);
    }

    async addShopType(typeData) {
        return this.request('/shop-types', 'POST', typeData);
    }

    async updateShopType(id, typeData) {
        return this.request(`/shop-types/${id}`, 'PUT', typeData);
    }

    async deleteShopType(id) {
        return this.request(`/shop-types/${id}`, 'DELETE');
    }

    // ============================================================================
    // SHOP ITEMS API METHODS (jotun_shop_items)
    // ============================================================================

    async getShopItems(params = {}) {
        const queryString = new URLSearchParams(params).toString();
        return this.request(`/shop-items${queryString ? '?' + queryString : ''}`);
    }

    async addShopItem(itemData) {
        return this.request('/shop-items', 'POST', itemData);
    }

    async updateShopItem(id, itemData) {
        return this.request(`/shop-items/${id}`, 'PUT', itemData);
    }

    async deleteShopItem(id) {
        return this.request(`/shop-items/${id}`, 'DELETE');
    }

    // ============================================================================
    // SHOP ROTATION API METHODS
    // ============================================================================

    async getShopRotations(shopId) {
        return this.request(`/shops/${shopId}/rotations`);
    }

    async updateShopRotation(shopId, rotation) {
        return this.request(`/shops/${shopId}/current-rotation`, 'PUT', { rotation });
    }

    // ============================================================================
    // TRANSACTIONS API METHODS (jotun_transactions)
    // ============================================================================

    async getTransactions(params = {}) {
        const queryString = new URLSearchParams(params).toString();
        return this.request(`/transactions${queryString ? '?' + queryString : ''}`);
    }

    async addTransaction(transactionData) {
        return this.request('/transactions', 'POST', transactionData);
    }

    async updateTransaction(id, transactionData) {
        return this.request(`/transactions/${id}`, 'PUT', transactionData);
    }

    async deleteTransaction(id) {
        return this.request(`/transactions/${id}`, 'DELETE');
    }

    // ============================================================================
    // ITEM LIST API METHODS (jotun_itemlist)
    // ============================================================================

    async getItems(params = {}) {
        const queryString = new URLSearchParams(params).toString();
        return this.request(`/itemlist${queryString ? '?' + queryString : ''}`);
    }

    async addItem(itemData) {
        return this.request('/itemlist', 'POST', itemData);
    }

    async updateItem(id, itemData) {
        return this.request(`/itemlist/${id}`, 'PUT', itemData);
    }

    async deleteItem(id) {
        return this.request(`/itemlist/${id}`, 'DELETE');
    }

    // Alias for backward compatibility
    async getItemlist(params = {}) {
        return this.getItems(params);
    }

    // ============================================================================
    // LEDGER API METHODS (jotun_ledger)
    // ============================================================================

    async getLedger(params = {}) {
        const queryString = new URLSearchParams(params).toString();
        return this.request(`/ledger${queryString ? '?' + queryString : ''}`);
    }

    async addLedgerEntry(entryData) {
        return this.request('/ledger', 'POST', entryData);
    }

    async updateLedgerEntry(id, entryData) {
        return this.request(`/ledger/${id}`, 'PUT', entryData);
    }

    async deleteLedgerEntry(id) {
        return this.request(`/ledger/${id}`, 'DELETE');
    }

    // ============================================================================
    // UTILITY METHODS
    // ============================================================================

    /**
     * Display a notification message
     */
    showNotification(message, type = 'success') {
        // Create notification element if it doesn't exist
        let notificationContainer = document.getElementById('jotun-notifications');
        if (!notificationContainer) {
            notificationContainer = document.createElement('div');
            notificationContainer.id = 'jotun-notifications';
            notificationContainer.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 10000;
                max-width: 300px;
            `;
            document.body.appendChild(notificationContainer);
        }

        // Create notification
        const notification = document.createElement('div');
        notification.style.cssText = `
            padding: 12px 16px;
            margin-bottom: 10px;
            border-radius: 4px;
            color: white;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transform: translateX(100%);
            transition: transform 0.3s ease;
            background-color: ${type === 'error' ? '#d32f2f' : '#2e7d32'};
        `;
        notification.textContent = message;

        notificationContainer.appendChild(notification);

        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 10);

        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 5000);
    }

    /**
     * Handle API errors with user-friendly messages
     */
    handleError(error, context = 'Operation') {
        console.error(`${context} failed:`, error);
        this.showNotification(`${context} failed: ${error.message}`, 'error');
    }

    /**
     * Handle API success with user-friendly messages
     */
    handleSuccess(message, data = null) {
        console.log('Operation successful:', message, data);
        this.showNotification(message, 'success');
    }
}

// Create global instance
window.JotunAPI = new JotunheimAPI();

// ============================================================================
// CONVENIENCE FUNCTIONS FOR COMMON OPERATIONS
// ============================================================================

/**
 * Player management convenience functions
 */
window.PlayerManager = {
    async searchPlayers(searchTerm) {
        try {
            const result = await JotunAPI.getPlayers({ search: searchTerm, limit: 50 });
            return result.data || [];
        } catch (error) {
            JotunAPI.handleError(error, 'Player search');
            return [];
        }
    },

    async registerPlayer(playerName, additionalData = {}) {
        try {
            const playerData = {
                player_name: playerName,
                ...additionalData
            };
            const result = await JotunAPI.addPlayer(playerData);
            JotunAPI.handleSuccess(`Player "${playerName}" registered successfully`);
            return result;
        } catch (error) {
            JotunAPI.handleError(error, 'Player registration');
            throw error;
        }
    }
};

/**
 * Shop management convenience functions
 */
window.ShopManager = {
    async getPlayerShops() {
        try {
            const result = await JotunAPI.getShops({ type: 'player' });
            return result.data || [];
        } catch (error) {
            JotunAPI.handleError(error, 'Loading player shops');
            return [];
        }
    },

    async getStaffShops() {
        try {
            const result = await JotunAPI.getShops({ type: 'staff' });
            return result.data || [];
        } catch (error) {
            JotunAPI.handleError(error, 'Loading staff shops');
            return [];
        }
    },

    async getShopInventory(shopId) {
        try {
            const result = await JotunAPI.getShopItems({ shop_id: shopId });
            return result.data || [];
        } catch (error) {
            JotunAPI.handleError(error, 'Loading shop inventory');
            return [];
        }
    }
};

/**
 * Transaction management convenience functions
 */
window.TransactionManager = {
    async recordSale(shopName, itemName, quantity, totalAmount, customerName, transactionType = 'general') {
        try {
            const transactionData = {
                shop_name: shopName,
                item_name: itemName,
                quantity: quantity,
                total_amount: totalAmount,
                customer_name: customerName,
                transaction_type: transactionType
            };
            const result = await JotunAPI.addTransaction(transactionData);
            JotunAPI.handleSuccess(`Sale recorded: ${quantity}x ${itemName} to ${customerName}`);
            return result;
        } catch (error) {
            JotunAPI.handleError(error, 'Recording sale');
            throw error;
        }
    },

    async getRecentTransactions(shopName = null, limit = 50) {
        try {
            const params = { limit };
            if (shopName) {
                params.shop_name = shopName;
            }
            const result = await JotunAPI.getTransactions(params);
            return result.data || [];
        } catch (error) {
            JotunAPI.handleError(error, 'Loading transactions');
            return [];
        }
    }
};

/**
 * Item management convenience functions
 */
window.ItemManager = {
    async searchItems(searchTerm, category = null) {
        try {
            const params = { search: searchTerm, limit: 100 };
            if (category) {
                params.category = category;
            }
            const result = await JotunAPI.getItems(params);
            return result.data || [];
        } catch (error) {
            JotunAPI.handleError(error, 'Item search');
            return [];
        }
    },

    async getItemPrice(itemName) {
        try {
            const items = await this.searchItems(itemName);
            const item = items.find(i => i.item_name.toLowerCase() === itemName.toLowerCase());
            return item ? item.cost : null;
        } catch (error) {
            JotunAPI.handleError(error, 'Getting item price');
            return null;
        }
    }
};

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('Jotunheim Comprehensive API loaded');
    
    // Create global instance of the API
    window.JotunAPI = new JotunheimAPI();
    
    // Set up global error handling for unhandled promise rejections
    window.addEventListener('unhandledrejection', function(event) {
        console.error('Unhandled promise rejection:', event.reason);
        if (window.JotunAPI) {
            JotunAPI.showNotification('An unexpected error occurred', 'error');
        }
    });
});