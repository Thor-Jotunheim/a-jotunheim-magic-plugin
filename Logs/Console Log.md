[Log] JQMIGRATE: Migrate is installed, version 3.4.1 (load-scripts.php, line 5)
[Log] Jotunheim Comprehensive API loaded (jotun-comprehensive-api.js, line 533)
[Log] 🚀🚀� UNIFIED TELLER: Initialization check: – {unified-teller-interface: true, teller-shop-selector: true, unified-teller-container: false, …} (unified-teller.js, line 5352)
{unified-teller-interface: true, teller-shop-selector: true, unified-teller-container: false, refresh-shop-btn: true, shouldInitialize: true}Object
[Log] 🚀🚀� UNIFIED TELLER: Conditions met, initializing UnifiedTeller... (unified-teller.js, line 5361)
[Log] �🚀🚀 UNIFIED TELLER: Event listener registered for shopRotationChanged (unified-teller.js, line 85)
[Log] DEBUG: Clear transaction button found: –  (unified-teller.js, line 110)
<button id="clear-transaction-btn" class="field-input clear-transaction-btn" onclick="console.log('🚨 DEBUG: Clear button onclick fired'); if(window.unifiedTeller) { console.log('🚨 DEBUG: unifiedTeller found, typeof clearCart:', typeof window.unifiedTeller.clearCart); try { console.log('🚨 ONCLICK: About to call clearCart'); window.unifiedTeller.clearCart(); console.log('🚨 ONCLICK: clearCart completed'); } catch(e) { console.error('🚨 ERROR in onclick clearCart():', e); console.error('🚨 ERROR stack:', e.stack); } } else { console.log('🚨 ERROR: unifiedTeller not found on window'); }">Clear Transaction</button>

<button id="clear-transaction-btn" class="field-input clear-transaction-btn" onclick="console.log('🚨 DEBUG: Clear button onclick fired'); if(window.unifiedTeller) { console.log('🚨 DEBUG: unifiedTeller found, typeof clearCart:', typeof window.unifiedTeller.clearCart); try { console.log('🚨 ONCLICK: About to call clearCart'); window.unifiedTeller.clearCart(); console.log('🚨 ONCLICK: clearCart completed'); } catch(e) { console.error('🚨 ERROR in onclick clearCart():', e); console.error('🚨 ERROR stack:', e.stack); } } else { console.log('🚨 ERROR: unifiedTeller not found on window'); }">Clear Transaction</button>
[Log] DEBUG: Clear transaction event listener attached (unified-teller.js, line 125)
[Log] UnifiedTeller: Starting to load initial data... (unified-teller.js, line 217)
[Log] JotunAPI is available, loading data... (unified-teller.js, line 233)
[Log] Loading shops for selector... (unified-teller.js, line 423)
[Log] JotunAPI status: – "object" (unified-teller.js, line 424)
[Log] jotun_api_vars: – {nonce: "16d4d0755d", rest_url: "https://jotun.games/wp-json/jotun-api/v1/"} (unified-teller.js, line 425)
[Log] Testing direct API call to: – "/wp-json/jotun-api/v1/shops" (unified-teller.js, line 433)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/shops" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
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
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
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
[Log] 🚨 DEBUG: updateCartDisplay() called (unified-teller.js, line 2195)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 3208)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 3209)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 3210)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 3211)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 3215)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3232)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 2199)
[Log] 🚨 DEBUG: updateRecordTransactionButton() called (unified-teller.js, line 2202)
[Log] DEBUG: resetItemDisplay() called. Cart length: 0 (unified-teller.js, line 2216)
[Log] DEBUG: Clearing 0 input fields (unified-teller.js, line 2232)
[Log] 🚨 DEBUG: resetItemDisplay() called (unified-teller.js, line 2206)
[Log] 🚨 DEBUG: showShopView() called (unified-teller.js, line 3167)
[Log] 🚨 DEBUG: Setting isCartView to false (unified-teller.js, line 3168)
[Log] 🚨 DEBUG: shopInventoryCard found: – true (unified-teller.js, line 3173)
[Log] 🚨 DEBUG: transactionSummaryCard found: – true (unified-teller.js, line 3180)
[Log] 🚨 DEBUG: Buttons found - viewCart: – true – "record:" – true – "back:" – true (unified-teller.js, line 3190)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 3208)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 3209)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 3210)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 3211)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 3215)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3232)
[Log] 🚨 DEBUG: showShopView() called (unified-teller.js, line 2210)
[Log] 🚨🚨🚨 DEBUG: clearCart() completed - CART CLEARING FINISHED (unified-teller.js, line 2212)
[Log] Loading shop items for shop ID: – "140" – "rotation:" – "1" (unified-teller.js, line 660)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/shop-items?shop_id=140&rotation=1" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] DEBUG: About to force button state update. Cart length: 0 (unified-teller.js, line 2246)
[Log] 🚨 DEBUG: forceButtonStateUpdate() called, cart length: – 0 (unified-teller.js, line 2327)
[Log] 🚨 DEBUG: Cart contents: – [] (0) (unified-teller.js, line 2328)
[Log] 🚨 DEBUG: Found 0 turn-in buttons to update (unified-teller.js, line 2341)
[Log] 🚨 DEBUG: forceButtonStateUpdate() completed (unified-teller.js, line 2368)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: Array} (jotun-comprehensive-api.js, line 39)
{data: Array}Object
[Log] Raw shop items from API: – [Object, Object, Object, …] (7) (unified-teller.js, line 665)
[Object, Object, Object, Object, Object, Object, Object]Array (7)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/itemlist" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: Array} (jotun-comprehensive-api.js, line 39)
{data: Array}Object
[Log] Item list response: – {data: Array} (unified-teller.js, line 669)
{data: Array}Object
[Log] Enriched shop items: – [Object, Object, Object, …] (7) (unified-teller.js, line 722)
[Object, Object, Object, Object, Object, Object, Object]Array (7)
[Log] No individual buy button found for item: – "Fader Trophy" (unified-teller.js, line 1149)
[Log] No sell button found for item: – "Fader Trophy" (unified-teller.js, line 1180)
[Log] No turn-in button found for item: – "Fader Trophy" (unified-teller.js, line 1195)
[Log] No individual buy button found for item: – "The Queen Trophy" (unified-teller.js, line 1149)
[Log] No sell button found for item: – "The Queen Trophy" (unified-teller.js, line 1180)
[Log] No turn-in button found for item: – "The Queen Trophy" (unified-teller.js, line 1195)
[Log] No individual buy button found for item: – "Yagluth Trophy" (unified-teller.js, line 1149)
[Log] No sell button found for item: – "Yagluth Trophy" (unified-teller.js, line 1180)
[Log] No turn-in button found for item: – "Yagluth Trophy" (unified-teller.js, line 1195)
[Log] No individual buy button found for item: – "Moder Trophy" (unified-teller.js, line 1149)
[Log] No sell button found for item: – "Moder Trophy" (unified-teller.js, line 1180)
[Log] No turn-in button found for item: – "Moder Trophy" (unified-teller.js, line 1195)
[Log] No individual buy button found for item: – "Bonemass Trophy" (unified-teller.js, line 1149)
[Log] No sell button found for item: – "Bonemass Trophy" (unified-teller.js, line 1180)
[Log] No turn-in button found for item: – "Bonemass Trophy" (unified-teller.js, line 1195)
[Log] No individual buy button found for item: – "The Elder Trophy" (unified-teller.js, line 1149)
[Log] No sell button found for item: – "The Elder Trophy" (unified-teller.js, line 1180)
[Log] No turn-in button found for item: – "The Elder Trophy" (unified-teller.js, line 1195)
[Log] No individual buy button found for item: – "Eikthyr Trophy" (unified-teller.js, line 1149)
[Log] No sell button found for item: – "Eikthyr Trophy" (unified-teller.js, line 1180)
[Log] No turn-in button found for item: – "Eikthyr Trophy" (unified-teller.js, line 1195)
[Log] getCurrentShopType: – {selectedShop: "140", selectedOption: <option>, shopType: "staff"} (unified-teller.js, line 773)
{selectedShop: "140", selectedOption: <option>, shopType: "staff"}Object
[Log] Setting up tracking interface: – {selectedShop: "140", shopType: "staff", isTurnInOnly: false} (unified-teller.js, line 728)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 3208)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 3209)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 3210)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 3211)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 3215)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3232)
[Log] 🔍 DEBUG Transaction History: selectedShop: – "140" (unified-teller.js, line 2607)
[Log] 🔍 DEBUG Transaction History: selectedOption: –  (unified-teller.js, line 2608)
<option value="140" data-shop-name="Popup Shop" data-shop-type="staff" data-current-rotation="1">Popup Shop</option>

