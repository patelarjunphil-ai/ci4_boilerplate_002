<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Services\NotificationService;

class TestRegistrationFlow extends BaseCommand
{
    protected $group       = 'Testing';
    protected $name        = 'test:registration-flow';
    protected $description = 'Test complete registration flow including email';

    public function run(array $params)
    {
        CLI::write('=== REGISTRATION FLOW TEST ===', 'yellow');
        CLI::newLine();

        try {
            // Test data
            $testEmail = 'patelarjunphil@gmail.com';
            $testUsername = 'TestRegistrationUser';
            $verificationLink = 'http://localhost:8080/verify-email?token=test_token_123';
            
            CLI::write('Testing registration email flow...', 'blue');
            CLI::write('Email: ' . $testEmail, 'blue');
            CLI::write('Username: ' . $testUsername, 'blue');
            CLI::newLine();
            
            // Create notification service
            $notificationService = new NotificationService();
            
            // Test welcome email
            CLI::write('1. Testing welcome email...', 'cyan');
            $welcomeResult = $notificationService->sendWelcomeEmail(
                $testEmail,
                $testUsername,
                $verificationLink
            );
            
            if ($welcomeResult) {
                CLI::write('   ✅ Welcome email sent successfully!', 'green');
            } else {
                CLI::write('   ❌ Welcome email failed', 'red');
            }
            
            CLI::newLine();
            
            // Test login notification
            CLI::write('2. Testing login notification...', 'cyan');
            $loginResult = $notificationService->sendLoginNotification(
                $testEmail,
                $testUsername,
                date('F j, Y \a\t g:i A'),
                '192.168.1.100',
                'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
            );
            
            if ($loginResult) {
                CLI::write('   ✅ Login notification sent successfully!', 'green');
            } else {
                CLI::write('   ❌ Login notification failed', 'red');
            }
            
            CLI::newLine();
            
            // Summary
            if ($welcomeResult && $loginResult) {
                CLI::write('🎉 REGISTRATION FLOW TEST PASSED!', 'green');
                CLI::write('Both emails are working correctly.', 'green');
                CLI::write('Check your inbox at: ' . $testEmail, 'green');
            } else {
                CLI::write('❌ REGISTRATION FLOW TEST FAILED', 'red');
                CLI::write('Some email functionality is not working.', 'red');
            }
            
        } catch (\Exception $e) {
            CLI::write('❌ ERROR: ' . $e->getMessage(), 'red');
        }

        CLI::newLine();
        CLI::write('=== TEST COMPLETE ===', 'yellow');
    }
}
