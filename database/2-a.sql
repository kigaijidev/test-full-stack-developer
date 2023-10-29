-- Tạo cơ sở dữ liệu
CREATE DATABASE ecommerce_db;

-- Sử dụng cơ sở dữ liệu
USE ecommerce_db;

-- Tạo bảng Products
CREATE TABLE Products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    product_description TEXT,
    product_price DECIMAL(10, 2),
    maker_id INT,
    FOREIGN KEY (maker_id) REFERENCES Makers(maker_id)
);

-- Tạo bảng Makers
CREATE TABLE Makers (
    maker_id INT AUTO_INCREMENT PRIMARY KEY,
    maker_name VARCHAR(255) NOT NULL
);

-- Tạo bảng Customers
CREATE TABLE Customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255) NOT NULL,
    customer_address TEXT
);

-- Tạo bảng Orders
CREATE TABLE Orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    order_date DATE,
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id)
);

-- Tạo bảng OrderDetails
CREATE TABLE OrderDetails (
    order_detail_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT,
    total_price DECIMAL(10, 2),
    FOREIGN KEY (order_id) REFERENCES Orders(order_id),
    FOREIGN KEY (product_id) REFERENCES Products(product_id)
);
