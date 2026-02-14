<?php
/**
 * User Activity Tracker
 * Tracks user activities for analytics
 */

/**
 * Track user activity
 */
function trackActivity($pdo, $userId, $activityType, $pageUrl = null, $pageTitle = null) {
    try {
        // Get device type from user agent
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $deviceType = getDeviceType($userAgent);
        
        // Get IP address
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '';
        if (strpos($ipAddress, ',') !== false) {
            $ipAddress = trim(explode(',', $ipAddress)[0]);
        }
        
        // Get referrer
        $referrer = $_SERVER['HTTP_REFERER'] ?? '';
        
        // Get or create session ID
        $sessionId = session_id() ?: uniqid('sess_', true);
        
        $stmt = $pdo->prepare("
            INSERT INTO user_activity 
            (user_id, session_id, activity_type, page_url, page_title, referrer, ip_address, user_agent, device_type) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $userId,
            $sessionId,
            $activityType,
            $pageUrl,
            $pageTitle,
            substr($referrer, 0, 500),
            $ipAddress,
            substr($userAgent, 0, 500),
            $deviceType
        ]);
        
        return true;
    } catch (PDOException $e) {
        // Don't break the app if tracking fails
        return false;
    }
}

/**
 * Get device type from user agent
 */
function getDeviceType($userAgent) {
    $userAgent = strtolower($userAgent);
    
    // Check for mobile devices
    $mobileKeywords = ['mobile', 'android', 'iphone', 'ipod', 'blackberry', 'windows phone'];
    foreach ($mobileKeywords as $keyword) {
        if (strpos($userAgent, $keyword) !== false) {
            return 'mobile';
        }
    }
    
    // Check for tablets
    $tabletKeywords = ['ipad', 'tablet', 'kindle'];
    foreach ($tabletKeywords as $keyword) {
        if (strpos($userAgent, $keyword) !== false) {
            return 'tablet';
        }
    }
    
    return 'desktop';
}

/**
 * Track page view (to be called via AJAX)
 */
function handlePageViewTracking($pdo) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return ['success' => false, 'message' => 'Method not allowed'];
    }
    
    $input = json_decode(file_get_contents('php://input'), true);
    $pageUrl = $input['url'] ?? '';
    $pageTitle = $input['title'] ?? '';
    
    $userId = $_SESSION['user_id'] ?? null;
    
    trackActivity($pdo, $userId, 'page_view', $pageUrl, $pageTitle);
    
    return ['success' => true];
}
?>








