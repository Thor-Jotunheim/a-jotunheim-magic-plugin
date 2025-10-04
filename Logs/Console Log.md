[Log] JQMIGRATE: Migrate is installed, version 3.4.1 (load-scripts.php, line 5)
[Log] Jotunheim Comprehensive API loaded (jotun-comprehensive-api.js, line 533)
[Log] 🚀🚀� UNIFIED TELLER: Initialization check: – {unified-teller-interface: true, teller-shop-selector: true, unified-teller-container: false, …} (unified-teller.js, line 5554)
{unified-teller-interface: true, teller-shop-selector: true, unified-teller-container: false, refresh-shop-btn: true, shouldInitialize: true}Object
[Log] 🚀🚀� UNIFIED TELLER: Conditions met, initializing UnifiedTeller... (unified-teller.js, line 5563)
[Log] �🚀🚀 UNIFIED TELLER: Event listener registered for shopRotationChanged (unified-teller.js, line 85)
[Log] DEBUG: Clear transaction button found: –  (unified-teller.js, line 110)
<button id="clear-transaction-btn" class="field-input clear-transaction-btn" onclick="console.log('🚨 DEBUG: Clear button onclick fired'); if(window.unifiedTeller) { console.log('🚨 DEBUG: unifiedTeller found, typeof clearCart:', typeof window.unifiedTeller.clearCart); try { console.log('🚨 ONCLICK: About to call clearCart'); window.unifiedTeller.clearCart(); console.log('🚨 ONCLICK: clearCart completed'); } catch(e) { console.error('🚨 ERROR in onclick clearCart():', e); console.error('🚨 ERROR stack:', e.stack); } } else { console.log('🚨 ERROR: unifiedTeller not found on window'); }">Clear Transaction</button>

