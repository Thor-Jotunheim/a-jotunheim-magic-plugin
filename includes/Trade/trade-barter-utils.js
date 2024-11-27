// Global variable to hold items data
let itemsData = [];

// Fetch items from the API
export async function fetchItems() {
    console.log('Fetching items from API...');
    try {
        const response = await fetch('https://jotun.games/wp-json/jotunheim-magic/v1/items');
        const data = await response.json();

        console.log('Fetched Items:', data); // Log the fetched data

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
                    filterItems('item-list-accordion');
                });
            } else {
                console.error('Search bar 1 not found.');
            }

            if (searchBar2) {
                searchBar2.addEventListener('input', (event) => {
                    filterItems('item-list-accordion-2');
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

export function filterItems(containerId) {
    const searchInput = document.getElementById(containerId === 'item-list-accordion' ? 'item-search' : 'item-search-2');
    if (!searchInput) {
        console.error(`Search input not found for container "${containerId}"`);
        return;
    }

    const query = searchInput.value.toLowerCase();
    const container = document.getElementById(containerId);
    if (!container) {
        console.error(`Accordion container with ID "${containerId}" not found.`);
        return;
    }

    const sections = container.querySelectorAll('.accordion-section');

    sections.forEach(section => {
        const content = section.querySelector('.accordion-content');
        const items = content.querySelectorAll('.item-button');

        // Check if any items in the section match the query
        let hasMatch = false;
        items.forEach(item => {
            if (item.textContent.toLowerCase().includes(query)) {
                item.style.display = ''; // Show item
                hasMatch = true;
            } else {
                item.style.display = 'none'; // Hide item
            }
        });

        // Show or hide the section based on whether it has matches
        if (hasMatch) {
            section.style.display = ''; // Show section
            content.classList.add('active'); // Expand section
            content.style.display = 'block'; // Ensure content is visible
        } else {
            section.style.display = 'none'; // Hide section
            content.classList.remove('active'); // Collapse section
            content.style.display = 'none'; // Ensure content is hidden
        }
    });
}

// Toggle accordion sections
export function toggleAccordion(section) {
    // Ensure the section is a valid accordion section
    if (!section || !section.classList.contains('accordion-section')) {
        console.error("Invalid section passed to toggleAccordion");
        return;
    }

    // Get the container that holds the accordion
    const container = section.closest('.item-list-sidebar');
    if (!container) {
        console.error("Container not found for the given section");
        return;
    }

    // Get all accordion content sections within the container
    const allSections = container.querySelectorAll('.accordion-section');

    // Close all sections except the one being clicked
    allSections.forEach((s) => {
        const content = s.querySelector('.accordion-content');
        if (s !== section) {
            content.classList.remove('active');
            content.style.display = 'none'; // Ensure it's hidden
        }
    });

    // Toggle the clicked section
    const content = section.querySelector('.accordion-content');
    if (content.classList.contains('active')) {
        content.classList.remove('active');
        content.style.display = 'none';
    } else {
        content.classList.add('active');
        content.style.display = 'block';

        // Scroll the container to bring the section into view
        const containerRect = container.getBoundingClientRect();
        const sectionRect = section.getBoundingClientRect();
        const offset = sectionRect.top - containerRect.top + container.scrollTop;

        container.scrollTop = offset - 10; // Adjust for padding if needed
    }

    // Adjust page height dynamically to account for expanded/collapsed content
    adjustPageHeight('jotunheim-barter-page');
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

export function addItemToContainer(item, containerId) {
    const wrapper = document.getElementById(containerId);
    if (!wrapper) {
        console.error(`Container with ID "${containerId}" not found.`);
        return;
    }

    let panels = wrapper.querySelectorAll('.selected-items-panel');
    let lastPanel = panels[panels.length - 1];

    if (!lastPanel || lastPanel.children.length >= 8) {
        lastPanel = document.createElement('div');
        lastPanel.className = 'selected-items-panel';
        wrapper.appendChild(lastPanel);
    }

    const existingItems = Array.from(wrapper.querySelectorAll(`.item-frame[data-item-id="${item.prefab_name}"]`));
    const hasLevelPrices = ['lv2_price', 'lv3_price', 'lv4_price', 'lv5_price'].some((key) => item[key] > 0);

    if (!hasLevelPrices && existingItems.length > 0) {
        console.warn(`Item "${item.item_name}" already exists and cannot be added multiple times.`);
        return;
    }

    // Prevent exceeding 5 levels for items with multiple levels
    const existingLevels = existingItems.map(itemFrame =>
        parseInt(itemFrame.querySelector('.level-dropdown')?.value || 1)
    );
    if (hasLevelPrices && existingLevels.length >= 5) {
        console.warn(`All levels for "${item.item_name}" are already in the container.`);
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
    removeButton.style.position = 'absolute';
    removeButton.style.top = '10px';
    removeButton.style.right = '10px';
    removeButton.style.width = '20px';
    removeButton.style.height = '20px';
    removeButton.style.border = 'none';
    removeButton.style.background = '#FF4C4C';
    removeButton.style.color = 'white';
    removeButton.style.borderRadius = '50%';
    removeButton.style.cursor = 'pointer';
    removeButton.onclick = () => {
        itemFrame.remove();
        updateLevelDropdowns(containerId, item.prefab_name);
        updateTotals();
    };
    itemFrame.appendChild(removeButton);

    const itemName = document.createElement('h3');
    itemName.textContent = sanitizeItemName(item.item_name || 'Unknown Item');
    itemFrame.appendChild(itemName);

    // Create the cost display below the item name
    const costDisplay = document.createElement('p');
    costDisplay.textContent = `Cost: ${item.unit_price || 0} Coins`;
    costDisplay.style.fontSize = '12px';
    costDisplay.style.color = '#333';
    costDisplay.style.textAlign = 'center';
    costDisplay.style.marginTop = '5px';
    itemFrame.appendChild(costDisplay);

    const inputContainer = document.createElement('div');
    inputContainer.className = 'input-container';

    const hasMultipleLevels = ['lv2_price', 'lv3_price', 'lv4_price', 'lv5_price'].some((key) => item[key] > 0);

    if (hasMultipleLevels) {
        const levelDropdown = document.createElement('select');
        levelDropdown.className = 'level-dropdown';
        levelDropdown.style.display = 'block';
        levelDropdown.style.fontSize = '10px';
        levelDropdown.style.width = '120px';
        levelDropdown.style.height = '25px';

        // Populate dropdown options
        ['unit_price', 'lv2_price', 'lv3_price', 'lv4_price', 'lv5_price'].forEach((key, index) => {
            if (item[key] > 0) {
                const option = document.createElement('option');
                option.value = index + 1;
                option.textContent = `Level ${index + 1}`;
                levelDropdown.appendChild(option);
            }
        });

        inputContainer.appendChild(levelDropdown);
    }

    const unitsInput = document.createElement('input');
    unitsInput.type = 'text';
    unitsInput.placeholder = 'Units';
    unitsInput.className = 'item-input units-input';
    unitsInput.style.fontSize = '11px';
    unitsInput.style.width = '120px';
    unitsInput.style.height = '25px';
    unitsInput.style.textAlign = 'center';

    addHighlightBehavior(unitsInput, 'units');
    unitsInput.dataset.previousValue = '';
    inputContainer.appendChild(unitsInput);

    if (item.stack_size > 1) {
        const stacksInput = document.createElement('input');
        stacksInput.type = 'text';
        stacksInput.placeholder = 'Stacks';
        stacksInput.className = 'item-input stacks-input';
        stacksInput.style.fontSize = '11px';
        stacksInput.style.width = '120px';
        stacksInput.style.height = '25px';
        stacksInput.style.textAlign = 'center';

        addHighlightBehavior(stacksInput, 'stacks');
        stacksInput.dataset.previousValue = '';
        inputContainer.appendChild(stacksInput);
    }

    inputContainer.style.display = 'flex';
    inputContainer.style.flexDirection = 'column';
    inputContainer.style.alignItems = 'center';
    inputContainer.style.gap = '2px';

    if (parseInt(item.undercut) === 1) {
        const discountInput = document.createElement('input');
        discountInput.type = 'text';
        discountInput.placeholder = 'Discount %';
        discountInput.className = 'item-input discount-input';
        discountInput.style.fontSize = '11px';
        discountInput.style.width = '120px';
        discountInput.style.height = '25px';
        discountInput.style.textAlign = 'center';

        addHighlightBehavior(discountInput, 'discount');
        discountInput.dataset.previousValue = '';
        inputContainer.appendChild(discountInput);
    }

    if (!itemFrame.contains(inputContainer)) {
        itemFrame.appendChild(inputContainer);
    }

    lastPanel.appendChild(itemFrame);

    // Function to update the cost based on user input
    const updateCostDisplay = () => {
        const level = parseInt(levelDropdown?.value || 1);
        const units = parseInt(unitsInput?.value || 1);
        const stacks = parseFloat(stacksInput?.value || 0);
        const discount = parseFloat(discountInput?.value || 0);

        const priceKey = level === 1 ? 'unit_price' : `lv${level}_price`;
        const price = parseFloat(item[priceKey]) || 0;
        const stackSize = parseFloat(item.stack_size) || 1;

        const discountedPrice = price * ((100 - discount) / 100);
        const totalCost = (units * discountedPrice) + (stacks * stackSize * discountedPrice);

        // Update the cost in the item frame
        costDisplay.textContent = `Cost: ${totalCost.toFixed(2)} Coins`;
    };

    // Update cost when input changes
    levelDropdown?.addEventListener('change', updateCostDisplay);
    unitsInput?.addEventListener('input', updateCostDisplay);
    stacksInput?.addEventListener('input', updateCostDisplay);
    discountInput?.addEventListener('input', updateCostDisplay);

    // Trigger updates for totals
    updateLevelDropdowns(containerId, item.prefab_name);
    updateTotals(); // Recalculate totals after item cost updates
}

// Function to update totals
export function updateTotals() {
    const trader1Container = document.getElementById('selected-items-container');
    const trader2Container = document.getElementById('selected-items-container-2');

    const calculateTotal = (container) => {
        let totalCoins = 0;

        const panels = container.querySelectorAll('.selected-items-panel');
        panels.forEach((panel) => {
            const items = panel.querySelectorAll('.item-frame');
            items.forEach((itemFrame) => {
                const units = parseInt(itemFrame.querySelector('.units-input')?.value) || 0;
                const stacksInput = itemFrame.querySelector('.stacks-input');
                const stacks = stacksInput ? parseFloat(stacksInput.value) || 0 : 0; // Use parseFloat for decimal values
                const level = parseInt(itemFrame.querySelector('.level-dropdown')?.value || 1);
                const discount = parseFloat(itemFrame.querySelector('.discount-input')?.value) || 0;

                const itemData = itemsData.find((data) => data.prefab_name === itemFrame.dataset.itemId);
                if (itemData) {
                    const priceKey = level === 1 ? 'unit_price' : `lv${level}_price`;
                    const price = parseFloat(itemData[priceKey]) || 0; // Ensure price is treated as a float
                    const stackSize = parseFloat(itemData.stack_size) || 1; // Ensure stack size is treated as a float

                    const discountedPrice = price * ((100 - discount) / 100);

                    totalCoins += units * discountedPrice;
                    totalCoins += stacks * discountedPrice * stackSize; // Allow fractional stacks
                }
            });
        });

        return { totalCoins };
    };

    const convertToYmirFlesh = (coins) => {
        const ymirFlesh = Math.floor(coins / 120);
        const remainingCoins = coins % 120;
        return { ymirFlesh, remainingCoins };
    };

    const trader1Totals = calculateTotal(trader1Container);
    const trader2Totals = calculateTotal(trader2Container);

    const trader1Ymir = convertToYmirFlesh(trader1Totals.totalCoins);
    const trader2Ymir = convertToYmirFlesh(trader2Totals.totalCoins);

    const formatTotals = (coins, ymirFlesh) => {
        return `
            <div style="text-align: center;">
                ${coins.toFixed(2)} Coins<br>
                <small>or</small><br>
                ${ymirFlesh.ymirFlesh} Ymir Flesh & ${ymirFlesh.remainingCoins.toFixed(2)} Coins
            </div>
        `;
    };

    document.getElementById('trader1-total-display').innerHTML = formatTotals(trader1Totals.totalCoins, trader1Ymir);
    document.getElementById('trader2-total-display').innerHTML = formatTotals(trader2Totals.totalCoins, trader2Ymir);

    const diffCoins = trader1Totals.totalCoins - trader2Totals.totalCoins;
    const diffYmir = convertToYmirFlesh(Math.abs(diffCoins));
    document.getElementById('trade-difference').innerHTML = formatTotals(Math.abs(diffCoins), diffYmir);
}