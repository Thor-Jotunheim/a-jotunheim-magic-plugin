[Log] JQMIGRATE: Migrate is installed, version 3.4.1 (load-scripts.php, line 5)
[Log] Jotunheim Comprehensive API loaded (jotun-comprehensive-api.js, line 526)
[Log] 🚀🚀� UNIFIED TELLER: Initialization check: – {unified-teller-interface: true, teller-shop-selector: true, unified-teller-container: false, …} (unified-teller.js, line 4964)
{unified-teller-interface: true, teller-shop-selector: true, unified-teller-container: false, refresh-shop-btn: true, shouldInitialize: true}Object
[Log] 🚀🚀� UNIFIED TELLER: Conditions met, initializing UnifiedTeller... (unified-teller.js, line 4973)
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
[Log] 🚨 DEBUG: Current cart contents: – [] (0) (unified-teller.js, line 2131)
[Log] 🚨 DEBUG: Cart array set to empty. New length: – 0 (unified-teller.js, line 2134)
[Log] 🚨 DEBUG: updateCartDisplay() called (unified-teller.js, line 2137)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 2992)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 2993)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 2994)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 2995)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 2999)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3016)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 2141)
[Log] 🚨 DEBUG: updateRecordTransactionButton() called (unified-teller.js, line 2144)
[Log] DEBUG: resetItemDisplay() called. Cart length: 0 (unified-teller.js, line 2158)
[Log] DEBUG: Clearing 0 input fields (unified-teller.js, line 2174)
[Log] 🚨 DEBUG: resetItemDisplay() called (unified-teller.js, line 2148)
[Log] 🚨 DEBUG: showShopView() called (unified-teller.js, line 2951)
[Log] 🚨 DEBUG: Setting isCartView to false (unified-teller.js, line 2952)
[Log] 🚨 DEBUG: shopInventoryCard found: – true (unified-teller.js, line 2957)
[Log] 🚨 DEBUG: transactionSummaryCard found: – true (unified-teller.js, line 2964)
[Log] 🚨 DEBUG: Buttons found - viewCart: – true – "record:" – true – "back:" – true (unified-teller.js, line 2974)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 2992)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 2993)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 2994)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 2995)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 2999)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3016)
[Log] 🚨 DEBUG: showShopView() called (unified-teller.js, line 2152)
[Log] 🚨🚨🚨 DEBUG: clearCart() completed - CART CLEARING FINISHED (unified-teller.js, line 2154)
[Log] Loading turn-in items for shop ID: – "139" – "rotation:" – "1" (unified-teller.js, line 862)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/shop-items?shop_id=139&rotation=1" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "8be04cc55d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] DEBUG: About to force button state update. Cart length: 0 (unified-teller.js, line 2188)
[Log] 🚨 DEBUG: forceButtonStateUpdate() called, cart length: – 0 (unified-teller.js, line 2272)
[Log] 🚨 DEBUG: Cart contents: – [] (0) (unified-teller.js, line 2273)
[Log] 🚨 DEBUG: Found 0 turn-in buttons to update (unified-teller.js, line 2286)
[Log] 🚨 DEBUG: forceButtonStateUpdate() completed (unified-teller.js, line 2313)
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
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1899)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1899)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1899)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1899)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3533)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 1, …}Object
[Log] Generating button for item 59: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1446)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1899)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1899)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1899)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1899)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, …} (unified-teller.js, line 3533)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, projectedTotal: 238, turnInRequirement: 4000, …}Object
[Log] Generating button for item 41: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1446)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1899)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1899)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1899)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1899)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, …} (unified-teller.js, line 3533)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, projectedTotal: 4, turnInRequirement: 250, …}Object
[Log] Generating button for item 38: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1446)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1899)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1899)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1899)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1899)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3533)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 1500, …}Object
[Log] Generating button for item 43: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1446)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1899)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1899)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1899)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1899)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3533)
{itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 50, …}Object
[Log] Generating button for item 40: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1446)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1899)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1899)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1899)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1899)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3533)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 2000, …}Object
[Log] Generating button for item 42: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1446)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1899)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1899)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1899)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1899)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3533)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 125, …}Object
[Log] Generating button for item 39: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1446)
[Log] Setting up turn-in tracking after loading items (unified-teller.js, line 900)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 2992)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 2993)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 2994)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 2995)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 2999)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3016)
[Log] 🔧 DEBUG: toggleItemsView() called, current isTableView: – false (unified-teller.js, line 2194)
[Log] 🔧 DEBUG: Found elements - gridView: – true – "tableView:" – true – "toggleBtn:" – true (unified-teller.js, line 2198)
[Log] 🔧 DEBUG: All elements found, proceeding with toggle (unified-teller.js, line 2201)
[Log] 🔧 DEBUG: Switching FROM grid TO table view (unified-teller.js, line 2212)
[Log] 🔧 DEBUG: renderItemsTable called, container: –  (unified-teller.js, line 4336)
<div class="items-table-wrapper" id="items-table-view" style="display: block;">…</div>

