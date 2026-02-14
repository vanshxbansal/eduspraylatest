<?php
/**
 * Admin Home Page Management
 * Manage home page sections content
 */

session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /admin/login.php');
    exit;
}

require_once '../php/config.php';

$message = '';
$error = '';

// Handle section update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sectionKey = $_POST['section_key'] ?? '';
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $imageUrl = $_POST['image_url'] ?? '';
    $displayOrder = intval($_POST['display_order'] ?? 0);
    $status = $_POST['status'] ?? 'active';
    
    // Handle meta_data for different sections
    $metaData = [];
    if ($sectionKey === 'hero') {
        $metaData = [
            'subtitle' => $_POST['meta_subtitle'] ?? '',
            'cta_primary' => $_POST['meta_cta_primary'] ?? '',
            'cta_primary_link' => $_POST['meta_cta_primary_link'] ?? '',
            'cta_secondary' => $_POST['meta_cta_secondary'] ?? '',
            'cta_secondary_link' => $_POST['meta_cta_secondary_link'] ?? ''
        ];
    } elseif ($sectionKey === 'features') {
        // Handle features items
        $items = [];
        if (isset($_POST['feature_icon']) && is_array($_POST['feature_icon'])) {
            foreach ($_POST['feature_icon'] as $index => $icon) {
                if (!empty($icon)) {
                    $items[] = [
                        'icon' => $icon,
                        'title' => $_POST['feature_title'][$index] ?? '',
                        'description' => $_POST['feature_description'][$index] ?? ''
                    ];
                }
            }
        }
        $metaData = ['items' => $items];
    } elseif ($sectionKey === 'stats') {
        // Handle stats items
        $items = [];
        if (isset($_POST['stat_number']) && is_array($_POST['stat_number'])) {
            foreach ($_POST['stat_number'] as $index => $number) {
                if (!empty($number)) {
                    $items[] = [
                        'number' => $number,
                        'label' => $_POST['stat_label'][$index] ?? ''
                    ];
                }
            }
        }
        $metaData = ['items' => $items];
    }
    
    try {
        $metaDataJson = json_encode($metaData);
        
        // Check if section exists
        $checkStmt = $pdo->prepare("SELECT id FROM home_page_sections WHERE section_key = ?");
        $checkStmt->execute([$sectionKey]);
        $exists = $checkStmt->fetch();
        
        if ($exists) {
            $stmt = $pdo->prepare("UPDATE home_page_sections SET title = ?, content = ?, image_url = ?, meta_data = ?, display_order = ?, status = ? WHERE section_key = ?");
            $stmt->execute([$title, $content, $imageUrl, $metaDataJson, $displayOrder, $status, $sectionKey]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO home_page_sections (section_key, title, content, image_url, meta_data, display_order, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$sectionKey, $title, $content, $imageUrl, $metaDataJson, $displayOrder, $status]);
        }
        
        $message = "Section updated successfully!";
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Get all sections
try {
    $stmt = $pdo->query("SELECT * FROM home_page_sections ORDER BY display_order ASC");
    $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Decode JSON fields
    foreach ($sections as &$section) {
        if (!empty($section['meta_data'])) {
            $section['meta_data'] = json_decode($section['meta_data'], true);
        }
    }
} catch (PDOException $e) {
    $sections = [];
    $error = "Error loading sections: " . $e->getMessage();
}

// Get section by key for editing
$editingSection = null;
if (isset($_GET['edit'])) {
    $editKey = $_GET['edit'];
    foreach ($sections as $section) {
        if ($section['section_key'] === $editKey) {
            $editingSection = $section;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page Management | Eduspray Admin</title>
    <link rel="shortcut icon" href="../images/02.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #0f0f23; color: #e0e0e0; min-height: 100vh; }
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background: linear-gradient(180deg, #1a1a3e 0%, #0f0f23 100%); border-right: 1px solid rgba(255,255,255,0.05); padding: 30px 0; position: fixed; height: 100vh; overflow-y: auto; }
        .logo { padding: 0 25px 30px; border-bottom: 1px solid rgba(255,255,255,0.05); margin-bottom: 25px; }
        .logo h1 { font-size: 22px; font-weight: 700; color: white; }
        .logo h1 span { color: #6366f1; }
        .nav-menu { list-style: none; }
        .nav-item a { display: flex; align-items: center; gap: 15px; padding: 14px 25px; color: #888; text-decoration: none; font-weight: 500; transition: all 0.3s ease; border-left: 3px solid transparent; }
        .nav-item a:hover, .nav-item a.active { color: white; background: rgba(99, 102, 241, 0.1); border-left-color: #6366f1; }
        .nav-item a i { width: 22px; font-size: 16px; }
        .nav-section { font-size: 11px; text-transform: uppercase; color: #555; padding: 20px 25px 10px; letter-spacing: 1px; }
        .main-content { flex: 1; margin-left: 260px; padding: 30px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h2 { font-size: 28px; font-weight: 700; color: white; }
        .card { background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%); border: 1px solid rgba(255,255,255,0.05); border-radius: 16px; padding: 25px; margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; color: #888; font-size: 13px; font-weight: 600; margin-bottom: 8px; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white; font-size: 14px; font-family: inherit; }
        .form-group input:focus, .form-group textarea:focus, .form-group select:focus { outline: none; border-color: #6366f1; background: rgba(99, 102, 241, 0.1); }
        .btn { padding: 12px 24px; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s; text-decoration: none; display: inline-block; }
        .btn-primary { background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 5px 20px rgba(99, 102, 241, 0.3); }
        .btn-secondary { background: rgba(255,255,255,0.1); color: white; }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-success { background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #10b981; }
        .alert-error { background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; }
        .section-list { display: grid; gap: 15px; }
        .section-item { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; padding: 20px; display: flex; justify-content: space-between; align-items: center; }
        .section-item h3 { color: white; font-size: 16px; margin-bottom: 5px; }
        .section-item p { color: #888; font-size: 12px; }
        .badge { padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; }
        .badge-active { background: rgba(16, 185, 129, 0.2); color: #10b981; }
        .badge-inactive { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
    </style>
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <div class="logo">
                <h1>Edu<span>spray</span></h1>
                <p style="font-size: 12px; color: #666; margin-top: 5px;">Admin Panel</p>
            </div>
            <ul class="nav-menu">
                <li class="nav-item"><a href="index.php"><i class="fas fa-chart-pie"></i> <span>Dashboard</span></a></li>
                <div class="nav-section">Content Management</div>
                <li class="nav-item"><a href="courses.php"><i class="fas fa-graduation-cap"></i> <span>Courses</span></a></li>
                <li class="nav-item"><a href="universities.php"><i class="fas fa-university"></i> <span>Universities</span></a></li>
                <li class="nav-item"><a href="home_page.php" class="active"><i class="fas fa-home"></i> <span>Home Page</span></a></li>
                <li class="nav-item"><a href="blogs.php"><i class="fas fa-blog"></i> <span>Blogs</span></a></li>
                <div class="nav-section">Quick Links</div>
                <li class="nav-item"><a href="../index.html" target="_blank"><i class="fas fa-external-link-alt"></i> <span>View Website</span></a></li>
                <li class="nav-item"><a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
            </ul>
        </aside>
        <main class="main-content">
            <div class="header">
                <h2>Home Page Management</h2>
            </div>
            
            <?php if ($message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($editingSection): ?>
            <div class="card">
                <h3 style="color: white; margin-bottom: 20px;">Edit Section: <?php echo htmlspecialchars($editingSection['section_key']); ?></h3>
                <form method="POST">
                    <input type="hidden" name="section_key" value="<?php echo htmlspecialchars($editingSection['section_key']); ?>">
                    
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="<?php echo htmlspecialchars($editingSection['title'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Content</label>
                        <textarea name="content" rows="4"><?php echo htmlspecialchars($editingSection['content'] ?? ''); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Image URL</label>
                        <input type="text" name="image_url" value="<?php echo htmlspecialchars($editingSection['image_url'] ?? ''); ?>" placeholder="images/example.jpg">
                    </div>
                    
                    <?php if ($editingSection['section_key'] === 'hero'): ?>
                    <div class="form-group">
                        <label>Subtitle</label>
                        <input type="text" name="meta_subtitle" value="<?php echo htmlspecialchars($editingSection['meta_data']['subtitle'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Primary CTA Text</label>
                        <input type="text" name="meta_cta_primary" value="<?php echo htmlspecialchars($editingSection['meta_data']['cta_primary'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label>Primary CTA Link</label>
                        <input type="text" name="meta_cta_primary_link" value="<?php echo htmlspecialchars($editingSection['meta_data']['cta_primary_link'] ?? ''); ?>">
                    </div>
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <label>Display Order</label>
                        <input type="number" name="display_order" value="<?php echo htmlspecialchars($editingSection['display_order'] ?? 0); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="active" <?php echo ($editingSection['status'] ?? 'active') === 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo ($editingSection['status'] ?? 'active') === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="home_page.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
            <?php else: ?>
            <div class="card">
                <h3 style="color: white; margin-bottom: 20px;">Home Page Sections</h3>
                <div class="section-list">
                    <?php foreach ($sections as $section): ?>
                    <div class="section-item">
                        <div>
                            <h3><?php echo htmlspecialchars($section['title'] ?? $section['section_key']); ?></h3>
                            <p>Key: <?php echo htmlspecialchars($section['section_key']); ?> | Order: <?php echo $section['display_order']; ?></p>
                        </div>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <span class="badge <?php echo ($section['status'] ?? 'active') === 'active' ? 'badge-active' : 'badge-inactive'; ?>">
                                <?php echo ucfirst($section['status'] ?? 'active'); ?>
                            </span>
                            <a href="?edit=<?php echo urlencode($section['section_key']); ?>" class="btn btn-secondary" style="padding: 8px 16px; font-size: 12px;">Edit</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>



