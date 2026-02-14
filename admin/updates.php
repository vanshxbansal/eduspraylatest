<?php
/**
 * Admin: Manage Course Updates (What's New Section)
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
        $courseSlug = trim($_POST['course_slug']) ?: 'all';
        $title = trim($_POST['title']);
        $author = trim($_POST['author']) ?: 'Eduspray Team';
        $content = trim($_POST['content']);
        $link = trim($_POST['link']);
        $status = $_POST['status'] ?? 'active';
        
        try {
            $stmt = $pdo->prepare("INSERT INTO course_updates (course_slug, title, author, content, link, status, display_order) VALUES (?, ?, ?, ?, ?, ?, (SELECT COALESCE(MAX(display_order), 0) + 1 FROM course_updates u2))");
            $stmt->execute([$courseSlug, $title, $author, $content, $link, $status]);
            $message = "Update added successfully!";
        } catch (PDOException $e) {
            $error = "Error adding update: " . $e->getMessage();
        }
    } elseif ($_POST['action'] === 'update') {
        $id = (int)$_POST['update_id'];
        $courseSlug = trim($_POST['course_slug']) ?: 'all';
        $title = trim($_POST['title']);
        $author = trim($_POST['author']) ?: 'Eduspray Team';
        $content = trim($_POST['content']);
        $link = trim($_POST['link']);
        $status = $_POST['status'] ?? 'active';
        
        try {
            $stmt = $pdo->prepare("UPDATE course_updates SET course_slug = ?, title = ?, author = ?, content = ?, link = ?, status = ? WHERE id = ?");
            $stmt->execute([$courseSlug, $title, $author, $content, $link, $status, $id]);
            $message = "Update updated successfully!";
        } catch (PDOException $e) {
            $error = "Error updating: " . $e->getMessage();
        }
    } elseif ($_POST['action'] === 'delete') {
        $id = (int)$_POST['update_id'];
        try {
            $stmt = $pdo->prepare("DELETE FROM course_updates WHERE id = ?");
            $stmt->execute([$id]);
            $message = "Update deleted successfully!";
        } catch (PDOException $e) {
            $error = "Error deleting: " . $e->getMessage();
        }
    } elseif ($_POST['action'] === 'toggle_status') {
        $id = (int)$_POST['update_id'];
        $newStatus = $_POST['new_status'];
        try {
            $stmt = $pdo->prepare("UPDATE course_updates SET status = ? WHERE id = ?");
            $stmt->execute([$newStatus, $id]);
            $message = "Status updated successfully!";
        } catch (PDOException $e) {
            $error = "Error updating status: " . $e->getMessage();
        }
    }
}

// Get all updates
try {
    $stmt = $pdo->query("SELECT * FROM course_updates ORDER BY display_order ASC, created_at DESC");
    $updates = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
    $updates = [];
}

// Get all courses for dropdown
try {
    $stmt = $pdo->query("SELECT slug, name FROM courses WHERE status = 'active' ORDER BY name");
    $courses = $stmt->fetchAll();
} catch (PDOException $e) {
    $courses = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Updates - Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #0f0f23;
            color: #e0e0e0;
            padding: 20px;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 24px;
            color: white;
        }
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
        }
        .btn-secondary {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
        }
        .message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .message.success {
            background: rgba(16, 185, 129, 0.2);
            color: #10b981;
        }
        .message.error {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }
        .updates-table {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            overflow: hidden;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        th {
            background: rgba(255,255,255,0.05);
            font-weight: 600;
            color: white;
        }
        td {
            color: #e0e0e0;
        }
        .badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }
        .badge.active { background: rgba(16, 185, 129, 0.2); color: #10b981; }
        .badge.inactive { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
        .actions {
            display: flex;
            gap: 8px;
        }
        .btn-sm {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
        }
        .btn-edit {
            background: rgba(99, 102, 241, 0.2);
            color: #6366f1;
        }
        .btn-delete {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }
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
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
        }
        .modal h3 {
            font-size: 20px;
            color: white;
            margin-bottom: 25px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #e0e0e0;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 8px;
            background: rgba(0,0,0,0.3);
            color: white;
            font-family: inherit;
            font-size: 14px;
        }
        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }
        .modal-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 25px;
        }
        .modal-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }
        .modal-btn.cancel {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        .modal-btn.save {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Manage Course Updates (What's New)</h1>
            <div>
                <a href="courses.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Courses
                </a>
                <button class="btn btn-primary" onclick="openAddModal()" style="margin-left: 10px;">
                    <i class="fas fa-plus"></i> Add Update
                </button>
            </div>
        </div>
        
        <?php if ($message): ?>
        <div class="message success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
        <div class="message error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <div class="updates-table">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Course</th>
                        <th>Author</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($updates)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #888;">
                            No updates found. Click "Add Update" to create one.
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($updates as $update): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($update['title']); ?></strong></td>
                        <td><?php echo htmlspecialchars($update['course_slug'] === 'all' ? 'All Courses' : ucfirst($update['course_slug'])); ?></td>
                        <td><?php echo htmlspecialchars($update['author']); ?></td>
                        <td><?php echo date('M d, Y', strtotime($update['created_at'])); ?></td>
                        <td>
                            <span class="badge <?php echo $update['status']; ?>">
                                <?php echo ucfirst($update['status']); ?>
                            </span>
                        </td>
                        <td>
                            <div class="actions">
                                <button class="btn-sm btn-edit" onclick="openEditModal(<?php echo htmlspecialchars(json_encode($update)); ?>)">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?')">
                                    <input type="hidden" name="action" value="toggle_status">
                                    <input type="hidden" name="update_id" value="<?php echo $update['id']; ?>">
                                    <input type="hidden" name="new_status" value="<?php echo $update['status'] === 'active' ? 'inactive' : 'active'; ?>">
                                    <button type="submit" class="btn-sm" style="background: rgba(249, 115, 22, 0.2); color: #f97316;">
                                        <i class="fas fa-<?php echo $update['status'] === 'active' ? 'eye-slash' : 'eye'; ?>"></i>
                                    </button>
                                </form>
                                <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this update?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="update_id" value="<?php echo $update['id']; ?>">
                                    <button type="submit" class="btn-sm btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
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
    
    <!-- Add/Edit Modal -->
    <div class="modal-overlay" id="updateModal">
        <div class="modal">
            <h3 id="modalTitle">Add Update</h3>
            <form method="POST" id="updateForm">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="update_id" id="updateId">
                
                <div class="form-group">
                    <label>Course (or 'all' for all courses)</label>
                    <select name="course_slug" id="courseSlug">
                        <option value="all">All Courses</option>
                        <?php foreach ($courses as $course): ?>
                        <option value="<?php echo htmlspecialchars($course['slug']); ?>">
                            <?php echo htmlspecialchars($course['name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Title *</label>
                    <input type="text" name="title" id="updateTitle" required>
                </div>
                
                <div class="form-group">
                    <label>Author</label>
                    <input type="text" name="author" id="updateAuthor" value="Eduspray Team">
                </div>
                
                <div class="form-group">
                    <label>Content (optional)</label>
                    <textarea name="content" id="updateContent"></textarea>
                </div>
                
                <div class="form-group">
                    <label>Link (optional)</label>
                    <input type="url" name="link" id="updateLink">
                </div>
                
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="updateStatus">
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
            document.getElementById('modalTitle').textContent = 'Add Update';
            document.getElementById('formAction').value = 'add';
            document.getElementById('updateForm').reset();
            document.getElementById('updateId').value = '';
            document.getElementById('updateModal').classList.add('show');
        }
        
        function openEditModal(update) {
            document.getElementById('modalTitle').textContent = 'Edit Update';
            document.getElementById('formAction').value = 'update';
            document.getElementById('updateId').value = update.id;
            document.getElementById('courseSlug').value = update.course_slug || 'all';
            document.getElementById('updateTitle').value = update.title || '';
            document.getElementById('updateAuthor').value = update.author || 'Eduspray Team';
            document.getElementById('updateContent').value = update.content || '';
            document.getElementById('updateLink').value = update.link || '';
            document.getElementById('updateStatus').value = update.status || 'active';
            document.getElementById('updateModal').classList.add('show');
        }
        
        function closeModal() {
            document.getElementById('updateModal').classList.remove('show');
        }
        
        // Close modal on overlay click
        document.getElementById('updateModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>




