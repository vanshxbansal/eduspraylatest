<?php
/**
 * Admin Courses Management
 * Manage course listings and content
 */

session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /admin/login.php');
    exit;
}

// Include database config
require_once '../php/config.php';

$message = '';
$error = '';

// Handle course update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'update') {
        $courseId = (int)$_POST['course_id'];
        $name = trim($_POST['name']);
        $fullName = trim($_POST['full_name']);
        $duration = trim($_POST['duration']);
        $avgFees = trim($_POST['avg_fees']);
        $status = $_POST['status'];
        $displayOrder = (int)$_POST['display_order'];
        
        try {
            $stmt = $pdo->prepare("UPDATE courses SET name = ?, full_name = ?, duration = ?, avg_fees = ?, status = ?, display_order = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
            $stmt->execute([$name, $fullName, $duration, $avgFees, $status, $displayOrder, $courseId]);
            $message = "Course updated successfully!";
        } catch (PDOException $e) {
            $error = "Error updating course: " . $e->getMessage();
        }
    } elseif ($_POST['action'] === 'toggle_status') {
        $courseId = (int)$_POST['course_id'];
        $newStatus = $_POST['new_status'];
        
        try {
            $stmt = $pdo->prepare("UPDATE courses SET status = ? WHERE id = ?");
            $stmt->execute([$newStatus, $courseId]);
            $message = "Course status updated!";
        } catch (PDOException $e) {
            $error = "Error updating status: " . $e->getMessage();
        }
    } elseif ($_POST['action'] === 'add') {
        $slug = trim(strtolower($_POST['slug']));
        $name = trim($_POST['name']);
        $fullName = trim($_POST['full_name']);
        $icon = trim($_POST['icon']) ?: 'fas fa-graduation-cap';
        $duration = trim($_POST['duration']);
        $avgFees = trim($_POST['avg_fees']);
        
        try {
            $stmt = $pdo->prepare("INSERT INTO courses (slug, name, full_name, icon, duration, avg_fees, status, display_order) VALUES (?, ?, ?, ?, ?, ?, 'active', (SELECT COALESCE(MAX(display_order), 0) + 1 FROM courses c2))");
            $stmt->execute([$slug, $name, $fullName, $icon, $duration, $avgFees]);
            $message = "Course added successfully!";
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $error = "A course with this slug already exists!";
            } else {
                $error = "Error adding course: " . $e->getMessage();
            }
        }
    } elseif ($_POST['action'] === 'manage_featured_courses') {
        $courseSlug = trim($_POST['course_slug']);
        $featuredCourses = isset($_POST['featured_courses']) ? $_POST['featured_courses'] : [];
        $displayOrders = isset($_POST['display_orders']) ? $_POST['display_orders'] : [];
        
        try {
            // Start transaction
            $pdo->beginTransaction();
            
            // Delete all existing featured courses for this course
            $stmt = $pdo->prepare("DELETE FROM featured_courses WHERE course_slug = ?");
            $stmt->execute([$courseSlug]);
            
            // Insert new featured courses
            if (!empty($featuredCourses)) {
                $insertStmt = $pdo->prepare("INSERT INTO featured_courses (course_slug, featured_course_slug, display_order, status) VALUES (?, ?, ?, 'active')");
                foreach ($featuredCourses as $index => $featuredSlug) {
                    $displayOrder = isset($displayOrders[$featuredSlug]) ? (int)$displayOrders[$featuredSlug] : ($index + 1);
                    $insertStmt->execute([$courseSlug, $featuredSlug, $displayOrder]);
                }
            }
            
            $pdo->commit();
            $message = "Featured courses updated successfully!";
        } catch (PDOException $e) {
            $pdo->rollBack();
            $error = "Error updating featured courses: " . $e->getMessage();
        }
    }
}

