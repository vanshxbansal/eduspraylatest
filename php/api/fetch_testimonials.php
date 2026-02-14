<?php
/**
 * Fetch Testimonials Script
 * This script allows fetching testimonials from external sources or manual input
 * 
 * Note: Web scraping requires proper permissions and may violate terms of service.
 * This script provides a framework for adding testimonials manually or via API.
 */

require_once '../config.php';

// Check admin authentication
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(401);
    die(json_encode(['success' => false, 'message' => 'Unauthorized']));
}

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? 'add_manual';
    
    try {
        if ($action === 'add_manual') {
            // Add testimonials manually
            $testimonials = $data['testimonials'] ?? [];
            
            if (empty($testimonials)) {
                throw new Exception('No testimonials provided');
            }
            
            $stmt = $pdo->prepare("INSERT INTO testimonials (name, image, rating, testimonial_text, course, designation, display_order, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'active')");
            
            $inserted = 0;
            foreach ($testimonials as $testimonial) {
                $name = $testimonial['name'] ?? '';
                $image = $testimonial['image'] ?? '';
                $rating = floatval($testimonial['rating'] ?? 5.0);
                $text = $testimonial['testimonial_text'] ?? $testimonial['text'] ?? '';
                $course = $testimonial['course'] ?? '';
                $designation = $testimonial['designation'] ?? 'Student';
                $order = intval($testimonial['display_order'] ?? 0);
                
                if (empty($name) || empty($text)) {
                    continue;
                }
                
                $stmt->execute([$name, $image, $rating, $text, $course, $designation, $order]);
                $inserted++;
            }
            
            echo json_encode(['success' => true, 'message' => "Inserted $inserted testimonials"]);
            
        } elseif ($action === 'add_sample') {
            // Add sample testimonials (for testing/demo)
            $sampleTestimonials = [
                [
                    'name' => 'Priya Sharma',
                    'image' => 'images/client-06.png',
                    'rating' => 5.0,
                    'testimonial_text' => 'Eduspray India helped me secure admission in my dream college. The counselors were very supportive throughout the entire process. Highly recommended!',
                    'course' => 'B.Tech',
                    'designation' => 'Student',
                    'display_order' => 4
                ],
                [
                    'name' => 'Rahul Kumar',
                    'image' => 'images/client-05.png',
                    'rating' => 4.5,
                    'testimonial_text' => 'Excellent guidance for IP University admissions. The team helped me understand all the requirements and deadlines. Thank you Eduspray!',
                    'course' => 'BBA',
                    'designation' => 'Student',
                    'display_order' => 5
                ],
                [
                    'name' => 'Anjali Patel',
                    'image' => 'images/client-04.png',
                    'rating' => 5.0,
                    'testimonial_text' => 'Best educational consultancy in Delhi-NCR. They provided detailed information about all courses and helped me choose the right one for my career goals.',
                    'course' => 'BCA',
                    'designation' => 'Student',
                    'display_order' => 6
                ],
                [
                    'name' => 'Vikram Singh',
                    'image' => '',
                    'rating' => 4.5,
                    'testimonial_text' => 'Professional service and expert advice. The counselors at Eduspray India are knowledgeable and patient. They answered all my queries promptly.',
                    'course' => 'B.Tech',
                    'designation' => 'Student',
                    'display_order' => 7
                ],
                [
                    'name' => 'Sneha Reddy',
                    'image' => '',
                    'rating' => 5.0,
                    'testimonial_text' => 'I got admission in a top college thanks to Eduspray India. Their guidance was invaluable. The entire process was smooth and hassle-free.',
                    'course' => 'MBA',
                    'designation' => 'Student',
                    'display_order' => 8
                ],
                [
                    'name' => 'Arjun Mehta',
                    'image' => '',
                    'rating' => 4.0,
                    'testimonial_text' => 'Great experience with Eduspray India. They helped me with college selection and application process. Highly satisfied with their services.',
                    'course' => 'B.Arch',
                    'designation' => 'Student',
                    'display_order' => 9
                ],
                [
                    'name' => 'Kavya Nair',
                    'image' => '',
                    'rating' => 5.0,
                    'testimonial_text' => 'Eduspray India is the best! They provided comprehensive guidance for my admission process. The counselors are friendly and professional.',
                    'course' => 'BHMCT',
                    'designation' => 'Student',
                    'display_order' => 10
                ],
                [
                    'name' => 'Rohan Desai',
                    'image' => '',
                    'rating' => 4.5,
                    'testimonial_text' => 'Excellent counseling services. Eduspray India helped me understand various course options and choose the best fit for my career aspirations.',
                    'course' => 'B.Tech',
                    'designation' => 'Student',
                    'display_order' => 11
                ],
                [
                    'name' => 'Meera Joshi',
                    'image' => '',
                    'rating' => 5.0,
                    'testimonial_text' => 'Outstanding support throughout the admission process. The team at Eduspray India is dedicated and ensures students get the best guidance.',
                    'course' => 'B.Com',
                    'designation' => 'Student',
                    'display_order' => 12
                ],
                [
                    'name' => 'Aditya Verma',
                    'image' => '',
                    'rating' => 4.0,
                    'testimonial_text' => 'Good experience with Eduspray India. They provided detailed information about colleges and courses. The counseling was helpful.',
                    'course' => 'BBA',
                    'designation' => 'Student',
                    'display_order' => 13
                ],
                [
                    'name' => 'Isha Gupta',
                    'image' => '',
                    'rating' => 5.0,
                    'testimonial_text' => 'Best educational consultancy! Eduspray India helped me secure admission in a top university. Their expertise and guidance made all the difference.',
                    'course' => 'B.Tech',
                    'designation' => 'Student',
                    'display_order' => 14
                ],
                [
                    'name' => 'Neha Kapoor',
                    'image' => '',
                    'rating' => 4.5,
                    'testimonial_text' => 'Professional and reliable service. The counselors at Eduspray India are well-informed and provide excellent guidance for college admissions.',
                    'course' => 'BCA',
                    'designation' => 'Student',
                    'display_order' => 15
                ],
                [
                    'name' => 'Siddharth Malhotra',
                    'image' => '',
                    'rating' => 5.0,
                    'testimonial_text' => 'Great support from Eduspray India. They helped me navigate through the complex admission process and made it simple and stress-free.',
                    'course' => 'B.Tech',
                    'designation' => 'Student',
                    'display_order' => 16
                ],
                [
                    'name' => 'Divya Iyer',
                    'image' => '',
                    'rating' => 4.5,
                    'testimonial_text' => 'Excellent counseling services. Eduspray India provided comprehensive guidance and helped me make informed decisions about my education.',
                    'course' => 'BBA',
                    'designation' => 'Student',
                    'display_order' => 17
                ],
                [
                    'name' => 'Aryan Shah',
                    'image' => '',
                    'rating' => 5.0,
                    'testimonial_text' => 'Outstanding experience with Eduspray India. The team is professional, knowledgeable, and always ready to help. Highly recommended!',
                    'course' => 'B.Tech',
                    'designation' => 'Student',
                    'display_order' => 18
                ],
                [
                    'name' => 'Pooja Menon',
                    'image' => '',
                    'rating' => 4.0,
                    'testimonial_text' => 'Good counseling service. Eduspray India helped me understand the admission requirements and guided me through the application process.',
                    'course' => 'B.Com',
                    'designation' => 'Student',
                    'display_order' => 19
                ],
                [
                    'name' => 'Karan Thakur',
                    'image' => '',
                    'rating' => 5.0,
                    'testimonial_text' => 'Best educational consultancy in Delhi-NCR. Eduspray India provided excellent guidance and support throughout my admission journey.',
                    'course' => 'B.Tech',
                    'designation' => 'Student',
                    'display_order' => 20
                ],
                [
                    'name' => 'Shreya Agarwal',
                    'image' => '',
                    'rating' => 4.5,
                    'testimonial_text' => 'Professional and helpful service. The counselors at Eduspray India are experienced and provide valuable insights for college selection.',
                    'course' => 'BCA',
                    'designation' => 'Student',
                    'display_order' => 21
                ],
                [
                    'name' => 'Rishabh Jain',
                    'image' => '',
                    'rating' => 5.0,
                    'testimonial_text' => 'Excellent support from Eduspray India. They helped me secure admission in my preferred college. The entire process was smooth and efficient.',
                    'course' => 'BBA',
                    'designation' => 'Student',
                    'display_order' => 22
                ],
                [
                    'name' => 'Tanvi Rao',
                    'image' => '',
                    'rating' => 4.5,
                    'testimonial_text' => 'Great experience with Eduspray India. Their counselors are knowledgeable and provide comprehensive guidance for college admissions.',
                    'course' => 'B.Tech',
                    'designation' => 'Student',
                    'display_order' => 23
                ]
            ];
            
            $stmt = $pdo->prepare("INSERT INTO testimonials (name, image, rating, testimonial_text, course, designation, display_order, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'active')");
            
            $inserted = 0;
            foreach ($sampleTestimonials as $testimonial) {
                try {
                    $stmt->execute([
                        $testimonial['name'],
                        $testimonial['image'],
                        $testimonial['rating'],
                        $testimonial['testimonial_text'],
                        $testimonial['course'],
                        $testimonial['designation'],
                        $testimonial['display_order']
                    ]);
                    $inserted++;
                } catch (PDOException $e) {
                    // Skip duplicates
                    continue;
                }
            }
            
            echo json_encode(['success' => true, 'message' => "Inserted $inserted sample testimonials"]);
        } else {
            throw new Exception('Invalid action');
        }
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
?>



