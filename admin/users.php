<?php
/**
 * Admin Users Management
 * View and edit all registered users
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

// Handle user update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'update') {
        $userId = (int)$_POST['user_id'];
        $name = trim($_POST['name']);
        $email = trim(strtolower($_POST['email']));
        $phone = trim($_POST['phone']);
        $status = $_POST['status'];
        $role = $_POST['role'];
        
        try {
            $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, phone = ?, status = ?, role = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
            $stmt->execute([$name, $email, $phone ?: null, $status, $role, $userId]);
            $message = "User updated successfully!";
        } catch (PDOException $e) {
            $error = "Error updating user: " . $e->getMessage();
        }
    } elseif ($_POST['action'] === 'delete') {
        $userId = (int)$_POST['user_id'];
        
        try {
            // Delete user activities first
            $stmt = $pdo->prepare("DELETE FROM user_activity WHERE user_id = ?");
            $stmt->execute([$userId]);
            
            // Delete user sessions
            $stmt = $pdo->prepare("DELETE FROM user_sessions WHERE user_id = ?");
            $stmt->execute([$userId]);
            
            // Delete user
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            
            $message = "User deleted successfully!";
        } catch (PDOException $e) {
            $error = "Error deleting user: " . $e->getMessage();
        }
    }
}

// Get all users
try {
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
    
    $query = "SELECT * FROM users WHERE 1=1";
    $params = [];
    
    if ($search) {
        $query .= " AND (name LIKE ? OR email LIKE ? OR phone LIKE ?)";
        $searchParam = "%$search%";
        $params = [$searchParam, $searchParam, $searchParam];
    }
    
    if ($filter === 'google') {
        $query .= " AND auth_provider = 'google'";
    } elseif ($filter === 'local') {
        $query .= " AND auth_provider = 'local'";
    } elseif ($filter === 'active') {
        $query .= " AND status = 'active'";
    } elseif ($filter === 'inactive') {
        $query .= " AND status != 'active'";
    }
    
    $query .= " ORDER BY created_at DESC";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $users = $stmt->fetchAll();
    
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
    $users = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users | Eduspray Admin</title>
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
            gap: 20px;
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
        
        /* Search & Filters */
        .toolbar {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }
        
        .search-box {
            flex: 1;
            min-width: 250px;
            position: relative;
        }
        
        .search-box input {
            width: 100%;
            padding: 14px 18px 14px 50px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            color: white;
            font-size: 14px;
            font-family: inherit;
        }
        
        .search-box input:focus {
            outline: none;
            border-color: #6366f1;
        }
        
        .search-box i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #555;
        }
        
        .filter-btn {
            padding: 14px 20px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            color: #888;
            font-size: 14px;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }
        
        .filter-btn:hover,
        .filter-btn.active {
            background: rgba(99, 102, 241, 0.1);
            border-color: #6366f1;
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
        
        /* Users Table */
        .users-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 16px;
            overflow: hidden;
        }
        
        .users-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .users-table th,
        .users-table td {
            padding: 16px 20px;
            text-align: left;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        
        .users-table th {
            color: #888;
            font-weight: 500;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: rgba(0,0,0,0.2);
        }
        
        .users-table td {
            color: #e0e0e0;
            font-size: 14px;
        }
        
        .users-table tr:hover {
            background: rgba(255,255,255,0.02);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            font-size: 14px;
        }
        
        .user-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .user-name {
            font-weight: 500;
            color: white;
        }
        
        .user-email {
            font-size: 12px;
            color: #888;
        }
        
        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
        }
        
        .badge.active { background: rgba(16, 185, 129, 0.2); color: #10b981; }
        .badge.inactive { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
        .badge.suspended { background: rgba(249, 115, 22, 0.2); color: #f97316; }
        .badge.google { background: rgba(66, 133, 244, 0.2); color: #4285f4; }
        .badge.local { background: rgba(99, 102, 241, 0.2); color: #6366f1; }
        .badge.admin { background: rgba(236, 72, 153, 0.2); color: #ec4899; }
        .badge.user { background: rgba(156, 163, 175, 0.2); color: #9ca3af; }
        
        .actions {
            display: flex;
            gap: 8px;
        }
        
        .action-btn {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        
        .action-btn.edit {
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
        }
        
        .action-btn.edit:hover {
            background: #6366f1;
            color: white;
        }
        
        .action-btn.delete {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }
        
        .action-btn.delete:hover {
            background: #ef4444;
            color: white;
        }
        
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
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
        
        .empty-state i {
            font-size: 50px;
            margin-bottom: 20px;
            opacity: 0.3;
        }
        
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .main-content { margin-left: 0; }
            .toolbar { flex-direction: column; }
            .search-box { min-width: 100%; }
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
                    <a href="users.php" class="active">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
                
                <div class="nav-section">Content Management</div>
                
                <li class="nav-item">
                    <a href="courses.php">
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
                <h2>Users Management</h2>
                <div class="header-right">
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
            
            <!-- Toolbar -->
            <div class="toolbar">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search users by name, email, or phone..." value="<?php echo htmlspecialchars($search ?? ''); ?>">
                </div>
                <a href="?filter=all" class="filter-btn <?php echo (!$filter || $filter === 'all') ? 'active' : ''; ?>">All</a>
                <a href="?filter=google" class="filter-btn <?php echo $filter === 'google' ? 'active' : ''; ?>">Google</a>
                <a href="?filter=local" class="filter-btn <?php echo $filter === 'local' ? 'active' : ''; ?>">Local</a>
                <a href="?filter=active" class="filter-btn <?php echo $filter === 'active' ? 'active' : ''; ?>">Active</a>
            </div>
            
            <!-- Users Table -->
            <div class="users-card">
                <?php if (empty($users)): ?>
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <p>No users found</p>
                </div>
                <?php else: ?>
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Phone</th>
                            <th>Provider</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">
                                        <?php if ($user['profile_picture']): ?>
                                        <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="">
                                        <?php else: ?>
                                        <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div class="user-name"><?php echo htmlspecialchars($user['name']); ?></div>
                                        <div class="user-email"><?php echo htmlspecialchars($user['email']); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($user['phone'] ?? '-'); ?></td>
                            <td><span class="badge <?php echo $user['auth_provider'] ?? 'local'; ?>"><?php echo ucfirst($user['auth_provider'] ?? 'local'); ?></span></td>
                            <td><span class="badge <?php echo $user['role']; ?>"><?php echo ucfirst($user['role']); ?></span></td>
                            <td><span class="badge <?php echo $user['status']; ?>"><?php echo ucfirst($user['status']); ?></span></td>
                            <td><?php echo date('M j, Y', strtotime($user['created_at'])); ?></td>
                            <td>
                                <div class="actions">
                                    <button class="action-btn edit" onclick="openEditModal(<?php echo htmlspecialchars(json_encode($user)); ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn delete" onclick="confirmDelete(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['name']); ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </main>
    </div>
    
    <!-- Edit Modal -->
    <div class="modal-overlay" id="editModal">
        <div class="modal">
            <h3><i class="fas fa-user-edit"></i> Edit User</h3>
            <form method="POST" id="editForm">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="user_id" id="editUserId">
                
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" id="editName" required>
                </div>
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="editEmail" required>
                </div>
                
                <div class="form-group">
                    <label>Phone</label>
                    <input type="tel" name="phone" id="editPhone">
                </div>
                
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" id="editRole">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="editStatus">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="suspended">Suspended</option>
                    </select>
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="modal-btn cancel" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="modal-btn save">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Delete Form (hidden) -->
    <form method="POST" id="deleteForm" style="display: none;">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="user_id" id="deleteUserId">
    </form>
    
    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const search = this.value.trim();
                const url = new URL(window.location.href);
                if (search) {
                    url.searchParams.set('search', search);
                } else {
                    url.searchParams.delete('search');
                }
                window.location.href = url.toString();
            }
        });
        
        // Open edit modal
        function openEditModal(user) {
            document.getElementById('editUserId').value = user.id;
            document.getElementById('editName').value = user.name;
            document.getElementById('editEmail').value = user.email;
            document.getElementById('editPhone').value = user.phone || '';
            document.getElementById('editRole').value = user.role;
            document.getElementById('editStatus').value = user.status;
            document.getElementById('editModal').classList.add('show');
        }
        
        // Close modal
        function closeModal() {
            document.getElementById('editModal').classList.remove('show');
        }
        
        // Close modal on overlay click
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
        
        // Confirm delete
        function confirmDelete(userId, userName) {
            if (confirm('Are you sure you want to delete user "' + userName + '"? This action cannot be undone.')) {
                document.getElementById('deleteUserId').value = userId;
                document.getElementById('deleteForm').submit();
            }
        }
        
        // ESC to close modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>
</html>

