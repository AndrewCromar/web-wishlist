USE astartup_wishlist;

CREATE TABLE IF NOT EXISTS ledger (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uid INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    description VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_uid (uid),
    INDEX idx_created_at (created_at),

    CONSTRAINT fk_ledger_account
        FOREIGN KEY (uid) REFERENCES accounts(uid)
        ON DELETE CASCADE
);

ALTER TABLE items
    ADD COLUMN weight INT NOT NULL DEFAULT 1 AFTER price,
    DROP COLUMN money_saved;