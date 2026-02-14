<?php
/**
 * Database Migration Script - Featured Courses
 * 
 * RUN THIS ONCE after the initial setup
 * Then DELETE this file for security!
 * 
 * Access: http://localhost:8000/php/migrate_featured_courses.php
 */

require_once 'config.php';

echo "<html><head><title>Featured Courses Migration</title>";
echo "<style>
    body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; background: #1a1a2e; color: #eee; }
    .success { color: #10b981; background: rgba(16, 185, 129, 0.1); padding: 15px; border-radius: 8px; margin: 10px 0; border: 1px solid rgba(16, 185, 129, 0.3); }
    .error { color: #ef4444; background: rgba(239, 68, 68, 0.1); padding: 15px; border-radius: 8px; margin: 10px 0; border: 1px solid rgba(239, 68, 68, 0.3); }
    .warning { color: #f97316; background: rgba(249, 115, 22, 0.1); padding: 15px; border-radius: 8px; margin: 10px 0; border: 1px solid rgba(249, 115, 22, 0.3); }
    .info { color: #6366f1; background: rgba(99, 102, 241, 0.1); padding: 15px; border-radius: 8px; margin: 10px 0; border: 1px solid rgba(99, 102, 241, 0.3); }
    h1 { color: #6366f1; }
    h2 { color: #888; margin-top: 30px; font-size: 18px; }
    code { background: rgba(0,0,0,0.3); padding: 2px 6px; border-radius: 4px; }
</style></head><body>";
echo "<h1>📚 Featured Courses Migration</h1>";

try {
    // Create featured_courses table
    $featuredCoursesTable = "CREATE TABLE IF NOT EXISTS featured_courses (
        id INT AUTO_INCREMENT PRIMARY KEY,
        course_slug VARCHAR(50) NOT NULL,
        featured_course_slug VARCHAR(50) NOT NULL,
        display_order INT DEFAULT 0,
        status ENUM('active', 'inactive') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY unique_featured (course_slug, featured_course_slug),
        INDEX idx_course_slug (course_slug),
        INDEX idx_status (status),
        INDEX idx_display_order (display_order)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($featuredCoursesTable);
    echo "<div class='success'>✅ Table <code>featured_courses</code> created/verified successfully!</div>";
    
    // Seed sample data based on course relationships
    echo "<h2>Seeding Sample Featured Courses...</h2>";
    
    $featuredCoursesData = [
        // Engineering Courses (btech, engineering)
        ['btech', 'barch', 1],
        ['btech', 'bca', 2],
        ['btech', 'management', 3],
        ['btech', 'engineering', 4],
        ['engineering', 'btech', 1],
        ['engineering', 'barch', 2],
        ['engineering', 'bca', 3],
        ['engineering', 'management', 4],
        
        // Medical
        ['medical', 'btech', 1], // biotech
        ['medical', 'management', 2], // hospital management
        
        // Management (bba, management)
        ['bba', 'bcom', 1],
        ['bba', 'bbe', 2],
        ['bba', 'btech', 3], // tech management
        ['management', 'bba', 1],
        ['management', 'bcom', 2],
        ['management', 'bbe', 3],
        ['management', 'btech', 4],
        
        // Architecture (barch, architecture)
        ['barch', 'btech', 1],
        ['barch', 'engineering', 2],
        ['barch', 'management', 3],
        ['architecture', 'barch', 1],
        ['architecture', 'btech', 2],
        ['architecture', 'engineering', 3],
        
        // Commerce (bcom, commerce)
        ['bcom', 'bba', 1],
        ['bcom', 'management', 2],
        ['bcom', 'bbe', 3],
        ['commerce', 'bcom', 1],
        ['commerce', 'bba', 2],
        ['commerce', 'management', 3],
        
        // Computer Science (bca)
        ['bca', 'btech', 1],
        ['bca', 'engineering', 2],
        ['bca', 'management', 3],
        
        // Hotel Management (bhmct, hotel)
        ['bhmct', 'management', 1],
        ['bhmct', 'aviation', 2],
        ['bhmct', 'commerce', 3],
        ['hotel', 'bhmct', 1],
        ['hotel', 'management', 2],
        ['hotel', 'aviation', 3],
        
        // Journalism (bajmc, journalism)
        ['bajmc', 'humanities', 1],
        ['bajmc', 'management', 2],
        ['bajmc', 'commerce', 3],
        ['journalism', 'bajmc', 1],
        ['journalism', 'humanities', 2],
        ['journalism', 'management', 3],
        
        // Humanities
        ['humanities', 'journalism', 1],
        ['humanities', 'commerce', 2],
        ['humanities', 'management', 3],
        
        // BBE
        ['bbe', 'bba', 1],
        ['bbe', 'bcom', 2],
        ['bbe', 'management', 3],
        
        // BA-Eng
        ['baeng', 'humanities', 1],
        ['baeng', 'journalism', 2],
        ['baeng', 'commerce', 3],
        
        // Aviation
        ['aviation', 'hotel', 1],
        ['aviation', 'management', 2],
        ['aviation', 'btech', 3],
    ];
    
    $insertFeatured = $pdo->prepare("INSERT IGNORE INTO featured_courses (course_slug, featured_course_slug, display_order, status) VALUES (?, ?, ?, 'active')");
    
    $insertedCount = 0;
    foreach ($featuredCoursesData as $data) {
        $insertFeatured->execute($data);
        if ($insertFeatured->rowCount() > 0) {
            $insertedCount++;
        }
    }
    
    echo "<div class='info'>📝 Inserted $insertedCount featured course relationships (existing relationships were skipped)</div>";
    
    echo "<div class='success' style='margin-top: 30px;'>
        <strong>✅ Migration completed successfully!</strong><br><br>
        <strong>Table created:</strong><br>
        • featured_courses - Stores featured course relationships<br><br>
        <strong>Next steps:</strong><br>
        1. Go to <a href='../admin/courses.php' style='color: #6366f1;'>Admin → Courses</a> to manage featured courses<br>
        2. View a course page to see featured courses section<br>
        3. Delete this migration file for security!
    </div>";
    
    echo "<div class='warning'>
        <strong>⚠️ IMPORTANT:</strong> Delete this file after migration!<br>
        <code>Delete: /php/migrate_featured_courses.php</code>
    </div>";
    
} catch (PDOException $e) {
    echo "<div class='error'>❌ Error: " . $e->getMessage() . "</div>";
}

echo "</body></html>";
?>

