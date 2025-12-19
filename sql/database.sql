CREATE DATABASE bankly_v2;
USE bankly_v2;

CREATE TABLE clients (
         client_id INT AUTO_INCREMENT PRIMARY KEY,
         full_name VARCHAR(100) NOT NULL,
         email VARCHAR(100) NOT NULL UNIQUE,
         phone VARCHAR(20) NOT NULL,
         cin VARCHAR(20) NOT NULL UNIQUE,
         registration_date DATETIME DEFAULT CURRENT_TIMESTAMP
     );

CREATE TABLE comptes (
    account_id INT AUTO_INCREMENT PRIMARY KEY,
    account_number VARCHAR(50) NOT NULL UNIQUE,
    balance DECIMAL(10,2) DEFAULT 0,
    account_type ENUM('Checking','Savings','Business') NOT NULL,
    account_status ENUM('Active','Closed') DEFAULT 'Active',
    client_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(client_id)
);

CREATE TABLE transactions (
    transaction_id INT AUTO_INCREMENT PRIMARY KEY,
    account_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    transaction_type ENUM('debit','credit') NOT NULL,
    transaction_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (account_id) REFERENCES comptes(account_id)
);

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','agent') DEFAULT 'agent',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (full_name,email,password,role)
VALUES (
'Admin Bankly',
'admin@bankly.com',
'admin123',
'admin'
);
