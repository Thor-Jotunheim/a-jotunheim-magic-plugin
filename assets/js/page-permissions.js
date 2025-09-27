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
            
            // Show loading state
            $button.html('🔄 Scanning...').prop('disabled', true);
            
            $.ajax({
                url: page_permissions_config.ajax_url,
                type: 'POST',
                data: {
                    action: 'scan_new_pages',
                    nonce: page_permissions_config.nonce
                },
                success: function(response) {
                    if (response.success) {
                        const data = response.data;
                        if (data.new_count > 0) {
                            PagePermissions.showMessage(
                                `Found ${data.new_count} new pages out of ${data.total_scanned} total! Auto-added to configuration. Refreshing page...`, 
                                'success'
                            );
                            
                            // Auto-refresh the page to show new pages
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                        } else {
                            PagePermissions.showMessage(
                                `${data.message} Scanned ${data.total_scanned} pages, ${data.already_configured} already configured.`, 
                                'info'
                            );
                        }
                    } else {
                        PagePermissions.showMessage('Error scanning pages: ' + response.data, 'error');
                    }
                },
                error: function() {
                    PagePermissions.showMessage('Network error occurred while scanning pages.', 'error');
                },
                complete: function() {
                    $button.text(originalText).prop('disabled', false);
                }
            });
        },

        removePages: function(e) {
            e.preventDefault();
            
            // Get selected pages
            const selectedPages = [];
            $('.page-select-checkbox:checked').each(function() {
                selectedPages.push($(this).val());
            });
            
            if (selectedPages.length === 0) {
                PagePermissions.showMessage('Please select pages to remove.', 'warning');
                return;
            }
            
            if (!confirm(`Are you sure you want to remove ${selectedPages.length} page(s) from permissions configuration?`)) {
                return;
            }
            
            const $button = $(e.target);
            const originalText = $button.text();
            
            // Show loading state
            $button.html('🗑️ Removing...').prop('disabled', true);
            
            $.ajax({
                url: page_permissions_config.ajax_url,
                type: 'POST',
                data: {
                    action: 'remove_pages',
                    nonce: page_permissions_config.nonce,
                    pages: selectedPages
                },
                success: function(response) {
                    if (response.success) {
                        const data = response.data;
                        PagePermissions.showMessage(
                            `${data.removed_count} page(s) removed! Reload the page to see changes.`, 
                            'success'
                        );
                        
                        // Remove rows from table
                        selectedPages.forEach(function(pageKey) {
                            $(`input[value="${pageKey}"]`).closest('tr').fadeOut();
                        });
                    } else {
                        PagePermissions.showMessage('Error removing pages: ' + response.data, 'error');
                    }
                },
                error: function() {
                    PagePermissions.showMessage('Network error occurred while removing pages.', 'error');
                },
                complete: function() {
                    $button.text(originalText).prop('disabled', false);
                }
            });
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