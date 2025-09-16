/**
 * Page Permissions JavaScript
 * Handles the page permissions configuration interface
 */

jQuery(document).ready(function($) {
    'use strict';

    const PagePermissions = {
        
        init: function() {
            this.bindEvents();
        },

        bindEvents: function() {
            // Save permissions
            $('#save-page-permissions').on('click', this.savePermissions.bind(this));
            
            // Select all permissions
            $('#select-all-permissions').on('click', this.selectAllPermissions.bind(this));
            
            // Clear all permissions  
            $('#clear-all-permissions').on('click', this.clearAllPermissions.bind(this));
            
            // Individual checkbox changes
            $('.permission-checkbox').on('change', this.handleCheckboxChange.bind(this));
        },

        savePermissions: function(e) {
            e.preventDefault();
            
            const $button = $(e.target);
            const originalText = $button.text();
            
            // Show loading state
            $button.html('<span class="spinner"></span>Saving...').prop('disabled', true);
            
            // Collect all permission data
            const permissions = {};
            $('.permission-checkbox').each(function() {
                const $checkbox = $(this);
                const page = $checkbox.data('page');
                const role = $checkbox.data('role');
                const checked = $checkbox.is(':checked');
                
                if (!permissions[page]) {
                    permissions[page] = {};
                }
                
                permissions[page][role] = checked ? 1 : 0;
            });
            
            $.ajax({
                url: page_permissions_config.ajax_url,
                type: 'POST',
                data: {
                    action: 'save_page_permissions',
                    nonce: page_permissions_config.nonce,
                    permissions: permissions
                },
                success: function(response) {
                    if (response.success) {
                        PagePermissions.showMessage('Page permissions saved successfully!', 'success');
                    } else {
                        PagePermissions.showMessage('Error saving permissions: ' + response.data, 'error');
                    }
                },
                error: function() {
                    PagePermissions.showMessage('Network error occurred while saving permissions.', 'error');
                },
                complete: function() {
                    $button.text(originalText).prop('disabled', false);
                }
            });
        },

        selectAllPermissions: function(e) {
            e.preventDefault();
            $('.permission-checkbox').prop('checked', true);
            this.showMessage('All permissions selected. Don\'t forget to save!', 'info');
        },

        clearAllPermissions: function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to clear all permissions?')) {
                $('.permission-checkbox').prop('checked', false);
                this.showMessage('All permissions cleared. Don\'t forget to save!', 'info');
            }
        },

        handleCheckboxChange: function(e) {
            const $checkbox = $(e.target);
            const page = $checkbox.data('page');
            const role = $checkbox.data('role');
            const checked = $checkbox.is(':checked');
            
            // You could add real-time feedback here if needed
            console.log(`Permission changed: ${page} - ${role} - ${checked}`);
        },

        showMessage: function(message, type) {
            // Remove existing messages
            $('.permissions-message').remove();
            
            // Create message element
            let messageClass = 'notice-info';
            if (type === 'success') messageClass = 'notice-success';
            if (type === 'error') messageClass = 'notice-error';
            
            const messageHtml = `
                <div class="notice ${messageClass} permissions-message" style="margin: 15px 0;">
                    <p>${message}</p>
                </div>
            `;
            
            // Insert message at the top of the form
            $('.page-permissions-config').prepend(messageHtml);
            
            // Auto-hide after 5 seconds
            setTimeout(function() {
                $('.permissions-message').fadeOut(function() {
                    $(this).remove();
                });
            }, 5000);
        }
    };

    // Initialize
    PagePermissions.init();
});