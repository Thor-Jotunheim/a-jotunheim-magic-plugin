# Point of Sale System

This implementation provides a Google Sheets-like Point of Sale system for the Jotunheim Magic Plugin.

## Features

### Admin Transactions
- Player registration with duplicate checking
- Player validation before transactions
- Transaction type selection (No Buys/Claims Only, No Claims/Buys Only, or Both)
- Multiple item entry with quantities and amounts
- Transaction recording to database

### Spell Transactions
- Player validation
- Spell entry with quantities and mana costs
- Transaction recording with spell-specific categorization

## Technical Implementation

### Database Integration
- Uses existing `jotun_ledger` table for player management
- Records transactions in `jotun_transactions` table
- Safe database operations with proper sanitization
- Handles missing database columns gracefully

### API Endpoints
- `POST /wp-json/pos/v1/register-player` - Register new players
- `POST /wp-json/pos/v1/validate-player` - Validate existing players
- `POST /wp-json/pos/v1/admin-record` - Record admin transactions
- `POST /wp-json/pos/v1/spell-record` - Record spell transactions

### Security
- WordPress nonce verification
- User capability checking (`edit_posts` permission required)
- Input sanitization and validation
- SQL injection prevention with prepared statements

### User Interface
- Tab-based interface for Admin and Spell modes
- Real-time validation feedback
- Status messages and notifications
- Responsive design
- Clear and intuitive form handling

## Usage

1. Access the Point of Sale system from the WordPress admin dashboard
2. Navigate to "Jotunheim Magic Plugin" → "Point of Sale"
3. Use the Admin tab for general transactions or Spell tab for spell-specific transactions
4. Register new players as needed
5. Validate players before recording transactions
6. Add items/spells with quantities and amounts
7. Record transactions to save to the database

## Google Apps Script Compatibility

This implementation replicates the functionality of the original Google Apps Script:
- Player registration (`_RegisterPlayer` function)
- Transaction recording (`_RecordToLedger` function)
- Admin and Spell modes (AdminRecord/SpellRecord functions)
- Clear functionality for form reset
- Status validation and error handling