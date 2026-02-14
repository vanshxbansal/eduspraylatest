<?php
/**
 * User Registration Handler
 * Handles POST requests from register.html
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

// Get and sanitize input
$name = trim($_POST['name'] ?? '');
$email = trim(strtolower($_POST['email'] ?? ''));
$phone = trim($_POST['phone'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Validation
$errors = [];

// Name validation
if (empty($name)) {
    $errors[] = 'Name is required';
} elseif (strlen($name) < 2 || strlen($name) > 100) {
    $errors[] = 'Name must be between 2 and 100 characters';
}

// Email validation
if (empty($email)) {
    $errors[] = 'Email is required';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address';
}

// Phone validation (optional but if provided, validate format)
if (!empty($phone)) {
    $phone = preg_replace('/[^0-9+]/', '', $phone);
    if (strlen($phone) < 10 || strlen($phone) > 15) {
        $errors[] = 'Please enter a valid phone number';
    }
}

// Password validation
if (empty($password)) {
    $errors[] = 'Password is required';
} elseif (strlen($password) < 8) {
    $errors[] = 'Password must be at least 8 characters long';
} elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
    $errors[] = 'Password must contain at least one letter and one number';
}

// Confirm password
if ($password !== $confirm_password) {
    $errors[] = 'Passwords do not match';
}

// Check if email already exists
if (empty($errors)) {
    try {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = 'This email is already registered. Please login instead.';
        }
    } catch (PDOException $e) {
        $errors[] = 'Unable to verify email. Please try again.';
    }
}

// Return errors if any
if (!empty($errors)) {
    http_response_code(400);
    echo json_encode([
        'success' => false, 
        'message' => $errors[0], // Return first error
        'errors' => $errors
    ]);
    exit;
}

// Hash password securely
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert user into database
try {
    $stmt = $pdo->prepare("INSERT INTO users (name, email, phone, password, auth_provider) VALUES (?, ?, ?, ?, 'local')");
    $stmt->execute([$name, $email, $phone ?: null, $hashed_password]);
    
    $userId = $pdo->lastInsertId();
    
    // Track registration activity
    trackActivity($pdo, $userId, 'register', null, 'Email Registration');
    
    // Auto-login after registration
    $_SESSION['user_id'] = $userId;
    $_SESSION['user_name'] = $name;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_role'] = 'user';
    $_SESSION['logged_in'] = true;
    $_SESSION['login_time'] = time();
    $_SESSION['auth_provider'] = 'local';
    
    session_regenerate_id(true);
    
    echo json_encode([
        'success' => true,
        'message' => 'Registration successful! Welcome to Eduspray!',
        'redirect' => 'index.html'
    ]);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Registration failed. Please try again later.'
    ]);
}
?>

