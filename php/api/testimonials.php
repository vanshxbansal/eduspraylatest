<?php
/**
 * Testimonials API - CRUD operations for testimonials
 */

header('Content-Type: application/json');
require_once '../config.php';

// Check admin authentication for write operations
session_start();
$isAdmin = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

try {
    switch ($method) {
        case 'GET':
            if ($action === 'all') {
                // Get all testimonials (public)
                $status = $isAdmin ? '' : 'AND status = "active"';
                $stmt = $pdo->query("SELECT * FROM testimonials WHERE 1=1 $status ORDER BY display_order ASC, created_at DESC");
                $testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode(['success' => true, 'data' => $testimonials]);
            } elseif ($action === 'home') {
                // Get testimonials for home page
                $limit = $_GET['limit'] ?? 3;
                $stmt = $pdo->prepare("SELECT * FROM testimonials WHERE status = 'active' ORDER BY display_order ASC, created_at DESC LIMIT ?");
                $stmt->execute([$limit]);
                $testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode(['success' => true, 'data' => $testimonials]);
            } else {
                // Get single testimonial
                $id = $_GET['id'] ?? 0;
                $stmt = $pdo->prepare("SELECT * FROM testimonials WHERE id = ?");
                $stmt->execute([$id]);
                $testimonial = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode(['success' => true, 'data' => $testimonial]);
            }
            break;
            
        case 'POST':
            if (!$isAdmin) {
                throw new Exception('Unauthorized');
            }
            
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (empty($data['name']) || empty($data['testimonial_text'])) {
                throw new Exception('Name and testimonial text are required');
            }
            
            $name = $data['name'];
            $image = $data['image'] ?? '';
            $rating = $data['rating'] ?? 5.0;
            $testimonialText = $data['testimonial_text'];
            $course = $data['course'] ?? '';
            $designation = $data['designation'] ?? 'Student';
            $displayOrder = $data['display_order'] ?? 0;
            $status = $data['status'] ?? 'active';
            
            $stmt = $pdo->prepare("INSERT INTO testimonials (name, image, rating, testimonial_text, course, designation, display_order, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $image, $rating, $testimonialText, $course, $designation, $displayOrder, $status]);
            
            echo json_encode(['success' => true, 'message' => 'Testimonial added successfully', 'id' => $pdo->lastInsertId()]);
            break;
            
        case 'PUT':
            if (!$isAdmin) {
                throw new Exception('Unauthorized');
            }
            
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['id'] ?? 0;
            
            if (!$id) {
                throw new Exception('Testimonial ID is required');
            }
            
            $name = $data['name'] ?? '';
            $image = $data['image'] ?? '';
            $rating = $data['rating'] ?? 5.0;
            $testimonialText = $data['testimonial_text'] ?? '';
            $course = $data['course'] ?? '';
            $designation = $data['designation'] ?? 'Student';
            $displayOrder = $data['display_order'] ?? 0;
            $status = $data['status'] ?? 'active';
            
            $stmt = $pdo->prepare("UPDATE testimonials SET name = ?, image = ?, rating = ?, testimonial_text = ?, course = ?, designation = ?, display_order = ?, status = ? WHERE id = ?");
            $stmt->execute([$name, $image, $rating, $testimonialText, $course, $designation, $displayOrder, $status, $id]);
            
            echo json_encode(['success' => true, 'message' => 'Testimonial updated successfully']);
            break;
            
        case 'DELETE':
            if (!$isAdmin) {
                throw new Exception('Unauthorized');
            }
            
            $id = $_GET['id'] ?? 0;
            
            if (!$id) {
                throw new Exception('Testimonial ID is required');
            }
            
            $stmt = $pdo->prepare("DELETE FROM testimonials WHERE id = ?");
            $stmt->execute([$id]);
            
            echo json_encode(['success' => true, 'message' => 'Testimonial deleted successfully']);
            break;
            
        default:
            throw new Exception('Method not allowed');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>



