<?php
/**
 * Test Email Script - Debug OTP Email Sending
 * Run this file directly to test email configuration
 */

session_start();
require_once 'email_config.php';
require_once 'otp_handler.php';

// Test configuration
$testEmail = 'indiaeduspray@gmail.com';
$testOTP = '123456';

echo "<h2>Email Configuration Test</h2>";
echo "<pre>";

// Check configuration
echo "=== Configuration Check ===\n";
echo "API Key: " . (defined('BREVO_API_KEY') && BREVO_API_KEY !== 'YOUR_BREVO_API_KEY_HERE' ? '✓ Set' : '✗ Not Set') . "\n";
echo "Sender Email: " . (defined('SENDER_EMAIL') ? SENDER_EMAIL : 'Not Set') . "\n";
echo "Sender Name: " . (defined('SENDER_NAME') ? SENDER_NAME : 'Not Set') . "\n";
echo "cURL Available: " . (function_exists('curl_init') ? '✓ Yes' : '✗ No') . "\n\n";

// Test API key format
if (defined('BREVO_API_KEY') && BREVO_API_KEY !== 'YOUR_BREVO_API_KEY_HERE') {
    $apiKey = BREVO_API_KEY;
    echo "API Key Length: " . strlen($apiKey) . " characters\n";
    echo "API Key Format: " . (strpos($apiKey, 'xkeysib-') === 0 ? '✓ Valid format' : '✗ Invalid format (should start with xkeysib-)') . "\n\n";
}

// Test sending email
echo "=== Testing Email Send ===\n";
echo "Sending test OTP to: $testEmail\n";
echo "Test OTP: $testOTP\n\n";

$result = sendOTPEmail($testEmail, $testOTP);

if ($result) {
    echo "✓ SUCCESS: Email sent successfully!\n";
    echo "Check your inbox at: $testEmail\n";
} else {
    echo "✗ FAILED: Email could not be sent\n\n";
    
    if (isset($_SESSION['email_error'])) {
        echo "Error Message: " . $_SESSION['email_error'] . "\n";
    }
    
    if (isset($_SESSION['email_error_details'])) {
        $details = $_SESSION['email_error_details'];
        echo "\n=== Error Details ===\n";
        echo "HTTP Code: " . $details['http_code'] . "\n";
        if (!empty($details['curl_error'])) {
            echo "cURL Error: " . $details['curl_error'] . "\n";
        }
        if (!empty($details['response'])) {
            echo "API Response: " . substr($details['response'], 0, 500) . "\n";
        }
    }
    
    echo "\n=== Common Solutions ===\n";
    echo "1. Verify your sender email in Brevo: https://app.brevo.com/senders\n";
    echo "2. Check if API key is correct: https://app.brevo.com/settings/keys/api\n";
    echo "3. Make sure sender email matches the verified email in Brevo\n";
}

echo "</pre>";
?>

