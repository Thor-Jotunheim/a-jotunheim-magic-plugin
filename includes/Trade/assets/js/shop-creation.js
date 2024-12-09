jQuery(document).ready(function ($) {
    const shopFormHTML = `
        <form id="shop-creation-form">
            <label for="shop-name">Shop Name:</label>
            <input type="text" id="shop-name" name="shop_name" required />

            <label for="shop-description">Description:</label>
            <textarea id="shop-description" name="shop_description"></textarea>

            <label for="shop-items">Items:</label>
            <div id="shop-items">
                <p>Loading items...</p>
            </div>

            <button type="submit">Create Shop</button>
        </form>
        <div id="shop-feedback"></div>
    `;

    $("#shop-creation-ui").html(shopFormHTML);

    // Fetch items for selection
    function fetchItems() {
        $.ajax({
            url: jotunShopData.ajax_url,
            method: "GET",
            data: {
                action: "jotun_fetch_items",
                nonce: jotunShopData.api_nonce,
            },
            success: function (response) {
                if (response.success) {
                    const itemsHTML = response.data.items
                        .map(item => `
                            <div>
                                <input type="checkbox" name="items[]" value="${item.id}" />
                                ${item.name} - ${item.price} credits
                            </div>
                        `)
                        .join("");
                    $("#shop-items").html(itemsHTML);
                } else {
                    $("#shop-items").html(`<p>Error loading items: ${response.data.message}</p>`);
                }
            },
        });
    }
    fetchItems();

    // Submit shop creation form
    $("#shop-creation-form").on("submit", function (e) {
        e.preventDefault();

        const formData = $(this).serialize();
        $.ajax({
            url: jotunShopData.ajax_url,
            method: "POST",
            data: {
                action: "jotun_create_shop_with_items",
                nonce: jotunShopData.api_nonce,
                form_data: formData,
            },
            success: function (response) {
                if (response.success) {
                    $("#shop-feedback").html(`<p>Shop created successfully!</p>`);
                    $("#shop-creation-form")[0].reset();
                } else {
                    $("#shop-feedback").html(`<p>Error: ${response.data.message}</p>`);
                }
            },
        });
    });
});
