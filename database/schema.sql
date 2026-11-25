-- ============================================================
-- FindIT: Web-Based Lost and Found Management System
-- Database Schema (MySQL / MariaDB)
-- ============================================================

CREATE DATABASE IF NOT EXISTS findit_db
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE findit_db;

-- ------------------------------------------------------------
-- Users (Registration & Login, roles: user / admin)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    user_id        INT AUTO_INCREMENT PRIMARY KEY,
    full_name      VARCHAR(120)  NOT NULL,
    email          VARCHAR(150)  NOT NULL UNIQUE,
    password_hash  VARCHAR(255)  NOT NULL,
    phone          VARCHAR(30)   DEFAULT NULL,
    role           ENUM('user','admin') NOT NULL DEFAULT 'user',
    status         ENUM('active','disabled') NOT NULL DEFAULT 'active',
    created_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Structured Item Categorization
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS categories (
    category_id    INT AUTO_INCREMENT PRIMARY KEY,
    name           VARCHAR(80) NOT NULL UNIQUE
) ENGINE=InnoDB;

INSERT INTO categories (name) VALUES
    ('Electronics'), ('Documents / ID Cards'), ('Bags & Wallets'),
    ('Jewelry & Accessories'), ('Clothing'), ('Keys'),
    ('Books & Stationery'), ('Others')
ON DUPLICATE KEY UPDATE name = VALUES(name);

-- ------------------------------------------------------------
-- Item Reporting (Lost / Found) with structured details
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS items (
    item_id        INT AUTO_INCREMENT PRIMARY KEY,
    user_id        INT NOT NULL,
    category_id    INT NOT NULL,
    item_type      ENUM('lost','found') NOT NULL,
    title          VARCHAR(150) NOT NULL,
    description    TEXT,
    location        VARCHAR(150) NOT NULL,
    item_date      DATE NOT NULL,
    item_time      TIME DEFAULT NULL,
    photo_path     VARCHAR(255) DEFAULT NULL,
    status         ENUM('open','matched','claimed','closed') NOT NULL DEFAULT 'open',
    created_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Claim Request Submission & Verification
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS claims (
    claim_id       INT AUTO_INCREMENT PRIMARY KEY,
    item_id        INT NOT NULL,          -- the FOUND item being claimed
    claimant_id    INT NOT NULL,          -- the user claiming it
    proof_details  TEXT NOT NULL,         -- description proving ownership
    match_score    DECIMAL(5,2) DEFAULT NULL,
    status         ENUM('pending','verified','rejected','approved') NOT NULL DEFAULT 'pending',
    admin_notes    TEXT,
    created_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    reviewed_at    DATETIME DEFAULT NULL,
    FOREIGN KEY (item_id) REFERENCES items(item_id) ON DELETE CASCADE,
    FOREIGN KEY (claimant_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Notification System for Possible Matches / Claim Updates
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS notifications (
    notification_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id          INT NOT NULL,
    message          VARCHAR(255) NOT NULL,
    link             VARCHAR(255) DEFAULT NULL,
    is_read          TINYINT(1) NOT NULL DEFAULT 0,
    created_at       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Matching Score Mechanism weight configuration (Admin editable)
-- Location 40% | Date & Time 30% | Category 30%  (per use case diagram)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS match_settings (
    setting_id       INT AUTO_INCREMENT PRIMARY KEY,
    location_weight  INT NOT NULL DEFAULT 40,
    datetime_weight  INT NOT NULL DEFAULT 30,
    category_weight  INT NOT NULL DEFAULT 30
) ENGINE=InnoDB;

INSERT INTO match_settings (location_weight, datetime_weight, category_weight)
SELECT 40, 30, 30 WHERE NOT EXISTS (SELECT 1 FROM match_settings);

-- ------------------------------------------------------------
-- Default admin account (password: Admin@123 - change after first login)
-- ------------------------------------------------------------
INSERT INTO users (full_name, email, password_hash, role)
SELECT 'System Administrator', 'admin@findit.local',
       '$2b$10$rEX0ZgP0.zYit59sbln3w.OEovR6ELeduvMMdRTfy3doxq7lBDWxK', 'admin'
WHERE NOT EXISTS (SELECT 1 FROM users WHERE email = 'admin@findit.local');
