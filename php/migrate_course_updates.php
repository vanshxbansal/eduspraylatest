<?php
/**
 * Migration: Create course_updates table for managing "What's New" section
 */

require_once 'config.php';

try {
    $updatesTable = "CREATE TABLE IF NOT EXISTS course_updates (
        id INT AUTO_INCREMENT PRIMARY KEY,
        course_slug VARCHAR(50) DEFAULT 'all',
        title VARCHAR(500) NOT NULL,
        author VARCHAR(200) DEFAULT 'Eduspray Team',
        content TEXT,
        link VARCHAR(500),
        status ENUM('active', 'inactive') DEFAULT 'active',
        display_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_course (course_slug),
        INDEX idx_status (status),
        INDEX idx_order (display_order),
        INDEX idx_created (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($updatesTable);
    echo "<div class='success'>✅ Table <code>course_updates</code> created successfully!</div>";
    
    // Insert some sample updates
    $sampleUpdates = [
        ['all', 'JEE Main 2026 Registration Open', 'Eduspray Team', 'Registration for JEE Main 2026 Session 1 is now open.'],
        ['btech', 'New Engineering Colleges Added', 'Eduspray Team', 'We have added 50+ new engineering colleges to our database.'],
        ['all', 'B.Tech Admission Process 2026', 'Eduspray Team', 'Complete guide to B.Tech admission process for 2026.'],
    ];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO course_updates (course_slug, title, author, content, status) VALUES (?, ?, ?, ?, 'active')");
    foreach ($sampleUpdates as $update) {
        $stmt->execute($update);
    }
    
    echo "<div class='success'>✅ Sample updates inserted!</div>";
    
} catch (PDOException $e) {
    echo "<div class='error'>❌ Error: " . $e->getMessage() . "</div>";
}
?>




