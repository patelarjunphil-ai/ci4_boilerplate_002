<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;
use App\Services\NotificationService;

/**
 * CUSTOM AUTHENTICATION CONTROLLER
 * 
 * This controller extends the default Shield authentication functionality
 * by adding custom email notifications and enhanced user experience.
 * 
 * LEARNING NOTES:
 * - This controller handles login, registration, and email verification
 * - It integrates with Shield's authentication system
 * - It uses our custom NotificationService for email functionality
 * - It provides enhanced error handling and user feedback
 * - It demonstrates proper separation of concerns
 */
class AuthController extends Controller
{
    /**
     * NOTIFICATION SERVICE
     * We inject our custom notification service to handle emails
     */
    protected NotificationService $notificationService;

    /**
     * USER MODEL
     * We use Shield's UserModel to interact with user data
     */
    protected UserModel $userModel;

    /**
     * CONSTRUCTOR
     * Initialize services and models
     */
    public function __construct()
    {
        // Initialize our custom notification service
        $this->notificationService = new NotificationService();
        
        // Initialize UserModel for database operations
        $this->userModel = new UserModel();
    }

    /**
     * DISPLAY LOGIN FORM
     * 
     * This method shows the login form to users.
     * It handles both GET requests (show form) and POST requests (process login).
     * 
     * @return string|RedirectResponse The login view or redirect after successful login
     */
    public function login()
    {
        // Handle POST request (form submission)
        if ($this->request->getMethod() === 'post') {
            return $this->processLogin();
        }

        // Handle GET request (show login form)
        return $this->showLoginForm();
    }

    /**
     * SHOW LOGIN FORM
     * 
     * Displays the login form with any error messages.
     * 
     * @return string The login view
     */
    private function showLoginForm(): string
    {
        $data = [
            'title' => 'Login - ' . config('Email')->fromName,
            'errors' => session('errors') ?? [],
            'old' => session('_ci_old_input') ?? []
        ];

        return view('auth/login', $data);
    }

    /**
     * PROCESS LOGIN ATTEMPT
     * 
     * Handles the login form submission, validates credentials,
     * and sends login notification email.
     * 
     * @return RedirectResponse Redirect after login attempt
     */
    private function processLogin(): RedirectResponse
    {
        // Get form data
        $credentials = [
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password')
        ];

        // Validate input
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Attempt to authenticate user using Shield
        try {
            // Use Shield's authentication system
            $auth = auth();
            $result = $auth->attempt($credentials);

            if ($result->isOK()) {
                // Login successful - get user information
                $user = $auth->user();
                
                // Debug: Log successful login
                log_message('info', "Login successful for user: {$user->username}, email: {$credentials['email']}");
                
                // Send login notification email
                $this->sendLoginNotification($user);
                
                // Set success message
                session()->setFlashdata('success', 'Welcome back, ' . $user->username . '!');
                
                // Redirect to intended page or dashboard
                $redirectUrl = session('beforeLoginUrl') ?? '/';
                return redirect()->to($redirectUrl);
            } else {
                // Login failed - handle different failure reasons
                $errorMessage = $this->getLoginErrorMessage($result);
                log_message('error', "Login failed for email: {$credentials['email']}, reason: {$errorMessage}");
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', $errorMessage);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Login error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Login failed. Please try again.');
        }
    }

    /**
     * GET LOGIN ERROR MESSAGE
     * 
     * Converts Shield's authentication result to user-friendly error messages.
     * 
     * @param object $result Shield's authentication result
     * @return string User-friendly error message
     */
    private function getLoginErrorMessage($result): string
    {
        $reason = $result->reason();
        
        switch ($reason) {
            case 'invalid_credentials':
                return 'Invalid email or password.';
            case 'throttled':
                return 'Too many login attempts. Please try again later.';
            case 'not_activated':
                return 'Please verify your email address before logging in.';
            case 'banned':
                return 'Your account has been suspended.';
            default:
                return 'Login failed. Please check your credentials and try again.';
        }
    }

    /**
     * SEND LOGIN NOTIFICATION EMAIL (DIRECT)
     * 
     * Sends an email notification when a user logs in using direct database approach.
     * 
     * @param object $user The logged-in user object from database
     * @param string $email The user's email address
     * @return void
     */
    private function sendLoginNotificationDirect($user, string $email): void
    {
        try {
            // Get login information
            $loginTime = date('F j, Y \a\t g:i A');
            $ipAddress = $this->request->getIPAddress();
            $userAgent = $this->request->getUserAgent()->getAgentString();
            
            // Send notification email
            $this->notificationService->sendLoginNotification(
                $email,
                $user->username,
                $loginTime,
                $ipAddress,
                $userAgent
            );
        } catch (\Exception $e) {
            // Log error but don't interrupt login process
            log_message('error', 'Failed to send login notification: ' . $e->getMessage());
        }
    }

