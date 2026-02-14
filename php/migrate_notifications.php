<?php
/**
 * Database Migration - Notifications (Latest News and Notifications banner)
 *
 * RUN THIS ONCE to create the notifications table.
 * Then DELETE this file for security!
 *
 * Access: http://localhost:3010/php/migrate_notifications.php
 */

require_once 'config.php';

header('Content-Type: text/html; charset=utf-8');
echo "<!DOCTYPE html><html><head><title>Notifications Migration</title>";
echo "<style>body{font-family:Arial,sans-serif;max-width:600px;margin:50px auto;padding:20px;background:#1a1a2e;color:#eee;}
.success{color:#10b981;background:rgba(16,185,129,0.1);padding:15px;border-radius:8px;margin:10px 0;}
.error{color:#ef4444;background:rgba(239,68,68,0.1);padding:15px;border-radius:8px;margin:10px 0;}
h1{color:#6366f1;}</style></head><body>";
echo "<h1>Notifications table migration</h1>";

try {
    $sql = "CREATE TABLE IF NOT EXISTS notifications (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(500) NOT NULL,
        excerpt VARCHAR(1000) DEFAULT NULL,
        image_url VARCHAR(500) DEFAULT NULL,
        link_url VARCHAR(500) DEFAULT NULL,
        is_live TINYINT(1) DEFAULT 1,
        display_order INT DEFAULT 0,
        status ENUM('active','inactive') DEFAULT 'active',
        published_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_status (status),
        INDEX idx_order (display_order),
        INDEX idx_published (published_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $pdo->exec($sql);
    echo "<div class='success'>✅ Table <code>notifications</code> created successfully.</div>";

    // Seed sample notifications if table is empty
    $count = $pdo->query("SELECT COUNT(*) FROM notifications")->fetchColumn();
    if ((int)$count === 0) {
        $insert = $pdo->prepare("
            INSERT INTO notifications (title, excerpt, image_url, link_url, is_live, display_order, status, published_at) VALUES
            (?, ?, ?, ?, ?, ?, 'active', NOW()),
            (?, ?, ?, ?, ?, ?, 'active', NOW()),
            (?, ?, ?, ?, ?, ?, 'active', NOW())
        ");
        $insert->execute([
            'NEET 2026 LIVE: UG registration begins at neet.nta.nic.in; documents, exam schedule',
            'Latest updates on NEET UG registration and admit card.',
            'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400',
            'https://neet.nta.nic.in/',
            1, 0,
            'JEE Main 2026 Result LIVE: Session 1 final answer key soon at jeemain.nta.nic.in',
            'JEE Main Session 1 answer key and result updates.',
            'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=400',
            'https://jeemain.nta.nic.in/',
            1, 1,
            'CUET 2026: Application dates, syllabus and participating universities',
            'Central University entrance exam updates.',
            'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=400',
            '#',
            0, 2
        ]);
        echo "<div class='success'>✅ Seeded 3 sample notifications. They will appear in the banner.</div>";
    } else {
        echo "<div class='success'>ℹ️ Table already has $count notification(s). No seed needed.</div>";
    }

    // Optional: ensure notification_banner_settings exists in home_page_sections for "View All" link (table may not exist yet)
    try {
        $check = $pdo->prepare("SELECT id FROM home_page_sections WHERE section_key = ?");
        $check->execute(['notification_banner_settings']);
        if (!$check->fetch()) {
            $ins = $pdo->prepare("INSERT INTO home_page_sections (section_key, title, meta_data, display_order, status) VALUES (?, ?, ?, ?, ?)");
            $ins->execute(['notification_banner_settings', 'Notification Banner', json_encode(['view_all_link' => '#']), 0, 'active']);
            echo "<div class='success'>✅ Default notification banner settings added.</div>";
        }
    } catch (PDOException $e) {
        // home_page_sections might not exist; run migrate_home_page.php first if needed
    }
} catch (PDOException $e) {
    echo "<div class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</div>";
}
echo "</body></html>";
