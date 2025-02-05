let itemsData = [];

// Fetch items from the API for dropdowns
async function fetchItems() {
    try {
        const response = await fetch('https://JOTUNHEIM_BASE_URL/wp-json/jotunheim-magic/v1/items');
        const data = await response.json();

        if (Array.isArray(data)) {
            itemsData = data;
            populateItemList();
        } else {
            console.error("Error fetching items:", data.message || "Unexpected data format");
        }
    } catch (error) {
        console.error("Error fetching items:", error);
    }
}

// Populate item list in accordion format
function populateItemList() {
    const itemListAccordion = document.getElementById('item-list-accordion');
    itemListAccordion.innerHTML = '';  // Clear existing content

    const categories = {};

    // Group items by category
    itemsData.forEach(item => {
        if (!categories[item.item_type]) {
            categories[item.item_type] = [];
        }
        categories[item.item_type].push(item);
    });

    // Create accordion sections
    Object.keys(categories).forEach(category => {
        const section = document.createElement('div');
        section.className = 'accordion-section';

        const header = document.createElement('div');
        header.className = 'accordion-header';
        header.textContent = category;
        header.onclick = () => {
            header.nextElementSibling.classList.toggle('active');
        };

        const content = document.createElement('div');
        content.className = 'accordion-content';

        categories[category].forEach(item => {
            const itemButton = document.createElement('div');
            itemButton.className = 'item-button';
            itemButton.textContent = item.item_name;
            itemButton.onclick = () => addItemToTrader(item);

            content.appendChild(itemButton);
        });

        section.appendChild(header);
        section.appendChild(content);
        itemListAccordion.appendChild(section);
    });
}

// Add selected item to trader's container
function addItemToTrader(item) {
    const selectedItemsContainer = document.getElementById('selected-items-container');

    const itemFrame = document.createElement('div');
    itemFrame.className = 'item-frame';

    const img = document.createElement('img');
    img.src = item.icon_url;
    img.alt = item.item_name;

    const itemName = document.createElement('h3');
    itemName.textContent = item.item_name;

    const removeButton = document.createElement('button');
    removeButton.className = 'remove-item';
    removeButton.textContent = 'X';
    removeButton.onclick = () => {
        itemFrame.remove();
        updateTotal();
    };

    itemFrame.appendChild(removeButton);
    itemFrame.appendChild(img);
    itemFrame.appendChild(itemName);
    selectedItemsContainer.appendChild(itemFrame);

    updateTotal();
}

// Update the totals for the trader
function updateTotal() {
    const trader1TotalElement = document.getElementById('trader1-total');
    const trader2TotalElement = document.getElementById('trader2-total');
    const tradeDifferenceElement = document.getElementById('trade-difference');

    // This example only has basic calculation logic for demonstration
    // Adjust calculation based on your needs
    let totalTrader1 = 0;
    let totalTrader2 = 0;

    trader1TotalElement.textContent = `${totalTrader1} Coins`;
    trader2TotalElement.textContent = `${totalTrader2} Coins`;
    tradeDifferenceElement.textContent = `${Math.abs(totalTrader1 - totalTrader2)} Coins`;
}

// Initialize by fetching items
fetchItems();