<option value="140" data-shop-name="Popup Shop" data-shop-type="staff" data-current-rotation="1">Popup Shop</option>
[Log] 🔍 DEBUG Transaction History: shopName from dataset: – "Popup Shop" (unified-teller.js, line 2609)
[Log] 🔍 DEBUG Transaction History: shopType from dataset: – "staff" (unified-teller.js, line 2610)
[Log] 🔍 DEBUG Transaction History: customerFromTransaction: – null (unified-teller.js, line 2611)
[Log] 🔍 DEBUG Transaction History: Added shop_name filter: – "Popup Shop" (unified-teller.js, line 2642)
[Log] 🔍 DEBUG Transaction History: Final params: – {shop_name: "Popup Shop", limit: 50} (unified-teller.js, line 2649)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/transactions?shop_name=Popup+Shop&limit=50" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: Array} (jotun-comprehensive-api.js, line 39)
{data: Array}Object
[Log] 🔍 DEBUG Transaction History: API response: – {data: Array} (unified-teller.js, line 2651)
{data: Array}Object
[Log] 🔍 DEBUG Render Transaction History: transactions received: – [Object, Object] (2) (unified-teller.js, line 2725)
[Object, Object]Array (2)
[Log] 🔍 DEBUG Render Transaction History: selectedShop: – "140" (unified-teller.js, line 2726)
[Log] 🚨 DEBUG: Current cart contents: – [] (0) (unified-teller.js, line 2189)
[Log] 🚨 DEBUG: Cart array set to empty. New length: – 0 (unified-teller.js, line 2192)
[Log] 🚨 DEBUG: updateCartDisplay() called (unified-teller.js, line 2195)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 3208)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 3209)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 3210)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 3211)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 3215)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3232)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 2199)
[Log] 🚨 DEBUG: updateRecordTransactionButton() called (unified-teller.js, line 2202)
[Log] DEBUG: resetItemDisplay() called. Cart length: 0 (unified-teller.js, line 2216)
[Log] DEBUG: Clearing 0 input fields (unified-teller.js, line 2232)
[Log] No individual buy button found for item: – "Fader Trophy" (unified-teller.js, line 1149)
[Log] No sell button found for item: – "Fader Trophy" (unified-teller.js, line 1180)
[Log] No turn-in button found for item: – "Fader Trophy" (unified-teller.js, line 1195)
[Log] No individual buy button found for item: – "The Queen Trophy" (unified-teller.js, line 1149)
[Log] No sell button found for item: – "The Queen Trophy" (unified-teller.js, line 1180)
[Log] No turn-in button found for item: – "The Queen Trophy" (unified-teller.js, line 1195)
[Log] No individual buy button found for item: – "Yagluth Trophy" (unified-teller.js, line 1149)
[Log] No sell button found for item: – "Yagluth Trophy" (unified-teller.js, line 1180)
[Log] No turn-in button found for item: – "Yagluth Trophy" (unified-teller.js, line 1195)
[Log] No individual buy button found for item: – "Moder Trophy" (unified-teller.js, line 1149)
[Log] No sell button found for item: – "Moder Trophy" (unified-teller.js, line 1180)
[Log] No turn-in button found for item: – "Moder Trophy" (unified-teller.js, line 1195)
[Log] No individual buy button found for item: – "Bonemass Trophy" (unified-teller.js, line 1149)
[Log] No sell button found for item: – "Bonemass Trophy" (unified-teller.js, line 1180)
[Log] No turn-in button found for item: – "Bonemass Trophy" (unified-teller.js, line 1195)
[Log] No individual buy button found for item: – "The Elder Trophy" (unified-teller.js, line 1149)
[Log] No sell button found for item: – "The Elder Trophy" (unified-teller.js, line 1180)
[Log] No turn-in button found for item: – "The Elder Trophy" (unified-teller.js, line 1195)
[Log] No individual buy button found for item: – "Eikthyr Trophy" (unified-teller.js, line 1149)
[Log] No sell button found for item: – "Eikthyr Trophy" (unified-teller.js, line 1180)
[Log] No turn-in button found for item: – "Eikthyr Trophy" (unified-teller.js, line 1195)
[Log] 🚨 DEBUG: resetItemDisplay() called (unified-teller.js, line 2206)
[Log] 🚨 DEBUG: showShopView() called (unified-teller.js, line 3167)
[Log] 🚨 DEBUG: Setting isCartView to false (unified-teller.js, line 3168)
[Log] 🚨 DEBUG: shopInventoryCard found: – true (unified-teller.js, line 3173)
[Log] 🚨 DEBUG: transactionSummaryCard found: – true (unified-teller.js, line 3180)
[Log] 🚨 DEBUG: Buttons found - viewCart: – true – "record:" – true – "back:" – true (unified-teller.js, line 3190)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 3208)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 3209)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 3210)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 3211)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 3215)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3232)
[Log] 🚨 DEBUG: showShopView() called (unified-teller.js, line 2210)
[Log] 🚨🚨🚨 DEBUG: clearCart() completed - CART CLEARING FINISHED (unified-teller.js, line 2212)
[Log] Loading turn-in items for shop ID: – "139" – "rotation:" – "1" (unified-teller.js, line 884)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/shop-items?shop_id=139&rotation=1" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: Array} (jotun-comprehensive-api.js, line 39)
{data: Array}Object
[Log] Turn-in items response: – {data: Array} (unified-teller.js, line 887)
{data: Array}Object
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/itemlist" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] DEBUG: About to force button state update. Cart length: 0 (unified-teller.js, line 2246)
[Log] 🚨 DEBUG: forceButtonStateUpdate() called, cart length: – 0 (unified-teller.js, line 2327)
[Log] 🚨 DEBUG: Cart contents: – [] (0) (unified-teller.js, line 2328)
[Log] 🚨 DEBUG: Found 0 turn-in buttons to update (unified-teller.js, line 2341)
[Log] 🚨 DEBUG: forceButtonStateUpdate() completed (unified-teller.js, line 2368)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: Array} (jotun-comprehensive-api.js, line 39)
{data: Array}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "242", …} (unified-teller.js, line 1940)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "242", parsed: 242, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 242, turnInRequirement: 4000, …} (unified-teller.js, line 1960)
{itemName: "Bear Hide", dailyTotal: 242, turnInRequirement: 4000, remaining: 3758, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "242", …} (unified-teller.js, line 1940)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "242", parsed: 242, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 242, turnInRequirement: 4000, …} (unified-teller.js, line 1960)
{itemName: "Bear Hide", dailyTotal: 242, turnInRequirement: 4000, remaining: 3758, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "242", …} (unified-teller.js, line 1940)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "242", parsed: 242, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 242, turnInRequirement: 4000, …} (unified-teller.js, line 1960)
{itemName: "Bear Hide", dailyTotal: 242, turnInRequirement: 4000, remaining: 3758, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "242", …} (unified-teller.js, line 1940)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "242", parsed: 242, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 242, turnInRequirement: 4000, …} (unified-teller.js, line 1960)
{itemName: "Bear Hide", dailyTotal: 242, turnInRequirement: 4000, remaining: 3758, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "242", …} (unified-teller.js, line 1940)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "242", parsed: 242, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 242, currentlySelected: 0, …} (unified-teller.js, line 3771)
{itemName: "Bear Hide", dailyTotal: 242, currentlySelected: 0, projectedTotal: 242, turnInRequirement: 4000, …}Object
[Log] Generating button for item 41: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1494)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1940)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1960)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1940)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1960)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1940)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1960)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1940)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1960)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1940)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, …} (unified-teller.js, line 3771)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, projectedTotal: 4, turnInRequirement: 250, …}Object
[Log] Generating button for item 38: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1494)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1960)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1960)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1960)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1960)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3771)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 1500, …}Object
[Log] Generating button for item 43: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1494)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1960)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1960)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1960)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1960)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3771)
{itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 50, …}Object
[Log] Generating button for item 40: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1494)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1960)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1960)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1960)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1960)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3771)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 2000, …}Object
[Log] Generating button for item 42: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1494)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1960)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1960)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1960)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1960)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3771)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 125, …}Object
[Log] Generating button for item 39: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1494)
[Log] Setting up turn-in tracking after loading items (unified-teller.js, line 922)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "242", …} (unified-teller.js, line 1940)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "242", parsed: 242, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 242, currentTransactionQty: 0, …} (unified-teller.js, line 807)
{itemName: "Bear Hide", dailyCollected: 242, currentTransactionQty: 0, projected: 242, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1940)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 807)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 807)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 807)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 807)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 807)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 3208)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 3209)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 3210)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 3211)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 3215)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3232)
[Log] 🔍 DEBUG Transaction History: selectedShop: – "139" (unified-teller.js, line 2607)
[Log] 🔍 DEBUG Transaction History: selectedOption: –  (unified-teller.js, line 2608)
<option value="139" data-shop-name="Call to Arms" data-shop-type="turn-in_only" data-current-rotation="1">Call to Arms</option>

