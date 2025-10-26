<?php
// Test session functionality
require_once 'vendor/autoload.php';

use CodeIgniter\Config\Services;

// Load CodeIgniter
$app = \CodeIgniter\Config\Services::codeigniter();
$app->initialize();

echo "Testing session system...\n";

// Test session
$session = Services::session();

// Set a test flashdata
$session->setFlashdata('test', 'This is a test message');

// Get the flashdata
$testMessage = $session->getFlashdata('test');

if ($testMessage) {
    echo "✅ Session flashdata working: " . $testMessage . "\n";
} else {
    echo "❌ Session flashdata not working\n";
}

echo "Test completed.\n";
?>
