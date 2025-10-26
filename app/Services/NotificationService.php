<?php

namespace App\Services;

use CodeIgniter\Email\Email;
use CodeIgniter\Config\Services;

/**
 * NOTIFICATION SERVICE
 * 
 * This service handles all email notifications for the application.
 * It provides a centralized way to send emails for various events
 * like user registration, login notifications, password resets, etc.
 * 
 * LEARNING NOTES:
 * - Services in CodeIgniter 4 are classes that provide specific functionality
 * - This service uses the Email library to send emails
 * - We use dependency injection to get the Email service
 * - All email templates are stored in app/Views/emails/ directory
 */
class NotificationService
{
    /**
     * EMAIL SERVICE INSTANCE
     * We inject the Email service to handle email sending
     */
    protected Email $email;

    /**
     * CONSTRUCTOR
     * Initialize the email service with proper configuration
     */
    public function __construct()
    {
        // Get the email service from CodeIgniter's service container
        $this->email = Services::email();
        
        // Configure email settings
        $this->configureEmail();
    }

    /**
     * CONFIGURE EMAIL SETTINGS
     * Set up the email service with proper configuration
     */
    private function configureEmail(): void
    {
        // Set the sender email and name
        $this->email->setFrom(config('Email')->fromEmail, config('Email')->fromName);
        
        // Set mail type to HTML for rich content
        $this->email->setMailType('html');
        
        // Note: Character encoding is set in the Email config file
        // The charset is automatically handled by CodeIgniter 4
    }

    /**
     * SEND REGISTRATION WELCOME EMAIL
     * 
     * This method sends a welcome email to newly registered users.
     * It includes account verification if required.
     * 
     * @param string $userEmail The user's email address
     * @param string $username The user's username
     * @param string $verificationLink Optional verification link
     * @return bool True if email was sent successfully, false otherwise
     */
    public function sendWelcomeEmail(string $userEmail, string $username, ?string $verificationLink = null): bool
    {
        try {
            // Set recipient
            $this->email->setTo($userEmail);
            
            // Set email subject
            $this->email->setSubject('Welcome to ' . config('Email')->fromName);
            
            // Prepare email data for the template
            $emailData = [
                'username' => $username,
                'userEmail' => $userEmail,
                'verificationLink' => $verificationLink,
                'appName' => config('Email')->fromName,
                'currentYear' => date('Y')
            ];
            
            // Load and render the email template
            $emailBody = view('emails/welcome', $emailData);
            
            // Set the email body
            $this->email->setMessage($emailBody);
            
            // Send the email
            $result = $this->email->send();
            
            // Log the email sending attempt
            if ($result) {
                log_message('info', "Welcome email sent successfully to: {$userEmail}");
            } else {
                log_message('error', "Failed to send welcome email to: {$userEmail}. Error: " . $this->email->printDebugger());
            }
            
            return $result;
            
        } catch (\Exception $e) {
            // Log any errors that occur
            log_message('error', "Exception in sendWelcomeEmail: " . $e->getMessage());
            return false;
        }
    }

    /**
     * SEND LOGIN NOTIFICATION EMAIL
     * 
     * This method sends a notification email when a user logs in.
     * This is useful for security purposes to notify users of account activity.
     * 
     * @param string $userEmail The user's email address
     * @param string $username The user's username
     * @param string $loginTime The time of login
     * @param string $ipAddress The IP address from which the user logged in
     * @param string $userAgent The browser/device information
     * @return bool True if email was sent successfully, false otherwise
     */
    public function sendLoginNotification(string $userEmail, string $username, string $loginTime, string $ipAddress, string $userAgent): bool
    {
        try {
            // Set recipient
            $this->email->setTo($userEmail);
            
            // Set email subject
            $this->email->setSubject('New Login Activity - ' . config('Email')->fromName);
            
            // Prepare email data for the template
            $emailData = [
                'username' => $username,
                'userEmail' => $userEmail,
                'loginTime' => $loginTime,
                'ipAddress' => $ipAddress,
                'userAgent' => $userAgent,
                'appName' => config('Email')->fromName,
                'currentYear' => date('Y')
            ];
            
            // Load and render the email template
            $emailBody = view('emails/login_notification', $emailData);
            
            // Set the email body
            $this->email->setMessage($emailBody);
            
            // Send the email
            $result = $this->email->send();
            
            // Log the email sending attempt
            if ($result) {
                log_message('info', "Login notification email sent successfully to: {$userEmail}");
            } else {
                log_message('error', "Failed to send login notification email to: {$userEmail}. Error: " . $this->email->printDebugger());
            }
            
            return $result;
            
        } catch (\Exception $e) {
            // Log any errors that occur
            log_message('error', "Exception in sendLoginNotification: " . $e->getMessage());
            return false;
        }
    }

