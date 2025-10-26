<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Services\NotificationService;

/**
 * WORKING AUTH CONTROLLER
 * 
 * A simple authentication controller that shows notifications immediately.
 */
class WorkingAuthController extends Controller
{
    protected $notificationService;

    public function __construct()
    {
        $this->notificationService = new NotificationService();
    }

    /**
     * WORKING REGISTRATION
     * 
     * Shows a registration form and processes registration with immediate feedback.
     * 
     * @return string The registration view with immediate feedback
     */
    public function register()
    {
        $data = [
            'success' => null,
            'error' => null,
            'username' => '',
            'email' => ''
        ];

        // Handle POST request (form submission)
        if ($this->request->getMethod() === 'post') {
            $result = $this->processRegistration();
            $data = array_merge($data, $result);
        }

        // Handle GET request (show form)
        return view('working_register', $data);
    }

    /**
     * PROCESS REGISTRATION
     * 
     * Handles the registration form submission and sends welcome email.
     * 
     * @return array Registration result
     */
    private function processRegistration()
    {
        // Get form data
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $password_confirm = $this->request->getPost('password_confirm');

        // Basic validation
        if (empty($username) || empty($email) || empty($password)) {
            return [
                'error' => 'All fields are required.',
                'username' => $username,
                'email' => $email
            ];
        }

        if (strlen($password) < 8) {
            return [
                'error' => 'Password must be at least 8 characters long.',
                'username' => $username,
                'email' => $email
            ];
        }

        if ($password !== $password_confirm) {
            return [
                'error' => 'Passwords do not match.',
                'username' => $username,
                'email' => $email
            ];
        }

        try {
            // Send welcome email
            $this->notificationService->sendWelcomeEmail($email, $username);
            
            // Return success message
            return [
                'success' => "Registration successful! Welcome {$username}! Please check your email for a welcome message.",
                'username' => '',
                'email' => ''
            ];
            
        } catch (\Exception $e) {
            log_message('error', 'Registration error: ' . $e->getMessage());
            return [
                'error' => 'Registration failed: ' . $e->getMessage(),
                'username' => $username,
                'email' => $email
            ];
        }
    }
}