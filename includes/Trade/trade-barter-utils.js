// Global variable to hold items data
let itemsData = [];

// Fetch items from the API
export async function fetchItems() {
    console.log('Fetching items from API...');
    try {
        const response = await fetch('https://jotun.games/wp-json/jotunheim-magic/v1/items');
        const data = await response.json();

        console.log('Fetched Items:', data); // Log the fetched data

        // Check if data is an array and process it
        if (Array.isArray(data)) {
            itemsData = data; // Populate the global variable

            // Populate the accordion lists
            populateItemList('item-list-accordion', itemsData, '', addItemToContainer);
            populateItemList('item-list-accordion-2', itemsData, '', addItemToContainer);

            // Add event listeners for search functionality
            const searchBar1 = document.getElementById('item-search');
            const searchBar2 = document.getElementById('item-search-2');

            if (searchBar1) {
                searchBar1.addEventListener('input', (event) => {
                    populateItemList('item-list-accordion', itemsData, event.target.value, addItemToContainer);
                });
            } else {
                console.error('Search bar 1 not found.');
            }

            if (searchBar2) {
                searchBar2.addEventListener('input', (event) => {
                    populateItemList('item-list-accordion-2', itemsData, event.target.value, addItemToContainer);
                });
            } else {
                console.error('Search bar 2 not found.');
            }
        } else {
            console.error('Error fetching items: Unexpected data format or empty response', data);
        }
    } catch (error) {
        console.error('Error fetching items:', error);
    }
}

// Populate an accordion list with items
export function populateItemList(containerId, itemsData, searchQuery, addItemCallback) {
    const itemListAccordion = document.getElementById(containerId);
    if (!itemListAccordion) {
        console.error(`Accordion container with ID "${containerId}" not found.`);
        return;
    }
    itemListAccordion.innerHTML = ''; // Clear existing content

    const categories = {};

    itemsData.forEach(item => {
        if (item.item_type?.toLowerCase() === 'untradable') return;

        if (!searchQuery || item.item_name.toLowerCase().includes(searchQuery.toLowerCase())) {
            if (!categories[item.item_type]) {
                categories[item.item_type] = [];
            }
            categories[item.item_type].push(item);
        }
    });

    Object.keys(categories).forEach(category => {
        const section = document.createElement('div');
        section.className = 'accordion-section';

        const header = document.createElement('div');
        header.className = 'accordion-header';
        header.textContent = category;

        const content = document.createElement('div');
        content.className = 'accordion-content';

        categories[category].forEach(item => {
            const itemButton = document.createElement('div');
            itemButton.className = 'item-button';
            itemButton.textContent = sanitizeItemName(item.item_name);
            itemButton.onclick = () =>
                addItemToContainer(
                    item,
                    containerId.includes('2') ? 'selected-items-container-2' : 'selected-items-container'
                );
            content.appendChild(itemButton);
        });

        section.appendChild(header);
        section.appendChild(content);
        itemListAccordion.appendChild(section);

        header.onclick = () => toggleAccordion(section);
    });
}

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
export function addItemToContainer(item, containerId) {
    const wrapper = document.getElementById(containerId);
    if (!wrapper) {
        console.error(`Container with ID "${containerId}" not found.`);
        return; // Prevent further execution if the container doesn't exist
    }

    let panels = wrapper.querySelectorAll('.selected-items-panel');
    let lastPanel = panels[panels.length - 1];

    if (!lastPanel || lastPanel.children.length >= 8) {
        lastPanel = document.createElement('div');
        lastPanel.className = 'selected-items-panel';
        wrapper.appendChild(lastPanel);
    }

    const existingItem = Array.from(wrapper.querySelectorAll('.item-frame')).find(
        (child) => child.dataset.itemId === item.prefab_name
    );
    if (existingItem) {
        console.warn(`Item "${item.item_name}" already exists in the container.`);
        return;
    }

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
    removeButton.onclick = () => {
        itemFrame.remove();
        updateTotals();
    };
    itemFrame.appendChild(removeButton);

    const sanitizedItemName = sanitizeItemName(item.item_name || 'Unknown Item');
    const itemName = document.createElement('h3');
    itemName.textContent = sanitizedItemName;
    itemFrame.appendChild(itemName);

    const inputContainer = document.createElement('div');
    inputContainer.className = 'input-container';

    // Units Input Field
    const unitsInput = document.createElement('input');
    unitsInput.type = 'number';
    unitsInput.placeholder = 'Units';
    unitsInput.className = 'item-input units-input';
    unitsInput.style.fontSize = '11px';
    unitsInput.style.width = '60px';
    unitsInput.style.height = '30px';
    unitsInput.style.marginRight = '5px';
    unitsInput.addEventListener('input', updateTotals);
    inputContainer.appendChild(unitsInput);

    // Stacks Input Field (only if stack_size > 1)
    if (item.stack_size > 1) {
        const stacksInput = document.createElement('input');
        stacksInput.type = 'number';
        stacksInput.placeholder = 'Stacks';
        stacksInput.className = 'item-input stacks-input';
        stacksInput.style.fontSize = '11px';
        stacksInput.style.width = '60px';
        stacksInput.style.height = '30px';
        stacksInput.addEventListener('input', updateTotals);
        inputContainer.appendChild(stacksInput);
    } else {
        console.log(`Hiding Stacks field for item "${item.item_name}" because stack_size is 1.`);
    }

    itemFrame.appendChild(inputContainer);

    // Dropdown and Discount Container
    const dropdownContainer = document.createElement('div');
    dropdownContainer.className = 'dropdown-container';
    dropdownContainer.style.display = 'flex';
    dropdownContainer.style.alignItems = 'center';

    // Level dropdown
    const hasLevelPrices = ['lv2_price', 'lv3_price', 'lv4_price', 'lv5_price'].some((key) => item[key] > 0);
    if (hasLevelPrices) {
        const levelDropdown = document.createElement('select');
        levelDropdown.className = 'level-dropdown';
        levelDropdown.style.fontSize = '11px';
        levelDropdown.style.width = '60px';
        levelDropdown.style.height = '30px';
        levelDropdown.style.marginRight = '5px';

        ['unit_price', 'lv2_price', 'lv3_price', 'lv4_price', 'lv5_price'].forEach((key, index) => {
            if (item[key] > 0) {
                const option = document.createElement('option');
                option.value = index + 1;
                option.textContent = `Level ${index + 1}`;
                levelDropdown.appendChild(option);
            }
        });

        levelDropdown.addEventListener('change', updateTotals);
        dropdownContainer.appendChild(levelDropdown);
    }

    // Discount input field (only if undercut === 1)
    if (parseInt(item.undercut) === 1) {
        const discountInput = document.createElement('input');
        discountInput.type = 'number';
        discountInput.placeholder = 'Discount %';
        discountInput.className = 'item-input discount-input';
        discountInput.style.fontSize = '9px';
        discountInput.style.width = '80px';
        discountInput.style.height = '30px';
        discountInput.min = 0;
        discountInput.max = 40;
        discountInput.addEventListener('input', () => {
            if (discountInput.value > 40) {
                discountInput.value = 40;
            }
            updateTotals();
        });
        dropdownContainer.appendChild(discountInput);
    }

    itemFrame.appendChild(dropdownContainer);
    lastPanel.appendChild(itemFrame);
}

// Initialize by fetching items
fetchItems();