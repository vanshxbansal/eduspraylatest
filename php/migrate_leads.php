<?php
/**
 * Migration: Create leads table for storing user inquiries
 */

require_once 'config.php';

try {
    $leadsTable = "CREATE TABLE IF NOT EXISTS leads (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(200),
        email VARCHAR(200),
        phone VARCHAR(20),
        course_slug VARCHAR(50),
        course_name VARCHAR(200),
        source VARCHAR(50) DEFAULT 'get_update',
        message TEXT,
        status ENUM('new', 'contacted', 'converted', 'closed') DEFAULT 'new',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_email (email),
        INDEX idx_phone (phone),
        INDEX idx_course (course_slug),
        INDEX idx_status (status),
        INDEX idx_created (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($leadsTable);
    echo "<div class='success'>✅ Table <code>leads</code> created successfully!</div>";
    
} catch (PDOException $e) {
    echo "<div class='error'>❌ Error: " . $e->getMessage() . "</div>";
}
?>




