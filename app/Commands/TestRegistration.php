<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Config\Services;

class TestRegistration extends BaseCommand
{
    protected $group       = 'Testing';
    protected $name        = 'test:registration';
    protected $description = 'Test registration process directly';

    public function run(array $params)
    {
        CLI::write('=== TESTING REGISTRATION PROCESS ===', 'yellow');
        
        try {
            $db = Services::database();
            
            // Test data
            $userData = [
                'username' => 'testuser_' . time(),
                'email' => 'testuser_' . time() . '@example.com',
                'password' => 'password123'
            ];
            
            CLI::write('Testing user creation...', 'blue');
            
            // Start transaction
            $db->transStart();
            
            // Create user
            $userDataToInsert = [
                'username' => $userData['username'],
                'status' => 'active',
                'active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $db->table('users')->insert($userDataToInsert);
            $userId = $db->insertID();
            
            CLI::write("User ID: {$userId}", 'green');
            
            // Create auth identity
            $identityData = [
                'user_id' => $userId,
                'type' => 'email_password',
                'name' => $userData['email'],
                'secret' => password_hash($userData['password'], PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $db->table('auth_identities')->insert($identityData);
            
            // Complete transaction
            $db->transComplete();
            
            if ($db->transStatus() === false) {
                CLI::write('❌ Transaction failed', 'red');
                CLI::write('Error: ' . $db->getLastQuery(), 'red');
            } else {
                CLI::write('✅ Registration test successful!', 'green');
            }
            
        } catch (\Exception $e) {
            CLI::write('❌ Error: ' . $e->getMessage(), 'red');
        }
    }
}
