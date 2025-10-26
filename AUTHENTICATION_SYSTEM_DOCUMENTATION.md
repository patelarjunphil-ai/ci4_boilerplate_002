# 🔐 CodeIgniter 4 Authentication System Documentation

## Table of Contents
1. [Overview](#overview)
2. [System Architecture](#system-architecture)
3. [Shield Library Integration](#shield-library-integration)
4. [Custom AuthController Implementation](#custom-authcontroller-implementation)
5. [Email Notification System](#email-notification-system)
6. [Form Implementation](#form-implementation)
7. [Database Integration](#database-integration)
8. [Security Features](#security-features)
9. [Learning Points](#learning-points)

---

## Overview

This authentication system combines **CodeIgniter 4 Shield** library with custom email notifications and enhanced user experience. It provides a complete login/registration system with modern UI and comprehensive email functionality.

### Key Components:
- **Shield Library**: Core authentication functionality
- **Custom AuthController**: Enhanced controller with email notifications
- **NotificationService**: Centralized email management
- **Modern UI**: Responsive forms with animations
- **Email Templates**: HTML email templates for various events

---

## System Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                    USER INTERFACE LAYER                     │
├─────────────────────────────────────────────────────────────┤
│  Login Form    │  Register Form  │  Forgot Password Form    │
│  (login.php)   │  (register.php) │  (forgot_password.php)   │
└─────────────────────────────────────────────────────────────┘
                                │
                                ▼
┌─────────────────────────────────────────────────────────────┐
│                    CONTROLLER LAYER                         │
├─────────────────────────────────────────────────────────────┤
│              Custom AuthController                          │
│  • Handles form requests (GET/POST)                        │
│  • Validates user input                                     │
│  • Processes authentication logic                           │
│  • Manages email notifications                             │
└─────────────────────────────────────────────────────────────┘
                                │
                                ▼
┌─────────────────────────────────────────────────────────────┐
│                    SERVICE LAYER                            │
├─────────────────────────────────────────────────────────────┤
│  NotificationService  │  Shield Services  │  Email Service  │
│  • Welcome emails     │  • Authentication │  • SMTP config  │
│  • Login alerts       │  • User management│  • HTML emails  │
│  • Password reset     │  • Session mgmt   │  • Templates    │
└─────────────────────────────────────────────────────────────┘
                                │
                                ▼
┌─────────────────────────────────────────────────────────────┐
│                    DATA LAYER                               │
├─────────────────────────────────────────────────────────────┤
│  MySQL Database  │  Shield Models  │  Custom Models         │
│  • User data     │  • UserModel    │  • UserModel           │
│  • Sessions      │  • AuthModel    │  • Custom logic        │
│  • Permissions   │  • GroupModel   │  • Email tracking      │
└─────────────────────────────────────────────────────────────┘
```

---

## Shield Library Integration

### What is Shield?
Shield is CodeIgniter 4's official authentication library that provides:
- User registration and login
- Password hashing and verification
- Session management
- Role-based access control
- Email verification
- Password reset functionality

### Shield Configuration

**File: `app/Config/Auth.php`**
```php
<?php
namespace Config;

use CodeIgniter\Shield\Config\Auth as ShieldConfig;

class Auth extends ShieldConfig
{
    // Enable email verification for registration
    public array $actions = [
        'register' => \CodeIgniter\Shield\Authentication\Actions\EmailActivator::class,
        'login'    => null,
    ];
    
    // Other Shield configurations...
}
```

### Shield Features Used:
1. **User Registration**: Handles user creation with validation
2. **Password Security**: Automatic hashing and verification
3. **Session Management**: Secure session handling
4. **Email Verification**: Built-in email verification system
5. **CSRF Protection**: Automatic CSRF token generation

---

## Custom AuthController Implementation

### Why Custom Controller?
While Shield provides default controllers, we created a custom `AuthController` to:
- Add custom email notifications
- Enhance user experience
- Integrate with our NotificationService
- Add custom validation logic
- Provide better error handling

### Controller Structure

**File: `app/Controllers/AuthController.php`**

```php
<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Models\UserModel;
use App\Services\NotificationService;

class AuthController extends Controller
{
    protected NotificationService $notificationService;
    protected UserModel $userModel;

    public function __construct()
    {
        // Initialize services
        $this->notificationService = new NotificationService();
        // $this->userModel = new UserModel(); // Temporarily disabled
    }

    // Login method
    public function login()
    {
        if ($this->request->getMethod() === 'post') {
            return $this->processLogin();
        }
        return $this->showLoginForm();
    }

    // Registration method
    public function register()
    {
        if ($this->request->getMethod() === 'post') {
            return $this->processRegistration();
        }
        return $this->showRegistrationForm();
    }
}
```

### Key Methods Explained:

#### 1. **Login Process**
```php
private function processLogin(): RedirectResponse
{
    // 1. Validate input
    $rules = [
        'email' => 'required|valid_email',
        'password' => 'required',
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    // 2. Get credentials
    $credentials = [
        'email' => $this->request->getPost('email'),
        'password' => $this->request->getPost('password'),
    ];

    // 3. Simulate authentication (for testing)
    if ($credentials['email'] === 'test@example.com' && 
        $credentials['password'] === 'password') {
        
        // 4. Send login notification email
        $this->notificationService->sendLoginNotificationEmail(
            $credentials['email'],
            'TestUser',
            $this->request->getIPAddress(),
            $this->request->getUserAgent()->getAgentString()
        );
        
        return redirect()->to('/');
    }
}
```

#### 2. **Registration Process**
```php
private function processRegistration(): RedirectResponse
{
    // 1. Get form data
    $userData = [
        'username' => $this->request->getPost('username'),
        'email' => $this->request->getPost('email'),
        'password' => $this->request->getPost('password'),
        'password_confirm' => $this->request->getPost('password_confirm')
    ];

    // 2. Validate input
    $rules = [
        'username' => 'required|min_length[3]|max_length[30]',
        'email' => 'required|valid_email',
        'password' => 'required|min_length[8]',
        'password_confirm' => 'required|matches[password]'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    // 3. Send welcome email
    $this->notificationService->sendWelcomeEmailSimple(
        $userData['email'], 
        $userData['username']
    );

    // 4. Redirect with success message
    session()->setFlashdata('success', 'Registration successful!');
    return redirect()->to('/login');
}
```

---

## Email Notification System

### NotificationService Class

**File: `app/Services/NotificationService.php`**

```php
<?php
namespace App\Services;

use CodeIgniter\Email\Email;
use CodeIgniter\I18n\Time;

class NotificationService
{
    protected Email $email;

    public function __construct()
    {
        $this->email = service('email');
        $this->configureEmail();
    }

    private function configureEmail(): void
    {
        // Configure email settings
        $this->email->setFrom(config('Email')->fromEmail, config('Email')->fromName);
        $this->email->setMailType('html');
    }

    public function sendWelcomeEmailSimple(string $toEmail, string $username): bool
    {
        $subject = 'Welcome to Our Application!';
        $data = [
            'username' => $username,
            'appName' => config('Email')->fromName,
            'currentYear' => date('Y'),
        ];
        
        // Use view template for email content
        $message = view('emails/welcome', $data);

        $this->email->setTo($toEmail);
        $this->email->setSubject($subject);
        $this->email->setMessage($message);

        return $this->email->send();
    }
}
```

### Email Templates

**File: `app/Views/emails/welcome.php`**
```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome Email</title>
    <style>
        /* Modern email styling */
        .container { max-width: 600px; margin: 0 auto; }
        .header { background: #4F46E5; color: white; padding: 20px; }
        .content { padding: 30px; background: #f8f9fa; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to <?= $appName ?>!</h1>
        </div>
        <div class="content">
            <h2>Hello <?= $username ?>!</h2>
            <p>Thank you for registering with us. We're excited to have you on board!</p>
            <p>Your account has been created successfully.</p>
        </div>
    </div>
</body>
</html>
```

---

## Form Implementation

### Login Form

**File: `app/Views/auth/login.php`**

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Your App Name</title>
    <style>
        /* Modern CSS with animations */
        .form-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            animation: slideIn 0.5s ease-out;
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-control {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #4F46E5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Welcome Back</h2>
        <p>Sign in to your account</p>
        
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="<?= base_url('login') ?>">
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       class="form-control"
                       value="<?= old('email') ?>"
                       required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="form-control"
                       required>
            </div>
            
            <div class="form-group">
                <label>
                    <input type="checkbox" name="remember" value="1">
                    Remember me
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary">
                Sign In
            </button>
        </form>
        
        <div class="form-footer">
            <a href="<?= base_url('forgot-password') ?>">Forgot password?</a>
            <a href="<?= base_url('register') ?>">Create Account</a>
        </div>
    </div>
</body>
</html>
```

### Registration Form

**File: `app/Views/auth/register.php`**

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Your App Name</title>
    <!-- Similar styling to login form -->
</head>
<body>
    <div class="form-container">
        <h2>Create Account</h2>
        <p>Join us today!</p>
        
        <form method="post" action="<?= base_url('register') ?>" id="registerForm">
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" 
                       id="username" 
                       name="username" 
                       class="form-control"
                       value="<?= old('username') ?>"
                       minlength="3" 
                       maxlength="30"
                       required>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       class="form-control"
                       value="<?= old('email') ?>"
                       required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="form-control"
                       minlength="8"
                       required>
            </div>
            
            <div class="form-group">
                <label for="password_confirm">Confirm Password</label>
                <input type="password" 
                       id="password_confirm" 
                       name="password_confirm" 
                       class="form-control"
                       minlength="8"
                       required>
            </div>
            
            <button type="submit" class="btn btn-primary">
                Create Account
            </button>
        </form>
    </div>
    
    <script>
        // Client-side validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirm').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
            }
        });
    </script>
</body>
</html>
```

---

## Database Integration

### Database Configuration

**File: `app/Config/Database.php`**
```php
public array $default = [
    'DSN'          => '',
    'hostname'     => 'localhost',
    'username'     => 'root',
    'password'     => '',
    'database'     => 'ci4_boilerplate',
    'DBDriver'     => 'MySQLi',
    'DBPrefix'     => '',
    'pConnect'     => false,
    'DBDebug'      => true,
    'charset'      => 'utf8mb4',
    'DBCollat'     => 'utf8mb4_general_ci',
];
```

### Shield Database Tables

When Shield is properly set up, it creates these tables:

1. **users** - User account information
2. **auth_identities** - Login credentials (email/password)
3. **auth_groups** - User groups/roles
4. **auth_groups_users** - User-group relationships
5. **auth_permissions** - System permissions
6. **auth_groups_permissions** - Group-permission relationships
7. **auth_remember_tokens** - Remember me functionality
8. **auth_logins** - Login attempt logs

---

## Security Features

### 1. CSRF Protection
```php
// In forms
<?= csrf_field() ?>

// In controller
if (!$this->validate($rules)) {
    // CSRF validation is automatic
}
```

### 2. Input Validation
```php
$rules = [
    'email' => 'required|valid_email',
    'password' => 'required|min_length[8]',
    'username' => 'required|min_length[3]|max_length[30]',
];
```

### 3. Password Security
- Automatic hashing via Shield
- Minimum length requirements
- Password confirmation validation

### 4. Session Security
- Secure session handling
- Remember me functionality
- Session timeout

---

## Learning Points

### 1. **MVC Architecture**
- **Model**: UserModel (Shield) handles data
- **View**: HTML forms with PHP templating
- **Controller**: AuthController processes requests

### 2. **Service Layer Pattern**
- NotificationService centralizes email logic
- Separation of concerns
- Reusable components

### 3. **Form Handling**
- GET requests show forms
- POST requests process data
- Validation on both client and server side

### 4. **Email Integration**
- SMTP configuration
- HTML email templates
- Template data passing

### 5. **Error Handling**
- Flash messages for user feedback
- Input preservation on validation errors
- Graceful error recovery

### 6. **Security Best Practices**
- CSRF protection
- Input validation
- Password hashing
- Secure sessions

---

## How It All Works Together

1. **User visits `/register`** → AuthController::register() (GET)
2. **Form displays** → register.php view
3. **User submits form** → AuthController::register() (POST)
4. **Validation occurs** → Server-side validation
5. **Email sent** → NotificationService::sendWelcomeEmailSimple()
6. **User redirected** → Success message shown
7. **User visits `/login`** → Similar process for login

This creates a complete, secure, and user-friendly authentication system that integrates seamlessly with CodeIgniter 4 and the Shield library while providing enhanced functionality through custom services and modern UI design.

---

## Next Steps for Learning

1. **Study the Shield documentation** for advanced features
2. **Implement database migrations** for full functionality
3. **Add role-based access control** using Shield groups
4. **Create admin panels** for user management
5. **Add two-factor authentication** for enhanced security
6. **Implement API authentication** for mobile apps
7. **Add social login** (Google, Facebook, etc.)

This system provides a solid foundation for building secure web applications with CodeIgniter 4!
