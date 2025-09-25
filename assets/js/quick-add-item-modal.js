// quick-add-item-modal.js
// JavaScript for the Quick Add Item Modal

class QuickAddItemModal {
    constructor() {
        this.modal = null;
        this.isSubmitting = false;
        this.onSuccessCallback = null;
        this.init();
    }

    init() {
        // Bind methods to preserve context
        this.show = this.show.bind(this);
        this.hide = this.hide.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleCancel = this.handleCancel.bind(this);
        this.handleOverlayClick = this.handleOverlayClick.bind(this);

        // Initialize modal when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setupModal());
        } else {
            this.setupModal();
        }
    }

    setupModal() {
        console.log('Setting up quick add modal...');
        this.modal = document.getElementById('quick-add-item-modal');
        if (!this.modal) {
            console.error('Quick add item modal not found in DOM');
            console.log('Available modals:', document.querySelectorAll('[id*="modal"]'));
            return;
        }
        console.log('Modal element found:', this.modal);

        // Get form elements
        this.form = document.getElementById('quick-add-item-form');
        this.itemNameInput = document.getElementById('quick-item-name');
        this.submitBtn = document.getElementById('quick-add-submit');
        this.cancelBtn = document.getElementById('quick-add-cancel');
        this.closeBtn = document.getElementById('quick-add-close');
        this.overlay = this.modal.querySelector('.quick-add-overlay');

        // Bind events
        if (this.submitBtn) {
            this.submitBtn.addEventListener('click', this.handleSubmit);
        }
        
        if (this.cancelBtn) {
            this.cancelBtn.addEventListener('click', this.handleCancel);
        }
        
        if (this.closeBtn) {
            this.closeBtn.addEventListener('click', this.hide);
        }
        
        if (this.overlay) {
            this.overlay.addEventListener('click', this.handleOverlayClick);
        }

        // ESC key to close
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.modal.style.display !== 'none') {
                this.hide();
            }
        });

        // Setup price suggestion based on tech level
        this.setupPriceSuggestion();

        console.log('Quick Add Item Modal initialized');
    }

    show(itemName, onSuccessCallback = null) {
        console.log('show() method called with itemName:', itemName);
        if (!this.modal) {
            console.error('Modal not initialized');
            return;
        }

        console.log('Modal element exists, showing modal...');

        // Set item name
        if (this.itemNameInput) {
            this.itemNameInput.value = itemName || '';
        }

        // Store success callback
        this.onSuccessCallback = onSuccessCallback;

        // Reset form to defaults
        this.resetForm();

        // Show modal
        console.log('Setting modal display to flex...');
        this.modal.style.display = 'flex';
        
        // Debug: Check DOM presence and positioning
        console.log('Modal exists in DOM:', document.contains(this.modal));
        console.log('Modal parent element:', this.modal.parentNode);
        console.log('Modal rect before:', this.modal.getBoundingClientRect());
        
        // CRITICAL FIX: Ensure modal is attached to body, not nested in another modal
        if (this.modal.parentNode && this.modal.parentNode.id === 'edit-shop-modal') {
            console.log('Auto-fixing modal nesting: Moving modal from edit-shop-modal to body');
            document.body.appendChild(this.modal);
        }
        
        document.body.style.overflow = 'hidden';

        // Focus first input
        const firstInput = this.modal.querySelector('select[required]');
        if (firstInput) {
            setTimeout(() => firstInput.focus(), 100);
        }

        console.log('Quick add modal shown for item:', itemName);
    }

    hide() {
        if (!this.modal) return;

        this.modal.style.display = 'none';
        document.body.style.overflow = '';
        this.isSubmitting = false;
        
        // Reset button state
        if (this.submitBtn) {
            this.submitBtn.disabled = false;
            this.submitBtn.textContent = 'Add to Item Database';
        }

        console.log('Quick add modal hidden');
    }

    resetForm() {
        if (!this.form) return;

        // Reset all inputs except item_name (readonly)
        const inputs = this.form.querySelectorAll('input:not([readonly]), select');
        inputs.forEach(input => {
            if (input.type === 'checkbox') {
                input.checked = false;
            } else if (input.tagName === 'SELECT') {
                // Set default values for selects
                if (input.name === 'type') {
                    input.value = ''; // Start with no selection to encourage user to choose
                } else if (input.name === 'tech_name') {
                    input.value = 'N/A';
                } else {
                    input.selectedIndex = 0;
                }
            } else if (input.type === 'number') {
                if (input.name === 'stack_size') {
                    input.value = '1';
                } else if (input.name === 'unit_price') {
                    input.value = '0.00';
                }
            } else {
                input.value = '';
            }
        });
    }

    handleSubmit() {
        if (this.isSubmitting || !this.form) return;

        // Validate required fields
        const itemType = document.getElementById('quick-add-type');
        if (!itemType || !itemType.value) {
            this.showValidationError('Please select an item type.');
            return;
        }

        this.isSubmitting = true;
        this.submitBtn.disabled = true;
        this.submitBtn.textContent = 'Adding to Database...';

        // Prepare form data
        const formData = new FormData(this.form);
        formData.append('action', 'quick_add_item');
        
        // Add the nonce from JavaScript localization
        if (jotunheimQuickAdd.quick_add_nonce) {
            formData.append('quick_add_nonce', jotunheimQuickAdd.quick_add_nonce);
        }

        // Submit via AJAX
        fetch(jotunheimQuickAdd.ajax_url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Item added successfully:', data.data);
                
                // Call success callback if provided
                if (this.onSuccessCallback) {
                    this.onSuccessCallback(data.data);
                }
                
                this.hide();
                this.showSuccessMessage(`${data.data.item_name} added to database successfully!`);
            } else {
                console.error('Failed to add item:', data.data);
                this.showValidationError(data.data || 'Failed to add item. Please try again.');
            }
        })
        .catch(error => {
            console.error('AJAX error:', error);
            this.showValidationError('Network error. Please check your connection and try again.');
        })
        .finally(() => {
            this.isSubmitting = false;
            this.submitBtn.disabled = false;
            this.submitBtn.textContent = 'Add to Item Database';
        });
    }

    handleCancel() {
        this.hide();
        
        // Show cancellation message
        if (window.unifiedTeller && window.unifiedTeller.showStatus) {
            window.unifiedTeller.showStatus('Transaction cancelled - custom item not added.', false, false);
        }
    }

    handleOverlayClick(e) {
        if (e.target === this.overlay) {
            this.hide();
        }
    }

    showValidationError(message) {
        // Show error in modal
        let errorDiv = this.modal.querySelector('.quick-add-error');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'quick-add-error';
            errorDiv.style.cssText = `
                background: #fef2f2;
                border-left: 4px solid #ef4444;
                color: #dc2626;
                padding: 12px 16px;
                margin: 16px 0 0 0;
                border-radius: 0 6px 6px 0;
                font-size: 14px;
            `;
            const body = this.modal.querySelector('.quick-add-body');
            if (body) {
                body.appendChild(errorDiv);
            }
        }
        
        errorDiv.textContent = message;
        errorDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        
        // Remove error after 5 seconds
        setTimeout(() => {
            if (errorDiv && errorDiv.parentNode) {
                errorDiv.parentNode.removeChild(errorDiv);
            }
        }, 5000);
    }

    showSuccessMessage(message) {
        // Use unified teller status system if available
        if (window.unifiedTeller && window.unifiedTeller.showStatus) {
            window.unifiedTeller.showStatus(message, true, false);
        } else {
            // Fallback alert
            alert(message);
        }
    }

    // Public method to check if modal is open
    isOpen() {
        return this.modal && this.modal.style.display !== 'none';
    }

    setupPriceSuggestion() {
        const techSelect = document.getElementById('quick-tech-name');
        const itemTypeSelect = document.getElementById('quick-add-type');
        const unitPriceInput = document.getElementById('quick-unit-price');
        
        if (!techSelect || !itemTypeSelect || !unitPriceInput) {
            return;
        }

        // Tech level price ranges (base prices)
        const techPriceRanges = {
            'N/A': { min: 1, max: 5 },
            'Meadow': { min: 1, max: 10 },
            'Forest': { min: 5, max: 25 },
            'Ocean': { min: 10, max: 40 },
            'Swamp': { min: 15, max: 60 },
            'Mountain': { min: 25, max: 100 },
            'Plains': { min: 40, max: 150 },
            'Mistlands': { min: 60, max: 200 },
            'Ashlands': { min: 80, max: 300 },
            'Deep North': { min: 100, max: 400 }
        };

        // Item type multipliers
        const typeMultipliers = {
            'Currency': 1.0,
            'Raw Food': 0.5,
            'Cooked Food': 0.8,
            'Fish': 0.6,
            'Seeds': 0.3,
            'Bait': 0.4,
            'Mead': 1.2,
            'Building & Crafting': 1.0,
            'Boss Summons': 3.0,
            'Tamed Animals': 5.0,
            'Metals & Ores': 1.5,
            'Gems & Precious Items': 2.0,
            'Tools': 2.0,
            'Weapons': 3.0,
            'Armor': 2.5,
            'Shields': 2.0,
            'Arrows & Ammunition': 0.8,
            'Trophies': 1.5,
            'Quest Items': 1.0,
            'Untradable': 0
        };

        const suggestPrice = () => {
            const techLevel = techSelect.value;
            const itemType = itemTypeSelect.value;
            
            if (!techLevel || !itemType || techLevel === '' || itemType === '') {
                return;
            }

            const baseRange = techPriceRanges[techLevel];
            const multiplier = typeMultipliers[itemType] || 1.0;
            
            if (!baseRange || multiplier === 0) {
                unitPriceInput.value = '0';
                unitPriceInput.style.backgroundColor = '#f0f0f0';
                return;
            }

            // Calculate suggested price (mid-range with multiplier)
            const baseSuggestion = (baseRange.min + baseRange.max) / 2;
            const suggestedPrice = Math.round(baseSuggestion * multiplier);
            
            // Set the suggested price
            unitPriceInput.value = suggestedPrice;
            unitPriceInput.style.backgroundColor = '#e8f5e8'; // Light green to indicate suggestion
            
            // Show a small tooltip/message
            const helpText = unitPriceInput.parentNode.querySelector('.price-suggestion-help') || 
                           this.createPriceSuggestionHelp(unitPriceInput.parentNode);
            helpText.textContent = `💡 Suggested: ${suggestedPrice} (${techLevel} ${itemType})`;
            helpText.style.display = 'block';
            
            setTimeout(() => {
                helpText.style.display = 'none';
                unitPriceInput.style.backgroundColor = '';
            }, 3000);
        };

        // Add event listeners
        techSelect.addEventListener('change', suggestPrice);
        itemTypeSelect.addEventListener('change', suggestPrice);
    }

    createPriceSuggestionHelp(parentElement) {
        const helpDiv = document.createElement('small');
        helpDiv.className = 'form-text text-muted price-suggestion-help';
        helpDiv.style.display = 'none';
        helpDiv.style.color = '#28a745';
        helpDiv.style.fontWeight = 'bold';
        parentElement.appendChild(helpDiv);
        return helpDiv;
    }
}

