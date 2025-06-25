<?php
require_once 'session_config.php';
require_once 'connection/db.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_user'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        
        $db->manageUsers('create', null, $username, $password, $email);
        header("Location: manage_users.php?action=added");
        exit;
    }
    
    if (isset($_POST['update_user'])) {
        $id = $_POST['id'];
        $username = $_POST['username'];
        $password = $_POST['password']; // Will be empty if not changing
        $email = $_POST['email'];
        
        $db->manageUsers('update', $id, $username, $password, $email);
        header("Location: manage_users.php?action=updated");
        exit;
    }
}

// Handle delete requests
if (isset($_GET['delete_user'])) {
    $id = $_GET['delete_user'];
    $db->manageUsers('delete', $id);
    header("Location: manage_users.php?action=deleted");
    exit;
}

// Get all users
$users = $db->manageUsers('read');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            max-width: 500px;
            margin-bottom: 30px;
        }
        input, button {
            margin: 5px 0;
            padding: 8px;
        }
        .success {
            color: green;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h1>Manage Users</h1>
    
    <a href="admin.php">Back to Admin Panel</a>
    
    <?php if (isset($_GET['action'])): ?>
        <div class="success">
            <?php 
                if ($_GET['action'] == 'added') echo "User added successfully!";
                if ($_GET['action'] == 'updated') echo "User updated successfully!";
                if ($_GET['action'] == 'deleted') echo "User deleted successfully!";
            ?>
        </div>
    <?php endif; ?>
    
    <h2>Add New User</h2>
    <form method="POST">
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
        </div>
        <button type="submit" name="add_user">Add User</button>
    </form>
    
    <h2>Existing Users</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $users->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email'] ?? ''); ?></td>
                    <td><?php echo $user['created_at']; ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a> | 
                        <a href="manage_users.php?delete_user=<?php echo $user['id']; ?>" 
                           onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>