<?php
/**
 * Reusable "What's New" section – same structure/CSS as course page.
 * Data from notifications table. Shown on all pages (home, course, blogs, etc.).
 *
 * Expects: $pdo available. Optional: $notification_banner_items (array), $notification_view_all_link (string).
 */
if (!isset($notification_banner_items) || !is_array($notification_banner_items)) {
    $notification_banner_items = [];
    if (!empty($pdo)) {
        try {
            $st = $pdo->query("SHOW TABLES LIKE 'notifications'");
            if ($st && $st->rowCount() > 0) {
                $st = $pdo->prepare("
                    SELECT id, title, excerpt, image_url, link_url, is_live, published_at, display_order
                    FROM notifications
                    WHERE status = 'active'
                    ORDER BY display_order ASC, published_at DESC
                    LIMIT 15
                ");
                $st->execute();
                $notification_banner_items = $st->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            $notification_banner_items = [];
        }
    }
}

if (!isset($notification_view_all_link) || $notification_view_all_link === '') {
    $notification_view_all_link = '#';
}
if ($notification_view_all_link === '#' && !empty($pdo)) {
    try {
        $st = $pdo->query("SHOW TABLES LIKE 'home_page_sections'");
        if ($st && $st->rowCount() > 0) {
            $st = $pdo->prepare("SELECT meta_data FROM home_page_sections WHERE section_key = 'notification_banner_settings' AND status = 'active' LIMIT 1");
            $st->execute();
            $row = $st->fetch(PDO::FETCH_ASSOC);
            if ($row && !empty($row['meta_data'])) {
                $meta = json_decode($row['meta_data'], true);
                if (!empty($meta['view_all_link'])) {
                    $notification_view_all_link = $meta['view_all_link'];
                }
            }
        }
    } catch (PDOException $e) { /* ignore */ }
}
$notification_banner_is_home = !empty($notification_banner_is_home);
$whats_new_items = $notification_banner_items;
$whats_new_duplicated = !empty($whats_new_items) ? array_merge($whats_new_items, $whats_new_items) : [];
?>
<!-- What's New – same component as course page, data from notifications -->
<div class="whats-new-section"<?php if ($notification_banner_is_home) echo ' style="top:0px;"'; ?>>
    <div class="container">
        <div class="whats-new-header">
            <h2>What's New</h2>
            <a href="<?php echo htmlspecialchars($notification_view_all_link !== '#' ? $notification_view_all_link : 'notifications.php'); ?>" class="whats-new-view-all">View All</a>
        </div>
        <div class="whats-new-ticker-wrapper" style="overflow: hidden;">
            <div class="whats-new-ticker">
                <?php if (empty($whats_new_duplicated)): ?>
                <div class="update-item">
                    <h3>No notifications at the moment. Check back later.</h3>
                </div>
                <?php else: ?>
                <?php foreach ($whats_new_duplicated as $item):
                    $title = $item['title'] ?? '';
                    $link_url = !empty($item['link_url']) ? $item['link_url'] : '#';
                    $pub = $item['published_at'] ?? '';
                    $date_str = $pub ? date('M d, Y', strtotime($pub)) : '';
                ?>
                <div class="update-item">
                    <h3><a href="<?php echo htmlspecialchars($link_url); ?>" target="_blank" rel="noopener"><?php echo htmlspecialchars($title); ?></a></h3>
                    <div class="update-meta">
                        <span class="update-author">Eduspray</span>
                        <?php if ($date_str): ?><span class="update-date"><?php echo htmlspecialchars($date_str); ?></span><?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<style>
/* What's New section – same as course page (notification data) */
.whats-new-section {
    background: white;
    padding: 15px 0;
    border-bottom: 1px solid #e5e7eb;
    overflow: hidden;
    position: relative;
}
.whats-new-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 10px;
    flex-wrap: wrap;
}
.whats-new-header h2 {
    font-size: 16px;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0;
    white-space: nowrap;
}
.whats-new-view-all {
    color: #0ea5e9;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
}
.whats-new-view-all:hover {
    text-decoration: underline;
}
.whats-new-ticker {
    display: flex;
    gap: 30px;
    animation: scrollTicker 30s linear infinite;
    width: max-content;
}
.whats-new-ticker:hover {
    animation-play-state: paused;
}
@keyframes scrollTicker {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.update-item {
    display: inline-flex;
    align-items: center;
    gap: 15px;
    padding: 8px 15px;
    background: #f8f9fa;
    border-radius: 6px;
    border-left: 3px solid #0ea5e9;
    white-space: nowrap;
    min-width: max-content;
}
.update-item h3 {
    font-size: 13px;
    font-weight: 600;
    color: #1a1a2e;
    margin: 0;
}
.update-item h3 a {
    color: #1a1a2e;
    text-decoration: none;
    transition: color 0.2s;
}
.update-item h3 a:hover {
    color: #0ea5e9;
}
.update-meta {
    font-size: 11px;
    color: #666;
    display: flex;
    gap: 10px;
    align-items: center;
}
.update-author { font-weight: 500; }
.update-date { color: #999; }
@media (max-width: 768px) {
    .whats-new-section { padding: 12px 0; }
    .whats-new-header { flex-direction: row; align-items: center; gap: 10px; }
    .whats-new-header h2 { font-size: 14px; }
    .whats-new-ticker { animation-duration: 20s; }
    .update-item { padding: 6px 12px; }
}
</style>
