<?php
/**
 * CodeIgniter 4 Boilerplate Setup Script
 * Automates the setup process for this boilerplate project.
 */

echo "🚀 Setting up CodeIgniter 4 with Shield Authentication\n\n";

// 1. Check Environment
echo "🔍 Running environment check...\n";
passthru('php check_env.php', $env_check_status);
if ($env_check_status !== 0) {
    echo "\n❌ Environment check failed. Please fix the issues above and try again.\n";
    exit(1);
}
echo "✅ Environment looks good.\n\n";

// 2. Get Database Name
$dbName = readline("Enter the name for your new database (e.g., my_project_db): ");
if (empty($dbName)) {
    echo "❌ Database name cannot be empty.\n";
    exit(1);
}
$dbName = strtolower(str_replace(' ', '_', $dbName));

// 3. Setup .env file
echo "🔧 Setting up .env file...\n";
if (!file_exists('.env')) {
    $envContent = file_get_contents('env');
    if ($envContent === false) {
        echo "❌ Could not read 'env' file.\n";
        exit(1);
    }
    // Replace database placeholder
    $envContent = str_replace('your_database_name', $dbName, $envContent);
    file_put_contents('.env', $envContent);
    echo "✅ Created .env file and set database name to '{$dbName}'.\n";
} else {
    echo "ℹ️ .env file already exists. Skipping creation.\n";
}

// 4. Install Composer Dependencies
echo "📦 Installing Composer dependencies...\n";
passthru('composer install');
echo "\n";

// 5. Generate Encryption Key
echo "🔑 Generating application key...\n";
passthru('php spark key:generate');
echo "\n";

// 6. Create Database
echo "🗄️ Creating database '{$dbName}'...\n";
$dbUser = readline("Enter database username (default: root): ") ?: 'root';
$dbPass = readline("Enter database password (leave blank for none): ");
$mysqlCommand = "mysql -u {$dbUser}" . (!empty($dbPass) ? " -p{$dbPass}" : "") . " -e \"CREATE DATABASE IF NOT EXISTS \`{$dbName}\`;\"";
passthru($mysqlCommand, $db_status);
if ($db_status !== 0) {
    echo "❌ Failed to create database. Please check your credentials and ensure MySQL is running.\n";
    exit(1);
}
echo "✅ Database created successfully.\n\n";

// 7. Run Shield Setup
echo "🛡️ Setting up Shield authentication...\n";
passthru('php spark shield:setup');
echo "\n";

// 7. Run Migrations
echo "📊 Running database migrations...\n";
passthru('php spark migrate');
echo "\n";

echo "🌱 Seeding database with initial data...\n";
passthru('php spark db:seed SiteSettingsSeeder');
passthru('php spark db:seed UserGroupsAndPermissionsSeeder');
echo "\n";

echo "🎉 Setup complete! Your project is ready.\n";
echo "------------------------------------------\n";
echo "To start the server, run: php spark serve\n";
echo "Access your application at: http://localhost:8080\n";
