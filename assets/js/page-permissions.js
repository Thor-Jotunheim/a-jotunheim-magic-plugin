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
            
            // Scan for new pages
            $('#scan-new-pages').on('click', this.scanNewPages.bind(this));
            
            // Remove pages
            $('#remove-pages').on('click', this.removePages.bind(this));
            
            // Select all pages checkbox
            $('#select-all-pages').on('change', this.toggleAllPageSelection.bind(this));
            
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

        scanNewPages: function(e) {
            e.preventDefault();
            
            const $button = $(e.target);
            const originalText = $button.text();
            
            $button.prop('disabled', true).text('Scanning...');
            
            $.ajax({
                url: page_permissions_config.ajax_url,
                type: 'POST',
                data: {
                    action: 'scan_new_pages',
                    nonce: page_permissions_config.nonce
                },
                success: (response) => {
                    if (response.success) {
                        if (response.data.new_count > 0) {
                            // Show popup with results
                            alert(`✅ Scan Complete!\n\n${response.data.message}\n\nThe page will refresh to show the new pages.`);
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            alert(`ℹ️ Scan Complete!\n\n${response.data.message}`);
                        }
                    } else {
                        alert(`❌ Error!\n\n${response.data || 'Unknown error'}`);
                    }
                },
                error: (xhr, status, error) => {
                    alert(`❌ AJAX Error!\n\n${error}`);
                },
                complete: () => {
                    $button.prop('disabled', false).text(originalText);
                }
            });
        },

        removePages: function(e) {
            e.preventDefault();
            
            const selectedPages = [];
            $('.page-select-checkbox:checked').each(function() {
                selectedPages.push($(this).val());
            });
            
            if (selectedPages.length === 0) {
                alert('Please select pages to remove by checking the boxes in the first column.');
                return;
            }
            
            const pageNames = selectedPages.join(', ');
            if (!confirm(`Are you sure you want to remove these ${selectedPages.length} page(s) from permissions configuration?\n\n${pageNames}\n\nThis will delete their permission settings and they will fall back to WordPress permissions.`)) {
                return;
            }
            
            const $button = $(e.target);
            const originalText = $button.text();
            
            $button.prop('disabled', true).text('Removing...');
            
            $.ajax({
                url: page_permissions_config.ajax_url,
                type: 'POST',
                data: {
                    action: 'remove_pages',
                    pages: selectedPages,
                    nonce: page_permissions_config.nonce
                },
                success: (response) => {
                    if (response.success) {
                        alert(`✅ Success!\n\n${response.data.message}\n\nThe page will refresh to show changes.`);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        alert(`❌ Error!\n\n${response.data || 'Unknown error'}`);
                    }
                },
                error: (xhr, status, error) => {
                    alert(`❌ AJAX Error!\n\n${error}`);
                },
                complete: () => {
                    $button.prop('disabled', false).text(originalText);
                }
            });
        },

        toggleAllPageSelection: function(e) {
            const isChecked = $(e.target).is(':checked');
            $('.page-select-checkbox').prop('checked', isChecked);
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