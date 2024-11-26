// Fetch items from the API
async function fetchItems() {
    try {
        const response = await fetch('https://jotun.games/wp-json/jotunheim-magic/v1/items');
        const data = await response.json();

        if (Array.isArray(data)) {
            itemsData = data;
            populateItemList('item-list-accordion', '');
            populateItemList('item-list-accordion-2', '');

            // Add event listeners to search bars
            document.getElementById('search-bar-1').addEventListener('input', (event) => {
                populateItemList('item-list-accordion', event.target.value);
            });
            document.getElementById('search-bar-2').addEventListener('input', (event) => {
                populateItemList('item-list-accordion-2', event.target.value);
            });
        } else {
            console.error("Error fetching items:", data.message || "Unexpected data format");
        }
    } catch (error) {
        console.error("Error fetching items:", error);
    }
}

// Populate an accordion list with items
export function populateItemList(containerId, searchQuery) {
    const itemListAccordion = document.getElementById(containerId);
    if (!itemListAccordion) {
        console.error(`Accordion container with ID "${containerId}" not found.`);
        return;
    }
    itemListAccordion.innerHTML = ''; // Clear existing content

    const categories = {};

    // Organize items by their type, skipping Untradable items
    itemsData.forEach(item => {
        if (item.item_type?.toLowerCase() === 'untradable') {
            console.log(`Skipping item: ${sanitizeItemName(item.item_name)} (Untradable)`); // Debugging
            return; // Skip items marked as Untradable
        }

        if (!searchQuery || sanitizeItemName(item.item_name).toLowerCase().includes(searchQuery.toLowerCase())) {
            if (!categories[item.item_type]) {
                categories[item.item_type] = [];
            }
            categories[item.item_type].push(item);
        }
    });

    console.log('Filtered Categories:', categories); // Debugging

    // Populate accordion with categorized items
    Object.keys(categories).forEach(category => {
        if (categories[category].length === 0) {
            return; // Skip empty categories
        }

        const section = document.createElement('div');
        section.className = 'accordion-section';

        const header = document.createElement('div');
        header.className = 'accordion-header';
        header.textContent = sanitizeItemName(category);

        const content = document.createElement('div');
        content.className = 'accordion-content';

        // Add items to accordion content
        categories[category].forEach(item => {
            const sanitizedItemName = sanitizeItemName(item.item_name);

            const itemButton = document.createElement('div');
            itemButton.className = 'item-button';
            itemButton.textContent = sanitizedItemName;
            itemButton.onclick = () => addItemToContainer(item, containerId.includes('2') ? 'selected-items-container-2' : 'selected-items-container');
            content.appendChild(itemButton);
        });

        // Expand section if it contains matching items and a search query exists
        if (searchQuery && categories[category].length > 0) {
            content.classList.add('active');
            content.style.display = 'block'; // Show the content
        } else {
            content.classList.remove('active');
            content.style.display = 'none'; // Collapse the content
        }

        section.appendChild(header);
        section.appendChild(content);
        itemListAccordion.appendChild(section);

        // Add click event to toggle accordion sections
        header.onclick = () => toggleAccordion(section);
    });

// Adjust page height dynamically
export function adjustPageHeight(pageId) {
    const page = document.getElementById(pageId);
    const totalHeight = page.scrollHeight; // Calculate the total content height
    document.body.style.minHeight = `${totalHeight}px`; // Adjust the body height dynamically
}

// Toggle accordion sections
export function toggleAccordion(section) {
    const content = section.querySelector('.accordion-content');
    if (content.classList.contains('active')) {
        content.classList.remove('active');
        content.style.display = 'none';
    } else {
        content.classList.add('active');
        content.style.display = 'block';
    }
}

// Sanitize item names
export function sanitizeItemName(name) {
    return name.replace(/\\/g, '').trim();
}

// Escape HTML
export function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

// Add item to a container
export function addItemToContainer(item, containerId, containerLimit = 8) {
    const container = document.getElementById(containerId);
    let panels = container.querySelectorAll('.selected-items-panel');
    let lastPanel = panels[panels.length - 1];

    // Add a new panel if the last one is full
    if (!lastPanel || lastPanel.children.length >= containerLimit) {
        lastPanel = document.createElement('div');
        lastPanel.className = 'selected-items-panel';
        container.appendChild(lastPanel);
    }

    // Check if the item already exists
    const existingItem = Array.from(container.querySelectorAll('.item-frame')).find(
        (child) => child.dataset.itemId === item.prefab_name
    );
    if (existingItem) {
        console.warn(`Item "${item.item_name}" already exists in the container.`);
        return;
    }

    // Create item frame
    const itemFrame = document.createElement('div');
    itemFrame.className = 'item-frame';
    itemFrame.dataset.itemId = item.prefab_name;

    const img = document.createElement('img');
    img.src = `/wp-content/uploads/Jotunheim-magic/icons/${item.prefab_name}.png`;
    img.alt = sanitizeItemName(item.item_name || 'Unknown Item');
    itemFrame.appendChild(img);

    const removeButton = document.createElement('button');
    removeButton.textContent = 'X';
    removeButton.className = 'remove-item';
    removeButton.onclick = () => itemFrame.remove();
    itemFrame.appendChild(removeButton);

    const itemName = document.createElement('h3');
    itemName.textContent = sanitizeItemName(item.item_name || 'Unknown Item');
    itemFrame.appendChild(itemName);

    // Append to the panel
    lastPanel.appendChild(itemFrame);
}