<?php
/**
 * Send transactional email via Brevo (same logic as admin OTP flow).
 * Used for: contact confirmation, lead/newsletter confirmation, admin OTP.
 * Requires: admin/email_config.php (BREVO_API_KEY, SENDER_EMAIL, SENDER_NAME).
 */

if (!defined('BREVO_API_KEY')) {
    require_once __DIR__ . '/../admin/email_config.php';
}

/**
 * Send HTML email via Brevo API (identical cURL/SSL behavior to admin otp_handler).
 * @param string $toEmail Recipient email
 * @param string $toName Recipient name
 * @param string $subject Subject line
 * @param string $htmlBody HTML body
 * @return bool true on success (HTTP 201), false otherwise; sets $_SESSION['email_error'] on failure
 */
function sendBrevoEmail($toEmail, $toName, $subject, $htmlBody) {
    $brevoApiKey = defined('BREVO_API_KEY') ? BREVO_API_KEY : '';
    $senderEmail = defined('SENDER_EMAIL') ? SENDER_EMAIL : 'noreply@eduspray.com';
    $senderName = defined('SENDER_NAME') ? SENDER_NAME : 'Eduspray India';

    if (empty($brevoApiKey) || $brevoApiKey === 'YOUR_BREVO_API_KEY_HERE') {
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }
        $_SESSION['email_error'] = 'Brevo API Key not configured. Please set it in admin/email_config.php';
        return false;
    }
    if (!filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    $emailData = [
        'sender' => ['name' => $senderName, 'email' => $senderEmail],
        'to' => [['email' => $toEmail, 'name' => $toName ?: 'User']],
        'subject' => $subject,
        'htmlContent' => $htmlBody
    ];

    if (!function_exists('curl_init')) {
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }
        $_SESSION['email_error'] = 'Server configuration error: cURL is not available';
        return false;
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.brevo.com/v3/smtp/email');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($emailData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    // SSL: same logic as admin/otp_handler.php (CA bundle or disable for localhost)
    $caBundlePaths = [
        __DIR__ . '/../admin/cacert.pem',
        ini_get('curl.cainfo'),
        getenv('SSL_CERT_FILE'),
        'C:/php/extras/ssl/cacert.pem',
        'C:/xampp/apache/bin/curl-ca-bundle.crt',
    ];
    $caBundleFound = false;
    foreach ($caBundlePaths as $caPath) {
        if ($caPath && file_exists($caPath)) {
            curl_setopt($ch, CURLOPT_CAINFO, $caPath);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            $caBundleFound = true;
            break;
        }
    }
    if (!$caBundleFound) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    }

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'accept: application/json',
        'api-key: ' . $brevoApiKey,
        'content-type: application/json'
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($httpCode === 201) {
        return true;
    }

    $errorMessage = 'Unknown error';
    $responseData = json_decode($response, true);
    if ($curlError) {
        $errorMessage = (strpos($curlError, 'SSL certificate problem') !== false || strpos($curlError, 'unable to get local issuer certificate') !== false)
            ? 'SSL certificate error: ' . $curlError
            : 'Connection error: ' . $curlError;
    } elseif ($responseData && isset($responseData['message'])) {
        $errorMessage = $responseData['message'];
        if (isset($responseData['code'])) {
            $errorMessage .= ' (Code: ' . $responseData['code'] . ')';
        }
    } else {
        $errorMessage = 'HTTP ' . $httpCode . ': ' . substr($response, 0, 200);
    }

    if (session_status() === PHP_SESSION_NONE) {
        @session_start();
    }
    $_SESSION['email_error'] = $errorMessage;
    $_SESSION['email_error_details'] = [
        'http_code' => $httpCode,
        'response' => $response,
        'curl_error' => $curlError
    ];
    error_log('Brevo send failed: ' . $errorMessage . ' | HTTP ' . $httpCode);
    return false;
}