<button id="clear-transaction-btn" class="field-input clear-transaction-btn" onclick="console.log('🚨 DEBUG: Clear button onclick fired'); if(window.unifiedTeller) { console.log('🚨 DEBUG: unifiedTeller found, typeof clearCart:', typeof window.unifiedTeller.clearCart); try { console.log('🚨 ONCLICK: About to call clearCart'); window.unifiedTeller.clearCart(); console.log('🚨 ONCLICK: clearCart completed'); } catch(e) { console.error('🚨 ERROR in onclick clearCart():', e); console.error('🚨 ERROR stack:', e.stack); } } else { console.log('🚨 ERROR: unifiedTeller not found on window'); }">Clear Transaction</button>
[Log] DEBUG: Clear transaction event listener attached (unified-teller.js, line 125)
[Log] UnifiedTeller: Starting to load initial data... (unified-teller.js, line 217)
[Log] JotunAPI is available, loading data... (unified-teller.js, line 233)
[Log] Loading shops for selector... (unified-teller.js, line 423)
[Log] JotunAPI status: – "object" (unified-teller.js, line 424)
[Log] jotun_api_vars: – {nonce: "49b5ea96ee", rest_url: "https://jotun.games/wp-json/jotun-api/v1/"} (unified-teller.js, line 425)
[Log] Testing direct API call to: – "/wp-json/jotun-api/v1/shops" (unified-teller.js, line 433)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/shops" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "49b5ea96ee"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] UnifiedTeller constructor completed, preventOverLimit method: – "function" (unified-teller.js, line 18)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: Array} (jotun-comprehensive-api.js, line 39)
{data: Array}Object
[Log] Shop API response: – {data: Array} (unified-teller.js, line 436)
{data: Array}Object
[Log] Shops data received: – [Object, Object, Object] (3) (unified-teller.js, line 439)
[Object, Object, Object]Array (3)
[Log] DEBUG - Populating unified teller shop selector with: – [Object, Object, Object] (3) (unified-teller.js, line 465)
[Object, Object, Object]Array (3)
[Log] DEBUG - Processing shop: – {shop_id: "138", owner_name: "Thor", is_active: "1", …} (unified-teller.js, line 470)
{shop_id: "138", owner_name: "Thor", is_active: "1", shop_name: "Aesir Spells & Items", shop_type: "aesir", …}Object
[Log] DEBUG - Added shop option: – "Aesir Spells & Items" – "with rotation:" – "1" (unified-teller.js, line 480)
[Log] DEBUG - Processing shop: – {shop_id: "139", owner_name: "Thor", is_active: "1", …} (unified-teller.js, line 470)
{shop_id: "139", owner_name: "Thor", is_active: "1", shop_name: "Call to Arms", shop_type: "turn-in_only", …}Object
[Log] DEBUG - Added shop option: – "Call to Arms" – "with rotation:" – "1" (unified-teller.js, line 480)
[Log] DEBUG - Processing shop: – {shop_id: "140", owner_name: "Thor", is_active: "1", …} (unified-teller.js, line 470)
{shop_id: "140", owner_name: "Thor", is_active: "1", shop_name: "Popup Shop", shop_type: "staff", …}Object
[Log] DEBUG - Added shop option: – "Popup Shop" – "with rotation:" – "1" (unified-teller.js, line 480)
[Log] DEBUG - Shop selector populated with – 3 – "active shops" (unified-teller.js, line 486)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/playerlist" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "49b5ea96ee"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: Array} (jotun-comprehensive-api.js, line 39)
{data: Array}Object
[Log] DEBUG - Loaded player list: – [Object, Object, Object, …] (714) (unified-teller.js, line 246)
[Object, Object, Object, Object, Object, Object, Object, Object, Object, Object, …]Array (714)
[Error] Failed to load resource: the server responded with a status of 403 (Forbidden) (current, line 0)
[Warning] User endpoint access denied - using fallback (unified-teller.js, line 288)
[Log] 🚨 DEBUG: Current cart contents: – [] (0) (unified-teller.js, line 2189)
[Log] 🚨 DEBUG: Cart array set to empty. New length: – 0 (unified-teller.js, line 2192)
[Log] 🚨 DEBUG: Customer name field cleared (unified-teller.js, line 2198)
[Log] 🚨 DEBUG: Customer validation cleared (unified-teller.js, line 2204)
[Log] getCurrentShopType: – {selectedShop: "138", selectedOption: <option>, shopType: "aesir"} (unified-teller.js, line 773)
{selectedShop: "138", selectedOption: <option>, shopType: "aesir"}Object
[Log] 🚨 DEBUG: Recent Transaction section cleared (unified-teller.js, line 2215)
[Log] 🚨 DEBUG: updateCartDisplay() called (unified-teller.js, line 2219)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 3323)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 3324)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 3325)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 3326)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 3330)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3347)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 2223)
[Log] 🚨 DEBUG: updateRecordTransactionButton() called (unified-teller.js, line 2226)
[Log] DEBUG: resetItemDisplay() called. Cart length: 0 (unified-teller.js, line 2240)
[Log] DEBUG: Clearing 0 input fields (unified-teller.js, line 2256)
[Log] 🚨 DEBUG: resetItemDisplay() called (unified-teller.js, line 2230)
[Log] 🚨 DEBUG: showShopView() called (unified-teller.js, line 3282)
[Log] 🚨 DEBUG: Setting isCartView to false (unified-teller.js, line 3283)
[Log] 🚨 DEBUG: shopInventoryCard found: – true (unified-teller.js, line 3288)
[Log] 🚨 DEBUG: transactionSummaryCard found: – true (unified-teller.js, line 3295)
[Log] 🚨 DEBUG: Buttons found - viewCart: – true – "record:" – true – "back:" – true (unified-teller.js, line 3305)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 3323)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 3324)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 3325)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 3326)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 3330)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3347)
[Log] 🚨 DEBUG: showShopView() called (unified-teller.js, line 2234)
[Log] 🚨🚨🚨 DEBUG: clearCart() completed - CART CLEARING FINISHED (unified-teller.js, line 2236)
[Log] Loading shop items for shop ID: – "138" – "rotation:" – "1" (unified-teller.js, line 660)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/shop-items?shop_id=138&rotation=1" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "49b5ea96ee"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] DEBUG: About to force button state update. Cart length: 0 (unified-teller.js, line 2270)
[Log] 🚨 DEBUG: forceButtonStateUpdate() called, cart length: – 0 (unified-teller.js, line 2351)
[Log] 🚨 DEBUG: Cart contents: – [] (0) (unified-teller.js, line 2352)
[Log] 🚨 DEBUG: Found 0 turn-in buttons to update (unified-teller.js, line 2365)
[Log] 🚨 DEBUG: forceButtonStateUpdate() completed (unified-teller.js, line 2392)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: Array} (jotun-comprehensive-api.js, line 39)
{data: Array}Object
[Log] Raw shop items from API: – [Object] (1) (unified-teller.js, line 665)
[Object]Array (1)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/itemlist" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "49b5ea96ee"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: Array} (jotun-comprehensive-api.js, line 39)
{data: Array}Object
[Log] Item list response: – {data: Array} (unified-teller.js, line 669)
{data: Array}Object
[Log] Enriched shop items: – [Object] (1) (unified-teller.js, line 722)
[Object]Array (1)
[Log] No individual buy button found for item: – "Unbreakable Oath" (unified-teller.js, line 1149)
[Log] No sell button found for item: – "Unbreakable Oath" (unified-teller.js, line 1180)
[Log] No turn-in button found for item: – "Unbreakable Oath" (unified-teller.js, line 1195)
[Log] getCurrentShopType: (unified-teller.js, line 773)
Object

