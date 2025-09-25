<?php
// File: includes/ItemList/itemlist-item-types.php
// Item Type Management System

// Prevent direct access
if (!defined('ABSPATH')) exit;

class Jotunheim_Item_Types {
    private $table_name;
    
    public function __construct() {
        global $wpdb;
        $this->table_name = 'jotun_itemlist_item_type';
        
        // Hook into WordPress
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('wp_ajax_save_item_type', array($this, 'handle_save_item_type'));
        add_action('wp_ajax_delete_item_type', array($this, 'handle_delete_item_type'));
        add_action('wp_ajax_get_item_types', array($this, 'handle_get_item_types'));
        
        // Register REST API endpoints
        add_action('rest_api_init', array($this, 'register_rest_routes'));
        
        // Create table on activation
        add_action('init', array($this, 'maybe_create_table'));
    }
    
    public function maybe_create_table() {
        global $wpdb;
        
        $table_exists = $wpdb->get_var("SHOW TABLES LIKE '{$this->table_name}'");
        if (!$table_exists) {
            $this->create_table();
        }
    }
    
    public function create_table() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE {$this->table_name} (
            id int(11) NOT NULL AUTO_INCREMENT,
            type_name varchar(100) NOT NULL,
            description text,
            price_multiplier decimal(4,2) DEFAULT 1.00,
            sort_order int(11) DEFAULT 0,
            is_active tinyint(1) DEFAULT 1,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY type_name (type_name)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
        // Insert default item types
        $this->insert_default_types();
        
        error_log('Item types table created successfully');
    }
    
    private function insert_default_types() {
        global $wpdb;
        
        $default_types = [
            ['Currency', 'Game currency and coins', 1.00, 1],
            ['Untradable', 'Items that cannot be traded', 0.00, 2],
            ['Raw Food', 'Uncooked food items', 0.50, 3],
            ['Cooked Food', 'Prepared food items', 0.80, 4],
            ['Fish', 'Fish and fishing items', 0.60, 5],
            ['Seeds', 'Seeds for farming', 0.30, 6],
            ['Bait', 'Fishing bait', 0.40, 7],
            ['Mead', 'Mead and beverages', 1.20, 8],
            ['Building & Crafting', 'Building and crafting materials', 1.00, 9],
            ['Boss Summons', 'Items to summon bosses', 3.00, 10],
            ['Tamed Animals', 'Tamed creatures', 5.00, 11],
            ['Metals & Ores', 'Mining materials', 1.50, 12],
            ['Gems & Precious Items', 'Valuable gems and items', 2.00, 13],
            ['Tools', 'Tools and utilities', 2.00, 14],
            ['Weapons', 'Weapons and combat items', 3.00, 15],
            ['Armor', 'Armor and protection', 2.50, 16],
            ['Shields', 'Shields and defensive items', 2.00, 17],
            ['Arrows & Ammunition', 'Projectiles and ammunition', 0.80, 18],
            ['Trophies', 'Trophy items', 1.50, 19],
            ['Quest Items', 'Quest and special items', 1.00, 20],
            ['Aesir Spell', 'Magical spells and abilities', 4.00, 21]
        ];
        
        foreach ($default_types as $type) {
            $existing = $wpdb->get_var($wpdb->prepare(
                "SELECT id FROM {$this->table_name} WHERE type_name = %s", 
                $type[0]
            ));
            
            if (!$existing) {
                $wpdb->insert(
                    $this->table_name,
                    [
                        'type_name' => $type[0],
                        'description' => $type[1],
                        'price_multiplier' => $type[2],
                        'sort_order' => $type[3]
                    ]
                );
            }
        }
    }
    
    public function add_admin_menu() {
        add_submenu_page(
            'jotunheim-magic',
            'Item Types',
            'Item Types',
            'manage_options',
            'jotunheim-item-types',
            array($this, 'admin_page')
        );
    }
    
