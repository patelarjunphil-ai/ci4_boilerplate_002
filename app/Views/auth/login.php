<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Login' ?></title>
    <style>
        /* MODERN LOGIN FORM STYLES */
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
        
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            position: relative;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header h1 {
            color: #333;
            font-size: 28px;
            font-weight: 300;
            margin-bottom: 10px;
        }
        
        .login-header p {
            color: #666;
            font-size: 14px;
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
        
        /* PASSWORD FIELD WITH TOGGLE ICON */
        .password-field {
            position: relative;
        }
        
        .password-field input {
            padding-right: 45px; /* Space for the toggle icon */
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
            font-size: 18px;
            padding: 5px;
            transition: color 0.3s ease;
        }
        
        .password-toggle:hover {
            color: #667eea;
        }
        
        .password-toggle:focus {
            outline: none;
            color: #667eea;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .login-button {
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
        
        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .login-button:active {
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
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 15px 0;
            font-size: 14px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
        }
        
        .remember-me input {
            margin-right: 8px;
            width: auto;
        }
        
        .forgot-password {
            color: #667eea;
            text-decoration: none;
        }
        
        .forgot-password:hover {
            color: #764ba2;
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
    </style>
</head>
<body>
    <div class="login-container">
        <!-- LOGIN HEADER -->
        <div class="login-header">
            <h1>Welcome Back</h1>
            <p>Sign in to your account to continue</p>
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
        
        <!-- LOGIN FORM -->
    <form action="<?= url_to('login') ?>" method="post">
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
            
            <!-- PASSWORD FIELD -->
            <div class="form-group">
        <label for="password">Password</label>
                <div class="password-field">
                    <input 
                        type="password" 
                        name="password" 
                        id="password"
                        placeholder="Enter your password"
                        required
                        autocomplete="current-password"
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        👁️
                    </button>
                </div>
            </div>
            
            <!-- REMEMBER ME & FORGOT PASSWORD -->
            <div class="remember-forgot">
                <div class="remember-me">
                    <input type="checkbox" name="remember" id="remember" value="1">
                    <label for="remember">Remember me</label>
                </div>
                <a href="<?= url_to('forgot-password') ?>" class="forgot-password">
                    Forgot password?
                </a>
            </div>
            
            <!-- LOGIN BUTTON -->
            <button type="submit" class="login-button">
                Sign In
            </button>
    </form>
        
        <!-- FORM LINKS -->
        <div class="form-links">
            <div class="divider">
                <span>Don't have an account?</span>
            </div>
            <a href="<?= url_to('register') ?>">Create Account</a>
        </div>
    </div>
    
    <!-- JAVASCRIPT FOR ENHANCED UX -->
    <script>
        // Password toggle functionality
        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const toggleButton = passwordField.nextElementSibling;
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleButton.innerHTML = '🙈'; // Hide icon
            } else {
                passwordField.type = 'password';
                toggleButton.innerHTML = '👁️'; // Show icon
            }
        }
        
        // Add loading state to login button
        document.querySelector('form').addEventListener('submit', function() {
            const button = document.querySelector('.login-button');
            button.textContent = 'Signing In...';
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
    </script>
</body>
</html>
