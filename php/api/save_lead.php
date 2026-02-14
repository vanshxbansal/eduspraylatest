<?php
/**
 * API: Save Lead / Newsletter / Get Update
 * Saves to leads table (no user details lost). Sends confirmation email to user.
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true) ?: [];

$email = filter_var($data['email'] ?? '', FILTER_VALIDATE_EMAIL);
$phone = preg_replace('/[^0-9+]/', '', $data['phone'] ?? '');
$name = trim($data['name'] ?? '');
$courseSlug = trim($data['course_slug'] ?? '');
$courseName = trim($data['course_name'] ?? '');
$source = trim($data['source'] ?? 'get_update');
$message = trim($data['message'] ?? '');

// Newsletter: only email required. Others: email or phone (at least one).
if ($source === 'newsletter') {
    if (empty($email)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Valid email is required']);
        exit;
    }
} else {
    if (empty($email) && empty($phone)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Email or phone number is required']);
        exit;
    }
    if (!empty($phone) && strlen($phone) < 10) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Valid phone number must be at least 10 digits']);
        exit;
    }
}

try {
    $existing = null;
    if (!empty($email)) {
        $stmt = $pdo->prepare("SELECT id FROM leads WHERE email = ? ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([$email]);
        $existing = $stmt->fetch();
    }
    if (!$existing && !empty($phone)) {
        $stmt = $pdo->prepare("SELECT id FROM leads WHERE phone = ? ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([$phone]);
        $existing = $stmt->fetch();
    }

    if ($existing) {
        $stmt = $pdo->prepare("UPDATE leads SET name = COALESCE(NULLIF(?, ''), name), email = COALESCE(NULLIF(?, ''), email), phone = COALESCE(NULLIF(?, ''), phone), course_slug = COALESCE(NULLIF(?, ''), course_slug), course_name = COALESCE(NULLIF(?, ''), course_name), source = ?, message = COALESCE(NULLIF(?, ''), message), status = 'new', updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->execute([$name, $email ?: null, $phone ?: null, $courseSlug ?: null, $courseName ?: null, $source, $message ?: null, $existing['id']]);
        $leadId = $existing['id'];
    } else {
        $stmt = $pdo->prepare("INSERT INTO leads (name, email, phone, course_slug, course_name, source, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name ?: null, $email ?: null, $phone ?: null, $courseSlug ?: null, $courseName ?: null, $source, $message ?: null]);
        $leadId = $pdo->lastInsertId();
    }

    // Send confirmation email to user (when we have email)
    if ($email) {
        require_once __DIR__ . '/../send_email.php';
        $subj = $source === 'newsletter' ? 'Thank you for subscribing – Eduspray India' : 'We received your request – Eduspray India';
        $body = '<!DOCTYPE html><html><body style="font-family:Arial,sans-serif;line-height:1.6;color:#333;">';
        $body .= '<p>Hi' . ($name ? ' ' . htmlspecialchars($name) : '') . ',</p>';
        $body .= '<p>Thank you for getting in touch with <strong>Eduspray India</strong>.</p>';
        $body .= '<p>We have received your details and our team will contact you soon.</p>';
        $body .= '<p>For any urgent query, call us at <strong>+91 8595684716</strong> or email <strong>edusprayIndia@gmail.com</strong>.</p>';
        $body .= '<p>— Eduspray India</p></body></html>';
        sendBrevoEmail($email, $name ?: 'User', $subj, $body);
    }

    echo json_encode([
        'success' => true,
        'message' => $source === 'newsletter' ? 'Thank you for subscribing!' : 'Thank you! We will contact you soon.',
        'lead_id' => $leadId
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error. Please try again.']);
}
