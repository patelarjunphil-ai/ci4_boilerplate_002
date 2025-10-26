# CodeIgniter 4 Boilerplate

This is a starter boilerplate for CodeIgniter 4 projects, designed to provide a solid foundation for new applications. It includes a variety of pre-configured features to help you get up and running quickly.

## Getting Started

### Prerequisites

-   PHP 8.1 or higher
-   Composer
-   SQLite3 PHP Extension

### Installation

1.  **Clone the repository:**
    ```bash
    git clone <repository_url>
    ```

2.  **Navigate to the project directory:**
    ```bash
    cd ci4_boilerplate
    ```

3.  **Install dependencies:**
    ```bash
    composer install
    ```

4.  **Copy the environment file:**
    ```bash
    cp env .env
    ```

5.  **Run the database migrations:**
    ```bash
    php spark migrate
    ```

6.  **Start the development server:**
    ```bash
    php spark serve
    ```

The application will be available at `http://localhost:8080`.

## Features

### Authentication (Shield)

This boilerplate uses [CodeIgniter Shield](https://shield.codeigniter.com/) for authentication. It has been configured to use custom views for login and registration.

-   **Login View:** `app/Views/auth/login.php`
-   **Registration View:** `app/Views/auth/register.php`

The authentication routes are automatically handled by Shield. You can view them by running `php spark routes`.

### User Roles and Permissions

User roles (Groups) and permissions are defined in the `app/Config/AuthGroups.php` file. You can easily add, remove, or modify groups and permissions in this file.

**Example Group:**

```php
'admin' => [
    'title'       => 'Admin',
    'description' => 'Administrators of the site.',
],
```

**Example Permission:**

```php
'admin.access' => 'Can access the sites admin area',
```

The `permission` filter is used in the `app/Config/Routes.php` file to protect routes.

**Example Route Protection:**

```php
$routes->group('admin', ['filter' => 'permission:admin.access'], function ($routes) {
    // Admin routes here
});
```

### User Management (Manual CRUD)

A manual CRUD (Create, Read, Update, Delete) implementation for managing users is included. You can access it at `/admin/users`.

-   **Controller:** `app/Controllers/Admin/Users.php`
-   **Model:** `app/Models/UserModel.php`
-   **Views:** `app/Views/admin/users/`

This feature is protected by the `admin.access` permission.

### Custom Settings Library

A custom, database-driven settings library is included. It uses the `site_settings` table to store key-value pairs.

**Service:** `App\Services\SettingsService`

You can access the settings service from anywhere in your application using the `service()` helper:

**Get a setting:**

```php
$siteName = service('settings')->get('site_name', 'My Awesome Site');
```

**Set a setting:**

```php
service('settings')->set('site_name', 'My New Site Name');
```

### Custom Navigation Library

A custom, permission-aware navigation library is included. It builds a navigation menu based on the user's roles and permissions.

**View Cell:** `App\Cells\NavbarCell`

The navigation links are stored in the `navigation_links` table. The `permission_key` column is used to determine if a user can see a particular link.

You can use the `NavbarCell` in your layout files to display the navigation menu:

```php
<?= view_cell('App\Cells\NavbarCell') ?>
```

### Starter Modules

#### Reports

A starter module for reports is included at `/admin/reports`. It includes a simple example of how to use Chart.js to display data from the database.

-   **Controller:** `app/Controllers/Admin/Reports.php`
-   **View:** `app/Views/admin/reports/overview.php`

This feature is protected by the `admin.access` permission.

#### Point of Sale (POS)

A starter module for a Point of Sale system is included at `/pos`. This is a placeholder and does not contain any functionality.

-   **Controller:** `app/Controllers/POS.php`

This feature is protected by the `pos.use` permission.
