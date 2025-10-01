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
            $('#save-discord-oauth').on('click', this.saveOAuthSettings.bind(this));
            
            // Save Discord roles
            $('#save-discord-roles').on('click', this.saveDiscordRoles.bind(this));
            
            // Add new role
            $('#add-discord-role').on('click', this.addRole.bind(this));
            
            // Remove role
            $(document).on('click', '.remove-role', this.removeRole.bind(this));
            
            // Toggle role disabled state
            $(document).on('click', '.toggle-role', this.toggleRole.bind(this));
            
            // Test connection
            $('#test-discord-connection').on('click', this.testConnection.bind(this));
        },

        saveOAuthSettings: function(e) {
            e.preventDefault();
            
            const $button = $(e.target);
            const originalText = $button.text();
            
            // Show loading state
            $button.html('<span class="discord-spinner"></span>Saving...').prop('disabled', true);
            
            // Collect form data
            const settings = {
                client_id: $('#discord_client_id').val(),
                client_secret: $('#discord_client_secret').val(),
                redirect_uri: $('#discord_redirect_uri').val(),
                bot_token: $('#discord_bot_token').val(),
                guild_id: $('#discord_guild_id').val(),
                enabled: $('#enable_discord_oauth').is(':checked'),
                require_discord_auth: $('#require_discord_auth').is(':checked')
            };
            
            $.ajax({
                url: discord_auth_config.ajax_url,
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
            $('.discord-role-item').each(function() {
                const $item = $(this);
                const roleInput = $item.find('.discord-role-id-input');
                const nameInput = $item.find('input[name*="[name]"]');
                const descInput = $item.find('input[name*="[description]"]');
                
                if (roleInput.length && nameInput.length) {
                    const name = nameInput.val();
                    const roleId = roleInput.val();
                    const description = descInput.length ? descInput.val() : '';
                    
                    // Extract role key from input name
                    const nameAttr = nameInput.attr('name');
                    const match = nameAttr.match(/discord_roles\[([^\]]+)\]\[name\]/);
                    const roleKey = match ? match[1] : null;
                    
                    if (roleKey && name) {
                        roles[roleKey] = {
                            name: name,
                            id: roleId,
                            description: description
                        };
                    }
                }
            });
            
            $.ajax({
                url: discord_auth_config.ajax_url,
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
            
            if (!roleName || !roleId) {
                this.showMessage('Please enter both role name and role ID.', 'error');
                return;
            }
            
            // Check if role already exists
            if ($(`input[value="${roleId}"]`).length > 0) {
                this.showMessage('A role with this ID already exists.', 'error');
                return;
            }
            
            // Add role to the existing roles container
            this.addRoleToExistingList(roleName, roleId);
            this.clearAddRoleForm();
            this.showMessage('Role added! Don\'t forget to save your changes.', 'success');
        },

        removeRole: function(e) {
            e.preventDefault();
            
            if (confirm('Are you sure you want to remove this role?')) {
                $(e.target).closest('.discord-role-item').remove();
                this.showMessage('Role removed! Don\'t forget to save your changes.', 'success');
            }
        },

        toggleRole: function(e) {
            e.preventDefault();
            
            const $button = $(e.target);
            const $roleItem = $button.closest('.discord-role-item');
            const roleKey = $button.data('role-key');
            const originalText = $button.text();
            const isCurrentlyDisabled = originalText === 'Enable';
            
            // Show loading state
            $button.text(isCurrentlyDisabled ? 'Enabling...' : 'Disabling...').prop('disabled', true);
            
            $.ajax({
                url: discord_auth_config.ajax_url,
                type: 'POST',
                data: {
                    action: 'toggle_discord_role',
                    nonce: discord_auth_config.nonce,
                    role_key: roleKey
                },
                success: function(response) {
                    if (response.success) {
                        const newState = response.data.state;
                        const isNowDisabled = newState === 'disabled';
                        
                        // Update button text and styling
                        $button.text(isNowDisabled ? 'Enable' : 'Disable');
                        
                        // Update hidden field for form submission
                        $roleItem.find('.role-disabled-field').val(isNowDisabled ? '1' : '0');
                        
                        if (isNowDisabled) {
                            // Role is now disabled - green "Enable" button
                            $button.css({
                                'background': '#00a32a',
                                'color': 'white'
                            });
                            $roleItem.css('opacity', '0.6');
                        } else {
                            // Role is now enabled - orange "Disable" button
                            $button.css({
                                'background': '#dba617',
                                'color': 'white'
                            });
                            $roleItem.css('opacity', '1');
                        }
                        
                        DiscordAuthConfig.showMessage(response.data.message, 'success');
                    } else {
                        DiscordAuthConfig.showMessage('Error toggling role: ' + response.data, 'error');
                        $button.text(originalText);
                    }
                },
                error: function() {
                    DiscordAuthConfig.showMessage('Network error occurred while toggling role.', 'error');
                    $button.text(originalText);
                },
                complete: function() {
                    $button.prop('disabled', false);
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
                    
                    console.log('Test connection response:', response);
                    
                    if (response && response.success) {
                        $result.removeClass('notice-error').addClass('notice-success');
                        $resultText.html('<strong>Success:</strong> ' + (response.data || 'Connection successful'));
                    } else {
                        $result.removeClass('notice-success').addClass('notice-error');
                        $resultText.html('<strong>Error:</strong> ' + (response.data || 'Unknown error occurred'));
                    }
                    
                    $result.show();
                    
                    // Hide result after 8 seconds
                    setTimeout(function() {
                        $result.fadeOut();
                    }, 8000);
                },
                error: function(xhr, status, error) {
                    const $result = $('#test-result');
                    const $resultText = $result.find('p');
                    
                    console.error('Test connection error:', xhr, status, error);
                    
                    $result.removeClass('notice-success').addClass('notice-error');
                    $resultText.html('<strong>Error:</strong> Network error occurred during connection test: ' + error);
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

        loadExistingRoles: function() {
            // This function can be expanded to load roles via AJAX if needed
        },

        addRoleToExistingList: function(roleName, roleId) {
            const roleKey = roleName.toLowerCase().replace(/[^a-z0-9]/g, '_');
            
            // Create new role item HTML
            const roleHtml = `
                <div class="discord-role-item" data-role-key="${roleKey}">
                    <div class="role-info">
                        <label for="discord_role_${roleKey}">
                            <strong>${roleName}</strong>
                        </label>
                        <p class="role-description">Custom Discord role</p>
                    </div>
                    <div class="role-input">
                        <input 
                            type="text" 
                            id="discord_role_${roleKey}"
                            name="discord_roles[${roleKey}][id]"
                            value="${roleId}"
                            placeholder="Discord Role ID"
                            class="discord-role-id-input"
                        />
                        <input 
                            type="hidden" 
                            name="discord_roles[${roleKey}][name]"
                            value="${roleName}"
                        />
                        <input 
                            type="hidden" 
                            name="discord_roles[${roleKey}][description]"
                            value="Custom Discord role"
                        />
                        <button type="button" class="button remove-role" data-role-key="${roleKey}" style="margin-left: 10px;">
                            Remove
                        </button>
                    </div>
                </div>
            `;
            
            $('.discord-roles-container').append(roleHtml);
        },

        clearAddRoleForm: function() {
            $('#new_role_name').val('');
            $('#new_role_id').val('');
        },

        showMessage: function(message, type) {
            // Remove existing messages
            $('.discord-message').remove();
            
            // Create message element
            const messageClass = type === 'success' ? 'notice-success' : 'notice-error';
            const messageHtml = `
                <div class="notice ${messageClass} discord-message" style="margin: 10px 0;">
                    <p>${message}</p>
                </div>
            `;
            
            // Insert message at the top of the form
            $('.discord-config-form').prepend(messageHtml);
            
            // Auto-hide after 5 seconds
            setTimeout(function() {
                $('.discord-message').fadeOut(function() {
                    $(this).remove();
                });
            }, 5000);
        }
    };

    // Initialize the Discord Auth Config
    DiscordAuthConfig.init();
});