let itemsData = [];

// Fetch items from the API
async function fetchItems() {
    try {
        const response = await fetch('https://JOTUNHEIM_BASE_URL/wp-json/jotunheim-magic/v1/items');
        const data = await response.json();

        if (Array.isArray(data)) {
            itemsData = data;
            populateItemList('item-list-accordion');
            populateItemList('item-list-accordion-2');
        } else {
            console.error("Error fetching items:", data.message || "Unexpected data format");
        }
    } catch (error) {
        console.error("Error fetching items:", error);
    }
}

// Populate item list in accordion format for a given container ID
function populateItemList(containerId) {
    const itemListAccordion = document.getElementById(containerId);
    if (!itemListAccordion) {
        console.error(`Accordion container with ID "${containerId}" not found.`);
        return;
    }
    itemListAccordion.innerHTML = ''; // Clear existing content

    const categories = {};

    // Organize items by their type
    itemsData.forEach(item => {
        if (!categories[item.item_type]) {
            categories[item.item_type] = [];
        }
        categories[item.item_type].push(item);
    });

    // Populate accordion with categorized items
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

        // Add items to accordion content
        categories[category].forEach(item => {
            const itemButton = document.createElement('div');
            itemButton.className = 'item-button';
            itemButton.textContent = item.item_name;
            itemButton.onclick = () => addItemToContainer(item, containerId.includes('2') ? 'selected-items-container-2' : 'selected-items-container');
            content.appendChild(itemButton);
        });

        section.appendChild(header);
        section.appendChild(content);
        itemListAccordion.appendChild(section);
    });
}

// Function to add selected items to trader containers
function addItemToContainer(item, containerId) {
    const container = document.getElementById(containerId);

    const itemFrame = document.createElement('div');
    itemFrame.className = 'item-frame';

    const img = document.createElement('img');
    img.src = item.icon_url;  // Ensure the API returns a valid URL for the icon
    img.alt = item.item_name;

    const itemName = document.createElement('h3');
    itemName.textContent = item.item_name;

    const removeButton = document.createElement('button');
    removeButton.className = 'remove-item';
    removeButton.textContent = 'X';
    removeButton.onclick = () => itemFrame.remove();

    itemFrame.appendChild(removeButton);
    itemFrame.appendChild(img);
    itemFrame.appendChild(itemName);
    container.appendChild(itemFrame);
}

// Initialize by fetching items
fetchItems();