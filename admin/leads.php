<?php
/**
 * Admin: User details / Leads – all contact form, newsletter, and get-update submissions in one place.
 */

session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require_once '../php/config.php';

$message = '';
$error = '';
$leads = [];

try {
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $sourceFilter = isset($_GET['source']) ? trim($_GET['source']) : '';
    $query = "SELECT * FROM leads WHERE 1=1";
    $params = [];
    if ($search !== '') {
        $query .= " AND (name LIKE ? OR email LIKE ? OR phone LIKE ? OR message LIKE ?)";
        $q = "%{$search}%";
        $params = array_merge($params, [$q, $q, $q, $q]);
    }
    if ($sourceFilter !== '') {
        $query .= " AND source = ?";
        $params[] = $sourceFilter;
    }
    $query .= " ORDER BY created_at DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $leads = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details / Leads | Eduspray Admin</title>
    <link rel="shortcut icon" href="../images/02.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #0f0f23; color: #e0e0e0; padding: 20px; }
        .container { max-width: 1400px; margin: 0 auto; }
        .header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px; }
        .header h1 { font-size: 22px; color: white; }
        .btn { padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; gap: 6px; border: none; cursor: pointer; }
        .btn-secondary { background: rgba(255,255,255,0.1); color: white; }
        .filters { display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap; align-items: center; }
        .filters input, .filters select { padding: 8px 12px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.3); color: white; }
        .message { padding: 12px; border-radius: 8px; margin-bottom: 16px; }
        .message.success { background: rgba(16,185,129,0.2); color: #10b981; }
        .message.error { background: rgba(239,68,68,0.2); color: #ef4444; }
        .table-wrap { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 14px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.08); }
        th { background: rgba(255,255,255,0.06); font-weight: 600; color: white; font-size: 11px; text-transform: uppercase; }
        td { font-size: 13px; color: #e0e0e0; }
        .badge { padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; }
        .badge.contact { background: rgba(99,102,241,0.2); color: #818cf8; }
        .badge.newsletter { background: rgba(16,185,129,0.2); color: #34d399; }
        .badge.get_update { background: rgba(249,115,22,0.2); color: #fb923c; }
        .badge.new { background: rgba(59,130,246,0.2); color: #60a5fa; }
        .badge.contacted { background: rgba(16,185,129,0.2); color: #34d399; }
        .message-cell { max-width: 280px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .message-cell:hover { white-space: normal; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-address-book"></i> User Details / Leads</h1>
            <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Dashboard</a>
        </div>
        <?php if ($message): ?><div class="message success"><?php echo htmlspecialchars($message); ?></div><?php endif; ?>
        <?php if ($error): ?><div class="message error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
        <div class="filters">
            <form method="GET" action="" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                <input type="text" name="search" placeholder="Search name, email, phone..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                <select name="source">
                    <option value="">All sources</option>
                    <option value="contact" <?php echo ($_GET['source'] ?? '') === 'contact' ? 'selected' : ''; ?>>Contact form</option>
                    <option value="newsletter" <?php echo ($_GET['source'] ?? '') === 'newsletter' ? 'selected' : ''; ?>>Newsletter</option>
                    <option value="get_update" <?php echo ($_GET['source'] ?? '') === 'get_update' ? 'selected' : ''; ?>>Get update (course)</option>
                </select>
                <button type="submit" class="btn btn-secondary">Filter</button>
            </form>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Source</th>
                        <th>Course</th>
                        <th>Message / Details</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($leads)): ?>
                    <tr><td colspan="8" style="text-align:center;padding:40px;color:#888;">No leads yet. All contact form, newsletter, and “Get update” submissions will appear here.</td></tr>
                    <?php else: ?>
                    <?php foreach ($leads as $l): ?>
                    <tr>
                        <td><?php echo date('M j, Y H:i', strtotime($l['created_at'])); ?></td>
                        <td><?php echo htmlspecialchars($l['name'] ?? '—'); ?></td>
                        <td><a href="mailto:<?php echo htmlspecialchars($l['email'] ?? ''); ?>" style="color:#60a5fa;"><?php echo htmlspecialchars($l['email'] ?? '—'); ?></a></td>
                        <td><?php echo htmlspecialchars($l['phone'] ?? '—'); ?></td>
                        <td><span class="badge <?php echo htmlspecialchars($l['source'] ?? ''); ?>"><?php echo htmlspecialchars($l['source'] ?? '—'); ?></span></td>
                        <td><?php echo htmlspecialchars($l['course_name'] ?? $l['course_slug'] ?? '—'); ?></td>
                        <td class="message-cell" title="<?php echo htmlspecialchars($l['message'] ?? ''); ?>"><?php echo htmlspecialchars($l['message'] ?? '—'); ?></td>
                        <td><span class="badge <?php echo $l['status']; ?>"><?php echo htmlspecialchars($l['status']); ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