// Get all courses
try {
    $stmt = $pdo->query("SELECT c.*, 
        (SELECT COUNT(*) FROM universities u WHERE JSON_CONTAINS(u.courses, CONCAT('\"', c.slug, '\"')) AND u.status = 'active') as university_count
        FROM courses c ORDER BY display_order ASC, name ASC");
    $courses = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
    $courses = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses | Eduspray Admin</title>
    <link rel="shortcut icon" href="../images/02.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #0f0f23;
            color: #e0e0e0;
            min-height: 100vh;
        }
        
        .layout {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #1a1a3e 0%, #0f0f23 100%);
            border-right: 1px solid rgba(255,255,255,0.05);
            padding: 30px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        
        .logo {
            padding: 0 25px 30px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            margin-bottom: 25px;
        }
        
        .logo h1 {
            font-size: 22px;
            font-weight: 700;
            color: white;
        }
        
        .logo h1 span {
            color: #6366f1;
        }
        
        .logo p {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        
        .nav-menu {
            list-style: none;
        }
        
        .nav-item a {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 14px 25px;
            color: #888;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        
        .nav-item a:hover,
        .nav-item a.active {
            color: white;
            background: rgba(99, 102, 241, 0.1);
            border-left-color: #6366f1;
        }
        
        .nav-item a i {
            width: 22px;
            font-size: 16px;
        }
        
        .nav-section {
            font-size: 11px;
            text-transform: uppercase;
            color: #555;
            padding: 20px 25px 10px;
            letter-spacing: 1px;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 30px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .header h2 {
            font-size: 28px;
            font-weight: 700;
            color: white;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .add-btn {
            padding: 12px 24px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }
        
        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
        }
        
        .logout-btn {
            padding: 10px 20px;
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            background: #ef4444;
            color: white;
        }
        
        /* Message */
        .message {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .message.success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: #10b981;
        }
        
        .message.error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }
        
        /* Courses Grid */
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
        }
        
        .course-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 16px;
            padding: 25px;
            transition: all 0.3s;
        }
        
        .course-card:hover {
            transform: translateY(-5px);
            border-color: rgba(99, 102, 241, 0.3);
        }
        
        .course-card.inactive {
            opacity: 0.5;
        }
        
        .course-header {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .course-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            flex-shrink: 0;
        }
        
        .course-info h3 {
            font-size: 18px;
            font-weight: 600;
            color: white;
            margin-bottom: 5px;
        }
        
        .course-info p {
            font-size: 13px;
            color: #888;
        }
        
        .course-meta {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 20px;
            padding: 15px;
            background: rgba(0,0,0,0.2);
            border-radius: 10px;
        }
        
        .meta-item {
            text-align: center;
        }
        
        .meta-item span {
            display: block;
            font-size: 11px;
            color: #666;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        
        .meta-item strong {
            font-size: 14px;
            color: #e0e0e0;
        }
        
        .course-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .course-actions button,
        .course-actions a {
            flex: 1;
            min-width: 80px;
            padding: 10px;
            border: none;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.3s;
        }
        
        .btn-edit {
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
        }
        
        .btn-edit:hover {
            background: #6366f1;
            color: white;
        }
        
        .btn-toggle {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }
        
        .btn-toggle.inactive {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }
        
        .btn-view {
            background: rgba(249, 115, 22, 0.1);
            color: #f97316;
        }
        
        .btn-view:hover {
            background: #f97316;
            color: white;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }
        
        .badge.active { background: rgba(16, 185, 129, 0.2); color: #10b981; }
        .badge.inactive { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
        
        /* Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.7);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            backdrop-filter: blur(5px);
        }
        
        .modal-overlay.show {
            display: flex;
        }
        
        .modal {
            background: #1a1a3e;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 35px;
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal h3 {
            font-size: 20px;
            color: white;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .modal .form-group {
            margin-bottom: 20px;
        }
        
        .modal label {
            display: block;
            color: #888;
            font-size: 13px;
            margin-bottom: 8px;
        }
        
        .modal input,
        .modal select {
            width: 100%;
            padding: 14px 16px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            color: white;
            font-size: 14px;
            font-family: inherit;
        }
        
        .modal input:focus,
        .modal select:focus {
            outline: none;
            border-color: #6366f1;
        }
        
        .modal select option {
            background: #1a1a3e;
        }
        
        .modal-actions {
            display: flex;
            gap: 12px;
            margin-top: 30px;
        }
        
        .modal-btn {
            flex: 1;
            padding: 14px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .modal-btn.cancel {
            background: rgba(255,255,255,0.05);
            color: #888;
        }
        
        .modal-btn.cancel:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        
        .modal-btn.save {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
        }
        
        .modal-btn.save:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
        }
        
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .main-content { margin-left: 0; }
            .courses-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <h1>Edu<span>spray</span></h1>
                <p>Admin Panel</p>
            </div>
            
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="index.php">
                        <i class="fas fa-chart-pie"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="users.php">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
                
                <div class="nav-section">Content Management</div>
                
                <li class="nav-item">
                    <a href="courses.php" class="active">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Courses</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="universities.php">
                        <i class="fas fa-university"></i>
                        <span>Universities</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="updates.php">
                        <i class="fas fa-bullhorn"></i>
                        <span>Updates (What's New)</span>
                    </a>
                </li>
                
                <div class="nav-section">Quick Links</div>
                
                <li class="nav-item">
                    <a href="../index.html" target="_blank">
                        <i class="fas fa-external-link-alt"></i>
                        <span>View Website</span>
                    </a>
                </li>
            </ul>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <h2>Courses Management</h2>
                <div class="header-right">
                    <button class="add-btn" onclick="openAddModal()">
                        <i class="fas fa-plus"></i> Add Course
                    </button>
                    <a href="/admin/logout.php" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
            
            <?php if ($message): ?>
            <div class="message success">
                <i class="fas fa-check-circle"></i>
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>
            
            <?php if ($error): ?>
            <div class="message error">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>
            
            <!-- Courses Grid -->
            <div class="courses-grid">
                <?php foreach ($courses as $course): ?>
                <div class="course-card <?php echo $course['status'] === 'inactive' ? 'inactive' : ''; ?>">
                    <div class="course-header">
                        <div class="course-icon">
                            <i class="<?php echo htmlspecialchars($course['icon'] ?? 'fas fa-graduation-cap'); ?>"></i>
                        </div>
                        <div class="course-info">
                            <h3><?php echo htmlspecialchars($course['name']); ?></h3>
                            <p><?php echo htmlspecialchars($course['full_name'] ?? ''); ?></p>
                        </div>
                        <span class="badge <?php echo $course['status']; ?>"><?php echo ucfirst($course['status']); ?></span>
                    </div>
                    
                    <div class="course-meta">
                        <div class="meta-item">
                            <span>Duration</span>
                            <strong><?php echo htmlspecialchars($course['duration'] ?? 'N/A'); ?></strong>
                        </div>
                        <div class="meta-item">
                            <span>Universities</span>
                            <strong><?php echo $course['university_count']; ?></strong>
                        </div>
                        <div class="meta-item">
                            <span>Order</span>
                            <strong>#<?php echo $course['display_order']; ?></strong>
                        </div>
                    </div>
                    
                    <div class="course-actions">
                        <button class="btn-edit" onclick="openEditModal(<?php echo htmlspecialchars(json_encode($course)); ?>)">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <a href="edit_course_content.php?slug=<?php echo urlencode($course['slug']); ?>" class="btn-edit" style="text-decoration: none; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-file-alt"></i> Content
                        </a>
                        <button class="btn-edit" onclick="openFeaturedCoursesModal('<?php echo htmlspecialchars($course['slug']); ?>', '<?php echo htmlspecialchars($course['name']); ?>')" style="flex: 1; min-width: 80px;">
                            <i class="fas fa-star"></i> Featured
                        </button>
                        <form method="POST" style="flex: 1; display: contents;">
                            <input type="hidden" name="action" value="toggle_status">
                            <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                            <input type="hidden" name="new_status" value="<?php echo $course['status'] === 'active' ? 'inactive' : 'active'; ?>">
                            <button type="submit" class="btn-toggle <?php echo $course['status'] === 'inactive' ? 'inactive' : ''; ?>">
                                <i class="fas fa-<?php echo $course['status'] === 'active' ? 'eye-slash' : 'eye'; ?>"></i>
                                <?php echo $course['status'] === 'active' ? 'Disable' : 'Enable'; ?>
                            </button>
                        </form>
                        <a href="../course.php?slug=<?php echo urlencode($course['slug']); ?>" target="_blank" class="btn-view" style="flex: 1; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 10px; border-radius: 8px;">
                            <i class="fas fa-external-link-alt"></i> View
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>
    
    <!-- Edit Modal -->
    <div class="modal-overlay" id="editModal">
        <div class="modal">
            <h3><i class="fas fa-edit"></i> Edit Course</h3>
            <form method="POST" id="editForm">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="course_id" id="editCourseId">
                
                <div class="form-group">
                    <label>Course Name</label>
                    <input type="text" name="name" id="editName" required>
                </div>
                
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" id="editFullName">
                </div>
                
                <div class="form-group">
                    <label>Duration</label>
                    <input type="text" name="duration" id="editDuration" placeholder="e.g., 4 Years">
                </div>
                
                <div class="form-group">
                    <label>Average Fees</label>
                    <input type="text" name="avg_fees" id="editAvgFees" placeholder="e.g., ₹1,00,000 - ₹4,00,000 per year">
                </div>
                
                <div class="form-group">
                    <label>Display Order</label>
                    <input type="number" name="display_order" id="editDisplayOrder" min="0">
                </div>
                
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="editStatus">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="modal-btn cancel" onclick="closeModal('editModal')">Cancel</button>
                    <button type="submit" class="modal-btn save">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Add Modal -->
    <div class="modal-overlay" id="addModal">
        <div class="modal">
            <h3><i class="fas fa-plus"></i> Add New Course</h3>
            <form method="POST">
                <input type="hidden" name="action" value="add">
                
                <div class="form-group">
                    <label>Slug (URL-friendly, lowercase)</label>
                    <input type="text" name="slug" required pattern="[a-z0-9-]+" placeholder="e.g., mtech">
                </div>
                
                <div class="form-group">
                    <label>Course Name</label>
                    <input type="text" name="name" required placeholder="e.g., M.Tech">
                </div>
                
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" placeholder="e.g., Master of Technology">
                </div>
                
                <div class="form-group">
                    <label>Icon (FontAwesome class)</label>
                    <input type="text" name="icon" placeholder="e.g., fas fa-microchip">
                </div>
                
                <div class="form-group">
                    <label>Duration</label>
                    <input type="text" name="duration" placeholder="e.g., 2 Years">
                </div>
                
                <div class="form-group">
                    <label>Average Fees</label>
                    <input type="text" name="avg_fees" placeholder="e.g., ₹1,00,000 - ₹2,00,000 per year">
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="modal-btn cancel" onclick="closeModal('addModal')">Cancel</button>
                    <button type="submit" class="modal-btn save">Add Course</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Featured Courses Modal -->
    <div class="modal-overlay" id="featuredCoursesModal">
        <div class="modal" style="max-width: 700px;">
            <h3><i class="fas fa-star"></i> Manage Featured Courses - <span id="featuredCourseName"></span></h3>
            <form method="POST" id="featuredCoursesForm">
                <input type="hidden" name="action" value="manage_featured_courses">
                <input type="hidden" name="course_slug" id="featuredCourseSlug">
                
                <div class="form-group">
                    <label>Select courses to feature on this course page:</label>
                    <div id="featuredCoursesList" style="max-height: 400px; overflow-y: auto; background: rgba(255,255,255,0.03); padding: 15px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.1);">
                        <!-- Courses will be loaded here -->
                    </div>
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="modal-btn cancel" onclick="closeModal('featuredCoursesModal')">Cancel</button>
                    <button type="submit" class="modal-btn save">Save Featured Courses</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function openEditModal(course) {
            document.getElementById('editCourseId').value = course.id;
            document.getElementById('editName').value = course.name;
            document.getElementById('editFullName').value = course.full_name || '';
            document.getElementById('editDuration').value = course.duration || '';
            document.getElementById('editAvgFees').value = course.avg_fees || '';
            document.getElementById('editDisplayOrder').value = course.display_order || 0;
            document.getElementById('editStatus').value = course.status;
            document.getElementById('editModal').classList.add('show');
        }
        
        function openAddModal() {
            document.getElementById('addModal').classList.add('show');
        }
        
        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
        }
        
        // Featured Courses Management
        const allCourses = <?php echo json_encode($courses); ?>;
        
        async function openFeaturedCoursesModal(courseSlug, courseName) {
            document.getElementById('featuredCourseSlug').value = courseSlug;
            document.getElementById('featuredCourseName').textContent = courseName;
            
            // Fetch current featured courses
            try {
                const response = await fetch(`get_featured_courses.php?course_slug=${encodeURIComponent(courseSlug)}`);
                const data = await response.json();
                const featuredCourses = data.featured_courses || [];
                const featuredSlugs = featuredCourses.map(fc => fc.slug);
                
                // Build the courses list
                const listContainer = document.getElementById('featuredCoursesList');
                listContainer.innerHTML = '';
                
                allCourses.forEach(course => {
                    if (course.slug === courseSlug) return; // Skip current course
                    
                    const isFeatured = featuredSlugs.includes(course.slug);
                    const featuredCourse = featuredCourses.find(fc => fc.slug === course.slug);
                    const displayOrder = featuredCourse ? featuredCourse.display_order : '';
                    
                    const courseItem = document.createElement('div');
                    courseItem.style.cssText = 'display: flex; align-items: center; gap: 15px; padding: 12px; margin-bottom: 8px; background: rgba(255,255,255,0.02); border-radius: 8px; border: 1px solid rgba(255,255,255,0.05);';
                    
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = 'featured_courses[]';
                    checkbox.value = course.slug;
                    checkbox.checked = isFeatured;
                    checkbox.id = `featured_${course.slug}`;
                    checkbox.style.cssText = 'width: 18px; height: 18px; cursor: pointer;';
                    
                    const label = document.createElement('label');
                    label.htmlFor = `featured_${course.slug}`;
                    label.style.cssText = 'flex: 1; color: #e0e0e0; cursor: pointer; display: flex; align-items: center; gap: 10px;';
                    label.innerHTML = `<i class="${course.icon || 'fas fa-graduation-cap'}" style="color: #6366f1;"></i> <span>${course.name}</span>`;
                    
                    const checkboxWrapper = document.createElement('div');
                    checkboxWrapper.style.cssText = 'display: flex; align-items: center; gap: 10px;';
                    checkboxWrapper.appendChild(checkbox);
                    checkboxWrapper.appendChild(label);
                    
                    const orderInput = document.createElement('input');
                    orderInput.type = 'number';
                    orderInput.name = `display_orders[${course.slug}]`;
                    orderInput.value = displayOrder || '';
                    orderInput.placeholder = 'Order';
                    orderInput.min = '1';
                    orderInput.style.cssText = 'width: 80px; padding: 6px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; color: white;';
                    orderInput.disabled = !isFeatured;
                    
                    checkbox.addEventListener('change', function() {
                        orderInput.disabled = !this.checked;
                        if (!this.checked) orderInput.value = '';
                    });
                    
                    courseItem.appendChild(checkboxWrapper);
                    courseItem.appendChild(orderInput);
                    listContainer.appendChild(courseItem);
                });
                
                document.getElementById('featuredCoursesModal').classList.add('show');
            } catch (error) {
                console.error('Error loading featured courses:', error);
                alert('Error loading featured courses. Please try again.');
            }
        }
        
        // Close modal on overlay click
        document.querySelectorAll('.modal-overlay').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('show');
                }
            });
        });
        
        // ESC to close modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('show'));
            }
        });
    </script>
</body>
</html>



