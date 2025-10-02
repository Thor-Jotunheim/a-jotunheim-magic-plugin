[Log] JQMIGRATE: Migrate is installed, version 3.4.1 (load-scripts.php, line 5)
[Log] Jotunheim Comprehensive API loaded (jotun-comprehensive-api.js, line 526)
[Log] 🚀🚀� UNIFIED TELLER: Initialization check: – {unified-teller-interface: true, teller-shop-selector: true, unified-teller-container: false, …} (unified-teller.js, line 4892)
{unified-teller-interface: true, teller-shop-selector: true, unified-teller-container: false, refresh-shop-btn: true, shouldInitialize: true}Object
[Log] 🚀🚀� UNIFIED TELLER: Conditions met, initializing UnifiedTeller... (unified-teller.js, line 4901)
[Log] �🚀🚀 UNIFIED TELLER: Event listener registered for shopRotationChanged (unified-teller.js, line 85)
[Log] DEBUG: Clear transaction button found: –  (unified-teller.js, line 110)
<button id="clear-transaction-btn" class="field-input clear-transaction-btn" onclick="console.log('🚨 DEBUG: Clear button onclick fired'); if(window.unifiedTeller) { console.log('🚨 DEBUG: unifiedTeller found, typeof clearCart:', typeof window.unifiedTeller.clearCart); try { console.log('🚨 ONCLICK: About to call clearCart'); window.unifiedTeller.clearCart(); console.log('🚨 ONCLICK: clearCart completed'); } catch(e) { console.error('🚨 ERROR in onclick clearCart():', e); console.error('🚨 ERROR stack:', e.stack); } } else { console.log('🚨 ERROR: unifiedTeller not found on window'); }">Clear Transaction</button>

<button id="clear-transaction-btn" class="field-input clear-transaction-btn" onclick="console.log('🚨 DEBUG: Clear button onclick fired'); if(window.unifiedTeller) { console.log('🚨 DEBUG: unifiedTeller found, typeof clearCart:', typeof window.unifiedTeller.clearCart); try { console.log('🚨 ONCLICK: About to call clearCart'); window.unifiedTeller.clearCart(); console.log('🚨 ONCLICK: clearCart completed'); } catch(e) { console.error('🚨 ERROR in onclick clearCart():', e); console.error('🚨 ERROR stack:', e.stack); } } else { console.log('🚨 ERROR: unifiedTeller not found on window'); }">Clear Transaction</button>
[Log] DEBUG: Clear transaction event listener attached (unified-teller.js, line 125)
[Log] UnifiedTeller: Starting to load initial data... (unified-teller.js, line 202)
[Log] JotunAPI is available, loading data... (unified-teller.js, line 218)
[Log] Loading shops for selector... (unified-teller.js, line 407)
[Log] JotunAPI status: – "object" (unified-teller.js, line 408)
[Log] jotun_api_vars: – {nonce: "8be04cc55d", rest_url: "https://jotun.games/wp-json/jotun-api/v1/"} (unified-teller.js, line 409)
[Log] Testing direct API call to: – "/wp-json/jotun-api/v1/shops" (unified-teller.js, line 417)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/shops" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "8be04cc55d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] UnifiedTeller constructor completed, preventOverLimit method: – "function" (unified-teller.js, line 18)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: Array} (jotun-comprehensive-api.js, line 39)
{data: Array}Object
[Log] Shop API response: – {data: Array} (unified-teller.js, line 420)
{data: Array}Object
[Log] Shops data received: – [Object, Object, Object] (3) (unified-teller.js, line 423)
[Object, Object, Object]Array (3)
[Log] DEBUG - Populating unified teller shop selector with: – [Object, Object, Object] (3) (unified-teller.js, line 449)
[Object, Object, Object]Array (3)
[Log] DEBUG - Processing shop: – {shop_id: "138", owner_name: "Thor", is_active: "1", …} (unified-teller.js, line 454)
{shop_id: "138", owner_name: "Thor", is_active: "1", shop_name: "Aesir Spells & Items", shop_type: "aesir", …}Object
[Log] DEBUG - Added shop option: – "Aesir Spells & Items" – "with rotation:" – "1" (unified-teller.js, line 464)
[Log] DEBUG - Processing shop: – {shop_id: "139", owner_name: "Thor", is_active: "1", …} (unified-teller.js, line 454)
{shop_id: "139", owner_name: "Thor", is_active: "1", shop_name: "Call to Arms", shop_type: "turn-in_only", …}Object
[Log] DEBUG - Added shop option: – "Call to Arms" – "with rotation:" – "1" (unified-teller.js, line 464)
[Log] DEBUG - Processing shop: – {shop_id: "140", owner_name: "Thor", is_active: "1", …} (unified-teller.js, line 454)
{shop_id: "140", owner_name: "Thor", is_active: "1", shop_name: "Popup Shop", shop_type: "staff", …}Object
[Log] DEBUG - Added shop option: – "Popup Shop" – "with rotation:" – "1" (unified-teller.js, line 464)
[Log] DEBUG - Shop selector populated with – 3 – "active shops" (unified-teller.js, line 470)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/playerlist" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "8be04cc55d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: Array} (jotun-comprehensive-api.js, line 39)
{data: Array}Object
[Log] DEBUG - Loaded player list: – [Object, Object, Object, …] (713) (unified-teller.js, line 230)
[Object, Object, Object, Object, Object, Object, Object, Object, Object, Object, …]Array (713)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/transactions?limit=50" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "8be04cc55d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: Array} (jotun-comprehensive-api.js, line 39)
{data: Array}Object
[Error] Failed to load resource: the server responded with a status of 403 (Forbidden) (current, line 0)
[Warning] User endpoint access denied - using fallback (unified-teller.js, line 272)
[Log] 🚨 DEBUG: Current cart contents: – [] (0) (unified-teller.js, line 2133)
[Log] 🚨 DEBUG: Cart array set to empty. New length: – 0 (unified-teller.js, line 2136)
[Log] 🚨 DEBUG: updateCartDisplay() called (unified-teller.js, line 2139)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 2994)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 2995)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 2996)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 2997)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 3001)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3018)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 2143)
[Log] 🚨 DEBUG: updateRecordTransactionButton() called (unified-teller.js, line 2146)
[Log] DEBUG: resetItemDisplay() called. Cart length: 0 (unified-teller.js, line 2160)
[Log] DEBUG: Clearing 0 input fields (unified-teller.js, line 2176)
[Log] 🚨 DEBUG: resetItemDisplay() called (unified-teller.js, line 2150)
[Log] 🚨 DEBUG: showShopView() called (unified-teller.js, line 2953)
[Log] 🚨 DEBUG: Setting isCartView to false (unified-teller.js, line 2954)
[Log] 🚨 DEBUG: shopInventoryCard found: – true (unified-teller.js, line 2959)
[Log] 🚨 DEBUG: transactionSummaryCard found: – true (unified-teller.js, line 2966)
[Log] 🚨 DEBUG: Buttons found - viewCart: – true – "record:" – true – "back:" – true (unified-teller.js, line 2976)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 2994)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 2995)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 2996)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 2997)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 3001)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3018)
[Log] 🚨 DEBUG: showShopView() called (unified-teller.js, line 2154)
[Log] 🚨🚨🚨 DEBUG: clearCart() completed - CART CLEARING FINISHED (unified-teller.js, line 2156)
[Log] Loading turn-in items for shop ID: – "139" – "rotation:" – "1" (unified-teller.js, line 862)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/shop-items?shop_id=139&rotation=1" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "8be04cc55d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] DEBUG: About to force button state update. Cart length: 0 (unified-teller.js, line 2190)
[Log] 🚨 DEBUG: forceButtonStateUpdate() called, cart length: – 0 (unified-teller.js, line 2274)
[Log] 🚨 DEBUG: Cart contents: – [] (0) (unified-teller.js, line 2275)
[Log] 🚨 DEBUG: Found 0 turn-in buttons to update (unified-teller.js, line 2288)
[Log] 🚨 DEBUG: forceButtonStateUpdate() completed (unified-teller.js, line 2315)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: Array} (jotun-comprehensive-api.js, line 39)
{data: Array}Object
[Log] Turn-in items response: – {data: Array} (unified-teller.js, line 865)
{data: Array}Object
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/itemlist" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "8be04cc55d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: Array} (jotun-comprehensive-api.js, line 39)
{data: Array}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1901)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1901)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1901)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1901)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3530)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 1, …}Object
[Log] Generating button for item 59: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1448)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1901)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1901)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1901)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1901)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, …} (unified-teller.js, line 3530)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, projectedTotal: 238, turnInRequirement: 4000, …}Object
[Log] Generating button for item 41: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1448)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1901)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1901)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1901)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1901)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, …} (unified-teller.js, line 3530)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, projectedTotal: 4, turnInRequirement: 250, …}Object
[Log] Generating button for item 38: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1448)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1901)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1901)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1901)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1901)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3530)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 1500, …}Object
[Log] Generating button for item 43: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1448)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1901)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1901)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1901)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1901)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3530)
{itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 50, …}Object
[Log] Generating button for item 40: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1448)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1901)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1901)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1901)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1901)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3530)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 2000, …}Object
[Log] Generating button for item 42: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1448)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1901)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1901)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1901)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1901)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3530)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 125, …}Object
[Log] Generating button for item 39: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1448)
[Log] Setting up turn-in tracking after loading items (unified-teller.js, line 900)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 2994)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 2995)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 2996)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 2997)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 3001)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3018)
[Log] 🔧 DEBUG: toggleItemsView() called, current isTableView: – false (unified-teller.js, line 2196)
[Log] 🔧 DEBUG: Found elements - gridView: – true – "tableView:" – true – "toggleBtn:" – true (unified-teller.js, line 2200)
[Log] 🔧 DEBUG: All elements found, proceeding with toggle (unified-teller.js, line 2203)
[Log] 🔧 DEBUG: Switching FROM grid TO table view (unified-teller.js, line 2214)
[Log] 🔧 DEBUG: renderItemsTable called, container: –  (unified-teller.js, line 4333)
<div class="items-table-wrapper" id="items-table-view" style="display: block;">…</div>

