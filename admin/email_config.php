<?php
/**
 * Email Configuration for OTP System
 * 
 * SETUP INSTRUCTIONS (Takes 2 minutes):
 * 
 * 1. Go to https://www.brevo.com/ (formerly Sendinblue)
 * 2. Click "Sign Up Free" (no credit card required)
 * 3. Verify your email address
 * 4. Go to Settings > API Keys (or https://app.brevo.com/settings/keys/api)
 * 5. Click "Generate a new API key"
 * 6. Copy admin/email_secrets.example.php to admin/email_secrets.php and paste your API key there (email_secrets.php is gitignored)
 * 7. Go to Senders & IP > Senders and add/verify your sender email
 * 8. Replace the sender email below with your verified email
 * 
 * FREE TIER: 300 emails per day - Perfect for admin OTP!
 */

// ============================================
// CONFIGURATION - UPDATE THESE VALUES
// ============================================

// Brevo API Key is loaded from admin/email_secrets.php (gitignored). Copy email_secrets.example.php to email_secrets.php and add your key.
if (file_exists(__DIR__ . '/email_secrets.php')) {
    require_once __DIR__ . '/email_secrets.php';
} else {
    define('BREVO_API_KEY', '');
}

// Your verified sender email in Brevo (must be verified in Brevo dashboard)
define('SENDER_EMAIL', 'indiaeduspray@gmail.com');

// Sender name (appears in recipient's inbox)
define('SENDER_NAME', 'Eduspray Admin');

// ============================================
// DO NOT MODIFY BELOW THIS LINE
// ============================================

