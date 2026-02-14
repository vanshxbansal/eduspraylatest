<?php
/**
 * User Logout Handler
 * Destroys session and redirects to homepage
 */

require_once 'config.php';
require_once 'activity_tracker.php';

// Track logout before destroying session
$userId = $_SESSION['user_id'] ?? null;
if ($userId) {
    trackActivity($pdo, $userId, 'logout', null, 'User Logout');
}

// Clear all session variables
$_SESSION = [];

// Delete session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Destroy the session
session_destroy();

// Redirect to homepage
header('Location: ../index.html');
exit;
?>

