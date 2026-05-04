<?php
// DBConn.php — database connection and schema initialization for SecondWear
// Connects to MySQL, creates the ClothingStore database if it does not already exist,
// and ensures the application tables are available before web pages use them.
$servername = "127.0.0.1:3306";   // force TCP/IP to avoid socket issues on some Windows setups
$username = "root";
$password = "";                    // default XAMPP MySQL root password is empty
$dbname = "ClothingStore";

// Open a connection to MySQL server without selecting a database first
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database if it does not already exist, then switch to it
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);

// Create all tables if they don't exist
$conn->query("CREATE TABLE IF NOT EXISTS tblUser (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    FullName VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Campus VARCHAR(100),
    Status ENUM('pending', 'verified') DEFAULT 'pending',
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP
)");

// Create admin table for application administrators
$conn->query("CREATE TABLE IF NOT EXISTS tblAdmin (
    AdminID INT AUTO_INCREMENT PRIMARY KEY,
    FullName VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP
)");

// Create clothes table for product listings. SellerID links to tblUser and is nullable.
$conn->query("CREATE TABLE IF NOT EXISTS tblClothes (
    ClothesID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Description TEXT,
    Price DECIMAL(10,2) NOT NULL,
    Size VARCHAR(10),
    Category VARCHAR(50),
    Gender ENUM('men','women','unisex') DEFAULT 'unisex',
    Brand VARCHAR(50),
    ItemCondition VARCHAR(50),
    Campus VARCHAR(100),
    SellerID INT,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (SellerID) REFERENCES tblUser(UserID) ON DELETE SET NULL
)");

// Create orders table to record purchases and order status
$conn->query("CREATE TABLE IF NOT EXISTS tblAorder (
    OrderID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    ClothesID INT,
    Quantity INT NOT NULL DEFAULT 1,
    TotalPrice DECIMAL(10,2) NOT NULL,
    OrderDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    Status VARCHAR(50) DEFAULT 'Pending',
    FOREIGN KEY (UserID) REFERENCES tblUser(UserID) ON DELETE SET NULL,
    FOREIGN KEY (ClothesID) REFERENCES tblClothes(ClothesID) ON DELETE SET NULL
)");

// Insert a default admin account if it does not already exist
$admin_email = "admin@secondwear.co.za";
$admin_pass = password_hash("admin123", PASSWORD_DEFAULT);
$check = $conn->query("SELECT * FROM tblAdmin WHERE Email = '$admin_email'");
if ($check->num_rows == 0) {
    $conn->query("INSERT INTO tblAdmin (FullName, Email, Password) VALUES ('Admin User', '$admin_email', '$admin_pass')");
}

// Set the character encoding for the connection
$conn->set_charset("utf8mb4");
?>
