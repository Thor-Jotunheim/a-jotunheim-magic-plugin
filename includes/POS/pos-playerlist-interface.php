<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Player List Management Interface
 * Provides a comprehensive interface for managing the jotun_playerlist table
 */

function jotun_playerlist_interface() {
    // Enqueue scripts and styles
    wp_enqueue_script('jotun-comprehensive-api', plugin_dir_url(__FILE__) . '../../assets/js/jotun-comprehensive-api.js', ['jquery'], '1.0.0', true);
    wp_enqueue_script('jotun-playerlist-interface', plugin_dir_url(__FILE__) . '../../assets/js/playerlist-interface.js', ['jquery', 'jotun-comprehensive-api'], '1.0.0', true);
    wp_enqueue_style('jotun-admin-styles', plugin_dir_url(__FILE__) . '../../assets/css/jotun-admin.css', [], '1.0.0');
    
    // Localize script for AJAX
    wp_localize_script('jotun-comprehensive-api', 'jotun_api_vars', [
        'nonce' => wp_create_nonce('wp_rest'),
        'rest_url' => rest_url('jotun-api/v1/')
    ]);
    ?>

    <div class="wrap jotun-admin-wrap">
        <h1 class="jotun-admin-title">
            <span class="dashicons dashicons-groups"></span>
            Player List Management
        </h1>
        
        <div class="jotun-admin-description">
            <p>Manage all registered players who can purchase items from shops. This replaces the Google Sheets system.</p>
        </div>

        <!-- Player Statistics -->
        <div class="jotun-stats-container">
            <div class="jotun-stat-card">
                <div class="stat-icon">
                    <span class="dashicons dashicons-admin-users"></span>
                </div>
                <div class="stat-content">
                    <div class="stat-number" id="total-players">-</div>
                    <div class="stat-label">Total Players</div>
                </div>
            </div>
            <div class="jotun-stat-card">
                <div class="stat-icon">
                    <span class="dashicons dashicons-yes-alt"></span>
                </div>
                <div class="stat-content">
                    <div class="stat-number" id="active-players">-</div>
                    <div class="stat-label">Active Players</div>
                </div>
            </div>
            <div class="jotun-stat-card">
                <div class="stat-icon">
                    <span class="dashicons dashicons-calendar-alt"></span>
                </div>
                <div class="stat-content">
                    <div class="stat-number" id="recent-registrations">-</div>
                    <div class="stat-label">Recent (7 days)</div>
                </div>
            </div>
        </div>

        <!-- Controls Section -->
        <div class="jotun-controls-section">
            <div class="jotun-controls-left">
                <button type="button" class="button button-primary" id="add-player-btn">
                    <span class="dashicons dashicons-plus-alt"></span>
                    Add New Player
                </button>
                <button type="button" class="button" id="import-players-btn">
                    <span class="dashicons dashicons-upload"></span>
                    Import from File
                </button>
                <button type="button" class="button" id="export-players-btn">
                    <span class="dashicons dashicons-download"></span>
                    Export Players
                </button>
            </div>
            <div class="jotun-controls-right">
                <div class="search-container">
                    <input type="text" id="player-search" placeholder="Search players..." class="search-input">
                    <span class="dashicons dashicons-search search-icon"></span>
                </div>
                <select id="player-filter" class="filter-select">
                    <option value="">All Players</option>
                    <option value="active">Active Only</option>
                    <option value="inactive">Inactive Only</option>
                    <option value="recent">Recent (7 days)</option>
                </select>
            </div>
        </div>

        <!-- Player List Table -->
        <div class="jotun-table-container">
            <table class="wp-list-table widefat fixed striped jotun-data-table" id="players-table">
                <thead>
                    <tr>
                        <th scope="col" class="manage-column column-cb check-column">
                            <input type="checkbox" id="select-all-players">
                        </th>
                        <th scope="col" class="manage-column column-player-name sortable">
                            Current Name
                            <span class="sorting-indicator"></span>
                        </th>
                        <th scope="col" class="manage-column column-original-name sortable">
                            Original Name
                            <span class="sorting-indicator"></span>
                        </th>
                        <th scope="col" class="manage-column column-steam-id">Steam ID</th>
                        <th scope="col" class="manage-column column-discord-id">Discord ID</th>
                        <th scope="col" class="manage-column column-registration-date sortable">
                            Registration Date
                            <span class="sorting-indicator"></span>
                        </th>
                        <th scope="col" class="manage-column column-rename-count sortable">
                            Renames
                            <span class="sorting-indicator"></span>
                        </th>
                        <th scope="col" class="manage-column column-status">Status</th>
                        <th scope="col" class="manage-column column-actions">Actions</th>
                    </tr>
                </thead>
                <tbody id="players-table-body">
                    <tr class="loading-row">
                        <td colspan="9" class="loading-cell">
                            <div class="loading-spinner">
                                <span class="dashicons dashicons-update spin"></span>
                                Loading players...
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="jotun-pagination">
            <div class="pagination-info">
                Showing <span id="pagination-start">0</span>-<span id="pagination-end">0</span> of <span id="pagination-total">0</span> players
            </div>
            <div class="pagination-controls">
                <button type="button" class="button" id="prev-page" disabled>
                    <span class="dashicons dashicons-arrow-left-alt2"></span>
                    Previous
                </button>
                <span id="pagination-numbers"></span>
                <button type="button" class="button" id="next-page" disabled>
                    Next
                    <span class="dashicons dashicons-arrow-right-alt2"></span>
                </button>
            </div>
        </div>

        <!-- Bulk Actions -->
        <div class="jotun-bulk-actions" id="bulk-actions" style="display: none;">
            <div class="bulk-actions-container">
                <select id="bulk-action-select">
                    <option value="">Select Action...</option>
                    <option value="activate">Activate Selected</option>
                    <option value="deactivate">Deactivate Selected</option>
                    <option value="delete">Delete Selected</option>
                    <option value="export">Export Selected</option>
                </select>
                <button type="button" class="button" id="apply-bulk-action">Apply</button>
                <button type="button" class="button" id="cancel-bulk-action">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Add/Edit Player Modal -->
    <div id="player-modal" class="jotun-modal" style="display: none;">
        <div class="jotun-modal-content">
            <div class="jotun-modal-header">
                <h2 id="modal-title">Add New Player</h2>
                <button type="button" class="jotun-modal-close" id="close-modal">
                    <span class="dashicons dashicons-no-alt"></span>
                </button>
            </div>
            <div class="jotun-modal-body">
                <form id="player-form">
                    <input type="hidden" id="player-id" name="player_id">
                    
                    <div class="form-group">
                        <label for="player-name">Player Name <span class="required">*</span></label>
                        <input type="text" id="player-name" name="player_name" required class="form-control">
                        <small class="form-text">The in-game name of the player</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="steam-id">Steam ID</label>
                        <input type="text" id="steam-id" name="steam_id" class="form-control">
                        <small class="form-text">Player's Steam ID (optional)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="discord-id">Discord ID</label>
                        <input type="text" id="discord-id" name="discord_id" class="form-control">
                        <small class="form-text">Player's Discord ID (optional)</small>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <input type="checkbox" id="is-active" name="is_active" checked>
                            Active Player
                        </label>
                        <small class="form-text">Inactive players cannot make purchases</small>
                    </div>
                </form>
            </div>
            <div class="jotun-modal-footer">
                <button type="button" class="button button-secondary" id="cancel-player">Cancel</button>
                <button type="button" class="button button-primary" id="save-player">
                    <span class="dashicons dashicons-saved"></span>
                    Save Player
                </button>
            </div>
        </div>
    </div>

    <!-- Import Players Modal -->
    <div id="import-modal" class="jotun-modal" style="display: none;">
        <div class="jotun-modal-content">
            <div class="jotun-modal-header">
                <h2>Import Players</h2>
                <button type="button" class="jotun-modal-close" id="close-import-modal">
                    <span class="dashicons dashicons-no-alt"></span>
                </button>
            </div>
            <div class="jotun-modal-body">
                <div class="import-section">
                    <h3>Upload File</h3>
                    <div class="file-upload-area" id="file-upload-area">
                        <div class="upload-content">
                            <span class="dashicons dashicons-cloud-upload upload-icon"></span>
                            <p>Drag and drop a CSV file here, or click to select</p>
                            <input type="file" id="import-file" accept=".csv,.txt" style="display: none;">
                            <button type="button" class="button" id="select-file">Select File</button>
                        </div>
                    </div>
                </div>
                
                <div class="import-section" id="import-preview" style="display: none;">
                    <h3>Preview</h3>
                    <div class="import-stats">
                        <span id="import-count">0</span> players ready to import
                    </div>
                    <div class="import-table-container">
                        <table class="import-preview-table">
                            <thead id="import-headers"></thead>
                            <tbody id="import-data"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="jotun-modal-footer">
                <button type="button" class="button button-secondary" id="cancel-import">Cancel</button>
                <button type="button" class="button button-primary" id="start-import" disabled>
                    <span class="dashicons dashicons-database-import"></span>
                    Import Players
                </button>
            </div>
        </div>
    </div>

    <!-- Rename Player Modal -->
    <div id="rename-modal" class="jotun-modal" style="display: none;">
        <div class="jotun-modal-content">
            <div class="jotun-modal-header">
                <h2>Rename Player</h2>
                <button type="button" class="jotun-modal-close" id="close-rename-modal">
                    <span class="dashicons dashicons-no-alt"></span>
                </button>
            </div>
            <div class="jotun-modal-body">
                <form id="rename-form">
                    <input type="hidden" id="rename-player-id">
                    
                    <div class="form-group">
                        <label for="current-name">Current Name</label>
                        <input type="text" id="current-name" readonly class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="new-name">New Name <span class="required">*</span></label>
                        <input type="text" id="new-name" required class="form-control">
                        <small class="form-text">Enter the new player name</small>
                    </div>
                    
                    <div id="rename-history" class="rename-history" style="display: none;">
                        <h4>Rename History</h4>
                        <ul id="rename-list"></ul>
                    </div>
                </form>
            </div>
            <div class="jotun-modal-footer">
                <button type="button" class="button button-secondary" id="cancel-rename">Cancel</button>
                <button type="button" class="button button-primary" id="save-rename">
                    <span class="dashicons dashicons-edit"></span>
                    Rename Player
                </button>
            </div>
        </div>
    </div>

    <style>
        .jotun-admin-wrap {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .jotun-admin-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #1d2327;
            margin-bottom: 10px;
        }

        .jotun-admin-description {
            margin-bottom: 30px;
            padding: 15px;
            background: #f0f6fc;
            border-left: 4px solid #0073aa;
            border-radius: 4px;
        }

        .jotun-stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .jotun-stat-card {
            background: white;
            border: 1px solid #c3c4c7;
            border-radius: 8px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            background: #0073aa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }

        .stat-number {
            font-size: 28px;
            font-weight: bold;
            color: #1d2327;
            line-height: 1;
        }

        .stat-label {
            font-size: 14px;
            color: #646970;
        }

        .jotun-controls-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .jotun-controls-left {
            display: flex;
            gap: 10px;
        }

        .jotun-controls-right {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .search-container {
            position: relative;
        }

        .search-input {
            padding: 8px 35px 8px 12px;
            border: 1px solid #8c8f94;
            border-radius: 4px;
            width: 250px;
        }

        .search-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #8c8f94;
        }

        .filter-select {
            padding: 8px 12px;
            border: 1px solid #8c8f94;
            border-radius: 4px;
            min-width: 150px;
        }

        .jotun-table-container {
            background: white;
            border: 1px solid #c3c4c7;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .jotun-data-table {
            margin: 0;
        }

        .jotun-data-table th {
            background: #f6f7f7;
            border-bottom: 1px solid #c3c4c7;
            font-weight: 600;
        }

        .jotun-data-table th.sortable {
            cursor: pointer;
            user-select: none;
        }

        .jotun-data-table th.sortable:hover {
            background: #f0f0f1;
        }

        .sorting-indicator {
            display: inline-block;
            margin-left: 5px;
            opacity: 0.3;
        }

        .sorting-indicator:after {
            content: '↕';
        }

        .jotun-data-table th.sorted-asc .sorting-indicator:after {
            content: '↑';
            opacity: 1;
        }

        .jotun-data-table th.sorted-desc .sorting-indicator:after {
            content: '↓';
            opacity: 1;
        }

        .loading-cell {
            text-align: center;
            padding: 40px;
            color: #646970;
        }

        .loading-spinner {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .jotun-pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            padding: 15px 0;
        }

        .pagination-info {
            color: #646970;
        }

        .pagination-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .jotun-bulk-actions {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            border: 1px solid #c3c4c7;
            border-radius: 4px;
            padding: 15px 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            z-index: 1000;
        }

        .bulk-actions-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Modal Styles */
        .jotun-modal {
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
        }

        .jotun-modal-content {
            background: white;
            border-radius: 8px;
            min-width: 500px;
            max-width: 90vw;
            max-height: 90vh;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }

        .jotun-modal-header {
            padding: 20px;
            border-bottom: 1px solid #c3c4c7;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f6f7f7;
        }

        .jotun-modal-header h2 {
            margin: 0;
            color: #1d2327;
        }

        .jotun-modal-close {
            background: none;
            border: none;
            color: #646970;
            cursor: pointer;
            padding: 5px;
            border-radius: 3px;
            font-size: 16px;
        }

        .jotun-modal-close:hover {
            background: #f0f0f1;
        }

        .jotun-modal-body {
            padding: 20px;
            max-height: 60vh;
            overflow-y: auto;
        }

        .jotun-modal-footer {
            padding: 20px;
            border-top: 1px solid #c3c4c7;
            background: #f6f7f7;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #1d2327;
        }

        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #8c8f94;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #0073aa;
            box-shadow: 0 0 0 1px #0073aa;
            outline: none;
        }

        .form-text {
            display: block;
            margin-top: 5px;
            color: #646970;
            font-size: 12px;
        }

        .required {
            color: #d63638;
        }

        /* Import specific styles */
        .file-upload-area {
            border: 2px dashed #c3c4c7;
            border-radius: 8px;
            padding: 40px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-upload-area:hover,
        .file-upload-area.drag-over {
            border-color: #0073aa;
            background: #f0f6fc;
        }

        .upload-icon {
            font-size: 48px;
            color: #c3c4c7;
            margin-bottom: 15px;
            display: block;
        }

        .import-section {
            margin-bottom: 30px;
        }

        .import-section h3 {
            margin-bottom: 15px;
            color: #1d2327;
        }

        .import-stats {
            background: #f0f6fc;
            border: 1px solid #0073aa;
            border-radius: 4px;
            padding: 10px 15px;
            margin-bottom: 15px;
            color: #0073aa;
            font-weight: 600;
        }

        .import-table-container {
            max-height: 300px;
            overflow: auto;
            border: 1px solid #c3c4c7;
            border-radius: 4px;
        }

        .import-preview-table {
            width: 100%;
            border-collapse: collapse;
        }

        .import-preview-table th,
        .import-preview-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #f0f0f1;
            text-align: left;
        }

        .import-preview-table th {
            background: #f6f7f7;
            font-weight: 600;
        }

        /* Status badges */
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
        }

        .status-active {
            background: #00a32a;
            color: white;
        }

        .status-inactive {
            background: #dba617;
            color: white;
        }

        /* Action buttons */
        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .action-btn {
            padding: 4px 8px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }

        .action-btn.edit {
            background: #0073aa;
            color: white;
        }

        .action-btn.delete {
            background: #d63638;
            color: white;
        }

        .action-btn:hover {
            opacity: 0.8;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .jotun-admin-wrap {
                padding: 10px;
            }

            .jotun-controls-section {
                flex-direction: column;
                align-items: stretch;
            }

            .jotun-controls-left,
            .jotun-controls-right {
                justify-content: space-between;
                width: 100%;
            }

            .search-input {
                width: 100%;
            }

            .jotun-modal-content {
                min-width: 0;
                width: 95vw;
            }
        }
    </style>

    <?php
}