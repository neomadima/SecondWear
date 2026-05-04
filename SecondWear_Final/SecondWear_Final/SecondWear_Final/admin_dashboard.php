<?php
// admin_dashboard.php — admin panel for managing users and approving registrations
// Requires a logged-in admin session and displays user management controls.
session_start();
include 'DBConn.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$message = "";

// Approve user (set Status = 'verified')
if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $conn->query("UPDATE tblUser SET Status = 'verified' WHERE UserID = $id");
    $message = "User #$id verified.";
    header("Location: admin_dashboard.php");
    exit();
}

// Delete user account permanently from tblUser
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM tblUser WHERE UserID = $id");
    $message = "User #$id deleted.";
    header("Location: admin_dashboard.php");
    exit();
}

// Add new user via admin panel form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $campus = trim($_POST['campus']);
    $status = $_POST['status'];
    $stmt = $conn->prepare("INSERT INTO tblUser (FullName, Email, Password, Campus, Status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $fullname, $email, $password, $campus, $status);
    if ($stmt->execute()) {
        $message = "New user '$fullname' added.";
    } else {
        $message = "Error: " . $conn->error;
    }
    $stmt->close();
}

// Edit user information via admin panel form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_user'])) {
    $id = intval($_POST['user_id']);
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $campus = trim($_POST['campus']);
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE tblUser SET FullName=?, Email=?, Campus=?, Status=? WHERE UserID=?");
    $stmt->bind_param("ssssi", $fullname, $email, $campus, $status, $id);
    if ($stmt->execute()) {
        $message = "User #$id updated.";
    } else {
        $message = "Error: " . $conn->error;
    }
    $stmt->close();
}

// Fetch all users from tblUser
$users = $conn->query("SELECT * FROM tblUser ORDER BY CreatedAt DESC");
$pending = $conn->query("SELECT COUNT(*) as cnt FROM tblUser WHERE Status='pending'")->fetch_assoc()['cnt'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SecondWear – Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }
        .container { max-width: 1200px; margin: auto; background: white; padding: 20px; border-radius: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #1a3b1a; color: white; }
        .btn { padding: 5px 10px; border-radius: 5px; text-decoration: none; font-size: 12px; display: inline-block; margin: 2px; }
        .btn-approve { background: green; color: white; }
        .btn-delete { background: red; color: white; }
        .btn-edit { background: blue; color: white; }
        .stats { display: flex; gap: 20px; margin-bottom: 20px; }
        .stat-card { background: #f0f0f0; padding: 15px; border-radius: 10px; flex: 1; text-align: center; }
        .add-form, .edit-form { background: #f9f9f9; padding: 15px; margin-top: 20px; border-radius: 10px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }
        .add-form input, .add-form select, .edit-form input { padding: 8px; border-radius: 5px; border: 1px solid #ccc; }
        button { background: #1a3b1a; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; }
        .logout { float: right; background: #dc2626; padding: 8px 15px; border-radius: 5px; text-decoration: none; color: white; }
    </style>
</head>
<body>
<div class="container">
    <div style="display: flex; justify-content: space-between;">
        <h2>Admin Dashboard</h2>
        <a href="logout.php" class="logout">Logout</a>
    </div>
    <?php if ($message): ?>
        <p style="background: #d4edda; padding: 10px;"><?php echo $message; ?></p>
    <?php endif; ?>
    <div class="stats">
        <div class="stat-card">Total Users: <?php echo $users->num_rows; ?></div>
        <div class="stat-card">Pending Approval: <?php echo $pending; ?></div>
    </div>

    <h3>All Customers</h3>
    <table>
        <thead><tr><th>ID</th><th>Full Name</th><th>Email</th><th>Campus</th><th>Status</th><th>Created At</th><th>Actions</th></tr></thead>
        <tbody>
        <?php while ($row = $users->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['UserID']; ?></td>
                <td><?php echo htmlspecialchars($row['FullName']); ?></td>
                <td><?php echo htmlspecialchars($row['Email']); ?></td>
                <td><?php echo htmlspecialchars($row['Campus']); ?></td>
                <td><?php echo $row['Status']; ?></td>
                <td><?php echo $row['CreatedAt']; ?></td>
                <td>
                    <?php if ($row['Status'] == 'pending'): ?>
                        <a href="?approve=<?php echo $row['UserID']; ?>" class="btn btn-approve" onclick="return confirm('Verify this user?')">Approve</a>
                    <?php endif; ?>
                    <button class="btn btn-edit" onclick="openEdit(<?php echo $row['UserID']; ?>, '<?php echo addslashes($row['FullName']); ?>', '<?php echo addslashes($row['Email']); ?>', '<?php echo addslashes($row['Campus']); ?>', '<?php echo $row['Status']; ?>')">Edit</button>
                    <a href="?delete=<?php echo $row['UserID']; ?>" class="btn btn-delete" onclick="return confirm('Delete this user?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <h3>Add New Customer</h3>
    <form method="POST" class="add-form">
        <input type="text" name="fullname" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="campus" required>
            <option value="">Campus</option>
            <option>Pretoria Campus</option><option>Johannesburg Campus</option><option>Cape Town Campus</option><option>Durban Campus</option>
        </select>
        <select name="status">
            <option value="verified">Verified</option>
            <option value="pending">Pending</option>
        </select>
        <button type="submit" name="add_user">Add Customer</button>
    </form>

    <!-- Edit Modal -->
    <div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
        <div style="background:white; padding:20px; border-radius:10px; width:400px;">
            <h3>Edit Customer</h3>
            <form method="POST">
                <input type="hidden" name="user_id" id="edit_id">
                <input type="text" name="fullname" id="edit_name" placeholder="Full Name" required style="width:100%; margin-bottom:10px;">
                <input type="email" name="email" id="edit_email" placeholder="Email" required style="width:100%; margin-bottom:10px;">
                <input type="text" name="campus" id="edit_campus" placeholder="Campus" style="width:100%; margin-bottom:10px;">
                <select name="status" id="edit_status" style="width:100%; margin-bottom:10px;">
                    <option value="verified">Verified</option>
                    <option value="pending">Pending</option>
                </select>
                <button type="submit" name="edit_user">Save Changes</button>
                <button type="button" onclick="closeEdit()">Cancel</button>
            </form>
        </div>
    </div>
</div>
<script>
function openEdit(id, name, email, campus, status) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_campus').value = campus;
    document.getElementById('edit_status').value = status;
    document.getElementById('editModal').style.display = 'flex';
}
function closeEdit() {
    document.getElementById('editModal').style.display = 'none';
}
</script>
</body>
</html>