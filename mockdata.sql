CREATE DATABASE IF NOT EXISTS pos_system;
USE pos_system;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    NAME VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    STATUS BOOLEAN NOT NULL DEFAULT TRUE
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    NAME VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    PASSWORD VARCHAR(255) NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_id VARCHAR(50) NOT NULL UNIQUE,
    customer_name VARCHAR(200) NOT NULL,
    cash DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    change_amount DECIMAL(10,2) NOT NULL,
    transaction_date DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE transaction_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_id VARCHAR(50) NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (transaction_id) REFERENCES transactions(transaction_id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Enable the event scheduler
SET GLOBAL event_scheduler = ON;

-- Create event to delete weekly transactions
CREATE EVENT IF NOT EXISTS delete_weekly_transaction
ON SCHEDULE EVERY 1 HOUR 
DO
DELETE FROM transactions
WHERE transaction_date < NOW() - INTERVAL 7 DAY;

-- ============================================
-- MOCK DATA FOR TESTING
-- ============================================

-- Insert mock products
INSERT INTO products (NAME, category, price, stock, STATUS) VALUES
('Bread', 'Bakery', 25.00, 50, TRUE),
('Milk', 'Dairy', 65.00, 30, TRUE),
('Eggs (1 tray)', 'Dairy', 120.00, 25, TRUE),
('Rice (5kg)', 'Grocery', 250.00, 40, TRUE),
('Chicken (1kg)', 'Meat', 180.00, 20, TRUE),
('Pork (1kg)', 'Meat', 220.00, 15, TRUE),
('Coca Cola (1.5L)', 'Beverages', 70.00, 45, TRUE),
('San Miguel Beer', 'Beverages', 85.00, 60, TRUE),
('Chips', 'Snacks', 35.00, 100, TRUE),
('Cookies', 'Snacks', 45.00, 80, TRUE),
('Toothpaste', 'Personal Care', 55.00, 35, TRUE),
('Shampoo', 'Personal Care', 120.00, 28, TRUE),
('Dish Soap', 'Household', 40.00, 42, TRUE),
('Laundry Detergent', 'Household', 150.00, 22, TRUE),
('Bananas (kg)', 'Fruits', 50.00, 55, TRUE),
('Apples (kg)', 'Fruits', 120.00, 32, TRUE),
('Coffee', 'Beverages', 90.00, 38, TRUE),
('Sugar (1kg)', 'Grocery', 65.00, 48, TRUE),
('Cooking Oil (1L)', 'Grocery', 95.00, 30, TRUE),
('Sardines', 'Canned Goods', 25.00, 85, TRUE);

-- Insert mock users (passwords are hashed versions of 'password123' for testing)
INSERT INTO users (NAME, email, PASSWORD, registration_date) VALUES
('John Doe', 'john.doe@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-01-15 10:30:00'),
('Jane Smith', 'jane.smith@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-01-20 14:45:00'),
('Maria Santos', 'maria.santos@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-02-01 09:15:00'),
('Carlos Reyes', 'carlos.reyes@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-02-10 16:20:00');

-- Insert mock transactions (last 30 days)
INSERT INTO transactions (transaction_id, customer_name, cash, total, change_amount, transaction_date) VALUES
('TRX-2026-001', 'Juan Dela Cruz', 1000.00, 785.00, 215.00, DATE_SUB(NOW(), INTERVAL 25 DAY)),
('TRX-2026-002', 'Maria Reyes', 500.00, 450.00, 50.00, DATE_SUB(NOW(), INTERVAL 24 DAY)),
('TRX-2026-003', 'Pedro Santos', 2000.00, 1890.00, 110.00, DATE_SUB(NOW(), INTERVAL 23 DAY)),
('TRX-2026-004', 'Ana Lopez', 300.00, 275.00, 25.00, DATE_SUB(NOW(), INTERVAL 22 DAY)),
('TRX-2026-005', 'Ramon Garcia', 1500.00, 1340.00, 160.00, DATE_SUB(NOW(), INTERVAL 21 DAY)),
('TRX-2026-006', 'Luz Fernandez', 800.00, 720.00, 80.00, DATE_SUB(NOW(), INTERVAL 20 DAY)),
('TRX-2026-007', 'Miguel Rodriguez', 1200.00, 1150.00, 50.00, DATE_SUB(NOW(), INTERVAL 19 DAY)),
('TRX-2026-008', 'Elena Cruz', 400.00, 380.00, 20.00, DATE_SUB(NOW(), INTERVAL 18 DAY)),
('TRX-2026-009', 'Francisco Gomez', 2500.00, 2230.00, 270.00, DATE_SUB(NOW(), INTERVAL 17 DAY)),
('TRX-2026-010', 'Isabella Torres', 600.00, 565.00, 35.00, DATE_SUB(NOW(), INTERVAL 16 DAY)),
('TRX-2026-011', 'Andres Bonifacio', 1800.00, 1690.00, 110.00, DATE_SUB(NOW(), INTERVAL 15 DAY)),
('TRX-2026-012', 'Gabriela Silang', 900.00, 845.00, 55.00, DATE_SUB(NOW(), INTERVAL 14 DAY)),
('TRX-2026-013', 'Jose Rizal', 3500.00, 3120.00, 380.00, DATE_SUB(NOW(), INTERVAL 13 DAY)),
('TRX-2026-014', 'Emilio Aguinaldo', 750.00, 695.00, 55.00, DATE_SUB(NOW(), INTERVAL 12 DAY)),
('TRX-2026-015', 'Apolinario Mabini', 1100.00, 1020.00, 80.00, DATE_SUB(NOW(), INTERVAL 11 DAY)),
('TRX-2026-016', 'Melchora Aquino', 450.00, 420.00, 30.00, DATE_SUB(NOW(), INTERVAL 10 DAY)),
('TRX-2026-017', 'Antonio Luna', 2800.00, 2650.00, 150.00, DATE_SUB(NOW(), INTERVAL 9 DAY)),
('TRX-2026-018', 'Gregorio Del Pilar', 950.00, 890.00, 60.00, DATE_SUB(NOW(), INTERVAL 8 DAY)),
('TRX-2026-019', 'Manuel Quezon', 2200.00, 2080.00, 120.00, DATE_SUB(NOW(), INTERVAL 7 DAY)),
('TRX-2026-020', 'Sergio Osmena', 1300.00, 1240.00, 60.00, DATE_SUB(NOW(), INTERVAL 6 DAY));

-- Insert mock transaction items
-- Transaction 1 items
INSERT INTO transaction_items (transaction_id, product_id, quantity, price, total) VALUES
('TRX-2026-001', 1, 2, 25.00, 50.00),
('TRX-2026-001', 4, 1, 250.00, 250.00),
('TRX-2026-001', 5, 1, 180.00, 180.00),
('TRX-2026-001', 7, 2, 70.00, 140.00),
('TRX-2026-001', 9, 3, 35.00, 105.00);

-- Transaction 2 items
INSERT INTO transaction_items (transaction_id, product_id, quantity, price, total) VALUES
('TRX-2026-002', 2, 2, 65.00, 130.00),
('TRX-2026-002', 3, 1, 120.00, 120.00),
('TRX-2026-002', 10, 4, 45.00, 180.00);

-- Transaction 3 items
INSERT INTO transaction_items (transaction_id, product_id, quantity, price, total) VALUES
('TRX-2026-003', 4, 3, 250.00, 750.00),
('TRX-2026-003', 6, 2, 220.00, 440.00),
('TRX-2026-003', 8, 5, 85.00, 425.00),
('TRX-2026-003', 19, 2, 95.00, 190.00);

-- Transaction 4 items
INSERT INTO transaction_items (transaction_id, product_id, quantity, price, total) VALUES
('TRX-2026-004', 11, 2, 55.00, 110.00),
('TRX-2026-004', 12, 1, 120.00, 120.00),
('TRX-2026-004', 13, 1, 40.00, 40.00);

-- Transaction 5 items
INSERT INTO transaction_items (transaction_id, product_id, quantity, price, total) VALUES
('TRX-2026-005', 1, 5, 25.00, 125.00),
('TRX-2026-005', 2, 3, 65.00, 195.00),
('TRX-2026-005', 14, 2, 150.00, 300.00),
('TRX-2026-005', 16, 4, 120.00, 480.00),
('TRX-2026-005', 18, 2, 65.00, 130.00);

-- Transaction 6 items
INSERT INTO transaction_items (transaction_id, product_id, quantity, price, total) VALUES
('TRX-2026-006', 3, 2, 120.00, 240.00),
('TRX-2026-006', 5, 1, 180.00, 180.00),
('TRX-2026-006', 17, 3, 90.00, 270.00);

-- Transaction 7 items
INSERT INTO transaction_items (transaction_id, product_id, quantity, price, total) VALUES
('TRX-2026-007', 7, 4, 70.00, 280.00),
('TRX-2026-007', 8, 3, 85.00, 255.00),
('TRX-2026-007', 9, 5, 35.00, 175.00),
('TRX-2026-007', 20, 6, 25.00, 150.00);

-- Transaction 8 items
INSERT INTO transaction_items (transaction_id, product_id, quantity, price, total) VALUES
('TRX-2026-008', 15, 3, 50.00, 150.00),
('TRX-2026-008', 16, 2, 120.00, 240.00);

-- Transaction 9 items
INSERT INTO transaction_items (transaction_id, product_id, quantity, price, total) VALUES
('TRX-2026-009', 4, 3, 250.00, 750.00),
('TRX-2026-009', 6, 2, 220.00, 440.00),
('TRX-2026-009', 8, 4, 85.00, 340.00),
('TRX-2026-009', 14, 2, 150.00, 300.00),
('TRX-2026-009', 19, 4, 95.00, 380.00);

-- Transaction 10 items
INSERT INTO transaction_items (transaction_id, product_id, quantity, price, total) VALUES
('TRX-2026-010', 1, 3, 25.00, 75.00),
('TRX-2026-010', 2, 2, 65.00, 130.00),
('TRX-2026-010', 10, 8, 45.00, 360.00);

-- Add more transaction items for recent transactions
INSERT INTO transaction_items (transaction_id, product_id, quantity, price, total) VALUES
('TRX-2026-011', 5, 2, 180.00, 360.00),
('TRX-2026-011', 6, 1, 220.00, 220.00),
('TRX-2026-011', 17, 4, 90.00, 360.00),
('TRX-2026-012', 3, 1, 120.00, 120.00),
('TRX-2026-012', 4, 1, 250.00, 250.00),
('TRX-2026-012', 7, 3, 70.00, 210.00),
('TRX-2026-013', 11, 3, 55.00, 165.00),
('TRX-2026-013', 12, 2, 120.00, 240.00),
('TRX-2026-013', 13, 5, 40.00, 200.00),
('TRX-2026-014', 1, 4, 25.00, 100.00),
('TRX-2026-014', 9, 6, 35.00, 210.00),
('TRX-2026-015', 2, 2, 65.00, 130.00),
('TRX-2026-015', 18, 3, 65.00, 195.00),
('TRX-2026-016', 15, 4, 50.00, 200.00),
('TRX-2026-016', 20, 8, 25.00, 200.00),
('TRX-2026-017', 4, 2, 250.00, 500.00),
('TRX-2026-017', 8, 5, 85.00, 425.00),
('TRX-2026-017', 14, 1, 150.00, 150.00),
('TRX-2026-018', 5, 1, 180.00, 180.00),
('TRX-2026-018', 6, 1, 220.00, 220.00),
('TRX-2026-018', 19, 2, 95.00, 190.00),
('TRX-2026-019', 7, 3, 70.00, 210.00),
('TRX-2026-019', 10, 5, 45.00, 225.00),
('TRX-2026-019', 16, 2, 120.00, 240.00),
('TRX-2026-020', 1, 2, 25.00, 50.00),
('TRX-2026-020', 3, 1, 120.00, 120.00),
('TRX-2026-020', 17, 4, 90.00, 360.00),
('TRX-2026-020', 20, 3, 25.00, 75.00);

-- Optional: Add some future transactions to test the auto-delete feature (will be deleted after 7 days)
INSERT INTO transactions (transaction_id, customer_name, cash, total, change_amount, transaction_date) VALUES
('TRX-TEST-001', 'Test Customer Old', 500.00, 450.00, 50.00, DATE_SUB(NOW(), INTERVAL 10 DAY)),
('TRX-TEST-002', 'Another Old Customer', 300.00, 280.00, 20.00, DATE_SUB(NOW(), INTERVAL 9 DAY));

INSERT INTO transaction_items (transaction_id, product_id, quantity, price, total) VALUES
('TRX-TEST-001', 2, 2, 65.00, 130.00),
('TRX-TEST-001', 9, 4, 35.00, 140.00),
('TRX-TEST-002', 1, 3, 25.00, 75.00),
('TRX-TEST-002', 11, 1, 55.00, 55.00);

-- Query to verify data was inserted
SELECT 'Products Count:' AS Info, COUNT(*) AS COUNT FROM products
UNION ALL
SELECT 'Users Count:', COUNT(*) FROM users
UNION ALL
SELECT 'Transactions Count:', COUNT(*) FROM transactions
UNION ALL
SELECT 'Transaction Items Count:', COUNT(*) FROM transaction_items;