@echo off
echo Setting up new CodeIgniter 4 project...

REM Get project name from user
set /p PROJECT_NAME="Enter project name: "

REM Create new project
composer create-project codeigniter4/appstarter %PROJECT_NAME%
cd %PROJECT_NAME%

REM Install Shield authentication
composer require codeigniter4/shield

REM Copy environment file
copy env .env

REM Install dependencies
composer install

REM Create database
echo Creating database...
mysql -u root -e "CREATE DATABASE IF NOT EXISTS %PROJECT_NAME%;"

REM Setup Shield
php spark shield:setup --force

REM Run migrations
php spark migrate

REM Start development server
echo Starting development server...
php spark serve

echo Setup complete! Your project is available at http://localhost:8080
pause
