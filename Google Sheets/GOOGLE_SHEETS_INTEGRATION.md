# Google Sheets Integration

## Overview

This plugin now integrates with Google Sheets to pull item data instead of using only the local WordPress database. The integration is designed to be robust with fallback mechanisms.

## Google Sheets Configuration

- **Spreadsheet ID**: `1WzT8ivJZkdeSzwInT4cLl7Stw2p1K7vSmw9P4tjeciI`
- **Sheet Range**: `AdminManager!A:R`
- **Access Method**: CSV export (public access)

## How It Works

1. **Primary Data Source**: Google Sheets CSV export
2. **Caching**: Results are cached for 5 minutes to reduce API calls
3. **Fallback**: If Google Sheets fails, falls back to local `jotun_itemlist` table
4. **API Endpoint**: `/wp-json/jotunheim-magic/v1/items` (unchanged for compatibility)

## Expected CSV Structure

The Google Sheets should have columns that match these names (case-insensitive):

- `item_name` (required)
- `item_type` 
- `unit_price`
- `lv2_price`, `lv3_price`, `lv4_price`, `lv5_price`
- `tech_tier`
- `undercut`

## Transaction Recording

**Important**: Transaction recording continues to use the existing WordPress database tables (`jotun_transactions`). Only item data is pulled from Google Sheets.

## Testing and Administration

- Go to **Tools > Google Sheets Test** in WordPress admin
- Test the connection to Google Sheets
- View cached items
- Clear cache when needed
- Monitor error logs for troubleshooting

## Files Modified

- `includes/ItemList/itemlist-rest-api.php` - Now uses Google Sheets service
- `jotunheim-magic.php` - Added Google Sheets includes
- `includes/GoogleSheets/google-sheets-service.php` - New service class
- `includes/GoogleSheets/google-sheets-admin.php` - Admin interface

## Troubleshooting

1. Check WordPress error logs for Google Sheets fetch errors
2. Use the admin test page to verify connectivity
3. If Google Sheets is unavailable, the system automatically falls back to the database
4. Clear the cache if data seems stale

## Future Migration

When ready to move to a full WordPress database solution:
1. Import Google Sheets data into WordPress database
2. Modify `google-sheets-service.php` to read from WordPress tables instead
3. Keep the same API structure for compatibility