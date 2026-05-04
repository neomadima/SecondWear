<?php
// myadmin.php — admin database utility page that ensures schema exists, inserts sample admin, and provides quick database management actions.
session_start();

// Database connection details
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "myClothingStore";

// Try to connect without database first
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Auto-create database and tables
$createDbSql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (!$conn->query($createDbSql)) {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($dbname);

// Create all tables
$tables = array(
    "CREATE TABLE IF NOT EXISTS tblUser (
        UserID INT AUTO_INCREMENT PRIMARY KEY,
        FullName VARCHAR(100) NOT NULL,
        Email VARCHAR(100) NOT NULL UNIQUE,
        Password VARCHAR(255) NOT NULL,
        Campus VARCHAR(100),
        Status ENUM('pending', 'verified') DEFAULT 'pending',
        CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP
    )",
    
    "CREATE TABLE IF NOT EXISTS tblAdmin (
        AdminID INT AUTO_INCREMENT PRIMARY KEY,
        FullName VARCHAR(100) NOT NULL,
        Email VARCHAR(100) NOT NULL UNIQUE,
        Password VARCHAR(255) NOT NULL,
        CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP
    )",
    
    "CREATE TABLE IF NOT EXISTS tblClothes (
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
        UserID INT,
        ImagePath VARCHAR(255),
        CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (UserID) REFERENCES tblUser(UserID) ON DELETE CASCADE
    )",
    
    "CREATE TABLE IF NOT EXISTS tblAorder (
        OrderID INT AUTO_INCREMENT PRIMARY KEY,
        UserID INT NOT NULL,
        ClothesID INT NOT NULL,
        OrderDate DATETIME DEFAULT CURRENT_TIMESTAMP,
        Status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
        FOREIGN KEY (UserID) REFERENCES tblUser(UserID) ON DELETE CASCADE,
        FOREIGN KEY (ClothesID) REFERENCES tblClothes(ClothesID) ON DELETE CASCADE
    )"
);

foreach ($tables as $table) {
    if (!$conn->query($table)) {
        error_log("Error creating table: " . $conn->error);
    }
}

// Insert sample admin if not exists
$checkAdmin = $conn->query("SELECT COUNT(*) as count FROM tblAdmin");
$adminRow = $checkAdmin->fetch_assoc();

if ($adminRow['count'] == 0) {
    $adminHash = password_hash("admin123", PASSWORD_DEFAULT);
    $conn->query("INSERT INTO tblAdmin (FullName, Email, Password) VALUES ('Admin User', 'admin@secondwear.co.za', '$adminHash')");
}

// Handle actions
$message = "";
if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $action = $_POST['action'] ?? '';

    // Verify user
    if ($action === 'verify' && isset($_POST['user_id'])) {
        $uid = intval($_POST['user_id']);
        $conn->query("UPDATE tblUser SET Status = 'verified' WHERE UserID = $uid");
        $message = "✅ User #$uid verified!";
    }

    // Delete user
    if ($action === 'delete' && isset($_POST['user_id'])) {
        $uid = intval($_POST['user_id']);
        $conn->query("DELETE FROM tblUser WHERE UserID = $uid");
        $message = "🗑️ User #$uid deleted!";
    }

    // Delete product
    if ($action === 'delete_product' && isset($_POST['product_id'])) {
        $pid = intval($_POST['product_id']);
        $conn->query("DELETE FROM tblClothes WHERE ClothesID = $pid");
        $message = "🗑️ Product #$pid deleted!";
    }
}

// Get statistics
$userCount = $conn->query("SELECT COUNT(*) as count FROM tblUser")->fetch_assoc()['count'];
$productCount = $conn->query("SELECT COUNT(*) as count FROM tblClothes")->fetch_assoc()['count'];
$orderCount = $conn->query("SELECT COUNT(*) as count FROM tblAorder")->fetch_assoc()['count'];
$verifiedCount = $conn->query("SELECT COUNT(*) as count FROM tblUser WHERE Status='verified'")->fetch_assoc()['count'];
$pendingCount = $conn->query("SELECT COUNT(*) as count FROM tblUser WHERE Status='pending'")->fetch_assoc()['count'];

