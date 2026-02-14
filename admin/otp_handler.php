<?php
/**
 * OTP Handler for Admin Login
 * Generates, stores, and verifies OTP codes
 */

// Load email configuration
require_once __DIR__ . '/email_config.php';

// OTP configuration
define('OTP_EXPIRY', 600); // 10 minutes in seconds
define('OTP_LENGTH', 6);

/**
 * Generate a random OTP
 */
function generateOTP($length = OTP_LENGTH) {
    return str_pad(rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
}

/**
 * Store OTP in session
 */
function storeOTP($email, $otp) {
    $_SESSION['otp_code'] = $otp;
    $_SESSION['otp_email'] = $email;
    $_SESSION['otp_created'] = time();
    $_SESSION['otp_verified'] = false;
}

/**
 * Verify OTP
 */
function verifyOTP($inputOTP) {
    if (!isset($_SESSION['otp_code']) || !isset($_SESSION['otp_created'])) {
        return false;
    }
    
    // Check if OTP expired
    if (time() - $_SESSION['otp_created'] > OTP_EXPIRY) {
        clearOTP();
        return false;
    }
    
    // Verify OTP
    if ($_SESSION['otp_code'] === $inputOTP) {
        $_SESSION['otp_verified'] = true;
        return true;
    }
    
    return false;
}

/**
 * Check if OTP is verified
 */
function isOTPVerified() {
    return isset($_SESSION['otp_verified']) && $_SESSION['otp_verified'] === true;
}

/**
 * Clear OTP from session
 */
function clearOTP() {
    unset($_SESSION['otp_code']);
    unset($_SESSION['otp_email']);
    unset($_SESSION['otp_created']);
    unset($_SESSION['otp_verified']);
}

/**
 * Send OTP via email using shared Brevo logic (php/send_email.php).
 * Same config and sending as contact form and newsletter; OTP flow works the same.
 */
function sendOTPEmail($email, $otp) {
    require_once __DIR__ . '/../php/send_email.php';

    $subject = "Your Admin Login OTP - Eduspray";
    $htmlContent = "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <style>
            body { 
                font-family: Arial, sans-serif; 
                line-height: 1.6; 
                color: #333; 
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }
            .container { 
                max-width: 600px; 
                margin: 20px auto; 
                padding: 0;
                background: white;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }
            .header {
                background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
                color: white;
                padding: 30px 20px;
                text-align: center;
            }
            .header h1 {
                margin: 0;
                font-size: 24px;
            }
            .content {
                padding: 30px 20px;
            }
            .otp-box { 
                background: #f8f9fa; 
                border: 2px dashed #6366f1;
                color: #6366f1; 
                padding: 30px; 
                text-align: center; 
                border-radius: 8px; 
                margin: 30px 0; 
            }
            .otp-code { 
                font-size: 42px; 
                font-weight: bold; 
                letter-spacing: 8px; 
                font-family: 'Courier New', monospace;
            }
            .footer { 
                margin-top: 30px; 
                font-size: 12px; 
                color: #666; 
                text-align: center;
                padding-top: 20px;
                border-top: 1px solid #eee;
            }
            .warning {
                background: #fff3cd;
                border-left: 4px solid #ffc107;
                padding: 15px;
                margin: 20px 0;
                border-radius: 4px;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>Edu<span style='color: #fbbf24;'>spray</span></h1>
                <p style='margin: 10px 0 0 0; opacity: 0.9;'>Admin Security Verification</p>
            </div>
            <div class='content'>
                <h2 style='color: #333; margin-top: 0;'>Admin Login OTP</h2>
                <p>You have requested to login to the Eduspray Admin Panel.</p>
                <p>Your One-Time Password (OTP) is:</p>
                <div class='otp-box'>
                    <div class='otp-code'>{$otp}</div>
                </div>
                <div class='warning'>
                    <strong>⚠️ Security Notice:</strong> This OTP is valid for 10 minutes only. Do not share this code with anyone.
                </div>
                <p>If you did not request this OTP, please ignore this email or contact support immediately.</p>
            </div>
            <div class='footer'>
                <p><strong>© Eduspray India</strong></p>
                <p>This is an automated security email. Please do not reply.</p>
            </div>
        </div>
    </body>
    </html>
    ";

    return sendBrevoEmail($email, 'Admin User', $subject, $htmlContent);
}
?>

