<?php
/**
 * CodeIgniter 4 Setup Script
 * Automates the setup process for new CI4 projects
 */

echo "🚀 Setting up CodeIgniter 4 with Shield Authentication\n\n";

// Get project details
$projectName = readline("Enter project name: ");
$dbName = strtolower(str_replace(' ', '_', $projectName));

echo "📦 Installing dependencies...\n";
exec('composer install');

echo "🔧 Setting up environment...\n";
if (!file_exists('.env')) {
    copy('env', '.env');
    echo "✅ Created .env file\n";
}

echo "🗄️ Creating database...\n";
exec("mysql -u root -e \"CREATE DATABASE IF NOT EXISTS {$dbName};\"");

echo "🔐 Setting up Shield authentication...\n";
exec('php spark shield:setup --force');

echo "📊 Running migrations...\n";
exec('php spark migrate');

echo "🎉 Setup complete!\n";
echo "Your CodeIgniter 4 project is ready!\n";
echo "Run 'php spark serve' to start the development server.\n";
echo "Access your application at: http://localhost:8080\n";
