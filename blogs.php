<?php
/**
 * Blog Listing Page
 */

require_once 'php/config.php';

// Get pagination parameters
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 12;
$offset = ($page - 1) * $limit;

// Get blogs
try {
    $stmt = $pdo->prepare("SELECT * FROM blogs WHERE status = 'published' ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->execute([$limit, $offset]);
    $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get total count
    $countStmt = $pdo->query("SELECT COUNT(*) as total FROM blogs WHERE status = 'published'");
    $total = $countStmt->fetch()['total'];
    $totalPages = ceil($total / $limit);
} catch (PDOException $e) {
    $blogs = [];
    $total = 0;
    $totalPages = 0;
}

$pageTitle = 'Blog - Eduspray India';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Read our latest blog posts about education, admission guidance, and career tips from Eduspray India.">
    
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/02.png">
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/slick-theme.css">
    <link rel="stylesheet" href="css/sal.css">
    <link rel="stylesheet" href="css/feather.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/euclid-circulara.css">
    <link rel="stylesheet" href="css/swiper.css">
    <link rel="stylesheet" href="css/style.css">
    
    <style>
        /* Header Protection - Match course.php styling */
        .rbt-sticky-placeholder {
            display: none !important;
            height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        /* Ensure header is visible and properly positioned - match homepage */
        .rbt-header {
            position: relative !important;
            width: 100%;
            z-index: 999;
        }
        
        .rbt-header-top {
            position: relative !important;
            width: 100%;
        }
        
        .rbt-header-wrapper {
            position: relative !important;
            width: 100%;
        }
        
        /* Ensure header takes up space in document flow */
        .rbt-header.rbt-header-8 {
            position: relative !important;
        }
        
        /* Ensure navigation is visible like on homepage - only on larger screens */
        @media (min-width: 1200px) {
            .rbt-main-navigation.d-none.d-xl-block {
                display: flex !important;
            }
        }
        
        /* On small screens, ensure navigation is hidden (uses hamburger menu) */
        @media (max-width: 1199px) {
            .rbt-main-navigation.d-none.d-xl-block {
                display: none !important;
            }
        }
        
        /* Prevent text wrapping in navigation menu items */
        .rbt-main-navigation .mainmenu li a {
            white-space: nowrap !important;
        }
        
        /* Ensure hero section comes after header with proper spacing */
        .blog-hero {
            position: relative;
            z-index: 1;
            margin-top: 0;
            clear: both;
            background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
            padding: 40px 0;
            color: white;
            text-align: center;
        }
        
        .blog-hero h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .blog-hero p {
            font-size: 16px;
            opacity: 0.9;
        }
        
        .blogs-section {
            padding: 50px 0;
            background: #f8f9fa;
        }
        
        .blog-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.12);
        }
        
        .blog-card-img {
            width: 100%;
            height: 200px;
            overflow: hidden;
            background: linear-gradient(135deg, #0ea5e9, #06b6d4);
        }
        
        .blog-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .blog-card:hover .blog-card-img img {
            transform: scale(1.05);
        }
        
        .blog-card-body {
            padding: 25px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .blog-card-category {
            display: inline-block;
            padding: 4px 12px;
            background: #e0f2fe;
            color: #0369a1;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 12px;
        }
        
        .blog-card-title {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 12px;
            line-height: 1.4;
        }
        
        .blog-card-title a {
            color: inherit;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .blog-card-title a:hover {
            color: #0ea5e9;
        }
        
        .blog-card-excerpt {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 15px;
            flex: 1;
        }
        
        .blog-card-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12px;
            color: #999;
            padding-top: 15px;
            border-top: 1px solid #f0f0f0;
        }
        
        .blog-card-author {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .blog-card-date {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .blog-read-more {
            color: #0ea5e9;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: gap 0.3s;
        }
        
        .blog-read-more:hover {
            gap: 10px;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 40px;
        }
        
        .pagination a,
        .pagination span {
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            color: #666;
            background: white;
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
        }
        
        .pagination a:hover {
            background: #0ea5e9;
            color: white;
            border-color: #0ea5e9;
        }
        
        .pagination .active {
            background: #0ea5e9;
            color: white;
            border-color: #0ea5e9;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        
        .empty-state i {
            font-size: 64px;
            color: #ddd;
            margin-bottom: 20px;
        }
        
        .empty-state h3 {
            font-size: 24px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .empty-state p {
            color: #999;
        }
    </style>
</head>
<body class="rbt-header-sticky">
    <?php include 'includes/header.php'; ?>
    
    <!-- Hero Section -->
    <div class="blog-hero">
        <div class="container">
            <h1>Eduspray India Blog</h1>
            <p>Latest updates, guidance, and insights</p>
        </div>
    </div>

    <?php require_once __DIR__ . '/includes/notification_banner.php'; ?>
    
    <!-- Blogs Section -->
    <div class="blogs-section">
        <div class="container">
            <?php if (empty($blogs)): ?>
            <div class="empty-state">
                <i class="feather-file-text"></i>
                <h3>No Blog Posts Yet</h3>
                <p>Check back soon for our latest blog posts!</p>
            </div>
            <?php else: ?>
            <div class="row g-4">
                <?php foreach ($blogs as $blog): 
                    $date = date('M d, Y', strtotime($blog['created_at']));
                ?>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="blog-card">
                        <div class="blog-card-img">
                            <?php if (!empty($blog['featured_image']) && file_exists($blog['featured_image'])): ?>
                            <img src="<?php echo htmlspecialchars($blog['featured_image']); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>">
                            <?php else: ?>
                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #0ea5e9, #06b6d4); display: flex; align-items: center; justify-content: center; color: white; font-size: 48px;">
                                <i class="feather-file-text"></i>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="blog-card-body">
                            <?php if (!empty($blog['category'])): ?>
                            <span class="blog-card-category"><?php echo htmlspecialchars($blog['category']); ?></span>
                            <?php endif; ?>
                            <h3 class="blog-card-title">
                                <a href="blog-detail.php?slug=<?php echo urlencode($blog['slug']); ?>">
                                    <?php echo htmlspecialchars($blog['title']); ?>
                                </a>
                            </h3>
                            <?php if (!empty($blog['excerpt'])): ?>
                            <p class="blog-card-excerpt"><?php echo htmlspecialchars($blog['excerpt']); ?></p>
                            <?php endif; ?>
                            <div class="blog-card-meta">
                                <div class="blog-card-author">
                                    <i class="feather-user"></i>
                                    <span><?php echo htmlspecialchars($blog['author']); ?></span>
                                </div>
                                <div class="blog-card-date">
                                    <i class="feather-calendar"></i>
                                    <span><?php echo $date; ?></span>
                                </div>
                            </div>
                            <a href="blog-detail.php?slug=<?php echo urlencode($blog['slug']); ?>" class="blog-read-more">
                                Read More <i class="feather-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>"><i class="feather-chevron-left"></i> Previous</a>
                <?php endif; ?>
                
                <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                <?php if ($i == $page): ?>
                <span class="active"><?php echo $i; ?></span>
                <?php else: ?>
                <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
                <?php endfor; ?>
                
                <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>">Next <i class="feather-chevron-right"></i></a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
    
    <!-- JS -->
    <script src="js/modernizr.min.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/sal.js"></script>
    <script src="js/main.js"></script>
</body>
</html>



