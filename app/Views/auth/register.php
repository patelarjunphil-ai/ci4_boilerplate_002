<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Register' ?></title>
    <style>
        /* MODERN REGISTRATION FORM STYLES */
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
        
        .register-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            position: relative;
        }
        
        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .register-header h1 {
            color: #333;
            font-size: 28px;
            font-weight: 300;
            margin-bottom: 10px;
        }
        
        .register-header p {
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
        
        .form-group input.error {
            border-color: #dc3545;
            background-color: #fff5f5;
        }
        
        .password-requirements {
            background-color: #f8f9fa;
            border: 1px solid #e1e5e9;
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
            font-size: 12px;
            color: #666;
        }
        
        .password-requirements h4 {
            margin: 0 0 8px 0;
            color: #333;
            font-size: 13px;
        }
        
        .password-requirements ul {
            margin: 0;
            padding-left: 20px;
        }
        
        .password-requirements li {
            margin: 4px 0;
        }
        
        .register-button {
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
        
        .register-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .register-button:active {
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
        
        .terms-notice {
            background-color: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            font-size: 12px;
            color: #1565c0;
        }
        
        .terms-notice a {
            color: #1565c0;
            text-decoration: none;
            font-weight: 500;
        }
        
        .terms-notice a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- REGISTRATION HEADER -->
        <div class="register-header">
            <h1>Create Account</h1>
            <p>Join us today and get started</p>
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

        <!-- REGISTRATION FORM -->
        <form action="<?= url_to('register') ?>" method="post" id="registerForm">
        <?= csrf_field() ?>

            <!-- USERNAME FIELD -->
            <div class="form-group">
        <label for="username">Username</label>
                <input 
                    type="text" 
                    name="username" 
                    id="username"
                    value="<?= old('username') ?>" 
                    placeholder="Choose a unique username"
                    required
                    autocomplete="username"
                    minlength="3"
                    maxlength="30"
                >
            </div>
            
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
                        placeholder="Create a strong password"
                        required
                        autocomplete="new-password"
                        minlength="8"
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        👁️
                    </button>
                </div>
                
                <!-- PASSWORD REQUIREMENTS -->
                <div class="password-requirements">
                    <h4>Password Requirements:</h4>
                    <ul>
                        <li>At least 8 characters long</li>
                        <li>Contains uppercase and lowercase letters</li>
                        <li>Contains at least one number</li>
                        <li>Contains at least one special character</li>
                    </ul>
                </div>
            </div>
            
            <!-- CONFIRM PASSWORD FIELD -->
            <div class="form-group">
        <label for="password_confirm">Confirm Password</label>
                <div class="password-field">
                    <input 
                        type="password" 
                        name="password_confirm" 
                        id="password_confirm"
                        placeholder="Confirm your password"
                        required
                        autocomplete="new-password"
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirm')">
                        👁️
                    </button>
                </div>
            </div> 
            
            
            <!-- TERMS AND CONDITIONS -->
            <div class="terms-notice">
                By creating an account, you agree to our 
                <a href="#" target="_blank">Terms of Service</a> and 
                <a href="#" target="_blank">Privacy Policy</a>.
            </div>
            
            <!-- REGISTER BUTTON -->
            <button type="submit" class="register-button">
                Create Account
            </button>
    </form>
        
        <!-- FORM LINKS -->
        <div class="form-links">
            <div class="divider">
                <span>Already have an account?</span>
            </div>
            <a href="<?= url_to('login') ?>">Sign In</a>
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
        
        // Password confirmation validation
        document.getElementById('password_confirm').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (confirmPassword && password !== confirmPassword) {
                this.classList.add('error');
            } else {
                this.classList.remove('error');
            }
        });
        
        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const requirements = document.querySelector('.password-requirements');
            
            // Simple password strength check
            const hasLength = password.length >= 8;
            const hasUpper = /[A-Z]/.test(password);
            const hasLower = /[a-z]/.test(password);
            const hasNumber = /\d/.test(password);
            const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);
            
            // Update visual indicators (you can enhance this)
            if (hasLength && hasUpper && hasLower && hasNumber && hasSpecial) {
                this.style.borderColor = '#28a745';
            } else {
                this.style.borderColor = '#e1e5e9';
            }
        });
        
        // Add loading state to register button
        document.getElementById('registerForm').addEventListener('submit', function() {
            const button = document.querySelector('.register-button');
            button.textContent = 'Creating Account...';
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