    /**
     * SEND PASSWORD RESET EMAIL
     * 
     * This method sends a password reset email to users who request it.
     * 
     * @param string $userEmail The user's email address
     * @param string $username The user's username
     * @param string $resetLink The password reset link
     * @return bool True if email was sent successfully, false otherwise
     */
    public function sendPasswordResetEmail(string $userEmail, string $username, string $resetLink): bool
    {
        try {
            // Set recipient
            $this->email->setTo($userEmail);
            
            // Set email subject
            $this->email->setSubject('Password Reset Request - ' . config('Email')->fromName);
            
            // Prepare email data for the template
            $emailData = [
                'username' => $username,
                'userEmail' => $userEmail,
                'resetLink' => $resetLink,
                'appName' => config('Email')->fromName,
                'currentYear' => date('Y')
            ];
            
            // Load and render the email template
            $emailBody = view('emails/password_reset', $emailData);
            
            // Set the email body
            $this->email->setMessage($emailBody);
            
            // Send the email
            $result = $this->email->send();
            
            // Log the email sending attempt
            if ($result) {
                log_message('info', "Password reset email sent successfully to: {$userEmail}");
            } else {
                log_message('error', "Failed to send password reset email to: {$userEmail}. Error: " . $this->email->printDebugger());
            }
            
            return $result;
            
        } catch (\Exception $e) {
            // Log any errors that occur
            log_message('error', "Exception in sendPasswordResetEmail: " . $e->getMessage());
            return false;
        }
    }

    /**
     * SEND EMAIL VERIFICATION
     * 
     * This method sends an email verification link to users.
     * 
     * @param string $userEmail The user's email address
     * @param string $username The user's username
     * @param string $verificationLink The email verification link
     * @return bool True if email was sent successfully, false otherwise
     */
    public function sendEmailVerification(string $userEmail, string $username, string $verificationLink): bool
    {
        try {
            // Set recipient
            $this->email->setTo($userEmail);
            
            // Set email subject
            $this->email->setSubject('Verify Your Email Address - ' . config('Email')->fromName);
            
            // Prepare email data for the template
            $emailData = [
                'username' => $username,
                'userEmail' => $userEmail,
                'verificationLink' => $verificationLink,
                'appName' => config('Email')->fromName,
                'currentYear' => date('Y')
            ];
            
            // Load and render the email template
            $emailBody = view('emails/email_verification', $emailData);
            
            // Set the email body
            $this->email->setMessage($emailBody);
            
            // Send the email
            $result = $this->email->send();
            
            // Log the email sending attempt
            if ($result) {
                log_message('info', "Email verification sent successfully to: {$userEmail}");
            } else {
                log_message('error', "Failed to send email verification to: {$userEmail}. Error: " . $this->email->printDebugger());
            }
            
            return $result;
            
        } catch (\Exception $e) {
            // Log any errors that occur
            log_message('error', "Exception in sendEmailVerification: " . $e->getMessage());
            return false;
        }
    }

    /**
     * SEND CUSTOM EMAIL
     * 
     * This method allows sending custom emails with any template.
     * 
     * @param string $toEmail Recipient email address
     * @param string $subject Email subject
     * @param string $template Email template name (without .php extension)
     * @param array $data Data to pass to the template
     * @return bool True if email was sent successfully, false otherwise
     */
    public function sendCustomEmail(string $toEmail, string $subject, string $template, array $data = []): bool
    {
        try {
            // Set recipient
            $this->email->setTo($toEmail);
            
            // Set email subject
            $this->email->setSubject($subject);
            
            // Add default data
            $data['appName'] = config('Email')->fromName;
            $data['currentYear'] = date('Y');
            
            // Load and render the email template
            $emailBody = view("emails/{$template}", $data);
            
            // Set the email body
            $this->email->setMessage($emailBody);
            
            // Send the email
            $result = $this->email->send();
            
            // Log the email sending attempt
            if ($result) {
                log_message('info', "Custom email sent successfully to: {$toEmail}");
            } else {
                log_message('error', "Failed to send custom email to: {$toEmail}. Error: " . $this->email->printDebugger());
            }
            
            return $result;
            
        } catch (\Exception $e) {
            // Log any errors that occur
            log_message('error', "Exception in sendCustomEmail: " . $e->getMessage());
            return false;
        }
    }

    /**
     * GET EMAIL DEBUG INFO
     * 
     * This method returns debug information about the last email attempt.
     * Useful for troubleshooting email issues.
     * 
     * @return string Debug information
     */
    public function getDebugInfo(): string
    {
        return $this->email->printDebugger();
    }
}
