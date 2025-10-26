<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Config\Services;

class TestDatabase extends BaseCommand
{
    protected $group       = 'Testing';
    protected $name        = 'test:database';
    protected $description = 'Test database connection and operations';

    public function run(array $params)
    {
        CLI::write('=== DATABASE CONNECTION TEST ===', 'yellow');
        CLI::newLine();

        try {
            // Test database connection
            $db = Services::database();
            CLI::write('✅ Database connection successful', 'green');
            
            // Test basic query
            $result = $db->query('SELECT 1 as test');
            CLI::write('✅ Basic query test successful', 'green');
            
            // Test users table
            $users = $db->table('users')->countAllResults();
            CLI::write("✅ Users table accessible - {$users} users found", 'green');
            
            // Test auth_identities table
            $identities = $db->table('auth_identities')->countAllResults();
            CLI::write("✅ Auth identities table accessible - {$identities} identities found", 'green');
            
            // Test inserting a test user
            CLI::newLine();
            CLI::write('Testing user creation...', 'blue');
            
            $testUserData = [
                'username' => 'testuser_' . time(),
                'status' => 'active',
                'active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $db->table('users')->insert($testUserData);
            $userId = $db->insertID();
            
            if ($userId) {
                CLI::write("✅ Test user created successfully with ID: {$userId}", 'green');
                
                // Test creating auth identity
                $identityData = [
                    'user_id' => $userId,
                    'type' => 'email_password',
                    'name' => 'test@example.com',
                    'secret' => password_hash('testpassword', PASSWORD_DEFAULT),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                
                $db->table('auth_identities')->insert($identityData);
                CLI::write('✅ Test auth identity created successfully', 'green');
                
                // Clean up test data
                $db->table('auth_identities')->where('user_id', $userId)->delete();
                $db->table('users')->where('id', $userId)->delete();
                CLI::write('✅ Test data cleaned up', 'green');
            } else {
                CLI::write('❌ Failed to create test user', 'red');
            }
            
        } catch (\Exception $e) {
            CLI::write('❌ Database error: ' . $e->getMessage(), 'red');
        }

        CLI::newLine();
        CLI::write('=== DATABASE TEST COMPLETE ===', 'yellow');
    }
}
