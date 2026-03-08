USE wishlist;

-- Remove foreign keys referencing accounts
ALTER TABLE groups DROP FOREIGN KEY fk_groups_account;
ALTER TABLE items DROP FOREIGN KEY fk_items_account;
ALTER TABLE ledger DROP FOREIGN KEY fk_ledger_account;

-- Drop auth tables
DROP TABLE IF EXISTS codes;
DROP TABLE IF EXISTS accounts;
