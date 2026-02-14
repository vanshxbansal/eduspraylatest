<?php
/**
 * Home Page API - CRUD operations for home page sections
 */

header('Content-Type: application/json');
require_once '../config.php';

// Check admin authentication
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

try {
    switch ($method) {
        case 'GET':
            if ($action === 'all') {
                // Get all sections
                $stmt = $pdo->query("SELECT * FROM home_page_sections ORDER BY display_order ASC");
                $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Decode JSON fields
                foreach ($sections as &$section) {
                    if (!empty($section['meta_data'])) {
                        $section['meta_data'] = json_decode($section['meta_data'], true);
                    }
                }
                
                echo json_encode(['success' => true, 'data' => $sections]);
            } elseif ($action === 'single') {
                // Get single section
                $id = $_GET['id'] ?? 0;
                $stmt = $pdo->prepare("SELECT * FROM home_page_sections WHERE id = ?");
                $stmt->execute([$id]);
                $section = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($section && !empty($section['meta_data'])) {
                    $section['meta_data'] = json_decode($section['meta_data'], true);
                }
                
                echo json_encode(['success' => true, 'data' => $section]);
            } else {
                // Get by section key
                $key = $_GET['key'] ?? '';
                if (empty($key)) {
                    throw new Exception('Section key is required');
                }
                
                $stmt = $pdo->prepare("SELECT * FROM home_page_sections WHERE section_key = ?");
                $stmt->execute([$key]);
                $section = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($section && !empty($section['meta_data'])) {
                    $section['meta_data'] = json_decode($section['meta_data'], true);
                }
                
                echo json_encode(['success' => true, 'data' => $section]);
            }
            break;
            
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (empty($data['section_key'])) {
                throw new Exception('Section key is required');
            }
            
            $sectionKey = $data['section_key'];
            $title = $data['title'] ?? '';
            $content = $data['content'] ?? '';
            $imageUrl = $data['image_url'] ?? '';
            $metaData = isset($data['meta_data']) ? json_encode($data['meta_data']) : '{}';
            $displayOrder = $data['display_order'] ?? 0;
            $status = $data['status'] ?? 'active';
            
            // Check if section exists
            $stmt = $pdo->prepare("SELECT id FROM home_page_sections WHERE section_key = ?");
            $stmt->execute([$sectionKey]);
            $existing = $stmt->fetch();
            
            if ($existing) {
                // Update
                $stmt = $pdo->prepare("UPDATE home_page_sections SET title = ?, content = ?, image_url = ?, meta_data = ?, display_order = ?, status = ? WHERE section_key = ?");
                $stmt->execute([$title, $content, $imageUrl, $metaData, $displayOrder, $status, $sectionKey]);
            } else {
                // Insert
                $stmt = $pdo->prepare("INSERT INTO home_page_sections (section_key, title, content, image_url, meta_data, display_order, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$sectionKey, $title, $content, $imageUrl, $metaData, $displayOrder, $status]);
            }
            
            echo json_encode(['success' => true, 'message' => 'Section saved successfully']);
            break;
            
        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['id'] ?? 0;
            
            if (!$id) {
                throw new Exception('Section ID is required');
            }
            
            $title = $data['title'] ?? '';
            $content = $data['content'] ?? '';
            $imageUrl = $data['image_url'] ?? '';
            $metaData = isset($data['meta_data']) ? json_encode($data['meta_data']) : '{}';
            $displayOrder = $data['display_order'] ?? 0;
            $status = $data['status'] ?? 'active';
            
            $stmt = $pdo->prepare("UPDATE home_page_sections SET title = ?, content = ?, image_url = ?, meta_data = ?, display_order = ?, status = ? WHERE id = ?");
            $stmt->execute([$title, $content, $imageUrl, $metaData, $displayOrder, $status, $id]);
            
            echo json_encode(['success' => true, 'message' => 'Section updated successfully']);
            break;
            
        case 'DELETE':
            $id = $_GET['id'] ?? 0;
            
            if (!$id) {
                throw new Exception('Section ID is required');
            }
            
            $stmt = $pdo->prepare("DELETE FROM home_page_sections WHERE id = ?");
            $stmt->execute([$id]);
            
            echo json_encode(['success' => true, 'message' => 'Section deleted successfully']);
            break;
            
        default:
            throw new Exception('Method not allowed');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>



