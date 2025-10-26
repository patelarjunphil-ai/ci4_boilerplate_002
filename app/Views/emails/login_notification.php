<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Login Activity - <?= $appName ?></title>
    <style>
        /* EMAIL TEMPLATE STYLES */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            line-height: 1.6;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .email-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        
        .email-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 300;
        }
        
        .email-body {
            padding: 40px 30px;
        }
        
        .login-message {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
        
        .login-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #28a745;
        }
        
        .login-details h3 {
            margin: 0 0 15px 0;
            color: #333;
            font-size: 16px;
        }
        
        .login-details p {
            margin: 8px 0;
            color: #666;
        }
        
        .security-notice {
            background-color: #d1ecf1;
            border: 1px solid #bee5eb;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            color: #0c5460;
        }
        
        .security-notice h4 {
            margin: 0 0 10px 0;
            color: #0c5460;
        }
        
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        
        .cta-button:hover {
            background: linear-gradient(135deg, #218838 0%, #1ea085 100%);
        }
        
        .email-footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        
        .social-links {
            margin: 20px 0;
        }
        
        .social-links a {
            color: #28a745;
            text-decoration: none;
            margin: 0 10px;
        }
        
        .warning-notice {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            color: #856404;
        }
        
        .warning-notice h4 {
            margin: 0 0 10px 0;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- EMAIL HEADER -->
        <div class="email-header">
            <h1>🔐 New Login Activity</h1>
            <p>Your account was accessed successfully</p>
        </div>
        
        <!-- EMAIL BODY -->
        <div class="email-body">
            <!-- LOGIN MESSAGE -->
            <div class="login-message">
                Hello <strong><?= esc($username) ?></strong>,
            </div>
            
            <p>
                We're writing to inform you that your <?= $appName ?> account was accessed successfully. 
                This is a security notification to keep you informed about your account activity.
            </p>
            
            <!-- LOGIN DETAILS -->
            <div class="login-details">
                <h3>📊 Login Details:</h3>
                <p><strong>Username:</strong> <?= esc($username) ?></p>
                <p><strong>Email:</strong> <?= esc($userEmail) ?></p>
                <p><strong>Login Time:</strong> <?= esc($loginTime) ?></p>
                <p><strong>IP Address:</strong> <?= esc($ipAddress) ?></p>
                <p><strong>Device/Browser:</strong> <?= esc($userAgent) ?></p>
            </div>
            
            <!-- SECURITY NOTICE -->
            <div class="security-notice">
                <h4>🛡️ Security Information</h4>
                <p>
                    If you recognize this login activity, no further action is required. 
                    Your account remains secure and you can continue using our services normally.
                </p>
            </div>
            
            <!-- WARNING FOR UNRECOGNIZED ACTIVITY -->
            <div class="warning-notice">
                <h4>⚠️ Didn't Make This Login?</h4>
                <p>
                    If you didn't make this login or don't recognize this activity, please take immediate action:
                </p>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>Change your password immediately</li>
                    <li>Review your account security settings</li>
                    <li>Contact our support team if you have concerns</li>
                </ul>
            </div>
            
            <!-- CALL TO ACTION -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="<?= base_url() ?>" class="cta-button">
                    Access Your Account
                </a>
            </div>
            
            <!-- SECURITY TIPS -->
            <div style="background-color: #f8f9fa; padding: 20px; border-radius: 6px; margin: 20px 0;">
                <h4 style="color: #333; margin: 0 0 15px 0;">🔒 Security Tips</h4>
                <ul style="color: #666; line-height: 1.8; margin: 0; padding-left: 20px;">
                    <li>Use a strong, unique password for your account</li>
                    <li>Enable two-factor authentication if available</li>
                    <li>Log out from shared or public computers</li>
                    <li>Regularly review your account activity</li>
                    <li>Keep your contact information up to date</li>
                </ul>
            </div>
            
            <!-- SUPPORT INFORMATION -->
            <div style="background-color: #e9ecef; padding: 20px; border-radius: 6px; margin: 20px 0;">
                <h4 style="color: #333; margin: 0 0 10px 0;">Need Help?</h4>
                <p style="margin: 5px 0; color: #666;">
                    If you have any security concerns or questions about this login activity, 
                    please contact our support team immediately. We're here to help keep your account secure.
                </p>
            </div>
        </div>
        
        <!-- EMAIL FOOTER -->
        <div class="email-footer">
            <p>
                <strong><?= $appName ?></strong><br>
                This security notification was sent to <?= esc($userEmail) ?>.
            </p>
            
            <div class="social-links">
                <a href="#">Website</a> |
                <a href="#">Support</a> |
                <a href="#">Security Center</a>
            </div>
            
            <p style="margin-top: 20px; font-size: 12px; color: #999;">
                © <?= $currentYear ?> <?= $appName ?>. All rights reserved.<br>
                This is an automated security notification. Please do not reply to this email.
            </p>
        </div>
    </div>
</body>
</html>