<div class="items-table-wrapper" id="items-table-view" style="display: block;">…</div>
[Log] 🔧 DEBUG: shopItems length: – 7 (unified-teller.js, line 4337)
[Log] 🔧 DEBUG: availableItems length: – 7 (unified-teller.js, line 4349)
[Log] 🔧 DEBUG: availableItems: – ["Abomination Trophy", "Bear Hide", "Bear Trophy", …] (7) (unified-teller.js, line 4350)
["Abomination Trophy", "Bear Hide", "Bear Trophy", "Ectoplasm", "Ghost Trophy", "Vile Ribcage", "Vile Trophy"]Array (7)
[Log] 🔧 DEBUG: leftItems length: – 4 – "rightItems length:" – 3 (unified-teller.js, line 4356)
[Log] 🔧 DEBUG: Creating table HTML structure without icon column (unified-teller.js, line 4358)
[Log] 🔧 DEBUG: About to populate left table with – 4 – "items" (unified-teller.js, line 4402)
[Log] 🔧 DEBUG: Processing left item – 0 – ":" – "Abomination Trophy" (unified-teller.js, line 4404)
[Log] 🔧 DEBUG: createTableRow called for item: – "Abomination Trophy" – {shop_item_id: "59", shop_id: "139", item_id: "474", …} (unified-teller.js, line 4419)
{shop_item_id: "59", shop_id: "139", item_id: "474", prefab_id: null, item_name: "Abomination Trophy", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1899)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1899)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3533)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 1, …}Object
[Log] Generating button for item 59: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1446)
[Log] 🔧 DEBUG: Processing left item – 1 – ":" – "Bear Hide" (unified-teller.js, line 4404)
[Log] 🔧 DEBUG: createTableRow called for item: – "Bear Hide" – {shop_item_id: "41", shop_id: "139", item_id: "677", …} (unified-teller.js, line 4419)
{shop_item_id: "41", shop_id: "139", item_id: "677", prefab_id: null, item_name: "Bear Hide", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1899)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1899)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, …} (unified-teller.js, line 3533)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, projectedTotal: 238, turnInRequirement: 4000, …}Object
[Log] Generating button for item 41: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1446)
[Log] 🔧 DEBUG: Processing left item – 2 – ":" – "Bear Trophy" (unified-teller.js, line 4404)
[Log] 🔧 DEBUG: createTableRow called for item: – "Bear Trophy" – {shop_item_id: "38", shop_id: "139", item_id: "678", …} (unified-teller.js, line 4419)
{shop_item_id: "38", shop_id: "139", item_id: "678", prefab_id: null, item_name: "Bear Trophy", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1899)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1899)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, …} (unified-teller.js, line 3533)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, projectedTotal: 4, turnInRequirement: 250, …}Object
[Log] Generating button for item 38: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1446)
[Log] 🔧 DEBUG: Processing left item – 3 – ":" – "Ectoplasm" (unified-teller.js, line 4404)
[Log] 🔧 DEBUG: createTableRow called for item: – "Ectoplasm" – {shop_item_id: "43", shop_id: "139", item_id: "682", …} (unified-teller.js, line 4419)
{shop_item_id: "43", shop_id: "139", item_id: "682", prefab_id: null, item_name: "Ectoplasm", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1899)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1899)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3533)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 1500, …}Object
[Log] Generating button for item 43: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1446)
[Log] 🔧 DEBUG: About to populate right table with – 3 – "items" (unified-teller.js, line 4410)
[Log] 🔧 DEBUG: Processing right item – 0 – ":" – "Ghost Trophy" (unified-teller.js, line 4412)
[Log] 🔧 DEBUG: createTableRow called for item: – "Ghost Trophy" – {shop_item_id: "40", shop_id: "139", item_id: "680", …} (unified-teller.js, line 4419)
{shop_item_id: "40", shop_id: "139", item_id: "680", prefab_id: null, item_name: "Ghost Trophy", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1899)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1899)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3533)
{itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 50, …}Object
[Log] Generating button for item 40: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1446)
[Log] 🔧 DEBUG: Processing right item – 1 – ":" – "Vile Ribcage" (unified-teller.js, line 4412)
[Log] 🔧 DEBUG: createTableRow called for item: – "Vile Ribcage" – {shop_item_id: "42", shop_id: "139", item_id: "681", …} (unified-teller.js, line 4419)
{shop_item_id: "42", shop_id: "139", item_id: "681", prefab_id: null, item_name: "Vile Ribcage", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1899)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1899)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3533)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 2000, …}Object
[Log] Generating button for item 42: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1446)
[Log] 🔧 DEBUG: Processing right item – 2 – ":" – "Vile Trophy" (unified-teller.js, line 4412)
[Log] 🔧 DEBUG: createTableRow called for item: – "Vile Trophy" – {shop_item_id: "39", shop_id: "139", item_id: "679", …} (unified-teller.js, line 4419)
{shop_item_id: "39", shop_id: "139", item_id: "679", prefab_id: null, item_name: "Vile Trophy", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1899)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1899)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3533)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 125, …}Object
[Log] Generating button for item 39: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1446)
[Log] 🟡 Manually attaching event listeners to units input: – "table-turnin-qty-59" (unified-teller.js, line 4459)
[Log] 🟡 Input element details: – {id: "table-turnin-qty-59", value: "0", type: "number"} (unified-teller.js, line 4460)
[Log] 🟡 Manually attaching event listeners to stacks input: – "table-turnin-stack-qty-59" (unified-teller.js, line 4499)
[Log] 🟡 Stacks input element details: – {id: "table-turnin-stack-qty-59", value: "0", type: "number"} (unified-teller.js, line 4500)
[Log] 🟡 Manually attaching event listeners to units input: – "table-turnin-qty-41" (unified-teller.js, line 4459)
[Log] 🟡 Input element details: – {id: "table-turnin-qty-41", value: "0", type: "number"} (unified-teller.js, line 4460)
[Log] 🟡 Manually attaching event listeners to stacks input: – "table-turnin-stack-qty-41" (unified-teller.js, line 4499)
[Log] 🟡 Stacks input element details: – {id: "table-turnin-stack-qty-41", value: "0", type: "number"} (unified-teller.js, line 4500)
[Log] 🟡 Manually attaching event listeners to units input: – "table-turnin-qty-38" (unified-teller.js, line 4459)
[Log] 🟡 Input element details: – {id: "table-turnin-qty-38", value: "0", type: "number"} (unified-teller.js, line 4460)
[Log] 🟡 Manually attaching event listeners to stacks input: – "table-turnin-stack-qty-38" (unified-teller.js, line 4499)
[Log] 🟡 Stacks input element details: – {id: "table-turnin-stack-qty-38", value: "0", type: "number"} (unified-teller.js, line 4500)
[Log] 🟡 Manually attaching event listeners to units input: – "table-turnin-qty-43" (unified-teller.js, line 4459)
[Log] 🟡 Input element details: – {id: "table-turnin-qty-43", value: "0", type: "number"} (unified-teller.js, line 4460)
[Log] 🟡 Manually attaching event listeners to stacks input: – "table-turnin-stack-qty-43" (unified-teller.js, line 4499)
[Log] 🟡 Stacks input element details: – {id: "table-turnin-stack-qty-43", value: "0", type: "number"} (unified-teller.js, line 4500)
[Log] 🟡 Manually attaching event listeners to units input: – "table-turnin-qty-40" (unified-teller.js, line 4459)
[Log] 🟡 Input element details: – {id: "table-turnin-qty-40", value: "0", type: "number"} (unified-teller.js, line 4460)
[Log] 🟡 Manually attaching event listeners to stacks input: – "table-turnin-stack-qty-40" (unified-teller.js, line 4499)
[Log] 🟡 Stacks input element details: – {id: "table-turnin-stack-qty-40", value: "0", type: "number"} (unified-teller.js, line 4500)
[Log] 🟡 Manually attaching event listeners to units input: – "table-turnin-qty-42" (unified-teller.js, line 4459)
[Log] 🟡 Input element details: – {id: "table-turnin-qty-42", value: "0", type: "number"} (unified-teller.js, line 4460)
[Log] 🟡 Manually attaching event listeners to stacks input: – "table-turnin-stack-qty-42" (unified-teller.js, line 4499)
[Log] 🟡 Stacks input element details: – {id: "table-turnin-stack-qty-42", value: "0", type: "number"} (unified-teller.js, line 4500)
[Log] 🟡 Manually attaching event listeners to units input: – "table-turnin-qty-39" (unified-teller.js, line 4459)
[Log] 🟡 Input element details: – {id: "table-turnin-qty-39", value: "0", type: "number"} (unified-teller.js, line 4460)
[Log] 🟡 Manually attaching event listeners to stacks input: – "table-turnin-stack-qty-39" (unified-teller.js, line 4499)
[Log] 🟡 Stacks input element details: – {id: "table-turnin-stack-qty-39", value: "0", type: "number"} (unified-teller.js, line 4500)
[Log] 🔸 Units input focused: – "table-turnin-qty-59" (unified-teller.js, line 4464)
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-qty-59" – "event:" – KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-qty-59", key: "1", currentValue: "", …} (unified-teller.js, line 1953)
{inputId: "table-turnin-qty-59", key: "1", currentValue: "", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "1", currentValue: "", cursorPos: null, …} (unified-teller.js, line 1977)
{key: "1", currentValue: "", cursorPos: null, cursorPosFixed: 0, newValue: "1", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-qty-59", itemFound: false, itemName: undefined} (unified-teller.js, line 1991)
[Log] 🟢 MANUAL ONINPUT FIRED for – "table-turnin-qty-59" – "value:" – "1" (unified-teller.js, line 4468)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1899)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Abomination Trophy", inputId: "table-turnin-qty-59", units: 1, …} (unified-teller.js, line 3380)
{itemName: "Abomination Trophy", inputId: "table-turnin-qty-59", units: 1, stacks: 0, stackSize: 20, …}Object
[Log] 🔵 updateProgressDisplay called for item 59 (unified-teller.js, line 3215)
[Log] 🔵 Progress element found: – true (unified-teller.js, line 3217)
[Log] 🔵 Item found: – true – "Abomination Trophy" (unified-teller.js, line 3221)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 1, stacks: 0 (unified-teller.js, line 3487)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, …} (unified-teller.js, line 3533)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, projectedTotal: 1, turnInRequirement: 1, …}Object
[Log] 🔵 Generated progress HTML: – "<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">1 / …" (unified-teller.js, line 3224)
"<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">1 / 1 collected</div>"
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔵 updateProgressDisplay called for item 59 (unified-teller.js, line 3215)
[Log] 🔵 Progress element found: – true (unified-teller.js, line 3217)
[Log] 🔵 Item found: – true – "Abomination Trophy" (unified-teller.js, line 3221)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 1, stacks: 0 (unified-teller.js, line 3487)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, …} (unified-teller.js, line 3533)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, projectedTotal: 1, turnInRequirement: 1, …}Object
[Log] 🔵 Generated progress HTML: – "<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">1 / …" (unified-teller.js, line 3224)
"<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">1 / 1 collected</div>"
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔵 updateProgressDisplay called for item 59 (unified-teller.js, line 3215)
[Log] 🔵 Progress element found: – true (unified-teller.js, line 3217)
[Log] 🔵 Item found: – true – "Abomination Trophy" (unified-teller.js, line 3221)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 1, stacks: 0 (unified-teller.js, line 3487)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, …} (unified-teller.js, line 3533)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, projectedTotal: 1, turnInRequirement: 1, …}Object
[Log] 🔵 Generated progress HTML: – "<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">1 / …" (unified-teller.js, line 3224)
"<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">1 / 1 collected</div>"
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🟠 MANUAL ONCHANGE FIRED for – "table-turnin-qty-59" – "value:" – "1" (unified-teller.js, line 4475)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1899)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Abomination Trophy", inputId: "table-turnin-qty-59", units: 1, …} (unified-teller.js, line 3380)
{itemName: "Abomination Trophy", inputId: "table-turnin-qty-59", units: 1, stacks: 0, stackSize: 20, …}Object
[Log] 🔵 updateProgressDisplay called for item 59 (unified-teller.js, line 3215)
[Log] 🔵 Progress element found: – true (unified-teller.js, line 3217)
[Log] 🔵 Item found: – true – "Abomination Trophy" (unified-teller.js, line 3221)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 1, stacks: 0 (unified-teller.js, line 3487)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, …} (unified-teller.js, line 3533)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, projectedTotal: 1, turnInRequirement: 1, …}Object
[Log] 🔵 Generated progress HTML: – "<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">1 / …" (unified-teller.js, line 3224)
"<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">1 / 1 collected</div>"
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔵 updateProgressDisplay called for item 59 (unified-teller.js, line 3215)
[Log] 🔵 Progress element found: – true (unified-teller.js, line 3217)
[Log] 🔵 Item found: – true – "Abomination Trophy" (unified-teller.js, line 3221)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 1, stacks: 0 (unified-teller.js, line 3487)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, …} (unified-teller.js, line 3533)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, projectedTotal: 1, turnInRequirement: 1, …}Object
[Log] 🔵 Generated progress HTML: – "<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">1 / …" (unified-teller.js, line 3224)
"<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">1 / 1 collected</div>"
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔵 updateProgressDisplay called for item 59 (unified-teller.js, line 3215)
[Log] 🔵 Progress element found: – true (unified-teller.js, line 3217)
[Log] 🔵 Item found: – true – "Abomination Trophy" (unified-teller.js, line 3221)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 1, stacks: 0 (unified-teller.js, line 3487)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, …} (unified-teller.js, line 3533)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, projectedTotal: 1, turnInRequirement: 1, …}Object
[Log] 🔵 Generated progress HTML: – "<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">1 / …" (unified-teller.js, line 3224)
"<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">1 / 1 collected</div>"
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔸 Units input focused: – "table-turnin-qty-41" (unified-teller.js, line 4464)
[Log] 🔥 KEYDOWN FIRED on – "table-turnin-qty-41" – "event:" – KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] 🚨 PREVENT OVER LIMIT DEBUG: – {inputId: "table-turnin-qty-41", key: "1", currentValue: "", …} (unified-teller.js, line 1953)
{inputId: "table-turnin-qty-41", key: "1", currentValue: "", cursorPos: null}Object
[Log] 🚨 NUMBER KEY PRESSED: – {key: "1", currentValue: "", cursorPos: null, …} (unified-teller.js, line 1977)
{key: "1", currentValue: "", cursorPos: null, cursorPosFixed: 0, newValue: "1", …}Object
[Log] 🚨 TURNIN VALIDATION: – {shopItemId: "table-turnin-qty-41", itemFound: false, itemName: undefined} (unified-teller.js, line 1991)
[Log] 🟢 MANUAL ONINPUT FIRED for – "table-turnin-qty-41" – "value:" – "1" (unified-teller.js, line 4468)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1899)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Bear Hide", inputId: "table-turnin-qty-41", units: 1, …} (unified-teller.js, line 3380)
{itemName: "Bear Hide", inputId: "table-turnin-qty-41", units: 1, stacks: 0, stackSize: 50, …}Object
[Log] 🔵 updateProgressDisplay called for item 41 (unified-teller.js, line 3215)
[Log] 🔵 Progress element found: – true (unified-teller.js, line 3217)
[Log] 🔵 Item found: – true – "Bear Hide" (unified-teller.js, line 3221)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 1, stacks: 0 (unified-teller.js, line 3487)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 1, …} (unified-teller.js, line 3533)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 1, projectedTotal: 239, turnInRequirement: 4000, …}Object
[Log] 🔵 Generated progress HTML: – "<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">239 / 400…" (unified-teller.js, line 3224)
"<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">239 / 4000 collected</div>"
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔵 updateProgressDisplay called for item 41 (unified-teller.js, line 3215)
[Log] 🔵 Progress element found: – true (unified-teller.js, line 3217)
[Log] 🔵 Item found: – true – "Bear Hide" (unified-teller.js, line 3221)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 1, stacks: 0 (unified-teller.js, line 3487)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 1, …} (unified-teller.js, line 3533)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 1, projectedTotal: 239, turnInRequirement: 4000, …}Object
[Log] 🔵 Generated progress HTML: – "<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">239 / 400…" (unified-teller.js, line 3224)
"<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">239 / 4000 collected</div>"
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔵 updateProgressDisplay called for item 41 (unified-teller.js, line 3215)
[Log] 🔵 Progress element found: – true (unified-teller.js, line 3217)
[Log] 🔵 Item found: – true – "Bear Hide" (unified-teller.js, line 3221)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 1, stacks: 0 (unified-teller.js, line 3487)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 1, …} (unified-teller.js, line 3533)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 1, projectedTotal: 239, turnInRequirement: 4000, …}Object
[Log] 🔵 Generated progress HTML: – "<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">239 / 400…" (unified-teller.js, line 3224)
"<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">239 / 4000 collected</div>"
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🟠 MANUAL ONCHANGE FIRED for – "table-turnin-qty-41" – "value:" – "1" (unified-teller.js, line 4475)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1899)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits combined: – {itemName: "Bear Hide", inputId: "table-turnin-qty-41", units: 1, …} (unified-teller.js, line 3380)
{itemName: "Bear Hide", inputId: "table-turnin-qty-41", units: 1, stacks: 0, stackSize: 50, …}Object
[Log] 🔵 updateProgressDisplay called for item 41 (unified-teller.js, line 3215)
[Log] 🔵 Progress element found: – true (unified-teller.js, line 3217)
[Log] 🔵 Item found: – true – "Bear Hide" (unified-teller.js, line 3221)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 1, stacks: 0 (unified-teller.js, line 3487)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 1, …} (unified-teller.js, line 3533)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 1, projectedTotal: 239, turnInRequirement: 4000, …}Object
[Log] 🔵 Generated progress HTML: – "<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">239 / 400…" (unified-teller.js, line 3224)
"<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">239 / 4000 collected</div>"
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔵 updateProgressDisplay called for item 41 (unified-teller.js, line 3215)
[Log] 🔵 Progress element found: – true (unified-teller.js, line 3217)
[Log] 🔵 Item found: – true – "Bear Hide" (unified-teller.js, line 3221)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 1, stacks: 0 (unified-teller.js, line 3487)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 1, …} (unified-teller.js, line 3533)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 1, projectedTotal: 239, turnInRequirement: 4000, …}Object
[Log] 🔵 Generated progress HTML: – "<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">239 / 400…" (unified-teller.js, line 3224)
"<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">239 / 4000 collected</div>"
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔵 updateProgressDisplay called for item 41 (unified-teller.js, line 3215)
[Log] 🔵 Progress element found: – true (unified-teller.js, line 3217)
[Log] 🔵 Item found: – true – "Bear Hide" (unified-teller.js, line 3221)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 1, stacks: 0 (unified-teller.js, line 3487)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 1, …} (unified-teller.js, line 3533)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 1, projectedTotal: 239, turnInRequirement: 4000, …}Object
[Log] 🔵 Generated progress HTML: – "<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">239 / 400…" (unified-teller.js, line 3224)
"<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">239 / 4000 collected</div>"
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔴 DEBUG: addTurninItemWithQuantity called for item 59 (unified-teller.js, line 4110)
[Log] 🔴 DEBUG: Customer validation failed (unified-teller.js, line 4114)
[Log] handleCustomerSearch called with: – "a" (unified-teller.js, line 3566)
[Log] handleCustomerSearch called with: – "as" (unified-teller.js, line 3566)
[Log] Filtered players: – [Object, Object, Object, …] (31) (unified-teller.js, line 3596)
[Object, Object, Object, Object, Object, Object, Object, Object, Object, Object, …]Array (31)
[Log] handleCustomerSearch called with: – "asd" (unified-teller.js, line 3566)
[Log] Filtered players: – [Object] (1) (unified-teller.js, line 3596)
[Object]Array (1)
[Log] handleCustomerSearch called with: – "asdf" (unified-teller.js, line 3566)
[Log] Filtered players: – [Object] (1) (unified-teller.js, line 3596)
[Object]Array (1)
[Log] Exact match found: – "asdf" (unified-teller.js, line 3604)
[Log] Validating customer: – "asdf" (unified-teller.js, line 1626)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/playerlist?search=asdf" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "8be04cc55d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: Array} (jotun-comprehensive-api.js, line 39)
{data: Array}Object
[Log] Search API response: – {data: Array} (unified-teller.js, line 1630)
{data: Array}Object
[Log] Players found from search: – [Object] (1) (unified-teller.js, line 1632)
[Object]Array (1)
[Log] Checking player: asdf, activeMatch: true, nameMatch: true (unified-teller.js, line 1655)
[Log] Player found result: – {id: "716", score: "0", level: "1", …} (unified-teller.js, line 1659)
{id: "716", score: "0", level: "1", created_at: "2025-09-30 11:55:41", steam_id: "", …}Object
[Log] Validation successful for: – "asdf" (unified-teller.js, line 1661)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 2992)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 2993)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 2994)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 2995)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 2999)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 3016)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/transactions?customer_name=asdf&transaction_type=turnin&hours=24" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "8be04cc55d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] Response received: – 200 – "OK" (jotun-comprehensive-api.js, line 36)
[Log] Response data: – {data: []} (jotun-comprehensive-api.js, line 39)
[Log] Daily turn-in data loaded: – {} (unified-teller.js, line 927)
[Log] Preserving quantities and re-rendering items... (unified-teller.js, line 3254)
[Log] Saved table-turnin-qty-59: 1 (unified-teller.js, line 3271)
[Log] Saved table-turnin-qty-41: 1 (unified-teller.js, line 3271)
[Log] 🔧 DEBUG: renderItemsTable called, container: –  (unified-teller.js, line 4336)
<div class="items-table-wrapper" id="items-table-view" style="display: block;">…</div>