<option value="139" data-shop-name="Call to Arms" data-shop-type="turn-in_only" data-current-rotation="1">Call to Arms</option>
[Log] 🔍 DEBUG Transaction History: shopName from dataset: – "Call to Arms" (unified-teller.js, line 2609)
[Log] 🔍 DEBUG Transaction History: shopType from dataset: – "turn-in_only" (unified-teller.js, line 2610)
[Log] 🔍 DEBUG Transaction History: customerFromTransaction: – null (unified-teller.js, line 2611)
[Log] 🔍 DEBUG Transaction History: Set transaction_type=turnin, shop_id=139 (unified-teller.js, line 2620)
[Log] 🔍 DEBUG Transaction History: Added shop_name filter: – "Call to Arms" (unified-teller.js, line 2642)
[Log] 🔍 DEBUG Transaction History: Final params: – {shop_name: "Call to Arms", transaction_type: "turnin", shop_id: "139", …} (unified-teller.js, line 2649)
{shop_name: "Call to Arms", transaction_type: "turnin", shop_id: "139", limit: 50}Object
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/transactions?shop_name=Call+to+Arms&transaction_type=turnin&shop_id=139&limit=50" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: Array} (jotun-comprehensive-api.js, line 39)
{data: Array}Object
[Log] 🔍 DEBUG Transaction History: API response: – {data: Array} (unified-teller.js, line 2651)
{data: Array}Object
[Log] 🔍 DEBUG Render Transaction History: transactions received: – [Object, Object, Object] (3) (unified-teller.js, line 2725)
[Object, Object, Object]Array (3)
[Log] 🔍 DEBUG Render Transaction History: selectedShop: – "139" (unified-teller.js, line 2726)
[Log] 🚨 DEBUG: Current cart contents: – [] (0) (unified-teller.js, line 2189)
[Log] 🚨 DEBUG: Cart array set to empty. New length: – 0 (unified-teller.js, line 2192)
[Log] 🚨 DEBUG: updateCartDisplay() called (unified-teller.js, line 2195)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 3208)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 3209)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 3210)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 3211)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 3215)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3232)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 2199)
[Log] 🚨 DEBUG: updateRecordTransactionButton() called (unified-teller.js, line 2202)
[Log] DEBUG: resetItemDisplay() called. Cart length: 0 (unified-teller.js, line 2216)
[Log] DEBUG: Clearing 12 input fields (unified-teller.js, line 2232)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "242", …} (unified-teller.js, line 1940)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "242", parsed: 242, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 242, turnInRequirement: 4000, …} (unified-teller.js, line 1960)
{itemName: "Bear Hide", dailyTotal: 242, turnInRequirement: 4000, remaining: 3758, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "242", …} (unified-teller.js, line 1940)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "242", parsed: 242, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 242, turnInRequirement: 4000, …} (unified-teller.js, line 1960)
{itemName: "Bear Hide", dailyTotal: 242, turnInRequirement: 4000, remaining: 3758, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "242", …} (unified-teller.js, line 1940)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "242", parsed: 242, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 242, turnInRequirement: 4000, …} (unified-teller.js, line 1960)
{itemName: "Bear Hide", dailyTotal: 242, turnInRequirement: 4000, remaining: 3758, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "242", …} (unified-teller.js, line 1940)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "242", parsed: 242, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 242, turnInRequirement: 4000, …} (unified-teller.js, line 1960)
{itemName: "Bear Hide", dailyTotal: 242, turnInRequirement: 4000, remaining: 3758, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "242", …} (unified-teller.js, line 1940)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "242", parsed: 242, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 242, currentlySelected: 0, …} (unified-teller.js, line 3771)
{itemName: "Bear Hide", dailyTotal: 242, currentlySelected: 0, projectedTotal: 242, turnInRequirement: 4000, …}Object
[Log] Generating button for item 41: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1494)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1940)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1960)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1940)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1960)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1940)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1960)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1940)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1960)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1940)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, …} (unified-teller.js, line 3771)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, projectedTotal: 4, turnInRequirement: 250, …}Object
[Log] Generating button for item 38: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1494)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1960)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1960)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1960)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1960)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3771)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 1500, …}Object
[Log] Generating button for item 43: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1494)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1960)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1960)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1960)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1960)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3771)
{itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 50, …}Object
[Log] Generating button for item 40: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1494)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1960)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1960)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1960)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1960)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3771)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 2000, …}Object
[Log] Generating button for item 42: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1494)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1960)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1960)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1960)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1960)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1940)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3771)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 125, …}Object
[Log] Generating button for item 39: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1494)
[Log] 🚨 DEBUG: resetItemDisplay() called (unified-teller.js, line 2206)
[Log] 🚨 DEBUG: showShopView() called (unified-teller.js, line 3167)
[Log] 🚨 DEBUG: Setting isCartView to false (unified-teller.js, line 3168)
[Log] 🚨 DEBUG: shopInventoryCard found: – true (unified-teller.js, line 3173)
[Log] 🚨 DEBUG: transactionSummaryCard found: – true (unified-teller.js, line 3180)
[Log] 🚨 DEBUG: Buttons found - viewCart: – true – "record:" – true – "back:" – true (unified-teller.js, line 3190)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 3208)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 3209)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 3210)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 3211)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 3215)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3232)
[Log] 🚨 DEBUG: showShopView() called (unified-teller.js, line 2210)
[Log] 🚨🚨🚨 DEBUG: clearCart() completed - CART CLEARING FINISHED (unified-teller.js, line 2212)
[Log] Loading shop items for shop ID: – "138" – "rotation:" – "1" (unified-teller.js, line 660)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/shop-items?shop_id=138&rotation=1" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: Array} (jotun-comprehensive-api.js, line 39)
{data: Array}Object
[Log] Raw shop items from API: – [Object] (1) (unified-teller.js, line 665)
[Object]Array (1)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/itemlist" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] DEBUG: About to force button state update. Cart length: 0 (unified-teller.js, line 2246)
[Log] 🚨 DEBUG: forceButtonStateUpdate() called, cart length: – 0 (unified-teller.js, line 2327)
[Log] 🚨 DEBUG: Cart contents: – [] (0) (unified-teller.js, line 2328)
[Log] 🚨 DEBUG: Found 6 turn-in buttons to update (unified-teller.js, line 2341)
[Log] 🚨 DEBUG: Button for item 41: inCart=false, current text="Turn In", cart.length=0 (unified-teller.js, line 2354)
[Log] 🚨 DEBUG: Button for item 38: inCart=false, current text="Turn In", cart.length=0 (unified-teller.js, line 2354)
[Log] 🚨 DEBUG: Button for item 43: inCart=false, current text="Turn In", cart.length=0 (unified-teller.js, line 2354)
[Log] 🚨 DEBUG: Button for item 40: inCart=false, current text="Turn In", cart.length=0 (unified-teller.js, line 2354)
[Log] 🚨 DEBUG: Button for item 42: inCart=false, current text="Turn In", cart.length=0 (unified-teller.js, line 2354)
[Log] 🚨 DEBUG: Button for item 39: inCart=false, current text="Turn In", cart.length=0 (unified-teller.js, line 2354)
[Log] 🚨 DEBUG: forceButtonStateUpdate() completed (unified-teller.js, line 2368)
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
[Log] getCurrentShopType: – {selectedShop: "138", selectedOption: <option>, shopType: "aesir"} (unified-teller.js, line 773)
{selectedShop: "138", selectedOption: <option>, shopType: "aesir"}Object
[Log] Setting up tracking interface: – {selectedShop: "138", shopType: "aesir", isTurnInOnly: false} (unified-teller.js, line 728)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 3208)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 3209)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 3210)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 3211)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 3215)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3232)
[Log] 🔍 DEBUG Transaction History: selectedShop: – "138" (unified-teller.js, line 2607)
[Log] 🔍 DEBUG Transaction History: selectedOption: –  (unified-teller.js, line 2608)
<option value="138" data-shop-name="Aesir Spells & Items" data-shop-type="aesir" data-current-rotation="1">Aesir Spells & Items</option>

