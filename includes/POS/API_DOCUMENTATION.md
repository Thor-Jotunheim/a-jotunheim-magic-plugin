# Jotunheim Magic Plugin - Comprehensive Database API

This document explains how to use the new comprehensive API system for managing all database tables in the Jotunheim Magic Plugin.

## Overview

The comprehensive API provides REST endpoints for all major database tables, replacing the need for Google Sheets integration. All endpoints are secured with WordPress authentication and follow REST API best practices.

## Database Tables Covered

1. **jotun_playerlist** - Registered players who can purchase from shops
2. **jotun_prefablist** - All prefabs in game for Super Hammer
3. **jotun_prefab_category** - Super Hammer tab categories
4. **jotun_prefab_status** - Status tracking for Super Hammer items
5. **jotun_shops** - All shop names (player and staff shops)
6. **jotun_shop_items** - Items for sale in player shops
7. **jotun_transactions** - Player shop transaction ledger
8. **jotun_itemlist** - All in-game items and their costs
9. **jotun_ledger** - Aesir Shop transaction records

## API Endpoints

All endpoints are available under `/wp-json/jotun-api/v1/`

### Player List (jotun_playerlist)

- `GET /playerlist` - Get all players (with pagination/search)
- `POST /playerlist` - Add new player
- `PUT /playerlist/{id}` - Update player
- `DELETE /playerlist/{id}` - Delete player

**Example Player Data:**
```json
{
    "player_name": "ThorViking",
    "steam_id": "76561198000000000",
    "discord_id": "123456789012345678",
    "is_active": true
}
```

### Prefab List (jotun_prefablist)

- `GET /prefablist` - Get all prefabs
- `POST /prefablist` - Add new prefab
- `PUT /prefablist/{id}` - Update prefab
- `DELETE /prefablist/{id}` - Delete prefab

**Example Prefab Data:**
```json
{
    "prefab_name": "Wood",
    "display_name": "Wood",
    "category_id": 1,
    "is_active": true
}
```

### Shops (jotun_shops)

- `GET /shops` - Get all shops
- `POST /shops` - Add new shop
- `PUT /shops/{id}` - Update shop
- `DELETE /shops/{id}` - Delete shop

**Example Shop Data:**
```json
{
    "shop_name": "Thor's Trading Post",
    "shop_type": "player",
    "owner_id": 123,
    "description": "Best prices in Valheim!",
    "is_active": true
}
```

### Transactions (jotun_transactions)

- `GET /transactions` - Get all transactions
- `POST /transactions` - Add new transaction
- `PUT /transactions/{id}` - Update transaction
- `DELETE /transactions/{id}` - Delete transaction

**Example Transaction Data:**
```json
{
    "shop_name": "Thor's Trading Post",
    "item_name": "Iron Ingot",
    "quantity": 50,
    "total_amount": 100.0,
    "customer_name": "PlayerName",
    "transaction_type": "general"
}
```

## JavaScript API Client

A comprehensive JavaScript client is included (`jotun-comprehensive-api.js`) that provides easy-to-use functions:

### Basic Usage

```javascript
// Get all players
const players = await JotunAPI.getPlayers();

// Add a new player
const newPlayer = await JotunAPI.addPlayer({
    player_name: "NewPlayer",
    steam_id: "76561198000000000",
    is_active: true
});

// Search players
const searchResults = await PlayerManager.searchPlayers("Thor");

// Record a sale
await TransactionManager.recordSale(
    "Thor's Shop",      // shop name
    "Iron Sword",       // item name
    1,                  // quantity
    25.0,              // total amount
    "Customer",        // customer name
    "general"          // transaction type
);
```

### Error Handling

The API client includes built-in error handling and user notifications:

```javascript
try {
    const result = await JotunAPI.addPlayer(playerData);
    // Success notification automatically shown
} catch (error) {
    // Error notification automatically shown
    console.error('Failed to add player:', error);
}
```

## Player List Management Interface

A complete admin interface is available at:
**WordPress Admin → Jotunheim Magic Plugin → Player List**

### Features:

1. **Player Management**
   - Add new players manually
   - Edit existing player information
   - Activate/deactivate players
   - Delete players

2. **Search & Filter**
   - Search by player name
   - Filter by status (active/inactive)
   - Filter by recent registrations

3. **Bulk Operations**
   - Select multiple players
   - Bulk activate/deactivate
   - Bulk delete
   - Bulk export

4. **Import/Export**
   - Import players from CSV files
   - Export player list to CSV
   - Drag-and-drop file upload

5. **Statistics Dashboard**
   - Total players count
   - Active players count
   - Recent registrations (last 7 days)

## Query Parameters

Most GET endpoints support these query parameters:

- `limit` - Number of records to return (default: 100)
- `offset` - Number of records to skip (for pagination)
- `search` - Search term for filtering
- `category` - Filter by category (where applicable)
- `shop_id` - Filter by shop ID (for shop items)
- `date_from` / `date_to` - Date range filtering

**Example:**
```
GET /wp-json/jotun-api/v1/playerlist?search=Thor&limit=50&offset=0
```

## Authentication

All endpoints require WordPress authentication. Users must have `edit_posts` capability or higher to access the API.

## Error Responses

The API returns standard HTTP status codes:

- `200` - Success
- `201` - Created
- `400` - Bad Request (validation error)
- `401` - Unauthorized
- `404` - Not Found
- `409` - Conflict (duplicate data)
- `500` - Internal Server Error

**Error Response Format:**
```json
{
    "error": "Error message description"
}
```

**Success Response Format:**
```json
{
    "data": [...],           // For GET requests
    "message": "Success!",   // For POST/PUT/DELETE
    "id": 123               // For POST requests (new record ID)
}
```

## Migration from Google Sheets

To migrate from Google Sheets:

1. Export your existing Google Sheets data as CSV
2. Use the Player List Management interface to import the CSV
3. Review imported data for accuracy
4. Deactivate Google Sheets integration
5. Update any existing code to use the new API endpoints

## Next Steps

With this API system in place, you can now:

1. Build point-of-sale interfaces that write directly to the database
2. Create inventory management systems
3. Develop transaction reporting tools
4. Integrate with Discord bots or other external systems
5. Build mobile apps that connect to your server

The API is designed to be extensible, so additional endpoints can be easily added as needed.