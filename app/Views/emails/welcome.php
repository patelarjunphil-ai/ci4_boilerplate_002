<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to <?= $appName ?></title>
    <style>
        /* EMAIL TEMPLATE STYLES */
        /* These styles ensure the email looks good across different email clients */
        
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        
        .welcome-message {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
        
        .user-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }
        
        .user-info h3 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 16px;
        }
        
        .user-info p {
            margin: 5px 0;
            color: #666;
        }
        
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        
        .cta-button:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
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
            color: #667eea;
            text-decoration: none;
            margin: 0 10px;
        }
        
        .verification-notice {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            color: #856404;
        }
        
        .verification-notice h4 {
            margin: 0 0 10px 0;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- EMAIL HEADER -->
        <div class="email-header">
            <h1>Welcome to <?= $appName ?>!</h1>
            <p>Your account has been successfully created</p>
        </div>
        
        <!-- EMAIL BODY -->
        <div class="email-body">
            <!-- WELCOME MESSAGE -->
            <div class="welcome-message">
                Hello <strong><?= esc($username) ?></strong>,
            </div>
            
            <p>
                Thank you for registering with <?= $appName ?>! We're excited to have you on board. 
                Your account has been successfully created and you can now start using our platform.
            </p>
            
            <!-- USER ACCOUNT INFORMATION -->
            <div class="user-info">
                <h3>Your Account Details:</h3>
                <p><strong>Username:</strong> <?= esc($username) ?></p>
                <p><strong>Email:</strong> <?= esc($userEmail) ?></p>
                <p><strong>Registration Date:</strong> <?= date('F j, Y \a\t g:i A') ?></p>
            </div>
            
            <!-- EMAIL VERIFICATION SECTION -->
            <?php if ($verificationLink): ?>
            <div class="verification-notice">
                <h4>📧 Verify Your Email Address</h4>
                <p>
                    To complete your registration and ensure the security of your account, 
                    please verify your email address by clicking the button below:
                </p>
                <div style="text-align: center; margin: 20px 0;">
                    <a href="<?= $verificationLink ?>" class="cta-button">
                        Verify Email Address
                    </a>
                </div>
                <p style="font-size: 12px; color: #666; margin-top: 15px;">
                    If the button doesn't work, copy and paste this link into your browser:<br>
                    <a href="<?= $verificationLink ?>" style="color: #667eea; word-break: break-all;">
                        <?= $verificationLink ?>
                    </a>
                </p>
            </div>
            <?php endif; ?>
            
            <!-- GETTING STARTED SECTION -->
            <div style="margin: 30px 0;">
                <h3 style="color: #333; margin-bottom: 15px;">🚀 Getting Started</h3>
                <p>Here are some things you can do to get the most out of your account:</p>
                <ul style="color: #666; line-height: 1.8;">
                    <li>Complete your profile information</li>
                    <li>Explore our features and tools</li>
                    <li>Join our community discussions</li>
                    <li>Set up your preferences</li>
                </ul>
            </div>
            
            <!-- CALL TO ACTION -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="<?= base_url() ?>" class="cta-button">
                    Start Using <?= $appName ?>
                </a>
            </div>
            
            <!-- SUPPORT INFORMATION -->
            <div style="background-color: #f8f9fa; padding: 20px; border-radius: 6px; margin: 20px 0;">
                <h4 style="color: #333; margin: 0 0 10px 0;">Need Help?</h4>
                <p style="margin: 5px 0; color: #666;">
                    If you have any questions or need assistance, please don't hesitate to contact our support team.
                    We're here to help you get the most out of your experience with <?= $appName ?>.
                </p>
            </div>
        </div>
        
        <!-- EMAIL FOOTER -->
        <div class="email-footer">
            <p>
                <strong><?= $appName ?></strong><br>
                This email was sent to <?= esc($userEmail) ?> because you registered for an account.
            </p>
            
            <div class="social-links">
                <a href="#">Website</a> |
                <a href="#">Support</a> |
                <a href="#">Privacy Policy</a>
            </div>
            
            <p style="margin-top: 20px; font-size: 12px; color: #999;">
                © <?= $currentYear ?> <?= $appName ?>. All rights reserved.<br>
                You received this email because you created an account with us.
            </p>
        </div>
    </div>
</body>
</html>