selectedOption: <option>

selectedShop: "138"

shopType: "aesir"

Object Prototype
[Log] Setting up tracking interface: – {selectedShop: "138", shopType: "aesir", isTurnInOnly: false} (unified-teller.js, line 728)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 3323)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 3324)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 3325)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 3326)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 3330)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3347)
[Log] 🔍 DEBUG Transaction History: selectedShop: – "138" (unified-teller.js, line 2631)
[Log] 🔍 DEBUG Transaction History: selectedOption: –  (unified-teller.js, line 2632)
<option value="138" data-shop-name="Aesir Spells & Items" data-shop-type="aesir" data-current-rotation="1">Aesir Spells & Items</option>

<option value="138" data-shop-name="Aesir Spells & Items" data-shop-type="aesir" data-current-rotation="1">Aesir Spells & Items</option>
[Log] 🔍 DEBUG Transaction History: shopName from dataset: – "Aesir Spells & Items" (unified-teller.js, line 2633)
[Log] 🔍 DEBUG Transaction History: shopType from dataset: – "aesir" (unified-teller.js, line 2634)
[Log] 🔍 DEBUG Transaction History: customerFromTransaction: – null (unified-teller.js, line 2635)
[Log] 🔍 DEBUG Transaction History: Aesir shop detected - showing transaction history (unified-teller.js, line 2647)
[Log] 🔍 DEBUG Transaction History: Aesir shop - will show ledger balance after empty transactions (unified-teller.js, line 2661)
[Log] 🔍 DEBUG Transaction History: Added shop_name filter: – "Aesir Spells & Items" (unified-teller.js, line 2664)
[Log] 🔍 DEBUG Transaction History: Final params: – {shop_name: "Aesir Spells & Items", shop_type: "aesir", limit: 50} (unified-teller.js, line 2671)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/transactions?shop_name=Aesir+Spells+%26+Items&shop_type=aesir&limit=50" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "49b5ea96ee"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: []} (jotun-comprehensive-api.js, line 39)
[Log] 🔍 DEBUG Transaction History: API response: – {data: []} (unified-teller.js, line 2673)
[Log] 🔍 DEBUG Render Transaction History: transactions received: – [] (0) (unified-teller.js, line 2824)
[Log] 🔍 DEBUG Render Transaction History: selectedShop: – "138" (unified-teller.js, line 2825)
[Log] 🔍 DEBUG Render Transaction History: Empty state message: – "<div class=\"transaction-item\">Select a customer to view their Aesir ledger balance</div>" (unified-teller.js, line 2861)
[Log] handleCustomerSearch called with: – "T" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] handleCustomerSearch called with: – "Th" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object, Object, Object, …] (40) (unified-teller.js, line 3970)
[Object, Object, Object, Object, Object, Object, Object, Object, Object, Object, …]Array (40)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
	handleCustomerSearch (unified-teller.js:3918)
