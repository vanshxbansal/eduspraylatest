<?php
/**
 * Home Page - Dynamic Content Integration
 */
require_once 'php/config.php';

// Get testimonials for home page (limit 3)
try {
    $stmt = $pdo->prepare("SELECT * FROM testimonials WHERE status = 'active' ORDER BY display_order ASC, created_at DESC LIMIT 3");
    $stmt->execute();
    $homeTestimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $homeTestimonials = [];
}

// Get featured blogs for home page (limit 3)
try {
    $stmt = $pdo->prepare("SELECT * FROM blogs WHERE status = 'published' AND featured = 1 ORDER BY created_at DESC LIMIT 3");
    $stmt->execute();
    $homeBlogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // If not enough featured, get latest
    if (count($homeBlogs) < 3) {
        $latestStmt = $pdo->prepare("SELECT * FROM blogs WHERE status = 'published' ORDER BY created_at DESC LIMIT ?");
        $latestStmt->execute([3 - count($homeBlogs)]);
        $latestBlogs = $latestStmt->fetchAll(PDO::FETCH_ASSOC);
        $homeBlogs = array_merge($homeBlogs, $latestBlogs);
        $homeBlogs = array_slice($homeBlogs, 0, 3);
    }
} catch (PDOException $e) {
    $homeBlogs = [];
}

// Get college cards by category
$collegeCardsByCategory = [];
try {
    $stmt = $pdo->prepare("SELECT * FROM college_cards WHERE status = 'active' ORDER BY category, rank_order ASC, id ASC");
    $stmt->execute();
    $allCards = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Group by category
    foreach ($allCards as $card) {
        $category = $card['category'];
        if (!isset($collegeCardsByCategory[$category])) {
            $collegeCardsByCategory[$category] = [];
        }
        $collegeCardsByCategory[$category][] = $card;
    }
} catch (PDOException $e) {
    $collegeCardsByCategory = [];
}

// Helper function to render college cards
function renderCollegeCards($cards, $categoryTitle) {
    if (empty($cards)) {
        return '';
    }
    
    $html = '<div class="rbt-categories-area bg-color-extra2">
        <div class="slider-parent">
            <div class="col-lg-12">
                <div class="section-title text-center">
                    <h2 class="title pt-5">' . htmlspecialchars($categoryTitle) . '</h2>
                </div>
            </div>
            <div class="multiple-items">';
    
    foreach ($cards as $card) {
        $imageUrl = !empty($card['image_url']) ? htmlspecialchars($card['image_url']) : 'images/default-college.jpg';
        $title = htmlspecialchars($card['title']);
        $description = htmlspecialchars($card['description'] ?? '');
        $linkUrl = !empty($card['link_url']) ? htmlspecialchars($card['link_url']) : 'contact.html';
        $isFirst = ($card === reset($cards));
        $sliderId = $isFirst ? ' id="slider-item"' : '';
        
        $html .= '
                <div>
                    <div class="rbt-cat-box rbt-cat-box-1 variation-3 text-center"' . $sliderId . '>
                        <div class="inner">
                            <div class="thumbnail">
                                <a href="' . $linkUrl . '" target="_blank">
                                    <img src="' . $imageUrl . '" alt="' . $title . '">
                                    <div class="read-more-btn">
                                        <span class="rbt-btn btn-sm btn-white radius-round">Apply</span>
                                    </div>
                                </a>
                            </div>
                            <div class="content">
                                <h5 class="title"><a href="' . $linkUrl . '" target="_blank">' . $title . '</a></h5>
                                <p class="description">' . $description . '</p>
                            </div>
                        </div>
                    </div>
                </div>';
    }
    
    $html .= '
            </div>
        </div>
    </div>';
    
    return $html;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Educational Support Services For India And Overseas Studies | Eduspray India </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Our expert counselors assist in selecting the right courses, colleges, and universities based on your career goals, budget, and academic background." content>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="google-adsense-account" content="ca-pub-1969362058599710">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/02.png">
    <style>
        #hero_img {
            max-width: 100%;
        }

        #hero_img .thumbnail {
            width: 900px;
            text-align: center;
            /* Adjust as needed */
        }

        #hero_img .thumbnail img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        @media (max-width:900px) {
            #hero_img  .thumbnail {
                width: 600px;
                text-align: left;
                /* Adjust as needed */
            }
        }

        @media (max-width:600px) {
            #hero_img   .thumbnail {
                width: 100% !important;
                text-align: left;
                /* Adjust as needed */
            }

            #hero_img .thumbnail img {
                width: 100%;
                height: 60vh;
                object-fit: cover;
            }
        }
    </style>
    <!-- CSS
	============================================ -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/slick-theme.css">
    <link rel="stylesheet" href="css/sal.css">
    <link rel="stylesheet" href="css/feather.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/euclid-circulara.css">
    <link rel="stylesheet" href="css/swiper.css">
    <link rel="stylesheet" href="css/magnify.css">
    <link rel="stylesheet" href="css/odometer.css">
    <link rel="stylesheet" href="css/animation.css">
    <link rel="stylesheet" href="css/bootstrap-select.min.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/magnigy-popup.min.css">
    <link rel="stylesheet" href="css/plyr.css">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"
        integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- User Menu Styles -->
    <style>
        .user-menu-wrapper {
            position: relative;
        }
        .user-menu-dropdown {
            position: relative;
        }
        .user-menu-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .user-menu-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        .user-avatar {
            width: 32px;
            height: 32px;
            background: rgba(255,255,255,0.2);
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
        .user-menu-btn .user-name {
            color: white;
            font-weight: 500;
            font-size: 14px;
            max-width: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .user-menu-btn i {
            color: white;
            font-size: 14px;
            transition: transform 0.3s ease;
        }
        .user-menu-btn.open i {
            transform: rotate(180deg);
        }
        .user-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            min-width: 180px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
            overflow: hidden;
        }
        .user-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .user-dropdown a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
            border-bottom: 1px solid #f0f0f0;
        }
        .user-dropdown a:last-child {
            border-bottom: none;
        }
        .user-dropdown a:hover {
            background: #f8f9ff;
            color: #667eea;
        }
        .user-dropdown a i {
            font-size: 16px;
            width: 20px;
            text-align: center;
        }
        
        /* Hide login button when user is logged in */
        body.user-logged-in #loginBtnWrapper {
            display: none !important;
        }
        
        body.user-logged-in #userMenuWrapper {
            display: block !important;
        }
        
        /* ========== Mobile responsive styles ========== */
        html {
            overflow-x: hidden;
        }
        body {
            overflow-x: hidden;
            max-width: 100vw;
        }
        
        /* Header top bar: stack and reduce on small screens */
        @media (max-width: 991px) {
            .rbt-header-top .rbt-information-list {
                flex-wrap: wrap;
                gap: 4px;
            }
            .rbt-header-top .rbt-information-list li a {
                font-size: 12px;
            }
            .rbt-header-top .header-social {
                flex-wrap: wrap;
            }
        }
        @media (max-width: 576px) {
            .rbt-header-top .top-expended-inner {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
            .rbt-header-top .rbt-information-list li a {
                font-size: 11px;
            }
        }
        
        /* Main header: logo and sticky bar */
        @media (max-width: 1199px) {
            .rbt-header-wrapper .logo img {
                max-height: 40px;
                width: auto;
            }
        }
        @media (max-width: 576px) {
            .rbt-header-wrapper .logo img {
                max-height: 36px;
            }
            .rbt-header-wrapper .mainbar-row {
                padding-top: 8px;
                padding-bottom: 8px;
            }
        }
        
        /* User menu on mobile: hide name, show avatar only on very small */
        @media (max-width: 400px) {
            .user-menu-btn .user-name {
                display: none;
            }
            .user-menu-btn {
                padding: 8px 12px;
            }
        }
        
        /* Banner section */
        @media (max-width: 991px) {
            .rbt-banner-7 .title {
                font-size: 1.75rem;
                line-height: 1.3;
            }
            .rbt-banner-7 .rbt-button-group {
                flex-wrap: wrap;
                gap: 10px;
                margin: 0;
                margin-top: 20px;
            }
            .rbt-banner-7 .rbt-button-group .rbt-btn {
                min-width: 100%;
                width: 100%;
                margin: 0;
                box-sizing: border-box;
                text-align: center;
                justify-content: center;
                overflow: hidden;
                -webkit-appearance: none;
                appearance: none;
                outline: none;
                border-radius: 8px;
            }
            .rbt-banner-7 .rbt-button-group .rbt-btn.btn-border {
                border: 2px solid rgba(102, 126, 234, 0.5);
                font-weight: 500;
            }
            /* Prevent double-bar artifact from rbt-switch-btn pseudo-element on mobile */
            .rbt-banner-7 .rbt-button-group .rbt-btn.rbt-switch-btn span::after {
                left: -9999px;
                transform: translate(0, -50%);
            }
        }
        @media (max-width: 576px) {
            .rbt-banner-7 .title {
                font-size: 1.45rem;
            }
            .rbt-banner-7 .subtitle {
                font-size: 12px;
            }
            .rbt-banner-7 .rbt-like-total .profile-share {
                flex-wrap: wrap;
            }
            .rbt-banner-7 .more-author-text .total-join-students {
                font-size: 14px;
            }
            .rbt-banner-7 .more-author-text .subtitle {
                font-size: 12px;
            }
            .rbt-banner-7 .rbt-button-group {
                margin-top: 16px;
                gap: 8px;
            }
            .rbt-banner-7 .rbt-button-group .rbt-btn {
                height: 52px;
                line-height: 52px;
                font-size: 15px;
                padding: 0 20px;
            }
            .rbt-banner-7 .rbt-button-group .rbt-btn.btn-border {
                line-height: 48px;
            }
            .rbt-banner-area {
                padding-top: 24px;
                padding-bottom: 16px;
            }
            .thumbnail-wrapper .card-info.bounce-slide {
                max-width: 90%;
                left: 50%;
                transform: translateX(-50%);
            }
            .thumbnail-wrapper .card-info .name {
                font-size: 13px;
            }
            .thumbnail-wrapper .card-info .rating-wrapper {
                font-size: 12px;
            }
        }
        
        /* Section titles */
        @media (max-width: 767px) {
            .section-title .title {
                font-size: 1.5rem;
            }
            .section-title.text-center .title.pt-5 {
                padding-top: 1rem !important;
            }
        }
        @media (max-width: 576px) {
            .section-title .title {
                font-size: 1.25rem;
            }
        }
        
        /* College card images: consistent size and aspect ratio (UI/UX) */
        .rbt-categories-area .rbt-cat-box-1.variation-3 .inner .thumbnail {
            position: relative;
            width: 100%;
            padding-bottom: 62.5%;
            overflow: hidden;
            border-radius: 10px;
            flex-shrink: 0;
        }
        .rbt-categories-area .rbt-cat-box-1.variation-3 .inner .thumbnail a {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: block;
        }
        .rbt-categories-area .rbt-cat-box-1.variation-3 .inner .thumbnail a img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }
        .rbt-categories-area .rbt-cat-box-1.variation-3 .inner .thumbnail a .read-more-btn {
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
        }
        
        /* Category/card sliders */
        @media (max-width: 767px) {
            .rbt-categories-area .slider-parent {
                padding-left: 15px;
                padding-right: 15px;
            }
            .rbt-cat-box .content .title {
                font-size: 1rem;
            }
            .rbt-cat-box .content .description {
                font-size: 13px;
                -webkit-line-clamp: 3;
            }
        }
        
        /* Card grid (Popular Countries, etc.) */
        @media (max-width: 576px) {
            .rbt-course-card-area .row.g-5 {
                margin-left: -0.5rem;
                margin-right: -0.5rem;
            }
            .rbt-course-card-area .row.g-5 > [class*="col-"] {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }
            .rbt-card-body .rbt-card-title {
                font-size: 1rem;
            }
        }
        
        /* WhatsApp floating icon */
        @media (max-width: 576px) {
            #whats_icon a {
                width: 56px !important;
                height: 56px !important;
                bottom: 20px !important;
                left: 16px !important;
            }
            #whats_icon img {
                width: 100%;
                height: 100%;
                object-fit: contain;
            }
        }
        
        /* Container padding on small screens */
        @media (max-width: 576px) {
            .container {
                padding-left: 12px;
                padding-right: 12px;
            }
        }
        
        /* Footer: ensure columns stack and spacing */
        @media (max-width: 767px) {
            .rbt-footer .footer-top .row [class*="col-"],
            .rbt-footer-wrapper .row [class*="col-"] {
                margin-bottom: 1.5rem;
            }
            .rbt-footer .footer-widget .description {
                font-size: 14px;
            }
        }
        @media (max-width: 576px) {
            .rbt-footer .footer-widget .ft-title {
                font-size: 1rem;
            }
        }
    </style>
    
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-4G7WGH7S17"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'G-4G7WGH7S17');
    </script>
    <!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1155178309670051');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1155178309670051&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
