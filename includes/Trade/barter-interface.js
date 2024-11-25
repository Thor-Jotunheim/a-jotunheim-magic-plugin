let itemsData = [];

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

function adjustPageHeight() {
    const barterPage = document.getElementById('jotunheim-barter-page');
    const totalHeight = barterPage.scrollHeight; // Total height of content inside
    document.body.style.minHeight = `${totalHeight}px`; // Dynamically adjust body height
}

// Call this function whenever items are added
function addItemToContainer(item, containerId) {
    // Your existing logic for adding items...
    
    // Adjust the page height after adding an item
    adjustPageHeight();
}

function populateItemList(containerId, searchQuery) {
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
}

document.getElementById('item-search').addEventListener('input', () => {
    filterItems('item-list-accordion');
});

document.getElementById('item-search-2').addEventListener('input', () => {
    filterItems('item-list-accordion-2');
});

function filterItems(containerId) {
    const searchInput = document.getElementById(containerId === 'item-list-accordion' ? 'item-search' : 'item-search-2');
    const query = searchInput.value.toLowerCase();

    const container = document.getElementById(containerId);
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

// Function to toggle accordion sections and adjust page height
function toggleAccordion(section) {
    // Ensure section is a valid accordion section
    if (!section || !section.classList.contains('accordion-section')) {
        console.error("Invalid section passed to toggleAccordion");
        return;
    }

    // Get the container that holds the accordion
    const container = section.closest('.item-list-sidebar'); // Corrected to .item-list-sidebar
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

        //container.scrollTop = offset - 10; // Adjust with padding if needed
    }

    // Adjust page height dynamically to account for expanded/collapsed content
    adjustPageHeight();
}

// Function to adjust page height dynamically
function adjustPageHeight() {
    const barterPage = document.getElementById('jotunheim-barter-page');
    const totalHeight = barterPage.scrollHeight; // Calculate the total content height
    document.body.style.minHeight = `${totalHeight}px`; // Adjust the body height dynamically
}

// Function to add selected items to trader containers
function updateTotals() {
    const trader1Container = document.getElementById('selected-items-container');
    const trader2Container = document.getElementById('selected-items-container-2');

    const calculateTotal = (container) => {
        let totalCoins = 0;

        const panels = container.querySelectorAll('.selected-items-panel');
        panels.forEach((panel) => {
            const items = panel.querySelectorAll('.item-frame');
            items.forEach((itemFrame) => {
                const units = parseInt(itemFrame.querySelector('.units-input')?.value) || 0;
                const stacksInput = itemFrame.querySelector('.stacks-input'); // Check if stacks field exists
                const stacks = stacksInput ? parseInt(stacksInput.value) || 0 : 0;
                const level = parseInt(itemFrame.querySelector('.level-dropdown')?.value || 1);
                const discount = parseFloat(itemFrame.querySelector('.discount-input')?.value) || 0;

                const itemData = itemsData.find((data) => data.prefab_name === itemFrame.dataset.itemId);
                if (itemData) {
                    const priceKey = level === 1 ? 'unit_price' : `lv${level}_price`;
                    const price = parseInt(itemData[priceKey]) || 0;
                    const stackSize = parseInt(itemData.stack_size) || 1;

                    // Apply discount to price
                    const discountedPrice = price * ((100 - discount) / 100);

                    totalCoins += units * discountedPrice;
                    totalCoins += stacks * discountedPrice * stackSize;
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

    document.getElementById('trader1-total-display').innerHTML = formatTotals(
        trader1Totals.totalCoins,
        trader1Ymir
    );

    document.getElementById('trader2-total-display').innerHTML = formatTotals(
        trader2Totals.totalCoins,
        trader2Ymir
    );

    const diffCoins = trader1Totals.totalCoins - trader2Totals.totalCoins;
    const diffYmir = convertToYmirFlesh(Math.abs(diffCoins));
    document.getElementById('trade-difference').innerHTML = formatTotals(
        Math.abs(diffCoins),
        diffYmir
    );
}

function sanitizeItemName(name) {
    // Remove unnecessary backslashes
    return name.replace(/\\/g, '').trim();
}

function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function addItemToContainer(item, containerId) {
    const wrapper = document.getElementById(containerId);
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