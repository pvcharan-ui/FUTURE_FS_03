-- sql/products.sql
CREATE DATABASE IF NOT EXISTS future_fs_03 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE future_fs_03;

-- products table
CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sku VARCHAR(64) NOT NULL UNIQUE,
  title VARCHAR(200) NOT NULL,
  description TEXT NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  image VARCHAR(255) DEFAULT NULL,
  stock INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- sample products (make sure corresponding images exist in public/assets/products/)
INSERT INTO products (sku, title, description, price, image, stock) VALUES
('NIKE-001', 'AirSprint Trainer', 'Lightweight trainer designed for speed and comfort. Excellent cushioning and breathable mesh upper.', 4999.00, 'prod1.jpg', 12),
('NIKE-002', 'MotionRun Shoe', 'High-performance running shoe with responsive midsole and secure fit.', 5999.00, 'prod2.jpg', 8),
('NIKE-003', 'SportFlex Hoodie', 'Comfortable hoodie for warmups and casual wear, made with moisture-wicking fabric.', 1999.00, 'prod3.jpg', 20);
