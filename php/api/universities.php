<?php
/**
 * Universities API
 * 
 * Endpoints:
 * GET /api/universities.php - Get all universities
 * GET /api/universities.php?course=btech - Filter by course
 * GET /api/universities.php?state=Delhi - Filter by state
 * GET /api/universities.php?type=government - Filter by type
 * GET /api/universities.php?search=amity - Search by name
 * GET /api/universities.php?slug=ggsipu - Get single university
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

require_once '../config.php';

try {
    // Get single university by slug
    if (isset($_GET['slug'])) {
        $slug = trim($_GET['slug']);
        
        $stmt = $pdo->prepare("SELECT * FROM universities WHERE slug = ? AND status = 'active'");
        $stmt->execute([$slug]);
        $university = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$university) {
            http_response_code(404);
            echo json_encode(['error' => 'University not found']);
            exit;
        }
        
        // Parse JSON courses field
        $university['courses'] = json_decode($university['courses'], true) ?? [];
        
        echo json_encode(['success' => true, 'data' => $university]);
        exit;
    }
    
    // Build query with filters
    $query = "SELECT * FROM universities WHERE status = 'active'";
    $params = [];
    
    // Filter by course
    if (isset($_GET['course']) && !empty($_GET['course'])) {
        $course = trim($_GET['course']);
        $query .= " AND JSON_CONTAINS(courses, ?)";
        $params[] = json_encode($course);
    }
    
    // Filter by state
    if (isset($_GET['state']) && !empty($_GET['state'])) {
        $query .= " AND state = ?";
        $params[] = trim($_GET['state']);
    }
    
    // Filter by city
    if (isset($_GET['city']) && !empty($_GET['city'])) {
        $query .= " AND city = ?";
        $params[] = trim($_GET['city']);
    }
    
    // Filter by type
    if (isset($_GET['type']) && !empty($_GET['type'])) {
        $query .= " AND type = ?";
        $params[] = trim($_GET['type']);
    }
    
    // Filter by affiliation
    if (isset($_GET['affiliation']) && !empty($_GET['affiliation'])) {
        $query .= " AND affiliation LIKE ?";
        $params[] = '%' . trim($_GET['affiliation']) . '%';
    }
    
    // Search by name
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = '%' . trim($_GET['search']) . '%';
        $query .= " AND (name LIKE ? OR short_name LIKE ? OR city LIKE ?)";
        $params[] = $search;
        $params[] = $search;
        $params[] = $search;
    }
    
    // Featured only
    if (isset($_GET['featured']) && $_GET['featured'] == '1') {
        $query .= " AND featured = 1";
    }
    
    // Order by
    $query .= " ORDER BY featured DESC, name ASC";
    
    // Pagination
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 50;
    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
    $query .= " LIMIT $limit OFFSET $offset";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $universities = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Parse JSON courses field for each
    foreach ($universities as &$uni) {
        $uni['courses'] = json_decode($uni['courses'], true) ?? [];
    }
    
    // Get total count (without limit)
    $countQuery = str_replace("SELECT *", "SELECT COUNT(*)", $query);
    $countQuery = preg_replace('/LIMIT \d+ OFFSET \d+/', '', $countQuery);
    $stmtCount = $pdo->prepare($countQuery);
    $stmtCount->execute($params);
    $totalCount = $stmtCount->fetchColumn();
    
    // Get filter options
    $states = $pdo->query("SELECT DISTINCT state FROM universities WHERE status = 'active' AND state IS NOT NULL ORDER BY state")->fetchAll(PDO::FETCH_COLUMN);
    $types = $pdo->query("SELECT DISTINCT type FROM universities WHERE status = 'active' AND type IS NOT NULL ORDER BY type")->fetchAll(PDO::FETCH_COLUMN);
    $affiliations = $pdo->query("SELECT DISTINCT affiliation FROM universities WHERE status = 'active' AND affiliation IS NOT NULL ORDER BY affiliation")->fetchAll(PDO::FETCH_COLUMN);
    
    echo json_encode([
        'success' => true,
        'data' => $universities,
        'count' => count($universities),
        'total' => (int)$totalCount,
        'filters' => [
            'states' => $states,
            'types' => $types,
            'affiliations' => $affiliations
        ]
    ]);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>








