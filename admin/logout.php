<?php
/**
 * Admin Logout
 */

session_start();

// Clear all admin session variables
unset($_SESSION['admin_logged_in']);
unset($_SESSION['admin_email']);
unset($_SESSION['admin_login_time']);

// Clear all session data
$_SESSION = [];

// Delete session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Destroy the session
session_destroy();

// Redirect to login
header('Location: /admin/login.php');
exit;
?>



