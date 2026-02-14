<?php
/**
 * Google OAuth Configuration
 * 
 * To get these credentials:
 * 1. Go to https://console.cloud.google.com/
 * 2. Create a new project (or select existing)
 * 3. Go to APIs & Services → Credentials
 * 4. Create OAuth 2.0 Client ID (Web application)
 * 5. Add authorized JavaScript origins: http://localhost:8080, https://eduspray.in
 * 6. Copy the Client ID below
 */

// ============================================
// UPDATE WITH YOUR GOOGLE OAUTH CREDENTIALS
// ============================================
define('GOOGLE_CLIENT_ID', '14574668562-4s4r6ji0c13s48v2a7lp6pcm8ju1rvll.apps.googleusercontent.com');

// For local development
define('GOOGLE_REDIRECT_URI_LOCAL', 'http://localhost:8080');

// For production
define('GOOGLE_REDIRECT_URI_PROD', 'https://eduspray.in');
?>

