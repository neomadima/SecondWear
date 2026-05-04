<?php
// login.php — handles user authentication for SecondWear
// Verifies username/email and password against tblUser, then starts a browser session.
session_start();
include 'DBConn.php';

$error = "";
$success = false;
$username_val = "";
$email_val = "";
$user_data = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_val = trim($_POST['username']);
    $email_val = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM tblUser WHERE FullName = ? AND Email = ?");
    $stmt->bind_param("ss", $username_val, $email_val);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if ($user['Status'] === 'pending') {
            $error = "Your account is pending verification. Please wait for admin approval.";
        } elseif (password_verify($password, $user['Password'])) {
            $_SESSION['user_id'] = $user['UserID'];
            $_SESSION['user_name'] = $user['FullName'];
            $success = true;
            $user_data = $user;   // store for display
        } else {
            $error = "Incorrect password. Please try again.";
        }
    } else {
        $error = "No account found with that username and email. Please register first.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SecondWear – Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #fefcf8; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
        .container { background: white; padding: 40px; border-radius: 16px; width: 100%; max-width: 550px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        h2 { color: #1a3b1a; margin-bottom: 20px; }
        input, button { width: 100%; padding: 12px; margin: 8px 0; border-radius: 8px; border: 1px solid #ddd; font-family: inherit; }
        button { background: #2c5e2a; color: white; font-weight: 600; cursor: pointer; border: none; }
        .error { background: #fee; color: #c33; padding: 10px; margin-bottom: 15px; border-radius: 8px; }
        .success { background: #e8f5e9; color: #2e7d32; padding: 10px; margin-bottom: 15px; border-radius: 8px; }
        .user-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .user-table th, .user-table td { padding: 10px; border-bottom: 1px solid #eee; text-align: left; }
        .user-table th { background: #1a3b1a; color: white; }
        .btn-link { display: inline-block; margin-top: 20px; color: #2c5e2a; text-decoration: none; }
    </style>
</head>
<body>
<div class="container">
    <h2>🔐 Login to SecondWear</h2>

    <?php if ($success && $user_data): ?>
        <div class="success">✅ User <?php echo htmlspecialchars($user_data['FullName']); ?> is logged in</div>
        <h3>Your Account Details</h3>
        <table class="user-table">
            <?php foreach ($user_data as $key => $value): ?>
                <?php if ($key !== 'Password'): ?>
                <tr>
                    <th><?php echo htmlspecialchars($key); ?></th>
                    <td><?php echo htmlspecialchars($value); ?></td>
                </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
        <div style="text-align: center; margin-top: 20px;">
            <a href="index.php" class="btn-link">← Continue to Homepage</a>
        </div>
    <?php else: ?>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username (Full Name)" required value="<?php echo htmlspecialchars($username_val); ?>">
            <input type="email" name="email" placeholder="Email Address" required value="<?php echo htmlspecialchars($email_val); ?>">
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <div style="margin-top: 20px; text-align: center;">
            <a href="register.php">Don’t have an account? Register</a><br>
            <a href="admin_login.php">Admin Login</a><br>
            <a href="index.php">← Back to Home</a>
        </div>
    <?php endif; ?>
</div>
</body>
</html>