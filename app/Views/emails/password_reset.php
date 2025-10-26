<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Request - <?= $appName ?></title>
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
            background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
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
        
        .reset-message {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
        
        .reset-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #dc3545;
        }
        
        .reset-details h3 {
            margin: 0 0 15px 0;
            color: #333;
            font-size: 16px;
        }
        
        .reset-details p {
            margin: 8px 0;
            color: #666;
        }
        
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        
        .cta-button:hover {
            background: linear-gradient(135deg, #c82333 0%, #d91a72 100%);
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
            color: #dc3545;
            text-decoration: none;
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- EMAIL HEADER -->
        <div class="email-header">
            <h1>🔑 Password Reset Request</h1>
            <p>Reset your account password</p>
        </div>
        
        <!-- EMAIL BODY -->
        <div class="email-body">
            <!-- RESET MESSAGE -->
            <div class="reset-message">
                Hello <strong><?= esc($username) ?></strong>,
            </div>
            
            <p>
                We received a request to reset the password for your <?= $appName ?> account. 
                If you made this request, click the button below to reset your password.
            </p>
            
            <!-- RESET DETAILS -->
            <div class="reset-details">
                <h3>📋 Request Details:</h3>
                <p><strong>Username:</strong> <?= esc($username) ?></p>
                <p><strong>Email:</strong> <?= esc($userEmail) ?></p>
                <p><strong>Request Time:</strong> <?= date('F j, Y \a\t g:i A') ?></p>
                <p><strong>IP Address:</strong> <?= $_SERVER['REMOTE_ADDR'] ?? 'Unknown' ?></p>
            </div>
            
            <!-- RESET BUTTON -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="<?= $resetLink ?>" class="cta-button">
                    Reset My Password
                </a>
            </div>
            
            <!-- ALTERNATIVE LINK -->
            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 6px; margin: 20px 0;">
                <p style="margin: 0; font-size: 14px; color: #666;">
                    <strong>Button not working?</strong> Copy and paste this link into your browser:<br>
                    <a href="<?= $resetLink ?>" style="color: #dc3545; word-break: break-all; font-size: 12px;">
                        <?= $resetLink ?>
                    </a>
                </p>
            </div>
            
            <!-- SECURITY NOTICE -->
            <div class="security-notice">
                <h4>🛡️ Security Information</h4>
                <p>
                    This password reset link will expire in 1 hour for security reasons. 
                    If you don't reset your password within this time, you'll need to request a new reset link.
                </p>
            </div>
            
            <!-- WARNING FOR UNRECOGNIZED REQUEST -->
            <div class="warning-notice">
                <h4>⚠️ Didn't Request This Reset?</h4>
                <p>
                    If you didn't request a password reset, please ignore this email. 
                    Your password will remain unchanged and your account will remain secure.
                </p>
                <p>
                    <strong>Important:</strong> If you're concerned about unauthorized access to your account, 
                    please contact our support team immediately.
                </p>
            </div>
            
            <!-- SECURITY TIPS -->
            <div style="background-color: #f8f9fa; padding: 20px; border-radius: 6px; margin: 20px 0;">
                <h4 style="color: #333; margin: 0 0 15px 0;">🔒 Password Security Tips</h4>
                <ul style="color: #666; line-height: 1.8; margin: 0; padding-left: 20px;">
                    <li>Use a strong password with at least 8 characters</li>
                    <li>Include a mix of uppercase, lowercase, numbers, and symbols</li>
                    <li>Don't use personal information in your password</li>
                    <li>Use a unique password for this account</li>
                    <li>Consider using a password manager</li>
                </ul>
            </div>
            
            <!-- SUPPORT INFORMATION -->
            <div style="background-color: #e9ecef; padding: 20px; border-radius: 6px; margin: 20px 0;">
                <h4 style="color: #333; margin: 0 0 10px 0;">Need Help?</h4>
                <p style="margin: 5px 0; color: #666;">
                    If you're having trouble resetting your password or have security concerns, 
                    please contact our support team. We're here to help you regain access to your account.
                </p>
            </div>
        </div>
        
        <!-- EMAIL FOOTER -->
        <div class="email-footer">
            <p>
                <strong><?= $appName ?></strong><br>
                This password reset request was sent to <?= esc($userEmail) ?>.
            </p>
            
            <div class="social-links">
                <a href="#">Website</a> |
                <a href="#">Support</a> |
                <a href="#">Security Center</a>
            </div>
            
            <p style="margin-top: 20px; font-size: 12px; color: #999;">
                © <?= $currentYear ?> <?= $appName ?>. All rights reserved.<br>
                This password reset link will expire in 1 hour for security reasons.
            </p>
        </div>
    </div>
</body>
</html>
