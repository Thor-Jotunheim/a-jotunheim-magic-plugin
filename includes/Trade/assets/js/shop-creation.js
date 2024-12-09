import { fetchItems, populateItemList } from './trade-barter-utils.js';

document.addEventListener("DOMContentLoaded", () => {
    const shopCreationUI = document.getElementById("shop-creation-ui");

    // Render the shop creation form
    shopCreationUI.innerHTML = `
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

    // Fetch items and populate the accordion
    fetchItems()
        .then(() => {
            populateItemList("item-list-accordion", itemsData, "", addSelectedItemToForm);
        })
        .catch((error) => {
            console.error("Error fetching items:", error);
            document.getElementById("item-list-accordion").innerHTML = `<p>Failed to load items.</p>`;
        });

    // Add selected items to the form
    function addSelectedItemToForm(item) {
        const selectedItemsContainer = document.getElementById("selected-items-container");
        selectedItemsContainer.innerHTML += `
            <div>
                <input type="checkbox" name="items[]" value="${item.id}" />
                ${item.name} - ${item.price} credits
            </div>
        `;
    }

    // Handle form submission
    document.getElementById("shop-creation-form").addEventListener("submit", (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);

        fetch(jotunShopData.ajax_url, {
            method: "POST",
            body: JSON.stringify({
                action: "jotun_create_shop_with_items",
                nonce: jotunShopData.api_nonce,
                form_data: Object.fromEntries(formData.entries()),
            }),
            headers: {
                "Content-Type": "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    document.getElementById("shop-feedback").innerHTML = `<p>Shop created successfully!</p>`;
                    e.target.reset();
                } else {
                    document.getElementById("shop-feedback").innerHTML = `<p>Error: ${data.message}</p>`;
                }
            })
            .catch((error) => {
                console.error("Error creating shop:", error);
                document.getElementById("shop-feedback").innerHTML = `<p>Failed to create shop.</p>`;
            });
    });
});
