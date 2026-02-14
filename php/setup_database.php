<?php
/**
 * Database Setup Script
 * 
 * RUN THIS ONCE after creating the database in Hostinger
 * Then DELETE this file for security!
 * 
 * Access: https://eduspray.in/php/setup_database.php
 */

require_once 'config.php';

echo "<html><head><title>Database Setup</title>";
echo "<style>
    body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
    .success { color: green; background: #e8f5e9; padding: 15px; border-radius: 8px; margin: 10px 0; }
    .error { color: red; background: #ffebee; padding: 15px; border-radius: 8px; margin: 10px 0; }
    .warning { color: #ff9800; background: #fff3e0; padding: 15px; border-radius: 8px; margin: 10px 0; }
    h1 { color: #667eea; }
</style></head><body>";
echo "<h1>🔧 Eduspray Database Setup</h1>";

// Create users table (with Google auth support)
$usersTable = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    password VARCHAR(255) NULL,
    auth_provider ENUM('local', 'google') DEFAULT 'local',
    google_id VARCHAR(100) NULL,
    profile_picture VARCHAR(500) NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    email_verified TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    INDEX idx_email (email),
    INDEX idx_status (status),
    INDEX idx_google_id (google_id),
    INDEX idx_auth_provider (auth_provider)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

// Create sessions table (for persistent sessions)
$sessionsTable = "CREATE TABLE IF NOT EXISTS user_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    session_token VARCHAR(255) NOT NULL UNIQUE,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_token (session_token),
    INDEX idx_expires (expires_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

// Create inquiries table (for contact forms)
$inquiriesTable = "CREATE TABLE IF NOT EXISTS inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(200),
    message TEXT NOT NULL,
    status ENUM('new', 'read', 'replied', 'closed') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_status (status),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

// Create user activity table (for tracking and analytics)
$userActivityTable = "CREATE TABLE IF NOT EXISTS user_activity (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    session_id VARCHAR(100),
    activity_type ENUM('page_view', 'login', 'logout', 'register', 'click') DEFAULT 'page_view',
    page_url VARCHAR(500),
    page_title VARCHAR(200),
    referrer VARCHAR(500),
    ip_address VARCHAR(45),
    user_agent VARCHAR(500),
    device_type ENUM('desktop', 'mobile', 'tablet') DEFAULT 'desktop',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user (user_id),
    INDEX idx_type (activity_type),
    INDEX idx_created (created_at),
    INDEX idx_session (session_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

// Execute table creation
$tables = [
    'users' => $usersTable,
    'user_sessions' => $sessionsTable,
    'inquiries' => $inquiriesTable,
    'user_activity' => $userActivityTable
];

$allSuccess = true;

foreach ($tables as $tableName => $sql) {
    try {
        $pdo->exec($sql);
        echo "<div class='success'>✅ Table '<strong>$tableName</strong>' created successfully!</div>";
    } catch (PDOException $e) {
        echo "<div class='error'>❌ Error creating table '$tableName': " . $e->getMessage() . "</div>";
        $allSuccess = false;
    }
}

if ($allSuccess) {
    echo "<div class='warning'>
        <strong>⚠️ IMPORTANT:</strong> Delete this file now for security!<br>
        <code>Delete: /php/setup_database.php</code>
    </div>";
    echo "<p>Your database is ready! You can now:</p>";
    echo "<ul>
        <li><a href='../register.html'>Register a new account</a></li>
        <li><a href='../login.html'>Login to your account</a></li>
    </ul>";
}

echo "</body></html>";
?>

