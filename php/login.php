<?php
/**
 * User Login Handler
 * Handles POST requests from login.html
 */

require_once 'config.php';
require_once 'activity_tracker.php';

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get input
$email = trim(strtolower($_POST['email'] ?? ''));
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']) && $_POST['remember'] === 'on';

// Basic validation
if (empty($email) || empty($password)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Email and password are required']);
    exit;
}

// Find user by email
try {
    $stmt = $pdo->prepare("SELECT id, name, email, phone, password, role, status FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again.']);
    exit;
}

// Check if user exists
if (!$user) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
    exit;
}

// Check account status
if ($user['status'] !== 'active') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Your account is not active. Please contact support.']);
    exit;
}

// Verify password
if (!password_verify($password, $user['password'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
    exit;
}

// Create session
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['name'];
$_SESSION['user_email'] = $user['email'];
$_SESSION['user_role'] = $user['role'];
$_SESSION['logged_in'] = true;
$_SESSION['login_time'] = time();

// Update last login timestamp
try {
    $stmt = $pdo->prepare("UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE id = ?");
    $stmt->execute([$user['id']]);
} catch (PDOException $e) {
    // Non-critical, continue
}

// Regenerate session ID for security
session_regenerate_id(true);

// Track login activity
trackActivity($pdo, $user['id'], 'login', null, 'Email Login');

// Success response - redirect to homepage
echo json_encode([
    'success' => true,
    'message' => 'Login successful! Redirecting...',
    'redirect' => 'index.html',
    'user' => [
        'name' => $user['name'],
        'email' => $user['email'],
        'role' => $user['role']
    ]
]);
?>

