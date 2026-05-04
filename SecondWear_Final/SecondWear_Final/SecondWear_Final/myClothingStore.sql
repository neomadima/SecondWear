-- ============================================================
-- myClothingStore.sql
-- ClothingStore Database — Full DDL + Data
-- Import this into phpMyAdmin
-- Generated for WEDE602 POE Part 2
-- ============================================================

CREATE DATABASE IF NOT EXISTS ClothingStore;
USE ClothingStore;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS tblAorder;
DROP TABLE IF EXISTS tblClothes;
DROP TABLE IF EXISTS tblUser;
DROP TABLE IF EXISTS tblAdmin;
SET FOREIGN_KEY_CHECKS = 1;

-- ══════════════════════════════════════════
-- tblUser (30 entries)
-- ══════════════════════════════════════════
CREATE TABLE tblUser (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    FullName VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Campus VARCHAR(100),
    Status ENUM('pending', 'verified') DEFAULT 'pending',
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- First 5 users (from userData.txt) with known passwords:
-- j.doe@abc.co.za = user1pass
-- sarah.j@campus.ac.za = user2pass
-- thabo.n@campus.ac.za = user3pass
-- emma.w@campus.ac.za = user4pass (PENDING - cannot login until admin verifies)
-- david.m@campus.ac.za = user5pass
INSERT INTO tblUser (FullName, Email, Password, Campus, Status) VALUES
('John Doe', 'j.doe@abc.co.za', '$2y$10$TmRbaVoXJefWV8XOnHEqie6NrbegQVv21aj1FbiPtHJ8rvSugjKNu', 'Pretoria Campus', 'verified'),
('Sarah Johnson', 'sarah.j@campus.ac.za', '$2y$10$HlWkL79U75rafnd9Uz3QeOeEqldnePrnZxhJu7onBeBMAX6XceMCG', 'Johannesburg Campus', 'verified'),
('Thabo Nkosi', 'thabo.n@campus.ac.za', '$2y$10$..WIlGkmHhh2zsAIcW1vbuH7n3LO0DE7kQ4VXa/Gq9oaseeJeING2', 'Pretoria Campus', 'verified'),
('Emma Williams', 'emma.w@campus.ac.za', '$2y$10$/Z1BYAVGvtqXe.Qustt8fuNEzvzXElBeizboDbEO6ZkHxfGo9W2Pu', 'Cape Town Campus', 'pending'),
('David Molefe', 'david.m@campus.ac.za', '$2y$10$I/mCU5zivxxmHOdS1EHb2uKsMbSAcLzkJtCf8dRIR2LWaGBhjbXoW', 'Durban Campus', 'verified'),
('Lerato Mokoena', 'lerato.m@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Pretoria Campus', 'verified'),
('James Smith', 'james.s@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Johannesburg Campus', 'verified'),
('Nomsa Dlamini', 'nomsa.d@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Cape Town Campus', 'verified'),
('Michael Brown', 'michael.b@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Durban Campus', 'pending'),
('Palesa Khumalo', 'palesa.k@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Pretoria Campus', 'verified'),
('Robert Taylor', 'robert.t@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Johannesburg Campus', 'verified'),
('Zanele Mthembu', 'zanele.m@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Cape Town Campus', 'verified'),
('William Harris', 'william.h@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Durban Campus', 'verified'),
('Mpho Sithole', 'mpho.s@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Pretoria Campus', 'pending'),
('Jessica Clark', 'jessica.c@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Johannesburg Campus', 'verified'),
('Sipho Ndlovu', 'sipho.n@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Cape Town Campus', 'verified'),
('Emily White', 'emily.w@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Durban Campus', 'verified'),
('Bongani Zulu', 'bongani.z@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Pretoria Campus', 'verified'),
('Amanda Green', 'amanda.g@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Johannesburg Campus', 'verified'),
('Tshepiso Mahlangu', 'tshepiso.m@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Cape Town Campus', 'pending'),
('Daniel King', 'daniel.k@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Durban Campus', 'verified'),
('Naledi Maseko', 'naledi.m@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Pretoria Campus', 'verified'),
('Chris Martin', 'chris.m@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Johannesburg Campus', 'verified'),
('Lindiwe Cele', 'lindiwe.c@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Cape Town Campus', 'verified'),
('Andrew Wilson', 'andrew.w@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Durban Campus', 'verified'),
('Kefilwe Motaung', 'kefilwe.m@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Pretoria Campus', 'pending'),
('Steven Adams', 'steven.a@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Johannesburg Campus', 'verified'),
('Precious Nxumalo', 'precious.n@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Cape Town Campus', 'verified'),
('Thomas Lee', 'thomas.l@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Durban Campus', 'verified'),
('Ayanda Ngcobo', 'ayanda.n@campus.ac.za', '$2y$10$4UOjAMFK5hBFcinzvSRzkO8kIGRGcFLirRpMWT7kd53OK8HecauNu', 'Pretoria Campus', 'verified');

-- ══════════════════════════════════════════
-- tblAdmin (5 entries)
-- Password for ALL admins: admin123
-- ══════════════════════════════════════════
CREATE TABLE tblAdmin (
    AdminID INT AUTO_INCREMENT PRIMARY KEY,
    FullName VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO tblAdmin (FullName, Email, Password) VALUES
('Admin User', 'admin@secondwear.co.za', '$2y$10$sHHg4kWP7WNyuE82epyideP8U8yVrH2vH4bF5Iy0XwQFVYEpWwtWW'),
('Jane Admin', 'jane.admin@secondwear.co.za', '$2y$10$sHHg4kWP7WNyuE82epyideP8U8yVrH2vH4bF5Iy0XwQFVYEpWwtWW'),
('Mike Manager', 'mike.mgr@secondwear.co.za', '$2y$10$sHHg4kWP7WNyuE82epyideP8U8yVrH2vH4bF5Iy0XwQFVYEpWwtWW'),
('Lisa Supervisor', 'lisa.sup@secondwear.co.za', '$2y$10$sHHg4kWP7WNyuE82epyideP8U8yVrH2vH4bF5Iy0XwQFVYEpWwtWW'),
('Neo Director', 'neomadima@gmail', '$2y$10$sHHg4kWP7WNyuE82epyideP8U8yVrH2vH4bF5Iy0XwQFVYEpWwtWW');

-- ══════════════════════════════════════════
-- tblClothes (30 entries)
-- ══════════════════════════════════════════
CREATE TABLE tblClothes (
    ClothesID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Description TEXT,
    Price DECIMAL(10,2) NOT NULL,
    Size VARCHAR(10),
    Category VARCHAR(50),
    Gender ENUM('men', 'women', 'unisex') DEFAULT 'unisex',
    Brand VARCHAR(50),
    ItemCondition VARCHAR(50),
    Campus VARCHAR(100),
    SellerID INT,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (SellerID) REFERENCES tblUser(UserID) ON DELETE SET NULL
);

INSERT INTO tblClothes (Name, Description, Price, Size, Category, Gender, Brand, ItemCondition, Campus, SellerID) VALUES
('Floral Summer Dress', 'Beautiful floral summer dress. Only worn once.', 210.00, 'M', 'Dresses', 'women', 'Zara', 'Like New', 'Johannesburg Campus', 2),
('Ripcurl T-Shirt', 'Ripcurl t-shirt. Perfect condition.', 100.00, '3XL', 'Tops', 'men', 'Rip Curl', 'Like New', 'Pretoria Campus', 1),
('Leather Moto Jacket', 'Genuine leather moto jacket.', 590.00, 'S', 'Jackets', 'women', 'Zara', 'Excellent', 'Cape Town Campus', 3),
('Classic Oxford Shirt', 'Premium cotton Oxford shirt.', 279.00, 'L', 'Shirts', 'men', 'Tommy Hilfiger', 'Like New', 'Pretoria Campus', 1),
('Oversized Knit Sweater', 'Cozy oversized knit sweater.', 180.00, 'L', 'Sweaters', 'women', 'H&M', 'Like New', 'Cape Town Campus', 5),
('Little Black Dress', 'Timeless classic little black dress.', 189.00, 'S', 'Dresses', 'women', 'H&M', 'Like New', 'Pretoria Campus', 6),
('Bohemian Maxi Dress', 'Flowing bohemian maxi dress.', 299.00, 'L', 'Dresses', 'women', 'Free People', 'Excellent', 'Cape Town Campus', 8),
('Denim Jeans', 'Classic straight-leg denim jeans.', 320.00, 'M', 'Pants', 'men', 'Levis', 'Good', 'Johannesburg Campus', 7),
('Crop Top', 'Trendy cropped summer top.', 89.00, 'S', 'Tops', 'women', 'Cotton On', 'Like New', 'Durban Campus', 10),
('Cargo Pants', 'High-rise cargo pants, olive green.', 245.00, 'M', 'Pants', 'women', 'Zara', 'Like New', 'Pretoria Campus', 3),
('Hoodie', 'Warm fleece-lined pullover hoodie.', 199.00, 'XL', 'Sweaters', 'men', 'Nike', 'Good', 'Johannesburg Campus', 11),
('Silk Blouse', 'Luxurious silk blouse, ivory.', 159.00, 'S', 'Tops', 'women', 'Zara', 'Excellent', 'Pretoria Campus', 12),
('Chino Shorts', 'Smart casual chino shorts.', 150.00, 'L', 'Pants', 'men', 'Woolworths', 'Like New', 'Cape Town Campus', 13),
('Wrap Midi Dress', 'Flattering wrap-style midi dress.', 245.00, 'M', 'Dresses', 'women', 'Zara', 'Very Good', 'Johannesburg Campus', 2),
('Bomber Jacket', 'Lightweight bomber jacket, olive.', 350.00, 'M', 'Jackets', 'men', 'Zara', 'Excellent', 'Pretoria Campus', 15),
('Athletic Leggings', 'High-waist compression leggings.', 199.00, 'S', 'Pants', 'women', 'Nike', 'Like New', 'Durban Campus', 16),
('Polo Shirt', 'Classic cotton polo shirt.', 129.00, 'L', 'Tops', 'men', 'Ralph Lauren', 'Good', 'Cape Town Campus', 17),
('Satin Slip Dress', 'Elegant satin slip dress.', 165.00, 'XS', 'Dresses', 'women', 'Forever New', 'Like New', 'Durban Campus', 18),
('Winter Coat', 'Long wool-blend winter coat.', 699.00, 'M', 'Jackets', 'women', 'Woolworths', 'Excellent', 'Pretoria Campus', 6),
('Running Shoes', 'Lightweight running sneakers.', 450.00, '10', 'Shoes', 'men', 'Adidas', 'Good', 'Johannesburg Campus', 7),
('Blazer', 'Structured tailored blazer.', 399.00, 'M', 'Jackets', 'women', 'Mango', 'Like New', 'Cape Town Campus', 8),
('Graphic Tee', 'Vintage band graphic t-shirt.', 79.00, 'L', 'Tops', 'men', 'Factorie', 'Good', 'Durban Campus', 5),
('Pleated Skirt', 'Midi-length pleated skirt.', 175.00, 'M', 'Skirts', 'women', 'H&M', 'Like New', 'Pretoria Campus', 10),
('Swim Shorts', 'Quick-dry swim shorts.', 120.00, 'M', 'Pants', 'men', 'Billabong', 'Excellent', 'Cape Town Campus', 11),
('Knit Cardigan', 'Oversized knit button-up cardigan.', 220.00, 'L', 'Sweaters', 'women', 'Zara', 'Like New', 'Johannesburg Campus', 12),
('Formal Trousers', 'Slim-fit formal trousers, black.', 289.00, 'M', 'Pants', 'men', 'Woolworths', 'Like New', 'Pretoria Campus', 13),
('Sundress', 'Cotton sundress with pockets.', 145.00, 'S', 'Dresses', 'women', 'Cotton On', 'Like New', 'Durban Campus', 16),
('Track Pants', 'Comfortable jogging track pants.', 169.00, 'L', 'Pants', 'men', 'Puma', 'Good', 'Johannesburg Campus', 15),
('Linen Shirt', 'Breathable linen summer shirt.', 199.00, 'M', 'Shirts', 'men', 'H&M', 'Excellent', 'Cape Town Campus', 17),
('Maxi Skirt', 'Flowing printed maxi skirt.', 185.00, 'M', 'Skirts', 'women', 'Forever New', 'Like New', 'Pretoria Campus', 18);

-- ══════════════════════════════════════════
-- tblAorder (30 entries)
-- ══════════════════════════════════════════
CREATE TABLE tblAorder (
    OrderID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    ClothesID INT,
    Quantity INT NOT NULL DEFAULT 1,
    TotalPrice DECIMAL(10,2) NOT NULL,
    OrderDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    Status VARCHAR(50) DEFAULT 'Pending',
    FOREIGN KEY (UserID) REFERENCES tblUser(UserID) ON DELETE SET NULL,
    FOREIGN KEY (ClothesID) REFERENCES tblClothes(ClothesID) ON DELETE SET NULL
);

INSERT INTO tblAorder (UserID, ClothesID, Quantity, TotalPrice, OrderDate, Status) VALUES
(1, 3, 1, 590.00, '2025-04-01 10:30:00', 'Delivered'),
(2, 1, 2, 420.00, '2025-04-05 14:15:00', 'Shipped'),
(3, 4, 1, 279.00, '2025-04-10 09:00:00', 'Processing'),
(5, 2, 3, 300.00, '2025-04-12 16:45:00', 'Delivered'),
(1, 5, 1, 180.00, '2025-04-15 11:20:00', 'Pending'),
(6, 7, 1, 299.00, '2025-04-16 08:00:00', 'Shipped'),
(7, 8, 1, 320.00, '2025-04-17 09:30:00', 'Delivered'),
(8, 9, 2, 178.00, '2025-04-18 10:00:00', 'Processing'),
(10, 10, 1, 245.00, '2025-04-19 11:15:00', 'Delivered'),
(11, 11, 1, 199.00, '2025-04-20 12:00:00', 'Shipped'),
(12, 12, 1, 159.00, '2025-04-21 13:30:00', 'Delivered'),
(13, 13, 2, 300.00, '2025-04-22 14:00:00', 'Pending'),
(15, 14, 1, 245.00, '2025-04-23 15:15:00', 'Shipped'),
(16, 15, 1, 350.00, '2025-04-24 16:00:00', 'Processing'),
(17, 16, 1, 199.00, '2025-04-25 09:00:00', 'Delivered'),
(18, 17, 2, 258.00, '2025-04-26 10:30:00', 'Shipped'),
(1, 18, 1, 165.00, '2025-04-27 11:00:00', 'Delivered'),
(2, 19, 1, 699.00, '2025-04-28 12:00:00', 'Processing'),
(3, 20, 1, 450.00, '2025-04-29 13:30:00', 'Pending'),
(5, 21, 1, 399.00, '2025-04-30 14:00:00', 'Delivered'),
(6, 22, 3, 237.00, '2025-05-01 15:00:00', 'Shipped'),
(7, 23, 1, 175.00, '2025-05-02 16:00:00', 'Delivered'),
(8, 24, 2, 240.00, '2025-05-03 09:00:00', 'Processing'),
(10, 25, 1, 220.00, '2025-05-04 10:00:00', 'Delivered'),
(11, 26, 1, 289.00, '2025-05-05 11:00:00', 'Shipped'),
(12, 27, 1, 145.00, '2025-05-06 12:00:00', 'Delivered'),
(13, 28, 1, 169.00, '2025-05-07 13:00:00', 'Pending'),
(15, 29, 1, 199.00, '2025-05-08 14:00:00', 'Shipped'),
(16, 30, 1, 185.00, '2025-05-09 15:00:00', 'Delivered'),
(17, 1, 1, 210.00, '2025-05-10 16:00:00', 'Processing');

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- LOGIN CREDENTIALS (for testing):
-- ============================================================
-- USER LOGIN (login.php):
--   Email: j.doe@abc.co.za       Password: user1pass
--   Email: sarah.j@campus.ac.za  Password: user2pass
--   Email: thabo.n@campus.ac.za  Password: user3pass
--   Email: david.m@campus.ac.za  Password: user5pass
--   (Users 6-30: password123)
--
-- ADMIN LOGIN (admin_login.php):
--   Email: admin@secondwear.co.za  Password: admin123
-- ============================================================