[Log] handleCustomerSearch called with: – "Tho" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object, Object, Object, …] (7) (unified-teller.js, line 3970)
[Object, Object, Object, Object, Object, Object, Object]Array (7)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
	handleCustomerSearch (unified-teller.js:3918)
[Log] handleCustomerSearch called with: – "Thor" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object, Object, Object, …] (6) (unified-teller.js, line 3970)
[Object, Object, Object, Object, Object, Object]Array (6)
[Log] Exact match found: – "Thor" (unified-teller.js, line 3978)
[Log] 🔍 DEBUG Auto-loading: this.selectedShop = – "138" (unified-teller.js, line 3993)
[Log] 🔍 DEBUG Auto-loading: selectedOption = –  (unified-teller.js, line 3995)
<option value="138" data-shop-name="Aesir Spells & Items" data-shop-type="aesir" data-current-rotation="1">Aesir Spells & Items</option>

<option value="138" data-shop-name="Aesir Spells & Items" data-shop-type="aesir" data-current-rotation="1">Aesir Spells & Items</option>
[Log] 🔍 DEBUG Auto-loading: shopType = – "aesir" (unified-teller.js, line 3997)
[Log] Auto-loading Aesir ledger balance for exact match: – "Thor" (unified-teller.js, line 4001)
[Log] 🔍 DEBUG Load Aesir Ledger: Fetching balance for customer: – "Thor" (unified-teller.js, line 2741)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/ledger/Thor" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "49b5ea96ee"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {player_name: "Thor", balances: [{item_name: "Vidar's Hammer", quantity: 1, column_name: "vidar"}, {item_name: "Unbreakable Oath", quantity: 3, column_name: "unbreakableoath"}, {item_name: "Eternal Flame", quantity: 1, column_name: "eternalflame"}], last_updated: "2025-10-04 11:26:21"} (jotun-comprehensive-api.js, line 39)
[Log] 🔍 DEBUG Load Aesir Ledger: API response: – {player_name: "Thor", balances: [{item_name: "Vidar's Hammer", quantity: 1, column_name: "vidar"}, {item_name: "Unbreakable Oath", quantity: 3, column_name: "unbreakableoath"}, {item_name: "Eternal Flame", quantity: 1, column_name: "eternalflame"}], last_updated: "2025-10-04 11:26:21"} (unified-teller.js, line 2743)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
[Log] 🔍 DEBUG Enter key: Customer already loaded, skipping (unified-teller.js, line 4230)
[Log] handleCustomerSearch called with: – "Tho" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object, Object, Object, …] (7) (unified-teller.js, line 3970)
[Object, Object, Object, Object, Object, Object, Object]Array (7)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
	handleCustomerSearch (unified-teller.js:3918)
[Log] handleCustomerSearch called with: – "Th" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object, Object, Object, …] (40) (unified-teller.js, line 3970)
[Object, Object, Object, Object, Object, Object, Object, Object, Object, Object, …]Array (40)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
	handleCustomerSearch (unified-teller.js:3918)
[Log] handleCustomerSearch called with: – "T" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] handleCustomerSearch called with: – "" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] 🔍 DEBUG: Empty search term - clearing customer validation and transaction history (unified-teller.js, line 3935)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 3323)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 3324)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 3325)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 3326)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 3330)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3347)
[Log] getCurrentShopType: – {selectedShop: "138", selectedOption: <option>, shopType: "aesir"} (unified-teller.js, line 773)
{selectedShop: "138", selectedOption: <option>, shopType: "aesir"}Object
[Log] handleCustomerSearch called with: – "C" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] handleCustomerSearch called with: – "Ch" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object, Object, Object, …] (19) (unified-teller.js, line 3970)
[Object, Object, Object, Object, Object, Object, Object, Object, Object, Object, …]Array (19)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
	handleCustomerSearch (unified-teller.js:3918)