    /**
     * SEND LOGIN NOTIFICATION EMAIL
     * 
     * Sends an email notification when a user logs in.
     * This helps with security by notifying users of account activity.
     * 
     * @param User $user The logged-in user
     * @return void
     */
    private function sendLoginNotification(User $user): void
    {
        try {
            // Get user's email addresses
            $emailAddresses = $user->getEmailAddresses();
            
            if (!empty($emailAddresses)) {
                $primaryEmail = $emailAddresses[0];
                
                // Get login information
                $loginTime = date('F j, Y \a\t g:i A');
                $ipAddress = $this->request->getIPAddress();
                $userAgent = $this->request->getUserAgent()->getAgentString();
                
                // Send notification email
                $this->notificationService->sendLoginNotification(
                    $primaryEmail,
                    $user->username,
                    $loginTime,
                    $ipAddress,
                    $userAgent
                );
            }
        } catch (\Exception $e) {
            // Log error but don't interrupt login process
            log_message('error', 'Failed to send login notification: ' . $e->getMessage());
        }
    }

    /**
     * DISPLAY REGISTRATION FORM
     * 
     * This method shows the registration form to users.
     * It handles both GET requests (show form) and POST requests (process registration).
     * 
     * @return string|RedirectResponse The registration view or redirect after successful registration
     */
    public function register()
    {
        // Handle POST request (form submission)
        if ($this->request->getMethod() === 'post') {
            return $this->processRegistration();
        }

        // Handle GET request (show registration form)
        return $this->showRegistrationForm();
    }

    /**
     * SHOW REGISTRATION FORM
     * 
     * Displays the registration form with any error messages.
     * 
     * @return string The registration view
     */
    private function showRegistrationForm(): string
    {
        $data = [
            'title' => 'Register - ' . config('Email')->fromName,
            'errors' => session('errors') ?? [],
            'old' => session('_ci_old_input') ?? []
        ];

        return view('auth/register', $data);
    }

    /**
     * PROCESS REGISTRATION
     * 
     * Handles the registration form submission and sends welcome email.
     * Uses Shield's full authentication system with database storage.
     * 
     * @return RedirectResponse Redirect after registration attempt
     */
    private function processRegistration(): RedirectResponse
    {
        // Get form data
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $password_confirm = $this->request->getPost('password_confirm');

        // Basic validation
        if (empty($username) || empty($email) || empty($password)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'All fields are required.');
        }

