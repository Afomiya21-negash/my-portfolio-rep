<?php
require_once 'session_config.php';
require_once 'connection/db.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Check if ID is provided
if (!isset($_GET['id'])) {
    header('Location: manage_users.php');
    exit;
}

$id = $_GET['id'];

// Get user data
$sql = "SELECT id, username, email FROM users WHERE id = ?";
$stmt = $db->conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header('Location: manage_users.php');
    exit;
}

$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }
        form {
            max-width: 500px;
        }
        input, button {
            margin: 5px 0;
            padding: 8px;
            width: 100%;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        .note {
            color: #666;
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <h1>Edit User</h1>
    
    <a href="manage_users.php">Back to User Management</a>
    
    <form method="POST" action="manage_users.php">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>
        
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <p class="note">Leave blank to keep current password</p>
        </div>
        
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
        </div>
        
        <button type="submit" name="update_user">Update User</button>
    </form>
</body>
</html>