<?php
/**
 * Database Migration Script - Blogs
 * 
 * RUN THIS ONCE after the initial setup
 * Then DELETE this file for security!
 * 
 * Access: http://localhost:3000/php/migrate_blogs.php
 */

require_once 'config.php';

echo "<html><head><title>Blogs Migration</title>";
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
echo "<h1>📝 Blogs Migration</h1>";

try {
    // Create blogs table
    $blogsTable = "CREATE TABLE IF NOT EXISTS blogs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(500) NOT NULL,
        slug VARCHAR(500) NOT NULL UNIQUE,
        excerpt TEXT,
        content LONGTEXT,
        featured_image VARCHAR(500),
        author VARCHAR(200) DEFAULT 'Eduspray Team',
        category VARCHAR(100),
        tags VARCHAR(500),
        status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
        featured TINYINT(1) DEFAULT 0,
        views INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_slug (slug),
        INDEX idx_status (status),
        INDEX idx_featured (featured),
        INDEX idx_category (category),
        INDEX idx_created (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($blogsTable);
    echo "<div class='success'>✅ Table <code>blogs</code> created/verified successfully!</div>";
    
    // Seed initial blogs (from existing index.html)
    $blogs = [
        [
            'title' => 'Free Admission Guidance For All Courses And University in Delhi-NCR',
            'slug' => 'free-admission-guidance-all-courses-delhi-ncr',
            'excerpt' => 'Get free admission guidance for all courses and universities in Delhi-NCR. Expert counseling to help you choose the best college for your future. Contact us today!',
            'content' => '<p>Get free admission guidance for all courses and universities in Delhi-NCR. Expert counseling to help you choose the best college for your future. Our experienced counselors will guide you through the entire admission process, from selecting the right course to filling out applications. Contact us today!</p>',
            'featured_image' => 'images/Admission.jpg',
            'author' => 'Eduspray Team',
            'category' => 'Admission Guidance',
            'status' => 'published',
            'featured' => 1
        ],
        [
            'title' => 'Free Admission Guidance For B.Tech 2025',
            'slug' => 'free-admission-guidance-btech-2025',
            'excerpt' => 'Get free admission guidance for B.Tech 2025! Expert counseling for top colleges, eligibility, and application process. Contact us today!',
            'content' => '<p>Get free admission guidance for B.Tech 2025! Expert counseling for top colleges, eligibility, and application process. We help students navigate through JEE Main, state entrance exams, and direct admission processes. Contact us today!</p>',
            'featured_image' => 'images/B.TECH.jpg',
            'author' => 'Eduspray Team',
            'category' => 'B.Tech',
            'status' => 'published',
            'featured' => 1
        ],
        [
            'title' => 'Admission Guidance For IP University With - Eduspray India.',
            'slug' => 'admission-guidance-ip-university-eduspray',
            'excerpt' => 'Get expert admission guidance for IP University with Eduspray India. Secure your spot in top courses with hassle-free counseling. Contact us today!',
            'content' => '<p>Get expert admission guidance for IP University with Eduspray India. Secure your spot in top courses with hassle-free counseling. IP University offers various undergraduate and postgraduate programs. Our counselors will help you understand the admission process, eligibility criteria, and important dates. Contact us today!</p>',
            'featured_image' => 'images/12th.png',
            'author' => 'Eduspray Team',
            'category' => 'IP University',
            'status' => 'published',
            'featured' => 1
        ]
    ];
    
    $stmt = $pdo->prepare("INSERT INTO blogs (title, slug, excerpt, content, featured_image, author, category, status, featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE title = VALUES(title), excerpt = VALUES(excerpt), content = VALUES(content), featured_image = VALUES(featured_image), author = VALUES(author), category = VALUES(category), status = VALUES(status), featured = VALUES(featured)");
    
    $insertedCount = 0;
    foreach ($blogs as $blog) {
        $stmt->execute([
            $blog['title'],
            $blog['slug'],
            $blog['excerpt'],
            $blog['content'],
            $blog['featured_image'],
            $blog['author'],
            $blog['category'],
            $blog['status'],
            $blog['featured']
        ]);
        if ($stmt->rowCount() > 0) {
            $insertedCount++;
        }
    }
    
    echo "<div class='info'>📝 Inserted/Updated $insertedCount initial blog posts</div>";
    echo "<div class='success'>✅ Blogs migration completed successfully!</div>";
    
} catch (PDOException $e) {
    echo "<div class='error'>❌ Error: " . $e->getMessage() . "</div>";
}

echo "</body></html>";
?>