<option value="138" data-shop-name="Aesir Spells & Items" data-shop-type="aesir" data-current-rotation="1">Aesir Spells & Items</option>
[Log] 🔍 DEBUG Transaction History: shopName from dataset: – "Aesir Spells & Items" (unified-teller.js, line 2609)
[Log] 🔍 DEBUG Transaction History: shopType from dataset: – "aesir" (unified-teller.js, line 2610)
[Log] 🔍 DEBUG Transaction History: customerFromTransaction: – null (unified-teller.js, line 2611)
[Log] 🔍 DEBUG Transaction History: Aesir shop detected - checking for customer to show ledger balance (unified-teller.js, line 2623)
[Log] 🔍 DEBUG Transaction History: No customer selected for Aesir shop (unified-teller.js, line 2637)
[Log] 🔍 DEBUG Transaction History: Added shop_name filter: – "Aesir Spells & Items" (unified-teller.js, line 2642)
[Log] 🔍 DEBUG Transaction History: Final params: – {shop_name: "Aesir Spells & Items", limit: 50} (unified-teller.js, line 2649)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/transactions?shop_name=Aesir+Spells+%26+Items&limit=50" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: []} (jotun-comprehensive-api.js, line 39)
[Log] 🔍 DEBUG Transaction History: API response: – {data: []} (unified-teller.js, line 2651)
[Log] 🔍 DEBUG Render Transaction History: transactions received: – [] (0) (unified-teller.js, line 2725)
[Log] 🔍 DEBUG Render Transaction History: selectedShop: – "138" (unified-teller.js, line 2726)
[Log] 🔍 DEBUG Render Transaction History: Empty state message: – "<div class=\"transaction-item\">Aesir shops use a balance system (jotun_ledger) rather than individual transaction records</div>" (unified-teller.js, line 2746)
[Log] handleCustomerSearch called with: – "T" (unified-teller.js, line 3804)
[Log] handleCustomerSearch called with: – "Te" (unified-teller.js, line 3804)
[Log] Filtered players: – [Object, Object, Object, …] (44) (unified-teller.js, line 3834)
[Object, Object, Object, Object, Object, Object, Object, Object, Object, Object, …]Array (44)
[Log] handleCustomerSearch called with: – "Tes" (unified-teller.js, line 3804)
[Log] Filtered players: – [Object, Object, Object, …] (16) (unified-teller.js, line 3834)
[Object, Object, Object, Object, Object, Object, Object, Object, Object, Object, …]Array (16)
[Log] handleCustomerSearch called with: – "Test" (unified-teller.js, line 3804)
[Log] Filtered players: – [Object, Object, Object, …] (12) (unified-teller.js, line 3834)
[Object, Object, Object, Object, Object, Object, Object, Object, Object, Object, …]Array (12)
[Log] Exact match found: – "Test" (unified-teller.js, line 3842)
[Log] Validating customer: – "Test" (unified-teller.js, line 1674)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/playerlist?search=Test" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: Array} (jotun-comprehensive-api.js, line 39)
{data: Array}Object
[Log] Search API response: – {data: Array} (unified-teller.js, line 1678)
{data: Array}Object
[Log] Players found from search: – [Object, Object, Object, …] (12) (unified-teller.js, line 1680)
[Object, Object, Object, Object, Object, Object, Object, Object, Object, Object, …]Array (12)
[Log] Checking player: Test4, exactMatch: false, partialMatch: true (unified-teller.js, line 1705)
[Log] Player found result: – {id: "715", score: "0", level: "1", …} (unified-teller.js, line 1709)
{id: "715", score: "0", level: "1", created_at: "2025-09-27 15:26:20", steam_id: "", …}Object
[Log] Validation successful for: – "Test4" (unified-teller.js, line 1711)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 3208)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 3209)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 3210)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 3211)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 3215)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3232)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/transactions?customer_name=Test4&transaction_type=turnin&hours=24" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: []} (jotun-comprehensive-api.js, line 39)
[Log] Daily turn-in data loaded: – {} (unified-teller.js, line 949)
[Log] 🔍 DEBUG Transaction History: selectedShop: – "138" (unified-teller.js, line 2607)
[Log] 🔍 DEBUG Transaction History: selectedOption: –  (unified-teller.js, line 2608)
<option value="138" data-shop-name="Aesir Spells & Items" data-shop-type="aesir" data-current-rotation="1">Aesir Spells & Items</option>

