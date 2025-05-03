-- Drop database if exists
DROP DATABASE IF EXISTS sqli_vulnerable;

-- Create database
CREATE DATABASE sqli_vulnerable;

-- Use the database
USE sqli_vulnerable;

-- Users table for login vulnerabilities
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    email VARCHAR(100),
    is_admin BOOLEAN DEFAULT FALSE
);

-- Products table for string-based injection
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2),
    category VARCHAR(50)
);

-- Customers table for numeric injection
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    credit_card VARCHAR(100),
    address TEXT
);

-- Secret data for advanced exploitation
CREATE TABLE secrets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    secret_key VARCHAR(100) NOT NULL,
    secret_value TEXT
);

-- Insert sample data
INSERT INTO users (username, password, email, is_admin) VALUES 
('admin', 'admin123', 'admin@example.com', TRUE),
('john', 'password123', 'john@example.com', FALSE),
('jane', 'jane123', 'jane@example.com', FALSE),
('test', 'test123', 'test@example.com', FALSE);

INSERT INTO products (name, description, price, category) VALUES 
('Laptop', 'High-performance laptop', 999.99, 'Electronics'),
('Smartphone', 'Latest smartphone model', 499.99, 'Electronics'),
('Headphones', 'Noise-cancelling headphones', 199.99, 'Accessories'),
('Keyboard', 'Mechanical gaming keyboard', 129.99, 'Accessories'),
('Monitor', '27-inch 4K monitor', 349.99, 'Electronics');

INSERT INTO customers (name, email, credit_card, address) VALUES 
('John Doe', 'john.doe@example.com', '1234-5678-9012-3456', '123 Main St, Anytown'),
('Jane Smith', 'jane.smith@example.com', '2345-6789-0123-4567', '456 Oak Ave, Othertown'),
('Bob Johnson', 'bob.johnson@example.com', '3456-7890-1234-5678', '789 Pine St, Sometown'),
('Alice Brown', 'alice.brown@example.com', '4567-8901-2345-6789', '321 Elm St, Anytown');

INSERT INTO secrets (secret_key, secret_value) VALUES 
('api_key', 'sk_live_51NqbGTHK9e7xCV54zXgDmuXMfD5jPAQecnUlTG'),
('admin_password', 'supersecretpassword123'),
('database_credentials', 'user:password@host/database'),
('encryption_key', 'AES256-CBC-12345-SECRET-KEY'); 