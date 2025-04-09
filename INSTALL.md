# School Exam System Installation Guide

## Requirements
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- Composer (for PHP dependencies)

## Installation Steps

1. **Database Setup**
```bash
mysql -u root -p < database.sql
```

2. **Configure Database Connection**
Edit `config.php` with your database credentials:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password'); 
define('DB_NAME', 'school_exam_system');
```

3. **Web Server Configuration**
- Set document root to the project directory
- Ensure mod_rewrite is enabled (for clean URLs)
- Configure proper file permissions:
```bash
chmod -R 755 storage/
chown -R www-data:www-data .
```

4. **Access the Application**
- Open in browser: http://localhost:8000
- First register a teacher account
- Then login to access the system

## First-Time Setup
1. Register a teacher account
2. Create exams and questions
3. Register student accounts
4. Students can now take exams

## Development Server
For testing, you can use PHP's built-in server:
```bash
php -S localhost:8000
```

## Troubleshooting
- Check PHP error logs if pages don't load
- Verify database connection in config.php
- Ensure all files are in the web root directory
