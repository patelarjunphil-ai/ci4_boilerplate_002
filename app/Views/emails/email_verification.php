<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - <?= $appName ?></title>
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
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
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
        
        .verification-message {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
        
        .verification-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #17a2b8;
        }
        
        .verification-details h3 {
            margin: 0 0 15px 0;
            color: #333;
            font-size: 16px;
        }
        
        .verification-details p {
            margin: 8px 0;
            color: #666;
        }
        
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        
        .cta-button:hover {
            background: linear-gradient(135deg, #138496 0%, #117a8b 100%);
        }
        
        .verification-notice {
            background-color: #d1ecf1;
            border: 1px solid #bee5eb;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            color: #0c5460;
        }
        
        .verification-notice h4 {
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
            color: #17a2b8;
            text-decoration: none;
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- EMAIL HEADER -->
        <div class="email-header">
            <h1>📧 Verify Your Email</h1>
            <p>Complete your account setup</p>
        </div>
        
        <!-- EMAIL BODY -->
        <div class="email-body">
            <!-- VERIFICATION MESSAGE -->
            <div class="verification-message">
                Hello <strong><?= esc($username) ?></strong>,
            </div>
            
            <p>
                Thank you for registering with <?= $appName ?>! To complete your account setup and ensure 
                the security of your account, please verify your email address by clicking the button below.
            </p>
            
            <!-- VERIFICATION DETAILS -->
            <div class="verification-details">
                <h3>📋 Account Details:</h3>
                <p><strong>Username:</strong> <?= esc($username) ?></p>
                <p><strong>Email:</strong> <?= esc($userEmail) ?></p>
                <p><strong>Registration Date:</strong> <?= date('F j, Y \a\t g:i A') ?></p>
            </div>
            
            <!-- VERIFICATION BUTTON -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="<?= $verificationLink ?>" class="cta-button">
                    Verify Email Address
                </a>
            </div>
            
            <!-- ALTERNATIVE LINK -->
            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 6px; margin: 20px 0;">
                <p style="margin: 0; font-size: 14px; color: #666;">
                    <strong>Button not working?</strong> Copy and paste this link into your browser:<br>
                    <a href="<?= $verificationLink ?>" style="color: #17a2b8; word-break: break-all; font-size: 12px;">
                        <?= $verificationLink ?>
                    </a>
                </p>
            </div>
            
            <!-- VERIFICATION NOTICE -->
            <div class="verification-notice">
                <h4>✅ Why Verify Your Email?</h4>
                <p>
                    Email verification helps us ensure that:
                </p>
                <ul style="margin: 10px 0; padding-left: 20px; color: #0c5460;">
                    <li>You have access to the email address you provided</li>
                    <li>We can send you important account notifications</li>
                    <li>Your account remains secure and protected</li>
                    <li>You can recover your account if needed</li>
                </ul>
            </div>
            
            <!-- EXPIRATION WARNING -->
            <div class="warning-notice">
                <h4>⏰ Verification Link Expires</h4>
                <p>
                    This verification link will expire in 24 hours for security reasons. 
                    If you don't verify your email within this time, you'll need to request a new verification email.
                </p>
            </div>
            
            <!-- BENEFITS OF VERIFICATION -->
            <div style="background-color: #f8f9fa; padding: 20px; border-radius: 6px; margin: 20px 0;">
                <h4 style="color: #333; margin: 0 0 15px 0;">🎯 What Happens After Verification?</h4>
                <ul style="color: #666; line-height: 1.8; margin: 0; padding-left: 20px;">
                    <li>Full access to all account features</li>
                    <li>Receive important notifications and updates</li>
                    <li>Enhanced account security</li>
                    <li>Ability to reset your password if needed</li>
                    <li>Access to customer support services</li>
                </ul>
            </div>
            
            <!-- SUPPORT INFORMATION -->
            <div style="background-color: #e9ecef; padding: 20px; border-radius: 6px; margin: 20px 0;">
                <h4 style="color: #333; margin: 0 0 10px 0;">Need Help?</h4>
                <p style="margin: 5px 0; color: #666;">
                    If you're having trouble verifying your email or didn't create an account with us, 
                    please contact our support team. We're here to help you get started.
                </p>
            </div>
        </div>
        
        <!-- EMAIL FOOTER -->
        <div class="email-footer">
            <p>
                <strong><?= $appName ?></strong><br>
                This verification email was sent to <?= esc($userEmail) ?>.
            </p>
            
            <div class="social-links">
                <a href="#">Website</a> |
                <a href="#">Support</a> |
                <a href="#">Help Center</a>
            </div>
            
            <p style="margin-top: 20px; font-size: 12px; color: #999;">
                © <?= $currentYear ?> <?= $appName ?>. All rights reserved.<br>
                This verification link will expire in 24 hours for security reasons.
            </p>
        </div>
    </div>
</body>
</html>
