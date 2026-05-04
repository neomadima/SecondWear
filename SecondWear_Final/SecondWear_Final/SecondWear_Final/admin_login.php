<?php
// admin_login.php — secure sign-in page for SecondWear administrators
// Redirects authenticated admins to the admin dashboard.
session_start();
include 'DBConn.php';

if (isset($_SESSION['admin_id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

$error = "";
$email_val = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_val = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM tblAdmin WHERE Email = ?");
    $stmt->bind_param("s", $email_val);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['Password'])) {
            $_SESSION['admin_id'] = $admin['AdminID'];
            $_SESSION['admin_name'] = $admin['FullName'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No admin account found with that email.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SecondWear – Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .admin-container { background: white; padding: 40px; border-radius: 16px; width: 400px; text-align: center; }
        input, button { width: 100%; padding: 12px; margin: 10px 0; border-radius: 8px; border: 1px solid #ddd; }
        button { background: #1a3b1a; color: white; font-weight: 600; cursor: pointer; border: none; }
        .error { color: red; margin-bottom: 10px; }
        a { color: #1a3b1a; text-decoration: none; }
    </style>
</head>
<body>
<div class="admin-container">
    <h2>Admin Login</h2>
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Admin Email" required value="<?php echo htmlspecialchars($email_val); ?>">
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p style="margin-top: 20px;"><a href="index.php">← Back to Home</a></p>
</div>
</body>
</html>