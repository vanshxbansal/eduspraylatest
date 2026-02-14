<?php
/**
 * Database Configuration for Eduspray India
 * 
 * INSTRUCTIONS:
 * 1. Create database in Hostinger Panel -> Databases -> MySQL Databases
 * 2. Replace the values below with your actual credentials
 * 3. Hostinger adds a prefix to your database name and username (like u755359476_)
 */

// ============================================
// UPDATE THESE VALUES AFTER CREATING DATABASE
// ============================================
// MAMP MySQL runs on port 8889 (use 127.0.0.1:8889 or localhost:8889)
define('DB_HOST', '127.0.0.1:8889');
define('DB_NAME', 'u755359476_eduspray_db');    // Create this DB in MAMP phpMyAdmin if missing
define('DB_USER', 'root');
define('DB_PASS', 'root');   // MAMP default is often "root"; use '' if you changed it  

// ============================================
// DO NOT MODIFY BELOW THIS LINE
// ============================================

// Create PDO connection
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    // Don't expose error details in production
    http_response_code(500);
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Helper function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

// Helper function to get current user
function getCurrentUser() {
    if (isLoggedIn()) {
        return [
            'id' => $_SESSION['user_id'],
            'name' => $_SESSION['user_name'],
            'email' => $_SESSION['user_email']
        ];
    }
    return null;
}
?>








