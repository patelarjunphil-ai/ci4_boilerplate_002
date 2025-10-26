# 💻 Code Examples and Detailed Explanations

## 1. Route Configuration

**File: `app/Config/Routes.php`**
```php
<?php
// Custom authentication routes that override Shield's defaults
$routes->get('/', 'Home::index');

// LOGIN ROUTES
$routes->get('login', 'AuthController::login');      // Show login form
$routes->post('login', 'AuthController::login');     // Process login

// REGISTRATION ROUTES  
$routes->get('register', 'AuthController::register');    // Show registration form
$routes->post('register', 'AuthController::register');   // Process registration

// OTHER AUTH ROUTES
$routes->get('logout', 'AuthController::logout');
$routes->get('forgot-password', 'AuthController::forgotPassword');
$routes->post('forgot-password', 'AuthController::forgotPassword');

// Include Shield's default routes for other functionality
service('auth')->routes($routes);
```

**Why This Matters:**
- We override Shield's default routes with our custom controller
- Same URL can handle both GET (show form) and POST (process form) requests
- This allows us to add custom functionality while keeping Shield's core features

---

## 2. Controller Method Breakdown

### Login Method Deep Dive

```php
public function login()
{
    // Check if user is already logged in (when database is enabled)
    // try {
    //     if (auth()->loggedIn()) {
    //         return redirect()->to('/');
    //     }
    // } catch (\Exception $e) {
    //     // Handle database connection issues gracefully
    // }

    // Determine if this is a form submission or form display
    if ($this->request->getMethod() === 'post') {
        return $this->processLogin();  // Handle form submission
    }

    return $this->showLoginForm();     // Show the login form
}
```

**Key Learning Points:**
- **Method Overloading**: Same method handles both GET and POST requests
- **Request Method Detection**: Uses `$this->request->getMethod()` to determine action
- **Error Handling**: Try-catch blocks for graceful error handling
- **Separation of Logic**: Form display and form processing are separate methods

### Form Processing Method

```php
private function processLogin(): RedirectResponse
{
    // 1. DEFINE VALIDATION RULES
    $rules = [
        'email' => 'required|valid_email',    // Email is required and must be valid
        'password' => 'required',             // Password is required
    ];

    // 2. VALIDATE INPUT
    if (!$this->validate($rules)) {
        // If validation fails, redirect back with errors
        return redirect()->back()
            ->withInput()                    // Preserve user input
            ->with('errors', $this->validator->getErrors()); // Show validation errors
    }

    // 3. GET FORM DATA
    $credentials = [
        'email' => $this->request->getPost('email'),
        'password' => $this->request->getPost('password'),
    ];

    // 4. SIMULATE AUTHENTICATION (for testing without database)
    if ($credentials['email'] === 'test@example.com' && 
        $credentials['password'] === 'password') {
        
        // 5. SEND LOGIN NOTIFICATION EMAIL
        $this->notificationService->sendLoginNotificationEmail(
            $credentials['email'],
            'TestUser',
            $this->request->getIPAddress(),
            $this->request->getUserAgent()->getAgentString()
        );

        // 6. SET SUCCESS MESSAGE AND REDIRECT
        session()->setFlashdata('success', 'Login successful! (Simulated)');
        return redirect()->to('/');
    } else {
        // 7. HANDLE INVALID CREDENTIALS
        return redirect()->back()
            ->withInput()
            ->with('error', 'Invalid credentials (Simulated).');
    }
}
```

**Key Learning Points:**
- **Validation**: Server-side validation using CodeIgniter's validation library
- **Flash Messages**: Temporary messages that show once then disappear
- **Input Preservation**: `withInput()` keeps form data when redirecting
- **Service Integration**: Calls NotificationService for email functionality
- **Security**: Gets IP address and user agent for security logging

---

## 3. Email Service Implementation

### Service Constructor and Configuration

```php
class NotificationService
{
    protected Email $email;

    public function __construct()
    {
        // Get the email service from CodeIgniter's service container
        $this->email = service('email');
        $this->configureEmail();
    }

    private function configureEmail(): void
    {
        // Set sender information from configuration
        $this->email->setFrom(
            config('Email')->fromEmail,    // 'noreply@yourdomain.com'
            config('Email')->fromName      // 'Your App Name'
        );

        // Set email type to HTML for rich content
        $this->email->setMailType('html');
    }
}
```

