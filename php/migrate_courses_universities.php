<?php
/**
 * Database Migration Script - Courses & Universities
 * 
 * RUN THIS ONCE after the initial setup
 * Then DELETE this file for security!
 * 
 * Access: http://localhost:8080/php/migrate_courses_universities.php
 */

require_once 'config.php';

echo "<html><head><title>Courses & Universities Migration</title>";
echo "<style>
    body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; background: #1a1a2e; color: #eee; }
    .success { color: #10b981; background: rgba(16, 185, 129, 0.1); padding: 15px; border-radius: 8px; margin: 10px 0; border: 1px solid rgba(16, 185, 129, 0.3); }
    .error { color: #ef4444; background: rgba(239, 68, 68, 0.1); padding: 15px; border-radius: 8px; margin: 10px 0; border: 1px solid rgba(239, 68, 68, 0.3); }
    .warning { color: #f97316; background: rgba(249, 115, 22, 0.1); padding: 15px; border-radius: 8px; margin: 10px 0; border: 1px solid rgba(249, 115, 22, 0.3); }
    .info { color: #6366f1; background: rgba(99, 102, 241, 0.1); padding: 15px; border-radius: 8px; margin: 10px 0; border: 1px solid rgba(99, 102, 241, 0.3); }
    h1 { color: #6366f1; }
    h2 { color: #888; margin-top: 30px; font-size: 18px; }
    code { background: rgba(0,0,0,0.3); padding: 2px 6px; border-radius: 4px; }
</style></head><body>";
echo "<h1>📚 Courses & Universities Migration</h1>";

try {
    // Create courses table
    $coursesTable = "CREATE TABLE IF NOT EXISTS courses (
        id INT AUTO_INCREMENT PRIMARY KEY,
        slug VARCHAR(50) NOT NULL UNIQUE,
        name VARCHAR(100) NOT NULL,
        full_name VARCHAR(200),
        icon VARCHAR(50) DEFAULT 'fas fa-graduation-cap',
        short_description TEXT,
        description LONGTEXT,
        eligibility LONGTEXT,
        career_options LONGTEXT,
        syllabus LONGTEXT,
        preparation_tips LONGTEXT,
        mock_tests LONGTEXT,
        question_papers LONGTEXT,
        study_material LONGTEXT,
        faqs LONGTEXT,
        duration VARCHAR(50),
        avg_fees VARCHAR(100),
        status ENUM('active', 'inactive') DEFAULT 'active',
        display_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_slug (slug),
        INDEX idx_status (status),
        INDEX idx_order (display_order)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($coursesTable);
    echo "<div class='success'>✅ Table <code>courses</code> created/verified successfully!</div>";
    
    // Add new columns if they don't exist
    try {
        $columnsToAdd = [
            'syllabus' => 'LONGTEXT',
            'preparation_tips' => 'LONGTEXT',
            'mock_tests' => 'LONGTEXT',
            'question_papers' => 'LONGTEXT',
            'study_material' => 'LONGTEXT',
            'faqs' => 'LONGTEXT'
        ];
        
        foreach ($columnsToAdd as $column => $type) {
            try {
                $pdo->exec("ALTER TABLE courses ADD COLUMN $column $type");
                echo "<div class='success'>✅ Added column <code>$column</code> to courses table</div>";
            } catch (PDOException $e) {
                if (strpos($e->getMessage(), 'Duplicate column') === false) {
                    throw $e;
                }
                // Column already exists, skip
            }
        }
    } catch (PDOException $e) {
        echo "<div class='error'>⚠️ Error adding columns: " . $e->getMessage() . "</div>";
    }
    
    // Create universities table
    $universitiesTable = "CREATE TABLE IF NOT EXISTS universities (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(200) NOT NULL,
        short_name VARCHAR(50),
        slug VARCHAR(100) NOT NULL UNIQUE,
        type ENUM('government', 'private', 'deemed', 'autonomous') DEFAULT 'private',
        affiliation VARCHAR(200),
        city VARCHAR(100),
        state VARCHAR(100),
        country VARCHAR(100) DEFAULT 'India',
        logo VARCHAR(500),
        website VARCHAR(500),
        established_year INT,
        ranking VARCHAR(100),
        fees_min INT,
        fees_max INT,
        courses JSON,
        description TEXT,
        highlights TEXT,
        facilities TEXT,
        contact_email VARCHAR(200),
        contact_phone VARCHAR(50),
        address TEXT,
        status ENUM('active', 'inactive') DEFAULT 'active',
        featured TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_slug (slug),
        INDEX idx_status (status),
        INDEX idx_type (type),
        INDEX idx_state (state),
        INDEX idx_city (city),
        INDEX idx_featured (featured)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($universitiesTable);
    echo "<div class='success'>✅ Table <code>universities</code> created/verified successfully!</div>";
    
    // Seed initial courses data (from the dropdown)
    echo "<h2>Seeding Initial Courses...</h2>";
    
    $courses = [
        ['btech', 'B.Tech', 'Bachelor of Technology', 'fas fa-microchip', 1],
        ['barch', 'B.Arch', 'Bachelor of Architecture', 'fas fa-building', 2],
        ['bhmct', 'BHMCT', 'Bachelor of Hotel Management & Catering Technology', 'fas fa-hotel', 3],
        ['bca', 'BCA', 'Bachelor of Computer Applications', 'fas fa-laptop-code', 4],
        ['bba', 'BBA', 'Bachelor of Business Administration', 'fas fa-briefcase', 5],
        ['bbe', 'BBE', 'Bachelor of Business Economics', 'fas fa-chart-line', 6],
        ['bajmc', 'BA-JMC', 'Bachelor of Arts in Journalism & Mass Communication', 'fas fa-newspaper', 7],
        ['bcom', 'B.Com (H)', 'Bachelor of Commerce (Honours)', 'fas fa-calculator', 8],
        ['baeng', 'BA-Eng', 'Bachelor of Arts in English', 'fas fa-book', 9],
        ['medical', 'Medical', 'Medical Sciences (MBBS, BDS, etc.)', 'fas fa-stethoscope', 10],
        ['engineering', 'Engineering', 'Engineering Courses', 'fas fa-cogs', 11],
        ['management', 'Business & Management', 'Business & Management Courses', 'fas fa-users-cog', 12],
        ['architecture', 'Architecture', 'Architecture & Design', 'fas fa-drafting-compass', 13],
        ['commerce', 'Commerce', 'Commerce & Accounting', 'fas fa-money-bill-wave', 14],
        ['aviation', 'Aviation', 'Aviation & Pilot Training', 'fas fa-plane', 15],
        ['hotel', 'Hotel Management', 'Hotel & Hospitality Management', 'fas fa-concierge-bell', 16],
        ['humanities', 'Humanities', 'Arts & Humanities', 'fas fa-palette', 17],
        ['journalism', 'Journalism', 'Journalism, Media & Mass Communication', 'fas fa-bullhorn', 18],
    ];
    
    $insertCourse = $pdo->prepare("INSERT IGNORE INTO courses (slug, name, full_name, icon, display_order) VALUES (?, ?, ?, ?, ?)");
    
    $insertedCount = 0;
    foreach ($courses as $course) {
        $insertCourse->execute($course);
        if ($insertCourse->rowCount() > 0) {
            $insertedCount++;
        }
    }
    
    echo "<div class='info'>📝 Inserted $insertedCount new courses (existing courses were skipped)</div>";
    
    // Add sample universities
    echo "<h2>Seeding Sample Universities...</h2>";
    
    $universities = [
        [
            'name' => 'Guru Gobind Singh Indraprastha University',
            'short_name' => 'GGSIPU',
            'slug' => 'ggsipu',
            'type' => 'government',
            'affiliation' => 'UGC',
            'city' => 'New Delhi',
            'state' => 'Delhi',
            'established_year' => 1998,
            'ranking' => 'NIRF Rank 75',
            'fees_min' => 80000,
            'fees_max' => 250000,
            'courses' => json_encode(['btech', 'bba', 'bca', 'medical', 'management']),
            'description' => 'One of the largest universities in Delhi NCR with 100+ affiliated colleges.',
            'featured' => 1
        ],
        [
            'name' => 'Maharaja Agrasen Institute of Technology',
            'short_name' => 'MAIT',
            'slug' => 'mait-delhi',
            'type' => 'private',
            'affiliation' => 'GGSIPU',
            'city' => 'New Delhi',
            'state' => 'Delhi',
            'established_year' => 1999,
            'ranking' => 'NIRF Rank 150-200',
            'fees_min' => 150000,
            'fees_max' => 180000,
            'courses' => json_encode(['btech', 'bca']),
            'description' => 'Premier engineering institute affiliated to GGSIPU.',
            'featured' => 1
        ],
        [
            'name' => 'Delhi University',
            'short_name' => 'DU',
            'slug' => 'delhi-university',
            'type' => 'government',
            'affiliation' => 'UGC',
            'city' => 'New Delhi',
            'state' => 'Delhi',
            'established_year' => 1922,
            'ranking' => 'NIRF Rank 13',
            'fees_min' => 20000,
            'fees_max' => 150000,
            'courses' => json_encode(['bcom', 'baeng', 'bba', 'humanities', 'commerce']),
            'description' => 'One of the most prestigious universities in India.',
            'featured' => 1
        ],
        [
            'name' => 'Amity University',
            'short_name' => 'Amity',
            'slug' => 'amity-noida',
            'type' => 'private',
            'affiliation' => 'UGC',
            'city' => 'Noida',
            'state' => 'Uttar Pradesh',
            'established_year' => 2005,
            'ranking' => 'NIRF Rank 30',
            'fees_min' => 200000,
            'fees_max' => 500000,
            'courses' => json_encode(['btech', 'bba', 'bca', 'hotel', 'aviation', 'journalism']),
            'description' => 'Leading private university with world-class infrastructure.',
            'featured' => 1
        ],
        [
            'name' => 'Lovely Professional University',
            'short_name' => 'LPU',
            'slug' => 'lpu-punjab',
            'type' => 'private',
            'affiliation' => 'UGC',
            'city' => 'Phagwara',
            'state' => 'Punjab',
            'established_year' => 2005,
            'ranking' => 'NIRF Rank 45',
            'fees_min' => 100000,
            'fees_max' => 300000,
            'courses' => json_encode(['btech', 'bba', 'bca', 'barch', 'hotel', 'humanities']),
            'description' => 'Largest single-campus university in India.',
            'featured' => 0
        ]
    ];
    
    $insertUniversity = $pdo->prepare("INSERT IGNORE INTO universities 
        (name, short_name, slug, type, affiliation, city, state, established_year, ranking, fees_min, fees_max, courses, description, featured) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $insertedUniCount = 0;
    foreach ($universities as $uni) {
        $insertUniversity->execute([
            $uni['name'],
            $uni['short_name'],
            $uni['slug'],
            $uni['type'],
            $uni['affiliation'],
            $uni['city'],
            $uni['state'],
            $uni['established_year'],
            $uni['ranking'],
            $uni['fees_min'],
            $uni['fees_max'],
            $uni['courses'],
            $uni['description'],
            $uni['featured']
        ]);
        if ($insertUniversity->rowCount() > 0) {
            $insertedUniCount++;
        }
    }
    
    echo "<div class='info'>🏛️ Inserted $insertedUniCount sample universities (existing universities were skipped)</div>";
    
    echo "<div class='success' style='margin-top: 30px;'>
        <strong>✅ Migration completed successfully!</strong><br><br>
        <strong>Tables created:</strong><br>
        • courses - Stores course information<br>
        • universities - Stores university/college information<br><br>
        <strong>Next steps:</strong><br>
        1. Go to <a href='../admin/courses.php' style='color: #6366f1;'>Admin → Courses</a> to manage courses<br>
        2. Go to <a href='../admin/universities.php' style='color: #6366f1;'>Admin → Universities</a> to manage universities<br>
        3. Delete this migration file for security!
    </div>";
    
    echo "<div class='warning'>
        <strong>⚠️ IMPORTANT:</strong> Delete this file after migration!<br>
        <code>Delete: /php/migrate_courses_universities.php</code>
    </div>";
    
} catch (PDOException $e) {
    echo "<div class='error'>❌ Error: " . $e->getMessage() . "</div>";
}

echo "</body></html>";
?>