</head>

<body class="rbt-header-sticky">

    <!-- <div id="preloader">
        <img src="https://cdn.dribbble.com/users/711094/screenshots/3288010/sean_tiffonnet_loader_360learning.gif" alt="">
    </div> -->

    <!-- Start Header Area -->
    <header class="rbt-header rbt-header-8 rbt-transparent-header">
        <div class="rbt-sticky-placeholder"></div>
        <!-- Start Header Top  -->
        <div
            class="rbt-header-top rbt-header-top-1 variation-height-60 header-space-betwween bg-color-transparent top-expended-activation">
            <div class="container">
                <div class="top-expended-wrapper">
                    <div class="top-expended-inner rbt-header-sec align-items-center ">
                        <div class="rbt-header-sec-col rbt-header-left">
                            <div class="rbt-header-content">
                                <div class="header-info  d-lg-block">
                                    <ul class="rbt-information-list">

                                        <li>
                                            <a style="font-weight: 900;" href="mailto:edusprayIndia@gmail.com"><i
                                                    class="feather-mail"></i>edusprayIndia@gmail.com</a>
                                        </li>
                                        <li>
                                            <a style="font-weight: 900;" href="tel:+91-8595684716"><i
                                                    class="feather-phone"></i>+91 8595684716</a>
                                        </li>
                                    </ul>

                                </div>
                                <div>
                                    <ul class="social-icon social-default header-social">
                                        <li><a href="https://www.facebook.com/profile.php?id=61569643561294#">
                                                <i class="feather-facebook"></i>
                                            </a>
                                        </li>
                                        <li><a href="https://www.twitter.com">
                                                <i class="feather-twitter"></i>
                                            </a>
                                        </li>
                                        <li><a href="https://www.instagram.com/edusprayIndia/">
                                                <i class="feather-instagram"></i>
                                            </a>
                                        </li>
                                        <li><a href="https://www.linkedin.com/feed/?trk=onboarding-landing">
                                                <i class="feather-linkedin"></i>
                                            </a>
                                        </li>

                                        <li><a href="https://www.youtube.com/@EdusprayIndia">
                                                <i class="feather-youtube"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!-- End Header Top  -->

        <div class="rbt-header-wrapper  header-sticky">
            <div class="container">
                <div class="mainbar-row rbt-navigation-end align-items-center">
                    <div class="header-left">
                        <div class="logo">
                            <a href="index.html">
                                <img src="images/e-logo.jpeg" alt="Education Logo Images">
                            </a>
                        </div>
                    </div>

                    <div class="rbt-main-navigation d-none d-xl-block">
                        <nav class="mainmenu-nav">
                            <ul class="mainmenu">
                                <li class="with-megamenu has-menu-child-item position-static">
                                    <a href="index.html">Home </a>
                                    <!-- Start Mega Menu  -->

                                    <!-- End Mega Menu  -->
                                </li>
                                <li class="with-megamenu has-menu-child-item position-static">
                                    <a href="about.html" target="_blank">About Us </a>
                                    <!-- Start Mega Menu  -->

                                    <!-- End Mega Menu  -->
                                </li>

                                <li class="with-megamenu has-menu-child-item">
                                    <a href="#">Courses <i class="feather-chevron-down"></i></a>
                                    <!-- Start Mega Menu  -->
                                    <div class="rbt-megamenu grid-item-2">
                                        <div class="wrapper">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mega-top-banner">
                                                        <div class="content">
                                                            <h4 class="title">Eduspray India</h4>
                                                            <p class="description">Best Educational Counsellor service
                                                                for Bachlor's and Master's Degree, We are India's most
                                                                trusted team of study in India
                                                                and abroad Counsellors
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row row--15">
                                                <div class="col-lg-12 col-xl-6 col-xxl-6 single-mega-item">
                                                    <h3 class="rbt-short-title">top Courses in India and Abroad</h3>
                                                    <ul class="mega-menu-item">
                                                        <li><a href="course.php?slug=btech"> <img src="images/B.TECH.png" alt="">
                                                                B.Tech</a></li>
                                                        <li><a href="course.php?slug=barch"> <img src="images/B.TECH.png" alt="">
                                                                B.Arch</a></li>
                                                        <li><a href="course.php?slug=bhmct"> <img src="images/B.TECH.png" alt="">
                                                                BHMCT</a></li>
                                                        <li><a href="course.php?slug=bca"><img src="images/BCA.png" alt="">
                                                                BCA</a></li>
                                                        <li><a href="course.php?slug=bba"> <img src="images/BBA.png" alt="">
                                                                BBA</a></li>
                                                        <li><a href="course.php?slug=bbe"> <img src="images/B.TECH.png" alt="">
                                                                BBE</a></li>
                                                        <li><a href="course.php?slug=bajmc"><img src="images/BA-JMC.png" alt="">
                                                                BA-JMC</a></li>
                                                        <li><a href="course.php?slug=bcom"><img src="images/B.COM.png" alt="">
                                                                B.Com (H)</a></li>
                                                        <li><a href="course.php?slug=baeng"><img src="images/BA-ENG.png" alt="">
                                                                BA-Eng</a></li>
                                                        <li><a href="course.php?slug=baeco"><img src="images/BA-ECO.png" alt="">
                                                                BA-Eco</a></li>
                                                        <li><a href="course.php?slug=ballb"><img src="images/BA-LLB.png" alt="">
                                                                BA-LLB</a></li>
                                                        <li><a href="course.php?slug=bballb"><img src="images/BBA-LLB.png" alt="">
                                                                BBA-LLB</a></li>
                                                        <li><a href="course.php?slug=bed"><img src="images/B.Ed.png" alt="">
                                                                B.Ed</a></li>
                                                        <li><a href="course.php?slug=medical"><img src="images/B.PHARMA.png"alt="">
                                                                MBBS</a></li>
                                                        <li><a href="course.php?slug=medical"><img src="images/B.PHARMA.png"alt="">
                                                                BUMS</a></li>
                                                        <li><a href="course.php?slug=medical"><img src="images/B.PHARMA.png"alt="">
                                                                BHMS</a></li>
                                                        <li><a href="course.php?slug=medical"><img src="images/B.PHARMA.png"alt="">
                                                                BPT</a></li>
                                                        <li><a href="course.php?slug=medical"><img src="images/B.PHARMA.png"alt="">
                                                                B.Pharma</a></li>
                                                        <li><a href="course.php?slug=medical"><img src="images/B.PHARMA.png"alt="">
                                                                D.Pharma</a></li>
                                                        <li><a href="course.php?slug=medical"><img src="images/B.PHARMA.png"alt="">
                                                                    MD/MS</a></li>
                                                        
                                                        

                                                    </ul>
                                                </div>
                                                <div class="col-lg-12 col-xl-6 col-xxl-6 single-mega-item">
                                                    <ul class="mega-menu-item">
                                                        <li><a href="course.php?slug=medical"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/medical.webp"
                                                                    alt="">Medical</a></li>
                                                        <li><a href="course.php?slug=engineering"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/engineering.webp"
                                                                    alt="">Engineering</a></li>
                                                        <li><a href="course.php?slug=management"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/management.webp"
                                                                    alt="">Business and Management</a></li>
                                                        <li><a href="course.php?slug=architecture"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/architecture.webp"
                                                                    alt=""> Architecture</a></li>
                                                        <li><a href="course.php?slug=commerce"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/commerce.webp"
                                                                    alt="">Commerce</a></li>
                                                        <li><a href="course.php?slug=aviation"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/aviation.webp"
                                                                    alt="">Aviation</a></li>
                                                        <li><a href="course.php?slug=hotel"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/hotel.webp"
                                                                    alt="">Hotel Management</a></li>
                                                        <li><a href="course.php?slug=humanities"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/arts.webp"
                                                                    alt="">Humanities</a></li>
                                                        <li><a href="course.php?slug=journalism"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/masscom.png"
                                                                    alt="">Journalism, Media and Mass Comm</a></li>
                                                        <li><a href="course.php?slug=law"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/law.webp"
                                                                    alt="">Law</a></li>
                                                        <li><a href="course.php?slug=languages"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/language.png"
                                                                    alt="">Languages and Teaching</a></li>
                                                        <li><a href="course.php?slug=design"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/design.webp"
                                                                    alt=""> Arts and Design</a></li>
                                                        <li><a href="course.php?slug=socialsciences"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/Science.png"
                                                                    alt="">Social Sciences</a></li>
                                                        <li><a href="course.php?slug=agriculture"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/Agriculture.webp"
                                                                    alt="">Agriculture and Forestry</a></li>
                                                        <li><a href="course.php?slug=computerscience"><img
                                                                    src="https://www.bookmyuniversity.com/images/courseicon/Science.webp"
                                                                    alt="">Computer Science and IT</a> </li>
                                                    </ul>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- End Mega Menu  -->
                                </li>

                                <li class="has-dropdown has-menu-child-item">
                                    <a href="#">University
                                        <i class="feather-chevron-down"></i>
                                    </a>
                                    <ul class="submenu">
                                        <li class="has-dropdown"><a href="#">Study in India</a>
                                            <ul class="submenu">
                                                <li><a href="university-of-delhi.html">University of Delhi-NCR</a></li>
                                                <li><a href="ipu.html">GGSIPU in Delhi-NCR</a></li>
                                                <li><a href="top_reputed.html"> Top Private Universities</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="has-dropdown"><a href="#">Study in Abroad</a>
                                            <!-- <ul class="submenu">
                                                <li><a href="student-dashboard.html">Dashboard</a></li>
                                                <li><a href="student-profile.html">Profile</a></li>
                                                <li><a href="student-enrolled-courses.html">Enrolled Courses</a></li>
                                              
                                            </ul> -->
                                        </li>
                                    </ul>
                                </li>
                                <li class="has-dropdown has-menu-child-item">
                                    <a href="#">Countries
                                        <i class="feather-chevron-down"></i>
                                    </a>
                                    <ul class="submenu">
                                        <li><a href="#"> <img src="images/India.png" alt=""> India</a>

                                        </li>
                                        <li><a href="#"> <img src="images/uk.png" alt=""> United-Kingdom</a>

                                        </li>
                                        <li><a href="#"><img src="images/usa.png" alt=""> USA</a></li>
                                        <li><a href="#"> <img src="images/ire.png" alt=""> Ireland</a></li>
                                        <li><a href="#"> <img src="images/can.png" alt=""> Canada</a></li>
                                        <li><a href="#"><img src="images/dub.png" alt="">Dubai</a></li>

                                    </ul>
                                </li>
                                
                                

                                <li class="has-dropdown has-menu-child-item">
                                    <a href="#">Medical
                                        <i class="feather-chevron-down"></i>
                                    </a>
                                    <ul class="submenu">
                                        <li class="has-dropdown"><a href="#"><img src="images/INDIA-NEET.png" alt="">Study in India</a>
                                            <ul class="submenu">
                                                <li><a href="#"><img src="images/DOCTER-NEET.png" alt="">NEET-UG</a></li>
                                                <li><a href="#"><img src="images/DOCTER-NEET.png" alt="">NEET-PG </a></li>
                                                <!-- <li><a href="top_reputed.html"> Top Reputed Universities</a> -->
                                                
                                            </ul>
                                        </li>
                                        <li class="has-dropdown"><a href="#"><img src="images/ABORAD.png" alt="">Study in Abroad</a>
                                            <!-- <ul class="submenu">
                                                <li><a href="student-dashboard.html">Dashboard</a></li>
                                                <li><a href="student-profile.html">Profile</a></li>
                                                <li><a href="student-enrolled-courses.html">Enrolled Courses</a></li>
                                              
                                            </ul> -->
                                        </li>
                                    </ul>
                                </li>
                                
                                

                                <li class="with-megamenu has-menu-child-item position-static">
                                    <a href="blog.html">Blog </a>
                                    <!-- Start Mega Menu  -->
                                    <!-- <div class="rbt-megamenu grid-item-3">
                                        <div class="wrapper">
                                            <div class="row row--15">
                                                <div class="col-lg-12 col-xl-4 col-xxl-4 single-mega-item">
                                                    <h3 class="rbt-short-title">Blog Styles</h3>
                                                    <ul class="mega-menu-item">
                                                        <li><a href="blog-list.html">Blog List</a></li>
                                                        <li><a href="blog.html">Blog Grid</a></li>
                                                        <li><a href="blog-grid-minimal.html">Blog Grid Minimal</a></li>
                                                        <li><a href="blog-with-sidebar.html">Blog With Sidebar</a></li>
                                                        <li><a href="blog-details.html">Blog Details</a></li>
                                                        <li><a href="post-format-standard.html">Post Format Standard</a>
                                                        </li>
                                                        <li><a href="post-format-gallery.html">Post Format Gallery</a>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="col-lg-12 col-xl-4 col-xxl-4 single-mega-item">
                                                    <h3 class="rbt-short-title">Get Started</h3>
                                                    <ul class="mega-menu-item">
                                                        <li><a href="post-format-quote.html">Post Format Quote</a></li>
                                                        <li><a href="post-format-audio.html">Post Format Audio</a></li>
                                                        <li><a href="post-format-video.html">Post Format Video</a></li>
                                                        <li><a href="#">Media Under Title <span
                                                                    class="rbt-badge-card">Coming</span></a></li>
                                                        <li><a href="#">Sticky Sidebar <span
                                                                    class="rbt-badge-card">Coming</span></a></li>
                                                        <li><a href="#">Auto Masonry <span
                                                                    class="rbt-badge-card">Coming</span></a></li>
                                                        <li><a href="#">Meta Overlaid <span
                                                                    class="rbt-badge-card">Coming</span></a></li>
                                                    </ul>
                                                </div>

                                                <div class="col-lg-12 col-xl-4 col-xxl-4 single-mega-item">
                                                    <div class="rbt-ads-wrapper">
                                                        <a class="d-block" href="#"><img src="images/mobile-cat.jpg"
                                                                alt="Education Images"></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- End Mega Menu  -->
                                </li>


                            </ul>
                        </nav>
                    </div>

                    <div class="header-right">
                        <!-- Login/Register Button (shown when not logged in) -->
                        <div class="rbt-btn-wrapper d-none d-xl-block" id="loginBtnWrapper">
                            <a class="rbt-btn rbt-switch-btn btn-gradient btn-sm hover-transform-none"
                                href="login.html">
                                <span data-text="Login / Register">Login / Register</span>
                            </a>
                        </div>
                        
                        <!-- User Menu (shown when logged in) - hidden by default -->
                        <div class="user-menu-wrapper d-none" id="userMenuWrapper">
                            <div class="user-menu-dropdown">
                                <button class="user-menu-btn" onclick="toggleUserDropdown()">
                                    <div class="user-avatar" id="userAvatar">
                                        <span id="userInitial">U</span>
                                    </div>
                                    <span class="user-name" id="userName">User</span>
                                    <i class="feather-chevron-down"></i>
                                </button>
                                <div class="user-dropdown" id="userDropdown">
                                    <a href="dashboard.html"><i class="feather-user"></i> My Dashboard</a>
                                    <a href="php/logout.php"><i class="feather-log-out"></i> Logout</a>
                                </div>
                            </div>
                        </div>

                        <!-- Start Mobile-Menu-Bar -->
                        <div class="mobile-menu-bar d-block d-xl-none">
                            <div class="hamberger">
                                <button class="hamberger-button rbt-round-btn">
                                    <i class="feather-menu"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Start Mobile-Menu-Bar -->
                    </div>

                </div>
            </div>
        </div>


    </header>
    
    <!-- Mobile Menu Section -->
    <div class="popup-mobile-menu">
        <div class="inner-wrapper">
            <div class="inner-top">
                <div class="content">
                    <div class="logo">
                        <a href="index.html">
                            <img src="images/log.png" alt="Education Logo Images">
                        </a>
                    </div>
                    <div class="rbt-btn-close">
                        <button class="close-button rbt-round-btn"><i class="feather-x"></i></button>
                    </div>
                </div>
                <p class="description">Announce upcoming events, workshops, or conferences related to education.</p>
                <ul class="navbar-top-left rbt-information-list justify-content-start">
                    <li>
                        <a href="mailto:edusprayIndia@gmail.com"><i class="feather-mail"></i>edusprayIndia@gmail.com</a>
                    </li>
                    <li>
                        <a href="tel:+91-8595684716"><i class="feather-phone"></i>+91 8595684716</a>
                    </li>
                </ul>
            </div>

            <nav class="mainmenu-nav">
                <ul class="mainmenu">
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li>
                        <a href="about.html" target="_blank">About Us</a>
                    </li>
                    <li class="with-megamenu has-menu-child-item">
                        <a href="#">Courses <i class="feather-chevron-down"></i></a>
                        <!-- Start Mega Menu  -->
                        <div class="rbt-megamenu grid-item-2">
                            <div class="wrapper">

                                <div class="row row--15">
                                    <div class="col-lg-12 col-xl-6 col-xxl-6 single-mega-item">
                                        <h3 class="rbt-short-title">top Courses in India and Abroad</h3>
                                        <ul class="mega-menu-item">
                                            <li><a href="course.php?slug=bca"><img src="images/BCA.png" alt=""> BCA</a></li>
                                            <li><a href="course.php?slug=bcom"><img src="images/B.COM.png" alt=""> B.com</a>
                                            </li>
                                            <li><a href="course.php?slug=btech"> <img src="images/B.TECH.png" alt=""> B.tech</a>
                                            </li>
                                            <li><a href="course.php?slug=bba"> <img src="images/BBA.png" alt=""> BBA</a></li>
                                            <li><a href="course.php?slug=bajmc"><img src="images/BA-JMC.png" alt=""> BA-jmc</a>
                                            </li>
                                            <li><a href="course.php?slug=medical"><img src="images/B.PHARMA.png" alt="">
                                                    B.Pharma</a></li>
                                            <li><a href="course.php?slug=bed"><img src="images/B.Ed.png" alt=""> B.Ed</a></li>
                                            <li><a href="course.php?slug=baeng"><img src="images/BA-ENG.png" alt=""> BA-Eng</a>
                                            </li>
                                            <li><a href="course.php?slug=baeco"><img src="images/BA-ECO.png" alt=""> BA-Eco</a>
                                            </li>
                                            <li><a href="course.php?slug=ballb"><img src="images/BA-LLB.png" alt=""> BA-LLB</a>
                                            </li>
                                            <li><a href="course.php?slug=bballb"><img src="images/BBA-LLB.png" alt=""> BBA-LLB</a>
                                            </li>

                                        </ul>
                                    </div>
                                    <div class="col-lg-12 col-xl-6 col-xxl-6 single-mega-item">
                                        <ul class="mega-menu-item">
                                            <li><a href="course.php?slug=medical"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/medical.webp"
                                                        alt="">Medical</a></li>
                                            <li><a href="course.php?slug=engineering"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/engineering.webp"
                                                        alt="">Engineering</a></li>
                                            <li><a href="course.php?slug=management"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/management.webp"
                                                        alt="">Business and Management</a></li>
                                            <li><a href="course.php?slug=architecture"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/architecture.webp"
                                                        alt=""> Architecture</a></li>
                                            <li><a href="course.php?slug=commerce"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/commerce.webp"
                                                        alt="">Commerce</a></li>
                                            <li><a href="course.php?slug=aviation"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/aviation.webp"
                                                        alt="">Aviation</a></li>
                                            <li><a href="course.php?slug=hotel"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/hotel.webp"
                                                        alt="">Hotel Management</a></li>
                                            <li><a href="course.php?slug=humanities"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/arts.webp"
                                                        alt="">Humanities</a></li>
                                            <li><a href="course.php?slug=journalism"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/masscom.png"
                                                        alt="">Journalism, Media and Mass Comm</a></li>
                                            <li><a href="course.php?slug=law"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/law.webp"
                                                        alt="">Law</a></li>
                                            <li><a href="course.php?slug=languages"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/language.png"
                                                        alt="">Languages and Teaching</a></li>
                                            <li><a href="course.php?slug=design"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/design.webp"
                                                        alt=""> Arts and Design</a></li>
                                            <li><a href="course.php?slug=socialsciences"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/Science.png"
                                                        alt="">Social Sciences</a></li>
                                            <li><a href="course.php?slug=agriculture"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/Agriculture.webp"
                                                        alt="">Agriculture and Forestry</a></li>
                                            <li><a href="course.php?slug=computerscience"><img
                                                        src="https://www.bookmyuniversity.com/images/courseicon/Science.webp"
                                                        alt="">Computer Science and IT</a> </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- End Mega Menu  -->
                    </li>

                    <li class="has-dropdown has-menu-child-item">
                        <a href="#">University
                            <i class="feather-chevron-down"></i>
                        </a>
                        <ul class="submenu">
                            <li class="has-dropdown has-menu-child-item">
                                <a href="#">Study in India
                                </a>
                                <ul class="submenu">
                                    <li><a href="university-of-delhi.html">University of Delhi-NCR</a></li>
                                    <li><a href="ipu.html">GGSIPU in Delhi-NCR</a></li>
                                    <li><a href="top_reputed.html"> Top Reputed Universities</a>
                                    </li>

                                </ul>
                            </li>

                    
                    <li><a href="studyinireland.html">Study in Abroad</a>

                    </li>
                </ul>
                </li>

                <li class="has-dropdown has-menu-child-item">
                    <a href="#">Countries
                        <i class="feather-chevron-down"></i>
                    </a>
                    <ul class="submenu">
                        <li><a href="#"> <img src="images/India.png" alt=""> India</a>

                        </li>
                        <li><a href="#"> <img src="images/uk.png" alt=""> United-Kingdom</a>

                        </li>
                        <li><a href="#"><img src="images/usa.png" alt=""> USA</a></li>
                        <li><a href="#"> <img src="images/ire.png" alt=""> Ireland</a></li>
                        <li><a href="#"> <img src="images/can.png" alt=""> Canada</a></li>
                        <li><a href="#"><img src="images/dub.png" alt="">Dubai</a></li>

                    </ul>
                </li>

                <li>
                    <a href="contact.html">Medical</a>
                    

                </li>
                <li>
                    <a href="blog.html">Blog</a>
                </li>

                </ul>
            </nav>

            <div class="mobile-menu-bottom">
                <div class="rbt-btn-wrapper mb--20">
                    <a target="_blank"
                        class="rbt-btn btn-border-gradient radius-round btn-sm hover-transform-none w-100 justify-content-center text-center"
                        href="contact.html">
                        <span>Register</span>
                    </a>
                </div>

                <div class="social-share-wrapper">
                    <span class="rbt-short-title d-block">Find With Us</span>
                    <ul class="social-icon social-default transparent-with-border justify-content-start mt--20">
                        <li><a href="https://www.facebook.com/edusprayIndia1/">
                                <i class="feather-facebook"></i>
                            </a>
                        </li>
                        <li><a href="https://www.twitter.com">
                                <i class="feather-twitter"></i>
                            </a>
                        </li>
                        <li><a href="https://www.instagram.com/edusprayIndia/">
                                <i class="feather-instagram"></i>
                            </a>
                        </li>
                        <li><a href="https://www.linkedin.com/feed/?trk=onboarding-landing">
                                <i class="feather-linkedin"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <div id="whats_icon">
        <a href="https://wa.me/+918595684716" style=" width: 70px;
        height:70px;
        position: fixed;
        bottom: 30px;
        left: 30px;
        z-index: 99999;
        display: block;
        object-fit: cover;"><img
                src="https://res.cloudinary.com/dxhwn8am2/image/upload/v1701074747/png-clipart-phone-logo-whatsapp-computer-icons-blackberry-10-mobile-phones-instant-messaging-icon-whatsapp-grass-symbol-removebg-preview_qrw0p0.png"
                alt=""></a>
    </div>
    <!-- Start Banner Area -->
    <div class="rbt-banner-area rbt-banner-7 bg-gradient-1 theme-shape header-transperent-spacer">
        <div class="wrapper w-100">
            <div class="container">
                <div class="row g-5 justify-content-between align-items-center">
                    <div class="col-lg-6 order-2 order-lg-1">
                        <div class="content">
                            <div class="inner">
                                <div class="section-title text-start">
                                    <span class="subtitle bg-primary-opacity">WELCOME TO EDUSPRAY</span>
                                </div>
                                <h1 class="title">Do <span class="theme-gradient">You Want</span>
                                    Study in India and Abroad with<span class="theme-gradient"> Eduspray </span> India.
                                </h1>
                                <div class="rbt-like-total">
                                    <div class="profile-share">
                                        <a href="#" class="avatar" data-tooltip="Umama Khan" tabindex="0"><img
                                                src="images/umma.jpg" alt="education"></a>
                                                <a href="#" class="avatar" data-tooltip="Khushboo" tabindex="0"><img
                                                    src="images/khusboo.jpg" alt="education"></a>
                                        <a href="#" class="avatar" data-tooltip="Gurman Singh" tabindex="0"><img
                                                src="images/gurman.jpg" alt="education"></a>
                                       
                                        <div class="more-author-text">
                                            <h5 class="total-join-students">Join Over 5000+ Students</h5>
                                            <p class="subtitle">These people are got top 10 universities with eduspray.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="rbt-button-group justify-content-start mt--30">
                                    <a href="contact.html" target="_blank" class="rbt-btn btn-gradient rbt-switch-btn">
                                        <span data-text="Get Free Counselling">Get Free Counselling</span>
                                    </a>
                                    <a class="rbt-btn btn-border rbt-switch-btn" href="#">
                                        <span data-text="Find University">Find University</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2">
                        <div class="thumbnail-wrapper" id="hero_img">
                            <div class="thumbnail text-end">
                                <img src="images/clg-girl.png" alt="Eduspray India Banner Image">
                            </div>
                            <a href="https://www.google.com/search?q=eduspray+India&oq=eduspray+India&gs_lcrp=EgZjaHJvbWUyBggAEEUYOTIGCAEQRRg8MgYIAhBFGDzSAQgzNTA0ajBqN6gCALACAA&sourceid=chrome&ie=UTF-8#"
                                target="_blank">
                                <div class="card-info bounce-slide">
                                    <div class="inner">
                                        <div class="name">Eduspray India.</div>
                                        <div class="rating-wrapper d-block d-sm-flex">
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half"></i>
                                            </div>
                                            <span> 4.8 (Google Review)</span>
                                        </div>
                                    </div>
                                    <div class="notify-icon">
                                        <img src='images/font.png' style="width: 70px; height: 70px;"
                                            alt="Banner image">
                                    </div>
                                </div>
                            </a>

                        </div>
                        <div id="anim-img">
                            <img src="https://html.creativegigstf.com/zoomy/assets/img/icon/02.svg" id="anim1" alt="">
                            <img src="https://html.creativegigstf.com/zoomy/assets/img/icon/06.svg" id="anim2" alt="">
                            <img src="https://html.creativegigstf.com/zoomy/assets/img/shape/zigzg-1.svg" id="anim3"
                                alt="">
                            <img src="https://html.creativegigstf.com/zoomy/assets/img/shape/dot-box-2.svg" id="anim4"
                                alt="">
                            <img src="https://themeholy.com/html/edura/demo/assets/img/update1/hero/shape_2_1.png"
                                id="anim5" alt="">
                            <img src="https://html.creativegigstf.com/zoomy/assets/img/icon/03.svg"
                                class="d-block d-md-none " id="anim6" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Banner Area -->

    <?php
    $notification_banner_is_home = true;
    require_once __DIR__ . '/includes/notification_banner.php';
    ?>

    <?php 
    // Render University of Delhi-NCR cards
    $delhiCards = isset($collegeCardsByCategory['University of Delhi-NCR']) ? $collegeCardsByCategory['University of Delhi-NCR'] : [];
    if (!empty($delhiCards)) {
        echo renderCollegeCards($delhiCards, 'Top 10 Colleges in University of Delhi-NCR');
    } else {
        // Fallback to original hardcoded content if no database entries
    ?>
    <div class="rbt-categories-area bg-color-extra2">

        <div class="slider-parent">
            <div class="col-lg-12">
                <div class="section-title text-center">
                    <h2 class="title pt-5">Top 10 Colleges in University of Delhi-NCR</h2>
                </div>
            </div>
            <div class="multiple-items">
                <!-- Start Category Box Layout  -->
                <div>
                    <div class="rbt-cat-box rbt-cat-box-1 variation-3 text-center" id="slider-item">
                        <div class="inner">
                            <div class="thumbnail">
                                <a href="contact.html" target="_blank">
                                    <img src="https://tsusjammu.org/wp-content/uploads/2017/07/college_commerce.jpg"
                                        alt="SRCC College">
                                    <div class="read-more-btn">
                                        <span class="rbt-btn btn-sm btn-white radius-round">Apply</span>
                                    </div>
                                </a>
                            </div>
                            <div class="content">
                                <h5 class="title"><a href="contact.html" target="_blank">1. shri ram college of commerce
                                    </a></h5>
                                <p class="description">Shri Ram College of Commerce or SRCC is an Indian Higher
                                    Education Institution in the fields of commerce, economics and business management.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Category Box Layout  -->
                <div>
                    <div class="rbt-cat-box rbt-cat-box-1 variation-3 text-center">
                        <div class="inner">
                            <div class="thumbnail">
                                <a href="contact.html" target="_blank">
                                    <img src="https://miro.medium.com/v2/resize:fit:800/0*vfd-5ffMhqhdb8rp.jpg"
                                        alt="St. Stephen's College">
                                    <div class="read-more-btn">
                                        <span class="rbt-btn btn-sm btn-white radius-round">Apply</span>
                                    </div>
                                </a>
                            </div>
                            <div class="content">
                                <h5 class="title"><a href="contact.html" target="_blank">2. St. Stephen's College</a>
                                </h5>
                                <p class="description">St. Stephen's College is a constituent college of the University
                                    of Delhi-NCR. Awarding both undergraduate and postgraduate degrees, it is regarded as
                                    the most prestigious liberal arts college in India. </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Start Category Box Layout  -->
                <div>
                    <div class="rbt-cat-box rbt-cat-box-1 variation-3 text-center">
                        <div class="inner">
                            <div class="thumbnail">
                                <a href="contact.html" target="_blank">
                                    <img src="https://static.toiimg.com/thumb/msid-104844229,width-1280,height-720,resizemode-4/104844229.jpg"
                                        alt="hindu College">
                                    <div class="read-more-btn">
                                        <span class="rbt-btn btn-sm btn-white radius-round">Apply</span>
                                    </div>
                                </a>
                            </div>
                            <div class="content">
                                <h5 class="title"><a href="contact.html" target="_blank">3. Hindu College</a>
                                </h5>
                                <p class="description">Hindu College is a constituent college of the University of Delhi-NCR in New Delhi-NCR, India. Founded in 1899, it is one of India’s oldest and most renowned colleges. It is ranked second best among colleges in India as per the latest National Institute Ranking Framework (NIRF). </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Category Box Layout  -->
                <div>
                    <div class="rbt-cat-box rbt-cat-box-1 variation-3 text-center">
                        <div class="inner">
                            <div class="thumbnail">
                                <a href="contact.html" target="_blank">
                                    <img src="https://www.hansrajcollege.in/wp-content/uploads/2015/03/1413891676.jpg"
                                        alt="Hans Raj College">
                                    <div class="read-more-btn">
                                        <span class="rbt-btn btn-sm btn-white radius-round">Apply</span>
                                    </div>
                                </a>
                            </div>
                            <div class="content">
                                <h5 class="title"><a href="contact.html" target="_blank">4. Hans Raj College</a></h5>
                                <p class="description">Hansraj College is a constituent college of the University of Delhi-NCR, in Delhi-NCR, India. Established in 1948 and situated in the Delhi-NCR University North Campus, it is considered as one of the best colleges in India.
                                    Miranda House is a constituent college for women at the University of Delhi-NCR in India. Established in 1948, it is one of the top ranked colleges of the country and ranked as number 1 for consecutively seven years.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Start Category Box Layout  -->
                <div>
                    <div class="rbt-cat-box rbt-cat-box-1 variation-3 text-center">
                        <div class="inner">
                            <div class="thumbnail">
                                <a href="contact.html" target="_blank">
                                    <img src="https://images.shiksha.com/mediadata/images/1610521322phpbKg4OR.png"
                                        alt="Kirori mal college">
                                    <div class="read-more-btn">
                                        <span class="rbt-btn btn-sm btn-white radius-round">Apply</span>
                                    </div>
                                </a>
                            </div>
                            <div class="content">
                                <h5 class="title"><a href="contact.html" target="_blank">5. Kirori Mal College</a></h5>
                                <p class="description">Kirori Mal College is a constituent college of the University of
                                    Delhi-NCR. It is ranked 2nd best college for Political Science and 6th best college for
                                    Chemistry in India according to India Today 2023 College Ranking. </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Start Category Box Layout  -->
                <div>
                    <div class="rbt-cat-box rbt-cat-box-1 variation-3 text-center">
                        <div class="inner">
                            <div class="thumbnail">
                                <a href="contact.html" target="_blank">
                                    <img src="images/ramjascollege.png"
                                        alt="ramjas colleges">
                                    <div class="read-more-btn">
                                        <span class="rbt-btn btn-sm btn-white radius-round">Apply</span>
                                    </div>
                                </a>
                            </div>
                            <div class="content">
                                <h5 class="title"><a href="contact.html" target="_blank">6. Ramjas College</a>
                                </h5>
                                <p class="description">Ramjas College is a college of the University of Delhi-NCR located in North Campus of the university in New Delhi-NCR, India.The college admits both undergraduates and post-graduates, 
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Category Box Layout  -->
                <div>
                    <div class="rbt-cat-box rbt-cat-box-1 variation-3 text-center">
                        <div class="inner">
                            <div class="thumbnail">
                                <a href="contact.html" target="_blank">
                                    <img src="https://images.shiksha.com/mediadata/images/1491465043phpiMaIek.jpeg"
                                        alt="Mirinda House College">
                                    <div class="read-more-btn">
                                        <span class="rbt-btn btn-sm btn-white radius-round">Apply</span>
                                    </div>
                                </a>
                            </div>
                            <div class="content">
                                <h5 class="title"><a href="contact.html" target="_blank">7. Mirinda House
                                    </a></h5>
                                <p class="description">Miranda House is a constituent college for women at the
                                    University of Delhi-NCR in India. Established in 1948.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="rbt-cat-box rbt-cat-box-1 variation-3 text-center">
                        <div class="inner">
                            <div class="thumbnail">
                                <a href="contact.html" target="_blank">
                                    <img src="https://static.toiimg.com/thumb/msid-80896994,width-1280,height-720,resizemode-4/80896994.jpg"
                                        alt="Sri Venkateswara College">
                                    <div class="read-more-btn">
                                        <span class="rbt-btn btn-sm btn-white radius-round">Apply</span>
                                    </div>
                                </a>
                            </div>
                            <div class="content">
                                <h5 class="title"><a href="contact.html" target="_blank">8.Sri Venkateswara College</a>
                                </h5>
                                <p class="description">Sri Venkateswara College is a constituent college of the
                                    University of Delhi-NCR established in 1961 in New Delhi-NCR, India. It is managed by
                                    Tirumala Tirupati Devasthanams & UGC and awards degrees under the purview of the
                                    University of Delhi-NCR </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="rbt-cat-box rbt-cat-box-1 variation-3 text-center">
                        <div class="inner">
                            <div class="thumbnail">
                                <a href="contact.html" target="_blank">
                                    <img src="https://media.licdn.com/dms/image/C511BAQHGdJvkqZs_7g/company-background_10000/0/1584451986668/college_of_vocational_studies_cover?e=2147483647&v=beta&t=js3lBrmteW4umh634UzBe9ioBno4n_mTmnGVmiT9aTs"
                                        alt=" College of Vocational
                                        Studies Colleges">
                                    <div class="read-more-btn">
                                        <span class="rbt-btn btn-sm btn-white radius-round">Apply</span>
                                    </div>
                                </a>
                            </div>
                            <div class="content">
                                <h5 class="title"><a href="contact.html" target="_blank">9. College of Vocational
                                        Studies </a> </h5>
                                <p class="description">The College of Vocational Studies is a constituent
                                    college of the University of Delhi-NCR. It is a co-educational college founded
                                    in 1972 with emphasis on vocational education to bridge the gap between.
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Category Box Layout  -->
                <div>
                    <div class="rbt-cat-box rbt-cat-box-1 variation-3 text-center">
                        <div class="inner">
                            <div class="thumbnail">
                                <a href="contact.html" target="_blank">
                                    <img src="https://tsusjammu.org/wp-content/uploads/2017/07/lsr.jpg"
                                        alt="Lady Shri Ram College">
                                    <div class="read-more-btn">
                                        <span class="rbt-btn btn-sm btn-white radius-round">Apply</span>
                                    </div>
                                </a>
                            </div>
                            <div class="content">
                                <h5 class="title"><a href="contact.html" target="_blank">10. Lady Shri Ram College For
                                        Women</h5>
                                <p class="description">Lady Shri Ram College for Women, has long been recognized as a premier institution of higher learning for women in India. Founded in 1956, Constituent women's college of the University of Delhi-NCR for Social Sciences, Humanities and Commerce </p>
                            </div>
                        </div>
                    </div>
                </div>







            </div>
        </div>
    </div>
    <?php } ?>







    <?php 
    // Render IPU cards
    $ipuCards = isset($collegeCardsByCategory['IPU']) ? $collegeCardsByCategory['IPU'] : [];
    if (!empty($ipuCards)) {
        echo renderCollegeCards($ipuCards, 'Top 10 Colleges in IPU');
    } else {
        // Fallback to original hardcoded content if no database entries
    ?>
    <div class="rbt-categories-area bg-color-extra2">
        <div class="slider-parent">
            <div class="col-lg-12">
                <div class="section-title text-center">
                    <h2 class="title pt-5">Top 10 Colleges in IPU</h2>
                </div>
            </div>
            <div class="multiple-items">
                <p class="text-center py-5">No IPU colleges found. Please add them through the admin panel.</p>
            </div>
        </div>
    </div>
    <?php } ?>



























    <?php 
    // Render UK cards
    $ukCards = isset($collegeCardsByCategory['UK']) ? $collegeCardsByCategory['UK'] : [];
    if (!empty($ukCards)) {
        echo renderCollegeCards($ukCards, 'Top 10 Universities in UK');
    } else {
        // Fallback to original hardcoded content if no database entries
    ?>
    <div class="rbt-categories-area bg-color-extra2">
        <div class="slider-parent">
            <div class="col-lg-12">
                <div class="section-title text-center">
                    <h2 class="title pt-5">Top 10 Universities in UK</h2>
                </div>
            </div>
            <div class="multiple-items">
                <p class="text-center py-5">No UK universities found. Please add them through the admin panel.</p>
            </div>
        </div>
    </div>
    <?php } ?>
    <!-- Start Card Style -->
    <div class="rbt-course-card-area rbt-section-gap bg-color-white">
        <div class="container">
            <div class="row align-items-center mb--60">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <span class="subtitle bg-pink-opacity">Popular Countries</span>
                        <h2 class="title">Popular Study in Abroad</h2>
                    </div>
                </div>
            </div>
            <!-- Start Card Area -->
            <div class="row g-5">
                <!-- Start Single Card  -->
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12" data-sal-delay="150" data-sal="slide-up"
                    data-sal-duration="800">
                    <div class="rbt-card variation-03 rbt-hover">
                        <div class="rbt-card-img">
                            <a class="thumbnail-link" href="uk.html">
                                <img src="https://img.freepik.com/premium-photo/education-gesture-people-concept-happy-female-student-mortar-board-bachelor-gown-with-diploma-celebrating-successful-graduation-british-flag-background_380164-166671.jpg?w=826"
                                    alt="Card image">
                                <span class="rbt-btn btn-white icon-hover btn-md">
                                    <span class="btn-text">Read More</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </span>
                            </a>
                        </div>
                        <div class="rbt-card-body">
                            <h5 class="rbt-card-title"><a href="uk.html" target="_blank">Study in UK</a>
                            </h5>
                            <div class="rbt-card-bottom">
                                <a class="transparent-button" href="course-details.html"><i><svg width="17" height="12"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g stroke="#27374D" fill="none" fill-rule="evenodd">
                                                <path d="M10.614 0l5.629 5.629-5.63 5.629" />
                                                <path stroke-linecap="square" d="M.663 5.572h14.594" />
                                            </g>
                                        </svg></i></a>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- End Single Card  -->
                <!-- Start Single Card  -->
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12" data-sal-delay="150" data-sal="slide-up"
                    data-sal-duration="800">
                    <div class="rbt-card variation-03 rbt-hover">
                        <div class="rbt-card-img">
                            <a class="thumbnail-link" href="course-details.html">
                                <img src="https://img.freepik.com/free-photo/happy-four-students-relaxing-nature-with-american-flag-celebrating-4th-july_496169-118.jpg?w=740&t=st=1699636090~exp=1699636690~hmac=4b6e7be47dd0265e82feb8f96f981306aa7c16a3fd96a5813f1331e5261b8cd7"
                                    alt="Card image">
                                <span class="rbt-btn btn-white icon-hover btn-md">
                                    <span class="btn-text">Read More</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </span>
                            </a>
                        </div>
                        <div class="rbt-card-body">
                            <h5 class="rbt-card-title"><a href="course-details.html">Study in USA</a>
                            </h5>
                            <div class="rbt-card-bottom">
                                <a class="transparent-button" href="course-details.html"><i><svg width="17" height="12"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g stroke="#27374D" fill="none" fill-rule="evenodd">
                                                <path d="M10.614 0l5.629 5.629-5.63 5.629" />
                                                <path stroke-linecap="square" d="M.663 5.572h14.594" />
                                            </g>
                                        </svg></i></a>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- End Single Card  -->



                <!-- Start Single Card  -->
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12" data-sal-delay="150" data-sal="slide-up"
                    data-sal-duration="800">
                    <div class="rbt-card variation-03 rbt-hover">
                        <div class="rbt-card-img">
                            <a class="thumbnail-link" href="studyinireland.html">
                                <img src="https://img.freepik.com/premium-photo/composite-image-female-college-student-with-books-park_1134-34984.jpg?w=740"
                                    alt="Card image">
                                <span class="rbt-btn btn-white icon-hover btn-md">
                                    <span class="btn-text">Read More</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </span>
                            </a>
                        </div>
                        <div class="rbt-card-body">
                            <h5 class="rbt-card-title"><a href="studyinireland.html">Study in Ireland</a>
                            </h5>
                            <div class="rbt-card-bottom">
                                <a class="transparent-button" href="studyinireland.html"><i><svg width="17" height="12"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g stroke="#27374D" fill="none" fill-rule="evenodd">
                                                <path d="M10.614 0l5.629 5.629-5.63 5.629" />
                                                <path stroke-linecap="square" d="M.663 5.572h14.594" />
                                            </g>
                                        </svg></i></a>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- End Single Card  -->

                <!-- Start Single Card  -->
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12" data-sal-delay="150" data-sal="slide-up"
                    data-sal-duration="800">
                    <div class="rbt-card variation-03 rbt-hover">
                        <div class="rbt-card-img">
                            <a class="thumbnail-link" href="course-details.html">
                                <img src="https://img.freepik.com/free-photo/young-chinese-girl-exchange-student-holding-canada-flag-afraid-shocked-with-surprise-amazed-expression-fear-excited-face_839833-11335.jpg?w=740&t=st=1699636803~exp=1699637403~hmac=3a4e3b6e7e8a0b528985a42172a1bd2a303a90cbc27b0a0d5fa675c097552d4b"
                                    alt="Card image">
                                <span class="rbt-btn btn-white icon-hover btn-md">
                                    <span class="btn-text">Read More</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </span>
                            </a>
                        </div>
                        <div class="rbt-card-body">
                            <h5 class="rbt-card-title"><a href="course-details.html">Study in Canada</a>
                            </h5>
                            <div class="rbt-card-bottom">
                                <a class="transparent-button" href="course-details.html"><i><svg width="17" height="12"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g stroke="#27374D" fill="none" fill-rule="evenodd">
                                                <path d="M10.614 0l5.629 5.629-5.63 5.629" />
                                                <path stroke-linecap="square" d="M.663 5.572h14.594" />
                                            </g>
                                        </svg></i></a>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- End Single Card  -->

                <!-- Start Single Card  -->
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12" data-sal-delay="150" data-sal="slide-up"
                    data-sal-duration="800">
                    <div class="rbt-card variation-03 rbt-hover">
                        <div class="rbt-card-img">
                            <a class="thumbnail-link" href="course-details.html">
                                <img src="https://img.freepik.com/free-photo/hands-waving-flags-united-arab-emirates_53876-21110.jpg?w=740&t=st=1699637022~exp=1699637622~hmac=b5be9a66849505ca6c68f02b60e5661a29b30387308fdc49a07e266eb8615c72"
                                    alt="Card image">
                                <span class="rbt-btn btn-white icon-hover btn-md">
                                    <span class="btn-text">Read More</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </span>
                            </a>
                        </div>
                        <div class="rbt-card-body">
                            <h5 class="rbt-card-title"><a href="course-details.html">Study in Dubai</a>
                            </h5>
                            <div class="rbt-card-bottom">
                                <a class="transparent-button" href="course-details.html"><i><svg width="17" height="12"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g stroke="#27374D" fill="none" fill-rule="evenodd">
                                                <path d="M10.614 0l5.629 5.629-5.63 5.629" />
                                                <path stroke-linecap="square" d="M.663 5.572h14.594" />
                                            </g>
                                        </svg></i></a>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- End Single Card  -->

                <!-- Start Single Card  -->
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12" data-sal-delay="150" data-sal="slide-up"
                    data-sal-duration="800">
                    <div class="rbt-card variation-03 rbt-hover">
                        <div class="rbt-card-img">
                            <a class="thumbnail-link" href="course-details.html">
                                <img src="https://img.freepik.com/premium-photo/teen-student-smiling-german-flag_87414-4210.jpg?w=826"
                                    alt="Card image">
                                <span class="rbt-btn btn-white icon-hover btn-md">
                                    <span class="btn-text">Read More</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </span>
                            </a>
                        </div>
                        <div class="rbt-card-body">
                            <h5 class="rbt-card-title"><a href="course-details.html">Study in Germany</a>
                            </h5>
                            <div class="rbt-card-bottom">
                                <a class="transparent-button" href="course-details.html"><i><svg width="17" height="12"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g stroke="#27374D" fill="none" fill-rule="evenodd">
                                                <path d="M10.614 0l5.629 5.629-5.63 5.629" />
                                                <path stroke-linecap="square" d="M.663 5.572h14.594" />
                                            </g>
                                        </svg></i></a>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- End Single Card  -->
            </div>
            <!-- End Card Area -->
        </div>
    </div>
    <!-- End Card Style -->

    <div class="rbt-counterup-area rbt-section-gapBottom bg-gradient-1">
        <div class="container">
            <div class="row mb--60">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <span class="subtitle bg-primary-opacity">Why Choose Us</span>
                        <h2 class="title">Why Choose Eduspray</h2>
                    </div>
                </div>
            </div>
            <div class="row g-5 hanger-line">
                <!-- Start Single Counter  -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="rbt-counterup rbt-hover-03 border-bottom-gradient">
                        <div class="top-circle-shape"></div>
                        <div class="inner">
                            <div class="rbt-round-icon">
                                <img src="images/counter-01.png" alt="Icons Images">
                            </div>
                            <div class="content">
                                <h3 class="counter"><span class="odometer" data-count="3000">00</span>
                                </h3>
                                <span class="subtitle">Certified Students</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Counter  -->

                <!-- Start Single Counter  -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt--60 mt_md--30 mt_sm--30 mt_mobile--60">
                    <div class="rbt-counterup rbt-hover-03 border-bottom-gradient">
                        <div class="top-circle-shape"></div>
                        <div class="inner">
                            <div class="rbt-round-icon">
                                <img src="images/counter-02.png" alt="Icons Images">
                            </div>
                            <div class="content">
                                <h3 class="counter"><span class="odometer" data-count="700">00</span>
                                </h3>
                                <span class="subtitle"> Courses</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Counter  -->

                <!-- Start Single Counter  -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt_md--60 mt_sm--60">
                    <div class="rbt-counterup rbt-hover-03 border-bottom-gradient">
                        <div class="top-circle-shape"></div>
                        <div class="inner">
                            <div class="rbt-round-icon">
                                <img src="images/counter-03.png" alt="Icons Images">
                            </div>
                            <div class="content">
                                <h3 class="counter"><span class="odometer" data-count="1500">00</span>
                                </h3>
                                <span class="subtitle">Universities</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Counter  -->

                <!-- Start Single Counter  -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt--60 mt_md--30 mt_sm--30 mt_mobile--60">
                    <div class="rbt-counterup rbt-hover-03 border-bottom-gradient">
                        <div class="top-circle-shape"></div>
                        <div class="inner">
                            <div class="rbt-round-icon">
                                <img src="images/counter-04.png" alt="Icons Images">
                            </div>
                            <div class="content">
                                <h3 class="counter"><span class="odometer" data-count="15">00</span>
                                </h3>
                                <span class="subtitle">Year of Experience</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Counter  -->
            </div>
        </div>
    </div>

    <div class="rbt-about-area about-style-1 rbt-section-gapTop pb--30 pb_md--80 pb_sm--80 bg-color-white">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="thumbnail-wrapper">
                        <div class="thumbnail image-1">
                            <img data-parallax="{" x": 0, "y" : -20}"
                                src="images/Why_Stepup_Education.jpg"
                                alt="Education Images">
                        </div>
                        <div class="thumbnail image-2 d-none d-xl-block">
                            <!-- <img data-parallax="{" x": 0, "y" : 60}" src="https://img.freepik.com/premium-photo/low-angle-students-with-diploma_23-2148522290.jpg?size=626&ext=jpg&ga=GA1.1.154645860.1689317304&semt=ais" alt="Education Images"> -->
                        </div>
                        <div class="thumbnail image-3 d-none d-md-block">
                            <!-- <img data-parallax="{" x": 0, "y" : 80}" src="images/about-03.png" alt="Education Images"> -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="inner pl--50 pl_sm--0 pl_md--0">
                        <div class="section-title text-start">
                            <span class="subtitle bg-coral-opacity">Know About Us</span>
                            <h2 class="title" style="text-transform: lowercase;"></h2>
                        </div>

                        <p class="description mt--30"><b>Eduspray India</b> is a trusted<b> educational consultancy in East Delhi,</b> dedicated to guiding <b>12th pass-out students of 2025</b>
                        Our expert counselors assist in selecting the right courses, colleges, and universities based on your career goals, budget, and academic background. Whether you're looking for <b>IP University admissions, private universities,</b> or professional courses, we ensure a smooth and hassle-free process.
                        </p>

                        <!-- Start Feature List  -->

                        <div class="row rbt-feature-wrapper mt--20 ml_dec_20">
                            <div class="col-md-6  mb-3">
                                <!-- <div class="icon bg-pink-opacity">
                                    <i class="feather-heart"></i>
                                </div> -->
                                <div class="feature-content">
                                    <h6>India’s leading overseas educational consultancy
                                    </h6>

                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <!-- <div class="icon bg-primary-opacity">
                                    <i class="feather-book"></i>
                                </div> -->
                                <div class="feature-content">
                                    <h6>8000+ Admissions</h6>

                                </div>
                            </div>

                            <div class="col-md-6  mb-3">

                                <div class="feature-content">
                                    <h6>Seminar's by Expert</h6>

                                </div>
                            </div>

                            <div class="col-md-6  mb-3">

                                <div class="feature-content">
                                    <h6>Verified Information</h6>

                                </div>
                            </div>

                            <div class="col-md-6  mb-3">

                                <div class="feature-content">
                                    <h6>Expert Guidance</h6>

                                </div>
                            </div>

                            <div class="col-md-6  mb-3">

                                <div class="feature-content">
                                    <h6>Transparency</h6>

                                </div>
                            </div>
                        </div>

                        <!-- End Feature List  -->
                        <div class="about-btn mt--40">
                            <a class="rbt-btn btn-gradient hover-icon-reverse" href="about.html" target="_blank">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">More About Us</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials Section - Dynamic -->
    <div class="bg_image bg_image--6 bg_image_fixed rbt-section-gap" data-black-overlay="5" style="padding: 40px 0;">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
                <h1 style="color: #fff; margin: 0; font-size: 28px;">Our Testimonials</h1>
                <a href="testimonials.php" style="color: #fff; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 8px; padding: 10px 20px; background: rgba(255,255,255,0.2); border-radius: 25px; transition: all 0.3s;">
                    View All <i class="feather-arrow-right"></i>
                </a>
            </div>
            <div class="multiple-items testi-parent">
                <?php if (empty($homeTestimonials)): ?>
                <!-- Fallback to original testimonials if database is empty -->
                <div id="testimonial" style="background-color: #fff;">
                    <img src="images/gurman.jpg" alt="Eduspray India Feedback">
                    <div class="rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half"></i>
                    </div>
                    <h1>Gurman Singh</h1>
                    <p><span>"</span>My Name Gurman Singh, My Counselor at Eduspray India Was Highly Professional and Made the Entire Colleges Selection Process Very Smooth. He Was Extremely Helpful. I Would Highly Recommend the Services of Eduspray India for Those Looking for Delhi-NCR University / IP University.<span>"</span></p>
                </div>
                <div id="testimonial" style="background-color: #fff;">
                    <img src="images/client-06.png" alt="Eduspray India Feedback">
                    <div class="rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <h1>Khushboo</h1>
                    <p><span>"</span>My Name Khushboo, Eduspray India is One of the Best Educational Consultancy, I visited them, to Seek Help to Pursue a Bachelor's in Delhi-NCR University. The Counselor Interacts With the Student Personally and Suggests the Best Colleges, Highly Recommend Them.<span>"</span></p>
                </div>
                <div id="testimonial" style="background-color: #fff;">
                    <img src="images/umma.jpg" alt="Eduspray India Feedback">
                    <div class="rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <h1>Umma Khan</h1>
                    <p><span>"</span>My Name Umma Khan, I Had a Good experience With Eduspray India, Special Thanks to My Counselor. His Counselling Was the Best And He Was Friendly With the Student, I Was Nicely Guided in Choosing Universities and Courses Was Hassle-free. I Highly Recommend Eduspray India.<span>"</span></p>
                </div>
                <?php else: ?>
                <?php foreach ($homeTestimonials as $testimonial): 
                    $rating = floatval($testimonial['rating']);
                    $fullStars = floor($rating);
                    $hasHalfStar = ($rating - $fullStars) >= 0.5;
                ?>
                <div id="testimonial" style="background-color: #fff;">
                    <?php if (!empty($testimonial['image']) && file_exists($testimonial['image'])): ?>
                    <img src="<?php echo htmlspecialchars($testimonial['image']); ?>" alt="<?php echo htmlspecialchars($testimonial['name']); ?>">
                    <?php else: ?>
                    <div style="width: 100px; height: 100px; margin: 0 auto 15px; background: linear-gradient(135deg, #0ea5e9, #06b6d4); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: 700;">
                        <?php echo strtoupper(substr($testimonial['name'], 0, 2)); ?>
                    </div>
                    <?php endif; ?>
                    <div class="rating">
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
                    <h1><?php echo htmlspecialchars($testimonial['name']); ?></h1>
                    <p><span>"</span><?php echo htmlspecialchars($testimonial['testimonial_text']); ?><span>"</span></p>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Start Blog Style - Dynamic -->
    <div class="rbt-rbt-blog-area rbt-section-gap bg-gradient-1">
        <div class="container">
            <div class="row mb--55 row--30 align-items-end">
                <div class="col-lg-12">
                    <div class="section-title text-center" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                        <div>
                            <span class="subtitle bg-pink-opacity">Our Posts</span>
                            <h2 class="title">Eduspray India Blog</h2>
                        </div>
                        <a href="blogs.php" style="color: #1a1a2e; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 8px; padding: 10px 20px; background: rgba(26,26,46,0.1); border-radius: 25px; transition: all 0.3s; margin-top: 10px;">
                            View All <i class="feather-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Start Card Area -->
            <div class="row g-5">
                <?php if (empty($homeBlogs)): ?>
                <!-- Fallback to original blogs if database is empty -->
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="rbt-card variation-02 rbt-hover">
                        <div class="rbt-card-img">
                            <a href="blogs.php"><img src="images/Admission.jpg" alt="BEST EDUCATIONAL COUNSULTANCY IN EAST DELHI"></a>
                        </div>
                        <div class="rbt-card-body">
                            <h5 class="rbt-card-title"><a href="blogs.php">Free Admission Guidance For All Courses And University in Delhi-NCR</a></h5>
                            <p class="rbt-card-text">Get free admission guidance for all courses and universities in Delhi-NCR. Expert counseling to help you choose the best college for your future. Contact us today!</p>
                            <div class="rbt-card-bottom">
                                <a class="transparent-button" href="blogs.php">Learn More<i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="#27374D" fill="none" fill-rule="evenodd"><path d="M10.614 0l5.629 5.629-5.63 5.629" /><path stroke-linecap="square" d="M.663 5.572h14.594" /></g></svg></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="rbt-card variation-02 rbt-hover">
                        <div class="rbt-card-img">
                            <a href="blogs.php"><img src="images/B.TECH.jpg" alt="BTECH ADMISSION GUIDANCE 2025"></a>
                        </div>
                        <div class="rbt-card-body">
                            <h5 class="rbt-card-title"><a href="blogs.php">Free Admission Guidance For B.Tech 2025</a></h5>
                            <p class="rbt-card-text">Get free admission guidance for B.Tech 2025! Expert counseling for top colleges, eligibility, and application process. Contact us today!</p>
                            <div class="rbt-card-bottom">
                                <a class="transparent-button" href="blogs.php">Learn More<i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="#27374D" fill="none" fill-rule="evenodd"><path d="M10.614 0l5.629 5.629-5.63 5.629" /><path stroke-linecap="square" d="M.663 5.572h14.594" /></g></svg></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="rbt-card variation-02 rbt-hover">
                        <div class="rbt-card-img">
                            <a href="blogs.php"><img src="images/12th.png" alt="12TH STUDENTS GUIDANCE FOR COLLEGES 2025"></a>
                        </div>
                        <div class="rbt-card-body">
                            <h5 class="rbt-card-title"><a href="blogs.php">Admission Guidance For IP University With - Eduspray India.</a></h5>
                            <p class="rbt-card-text">Get expert admission guidance for IP University with Eduspray India. Secure your spot in top courses with hassle-free counseling. Contact us today!</p>
                            <div class="rbt-card-bottom">
                                <a class="transparent-button" href="blogs.php">Learn More<i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="#27374D" fill="none" fill-rule="evenodd"><path d="M10.614 0l5.629 5.629-5.63 5.629" /><path stroke-linecap="square" d="M.663 5.572h14.594" /></g></svg></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <?php foreach ($homeBlogs as $blog): ?>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="rbt-card variation-02 rbt-hover">
                        <div class="rbt-card-img">
                            <a href="blog-detail.php?slug=<?php echo urlencode($blog['slug']); ?>">
                                <?php if (!empty($blog['featured_image']) && file_exists($blog['featured_image'])): ?>
                                <img src="<?php echo htmlspecialchars($blog['featured_image']); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>">
                                <?php else: ?>
                                <div style="width: 100%; height: 200px; background: linear-gradient(135deg, #0ea5e9, #06b6d4); display: flex; align-items: center; justify-content: center; color: white; font-size: 48px;">
                                    <i class="feather-file-text"></i>
                                </div>
                                <?php endif; ?>
                            </a>
                        </div>
                        <div class="rbt-card-body">
                            <h5 class="rbt-card-title">
                                <a href="blog-detail.php?slug=<?php echo urlencode($blog['slug']); ?>"><?php echo htmlspecialchars($blog['title']); ?></a>
                            </h5>
                            <p class="rbt-card-text"><?php echo htmlspecialchars($blog['excerpt'] ?? substr(strip_tags($blog['content']), 0, 150) . '...'); ?></p>
                            <div class="rbt-card-bottom">
                                <a class="transparent-button" href="blog-detail.php?slug=<?php echo urlencode($blog['slug']); ?>">Learn More<i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="#27374D" fill="none" fill-rule="evenodd"><path d="M10.614 0l5.629 5.629-5.63 5.629" /><path stroke-linecap="square" d="M.663 5.572h14.594" /></g></svg></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <!-- End Card Area -->
        </div>
    </div>
    <!-- End Blog Style -->

    <!-- Start Footer aera -->
    <footer class="rbt-footer footer-style-1 bg-color-white overflow-hidden">
        <div class="footer-top">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="footer-widget">
                            <div class="logo">
                                <a href='/'>
                                    <img src="images/e-logo.jpeg" alt="Eduspray India">
                                </a>
                            </div>

                            <p class="description mt--20">Best Educational Counsellor service for Bachlor's and Master's
                                Degree, We are India's most trusted team of study in India and abroad Counsellors, Delhi-NCR


                            </p>

                            <ul class="social-icon social-default justify-content-start">
                                <li><a href="https://www.facebook.com/profile.php?id=61569643561294#">
                                        <i class="feather-facebook"></i>
                                    </a>
                                </li>
                                <li><a href="https://www.twitter.com">
                                        <i class="feather-twitter"></i>
                                    </a>
                                </li>
                                <li><a href="https://www.instagram.com/edusprayIndia/">
                                        <i class="feather-instagram"></i>
                                    </a>
                                </li>
                                <li><a href="https://www.linkedin.com/feed/?trk=onboarding-landing">
                                        <i class="feather-linkedin"></i>
                                    </a>
                                </li>

                                <li><a href="https://www.youtube.com/@EdusprayIndia">
                                        <i class="feather-youtube"></i>
                                    </a>
                                </li>
                            </ul>

                            <div class="contact-btn mt--30">
                                <a class="rbt-btn hover-icon-reverse btn-border-gradient radius-round"
                                    href="contact.html">
                                    <div class="icon-reverse-wrapper">
                                        <span class="btn-text">Contact With Us</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                        <div class="footer-widget">
                            <h5 class="ft-title">Useful Links</h5>
                            <ul class="ft-link">
                                <li>
                                    <a href="index.html">Eduspray India</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Blog</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Testimonial</a>
                                </li>
                                <li>
                                    <a href="Faq.html">FAQ</a>
                                </li>
                                <li>
                                    <a href="about.html" target="_blank">About Us</a>
                                </li>
                                <li>
                                    <a href="Privacy.html" target="_blank">Privacy policy</a>
                                </li>
                                <li>
                                    <a href="contact.html">Contact Us</a>
                                </li>
                                <li>
                                    <a href="blog.html">Best educational consultancy in East Delhi</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                        <div class="footer-widget">
                            <h5 class="ft-title">Our Company</h5>
                            <ul class="ft-link">
                                <li>
                                    <a href='contact.html'>Contact Us</a>
                                </li>

                                <li>
                                    <a href="blog.html">Study in India</a>
                                </li>
                                <li>
                                    <a href="instructor.html">Study in Abroad</a>
                                </li>

                                <li>
                                    <a href="contact.html" target="_blank">Course</a>
                                </li>
                                <li> 
                                <a href="blog.html">Free Guidance</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="footer-widget">
                            <h5 class="ft-title">Get Contact</h5>
                            <ul class="ft-link">
                                <li><span>Phone:</span> <a href="tel:+91 8595684716">+91 8595684716</a></li>
                                <li><span>E-mail:</span> <a
                                        href="mailto:edusprayIndia@gmail.com">edusprayIndia@gmail.com</a></li>
                            </ul>

                            <form class="newsletter-form mt--20" action="#">
                                <h6 class="w-600">Address:</h6>
                                <p class="description">Office No- 104/105, First Floor, Rishabh Corporate Tower Community
                                    Center, Karkar Duma, Karkardooma, Anand Vihar, Delhi-NCR, 110092</p>

                                <div class="form-group right-icon icon-email mb--20">
                                    <input id="email" name="email" type="email" required placeholder="Enter your email">
                                </div>

                                <div class="form-group mb--0">
                                    <button class="rbt-btn rbt-switch-btn btn-gradient radius-round btn-sm"
                                        type="submit">
                                        <span data-text="Submit Now">Submit Now</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="rbt-separator-mid">
            <div class="container">
                <hr class="rbt-separator m-0">
            </div>
        </div>
        <!-- Start Copyright Area  -->
        <div class="copyright-area copyright-style-1 ptb--20">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="text-center col-12">
                        <p class="rbt-link-hover text-center">Copyright © 2022 <a
                                href="https://eduspray.in">Eduspray India</a> All Rights Reserved</p>
                    </div>

                </div>
            </div>
        </div>
        <!-- End Copyright Area  -->
    </footer>
    <!-- End Footer aera -->
    <div class="rbt-progress-parent">
        <svg class="rbt-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>

    <!-- JS