    public function admin_page() {
        ?>
        <div class="wrap">
            <h1>Item Type Management</h1>
            
            <div id="item-types-container">
                <div class="item-types-header">
                    <button id="add-new-type" class="button button-primary">Add New Item Type</button>
                </div>
                
                <table id="item-types-table" class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th>Type Name</th>
                            <th>Description</th>
                            <th>Price Multiplier</th>
                            <th>Sort Order</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="item-types-tbody">
                        <tr><td colspan="6">Loading...</td></tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Edit Modal -->
            <div id="item-type-modal" class="item-type-modal" style="display: none;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 id="modal-title">Add New Item Type</h3>
                        <span class="close" id="modal-close">&times;</span>
                    </div>
                    <div class="modal-body">
                        <form id="item-type-form">
                            <input type="hidden" id="type-id" name="id">
                            
                            <div class="form-group">
                                <label for="type-name">Type Name *</label>
                                <input type="text" id="type-name" name="type_name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" rows="3"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="price-multiplier">Price Multiplier</label>
                                <input type="number" id="price-multiplier" name="price_multiplier" step="0.01" min="0" value="1.00">
                                <small>Multiplier for suggested pricing (1.00 = normal, 2.00 = double price, etc.)</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="sort-order">Sort Order</label>
                                <input type="number" id="sort-order" name="sort_order" min="0" value="0">
                                <small>Lower numbers appear first in dropdown lists</small>
                            </div>
                            
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" id="is-active" name="is_active" checked>
                                    Active (appears in dropdown lists)
                                </label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="save-type" class="button button-primary">Save Item Type</button>
                        <button type="button" id="cancel-edit" class="button">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        
        <style>
        .item-types-header {
            margin: 20px 0;
        }
        
        .item-type-modal {
            position: fixed;
            z-index: 100000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            border: 1px solid #888;
            width: 90%;
            max-width: 600px;
            border-radius: 8px;
        }
        
        .modal-header {
            padding: 20px;
            background: #f1f1f1;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-header h3 {
            margin: 0;
        }
        
        .close {
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close:hover {
            color: #red;
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .form-group small {
            display: block;
            color: #666;
            margin-top: 5px;
        }
        
        .modal-footer {
            padding: 20px;
            background: #f1f1f1;
            border-top: 1px solid #ddd;
            text-align: right;
        }
        
        .modal-footer .button {
            margin-left: 10px;
        }
        
        .status-active { color: #008000; }
        .status-inactive { color: #999; }
        </style>
        
        <script>
        jQuery(document).ready(function($) {
            let itemTypes = [];
            
            // Load item types
            function loadItemTypes() {
                $.post(ajaxurl, {
                    action: 'get_item_types',
                    nonce: '<?php echo wp_create_nonce('item_types_nonce'); ?>'
                }, function(response) {
                    if (response.success) {
                        itemTypes = response.data;
                        renderTable();
                    }
                });
            }
            
            function renderTable() {
                const tbody = $('#item-types-tbody');
                tbody.empty();
                
                if (itemTypes.length === 0) {
                    tbody.append('<tr><td colspan="6">No item types found</td></tr>');
                    return;
                }
                
                itemTypes.forEach(type => {
                    const statusClass = type.is_active == 1 ? 'status-active' : 'status-inactive';
                    const statusText = type.is_active == 1 ? 'Active' : 'Inactive';
                    
                    tbody.append(`
                        <tr>
                            <td><strong>${type.type_name}</strong></td>
                            <td>${type.description || '-'}</td>
                            <td>${type.price_multiplier}x</td>
                            <td>${type.sort_order}</td>
                            <td><span class="${statusClass}">${statusText}</span></td>
                            <td>
                                <button class="button edit-type" data-id="${type.id}">Edit</button>
                                <button class="button delete-type" data-id="${type.id}" data-name="${type.type_name}">Delete</button>
                            </td>
                        </tr>
                    `);
                });
            }
            
            // Modal handling
            function openModal(type = null) {
                if (type) {
                    $('#modal-title').text('Edit Item Type');
                    $('#type-id').val(type.id);
                    $('#type-name').val(type.type_name);
                    $('#description').val(type.description);
                    $('#price-multiplier').val(type.price_multiplier);
                    $('#sort-order').val(type.sort_order);
                    $('#is-active').prop('checked', type.is_active == 1);
                } else {
                    $('#modal-title').text('Add New Item Type');
                    $('#item-type-form')[0].reset();
                    $('#type-id').val('');
                    $('#price-multiplier').val('1.00');
                    $('#is-active').prop('checked', true);
                }
                $('#item-type-modal').show();
            }
            
            function closeModal() {
                $('#item-type-modal').hide();
            }
            
            // Event handlers
            $('#add-new-type').click(() => openModal());
            $('#modal-close, #cancel-edit').click(closeModal);
            
            $(document).on('click', '.edit-type', function() {
                const id = $(this).data('id');
                const type = itemTypes.find(t => t.id == id);
                openModal(type);
            });
            
            $(document).on('click', '.delete-type', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                
                if (confirm(`Are you sure you want to delete the item type "${name}"?`)) {
                    $.post(ajaxurl, {
                        action: 'delete_item_type',
                        id: id,
                        nonce: '<?php echo wp_create_nonce('item_types_nonce'); ?>'
                    }, function(response) {
                        if (response.success) {
                            loadItemTypes();
                        } else {
                            alert('Error: ' + response.data);
                        }
                    });
                }
            });
            
            $('#save-type').click(function() {
                const formData = {
                    action: 'save_item_type',
                    nonce: '<?php echo wp_create_nonce('item_types_nonce'); ?>',
                    id: $('#type-id').val(),
                    type_name: $('#type-name').val(),
                    description: $('#description').val(),
                    price_multiplier: $('#price-multiplier').val(),
                    sort_order: $('#sort-order').val(),
                    is_active: $('#is-active').prop('checked') ? 1 : 0
                };
                
                $.post(ajaxurl, formData, function(response) {
                    if (response.success) {
                        closeModal();
                        loadItemTypes();
                    } else {
                        alert('Error: ' + response.data);
                    }
                });
            });
            
            // Load data on page load
            loadItemTypes();
        });
        </script>
        <?php
    }
    
    public function handle_get_item_types() {
        if (!wp_verify_nonce($_POST['nonce'], 'item_types_nonce')) {
            wp_send_json_error('Invalid nonce');
            return;
        }
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Insufficient permissions');
            return;
        }
        
        global $wpdb;
        
        $types = $wpdb->get_results(
            "SELECT * FROM {$this->table_name} ORDER BY sort_order ASC, type_name ASC",
            ARRAY_A
        );
        
        wp_send_json_success($types);
    }
    
    public function register_rest_routes() {
        register_rest_route('jotunheim/v1', '/itemlist-item-types/', array(
            'methods' => 'GET',
            'callback' => array($this, 'rest_get_item_types'),
            'permission_callback' => array($this, 'check_permissions')
        ));
        
        register_rest_route('jotunheim/v1', '/itemlist-item-types/', array(
            'methods' => 'POST',
            'callback' => array($this, 'rest_create_item_type'),
            'permission_callback' => array($this, 'check_permissions')
        ));
        
        register_rest_route('jotunheim/v1', '/itemlist-item-types/(?P<id>\d+)', array(
            'methods' => 'PUT',
            'callback' => array($this, 'rest_update_item_type'),
            'permission_callback' => array($this, 'check_permissions')
        ));
        
        register_rest_route('jotunheim/v1', '/itemlist-item-types/(?P<id>\d+)', array(
            'methods' => 'DELETE',
            'callback' => array($this, 'rest_delete_item_type'),
            'permission_callback' => array($this, 'check_permissions')
        ));
    }
    
    public function check_permissions() {
        return current_user_can('manage_options');
    }
    
    public function rest_get_item_types($request) {
        global $wpdb;
        
        $types = $wpdb->get_results(
            "SELECT * FROM {$this->table_name} WHERE is_active = 1 ORDER BY sort_order ASC, type_name ASC",
            ARRAY_A
        );
        
        return rest_ensure_response(array(
            'success' => true,
            'data' => $types,
            'timestamp' => current_time('mysql')
        ));
    }
    
    public function rest_create_item_type($request) {
        global $wpdb;
        
        $params = $request->get_json_params();
        
        if (empty($params['type_name'])) {
            return new WP_Error('missing_type_name', 'Type name is required', array('status' => 400));
        }
        
        $result = $wpdb->insert(
            $this->table_name,
            array(
                'type_name' => sanitize_text_field($params['type_name']),
                'description' => sanitize_textarea_field($params['description'] ?? ''),
                'price_multiplier' => floatval($params['price_multiplier'] ?? 1.0),
                'sort_order' => intval($params['sort_order'] ?? 0),
                'is_active' => intval($params['is_active'] ?? 1)
            )
        );
        
        if ($result === false) {
            return new WP_Error('insert_failed', 'Failed to create item type', array('status' => 500));
        }
        
        return rest_ensure_response(array(
            'success' => true,
            'data' => array('id' => $wpdb->insert_id),
            'timestamp' => current_time('mysql')
        ));
    }
    
    public function rest_update_item_type($request) {
        global $wpdb;
        
        $id = $request->get_param('id');
        $params = $request->get_json_params();
        
        $result = $wpdb->update(
            $this->table_name,
            array(
                'type_name' => sanitize_text_field($params['type_name']),
                'description' => sanitize_textarea_field($params['description'] ?? ''),
                'price_multiplier' => floatval($params['price_multiplier'] ?? 1.0),
                'sort_order' => intval($params['sort_order'] ?? 0),
                'is_active' => intval($params['is_active'] ?? 1)
            ),
            array('id' => $id)
        );
        
        if ($result === false) {
            return new WP_Error('update_failed', 'Failed to update item type', array('status' => 500));
        }
        
        return rest_ensure_response(array(
            'success' => true,
            'data' => array('affected_rows' => $result),
            'timestamp' => current_time('mysql')
        ));
    }
    
    public function rest_delete_item_type($request) {
        global $wpdb;
        
        $id = $request->get_param('id');
        
        $result = $wpdb->delete(
            $this->table_name,
            array('id' => $id)
        );
        
        if ($result === false) {
            return new WP_Error('delete_failed', 'Failed to delete item type', array('status' => 500));
        }
        
        return rest_ensure_response(array(
            'success' => true,
            'data' => array('affected_rows' => $result),
            'timestamp' => current_time('mysql')
        ));
    }
    
    public function handle_save_item_type() {
        if (!wp_verify_nonce($_POST['nonce'], 'item_types_nonce')) {
            wp_send_json_error('Invalid nonce');
            return;
        }
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Insufficient permissions');
            return;
        }
        
        global $wpdb;
        
        $data = [
            'type_name' => sanitize_text_field($_POST['type_name']),
            'description' => sanitize_textarea_field($_POST['description']),
            'price_multiplier' => floatval($_POST['price_multiplier']),
            'sort_order' => intval($_POST['sort_order']),
            'is_active' => intval($_POST['is_active'])
        ];
        
        if (empty($_POST['id'])) {
            // Insert new
            $result = $wpdb->insert($this->table_name, $data);
        } else {
            // Update existing
            $result = $wpdb->update(
                $this->table_name,
                $data,
                ['id' => intval($_POST['id'])]
            );
        }
        
        if ($result === false) {
            wp_send_json_error('Database error: ' . $wpdb->last_error);
            return;
        }
        
        wp_send_json_success('Item type saved successfully');
    }
    
    public function handle_delete_item_type() {
        if (!wp_verify_nonce($_POST['nonce'], 'item_types_nonce')) {
            wp_send_json_error('Invalid nonce');
            return;
        }
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Insufficient permissions');
            return;
        }
        
        global $wpdb;
        
        $result = $wpdb->delete(
            $this->table_name,
            ['id' => intval($_POST['id'])],
            ['%d']
        );
        
        if ($result === false) {
            wp_send_json_error('Database error: ' . $wpdb->last_error);
            return;
        }
        
        wp_send_json_success('Item type deleted successfully');
    }
    
    // Get item types for dropdowns (public method)
    public function get_active_types() {
        global $wpdb;
        
        return $wpdb->get_results(
            "SELECT * FROM {$this->table_name} WHERE is_active = 1 ORDER BY sort_order ASC, type_name ASC",
            ARRAY_A
        );
    }
}

// Initialize the class
new Jotunheim_Item_Types();

// Helper function for other parts of the plugin
function jotunheim_get_item_types() {
    global $wpdb;
    return $wpdb->get_results(
        "SELECT * FROM jotun_itemlist_item_type WHERE is_active = 1 ORDER BY sort_order ASC, type_name ASC",
        ARRAY_A
    );
}