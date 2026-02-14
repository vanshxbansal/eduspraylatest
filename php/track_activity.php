<?php
/**
 * Activity Tracking Endpoint
 * Called via AJAX to track page views
 */

require_once 'config.php';
require_once 'activity_tracker.php';

header('Content-Type: application/json');

$result = handlePageViewTracking($pdo);
echo json_encode($result);
?>








