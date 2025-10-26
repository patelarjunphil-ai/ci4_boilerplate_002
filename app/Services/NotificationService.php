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
            
            // Create simple HTML message
            $message = '
            <html>
            <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
                <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
                    <h1 style="color: #667eea;">Welcome to ' . config('Email')->fromName . '!</h1>
                    <p>Hello <strong>' . $username . '</strong>,</p>
                    <p>Thank you for registering with us! Your account has been created successfully.</p>';
            
            if ($verificationLink) {
                $message .= '
                    <p>Please verify your email address by clicking the button below:</p>
                    <div style="text-align: center; margin: 30px 0;">
                        <a href="' . $verificationLink . '" style="background-color: #667eea; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;">Verify Email Address</a>
                    </div>';
            }
            
            $message .= '
                    <p>If you have any questions, please don\'t hesitate to contact us.</p>
                    <p>Best regards,<br>The ' . config('Email')->fromName . ' Team</p>
                    <hr style="margin: 30px 0; border: none; border-top: 1px solid #eee;">
                    <p style="font-size: 12px; color: #666;">This email was sent to ' . $userEmail . '</p>
                </div>
            </body>
            </html>';
            
            // Set the email body
            $this->email->setMessage($message);
            
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
            
            // Create simple HTML message
            $message = '
            <html>
            <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
                <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
                    <h1 style="color: #dc3545;">🔒 Security Alert</h1>
                    <p>Hello <strong>' . $username . '</strong>,</p>
                    <p>We detected a new login to your account. Here are the details:</p>
                    
                    <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
                        <h3 style="margin-top: 0; color: #495057;">Login Details:</h3>
                        <p><strong>Time:</strong> ' . $loginTime . '</p>
                        <p><strong>IP Address:</strong> ' . $ipAddress . '</p>
                        <p><strong>Device/Browser:</strong> ' . $userAgent . '</p>
                    </div>
                    
                    <p>If this was you, you can safely ignore this email.</p>
                    <p>If you don\'t recognize this login, please secure your account immediately by changing your password.</p>
                    
                    <div style="text-align: center; margin: 30px 0;">
                        <a href="http://localhost:8080/login" style="background-color: #dc3545; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;">Secure My Account</a>
                    </div>
                    
                    <p>Best regards,<br>The ' . config('Email')->fromName . ' Security Team</p>
                    <hr style="margin: 30px 0; border: none; border-top: 1px solid #eee;">
                    <p style="font-size: 12px; color: #666;">This email was sent to ' . $userEmail . '</p>
                </div>
            </body>
            </html>';
            
            // Set the email body
            $this->email->setMessage($message);
            
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
