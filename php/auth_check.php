<?php
/**
 * Authentication Check
 * Returns current user info if logged in
 */

require_once 'config.php';

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

if (isLoggedIn()) {
    $user = getCurrentUser();
    
    // Get additional user info from database (like profile picture)
    try {
        $stmt = $pdo->prepare("SELECT profile_picture, auth_provider FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $dbUser = $stmt->fetch();
        
        if ($dbUser) {
            $user['picture'] = $dbUser['profile_picture'];
            $user['auth_provider'] = $dbUser['auth_provider'];
        }
    } catch (PDOException $e) {
        // Continue without picture
    }
    
    echo json_encode([
        'logged_in' => true,
        'user' => $user
    ]);
} else {
    echo json_encode([
        'logged_in' => false,
        'user' => null
    ]);
}
?>

