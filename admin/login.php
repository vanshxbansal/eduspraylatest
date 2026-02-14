<?php
/**
 * Admin Login Page with OTP Verification
 * Hardcoded credentials for admin access
 */

session_start();
require_once 'otp_handler.php';

// Hardcoded admin credentials
define('ADMIN_EMAIL', 'admin@admin.com');
define('ADMIN_PASSWORD', 'demo');

// OTP recipient email (where OTP will be sent)
define('OTP_RECIPIENT_EMAIL', 'indiaeduspray@gmail.com');

$error = '';
$success = '';
$showOTPForm = false;

// Check if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: /admin/index.php');
    exit;
}

// Handle resend OTP
if (isset($_GET['resend']) && isset($_SESSION['otp_email'])) {
    $email = $_SESSION['otp_email'];
    $otp = generateOTP();
    storeOTP($email, $otp);
    
    // Send OTP to the configured recipient email
    $otpRecipient = defined('OTP_RECIPIENT_EMAIL') ? OTP_RECIPIENT_EMAIL : $email;
    
    if (sendOTPEmail($otpRecipient, $otp)) {
        $success = 'New OTP has been sent to your email.';
        $showOTPForm = true;
    } else {
        $error = 'Failed to resend OTP. Please try again.';
        $showOTPForm = true;
    }
}

