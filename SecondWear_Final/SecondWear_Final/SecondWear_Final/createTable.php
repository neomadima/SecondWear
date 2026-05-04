<?php
// createTable.php — Check if tblUser exists, drop it, recreate it, load data from userData.txt
// Include the database connection
include 'DBConn.php';

echo "<h2>createTable.php — Rebuilding tblUser</h2>";

// Step 1: Drop tblUser if it exists
$conn->query("DROP TABLE IF EXISTS tblUser");
echo "<p>✅ Dropped tblUser (if it existed)</p>";

// Step 2: Create tblUser
$createSQL = "CREATE TABLE tblUser (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    FullName VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Campus VARCHAR(100),
    Status ENUM('pending', 'verified') DEFAULT 'pending',
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($createSQL) === TRUE) {
    echo "<p>✅ tblUser created successfully</p>";
} else {
    echo "<p>❌ Error creating table: " . $conn->error . "</p>";
}

// Step 3: Load user data from the plain-text file userData.txt
$filename = "userData.txt";
if (file_exists($filename)) {
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $stmt = $conn->prepare("INSERT INTO tblUser (FullName, Email, Password, Campus, Status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $password, $campus, $status);

    $count = 0;
    foreach ($lines as $line) {
        $parts = explode("\t", $line);
        if (count($parts) >= 5) {
            $name = trim($parts[0]);
            $email = trim($parts[1]);
            $password = trim($parts[2]);
            $campus = trim($parts[3]);
            $status = trim($parts[4]);
            if ($stmt->execute()) {
                $count++;
            } else {
                echo "<p>❌ Error inserting: " . $stmt->error . "</p>";
            }
        }
    }
    $stmt->close();
    echo "<p>✅ Loaded $count users from $filename</p>";
} else {
    echo "<p>❌ File $filename not found!</p>";
}

// Step 4: Display loaded data
$result = $conn->query("SELECT * FROM tblUser");
if ($result->num_rows > 0) {
    echo "<h3>Current tblUser contents:</h3>";
    echo "<table border='1' cellpadding='8' cellspacing='0' style='border-collapse:collapse; font-family:Arial;'>";
    echo "<tr style='background:#1a3b1a; color:white;'><th>UserID</th><th>FullName</th><th>Email</th><th>Campus</th><th>Status</th><th>CreatedAt</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["UserID"] . "</td>";
        echo "<td>" . $row["FullName"] . "</td>";
        echo "<td>" . $row["Email"] . "</td>";
        echo "<td>" . $row["Campus"] . "</td>";
        echo "<td>" . $row["Status"] . "</td>";
        echo "<td>" . $row["CreatedAt"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

$conn->close();
echo "<p><br><a href='index.php'>← Back to Home</a></p>";
?>
