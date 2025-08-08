# POS System Testing Guide

## Manual Testing Checklist

### Prerequisites
1. WordPress admin access with `edit_posts` capability
2. Plugin activated and POS system accessible at: WordPress Admin → Jotunheim Magic Plugin → Point of Sale

### Test Cases

#### 1. Basic Interface Loading
- [ ] Navigate to Point of Sale page
- [ ] Verify both tabs (Admin Transactions, Spell Transactions) are visible
- [ ] Verify tab switching works
- [ ] Verify initial form fields are present

#### 2. Player Registration (Admin Tab)
- [ ] Enter a new player name
- [ ] Click "Register Player"
- [ ] Verify success message appears
- [ ] Try registering the same player again
- [ ] Verify error message for duplicate player

#### 3. Player Validation
- [ ] Enter an existing player name
- [ ] Click "Validate Player"
- [ ] Verify "Player found" message
- [ ] Enter a non-existent player name
- [ ] Verify "Player not found" message

#### 4. Admin Transaction Recording
- [ ] Validate an existing player
- [ ] Add multiple items with quantities and amounts
- [ ] Test "No Buys" checkbox
- [ ] Test "No Claims" checkbox
- [ ] Click "Record Transaction"
- [ ] Verify success message and form clear

#### 5. Spell Transaction Recording (Spell Tab)
- [ ] Switch to Spell Transactions tab
- [ ] Validate an existing player
- [ ] Add multiple spells with quantities and mana costs
- [ ] Click "Record Transaction"
- [ ] Verify success message and form clear

#### 6. Error Handling
- [ ] Try recording transaction without player name
- [ ] Try recording transaction without items
- [ ] Try recording transaction with invalid player
- [ ] Verify appropriate error messages appear

### Database Verification

After successful transactions, check the database:

```sql
-- Check jotun_ledger for new players
SELECT * FROM jotun_ledger WHERE playerName = 'TEST_PLAYER';

-- Check jotun_transactions for recorded transactions
SELECT * FROM jotun_transactions WHERE customer_name = 'TEST_PLAYER' ORDER BY transaction_date DESC;

-- Check transaction types (if column exists)
SELECT shop_name, transaction_type, COUNT(*) as count 
FROM jotun_transactions 
WHERE shop_name IN ('POS_Admin', 'POS_Spell') 
GROUP BY shop_name, transaction_type;
```

### API Endpoint Testing (Optional)

Using a tool like Postman or curl, test direct API calls:

```bash
# Player Registration
curl -X POST "http://your-site/wp-json/pos/v1/register-player" \
  -H "Content-Type: application/json" \
  -H "X-WP-Nonce: YOUR_NONCE" \
  -d '{"playerName": "TestPlayer"}'

# Player Validation
curl -X POST "http://your-site/wp-json/pos/v1/validate-player" \
  -H "Content-Type: application/json" \
  -H "X-WP-Nonce: YOUR_NONCE" \
  -d '{"playerName": "TestPlayer"}'
```

### Expected Results
- All operations should complete without PHP errors
- Success/error messages should be appropriate and user-friendly
- Database entries should be created correctly
- Transaction type column should be handled gracefully (whether it exists or not)
- UI should be responsive and intuitive