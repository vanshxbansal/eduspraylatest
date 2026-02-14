<?php
/**
 * Admin College Cards Management
 * Full CRUD for college cards displayed on home page
 */

session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /admin/login.php');
    exit;
}

// Include database config
require_once '../php/config.php';

$message = '';
$error = '';

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add') {
        $category = trim($_POST['category']);
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $imageUrl = trim($_POST['image_url']);
        $linkUrl = trim($_POST['link_url']) ?: 'contact.html';
        $rankOrder = (int)$_POST['rank_order'] ?: 0;
        $status = $_POST['status'];
        
        try {
            $stmt = $pdo->prepare("INSERT INTO college_cards (category, title, description, image_url, link_url, rank_order, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$category, $title, $description, $imageUrl, $linkUrl, $rankOrder, $status]);
            $message = "College card added successfully!";
        } catch (PDOException $e) {
            $error = "Error adding college card: " . $e->getMessage();
        }
    } elseif ($_POST['action'] === 'update') {
        $id = (int)$_POST['card_id'];
        $category = trim($_POST['category']);
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $imageUrl = trim($_POST['image_url']);
        $linkUrl = trim($_POST['link_url']) ?: 'contact.html';
        $rankOrder = (int)$_POST['rank_order'] ?: 0;
        $status = $_POST['status'];
        
        try {
            $stmt = $pdo->prepare("UPDATE college_cards SET category = ?, title = ?, description = ?, image_url = ?, link_url = ?, rank_order = ?, status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
            $stmt->execute([$category, $title, $description, $imageUrl, $linkUrl, $rankOrder, $status, $id]);
            $message = "College card updated successfully!";
        } catch (PDOException $e) {
            $error = "Error updating college card: " . $e->getMessage();
        }
    } elseif ($_POST['action'] === 'delete') {
        $id = (int)$_POST['card_id'];
        
        try {
            $stmt = $pdo->prepare("DELETE FROM college_cards WHERE id = ?");
            $stmt->execute([$id]);
            $message = "College card deleted successfully!";
        } catch (PDOException $e) {
            $error = "Error deleting college card: " . $e->getMessage();
        }
    }
}

// Get filters
$filterCategory = isset($_GET['category']) ? $_GET['category'] : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build query
$query = "SELECT * FROM college_cards WHERE 1=1";
$params = [];

if ($filterCategory) {
    $query .= " AND category = ?";
    $params[] = $filterCategory;
}

if ($search) {
    $query .= " AND (title LIKE ? OR description LIKE ?)";
    $searchTerm = "%$search%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
}

$query .= " ORDER BY category, rank_order ASC, id ASC";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $cards = [];
    $error = "Error fetching cards: " . $e->getMessage();
}

// Get unique categories
try {
    $stmt = $pdo->query("SELECT DISTINCT category FROM college_cards ORDER BY category");
    $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    $categories = [];
}

// Get card for editing
$editCard = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM college_cards WHERE id = ?");
        $stmt->execute([$editId]);
        $editCard = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = "Error fetching card: " . $e->getMessage();
    }
}