<div class="items-table-wrapper" id="items-table-view" style="display: block;">…</div>
[Log] 🔧 DEBUG: shopItems length: – 7 (unified-teller.js, line 4337)
[Log] 🔧 DEBUG: availableItems length: – 7 (unified-teller.js, line 4349)
[Log] 🔧 DEBUG: availableItems: – ["Abomination Trophy", "Bear Hide", "Bear Trophy", …] (7) (unified-teller.js, line 4350)
["Abomination Trophy", "Bear Hide", "Bear Trophy", "Ectoplasm", "Ghost Trophy", "Vile Ribcage", "Vile Trophy"]Array (7)
[Log] 🔧 DEBUG: leftItems length: – 4 – "rightItems length:" – 3 (unified-teller.js, line 4356)
[Log] 🔧 DEBUG: Creating table HTML structure without icon column (unified-teller.js, line 4358)
[Log] 🔧 DEBUG: About to populate left table with – 4 – "items" (unified-teller.js, line 4402)
[Log] 🔧 DEBUG: Processing left item – 0 – ":" – "Abomination Trophy" (unified-teller.js, line 4404)
[Log] 🔧 DEBUG: createTableRow called for item: – "Abomination Trophy" – {shop_item_id: "59", shop_id: "139", item_id: "474", …} (unified-teller.js, line 4419)
{shop_item_id: "59", shop_id: "139", item_id: "474", prefab_id: null, item_name: "Abomination Trophy", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1899)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1899)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3533)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 1, …}Object
[Log] Generating button for item 59: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1446)
[Log] 🔧 DEBUG: Processing left item – 1 – ":" – "Bear Hide" (unified-teller.js, line 4404)
[Log] 🔧 DEBUG: createTableRow called for item: – "Bear Hide" – {shop_item_id: "41", shop_id: "139", item_id: "677", …} (unified-teller.js, line 4419)
{shop_item_id: "41", shop_id: "139", item_id: "677", prefab_id: null, item_name: "Bear Hide", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1899)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1899)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, …} (unified-teller.js, line 3533)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, projectedTotal: 238, turnInRequirement: 4000, …}Object
[Log] Generating button for item 41: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1446)
[Log] 🔧 DEBUG: Processing left item – 2 – ":" – "Bear Trophy" (unified-teller.js, line 4404)
[Log] 🔧 DEBUG: createTableRow called for item: – "Bear Trophy" – {shop_item_id: "38", shop_id: "139", item_id: "678", …} (unified-teller.js, line 4419)
{shop_item_id: "38", shop_id: "139", item_id: "678", prefab_id: null, item_name: "Bear Trophy", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1899)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1899)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, …} (unified-teller.js, line 3533)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, projectedTotal: 4, turnInRequirement: 250, …}Object
[Log] Generating button for item 38: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1446)
[Log] 🔧 DEBUG: Processing left item – 3 – ":" – "Ectoplasm" (unified-teller.js, line 4404)
[Log] 🔧 DEBUG: createTableRow called for item: – "Ectoplasm" – {shop_item_id: "43", shop_id: "139", item_id: "682", …} (unified-teller.js, line 4419)
{shop_item_id: "43", shop_id: "139", item_id: "682", prefab_id: null, item_name: "Ectoplasm", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1899)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1899)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3533)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 1500, …}Object
[Log] Generating button for item 43: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1446)
[Log] 🔧 DEBUG: About to populate right table with – 3 – "items" (unified-teller.js, line 4410)
[Log] 🔧 DEBUG: Processing right item – 0 – ":" – "Ghost Trophy" (unified-teller.js, line 4412)
[Log] 🔧 DEBUG: createTableRow called for item: – "Ghost Trophy" – {shop_item_id: "40", shop_id: "139", item_id: "680", …} (unified-teller.js, line 4419)
{shop_item_id: "40", shop_id: "139", item_id: "680", prefab_id: null, item_name: "Ghost Trophy", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1899)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1899)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3533)
{itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 50, …}Object
[Log] Generating button for item 40: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1446)
[Log] 🔧 DEBUG: Processing right item – 1 – ":" – "Vile Ribcage" (unified-teller.js, line 4412)
[Log] 🔧 DEBUG: createTableRow called for item: – "Vile Ribcage" – {shop_item_id: "42", shop_id: "139", item_id: "681", …} (unified-teller.js, line 4419)
{shop_item_id: "42", shop_id: "139", item_id: "681", prefab_id: null, item_name: "Vile Ribcage", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1899)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1899)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3533)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 2000, …}Object
[Log] Generating button for item 42: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1446)
[Log] 🔧 DEBUG: Processing right item – 2 – ":" – "Vile Trophy" (unified-teller.js, line 4412)
[Log] 🔧 DEBUG: createTableRow called for item: – "Vile Trophy" – {shop_item_id: "39", shop_id: "139", item_id: "679", …} (unified-teller.js, line 4419)
{shop_item_id: "39", shop_id: "139", item_id: "679", prefab_id: null, item_name: "Vile Trophy", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1899)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1899)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: true}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3533)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 125, …}Object
[Log] Generating button for item 39: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1446)
[Log] 🟡 Manually attaching event listeners to units input: – "table-turnin-qty-59" (unified-teller.js, line 4459)
[Log] 🟡 Input element details: – {id: "table-turnin-qty-59", value: "0", type: "number"} (unified-teller.js, line 4460)
[Log] 🟡 Manually attaching event listeners to stacks input: – "table-turnin-stack-qty-59" (unified-teller.js, line 4499)
[Log] 🟡 Stacks input element details: – {id: "table-turnin-stack-qty-59", value: "0", type: "number"} (unified-teller.js, line 4500)
[Log] 🟡 Manually attaching event listeners to units input: – "table-turnin-qty-41" (unified-teller.js, line 4459)
[Log] 🟡 Input element details: – {id: "table-turnin-qty-41", value: "0", type: "number"} (unified-teller.js, line 4460)
[Log] 🟡 Manually attaching event listeners to stacks input: – "table-turnin-stack-qty-41" (unified-teller.js, line 4499)
[Log] 🟡 Stacks input element details: – {id: "table-turnin-stack-qty-41", value: "0", type: "number"} (unified-teller.js, line 4500)
[Log] 🟡 Manually attaching event listeners to units input: – "table-turnin-qty-38" (unified-teller.js, line 4459)
[Log] 🟡 Input element details: – {id: "table-turnin-qty-38", value: "0", type: "number"} (unified-teller.js, line 4460)
[Log] 🟡 Manually attaching event listeners to stacks input: – "table-turnin-stack-qty-38" (unified-teller.js, line 4499)
[Log] 🟡 Stacks input element details: – {id: "table-turnin-stack-qty-38", value: "0", type: "number"} (unified-teller.js, line 4500)
[Log] 🟡 Manually attaching event listeners to units input: – "table-turnin-qty-43" (unified-teller.js, line 4459)
[Log] 🟡 Input element details: – {id: "table-turnin-qty-43", value: "0", type: "number"} (unified-teller.js, line 4460)
[Log] 🟡 Manually attaching event listeners to stacks input: – "table-turnin-stack-qty-43" (unified-teller.js, line 4499)
[Log] 🟡 Stacks input element details: – {id: "table-turnin-stack-qty-43", value: "0", type: "number"} (unified-teller.js, line 4500)
[Log] 🟡 Manually attaching event listeners to units input: – "table-turnin-qty-40" (unified-teller.js, line 4459)
[Log] 🟡 Input element details: – {id: "table-turnin-qty-40", value: "0", type: "number"} (unified-teller.js, line 4460)
[Log] 🟡 Manually attaching event listeners to stacks input: – "table-turnin-stack-qty-40" (unified-teller.js, line 4499)
[Log] 🟡 Stacks input element details: – {id: "table-turnin-stack-qty-40", value: "0", type: "number"} (unified-teller.js, line 4500)
[Log] 🟡 Manually attaching event listeners to units input: – "table-turnin-qty-42" (unified-teller.js, line 4459)
[Log] 🟡 Input element details: – {id: "table-turnin-qty-42", value: "0", type: "number"} (unified-teller.js, line 4460)
[Log] 🟡 Manually attaching event listeners to stacks input: – "table-turnin-stack-qty-42" (unified-teller.js, line 4499)
[Log] 🟡 Stacks input element details: – {id: "table-turnin-stack-qty-42", value: "0", type: "number"} (unified-teller.js, line 4500)
[Log] 🟡 Manually attaching event listeners to units input: – "table-turnin-qty-39" (unified-teller.js, line 4459)
[Log] 🟡 Input element details: – {id: "table-turnin-qty-39", value: "0", type: "number"} (unified-teller.js, line 4460)
[Log] 🟡 Manually attaching event listeners to stacks input: – "table-turnin-stack-qty-39" (unified-teller.js, line 4499)
[Log] 🟡 Stacks input element details: – {id: "table-turnin-stack-qty-39", value: "0", type: "number"} (unified-teller.js, line 4500)
[Log] Restored table-turnin-qty-59: 1 (unified-teller.js, line 3284)
[Log] Restored table-turnin-qty-41: 1 (unified-teller.js, line 3284)
[Log] Recalculating all progress displays based on current input values... (unified-teller.js, line 3294)
[Log] Progress recalculation complete. (unified-teller.js, line 3316)
[Log] 🔴 DEBUG: addTurninItemWithQuantity called for item 59 (unified-teller.js, line 4110)
[Log] 🔴 DEBUG: View detection - this.isTableView: true, DOM tableView visible: true, DOM gridView visible: false (unified-teller.js, line 4124)
[Log] 🔴 DEBUG: Table view active - looking for table inputs (unified-teller.js, line 4132)
[Log] 🔴 DEBUG: Units input found: true, value: 1, id: table-turnin-qty-59 (unified-teller.js, line 4142)
[Log] 🔴 DEBUG: Stacks input found: true, value: 0, id: table-turnin-stack-qty-59 (unified-teller.js, line 4143)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - checkTurninLimits: – {itemName: "Abomination Trophy", dailyTotal: 0, cartQuantity: 0, …} (unified-teller.js, line 1931)
{itemName: "Abomination Trophy", dailyTotal: 0, cartQuantity: 0, requestedQuantity: 1, projectedTotal: 1, …}Object
[Log] DEBUG: addTurninItemWithQuantity - shopItemId=59, quantity=1, cartBefore=0 (unified-teller.js, line 4175)
[Log] DEBUG: Added turn-in item to cart: – "Abomination Trophy" – "quantity:" – 1 – "Cart now has" – 1 – "items" – "existingItem:" – false (unified-teller.js, line 4203)
[Log] DEBUG: Cart contents: – [{id: 59, action: "turnin", qty: 1}] (1) (unified-teller.js, line 4204)
[Log] DEBUG - Turn-in progress calculation: – {turn_in_quantity: 0, turn_in_quantity_type: "number", quantity: 1, …} (unified-teller.js, line 4758)
{turn_in_quantity: 0, turn_in_quantity_type: "number", quantity: 1, quantity_type: "number", raw_addition: 1}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Fixed progress calculation (no double-counting): – {dailyTotal: 0, cartQuantity: 1, projectedTotal: 1, …} (unified-teller.js, line 4773)
{dailyTotal: 0, cartQuantity: 1, projectedTotal: 1, required: 1, remaining: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1884)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 2992)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 2993)
[Log] 🚨 DEBUG: cart length: – 1 (unified-teller.js, line 2994)
[Log] 🚨 DEBUG: cart contents: – [Object] (1) (unified-teller.js, line 2995)
[Object]Array (1)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: true, cartLength: 1} (unified-teller.js, line 2999)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – false – "text:" – "View Cart (1)" (unified-teller.js, line 3016)
[Log] 🚨 DEBUG: forceButtonStateUpdate() called, cart length: – 1 (unified-teller.js, line 2272)
[Log] 🚨 DEBUG: Cart contents: – [Object] (1) (unified-teller.js, line 2273)
[Object]Array (1)
[Log] 🚨 DEBUG: Found 14 turn-in buttons to update (unified-teller.js, line 2286)
[Log] 🚨 DEBUG: Button for item 59: inCart=true, current text="Turn In", cart.length=1 (unified-teller.js, line 2299)
[Log] 🚨 DEBUG: Updated button text to "Update" for item 59 (unified-teller.js, line 2304)
[Log] 🚨 DEBUG: Button for item 41: inCart=false, current text="Turn In", cart.length=1 (unified-teller.js, line 2299)
[Log] 🚨 DEBUG: Button for item 38: inCart=false, current text="Turn In", cart.length=1 (unified-teller.js, line 2299)
[Log] 🚨 DEBUG: Button for item 43: inCart=false, current text="Turn In", cart.length=1 (unified-teller.js, line 2299)
[Log] 🚨 DEBUG: Button for item 40: inCart=false, current text="Turn In", cart.length=1 (unified-teller.js, line 2299)
[Log] 🚨 DEBUG: Button for item 42: inCart=false, current text="Turn In", cart.length=1 (unified-teller.js, line 2299)
[Log] 🚨 DEBUG: Button for item 39: inCart=false, current text="Turn In", cart.length=1 (unified-teller.js, line 2299)
[Log] 🚨 DEBUG: Button for item 59: inCart=true, current text="Turn In", cart.length=1 (unified-teller.js, line 2299)
[Log] 🚨 DEBUG: Updated button text to "Update" for item 59 (unified-teller.js, line 2304)
[Log] 🚨 DEBUG: Button for item 41: inCart=false, current text="Turn In", cart.length=1 (unified-teller.js, line 2299)
[Log] 🚨 DEBUG: Button for item 38: inCart=false, current text="Turn In", cart.length=1 (unified-teller.js, line 2299)
[Log] 🚨 DEBUG: Button for item 43: inCart=false, current text="Turn In", cart.length=1 (unified-teller.js, line 2299)
[Log] 🚨 DEBUG: Button for item 40: inCart=false, current text="Turn In", cart.length=1 (unified-teller.js, line 2299)
[Log] 🚨 DEBUG: Button for item 42: inCart=false, current text="Turn In", cart.length=1 (unified-teller.js, line 2299)
[Log] 🚨 DEBUG: Button for item 39: inCart=false, current text="Turn In", cart.length=1 (unified-teller.js, line 2299)
[Log] 🚨 DEBUG: forceButtonStateUpdate() completed (unified-teller.js, line 2313)
[Log] 🔵 updateProgressDisplay called for item 59 (unified-teller.js, line 3215)
[Log] 🔵 Progress element found: – true (unified-teller.js, line 3217)
[Log] 🔵 Item found: – true – "Abomination Trophy" (unified-teller.js, line 3221)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] 🔴 DEBUG: Progress using table inputs - units: 1, stacks: 0 (unified-teller.js, line 3487)
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, …} (unified-teller.js, line 3533)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 1, projectedTotal: 1, turnInRequirement: 1, …}Object
[Log] 🔵 Generated progress HTML: (unified-teller.js, line 3224)
"<div class=\"progress-line transaction-progress\">1 turned in this transaction</div><div class=\"progress-line server-progress\">1 / 1 collected</div>"
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1884)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1884)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: (unified-teller.js, line 785)
Object

