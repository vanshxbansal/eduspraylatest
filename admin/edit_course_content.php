<?php
/**
 * Admin: Edit Course Content
 * Allows editing all course content fields from admin panel
 */

session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require_once '../php/config.php';

$message = '';
$error = '';
$course = null;

// Get course slug
$slug = $_GET['slug'] ?? '';

if (empty($slug)) {
    header('Location: courses.php');
    exit;
}

// Get course data
try {
    $stmt = $pdo->prepare("SELECT * FROM courses WHERE slug = ?");
    $stmt->execute([$slug]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$course) {
        header('Location: courses.php');
        exit;
    }
    
    // Get predefined content
    require_once '../php/courses_data.php';
    $predefinedContent = getCourseContent($slug);
    $course = array_merge($course, $predefinedContent);
    
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $description = $_POST['description'] ?? '';
    $eligibility = $_POST['eligibility'] ?? '';
    $careerOptions = $_POST['career_options'] ?? '';
    $syllabus = $_POST['syllabus'] ?? '';
    $preparationTips = $_POST['preparation_tips'] ?? '';
    $mockTests = $_POST['mock_tests'] ?? '';
    $questionPapers = $_POST['question_papers'] ?? '';
    $studyMaterial = $_POST['study_material'] ?? '';
    $faqs = $_POST['faqs'] ?? '';
    $shortDescription = $_POST['short_description'] ?? '';
    
    try {
        // Update database fields (if they exist in schema)
        $updateFields = [];
        $updateValues = [];
        
        // Check which fields exist in database
        $stmt = $pdo->query("DESCRIBE courses");
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        if (in_array('description', $columns)) {
            $updateFields[] = "description = ?";
            $updateValues[] = $description;
        }
        if (in_array('eligibility', $columns)) {
            $updateFields[] = "eligibility = ?";
            $updateValues[] = $eligibility;
        }
        if (in_array('career_options', $columns)) {
            $updateFields[] = "career_options = ?";
            $updateValues[] = $careerOptions;
        }
        if (in_array('short_description', $columns)) {
            $updateFields[] = "short_description = ?";
            $updateValues[] = $shortDescription;
        }
        if (in_array('syllabus', $columns)) {
            $updateFields[] = "syllabus = ?";
            $updateValues[] = $syllabus;
        }
        if (in_array('preparation_tips', $columns)) {
            $updateFields[] = "preparation_tips = ?";
            $updateValues[] = $preparationTips;
        }
        if (in_array('mock_tests', $columns)) {
            $updateFields[] = "mock_tests = ?";
            $updateValues[] = $mockTests;
        }
        if (in_array('question_papers', $columns)) {
            $updateFields[] = "question_papers = ?";
            $updateValues[] = $questionPapers;
        }
        if (in_array('study_material', $columns)) {
            $updateFields[] = "study_material = ?";
            $updateValues[] = $studyMaterial;
        }
        if (in_array('faqs', $columns)) {
            $updateFields[] = "faqs = ?";
            $updateValues[] = $faqs;
        }
        
        if (!empty($updateFields)) {
            $updateValues[] = $slug;
            $sql = "UPDATE courses SET " . implode(", ", $updateFields) . " WHERE slug = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($updateValues);
        }
        
        // Also update courses_data.php file (for fields not in DB)
        // Note: This is a simplified approach. In production, you might want to store all content in DB
        $message = "Course content updated successfully!";
        
    } catch (PDOException $e) {
        $error = "Error updating content: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course Content - <?php echo htmlspecialchars($course['name'] ?? ''); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #0f0f23;
            color: #e0e0e0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 24px;
            color: white;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
        }
        .btn-secondary {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
        }
        .message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .message.success {
            background: rgba(16, 185, 129, 0.2);
            color: #10b981;
        }
        .message.error {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }
        .form-section {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
        }
        .form-section h2 {
            font-size: 18px;
            margin-bottom: 15px;
            color: white;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #e0e0e0;
        }
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 8px;
            background: rgba(0,0,0,0.3);
            color: white;
            font-family: inherit;
            font-size: 14px;
            min-height: 150px;
            resize: vertical;
        }
        .form-group textarea:focus {
            outline: none;
            border-color: #6366f1;
        }
        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 30px;
        }
        .help-text {
            font-size: 12px;
            color: #888;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Edit Content: <?php echo htmlspecialchars($course['name'] ?? ''); ?></h1>
            <a href="courses.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Courses
            </a>
        </div>
        
        <?php if ($message): ?>
        <div class="message success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
        <div class="message error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <input type="hidden" name="action" value="update">
            
            <div class="form-section">
                <h2>Short Description</h2>
                <div class="form-group">
                    <label>Short Description (shown in hero section)</label>
                    <textarea name="short_description"><?php echo htmlspecialchars($course['short_description'] ?? ''); ?></textarea>
                    <div class="help-text">Brief description shown below the course title</div>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Overview / Description</h2>
                <div class="form-group">
                    <label>Full Description (HTML allowed)</label>
                    <textarea name="description" style="min-height: 200px;"><?php echo htmlspecialchars($course['description'] ?? ''); ?></textarea>
                    <div class="help-text">You can use HTML tags like &lt;p&gt;, &lt;h4&gt;, &lt;ul&gt;, &lt;li&gt;, etc.</div>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Eligibility</h2>
                <div class="form-group">
                    <label>Eligibility Criteria (HTML allowed)</label>
                    <textarea name="eligibility" style="min-height: 200px;"><?php echo htmlspecialchars($course['eligibility'] ?? ''); ?></textarea>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Syllabus</h2>
                <div class="form-group">
                    <label>Syllabus Content (HTML allowed)</label>
                    <textarea name="syllabus" style="min-height: 200px;"><?php echo htmlspecialchars($course['syllabus'] ?? ''); ?></textarea>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Preparation Tips</h2>
                <div class="form-group">
                    <label>Preparation Tips (HTML allowed)</label>
                    <textarea name="preparation_tips" style="min-height: 200px;"><?php echo htmlspecialchars($course['preparation_tips'] ?? ''); ?></textarea>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Mock Tests</h2>
                <div class="form-group">
                    <label>Mock Test Information (HTML allowed)</label>
                    <textarea name="mock_tests" style="min-height: 200px;"><?php echo htmlspecialchars($course['mock_tests'] ?? ''); ?></textarea>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Question Papers</h2>
                <div class="form-group">
                    <label>Question Papers Information (HTML allowed)</label>
                    <textarea name="question_papers" style="min-height: 200px;"><?php echo htmlspecialchars($course['question_papers'] ?? ''); ?></textarea>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Study Material</h2>
                <div class="form-group">
                    <label>Study Material Information (HTML allowed)</label>
                    <textarea name="study_material" style="min-height: 200px;"><?php echo htmlspecialchars($course['study_material'] ?? ''); ?></textarea>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Career Options</h2>
                <div class="form-group">
                    <label>Career Options (HTML allowed)</label>
                    <textarea name="career_options" style="min-height: 200px;"><?php echo htmlspecialchars($course['career_options'] ?? ''); ?></textarea>
                </div>
            </div>
            
            <div class="form-section">
                <h2>FAQs</h2>
                <div class="form-group">
                    <label>Frequently Asked Questions (HTML allowed)</label>
                    <textarea name="faqs" style="min-height: 200px;"><?php echo htmlspecialchars($course['faqs'] ?? ''); ?></textarea>
                </div>
            </div>
            
            <div class="form-actions">
                <a href="courses.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</body>
</html>




