<?php
// itemlist-editor-interface.php

// Function to display the ItemList Editor interface
function itemlist_editor_interface() {
    ?>
    <div class="wrap itemlist-editor-container" id="itemlist-editor-container" style="width: 100%; max-width: 1000px; margin: auto; background: url('https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.bhmpics.com%2Fdownloads%2FValheim-Wallpapers%2F77.3-mistlands-teaser-1bb74b243f7219098476.jpg&f=1&nofb=1&ipt=45065e8b7cc5ca3ae8824364501250a2b5b4cf1428e93cd817bd8671ce697ec2&ipo=images') no-repeat fixed center; background-size: cover; filter: brightness(1); padding: 5px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); overflow: hidden; display: flex; gap: 20px; height: auto; min-height: calc(100vh - 50px);">
        <div style="flex: 1; background: rgba(255, 255, 255, 0.8); padding: 10px; border-radius: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);">
            <h1 class="itemlist-title" style="font-family: 'MedievalSharp', cursive; font-size: 36px; color: #fff; text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7); text-align: center;">Jotunheim ItemList Editor</h1>
            <div class="search-section" style="margin-bottom: 5px;">
                <input type="text" id="itemlist-search" placeholder="Search for an item..." style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666; margin-bottom: 10px; font-size: 16px;">
                <div id="itemlist-container" style="max-height: calc(100vh - 700px); overflow-y: auto; background: rgba(255, 255, 255, 0.9); padding: 10px; border-radius: 5px;">
                    <!-- Dynamically added checkboxes -->
                </div>
                <button id="load-item-btn" style="width: 100%; background: #444; color: #fff; padding: 12px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; margin-top: 10px;">Load Selected Items</button>
        <button id="clear-selected-items-btn" style="width: 100%; background: #888; color: #fff; padding: 12px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; margin-top: 10px;">Clear Selected Items</button>
            </div>
        </div>
        <div style="flex: 2; overflow-y: auto; max-height: calc(100vh - 50px);">
            <div id="edit-sections-container" class="edit-section" style="background: rgba(255, 255, 255, 0.7); padding: 10px; border-radius: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);">
                <h3 style="font-family: 'Roboto', sans-serif; font-weight: 700; color: #222; text-align: center;">Edit Item Details</h3>
                <!-- Edit sections will be dynamically added here -->
            </div>
<div id="actions-container" style="display: none;">
    <button id="save-item-btn" style="width: 100%; background: #8B0000; color: #fff; padding: 15px; border: none; border-radius: 5px; font-size: 18px; font-weight: bold; cursor: pointer; margin-top: 20px;">Save Changes</button>

    <button id="delete-item-btn" style="width: 100%; background: #d9534f; color: #fff; padding: 15px; border: none; border-radius: 5px; font-size: 18px; font-weight: bold; cursor: pointer; margin-top: 20px;">Delete Records</button>

    <div style="margin: 15px auto 0; background: rgba(255, 255, 255, 0.8); padding: 10px; border-radius: 5px; max-width: 300px; text-align: center;">
        <input type="checkbox" id="confirm-delete-checkbox" style="margin-right: 10px; transform: scale(1.2); cursor: pointer;">
        <label for="confirm-delete-checkbox" style="font-weight: bold;">Confirm Delete</label>
    </div>
</div>



        </div>
    </div>

    <script type="text/javascript">
    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
        jQuery(document).ready(function ($) {
            // Adjust container height to ensure the load button is visible
            function adjustContainerHeight() {
                const windowHeight = $(window).height();
                const containerHeight = windowHeight - $('#itemlist-editor-container').offset().top - 20;
                $('#itemlist-editor-container').css('min-height', containerHeight + 'px');
                $('#itemlist-container').css('max-height', containerHeight - 500 + 'px');
            }
            
            adjustContainerHeight();
            $(window).resize(function () {
                adjustContainerHeight();
            });

            // Function to refresh the item list
            function refreshItemList() {
                $.post(ajaxurl, {
                    action: 'fetch_all_items'
                }, function (response) {
                    if (response.success) {
                        $('#itemlist-container').empty();
                        response.data.forEach(function (item) {
                            // Ensure data-id is set correctly for each checkbox
                            const checkbox = `<div><label style="display: flex; align-items: center;"><input type="checkbox" class="item-checkbox" data-id="${item.id}" value="${item.item_name}" style="margin-right: 10px; transform: scale(1.8); cursor: pointer;">${item.item_name}</label></div>`;

                            $('#itemlist-container').append(checkbox);
                        });
                    }
                });
            }

            // Fetch the item list initially
            refreshItemList();

            // Search for items
            $('#itemlist-search').on('input', function () {
                const searchValue = $(this).val();
                if (searchValue.length >= 2) {
                    $.post(ajaxurl, {
                        action: 'search_items',
                        search_value: searchValue
                    }, function (response) {
                        if (response.success) {
                            $('#itemlist-container').empty();
                            response.data.forEach(function (item) {
                                // Correctly set the data-id in search results
                                const checkbox = `<div><label style="display: flex; align-items: center;"><input type="checkbox" class="item-checkbox" data-id="${item.id}" value="${item.item_name}" style="margin-right: 10px; transform: scale(1.8); cursor: pointer;">${item.item_name}</label></div>`;
                                $('#itemlist-container').append(checkbox);
                            });
                        } else {
                            $('#itemlist-container').empty(); // Clear container if no results
                        }
                    });
                } else {
                    refreshItemList(); // Reset dropdown if search is less than 2 characters
                }
            });
// Clear selected items functionality
$('#clear-selected-items-btn').click(function () {
    $('.item-checkbox:checked').prop('checked', false);
});

// Load selected items and show action buttons
$('#load-item-btn').click(function () {
    const selectedItems = [];
    $('.item-checkbox:checked').each(function () {
        selectedItems.push($(this).data('id'));  // Use data-id (item_id) instead of item_name
    });

    if (selectedItems.length > 0) {
        $('#edit-sections-container').empty();
        $('#actions-container').show(); // Show save and delete actions

        selectedItems.forEach(function (item_id) {
            $.post(ajaxurl, {
                action: 'fetch_item_details',
                item_id: item_id  // Correctly send item_id to the backend
            }, function (response) {
                if (response.success) {
                    const item = response.data;
                    const editSection = `
                        <div class="single-edit-section" style="margin-bottom: 40px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background: rgba(255, 255, 255, 0.8);">
                            <h4 style="font-family: 'Roboto', sans-serif; font-weight: 700; color: #444;">Editing: ${item.item_name}</h4>
                            <form class="item-details-form" data-item-id="${item.id}" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; align-items: center;">
                                <label for="item-name-${item.id}" style="font-weight: bold;">Item Name:</label>
                                <input type="text" id="item-name-${item.id}" name="item_name" class="item-name" value="${item.item_name || ''}" style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666;">

                                <label for="tech-name-${item.id}" style="font-weight: bold;">Tech Name:</label>
                                <select id="tech-name-${item.id}" name="tech_name" class="tech-name" style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666;">
                                    <option value="N/A" ${item.tech_name === 'N/A' ? 'selected' : ''}>N/A</option>
                                    <option value="Meadow" ${item.tech_name === 'Meadow' ? 'selected' : ''}>Meadow</option>
                                    <option value="Forest" ${item.tech_name === 'Forest' ? 'selected' : ''}>Forest</option>
                                    <option value="Ocean" ${item.tech_name === 'Ocean' ? 'selected' : ''}>Ocean</option>
                                    <option value="Swamp" ${item.tech_name === 'Swamp' ? 'selected' : ''}>Swamp</option>
                                    <option value="Mountain" ${item.tech_name === 'Mountain' ? 'selected' : ''}>Mountain</option>
                                    <option value="Plains" ${item.tech_name === 'Plains' ? 'selected' : ''}>Plains</option>
                                    <option value="Mistlands" ${item.tech_name === 'Mistlands' ? 'selected' : ''}>Mistlands</option>
                                    <option value="Ashlands" ${item.tech_name === 'Ashlands' ? 'selected' : ''}>Ashlands</option>
                                    <option value="Deep North" ${item.tech_name === 'Deep North' ? 'selected' : ''}>Deep North</option>
                                </select>

                                <label for="item-type-${item.id}" style="font-weight: bold;">Item Type:</label>
                                <select id="item-type-${item.id}" name="item_type" class="item-type" style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666;">
                                    <option value="Currency" ${item.item_type === 'Currency' ? 'selected' : ''}>Currency</option>
                                    <option value="Untradable" ${item.item_type === 'Untradable' ? 'selected' : ''}>Untradable</option>
                                    <option value="Raw Food" ${item.item_type === 'Raw Food' ? 'selected' : ''}>Raw Food</option>
                                    <option value="Cooked Food" ${item.item_type === 'Cooked Food' ? 'selected' : ''}>Cooked Food</option>
                                    <option value="Fish" ${item.item_type === 'Fish' ? 'selected' : ''}>Fish</option>
                                    <option value="Seeds" ${item.item_type === 'Seeds' ? 'selected' : ''}>Seeds</option>
                                    <option value="Bait" ${item.item_type === 'Bait' ? 'selected' : ''}>Bait</option>
                                    <option value="Mead" ${item.item_type === 'Mead' ? 'selected' : ''}>Mead</option>
                                    <option value="Building & Crafting" ${item.item_type === 'Building & Crafting' ? 'selected' : ''}>Building & Crafting</option>
                                    <option value="Boss Summons" ${item.item_type === 'Boss Summons' ? 'selected' : ''}>Boss Summons</option>
                                    <option value="Tamed Animals" ${item.item_type === 'Tamed Animals' ? 'selected' : ''}>Tamed Animals</option>
                                    <option value="Armor Sets" ${item.item_type === 'Armor Sets' ? 'selected' : ''}>Armor Sets</option>
                                    <option value="Armor" ${item.item_type === 'Armor' ? 'selected' : ''}>Armor</option>
                                    <option value="Ammunition" ${item.item_type === 'Ammunition' ? 'selected' : ''}>Ammunition</option>
                                    <option value="Weapons" ${item.item_type === 'Weapons' ? 'selected' : ''}>Weapons</option>
                                    <option value="Tools" ${item.item_type === 'Tools' ? 'selected' : ''}>Tools</option>
                                    <option value="Shields" ${item.item_type === 'Shields' ? 'selected' : ''}>Shields</option>
                                    <option value="Trophies" ${item.item_type === 'Trophies' ? 'selected' : ''}>Trophies</option>
                                    <option value="Crafting Components" ${item.item_type === 'Crafting Components' ? 'selected' : ''}>Crafting Components</option>
                                </select>

                                <label for="stack-size-${item.id}" style="font-weight: bold;">Stack Size:</label>
                                <input type="number" id="stack-size-${item.id}" name="stack_size" class="stack-size" value="${item.stack_size || 0}" style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666;">

                                <label for="undercut-${item.id}" style="font-weight: bold;">Can Be Undercut:</label>
                               <input type="checkbox" id="undercut-${item.id}" name="undercut" class="undercut" ${item.undercut == '1' ? 'checked' : ''} style="transform: scale(1.8); margin-top: 5px;">


                                <label for="unit-price-${item.id}" style="font-weight: bold;">Unit Price:</label>
                                <input type="number" step="0.01" id="unit-price-${item.id}" name="unit_price" class="unit-price" value="${item.unit_price || 0}" style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666;">

                                <label for="lv2-price-${item.id}" style="font-weight: bold;">Lv 2 Price:</label>
                                <input type="number" step="0.01" id="lv2-price-${item.id}" name="lv2_price" class="lv2-price" value="${item.lv2_price || 0}" style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666;">

                                <label for="lv3-price-${item.id}" style="font-weight: bold;">Lv 3 Price:</label>
                                <input type="number" step="0.01" id="lv3-price-${item.id}" name="lv3_price" class="lv3-price" value="${item.lv3_price || 0}" style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666;">

                                <label for="lv4-price-${item.id}" style="font-weight: bold;">Lv 4 Price:</label>
                                <input type="number" step="0.01" id="lv4-price-${item.id}" name="lv4_price" class="lv4-price" value="${item.lv4_price || 0}" style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666;">

                                <label for="lv5-price-${item.id}" style="font-weight: bold;">Lv 5 Price:</label>
                                <input type="number" step="0.01" id="lv5-price-${item.id}" name="lv5_price" class="lv5-price" value="${item.lv5_price || 0}" style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666;">

                                <label for="prefab-name-${item.id}" style="font-weight: bold;">Prefab Name:</label>
                                <input type="text" id="prefab-name-${item.id}" name="prefab_name" class="prefab-name" value="${item.prefab_name || ''}" style="width: 100%; padding: 10px; border-radius: 5px; border: 2px solid #666;">
                            </form>
                        </div>
                    `;
                    $('#edit-sections-container').append(editSection);
                } else {
                    alert('Item not found.');
                }
            });
        });
    } else {
        alert('Please select at least one item.');
    }
});

// Hide save and delete buttons if no items are loaded
$('#clear-selected-items-btn').click(function () {
    $('#edit-sections-container').empty();
    $('#actions-container').hide();
});


            // Save item details and refresh the item list
            $('#save-item-btn').click(function () {
    const itemsData = [];

    $('.single-edit-section').each(function () {
        const formElement = $(this).find('.item-details-form');
        const itemData = {
            id: formElement.data('item-id'),
            item_name: formElement.find('.item-name').val(),
            tech_name: formElement.find('.tech-name').val(),
            item_type: formElement.find('.item-type').val(),
            stack_size: formElement.find('.stack-size').val(),
            undercut: formElement.find('.undercut').is(':checked') ? 1 : 0,
            unit_price: formElement.find('.unit-price').val(),
            lv2_price: formElement.find('.lv2-price').val(),
            lv3_price: formElement.find('.lv3-price').val(),
            lv4_price: formElement.find('.lv4-price').val(),
            lv5_price: formElement.find('.lv5-price').val(),
            prefab_name: formElement.find('.prefab-name').val()
        };
        itemsData.push(itemData);
    });

    $.post(ajaxurl, {
        action: 'save_item_details',
        items_data: itemsData
    }, function (response) {
        if (response.success) {
            alert('Item details saved successfully.');
            refreshItemList(); // Refresh the item list after saving
        } else {
            alert('Failed to save item details.');
        }
    });
});

        // Disable delete button initially
$('#delete-item-btn').prop('disabled', true);

// Enable or disable delete button based on confirm delete checkbox state
$('#confirm-delete-checkbox').change(function () {
    if ($(this).is(':checked')) {
        $('#delete-item-btn').prop('disabled', false);
    } else {
        $('#delete-item-btn').prop('disabled', true);
    }
});

// Handle delete button click
$('#delete-item-btn').click(function () {
    if (!$('#confirm-delete-checkbox').is(':checked')) {
        alert('Must check Confirm Delete box');
        return;
    }

    // Show confirmation popup before deleting
    if (confirm('Are you sure you want to delete the selected items?')) {
        const selectedItems = [];
        $('.item-checkbox:checked').each(function () {
            selectedItems.push($(this).data('id'));  // Get item IDs to delete
        });

        // Delete each selected item
        selectedItems.forEach(function (item_id) {
            $.post(ajaxurl, {
                action: 'delete_item_details',
                item_id: item_id
            }, function (response) {
                if (response.success) {
                    alert('Item deleted successfully.');
                    refreshItemList(); // Refresh the item list after deleting
                } else {
                    alert('Failed to delete item.');
                }
            });
        });

        // Hide actions container after deletion
        $('#actions-container').hide();
        $('#edit-sections-container').empty();
    }
});

    

        });
    </script>
    <?php
}
?>