<option value="138" data-shop-name="Aesir Spells & Items" data-shop-type="aesir" data-current-rotation="1">Aesir Spells & Items</option>
[Log] 🔍 DEBUG Transaction History: shopName from dataset: – "Aesir Spells & Items" (unified-teller.js, line 2609)
[Log] 🔍 DEBUG Transaction History: shopType from dataset: – "aesir" (unified-teller.js, line 2610)
[Log] 🔍 DEBUG Transaction History: customerFromTransaction: – "Test" (unified-teller.js, line 2611)
[Log] 🔍 DEBUG Transaction History: Aesir shop detected - checking for customer to show ledger balance (unified-teller.js, line 2623)
[Log] 🔍 DEBUG Transaction History: Customer selected, showing ledger balance for: – "Test" (unified-teller.js, line 2633)
[Log] 🔍 DEBUG Ledger Balance: Fetching balance for customer: – "Test" (unified-teller.js, line 2662)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/ledger/Test" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {player_name: "Test", balances: [], last_updated: "2025-10-03 22:19:02"} (jotun-comprehensive-api.js, line 39)
[Log] 🔍 DEBUG Ledger Balance: API response: – {player_name: "Test", balances: [], last_updated: "2025-10-03 22:19:02"} (unified-teller.js, line 2664)
[Log] Preserving quantities and re-rendering items... (unified-teller.js, line 3492)
[Log] Saved buy-qty-44: 1 (unified-teller.js, line 3509)
[Log] No individual buy button found for item: – "Unbreakable Oath" (unified-teller.js, line 1149)
[Log] No sell button found for item: – "Unbreakable Oath" (unified-teller.js, line 1180)
[Log] No turn-in button found for item: – "Unbreakable Oath" (unified-teller.js, line 1195)
[Log] Restored buy-qty-44: 1 (unified-teller.js, line 3522)
[Log] Recalculating all progress displays based on current input values... (unified-teller.js, line 3532)
[Log] Progress recalculation complete. (unified-teller.js, line 3554)
[Log] handleCustomerSearch called with: – "G" (unified-teller.js, line 3804)
[Log] handleCustomerSearch called with: – "Gu" (unified-teller.js, line 3804)
[Log] Filtered players: – [Object, Object, Object, …] (13) (unified-teller.js, line 3834)
[Object, Object, Object, Object, Object, Object, Object, Object, Object, Object, …]Array (13)
[Log] handleCustomerSearch called with: – "Gun" (unified-teller.js, line 3804)
[Log] Filtered players: – [Object, Object, Object, …] (5) (unified-teller.js, line 3834)
[Object, Object, Object, Object, Object]Array (5)
[Log] handleCustomerSearch called with: – "Gunn" (unified-teller.js, line 3804)
[Log] Filtered players: – [Object, Object, Object] (3) (unified-teller.js, line 3834)
[Object, Object, Object]Array (3)
[Log] handleCustomerSearch called with: – "Gunna" (unified-teller.js, line 3804)
[Log] Filtered players: – [Object, Object] (2) (unified-teller.js, line 3834)
[Object, Object]Array (2)
[Log] handleCustomerSearch called with: – "Gunnar" (unified-teller.js, line 3804)
[Log] Filtered players: – [Object, Object] (2) (unified-teller.js, line 3834)
[Object, Object]Array (2)
[Log] Validating customer: – "Gunnar" (unified-teller.js, line 1674)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/playerlist?search=Gunnar" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: Array} (jotun-comprehensive-api.js, line 39)
{data: Array}Object
[Log] Search API response: – {data: Array} (unified-teller.js, line 1678)
{data: Array}Object
[Log] Players found from search: – [Object, Object] (2) (unified-teller.js, line 1680)
[Object, Object]Array (2)
[Log] Checking player: Gunnar Uthwagin, exactMatch: false, partialMatch: true (unified-teller.js, line 1705)
[Log] Player found result: – {id: "407", score: "0", level: "1", …} (unified-teller.js, line 1709)
{id: "407", score: "0", level: "1", created_at: "2025-09-22 14:25:22", steam_id: "", …}Object
[Log] Validation successful for: – "Gunnar Uthwagin" (unified-teller.js, line 1711)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 3208)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 3209)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 3210)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 3211)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 3215)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3232)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/transactions?customer_name=Gunnar+Uthwagin&transaction_type=turnin&hours=24" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: []} (jotun-comprehensive-api.js, line 39)
[Log] Daily turn-in data loaded: – {} (unified-teller.js, line 949)
[Log] 🔍 DEBUG Transaction History: selectedShop: – "138" (unified-teller.js, line 2607)
[Log] 🔍 DEBUG Transaction History: selectedOption: –  (unified-teller.js, line 2608)
<option value="138" data-shop-name="Aesir Spells & Items" data-shop-type="aesir" data-current-rotation="1">Aesir Spells & Items</option>

<option value="138" data-shop-name="Aesir Spells & Items" data-shop-type="aesir" data-current-rotation="1">Aesir Spells & Items</option>
[Log] 🔍 DEBUG Transaction History: shopName from dataset: – "Aesir Spells & Items" (unified-teller.js, line 2609)
[Log] 🔍 DEBUG Transaction History: shopType from dataset: – "aesir" (unified-teller.js, line 2610)
[Log] 🔍 DEBUG Transaction History: customerFromTransaction: – "Gunnar" (unified-teller.js, line 2611)
[Log] 🔍 DEBUG Transaction History: Aesir shop detected - checking for customer to show ledger balance (unified-teller.js, line 2623)
[Log] 🔍 DEBUG Transaction History: Customer selected, showing ledger balance for: – "Gunnar" (unified-teller.js, line 2633)
[Log] 🔍 DEBUG Ledger Balance: Fetching balance for customer: – "Gunnar" (unified-teller.js, line 2662)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/ledger/Gunnar" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Error] Failed to load resource: the server responded with a status of 404 (Not Found) (Gunnar, line 0)
[Log] Response received: – 404 – "Not Found" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {error: "Player not found in ledger"} (jotun-comprehensive-api.js, line 39)
[Error] API Request failed: – Error: HTTP error! status: 404 — jotun-comprehensive-api.js:42
Error: HTTP error! status: 404 — jotun-comprehensive-api.js:42
	(anonymous function) (jotun-comprehensive-api.js:47)
