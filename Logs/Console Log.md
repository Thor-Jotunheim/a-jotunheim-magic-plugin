Console log:
[Log] JQMIGRATE: Migrate is installed, version 3.4.1 (load-scripts.php, line 5)
[Log] Jotunheim Comprehensive API loaded (jotun-comprehensive-api.js, line 526)
[Log] 🚀🚀� UNIFIED TELLER: Initialization check: – {unified-teller-interface: true, teller-shop-selector: true, unified-teller-container: false, …} (unified-teller.js, line 4609)
{unified-teller-interface: true, teller-shop-selector: true, unified-teller-container: false, refresh-shop-btn: true, shouldInitialize: true}Object
[Log] 🚀🚀� UNIFIED TELLER: Conditions met, initializing UnifiedTeller... (unified-teller.js, line 4618)
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
[Log] 🚨 DEBUG: Current cart contents: – [] (0) (unified-teller.js, line 1991)
[Log] 🚨 DEBUG: Cart array set to empty. New length: – 0 (unified-teller.js, line 1994)
[Log] 🚨 DEBUG: updateCartDisplay() called (unified-teller.js, line 1997)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 2850)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 2851)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 2852)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 2853)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 2857)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 2874)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 2001)
[Log] 🚨 DEBUG: updateRecordTransactionButton() called (unified-teller.js, line 2004)
[Log] DEBUG: resetItemDisplay() called. Cart length: 0 (unified-teller.js, line 2018)
[Log] DEBUG: Clearing 0 input fields (unified-teller.js, line 2034)
[Log] 🚨 DEBUG: resetItemDisplay() called (unified-teller.js, line 2008)
[Log] 🚨 DEBUG: showShopView() called (unified-teller.js, line 2809)
[Log] 🚨 DEBUG: Setting isCartView to false (unified-teller.js, line 2810)
[Log] 🚨 DEBUG: shopInventoryCard found: – true (unified-teller.js, line 2815)
[Log] 🚨 DEBUG: transactionSummaryCard found: – true (unified-teller.js, line 2822)
[Log] 🚨 DEBUG: Buttons found - viewCart: – true – "record:" – true – "back:" – true (unified-teller.js, line 2832)
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 2850)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 2851)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 2852)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 2853)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 2857)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 2874)
[Log] 🚨 DEBUG: showShopView() called (unified-teller.js, line 2012)
[Log] 🚨🚨🚨 DEBUG: clearCart() completed - CART CLEARING FINISHED (unified-teller.js, line 2014)
[Log] Loading turn-in items for shop ID: – "139" – "rotation:" – "1" (unified-teller.js, line 862)
[Log] Making API request: – "GET" – "/wp-json/jotun-api/v1/shop-items?shop_id=139&rotation=1" – null (jotun-comprehensive-api.js, line 17)
[Log] Request config: – {method: "GET", headers: {Content-Type: "application/json", X-WP-Nonce: "8be04cc55d"}} (jotun-comprehensive-api.js, line 31)
[Log] Sending fetch request... (jotun-comprehensive-api.js, line 34)
[Log] DEBUG: About to force button state update. Cart length: 0 (unified-teller.js, line 2048)
[Log] 🚨 DEBUG: forceButtonStateUpdate() called, cart length: – 0 (unified-teller.js, line 2130)
[Log] 🚨 DEBUG: Cart contents: – [] (0) (unified-teller.js, line 2131)
[Log] 🚨 DEBUG: Found 0 turn-in buttons to update (unified-teller.js, line 2144)
[Log] 🚨 DEBUG: forceButtonStateUpdate() completed (unified-teller.js, line 2171)
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
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 1, …}Object
[Log] Generating button for item 59: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1353)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1806)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1806)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1806)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1806)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, projectedTotal: 238, turnInRequirement: 4000, …}Object
[Log] Generating button for item 41: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1353)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1806)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1806)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1806)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1806)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, projectedTotal: 4, turnInRequirement: 250, …}Object
[Log] Generating button for item 38: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1353)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1806)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1806)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1806)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1806)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 1500, …}Object
[Log] Generating button for item 43: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1353)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1806)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1806)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1806)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1806)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 50, …}Object
[Log] Generating button for item 40: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1353)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1806)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1806)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1806)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1806)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 2000, …}Object
[Log] Generating button for item 42: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1353)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1806)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1806)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1806)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1806)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 125, …}Object
[Log] Generating button for item 39: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1353)
[Log] Setting up turn-in tracking after loading items (unified-teller.js, line 900)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🚨 DEBUG: updateViewCartButton() called (unified-teller.js, line 2850)
[Log] 🚨 DEBUG: viewCartBtn found: – true (unified-teller.js, line 2851)
[Log] 🚨 DEBUG: cart length: – 0 (unified-teller.js, line 2852)
[Log] 🚨 DEBUG: cart contents: – [] (0) (unified-teller.js, line 2853)
[Log] 🚨 DEBUG: Updating View Cart button: – {hasItems: false, cartLength: 0} (unified-teller.js, line 2857)
[Log] 🚨 DEBUG: View Cart button updated - disabled: – true – "text:" – "View Cart" (unified-teller.js, line 2874)
[Log] 🔧 DEBUG: toggleItemsView() called, current isTableView: – false (unified-teller.js, line 2054)
[Log] 🔧 DEBUG: Found elements - gridView: – true – "tableView:" – true – "toggleBtn:" – true (unified-teller.js, line 2058)
[Log] 🔧 DEBUG: All elements found, proceeding with toggle (unified-teller.js, line 2061)
[Log] 🔧 DEBUG: Switching FROM grid TO table view (unified-teller.js, line 2072)
[Log] 🔧 DEBUG: renderItemsTable called, container: –  (unified-teller.js, line 4067)
<div class="items-table-wrapper" id="items-table-view" style="display: block;">…</div>