<div class="items-table-wrapper" id="items-table-view" style="display: block;">…</div>
[Log] 🔧 DEBUG: shopItems length: – 7 (unified-teller.js, line 4334)
[Log] 🔧 DEBUG: Creating table HTML structure without icon column (unified-teller.js, line 4352)
[Log] 🔧 DEBUG: createTableRow called for item: – "Abomination Trophy" – {shop_item_id: "59", shop_id: "139", item_id: "474", …} (unified-teller.js, line 4409)
{shop_item_id: "59", shop_id: "139", item_id: "474", prefab_id: null, item_name: "Abomination Trophy", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1901)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1901)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3530)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 1, …}Object
[Log] Generating button for item 59: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1448)
[Log] 🔧 DEBUG: createTableRow called for item: – "Bear Hide" – {shop_item_id: "41", shop_id: "139", item_id: "677", …} (unified-teller.js, line 4409)
{shop_item_id: "41", shop_id: "139", item_id: "677", prefab_id: null, item_name: "Bear Hide", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1901)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1901)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, …} (unified-teller.js, line 3530)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, projectedTotal: 238, turnInRequirement: 4000, …}Object
[Log] Generating button for item 41: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1448)
[Log] 🔧 DEBUG: createTableRow called for item: – "Bear Trophy" – {shop_item_id: "38", shop_id: "139", item_id: "678", …} (unified-teller.js, line 4409)
{shop_item_id: "38", shop_id: "139", item_id: "678", prefab_id: null, item_name: "Bear Trophy", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1901)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1901)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, …} (unified-teller.js, line 3530)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, projectedTotal: 4, turnInRequirement: 250, …}Object
[Log] Generating button for item 38: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1448)
[Log] 🔧 DEBUG: createTableRow called for item: – "Ectoplasm" – {shop_item_id: "43", shop_id: "139", item_id: "682", …} (unified-teller.js, line 4409)
{shop_item_id: "43", shop_id: "139", item_id: "682", prefab_id: null, item_name: "Ectoplasm", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1901)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1901)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3530)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 1500, …}Object
[Log] Generating button for item 43: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1448)
[Log] 🔧 DEBUG: createTableRow called for item: – "Ghost Trophy" – {shop_item_id: "40", shop_id: "139", item_id: "680", …} (unified-teller.js, line 4409)
{shop_item_id: "40", shop_id: "139", item_id: "680", prefab_id: null, item_name: "Ghost Trophy", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1901)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1901)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3530)
{itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 50, …}Object
[Log] Generating button for item 40: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1448)
[Log] 🔧 DEBUG: createTableRow called for item: – "Vile Ribcage" – {shop_item_id: "42", shop_id: "139", item_id: "681", …} (unified-teller.js, line 4409)
{shop_item_id: "42", shop_id: "139", item_id: "681", prefab_id: null, item_name: "Vile Ribcage", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1901)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1901)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3530)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 2000, …}Object
[Log] Generating button for item 42: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1448)
[Log] 🔧 DEBUG: createTableRow called for item: – "Vile Trophy" – {shop_item_id: "39", shop_id: "139", item_id: "679", …} (unified-teller.js, line 4409)
{shop_item_id: "39", shop_id: "139", item_id: "679", prefab_id: null, item_name: "Vile Trophy", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1901)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1901)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3530)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 125, …}Object
[Log] Generating button for item 39: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1448)
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-qty-59" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-qty-59", key: "9", currentValue: "", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-qty-59", key: "9", currentValue: "", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "", cursorPos: null, cursorPosFixed: 0, newValue: "9", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-qty-59", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1901)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Abomination Trophy", inputId: "table-turnin-qty-59", units: 9, …} (unified-teller.js, line 3377)
{itemName: "Abomination Trophy", inputId: "table-turnin-qty-59", units: 9, stacks: 0, stackSize: 20, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 1, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, …} (unified-teller.js, line 3530)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, projectedTotal: 1, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 1, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, …} (unified-teller.js, line 3530)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, projectedTotal: 1, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Error] InvalidStateError: The input element's type ('number') does not support selection.
	setSelectionRange (unified-teller.js:3405)
	(anonymous function) (unified-teller.js:3405)
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-qty-59" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-qty-59", key: "9", currentValue: "1", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-qty-59", key: "9", currentValue: "1", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "1", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "1", cursorPos: null, cursorPosFixed: 1, newValue: "19", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-qty-59", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1901)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Abomination Trophy", inputId: "table-turnin-qty-59", units: 19, …} (unified-teller.js, line 3377)
{itemName: "Abomination Trophy", inputId: "table-turnin-qty-59", units: 19, stacks: 0, stackSize: 20, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 1, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, …} (unified-teller.js, line 3530)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, projectedTotal: 1, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 1, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, …} (unified-teller.js, line 3530)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, projectedTotal: 1, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Error] InvalidStateError: The input element's type ('number') does not support selection.
	setSelectionRange (unified-teller.js:3405)
	(anonymous function) (unified-teller.js:3405)
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-qty-59" – "event:" – KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-qty-59", key: "Tab", currentValue: "1", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-qty-59", key: "Tab", currentValue: "1", cursorPos: null}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 1, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, …} (unified-teller.js, line 3530)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, projectedTotal: 1, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-stack-qty-59" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-stack-qty-59", key: "9", currentValue: "", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-stack-qty-59", key: "9", currentValue: "", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "", cursorPos: null, cursorPosFixed: 0, newValue: "9", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-stack-qty-59", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1901)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Abomination Trophy", inputId: "table-turnin-stack-qty-59", units: 1, …} (unified-teller.js, line 3377)
{itemName: "Abomination Trophy", inputId: "table-turnin-stack-qty-59", units: 1, stacks: 9, stackSize: 20, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 1, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, …} (unified-teller.js, line 3530)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, projectedTotal: 1, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 1, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, …} (unified-teller.js, line 3530)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, projectedTotal: 1, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Error] InvalidStateError: The input element's type ('number') does not support selection.
	setSelectionRange (unified-teller.js:3405)
	(anonymous function) (unified-teller.js:3405)
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-stack-qty-59" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-stack-qty-59", key: "9", currentValue: "0", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-stack-qty-59", key: "9", currentValue: "0", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "0", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "0", cursorPos: null, cursorPosFixed: 1, newValue: "09", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-stack-qty-59", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1901)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Abomination Trophy", inputId: "table-turnin-stack-qty-59", units: 1, …} (unified-teller.js, line 3377)
{itemName: "Abomination Trophy", inputId: "table-turnin-stack-qty-59", units: 1, stacks: 9, stackSize: 20, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 1, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, …} (unified-teller.js, line 3530)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, projectedTotal: 1, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 1, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, …} (unified-teller.js, line 3530)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, projectedTotal: 1, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Error] InvalidStateError: The input element's type ('number') does not support selection.
	setSelectionRange (unified-teller.js:3405)
	(anonymous function) (unified-teller.js:3405)
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-stack-qty-59" – "event:" – KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-stack-qty-59", key: "Tab", currentValue: "0", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-stack-qty-59", key: "Tab", currentValue: "0", cursorPos: null}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 1, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, …} (unified-teller.js, line 3530)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, projectedTotal: 1, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-qty-41" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-qty-41", key: "9", currentValue: "", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-qty-41", key: "9", currentValue: "", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "", cursorPos: null, cursorPosFixed: 0, newValue: "9", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-qty-41", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1901)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Bear Hide", inputId: "table-turnin-qty-41", units: 9, …} (unified-teller.js, line 3377)
{itemName: "Bear Hide", inputId: "table-turnin-qty-41", units: 9, stacks: 0, stackSize: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 9, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 9, …} (unified-teller.js, line 3530)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 9, projectedTotal: 247, turnInRequirement: 4000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 9, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 9, …} (unified-teller.js, line 3530)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 9, projectedTotal: 247, turnInRequirement: 4000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-qty-41" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-qty-41", key: "9", currentValue: "9", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-qty-41", key: "9", currentValue: "9", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "9", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "9", cursorPos: null, cursorPosFixed: 1, newValue: "99", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-qty-41", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1901)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Bear Hide", inputId: "table-turnin-qty-41", units: 99, …} (unified-teller.js, line 3377)
{itemName: "Bear Hide", inputId: "table-turnin-qty-41", units: 99, stacks: 0, stackSize: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 99, …} (unified-teller.js, line 3530)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 99, projectedTotal: 337, turnInRequirement: 4000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 99, …} (unified-teller.js, line 3530)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 99, projectedTotal: 337, turnInRequirement: 4000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-qty-41" – "event:" – KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-qty-41", key: "Tab", currentValue: "99", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-qty-41", key: "Tab", currentValue: "99", cursorPos: null}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 99, …} (unified-teller.js, line 3530)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 99, projectedTotal: 337, turnInRequirement: 4000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 99, …} (unified-teller.js, line 3530)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 99, projectedTotal: 337, turnInRequirement: 4000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-stack-qty-41" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-stack-qty-41", key: "9", currentValue: "", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-stack-qty-41", key: "9", currentValue: "", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "", cursorPos: null, cursorPosFixed: 0, newValue: "9", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-stack-qty-41", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1901)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Bear Hide", inputId: "table-turnin-stack-qty-41", units: 99, …} (unified-teller.js, line 3377)
{itemName: "Bear Hide", inputId: "table-turnin-stack-qty-41", units: 99, stacks: 9, stackSize: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 9 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 549, …} (unified-teller.js, line 3530)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 549, projectedTotal: 787, turnInRequirement: 4000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 9 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 549, …} (unified-teller.js, line 3530)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 549, projectedTotal: 787, turnInRequirement: 4000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-stack-qty-41" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-stack-qty-41", key: "9", currentValue: "9", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-stack-qty-41", key: "9", currentValue: "9", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "9", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "9", cursorPos: null, cursorPosFixed: 1, newValue: "99", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-stack-qty-41", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1901)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Bear Hide", inputId: "table-turnin-stack-qty-41", units: 99, …} (unified-teller.js, line 3377)
{itemName: "Bear Hide", inputId: "table-turnin-stack-qty-41", units: 99, stacks: 99, stackSize: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 73 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 3749, …} (unified-teller.js, line 3530)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 3749, projectedTotal: 3987, turnInRequirement: 4000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 73 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 3749, …} (unified-teller.js, line 3530)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 3749, projectedTotal: 3987, turnInRequirement: 4000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Error] InvalidStateError: The input element's type ('number') does not support selection.
	setSelectionRange (unified-teller.js:3405)
	(anonymous function) (unified-teller.js:3405)
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-stack-qty-41" – "event:" – KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-stack-qty-41", key: "Tab", currentValue: "73", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-stack-qty-41", key: "Tab", currentValue: "73", cursorPos: null}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 73 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 3749, …} (unified-teller.js, line 3530)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 3749, projectedTotal: 3987, turnInRequirement: 4000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-qty-38" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-qty-38", key: "9", currentValue: "", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-qty-38", key: "9", currentValue: "", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "", cursorPos: null, cursorPosFixed: 0, newValue: "9", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-qty-38", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1901)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Bear Trophy", inputId: "table-turnin-qty-38", units: 9, …} (unified-teller.js, line 3377)
{itemName: "Bear Trophy", inputId: "table-turnin-qty-38", units: 9, stacks: 0, stackSize: 20, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 9, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 9, …} (unified-teller.js, line 3530)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 9, projectedTotal: 13, turnInRequirement: 250, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 9, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 9, …} (unified-teller.js, line 3530)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 9, projectedTotal: 13, turnInRequirement: 250, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-qty-38" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-qty-38", key: "9", currentValue: "9", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-qty-38", key: "9", currentValue: "9", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "9", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "9", cursorPos: null, cursorPosFixed: 1, newValue: "99", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-qty-38", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1901)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Bear Trophy", inputId: "table-turnin-qty-38", units: 99, …} (unified-teller.js, line 3377)
{itemName: "Bear Trophy", inputId: "table-turnin-qty-38", units: 99, stacks: 0, stackSize: 20, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 99, …} (unified-teller.js, line 3530)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 99, projectedTotal: 103, turnInRequirement: 250, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 99, …} (unified-teller.js, line 3530)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 99, projectedTotal: 103, turnInRequirement: 250, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-qty-38" – "event:" – KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-qty-38", key: "Tab", currentValue: "99", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-qty-38", key: "Tab", currentValue: "99", cursorPos: null}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 99, …} (unified-teller.js, line 3530)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 99, projectedTotal: 103, turnInRequirement: 250, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 99, …} (unified-teller.js, line 3530)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 99, projectedTotal: 103, turnInRequirement: 250, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-stack-qty-38" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-stack-qty-38", key: "9", currentValue: "", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-stack-qty-38", key: "9", currentValue: "", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "", cursorPos: null, cursorPosFixed: 0, newValue: "9", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-stack-qty-38", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1901)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Bear Trophy", inputId: "table-turnin-stack-qty-38", units: 99, …} (unified-teller.js, line 3377)
{itemName: "Bear Trophy", inputId: "table-turnin-stack-qty-38", units: 99, stacks: 9, stackSize: 20, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 7 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 239, …} (unified-teller.js, line 3530)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 239, projectedTotal: 243, turnInRequirement: 250, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 7 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 239, …} (unified-teller.js, line 3530)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 239, projectedTotal: 243, turnInRequirement: 250, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Error] InvalidStateError: The input element's type ('number') does not support selection.
	setSelectionRange (unified-teller.js:3405)
	(anonymous function) (unified-teller.js:3405)
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-stack-qty-38" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-stack-qty-38", key: "9", currentValue: "7", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-stack-qty-38", key: "9", currentValue: "7", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "7", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "7", cursorPos: null, cursorPosFixed: 1, newValue: "79", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-stack-qty-38", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1901)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Bear Trophy", inputId: "table-turnin-stack-qty-38", units: 99, …} (unified-teller.js, line 3377)
{itemName: "Bear Trophy", inputId: "table-turnin-stack-qty-38", units: 99, stacks: 79, stackSize: 20, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 7 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 239, …} (unified-teller.js, line 3530)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 239, projectedTotal: 243, turnInRequirement: 250, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 7 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 239, …} (unified-teller.js, line 3530)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 239, projectedTotal: 243, turnInRequirement: 250, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Error] InvalidStateError: The input element's type ('number') does not support selection.
	setSelectionRange (unified-teller.js:3405)
	(anonymous function) (unified-teller.js:3405)
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-stack-qty-38" – "event:" – KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-stack-qty-38", key: "Tab", currentValue: "7", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-stack-qty-38", key: "Tab", currentValue: "7", cursorPos: null}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 7 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 239, …} (unified-teller.js, line 3530)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 239, projectedTotal: 243, turnInRequirement: 250, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-qty-43" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-qty-43", key: "9", currentValue: "", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-qty-43", key: "9", currentValue: "", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "", cursorPos: null, cursorPosFixed: 0, newValue: "9", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-qty-43", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1901)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Ectoplasm", inputId: "table-turnin-qty-43", units: 9, …} (unified-teller.js, line 3377)
{itemName: "Ectoplasm", inputId: "table-turnin-qty-43", units: 9, stacks: 0, stackSize: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 9, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 9, …} (unified-teller.js, line 3530)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 9, projectedTotal: 9, turnInRequirement: 1500, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 9, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 9, …} (unified-teller.js, line 3530)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 9, projectedTotal: 9, turnInRequirement: 1500, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-qty-43" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-qty-43", key: "9", currentValue: "9", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-qty-43", key: "9", currentValue: "9", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "9", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "9", cursorPos: null, cursorPosFixed: 1, newValue: "99", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-qty-43", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1901)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Ectoplasm", inputId: "table-turnin-qty-43", units: 99, …} (unified-teller.js, line 3377)
{itemName: "Ectoplasm", inputId: "table-turnin-qty-43", units: 99, stacks: 0, stackSize: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 99, …} (unified-teller.js, line 3530)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 99, projectedTotal: 99, turnInRequirement: 1500, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 99, …} (unified-teller.js, line 3530)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 99, projectedTotal: 99, turnInRequirement: 1500, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-qty-43" – "event:" – KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-qty-43", key: "Tab", currentValue: "99", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-qty-43", key: "Tab", currentValue: "99", cursorPos: null}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 99, …} (unified-teller.js, line 3530)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 99, projectedTotal: 99, turnInRequirement: 1500, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 99, …} (unified-teller.js, line 3530)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 99, projectedTotal: 99, turnInRequirement: 1500, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-stack-qty-43" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-stack-qty-43", key: "9", currentValue: "", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-stack-qty-43", key: "9", currentValue: "", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "", cursorPos: null, cursorPosFixed: 0, newValue: "9", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-stack-qty-43", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1901)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Ectoplasm", inputId: "table-turnin-stack-qty-43", units: 99, …} (unified-teller.js, line 3377)
{itemName: "Ectoplasm", inputId: "table-turnin-stack-qty-43", units: 99, stacks: 9, stackSize: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 9 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 549, …} (unified-teller.js, line 3530)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 549, projectedTotal: 549, turnInRequirement: 1500, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 9 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 549, …} (unified-teller.js, line 3530)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 549, projectedTotal: 549, turnInRequirement: 1500, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-stack-qty-43" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-stack-qty-43", key: "9", currentValue: "9", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-stack-qty-43", key: "9", currentValue: "9", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "9", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "9", cursorPos: null, cursorPosFixed: 1, newValue: "99", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-stack-qty-43", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1901)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Ectoplasm", inputId: "table-turnin-stack-qty-43", units: 99, …} (unified-teller.js, line 3377)
{itemName: "Ectoplasm", inputId: "table-turnin-stack-qty-43", units: 99, stacks: 99, stackSize: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 28 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 1499, …} (unified-teller.js, line 3530)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 1499, projectedTotal: 1499, turnInRequirement: 1500, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 28 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 1499, …} (unified-teller.js, line 3530)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 1499, projectedTotal: 1499, turnInRequirement: 1500, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Error] InvalidStateError: The input element's type ('number') does not support selection.
	setSelectionRange (unified-teller.js:3405)
	(anonymous function) (unified-teller.js:3405)
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-stack-qty-43" – "event:" – KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-stack-qty-43", key: "Tab", currentValue: "28", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-stack-qty-43", key: "Tab", currentValue: "28", cursorPos: null}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 28 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 1499, …} (unified-teller.js, line 3530)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 1499, projectedTotal: 1499, turnInRequirement: 1500, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-qty-40" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-qty-40", key: "9", currentValue: "", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-qty-40", key: "9", currentValue: "", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "", cursorPos: null, cursorPosFixed: 0, newValue: "9", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-qty-40", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1901)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Ghost Trophy", inputId: "table-turnin-qty-40", units: 9, …} (unified-teller.js, line 3377)
{itemName: "Ghost Trophy", inputId: "table-turnin-qty-40", units: 9, stacks: 0, stackSize: 20, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 9, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 9, …} (unified-teller.js, line 3530)
{itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 9, projectedTotal: 9, turnInRequirement: 50, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 9, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 9, …} (unified-teller.js, line 3530)
{itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 9, projectedTotal: 9, turnInRequirement: 50, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-qty-40" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-qty-40", key: "9", currentValue: "9", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-qty-40", key: "9", currentValue: "9", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "9", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "9", cursorPos: null, cursorPosFixed: 1, newValue: "99", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-qty-40", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1901)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Ghost Trophy", inputId: "table-turnin-qty-40", units: 99, …} (unified-teller.js, line 3377)
{itemName: "Ghost Trophy", inputId: "table-turnin-qty-40", units: 99, stacks: 0, stackSize: 20, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 50, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 50, …} (unified-teller.js, line 3530)
{itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 50, projectedTotal: 50, turnInRequirement: 50, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 50, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 50, …} (unified-teller.js, line 3530)
{itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 50, projectedTotal: 50, turnInRequirement: 50, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Error] InvalidStateError: The input element's type ('number') does not support selection.
	setSelectionRange (unified-teller.js:3405)
	(anonymous function) (unified-teller.js:3405)
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-qty-40" – "event:" – KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-qty-40", key: "Tab", currentValue: "50", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-qty-40", key: "Tab", currentValue: "50", cursorPos: null}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 50, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 50, …} (unified-teller.js, line 3530)
{itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 50, projectedTotal: 50, turnInRequirement: 50, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-stack-qty-40" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-stack-qty-40", key: "9", currentValue: "", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-stack-qty-40", key: "9", currentValue: "", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "", cursorPos: null, cursorPosFixed: 0, newValue: "9", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-stack-qty-40", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1901)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Ghost Trophy", inputId: "table-turnin-stack-qty-40", units: 50, …} (unified-teller.js, line 3377)
{itemName: "Ghost Trophy", inputId: "table-turnin-stack-qty-40", units: 50, stacks: 9, stackSize: 20, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 50, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 50, …} (unified-teller.js, line 3530)
{itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 50, projectedTotal: 50, turnInRequirement: 50, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 50, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 50, …} (unified-teller.js, line 3530)
{itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 50, projectedTotal: 50, turnInRequirement: 50, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Error] InvalidStateError: The input element's type ('number') does not support selection.
	setSelectionRange (unified-teller.js:3405)
	(anonymous function) (unified-teller.js:3405)
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-stack-qty-40" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-stack-qty-40", key: "9", currentValue: "0", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-stack-qty-40", key: "9", currentValue: "0", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "0", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "0", cursorPos: null, cursorPosFixed: 1, newValue: "09", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-stack-qty-40", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1901)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Ghost Trophy", inputId: "table-turnin-stack-qty-40", units: 50, …} (unified-teller.js, line 3377)
{itemName: "Ghost Trophy", inputId: "table-turnin-stack-qty-40", units: 50, stacks: 9, stackSize: 20, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 50, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 50, …} (unified-teller.js, line 3530)
{itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 50, projectedTotal: 50, turnInRequirement: 50, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 50, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 50, …} (unified-teller.js, line 3530)
{itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 50, projectedTotal: 50, turnInRequirement: 50, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Error] InvalidStateError: The input element's type ('number') does not support selection.
	setSelectionRange (unified-teller.js:3405)
	(anonymous function) (unified-teller.js:3405)
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-stack-qty-40" – "event:" – KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-stack-qty-40", key: "Tab", currentValue: "0", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-stack-qty-40", key: "Tab", currentValue: "0", cursorPos: null}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 50, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 50, …} (unified-teller.js, line 3530)
{itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 50, projectedTotal: 50, turnInRequirement: 50, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-qty-42" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-qty-42", key: "9", currentValue: "", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-qty-42", key: "9", currentValue: "", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "", cursorPos: null, cursorPosFixed: 0, newValue: "9", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-qty-42", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1901)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Vile Ribcage", inputId: "table-turnin-qty-42", units: 9, …} (unified-teller.js, line 3377)
{itemName: "Vile Ribcage", inputId: "table-turnin-qty-42", units: 9, stacks: 0, stackSize: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 9, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 9, …} (unified-teller.js, line 3530)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 9, projectedTotal: 9, turnInRequirement: 2000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 9, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 9, …} (unified-teller.js, line 3530)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 9, projectedTotal: 9, turnInRequirement: 2000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-qty-42" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-qty-42", key: "9", currentValue: "9", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-qty-42", key: "9", currentValue: "9", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "9", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "9", cursorPos: null, cursorPosFixed: 1, newValue: "99", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-qty-42", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1901)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Vile Ribcage", inputId: "table-turnin-qty-42", units: 99, …} (unified-teller.js, line 3377)
{itemName: "Vile Ribcage", inputId: "table-turnin-qty-42", units: 99, stacks: 0, stackSize: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 99, …} (unified-teller.js, line 3530)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 99, projectedTotal: 99, turnInRequirement: 2000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 99, …} (unified-teller.js, line 3530)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 99, projectedTotal: 99, turnInRequirement: 2000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-qty-42" – "event:" – KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-qty-42", key: "Tab", currentValue: "99", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-qty-42", key: "Tab", currentValue: "99", cursorPos: null}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 99, …} (unified-teller.js, line 3530)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 99, projectedTotal: 99, turnInRequirement: 2000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 99, …} (unified-teller.js, line 3530)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 99, projectedTotal: 99, turnInRequirement: 2000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-stack-qty-42" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-stack-qty-42", key: "9", currentValue: "", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-stack-qty-42", key: "9", currentValue: "", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "", cursorPos: null, cursorPosFixed: 0, newValue: "9", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-stack-qty-42", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1901)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Vile Ribcage", inputId: "table-turnin-stack-qty-42", units: 99, …} (unified-teller.js, line 3377)
{itemName: "Vile Ribcage", inputId: "table-turnin-stack-qty-42", units: 99, stacks: 9, stackSize: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 9 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 549, …} (unified-teller.js, line 3530)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 549, projectedTotal: 549, turnInRequirement: 2000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 9 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 549, …} (unified-teller.js, line 3530)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 549, projectedTotal: 549, turnInRequirement: 2000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-stack-qty-42" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-stack-qty-42", key: "9", currentValue: "9", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-stack-qty-42", key: "9", currentValue: "9", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "9", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "9", cursorPos: null, cursorPosFixed: 1, newValue: "99", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-stack-qty-42", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1901)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Vile Ribcage", inputId: "table-turnin-stack-qty-42", units: 99, …} (unified-teller.js, line 3377)
{itemName: "Vile Ribcage", inputId: "table-turnin-stack-qty-42", units: 99, stacks: 99, stackSize: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 38 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 1999, …} (unified-teller.js, line 3530)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 1999, projectedTotal: 1999, turnInRequirement: 2000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 38 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 1999, …} (unified-teller.js, line 3530)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 1999, projectedTotal: 1999, turnInRequirement: 2000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Error] InvalidStateError: The input element's type ('number') does not support selection.
	setSelectionRange (unified-teller.js:3405)
	(anonymous function) (unified-teller.js:3405)
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-stack-qty-42" – "event:" – KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-stack-qty-42", key: "Tab", currentValue: "38", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-stack-qty-42", key: "Tab", currentValue: "38", cursorPos: null}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 38 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 1999, …} (unified-teller.js, line 3530)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 1999, projectedTotal: 1999, turnInRequirement: 2000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-qty-39" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-qty-39", key: "9", currentValue: "", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-qty-39", key: "9", currentValue: "", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "", cursorPos: null, cursorPosFixed: 0, newValue: "9", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-qty-39", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1901)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Vile Trophy", inputId: "table-turnin-qty-39", units: 9, …} (unified-teller.js, line 3377)
{itemName: "Vile Trophy", inputId: "table-turnin-qty-39", units: 9, stacks: 0, stackSize: 20, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 9, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 9, …} (unified-teller.js, line 3530)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 9, projectedTotal: 9, turnInRequirement: 125, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 9, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 9, …} (unified-teller.js, line 3530)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 9, projectedTotal: 9, turnInRequirement: 125, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-qty-39" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-qty-39", key: "9", currentValue: "9", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-qty-39", key: "9", currentValue: "9", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "9", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "9", cursorPos: null, cursorPosFixed: 1, newValue: "99", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-qty-39", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1901)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Vile Trophy", inputId: "table-turnin-qty-39", units: 99, …} (unified-teller.js, line 3377)
{itemName: "Vile Trophy", inputId: "table-turnin-qty-39", units: 99, stacks: 0, stackSize: 20, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 99, …} (unified-teller.js, line 3530)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 99, projectedTotal: 99, turnInRequirement: 125, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 99, …} (unified-teller.js, line 3530)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 99, projectedTotal: 99, turnInRequirement: 125, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-qty-39" – "event:" – KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-qty-39", key: "Tab", currentValue: "99", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-qty-39", key: "Tab", currentValue: "99", cursorPos: null}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 99, …} (unified-teller.js, line 3530)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 99, projectedTotal: 99, turnInRequirement: 125, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 99, …} (unified-teller.js, line 3530)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 99, projectedTotal: 99, turnInRequirement: 125, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-stack-qty-39" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-stack-qty-39", key: "9", currentValue: "", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-stack-qty-39", key: "9", currentValue: "", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "", cursorPos: null, cursorPosFixed: 0, newValue: "9", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-stack-qty-39", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1901)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Vile Trophy", inputId: "table-turnin-stack-qty-39", units: 99, …} (unified-teller.js, line 3377)
{itemName: "Vile Trophy", inputId: "table-turnin-stack-qty-39", units: 99, stacks: 9, stackSize: 20, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 1 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 119, …} (unified-teller.js, line 3530)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 119, projectedTotal: 119, turnInRequirement: 125, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 1 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 119, …} (unified-teller.js, line 3530)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 119, projectedTotal: 119, turnInRequirement: 125, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Error] InvalidStateError: The input element's type ('number') does not support selection.
	setSelectionRange (unified-teller.js:3405)
	(anonymous function) (unified-teller.js:3405)
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-stack-qty-39" – "event:" – KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "9", code: "Digit9", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-stack-qty-39", key: "9", currentValue: "1", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-stack-qty-39", key: "9", currentValue: "1", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "9", currentValue: "1", cursorPos: null, …} (unified-teller.js, line 1979)
{key: "9", currentValue: "1", cursorPos: null, cursorPosFixed: 1, newValue: "19", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-stack-qty-39", itemFound: false, itemName: undefined} (unified-teller.js, line 1993)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1901)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Vile Trophy", inputId: "table-turnin-stack-qty-39", units: 99, …} (unified-teller.js, line 3377)
{itemName: "Vile Trophy", inputId: "table-turnin-stack-qty-39", units: 99, stacks: 19, stackSize: 20, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 1 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 119, …} (unified-teller.js, line 3530)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 119, projectedTotal: 119, turnInRequirement: 125, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 1 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 119, …} (unified-teller.js, line 3530)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 119, projectedTotal: 119, turnInRequirement: 125, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Error] InvalidStateError: The input element's type ('number') does not support selection.
	setSelectionRange (unified-teller.js:3405)
	(anonymous function) (unified-teller.js:3405)
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-stack-qty-39" – "event:" – KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "Tab", code: "Tab", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-stack-qty-39", key: "Tab", currentValue: "1", …} (unified-teller.js, line 1955)
{inputId: "table-turnin-stack-qty-39", key: "Tab", currentValue: "1", cursorPos: null}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 1 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 119, …} (unified-teller.js, line 3530)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 119, projectedTotal: 119, turnInRequirement: 125, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔴 DEBUG: addTurninItemWithQuantity called for item 59 (unified-teller.js, line 4107)
[Log] 🔴 DEBUG: Customer validation failed (unified-teller.js, line 4111)
[Log] 🔴 DEBUG: addTurninItemWithQuantity called for item 41 (unified-teller.js, line 4107)
[Log] 🔴 DEBUG: Customer validation failed (unified-teller.js, line 4111)
[Log] handleCustomerSearch called with: – "a" (unified-teller.js, line 3563)
[Log] handleCustomerSearch called with: – "as" (unified-teller.js, line 3563)
[Log] Filtered players: – [Object, Object, Object, …] (31) (unified-teller.js, line 3593)
[Object, Object, Object, Object, Object, Object, Object, Object, Object, Object, …]Array (31)
[Log] handleCustomerSearch called with: – "asd" (unified-teller.js, line 3563)
[Log] Filtered players: – [Object] (1) (unified-teller.js, line 3593)
[Object]Array (1)
[Log] handleCustomerSearch called with: – "asdf" (unified-teller.js, line 3563)
[Log] Filtered players: – [Object] (1) (unified-teller.js, line 3593)
[Object]Array (1)
[Log] Exact match found: – "asdf" (unified-teller.js, line 3601)
[Log] Validating customer: – "asdf" (unified-teller.js, line 1628)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/playerlist?search=asdf" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "8be04cc55d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: Array} (jotun-comprehensive-api.js, line 39)
{data: Array}Object
[Log] Search API response: – {data: Array} (unified-teller.js, line 1632)
{data: Array}Object
[Log] Players found from search: – [Object] (1) (unified-teller.js, line 1634)
[Object]Array (1)
[Log] Checking player: asdf, activeMatch: true, nameMatch: true (unified-teller.js, line 1657)
[Log] Player found result: – {id: "716", score: "0", level: "1", …} (unified-teller.js, line 1661)
{id: "716", score: "0", level: "1", created_at: "2025-09-30 11:55:41", steam_id: "", …}Object
[Log] Validation successful for: – "asdf" (unified-teller.js, line 1663)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 2994)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 2995)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 2996)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 2997)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 3001)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3018)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/transactions?customer_name=asdf&transaction_type=turnin&hours=24" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "8be04cc55d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: []} (jotun-comprehensive-api.js, line 39)
[Log] Daily turn-in data loaded: – {} (unified-teller.js, line 927)
[Log] Preserving quantities and re-rendering items... (unified-teller.js, line 3251)
[Log] Saved table-turnin-qty-59: 1 (unified-teller.js, line 3268)
[Log] Saved table-turnin-qty-41: 99 (unified-teller.js, line 3268)
[Log] Saved table-turnin-stack-qty-41: 73 (unified-teller.js, line 3268)
[Log] Saved table-turnin-qty-38: 99 (unified-teller.js, line 3268)
[Log] Saved table-turnin-stack-qty-38: 7 (unified-teller.js, line 3268)
[Log] Saved table-turnin-qty-43: 99 (unified-teller.js, line 3268)
[Log] Saved table-turnin-stack-qty-43: 28 (unified-teller.js, line 3268)
[Log] Saved table-turnin-qty-40: 50 (unified-teller.js, line 3268)
[Log] Saved table-turnin-qty-42: 99 (unified-teller.js, line 3268)
[Log] Saved table-turnin-stack-qty-42: 38 (unified-teller.js, line 3268)
[Log] Saved table-turnin-qty-39: 99 (unified-teller.js, line 3268)
[Log] Saved table-turnin-stack-qty-39: 1 (unified-teller.js, line 3268)
[Log] 🔧 DEBUG: renderItemsTable called, container: –  (unified-teller.js, line 4333)
<div class="items-table-wrapper" id="items-table-view" style="display: block;">…</div>

