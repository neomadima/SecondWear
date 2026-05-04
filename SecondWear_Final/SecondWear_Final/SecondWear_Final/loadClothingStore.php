<?php
// loadClothingStore.php — rebuilds the entire ClothingStore schema and imports text-based dataset files
// This script drops the existing schema and re-creates tables using the same structure as DBConn.php.
include 'DBConn.php';   // use the existing connection from DBConn.php

echo "<h2>loadClothingStore.php — Building ClothingStore Database</h2>";

// Drop tables in the correct order to avoid foreign key constraint errors
$conn->query("SET FOREIGN_KEY_CHECKS = 0");
$conn->query("DROP TABLE IF EXISTS tblAorder");
$conn->query("DROP TABLE IF EXISTS tblClothes");
$conn->query("DROP TABLE IF EXISTS tblUser");
$conn->query("DROP TABLE IF EXISTS tblAdmin");
$conn->query("SET FOREIGN_KEY_CHECKS = 1");
echo "<p>✅ All existing tables dropped</p>";

// Recreate tables (same structure as in DBConn.php, but we ensure it's done)
$conn->query("CREATE TABLE tblUser (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    FullName VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Campus VARCHAR(100),
    Status ENUM('pending', 'verified') DEFAULT 'pending',
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP
)");
echo "<p>✅ tblUser created</p>";

$conn->query("CREATE TABLE tblAdmin (
    AdminID INT AUTO_INCREMENT PRIMARY KEY,
    FullName VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP
)");
echo "<p>✅ tblAdmin created</p>";

$conn->query("CREATE TABLE tblClothes (
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
echo "<p>✅ tblClothes created</p>";

$conn->query("CREATE TABLE tblAorder (
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
echo "<p>✅ tblAorder created</p>";

// Load data from text files
// Helper function to read a tab-delimited data file and insert rows into the matching table
function loadFromFile($conn, $filename, $table, $columns, $types) {
    if (!file_exists($filename)) { echo "<p>❌ $filename not found</p>"; return 0; }
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $placeholders = implode(',', array_fill(0, count($columns), '?'));
    $colStr = implode(',', $columns);
    $stmt = $conn->prepare("INSERT INTO $table ($colStr) VALUES ($placeholders)");
    $count = 0;
    foreach ($lines as $line) {
        $parts = explode("\t", $line);
        if (count($parts) >= count($columns)) {
            $params = array_slice($parts, 0, count($columns));
            $params = array_map('trim', $params);
            $stmt->bind_param($types, ...$params);
            if ($stmt->execute()) $count++;
        }
    }
    $stmt->close();
    echo "<p>✅ Loaded $count rows into $table from $filename</p>";
    return $count;
}

loadFromFile($conn, "userData.txt", "tblUser",
    ["FullName", "Email", "Password", "Campus", "Status"], "sssss");

loadFromFile($conn, "adminData.txt", "tblAdmin",
    ["FullName", "Email", "Password"], "sss");

loadFromFile($conn, "clothesData.txt", "tblClothes",
    ["Name", "Description", "Price", "Size", "Category", "Gender", "Brand", "ItemCondition", "Campus", "SellerID"], "ssdssssssi");

loadFromFile($conn, "orderData.txt", "tblAorder",
    ["UserID", "ClothesID", "Quantity", "TotalPrice", "OrderDate", "Status"], "iiidss");

echo "<h3>Database Summary:</h3>";
$tables = ["tblUser", "tblAdmin", "tblClothes", "tblAorder"];
echo "<table border='1' cellpadding='8' cellspacing='0' style='border-collapse:collapse;'>";
echo "<tr style='background:#1a3b1a; color:white;'><th>Table</th><th>Row Count</th></tr>";
foreach ($tables as $t) {
    $res = $conn->query("SELECT COUNT(*) as cnt FROM $t");
    $row = $res->fetch_assoc();
    echo "<tr><td>$t</td><td>" . $row["cnt"] . "</td></tr>";
}
echo "</table>";

$conn->close();
echo "<p><br><a href='index.php'>← Back to Home</a></p>";
?>