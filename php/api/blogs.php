<?php
/**
 * Blogs API - CRUD operations for blogs
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
                // Get all blogs
                $status = $isAdmin ? '' : 'AND status = "published"';
                $page = $_GET['page'] ?? 1;
                $limit = $_GET['limit'] ?? 10;
                $offset = ($page - 1) * $limit;
                
                $stmt = $pdo->query("SELECT * FROM blogs WHERE 1=1 $status ORDER BY created_at DESC LIMIT $limit OFFSET $offset");
                $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Get total count
                $countStmt = $pdo->query("SELECT COUNT(*) as total FROM blogs WHERE 1=1 $status");
                $total = $countStmt->fetch()['total'];
                
                echo json_encode(['success' => true, 'data' => $blogs, 'total' => $total, 'page' => $page, 'limit' => $limit]);
            } elseif ($action === 'featured') {
                // Get featured blogs for home page
                $limit = $_GET['limit'] ?? 3;
                $stmt = $pdo->prepare("SELECT * FROM blogs WHERE status = 'published' AND featured = 1 ORDER BY created_at DESC LIMIT ?");
                $stmt->execute([$limit]);
                $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode(['success' => true, 'data' => $blogs]);
            } elseif ($action === 'latest') {
                // Get latest blogs
                $limit = $_GET['limit'] ?? 3;
                $stmt = $pdo->prepare("SELECT * FROM blogs WHERE status = 'published' ORDER BY created_at DESC LIMIT ?");
                $stmt->execute([$limit]);
                $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode(['success' => true, 'data' => $blogs]);
            } else {
                // Get single blog by slug or ID
                $slug = $_GET['slug'] ?? '';
                $id = $_GET['id'] ?? 0;
                
                if ($slug) {
                    $stmt = $pdo->prepare("SELECT * FROM blogs WHERE slug = ?");
                    $stmt->execute([$slug]);
                } elseif ($id) {
                    $stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = ?");
                    $stmt->execute([$id]);
                } else {
                    throw new Exception('Slug or ID is required');
                }
                
                $blog = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($blog && $blog['status'] === 'published' || $isAdmin) {
                    // Increment views
                    $viewStmt = $pdo->prepare("UPDATE blogs SET views = views + 1 WHERE id = ?");
                    $viewStmt->execute([$blog['id']]);
                    $blog['views'] = ($blog['views'] ?? 0) + 1;
                    
                    echo json_encode(['success' => true, 'data' => $blog]);
                } else {
                    throw new Exception('Blog not found');
                }
            }
            break;
            
        case 'POST':
            if (!$isAdmin) {
                throw new Exception('Unauthorized');
            }
            
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (empty($data['title'])) {
                throw new Exception('Title is required');
            }
            
            $title = $data['title'];
            $slug = $data['slug'] ?? strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
            $excerpt = $data['excerpt'] ?? '';
            $content = $data['content'] ?? '';
            $featuredImage = $data['featured_image'] ?? '';
            $author = $data['author'] ?? 'Eduspray Team';
            $category = $data['category'] ?? '';
            $tags = $data['tags'] ?? '';
            $status = $data['status'] ?? 'draft';
            $featured = $data['featured'] ?? 0;
            
            // Ensure slug is unique
            $slugCheck = $pdo->prepare("SELECT id FROM blogs WHERE slug = ?");
            $slugCheck->execute([$slug]);
            if ($slugCheck->fetch()) {
                $slug .= '-' . time();
            }
            
            $stmt = $pdo->prepare("INSERT INTO blogs (title, slug, excerpt, content, featured_image, author, category, tags, status, featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $slug, $excerpt, $content, $featuredImage, $author, $category, $tags, $status, $featured]);
            
            echo json_encode(['success' => true, 'message' => 'Blog created successfully', 'id' => $pdo->lastInsertId(), 'slug' => $slug]);
            break;
            
        case 'PUT':
            if (!$isAdmin) {
                throw new Exception('Unauthorized');
            }
            
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['id'] ?? 0;
            
            if (!$id) {
                throw new Exception('Blog ID is required');
            }
            
            $title = $data['title'] ?? '';
            $slug = $data['slug'] ?? '';
            $excerpt = $data['excerpt'] ?? '';
            $content = $data['content'] ?? '';
            $featuredImage = $data['featured_image'] ?? '';
            $author = $data['author'] ?? 'Eduspray Team';
            $category = $data['category'] ?? '';
            $tags = $data['tags'] ?? '';
            $status = $data['status'] ?? 'draft';
            $featured = $data['featured'] ?? 0;
            
            // Check slug uniqueness if changed
            if ($slug) {
                $slugCheck = $pdo->prepare("SELECT id FROM blogs WHERE slug = ? AND id != ?");
                $slugCheck->execute([$slug, $id]);
                if ($slugCheck->fetch()) {
                    $slug .= '-' . time();
                }
            }
            
            $stmt = $pdo->prepare("UPDATE blogs SET title = ?, slug = ?, excerpt = ?, content = ?, featured_image = ?, author = ?, category = ?, tags = ?, status = ?, featured = ? WHERE id = ?");
            $stmt->execute([$title, $slug, $excerpt, $content, $featuredImage, $author, $category, $tags, $status, $featured, $id]);
            
            echo json_encode(['success' => true, 'message' => 'Blog updated successfully']);
            break;
            
        case 'DELETE':
            if (!$isAdmin) {
                throw new Exception('Unauthorized');
            }
            
            $id = $_GET['id'] ?? 0;
            
            if (!$id) {
                throw new Exception('Blog ID is required');
            }
            
            $stmt = $pdo->prepare("DELETE FROM blogs WHERE id = ?");
            $stmt->execute([$id]);
            
            echo json_encode(['success' => true, 'message' => 'Blog deleted successfully']);
            break;
            
        default:
            throw new Exception('Method not allowed');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>



