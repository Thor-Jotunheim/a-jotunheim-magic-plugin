jQuery(document).ready(function ($) {
    const shopFormHTML = `
        <div class="barter-container">
            <form id="shop-creation-form">
                <div class="barter-header">
                    <h2>Create a New Shop</h2>
                </div>
                <label for="shop-name">Shop Name:</label>
                <input type="text" id="shop-name" name="shop_name" required />

                <label for="shop-description">Description:</label>
                <textarea id="shop-description" name="shop_description"></textarea>

                <div class="barter-items">
                    <h3>Select Items for Your Shop</h3>
                    <div id="shop-items" class="accordion">
                        <p>Loading items...</p>
                    </div>
                </div>

                <button type="submit" class="barter-button">Create Shop</button>
            </form>
            <div id="shop-feedback"></div>
        </div>
    `;

    $("#shop-creation-ui").html(shopFormHTML);

    // Fetch items and render as accordion
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
                            <div class="accordion-item">
                                <button class="accordion-button">${item.name} - ${item.price} credits</button>
                                <div class="accordion-content">
                                    <input type="checkbox" name="items[]" value="${item.id}" />
                                    <label for="item-${item.id}">Include this item</label>
                                </div>
                            </div>
                        `)
                        .join("");
                    $("#shop-items").html(itemsHTML);

                    // Activate accordion functionality
                    $(".accordion-button").on("click", function () {
                        const content = $(this).next(".accordion-content");
                        content.toggleClass("active");
                    });
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
