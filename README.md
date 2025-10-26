# CodeIgniter 4 Boilerplate with Shield Authentication

A complete, ready-to-use CodeIgniter 4 boilerplate with Shield authentication, admin panel, and POS system.

## 🚀 Features

- **CodeIgniter 4.6.3** - Latest stable version
- **Shield Authentication** - Complete user authentication system
- **Admin Panel** - User management and reports
- **POS System** - Point of Sale functionality
- **Database Migrations** - Pre-configured database structure
- **Custom Views** - Modern, responsive UI components
- **Settings Management** - Configurable application settings

## 📋 Prerequisites

- PHP 8.1 or higher
- MySQL 5.7+ or MariaDB 10.3+
- Composer
- XAMPP (recommended for Windows)

## 🛠️ Installation

### Quick Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/patelarjunphil-ai/ci4_boilerplate_002.git my_project
   cd my_project
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Setup environment**
   ```bash
   cp env .env
   # Edit .env file with your database settings
   ```

4. **Generate encryption key**
   ```bash
   php spark key:generate
   ```
   Copy the output and paste it into your `.env` file.

5. **Create database**
   ```bash
   mysql -u root -e "CREATE DATABASE my_project;"
   ```

6. **Run Shield setup and database migrations**
   ```bash
   php spark shield:setup
   php spark migrate
   ```

7. **Start development server**
   ```bash
   php spark serve
   ```

### Automated Setup (Windows)

Run the provided batch file:
```bash
setup_new_ci4.bat
```

## ⚙️ Configuration

### Environment Variables (.env)

```env
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'
database.default.hostname = localhost
database.default.database = your_database_name
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.port = 3306
encryption.key = your_encryption_key_here
```

### Database Configuration

The boilerplate includes these database tables:
- `users` - User accounts
- `auth_identities` - Authentication identities
- `auth_logins` - Login attempts
- `auth_groups_users` - User groups
- `auth_permissions_users` - User permissions
- `site_settings` - Application settings
- `navigation_links` - Navigation menu

## 🎯 Usage

### Accessing the Application

- **Main Application**: `http://localhost:8080`
- **Admin Panel**: `http://localhost:8080/admin`
- **POS System**: `http://localhost:8080/pos`

### Creating Users

1. Register a new user at `/register`
2. Assign admin permissions via database or admin panel
3. Access admin features at `/admin`

### Customization

- **Controllers**: Add new controllers in `app/Controllers/`
- **Views**: Modify views in `app/Views/`
- **Models**: Create models in `app/Models/`
- **Migrations**: Add database migrations in `app/Database/Migrations/`

## 📁 Project Structure

```
ci4_boilerplate/
├── app/
│   ├── Controllers/          # Application controllers
│   │   ├── Admin/           # Admin panel controllers
│   │   ├── Home.php         # Home controller
│   │   └── POS.php          # POS system controller
│   ├── Views/               # View templates
│   │   ├── admin/           # Admin panel views
│   │   ├── auth/            # Authentication views
│   │   └── layout.php       # Main layout
│   ├── Models/              # Data models
│   ├── Database/            # Migrations and seeds
│   └── Config/              # Configuration files
├── public/                  # Web-accessible files
├── writable/                # Writable directories
└── vendor/                  # Composer dependencies
```

## 🔧 Available Commands

```bash
# Start development server
php spark serve

# Run database migrations
php spark migrate

# Create new migration
php spark make:migration CreateTableName

# Create new controller
php spark make:controller ControllerName

# Create new model
php spark make:model ModelName

# Setup Shield authentication
php spark shield:setup
```

## 🛡️ Security Features

- **Shield Authentication** - Secure authentication system
- **CSRF Protection** - Cross-site request forgery protection
- **Input Validation** - Comprehensive input validation
- **SQL Injection Prevention** - Parameterized queries
- **XSS Protection** - Output escaping

## 📊 Admin Features

- **User Management** - Create, edit, delete users
- **Reports** - System reports and analytics
- **Settings** - Application configuration
- **Navigation** - Menu management

## 🛒 POS System

- **Product Management** - Add, edit, delete products
- **Sales Processing** - Handle transactions
- **Inventory Tracking** - Stock management
- **Reports** - Sales reports and analytics

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 🆘 Support

For support and questions:
- Create an issue on GitHub
- Check the [CodeIgniter 4 documentation](https://codeigniter.com/user_guide/)
- Visit the [Shield documentation](https://codeigniter4.github.io/shield/)

## 🔄 Updates

To update your project:

```bash
git pull origin main
composer update
php spark migrate
```

---

**Happy Coding!** 🎉