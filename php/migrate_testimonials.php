<?php
/**
 * Database Migration Script - Testimonials
 * 
 * RUN THIS ONCE after the initial setup
 * Then DELETE this file for security!
 * 
 * Access: http://localhost:3000/php/migrate_testimonials.php
 */

require_once 'config.php';

echo "<html><head><title>Testimonials Migration</title>";
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
echo "<h1>💬 Testimonials Migration</h1>";

try {
    // Create testimonials table
    $testimonialsTable = "CREATE TABLE IF NOT EXISTS testimonials (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(200) NOT NULL,
        image VARCHAR(500),
        rating DECIMAL(2,1) DEFAULT 5.0,
        testimonial_text TEXT NOT NULL,
        course VARCHAR(100),
        designation VARCHAR(200),
        status ENUM('active', 'inactive') DEFAULT 'active',
        display_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_status (status),
        INDEX idx_order (display_order),
        INDEX idx_course (course)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($testimonialsTable);
    echo "<div class='success'>✅ Table <code>testimonials</code> created/verified successfully!</div>";
    
    // Seed initial testimonials (existing ones from index.html)
    $testimonials = [
        [
            'name' => 'Gurman Singh',
            'image' => 'images/gurman.jpg',
            'rating' => 4.5,
            'testimonial_text' => 'My Name Gurman Singh, My Counselor at Eduspray India Was Highly Professional and Made the Entire Colleges Selection Process Very Smooth. He Was Extremely Helpful. I Would Highly Recommend the Services of Eduspray India for Those Looking for Delhi-NCR University / IP University.',
            'course' => 'B.Tech',
            'designation' => 'Student',
            'display_order' => 1
        ],
        [
            'name' => 'Khushboo',
            'image' => 'images/client-06.png',
            'rating' => 5.0,
            'testimonial_text' => 'My Name Khushboo, Eduspray India is One of the Best Educational Consultancy, I visited them, to Seek Help to Pursue a Bachelor\'s in Delhi-NCR University. The Counselor Interacts With the Student Personally and Suggests the Best Colleges, Highly Recommend Them.',
            'course' => 'B.Tech',
            'designation' => 'Student',
            'display_order' => 2
        ],
        [
            'name' => 'Umma Khan',
            'image' => 'images/umma.jpg',
            'rating' => 4.0,
            'testimonial_text' => 'My Name Umma Khan, I Had a Good experience With Eduspray India, Special Thanks to My Counselor. His Counselling Was the Best And He Was Friendly With the Student, I Was Nicely Guided in Choosing Universities and Courses Was Hassle-free. I Highly Recommend Eduspray India.',
            'course' => 'B.Tech',
            'designation' => 'Student',
            'display_order' => 3
        ]
    ];
    
    $stmt = $pdo->prepare("INSERT INTO testimonials (name, image, rating, testimonial_text, course, designation, display_order, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'active') ON DUPLICATE KEY UPDATE name = VALUES(name), image = VALUES(image), rating = VALUES(rating), testimonial_text = VALUES(testimonial_text), course = VALUES(course), designation = VALUES(designation), display_order = VALUES(display_order)");
    
    $insertedCount = 0;
    foreach ($testimonials as $testimonial) {
        $stmt->execute([
            $testimonial['name'],
            $testimonial['image'],
            $testimonial['rating'],
            $testimonial['testimonial_text'],
            $testimonial['course'],
            $testimonial['designation'],
            $testimonial['display_order']
        ]);
        if ($stmt->rowCount() > 0) {
            $insertedCount++;
        }
    }
    
    echo "<div class='info'>📝 Inserted/Updated $insertedCount initial testimonials</div>";
    echo "<div class='warning'>⚠️ Note: Run the fetch_testimonials.php script to add more testimonials from external sources.</div>";
    echo "<div class='success'>✅ Testimonials migration completed successfully!</div>";
    
} catch (PDOException $e) {
    echo "<div class='error'>❌ Error: " . $e->getMessage() . "</div>";
}

echo "</body></html>";
?>