[Log] handleCustomerSearch called with: – "Che" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object, Object, Object, …] (7) (unified-teller.js, line 3970)
[Object, Object, Object, Object, Object, Object, Object]Array (7)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
	handleCustomerSearch (unified-teller.js:3918)
[Log] handleCustomerSearch called with: – "Cher" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object, Object] (2) (unified-teller.js, line 3970)
[Object, Object]Array (2)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
	handleCustomerSearch (unified-teller.js:3918)
[Log] handleCustomerSearch called with: – "Cheri" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object] (1) (unified-teller.js, line 3970)
[Object]Array (1)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
	handleCustomerSearch (unified-teller.js:3918)
[Log] handleCustomerSearch called with: – "Cheris" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object] (1) (unified-teller.js, line 3970)
[Object]Array (1)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
	handleCustomerSearch (unified-teller.js:3918)
[Log] handleCustomerSearch called with: – "Cherise" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object] (1) (unified-teller.js, line 3970)
[Object]Array (1)
[Log] Exact match found: – "Cherise" (unified-teller.js, line 3978)
[Log] 🔍 DEBUG Auto-loading: this.selectedShop = – "138" (unified-teller.js, line 3993)
[Log] 🔍 DEBUG Auto-loading: selectedOption = –  (unified-teller.js, line 3995)
<option value="138" data-shop-name="Aesir Spells & Items" data-shop-type="aesir" data-current-rotation="1">Aesir Spells & Items</option>

<option value="138" data-shop-name="Aesir Spells & Items" data-shop-type="aesir" data-current-rotation="1">Aesir Spells & Items</option>
[Log] 🔍 DEBUG Auto-loading: shopType = – "aesir" (unified-teller.js, line 3997)
[Log] Auto-loading Aesir ledger balance for exact match: – "Cherise" (unified-teller.js, line 4001)
[Log] 🔍 DEBUG Load Aesir Ledger: Fetching balance for customer: – "Cherise" (unified-teller.js, line 2741)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/ledger/Cherise" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "49b5ea96ee"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {player_name: "Cherise", balances: [{item_name: "Unbreakable Oath", quantity: 2, column_name: "unbreakableoath"}], last_updated: "2025-10-04 11:26:27"} (jotun-comprehensive-api.js, line 39)
[Log] 🔍 DEBUG Load Aesir Ledger: API response: – {player_name: "Cherise", balances: [{item_name: "Unbreakable Oath", quantity: 2, column_name: "unbreakableoath"}], last_updated: "2025-10-04 11:26:27"} (unified-teller.js, line 2743)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
[Log] 🔍 DEBUG Enter key: Customer already loaded, skipping (unified-teller.js, line 4230)
[Log] handleCustomerSearch called with: – "G" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] handleCustomerSearch called with: – "Gu" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object, Object, Object, …] (13) (unified-teller.js, line 3970)
[Object, Object, Object, Object, Object, Object, Object, Object, Object, Object, …]Array (13)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
	handleCustomerSearch (unified-teller.js:3918)
[Log] handleCustomerSearch called with: – "Gun" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object, Object, Object, …] (5) (unified-teller.js, line 3970)
[Object, Object, Object, Object, Object]Array (5)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
	handleCustomerSearch (unified-teller.js:3918)
[Log] handleCustomerSearch called with: – "Gunn" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object, Object, Object] (3) (unified-teller.js, line 3970)
[Object, Object, Object]Array (3)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
	handleCustomerSearch (unified-teller.js:3918)
[Log] handleCustomerSearch called with: – "Gunna" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object, Object] (2) (unified-teller.js, line 3970)
[Object, Object]Array (2)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
	handleCustomerSearch (unified-teller.js:3918)
[Log] handleCustomerSearch called with: – "Gunnar" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object, Object] (2) (unified-teller.js, line 3970)
[Object, Object]Array (2)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
	handleCustomerSearch (unified-teller.js:3918)