============================================ -->
    <!-- Modernizer JS -->
    <script src="js/modernizr.min.js"></script>
    <!-- jQuery JS -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap JS -->
    <script src="js/bootstrap.min.js"></script>
    <!-- sal.js -->
    <script src="js/sal.js"></script>
    <script src="js/swiper.js"></script>
    <script src="js/magnify.min.js"></script>
    <script src="js/jquery-appear.js"></script>
    <script src="js/odometer.js"></script>
    <script src="js/backtotop.js"></script>
    <script src="js/isotop.js"></script>
    <script src="js/imageloaded.js"></script>

    <script src="js/wow.js"></script>
    <script src="js/waypoint.min.js"></script>
    <script src="js/easypie.js"></script>
    <script src="js/text-type.js"></script>
    <script src="js/jquery-one-page-nav.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/magnify-popup.min.js"></script>
    <script src="js/paralax-scroll.js"></script>
    <script src="js/paralax.min.js"></script>
    <script src="js/countdown.js"></script>
    <script src="js/plyr.js"></script>
    <!-- Main JS -->
    <script src="js/main.js"></script>
    <script src="js/lead-forms.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.js"
        integrity="sha512-WNZwVebQjhSxEzwbettGuQgWxbpYdoLf7mH+25A7sfQbbxKeS5SQ9QBf97zOY4nOlwtksgDA/czSTmfj4DUEiQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>

        // A $( document ).ready() block.
        $(document).ready(function () {
            $('.multiple-items').slick({
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 3,
                dots: true,
                arrows: false,
                autoplay: true,
                responsive: [

                    {
                        breakpoint: 750,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 586,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }

                ]

            });
        });
    </script>
    
    <!-- User Authentication & Menu Script -->
    <script>
        // Toggle user dropdown
        function toggleUserDropdown() {
            const dropdown = document.getElementById('userDropdown');
            const btn = document.querySelector('.user-menu-btn');
            dropdown.classList.toggle('show');
            btn.classList.toggle('open');
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');
            const btn = document.querySelector('.user-menu-btn');
            if (dropdown && !e.target.closest('.user-menu-dropdown')) {
                dropdown.classList.remove('show');
                if (btn) btn.classList.remove('open');
            }
        });
        
        // Check authentication status on page load
        document.addEventListener('DOMContentLoaded', async function() {
            try {
                const response = await fetch('php/auth_check.php');
                const data = await response.json();
                
                const loginBtn = document.getElementById('loginBtnWrapper');
                const userMenu = document.getElementById('userMenuWrapper');
                
                if (data.logged_in && data.user) {
                    // Add logged-in class to body for CSS fallback
                    document.body.classList.add('user-logged-in');
                    
                    // Show user menu, hide login button
                    if (loginBtn) {
                        loginBtn.classList.add('d-none');
                        loginBtn.classList.remove('d-xl-block');
                    }
                    if (userMenu) {
                        userMenu.classList.remove('d-none');
                        userMenu.classList.add('d-xl-block');
                        
                        // Set user name
                        const nameEl = document.getElementById('userName');
                        const initialEl = document.getElementById('userInitial');
                        const avatarEl = document.getElementById('userAvatar');
                        
                        if (nameEl) nameEl.textContent = data.user.name.split(' ')[0];
                        if (initialEl) initialEl.textContent = data.user.name.charAt(0).toUpperCase();
                        
                        // If user has profile picture (from Google)
                        if (data.user.picture && avatarEl) {
                            avatarEl.innerHTML = '<img src="' + data.user.picture + '" alt="Profile">';
                        }
                    }
                } else {
                    // Show login button, hide user menu (default state is correct, no changes needed)
                    if (loginBtn) {
                        loginBtn.classList.remove('d-none');
                        loginBtn.classList.add('d-xl-block');
                    }
                    if (userMenu) {
                        userMenu.classList.add('d-none');
                        userMenu.classList.remove('d-xl-block');
                    }
                }
            } catch (error) {
                console.log('Auth check failed:', error);
            }
            
            // Track page view
            try {
                fetch('php/track_activity.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        url: window.location.href,
                        title: document.title
                    })
                });
            } catch (e) { /* Silent fail */ }
        });
    </script>
</body>

</html>
