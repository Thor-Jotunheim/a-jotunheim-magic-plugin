// Dashboard REST API Client
class JotunheimDashboardAPI {
    constructor() {
        this.baseURL = wpApiSettings.root + 'jotunheim/v1/dashboard';
        this.nonce = wpApiSettings.nonce;
    }

    async makeRequest(endpoint, method = 'GET', data = null) {
        const url = this.baseURL + endpoint;
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

        try {
            const response = await fetch(url, config);
            const result = await response.json();
            
            console.log(`API ${method} ${endpoint}:`, result);
            
            if (!response.ok) {
                throw new Error(result.error || 'API request failed');
            }
            
            return result;
        } catch (error) {
            console.error(`API Error ${method} ${endpoint}:`, error);
            throw error;
        }
    }

    async getConfig() {
        return this.makeRequest('/config');
    }

    async saveConfig(configData) {
        return this.makeRequest('/config', 'POST', configData);
    }

    async updateQuickAction(itemId, quickAction) {
        return this.makeRequest('/quick-action', 'POST', {
            item_id: itemId,
            quick_action: quickAction
        });
    }

    async getMenuItems() {
        return this.makeRequest('/menu-items');
    }

    async getDebugInfo() {
        return this.makeRequest('/debug');
    }
}

// Dashboard Configuration Manager
class DashboardConfigManager {
    constructor() {
        this.api = new JotunheimDashboardAPI();
        this.currentConfig = null;
        this.menuItems = null;
        this.init();
    }

    async init() {
        try {
            console.log('Initializing Dashboard Config Manager...');
            
            // Load menu items first
            await this.loadMenuItems();
            
            // Load current configuration
            await this.loadConfig();
            
            // Setup event listeners
            this.setupEventListeners();
            
            console.log('Dashboard Config Manager initialized successfully');
        } catch (error) {
            console.error('Failed to initialize Dashboard Config Manager:', error);
            this.showNotification('Failed to load dashboard configuration', 'error');
        }
    }

    async loadMenuItems() {
        try {
            const response = await this.api.getMenuItems();
            this.menuItems = response.data;
            console.log('Menu items loaded:', this.menuItems);
        } catch (error) {
            console.error('Failed to load menu items:', error);
            throw error;
        }
    }

    async loadConfig() {
        try {
            const response = await this.api.getConfig();
            this.currentConfig = response.data;
            this.updateUI();
            console.log('Configuration loaded:', this.currentConfig);
        } catch (error) {
            console.error('Failed to load configuration:', error);
            throw error;
        }
    }

    setupEventListeners() {
        // Quick Action toggles
        document.addEventListener('change', async (e) => {
            if (e.target.classList.contains('quick-action-toggle')) {
                await this.handleQuickActionToggle(e);
            }
        });

        // Save button
        const saveButton = document.getElementById('save-config');
        if (saveButton) {
            saveButton.addEventListener('click', (e) => {
                e.preventDefault();
                this.saveConfiguration();
            });
        }

        // Debug button
        const debugButton = document.getElementById('debug-info');
        if (debugButton) {
            debugButton.addEventListener('click', (e) => {
                e.preventDefault();
                this.showDebugInfo();
            });
        }
    }

    async handleQuickActionToggle(event) {
        const checkbox = event.target;
        const itemId = checkbox.dataset.itemId;
        const quickAction = checkbox.checked;

        try {
            // Show loading state
            checkbox.disabled = true;
            this.showNotification(`Updating ${itemId}...`, 'info');

            // Make API call
            const response = await this.api.updateQuickAction(itemId, quickAction);
            
            if (response.success) {
                this.showNotification(`Successfully updated ${itemId}`, 'success');
                console.log('Quick action updated:', response.data);
            } else {
                throw new Error(response.error || 'Failed to update quick action');
            }
        } catch (error) {
            console.error('Quick action toggle failed:', error);
            
            // Revert checkbox state
            checkbox.checked = !quickAction;
            
            this.showNotification(`Failed to update ${itemId}: ${error.message}`, 'error');
        } finally {
            checkbox.disabled = false;
        }
    }

    async saveConfiguration() {
        try {
            const saveButton = document.getElementById('save-config');
            if (saveButton) {
                saveButton.disabled = true;
                saveButton.textContent = 'Saving...';
            }

            this.showNotification('Saving configuration...', 'info');

            // Collect form data
            const configData = this.collectFormData();
            console.log('Saving configuration:', configData);

            // Make API call
            const response = await this.api.saveConfig(configData);
            
            if (response.success) {
                this.showNotification('Configuration saved successfully!', 'success');
                this.currentConfig = response.data;
                console.log('Configuration saved:', response.data);
            } else {
                throw new Error(response.error || 'Failed to save configuration');
            }
        } catch (error) {
            console.error('Save configuration failed:', error);
            this.showNotification(`Failed to save: ${error.message}`, 'error');
        } finally {
            const saveButton = document.getElementById('save-config');
            if (saveButton) {
                saveButton.disabled = false;
                saveButton.textContent = 'Save Configuration';
            }
        }
    }

    collectFormData() {
        // This will depend on your form structure
        // For now, return current config as placeholder
        return this.currentConfig || {};
    }

    updateUI() {
        // Update quick action checkboxes based on current config
        if (this.menuItems) {
            this.menuItems.forEach(item => {
                const checkbox = document.querySelector(`[data-item-id="${item.id}"]`);
                if (checkbox) {
                    checkbox.checked = item.quick_action || false;
                }
            });
        }
    }

    async showDebugInfo() {
        try {
            const response = await this.api.getDebugInfo();
            console.log('Debug info:', response.data);
            
            const debugInfo = JSON.stringify(response.data, null, 2);
            alert('Debug info logged to console. Check browser console for details.\n\n' + debugInfo);
        } catch (error) {
            console.error('Failed to get debug info:', error);
            this.showNotification('Failed to get debug info', 'error');
        }
    }

    showNotification(message, type = 'info') {
        console.log(`[${type.toUpperCase()}] ${message}`);
        
        // Create or update notification element
        let notification = document.getElementById('dashboard-notification');
        if (!notification) {
            notification = document.createElement('div');
            notification.id = 'dashboard-notification';
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 12px 20px;
                border-radius: 4px;
                z-index: 10000;
                max-width: 300px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            `;
            document.body.appendChild(notification);
        }

        // Set message and style based on type
        notification.textContent = message;
        
        const colors = {
            success: { bg: '#d4edda', border: '#c3e6cb', text: '#155724' },
            error: { bg: '#f8d7da', border: '#f5c6cb', text: '#721c24' },
            info: { bg: '#d1ecf1', border: '#bee5eb', text: '#0c5460' }
        };
        
        const color = colors[type] || colors.info;
        notification.style.backgroundColor = color.bg;
        notification.style.borderLeft = `4px solid ${color.border}`;
        notification.style.color = color.text;

        // Auto-hide after 5 seconds
        clearTimeout(notification.timeoutId);
        notification.timeoutId = setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 5000);
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    if (typeof wpApiSettings !== 'undefined') {
        window.dashboardManager = new DashboardConfigManager();
    } else {
        console.error('WordPress REST API settings not available');
    }
});