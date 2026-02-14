<?php
/**
 * Data Migration Script - College Cards
 * 
 * This script migrates the hardcoded college cards data to the database
 * RUN THIS ONCE after creating the table
 * Then DELETE this file for security!
 * 
 * Access: http://localhost:8000/php/migrate_college_cards_data.php
 */

require_once 'config.php';

echo "<html><head><title>College Cards Data Migration</title>";
echo "<style>
    body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; background: #1a1a2e; color: #eee; }
    .success { color: #10b981; background: rgba(16, 185, 129, 0.1); padding: 15px; border-radius: 8px; margin: 10px 0; border: 1px solid rgba(16, 185, 129, 0.3); }
    .error { color: #ef4444; background: rgba(239, 68, 68, 0.1); padding: 15px; border-radius: 8px; margin: 10px 0; border: 1px solid rgba(239, 68, 68, 0.3); }
    .warning { color: #f97316; background: rgba(249, 115, 22, 0.1); padding: 15px; border-radius: 8px; margin: 10px 0; border: 1px solid rgba(249, 115, 22, 0.3); }
    .info { color: #6366f1; background: rgba(99, 102, 241, 0.1); padding: 15px; border-radius: 8px; margin: 10px 0; border: 1px solid rgba(99, 102, 241, 0.3); }
    h1 { color: #6366f1; }
    code { background: rgba(0,0,0,0.3); padding: 2px 6px; border-radius: 4px; }
</style></head><body>";
echo "<h1>📚 College Cards Data Migration</h1>";

// Check if table exists
try {
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM college_cards");
    $existingCount = $stmt->fetch()['count'];
    
    if ($existingCount > 0) {
        echo "<div class='warning'>⚠️ Table already contains <strong>$existingCount</strong> records. This script will add new records only.</div>";
    }
} catch (PDOException $e) {
    echo "<div class='error'>❌ Error: Table 'college_cards' does not exist. Please run migrate_college_cards.php first!</div>";
    echo "</body></html>";
    exit;
}

// University of Delhi-NCR cards
$delhiCards = [
    ['category' => 'University of Delhi-NCR', 'title' => '1. Shri Ram College of Commerce', 'description' => 'Shri Ram College of Commerce or SRCC is an Indian Higher Education Institution in the fields of commerce, economics and business management.', 'image_url' => 'https://tsusjammu.org/wp-content/uploads/2017/07/college_commerce.jpg', 'rank_order' => 1],
    ['category' => 'University of Delhi-NCR', 'title' => '2. St. Stephen\'s College', 'description' => 'St. Stephen\'s College is a constituent college of the University of Delhi-NCR. Awarding both undergraduate and postgraduate degrees, it is regarded as the most prestigious liberal arts college in India.', 'image_url' => 'https://miro.medium.com/v2/resize:fit:800/0*vfd-5ffMhqhdb8rp.jpg', 'rank_order' => 2],
    ['category' => 'University of Delhi-NCR', 'title' => '3. Hindu College', 'description' => 'Hindu College is a constituent college of the University of Delhi-NCR in New Delhi-NCR, India. Founded in 1899, it is one of India\'s oldest and most renowned colleges. It is ranked second best among colleges in India as per the latest National Institute Ranking Framework (NIRF).', 'image_url' => 'https://static.toiimg.com/thumb/msid-104844229,width-1280,height-720,resizemode-4/104844229.jpg', 'rank_order' => 3],
    ['category' => 'University of Delhi-NCR', 'title' => '4. Hans Raj College', 'description' => 'Hansraj College is a constituent college of the University of Delhi-NCR, in Delhi-NCR, India. Established in 1948 and situated in the Delhi-NCR University North Campus, it is considered as one of the best colleges in India.', 'image_url' => 'https://www.hansrajcollege.in/wp-content/uploads/2015/03/1413891676.jpg', 'rank_order' => 4],
    ['category' => 'University of Delhi-NCR', 'title' => '5. Kirori Mal College', 'description' => 'Kirori Mal College is a constituent college of the University of Delhi-NCR. It is ranked 2nd best college for Political Science and 6th best college for Chemistry in India according to India Today 2023 College Ranking.', 'image_url' => 'https://images.shiksha.com/mediadata/images/1610521322phpbKg4OR.png', 'rank_order' => 5],
    ['category' => 'University of Delhi-NCR', 'title' => '6. Ramjas College', 'description' => 'Ramjas College is a college of the University of Delhi-NCR located in North Campus of the university in New Delhi-NCR, India. The college admits both undergraduates and post-graduates.', 'image_url' => 'images/ramjascollege.png', 'rank_order' => 6],
    ['category' => 'University of Delhi-NCR', 'title' => '7. Miranda House', 'description' => 'Miranda House is a constituent college for women at the University of Delhi-NCR in India. Established in 1948, it is one of the top ranked colleges of the country and ranked as number 1 for consecutively seven years.', 'image_url' => 'https://images.shiksha.com/mediadata/images/1491465043phpiMaIek.jpeg', 'rank_order' => 7],
    ['category' => 'University of Delhi-NCR', 'title' => '8. Sri Venkateswara College', 'description' => 'Sri Venkateswara College is a constituent college of the University of Delhi-NCR established in 1961 in New Delhi-NCR, India. It is managed by Tirumala Tirupati Devasthanams & UGC and awards degrees under the purview of the University of Delhi-NCR.', 'image_url' => 'https://static.toiimg.com/thumb/msid-80896994,width-1280,height-720,resizemode-4/80896994.jpg', 'rank_order' => 8],
    ['category' => 'University of Delhi-NCR', 'title' => '9. College of Vocational Studies', 'description' => 'The College of Vocational Studies is a constituent college of the University of Delhi-NCR. It is a co-educational college founded in 1972 with emphasis on vocational education to bridge the gap between.', 'image_url' => 'https://media.licdn.com/dms/image/C511BAQHGdJvkqZs_7g/company-background_10000/0/1584451986668/college_of_vocational_studies_cover?e=2147483647&v=beta&t=js3lBrmteW4umh634UzBe9ioBno4n_mTmnGVmiT9aTs', 'rank_order' => 9],
    ['category' => 'University of Delhi-NCR', 'title' => '10. Lady Shri Ram College For Women', 'description' => 'Lady Shri Ram College for Women, has long been recognized as a premier institution of higher learning for women in India. Founded in 1956, Constituent women\'s college of the University of Delhi-NCR for Social Sciences, Humanities and Commerce.', 'image_url' => 'https://tsusjammu.org/wp-content/uploads/2017/07/lsr.jpg', 'rank_order' => 10],
];

// IPU cards
$ipuCards = [
    ['category' => 'IPU', 'title' => '1. USAR-Delhi-NCR', 'description' => 'The University School of Automation & Robotics Delhi-NCR is widely regarded as one of the premier government colleges in Delhi-NCR.', 'image_url' => 'images/east.jpg', 'rank_order' => 1],
    ['category' => 'IPU', 'title' => '2. Maharaja Agrasen Institute Of Technology', 'description' => 'Maharaja Agrasen Institute of Technology (MAIT) is established by Maharaja Agrasen Technical Education Society, in 1999.', 'image_url' => 'images/mait.png', 'rank_order' => 2],
    ['category' => 'IPU', 'title' => '3. Maharaja Surajmal Institute of Technology', 'description' => 'Information Technology is most prominent and rapidly developing field in todays world. To maintain speed with latest trends in Information Technology industry.', 'image_url' => 'https://ipubuzz.com/wp-content/uploads/2020/08/3EE47F7537F01FC4-1-1024x682.jpeg', 'rank_order' => 3],
    ['category' => 'IPU', 'title' => '4. Vivekananda Institute of Professional Studies', 'description' => 'Vivekananda Institute of Professional Studies is in Pitampura, New Delhi-NCR, India. It is a private college, affiliated with Guru Gobind Singh Indraprastha University. It has seven different schools/departments.', 'image_url' => 'images/viiips.png', 'rank_order' => 4],
    ['category' => 'IPU', 'title' => '5. Bhagwan Parshuram Institute of Technology', 'description' => 'Bhagwan Parshuram Institute of Technology provides students with the benefit of the knowledge and skills acquired by its trained and experienced faculty.', 'image_url' => 'images/BPIT.jpg', 'rank_order' => 5],
    ['category' => 'IPU', 'title' => '6. Dr. Akhilesh Das Gupta Institute of Technology & Management', 'description' => 'Dr. Akhilesh Das Gupta Institute of Technology & Management, formerly known as Northern India Engineering College is a private institution.', 'image_url' => 'images/Adgitm.png', 'rank_order' => 6],
    ['category' => 'IPU', 'title' => '7. SGT BAHADUR college', 'description' => 'SGTB Khalsa College, Anandpur Sahib, is committed to deliver quality education in undergraduate and postgraduate streams of commerce, science, management, computer applications.', 'image_url' => 'https://www.sgtbimit.com/public/frontend/images/about/about-sgtbimit.jpg', 'rank_order' => 7],
    ['category' => 'IPU', 'title' => '8. Jagan Institute of Management Studies Technical Campus- JIMS Rohini', 'description' => 'To serve the society and improve the quality of life by imparting high quality education in management and information technology, providing training and development services.', 'image_url' => 'images/jims.png', 'rank_order' => 8],
    ['category' => 'IPU', 'title' => '9. Delhi-NCR Technical Campus', 'description' => 'Promoted by the founders of Mayoor School, Noida (in collaboration with GC MAYO College, Ajmer), Delhi-NCR Technical Campus provides the most sought after programmes affiliated to Guru Gobind Singh Indraprastha University and approved by All India.', 'image_url' => 'https://images.shiksha.com/mediadata/images/1568612372phpqFjkmT.jpeg', 'rank_order' => 9],
    ['category' => 'IPU', 'title' => '10. Rukmani devi college', 'description' => 'Rukmini Devi Institute of Advanced Studies (RDIAS), Affiliated to GGSIPU, has been pioneering management education for over a decade now.', 'image_url' => 'images/ruko.jpg', 'rank_order' => 10],
];

// UK cards
$ukCards = [
    ['category' => 'UK', 'title' => 'University of Oxford', 'description' => 'Benefits of studying here: Studying at the University of Oxford offers exceptional academic excellence, renowned faculty members, a rich historical legacy', 'image_url' => 'images/Oxford university.jpg', 'rank_order' => 1],
    ['category' => 'UK', 'title' => 'University College London', 'description' => 'University College London, which operates as UCL, is a public research university in London, England. It is a member institution of the federal University of London', 'image_url' => 'images/University College London (UCL).jpg', 'rank_order' => 2],
    ['category' => 'UK', 'title' => 'University of Cambridge', 'description' => 'The University of Cambridge is a public collegiate research university in Cambridge, England. Founded in 1209.', 'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b4/KingsCollegeChapelWest.jpg/800px-KingsCollegeChapelWest.jpg', 'rank_order' => 3],
    ['category' => 'UK', 'title' => 'University of Warwick', 'description' => 'The University of Warwick abbreviated as Warw. in post-nominal letters is a public research university on the outskirts of Coventry between the West Midlands and Warwickshire, England.', 'image_url' => 'https://images.shiksha.com/mediadata/images/1533642997phpf8SqM8.jpeg', 'rank_order' => 4],
    ['category' => 'UK', 'title' => 'University of Bristol', 'description' => 'The University of Bristol is a red brick Russell Group research university in Bristol, England.', 'image_url' => 'https://www.bristol.ac.uk/media-library/sites/news/2022/september/Open%20day%20-%20article.jpg', 'rank_order' => 5],
    ['category' => 'UK', 'title' => 'University of Loughborough', 'description' => 'The university traces its roots back to 1909 when Loughborough Technical Institute was founded in the town centre.', 'image_url' => 'images/uk.jpg', 'rank_order' => 6],
    ['category' => 'UK', 'title' => 'University of Glasgow', 'description' => 'The University of Glasgow was founded in 1451 by a charter or papal bull from Pope Nicholas V, at the suggestion of King James II, giving Bishop William Turnbull, a graduate of the University of St Andrews.', 'image_url' => 'images/gu.jpeg', 'rank_order' => 7],
    ['category' => 'UK', 'title' => 'University of Manchester', 'description' => 'The University of Manchester is a public research university in Manchester, England. The main campus is south of Manchester City Centre on Oxford Road.', 'image_url' => 'https://www.wur.nl/upload/6f37ab47-390e-4a11-8677-7728208787e3_291033426_6067606606599046_5002841370475822249_n.jpg', 'rank_order' => 8],
    ['category' => 'UK', 'title' => 'University of Aston', 'description' => 'The origins of Aston University are a School of Metallurgy formed in the Birmingham and Midland Institute in 1875.', 'image_url' => 'https://images.shiksha.com/mediadata/images/1628776000php9WAot8.jpeg', 'rank_order' => 9],
    ['category' => 'UK', 'title' => 'University of Bath', 'description' => 'The University of Bath is a public research university in Bath, England. It received its royal charter in 1966.', 'image_url' => 'https://yourdreamschool.fr/wp-content/uploads/2020/10/shutterstock_734126488.jpg', 'rank_order' => 10],
];

$allCards = array_merge($delhiCards, $ipuCards, $ukCards);

$successCount = 0;
$errorCount = 0;
$skippedCount = 0;

foreach ($allCards as $card) {
    try {
        // Check if card already exists (by title and category)
        $stmt = $pdo->prepare("SELECT id FROM college_cards WHERE category = ? AND title = ?");
        $stmt->execute([$card['category'], $card['title']]);
        
        if ($stmt->fetch()) {
            $skippedCount++;
            continue;
        }
        
        // Insert card
        $stmt = $pdo->prepare("INSERT INTO college_cards (category, title, description, image_url, link_url, rank_order, status) VALUES (?, ?, ?, ?, ?, ?, 'active')");
        $stmt->execute([
            $card['category'],
            $card['title'],
            $card['description'],
            $card['image_url'],
            'contact.html',
            $card['rank_order']
        ]);
        
        $successCount++;
        echo "<div class='success'>✅ Added: " . htmlspecialchars($card['title']) . " (" . htmlspecialchars($card['category']) . ")</div>";
    } catch (PDOException $e) {
        $errorCount++;
        echo "<div class='error'>❌ Error adding " . htmlspecialchars($card['title']) . ": " . $e->getMessage() . "</div>";
    }
}

echo "<div class='info'>
    <h3>Migration Summary</h3>
    <ul>
        <li>✅ Successfully added: <strong>$successCount</strong> cards</li>
        <li>⏭️ Skipped (already exists): <strong>$skippedCount</strong> cards</li>
        <li>❌ Errors: <strong>$errorCount</strong> cards</li>
    </ul>
</div>";

if ($successCount > 0 || $skippedCount > 0) {
    echo "<div class='warning'>
        <strong>⚠️ IMPORTANT:</strong> Delete this file now for security!<br>
        <code>Delete: /php/migrate_college_cards_data.php</code>
    </div>";
    echo "<p><a href='../admin/college_cards.php' style='color: #6366f1;'>Go to Admin Panel</a> to manage the cards.</p>";
}

echo "</body></html>";
?>

