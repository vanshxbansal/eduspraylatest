<?php
/**
 * Public API: Fetch active notifications for the Latest News and Notifications banner.
 * No authentication required (frontend only).
 */

header('Content-Type: application/json');
header('Cache-Control: public, max-age=60');

require_once __DIR__ . '/../config.php';

try {
    $stmt = $pdo->prepare("
        SELECT id, title, excerpt, image_url, link_url, is_live, published_at, display_order
        FROM notifications
        WHERE status = 'active'
        ORDER BY display_order ASC, published_at DESC
        LIMIT 20
    ");
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format dates for frontend
    foreach ($items as &$row) {
        if (!empty($row['published_at'])) {
            $row['published_at_formatted'] = date('F j, Y, g:i A T', strtotime($row['published_at']));
        }
    }

    $view_all_link = 'notifications.php';
    try {
        $st = $pdo->prepare("SELECT meta_data FROM home_page_sections WHERE section_key = 'notification_banner_settings' AND status = 'active' LIMIT 1");
        $st->execute();
        $row = $st->fetch(PDO::FETCH_ASSOC);
        if ($row && !empty($row['meta_data'])) {
            $meta = json_decode($row['meta_data'], true);
            if (!empty($meta['view_all_link'])) {
                $view_all_link = $meta['view_all_link'];
            }
        }
    } catch (PDOException $e) { /* ignore */ }

    echo json_encode(['success' => true, 'data' => $items, 'view_all_link' => $view_all_link]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to load notifications', 'data' => []]);
}