<div class="items-table-wrapper" id="items-table-view" style="display: block;">…</div>
[Log] 🔧 DEBUG: shopItems length: – 7 (unified-teller.js, line 4068)
[Log] 🔧 DEBUG: Creating table HTML structure without icon column (unified-teller.js, line 4086)
[Log] 🔧 DEBUG: createTableRow called for item: – "Abomination Trophy" – {shop_item_id: "59", shop_id: "139", item_id: "474", …} (unified-teller.js, line 4141)
{shop_item_id: "59", shop_id: "139", item_id: "474", prefab_id: null, item_name: "Abomination Trophy", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 1, …}Object
[Log] Generating button for item 59: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1353)
[Log] 🔧 DEBUG: createTableRow called for item: – "Bear Hide" – {shop_item_id: "41", shop_id: "139", item_id: "677", …} (unified-teller.js, line 4141)
{shop_item_id: "41", shop_id: "139", item_id: "677", prefab_id: null, item_name: "Bear Hide", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1806)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1806)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1806)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1806)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, projectedTotal: 238, turnInRequirement: 4000, …}Object
[Log] Generating button for item 41: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1353)
[Log] 🔧 DEBUG: createTableRow called for item: – "Bear Trophy" – {shop_item_id: "38", shop_id: "139", item_id: "678", …} (unified-teller.js, line 4141)
{shop_item_id: "38", shop_id: "139", item_id: "678", prefab_id: null, item_name: "Bear Trophy", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1806)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1806)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1806)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1806)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, projectedTotal: 4, turnInRequirement: 250, …}Object
[Log] Generating button for item 38: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1353)
[Log] 🔧 DEBUG: createTableRow called for item: – "Ectoplasm" – {shop_item_id: "43", shop_id: "139", item_id: "682", …} (unified-teller.js, line 4141)
{shop_item_id: "43", shop_id: "139", item_id: "682", prefab_id: null, item_name: "Ectoplasm", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1806)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1806)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1806)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1806)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 1500, …}Object
[Log] Generating button for item 43: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1353)
[Log] 🔧 DEBUG: createTableRow called for item: – "Ghost Trophy" – {shop_item_id: "40", shop_id: "139", item_id: "680", …} (unified-teller.js, line 4141)
{shop_item_id: "40", shop_id: "139", item_id: "680", prefab_id: null, item_name: "Ghost Trophy", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1806)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1806)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1806)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1806)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 50, …}Object
[Log] Generating button for item 40: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1353)
[Log] 🔧 DEBUG: createTableRow called for item: – "Vile Ribcage" – {shop_item_id: "42", shop_id: "139", item_id: "681", …} (unified-teller.js, line 4141)
{shop_item_id: "42", shop_id: "139", item_id: "681", prefab_id: null, item_name: "Vile Ribcage", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1806)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1806)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1806)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1806)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 2000, …}Object
[Log] Generating button for item 42: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1353)
[Log] 🔧 DEBUG: createTableRow called for item: – "Vile Trophy" – {shop_item_id: "39", shop_id: "139", item_id: "679", …} (unified-teller.js, line 4141)
{shop_item_id: "39", shop_id: "139", item_id: "679", prefab_id: null, item_name: "Vile Trophy", …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1806)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1806)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1806)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1806)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 125, …}Object
[Log] Generating button for item 39: inCart=false, buttonText=Turn In, cartSize=0 (unified-teller.js, line 1353)
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 20, …} (unified-teller.js, line 3287)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 20, projectedTotal: 20, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] 🔥 KEYDOWN FIRED on – "turnin-stack-qty-59" – "event:" – KeyboardEvent {isTrusted: true, key: "8", code: "Digit8", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "8", code: "Digit8", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] 🔥 KEYDOWN FIRED on – "turnin-stack-qty-59" – "event:" – KeyboardEvent {isTrusted: true, key: "8", code: "Digit8", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "8", code: "Digit8", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] 🔥 KEYDOWN FIRED on – "turnin-stack-qty-59" – "event:" – KeyboardEvent {isTrusted: true, key: "8", code: "Digit8", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "8", code: "Digit8", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 20, …} (unified-teller.js, line 3287)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 20, projectedTotal: 20, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 19, …} (unified-teller.js, line 3287)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 19, projectedTotal: 19, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 19, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 19, projected: 19, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 18, …} (unified-teller.js, line 3287)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 18, projectedTotal: 18, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 18, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 18, projected: 18, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 20, …} (unified-teller.js, line 3287)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 20, projectedTotal: 20, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
> Selected Element
< <div class="card-header">…</div>
[Log] 🔥 KEYDOWN FIRED on – "turnin-qty-41" – "event:" – KeyboardEvent {isTrusted: true, key: "2", code: "Digit2", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "2", code: "Digit2", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1806)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1806)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits for turn-in: – {itemName: "Bear Hide", inputId: "turnin-qty-41", originalMax: "3762", …} (unified-teller.js, line 3177)
{itemName: "Bear Hide", inputId: "turnin-qty-41", originalMax: "3762", dynamicMax: 3762, currentValue: 2, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, projectedTotal: 238, turnInRequirement: 4000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "turnin-qty-41" – "event:" – KeyboardEvent {isTrusted: true, key: "2", code: "Digit2", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "2", code: "Digit2", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1806)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1806)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits for turn-in: – {itemName: "Bear Hide", inputId: "turnin-qty-41", originalMax: "3762", …} (unified-teller.js, line 3177)
{itemName: "Bear Hide", inputId: "turnin-qty-41", originalMax: "3762", dynamicMax: 3762, currentValue: 22, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, projectedTotal: 238, turnInRequirement: 4000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "turnin-qty-41" – "event:" – KeyboardEvent {isTrusted: true, key: "Enter", code: "Enter", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "Enter", code: "Enter", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, projectedTotal: 238, turnInRequirement: 4000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, projectedTotal: 238, turnInRequirement: 4000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "turnin-stack-qty-41" – "event:" – KeyboardEvent {isTrusted: true, key: "2", code: "Digit2", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "2", code: "Digit2", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1806)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, …} (unified-teller.js, line 1806)
{itemName: "Bear Hide", dailyTotal: 238, turnInRequirement: 4000, remaining: 3762, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits for turn-in: – {itemName: "Bear Hide", inputId: "turnin-stack-qty-41", originalMax: "75", …} (unified-teller.js, line 3177)
{itemName: "Bear Hide", inputId: "turnin-stack-qty-41", originalMax: "75", dynamicMax: 75, currentValue: 2, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, projectedTotal: 238, turnInRequirement: 4000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 0, projectedTotal: 238, turnInRequirement: 4000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 0, projected: 238, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 50, …} (unified-teller.js, line 3287)
{itemName: "Bear Hide", dailyTotal: 238, currentlySelected: 50, projectedTotal: 288, turnInRequirement: 4000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "turnin-stack-qty-59" – "event:" – KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 20, …} (unified-teller.js, line 3287)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 20, projectedTotal: 20, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "turnin-qty-59" – "event:" – KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] 🔥 KEYDOWN FIRED on – "turnin-qty-59" – "event:" – KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 40, …} (unified-teller.js, line 3287)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 40, projectedTotal: 40, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "turnin-qty-38" – "event:" – KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1806)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1806)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits for turn-in: – {itemName: "Bear Trophy", inputId: "turnin-qty-38", originalMax: "246", …} (unified-teller.js, line 3177)
{itemName: "Bear Trophy", inputId: "turnin-qty-38", originalMax: "246", dynamicMax: 246, currentValue: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, projectedTotal: 4, turnInRequirement: 250, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, projectedTotal: 4, turnInRequirement: 250, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, projectedTotal: 4, turnInRequirement: 250, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "turnin-stack-qty-38" – "event:" – KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1806)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, …} (unified-teller.js, line 1806)
{itemName: "Bear Trophy", dailyTotal: 4, turnInRequirement: 250, remaining: 246, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits for turn-in: – {itemName: "Bear Trophy", inputId: "turnin-stack-qty-38", originalMax: "12", …} (unified-teller.js, line 3177)
{itemName: "Bear Trophy", inputId: "turnin-stack-qty-38", originalMax: "12", dynamicMax: 12, currentValue: 10, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, projectedTotal: 4, turnInRequirement: 250, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 0, projectedTotal: 4, turnInRequirement: 250, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 0, projected: 4, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 20, …} (unified-teller.js, line 3287)
{itemName: "Bear Trophy", dailyTotal: 4, currentlySelected: 20, projectedTotal: 24, turnInRequirement: 250, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "turnin-qty-43" – "event:" – KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1806)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1806)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits for turn-in: – {itemName: "Ectoplasm", inputId: "turnin-qty-43", originalMax: "1500", …} (unified-teller.js, line 3177)
{itemName: "Ectoplasm", inputId: "turnin-qty-43", originalMax: "1500", dynamicMax: 1500, currentValue: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 1500, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 1500, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 1500, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "turnin-stack-qty-43" – "event:" – KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1806)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, …} (unified-teller.js, line 1806)
{itemName: "Ectoplasm", dailyTotal: 0, turnInRequirement: 1500, remaining: 1500, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits for turn-in: – {itemName: "Ectoplasm", inputId: "turnin-stack-qty-43", originalMax: "30", …} (unified-teller.js, line 3177)
{itemName: "Ectoplasm", inputId: "turnin-stack-qty-43", originalMax: "30", dynamicMax: 30, currentValue: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 1500, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 1500, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 50, …} (unified-teller.js, line 3287)
{itemName: "Ectoplasm", dailyTotal: 0, currentlySelected: 50, projectedTotal: 50, turnInRequirement: 1500, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "turnin-stack-qty-59" – "event:" – KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 40, …} (unified-teller.js, line 3287)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 40, projectedTotal: 40, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "turnin-qty-59" – "event:" – KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 40, …} (unified-teller.js, line 3287)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 40, projectedTotal: 40, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "turnin-qty-59" – "event:" – KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 40, …} (unified-teller.js, line 3287)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 40, projectedTotal: 40, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "turnin-stack-qty-40" – "event:" – KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1806)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 20, …} (unified-teller.js, line 3287)
{itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 20, projectedTotal: 20, turnInRequirement: 50, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "turnin-qty-40" – "event:" – KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1806)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, …} (unified-teller.js, line 1806)
{itemName: "Ghost Trophy", dailyTotal: 0, turnInRequirement: 50, remaining: 50, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits for turn-in: – {itemName: "Ghost Trophy", inputId: "turnin-qty-40", originalMax: "50", …} (unified-teller.js, line 3177)
{itemName: "Ghost Trophy", inputId: "turnin-qty-40", originalMax: "50", dynamicMax: 50, currentValue: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 20, …} (unified-teller.js, line 3287)
{itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 20, projectedTotal: 20, turnInRequirement: 50, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 20, …} (unified-teller.js, line 3287)
{itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 20, projectedTotal: 20, turnInRequirement: 50, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 40, …} (unified-teller.js, line 3287)
{itemName: "Ghost Trophy", dailyTotal: 0, currentlySelected: 40, projectedTotal: 40, turnInRequirement: 50, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "turnin-qty-42" – "event:" – KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1806)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1806)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits for turn-in: – {itemName: "Vile Ribcage", inputId: "turnin-qty-42", originalMax: "2000", …} (unified-teller.js, line 3177)
{itemName: "Vile Ribcage", inputId: "turnin-qty-42", originalMax: "2000", dynamicMax: 2000, currentValue: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 2000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 2000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 2000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "turnin-stack-qty-42" – "event:" – KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1806)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1806)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits for turn-in: – {itemName: "Vile Ribcage", inputId: "turnin-stack-qty-42", originalMax: "40", …} (unified-teller.js, line 3177)
{itemName: "Vile Ribcage", inputId: "turnin-stack-qty-42", originalMax: "40", dynamicMax: 40, currentValue: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 2000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, …} (unified-teller.js, line 3287)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 0, projectedTotal: 0, turnInRequirement: 2000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 50, …} (unified-teller.js, line 3287)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 50, projectedTotal: 50, turnInRequirement: 2000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 0, projected: 0, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "turnin-stack-qty-39" – "event:" – KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1806)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 20, …} (unified-teller.js, line 3287)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 20, projectedTotal: 20, turnInRequirement: 125, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "turnin-qty-39" – "event:" – KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1806)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1806)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG - enforceQuantityLimits for turn-in: – {itemName: "Vile Trophy", inputId: "turnin-qty-39", originalMax: "125", …} (unified-teller.js, line 3177)
{itemName: "Vile Trophy", inputId: "turnin-qty-39", originalMax: "125", dynamicMax: 125, currentValue: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 20, …} (unified-teller.js, line 3287)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 20, projectedTotal: 20, turnInRequirement: 125, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 20, …} (unified-teller.js, line 3287)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 20, projectedTotal: 20, turnInRequirement: 125, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 40, …} (unified-teller.js, line 3287)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 40, projectedTotal: 40, turnInRequirement: 125, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1806)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 41, …} (unified-teller.js, line 3287)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 41, projectedTotal: 41, turnInRequirement: 125, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 21, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 21, projected: 21, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, …} (unified-teller.js, line 1806)
{itemName: "Vile Trophy", dailyTotal: 0, turnInRequirement: 125, remaining: 125, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 42, …} (unified-teller.js, line 3287)
{itemName: "Vile Trophy", dailyTotal: 0, currentlySelected: 42, projectedTotal: 42, turnInRequirement: 125, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 22, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 22, projected: 22, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1806)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 51, …} (unified-teller.js, line 3287)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 51, projectedTotal: 51, turnInRequirement: 2000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 51, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 51, projected: 51, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 22, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 22, projected: 22, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, …} (unified-teller.js, line 1806)
{itemName: "Vile Ribcage", dailyTotal: 0, turnInRequirement: 2000, remaining: 2000, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 52, …} (unified-teller.js, line 3287)
{itemName: "Vile Ribcage", dailyTotal: 0, currentlySelected: 52, projectedTotal: 52, turnInRequirement: 2000, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 52, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 52, projected: 52, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 22, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 22, projected: 22, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] 🔥 KEYDOWN FIRED on – "turnin-qty-59" – "event:" – KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 40, …} (unified-teller.js, line 3287)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 40, projectedTotal: 40, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 52, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 52, projected: 52, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 22, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 22, projected: 22, requirement: 125, …}Object
[Log] 🔥 KEYDOWN FIRED on – "turnin-stack-qty-59" – "event:" – KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", …} (admin.php, line 1)
KeyboardEvent {isTrusted: true, key: "1", code: "Digit1", location: 0, ctrlKey: false, …}KeyboardEvent
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - getMaxAllowedTurnin: – {itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, …} (unified-teller.js, line 1806)
{itemName: "Abomination Trophy", dailyTotal: 0, turnInRequirement: 1, remaining: 1, dailyTurninDataExists: false}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 40, …} (unified-teller.js, line 3287)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 40, projectedTotal: 40, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 52, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 52, projected: 52, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 22, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 22, projected: 22, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 40, …} (unified-teller.js, line 3287)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 40, projectedTotal: 40, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 52, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 52, projected: 52, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 22, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 22, projected: 22, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 40, …} (unified-teller.js, line 3287)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 40, projectedTotal: 40, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 52, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 52, projected: 52, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 22, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 22, projected: 22, requirement: 125, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turn-in progress calculation: – {itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 40, …} (unified-teller.js, line 3287)
{itemName: "Abomination Trophy", dailyTotal: 0, currentlySelected: 40, projectedTotal: 40, turnInRequirement: 1, …}Object
[Log] getCurrentShopType: – {selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"} (unified-teller.js, line 751)
{selectedShop: "139", selectedOption: <option>, shopType: "turn-in_only"}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Abomination Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Abomination Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 1, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Hide", item: Object, turn_in_quantity: "238", …} (unified-teller.js, line 1791)
{itemName: "Bear Hide", item: Object, turn_in_quantity: "238", parsed: 238, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Bear Hide", dailyCollected: 238, currentTransactionQty: 50, projected: 288, requirement: 4000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", …} (unified-teller.js, line 1791)
{itemName: "Bear Trophy", item: Object, turn_in_quantity: "4", parsed: 4, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Bear Trophy", dailyCollected: 4, currentTransactionQty: 20, projected: 24, requirement: 250, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ectoplasm", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, …} (unified-teller.js, line 785)
{itemName: "Ectoplasm", dailyCollected: 0, currentTransactionQty: 50, projected: 50, requirement: 1500, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Ghost Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, …} (unified-teller.js, line 785)
{itemName: "Ghost Trophy", dailyCollected: 0, currentTransactionQty: 20, projected: 20, requirement: 50, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Ribcage", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 52, …} (unified-teller.js, line 785)
{itemName: "Vile Ribcage", dailyCollected: 0, currentTransactionQty: 52, projected: 52, requirement: 2000, …}Object
[Log] DEBUG getDailyTurninTotal (using turn_in_quantity from item): – {itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", …} (unified-teller.js, line 1791)
{itemName: "Vile Trophy", item: Object, turn_in_quantity: "0", parsed: 0, oldMethod: 0}Object
[Log] DEBUG - Turnin compact display: – {itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 22, …} (unified-teller.js, line 785)
{itemName: "Vile Trophy", dailyCollected: 0, currentTransactionQty: 22, projected: 22, requirement: 125, …}Object
> Selected Element
< <div class="card-header">…</div>