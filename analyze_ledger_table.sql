-- First, let's see the current structure of the jotun_ledger table
DESCRIBE jotun_ledger;

-- Show all columns to identify what needs to be removed
SHOW COLUMNS FROM jotun_ledger;

-- Commands to remove the unwanted playerRename columns
-- WARNING: These will permanently delete the columns and their data!

ALTER TABLE jotun_ledger DROP COLUMN IF EXISTS playerRename4;
ALTER TABLE jotun_ledger DROP COLUMN IF EXISTS playerRename3;
ALTER TABLE jotun_ledger DROP COLUMN IF EXISTS playerRename2;
ALTER TABLE jotun_ledger DROP COLUMN IF EXISTS playerRename1;

-- Analysis of linking strategy:
-- Current situation: ledger has both playerName and activePlayerName
-- Recommended approach: Add a foreign key to link to jotun_playerlist.id

-- Option 1: Add a player_id foreign key column (RECOMMENDED)
-- This creates a proper relational link to jotun_playerlist table
ALTER TABLE jotun_ledger ADD COLUMN player_id INT(11) DEFAULT NULL COMMENT 'Foreign key to jotun_playerlist.id';

-- Add foreign key constraint (optional but recommended for data integrity)
ALTER TABLE jotun_ledger ADD CONSTRAINT fk_ledger_player 
FOREIGN KEY (player_id) REFERENCES jotun_playerlist(id) 
ON DELETE SET NULL ON UPDATE CASCADE;

-- Add index for better performance
ALTER TABLE jotun_ledger ADD INDEX idx_player_id (player_id);

-- Option 2: If you prefer to keep activePlayerName as the link field
-- You could remove playerName and keep only activePlayerName
-- ALTER TABLE jotun_ledger DROP COLUMN playerName;

-- View the final structure
DESCRIBE jotun_ledger;
