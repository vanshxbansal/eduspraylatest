<?php
/**
 * Database Migration Script - Home Page Sections
 * 
 * RUN THIS ONCE after the initial setup
 * Then DELETE this file for security!
 * 
 * Access: http://localhost:3000/php/migrate_home_page.php
 */

require_once 'config.php';

echo "<html><head><title>Home Page Sections Migration</title>";
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
echo "<h1>🏠 Home Page Sections Migration</h1>";

try {
    // Create home_page_sections table
    $homePageTable = "CREATE TABLE IF NOT EXISTS home_page_sections (
        id INT AUTO_INCREMENT PRIMARY KEY,
        section_key VARCHAR(100) NOT NULL UNIQUE,
        title VARCHAR(500),
        content LONGTEXT,
        image_url VARCHAR(500),
        meta_data JSON,
        display_order INT DEFAULT 0,
        status ENUM('active', 'inactive') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_section_key (section_key),
        INDEX idx_status (status),
        INDEX idx_order (display_order)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($homePageTable);
    echo "<div class='success'>✅ Table <code>home_page_sections</code> created/verified successfully!</div>";
    
    // Seed initial sections
    $sections = [
        [
            'section_key' => 'hero',
            'title' => 'Educational Support Services For India And Overseas Studies',
            'content' => 'Best Educational Counsellor service for Bachelor\'s and Master\'s Degree',
            'image_url' => 'images/hero-image.jpg',
            'meta_data' => json_encode([
                'subtitle' => 'We are India\'s most trusted team of study in India and abroad Counsellors',
                'cta_primary' => 'Get Started',
                'cta_primary_link' => 'contact.html',
                'cta_secondary' => 'Learn More',
                'cta_secondary_link' => 'about.html'
            ]),
            'display_order' => 1
        ],
        [
            'section_key' => 'features',
            'title' => 'Why Choose Us',
            'content' => '',
            'image_url' => '',
            'meta_data' => json_encode([
                'items' => [
                    ['icon' => 'fas fa-graduation-cap', 'title' => 'Expert Guidance', 'description' => 'Professional counselors with years of experience'],
                    ['icon' => 'fas fa-university', 'title' => 'Top Colleges', 'description' => 'Access to best colleges and universities'],
                    ['icon' => 'fas fa-handshake', 'title' => 'Free Consultation', 'description' => 'Free counseling for all students'],
                    ['icon' => 'fas fa-clock', 'title' => '24/7 Support', 'description' => 'Round the clock assistance']
                ]
            ]),
            'display_order' => 2
        ],
        [
            'section_key' => 'stats',
            'title' => 'Our Achievements',
            'content' => '',
            'image_url' => '',
            'meta_data' => json_encode([
                'items' => [
                    ['number' => '10000+', 'label' => 'Students Helped'],
                    ['number' => '500+', 'label' => 'Colleges'],
                    ['number' => '50+', 'label' => 'Courses'],
                    ['number' => '98%', 'label' => 'Success Rate']
                ]
            ]),
            'display_order' => 3
        ],
        [
            'section_key' => 'testimonials_home',
            'title' => 'Our Testimonials',
            'content' => 'What our students say about us',
            'image_url' => '',
            'meta_data' => json_encode([
                'display_count' => 3,
                'view_all_link' => 'testimonials.php'
            ]),
            'display_order' => 4
        ],
        [
            'section_key' => 'blogs_home',
            'title' => 'Eduspray India Blog',
            'content' => 'Latest updates and guidance',
            'image_url' => '',
            'meta_data' => json_encode([
                'display_count' => 3,
                'view_all_link' => 'blogs.php'
            ]),
            'display_order' => 5
        ]
    ];
    
    $stmt = $pdo->prepare("INSERT INTO home_page_sections (section_key, title, content, image_url, meta_data, display_order, status) VALUES (?, ?, ?, ?, ?, ?, 'active') ON DUPLICATE KEY UPDATE title = VALUES(title), content = VALUES(content), image_url = VALUES(image_url), meta_data = VALUES(meta_data), display_order = VALUES(display_order)");
    
    $insertedCount = 0;
    foreach ($sections as $section) {
        $stmt->execute([
            $section['section_key'],
            $section['title'],
            $section['content'],
            $section['image_url'],
            $section['meta_data'],
            $section['display_order']
        ]);
        $insertedCount++;
    }
    
    echo "<div class='info'>📝 Inserted/Updated $insertedCount home page sections</div>";
    echo "<div class='success'>✅ Home page sections migration completed successfully!</div>";
    
} catch (PDOException $e) {
    echo "<div class='error'>❌ Error: " . $e->getMessage() . "</div>";
}

echo "</body></html>";
?>



