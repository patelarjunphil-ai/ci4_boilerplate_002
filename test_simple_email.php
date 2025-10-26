<?php
// Simple email test
require_once 'vendor/autoload.php';

use CodeIgniter\Config\Services;

// Load CodeIgniter
$app = \CodeIgniter\Config\Services::codeigniter();
$app->initialize();

echo "Testing email system...\n";

// Test email sending
$email = Services::email();

$email->setTo('test@example.com');
$email->setSubject('Test Email from CI4');
$email->setMessage('This is a test email to verify the email system is working.');

if ($email->send()) {
    echo "✅ Email sent successfully!\n";
} else {
    echo "❌ Email failed: " . $email->printDebugger() . "\n";
}

echo "Test completed.\n";
?>
