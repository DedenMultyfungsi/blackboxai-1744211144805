
Built by https://www.blackbox.ai

---

```markdown
# School Exam System

## Project Overview
The **School Exam System** is a web application designed to facilitate the registration of users, management of exams, and the evaluation of student performance. This system supports both students and teachers, allowing teachers to create and manage exams, while students can register, take exams, and view their results.

## Installation

### Requirements
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- Composer (for PHP dependencies)

### Installation Steps

1. **Database Setup**
   Execute the following command in your MySQL console:
   ```bash
   mysql -u root -p < database.sql
   ```

2. **Configure Database Connection**
   Edit `config.php` with your database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password'); 
   define('DB_NAME', 'school_exam');
   ```

3. **Web Server Configuration**
   - Set the document root to the project directory.
   - Ensure `mod_rewrite` is enabled (for clean URLs).
   - Configure proper file permissions:
   ```bash
   chmod -R 755 storage/
   chown -R www-data:www-data .
   ```

4. **Access the Application**
   Open in your browser: `http://localhost:8000`. 
   - First, register a teacher account.
   - Then log in to access the system.

### First-Time Setup
1. Register a teacher account.
2. Create exams and questions.
3. Register student accounts.
4. Students can now take exams.

### Development Server
For testing, you can use PHP's built-in server:
```bash
php -S localhost:8000
```

### Troubleshooting
- Check PHP error logs if pages don't load.
- Verify the database connection in `config.php`.
- Ensure all files are in the web root directory.

## Usage
- **User Registration**: Users can register as either students or teachers.
- **Login/Logout**: Users can log in to access their dashboards.
- **Exam Management**: Teachers can create exams and add questions.
- **Taking Exams**: Students can attempt the exams assigned to them.
- **Results Review**: Users can view their scores and performance analytics.

## Features
- User registration and authentication.
- Role-based access for teachers and students.
- Creation and management of exams and questions by teachers.
- Score calculation and result display for students.
- User-friendly interface designed with TailwindCSS.

## Dependencies
This project does not have an explicit `package.json` for Node.js dependencies. PHP is the primary technology used, and dependencies such as database connections and session management are handled within the PHP files.

## Project Structure
```
├── config.php               # Database configuration and connection management
├── auth.php                 # User registration and authentication functions
├── index.php                # Main entry point (landing page)
├── login.php                # User login page
├── register.php             # User registration page
├── dashboard.php            # User dashboard with role-specific options
├── logout.php               # User logout handler
├── exam_functions.php       # Functions for managing exams and questions
├── admin.php                # Admin interface for teachers to manage exams
├── exam_edit.php            # Page for editing exam questions
├── exam.php                 # Page for students to take exams
├── results.php              # Page for displaying exam results
├── navbar.php               # Navigation bar component
├── INSTALL.md               # Installation guide
```

For detailed functionality and customization, refer to the code comments within the PHP files and the `INSTALL.md`.

## Contributing
If you would like to contribute to this project, feel free to fork the repository and submit a Pull Request with your enhancements or bug fixes.

## License
This project is open-source and available under the MIT License. Please feel free to use and modify it as you wish.
```