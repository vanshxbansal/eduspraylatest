<?php
/**
 * Contact form submission: save to leads table and send confirmation email to user.
 * Accepts POST (application/x-www-form-urlencoded or JSON).
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

$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
if (stripos($contentType, 'application/json') !== false) {
    $data = json_decode(file_get_contents('php://input'), true) ?: [];
} else {
    $data = $_POST;
}

$name = trim($data['Name'] ?? $data['name'] ?? '');
$email = filter_var($data['Email'] ?? $data['email'] ?? '', FILTER_VALIDATE_EMAIL);
$phone = preg_replace('/[^0-9+]/', '', $data['Phone'] ?? $data['phone'] ?? '');

if (empty($email)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Valid email is required']);
    exit;
}

// Build message from all form fields (for admin reference)
$parts = [];
$fields = ['Degree', 'What are you completed?', 'Country', 'Message', 'message', 'Subject', 'subject'];
foreach ($data as $k => $v) {
    if (in_array($k, ['Name', 'name', 'Email', 'email', 'Phone', 'phone', 'access_key'])) continue;
    if (is_string($v) && trim($v) !== '') {
        $parts[] = $k . ': ' . trim($v);
    }
}
$message = $name ? "Name: $name\n" : '';
$message .= "Email: $email\n";
if ($phone) $message .= "Phone: $phone\n";
$message .= implode("\n", $parts);

try {
    $stmt = $pdo->prepare("SELECT id FROM leads WHERE email = ? ORDER BY created_at DESC LIMIT 1");
    $stmt->execute([$email]);
    $existing = $stmt->fetch();

    if ($existing) {
        $stmt = $pdo->prepare("UPDATE leads SET name = COALESCE(NULLIF(?, ''), name), phone = COALESCE(NULLIF(?, ''), phone), source = 'contact', message = ?, status = 'new', updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->execute([$name ?: null, $phone ?: null, $message, $existing['id']]);
        $leadId = $existing['id'];
    } else {
        $stmt = $pdo->prepare("INSERT INTO leads (name, email, phone, source, message) VALUES (?, ?, ?, 'contact', ?)");
        $stmt->execute([$name ?: null, $email, $phone ?: null, $message]);
        $leadId = $pdo->lastInsertId();
    }

    require_once __DIR__ . '/send_email.php';
    $body = '<!DOCTYPE html><html><body style="font-family:Arial,sans-serif;line-height:1.6;color:#333;">';
    $body .= '<p>Hi' . ($name ? ' ' . htmlspecialchars($name) : '') . ',</p>';
    $body .= '<p>Thank you for contacting <strong>Eduspray India</strong>. We have received your details and our counsellor will get in touch with you soon.</p>';
    $body .= '<p>For urgent queries: <strong>+91 8595684716</strong> | <strong>edusprayIndia@gmail.com</strong></p>';
    $body .= '<p>— Eduspray India</p></body></html>';
    sendBrevoEmail($email, $name ?: 'User', 'We received your contact request – Eduspray India', $body);

    echo json_encode([
        'success' => true,
        'message' => 'Thank you! We will contact you soon.',
        'lead_id' => $leadId
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Something went wrong. Please try again.']);
}
