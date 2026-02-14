<?php
/**
 * Dynamic Course Page - Matches index.html design
 * URL: /course.php?slug=btech
 */

require_once 'php/config.php';
require_once 'php/courses_data.php';

// Get course slug from URL
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

if (empty($slug)) {
    header('Location: index.html');
    exit;
}

// Get course from database
try {
    $stmt = $pdo->prepare("SELECT * FROM courses WHERE slug = ? AND status = 'active'");
    $stmt->execute([$slug]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$course) {
        header('Location: index.html');
        exit;
    }
    
    // Get predefined content (fallback if DB fields are empty)
    $content = getCourseContent($slug);
    // Merge with DB content, but DB takes priority
    foreach ($content as $key => $value) {
        if (empty($course[$key])) {
            $course[$key] = $value;
        }
    }
    
    // Get universities offering this course
    $stmt = $pdo->prepare("SELECT * FROM universities WHERE status = 'active' AND JSON_CONTAINS(courses, ?) ORDER BY featured DESC, name ASC");
    $stmt->execute([json_encode($slug)]);
    $universities = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get featured courses for this course page
    $stmt = $pdo->prepare("
        SELECT c.*, fc.display_order 
        FROM featured_courses fc
        INNER JOIN courses c ON fc.featured_course_slug = c.slug
        WHERE fc.course_slug = ? AND fc.status = 'active' AND c.status = 'active'
        ORDER BY fc.display_order ASC, c.name ASC
        LIMIT 8
    ");
    $stmt->execute([$slug]);
    $featuredCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get filter options
    $states = $pdo->query("SELECT DISTINCT state FROM universities WHERE status = 'active' AND state IS NOT NULL ORDER BY state")->fetchAll(PDO::FETCH_COLUMN);
    $types = ['government', 'private', 'deemed', 'autonomous'];
    
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

$pageTitle = $course['name'] . ' - ' . ($course['full_name'] ?? $course['name']) . ' | Eduspray India';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($course['short_description'] ?? 'Learn about ' . $course['name'] . ' courses, eligibility, career options, and top universities.'); ?>">
    <meta name="google-adsense-account" content="ca-pub-1969362058599710">

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
    
    <!-- User Menu Styles & Header Protection -->
    <style>
        /* Minimal fixes to match homepage - only fix sticky placeholder */
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
        /* Add padding to body to account for absolute header */
    
        
        .course-hero-section {
            position: relative;
            z-index: 1;
            margin-top: 0;
            clear: both;
        }
        
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
            background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .user-menu-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(14, 165, 233, 0.4);
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
            background: #f0f9ff;
            color: #0ea5e9;
        }
        .user-dropdown a i {
            font-size: 16px;
            width: 20px;
            text-align: center;
        }
        
        body.user-logged-in #loginBtnWrapper {
            display: none !important;
        }
        
        body.user-logged-in #userMenuWrapper {
            display: block !important;
        }
        
        /* Course Page Specific Styles - Tabbed Interface */
        .course-hero-section {
            background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
            padding: 25px 0 20px;
            color: white;
        }
        
        .course-hero-content h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
            color: white;
            line-height: 1.3;
        }
        
        .course-hero-content .subtitle {
            font-size: 13px;
            opacity: 0.95;
            margin: 0 0 12px 0;
            line-height: 1.4;
        }
        
        .course-hero-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 12px;
        }
        
        .hero-action-btn {
            padding: 6px 12px;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 4px;
            color: white;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .hero-action-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }
        
        .hero-action-btn.primary {
            background: white;
            color: #0ea5e9;
            border-color: white;
        }
        
        .hero-action-btn.primary:hover {
            background: #f0f9ff;
            color: #0284c7;
        }
        
        .badge-open {
            display: inline-block;
            padding: 4px 8px;
            background: #10b981;
            color: white;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            margin-left: 8px;
        }
        
        .course-meta-cards {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
            flex-wrap: wrap;
        }
        
        .meta-card {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            padding: 6px 10px;
            border-radius: 6px;
            text-align: center;
            min-width: 65px;
        }
        
        .meta-card i {
            font-size: 14px;
            margin-bottom: 3px;
            display: block;
        }
        
        .meta-card .label {
            font-size: 9px;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-top: 2px;
        }
        
        .meta-card .value {
            font-size: 11px;
            font-weight: 700;
        }
        
        /* Tabbed Interface - Modern Design */
        .course-tabs-container {
            padding: 30px 0 50px;
            background: #f8f9fa;
        }
        
        .course-tabs-wrapper {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        
        .course-tabs-nav {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 4px;
            background: #f8f9fa;
            border-radius: 8px 8px 0 0;
            gap: 3px;
            flex-wrap: wrap;
        }
        
        .course-tabs-nav li {
            flex: 0 0 auto;
            min-width: fit-content;
        }
        
        .tab-btn {
            padding: 6px 12px;
            background: transparent;
            border: none;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: center;
            position: relative;
            overflow: hidden;
            white-space: nowrap;
            min-height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .tab-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 5px;
        }
        
        .tab-btn span {
            position: relative;
            z-index: 1;
        }
        
        .tab-btn:hover {
            color: #0ea5e9;
            transform: translateY(-1px);
        }
        
        .tab-btn:hover::before {
            opacity: 0.08;
        }
        
        .tab-btn.active {
            background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(14, 165, 233, 0.3);
            transform: translateY(-1px);
        }
        
        .tab-btn.active::before {
            opacity: 1;
        }
        
        .tab-btn.active:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(14, 165, 233, 0.4);
        }
        
        .tab-btn:hover::before {
            background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
        }
        
        .course-tabs-content {
            position: relative;
            min-height: 400px;
        }
        
        .tab-pane {
            display: none;
            padding: 30px;
        }
        
        .tab-pane.active {
            display: block;
        }
        
        .tab-content-inner {
            line-height: 1.8;
            font-size: 15px;
            color: #555;
        }
        
        .tab-content-inner ul {
            font-size: 15px;
        }
        
        .tab-content-inner li {
            line-height: 1.8;
            margin-bottom: 10px;
        }
        
        .tab-content-inner h4 {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a2e;
            margin: 25px 0 15px;
            line-height: 1.4;
        }
        
        .tab-content-inner h4:first-child {
            margin-top: 0;
        }
        
        .tab-content-inner p {
            margin-bottom: 15px;
            font-size: 15px;
            line-height: 1.7;
            color: #555;
        }
        
        .tab-content-inner ul {
            padding-left: 20px;
            margin-bottom: 12px;
        }
        
        .tab-content-inner li {
            margin-bottom: 8px;
        }
        
        .tab-content-inner strong {
            color: #0ea5e9;
        }
        
        /* What's New Section - Horizontal Scrolling Ticker */
        .whats-new-section {
            background: white;
            padding: 15px 0;
            border-bottom: 1px solid #e5e7eb;
            overflow: hidden;
            position: relative;
        }
        
        .whats-new-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
        }
        
        .whats-new-header h2 {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a2e;
            margin: 0;
            white-space: nowrap;
        }
        
        .whats-new-ticker {
            display: flex;
            gap: 30px;
            animation: scrollTicker 30s linear infinite;
            width: max-content;
        }
        
        .whats-new-ticker:hover {
            animation-play-state: paused;
        }
        
        @keyframes scrollTicker {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }
        
        .update-item {
            display: inline-flex;
            align-items: center;
            gap: 15px;
            padding: 8px 15px;
            background: #f8f9fa;
            border-radius: 6px;
            border-left: 3px solid #0ea5e9;
            white-space: nowrap;
            min-width: max-content;
        }
        
        .update-item h3 {
            font-size: 13px;
            font-weight: 600;
            color: #1a1a2e;
            margin: 0;
        }
        
        .update-item h3 a {
            color: #1a1a2e;
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .update-item h3 a:hover {
            color: #0ea5e9;
        }
        
        .update-meta {
            font-size: 11px;
            color: #666;
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .update-author {
            font-weight: 500;
        }
        
        .update-date {
            color: #999;
        }
        
        /* Duplicate items for seamless loop */
        .whats-new-ticker::after {
            content: '';
            display: none;
        }
        
        /* Key Information Table - Side by Side Layout */
        .key-info-section {
            background: #f8f9fa;
            padding: 25px 0;
        }
        
        .key-info-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .key-info-left,
        .key-info-right {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 5px rgba(0,0,0,0.05);
        }
        
        .key-info-section h2 {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 15px;
        }
        
        .specializations-section h2 {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 15px;
        }
        
        .key-info-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .key-info-table th {
            background: #f8f9fa;
            padding: 8px 12px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            color: #1a1a2e;
            border-bottom: 2px solid #e5e7eb;
            width: 35%;
        }
        
        .key-info-table td {
            padding: 8px 12px;
            font-size: 11px;
            color: #555;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .key-info-table tr:last-child td {
            border-bottom: none;
        }
        
        /* Specializations Section - Now in right column */
        .specializations-section {
            background: transparent;
            padding: 0;
        }
        
        .spec-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        
        .spec-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .spec-card:hover {
            border-color: #0ea5e9;
            box-shadow: 0 2px 8px rgba(14, 165, 233, 0.15);
            transform: translateY(-1px);
        }
        
        .spec-card h3 {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a2e;
            margin: 0 0 6px 0;
        }
        
        .spec-card .college-count {
            font-size: 12px;
            color: #0ea5e9;
            font-weight: 600;
        }
        
        /* Featured Colleges Section */
        .featured-colleges-section {
            background: #f8f9fa;
            padding: 25px 0;
        }
        
        .featured-colleges-section h2 {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 15px;
        }
        
        .featured-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 12px;
        }
        
        .featured-college-card {
            background: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 1px 5px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .featured-college-card:hover {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transform: translateY(-1px);
        }
        
        .featured-college-card h3 {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a2e;
            margin: 0 0 8px 0;
        }
        
        .featured-college-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 10px;
        }
        
        .featured-badge {
            padding: 3px 8px;
            background: #e0f2fe;
            color: #0369a1;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
        }
        
        .featured-college-highlights {
            font-size: 12px;
            color: #666;
            margin-bottom: 12px;
            line-height: 1.5;
        }
        
        .featured-apply-btn {
            width: 100%;
            padding: 8px;
            background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .featured-apply-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(14, 165, 233, 0.4);
        }
        
        /* Featured Courses Section */
        .featured-courses-section {
            background: #ffffff;
            padding: 25px 0;
        }
        
        .featured-courses-section h2 {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 15px;
        }
        
        .featured-courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 12px;
        }
        
        .featured-course-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 5px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            text-align: center;
        }
        
        .featured-course-card:hover {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transform: translateY(-2px);
            border-color: #0ea5e9;
        }
        
        .featured-course-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 12px;
            background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }
        
        .featured-course-card h3 {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a2e;
            margin: 0 0 8px 0;
        }
        
        .featured-course-card .course-full-name {
            font-size: 12px;
            color: #666;
            margin-bottom: 10px;
            min-height: 32px;
        }
        
        .featured-course-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11px;
            color: #888;
            margin-bottom: 12px;
            padding-top: 10px;
            border-top: 1px solid #f0f0f0;
        }
        
        .featured-course-duration {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        .featured-course-view-btn {
            width: 100%;
            padding: 8px;
            background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
            text-align: center;
        }
        
        .featured-course-view-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(14, 165, 233, 0.4);
            color: white;
        }
        
        /* FAQ Styles */
        .faq-item {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .faq-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .faq-item h4 {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 6px;
        }
        
        .faq-item p {
            font-size: 12px;
            color: #555;
            line-height: 1.6;
            margin: 0;
        }
        
        /* Modal Styles - High z-index to appear above everything */
        .modal-overlay {
            display: none !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            background: rgba(0, 0, 0, 0.6) !important;
            z-index: 999999 !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 20px !important;
            backdrop-filter: blur(4px);
            margin: 0 !important;
        }
        
        .modal-overlay.active {
            display: flex !important;
            visibility: visible !important;
        }
        
        .modal-overlay.active .modal {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        .modal {
            background: white !important;
            border-radius: 12px;
            padding: 25px;
            max-width: 500px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            position: relative !important;
            z-index: 100001 !important;
            transform: scale(1);
            animation: modalFadeIn 0.3s ease;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        .modal-header h3 {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a2e;
            margin: 0;
        }
        
        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            color: #999;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
        }
        
        .modal-close:hover {
            background: #f0f0f0;
            color: #333;
        }
        
        .modal-body {
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #333;
            margin-bottom: 6px;
        }
        
        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.2s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #0ea5e9;
        }
        
        .form-group input.error {
            border-color: #ef4444;
        }
        
        .form-error {
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
            display: none;
        }
        
        .form-error.show {
            display: block;
        }
        
        .modal-footer {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
        
        .btn-modal {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-modal-primary {
            background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
            color: white;
        }
        
        .btn-modal-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
        }
        
        .btn-modal-secondary {
            background: #f0f0f0;
            color: #333;
        }
        
        .btn-modal-secondary:hover {
            background: #e0e0e0;
        }
        
        .modal-success {
            text-align: center;
            padding: 20px;
        }
        
        .modal-success i {
            font-size: 48px;
            color: #10b981;
            margin-bottom: 15px;
        }
        
        .modal-success h4 {
            font-size: 18px;
            color: #1a1a2e;
            margin-bottom: 8px;
        }
        
        .modal-success p {
            font-size: 14px;
            color: #666;
        }
        
        /* Fix CTA Button Alignment */
        .rbt-btn.btn-white {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .rbt-btn.btn-white .btn-text {
            white-space: nowrap;
        }
        
        /* Newsletter Form Alignment */
        .newsletter-form {
            margin-top: 20px;
        }
        
        .newsletter-form .form-group {
            margin-bottom: 15px;
        }
        
        .newsletter-form .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        
        .newsletter-form .form-group.right-icon {
            position: relative;
        }
        
        .newsletter-form .form-group.right-icon input {
            width: 100%;
            padding: 10px 40px 10px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.2s;
        }
        
        .newsletter-form .form-group.right-icon input:focus {
            outline: none;
            border-color: #0ea5e9;
        }
        
        .newsletter-form .form-group.right-icon.icon-email::after {
            content: '\f0e0';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 16px;
            pointer-events: none;
        }
        
        .newsletter-form .form-group.mb--0 {
            margin-bottom: 0;
        }
        
        .newsletter-form .rbt-btn {
            width: 100% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 12px 20px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            margin: 0 !important;
        }
        
        .newsletter-form .rbt-btn span {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px;
            width: 100%;
        }
        
        .newsletter-form .form-group {
            width: 100%;
        }
        
        .newsletter-form input {
            width: 100% !important;
            box-sizing: border-box;
        }
        
        /* Universities Table Layout */
        .filter-bar {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .search-box {
            flex: 1;
            min-width: 180px;
            position: relative;
        }
        
        .search-box input {
            width: 100%;
            padding: 6px 10px 6px 30px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 12px;
        }
        
        .search-box input:focus {
            outline: none;
            border-color: #0ea5e9;
        }
        
        .search-box i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 14px;
        }
        
        .filter-select {
            padding: 6px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 12px;
            min-width: 100px;
            cursor: pointer;
            background: white;
            border: none;
        }
        
        .filter-select:focus {
            outline: none;
            border-color: #0ea5e9;
        }
        
        .universities-table-wrapper {
            overflow-x: auto;
        }
        
        .universities-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table-header {
            display: grid;
            grid-template-columns: 2.5fr 1.5fr 1fr 1.2fr 1fr;
            gap: 10px;
            padding: 8px 12px;
            background: #f8f9fa;
            border-bottom: 2px solid #e0e0e0;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            color: #666;
        }
        
        .table-body {
            display: flex;
            flex-direction: column;
        }
        
        .table-row {
            display: grid;
            grid-template-columns: 2.5fr 1.5fr 1fr 1.2fr 1fr;
            gap: 10px;
            padding: 10px 12px;
            border-bottom: 1px solid #f0f0f0;
            align-items: center;
            transition: background 0.2s;
        }
        
        .table-row:hover {
            background: #f8f9fa;
        }
        
        .table-row.hidden {
            display: none;
        }
        
        .col-name {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .uni-logo-small {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #0ea5e9, #06b6d4);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 12px;
            flex-shrink: 0;
        }
        
        .uni-logo-small img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 4px;
        }
        
        .uni-name-info {
            flex: 1;
            min-width: 0;
        }
        
        .uni-name-info strong {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 2px;
        }
        
        .uni-full-name {
            display: block;
            font-size: 11px;
            color: #666;
            margin-top: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .col-location {
            font-size: 12px;
            color: #666;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        .col-location i {
            font-size: 11px;
        }
        
        .col-type {
            display: flex;
            align-items: center;
        }
        
        .col-fees {
            font-size: 12px;
            font-weight: 600;
            color: #10b981;
        }
        
        .col-action {
            display: flex;
            justify-content: flex-end;
        }
        
        .badge-sm {
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .badge.government { background: #e6f7f0; color: #10b981; }
        .badge.private { background: #e0f2fe; color: #0369a1; }
        .badge.deemed { background: #fff4e6; color: #f97316; }
        .badge.autonomous { background: #fce7f3; color: #ec4899; }
        .badge.featured { background: linear-gradient(135deg, #0ea5e9, #06b6d4); color: white; }
        
        .btn-sm {
            padding: 7px 15px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-sm:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #999;
        }
        
        .empty-state i {
            font-size: 48px;
            color: #ddd;
            margin-bottom: 15px;
        }
        
        .empty-state h3 {
            font-size: 18px;
            color: #666;
            margin-bottom: 8px;
        }
        
        .text-muted {
            color: #999;
        }
        
        .spec-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 12px;
        }
        
        .spec-tag {
            padding: 4px 8px;
            background: #e0f2fe;
            color: #0369a1;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 500;
        }
        
        .career-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 10px;
            margin-top: 12px;
        }
        
        .career-card {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 10px 8px;
            text-align: center;
            transition: all 0.3s;
        }
        
        .career-card:hover {
            border-color: #0ea5e9;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(14, 165, 233, 0.15);
        }
        
        .career-card i {
            font-size: 20px;
            color: #0ea5e9;
            margin-bottom: 6px;
        }
        
        .career-card h5 {
            font-size: 12px;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 4px;
        }
        
        .career-card p {
            font-size: 10px;
            color: #10b981;
            font-weight: 600;
            margin: 0;
        }
        
        /* CTA Section Optimization */
        .rbt-cta-area {
            padding: 20px 0 !important;
        }
        
        .rbt-cta-area .title {
            font-size: 18px !important;
            margin-bottom: 6px !important;
        }
        
        .rbt-cta-area p {
            font-size: 12px !important;
            margin-bottom: 0 !important;
        }
        
        /* Responsive Design */
        @media (max-width: 1199px) {
            .rbt-header-top .rbt-header-content {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
            
            .rbt-header-top .header-info {
                width: 100%;
            }
            
            .rbt-header-top .rbt-information-list {
                flex-wrap: wrap;
                gap: 10px;
            }
        }
        
        @media (max-width: 992px) {
            .table-header,
            .table-row {
                grid-template-columns: 2fr 1.2fr 0.8fr 1fr 1fr;
                gap: 10px;
            }
            
            .col-name {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
            
            .uni-name-info strong {
                font-size: 13px;
            }
        }
        
        @media (max-width: 768px) {
            .course-hero-section {
                padding: 18px 0 15px;
            }
            
            .course-hero-content h1 {
                font-size: 18px;
                line-height: 1.3;
            }
            
            .course-hero-content .subtitle {
                font-size: 12px;
            }
            
            .course-hero-actions {
                flex-direction: column;
                gap: 6px;
                margin-top: 10px;
            }
            
            .hero-action-btn {
                width: 100%;
                justify-content: center;
                padding: 5px 10px;
                font-size: 11px;
            }
            
            .badge-open {
                display: block;
                margin: 8px 0 0 0;
                width: fit-content;
                padding: 3px 6px;
                font-size: 9px;
            }
            
            .course-meta-cards {
                justify-content: flex-start;
                margin-top: 15px;
            }
            
            .meta-card {
                min-width: 60px;
                padding: 5px 8px;
            }
            
            .meta-card i {
                font-size: 12px;
            }
            
            .meta-card .value {
                font-size: 10px;
            }
            
            .meta-card .label {
                font-size: 8px;
            }
            
            .whats-new-section {
                padding: 12px 0;
            }
            
            .whats-new-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .whats-new-header h2 {
                font-size: 14px;
            }
            
            .whats-new-ticker {
                animation-duration: 15s;
            }
            
            .update-item {
                padding: 6px 12px;
                gap: 10px;
            }
            
            .update-item h3 {
                font-size: 12px;
            }
            
            .update-meta {
                font-size: 10px;
                gap: 8px;
            }
            
            .key-info-section,
            .featured-colleges-section {
                padding: 20px 0;
            }
            
            .key-info-section h2,
            .featured-colleges-section h2 {
                font-size: 16px;
            }
            
            .key-info-wrapper {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .key-info-left,
            .key-info-right {
                padding: 15px;
            }
            
            .key-info-table {
                overflow-x: auto;
            }
            
            .key-info-table table {
                min-width: 100%;
            }
            
            .key-info-table th,
            .key-info-table td {
                padding: 8px 12px;
                font-size: 11px;
            }
            
            .spec-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            
            @media (min-width: 768px) {
                .spec-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }
            
            .whats-new-ticker {
                animation-duration: 20s;
            }
            
            .spec-card {
                padding: 10px;
            }
            
            .spec-card h3 {
                font-size: 13px;
            }
            
            .featured-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            
            .featured-college-card {
                padding: 12px;
            }
            
            .featured-college-card h3 {
                font-size: 14px;
            }
            
            .featured-college-highlights {
                font-size: 11px;
            }
            
            .featured-apply-btn {
                padding: 6px;
                font-size: 12px;
            }
            
            .course-tabs-container {
                padding: 15px 0 30px;
            }
            
            .course-tabs-nav {
                flex-wrap: wrap;
                gap: 3px;
                padding: 4px;
            }
            
            .course-tabs-nav li {
                flex: 0 0 auto;
                min-width: fit-content;
            }
            
            .tab-btn {
                padding: 5px 10px;
                font-size: 10px;
                border-radius: 5px;
                white-space: nowrap;
                min-height: 28px;
            }
            
            .tab-btn.active {
                transform: translateY(-1px);
            }
            
            .tab-pane {
                padding: 15px 12px;
            }
            
            .tab-content-inner h4 {
                font-size: 15px;
                margin: 15px 0 8px;
            }
            
            .tab-content-inner p,
            .tab-content-inner ul,
            .tab-content-inner li {
                font-size: 12px;
            }
            
            .faq-item {
                margin-bottom: 12px;
                padding-bottom: 12px;
            }
            
            .faq-item h4 {
                font-size: 13px;
            }
            
            .faq-item p {
                font-size: 11px;
            }
            
            .table-header {
                display: none;
            }
            
            .table-row {
                display: block;
                padding: 15px;
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                margin-bottom: 12px;
            }
            
            .col-name,
            .col-location,
            .col-type,
            .col-fees,
            .col-action {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 8px 0;
                border-bottom: 1px solid #f0f0f0;
            }
            
            .col-name::before { content: "University: "; font-weight: 600; color: #666; }
            .col-location::before { content: "Location: "; font-weight: 600; color: #666; }
            .col-type::before { content: "Type: "; font-weight: 600; color: #666; }
            .col-fees::before { content: "Fees: "; font-weight: 600; color: #666; }
            .col-action::before { content: "Action: "; font-weight: 600; color: #666; }
            
            .col-action {
                border-bottom: none;
                padding-top: 12px;
            }
            
            .filter-bar {
                flex-direction: column;
            }
            
            .search-box,
            .filter-select {
                width: 100%;
                min-width: 100%;
            }
            
            .rbt-cta-area {
                padding: 25px 0 !important;
            }
            
            .rbt-cta-area .title {
                font-size: 20px !important;
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

    <?php include 'includes/header.php'; ?>
    
    <!-- Hero Section -->
    <div class="course-hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="course-hero-content">
                        <h1><?php echo htmlspecialchars($course['full_name'] ?? $course['name']); ?> - Course Details, Eligibility, Admission, Colleges<span class="badge-open">Applications Open</span></h1>
                        <p class="subtitle"><?php echo htmlspecialchars($course['short_description'] ?? 'Explore opportunities in ' . $course['name']); ?></p>
                        <div class="course-hero-actions">
                            <a href="download pdf/<?php echo htmlspecialchars($slug); ?>_brochure.pdf" class="hero-action-btn" target="_blank" download>
                                <i class="feather-download"></i> Brochure
                            </a>
                            <a href="#" class="hero-action-btn" onclick="getUpdates(); return false;">
                                <i class="feather-bell"></i> Get Update
                            </a>
                            <a href="contact.html" class="hero-action-btn">
                                <i class="feather-message-circle"></i> Ask Now
                            </a>
                            <a href="#" class="hero-action-btn primary">
                                <i class="feather-file-text"></i> Mock Test Series
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="course-meta-cards">
                        <div class="meta-card">
                            <i class="feather-clock"></i>
                            <div class="value"><?php echo htmlspecialchars($course['duration'] ?? '3-4 Years'); ?></div>
                            <div class="label">Duration</div>
                        </div>
                        <div class="meta-card">
                            <i class="feather-dollar-sign"></i>
                            <div class="value"><?php echo htmlspecialchars($course['avg_fees'] ?? 'Varies'); ?></div>
                            <div class="label">Avg. Fees</div>
                        </div>
                        <div class="meta-card">
                            <i class="feather-book"></i>
                            <div class="value"><?php echo count($universities); ?>+</div>
                            <div class="label">Colleges</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php require_once __DIR__ . '/includes/notification_banner.php'; ?>
    
    <!-- What's New Section - Horizontal Scrolling Ticker -->
    <?php 
    // Get updates from database (will create admin panel for this)
    try {
        $stmt = $pdo->prepare("SELECT * FROM course_updates WHERE course_slug = ? OR course_slug = 'all' ORDER BY created_at DESC LIMIT 10");
        $stmt->execute([$slug]);
        $dbUpdates = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $dbUpdates = [];
    }
    
    // Fallback to predefined updates
    $updates = $course['updates'] ?? [];
    if (empty($updates) && !empty($dbUpdates)) {
        $updates = array_map(function($u) {
            return [
                'title' => $u['title'],
                'author' => $u['author'] ?? 'Eduspray Team',
                'date' => $u['created_at']
            ];
        }, $dbUpdates);
    }
    
    if (!empty($updates)): 
    ?>
    
    <?php endif; ?>
    
    <!-- Key Information & Courses Offered - Side by Side -->
    <?php 
    $keyInfo = $course['key_info'] ?? [];
    $specializations = $course['specializations'] ?? [];
    if (!empty($keyInfo) || !empty($specializations)): 
    ?>
    <div class="key-info-section">
        <div class="container">
            <div class="key-info-wrapper">
                <!-- Left: Key Points Table -->
                <?php if (!empty($keyInfo)): ?>
                <div class="key-info-left">
                    <h2><?php echo htmlspecialchars($course['full_name'] ?? $course['name']); ?>: Key Points</h2>
                    <div class="key-info-table">
                        <table>
                            <tbody>
                                <?php foreach ($keyInfo as $label => $value): ?>
                                <tr>
                                    <th><?php echo htmlspecialchars($label); ?></th>
                                    <td><?php echo htmlspecialchars($value); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Right: Courses Offered -->
                <?php if (!empty($specializations)): ?>
                <div class="key-info-right">
                    <h2>Courses Offered</h2>
                    <div class="spec-grid">
                        <?php 
                        foreach ($specializations as $specName => $specCode): 
                            // Count universities offering this specialization (simplified - would need proper DB query)
                            $specCount = count($universities); // Placeholder - would need actual count
                        ?>
                        <div class="spec-card" onclick="filterBySpecialization('<?php echo htmlspecialchars($specCode); ?>')">
                            <h3><?php echo htmlspecialchars($specName); ?></h3>
                            <div class="college-count">College Available: <?php echo $specCount; ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Tabbed Content Section -->
    <div class="course-tabs-container">
        <div class="container">
            <div class="course-tabs-wrapper">
                <ul class="course-tabs-nav" role="tablist">
                    <li><button class="tab-btn active" data-tab="overview"><span>Overview</span></button></li>
                    <li><button class="tab-btn" data-tab="eligibility"><span>Eligibility</span></button></li>
                    <li><button class="tab-btn" data-tab="syllabus"><span>Syllabus</span></button></li>
                    <li><button class="tab-btn" data-tab="preparation"><span>Preparation Tips</span></button></li>
                    <li><button class="tab-btn" data-tab="mock-tests"><span>Mock Tests</span></button></li>
                    <li><button class="tab-btn" data-tab="question-papers"><span>Question Papers</span></button></li>
                    <li><button class="tab-btn" data-tab="study-material"><span>Study Material</span></button></li>
                    <li><button class="tab-btn" data-tab="universities"><span>Universities (<?php echo count($universities); ?>)</span></button></li>
                    <li><button class="tab-btn" data-tab="career"><span>Career Options</span></button></li>
                    <li><button class="tab-btn" data-tab="faqs"><span>FAQs</span></button></li>
                </ul>
                
                <div class="course-tabs-content">
                    <!-- Overview Tab -->
                    <div class="tab-pane active" id="overview-tab">
                        <div class="tab-content-inner">
                            <?php echo $course['description'] ?? '<p>Course description coming soon.</p>'; ?>
                        </div>
                    </div>
                    
                    <!-- Eligibility Tab -->
                    <div class="tab-pane" id="eligibility-tab">
                        <div class="tab-content-inner">
                            <?php echo $course['eligibility'] ?? '<p>Eligibility information coming soon.</p>'; ?>
                        </div>
                    </div>
                    
                    <!-- Syllabus Tab -->
                    <div class="tab-pane" id="syllabus-tab">
                        <div class="tab-content-inner">
                            <?php echo $course['syllabus'] ?? '<p>Syllabus information coming soon.</p>'; ?>
                        </div>
                    </div>
                    
                    <!-- Preparation Tips Tab -->
                    <div class="tab-pane" id="preparation-tab">
                        <div class="tab-content-inner">
                            <?php echo $course['preparation_tips'] ?? '<p>Preparation tips coming soon.</p>'; ?>
                        </div>
                    </div>
                    
                    <!-- Mock Tests Tab -->
                    <div class="tab-pane" id="mock-tests-tab">
                        <div class="tab-content-inner">
                            <?php echo $course['mock_tests'] ?? '<p>Mock test information coming soon.</p>'; ?>
                        </div>
                    </div>
                    
                    <!-- Question Papers Tab -->
                    <div class="tab-pane" id="question-papers-tab">
                        <div class="tab-content-inner">
                            <?php echo $course['question_papers'] ?? '<p>Question paper information coming soon.</p>'; ?>
                        </div>
                    </div>
                    
                    <!-- Study Material Tab -->
                    <div class="tab-pane" id="study-material-tab">
                        <div class="tab-content-inner">
                            <?php echo $course['study_material'] ?? '<p>Study material information coming soon.</p>'; ?>
                        </div>
                    </div>
                    
                    <!-- Universities Tab -->
                    <div class="tab-pane" id="universities-tab">
                        <div class="tab-content-inner">
                            <div class="filter-bar">
                                <div class="search-box">
                                    <i class="feather-search"></i>
                                    <input type="text" id="searchInput" placeholder="Search universities...">
                                </div>
                                <select class="filter-select" id="stateFilter">
                                    <option value="">All States</option>
                                    <?php foreach ($states as $state): ?>
                                    <option value="<?php echo htmlspecialchars($state); ?>"><?php echo htmlspecialchars($state); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <select class="filter-select" id="typeFilter">
                                    <option value="">All Types</option>
                                    <?php foreach ($types as $type): ?>
                                    <option value="<?php echo htmlspecialchars($type); ?>"><?php echo ucfirst(htmlspecialchars($type)); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="universities-table-wrapper">
                                <?php if (empty($universities)): ?>
                                <div class="empty-state">
                                    <i class="feather-university"></i>
                                    <h3>No Universities Found</h3>
                                    <p>We're adding more universities soon. Check back later!</p>
                                </div>
                                <?php else: ?>
                                <div class="universities-table" id="universitiesTable">
                                    <div class="table-header">
                                        <div class="col-name">University</div>
                                        <div class="col-location">Location</div>
                                        <div class="col-type">Type</div>
                                        <div class="col-fees">Fees/Year</div>
                                        <div class="col-action">Action</div>
                                    </div>
                                    <div class="table-body" id="universitiesGrid">
                                        <?php foreach ($universities as $uni): ?>
                                        <div class="table-row university-row" 
                                             data-name="<?php echo htmlspecialchars(strtolower($uni['name'] . ' ' . ($uni['short_name'] ?? ''))); ?>"
                                             data-state="<?php echo htmlspecialchars($uni['state'] ?? ''); ?>"
                                             data-type="<?php echo htmlspecialchars($uni['type'] ?? ''); ?>">
                                            <div class="col-name">
                                                <div class="uni-logo-small">
                                                    <?php if (!empty($uni['logo'])): ?>
                                                    <img src="<?php echo htmlspecialchars($uni['logo']); ?>" alt="">
                                                    <?php else: ?>
                                                    <?php echo strtoupper(substr($uni['short_name'] ?? $uni['name'], 0, 2)); ?>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="uni-name-info">
                                                    <strong><?php echo htmlspecialchars($uni['short_name'] ? $uni['short_name'] : $uni['name']); ?></strong>
                                                    <?php if ($uni['short_name'] && $uni['short_name'] != $uni['name']): ?>
                                                    <span class="uni-full-name"><?php echo htmlspecialchars($uni['name']); ?></span>
                                                    <?php endif; ?>
                                                    <?php if (!empty($uni['featured'])): ?>
                                                    <span class="badge badge-sm featured">Featured</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-location">
                                                <i class="feather-map-pin"></i>
                                                <?php echo htmlspecialchars(($uni['city'] ?? '') . ', ' . ($uni['state'] ?? '')); ?>
                                            </div>
                                            <div class="col-type">
                                                <span class="badge badge-sm <?php echo htmlspecialchars($uni['type'] ?? 'private'); ?>">
                                                    <?php echo ucfirst(htmlspecialchars($uni['type'] ?? 'Private')); ?>
                                                </span>
                                            </div>
                                            <div class="col-fees">
                                                <?php 
                                                if ($uni['fees_min'] && $uni['fees_max']) {
                                                    echo '₹' . number_format($uni['fees_min']/1000) . 'K - ₹' . number_format($uni['fees_max']/1000) . 'K';
                                                } else {
                                                    echo '<span class="text-muted">Contact</span>';
                                                }
                                                ?>
                                            </div>
                                            <div class="col-action">
                                                <button class="btn-sm btn-primary" onclick="openInquiry('<?php echo htmlspecialchars(addslashes($uni['name'])); ?>')">
                                                    Get Details
                                                </button>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Career Tab -->
                    <div class="tab-pane" id="career-tab">
                        <div class="tab-content-inner">
                            <?php echo $course['career_options'] ?? '<p>Career information coming soon.</p>'; ?>
                        </div>
                    </div>
                    
                    <!-- FAQs Tab -->
                    <div class="tab-pane" id="faqs-tab">
                        <div class="tab-content-inner">
                            <?php echo $course['faqs'] ?? '<p>FAQs coming soon.</p>'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Featured Colleges Section -->
    <?php 
    $featuredUniversities = array_filter($universities, function($uni) {
        return !empty($uni['featured']);
    });
    $featuredUniversities = array_slice($featuredUniversities, 0, 6); // Top 6 featured
    if (!empty($featuredUniversities)): 
    ?>
    <div class="featured-colleges-section">
        <div class="container">
            <h2>Featured Colleges</h2>
            <div class="featured-grid">
                <?php foreach ($featuredUniversities as $uni): ?>
                <div class="featured-college-card">
                    <h3><?php echo htmlspecialchars($uni['short_name'] ? $uni['short_name'] : $uni['name']); ?></h3>
                    <div class="featured-college-badges">
                        <?php if (!empty($uni['ranking'])): ?>
                        <span class="featured-badge">Ranked #<?php echo htmlspecialchars($uni['ranking']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($uni['type'])): ?>
                        <span class="featured-badge"><?php echo ucfirst(htmlspecialchars($uni['type'])); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="featured-college-highlights">
                        <?php if (!empty($uni['highlights'])): ?>
                            <?php echo htmlspecialchars($uni['highlights']); ?>
                        <?php else: ?>
                            <p>Top-ranked institution offering <?php echo htmlspecialchars($course['name']); ?> programs with excellent placement opportunities.</p>
                        <?php endif; ?>
                    </div>
                    <button class="featured-apply-btn" onclick="openInquiry('<?php echo htmlspecialchars(addslashes($uni['name'])); ?>')">
                        Apply Now
                    </button>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Featured Courses Section -->
    <?php if (!empty($featuredCourses)): ?>
    <div class="featured-courses-section">
        <div class="container">
            <h2>Featured Courses</h2>
            <div class="featured-courses-grid">
                <?php foreach ($featuredCourses as $featuredCourse): 
                    // Get predefined content for featured course if needed
                    $featuredContent = getCourseContent($featuredCourse['slug']);
                    $featuredCourseIcon = $featuredCourse['icon'] ?? $featuredContent['icon'] ?? 'fas fa-graduation-cap';
                    $featuredCourseFullName = $featuredCourse['full_name'] ?? $featuredContent['full_name'] ?? $featuredCourse['name'];
                    $featuredCourseDuration = $featuredCourse['duration'] ?? $featuredContent['duration'] ?? 'N/A';
                ?>
                <div class="featured-course-card">
                    <div class="featured-course-icon">
                        <i class="<?php echo htmlspecialchars($featuredCourseIcon); ?>"></i>
                    </div>
                    <h3><?php echo htmlspecialchars($featuredCourse['name']); ?></h3>
                    <?php if (!empty($featuredCourseFullName) && $featuredCourseFullName !== $featuredCourse['name']): ?>
                    <div class="course-full-name"><?php echo htmlspecialchars($featuredCourseFullName); ?></div>
                    <?php endif; ?>
                    <div class="featured-course-meta">
                        <div class="featured-course-duration">
                            <i class="feather-clock" style="font-size: 12px;"></i>
                            <span><?php echo htmlspecialchars($featuredCourseDuration); ?></span>
                        </div>
                    </div>
                    <a href="course.php?slug=<?php echo urlencode($featuredCourse['slug']); ?>" class="featured-course-view-btn">
                        View Course
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- CTA Section -->
    <div class="rbt-cta-area rbt-cta-style-1" style="background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-8">
                    <div class="content">
                        <h2 class="title color-white">Need Help Choosing the Right College?</h2>
                        <p class="color-white">Our expert counselors will guide you through the admission process</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="rbt-button-group justify-content-start justify-content-lg-end">
                        <a class="rbt-btn btn-white hover-icon-reverse" href="contact.html">
                            <span class="btn-text">Get Free Counselling</span>
                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                                    <label for="email">Enter Your Email Here</label>
                                    <input id="email" name="email" type="email" required placeholder="Enter your email address">
                                </div>

                                <div class="form-group mb--0">
                                    <button class="rbt-btn rbt-switch-btn btn-gradient radius-round" style="width: 100%;"
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
    
    <!-- Modals - Must be outside footer for proper z-index -->
    <!-- Get Update Modal -->
    <div class="modal-overlay" id="updateModal">
        <div class="modal">
            <div class="modal-header">
                <h3>Get Updates</h3>
                <button class="modal-close" onclick="closeUpdateModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="updateForm" onsubmit="submitUpdateForm(event)">
                    <div class="form-group">
                        <label for="updateName">Name *</label>
                        <input type="text" id="updateName" name="name" required>
                        <div class="form-error" id="nameError">Name is required</div>
                    </div>
                    <div class="form-group">
                        <label for="updateEmail">Email *</label>
                        <input type="email" id="updateEmail" name="email" required>
                        <div class="form-error" id="emailError">Valid email is required</div>
                    </div>
                    <div class="form-group">
                        <label for="updatePhone">Phone Number *</label>
                        <input type="tel" id="updatePhone" name="phone" required minlength="10">
                        <div class="form-error" id="phoneError">Valid phone number is required (minimum 10 digits)</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-modal btn-modal-secondary" onclick="closeUpdateModal()">Cancel</button>
                        <button type="submit" class="btn-modal btn-modal-primary" id="submitUpdateBtn">Subscribe</button>
                    </div>
                </form>
                <div class="modal-success" id="updateSuccess" style="display: none;">
                    <i class="feather-check-circle"></i>
                    <h4>Thank You!</h4>
                    <p>We'll keep you updated about <?php echo htmlspecialchars($course['name']); ?>.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="rbt-progress-parent">
        <svg class="rbt-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>

    <!-- JS -->
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
    
    <!-- Course Page Specific Scripts -->
    <script>
        // Tab Switching
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const tabId = this.dataset.tab;
                
                // Update buttons
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                // Update panes
                document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));
                const targetPane = document.getElementById(tabId + '-tab');
                if (targetPane) {
                    targetPane.classList.add('active');
                }
            });
        });
        
        // University filtering (for table layout)
        const searchInput = document.getElementById('searchInput');
        const stateFilter = document.getElementById('stateFilter');
        const typeFilter = document.getElementById('typeFilter');
        const rows = document.querySelectorAll('.university-row');
        
        function filterUniversities() {
            if (!rows.length) return;
            
            const searchTerm = (searchInput?.value || '').toLowerCase();
            const selectedState = stateFilter?.value || '';
            const selectedType = (typeFilter?.value || '').toLowerCase();
            
            let visibleCount = 0;
            
            rows.forEach(row => {
                const name = row.dataset.name || '';
                const state = row.dataset.state || '';
                const type = row.dataset.type || '';
                
                const matchesSearch = name.includes(searchTerm);
                const matchesState = !selectedState || state === selectedState;
                const matchesType = !selectedType || type === selectedType;
                
                if (matchesSearch && matchesState && matchesType) {
                    row.classList.remove('hidden');
                    visibleCount++;
                } else {
                    row.classList.add('hidden');
                }
            });
            
            // Show/hide empty state
            const emptyState = document.querySelector('.empty-state');
            if (emptyState) {
                emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        }
        
        if (searchInput) searchInput.addEventListener('input', filterUniversities);
        if (stateFilter) stateFilter.addEventListener('change', filterUniversities);
        if (typeFilter) typeFilter.addEventListener('change', filterUniversities);
        
        function openInquiry(universityName) {
            window.location.href = `contact.html?university=${encodeURIComponent(universityName)}&course=<?php echo urlencode($course['name']); ?>`;
        }
        
        
        // Close modals on overlay click
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    overlay.classList.remove('active');
                    document.body.style.overflow = ''; // Restore scrolling
                }
            });
        });
        
        // Close modals on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-overlay.active').forEach(overlay => {
                    overlay.classList.remove('active');
                    document.body.style.overflow = ''; // Restore scrolling
                });
            }
        });
        
        function getUpdates() {
            const modal = document.getElementById('updateModal');
            if (modal) {
                console.log('Opening update modal');
                modal.classList.add('active');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
                // Force visibility
                modal.style.display = 'flex';
                modal.style.visibility = 'visible';
                const modalContent = modal.querySelector('.modal');
                if (modalContent) {
                    modalContent.style.display = 'block';
                    modalContent.style.visibility = 'visible';
                }
            } else {
                console.error('Update modal not found');
                alert('Modal element not found. Please check the page structure.');
            }
        }
        
        function closeUpdateModal() {
            const modal = document.getElementById('updateModal');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = ''; // Restore scrolling
            }
            // Reset form
            const form = document.getElementById('updateForm');
            if (form) {
                form.reset();
                form.style.display = 'block';
            }
            const success = document.getElementById('updateSuccess');
            if (success) {
                success.style.display = 'none';
            }
            document.querySelectorAll('#updateModal .form-error').forEach(el => el.classList.remove('show'));
            document.querySelectorAll('#updateModal .form-group input').forEach(el => el.classList.remove('error'));
        }
        
        function submitUpdateForm(e) {
            e.preventDefault();
            
            const name = document.getElementById('updateName').value.trim();
            const email = document.getElementById('updateEmail').value.trim();
            const phone = document.getElementById('updatePhone').value.trim();
            
            // Validation
            let isValid = true;
            document.querySelectorAll('.form-error').forEach(el => el.classList.remove('show'));
            document.querySelectorAll('.form-group input').forEach(el => el.classList.remove('error'));
            
            if (!name) {
                document.getElementById('nameError').classList.add('show');
                document.getElementById('updateName').classList.add('error');
                isValid = false;
            }
            
            if (!email || !email.includes('@')) {
                document.getElementById('emailError').classList.add('show');
                document.getElementById('updateEmail').classList.add('error');
                isValid = false;
            }
            
            if (!phone || phone.length < 10) {
                document.getElementById('phoneError').classList.add('show');
                document.getElementById('updatePhone').classList.add('error');
                isValid = false;
            }
            
            if (!isValid) return;
            
            // Show loading
            const submitBtn = document.getElementById('submitUpdateBtn');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting...';
            
            // Send to API
            fetch('php/api/save_lead.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    name: name,
                    email: email,
                    phone: phone,
                    course_slug: '<?php echo htmlspecialchars($slug); ?>',
                    course_name: '<?php echo htmlspecialchars($course['name']); ?>',
                    source: 'get_update'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    document.getElementById('updateForm').style.display = 'none';
                    document.getElementById('updateSuccess').style.display = 'block';
                    
                    setTimeout(() => {
                        closeUpdateModal();
                        document.getElementById('updateForm').style.display = 'block';
                        document.getElementById('updateSuccess').style.display = 'none';
                    }, 2000);
                } else {
                    alert('Error: ' + (data.message || 'Something went wrong'));
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error submitting form. Please try again.');
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        }
        
        function filterBySpecialization(specCode) {
            // Scroll to universities tab and filter
            const universitiesTab = document.getElementById('universities-tab');
            const tabBtn = document.querySelector('[data-tab="universities"]');
            if (tabBtn) {
                tabBtn.click();
                setTimeout(() => {
                    if (universitiesTab) {
                        universitiesTab.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }, 100);
            }
            // Note: Actual filtering by specialization would require database query
            alert('Filtering by specialization: ' + specCode + '. This feature will be enhanced soon.');
        }
    </script>
</body>

</html>