[Error] Error loading ledger balance: – Error: HTTP error! status: 404 — jotun-comprehensive-api.js:42
Error: HTTP error! status: 404 — jotun-comprehensive-api.js:42
	(anonymous function) (unified-teller.js:2703)
[Log] Preserving quantities and re-rendering items... (unified-teller.js, line 3492)
[Log] Saved buy-qty-44: 1 (unified-teller.js, line 3509)
[Log] No individual buy button found for item: – "Unbreakable Oath" (unified-teller.js, line 1149)
[Log] No sell button found for item: – "Unbreakable Oath" (unified-teller.js, line 1180)
[Log] No turn-in button found for item: – "Unbreakable Oath" (unified-teller.js, line 1195)
[Log] Restored buy-qty-44: 1 (unified-teller.js, line 3522)
[Log] Recalculating all progress displays based on current input values... (unified-teller.js, line 3532)
[Log] Progress recalculation complete. (unified-teller.js, line 3554)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/transactions?customer_name=Gunnar+Svensson&transaction_type=turnin&hours=24" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: []} (jotun-comprehensive-api.js, line 39)
[Log] Daily turn-in data loaded: – {} (unified-teller.js, line 949)
[Log] 🔍 DEBUG Transaction History: selectedShop: – "138" (unified-teller.js, line 2607)
[Log] 🔍 DEBUG Transaction History: selectedOption: –  (unified-teller.js, line 2608)
<option value="138" data-shop-name="Aesir Spells & Items" data-shop-type="aesir" data-current-rotation="1">Aesir Spells & Items</option>

<option value="138" data-shop-name="Aesir Spells & Items" data-shop-type="aesir" data-current-rotation="1">Aesir Spells & Items</option>
[Log] 🔍 DEBUG Transaction History: shopName from dataset: – "Aesir Spells & Items" (unified-teller.js, line 2609)
[Log] 🔍 DEBUG Transaction History: shopType from dataset: – "aesir" (unified-teller.js, line 2610)
[Log] 🔍 DEBUG Transaction History: customerFromTransaction: – "Gunnar Svensson" (unified-teller.js, line 2611)
[Log] 🔍 DEBUG Transaction History: Aesir shop detected - checking for customer to show ledger balance (unified-teller.js, line 2623)
[Log] 🔍 DEBUG Transaction History: Customer selected, showing ledger balance for: – "Gunnar Svensson" (unified-teller.js, line 2633)
[Log] 🔍 DEBUG Ledger Balance: Fetching balance for customer: – "Gunnar Svensson" (unified-teller.js, line 2662)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/ledger/Gunnar%20Svensson" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {player_name: "Gunnar Svensson", balances: [{item_name: "Vidar's Hammer", quantity: 1, column_name: "vidar"}], last_updated: "2025-10-03 22:19:06"} (jotun-comprehensive-api.js, line 39)
[Log] 🔍 DEBUG Ledger Balance: API response: – {player_name: "Gunnar Svensson", balances: [{item_name: "Vidar's Hammer", quantity: 1, column_name: "vidar"}], last_updated: "2025-10-03 22:19:06"} (unified-teller.js, line 2664)
[Log] Preserving quantities and re-rendering items... (unified-teller.js, line 3492)
[Log] Saved buy-qty-44: 1 (unified-teller.js, line 3509)
[Log] No individual buy button found for item: – "Unbreakable Oath" (unified-teller.js, line 1149)
[Log] No sell button found for item: – "Unbreakable Oath" (unified-teller.js, line 1180)
[Log] No turn-in button found for item: – "Unbreakable Oath" (unified-teller.js, line 1195)
[Log] Restored buy-qty-44: 1 (unified-teller.js, line 3522)
[Log] Recalculating all progress displays based on current input values... (unified-teller.js, line 3532)
[Log] Progress recalculation complete. (unified-teller.js, line 3554)
[Log] handleCustomerSearch called with: – "C" (unified-teller.js, line 3804)
[Log] handleCustomerSearch called with: – "Ch" (unified-teller.js, line 3804)
[Log] Filtered players: – [Object, Object, Object, …] (19) (unified-teller.js, line 3834)
[Object, Object, Object, Object, Object, Object, Object, Object, Object, Object, …]Array (19)
[Log] handleCustomerSearch called with: – "Che" (unified-teller.js, line 3804)
[Log] Filtered players: – [Object, Object, Object, …] (7) (unified-teller.js, line 3834)
[Object, Object, Object, Object, Object, Object, Object]Array (7)
[Log] handleCustomerSearch called with: – "Cher" (unified-teller.js, line 3804)
[Log] Filtered players: – [Object, Object] (2) (unified-teller.js, line 3834)
[Object, Object]Array (2)
[Log] Validating customer: – "Cher" (unified-teller.js, line 1674)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/playerlist?search=Cher" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/transactions?customer_name=Cherise&transaction_type=turnin&hours=24" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: Array} (jotun-comprehensive-api.js, line 39)
{data: Array}Object
[Log] Search API response: – {data: Array} (unified-teller.js, line 1678)
{data: Array}Object
[Log] Players found from search: – [Object, Object] (2) (unified-teller.js, line 1680)
[Object, Object]Array (2)
[Log] Checking player: Moonwatcher, exactMatch: false, partialMatch: false (unified-teller.js, line 1705)
[Log] Checking player: Cherise, exactMatch: false, partialMatch: true (unified-teller.js, line 1705)
[Log] Player found result: – {id: "2", score: "0", level: "1", …} (unified-teller.js, line 1709)
{id: "2", score: "0", level: "1", created_at: "2025-09-22 14:24:28", steam_id: "", …}Object
[Log] Validation successful for: – "Cherise" (unified-teller.js, line 1711)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 3208)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 3209)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 3210)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 3211)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 3215)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3232)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/transactions?customer_name=Cherise&transaction_type=turnin&hours=24" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: []} (jotun-comprehensive-api.js, line 39)
[Log] Daily turn-in data loaded: – {} (unified-teller.js, line 949)
[Log] 🔍 DEBUG Transaction History: selectedShop: – "138" (unified-teller.js, line 2607)
[Log] 🔍 DEBUG Transaction History: selectedOption: –  (unified-teller.js, line 2608)
<option value="138" data-shop-name="Aesir Spells & Items" data-shop-type="aesir" data-current-rotation="1">Aesir Spells & Items</option>