// Initialize modal when script loads
let quickAddModal = null;

// Load dynamic item types
function loadItemTypes() {
    fetch(window.jotunheimQuickAdd.rest_url + 'jotunheim/v1/itemlist-item-types/', {
        method: 'GET',
        headers: {
            'X-WP-Nonce': window.jotunheimQuickAdd.nonce,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data) {
            populateItemTypeDropdown(data.data);
        } else {
            console.warn('Failed to load item types, using fallback');
            populateItemTypeDropdown([]);
        }
    })
    .catch(error => {
        console.error('Error loading item types:', error);
        populateItemTypeDropdown([]);
    });
}

// Populate item type dropdown with dynamic data
function populateItemTypeDropdown(itemTypes) {
    const typeSelect = document.getElementById('quick-add-type');
    if (!typeSelect) return;

    // Clear existing options except first one
    while (typeSelect.children.length > 1) {
        typeSelect.removeChild(typeSelect.lastChild);
    }

    // Add dynamic options
    if (itemTypes.length > 0) {
        itemTypes.forEach(type => {
            const option = document.createElement('option');
            option.value = type.type_name;
            option.textContent = type.type_name;
            option.dataset.multiplier = type.price_multiplier;
            typeSelect.appendChild(option);
        });
    } else {
        // Fallback hardcoded options if API fails
        const fallbackTypes = [
            { type_name: 'Weapon', price_multiplier: 1.2 },
            { type_name: 'Armor', price_multiplier: 1.1 },
            { type_name: 'Tool', price_multiplier: 1.0 },
            { type_name: 'Food', price_multiplier: 0.8 },
            { type_name: 'Material', price_multiplier: 0.5 },
            { type_name: 'Resource', price_multiplier: 0.7 },
            { type_name: 'Building', price_multiplier: 0.9 },
            { type_name: 'Consumable', price_multiplier: 0.6 },
            { type_name: 'Misc', price_multiplier: 0.4 },
            { type_name: 'Decoration', price_multiplier: 0.3 },
            { type_name: 'Trophy', price_multiplier: 2.0 },
            { type_name: 'Aesir Spell', price_multiplier: 3.0 }
        ];
        
        fallbackTypes.forEach(type => {
            const option = document.createElement('option');
            option.value = type.type_name;
            option.textContent = type.type_name;
            option.dataset.multiplier = type.price_multiplier;
            typeSelect.appendChild(option);
        });
    }
}

// Wait for DOM and initialize
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        initQuickAddModal();
        loadItemTypes();
    });
} else {
    initQuickAddModal();
    loadItemTypes();
}

function initQuickAddModal() {
    quickAddModal = new QuickAddItemModal();
    
    // Make it globally available
    window.quickAddModal = quickAddModal;
    
    console.log('Quick Add Item Modal system loaded');
}

// Global helper function for other scripts to use
window.showQuickAddModal = function(itemName, onSuccessCallback) {
    console.log('Global showQuickAddModal called with:', itemName);
    console.log('quickAddModal instance:', quickAddModal);
    if (quickAddModal) {
        quickAddModal.show(itemName, onSuccessCallback);
    } else {
        console.error('Quick Add Modal not initialized');
    }
};