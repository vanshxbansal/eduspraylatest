<?php
/**
 * Testimonials Page - Display all testimonials with copy protection
 */

require_once 'php/config.php';

// Get all active testimonials
try {
    $stmt = $pdo->query("SELECT * FROM testimonials WHERE status = 'active' ORDER BY display_order ASC, created_at DESC");
    $testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $testimonials = [];
}

$pageTitle = 'Our Testimonials - Eduspray India';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Read testimonials from our students who have successfully secured admissions in top colleges and universities with Eduspray India's guidance.">
    
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
        .testimonials-hero {
            position: relative;
            z-index: 1;
            margin-top: 0;
            clear: both;
        }
        
        /* Copy Protection Styles */
        .testimonials-container {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            -webkit-touch-callout: none;
            -webkit-tap-highlight-color: transparent;
        }
        
        .testimonial-card {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            position: relative;
        }
        
        .testimonial-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
            pointer-events: none;
        }
        
        .testimonial-image {
            pointer-events: none;
            -webkit-user-drag: none;
            -khtml-user-drag: none;
            -moz-user-drag: none;
            -o-user-drag: none;
            user-drag: none;
        }
        
        /* Page Styles */
        .testimonials-hero {
            background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
            padding: 40px 0;
            color: white;
            text-align: center;
        }
        
        .testimonials-hero h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .testimonials-hero p {
            font-size: 16px;
            opacity: 0.9;
        }
        
        .testimonials-section {
            padding: 50px 0;
            background: #f8f9fa;
        }
        
        .testimonial-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.12);
        }
        
        .testimonial-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .testimonial-image-wrapper {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
            background: linear-gradient(135deg, #0ea5e9, #06b6d4);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .testimonial-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .testimonial-image-wrapper .initials {
            color: white;
            font-size: 28px;
            font-weight: 700;
        }
        
        .testimonial-info h3 {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a2e;
            margin: 0 0 5px 0;
        }
        
        .testimonial-info .designation {
            font-size: 14px;
            color: #666;
            margin: 0 0 8px 0;
        }
        
        .testimonial-rating {
            display: flex;
            gap: 3px;
        }
        
        .testimonial-rating i {
            color: #fbbf24;
            font-size: 14px;
        }
        
        .testimonial-text {
            font-size: 16px;
            line-height: 1.8;
            color: #555;
            margin: 0;
            position: relative;
            padding-left: 20px;
        }
        
        .testimonial-text::before {
            content: '"';
            position: absolute;
            left: 0;
            top: -5px;
            font-size: 48px;
            color: #0ea5e9;
            opacity: 0.3;
            font-family: Georgia, serif;
        }
        
        .testimonial-course {
            display: inline-block;
            margin-top: 15px;
            padding: 5px 12px;
            background: #e0f2fe;
            color: #0369a1;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
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
        
        @media (max-width: 768px) {
            .testimonials-hero h1 {
                font-size: 24px;
            }
            
            .testimonial-card {
                padding: 20px;
            }
            
            .testimonial-header {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body class="rbt-header-sticky">
    <?php include 'includes/header.php'; ?>
    
    <!-- Hero Section -->
    <div class="testimonials-hero">
        <div class="container">
            <h1>Our Testimonials</h1>
            <p>What our students say about Eduspray India</p>
        </div>
    </div>

    <?php require_once __DIR__ . '/includes/notification_banner.php'; ?>
    
    <!-- Testimonials Section -->
    <div class="testimonials-section testimonials-container">
        <div class="container">
            <?php if (empty($testimonials)): ?>
            <div class="empty-state">
                <i class="feather-message-circle"></i>
                <h3>No Testimonials Yet</h3>
                <p>Check back soon for student testimonials!</p>
            </div>
            <?php else: ?>
            <div class="row">
                <?php foreach ($testimonials as $testimonial): 
                    $initials = strtoupper(substr($testimonial['name'], 0, 2));
                    $rating = floatval($testimonial['rating']);
                    $fullStars = floor($rating);
                    $hasHalfStar = ($rating - $fullStars) >= 0.5;
                ?>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-image-wrapper">
                                <?php if (!empty($testimonial['image']) && file_exists($testimonial['image'])): ?>
                                <img src="<?php echo htmlspecialchars($testimonial['image']); ?>" alt="<?php echo htmlspecialchars($testimonial['name']); ?>" class="testimonial-image">
                                <?php else: ?>
                                <div class="initials"><?php echo $initials; ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="testimonial-info">
                                <h3><?php echo htmlspecialchars($testimonial['name']); ?></h3>
                                <?php if (!empty($testimonial['designation'])): ?>
                                <div class="designation"><?php echo htmlspecialchars($testimonial['designation']); ?></div>
                                <?php endif; ?>
                                <div class="testimonial-rating">
                                    <?php for ($i = 0; $i < $fullStars; $i++): ?>
                                    <i class="fas fa-star"></i>
                                    <?php endfor; ?>
                                    <?php if ($hasHalfStar): ?>
                                    <i class="fas fa-star-half-alt"></i>
                                    <?php endif; ?>
                                    <?php for ($i = $fullStars + ($hasHalfStar ? 1 : 0); $i < 5; $i++): ?>
                                    <i class="far fa-star"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                        <p class="testimonial-text"><?php echo htmlspecialchars($testimonial['testimonial_text']); ?></p>
                        <?php if (!empty($testimonial['course'])): ?>
                        <span class="testimonial-course"><?php echo htmlspecialchars($testimonial['course']); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
    
    <!-- Copy Protection Script -->
    <script>
        // Disable right-click context menu
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            return false;
        });
        
        // Disable text selection
        document.addEventListener('selectstart', function(e) {
            e.preventDefault();
            return false;
        });
        
        // Disable drag
        document.addEventListener('dragstart', function(e) {
            e.preventDefault();
            return false;
        });
        
        // Disable keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Disable Ctrl+C, Ctrl+A, Ctrl+X, Ctrl+V, Ctrl+S, Ctrl+P, F12
            if (e.ctrlKey && (e.keyCode === 67 || e.keyCode === 65 || e.keyCode === 88 || e.keyCode === 86 || e.keyCode === 83 || e.keyCode === 80)) {
                e.preventDefault();
                return false;
            }
            // Disable F12 (Developer Tools)
            if (e.keyCode === 123) {
                e.preventDefault();
                return false;
            }
            // Disable Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+Shift+C (Developer Tools)
            if (e.ctrlKey && e.shiftKey && (e.keyCode === 73 || e.keyCode === 74 || e.keyCode === 67)) {
                e.preventDefault();
                return false;
            }
        });
        
        // Disable copy event
        document.addEventListener('copy', function(e) {
            e.clipboardData.setData('text/plain', '');
            e.preventDefault();
            return false;
        });
        
        // Disable cut event
        document.addEventListener('cut', function(e) {
            e.clipboardData.setData('text/plain', '');
            e.preventDefault();
            return false;
        });
        
        // Disable paste event
        document.addEventListener('paste', function(e) {
            e.preventDefault();
            return false;
        });
        
        // Additional protection: Disable image saving via drag
        var images = document.querySelectorAll('img');
        images.forEach(function(img) {
            img.addEventListener('dragstart', function(e) {
                e.preventDefault();
                return false;
            });
        });
        
        // Console warning (basic protection)
        console.log('%cStop!', 'color: red; font-size: 50px; font-weight: bold;');
        console.log('%cThis is a browser feature intended for developers. If someone told you to copy-paste something here, it is a scam.', 'color: red; font-size: 16px;');
    </script>
    
    <!-- JS -->
    <script src="js/modernizr.min.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/sal.js"></script>
    <script src="js/main.js"></script>
</body>
</html>



