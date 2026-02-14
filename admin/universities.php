<?php
/**
 * Admin Universities Management
 * Full CRUD for universities/colleges
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

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add') {
        $name = trim($_POST['name']);
        $shortName = trim($_POST['short_name']);
        $slug = trim(strtolower(preg_replace('/[^a-z0-9]+/', '-', strtolower($_POST['slug'] ?: $name))));
        $type = $_POST['type'];
        $affiliation = trim($_POST['affiliation']);
        $city = trim($_POST['city']);
        $state = trim($_POST['state']);
        $establishedYear = (int)$_POST['established_year'] ?: null;
        $ranking = trim($_POST['ranking']);
        $feesMin = (int)$_POST['fees_min'] ?: null;
        $feesMax = (int)$_POST['fees_max'] ?: null;
        $courses = isset($_POST['courses']) ? json_encode($_POST['courses']) : '[]';
        $description = trim($_POST['description']);
        $website = trim($_POST['website']);
        $featured = isset($_POST['featured']) ? 1 : 0;
        
        try {
            $stmt = $pdo->prepare("INSERT INTO universities (name, short_name, slug, type, affiliation, city, state, established_year, ranking, fees_min, fees_max, courses, description, website, featured, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active')");
            $stmt->execute([$name, $shortName, $slug, $type, $affiliation, $city, $state, $establishedYear, $ranking, $feesMin, $feesMax, $courses, $description, $website, $featured]);
            $message = "University added successfully!";
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $error = "A university with this slug already exists!";
            } else {
                $error = "Error adding university: " . $e->getMessage();
            }
        }
    } elseif ($_POST['action'] === 'update') {
        $id = (int)$_POST['university_id'];
        $name = trim($_POST['name']);
        $shortName = trim($_POST['short_name']);
        $type = $_POST['type'];
        $affiliation = trim($_POST['affiliation']);
        $city = trim($_POST['city']);
        $state = trim($_POST['state']);
        $establishedYear = (int)$_POST['established_year'] ?: null;
        $ranking = trim($_POST['ranking']);
        $feesMin = (int)$_POST['fees_min'] ?: null;
        $feesMax = (int)$_POST['fees_max'] ?: null;
        $courses = isset($_POST['courses']) ? json_encode($_POST['courses']) : '[]';
        $description = trim($_POST['description']);
        $website = trim($_POST['website']);
        $featured = isset($_POST['featured']) ? 1 : 0;
        $status = $_POST['status'];
        
        try {
            $stmt = $pdo->prepare("UPDATE universities SET name = ?, short_name = ?, type = ?, affiliation = ?, city = ?, state = ?, established_year = ?, ranking = ?, fees_min = ?, fees_max = ?, courses = ?, description = ?, website = ?, featured = ?, status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
            $stmt->execute([$name, $shortName, $type, $affiliation, $city, $state, $establishedYear, $ranking, $feesMin, $feesMax, $courses, $description, $website, $featured, $status, $id]);
            $message = "University updated successfully!";
        } catch (PDOException $e) {
            $error = "Error updating university: " . $e->getMessage();
        }
    } elseif ($_POST['action'] === 'delete') {
        $id = (int)$_POST['university_id'];
        
        try {
            $stmt = $pdo->prepare("DELETE FROM universities WHERE id = ?");
            $stmt->execute([$id]);
            $message = "University deleted successfully!";
        } catch (PDOException $e) {
            $error = "Error deleting university: " . $e->getMessage();
        }
    }
}

// Get filters
$filterCourse = isset($_GET['course']) ? $_GET['course'] : '';
$filterState = isset($_GET['state']) ? $_GET['state'] : '';
$filterType = isset($_GET['type']) ? $_GET['type'] : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build query
$query = "SELECT * FROM universities WHERE 1=1";
$params = [];

if ($filterCourse) {
    $query .= " AND JSON_CONTAINS(courses, ?)";
    $params[] = json_encode($filterCourse);
}

if ($filterState) {
    $query .= " AND state = ?";
    $params[] = $filterState;
}

if ($filterType) {
    $query .= " AND type = ?";
    $params[] = $filterType;
}

if ($search) {
    $query .= " AND (name LIKE ? OR short_name LIKE ? OR city LIKE ?)";
    $searchParam = "%$search%";
    $params[] = $searchParam;
    $params[] = $searchParam;
    $params[] = $searchParam;
}

$query .= " ORDER BY featured DESC, name ASC";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $universities = $stmt->fetchAll();
    
    // Get all courses for the dropdown
    $coursesStmt = $pdo->query("SELECT slug, name FROM courses WHERE status = 'active' ORDER BY display_order ASC");
    $allCourses = $coursesStmt->fetchAll();
    
    // Get distinct states
    $statesStmt = $pdo->query("SELECT DISTINCT state FROM universities WHERE state IS NOT NULL AND state != '' ORDER BY state");
    $allStates = $statesStmt->fetchAll(PDO::FETCH_COLUMN);
    
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
    $universities = [];
    $allCourses = [];
    $allStates = [];
}

$types = ['government', 'private', 'deemed', 'autonomous'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universities | Eduspray Admin</title>
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
        
        /* Toolbar */
        .toolbar {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
            padding: 20px;
            background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 16px;
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
        
        .filter-select {
            padding: 14px 20px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            color: white;
            font-size: 14px;
            font-family: inherit;
            cursor: pointer;
            min-width: 150px;
        }
        
        .filter-select option {
            background: #1a1a3e;
        }
        
        /* Table */
        .table-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 16px;
            overflow: hidden;
        }
        
        .uni-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .uni-table th,
        .uni-table td {
            padding: 16px 20px;
            text-align: left;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        
        .uni-table th {
            color: #888;
            font-weight: 500;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: rgba(0,0,0,0.2);
        }
        
        .uni-table td {
            color: #e0e0e0;
            font-size: 14px;
        }
        
        .uni-table tr:hover {
            background: rgba(255,255,255,0.02);
        }
        
        .uni-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .uni-logo {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            font-size: 14px;
            flex-shrink: 0;
        }
        
        .uni-name {
            font-weight: 500;
            color: white;
        }
        
        .uni-location {
            font-size: 12px;
            color: #888;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
        }
        
        .badge.government { background: rgba(16, 185, 129, 0.2); color: #10b981; }
        .badge.private { background: rgba(99, 102, 241, 0.2); color: #6366f1; }
        .badge.deemed { background: rgba(249, 115, 22, 0.2); color: #f97316; }
        .badge.autonomous { background: rgba(236, 72, 153, 0.2); color: #ec4899; }
        .badge.active { background: rgba(16, 185, 129, 0.2); color: #10b981; }
        .badge.inactive { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
        .badge.featured { background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; }
        
        .course-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }
        
        .course-tag {
            padding: 3px 8px;
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 500;
        }
        
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
            max-width: 700px;
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
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        
        .modal label {
            display: block;
            color: #888;
            font-size: 13px;
            margin-bottom: 8px;
        }
        
        .modal input,
        .modal select,
        .modal textarea {
            width: 100%;
            padding: 14px 16px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            color: white;
            font-size: 14px;
            font-family: inherit;
        }
        
        .modal textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .modal input:focus,
        .modal select:focus,
        .modal textarea:focus {
            outline: none;
            border-color: #6366f1;
        }
        
        .modal select option {
            background: #1a1a3e;
        }
        
        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 8px;
        }
        
        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .checkbox-label:hover {
            border-color: #6366f1;
        }
        
        .checkbox-label input[type="checkbox"]:checked + span {
            color: #6366f1;
        }
        
        .toggle-label {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }
        
        .toggle-label input[type="checkbox"] {
            width: 20px;
            height: 20px;
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
            .toolbar { flex-direction: column; }
            .form-row { grid-template-columns: 1fr; }
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
                    <a href="courses.php">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Courses</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="universities.php" class="active">
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
                <h2>Universities Management</h2>
                <div class="header-right">
                    <button class="add-btn" onclick="openAddModal()">
                        <i class="fas fa-plus"></i> Add University
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
            
            <!-- Toolbar -->
            <div class="toolbar">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search universities..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <select class="filter-select" id="courseFilter" onchange="applyFilters()">
                    <option value="">All Courses</option>
                    <?php foreach ($allCourses as $course): ?>
                    <option value="<?php echo htmlspecialchars($course['slug']); ?>" <?php echo $filterCourse === $course['slug'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($course['name']); ?></option>
                    <?php endforeach; ?>
                </select>
                <select class="filter-select" id="stateFilter" onchange="applyFilters()">
                    <option value="">All States</option>
                    <?php foreach ($allStates as $state): ?>
                    <option value="<?php echo htmlspecialchars($state); ?>" <?php echo $filterState === $state ? 'selected' : ''; ?>><?php echo htmlspecialchars($state); ?></option>
                    <?php endforeach; ?>
                </select>
                <select class="filter-select" id="typeFilter" onchange="applyFilters()">
                    <option value="">All Types</option>
                    <?php foreach ($types as $type): ?>
                    <option value="<?php echo htmlspecialchars($type); ?>" <?php echo $filterType === $type ? 'selected' : ''; ?>><?php echo ucfirst(htmlspecialchars($type)); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- Table -->
            <div class="table-card">
                <?php if (empty($universities)): ?>
                <div class="empty-state">
                    <i class="fas fa-university"></i>
                    <p>No universities found</p>
                </div>
                <?php else: ?>
                <table class="uni-table">
                    <thead>
                        <tr>
                            <th>University</th>
                            <th>Type</th>
                            <th>Courses</th>
                            <th>Fees Range</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($universities as $uni): ?>
                        <?php $uniCourses = json_decode($uni['courses'], true) ?? []; ?>
                        <tr>
                            <td>
                                <div class="uni-info">
                                    <div class="uni-logo">
                                        <?php echo strtoupper(substr($uni['short_name'] ?: $uni['name'], 0, 2)); ?>
                                    </div>
                                    <div>
                                        <div class="uni-name">
                                            <?php echo htmlspecialchars($uni['short_name'] ? $uni['short_name'] . ' - ' : ''); ?><?php echo htmlspecialchars($uni['name']); ?>
                                            <?php if ($uni['featured']): ?>
                                            <span class="badge featured" style="margin-left: 8px;">Featured</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="uni-location">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <?php echo htmlspecialchars($uni['city'] . ', ' . $uni['state']); ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge <?php echo htmlspecialchars($uni['type']); ?>"><?php echo ucfirst(htmlspecialchars($uni['type'])); ?></span></td>
                            <td>
                                <div class="course-tags">
                                    <?php foreach (array_slice($uniCourses, 0, 3) as $course): ?>
                                    <span class="course-tag"><?php echo strtoupper(htmlspecialchars($course)); ?></span>
                                    <?php endforeach; ?>
                                    <?php if (count($uniCourses) > 3): ?>
                                    <span class="course-tag">+<?php echo count($uniCourses) - 3; ?></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <?php if ($uni['fees_min'] && $uni['fees_max']): ?>
                                ₹<?php echo number_format($uni['fees_min']); ?> - ₹<?php echo number_format($uni['fees_max']); ?>
                                <?php else: ?>
                                -
                                <?php endif; ?>
                            </td>
                            <td><span class="badge <?php echo htmlspecialchars($uni['status']); ?>"><?php echo ucfirst(htmlspecialchars($uni['status'])); ?></span></td>
                            <td>
                                <div class="actions">
                                    <button class="action-btn edit" onclick='openEditModal(<?php echo json_encode($uni); ?>)'>
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn delete" onclick="confirmDelete(<?php echo $uni['id']; ?>, '<?php echo htmlspecialchars(addslashes($uni['name'])); ?>')">
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
    
    <!-- Add Modal -->
    <div class="modal-overlay" id="addModal">
        <div class="modal">
            <h3><i class="fas fa-plus"></i> Add New University</h3>
            <form method="POST">
                <input type="hidden" name="action" value="add">
                
                <div class="form-row">
                    <div class="form-group">
                        <label>University Name *</label>
                        <input type="text" name="name" required placeholder="e.g., Guru Gobind Singh Indraprastha University">
                    </div>
                    <div class="form-group">
                        <label>Short Name</label>
                        <input type="text" name="short_name" placeholder="e.g., GGSIPU">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Slug (URL-friendly)</label>
                        <input type="text" name="slug" pattern="[a-z0-9-]+" placeholder="e.g., ggsipu (auto-generated if empty)">
                    </div>
                    <div class="form-group">
                        <label>Type *</label>
                        <select name="type" required>
                            <?php foreach ($types as $type): ?>
                            <option value="<?php echo $type; ?>"><?php echo ucfirst($type); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Affiliation</label>
                        <input type="text" name="affiliation" placeholder="e.g., UGC, AICTE">
                    </div>
                    <div class="form-group">
                        <label>Established Year</label>
                        <input type="number" name="established_year" min="1800" max="2030" placeholder="e.g., 1998">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>City *</label>
                        <input type="text" name="city" required placeholder="e.g., New Delhi">
                    </div>
                    <div class="form-group">
                        <label>State *</label>
                        <input type="text" name="state" required placeholder="e.g., Delhi">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Ranking</label>
                        <input type="text" name="ranking" placeholder="e.g., NIRF Rank 75">
                    </div>
                    <div class="form-group">
                        <label>Website</label>
                        <input type="url" name="website" placeholder="https://example.edu">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Minimum Fees (₹/year)</label>
                        <input type="number" name="fees_min" min="0" placeholder="e.g., 80000">
                    </div>
                    <div class="form-group">
                        <label>Maximum Fees (₹/year)</label>
                        <input type="number" name="fees_max" min="0" placeholder="e.g., 250000">
                    </div>
                </div>
                
                <div class="form-group full-width">
                    <label>Courses Offered</label>
                    <div class="checkbox-group">
                        <?php foreach ($allCourses as $course): ?>
                        <label class="checkbox-label">
                            <input type="checkbox" name="courses[]" value="<?php echo htmlspecialchars($course['slug']); ?>">
                            <span><?php echo htmlspecialchars($course['name']); ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="form-group full-width">
                    <label>Description</label>
                    <textarea name="description" placeholder="Brief description of the university..."></textarea>
                </div>
                
                <div class="form-group">
                    <label class="toggle-label">
                        <input type="checkbox" name="featured" value="1">
                        <span>Featured University</span>
                    </label>
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="modal-btn cancel" onclick="closeModal('addModal')">Cancel</button>
                    <button type="submit" class="modal-btn save">Add University</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Edit Modal -->
    <div class="modal-overlay" id="editModal">
        <div class="modal">
            <h3><i class="fas fa-edit"></i> Edit University</h3>
            <form method="POST" id="editForm">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="university_id" id="editId">
                
                <div class="form-row">
                    <div class="form-group">
                        <label>University Name *</label>
                        <input type="text" name="name" id="editName" required>
                    </div>
                    <div class="form-group">
                        <label>Short Name</label>
                        <input type="text" name="short_name" id="editShortName">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Type *</label>
                        <select name="type" id="editType" required>
                            <?php foreach ($types as $type): ?>
                            <option value="<?php echo $type; ?>"><?php echo ucfirst($type); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" id="editStatus">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Affiliation</label>
                        <input type="text" name="affiliation" id="editAffiliation">
                    </div>
                    <div class="form-group">
                        <label>Established Year</label>
                        <input type="number" name="established_year" id="editEstablishedYear" min="1800" max="2030">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>City *</label>
                        <input type="text" name="city" id="editCity" required>
                    </div>
                    <div class="form-group">
                        <label>State *</label>
                        <input type="text" name="state" id="editState" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Ranking</label>
                        <input type="text" name="ranking" id="editRanking">
                    </div>
                    <div class="form-group">
                        <label>Website</label>
                        <input type="url" name="website" id="editWebsite">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Minimum Fees (₹/year)</label>
                        <input type="number" name="fees_min" id="editFeesMin" min="0">
                    </div>
                    <div class="form-group">
                        <label>Maximum Fees (₹/year)</label>
                        <input type="number" name="fees_max" id="editFeesMax" min="0">
                    </div>
                </div>
                
                <div class="form-group full-width">
                    <label>Courses Offered</label>
                    <div class="checkbox-group" id="editCoursesContainer">
                        <?php foreach ($allCourses as $course): ?>
                        <label class="checkbox-label">
                            <input type="checkbox" name="courses[]" value="<?php echo htmlspecialchars($course['slug']); ?>" class="edit-course-checkbox">
                            <span><?php echo htmlspecialchars($course['name']); ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="form-group full-width">
                    <label>Description</label>
                    <textarea name="description" id="editDescription"></textarea>
                </div>
                
                <div class="form-group">
                    <label class="toggle-label">
                        <input type="checkbox" name="featured" id="editFeatured" value="1">
                        <span>Featured University</span>
                    </label>
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="modal-btn cancel" onclick="closeModal('editModal')">Cancel</button>
                    <button type="submit" class="modal-btn save">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Delete Form -->
    <form method="POST" id="deleteForm" style="display: none;">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="university_id" id="deleteId">
    </form>
    
    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                applyFilters();
            }
        });
        
        function applyFilters() {
            const search = document.getElementById('searchInput').value.trim();
            const course = document.getElementById('courseFilter').value;
            const state = document.getElementById('stateFilter').value;
            const type = document.getElementById('typeFilter').value;
            
            let url = 'universities.php?';
            const params = [];
            
            if (search) params.push('search=' + encodeURIComponent(search));
            if (course) params.push('course=' + encodeURIComponent(course));
            if (state) params.push('state=' + encodeURIComponent(state));
            if (type) params.push('type=' + encodeURIComponent(type));
            
            window.location.href = url + params.join('&');
        }
        
        function openAddModal() {
            document.getElementById('addModal').classList.add('show');
        }
        
        function openEditModal(uni) {
            document.getElementById('editId').value = uni.id;
            document.getElementById('editName').value = uni.name;
            document.getElementById('editShortName').value = uni.short_name || '';
            document.getElementById('editType').value = uni.type;
            document.getElementById('editStatus').value = uni.status;
            document.getElementById('editAffiliation').value = uni.affiliation || '';
            document.getElementById('editEstablishedYear').value = uni.established_year || '';
            document.getElementById('editCity').value = uni.city || '';
            document.getElementById('editState').value = uni.state || '';
            document.getElementById('editRanking').value = uni.ranking || '';
            document.getElementById('editWebsite').value = uni.website || '';
            document.getElementById('editFeesMin').value = uni.fees_min || '';
            document.getElementById('editFeesMax').value = uni.fees_max || '';
            document.getElementById('editDescription').value = uni.description || '';
            document.getElementById('editFeatured').checked = uni.featured == 1;
            
            // Handle courses
            const courses = typeof uni.courses === 'string' ? JSON.parse(uni.courses) : (uni.courses || []);
            document.querySelectorAll('.edit-course-checkbox').forEach(cb => {
                cb.checked = courses.includes(cb.value);
            });
            
            document.getElementById('editModal').classList.add('show');
        }
        
        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
        }
        
        function confirmDelete(id, name) {
            if (confirm('Are you sure you want to delete "' + name + '"? This action cannot be undone.')) {
                document.getElementById('deleteId').value = id;
                document.getElementById('deleteForm').submit();
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



