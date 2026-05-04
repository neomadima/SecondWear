<?php
// setup_database.php — import the prebuilt SQL schema into the MySQL server
// Run this page once to initialize the ClothingStore database and seed sample data.

$servername = "localhost:3306";
$username = "root";
$password = "";

// Create connection to MySQL server without choosing a default database
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Path to the SQL dump file containing database schema and sample data
$sqlFile = __DIR__ . '/myClothingStore.sql';

if (!file_exists($sqlFile)) {
    die("Error: SQL file not found at " . $sqlFile);
}

$sqlContent = file_get_contents($sqlFile);

// Split by semicolon and execute each statement
$statements = array_filter(array_map('trim', explode(';', $sqlContent)));

$successCount = 0;
$errorCount = 0;
$errors = [];

foreach ($statements as $statement) {
    if (empty($statement)) continue;
    
    // Execute each SQL statement from the dump file
    if ($conn->multi_query($statement)) {
        $successCount++;
        // Clear any additional result sets produced by multi_query
        while ($conn->next_result()) {
            if ($res = $conn->store_result()) {
                $res->free();
            }
        }
    } else {
        $errorCount++;
        $errors[] = "Error: " . $conn->error . " | Query: " . substr($statement, 0, 50) . "...";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecondWear Database Setup</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f5f5f5; color: #333; }
        .container { max-width: 800px; margin: 50px auto; padding: 40px; background: white; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h1 { color: #1a3b1a; margin-bottom: 20px; }
        .success { background: #e8f5e9; border-left: 4px solid #4caf50; padding: 15px; margin: 15px 0; border-radius: 4px; color: #2e7d32; }
        .error { background: #ffebee; border-left: 4px solid #f44336; padding: 15px; margin: 15px 0; border-radius: 4px; color: #c62828; }
        .info { background: #e3f2fd; border-left: 4px solid #2196f3; padding: 15px; margin: 15px 0; border-radius: 4px; color: #1565c0; }
        .button { background: #2c5e2a; color: white; padding: 12px 24px; border: none; border-radius: 40px; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block; margin-top: 20px; }
        .button:hover { background: #1a3b1a; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 4px; font-family: monospace; }
    </style>
</head>
<body>
<div class="container">
    <h1>🔧 SecondWear Database Setup</h1>
    
    <?php if ($successCount > 0): ?>
        <div class="success">
            <strong>✅ Success!</strong><br>
            Database imported successfully!<br>
            <strong><?php echo $successCount; ?></strong> SQL statements executed.
        </div>
        
        <div class="info">
            <strong>📝 Sample Login Credentials:</strong><br><br>
            <strong>Admin Account:</strong><br>
            Email: <code>admin@secondwear.co.za</code><br>
            Password: <code>admin123</code><br><br>
            <strong>Test User Account:</strong><br>
            Email: <code>j.doe@abc.co.za</code><br>
            Password: <code>user1pass</code>
        </div>
    <?php endif; ?>
    
    <?php if ($errorCount > 0): ?>
        <div class="error">
            <strong>⚠️ Warnings:</strong><br>
            <?php echo $errorCount; ?> statements had issues (this may be normal if tables already exist).<br>
            <?php foreach ($errors as $err): ?>
                <small><?php echo htmlspecialchars($err); ?></small><br>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <div class="info">
        <strong>✓ Database is ready!</strong><br>
        You can now use the SecondWear application.
    </div>
    
    <a href="index.php" class="button">Go to Home Page →</a>
</div>
</body>
</html>