// Common categories
$commonCategories = [
    'University of Delhi-NCR',
    'IPU',
    'UK'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Cards Management - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .admin-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 1rem 1.5rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5568d3 0%, #653a91 100%);
        }
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        .badge {
            padding: 0.5em 0.75em;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .alert {
            border-radius: 10px;
        }
        .card-image-preview {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-0"><i class="fas fa-id-card"></i> College Cards Management</h1>
                    <p class="mb-0 mt-2">Manage college cards displayed on the home page</p>
                </div>
                <div>
                    <a href="index.php" class="btn btn-light"><i class="fas fa-home"></i> Dashboard</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <?php if ($message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Add/Edit Form -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-<?php echo $editCard ? 'edit' : 'plus'; ?>"></i>
                    <?php echo $editCard ? 'Edit College Card' : 'Add New College Card'; ?>
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <input type="hidden" name="action" value="<?php echo $editCard ? 'update' : 'add'; ?>">
                    <?php if ($editCard): ?>
                        <input type="hidden" name="card_id" value="<?php echo $editCard['id']; ?>">
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="">Select Category</option>
                                <?php foreach ($commonCategories as $cat): ?>
                                    <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo ($editCard && $editCard['category'] === $cat) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($cat); ?>
                                    </option>
                                <?php endforeach; ?>
                                <?php foreach ($categories as $cat): ?>
                                    <?php if (!in_array($cat, $commonCategories)): ?>
                                        <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo ($editCard && $editCard['category'] === $cat) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat); ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Or type a new category name</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="rank_order" class="form-label">Rank/Order</label>
                            <input type="number" class="form-control" id="rank_order" name="rank_order" 
                                   value="<?php echo $editCard ? htmlspecialchars($editCard['rank_order']) : '0'; ?>" min="0">
                            <small class="text-muted">Lower numbers appear first</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?php echo $editCard ? htmlspecialchars($editCard['title']) : ''; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="4" required><?php echo $editCard ? htmlspecialchars($editCard['description']) : ''; ?></textarea>
                        <small class="text-muted">Keep it concise (recommended: 100-200 characters)</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="image_url" class="form-label">Image URL <span class="text-danger">*</span></label>
                            <input type="url" class="form-control" id="image_url" name="image_url" 
                                   value="<?php echo $editCard ? htmlspecialchars($editCard['image_url']) : ''; ?>" required>
                            <?php if ($editCard && $editCard['image_url']): ?>
                                <div class="mt-2">
                                    <img src="<?php echo htmlspecialchars($editCard['image_url']); ?>" 
                                         alt="Preview" class="card-image-preview" 
                                         onerror="this.style.display='none'">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="link_url" class="form-label">Link URL</label>
                            <input type="url" class="form-control" id="link_url" name="link_url" 
                                   value="<?php echo $editCard ? htmlspecialchars($editCard['link_url']) : 'contact.html'; ?>">
                            <small class="text-muted">Default: contact.html</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="active" <?php echo ($editCard && $editCard['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo ($editCard && $editCard['status'] === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> <?php echo $editCard ? 'Update Card' : 'Add Card'; ?>
                        </button>
                        <?php if ($editCard): ?>
                            <a href="college_cards.php" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Filters -->
        <div class="card">
            <div class="card-body">
                <form method="GET" action="" class="row g-3">
                    <div class="col-md-4">
                        <label for="filter_category" class="form-label">Filter by Category</label>
                        <select class="form-select" id="filter_category" name="category">
                            <option value="">All Categories</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo $filterCategory === $cat ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="<?php echo htmlspecialchars($search); ?>" placeholder="Search by title or description">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Cards List -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-list"></i> All College Cards (<?php echo count($cards); ?>)</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Rank</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($cards)): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No college cards found. Add your first card above!</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($cards as $card): ?>
                                    <tr>
                                        <td><?php echo $card['id']; ?></td>
                                        <td>
                                            <?php if ($card['image_url']): ?>
                                                <img src="<?php echo htmlspecialchars($card['image_url']); ?>" 
                                                     alt="Card" class="card-image-preview"
                                                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%27100%27 height=%27100%27%3E%3Crect fill=%27%23ddd%27 width=%27100%27 height=%27100%27/%3E%3Ctext fill=%27%23999%27 x=%2750%25%27 y=%2750%25%27 text-anchor=%27middle%27 dy=%27.3em%27%3ENo Image%3C/text%3E%3C/svg%3E'">
                                            <?php else: ?>
                                                <span class="text-muted">No image</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($card['title']); ?></strong><br>
                                            <small class="text-muted"><?php echo htmlspecialchars(substr($card['description'], 0, 60)) . '...'; ?></small>
                                        </td>
                                        <td>
                                            <span class="badge bg-info"><?php echo htmlspecialchars($card['category']); ?></span>
                                        </td>
                                        <td><?php echo $card['rank_order']; ?></td>
                                        <td>
                                            <?php if ($card['status'] === 'active'): ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="?edit=<?php echo $card['id']; ?>" class="btn btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="" style="display: inline;" 
                                                      onsubmit="return confirm('Are you sure you want to delete this card?');">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="card_id" value="<?php echo $card['id']; ?>">
                                                    <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Image preview on input
        document.getElementById('image_url')?.addEventListener('input', function(e) {
            const preview = document.querySelector('.card-image-preview');
            if (preview && e.target.value) {
                preview.src = e.target.value;
            }
        });
    </script>
</body>
</html>

