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
            
            // Reset permissions
            $('#reset-permissions').on('click', this.resetPermissions.bind(this));
            
            // Individual radio button changes
            $('.permission-radio').on('change', this.handleRadioChange.bind(this));
        },

        savePermissions: function(e) {
            e.preventDefault();
            
            const $button = $(e.target);
            const originalText = $button.text();
            
            // Show loading state
            $button.html('<span class="spinner"></span>Saving...').prop('disabled', true);
            
            // Collect all permission data from radio buttons
            const permissions = {};
            $('.permission-radio:checked').each(function() {
                const $radio = $(this);
                const page = $radio.data('page');
                const role = $radio.data('role');
                const level = $radio.val();
                
                if (!permissions[page]) {
                    permissions[page] = {};
                }
                
                permissions[page][role] = level;
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
            // Set all radio buttons to 'read' permission
            $('.permission-radio[value="read"]').prop('checked', true);
            this.showMessage('All permissions set to READ access. Don\'t forget to save!', 'info');
        },

        clearAllPermissions: function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to clear all permissions?')) {
                // Set all radio buttons to 'none'
                $('.permission-radio[value="none"]').prop('checked', true);
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
                        
                        // Always show the modal if we have show_selection flag
                        if (data.show_selection && data.new_pages && Object.keys(data.new_pages).length > 0) {
                            PagePermissions.showMessage(data.message, 'success');
                            PagePermissions.showPageSelectionModal(data.new_pages);
                        } else if (data.new_count > 0) {
                            PagePermissions.showMessage(
                                `Found ${data.new_count} new pages out of ${data.total_scanned} total!`, 
                                'success'
                            );
                            PagePermissions.showPageSelectionModal(data.new_pages);
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

        handleRadioChange: function(e) {
            const $radio = $(e.target);
            const page = $radio.data('page');
            const role = $radio.data('role');
            const level = $radio.val();
            
            // You could add real-time feedback here if needed
            console.log(`Permission changed: ${page} - ${role} - ${level}`);
        },

        resetPermissions: function(e) {
            e.preventDefault();
            
            if (!confirm('Are you sure you want to reset permissions to admin pages only? This will remove all shortcode and other page permissions.')) {
                return;
            }
            
            const $button = $(e.target);
            const originalText = $button.text();
            
            // Show loading state
            $button.html('🔄 Resetting...').prop('disabled', true);
            
            $.ajax({
                url: page_permissions_config.ajax_url,
                type: 'POST',
                data: {
                    action: 'reset_permissions',
                    nonce: page_permissions_config.nonce
                },
                success: function(response) {
                    if (response.success) {
                        PagePermissions.showMessage(response.data.message, 'success');
                        
                        // Refresh page to show reset state
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    } else {
                        PagePermissions.showMessage('Error resetting permissions: ' + response.data, 'error');
                    }
                },
                error: function() {
                    PagePermissions.showMessage('Network error occurred while resetting permissions.', 'error');
                },
                complete: function() {
                    $button.text(originalText).prop('disabled', false);
                }
            });
        },

        showPageSelectionModal: function(newPages) {
            // Create modal HTML
            const modalHtml = `
                <div id="page-selection-modal" style="
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0,0,0,0.5);
                    z-index: 10000;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                ">
                    <div style="
                        background: white;
                        padding: 30px;
                        border-radius: 8px;
                        max-width: 80%;
                        max-height: 80%;
                        overflow-y: auto;
                        box-shadow: 0 4px 20px rgba(0,0,0,0.3);
                    ">
                        <h2>Select Pages to Add to Permissions</h2>
                        <p>Choose which pages you want to add to the permissions system:</p>
                        
                        <div style="margin: 20px 0;">
                            <button type="button" id="select-all-new-pages" class="button">Select All</button>
                            <button type="button" id="select-none-new-pages" class="button">Select None</button>
                        </div>
                        
                        <div id="new-pages-list" style="max-height: 400px; overflow-y: auto; border: 1px solid #ccc; padding: 15px;">
                            <!-- Pages will be inserted here -->
                        </div>
                        
                        <div style="margin-top: 20px; text-align: right;">
                            <button type="button" id="cancel-page-selection" class="button">Cancel</button>
                            <button type="button" id="add-selected-pages-btn" class="button button-primary">Add Selected Pages</button>
                        </div>
                    </div>
                </div>
            `;
            
            // Remove any existing modal
            $('#page-selection-modal').remove();
            
            // Add modal to page
            $('body').append(modalHtml);
            
            // Populate pages list
            const $pagesList = $('#new-pages-list');
            let pagesHtml = '';
            
            Object.keys(newPages).forEach(function(pageKey) {
                const page = newPages[pageKey];
                pagesHtml += `
                    <div style="margin: 8px 0; padding: 8px; border: 1px solid #ddd; background: #f9f9f9;">
                        <label style="display: block; cursor: pointer;">
                            <input type="checkbox" value="${pageKey}" style="margin-right: 10px;">
                            <strong>${page.title}</strong>
                            <br><small style="color: #666;">${page.description || ''} (${page.type || 'unknown'})</small>
                        </label>
                    </div>
                `;
            });
            
            $pagesList.html(pagesHtml);
            
            // Bind events
            $('#select-all-new-pages').on('click', function() {
                $('#new-pages-list input[type="checkbox"]').prop('checked', true);
            });
            
            $('#select-none-new-pages').on('click', function() {
                $('#new-pages-list input[type="checkbox"]').prop('checked', false);
            });
            
            $('#cancel-page-selection').on('click', function() {
                $('#page-selection-modal').remove();
            });
            
            $('#add-selected-pages-btn').on('click', function() {
                const selectedPages = [];
                $('#new-pages-list input[type="checkbox"]:checked').each(function() {
                    selectedPages.push($(this).val());
                });
                
                if (selectedPages.length === 0) {
                    alert('Please select at least one page to add.');
                    return;
                }
                
                PagePermissions.addSelectedPages(selectedPages);
            });
        },

        addSelectedPages: function(selectedPages) {
            console.log('Adding selected pages:', selectedPages);
            $.ajax({
                url: page_permissions_config.ajax_url,
                type: 'POST',
                data: {
                    action: 'add_selected_pages',
                    nonce: page_permissions_config.nonce,
                    selected_pages: selectedPages
                },
                success: function(response) {
                    $('#page-selection-modal').remove();
                    
                    if (response.success) {
                        PagePermissions.showMessage(response.data.message, 'success');
                        
                        // Refresh page to show new pages
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    } else {
                        PagePermissions.showMessage('Error adding pages: ' + response.data, 'error');
                    }
                },
                error: function() {
                    $('#page-selection-modal').remove();
                    PagePermissions.showMessage('Network error adding pages', 'error');
                }
            });
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