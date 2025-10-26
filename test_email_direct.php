<?php
// Direct email test
require_once 'vendor/autoload.php';

use CodeIgniter\Config\Services;

// Load CodeIgniter
$app = \CodeIgniter\Config\Services::codeigniter();
$app->initialize();

// Test email sending
$email = Services::email();

$email->setTo('testuser999@example.com');
$email->setSubject('Test Email from CI4');
$email->setMessage('This is a test email to verify the email system is working.');

if ($email->send()) {
    echo "Email sent successfully!\n";
} else {
    echo "Email failed: " . $email->printDebugger() . "\n";
}
?>
