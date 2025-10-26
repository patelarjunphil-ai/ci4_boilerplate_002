<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Forgot Password' ?></title>
    <style>
        /* MODERN FORGOT PASSWORD FORM STYLES */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .forgot-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            position: relative;
        }
        
        .forgot-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .forgot-header h1 {
            color: #333;
            font-size: 28px;
            font-weight: 300;
            margin-bottom: 10px;
        }
        
        .forgot-header p {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .reset-button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        .reset-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .reset-button:active {
            transform: translateY(0);
        }
        
        .form-links {
            text-align: center;
            margin-top: 20px;
        }
        
        .form-links a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            margin: 0 10px;
            transition: color 0.3s ease;
        }
        
        .form-links a:hover {
            color: #764ba2;
        }
        
        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
            color: #666;
            font-size: 14px;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background-color: #e1e5e9;
            z-index: 1;
        }
        
        .divider span {
            background-color: white;
            padding: 0 15px;
            position: relative;
            z-index: 2;
        }
        
        .info-notice {
            background-color: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            font-size: 12px;
            color: #1565c0;
        }
        
        .info-notice h4 {
            margin: 0 0 8px 0;
            color: #1565c0;
            font-size: 13px;
        }
        
        .back-to-login {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-to-login a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            transition: color 0.3s ease;
        }
        
        .back-to-login a:hover {
            color: #764ba2;
        }
        
        .back-to-login a::before {
            content: '←';
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="forgot-container">
        <!-- FORGOT PASSWORD HEADER -->
        <div class="forgot-header">
            <h1>Forgot Password?</h1>
            <p>No worries! Enter your email address and we'll send you a link to reset your password.</p>
        </div>
        
        <!-- SUCCESS/ERROR MESSAGES -->
        <?php if (session('success')): ?>
            <div class="alert alert-success">
                <?= session('success') ?>
            </div>
        <?php endif; ?>
        
        <?php if (session('error')): ?>
            <div class="alert alert-error">
                <?= session('error') ?>
            </div>
        <?php endif; ?>
        
        <?php if (session('errors')): ?>
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <!-- INFORMATION NOTICE -->
        <div class="info-notice">
            <h4>📧 What happens next?</h4>
            <p>
                If an account with that email exists, we'll send you a password reset link. 
                The link will be valid for 1 hour for security reasons.
            </p>
        </div>
        
        <!-- FORGOT PASSWORD FORM -->
        <form action="<?= url_to('forgot-password') ?>" method="post" id="forgotForm">
            <?= csrf_field() ?>
            
            <!-- EMAIL FIELD -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email"
                    value="<?= old('email') ?>" 
                    placeholder="Enter your email address"
                    required
                    autocomplete="email"
                >
            </div>
            
            <!-- RESET BUTTON -->
            <button type="submit" class="reset-button">
                Send Reset Link
            </button>
        </form>
        
        <!-- FORM LINKS -->
        <div class="form-links">
            <div class="divider">
                <span>Remember your password?</span>
            </div>
            <a href="<?= url_to('login') ?>">Back to Sign In</a>
        </div>
        
        <!-- BACK TO LOGIN -->
        <div class="back-to-login">
            <a href="<?= url_to('login') ?>">Back to Login</a>
        </div>
    </div>
    
    <!-- JAVASCRIPT FOR ENHANCED UX -->
    <script>
        // Add loading state to reset button
        document.getElementById('forgotForm').addEventListener('submit', function() {
            const button = document.querySelector('.reset-button');
            button.textContent = 'Sending...';
            button.disabled = true;
        });
        
        // Add focus effects
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
        
        // Email validation feedback
        document.getElementById('email').addEventListener('input', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && !emailRegex.test(email)) {
                this.style.borderColor = '#dc3545';
            } else {
                this.style.borderColor = '#e1e5e9';
            }
        });
    </script>
</body>
</html>
