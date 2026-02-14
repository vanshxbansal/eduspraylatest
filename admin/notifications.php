<?php
/**
 * Admin: Manage Notification Banner (Latest News and Notifications)
 * CRUD for items shown in the notification banner on home and course pages.
 */

session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require_once '../php/config.php';

$message = '';
$error = '';

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add') {
        $title = trim($_POST['title'] ?? '');
        $excerpt = trim($_POST['excerpt'] ?? '');
        $image_url = trim($_POST['image_url'] ?? '');
        $link_url = trim($_POST['link_url'] ?? '');
        $is_live = isset($_POST['is_live']) ? 1 : 0;
        $display_order = (int)($_POST['display_order'] ?? 0);
        $status = $_POST['status'] ?? 'active';
        $published_at = !empty($_POST['published_at']) ? $_POST['published_at'] : date('Y-m-d H:i:s');

        try {
            $stmt = $pdo->prepare("INSERT INTO notifications (title, excerpt, image_url, link_url, is_live, display_order, status, published_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $excerpt, $image_url, $link_url, $is_live, $display_order, $status, $published_at]);
            $message = "Notification added successfully!";
        } catch (PDOException $e) {
            $error = "Error adding: " . $e->getMessage();
        }
    } elseif ($_POST['action'] === 'update') {
        $id = (int)($_POST['notification_id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $excerpt = trim($_POST['excerpt'] ?? '');
        $image_url = trim($_POST['image_url'] ?? '');
        $link_url = trim($_POST['link_url'] ?? '');
        $is_live = isset($_POST['is_live']) ? 1 : 0;
        $display_order = (int)($_POST['display_order'] ?? 0);
        $status = $_POST['status'] ?? 'active';
        $published_at = !empty($_POST['published_at']) ? $_POST['published_at'] : date('Y-m-d H:i:s');

        try {
            $stmt = $pdo->prepare("UPDATE notifications SET title = ?, excerpt = ?, image_url = ?, link_url = ?, is_live = ?, display_order = ?, status = ?, published_at = ? WHERE id = ?");
            $stmt->execute([$title, $excerpt, $image_url, $link_url, $is_live, $display_order, $status, $published_at, $id]);
            $message = "Notification updated successfully!";
        } catch (PDOException $e) {
            $error = "Error updating: " . $e->getMessage();
        }
    } elseif ($_POST['action'] === 'delete') {
        $id = (int)($_POST['notification_id'] ?? 0);
        try {
            $stmt = $pdo->prepare("DELETE FROM notifications WHERE id = ?");
            $stmt->execute([$id]);
            $message = "Notification deleted successfully!";
        } catch (PDOException $e) {
            $error = "Error deleting: " . $e->getMessage();
        }
    } elseif ($_POST['action'] === 'toggle_status') {
        $id = (int)($_POST['notification_id'] ?? 0);
        $newStatus = $_POST['new_status'] ?? 'active';
        try {
            $stmt = $pdo->prepare("UPDATE notifications SET status = ? WHERE id = ?");
            $stmt->execute([$newStatus, $id]);
            $message = "Status updated successfully!";
        } catch (PDOException $e) {
            $error = "Error updating status: " . $e->getMessage();
        }
    } elseif ($_POST['action'] === 'save_view_all') {
        $view_all_link = trim($_POST['view_all_link'] ?? '#');
        if ($view_all_link === '') {
            $view_all_link = 'notifications.php';
        }
        try {
            $meta = json_encode(['view_all_link' => $view_all_link]);
            $stmt = $pdo->prepare("SELECT id FROM home_page_sections WHERE section_key = 'notification_banner_settings'");
            $stmt->execute();
            if ($stmt->fetch()) {
                $up = $pdo->prepare("UPDATE home_page_sections SET meta_data = ? WHERE section_key = 'notification_banner_settings'");
                $up->execute([$meta]);
            } else {
                $ins = $pdo->prepare("INSERT INTO home_page_sections (section_key, title, meta_data, display_order, status) VALUES ('notification_banner_settings', 'Notification Banner', ?, 0, 'active')");
                $ins->execute([$meta]);
            }
            $message = "View All link saved!";
        } catch (PDOException $e) {
            $error = "Error saving: " . $e->getMessage();
        }
    } elseif ($_POST['action'] === 'reorder_up' || $_POST['action'] === 'reorder_down') {
        $id = (int)($_POST['notification_id'] ?? 0);
        $dir = $_POST['action'] === 'reorder_up' ? -1 : 1;
        try {
            $stmt = $pdo->query("SELECT id, display_order FROM notifications ORDER BY display_order ASC, published_at DESC");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idx = null;
            foreach ($rows as $i => $r) {
                if ((int)$r['id'] === $id) { $idx = $i; break; }
            }
            if ($idx !== null) {
                $swapIdx = $idx + $dir;
                if ($swapIdx >= 0 && $swapIdx < count($rows)) {
                    $curOrder = (int)$rows[$idx]['display_order'];
                    $swapOrder = (int)$rows[$swapIdx]['display_order'];
                    $pdo->prepare("UPDATE notifications SET display_order = ? WHERE id = ?")->execute([$swapOrder, $id]);
                    $pdo->prepare("UPDATE notifications SET display_order = ? WHERE id = ?")->execute([$curOrder, (int)$rows[$swapIdx]['id']]);
                    $message = "Order updated!";
                }
            }
        } catch (PDOException $e) {
            $error = "Error reordering: " . $e->getMessage();
        }
    }
}

// Get View All link for banner
$view_all_link = 'notifications.php';
try {
    $stmt = $pdo->prepare("SELECT meta_data FROM home_page_sections WHERE section_key = 'notification_banner_settings' LIMIT 1");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row && !empty($row['meta_data'])) {
        $meta = json_decode($row['meta_data'], true);
        if (!empty($meta['view_all_link'])) {
            $view_all_link = $meta['view_all_link'];
        }
    }
} catch (PDOException $e) {
    // table may not exist
}

