<?php
/**
 * Courses API
 * 
 * Endpoints:
 * GET /api/courses.php - Get all courses
 * GET /api/courses.php?slug=btech - Get single course
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

require_once '../config.php';
require_once '../courses_data.php';

try {
    // Get single course by slug
    if (isset($_GET['slug'])) {
        $slug = trim($_GET['slug']);
        
        // Get from database
        $stmt = $pdo->prepare("SELECT * FROM courses WHERE slug = ? AND status = 'active'");
        $stmt->execute([$slug]);
        $course = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$course) {
            http_response_code(404);
            echo json_encode(['error' => 'Course not found']);
            exit;
        }
        
        // Merge with predefined content
        $predefinedContent = getCourseContent($slug);
        $course = array_merge($course, $predefinedContent);
        
        echo json_encode(['success' => true, 'data' => $course]);
        exit;
    }
    
    // Get all active courses
    $stmt = $pdo->query("SELECT * FROM courses WHERE status = 'active' ORDER BY display_order ASC, name ASC");
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Merge with predefined content
    foreach ($courses as &$course) {
        $predefinedContent = getCourseContent($course['slug']);
        if (isset($predefinedContent['icon'])) {
            $course['icon'] = $predefinedContent['icon'];
        }
        if (isset($predefinedContent['short_description'])) {
            $course['short_description'] = $predefinedContent['short_description'];
        }
    }
    
    echo json_encode(['success' => true, 'data' => $courses, 'count' => count($courses)]);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>








