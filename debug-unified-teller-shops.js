#!/usr/bin/env node

/**
 * Debug script to test the unified teller shop loading issue
 * This will simulate the API call and log what we get back
 */

const API_BASE = 'https://jotunheim.net/wp-json/jotun-api/v1';

async function testShopsAPI() {
    console.log('Testing shops API endpoint...');
    
    try {
        const response = await fetch(`${API_BASE}/shops`);
        const responseText = await response.text();
        
        console.log('Response status:', response.status);
        console.log('Response headers:', Object.fromEntries(response.headers.entries()));
        console.log('Raw response (first 500 chars):', responseText.substring(0, 500));
        
        if (response.headers.get('content-type')?.includes('application/json')) {
            const data = JSON.parse(responseText);
            console.log('Parsed JSON data:', JSON.stringify(data, null, 2));
            
            if (data.data && Array.isArray(data.data)) {
                console.log(`Found ${data.data.length} shops`);
                
                const activeShops = data.data.filter(shop => shop.is_active == 1);
                console.log(`Active shops: ${activeShops.length}`);
                
                activeShops.forEach(shop => {
                    console.log(`- ${shop.shop_name} (ID: ${shop.shop_id}, Type: ${shop.shop_type})`);
                });
            } else {
                console.log('No shops found or unexpected data structure');
            }
        } else {
            console.log('Response is not JSON - likely an error page or authentication required');
        }
        
    } catch (error) {
        console.error('Error testing shops API:', error);
    }
}

testShopsAPI();