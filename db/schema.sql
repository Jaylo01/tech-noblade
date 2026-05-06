-- Database Schema for Tech Noblade & Top Up
-- Recommended database name: tech_noblade_db

CREATE DATABASE IF NOT EXISTS tech_noblade_db;
USE tech_noblade_db;

-- ------------------------------------------------------------
-- Users (Customers and Administrative accounts)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    full_name     VARCHAR(100) NOT NULL,
    email         VARCHAR(150) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role          ENUM('customer', 'admin') DEFAULT 'customer',
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ------------------------------------------------------------
-- Orders (Product purchases and top-ups)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS orders (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    order_id     VARCHAR(50) UNIQUE NOT NULL,
    game         VARCHAR(100) NOT NULL,
    item         VARCHAR(100) NOT NULL,
    price        DECIMAL(10, 2) NOT NULL,
    qty          INT NOT NULL,
    total        DECIMAL(10, 2) NOT NULL,
    method       VARCHAR(50) NOT NULL,
    userid       VARCHAR(100),
    zoneid       VARCHAR(50),
    payment_ref  VARCHAR(255),
    customer_id  INT NULL,
    status       VARCHAR(50) DEFAULT 'Processing',
    timestamp    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_orders_user FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE SET NULL
);

-- ------------------------------------------------------------
-- Products & Categories (Inventory management)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS products (
    id     INT AUTO_INCREMENT PRIMARY KEY,
    name   VARCHAR(100) UNIQUE NOT NULL,
    status ENUM('Active', 'Inactive') DEFAULT 'Active'
);

CREATE TABLE IF NOT EXISTS product_skus (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    game      VARCHAR(100) NOT NULL,
    item_name VARCHAR(100) NOT NULL,
    price     DECIMAL(10, 2) NOT NULL,
    stock     INT DEFAULT 20,
    FOREIGN KEY (game) REFERENCES products(name) ON DELETE CASCADE
);

-- ------------------------------------------------------------
-- Service Requests (Technical Repair Hub)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS service_requests (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    reference_id     VARCHAR(50) UNIQUE NOT NULL,
    customer_name    VARCHAR(100) NOT NULL,
    contact          VARCHAR(100) NOT NULL,
    device           VARCHAR(100) NOT NULL,
    issue            TEXT NOT NULL,
    shipping         VARCHAR(50),
    customer_id      INT NULL,
    status           VARCHAR(50) DEFAULT 'Pending',
    pickup_address   TEXT,
    schedule_date    DATE,
    schedule_time    TIME,
    notes            TEXT,
    diagnostic_quote DECIMAL(10, 2),
    quote_status     ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_sr_user FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE SET NULL
);

-- ------------------------------------------------------------
-- Default Data
-- ------------------------------------------------------------
INSERT IGNORE INTO products (name) VALUES 
('Mobile Legends'),
('Roblox (Robux)'),
('Call of Duty: Mobile'),
('Honor of Kings'),
('Valorant'),
('League of Legends');
