CREATE DATABASE IF NOT EXISTS wishlist
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE wishlist;

CREATE TABLE groups (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uid INT NOT NULL,
    name VARCHAR(255) NOT NULL,

    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_uid (uid),
    UNIQUE KEY uniq_user_group (uid, name),

);

CREATE TABLE items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uid INT NOT NULL,
    group_id INT NULL,

    name VARCHAR(255) NOT NULL,
    link VARCHAR(512) DEFAULT NULL,
    price DECIMAL(10,2) NOT NULL,
    weight INT NOT NULL DEFAULT 1,
    bought BOOLEAN NOT NULL DEFAULT FALSE,
    archived BOOLEAN NOT NULL DEFAULT FALSE,

    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_uid (uid),
    INDEX idx_group_id (group_id),
    INDEX idx_bought (bought),
    INDEX idx_archived (archived),

    CONSTRAINT fk_items_group
        FOREIGN KEY (group_id) REFERENCES groups(id)
        ON DELETE SET NULL
);

CREATE TABLE ledger (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uid INT NOT NULL,

    amount DECIMAL(10,2) NOT NULL,

    description VARCHAR(255) DEFAULT NULL,

    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_uid (uid),
    INDEX idx_created_at (created_at),

);