<option value="138" data-shop-name="Aesir Spells & Items" data-shop-type="aesir" data-current-rotation="1">Aesir Spells & Items</option>
[Log] 🔍 DEBUG Transaction History: shopName from dataset: – "Aesir Spells & Items" (unified-teller.js, line 2609)
[Log] 🔍 DEBUG Transaction History: shopType from dataset: – "aesir" (unified-teller.js, line 2610)
[Log] 🔍 DEBUG Transaction History: customerFromTransaction: – "Cher" (unified-teller.js, line 2611)
[Log] 🔍 DEBUG Transaction History: Aesir shop detected - checking for customer to show ledger balance (unified-teller.js, line 2623)
[Log] 🔍 DEBUG Transaction History: Customer selected, showing ledger balance for: – "Cher" (unified-teller.js, line 2633)
[Log] 🔍 DEBUG Ledger Balance: Fetching balance for customer: – "Cher" (unified-teller.js, line 2662)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/ledger/Cher" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Error] Failed to load resource: the server responded with a status of 404 (Not Found) (Cher, line 0)
[Log] Response received: – 404 – "Not Found" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {error: "Player not found in ledger"} (jotun-comprehensive-api.js, line 39)
[Error] API Request failed: – Error: HTTP error! status: 404 — jotun-comprehensive-api.js:42
Error: HTTP error! status: 404 — jotun-comprehensive-api.js:42
	(anonymous function) (jotun-comprehensive-api.js:47)
[Error] Error loading ledger balance: – Error: HTTP error! status: 404 — jotun-comprehensive-api.js:42
Error: HTTP error! status: 404 — jotun-comprehensive-api.js:42
	(anonymous function) (unified-teller.js:2703)
[Log] Preserving quantities and re-rendering items... (unified-teller.js, line 3492)
[Log] Saved buy-qty-44: 1 (unified-teller.js, line 3509)
[Log] No individual buy button found for item: – "Unbreakable Oath" (unified-teller.js, line 1149)
[Log] No sell button found for item: – "Unbreakable Oath" (unified-teller.js, line 1180)
[Log] No turn-in button found for item: – "Unbreakable Oath" (unified-teller.js, line 1195)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: []} (jotun-comprehensive-api.js, line 39)
[Log] Daily turn-in data loaded: – {} (unified-teller.js, line 949)
[Log] 🔍 DEBUG Transaction History: selectedShop: – "138" (unified-teller.js, line 2607)
[Log] 🔍 DEBUG Transaction History: selectedOption: –  (unified-teller.js, line 2608)
<option value="138" data-shop-name="Aesir Spells & Items" data-shop-type="aesir" data-current-rotation="1">Aesir Spells & Items</option>

<option value="138" data-shop-name="Aesir Spells & Items" data-shop-type="aesir" data-current-rotation="1">Aesir Spells & Items</option>
[Log] 🔍 DEBUG Transaction History: shopName from dataset: – "Aesir Spells & Items" (unified-teller.js, line 2609)
[Log] 🔍 DEBUG Transaction History: shopType from dataset: – "aesir" (unified-teller.js, line 2610)
[Log] 🔍 DEBUG Transaction History: customerFromTransaction: – "Cherise" (unified-teller.js, line 2611)
[Log] 🔍 DEBUG Transaction History: Aesir shop detected - checking for customer to show ledger balance (unified-teller.js, line 2623)
[Log] 🔍 DEBUG Transaction History: Customer selected, showing ledger balance for: – "Cherise" (unified-teller.js, line 2633)
[Log] 🔍 DEBUG Ledger Balance: Fetching balance for customer: – "Cherise" (unified-teller.js, line 2662)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/ledger/Cherise" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Restored buy-qty-44: 1 (unified-teller.js, line 3522)
[Log] Recalculating all progress displays based on current input values... (unified-teller.js, line 3532)
[Log] Progress recalculation complete. (unified-teller.js, line 3554)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {player_name: "Cherise", balances: [], last_updated: "2025-10-03 22:19:19"} (jotun-comprehensive-api.js, line 39)
[Log] 🔍 DEBUG Ledger Balance: API response: – {player_name: "Cherise", balances: [], last_updated: "2025-10-03 22:19:19"} (unified-teller.js, line 2664)
[Log] Preserving quantities and re-rendering items... (unified-teller.js, line 3492)
[Log] Saved buy-qty-44: 1 (unified-teller.js, line 3509)
[Log] No individual buy button found for item: – "Unbreakable Oath" (unified-teller.js, line 1149)
[Log] No sell button found for item: – "Unbreakable Oath" (unified-teller.js, line 1180)
[Log] No turn-in button found for item: – "Unbreakable Oath" (unified-teller.js, line 1195)
[Log] Restored buy-qty-44: 1 (unified-teller.js, line 3522)
[Log] Recalculating all progress displays based on current input values... (unified-teller.js, line 3532)
[Log] Progress recalculation complete. (unified-teller.js, line 3554)
[Log] handleCustomerSearch called with: – "T" (unified-teller.js, line 3804)
[Log] handleCustomerSearch called with: – "Te" (unified-teller.js, line 3804)
[Log] Filtered players: – [Object, Object, Object, …] (44) (unified-teller.js, line 3834)
[Object, Object, Object, Object, Object, Object, Object, Object, Object, Object, …]Array (44)
[Log] handleCustomerSearch called with: – "Tes" (unified-teller.js, line 3804)
[Log] Filtered players: – [Object, Object, Object, …] (16) (unified-teller.js, line 3834)
[Object, Object, Object, Object, Object, Object, Object, Object, Object, Object, …]Array (16)
[Log] handleCustomerSearch called with: – "Test" (unified-teller.js, line 3804)
[Log] Filtered players: – [Object, Object, Object, …] (12) (unified-teller.js, line 3834)
[Object, Object, Object, Object, Object, Object, Object, Object, Object, Object, …]Array (12)
[Log] Exact match found: – "Test" (unified-teller.js, line 3842)
[Log] Validating customer: – "Test" (unified-teller.js, line 1674)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/playerlist?search=Test" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: Array} (jotun-comprehensive-api.js, line 39)
{data: Array}Object
[Log] Search API response: – {data: Array} (unified-teller.js, line 1678)
{data: Array}Object
[Log] Players found from search: – [Object, Object, Object, …] (12) (unified-teller.js, line 1680)
[Object, Object, Object, Object, Object, Object, Object, Object, Object, Object, …]Array (12)
[Log] Checking player: Test4, exactMatch: false, partialMatch: true (unified-teller.js, line 1705)
[Log] Player found result: – {id: "715", score: "0", level: "1", …} (unified-teller.js, line 1709)
{id: "715", score: "0", level: "1", created_at: "2025-09-27 15:26:20", steam_id: "", …}Object
[Log] Validation successful for: – "Test4" (unified-teller.js, line 1711)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 3208)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 3209)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 3210)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 3211)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 3215)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3232)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/transactions?customer_name=Test4&transaction_type=turnin&hours=24" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: []} (jotun-comprehensive-api.js, line 39)
[Log] Daily turn-in data loaded: – {} (unified-teller.js, line 949)
[Log] 🔍 DEBUG Transaction History: selectedShop: – "138" (unified-teller.js, line 2607)
[Log] 🔍 DEBUG Transaction History: selectedOption: –  (unified-teller.js, line 2608)
<option value="138" data-shop-name="Aesir Spells & Items" data-shop-type="aesir" data-current-rotation="1">Aesir Spells & Items</option>

