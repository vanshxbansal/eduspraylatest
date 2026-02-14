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
 * 6. Copy the API key and paste it below
 * 7. Go to Senders & IP > Senders and add/verify your sender email
 * 8. Replace the sender email below with your verified email
 * 
 * FREE TIER: 300 emails per day - Perfect for admin OTP!
 */

// ============================================
// CONFIGURATION - UPDATE THESE VALUES
// ============================================

// Your Brevo API Key (get from https://app.brevo.com/settings/keys/api)
define('BREVO_API_KEY', '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');

// Your verified sender email in Brevo (must be verified in Brevo dashboard)
define('SENDER_EMAIL', 'indiaeduspray@gmail.com');

// Sender name (appears in recipient's inbox)
define('SENDER_NAME', 'Eduspray Admin');

// ============================================
// DO NOT MODIFY BELOW THIS LINE
// ============================================