<div class="items-table-wrapper" id="items-table-view" style="display: block;">…</div>
[Log] 🔧 DEBUG: shopItems length: – 7 (unified-teller.js, line 4334)
[Log] 🔧 DEBUG: Creating table HTML structure without icon column (unified-teller.js, line 4352)
[Log] 🔧 DEBUG: createTableRow called for item: – "Abomination Trophy" – {shop_item_id: "59", shop_id: "139", item_id: "474", …} (unified-teller.js, line 4409)
{shop_item_id: "59", shop_id: "139", item_id: "474", prefab_id: null, item_name: "Abomination Trophy", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1901)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1901)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3530)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 1, …}Object
[Log] Generating button for item 59: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1448)
[Log] 🔧 DEBUG: createTableRow called for item: – "Bear Hide" – {shop_item_id: "41", shop_id: "139", item_id: "677", …} (unified-teller.js, line 4409)
{shop_item_id: "41", shop_id: "139", item_id: "677", prefab_id: null, item_name: "Bear Hide", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1901)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1901)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, …} (unified-teller.js, line 3530)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, projectedTotal: 238, turnInRequirement: 4000, …}Object
[Log] Generating button for item 41: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1448)
[Log] 🔧 DEBUG: createTableRow called for item: – "Bear Trophy" – {shop_item_id: "38", shop_id: "139", item_id: "678", …} (unified-teller.js, line 4409)
{shop_item_id: "38", shop_id: "139", item_id: "678", prefab_id: null, item_name: "Bear Trophy", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1901)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1901)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, …} (unified-teller.js, line 3530)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, projectedTotal: 4, turnInRequirement: 250, …}Object
[Log] Generating button for item 38: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1448)
[Log] 🔧 DEBUG: createTableRow called for item: – "Ectoplasm" – {shop_item_id: "43", shop_id: "139", item_id: "682", …} (unified-teller.js, line 4409)
{shop_item_id: "43", shop_id: "139", item_id: "682", prefab_id: null, item_name: "Ectoplasm", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1901)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1901)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3530)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 1500, …}Object
[Log] Generating button for item 43: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1448)
[Log] 🔧 DEBUG: createTableRow called for item: – "Ghost Trophy" – {shop_item_id: "40", shop_id: "139", item_id: "680", …} (unified-teller.js, line 4409)
{shop_item_id: "40", shop_id: "139", item_id: "680", prefab_id: null, item_name: "Ghost Trophy", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1901)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1901)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3530)
{itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 50, …}Object
[Log] Generating button for item 40: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1448)
[Log] 🔧 DEBUG: createTableRow called for item: – "Vile Ribcage" – {shop_item_id: "42", shop_id: "139", item_id: "681", …} (unified-teller.js, line 4409)
{shop_item_id: "42", shop_id: "139", item_id: "681", prefab_id: null, item_name: "Vile Ribcage", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1901)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1901)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3530)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 2000, …}Object
[Log] Generating button for item 42: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1448)
[Log] 🔧 DEBUG: createTableRow called for item: – "Vile Trophy" – {shop_item_id: "39", shop_id: "139", item_id: "679", …} (unified-teller.js, line 4409)
{shop_item_id: "39", shop_id: "139", item_id: "679", prefab_id: null, item_name: "Vile Trophy", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1901)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1901)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3530)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 125, …}Object
[Log] Generating button for item 39: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1448)
[Log] Restored table-turnin-qty-59: 1 (unified-teller.js, line 3281)
[Log] Restored table-turnin-qty-41: 99 (unified-teller.js, line 3281)
[Log] Restored table-turnin-stack-qty-41: 73 (unified-teller.js, line 3281)
[Log] Restored table-turnin-qty-38: 99 (unified-teller.js, line 3281)
[Log] Restored table-turnin-stack-qty-38: 7 (unified-teller.js, line 3281)
[Log] Restored table-turnin-qty-43: 99 (unified-teller.js, line 3281)
[Log] Restored table-turnin-stack-qty-43: 28 (unified-teller.js, line 3281)
[Log] Restored table-turnin-qty-40: 50 (unified-teller.js, line 3281)
[Log] Restored table-turnin-qty-42: 99 (unified-teller.js, line 3281)
[Log] Restored table-turnin-stack-qty-42: 38 (unified-teller.js, line 3281)
[Log] Restored table-turnin-qty-39: 99 (unified-teller.js, line 3281)
[Log] Restored table-turnin-stack-qty-39: 1 (unified-teller.js, line 3281)
[Log] Recalculating all progress displays based on current input values... (unified-teller.js, line 3291)
[Log] Progress recalculation complete. (unified-teller.js, line 3313)
[Log] 🔴 DEBUG: addTurninItemWithQuantity called for item 59 (unified-teller.js, line 4107)
[Log] 🔴 DEBUG: View detection - this.isTableView: true, DOM tableView visible: true, DOM gridView visible: false (unified-teller.js, line 4121)
[Log] 🔴 DEBUG: Table view active - looking for table inputs (unified-teller.js, line 4129)
[Log] 🔴 DEBUG: Units input found: true, value: 1, id: table-turnin-qty-59 (unified-teller.js, line 4139)
[Log] 🔴 DEBUG: Stacks input found: true, value: 0, id: table-turnin-stack-qty-59 (unified-teller.js, line 4140)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - checkTurninLimits: – {itemName: "Abomination Trophy", dailyTotal: 0, cartQuantity: 0, …} (unified-teller.js, line 1933)
{itemName: "Abomination Trophy", dailyTotal: 0, cartQuantity: 0, requestedQuantity: 1, projectedTotal: 1, …}Object
[Log] DEBUG: addTurninItemWithQuantity - shopItemId=59, quantity=1, cartBefore=0 (unified-teller.js, line 4172)
[Log] DEBUG: Added turn-in item to cart: – "Abomination Trophy" – "quantity:" – 1 – "Cart now has" – 1 – "items" – "existingItem:" – false (unified-teller.js, line 4200)
[Log] DEBUG: Cart contents: – [{id: 59, action: "turnin", qty: 1}] (1) (unified-teller.js, line 4201)
[Log] DEBUG - Turn-in progress calculation: – {turn_in_quantity: 0, turn_in_quantity_type: "number", quantity: 1, …} (unified-teller.js, line 4686)
{turn_in_quantity: 0, turn_in_quantity_type: "number", quantity: 1, quantity_type: "number", raw_addition: 1}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Fixed progress calculation (no double-counting): – {dailyTotal: 0, cartQuantity: 1, projectedTotal: 1, …} (unified-teller.js, line 4701)
{dailyTotal: 0, cartQuantity: 1, projectedTotal: 1, required: 1, remaining: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 2994)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 2995)
[Log] 🚨 DEBUG: cart length: – 1 (unified-teller.js, line 2996)
[Log] 🚨 DEBUG: cart contents: – [Object] (1) (unified-teller.js, line 2997)
[Object]Array (1)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: true, cartLength: 1} (unified-teller.js, line 3001)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – false – "text:" – "View Cart (1)" (unified-teller.js, line 3018)
[Log] 🚨 DEBUG: forceButtonStateUpdate() called, cart length: – 1 (unified-teller.js, line 2274)
[Log] 🚨 DEBUG: Cart contents: – [Object] (1) (unified-teller.js, line 2275)
[Object]Array (1)
[Log] 🚨 DEBUG: Found 14 turn-in buttons to update (unified-teller.js, line 2288)
[Log] 🚨 DEBUG: Button for item 59: inCart=true, current text="Turn In", cart.length=1 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Updated button text to "Update" for item 59 (unified-teller.js, line 2306)
[Log] 🚨 DEBUG: Button for item 41: inCart=false, current text="Turn In", cart.length=1 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Button for item 38: inCart=false, current text="Turn In", cart.length=1 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Button for item 43: inCart=false, current text="Turn In", cart.length=1 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Button for item 40: inCart=false, current text="Turn In", cart.length=1 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Button for item 42: inCart=false, current text="Turn In", cart.length=1 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Button for item 39: inCart=false, current text="Turn In", cart.length=1 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Button for item 59: inCart=true, current text="Turn In", cart.length=1 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Updated button text to "Update" for item 59 (unified-teller.js, line 2306)
[Log] 🚨 DEBUG: Button for item 41: inCart=false, current text="Turn In", cart.length=1 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Button for item 38: inCart=false, current text="Turn In", cart.length=1 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Button for item 43: inCart=false, current text="Turn In", cart.length=1 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Button for item 40: inCart=false, current text="Turn In", cart.length=1 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Button for item 42: inCart=false, current text="Turn In", cart.length=1 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Button for item 39: inCart=false, current text="Turn In", cart.length=1 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: forceButtonStateUpdate() completed (unified-teller.js, line 2315)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 1, stacks: 0 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, …} (unified-teller.js, line 3530)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, projectedTotal: 1, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔴 DEBUG: addTurninItemWithQuantity called for item 41 (unified-teller.js, line 4107)
[Log] 🔴 DEBUG: View detection - this.isTableView: true, DOM tableView visible: true, DOM gridView visible: false (unified-teller.js, line 4121)
[Log] 🔴 DEBUG: Table view active - looking for table inputs (unified-teller.js, line 4129)
[Log] 🔴 DEBUG: Units input found: true, value: 99, id: table-turnin-qty-41 (unified-teller.js, line 4139)
[Log] 🔴 DEBUG: Stacks input found: true, value: 73, id: table-turnin-stack-qty-41 (unified-teller.js, line 4140)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - checkTurninLimits: – {itemName: "Bear Hide", dailyTotal: 238, cartQuantity: 0, …} (unified-teller.js, line 1933)
{itemName: "Bear Hide", dailyTotal: 238, cartQuantity: 0, requestedQuantity: 3749, projectedTotal: 3987, …}Object
[Log] DEBUG: addTurninItemWithQuantity - shopItemId=41, quantity=3749, cartBefore=1 (unified-teller.js, line 4172)
[Log] DEBUG: Added turn-in item to cart: – "Bear Hide" – "quantity:" – 3749 – "Cart now has" – 2 – "items" – "existingItem:" – false (unified-teller.js, line 4200)
[Log] DEBUG: Cart contents: – [{id: 59, action: "turnin", qty: 1}, {id: 41, action: "turnin", qty: 3749}] (2) (unified-teller.js, line 4201)
[Log] DEBUG - Turn-in progress calculation: – {turn_in_quantity: 0, turn_in_quantity_type: "number", quantity: 1, …} (unified-teller.js, line 4686)
{turn_in_quantity: 0, turn_in_quantity_type: "number", quantity: 1, quantity_type: "number", raw_addition: 1}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Fixed progress calculation (no double-counting): – {dailyTotal: 0, cartQuantity: 1, projectedTotal: 1, …} (unified-teller.js, line 4701)
{dailyTotal: 0, cartQuantity: 1, projectedTotal: 1, required: 1, remaining: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {turn_in_quantity: 238, turn_in_quantity_type: "number", quantity: 3749, …} (unified-teller.js, line 4686)
{turn_in_quantity: 238, turn_in_quantity_type: "number", quantity: 3749, quantity_type: "number", raw_addition: 3987}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Fixed progress calculation (no double-counting): – {dailyTotal: 238, cartQuantity: 3749, projectedTotal: 3987, …} (unified-teller.js, line 4701)
{dailyTotal: 238, cartQuantity: 3749, projectedTotal: 3987, required: 4000, remaining: 3762, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 2994)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 2995)
[Log] 🚨 DEBUG: cart length: – 2 (unified-teller.js, line 2996)
[Log] 🚨 DEBUG: cart contents: – [Object, Object] (2) (unified-teller.js, line 2997)
[Object, Object]Array (2)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: true, cartLength: 2} (unified-teller.js, line 3001)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – false – "text:" – "View Cart (2)" (unified-teller.js, line 3018)
[Log] 🚨 DEBUG: forceButtonStateUpdate() called, cart length: – 2 (unified-teller.js, line 2274)
[Log] 🚨 DEBUG: Cart contents: – [Object, Object] (2) (unified-teller.js, line 2275)
[Object, Object]Array (2)
[Log] 🚨 DEBUG: Found 14 turn-in buttons to update (unified-teller.js, line 2288)
[Log] 🚨 DEBUG: Button for item 59: inCart=true, current text="Update", cart.length=2 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Button for item 41: inCart=true, current text="Turn In", cart.length=2 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Updated button text to "Update" for item 41 (unified-teller.js, line 2306)
[Log] 🚨 DEBUG: Button for item 38: inCart=false, current text="Turn In", cart.length=2 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Button for item 43: inCart=false, current text="Turn In", cart.length=2 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Button for item 40: inCart=false, current text="Turn In", cart.length=2 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Button for item 42: inCart=false, current text="Turn In", cart.length=2 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Button for item 39: inCart=false, current text="Turn In", cart.length=2 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Button for item 59: inCart=true, current text="Update", cart.length=2 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Button for item 41: inCart=true, current text="Turn In", cart.length=2 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Updated button text to "Update" for item 41 (unified-teller.js, line 2306)
[Log] 🚨 DEBUG: Button for item 38: inCart=false, current text="Turn In", cart.length=2 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Button for item 43: inCart=false, current text="Turn In", cart.length=2 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Button for item 40: inCart=false, current text="Turn In", cart.length=2 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Button for item 42: inCart=false, current text="Turn In", cart.length=2 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: Button for item 39: inCart=false, current text="Turn In", cart.length=2 (unified-teller.js, line 2301)
[Log] 🚨 DEBUG: forceButtonStateUpdate() completed (unified-teller.js, line 2315)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 99, stacks: 73 (unified-teller.js, line 3484)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 3749, …} (unified-teller.js, line 3530)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 3749, projectedTotal: 3987, turnInRequirement: 4000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1886)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1886)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1886)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object