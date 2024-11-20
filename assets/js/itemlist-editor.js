$('#load-item-btn').click(function () {
    const selectedItems = [];
    $('.item-checkbox:checked').each(function () {
        selectedItems.push($(this).data('id'));  // Use data-id for each item
    });

    if (selectedItems.length > 0) {
        $('#edit-sections-container').empty();  // Clear previous edit sections
        selectedItems.forEach(function (item_id) {
            $.post(ajaxurl, {
                action: 'fetch_item_details',
                item_id: item_id  // Send item_id to the server
            }, function (response) {
                console.log(response);  // Check if response is correct
                if (response.success) {
                    const item = response.data;
                    const editSection = `
                        <div class="single-edit-section" style="margin-bottom: 40px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background: rgba(255, 255, 255, 0.8);">
                            <h4 style="font-family: 'Roboto', sans-serif; font-weight: 700; color: #444;">Editing: ${item.item_name}</h4>
                            <form class="item-details-form" data-item-id="${item.id}" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; align-items: center;">
                                <!-- Item fields -->
                                <label for="item-name">Item Name:</label>
                                <input type="text" class="item-name" value="${item.item_name}">
                                
                                <label for="tech-name">Tech Name:</label>
                                <input type="text" class="tech-name" value="${item.tech_name}">
                                
                                <label for="item-type">Item Type:</label>
                                <input type="text" class="item-type" value="${item.item_type}">
                                
                                <label for="stack-size">Stack Size:</label>
                                <input type="number" class="stack-size" value="${item.stack_size}">
                                
                                <label for="undercut">Can be Undercut:</label>
                                <input type="checkbox" class="undercut" ${item.undercut == '1' ? 'checked' : ''}>
                                
                                <label for="unit-price">Unit Price:</label>
                                <input type="number" step="0.01" class="unit-price" value="${item.unit_price}">
                                
                                <label for="lv2-price">Lv 2 Price:</label>
                                <input type="number" step="0.01" class="lv2-price" value="${item.lv2_price}">
                                
                                <label for="lv3-price">Lv 3 Price:</label>
                                <input type="number" step="0.01" class="lv3-price" value="${item.lv3_price}">
                                
                                <label for="lv4-price">Lv 4 Price:</label>
                                <input type="number" step="0.01" class="lv4-price" value="${item.lv4_price}">
                                
                                <label for="lv5-price">Lv 5 Price:</label>
                                <input type="number" step="0.01" class="lv5-price" value="${item.lv5_price}">
                                
                                <label for="prefab-name">Prefab Name:</label>
                                <input type="text" class="prefab-name" value="${item.prefab_name}">
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