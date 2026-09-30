-- ============================================================================
-- Experiment 19: Customer Database Schema
-- Course: Advanced Web Technology (CSIT248) - Sem III / VI
-- Amity University Noida
-- ============================================================================

-- 1. Create Database
CREATE DATABASE IF NOT EXISTS customer_db;
USE customer_db;

-- 2. Create CUSTOMER Table
CREATE TABLE IF NOT EXISTS customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(60) NOT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Insert Initial Sample Records
INSERT INTO customers (customer_name, email, phone, address, city) VALUES
('Atul Anand', 'atul.anand@example.com', '+91 98765 43210', 'Sector 125, Express Highway', 'Noida'),
('Priya Sharma', 'priya.sharma@example.com', '+91 98123 45678', 'Connaught Place, Central Delhi', 'New Delhi'),
('Rohan Verma', 'rohan.verma@example.com', '+91 97234 56789', 'Boring Road, Near Canal', 'Patna'),
('Ananya Sengupta', 'ananya.s@example.com', '+91 96345 67890', 'Park Street, South Block', 'Kolkata');