<option value="138" data-shop-name="Aesir Spells & Items" data-shop-type="aesir" data-current-rotation="1">Aesir Spells & Items</option>
[Log] 🔍 DEBUG Transaction History: shopName from dataset: – "Aesir Spells & Items" (unified-teller.js, line 2609)
[Log] 🔍 DEBUG Transaction History: shopType from dataset: – "aesir" (unified-teller.js, line 2610)
[Log] 🔍 DEBUG Transaction History: customerFromTransaction: – "Test" (unified-teller.js, line 2611)
[Log] 🔍 DEBUG Transaction History: Aesir shop detected - checking for customer to show ledger balance (unified-teller.js, line 2623)
[Log] 🔍 DEBUG Transaction History: Customer selected, showing ledger balance for: – "Test" (unified-teller.js, line 2633)
[Log] 🔍 DEBUG Ledger Balance: Fetching balance for customer: – "Test" (unified-teller.js, line 2662)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/ledger/Test" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {player_name: "Test", balances: [], last_updated: "2025-10-03 22:19:31"} (jotun-comprehensive-api.js, line 39)
[Log] 🔍 DEBUG Ledger Balance: API response: – {player_name: "Test", balances: [], last_updated: "2025-10-03 22:19:31"} (unified-teller.js, line 2664)
[Log] Preserving quantities and re-rendering items... (unified-teller.js, line 3492)
[Log] Saved buy-qty-44: 1 (unified-teller.js, line 3509)
[Log] No individual buy button found for item: – "Unbreakable Oath" (unified-teller.js, line 1149)
[Log] No sell button found for item: – "Unbreakable Oath" (unified-teller.js, line 1180)
[Log] No turn-in button found for item: – "Unbreakable Oath" (unified-teller.js, line 1195)
[Log] Restored buy-qty-44: 1 (unified-teller.js, line 3522)
[Log] Recalculating all progress displays based on current input values... (unified-teller.js, line 3532)
[Log] Progress recalculation complete. (unified-teller.js, line 3554)
[Log] handleCustomerSearch called with: – "T" (unified-teller.js, line 3804)
[Log] handleCustomerSearch called with: – "Th" (unified-teller.js, line 3804)
[Log] Filtered players: – [Object, Object, Object, …] (40) (unified-teller.js, line 3834)
[Object, Object, Object, Object, Object, Object, Object, Object, Object, Object, …]Array (40)
[Log] handleCustomerSearch called with: – "Tho" (unified-teller.js, line 3804)
[Log] Filtered players: – [Object, Object, Object, …] (7) (unified-teller.js, line 3834)
[Object, Object, Object, Object, Object, Object, Object]Array (7)
[Log] handleCustomerSearch called with: – "Thor" (unified-teller.js, line 3804)
[Log] Filtered players: – [Object, Object, Object, …] (6) (unified-teller.js, line 3834)
[Object, Object, Object, Object, Object, Object]Array (6)
[Log] Exact match found: – "Thor" (unified-teller.js, line 3842)
[Log] Enter key - exact match found: – "Thor" (unified-teller.js, line 4038)
[Log] Validating customer: – "Thor" (unified-teller.js, line 1674)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/playerlist?search=Thor" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: Array} (jotun-comprehensive-api.js, line 39)
{data: Array}Object
[Log] Search API response: – {data: Array} (unified-teller.js, line 1678)
{data: Array}Object
[Log] Players found from search: – [Object, Object, Object, …] (6) (unified-teller.js, line 1680)
[Object, Object, Object, Object, Object, Object]Array (6)
[Log] Checking player: Turk Thorgard, exactMatch: false, partialMatch: false (unified-teller.js, line 1705)
[Log] Checking player: Agathor1, exactMatch: false, partialMatch: false (unified-teller.js, line 1705)
[Log] Checking player: Agathor, exactMatch: false, partialMatch: false (unified-teller.js, line 1705)
[Log] Checking player: Thor, exactMatch: true, partialMatch: true (unified-teller.js, line 1705)
[Log] Player found result: – {id: "339", score: "0", level: "1", …} (unified-teller.js, line 1709)
{id: "339", score: "0", level: "1", created_at: "2025-09-22 14:25:11", steam_id: "", …}Object
[Log] Validation successful for: – "Thor" (unified-teller.js, line 1711)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 3208)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 3209)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 3210)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 3211)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 3215)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3232)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/transactions?customer_name=Thor&transaction_type=turnin&hours=24" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: []} (jotun-comprehensive-api.js, line 39)
[Log] Daily turn-in data loaded: – {} (unified-teller.js, line 949)
[Log] 🔍 DEBUG Transaction History: selectedShop: – "138" (unified-teller.js, line 2607)
[Log] 🔍 DEBUG Transaction History: selectedOption: –  (unified-teller.js, line 2608)
<option value="138" data-shop-name="Aesir Spells & Items" data-shop-type="aesir" data-current-rotation="1">Aesir Spells & Items</option>

<option value="138" data-shop-name="Aesir Spells & Items" data-shop-type="aesir" data-current-rotation="1">Aesir Spells & Items</option>
[Log] 🔍 DEBUG Transaction History: shopName from dataset: – "Aesir Spells & Items" (unified-teller.js, line 2609)
[Log] 🔍 DEBUG Transaction History: shopType from dataset: – "aesir" (unified-teller.js, line 2610)
[Log] 🔍 DEBUG Transaction History: customerFromTransaction: – "Thor" (unified-teller.js, line 2611)
[Log] 🔍 DEBUG Transaction History: Aesir shop detected - checking for customer to show ledger balance (unified-teller.js, line 2623)
[Log] 🔍 DEBUG Transaction History: Customer selected, showing ledger balance for: – "Thor" (unified-teller.js, line 2633)
[Log] 🔍 DEBUG Ledger Balance: Fetching balance for customer: – "Thor" (unified-teller.js, line 2662)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/ledger/Thor" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "16d4d0755d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {player_name: "Thor", balances: [], last_updated: "2025-10-03 22:19:38"} (jotun-comprehensive-api.js, line 39)
[Log] 🔍 DEBUG Ledger Balance: API response: – {player_name: "Thor", balances: [], last_updated: "2025-10-03 22:19:38"} (unified-teller.js, line 2664)
[Log] Preserving quantities and re-rendering items... (unified-teller.js, line 3492)
[Log] Saved buy-qty-44: 1 (unified-teller.js, line 3509)
[Log] No individual buy button found for item: – "Unbreakable Oath" (unified-teller.js, line 1149)
[Log] No sell button found for item: – "Unbreakable Oath" (unified-teller.js, line 1180)
[Log] No turn-in button found for item: – "Unbreakable Oath" (unified-teller.js, line 1195)
[Log] Restored buy-qty-44: 1 (unified-teller.js, line 3522)
[Log] Recalculating all progress displays based on current input values... (unified-teller.js, line 3532)
[Log] Progress recalculation complete. (unified-teller.js, line 3554)