currentTransactionQty: 0

dailyCollected: 238

itemName: "Bear Hide"

projected: 238

qtyInputValue: "0"

requirement: 4000

Object Prototype
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): (unified-teller.js, line 1884)
Object

item: {shop_item_id: "38", shop_id: "139", item_id: "678", prefab_id: null, item_name: "Bear Trophy", …}

itemName: "Bear Trophy"

oldMethod: 0

parsed: 4

turn_in_quantity: "4"

Object Prototype
[Log] DEBUG - Turnin compact display: (unified-teller.js, line 785)
Object

currentTransactionQty: 0

dailyCollected: 4

itemName: "Bear Trophy"

projected: 4

qtyInputValue: "0"

requirement: 250

Object Prototype
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): (unified-teller.js, line 1884)
Object

item: {shop_item_id: "43", shop_id: "139", item_id: "682", prefab_id: null, item_name: "Ectoplasm", …}

itemName: "Ectoplasm"

oldMethod: 0

parsed: 0

turn_in_quantity: "0"

Object Prototype
[Log] DEBUG - Turnin compact display: (unified-teller.js, line 785)
Object

currentTransactionQty: 0

dailyCollected: 0

itemName: "Ectoplasm"

projected: 0

qtyInputValue: "0"

requirement: 1500