// Handle OTP verification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['otp'])) {
    $inputOTP = trim($_POST['otp'] ?? '');
    
    if (empty($inputOTP)) {
        $error = 'Please enter the OTP';
        $showOTPForm = true;
    } elseif (verifyOTP($inputOTP)) {
        // OTP verified, complete login
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = $_SESSION['otp_email'];
        $_SESSION['admin_login_time'] = time();
        clearOTP();
        
        header('Location: /admin/index.php');
        exit;
    } else {
        $error = 'Invalid or expired OTP. Please try again.';
        $showOTPForm = true;
    }
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = trim(strtolower($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    
    if ($email === ADMIN_EMAIL && $password === ADMIN_PASSWORD) {
        // Generate and send OTP
        $otp = generateOTP();
        storeOTP($email, $otp);
        
        // Send OTP to the configured recipient email
        $otpRecipient = defined('OTP_RECIPIENT_EMAIL') ? OTP_RECIPIENT_EMAIL : $email;
        
        if (sendOTPEmail($otpRecipient, $otp)) {
            $success = 'OTP has been sent to ' . $otpRecipient . '. Please check your inbox (and spam folder).';
            $showOTPForm = true;
        } else {
            // Get detailed error message if available
            $errorMsg = 'Failed to send OTP. ';
            if (isset($_SESSION['email_error'])) {
                $errorMsg .= $_SESSION['email_error'];
                // Show common solutions
                if (strpos($_SESSION['email_error'], 'sender') !== false || strpos($_SESSION['email_error'], 'invalid') !== false) {
                    $errorMsg .= ' Please verify your sender email in Brevo dashboard.';
                } elseif (strpos($_SESSION['email_error'], 'unauthorized') !== false || strpos($_SESSION['email_error'], '401') !== false) {
                    $errorMsg .= ' Please check your API key in email_config.php.';
                }
                unset($_SESSION['email_error']);
            } else {
                $errorMsg .= 'Please try again or contact support.';
            }
            $error = $errorMsg;
        }
    } else {
        $error = 'Invalid email or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Eduspray</title>
    <link rel="shortcut icon" href="../images/02.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0f0f23;
            position: relative;
            overflow: hidden;
        }
        
        /* Animated background grid */
        .bg-grid {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(99, 102, 241, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99, 102, 241, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
        }
        
        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }
        
        /* Glowing orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.3;
            animation: float 8s ease-in-out infinite;
        }
        
        .orb-1 {
            width: 400px;
            height: 400px;
            background: #6366f1;
            top: -100px;
            right: -100px;
        }
        
        .orb-2 {
            width: 300px;
            height: 300px;
            background: #ec4899;
            bottom: -50px;
            left: -50px;
            animation-delay: -4s;
        }
        
        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, 30px) scale(1.1); }
        }
        
        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 50px 40px;
            backdrop-filter: blur(20px);
        }
        
        .logo {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .logo h1 {
            font-size: 28px;
            font-weight: 700;
            color: white;
        }
        
        .logo h1 span {
            color: #6366f1;
        }
        
        .logo p {
            color: #666;
            font-size: 14px;
            margin-top: 8px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            color: #888;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-wrapper i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #555;
            font-size: 16px;
            transition: color 0.3s;
        }
        
        .form-group input {
            width: 100%;
            padding: 16px 18px 16px 50px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: white;
            font-size: 15px;
            font-family: inherit;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #6366f1;
            background: rgba(99, 102, 241, 0.05);
        }
        
        .form-group input:focus + i,
        .form-group input:focus ~ i {
            color: #6366f1;
        }
        
        .form-group input::placeholder {
            color: #555;
        }
        
        /* OTP Input Styling */
        .otp-input {
            text-align: center;
            font-size: 24px;
            letter-spacing: 8px;
            font-weight: 600;
            padding-left: 18px !important;
        }
        
        .login-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(99, 102, 241, 0.3);
        }
        
        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #ef4444;
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .success-message {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: #10b981;
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .resend-otp {
            text-align: center;
            margin-top: 15px;
        }
        
        .resend-otp a {
            color: #6366f1;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }
        
        .resend-otp a:hover {
            text-decoration: underline;
        }
        
        .back-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            color: #666;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }
        
        .back-link:hover {
            color: #6366f1;
        }
        
        .security-note {
            text-align: center;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        
        .security-note i {
            color: #10b981;
            margin-right: 8px;
        }
        
        .security-note span {
            color: #555;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <!-- Background effects -->
    <div class="bg-grid"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    
    <div class="login-container">
        <div class="login-card">
            <div class="logo">
                <h1>Edu<span>spray</span></h1>
                <p>Admin Control Panel</p>
            </div>
            
            <?php if ($error): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
            <div class="success-message">
                <i class="fas fa-check-circle"></i>
                <?php echo htmlspecialchars($success); ?>
            </div>
            <?php endif; ?>
            
            <?php if ($showOTPForm): ?>
            <!-- OTP Verification Form -->
            <form method="POST" action="">
                <div class="form-group">
                    <label>Enter OTP</label>
                    <div class="input-wrapper">
                        <input type="text" name="otp" class="otp-input" placeholder="000000" maxlength="6" pattern="[0-9]{6}" required autofocus>
                        <i class="fas fa-key"></i>
                    </div>
                    <p style="color: #666; font-size: 12px; margin-top: 8px;">Check your email for the 6-digit OTP (valid for 10 minutes)</p>
                </div>
                
                <button type="submit" class="login-btn">
                    <i class="fas fa-shield-alt"></i>
                    Verify OTP
                </button>
            </form>
            
            <div class="resend-otp">
                <a href="?resend=1">Didn't receive OTP? Resend</a>
            </div>
            <?php else: ?>
            <!-- Login Form -->
            <form method="POST" action="">
                <div class="form-group">
                    <label>Email Address</label>
                    <div class="input-wrapper">
                        <input type="email" name="email" placeholder="admin@admin.com" required>
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" placeholder="Enter password" required>
                        <i class="fas fa-lock"></i>
                    </div>
                </div>
                
                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i>
                    Access Dashboard
                </button>
            </form>
            <?php endif; ?>
            
            <a href="../index.html" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Website
            </a>
            
            <div class="security-note">
                <i class="fas fa-shield-alt"></i>
                <span>Secure admin access only</span>
            </div>
        </div>
    </div>
    
    <?php if ($showOTPForm): ?>
    <script>
        // Auto-focus and format OTP input
        document.querySelector('input[name="otp"]').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
    <?php endif; ?>
</body>
</html>



