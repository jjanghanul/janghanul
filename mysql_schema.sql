CREATE DATABASE IF NOT EXISTS janghanul
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_0900_ai_ci;

CREATE USER IF NOT EXISTS 'janghanul_user'@'localhost' IDENTIFIED BY 'janghanul_password';
CREATE USER IF NOT EXISTS 'janghanul_user'@'127.0.0.1' IDENTIFIED BY 'janghanul_password';
GRANT ALL PRIVILEGES ON janghanul.* TO 'janghanul_user'@'localhost';
GRANT ALL PRIVILEGES ON janghanul.* TO 'janghanul_user'@'127.0.0.1';
FLUSH PRIVILEGES;

USE janghanul;

CREATE TABLE IF NOT EXISTS users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
