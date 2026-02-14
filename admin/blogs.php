<?php
/**
 * Admin Blogs Management
 * Manage blog posts
 */

session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /admin/login.php');
    exit;
}

require_once '../php/config.php';

$message = '';
$error = '';

// Handle blog operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'add' || $_POST['action'] === 'update') {
        $id = isset($_POST['blog_id']) ? intval($_POST['blog_id']) : 0;
        $title = trim($_POST['title']);
        $slug = trim($_POST['slug']) ?: strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $excerpt = trim($_POST['excerpt']);
        $content = trim($_POST['content']);
        $featuredImage = trim($_POST['featured_image']);
        $author = trim($_POST['author']) ?: 'Eduspray Team';
        $category = trim($_POST['category']);
        $tags = trim($_POST['tags']);
        $status = $_POST['status'];
        $featured = isset($_POST['featured']) ? 1 : 0;
        
        try {
            if ($_POST['action'] === 'add') {
                // Check slug uniqueness
                $slugCheck = $pdo->prepare("SELECT id FROM blogs WHERE slug = ?");
                $slugCheck->execute([$slug]);
                if ($slugCheck->fetch()) {
                    $slug .= '-' . time();
                }
                
                $stmt = $pdo->prepare("INSERT INTO blogs (title, slug, excerpt, content, featured_image, author, category, tags, status, featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$title, $slug, $excerpt, $content, $featuredImage, $author, $category, $tags, $status, $featured]);
                $message = "Blog added successfully!";
            } else {
                // Check slug uniqueness for update
                $slugCheck = $pdo->prepare("SELECT id FROM blogs WHERE slug = ? AND id != ?");
                $slugCheck->execute([$slug, $id]);
                if ($slugCheck->fetch()) {
                    $slug .= '-' . time();
                }
                
                $stmt = $pdo->prepare("UPDATE blogs SET title = ?, slug = ?, excerpt = ?, content = ?, featured_image = ?, author = ?, category = ?, tags = ?, status = ?, featured = ? WHERE id = ?");
                $stmt->execute([$title, $slug, $excerpt, $content, $featuredImage, $author, $category, $tags, $status, $featured, $id]);
                $message = "Blog updated successfully!";
            }
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    } elseif ($_POST['action'] === 'delete') {
        $id = intval($_POST['blog_id']);
        try {
            $stmt = $pdo->prepare("DELETE FROM blogs WHERE id = ?");
            $stmt->execute([$id]);
            $message = "Blog deleted successfully!";
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}

// Get all blogs
try {
    $stmt = $pdo->query("SELECT * FROM blogs ORDER BY created_at DESC");
    $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $blogs = [];
    $error = "Error loading blogs: " . $e->getMessage();
}

// Get blog for editing
$editingBlog = null;
if (isset($_GET['edit'])) {
    $editId = intval($_GET['edit']);
    foreach ($blogs as $blog) {
        if ($blog['id'] === $editId) {
            $editingBlog = $blog;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs Management | Eduspray Admin</title>
    <link rel="shortcut icon" href="../images/02.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #0f0f23; color: #e0e0e0; min-height: 100vh; }
        .layout { display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background: linear-gradient(180deg, #1a1a3e 0%, #0f0f23 100%); border-right: 1px solid rgba(255,255,255,0.05); padding: 30px 0; position: fixed; height: 100vh; overflow-y: auto; }
        .logo { padding: 0 25px 30px; border-bottom: 1px solid rgba(255,255,255,0.05); margin-bottom: 25px; }
        .logo h1 { font-size: 22px; font-weight: 700; color: white; }
        .logo h1 span { color: #6366f1; }
        .nav-menu { list-style: none; }
        .nav-item a { display: flex; align-items: center; gap: 15px; padding: 14px 25px; color: #888; text-decoration: none; font-weight: 500; transition: all 0.3s ease; border-left: 3px solid transparent; }
        .nav-item a:hover, .nav-item a.active { color: white; background: rgba(99, 102, 241, 0.1); border-left-color: #6366f1; }
        .nav-item a i { width: 22px; font-size: 16px; }
        .nav-section { font-size: 11px; text-transform: uppercase; color: #555; padding: 20px 25px 10px; letter-spacing: 1px; }
        .main-content { flex: 1; margin-left: 260px; padding: 30px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h2 { font-size: 28px; font-weight: 700; color: white; }
        .card { background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%); border: 1px solid rgba(255,255,255,0.05); border-radius: 16px; padding: 25px; margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; color: #888; font-size: 13px; font-weight: 600; margin-bottom: 8px; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white; font-size: 14px; font-family: inherit; }
        .form-group input:focus, .form-group textarea:focus, .form-group select:focus { outline: none; border-color: #6366f1; background: rgba(99, 102, 241, 0.1); }
        .form-group textarea { min-height: 150px; resize: vertical; }
        .form-group textarea.content { min-height: 300px; }
        .btn { padding: 12px 24px; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s; text-decoration: none; display: inline-block; }
        .btn-primary { background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 5px 20px rgba(99, 102, 241, 0.3); }
        .btn-secondary { background: rgba(255,255,255,0.1); color: white; }
        .btn-danger { background: rgba(239, 68, 68, 0.2); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); }
        .btn-danger:hover { background: rgba(239, 68, 68, 0.3); }
        .btn-sm { padding: 8px 16px; font-size: 12px; }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-success { background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #10b981; }
        .alert-error { background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; }
        .blog-list { display: grid; gap: 15px; }
        .blog-item { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; padding: 20px; }
        .blog-item-header { display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px; }
        .blog-item h3 { color: white; font-size: 18px; margin-bottom: 8px; }
        .blog-item-meta { display: flex; gap: 15px; font-size: 12px; color: #888; margin-bottom: 10px; }
        .blog-item-excerpt { color: #aaa; font-size: 13px; line-height: 1.6; margin-bottom: 15px; }
        .blog-item-actions { display: flex; gap: 10px; }
        .badge { padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; }
        .badge-published { background: rgba(16, 185, 129, 0.2); color: #10b981; }
        .badge-draft { background: rgba(249, 115, 22, 0.2); color: #f97316; }
        .badge-featured { background: rgba(99, 102, 241, 0.2); color: #6366f1; margin-left: 8px; }
        .checkbox-group { display: flex; align-items: center; gap: 10px; }
        .checkbox-group input[type="checkbox"] { width: auto; }
    </style>
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <div class="logo">
                <h1>Edu<span>spray</span></h1>
                <p style="font-size: 12px; color: #666; margin-top: 5px;">Admin Panel</p>
            </div>
            <ul class="nav-menu">
                <li class="nav-item"><a href="index.php"><i class="fas fa-chart-pie"></i> <span>Dashboard</span></a></li>
                <div class="nav-section">Content Management</div>
                <li class="nav-item"><a href="courses.php"><i class="fas fa-graduation-cap"></i> <span>Courses</span></a></li>
                <li class="nav-item"><a href="universities.php"><i class="fas fa-university"></i> <span>Universities</span></a></li>
                <li class="nav-item"><a href="home_page.php"><i class="fas fa-home"></i> <span>Home Page</span></a></li>
                <li class="nav-item"><a href="blogs.php" class="active"><i class="fas fa-blog"></i> <span>Blogs</span></a></li>
                <div class="nav-section">Quick Links</div>
                <li class="nav-item"><a href="../index.html" target="_blank"><i class="fas fa-external-link-alt"></i> <span>View Website</span></a></li>
                <li class="nav-item"><a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
            </ul>
        </aside>
        <main class="main-content">
            <div class="header">
                <h2>Blogs Management</h2>
                <?php if (!$editingBlog): ?>
                <button onclick="document.getElementById('addBlogForm').scrollIntoView({behavior: 'smooth'})" class="btn btn-primary">+ Add New Blog</button>
                <?php endif; ?>
            </div>
            
            <?php if ($message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($editingBlog): ?>
            <div class="card">
                <h3 style="color: white; margin-bottom: 20px;">Edit Blog</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="blog_id" value="<?php echo $editingBlog['id']; ?>">
                    
                    <div class="form-group">
                        <label>Title *</label>
                        <input type="text" name="title" value="<?php echo htmlspecialchars($editingBlog['title']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" name="slug" value="<?php echo htmlspecialchars($editingBlog['slug']); ?>" placeholder="auto-generated-from-title">
                    </div>
                    
                    <div class="form-group">
                        <label>Excerpt</label>
                        <textarea name="excerpt" rows="3"><?php echo htmlspecialchars($editingBlog['excerpt']); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Content *</label>
                        <textarea name="content" class="content" required><?php echo htmlspecialchars($editingBlog['content']); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Featured Image URL</label>
                        <input type="text" name="featured_image" value="<?php echo htmlspecialchars($editingBlog['featured_image']); ?>" placeholder="images/blog-image.jpg">
                    </div>
                    
                    <div class="form-group">
                        <label>Author</label>
                        <input type="text" name="author" value="<?php echo htmlspecialchars($editingBlog['author']); ?>" placeholder="Eduspray Team">
                    </div>
                    
                    <div class="form-group">
                        <label>Category</label>
                        <input type="text" name="category" value="<?php echo htmlspecialchars($editingBlog['category']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Tags (comma separated)</label>
                        <input type="text" name="tags" value="<?php echo htmlspecialchars($editingBlog['tags']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="draft" <?php echo $editingBlog['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                            <option value="published" <?php echo $editingBlog['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                            <option value="archived" <?php echo $editingBlog['status'] === 'archived' ? 'selected' : ''; ?>>Archived</option>
                        </select>
                    </div>
                    
                    <div class="form-group checkbox-group">
                        <input type="checkbox" name="featured" id="featured" value="1" <?php echo $editingBlog['featured'] ? 'checked' : ''; ?>>
                        <label for="featured" style="margin: 0;">Feature on Home Page</label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Blog</button>
                    <a href="blogs.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
            <?php else: ?>
            <!-- Add New Blog Form -->
            <div class="card" id="addBlogForm">
                <h3 style="color: white; margin-bottom: 20px;">Add New Blog</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="add">
                    
                    <div class="form-group">
                        <label>Title *</label>
                        <input type="text" name="title" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Slug (leave empty for auto-generation)</label>
                        <input type="text" name="slug" placeholder="auto-generated-from-title">
                    </div>
                    
                    <div class="form-group">
                        <label>Excerpt</label>
                        <textarea name="excerpt" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Content *</label>
                        <textarea name="content" class="content" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Featured Image URL</label>
                        <input type="text" name="featured_image" placeholder="images/blog-image.jpg">
                    </div>
                    
                    <div class="form-group">
                        <label>Author</label>
                        <input type="text" name="author" value="Eduspray Team">
                    </div>
                    
                    <div class="form-group">
                        <label>Category</label>
                        <input type="text" name="category">
                    </div>
                    
                    <div class="form-group">
                        <label>Tags (comma separated)</label>
                        <input type="text" name="tags">
                    </div>
                    
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                    
                    <div class="form-group checkbox-group">
                        <input type="checkbox" name="featured" id="featured_new" value="1">
                        <label for="featured_new" style="margin: 0;">Feature on Home Page</label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Add Blog</button>
                </form>
            </div>
            
            <!-- Blogs List -->
            <div class="card">
                <h3 style="color: white; margin-bottom: 20px;">All Blogs</h3>
                <div class="blog-list">
                    <?php if (empty($blogs)): ?>
                    <p style="color: #888; text-align: center; padding: 40px;">No blogs found. Add your first blog above!</p>
                    <?php else: ?>
                    <?php foreach ($blogs as $blog): ?>
                    <div class="blog-item">
                        <div class="blog-item-header">
                            <div style="flex: 1;">
                                <h3><?php echo htmlspecialchars($blog['title']); ?></h3>
                                <div class="blog-item-meta">
                                    <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($blog['author']); ?></span>
                                    <span><i class="fas fa-calendar"></i> <?php echo date('M d, Y', strtotime($blog['created_at'])); ?></span>
                                    <span><i class="fas fa-eye"></i> <?php echo number_format($blog['views'] ?? 0); ?> views</span>
                                </div>
                                <?php if (!empty($blog['excerpt'])): ?>
                                <div class="blog-item-excerpt"><?php echo htmlspecialchars(substr($blog['excerpt'], 0, 150)); ?>...</div>
                                <?php endif; ?>
                            </div>
                            <div>
                                <span class="badge <?php echo $blog['status'] === 'published' ? 'badge-published' : 'badge-draft'; ?>">
                                    <?php echo ucfirst($blog['status']); ?>
                                </span>
                                <?php if ($blog['featured']): ?>
                                <span class="badge badge-featured">Featured</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="blog-item-actions">
                            <a href="?edit=<?php echo $blog['id']; ?>" class="btn btn-secondary btn-sm">Edit</a>
                            <a href="../blog-detail.php?slug=<?php echo urlencode($blog['slug']); ?>" target="_blank" class="btn btn-secondary btn-sm">View</a>
                            <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="blog_id" value="<?php echo $blog['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>


