// Simple Dashboard REST API Client
class JotunheimDashboardAPI {
    constructor() {
        // Use the dashboardConfig from our localization
        this.baseURL = dashboardConfig.restUrl;
        this.nonce = dashboardConfig.nonce;
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

    async getMenuItems() {
        return this.makeRequest('/menu-items');
    }

    async saveConfig(configData) {
        return this.makeRequest('/config', 'POST', configData);
    }
}

// Simple Dashboard Manager
class DashboardConfigManager {
    constructor() {
        this.api = new JotunheimDashboardAPI();
        this.currentConfig = null;
        this.menuItems = null;
        this.init();
    }

    async init() {
        try {
            console.log('Loading dashboard data via REST API...');
            
            // Load configuration from REST API
            await this.loadConfig();
            
            // Setup event listeners
            this.setupEventListeners();
            
            // Update the UI with loaded data
            this.updateUI();
            
            console.log('Dashboard loaded successfully');
        } catch (error) {
            console.error('Failed to load dashboard:', error);
            this.showNotification('Failed to load dashboard configuration', 'error');
        }
    }

    async loadConfig() {
        try {
            const configResponse = await this.api.getConfig();
            this.currentConfig = configResponse.data;
            console.log('Loaded config:', this.currentConfig);
            
            const menuResponse = await this.api.getMenuItems();
            this.menuItems = menuResponse.data;
            console.log('Loaded menu items:', this.menuItems);
            
        } catch (error) {
            console.error('Failed to load configuration:', error);
            throw error;
        }
    }

    setupEventListeners() {
        // Save button - this will save ALL changes including quick actions
        const saveButton = document.getElementById('save-config');
        if (saveButton) {
            saveButton.addEventListener('click', (e) => {
                e.preventDefault();
                this.saveConfiguration();
            });
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

            // Collect ALL form data including quick action checkboxes
            const configData = this.collectFormData();
            console.log('Saving configuration:', configData);

            // Save via REST API
            const response = await this.api.saveConfig(configData);
            
            if (response.success) {
                this.showNotification('Configuration saved successfully!', 'success');
                this.currentConfig = response.data;
                console.log('Configuration saved:', response.data);
                
                // Reload the page to show updated state
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
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
        // Collect current configuration including quick action states
        const sections = {};
        
        // Go through each section in the current config
        if (this.currentConfig) {
            Object.keys(this.currentConfig).forEach(sectionKey => {
                const section = this.currentConfig[sectionKey];
                sections[sectionKey] = {
                    title: section.title,
                    description: section.description || 'No description available',
                    order: section.order || 0,
                    enabled: section.enabled || true,
                    items: []
                };
                
                // Process items in this section
                if (section.items) {
                    section.items.forEach(item => {
                        // Check if there's a quick action checkbox for this item
                        const quickActionCheckbox = document.querySelector(`input.quick-action-checkbox[data-item-id="${item.item_id}"]`);
                        const enabledCheckbox = document.querySelector(`input.item-enabled-checkbox[data-item-id="${item.item_id}"]`);
                        
                        const quickAction = quickActionCheckbox ? quickActionCheckbox.checked : (item.quick_action || false);
                        const enabled = enabledCheckbox ? enabledCheckbox.checked : (item.enabled || true);
                        
                        sections[sectionKey].items.push({
                            id: item.item_id,
                            item_id: item.item_id,
                            title: item.title,
                            callback: item.callback,
                            enabled: enabled,
                            quick_action: quickAction, // This is the key - get it from checkbox
                            order: item.order || 0,
                            icon: item.icon || null,
                            description: item.description || null,
                            permissions: item.permissions || null
                        });
                    });
                }
            });
        }
        
        return { sections: sections };
    }

    updateUI() {
        // Set quick action checkboxes based on loaded data
        if (this.menuItems) {
            this.menuItems.forEach(item => {
                const quickActionCheckbox = document.querySelector(`input.quick-action-checkbox[data-item-id="${item.id}"]`);
                const enabledCheckbox = document.querySelector(`input.item-enabled-checkbox[data-item-id="${item.id}"]`);
                
                if (quickActionCheckbox) {
                    quickActionCheckbox.checked = item.quick_action || false;
                    console.log(`Set quick action checkbox for ${item.id} to:`, item.quick_action);
                }
                
                if (enabledCheckbox) {
                    enabledCheckbox.checked = item.enabled || true;
                    console.log(`Set enabled checkbox for ${item.id} to:`, item.enabled);
                }
            });
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
    if (typeof dashboardConfig !== 'undefined') {
        window.dashboardManager = new DashboardConfigManager();
    } else {
        console.error('Dashboard configuration not available');
    }
});