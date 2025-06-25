<?php
require_once 'session_config.php';

echo "<h1>Session Test</h1>";
echo "<pre>";
echo "Session ID: " . session_id() . "\n\n";
echo "Session Data:\n";
print_r($_SESSION);
echo "</pre>";

echo "<p>Is admin logged in? ";
echo (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) ? "YES" : "NO";
echo "</p>";

echo "<p><a href='admin.php'>Try accessing admin page</a></p>";
echo "<p><a href='login.php'>Go to login page</a></p>";
echo "<p><a href='logout.php'>Logout</a></p>";
?>