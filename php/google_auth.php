<?php
/**
 * Google OAuth Handler
 * Handles Google Sign-In token verification and user creation/login
 */

require_once 'config.php';
require_once 'google_config.php';
require_once 'activity_tracker.php';

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get the credential token from the request
$input = json_decode(file_get_contents('php://input'), true);
$credential = $input['credential'] ?? '';

if (empty($credential)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'No credential provided']);
    exit;
}

// Verify the Google token
// The token is a JWT, we need to decode and verify it
$tokenParts = explode('.', $credential);
if (count($tokenParts) !== 3) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid token format']);
    exit;
}

// Decode the payload (middle part)
$payload = json_decode(base64_decode(strtr($tokenParts[1], '-_', '+/')), true);

if (!$payload) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Failed to decode token']);
    exit;
}

// Verify the token claims
$now = time();

// Check if token is expired
if (isset($payload['exp']) && $payload['exp'] < $now) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Token has expired']);
    exit;
}

// Check if token was issued in the future (clock skew)
if (isset($payload['iat']) && $payload['iat'] > $now + 300) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Token issued in the future']);
    exit;
}

// Verify the audience (client ID)
if (!isset($payload['aud']) || $payload['aud'] !== GOOGLE_CLIENT_ID) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Invalid token audience']);
    exit;
}

// Extract user info from Google token
$googleId = $payload['sub'] ?? '';
$email = $payload['email'] ?? '';
$name = $payload['name'] ?? '';
$picture = $payload['picture'] ?? '';
$emailVerified = $payload['email_verified'] ?? false;

if (empty($googleId) || empty($email)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing user information from Google']);
    exit;
}

try {
    // Check if user already exists
    $stmt = $pdo->prepare("SELECT id, name, email, role, status, auth_provider, google_id FROM users WHERE email = ? OR google_id = ?");
    $stmt->execute([$email, $googleId]);
    $user = $stmt->fetch();
    
    if ($user) {
        // User exists - check if it's a Google account or needs linking
        if ($user['auth_provider'] === 'local' && empty($user['google_id'])) {
            // Link Google account to existing local account
            $stmt = $pdo->prepare("UPDATE users SET google_id = ?, profile_picture = ?, auth_provider = 'google' WHERE id = ?");
            $stmt->execute([$googleId, $picture, $user['id']]);
        }
        
        // Check account status
        if ($user['status'] !== 'active') {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Your account is not active. Please contact support.']);
            exit;
        }
        
        $userId = $user['id'];
        $userName = $user['name'];
        $userEmail = $user['email'];
        $userRole = $user['role'];
        
    } else {
        // New user - create account
        $stmt = $pdo->prepare("INSERT INTO users (name, email, auth_provider, google_id, profile_picture, email_verified) VALUES (?, ?, 'google', ?, ?, 1)");
        $stmt->execute([$name, $email, $googleId, $picture]);
        
        $userId = $pdo->lastInsertId();
        $userName = $name;
        $userEmail = $email;
        $userRole = 'user';
        
        // Track registration activity
        trackActivity($pdo, $userId, 'register', null, 'Google Sign-Up');
    }
    
    // Update last login
    $stmt = $pdo->prepare("UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE id = ?");
    $stmt->execute([$userId]);
    
    // Create session
    $_SESSION['user_id'] = $userId;
    $_SESSION['user_name'] = $userName;
    $_SESSION['user_email'] = $userEmail;
    $_SESSION['user_role'] = $userRole;
    $_SESSION['logged_in'] = true;
    $_SESSION['login_time'] = time();
    $_SESSION['auth_provider'] = 'google';
    
    // Regenerate session ID
    session_regenerate_id(true);
    
    // Track login activity
    trackActivity($pdo, $userId, 'login', null, 'Google Login');
    
    echo json_encode([
        'success' => true,
        'message' => 'Login successful!',
        'redirect' => 'index.html',
        'user' => [
            'name' => $userName,
            'email' => $userEmail,
            'picture' => $picture,
            'role' => $userRole
        ]
    ]);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error occurred']);
}
?>








