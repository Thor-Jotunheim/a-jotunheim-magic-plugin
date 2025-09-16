/**
 * Player List Management Interface JavaScript
 * Handles all frontend functionality for the player list management
 */

jQuery(document).ready(function($) {
    let currentPage = 1;
    let pageSize = 50;
    let currentSort = { column: 'registration_date', direction: 'desc' };
    let currentFilter = '';
    let currentSearch = '';
    let selectedPlayers = new Set();

    // Initialize the interface
    init();

    function init() {
        loadPlayerStats();
        loadPlayers();
        bindEvents();
        setupDragAndDrop();
    }

    function bindEvents() {
        // Search functionality
        $('#player-search').on('input', debounce(function() {
            currentSearch = $(this).val();
            currentPage = 1;
            loadPlayers();
        }, 300));

        // Filter functionality
        $('#player-filter').on('change', function() {
            currentFilter = $(this).val();
            currentPage = 1;
            loadPlayers();
        });

        // Add player button
        $('#add-player-btn').on('click', function() {
            openPlayerModal();
        });

        // Import players button
        $('#import-players-btn').on('click', function() {
            openImportModal();
        });

        // Export players button
        $('#export-players-btn').on('click', function() {
            exportPlayers();
        });

        // Pagination
        $('#prev-page').on('click', function() {
            if (currentPage > 1) {
                currentPage--;
                loadPlayers();
            }
        });

        $('#next-page').on('click', function() {
            currentPage++;
            loadPlayers();
        });

        // Table sorting
        $('.jotun-data-table th.sortable').on('click', function() {
            const column = $(this).data('column') || $(this).text().toLowerCase().replace(' ', '_');
            
            if (currentSort.column === column) {
                currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
            } else {
                currentSort.column = column;
                currentSort.direction = 'asc';
            }
            
            updateSortIndicators();
            currentPage = 1;
            loadPlayers();
        });

        // Select all checkbox
        $('#select-all-players').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('.player-checkbox').prop('checked', isChecked);
            updateSelectedPlayers();
        });

        // Individual checkboxes
        $(document).on('change', '.player-checkbox', function() {
            updateSelectedPlayers();
        });

        // Player form modal
        $('#save-player').on('click', savePlayer);
        $('#cancel-player, #close-modal').on('click', closePlayerModal);

        // Import modal
        $('#select-file').on('click', function() {
            $('#import-file').click();
        });

        $('#import-file').on('change', handleFileSelect);
        $('#start-import').on('click', startImport);
        $('#cancel-import, #close-import-modal').on('click', closeImportModal);

        // Bulk actions
        $('#apply-bulk-action').on('click', applyBulkAction);
        $('#cancel-bulk-action').on('click', function() {
            selectedPlayers.clear();
            $('.player-checkbox').prop('checked', false);
            $('#select-all-players').prop('checked', false);
            $('#bulk-actions').hide();
        });

        // Action buttons (delegated events)
        $(document).on('click', '.edit-player', function() {
            const playerId = $(this).data('id');
            editPlayer(playerId);
        });

        $(document).on('click', '.delete-player', function() {
            const playerId = $(this).data('id');
            const playerName = $(this).data('name');
            deletePlayer(playerId, playerName);
        });

        // Modal close on background click
        $('.jotun-modal').on('click', function(e) {
            if (e.target === this) {
                $(this).hide();
            }
        });
    }

    async function loadPlayerStats() {
        try {
            // Get all players to calculate stats
            const result = await JotunAPI.getPlayers({ limit: 1000 });
            const players = result.data || [];
            
            const totalPlayers = players.length;
            const activePlayers = players.filter(p => p.is_active).length;
            
            // Calculate recent registrations (last 7 days)
            const sevenDaysAgo = new Date();
            sevenDaysAgo.setDate(sevenDaysAgo.getDate() - 7);
            const recentRegistrations = players.filter(p => {
                const regDate = new Date(p.registration_date);
                return regDate >= sevenDaysAgo;
            }).length;

            $('#total-players').text(totalPlayers);
            $('#active-players').text(activePlayers);
            $('#recent-registrations').text(recentRegistrations);
        } catch (error) {
            console.error('Error loading player stats:', error);
            $('#total-players').text('Error');
            $('#active-players').text('Error');
            $('#recent-registrations').text('Error');
        }
    }

    async function loadPlayers() {
        try {
            showLoading();
            
            const params = {
                limit: pageSize,
                offset: (currentPage - 1) * pageSize
            };

            if (currentSearch) {
                params.search = currentSearch;
            }

            // Apply filter
            if (currentFilter === 'active') {
                params.is_active = true;
            } else if (currentFilter === 'inactive') {
                params.is_active = false;
            } else if (currentFilter === 'recent') {
                const sevenDaysAgo = new Date();
                sevenDaysAgo.setDate(sevenDaysAgo.getDate() - 7);
                params.date_from = sevenDaysAgo.toISOString().split('T')[0];
            }

            const result = await JotunAPI.getPlayers(params);
            const players = result.data || [];
            
            renderPlayersTable(players);
            updatePagination(players.length);
            
        } catch (error) {
            console.error('Error loading players:', error);
            showError('Failed to load players');
        }
    }

    function renderPlayersTable(players) {
        const tbody = $('#players-table-body');
        tbody.empty();

        if (players.length === 0) {
            tbody.append(`
                <tr class="no-items">
                    <td colspan="7" style="text-align: center; padding: 40px; color: #646970;">
                        <span class="dashicons dashicons-admin-users" style="font-size: 48px; margin-bottom: 10px; display: block; opacity: 0.3;"></span>
                        No players found
                    </td>
                </tr>
            `);
            return;
        }

        players.forEach(player => {
            const row = $(`
                <tr data-id="${player.id}">
                    <td class="check-column">
                        <input type="checkbox" class="player-checkbox" value="${player.id}">
                    </td>
                    <td class="column-player-name">
                        <strong>${escapeHtml(player.player_name)}</strong>
                    </td>
                    <td class="column-steam-id">
                        ${escapeHtml(player.steam_id || '-')}
                    </td>
                    <td class="column-discord-id">
                        ${escapeHtml(player.discord_id || '-')}
                    </td>
                    <td class="column-registration-date">
                        ${formatDate(player.registration_date)}
                    </td>
                    <td class="column-status">
                        <span class="status-badge status-${player.is_active ? 'active' : 'inactive'}">
                            ${player.is_active ? 'Active' : 'Inactive'}
                        </span>
                    </td>
                    <td class="column-actions">
                        <div class="action-buttons">
                            <button class="action-btn edit edit-player" data-id="${player.id}" title="Edit Player">
                                <span class="dashicons dashicons-edit-large"></span>
                            </button>
                            <button class="action-btn delete delete-player" data-id="${player.id}" data-name="${escapeHtml(player.player_name)}" title="Delete Player">
                                <span class="dashicons dashicons-trash"></span>
                            </button>
                        </div>
                    </td>
                </tr>
            `);
            tbody.append(row);
        });
    }

    function updatePagination(currentCount) {
        const start = (currentPage - 1) * pageSize + 1;
        const end = start + currentCount - 1;
        
        $('#pagination-start').text(start);
        $('#pagination-end').text(end);
        
        // Update navigation buttons
        $('#prev-page').prop('disabled', currentPage <= 1);
        $('#next-page').prop('disabled', currentCount < pageSize);
    }

    function updateSelectedPlayers() {
        selectedPlayers.clear();
        $('.player-checkbox:checked').each(function() {
            selectedPlayers.add($(this).val());
        });

        if (selectedPlayers.size > 0) {
            $('#bulk-actions').show();
        } else {
            $('#bulk-actions').hide();
        }

        // Update select all checkbox
        const totalCheckboxes = $('.player-checkbox').length;
        const checkedCheckboxes = $('.player-checkbox:checked').length;
        
        $('#select-all-players').prop('indeterminate', checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes);
        $('#select-all-players').prop('checked', checkedCheckboxes === totalCheckboxes && totalCheckboxes > 0);
    }

    function updateSortIndicators() {
        $('.jotun-data-table th').removeClass('sorted-asc sorted-desc');
        $(`.jotun-data-table th[data-column="${currentSort.column}"]`).addClass(`sorted-${currentSort.direction}`);
    }

    function openPlayerModal(player = null) {
        const modal = $('#player-modal');
        const title = $('#modal-title');
        const form = $('#player-form')[0];
        
        if (player) {
            title.text('Edit Player');
            $('#player-id').val(player.id);
            $('#player-name').val(player.player_name);
            $('#steam-id').val(player.steam_id || '');
            $('#discord-id').val(player.discord_id || '');
            $('#is-active').prop('checked', player.is_active);
        } else {
            title.text('Add New Player');
            form.reset();
            $('#player-id').val('');
            $('#is-active').prop('checked', true);
        }
        
        modal.show();
        $('#player-name').focus();
    }

    function closePlayerModal() {
        $('#player-modal').hide();
    }

    async function savePlayer() {
        try {
            const playerId = $('#player-id').val();
            const playerData = {
                player_name: $('#player-name').val().trim(),
                steam_id: $('#steam-id').val().trim(),
                discord_id: $('#discord-id').val().trim(),
                is_active: $('#is-active').is(':checked')
            };

            if (!playerData.player_name) {
                alert('Player name is required');
                return;
            }

            $('#save-player').prop('disabled', true).text('Saving...');

            if (playerId) {
                await JotunAPI.updatePlayer(playerId, playerData);
                JotunAPI.handleSuccess(`Player "${playerData.player_name}" updated successfully`);
            } else {
                await JotunAPI.addPlayer(playerData);
                JotunAPI.handleSuccess(`Player "${playerData.player_name}" added successfully`);
            }

            closePlayerModal();
            loadPlayers();
            loadPlayerStats();

        } catch (error) {
            JotunAPI.handleError(error, playerId ? 'Update player' : 'Add player');
        } finally {
            $('#save-player').prop('disabled', false).html('<span class="dashicons dashicons-saved"></span> Save Player');
        }
    }

    async function editPlayer(playerId) {
        try {
            // Get player data from the table row for now
            // In a full implementation, you might want to fetch from API
            const row = $(`tr[data-id="${playerId}"]`);
            const playerName = row.find('.column-player-name strong').text();
            const steamId = row.find('.column-steam-id').text();
            const discordId = row.find('.column-discord-id').text();
            const isActive = row.find('.status-active').length > 0;

            const player = {
                id: playerId,
                player_name: playerName,
                steam_id: steamId === '-' ? '' : steamId,
                discord_id: discordId === '-' ? '' : discordId,
                is_active: isActive
            };

            openPlayerModal(player);
        } catch (error) {
            JotunAPI.handleError(error, 'Edit player');
        }
    }

    async function deletePlayer(playerId, playerName) {
        if (!confirm(`Are you sure you want to delete player "${playerName}"? This action cannot be undone.`)) {
            return;
        }

        try {
            await JotunAPI.deletePlayer(playerId);
            JotunAPI.handleSuccess(`Player "${playerName}" deleted successfully`);
            loadPlayers();
            loadPlayerStats();
        } catch (error) {
            JotunAPI.handleError(error, 'Delete player');
        }
    }

    function openImportModal() {
        $('#import-modal').show();
    }

    function closeImportModal() {
        $('#import-modal').hide();
        $('#import-file').val('');
        $('#import-preview').hide();
        $('#start-import').prop('disabled', true);
    }

    function setupDragAndDrop() {
        const uploadArea = $('#file-upload-area');
        
        uploadArea.on('dragover', function(e) {
            e.preventDefault();
            $(this).addClass('drag-over');
        });

        uploadArea.on('dragleave', function(e) {
            e.preventDefault();
            $(this).removeClass('drag-over');
        });

        uploadArea.on('drop', function(e) {
            e.preventDefault();
            $(this).removeClass('drag-over');
            
            const files = e.originalEvent.dataTransfer.files;
            if (files.length > 0) {
                handleFileSelect({ target: { files: files } });
            }
        });

        uploadArea.on('click', function() {
            $('#import-file').click();
        });
    }

    function handleFileSelect(event) {
        const file = event.target.files[0];
        if (!file) return;

        if (file.type !== 'text/csv' && !file.name.endsWith('.csv')) {
            alert('Please select a CSV file');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const csv = e.target.result;
            parseCSV(csv);
        };
        reader.readAsText(file);
    }

    function parseCSV(csv) {
        const lines = csv.split('\n').filter(line => line.trim());
        if (lines.length < 2) {
            alert('CSV file must have at least a header row and one data row');
            return;
        }

        const headers = lines[0].split(',').map(h => h.trim().replace(/"/g, ''));
        const data = lines.slice(1).map(line => {
            const values = line.split(',').map(v => v.trim().replace(/"/g, ''));
            const row = {};
            headers.forEach((header, index) => {
                row[header] = values[index] || '';
            });
            return row;
        });

        displayImportPreview(headers, data);
    }

    function displayImportPreview(headers, data) {
        const headersHtml = headers.map(h => `<th>${escapeHtml(h)}</th>`).join('');
        $('#import-headers').html(`<tr>${headersHtml}</tr>`);

        const dataHtml = data.slice(0, 10).map(row => {
            const cells = headers.map(h => `<td>${escapeHtml(row[h] || '')}</td>`).join('');
            return `<tr>${cells}</tr>`;
        }).join('');
        $('#import-data').html(dataHtml);

        $('#import-count').text(data.length);
        $('#import-preview').show();
        $('#start-import').prop('disabled', false);

        // Store data for import
        window.importData = data;
    }

    async function startImport() {
        if (!window.importData || window.importData.length === 0) {
            alert('No data to import');
            return;
        }

        const data = window.importData;
        let imported = 0;
        let errors = 0;

        $('#start-import').prop('disabled', true).text('Importing...');

        for (const row of data) {
            try {
                const playerData = {
                    player_name: row.player_name || row.name || row.Player || '',
                    steam_id: row.steam_id || row.steamid || row.Steam || '',
                    discord_id: row.discord_id || row.discordid || row.Discord || '',
                    is_active: true
                };

                if (playerData.player_name) {
                    await JotunAPI.addPlayer(playerData);
                    imported++;
                }
            } catch (error) {
                console.error('Error importing player:', row, error);
                errors++;
            }
        }

        JotunAPI.handleSuccess(`Import completed: ${imported} players imported, ${errors} errors`);
        closeImportModal();
        loadPlayers();
        loadPlayerStats();
    }

    async function exportPlayers() {
        try {
            const result = await JotunAPI.getPlayers({ limit: 1000 });
            const players = result.data || [];

            if (players.length === 0) {
                alert('No players to export');
                return;
            }

            const csv = playersToCSV(players);
            downloadCSV(csv, 'jotunheim_players.csv');
            JotunAPI.handleSuccess(`Exported ${players.length} players`);
        } catch (error) {
            JotunAPI.handleError(error, 'Export players');
        }
    }

    function playersToCSV(players) {
        const headers = ['Player Name', 'Steam ID', 'Discord ID', 'Registration Date', 'Status'];
        const csvContent = [
            headers.join(','),
            ...players.map(p => [
                `"${p.player_name}"`,
                `"${p.steam_id || ''}"`,
                `"${p.discord_id || ''}"`,
                `"${p.registration_date}"`,
                `"${p.is_active ? 'Active' : 'Inactive'}"`
            ].join(','))
        ].join('\n');

        return csvContent;
    }

    function downloadCSV(csv, filename) {
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
    }

    async function applyBulkAction() {
        const action = $('#bulk-action-select').val();
        if (!action || selectedPlayers.size === 0) {
            alert('Please select an action and at least one player');
            return;
        }

        const playerIds = Array.from(selectedPlayers);
        const playerCount = playerIds.length;

        if (!confirm(`Are you sure you want to ${action} ${playerCount} selected player(s)?`)) {
            return;
        }

        try {
            $('#apply-bulk-action').prop('disabled', true).text('Processing...');

            let successCount = 0;
            let errorCount = 0;

            for (const playerId of playerIds) {
                try {
                    switch (action) {
                        case 'activate':
                            await JotunAPI.updatePlayer(playerId, { is_active: true });
                            successCount++;
                            break;
                        case 'deactivate':
                            await JotunAPI.updatePlayer(playerId, { is_active: false });
                            successCount++;
                            break;
                        case 'delete':
                            await JotunAPI.deletePlayer(playerId);
                            successCount++;
                            break;
                        case 'export':
                            // Export functionality would go here
                            successCount++;
                            break;
                    }
                } catch (error) {
                    console.error('Bulk action error:', error);
                    errorCount++;
                }
            }

            JotunAPI.handleSuccess(`Bulk action completed: ${successCount} successful, ${errorCount} errors`);
            
            // Clear selection and reload
            selectedPlayers.clear();
            $('.player-checkbox').prop('checked', false);
            $('#select-all-players').prop('checked', false);
            $('#bulk-actions').hide();
            loadPlayers();
            loadPlayerStats();

        } catch (error) {
            JotunAPI.handleError(error, 'Bulk action');
        } finally {
            $('#apply-bulk-action').prop('disabled', false).text('Apply');
        }
    }

    function showLoading() {
        $('#players-table-body').html(`
            <tr class="loading-row">
                <td colspan="7" class="loading-cell">
                    <div class="loading-spinner">
                        <span class="dashicons dashicons-update spin"></span>
                        Loading players...
                    </div>
                </td>
            </tr>
        `);
    }

    function showError(message) {
        $('#players-table-body').html(`
            <tr class="error-row">
                <td colspan="7" style="text-align: center; padding: 40px; color: #d63638;">
                    <span class="dashicons dashicons-warning" style="font-size: 48px; margin-bottom: 10px; display: block;"></span>
                    ${escapeHtml(message)}
                </td>
            </tr>
        `);
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
});