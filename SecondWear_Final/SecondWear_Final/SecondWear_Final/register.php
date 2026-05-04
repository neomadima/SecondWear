<?php
// register.php — handles new user registration for SecondWear
// Validates passwords, checks for an existing email, then inserts pending user records.
session_start();
include 'DBConn.php';

$error = "";
$success = "";
$fullname_val = "";
$email_val = "";
$campus_val = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname_val = trim($_POST['fullname']);
    $email_val    = trim($_POST['email']);
    $campus_val   = trim($_POST['campus']);
    $password     = $_POST['password'];
    $confirm      = $_POST['confirm_password'];

    if ($password !== $confirm) {
        $error = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        $check = $conn->prepare("SELECT UserID FROM tblUser WHERE Email = ?");
        $check->bind_param("s", $email_val);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $error = "An account with this email already exists.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $status = "pending";
            $stmt = $conn->prepare("INSERT INTO tblUser (FullName, Email, Password, Campus, Status) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $fullname_val, $email_val, $hashed, $campus_val, $status);
            if ($stmt->execute()) {
                $success = "Registration successful! Your account is pending admin verification.";
                $fullname_val = $email_val = $campus_val = "";
            } else {
                $error = "Registration failed: " . $conn->error;
            }
            $stmt->close();
        }
        $check->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SecondWear – Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #fefcf8; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
        .container { background: white; padding: 40px; border-radius: 16px; width: 100%; max-width: 500px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        h2 { color: #1a3b1a; margin-bottom: 20px; }
        input, select, button { width: 100%; padding: 12px; margin: 8px 0; border-radius: 8px; border: 1px solid #ddd; font-family: inherit; }
        button { background: #2c5e2a; color: white; font-weight: 600; cursor: pointer; border: none; }
        .error { background: #fee; color: #c33; padding: 10px; margin-bottom: 15px; border-radius: 8px; }
        .success { background: #e8f5e9; color: #2e7d32; padding: 10px; margin-bottom: 15px; border-radius: 8px; }
        a { color: #2c5e2a; text-decoration: none; }
    </style>
</head>
<body>
<div class="container">
    <h2>📝 Create Account</h2>
    <?php if ($error): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="success"><?php echo $success; ?></div><?php endif; ?>
    <form method="POST">
        <input type="text" name="fullname" placeholder="Full Name *" required value="<?php echo htmlspecialchars($fullname_val); ?>">
        <input type="email" name="email" placeholder="Email Address *" required value="<?php echo htmlspecialchars($email_val); ?>">
        <select name="campus" required>
            <option value="">Select Campus *</option>
            <option value="Pretoria" <?php if($campus_val=='Pretoria') echo 'selected'; ?>>Pretoria</option>
            <option value="Johannesburg" <?php if($campus_val=='Johannesburg') echo 'selected'; ?>>Johannesburg</option>
            <option value="Cape Town" <?php if($campus_val=='Cape Town') echo 'selected'; ?>>Cape Town</option>
            <option value="Durban" <?php if($campus_val=='Durban') echo 'selected'; ?>>Durban</option>
        </select>
        <input type="password" name="password" placeholder="Password * (min 6 characters)" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password *" required>
        <button type="submit">Register</button>
    </form>
    <p style="margin-top: 15px; text-align: center;"><a href="login.php">Already have an account? Login</a></p>
</div>
</body>
</html>