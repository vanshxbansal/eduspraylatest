<?php
/**
 * Get Featured Courses API
 * Returns featured courses for a given course slug
 */

session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Include database config
require_once '../php/config.php';

header('Content-Type: application/json');

$courseSlug = isset($_GET['course_slug']) ? trim($_GET['course_slug']) : '';

if (empty($courseSlug)) {
    http_response_code(400);
    echo json_encode(['error' => 'Course slug is required']);
    exit;
}

try {
    $stmt = $pdo->prepare("
        SELECT fc.featured_course_slug as slug, fc.display_order
        FROM featured_courses fc
        WHERE fc.course_slug = ? AND fc.status = 'active'
        ORDER BY fc.display_order ASC
    ");
    $stmt->execute([$courseSlug]);
    $featuredCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'featured_courses' => $featuredCourses
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>