**Key Learning Points:**
- **Service Container**: CodeIgniter's dependency injection system
- **Configuration Access**: Using `config()` helper to access configuration
- **Constructor Pattern**: Initialize dependencies in constructor
- **Private Methods**: Helper methods for internal use

### Email Sending Method

```php
public function sendWelcomeEmailSimple(string $toEmail, string $username): bool
{
    // 1. PREPARE EMAIL DATA
    $subject = 'Welcome to Our Application!';
    $data = [
        'username' => $username,
        'verificationLink' => null,  // No verification in simplified version
        'appName' => config('Email')->fromName,
        'currentYear' => date('Y'),
    ];

    // 2. RENDER EMAIL TEMPLATE
    $message = view('emails/welcome', $data);

    // 3. CONFIGURE EMAIL
    $this->email->setTo($toEmail);
    $this->email->setSubject($subject);
    $this->email->setMessage($message);

    // 4. SEND EMAIL AND RETURN RESULT
    return $this->email->send();
}
```

**Key Learning Points:**
- **Template Rendering**: Using `view()` helper to render HTML templates
- **Data Passing**: Associative array passed to view template
- **Return Values**: Boolean return indicates success/failure
- **Error Handling**: Email service handles SMTP errors internally

---

## 4. View Template System

### Form Template with PHP Integration

```html
<!-- app/Views/auth/login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Your App Name</title>
    <style>
        /* CSS for modern styling */
        .form-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            animation: slideIn 0.5s ease-out;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Welcome Back</h2>
        <p>Sign in to your account</p>
        
        <!-- PHP: Display flash messages -->
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
        
        <!-- HTML: Form with PHP integration -->
        <form method="post" action="<?= base_url('login') ?>">
            <!-- CSRF Protection -->
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       class="form-control"
                       value="<?= old('email') ?>"  <!-- Preserve input on validation error -->
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
            
            <button type="submit" class="btn btn-primary">
                Sign In
            </button>
        </form>
    </div>
</body>
</html>
```

**Key Learning Points:**
- **PHP in HTML**: Mixing PHP logic with HTML presentation
- **Helper Functions**: `base_url()`, `old()`, `csrf_field()` are CodeIgniter helpers
- **Flash Messages**: Displaying temporary success/error messages
- **Input Preservation**: `old('email')` keeps form data after validation errors
- **Security**: CSRF token automatically generated and validated

### Email Template with Data

```html
<!-- app/Views/emails/welcome.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome Email</title>
    <style>
        .container { max-width: 600px; margin: 0 auto; }
        .header { background: #4F46E5; color: white; padding: 20px; }
        .content { padding: 30px; background: #f8f9fa; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to <?= $appName ?>!</h1>  <!-- PHP variable -->
        </div>
        <div class="content">
            <h2>Hello <?= $username ?>!</h2>      <!-- PHP variable -->
            <p>Thank you for registering with us. We're excited to have you on board!</p>
            <p>Your account has been created successfully.</p>
            <p>&copy; <?= $currentYear ?> <?= $appName ?>. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
```

**Key Learning Points:**
- **Template Variables**: Data passed from controller is available as variables
- **Email Styling**: Inline CSS for email compatibility
- **Dynamic Content**: PHP variables make content dynamic
- **Professional Layout**: Clean, modern email design

---

## 5. Configuration Management

### Email Configuration

**File: `app/Config/Email.php`**
```php
<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    // SENDER INFORMATION
    public string $fromEmail  = 'noreply@yourdomain.com';
    public string $fromName   = 'Your App Name';
    
    // SMTP CONFIGURATION
    public string $protocol = 'smtp';
    public string $SMTPHost = 'smtp.gmail.com';
    public string $SMTPUser = 'your-email@gmail.com';
    public string $SMTPPass = 'your-app-password';
    public int $SMTPPort = 587;
    public string $mailType = 'html';
    public string $charset = 'utf-8';
    
    // SMTP SECURITY
    public bool $SMTPCrypto = true;  // Enable TLS encryption
    public bool $SMTPAuth = true;    // Enable SMTP authentication
}
```

