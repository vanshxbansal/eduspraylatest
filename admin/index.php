<?php
/**
 * Admin Dashboard
 * Main admin panel with user activity analytics
 */

session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /admin/login.php');
    exit;
}

// Include database config
require_once '../php/config.php';

$totalLeads = 0;
// Get stats
try {
    // Total users
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
    $totalUsers = $stmt->fetch()['total'];
    
    // Today's users
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM users WHERE DATE(created_at) = CURDATE()");
    $todayUsers = $stmt->fetch()['total'];
    
    // Active sessions (last 24 hours)
    $stmt = $pdo->query("SELECT COUNT(DISTINCT user_id) as total FROM user_activity WHERE created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)");
    $activeSessions = $stmt->fetch()['total'];
    
    // Total page views today
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM user_activity WHERE activity_type = 'page_view' AND DATE(created_at) = CURDATE()");
    $todayPageViews = $stmt->fetch()['total'];
    
    // Users by auth provider
    $stmt = $pdo->query("SELECT auth_provider, COUNT(*) as count FROM users GROUP BY auth_provider");
    $authProviders = $stmt->fetchAll();
    
    // Activity by type (last 7 days)
    $stmt = $pdo->query("SELECT activity_type, COUNT(*) as count FROM user_activity WHERE created_at > DATE_SUB(NOW(), INTERVAL 7 DAY) GROUP BY activity_type");
    $activityByType = $stmt->fetchAll();
    
    // Daily registrations (last 7 days)
    $stmt = $pdo->query("SELECT DATE(created_at) as date, COUNT(*) as count FROM users WHERE created_at > DATE_SUB(NOW(), INTERVAL 7 DAY) GROUP BY DATE(created_at) ORDER BY date");
    $dailyRegistrations = $stmt->fetchAll();
    
    // Device breakdown (last 7 days)
    $stmt = $pdo->query("SELECT device_type, COUNT(*) as count FROM user_activity WHERE created_at > DATE_SUB(NOW(), INTERVAL 7 DAY) GROUP BY device_type");
    $deviceBreakdown = $stmt->fetchAll();
    
    // Recent activities
    $stmt = $pdo->query("SELECT ua.*, u.name, u.email FROM user_activity ua LEFT JOIN users u ON ua.user_id = u.id ORDER BY ua.created_at DESC LIMIT 10");
    $recentActivities = $stmt->fetchAll();
    
    // Total leads (contact / newsletter / get update)
    $totalLeads = 0;
    try {
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM leads");
        $totalLeads = (int) $stmt->fetch()['total'];
    } catch (PDOException $e) { /* leads table may not exist */ }
    
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Eduspray Admin</title>
    <link rel="shortcut icon" href="../images/02.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        
        .admin-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.05);
            padding: 10px 20px;
            border-radius: 50px;
        }
        
        .admin-badge i {
            color: #6366f1;
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
        
        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 16px;
            padding: 25px;
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card .icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 15px;
        }
        
        .stat-card.users .icon { background: rgba(99, 102, 241, 0.2); color: #6366f1; }
        .stat-card.today .icon { background: rgba(16, 185, 129, 0.2); color: #10b981; }
        .stat-card.sessions .icon { background: rgba(249, 115, 22, 0.2); color: #f97316; }
        .stat-card.views .icon { background: rgba(236, 72, 153, 0.2); color: #ec4899; }
        
        .stat-card .value {
            font-size: 32px;
            font-weight: 700;
            color: white;
            margin-bottom: 5px;
        }
        
        .stat-card .label {
            font-size: 14px;
            color: #888;
        }
        
        /* Charts Grid */
        .charts-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .chart-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 16px;
            padding: 25px;
        }
        
        .chart-card h3 {
            font-size: 16px;
            font-weight: 600;
            color: white;
            margin-bottom: 20px;
        }
        
        .chart-container {
            position: relative;
            height: 250px;
        }
        
        /* Activity Table */
        .activity-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 16px;
            padding: 25px;
        }
        
        .activity-card h3 {
            font-size: 16px;
            font-weight: 600;
            color: white;
            margin-bottom: 20px;
        }
        
        .activity-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .activity-table th,
        .activity-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        
        .activity-table th {
            color: #888;
            font-weight: 500;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .activity-table td {
            color: #e0e0e0;
            font-size: 14px;
        }
        
        .activity-table tr:hover {
            background: rgba(255,255,255,0.02);
        }
        
        .activity-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .activity-badge.login { background: rgba(16, 185, 129, 0.2); color: #10b981; }
        .activity-badge.logout { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
        .activity-badge.register { background: rgba(99, 102, 241, 0.2); color: #6366f1; }
        .activity-badge.page_view { background: rgba(249, 115, 22, 0.2); color: #f97316; }
        
        @media (max-width: 1200px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .charts-grid { grid-template-columns: 1fr; }
        }
        
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .main-content { margin-left: 0; }
            .stats-grid { grid-template-columns: 1fr; }
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
                    <a href="index.php" class="active">
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
                <li class="nav-item">
                    <a href="leads.php">
                        <i class="fas fa-address-book"></i>
                        <span>User Details / Leads</span>
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
                <li class="nav-item">
                    <a href="home_page.php">
                        <i class="fas fa-home"></i>
                        <span>Home Page</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin/college_cards.php">
                        <i class="fas fa-id-card"></i>
                        <span>College Cards</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="blogs.php">
                        <i class="fas fa-blog"></i>
                        <span>Blogs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="notifications.php">
                        <i class="fas fa-bell"></i>
                        <span>Notification Banner</span>
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
                <h2>Dashboard</h2>
                <div class="header-right">
                    <div class="admin-badge">
                        <i class="fas fa-shield-alt"></i>
                        <span>Administrator</span>
                    </div>
                    <a href="/admin/logout.php" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
            
            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card users">
                    <div class="icon"><i class="fas fa-users"></i></div>
                    <div class="value"><?php echo number_format($totalUsers); ?></div>
                    <div class="label">Total Users</div>
                </div>
                <div class="stat-card today">
                    <div class="icon"><i class="fas fa-user-plus"></i></div>
                    <div class="value"><?php echo number_format($todayUsers); ?></div>
                    <div class="label">New Today</div>
                </div>
                <div class="stat-card sessions">
                    <div class="icon"><i class="fas fa-signal"></i></div>
                    <div class="value"><?php echo number_format($activeSessions); ?></div>
                    <div class="label">Active Users (24h)</div>
                </div>
                <div class="stat-card views">
                    <div class="icon"><i class="fas fa-eye"></i></div>
                    <div class="value"><?php echo number_format($todayPageViews); ?></div>
                    <div class="label">Page Views Today</div>
                </div>
                <a href="leads.php" class="stat-card" style="text-decoration:none;color:inherit;">
                    <div class="icon" style="background:rgba(16,185,129,0.2);color:#10b981;"><i class="fas fa-address-book"></i></div>
                    <div class="value"><?php echo number_format($totalLeads); ?></div>
                    <div class="label">User Details / Leads</div>
                </a>
            </div>
            
            <!-- Charts Grid -->
            <div class="charts-grid">
                <div class="chart-card">
                    <h3>User Registrations (Last 7 Days)</h3>
                    <div class="chart-container">
                        <canvas id="registrationsChart"></canvas>
                    </div>
                </div>
                <div class="chart-card">
                    <h3>Device Breakdown</h3>
                    <div class="chart-container">
                        <canvas id="deviceChart"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="charts-grid">
                <div class="chart-card">
                    <h3>Activity Types (Last 7 Days)</h3>
                    <div class="chart-container">
                        <canvas id="activityChart"></canvas>
                    </div>
                </div>
                <div class="chart-card">
                    <h3>Auth Providers</h3>
                    <div class="chart-container">
                        <canvas id="authChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activity -->
            <div class="activity-card">
                <h3>Recent Activity</h3>
                <table class="activity-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Activity</th>
                            <th>Page</th>
                            <th>Device</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentActivities as $activity): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($activity['name'] ?? 'Guest'); ?></td>
                            <td>
                                <span class="activity-badge <?php echo $activity['activity_type']; ?>">
                                    <?php echo ucfirst(str_replace('_', ' ', $activity['activity_type'])); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars(basename($activity['page_url'] ?? '-')); ?></td>
                            <td><?php echo ucfirst($activity['device_type']); ?></td>
                            <td><?php echo date('M j, g:i A', strtotime($activity['created_at'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    
    <script>
        // Chart.js configuration
        Chart.defaults.color = '#888';
        Chart.defaults.borderColor = 'rgba(255,255,255,0.05)';
        
        // Registrations Chart
        new Chart(document.getElementById('registrationsChart'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_map(function($r) { return date('M j', strtotime($r['date'])); }, $dailyRegistrations)); ?>,
                datasets: [{
                    label: 'Registrations',
                    data: <?php echo json_encode(array_column($dailyRegistrations, 'count')); ?>,
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });
        
        // Device Chart
        new Chart(document.getElementById('deviceChart'), {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode(array_map(function($d) { return ucfirst($d['device_type']); }, $deviceBreakdown)); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($deviceBreakdown, 'count')); ?>,
                    backgroundColor: ['#6366f1', '#10b981', '#f97316']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
        
        // Activity Chart
        new Chart(document.getElementById('activityChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_map(function($a) { return ucfirst(str_replace('_', ' ', $a['activity_type'])); }, $activityByType)); ?>,
                datasets: [{
                    label: 'Count',
                    data: <?php echo json_encode(array_column($activityByType, 'count')); ?>,
                    backgroundColor: ['#6366f1', '#10b981', '#f97316', '#ec4899', '#8b5cf6']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
        
        // Auth Chart
        new Chart(document.getElementById('authChart'), {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_map(function($a) { return ucfirst($a['auth_provider'] ?? 'Local'); }, $authProviders)); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($authProviders, 'count')); ?>,
                    backgroundColor: ['#6366f1', '#10b981']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    </script>
</body>
</html>

