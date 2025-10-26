# 🔄 Authentication System Flow Diagram

## User Registration Flow

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   User visits   │───▶│  AuthController │───▶│  Register Form  │
│   /register     │    │  ::register()   │    │  (register.php) │
│   (GET request) │    │  (GET method)   │    │                 │
└─────────────────┘    └─────────────────┘    └─────────────────┘
                                                       │
                                                       ▼
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│  Success Page   │◀───│  AuthController │◀───│  User submits   │
│  with message   │    │  ::register()   │    │  form data      │
│                 │    │  (POST method)  │    │  (POST request) │
└─────────────────┘    └─────────────────┘    └─────────────────┘
                                │
                                ▼
                       ┌─────────────────┐
                       │ NotificationService │
                       │ ::sendWelcomeEmail() │
                       │                 │
                       └─────────────────┘
```

## User Login Flow

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   User visits   │───▶│  AuthController │───▶│   Login Form    │
│   /login        │    │  ::login()      │    │  (login.php)    │
│   (GET request) │    │  (GET method)   │    │                 │
└─────────────────┘    └─────────────────┘    └─────────────────┘
                                                       │
                                                       ▼
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│  Dashboard or   │◀───│  AuthController │◀───│  User submits   │
│  Home Page      │    │  ::login()      │    │  credentials    │
│                 │    │  (POST method)  │    │  (POST request) │
└─────────────────┘    └─────────────────┘    └─────────────────┘
                                │
                                ▼
                       ┌─────────────────┐
                       │ NotificationService │
                       │ ::sendLoginNotification() │
                       │                 │
                       └─────────────────┘
```

## Email Notification Flow

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│  AuthController │───▶│ NotificationService │───▶│  Email Service  │
│  calls email    │    │  processes data │    │  (SMTP)         │
│  method         │    │  and templates  │    │                 │
└─────────────────┘    └─────────────────┘    └─────────────────┘
                                │
                                ▼
                       ┌─────────────────┐
                       │  Email Template │
                       │  (welcome.php,  │
                       │   login_notification.php) │
                       └─────────────────┘
```

## Database Integration Flow

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│  AuthController │───▶│   UserModel     │───▶│  MySQL Database │
│  (when enabled) │    │  (Shield)       │    │  (ci4_boilerplate) │
└─────────────────┘    └─────────────────┘    └─────────────────┘
                                │
                                ▼
                       ┌─────────────────┐
                       │  Shield Tables  │
                       │  • users        │
                       │  • auth_identities │
                       │  • auth_groups  │
                       │  • auth_logins  │
                       └─────────────────┘
```

## Security Layer

```
┌─────────────────┐
│   User Input    │
└─────────────────┘
         │
         ▼
┌─────────────────┐
│  CSRF Protection│
└─────────────────┘
         │
         ▼
┌─────────────────┐
│ Input Validation│
│ • Required fields│
│ • Email format  │
│ • Password strength│
└─────────────────┘
         │
         ▼
┌─────────────────┐
│ Password Hashing│
│ (via Shield)    │
└─────────────────┘
         │
         ▼
┌─────────────────┐
│ Session Management│
│ (secure cookies)│
└─────────────────┘
```

## File Structure Overview

```
app/
├── Controllers/
│   └── AuthController.php          # Main authentication controller
├── Services/
│   └── NotificationService.php     # Email notification service
├── Views/
│   └── auth/
│       ├── login.php              # Login form view
│       ├── register.php           # Registration form view
│       └── forgot_password.php    # Password reset form view
├── Views/
│   └── emails/
│       ├── welcome.php            # Welcome email template
│       ├── login_notification.php # Login alert template
│       └── password_reset.php     # Password reset template
├── Config/
│   ├── Auth.php                   # Shield configuration
│   ├── Database.php               # Database configuration
│   └── Email.php                  # Email/SMTP configuration
└── Models/
    └── UserModel.php              # Shield user model
```

## Key Learning Concepts

### 1. **Separation of Concerns**
- **Controller**: Handles HTTP requests and responses
- **Service**: Contains business logic (email sending)
- **View**: Handles presentation (HTML forms)
- **Model**: Manages data (user information)

### 2. **Dependency Injection**
```php
// Services are injected into the controller
protected NotificationService $notificationService;

public function __construct()
{
    $this->notificationService = new NotificationService();
}
```

### 3. **Form Processing Pattern**
```php
public function register()
{
    // GET request: Show form
    if ($this->request->getMethod() === 'get') {
        return $this->showRegistrationForm();
    }
    
    // POST request: Process form
    if ($this->request->getMethod() === 'post') {
        return $this->processRegistration();
    }
}
```

### 4. **Template System**
```php
// Data is passed to view templates
$data = [
    'username' => $username,
    'appName' => config('Email')->fromName,
    'currentYear' => date('Y'),
];

// Template is rendered with data
$message = view('emails/welcome', $data);
```

### 5. **Configuration Management**
```php
// Configuration is accessed via config() helper
$this->email->setFrom(
    config('Email')->fromEmail, 
    config('Email')->fromName
);
```

This system demonstrates modern PHP development practices with CodeIgniter 4, providing a solid foundation for building secure web applications!
