<?php
/**
 * View All Notifications – public page linked from "View All" in the notification banner.
 */

require_once 'php/config.php';

$notifications = [];
$view_all_link = '#';

try {
    $stmt = $pdo->query("SHOW TABLES LIKE 'notifications'");
    if ($stmt && $stmt->rowCount() > 0) {
        $stmt = $pdo->prepare("
            SELECT id, title, excerpt, image_url, link_url, is_live, published_at, display_order
            FROM notifications
            WHERE status = 'active'
            ORDER BY display_order ASC, published_at DESC
        ");
        $stmt->execute();
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $stmt = $pdo->query("SHOW TABLES LIKE 'home_page_sections'");
    if ($stmt && $stmt->rowCount() > 0) {
        $stmt = $pdo->prepare("SELECT meta_data FROM home_page_sections WHERE section_key = 'notification_banner_settings' AND status = 'active' LIMIT 1");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && !empty($row['meta_data'])) {
            $meta = json_decode($row['meta_data'], true);
            if (!empty($meta['view_all_link'])) {
                $view_all_link = $meta['view_all_link'];
            }
        }
    }
} catch (PDOException $e) {
    $notifications = [];
}

$pageTitle = 'Latest News and Notifications | Eduspray India';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <meta name="description" content="Latest news and notifications from Eduspray India – exam updates, admission alerts, and education news.">
    <link rel="shortcut icon" type="image/x-icon" href="images/02.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/feather.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .notif-page { padding: 40px 0 60px; }
        .notif-page .page-title { margin-bottom: 28px; font-size: 26px; color: var(--color-heading); }
        .notif-page .notif-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px; }
        .notif-page .notif-card { display: flex; align-items: flex-start; gap: 14px; padding: 16px; background: var(--color-white); border-radius: var(--radius-10); border: 1px solid var(--color-border); box-shadow: var(--shadow-light); text-decoration: none; color: inherit; transition: box-shadow 0.2s; }
        .notif-page .notif-card:hover { box-shadow: var(--shadow-1); }
        .notif-page .notif-card-img { flex-shrink: 0; width: 100px; height: 68px; border-radius: var(--radius-small); overflow: hidden; background: var(--color-gray-lighter); }
        .notif-page .notif-card-img img { width: 100%; height: 100%; object-fit: cover; }
        .notif-page .notif-card-noimg { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--color-gray); font-size: 24px; }
        .notif-page .notif-live { position: absolute; top: 6px; left: 6px; background: #ea580c; color: #fff; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 4px; }
        .notif-page .notif-card-body { flex: 1; min-width: 0; }
        .notif-page .notif-card-title { font-size: 15px; font-weight: 600; color: var(--color-heading); margin: 0 0 6px 0; line-height: 1.4; }
        .notif-page .notif-card:hover .notif-card-title { color: var(--color-primary); }
        .notif-page .notif-card-date { font-size: 12px; color: var(--color-body); margin: 0; }
        .notif-page .notif-empty { text-align: center; color: var(--color-body); padding: 40px 20px; }
        .notif-page .back-link { display: inline-flex; align-items: center; gap: 8px; color: var(--color-primary); font-weight: 600; margin-bottom: 24px; text-decoration: none; }
        .notif-page .back-link:hover { color: var(--color-secondary); }
        .notif-page .notif-card-img-wrap { position: relative; }
    </style>
</head>
<body class="rbt-header-sticky">
    <div class="container notif-page">
        <a href="index.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Home</a>
        <h1 class="page-title">Latest News and Notifications</h1>
        <?php if (empty($notifications)): ?>
        <p class="notif-empty">No notifications at the moment. Check back later.</p>
        <?php else: ?>
        <div class="notif-grid">
            <?php foreach ($notifications as $item):
                $title = $item['title'] ?? '';
                $image_url = !empty($item['image_url']) ? $item['image_url'] : '';
                $link_url = !empty($item['link_url']) ? $item['link_url'] : '#';
                $is_live = isset($item['is_live']) && (int)$item['is_live'] === 1;
                $pub = $item['published_at'] ?? '';
                $date_str = $pub ? date('F j, Y, g:i A', strtotime($pub)) . ' IST' : '';
            ?>
            <a href="<?php echo htmlspecialchars($link_url); ?>" class="notif-card" target="_blank" rel="noopener">
                <div class="notif-card-img-wrap">
                    <div class="notif-card-img">
                        <?php if ($image_url): ?>
                        <img src="<?php echo htmlspecialchars($image_url); ?>" alt="" loading="lazy">
                        <?php if ($is_live): ?><span class="notif-live">Live</span><?php endif; ?>
                        <?php else: ?>
                        <span class="notif-card-noimg"><i class="fas fa-newspaper"></i></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="notif-card-body">
                    <h3 class="notif-card-title"><?php echo htmlspecialchars($title); ?></h3>
                    <?php if ($date_str): ?><p class="notif-card-date"><?php echo htmlspecialchars($date_str); ?></p><?php endif; ?>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
