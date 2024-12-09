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

                <div class="item-list-sidebar-container">
                    <input type="text" id="item-search" class="search-bar" placeholder="Search items..." />
                    <div id="item-list-accordion" class="item-list-sidebar">
                        <!-- Accordion content populated dynamically -->
                    </div>
                </div>

                <button type="submit" class="barter-button">Create Shop</button>
            </form>
            <div id="shop-feedback"></div>
        </div>
    `;

    $("#shop-creation-ui").html(shopFormHTML);

    // Fetch and populate items in the accordion
    function fetchItemsForAccordion() {
        $.ajax({
            url: jotunShopData.ajax_url,
            method: "GET",
            data: {
                action: "jotun_fetch_items",
                nonce: jotunShopData.api_nonce,
            },
            success: function (response) {
                if (response.success) {
                    populateItemList(response.data.items);
                } else {
                    $("#item-list-accordion").html(`<p>Error loading items: ${response.data.message}</p>`);
                }
            },
        });
    }

    function populateItemList(items) {
        const itemListHTML = items
            .map(item => `
                <div class="accordion-section">
                    <div class="accordion-header">${escapeHtml(item.name)} - ${item.price} credits</div>
                    <div class="accordion-content">
                        <label>
                            <input type="checkbox" name="items[]" value="${item.id}" />
                            Add to Shop
                        </label>
                    </div>
                </div>
            `)
            .join("");

        $("#item-list-accordion").html(itemListHTML);

        // Enable accordion behavior
        $(".accordion-header").on("click", function () {
            $(this).next(".accordion-content").toggleClass("active");
        });
    }

    // Initialize item fetch
    fetchItemsForAccordion();

    // Handle form submission
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
