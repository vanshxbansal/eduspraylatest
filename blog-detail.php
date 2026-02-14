<?php
/**
 * Blog Detail Page - Individual blog post view
 */

require_once 'php/config.php';

// Get blog slug from URL
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

if (empty($slug)) {
    header('Location: blogs.php');
    exit;
}

// Get blog from database
try {
    $stmt = $pdo->prepare("SELECT * FROM blogs WHERE slug = ? AND status = 'published'");
    $stmt->execute([$slug]);
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$blog) {
        header('Location: blogs.php');
        exit;
    }
    
    // Increment views
    $viewStmt = $pdo->prepare("UPDATE blogs SET views = views + 1 WHERE id = ?");
    $viewStmt->execute([$blog['id']]);
    
    // Get related blogs
    $relatedStmt = $pdo->prepare("SELECT * FROM blogs WHERE status = 'published' AND id != ? AND category = ? ORDER BY created_at DESC LIMIT 3");
    $relatedStmt->execute([$blog['id'], $blog['category'] ?? '']);
    $relatedBlogs = $relatedStmt->fetchAll(PDO::FETCH_ASSOC);
    
    // If not enough related blogs, get latest
    if (count($relatedBlogs) < 3) {
        $latestStmt = $pdo->prepare("SELECT * FROM blogs WHERE status = 'published' AND id != ? ORDER BY created_at DESC LIMIT ?");
        $latestStmt->execute([$blog['id'], 3 - count($relatedBlogs)]);
        $latestBlogs = $latestStmt->fetchAll(PDO::FETCH_ASSOC);
        $relatedBlogs = array_merge($relatedBlogs, $latestBlogs);
    }
    
} catch (PDOException $e) {
    header('Location: blogs.php');
    exit;
}