// Get all notifications
try {
    $stmt = $pdo->query("SELECT * FROM notifications ORDER BY display_order ASC, published_at DESC");
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
    $notifications = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Banner - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #0f0f23;
            color: #e0e0e0;
            padding: 20px;
        }
        .container { max-width: 1200px; margin: 0 auto; }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }
        .header h1 { font-size: 24px; color: white; }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            font-size: 14px;
        }
        .btn-secondary { background: rgba(255,255,255,0.1); color: white; }
        .btn-primary { background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; }
        .message { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .message.success { background: rgba(16, 185, 129, 0.2); color: #10b981; }
        .message.error { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
        .table-wrap {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            overflow: hidden;
        }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1); }
        th { background: rgba(255,255,255,0.05); font-weight: 600; color: white; font-size: 12px; text-transform: uppercase; }
        td { color: #e0e0e0; font-size: 14px; }
        .thumb { width: 50px; height: 36px; object-fit: cover; border-radius: 6px; background: #333; }
        .badge { padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; }
        .badge.active { background: rgba(16, 185, 129, 0.2); color: #10b981; }
        .badge.inactive { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
        .badge.live { background: rgba(234, 88, 12, 0.2); color: #ea580c; }
        .actions { display: flex; gap: 8px; flex-wrap: wrap; }
        .btn-sm {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .btn-edit { background: rgba(99, 102, 241, 0.2); color: #6366f1; }
        .btn-delete { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.7);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
        }
        .modal-overlay.show { display: flex; }
        .modal {
            background: #1a1a3e;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 35px;
            width: 100%;
            max-width: 560px;
            max-height: 90vh;
            overflow-y: auto;
        }
        .modal h3 { font-size: 20px; color: white; margin-bottom: 25px; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 6px; font-weight: 600; color: #e0e0e0; font-size: 13px; }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 8px;
            background: rgba(0,0,0,0.3);
            color: white;
            font-size: 14px;
        }
        .form-group textarea { min-height: 80px; resize: vertical; }
        .form-group .hint { font-size: 11px; color: #888; margin-top: 4px; }
        .form-row { display: flex; gap: 12px; }
        .form-row .form-group { flex: 1; }
        .checkbox-wrap { display: flex; align-items: center; gap: 8px; }
        .checkbox-wrap input { width: auto; }
        .modal-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 25px; }
        .modal-btn { padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; }
        .modal-btn.cancel { background: rgba(255,255,255,0.1); color: white; }
        .modal-btn.save { background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-bell"></i> Notification Banner (Latest News)</h1>
            <div>
                <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Dashboard</a>
                <button class="btn btn-primary" onclick="openAddModal()" style="margin-left: 10px;"><i class="fas fa-plus"></i> Add Notification</button>
            </div>
        </div>

        <?php if ($message): ?>
        <div class="message success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
        <div class="message error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="table-wrap" style="margin-bottom: 20px;">
            <div style="padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                <strong style="color: white;">Banner settings</strong>
                <form method="POST" style="display: flex; gap: 12px; align-items: flex-end; margin-top: 10px; flex-wrap: wrap;">
                    <input type="hidden" name="action" value="save_view_all">
                    <div class="form-group" style="margin: 0; flex: 1; min-width: 200px;">
                        <label style="margin-bottom: 4px;">"View All" link URL</label>
                        <input type="text" name="view_all_link" value="<?php echo htmlspecialchars($view_all_link); ?>" placeholder="notifications.php or full URL">
                    <p class="hint" style="margin-top:6px;">Use <code>notifications.php</code> for the "View All" page, or any full URL.</p>
                    </div>
                    <button type="submit" class="btn btn-primary" style="margin: 0;">Save View All link</button>
                </form>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Live</th>
                        <th>Order</th>
                        <th>Reorder</th>
                        <th>Published</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($notifications)): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px; color: #888;">
                            No notifications yet. These appear in the "Latest News and Notifications" banner on the home and course pages. Click "Add Notification" to create one.
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($notifications as $n): ?>
                    <tr>
                        <td>
                            <?php if (!empty($n['image_url'])): ?>
                            <img src="<?php echo htmlspecialchars($n['image_url']); ?>" alt="" class="thumb">
                            <?php else: ?>
                            <span style="color:#666">—</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?php echo htmlspecialchars($n['title']); ?></strong>
                            <?php if (!empty($n['link_url'])): ?>
                            <br><a href="<?php echo htmlspecialchars($n['link_url']); ?>" target="_blank" rel="noopener" style="color:#6366f1;font-size:12px;">Link</a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($n['is_live'])): ?>
                            <span class="badge live">Live</span>
                            <?php else: ?>
                            <span style="color:#666">—</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo (int)$n['display_order']; ?></td>
                        <td><?php echo $n['published_at'] ? date('M j, Y H:i', strtotime($n['published_at'])) : '—'; ?></td>
                        <td><span class="badge <?php echo $n['status']; ?>"><?php echo ucfirst($n['status']); ?></span></td>
                        <td>
                            <div class="actions" style="flex-wrap: nowrap;">
                                <form method="POST" style="display:inline;" title="Move up">
                                    <input type="hidden" name="action" value="reorder_up">
                                    <input type="hidden" name="notification_id" value="<?php echo (int)$n['id']; ?>">
                                    <button type="submit" class="btn-sm" style="background:rgba(255,255,255,0.1);color:#e0e0e0;padding:4px 8px;"><i class="fas fa-chevron-up"></i></button>
                                </form>
                                <form method="POST" style="display:inline;" title="Move down">
                                    <input type="hidden" name="action" value="reorder_down">
                                    <input type="hidden" name="notification_id" value="<?php echo (int)$n['id']; ?>">
                                    <button type="submit" class="btn-sm" style="background:rgba(255,255,255,0.1);color:#e0e0e0;padding:4px 8px;"><i class="fas fa-chevron-down"></i></button>
                                </form>
                                <button type="button" class="btn-sm btn-edit" onclick='openEditModal(<?php echo htmlspecialchars(json_encode($n)); ?>)'><i class="fas fa-edit"></i> Edit</button>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Toggle status?');">
                                    <input type="hidden" name="action" value="toggle_status">
                                    <input type="hidden" name="notification_id" value="<?php echo (int)$n['id']; ?>">
                                    <input type="hidden" name="new_status" value="<?php echo $n['status'] === 'active' ? 'inactive' : 'active'; ?>">
                                    <button type="submit" class="btn-sm" style="background:rgba(249,115,22,0.2);color:#f97316;"><i class="fas fa-<?php echo $n['status'] === 'active' ? 'eye-slash' : 'eye'; ?>"></i></button>
                                </form>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this notification?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="notification_id" value="<?php echo (int)$n['id']; ?>">
                                    <button type="submit" class="btn-sm btn-delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal-overlay" id="notificationModal">
        <div class="modal">
            <h3 id="modalTitle">Add Notification</h3>
            <form method="POST" id="notificationForm">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="notification_id" id="notificationId">

                <div class="form-group">
                    <label>Title *</label>
                    <input type="text" name="title" id="notifTitle" required placeholder="e.g. NEET 2026 LIVE: UG registration begins...">
                </div>
                <div class="form-group">
                    <label>Excerpt (optional)</label>
                    <textarea name="excerpt" id="notifExcerpt" placeholder="Short description"></textarea>
                </div>
                <div class="form-group">
                    <label>Image URL</label>
                    <input type="url" name="image_url" id="notifImageUrl" placeholder="https://...">
                    <p class="hint">Thumbnail shown in the banner card.</p>
                </div>
                <div class="form-group">
                    <label>Link URL</label>
                    <input type="url" name="link_url" id="notifLinkUrl" placeholder="https://...">
                    <p class="hint">Where the card links to when clicked.</p>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Display order</label>
                        <input type="number" name="display_order" id="notifOrder" value="0" min="0">
                    </div>
                    <div class="form-group">
                        <label>Published at</label>
                        <input type="datetime-local" name="published_at" id="notifPublished">
                    </div>
                </div>
                <div class="form-group">
                    <label class="checkbox-wrap">
                        <input type="checkbox" name="is_live" id="notifLive" value="1">
                        <span>Show "Live" badge</span>
                    </label>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="notifStatus">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="modal-actions">
                    <button type="button" class="modal-btn cancel" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="modal-btn save">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Add Notification';
            document.getElementById('formAction').value = 'add';
            document.getElementById('notificationForm').reset();
            document.getElementById('notificationId').value = '';
            var d = new Date();
            d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
            document.getElementById('notifPublished').value = d.toISOString().slice(0, 16);
            document.getElementById('notificationModal').classList.add('show');
        }
        function openEditModal(n) {
            document.getElementById('modalTitle').textContent = 'Edit Notification';
            document.getElementById('formAction').value = 'update';
            document.getElementById('notificationId').value = n.id;
            document.getElementById('notifTitle').value = n.title || '';
            document.getElementById('notifExcerpt').value = n.excerpt || '';
            document.getElementById('notifImageUrl').value = n.image_url || '';
            document.getElementById('notifLinkUrl').value = n.link_url || '';
            document.getElementById('notifOrder').value = n.display_order || 0;
            document.getElementById('notifLive').checked = n.is_live == 1;
            document.getElementById('notifStatus').value = n.status || 'active';
            var pub = n.published_at ? n.published_at.replace(' ', 'T').slice(0, 16) : '';
            document.getElementById('notifPublished').value = pub;
            document.getElementById('notificationModal').classList.add('show');
        }
        function closeModal() {
            document.getElementById('notificationModal').classList.remove('show');
        }
        document.getElementById('notificationModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
</body>
</html>