Object Prototype
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): (unified-teller.js, line 1884)
Object

item: {shop_item_id: "40", shop_id: "139", item_id: "680", prefab_id: null, item_name: "Ghost Trophy", …}

itemName: "Ghost Trophy"

oldMethod: 0

parsed: 0

turn_in_quantity: "0"

Object Prototype
[Log] DEBUG - Turnin compact display: (unified-teller.js, line 785)
Object

currentTransactionQty: 0

dailyCollected: 0

itemName: "Ghost Trophy"

projected: 0

qtyInputValue: "0"

requirement: 50

Object Prototype
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): (unified-teller.js, line 1884)
Object

item: {shop_item_id: "42", shop_id: "139", item_id: "681", prefab_id: null, item_name: "Vile Ribcage", …}

itemName: "Vile Ribcage"

oldMethod: 0

parsed: 0

turn_in_quantity: "0"

Object Prototype
[Log] DEBUG - Turnin compact display: (unified-teller.js, line 785)
Object

currentTransactionQty: 0

dailyCollected: 0

itemName: "Vile Ribcage"

projected: 0

qtyInputValue: "0"

requirement: 2000

Object Prototype
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): (unified-teller.js, line 1884)
Object

item: {shop_item_id: "39", shop_id: "139", item_id: "679", prefab_id: null, item_name: "Vile Trophy", …}

itemName: "Vile Trophy"

oldMethod: 0

parsed: 0

turn_in_quantity: "0"

Object Prototype
[Log] DEBUG - Turnin compact display: (unified-teller.js, line 785)
Object

currentTransactionQty: 0

dailyCollected: 0

itemName: "Vile Trophy"

projected: 0

qtyInputValue: "0"

requirement: 125

Object Prototype