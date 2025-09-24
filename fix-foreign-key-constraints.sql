-- Fix Foreign Key Constraints and Complete Database Cleanup
-- Execute these commands in your database to resolve the constraint issues

-- Step 1: Check current foreign key constraints
SELECT 
    CONSTRAINT_NAME,
    TABLE_NAME,
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
WHERE CONSTRAINT_SCHEMA = DATABASE() 
AND TABLE_NAME IN ('jotun_ledger', 'jotun_playerlist')
AND REFERENCED_TABLE_NAME IS NOT NULL;

-- Step 2: Drop the foreign key constraint that's preventing activePlayerName column removal
-- (Replace 'FK_CONSTRAINT_NAME' with the actual constraint name from Step 1)
-- Common constraint names might be like: jotun_ledger_ibfk_1, fk_ledger_player, etc.

-- If the constraint name is unknown, use this query to find it:
SELECT 
    CONSTRAINT_NAME 
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
WHERE TABLE_SCHEMA = DATABASE() 
AND TABLE_NAME = 'jotun_ledger' 
AND COLUMN_NAME = 'activePlayerName'
AND REFERENCED_TABLE_NAME IS NOT NULL;

-- Step 3: Drop the foreign key constraint (example - replace with actual name)
-- ALTER TABLE jotun_ledger DROP FOREIGN KEY your_constraint_name_here;

-- Step 4: Drop the index on activePlayerName if it exists
-- DROP INDEX activePlayerName ON jotun_ledger;

-- Step 5: Now we can safely drop the legacy columns
ALTER TABLE jotun_ledger DROP COLUMN IF EXISTS playerRename4;
ALTER TABLE jotun_ledger DROP COLUMN IF EXISTS playerRename3;
ALTER TABLE jotun_ledger DROP COLUMN IF EXISTS playerRename2;
ALTER TABLE jotun_ledger DROP COLUMN IF EXISTS playerRename1;

-- Step 6: Drop the activePlayerName column after removing its constraint
-- ALTER TABLE jotun_ledger DROP COLUMN activePlayerName;

-- Step 7: Keep playerName for now until we update all transaction recording code

-- Step 8: Verify the final structure
DESCRIBE jotun_ledger;

-- Step 9: Check that our player_id foreign key is still intact
SELECT 
    CONSTRAINT_NAME,
    TABLE_NAME,
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
WHERE CONSTRAINT_SCHEMA = DATABASE() 
AND TABLE_NAME = 'jotun_ledger'
AND COLUMN_NAME = 'player_id'
AND REFERENCED_TABLE_NAME IS NOT NULL;