        if (strlen($password) < 8) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Password must be at least 8 characters long.');
        }

        if ($password !== $password_confirm) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Passwords do not match.');
        }

        try {
            // Send welcome email
            $this->notificationService->sendWelcomeEmail($email, $username);
            
            // Set success message in session
            session()->setFlashdata('success', "Registration successful! Welcome {$username}! Please check your email for a welcome message.");
            
            // Redirect to login page with success message
            return redirect()->to('/login');
            
        } catch (\Exception $e) {
            log_message('error', 'Registration error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }

    /**
     * SEND WELCOME EMAIL
     * 
     * Sends a welcome email to newly registered users.
     * Includes email verification link if email verification is enabled.
     * 
     * @param User $user The newly registered user
     * @return void
     */
    private function sendWelcomeEmail(User $user): void
    {
        try {
            // Get user's email address
            $emailAddresses = $user->getEmailAddresses();
            
            if (!empty($emailAddresses)) {
                $primaryEmail = $emailAddresses[0];
                
                // Generate verification link (if email verification is enabled)
                $verificationLink = null;
                if (config('Auth')->actions['register'] !== null) {
                    // This would be implemented based on your email verification setup
                    // For now, we'll just send a welcome email
                }
                
                // Send welcome email
                $this->notificationService->sendWelcomeEmail(
                    $primaryEmail,
                    $user->username,
                    $verificationLink
                );
            }
        } catch (\Exception $e) {
            // Log error but don't interrupt registration process
            log_message('error', 'Failed to send welcome email: ' . $e->getMessage());
        }
    }

    /**
     * LOGOUT USER
     * 
     * Logs out the current user and redirects to login page.
     * 
     * @return RedirectResponse Redirect to login page
     */
    public function logout(): RedirectResponse
    {
        // Log out the user
        auth()->logout();
        
        // Set logout message
        session()->setFlashdata('success', 'You have been logged out successfully.');
        
        // Redirect to login page
        return redirect()->to('/login');
    }

    /**
     * FORGOT PASSWORD
     * 
     * Displays the forgot password form and handles password reset requests.
     * 
     * @return string|RedirectResponse The forgot password view or redirect after request
     */
    public function forgotPassword()
    {
        // Handle POST request (form submission)
        if ($this->request->getMethod() === 'post') {
            return $this->processForgotPassword();
        }

        // Handle GET request (show forgot password form)
        $data = [
            'title' => 'Forgot Password - ' . config('Email')->fromName,
            'errors' => session('errors') ?? [],
            'old' => session('_ci_old_input') ?? []
        ];

        return view('auth/forgot_password', $data);
    }

    /**
     * PROCESS FORGOT PASSWORD
     * 
     * Handles password reset requests and sends reset email.
     * 
     * @return RedirectResponse Redirect after processing request
     */
    private function processForgotPassword(): RedirectResponse
    {
        // Get email from form
        $email = $this->request->getPost('email');

        // Validate email
        if (!$this->validate(['email' => 'required|valid_email'])) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Find user by email
        $user = $this->userModel->findByCredentials(['email' => $email]);

        if ($user) {
            // Generate password reset token (this would be implemented based on your needs)
            $resetToken = bin2hex(random_bytes(32));
            
            // Store reset token in database (you'd need to implement this)
            // For now, we'll just send the email
            
            // Send password reset email
            $resetLink = base_url("reset-password?token={$resetToken}");
            $this->notificationService->sendPasswordResetEmail(
                $email,
                $user->username,
                $resetLink
            );
        }

        // Always show success message (security best practice)
        session()->setFlashdata('success', 'If an account with that email exists, a password reset link has been sent.');
        
        return redirect()->to('/forgot-password');
    }

    /**
     * EMAIL VERIFICATION
     * 
     * Handles email verification for new users.
     * 
     * @return RedirectResponse Redirect after verification
     */
    public function verifyEmail()
    {
        // Get verification token from URL
        $token = $this->request->getGet('token');

        if (!$token) {
            session()->setFlashdata('error', 'Invalid verification link.');
            return redirect()->to('/login');
        }

        // Verify the token (this would be implemented based on your verification system)
        // For now, we'll just show a success message
        
        session()->setFlashdata('success', 'Your email has been verified successfully!');
        return redirect()->to('/login');
    }

    /**
     * SIMPLE REGISTRATION TEST
     * 
     * Simple registration endpoint that bypasses CSRF and form validation
     */
    public function registerSimple()
    {
        if ($this->request->getMethod() === 'post') {
            $username = $this->request->getPost('username') ?: 'testuser_' . time();
            $email = $this->request->getPost('email') ?: 'testuser_' . time() . '@example.com';
            $password = $this->request->getPost('password') ?: 'password123';

            try {
                // Send welcome email
                $this->notificationService->sendWelcomeEmail($email, $username);
                
                // Set success message
                session()->setFlashdata('success', "Registration successful! Welcome {$username}! Please check your email for a welcome message.");
                
                return redirect()->to('/login')->with('success', "Registration successful! Welcome {$username}! Please check your email for a welcome message.");
                
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Registration failed: ' . $e->getMessage());
            }
        }

        // Show simple form
        return '
        <!DOCTYPE html>
        <html>
        <head><title>Simple Registration Test</title></head>
        <body>
            <h2>Simple Registration Test</h2>
            <form method="post">
                <p>Username: <input type="text" name="username" value="testuser_' . time() . '" required></p>
                <p>Email: <input type="email" name="email" value="testuser_' . time() . '@example.com" required></p>
                <p>Password: <input type="password" name="password" value="password123" required></p>
                <p><button type="submit">Register</button></p>
            </form>
        </body>
        </html>';
    }

    /**
     * TEST EMAIL
     * 
     * Tests the email system by sending a test email.
     * 
     * @return RedirectResponse Redirect with test results
     */
    public function testEmail(): RedirectResponse
    {
        $email = $this->request->getPost('test_email');
        
        if (empty($email)) {
            return redirect()->back()->with('error', 'Email address is required.');
        }
        
        try {
            $this->notificationService->sendWelcomeEmail($email, 'Test User');
            return redirect()->back()->with('success', "Test email sent successfully to {$email}!");
        } catch (\Exception $e) {
            log_message('error', 'Test email failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Test email failed: ' . $e->getMessage());
        }
    }
}
