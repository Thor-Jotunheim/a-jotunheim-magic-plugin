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
                if (input.name === 'item_type') {
                    input.value = 'Trophies'; // Default to Trophies for most custom items
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
        const itemType = document.getElementById('quick-item-type');
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

        // Submit via AJAX
        fetch(jotunheim_ajax.ajax_url, {
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
                this.showSuccessMessage(`${data.data.item_name} added to Item Database successfully!`);
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
}

// Initialize modal when script loads
let quickAddModal = null;

// Wait for DOM and initialize
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initQuickAddModal);
} else {
    initQuickAddModal();
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