$pageTitle = htmlspecialchars($blog['title']) . ' - Eduspray India Blog';
$date = date('F d, Y', strtotime($blog['created_at']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $pageTitle; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($blog['excerpt'] ?? $blog['title']); ?>">
    
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
        .blog-detail-hero {
            background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
            padding: 60px 0 40px;
            color: white;
        }
        
        .blog-detail-hero .container {
            max-width: 800px;
        }
        
        .blog-detail-hero .category {
            display: inline-block;
            padding: 6px 16px;
            background: rgba(255,255,255,0.2);
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .blog-detail-hero h1 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.3;
        }
        
        .blog-detail-hero .meta {
            display: flex;
            align-items: center;
            gap: 20px;
            font-size: 14px;
            opacity: 0.9;
        }
        
        .blog-detail-content {
            padding: 50px 0;
            background: #f8f9fa;
        }
        
        .blog-detail-wrapper {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        
        .blog-featured-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 30px;
        }
        
        .blog-content {
            font-size: 16px;
            line-height: 1.8;
            color: #555;
        }
        
        .blog-content h2,
        .blog-content h3,
        .blog-content h4 {
            color: #1a1a2e;
            margin-top: 30px;
            margin-bottom: 15px;
        }
        
        .blog-content p {
            margin-bottom: 20px;
        }
        
        .blog-content ul,
        .blog-content ol {
            margin-bottom: 20px;
            padding-left: 30px;
        }
        
        .blog-content li {
            margin-bottom: 10px;
        }
        
        .blog-share {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #f0f0f0;
        }
        
        .blog-share h4 {
            font-size: 18px;
            margin-bottom: 15px;
        }
        
        .share-buttons {
            display: flex;
            gap: 10px;
        }
        
        .share-btn {
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            font-weight: 600;
            font-size: 14px;
            transition: transform 0.3s;
        }
        
        .share-btn:hover {
            transform: translateY(-2px);
            color: white;
        }
        
        .share-btn.facebook { background: #1877f2; }
        .share-btn.twitter { background: #1da1f2; }
        .share-btn.linkedin { background: #0077b5; }
        .share-btn.whatsapp { background: #25d366; }
        
        .related-blogs {
            padding: 50px 0;
            background: white;
        }
        
        .related-blogs h3 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 30px;
            color: #1a1a2e;
        }
        
        .related-blog-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
            height: 100%;
        }
        
        .related-blog-card:hover {
            transform: translateY(-5px);
        }
        
        .related-blog-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .related-blog-body {
            padding: 20px;
        }
        
        .related-blog-title {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 10px;
        }
        
        .related-blog-title a {
            color: inherit;
            text-decoration: none;
        }
        
        .related-blog-title a:hover {
            color: #0ea5e9;
        }
        
        @media (max-width: 768px) {
            .blog-detail-hero h1 {
                font-size: 24px;
            }
            
            .blog-detail-wrapper {
                padding: 20px;
            }
            
            .blog-featured-image {
                height: 250px;
            }
        }
    </style>
</head>
<body class="rbt-header-sticky">
    <?php include 'includes/header.php'; ?>
    
    <!-- Hero Section -->
    <div class="blog-detail-hero">
        <div class="container">
            <?php if (!empty($blog['category'])): ?>
            <span class="category"><?php echo htmlspecialchars($blog['category']); ?></span>
            <?php endif; ?>
            <h1><?php echo htmlspecialchars($blog['title']); ?></h1>
            <div class="meta">
                <span><i class="feather-user"></i> <?php echo htmlspecialchars($blog['author']); ?></span>
                <span><i class="feather-calendar"></i> <?php echo $date; ?></span>
                <span><i class="feather-eye"></i> <?php echo number_format($blog['views'] ?? 0); ?> views</span>
            </div>
        </div>
    </div>

    <?php require_once __DIR__ . '/includes/notification_banner.php'; ?>
    
    <!-- Blog Content -->
    <div class="blog-detail-content">
        <div class="container">
            <div class="blog-detail-wrapper">
                <?php if (!empty($blog['featured_image']) && file_exists($blog['featured_image'])): ?>
                <img src="<?php echo htmlspecialchars($blog['featured_image']); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>" class="blog-featured-image">
                <?php endif; ?>
                
                <div class="blog-content">
                    <?php echo $blog['content']; ?>
                </div>
                
                <!-- Share Buttons -->
                <div class="blog-share">
                    <h4>Share this post</h4>
                    <div class="share-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank" class="share-btn facebook">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>&text=<?php echo urlencode($blog['title']); ?>" target="_blank" class="share-btn twitter">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank" class="share-btn linkedin">
                            <i class="fab fa-linkedin-in"></i> LinkedIn
                        </a>
                        <a href="https://wa.me/?text=<?php echo urlencode($blog['title'] . ' - ' . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank" class="share-btn whatsapp">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Blogs -->
    <?php if (!empty($relatedBlogs)): ?>
    <div class="related-blogs">
        <div class="container">
            <h3>Related Posts</h3>
            <div class="row g-4">
                <?php foreach (array_slice($relatedBlogs, 0, 3) as $related): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="related-blog-card">
                        <?php if (!empty($related['featured_image']) && file_exists($related['featured_image'])): ?>
                        <img src="<?php echo htmlspecialchars($related['featured_image']); ?>" alt="<?php echo htmlspecialchars($related['title']); ?>" class="related-blog-img">
                        <?php else: ?>
                        <div style="width: 100%; height: 200px; background: linear-gradient(135deg, #0ea5e9, #06b6d4); display: flex; align-items: center; justify-content: center; color: white; font-size: 48px;">
                            <i class="feather-file-text"></i>
                        </div>
                        <?php endif; ?>
                        <div class="related-blog-body">
                            <h4 class="related-blog-title">
                                <a href="blog-detail.php?slug=<?php echo urlencode($related['slug']); ?>">
                                    <?php echo htmlspecialchars($related['title']); ?>
                                </a>
                            </h4>
                            <a href="blog-detail.php?slug=<?php echo urlencode($related['slug']); ?>" style="color: #0ea5e9; text-decoration: none; font-weight: 600;">
                                Read More <i class="feather-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
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