// Get recent data
$recentUsers = $conn->query("SELECT * FROM tblUser ORDER BY CreatedAt DESC LIMIT 5");
$recentProducts = $conn->query("SELECT * FROM tblClothes ORDER BY CreatedAt DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyAdmin - SecondWear Database</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Inter', sans-serif; 
            background: linear-gradient(135deg, #1a3b1a 0%, #2d5a2a 100%);
            color: #333;
            min-height: 100vh;
            padding: 20px;
        }
        .container { max-width: 1400px; margin: 0 auto; }
        .header {
            background: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        .header h1 { color: #1a3b1a; font-size: 32px; }
        .header p { color: #666; font-size: 14px; }
        .button-group { display: flex; gap: 10px; flex-wrap: wrap; }
        .btn {
            background: #2c5e2a;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 40px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
        }
        .btn:hover { background: #1a3b1a; }
        .btn-danger { background: #f44336; }
        .btn-danger:hover { background: #d32f2f; }
        .btn-info { background: #2196f3; }
        .btn-info:hover { background: #1976d2; }
        .message { 
            background: #e8f5e9; 
            border-left: 4px solid #4caf50; 
            padding: 15px; 
            margin-bottom: 20px; 
            border-radius: 4px; 
            color: #2e7d32;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stat-card h3 { color: #666; font-size: 14px; margin-bottom: 10px; }
        .stat-card .number { color: #2c5e2a; font-size: 36px; font-weight: 700; }
        .content-section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .content-section h2 { color: #1a3b1a; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #eee; }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th {
            background: #f5f5f5;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #ddd;
        }
        table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        table tr:hover { background: #f9f9f9; }
        .status-verified { background: #e8f5e9; color: #2e7d32; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 600; }
        .status-pending { background: #fff3e0; color: #e65100; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 600; }
        .no-data { text-align: center; color: #999; padding: 40px; }
        .action-buttons { display: flex; gap: 8px; }
        .action-buttons a { font-size: 12px; }
        @media (max-width: 768px) {
            .header { flex-direction: column; align-items: flex-start; }
            .stats { grid-template-columns: 1fr; }
            table { font-size: 12px; }
            table th, table td { padding: 8px; }
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Header -->
    <div class="header">
        <div>
            <h1>🔧 MyAdmin</h1>
            <p>SecondWear Database Management</p>
        </div>
        <div class="button-group">
            <a href="index.php" class="btn"><i class="fas fa-home"></i> Home</a>
            <a href="admin_dashboard.php" class="btn btn-info"><i class="fas fa-chart-line"></i> Admin Panel</a>
        </div>
    </div>

    <?php if (!empty($message)): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <!-- Statistics -->
    <div class="stats">
        <div class="stat-card">
            <h3>👥 Total Users</h3>
            <div class="number"><?php echo $userCount; ?></div>
        </div>
        <div class="stat-card">
            <h3>✅ Verified Users</h3>
            <div class="number"><?php echo $verifiedCount; ?></div>
        </div>
        <div class="stat-card">
            <h3>⏳ Pending Users</h3>
            <div class="number"><?php echo $pendingCount; ?></div>
        </div>
        <div class="stat-card">
            <h3>👕 Total Products</h3>
            <div class="number"><?php echo $productCount; ?></div>
        </div>
        <div class="stat-card">
            <h3>📦 Total Orders</h3>
            <div class="number"><?php echo $orderCount; ?></div>
        </div>
        <div class="stat-card">
            <h3>🗄️ Database</h3>
            <div class="number" style="color: #2196f3;">✓ OK</div>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="content-section">
        <h2>👥 Recent Users</h2>
        <?php if ($recentUsers->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Campus</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $recentUsers->fetch_assoc()): ?>
                        <tr>
                            <td>#<?php echo $user['UserID']; ?></td>
                            <td><?php echo htmlspecialchars($user['FullName']); ?></td>
                            <td><?php echo htmlspecialchars($user['Email']); ?></td>
                            <td><?php echo htmlspecialchars($user['Campus'] ?? 'N/A'); ?></td>
                            <td>
                                <?php if ($user['Status'] === 'verified'): ?>
                                    <span class="status-verified">✓ Verified</span>
                                <?php else: ?>
                                    <span class="status-pending">⏳ Pending</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($user['CreatedAt'])); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <?php if ($user['Status'] === 'pending'): ?>
                        <form method="POST" style="display:inline; margin:0;">
                            <input type="hidden" name="action" value="verify">
                            <input type="hidden" name="user_id" value="<?php echo $user['UserID']; ?>">
                            <button type="submit" class="btn" style="padding: 6px 12px; font-size: 11px;" onclick="return confirm('Verify this user?');"><i class="fas fa-check"></i> Verify</button>
                        </form>
                    <?php endif; ?>
                    <form method="POST" style="display:inline; margin:0;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="user_id" value="<?php echo $user['UserID']; ?>">
                        <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 11px;" onclick="return confirm('Delete this user?');"><i class="fas fa-trash"></i> Delete</button>
                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">No users yet. Register to get started!</div>
        <?php endif; ?>
    </div>

    <!-- Recent Products -->
    <div class="content-section">
        <h2>👕 Recent Products</h2>
        <?php if ($recentProducts->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Size</th>
                        <th>Campus</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($product = $recentProducts->fetch_assoc()): ?>
                        <tr>
                            <td>#<?php echo $product['ClothesID']; ?></td>
                            <td><?php echo htmlspecialchars($product['Name']); ?></td>
                            <td>R<?php echo number_format($product['Price'], 2); ?></td>
                            <td><?php echo htmlspecialchars($product['Category'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($product['Size'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($product['Campus'] ?? 'N/A'); ?></td>
                            <td><?php echo date('M d, Y', strtotime($product['CreatedAt'])); ?></td>
                            <td>
                                <form method="POST" style="display:inline; margin:0;">
                                    <input type="hidden" name="action" value="delete_product">
                                    <input type="hidden" name="product_id" value="<?php echo $product['ClothesID']; ?>">
                                    <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 11px;" onclick="return confirm('Delete this product?');"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">No products yet. Start selling!</div>
        <?php endif; ?>
    </div>

    <!-- Database Info -->
    <div class="content-section">
        <h2>🗄️ Database Information</h2>
        <table>
            <tr>
                <td><strong>Database Name:</strong></td>
                <td><?php echo $dbname; ?></td>
            </tr>
            <tr>
                <td><strong>Server:</strong></td>
                <td><?php echo $servername; ?></td>
            </tr>
            <tr>
                <td><strong>Status:</strong></td>
                <td>✅ Connected & Running</td>
            </tr>
            <tr>
                <td><strong>Tables:</strong></td>
                <td>tblUser, tblAdmin, tblClothes, tblAorder</td>
            </tr>
        </table>
    </div>

</div>
</body>
</html>

<?php $conn->close(); ?>
