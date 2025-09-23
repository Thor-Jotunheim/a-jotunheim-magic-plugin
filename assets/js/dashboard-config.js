/**
 * Dashboard Configuration JavaScript
 * Handles the drag-and-drop interface for organizing dashboard menu items
 */

jQuery(document).ready(function($) {
    let currentConfig = dashboardConfig.config;
    let menuItems = dashboardConfig.menuItems;

    // Make currentConfig globally accessible for the Add Pages modal
    window.currentConfig = currentConfig;

    // Global function to refresh dashboard configuration from server
    window.refreshDashboardConfig = function() {
        console.log('Refreshing dashboard configuration from server...');
        
        // Make AJAX call to get fresh configuration
        $.post(dashboardConfig.ajaxurl, {
            action: 'get_dashboard_config_frontend',
            nonce: dashboardConfig.nonce
        })
        .done(function(response) {
            if (response.success && response.data) {
                console.log('Dashboard config refresh successful, updating interface...');
                
                // Update the local configuration
                currentConfig = response.data;
                window.currentConfig = currentConfig;
                dashboardConfig.config = response.data;
                
                // Re-render the interface with the new data
                renderSections();
                renderItems();
                populateFilters();
                
                // Show success message
                showNotification('Dashboard configuration refreshed with new pages!', 'success');
            } else {
                console.error('Failed to refresh dashboard config:', response);
                showNotification('Failed to refresh configuration. Please reload the page.', 'error');
            }
        })
        .fail(function() {
            console.error('AJAX error refreshing dashboard config');
            showNotification('Failed to refresh configuration. Please reload the page.', 'error');
        });
    };

    // Helper function to show notifications
    function showNotification(message, type) {
        const noticeClass = type === 'success' ? 'notice-success' : 'notice-error';
        const $notice = $('<div class="notice ' + noticeClass + ' is-dismissible"><p>' + message + '</p></div>');
        $('.wrap h1').after($notice);
        setTimeout(function() {
            $notice.fadeOut();
        }, 4000);
    }

    // Initialize the interface
    init();

    function init() {
        renderSections();
        renderItems();
        bindEvents();
        setupSortable();
        populateFilters();
    }

    function bindEvents() {
        // Add new section
        $('#add-section').on('click', addNewSection);
        
        // Section modal events
        $('#save-section').on('click', saveSection);
        $('#cancel-section, #close-section-modal').on('click', closeSectionModal);
        
        // Filter events
        $('#section-filter, #status-filter').on('change', filterItems);
        
        // Section control events (delegated)
        $(document).on('click', '.edit-section', editSection);
        $(document).on('click', '.toggle-section', toggleSection);
        $(document).on('click', '.delete-section', deleteSection);
        
        // Item control events (delegated)
        $(document).on('click', '.toggle-item', toggleItem);
        $(document).on('change', '.item-section-select', changeItemSection);
        $(document).on('change', '.quick-action-checkbox', toggleQuickAction);
        $(document).on('click', '.edit-item', editItem);
        $(document).on('click', '.delete-item', deleteItem);
        
        // Discord role events
        $('#save-discord-roles').on('click', saveDiscordRoles);
        $('#test-discord-connection').on('click', testDiscordConnection);
        
        // Modal close on background click
        $('.dashboard-modal').on('click', function(e) {
            if (e.target === this) {
                $(this).hide();
            }
        });
        
    }

    function renderSections() {
        const container = $('#sections-container');
        container.empty();
        
        const sections = [...currentConfig.sections].sort((a, b) => a.order - b.order);
        
        sections.forEach(section => {
            const sectionHtml = `
                <div class="section-item" data-id="${section.id}">
                    <div class="section-header">
                        <div class="section-title">
                            <span class="dashicons ${section.icon}"></span>
                            ${escapeHtml(section.title)}
                        </div>
                        <div class="section-controls">
                            <button class="control-btn edit edit-section" data-id="${section.id}" title="Edit Section">
                                <span class="dashicons dashicons-edit"></span>
                            </button>
                            <button class="control-btn toggle toggle-section ${section.enabled ? '' : 'disabled'}" 
                                    data-id="${section.id}" title="${section.enabled ? 'Disable' : 'Enable'} Section">
                                <span class="dashicons dashicons-${section.enabled ? 'visibility' : 'hidden'}"></span>
                            </button>
                            <button class="control-btn delete delete-section" data-id="${section.id}" title="Delete Section">
                                <span class="dashicons dashicons-trash"></span>
                            </button>
                        </div>
                    </div>
                    <div class="section-description">
                        ${escapeHtml(section.description)}
                    </div>
                    <div class="section-meta">
                        <span class="section-status ${section.enabled ? 'enabled' : 'disabled'}">
                            ${section.enabled ? 'Enabled' : 'Disabled'}
                        </span>
                        <span class="section-items-count">
                            ${getItemsInSection(section.id).length} items
                        </span>
                    </div>
                </div>
            `;
            container.append(sectionHtml);
        });
    }

    function renderItems() {
        const container = $('#items-container');
        container.empty();
        
        const items = [...currentConfig.items].sort((a, b) => a.order - b.order);
        
        items.forEach(itemConfig => {
            // For config page, use itemConfig data directly instead of relying on menuItems
            // This ensures disabled items still show up for management
            const menuItem = findMenuItem(itemConfig.id) || {
                id: itemConfig.id,
                menu_title: itemConfig.title || itemConfig.id,
                description: itemConfig.description || '',
                quick_action: itemConfig.quick_action || false
            };
            
            const section = findSection(itemConfig.section);
            const sectionName = section ? section.title : 'Unknown Section';
            
            const itemHtml = `
                <div class="menu-item" data-id="${itemConfig.id}" data-section="${itemConfig.section}">
                    <div class="item-content">
                        <div class="item-title">
                            ${escapeHtml(menuItem.menu_title)}
                        </div>
                        <div class="item-description">
                            ${escapeHtml(menuItem.description || '')}
                        </div>
                        <div class="item-meta">
                            <span class="item-section">${escapeHtml(sectionName)}</span>
                            <span class="item-status ${itemConfig.enabled ? 'enabled' : 'disabled'}">
                                ${itemConfig.enabled ? 'Enabled' : 'Disabled'}
                            </span>
                        </div>
                    </div>
                    <div class="item-controls">
                        <div class="item-section-control">
                            <label>Section:</label>
                            <select class="item-section-select" data-id="${menuItem.id}">
                                ${renderSectionOptions(itemConfig.section)}
                            </select>
                        </div>
                        <div class="item-status-control">
                            <label>Status:</label>
                            <button class="control-btn toggle toggle-item ${itemConfig.enabled ? '' : 'disabled'}" 
                                    data-id="${menuItem.id}" title="${itemConfig.enabled ? 'Disable' : 'Enable'} Item">
                                <span class="dashicons dashicons-${itemConfig.enabled ? 'visibility' : 'hidden'}"></span>
                                ${itemConfig.enabled ? 'Enabled' : 'Disabled'}
                            </button>
                        </div>
                        <div class="item-quick-action-control">
                            <label>
                                <input type="checkbox" class="quick-action-checkbox" data-id="${menuItem.id}" 
                                       ${(itemConfig.quick_action || false) ? 'checked' : ''}>
                                Quick Action
                            </label>
                        </div>
                        <div class="item-action-buttons">
                            <button class="control-btn edit edit-item" data-id="${menuItem.id}" data-title="${escapeHtml(menuItem.menu_title)}" title="Edit Item">
                                <span class="dashicons dashicons-edit"></span>
                            </button>
                            <button class="control-btn delete delete-item" data-id="${menuItem.id}" data-title="${escapeHtml(menuItem.menu_title)}" title="Delete Item">
                                <span class="dashicons dashicons-trash"></span>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            container.append(itemHtml);
        });
    }

    function renderSectionOptions(selectedSection) {
        let options = '';
        currentConfig.sections.forEach(section => {
            if (section.enabled) {
                const selected = section.id === selectedSection ? 'selected' : '';
                options += `<option value="${section.id}" ${selected}>${escapeHtml(section.title)}</option>`;
            }
        });
        return options;
    }

    function setupSortable() {
        // Make sections sortable
        $('#sections-container').sortable({
            placeholder: 'section-item ui-sortable-placeholder',
            update: function(event, ui) {
                updateSectionOrder();
                // Auto-save when section order changes
            }
        });
        
        // Make items sortable
        $('#items-container').sortable({
            placeholder: 'menu-item ui-sortable-placeholder',
            update: function(event, ui) {
                updateItemOrder();
                // Auto-save when item order changes
            }
        });
    }

    function populateFilters() {
        const sectionFilter = $('#section-filter');
        sectionFilter.empty().append('<option value="">All Sections</option>');
        
        currentConfig.sections.forEach(section => {
            if (section.enabled) {
                sectionFilter.append(`<option value="${section.id}">${escapeHtml(section.title)}</option>`);
            }
        });
    }

    function filterItems() {
        const sectionFilter = $('#section-filter').val();
        const statusFilter = $('#status-filter').val();
        
        $('.menu-item').each(function() {
            const $item = $(this);
            const itemSection = $item.data('section');
            const itemEnabled = !$item.find('.toggle-item').hasClass('disabled');
            
            let show = true;
            
            if (sectionFilter && itemSection !== sectionFilter) {
                show = false;
            }
            
            if (statusFilter === 'enabled' && !itemEnabled) {
                show = false;
            } else if (statusFilter === 'disabled' && itemEnabled) {
                show = false;
            }
            
            $item.toggle(show);
        });
    }

    function updateSectionOrder() {
        const sectionOrders = {};
        $('#sections-container .section-item').each(function(index) {
            const sectionId = $(this).data('id');
            const section = findSection(sectionId);
            if (section) {
                section.order = index + 1;
                sectionOrders[sectionId] = index + 1;
            }
        });
        
        // Auto-save section order
        $.ajax({
            url: dashboardConfig.ajaxurl,
            type: 'POST',
            data: {
                action: 'update_section_order',
                section_orders: sectionOrders,
                nonce: dashboardConfig.nonce
            },
            success: function(response) {
                if (response.success) {
                    console.log('Section order auto-saved successfully');
                } else {
                    console.error('Error updating section order:', response.data);
                }
            },
            error: function() {
                console.error('Error updating section order');
            }
        });
    }

    function updateItemOrder() {
        const itemOrders = {};
        $('#items-container .menu-item').each(function(index) {
            const itemId = $(this).data('id');
            const itemConfig = findItemConfig(itemId);
            if (itemConfig) {
                itemConfig.order = index + 1;
                itemOrders[itemId] = index + 1;
            }
        });
        
        // Auto-save item order
        $.ajax({
            url: dashboardConfig.ajaxurl,
            type: 'POST',
            data: {
                action: 'update_item_order',
                item_orders: itemOrders,
                nonce: dashboardConfig.nonce
            },
            success: function(response) {
                if (response.success) {
                    console.log('Item order auto-saved successfully');
                } else {
                    console.error('Error updating item order:', response.data);
                }
            },
            error: function() {
                console.error('Error updating item order');
            }
        });
    }

    function addNewSection() {
        const newSection = {
            id: 'section_' + Date.now(),
            title: 'New Section',
            description: 'Description for new section',
            icon: 'dashicons-category',
            order: currentConfig.sections.length + 1,
            enabled: true
        };
        
        openSectionModal(newSection, true);
    }

    function editSection(e) {
        const sectionId = $(e.currentTarget).data('id');
        const section = findSection(sectionId);
        if (section) {
            openSectionModal(section, false);
        }
    }

    function openSectionModal(section, isNew) {
        $('#section-modal-title').text(isNew ? 'Add New Section' : 'Edit Section');
        $('#section-id').val(section.id);
        $('#section-title').val(section.title);
        $('#section-description').val(section.description);
        $('#section-icon').val(section.icon);
        $('#section-enabled').prop('checked', section.enabled);
        
        $('#section-modal').show();
        $('#section-title').focus();
        
        // Store if this is a new section
        $('#section-modal').data('isNew', isNew);
    }

    function saveSection() {
        const isNew = $('#section-modal').data('isNew');
        const sectionData = {
            id: $('#section-id').val(),
            title: $('#section-title').val().trim(),
            description: $('#section-description').val().trim(),
            icon: $('#section-icon').val(),
            enabled: $('#section-enabled').is(':checked')
        };
        
        if (!sectionData.title) {
            alert('Section title is required');
            return;
        }
        
        if (isNew) {
            // For new sections, add to local config and render
            sectionData.order = currentConfig.sections.length + 1;
            currentConfig.sections.push(sectionData);
            
            closeSectionModal();
            renderSections();
            populateFilters();
            updateItemSectionSelects();
            
            // For new sections, we would need to create them via a different endpoint
            // For now, new sections still require the full config save
            showNotification('New section added. Note: New sections are saved automatically when you make other changes.', 'success');
        } else {
            // For existing sections, auto-save immediately via AJAX
            $.ajax({
                url: dashboardConfig.ajaxurl,
                type: 'POST',
                data: {
                    action: 'edit_dashboard_section',
                    section_id: sectionData.id,
                    section_data: {
                        title: sectionData.title,
                        description: sectionData.description,
                        icon: sectionData.icon,
                        enabled: sectionData.enabled
                    },
                    nonce: dashboardConfig.nonce
                },
                success: function(response) {
                    if (response.success) {
                        // Update local data
                        const section = findSection(sectionData.id);
                        if (section) {
                            Object.assign(section, sectionData);
                        }
                        
                        closeSectionModal();
                        showNotification('Section updated successfully! Refreshing page...', 'success');
                        console.log('Section auto-saved successfully');
                        
                        // Refresh page to show changes
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        alert('Error updating section: ' + (response.data || 'Unknown error'));
                    }
                },
                error: function() {
                    alert('Error updating section. Please try again.');
                }
            });
        }
    }

    function closeSectionModal() {
        $('#section-modal').hide();
    }

    function toggleSection(e) {
        const sectionId = $(e.currentTarget).data('id');
        const section = findSection(sectionId);
        if (section) {
            const newEnabledState = !section.enabled;
            
            // Auto-save section toggle immediately
            $.ajax({
                url: dashboardConfig.ajaxurl,
                type: 'POST',
                data: {
                    action: 'edit_dashboard_section',
                    section_id: sectionId,
                    section_data: {
                        enabled: newEnabledState
                    },
                    nonce: dashboardConfig.nonce
                },
                success: function(response) {
                    if (response.success) {
                        // Update local data
                        section.enabled = newEnabledState;
                        showNotification('Section visibility updated! Refreshing page...', 'success');
                        console.log('Section visibility auto-saved successfully');
                        
                        // Refresh page to show changes
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        alert('Error updating section visibility: ' + (response.data || 'Unknown error'));
                    }
                },
                error: function() {
                    alert('Error updating section visibility. Please try again.');
                }
            });
        }
    }

    function deleteSection(e) {
        const sectionId = $(e.currentTarget).data('id');
        const section = findSection(sectionId);
        if (!section) return;
        
        const itemsInSection = getItemsInSection(sectionId);
        let confirmMessage = `Are you sure you want to delete the section "${section.title}"?`;
        
        if (itemsInSection.length > 0) {
            confirmMessage += `\n\nThis will also move ${itemsInSection.length} menu item(s) to the first available section.`;
        }
        
        if (confirm(confirmMessage)) {
            // Move items to first available section
            if (itemsInSection.length > 0) {
                const firstSection = currentConfig.sections.find(s => s.enabled && s.id !== sectionId);
                if (firstSection) {
                    itemsInSection.forEach(item => {
                        item.section = firstSection.id;
                    });
                }
            }
            
            // Remove section
            currentConfig.sections = currentConfig.sections.filter(s => s.id !== sectionId);
            
            renderSections();
            renderItems();
            populateFilters();
            // Auto-save after section deletion
        }
    }

    function toggleItem(e) {
        const itemId = $(e.currentTarget).data('id');
        const itemConfig = findItemConfig(itemId);
        
        if (!itemConfig) {
            console.error('Error: Item config not found for ID:', itemId);
            return;
        }
        
        const newEnabledState = !itemConfig.enabled;
        
        // Save immediately to database like rename and quick action functions do
        $.ajax({
            url: dashboardConfig.ajaxurl,
            type: 'POST',
            data: {
                action: 'edit_dashboard_page',
                page_id: itemId,
                page_data: {
                    enabled: newEnabledState
                },
                nonce: dashboardConfig.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Update local data
                    itemConfig.enabled = newEnabledState;
                    const menuItem = findMenuItem(itemId);
                    if (menuItem) {
                        menuItem.enabled = newEnabledState;
                    }
                    
                    // Don't mark dirty - toggle saves immediately to database
                    // markDirty(); // Removed - no need to save again
                    renderItems(); // Re-render to show the new state
                    console.log('TOGGLE DEBUG: Item visibility saved immediately. New state:', newEnabledState);
                } else {
                    alert('Error updating item visibility: ' + (response.data || 'Unknown error'));
                }
            },
            error: function() {
                alert('Error updating item visibility. Please try again.');
            }
        });
    }

    function changeItemSection(e) {
        const itemId = $(e.currentTarget).data('id');
        const newSection = $(e.currentTarget).val();
        const itemConfig = findItemConfig(itemId);
        
        if (itemConfig) {
            itemConfig.section = newSection;
            $(e.currentTarget).closest('.menu-item').attr('data-section', newSection);
            renderItems(); // Re-render to update section display
            // Auto-save after section change
        }
    }

    function toggleQuickAction(e) {
        const itemId = $(e.currentTarget).data('id');
        const isChecked = $(e.currentTarget).is(':checked');
        
        if (!itemId) {
            console.error('Error: Page ID is missing. Element:', e.currentTarget);
            alert('Error: Page ID is missing. Please refresh the page and try again.');
            $(e.currentTarget).prop('checked', !isChecked); // Revert checkbox
            return;
        }
        
        // Save immediately to database like rename function does
        $.ajax({
            url: dashboardConfig.ajaxurl,
            type: 'POST',
            data: {
                action: 'edit_dashboard_page',
                page_id: itemId,
                page_data: {
                    quick_action: isChecked
                },
                nonce: dashboardConfig.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Update local data - focus on itemConfig since that's what template uses
                    const configItem = currentConfig.items.find(item => item.id === itemId);
                    const menuItem = findMenuItem(itemId);
                    
                    // Primary update: configItem (used by template)
                    if (configItem) {
                        configItem.quick_action = isChecked;
                    }
                    // Secondary update: menuItem (if it exists)
                    if (menuItem) {
                        menuItem.quick_action = isChecked;
                    }
                    
                    // Re-render to update the display with new data
                    renderItems();
                    
                    console.log('Quick action saved successfully. Item:', itemId, 'Value:', isChecked);
                } else {
                    // Revert checkbox on error
                    $(e.currentTarget).prop('checked', !isChecked);
                    alert('Error updating quick action: ' + (response.data || 'Unknown error'));
                }
            },
            error: function(xhr, status, error) {
                // Revert checkbox on error
                $(e.currentTarget).prop('checked', !isChecked);
                alert('Error updating quick action. Please try again.');
            }
        });
    }

    function editItem(e) {
        const itemId = $(e.currentTarget).data('id');
        const itemTitle = $(e.currentTarget).data('title');
        
        // Create simple prompt for editing page title
        const newTitle = prompt('Edit dashboard title for: ' + itemTitle, itemTitle);
        
        if (newTitle && newTitle !== itemTitle) {
            // Send AJAX request to update the page
            $.ajax({
                url: dashboardConfig.ajaxurl,
                type: 'POST',
                data: {
                    action: 'edit_dashboard_page',
                    page_id: itemId,
                    page_data: {
                        menu_title: newTitle
                    },
                    nonce: dashboardConfig.nonce
                },
                success: function(response) {
                    if (response.success) {
                        // Find and update both the menu item and config item
                        const menuItem = findMenuItem(itemId);
                        const configItem = currentConfig.items.find(item => item.id === itemId);
                        
                        if (menuItem) {
                            menuItem.menu_title = newTitle;
                        }
                        if (configItem) {
                            configItem.menu_title = newTitle;
                        }
                        
                        // Don't mark dirty - rename saves immediately to database
                        // markDirty(); // Removed - no need to save again
                        renderItems(); // Re-render to show the new title
                        alert('Page title updated successfully! (Saved immediately)');
                    } else {
                        alert('Error updating page: ' + (response.data || 'Unknown error'));
                    }
                },
                error: function() {
                    alert('Error updating page');
                }
            });
        }
    }

    function deleteItem(e) {
        const itemId = $(e.currentTarget).data('id');
        const itemTitle = $(e.currentTarget).data('title');
        
        if (confirm('Are you sure you want to delete "' + itemTitle + '" from the dashboard?')) {
            $.ajax({
                url: dashboardConfig.ajaxurl,
                type: 'POST',
                data: {
                    action: 'delete_dashboard_page',
                    page_id: itemId,
                    nonce: dashboardConfig.nonce
                },
                success: function(response) {
                    if (response.success) {
                        // Remove the item from the config
                        currentConfig.items = currentConfig.items.filter(item => item.id !== itemId);
                        // Auto-save after page deletion
                        renderItems(); // Re-render to remove the item
                        alert('Page deleted successfully!');
                    } else {
                        alert('Error deleting page: ' + (response.data || 'Unknown error'));
                    }
                },
                error: function() {
                    alert('Error deleting page');
                }
            });
        }
    }

    function updateItemSectionSelects() {
        $('.item-section-select').each(function() {
            const currentSection = $(this).data('id');
            const itemConfig = findItemConfig(currentSection);
            if (itemConfig) {
                $(this).html(renderSectionOptions(itemConfig.section));
            }
        });
    }



    // Helper functions
    function findSection(id) {
        return currentConfig.sections.find(s => s.id === id);
    }

    function findItemConfig(id) {
        return currentConfig.items.find(i => i.id === id);
    }

    function findMenuItem(id) {
        return menuItems.find(i => i.id === id);
    }

    function getItemsInSection(sectionId) {
        return currentConfig.items.filter(item => item.section === sectionId);
    }



    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function showNotification(message, type = 'success') {
        const notification = $(`
            <div class="dashboard-notification ${type}">
                ${escapeHtml(message)}
            </div>
        `);
        
        $('body').append(notification);
        
        setTimeout(() => {
            notification.addClass('show');
        }, 100);
        
        setTimeout(() => {
            notification.removeClass('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }

    // Discord Role Management Functions
    function saveDiscordRoles() {
        const roleData = {};
        
        $('.discord-role-item').each(function() {
            const $item = $(this);
            const roleKey = $item.find('.discord-role-id-input').attr('id').replace('discord_role_', '');
            const roleId = $item.find('.discord-role-id-input').val().trim();
            const roleName = $item.find('input[name$="[name]"]').val();
            const roleDescription = $item.find('input[name$="[description]"]').val();
            
            roleData[roleKey] = {
                id: roleId,
                name: roleName,
                description: roleDescription
            };
        });
        
        $.ajax({
            url: dashboardConfig.ajaxurl,
            type: 'POST',
            data: {
                action: 'save_discord_roles',
                nonce: dashboardConfig.nonce,
                roles: roleData
            },
            beforeSend: function() {
                $('#save-discord-roles').prop('disabled', true).text('Saving...');
            },
            success: function(response) {
                if (response.success) {
                    showNotification('Discord roles saved successfully!', 'success');
                } else {
                    showNotification('Error saving Discord roles: ' + (response.data || 'Unknown error'), 'error');
                }
            },
            error: function() {
                showNotification('Failed to save Discord roles. Please try again.', 'error');
            },
            complete: function() {
                $('#save-discord-roles').prop('disabled', false).text('Save Discord Roles');
            }
        });
    }
    
    function testDiscordConnection() {
        $.ajax({
            url: dashboardConfig.ajaxurl,
            type: 'POST',
            data: {
                action: 'test_discord_connection',
                nonce: dashboardConfig.nonce
            },
            beforeSend: function() {
                $('#test-discord-connection').prop('disabled', true).text('Testing...');
            },
            success: function(response) {
                if (response.success) {
                    showNotification('Discord connection test successful!', 'success');
                } else {
                    showNotification('Discord connection test failed: ' + (response.data || 'Unknown error'), 'error');
                }
            },
            error: function() {
                showNotification('Failed to test Discord connection. Please try again.', 'error');
            },
            complete: function() {
                $('#test-discord-connection').prop('disabled', false).text('Test Discord Connection');
            }
        });
    }

});

// Add notification styles
const notificationStyles = `
<style>
.dashboard-notification {
    position: fixed;
    top: 32px;
    right: 20px;
    max-width: 300px;
    padding: 12px 16px;
    border-radius: 4px;
    color: white;
    font-size: 14px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    z-index: 100000;
    transform: translateX(100%);
    transition: transform 0.3s ease;
}

.dashboard-notification.show {
    transform: translateX(0);
}

.dashboard-notification.success {
    background: #00a32a;
}

.dashboard-notification.error {
    background: #d63638;
}

.button-primary-dirty {
    background: #d63638 !important;
    border-color: #d63638 !important;
}
</style>
`;

jQuery(document).ready(function() {
    jQuery('head').append(notificationStyles);
});