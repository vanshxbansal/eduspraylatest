<?php
/**
 * Database Migration Script - College Cards
 * 
 * RUN THIS ONCE to create the college_cards table
 * Then DELETE this file for security!
 * 
 * Access: http://localhost:8000/php/migrate_college_cards.php
 */

require_once 'config.php';

echo "<html><head><title>College Cards Migration</title>";
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
echo "<h1>🏛️ College Cards Migration</h1>";

try {
    // Create college_cards table
    $collegeCardsTable = "CREATE TABLE IF NOT EXISTS college_cards (
        id INT AUTO_INCREMENT PRIMARY KEY,
        category VARCHAR(100) NOT NULL,
        title VARCHAR(200) NOT NULL,
        description TEXT,
        image_url VARCHAR(500),
        link_url VARCHAR(500) DEFAULT 'contact.html',
        rank_order INT DEFAULT 0,
        status ENUM('active', 'inactive') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_category (category),
        INDEX idx_status (status),
        INDEX idx_rank (rank_order)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($collegeCardsTable);
    echo "<div class='success'>✅ Table <code>college_cards</code> created successfully!</div>";
    
    // Check if table is empty
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM college_cards");
    $count = $stmt->fetch()['count'];
    
    if ($count == 0) {
        echo "<div class='info'>📝 Table is empty. You can now add cards through the admin panel.</div>";
        echo "<div class='warning'>
            <strong>⚠️ IMPORTANT:</strong> Delete this file now for security!<br>
            <code>Delete: /php/migrate_college_cards.php</code>
        </div>";
        echo "<p>Next steps:</p>";
        echo "<ul>
            <li><a href='../admin/college_cards.php' style='color: #6366f1;'>Go to Admin Panel</a> to add college cards</li>
            <li>Or use the migration script to import existing data</li>
        </ul>";
    } else {
        echo "<div class='success'>✅ Table already contains <strong>$count</strong> records.</div>";
    }
    
} catch (PDOException $e) {
    echo "<div class='error'>❌ Error: " . $e->getMessage() . "</div>";
}

echo "</body></html>";
?>