[Log] handleCustomerSearch called with: – "Gunnar " (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object, Object] (2) (unified-teller.js, line 3970)
[Object, Object]Array (2)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
	handleCustomerSearch (unified-teller.js:3918)
[Log] handleCustomerSearch called with: – "Gunnar S" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object] (1) (unified-teller.js, line 3970)
[Object]Array (1)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
	handleCustomerSearch (unified-teller.js:3918)
[Log] handleCustomerSearch called with: – "Gunnar Sv" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object] (1) (unified-teller.js, line 3970)
[Object]Array (1)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
	handleCustomerSearch (unified-teller.js:3918)
[Log] handleCustomerSearch called with: – "Gunnar Sve" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object] (1) (unified-teller.js, line 3970)
[Object]Array (1)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
	handleCustomerSearch (unified-teller.js:3918)
[Log] handleCustomerSearch called with: – "Gunnar Sven" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object] (1) (unified-teller.js, line 3970)
[Object]Array (1)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
	handleCustomerSearch (unified-teller.js:3918)
[Log] handleCustomerSearch called with: – "Gunnar Svens" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object] (1) (unified-teller.js, line 3970)
[Object]Array (1)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
	handleCustomerSearch (unified-teller.js:3918)
[Log] handleCustomerSearch called with: – "Gunnar Svenss" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object] (1) (unified-teller.js, line 3970)
[Object]Array (1)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
	handleCustomerSearch (unified-teller.js:3918)
[Log] handleCustomerSearch called with: – "Gunnar Svensso" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object] (1) (unified-teller.js, line 3970)
[Object]Array (1)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
	handleCustomerSearch (unified-teller.js:3918)
[Log] handleCustomerSearch called with: – "Gunnar Svensson" (unified-teller.js, line 3919)
[Log] 🔍 DEBUG Flags: isSelectingCustomer = – undefined – ", suppressDropdown =" – undefined (unified-teller.js, line 3920)
[Log] Filtered players: – [Object] (1) (unified-teller.js, line 3970)
[Object]Array (1)
[Log] Exact match found: – "Gunnar Svensson" (unified-teller.js, line 3978)
[Log] 🔍 DEBUG Auto-loading: this.selectedShop = – "138" (unified-teller.js, line 3993)
[Log] 🔍 DEBUG Auto-loading: selectedOption = –  (unified-teller.js, line 3995)
<option value="138" data-shop-name="Aesir Spells & Items" data-shop-type="aesir" data-current-rotation="1">Aesir Spells & Items</option>

<option value="138" data-shop-name="Aesir Spells & Items" data-shop-type="aesir" data-current-rotation="1">Aesir Spells & Items</option>
[Log] 🔍 DEBUG Auto-loading: shopType = – "aesir" (unified-teller.js, line 3997)
[Log] Auto-loading Aesir ledger balance for exact match: – "Gunnar Svensson" (unified-teller.js, line 4001)
[Log] 🔍 DEBUG Load Aesir Ledger: Fetching balance for customer: – "Gunnar Svensson" (unified-teller.js, line 2741)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/ledger/Gunnar%20Svensson" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "49b5ea96ee"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {player_name: "Gunnar Svensson", balances: [{item_name: "Vidar's Hammer", quantity: 1, column_name: "vidar"}], last_updated: "2025-10-04 11:26:36"} (jotun-comprehensive-api.js, line 39)
[Log] 🔍 DEBUG Load Aesir Ledger: API response: – {player_name: "Gunnar Svensson", balances: [{item_name: "Vidar's Hammer", quantity: 1, column_name: "vidar"}], last_updated: "2025-10-04 11:26:36"} (unified-teller.js, line 2743)
[Error] Unhandled promise rejection: – ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
ReferenceError: Can't find variable: exactMatch — unified-teller.js:4042
	(anonymous function) (jotun-comprehensive-api.js:540)
[Error] Unhandled Promise Rejection: ReferenceError: Can't find variable: exactMatch
	(anonymous function) (unified-teller.js:4042)
[Log] 🔍 DEBUG Enter key: Auto-loading in progress, skipping Enter processing (unified-teller.js, line 4219)