**Key Learning Points:**
- **Configuration Classes**: Extend BaseConfig for proper configuration
- **SMTP Settings**: Complete SMTP configuration for email sending
- **Security**: TLS encryption and authentication enabled
- **Gmail Integration**: Specific settings for Gmail SMTP

### Database Configuration

**File: `app/Config/Database.php`**
```php
public array $default = [
    'DSN'          => '',                    // Data Source Name (optional)
    'hostname'     => 'localhost',           // Database server
    'username'     => 'root',                // Database username
    'password'     => '',                    // Database password
    'database'     => 'ci4_boilerplate',     // Database name
    'DBDriver'     => 'MySQLi',              // Database driver
    'DBPrefix'     => '',                    // Table prefix
    'pConnect'     => false,                 // Persistent connection
    'DBDebug'      => true,                  // Debug mode
    'charset'      => 'utf8mb4',             // Character set
    'DBCollat'     => 'utf8mb4_general_ci',  // Collation
    'swapPre'      => '',                    // Swap prefix
    'encrypt'      => false,                 // Encryption
    'compress'     => false,                 // Compression
    'strictOn'     => false,                 // Strict mode
    'failover'     => [],                    // Failover servers
    'port'         => 3306,                  // Database port
];
```

---

## 6. Security Implementation

### CSRF Protection

```php
// In forms
<?= csrf_field() ?>

// This generates:
<input type="hidden" name="csrf_test_name" value="random_token_here">
```

**How it works:**
1. Server generates a random token
2. Token is stored in session
3. Token is included in form
4. On form submission, server validates token
5. If token doesn't match, request is rejected

### Input Validation

```php
$rules = [
    'email' => 'required|valid_email',
    'password' => 'required|min_length[8]',
    'username' => 'required|min_length[3]|max_length[30]',
];

if (!$this->validate($rules)) {
    // Validation failed
    return redirect()->back()
        ->withInput()
        ->with('errors', $this->validator->getErrors());
}
```

**Validation Rules Explained:**
- `required`: Field must not be empty
- `valid_email`: Must be a valid email format
- `min_length[8]`: Minimum 8 characters
- `max_length[30]`: Maximum 30 characters

### Password Security

```php
// Shield automatically handles password hashing
$user = $this->userModel->save([
    'username' => $username,
    'email' => $email,
    'password' => $password,  // Automatically hashed by Shield
]);
```

**Security Features:**
- Automatic password hashing using bcrypt
- Salt generation for each password
- Secure password verification
- Protection against timing attacks

---

## 7. Error Handling and User Experience

### Flash Messages

```php
// Set flash message
session()->setFlashdata('success', 'Registration successful!');

// Display flash message in view
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>
```

### Input Preservation

```php
// Preserve input on validation error
<input type="email" 
       name="email" 
       value="<?= old('email') ?>">

// This keeps the user's input even after a failed validation
```

### Graceful Error Handling

```php
try {
    // Database operation that might fail
    $this->userModel->save($userData);
} catch (\Exception $e) {
    // Log the error
    log_message('error', 'Registration error: ' . $e->getMessage());
    
    // Show user-friendly message
    return redirect()->back()
        ->withInput()
        ->with('error', 'Registration failed. Please try again.');
}
```

---

## 8. Modern Development Practices

### Service Layer Pattern

```php
// Instead of putting email logic in controller
class AuthController extends Controller
{
    protected NotificationService $notificationService;
    
    public function __construct()
    {
        $this->notificationService = new NotificationService();
    }
    
    public function register()
    {
        // Controller focuses on HTTP handling
        $this->notificationService->sendWelcomeEmail($email, $username);
    }
}
```

### Dependency Injection

```php
// Services are injected rather than created inline
public function __construct()
{
    $this->notificationService = new NotificationService();
    // This makes testing easier and code more maintainable
}
```

### Configuration Management

```php
// Configuration is centralized and easily changeable
$fromEmail = config('Email')->fromEmail;
$appName = config('Email')->fromName;
```

This comprehensive system demonstrates modern PHP development with CodeIgniter 4, providing a solid foundation for building secure, maintainable web applications!
