/**
 * Discord Auth Config JavaScript
 * Handles the interactive functionality for the Discord authentication configuration page
 */

jQuery(document).ready(function($) {
    'use strict';

    const DiscordAuthConfig = {
        
        init: function() {
            this.bindEvents();
            this.loadExistingRoles();
        },

        bindEvents: function() {
            // Save OAuth settings
            $('#save-oauth-settings').on('click', this.saveOAuthSettings.bind(this));
            
            // Save Discord roles
            $('#save-discord-roles').on('click', this.saveDiscordRoles.bind(this));
            
            // Add new role
            $('#add-discord-role').on('click', this.addRole.bind(this));
            
            // Remove role
            $(document).on('click', '.remove-role', this.removeRole.bind(this));
            
            // Update role level
            $(document).on('change', '.role-level-select', this.updateRoleLevel.bind(this));
            
            // Test connection
            $('#test-discord-connection').on('click', this.testConnection.bind(this));
            
            // Import roles from Discord
            $('#import-discord-roles').on('click', this.importRoles.bind(this));
        },

        saveOAuthSettings: function(e) {
            e.preventDefault();
            
            const $button = $(e.target);
            const originalText = $button.text();
            
            // Show loading state
            $button.html('<span class="discord-spinner"></span>Saving...').prop('disabled', true);
            
            const settings = {
                client_id: $('#discord_client_id').val(),
                client_secret: $('#discord_client_secret').val(),
                redirect_uri: $('#discord_redirect_uri').val(),
                bot_token: $('#discord_bot_token').val(),
                guild_id: $('#discord_guild_id').val(),
                enabled: $('#discord_enabled').is(':checked'),
                require_discord_auth: $('#discord_require_auth').is(':checked')
            };
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'save_discord_oauth_settings',
                    nonce: discord_auth_config.nonce,
                    settings: settings
                },
                success: function(response) {
                    if (response.success) {
                        DiscordAuthConfig.showMessage('OAuth settings saved successfully!', 'success');
                    } else {
                        DiscordAuthConfig.showMessage('Error saving settings: ' + response.data, 'error');
                    }
                },
                error: function() {
                    DiscordAuthConfig.showMessage('Network error occurred while saving settings.', 'error');
                },
                complete: function() {
                    $button.text(originalText).prop('disabled', false);
                }
            });
        },

        saveDiscordRoles: function(e) {
            e.preventDefault();
            
            const $button = $(e.target);
            const originalText = $button.text();
            
            // Show loading state
            $button.html('<span class="discord-spinner"></span>Saving...').prop('disabled', true);
            
            // Collect all role data from the form
            const roles = {};
            $('.discord-role-row').each(function() {
                const $row = $(this);
                const roleKey = $row.data('role-key');
                const roleName = $row.find('.role-name').val();
                const roleId = $row.find('.role-id').val();
                const roleDescription = $row.find('.role-description').val();
                
                if (roleKey && roleName) {
                    roles[roleKey] = {
                        name: roleName,
                        id: roleId,
                        description: roleDescription
                    };
                }
            });
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'save_discord_roles',
                    nonce: discord_auth_config.nonce,
                    roles: roles
                },
                success: function(response) {
                    if (response.success) {
                        DiscordAuthConfig.showMessage('Discord roles saved successfully!', 'success');
                    } else {
                        DiscordAuthConfig.showMessage('Error saving roles: ' + response.data, 'error');
                    }
                },
                error: function() {
                    DiscordAuthConfig.showMessage('Network error occurred while saving roles.', 'error');
                },
                complete: function() {
                    $button.text(originalText).prop('disabled', false);
                }
            });
        },

        addRole: function(e) {
            e.preventDefault();
            
            const roleName = $('#new_role_name').val().trim();
            const roleId = $('#new_role_id').val().trim();
            const roleLevel = $('#new_role_level').val();
            
            if (!roleName || !roleId) {
                this.showMessage('Please enter both role name and role ID.', 'error');
                return;
            }
            
            // Check if role already exists
            if ($(`[data-role-id="${roleId}"]`).length > 0) {
                this.showMessage('A role with this ID already exists.', 'error');
                return;
            }
            
            const $button = $('#add-discord-role');
            const originalText = $button.text();
            
            $button.html('<span class="discord-spinner"></span>Adding...').prop('disabled', true);
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'add_discord_role',
                    nonce: discord_auth_config.nonce,
                    role_name: roleName,
                    role_id: roleId,
                    role_level: roleLevel
                },
                success: function(response) {
                    if (response.success) {
                        DiscordAuthConfig.addRoleToList(roleName, roleId, roleLevel);
                        DiscordAuthConfig.clearAddRoleForm();
                        DiscordAuthConfig.showMessage('Role added successfully!', 'success');
                    } else {
                        DiscordAuthConfig.showMessage('Error adding role: ' + response.data, 'error');
                    }
                },
                error: function() {
                    DiscordAuthConfig.showMessage('Network error occurred while adding role.', 'error');
                },
                complete: function() {
                    $button.text(originalText).prop('disabled', false);
                }
            });
        },

        removeRole: function(e) {
            e.preventDefault();
            
            const $roleItem = $(e.target).closest('.discord-role-item');
            const roleId = $roleItem.data('role-id');
            const roleName = $roleItem.find('.discord-role-name').text();
            
            if (!confirm(`Are you sure you want to remove the role "${roleName}"?`)) {
                return;
            }
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'remove_discord_role',
                    nonce: discord_auth_config.nonce,
                    role_id: roleId
                },
                success: function(response) {
                    if (response.success) {
                        $roleItem.fadeOut(300, function() {
                            $(this).remove();
                        });
                        DiscordAuthConfig.showMessage('Role removed successfully!', 'success');
                    } else {
                        DiscordAuthConfig.showMessage('Error removing role: ' + response.data, 'error');
                    }
                },
                error: function() {
                    DiscordAuthConfig.showMessage('Network error occurred while removing role.', 'error');
                }
            });
        },

        updateRoleLevel: function(e) {
            const $select = $(e.target);
            const $roleItem = $select.closest('.discord-role-item');
            const roleId = $roleItem.data('role-id');
            const newLevel = $select.val();
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'update_discord_role_level',
                    nonce: discord_auth_config.nonce,
                    role_id: roleId,
                    role_level: newLevel
                },
                success: function(response) {
                    if (response.success) {
                        DiscordAuthConfig.showMessage('Role level updated successfully!', 'success');
                    } else {
                        DiscordAuthConfig.showMessage('Error updating role level: ' + response.data, 'error');
                        // Revert the select value
                        $select.val($select.data('original-value'));
                    }
                },
                error: function() {
                    DiscordAuthConfig.showMessage('Network error occurred while updating role level.', 'error');
                    $select.val($select.data('original-value'));
                }
            });
        },

        testConnection: function(e) {
            e.preventDefault();
            
            const $button = $(e.target);
            const originalText = $button.text();
            
            $button.html('<span class="discord-spinner"></span>Testing...').prop('disabled', true);
            
            $.ajax({
                url: discord_auth_config.ajax_url,
                type: 'POST',
                data: {
                    action: 'test_discord_connection',
                    nonce: discord_auth_config.nonce
                },
                success: function(response) {
                    const $result = $('#test-result');
                    const $resultText = $result.find('p');
                    
                    if (response.success) {
                        $result.removeClass('notice-error').addClass('notice-success');
                        $resultText.html('<strong>Success:</strong> ' + response.data);
                    } else {
                        $result.removeClass('notice-success').addClass('notice-error');
                        $resultText.html('<strong>Error:</strong> ' + response.data);
                    }
                    
                    $result.show();
                    
                    // Hide result after 8 seconds
                    setTimeout(function() {
                        $result.fadeOut();
                    }, 8000);
                },
                error: function() {
                    const $result = $('#test-result');
                    const $resultText = $result.find('p');
                    
                    $result.removeClass('notice-success').addClass('notice-error');
                    $resultText.html('<strong>Error:</strong> Network error occurred during connection test.');
                    $result.show();
                    
                    setTimeout(function() {
                        $result.fadeOut();
                    }, 8000);
                },
                complete: function() {
                    $button.text(originalText).prop('disabled', false);
                }
            });
        },

        importRoles: function(e) {
            e.preventDefault();
            
            const $button = $(e.target);
            const originalText = $button.text();
            
            $button.html('<span class="discord-spinner"></span>Importing...').prop('disabled', true);
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'import_discord_roles',
                    nonce: discord_auth_config.nonce
                },
                success: function(response) {
                    if (response.success) {
                        DiscordAuthConfig.loadExistingRoles();
                        DiscordAuthConfig.showMessage(`Successfully imported ${response.data.count} roles from Discord!`, 'success');
                    } else {
                        DiscordAuthConfig.showMessage('Error importing roles: ' + response.data, 'error');
                    }
                },
                error: function() {
                    DiscordAuthConfig.showMessage('Network error occurred while importing roles.', 'error');
                },
                complete: function() {
                    $button.text(originalText).prop('disabled', false);
                }
            });
        },

        loadExistingRoles: function() {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'get_discord_roles',
                    nonce: discord_auth_config.nonce
                },
                success: function(response) {
                    if (response.success) {
                        DiscordAuthConfig.populateRolesList(response.data);
                    }
                }
            });
        },

        populateRolesList: function(roles) {
            const $rolesList = $('#discord-roles-list');
            $rolesList.empty();
            
            if (roles.length === 0) {
                $rolesList.html('<div class="discord-role-item"><div class="discord-role-info"><div class="discord-role-name">No roles configured</div><div class="discord-role-id">Add roles using the form below</div></div></div>');
                return;
            }
            
            roles.forEach(function(role) {
                DiscordAuthConfig.addRoleToList(role.name, role.id, role.level, false);
            });
        },

        addRoleToList: function(roleName, roleId, roleLevel, animate = true) {
            const roleHtml = `
                <div class="discord-role-item" data-role-id="${roleId}" ${animate ? 'style="display:none"' : ''}>
                    <div class="discord-role-info">
                        <div class="discord-role-name">${this.escapeHtml(roleName)}</div>
                        <div class="discord-role-id">${this.escapeHtml(roleId)}</div>
                    </div>
                    <div class="discord-role-level">
                        <select class="role-level-select" data-original-value="${roleLevel}">
                            <option value="1" ${roleLevel == '1' ? 'selected' : ''}>Basic</option>
                            <option value="2" ${roleLevel == '2' ? 'selected' : ''}>Moderator</option>
                            <option value="3" ${roleLevel == '3' ? 'selected' : ''}>Admin</option>
                            <option value="4" ${roleLevel == '4' ? 'selected' : ''}>Owner</option>
                        </select>
                    </div>
                    <div class="discord-role-actions">
                        <button type="button" class="discord-btn discord-btn-danger discord-btn-small remove-role">Remove</button>
                    </div>
                </div>
            `;
            
            const $roleItem = $(roleHtml);
            $('#discord-roles-list').append($roleItem);
            
            if (animate) {
                $roleItem.fadeIn(300);
            }
        },

        clearAddRoleForm: function() {
            $('#new_role_name').val('');
            $('#new_role_id').val('');
            $('#new_role_level').val('1');
        },

        showMessage: function(message, type) {
            const $container = $('.discord-auth-config-container');
            const $existing = $container.find('.discord-status-message');
            
            $existing.remove();
            
            const $message = $(`<div class="discord-status-message discord-status-${type}">${this.escapeHtml(message)}</div>`);
            $container.prepend($message);
            
            // Auto-hide success messages after 5 seconds
            if (type === 'success') {
                setTimeout(function() {
                    $message.fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 5000);
            }
        },

        escapeHtml: function(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    };

    // Initialize when DOM is ready
    DiscordAuthConfig.init();
    
    // Make it globally accessible for debugging
    window.DiscordAuthConfig = DiscordAuthConfig;
});