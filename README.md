# Portfolio Website for Abebe Bihonegn

**Developer**: Abebe Bihonegn  
**Updated**: May 13, 2025  
**Bootstrap Version**: 5.3.3  
**Author**: Abebe  

## Overview

This is a personal portfolio website showcasing the skills, projects, and contact information of Abebe Bihonegn, a software engineer. The site includes user authentication features (registration, login, email verification, password reset) and supports multiple languages (English, Amharic, Afan Oromo, Tigrinya, Persian) with RTL for Persian.

## Features

- Responsive design with Bootstrap 5.3.3.
- Multilingual support with session-based language persistence.
- User authentication with CSRF protection.
- Email verification and password reset using PHPMailer.
- AOS animations and Bootstrap Icons.
- Docker-compatible session storage.
- SEO-friendly with hreflang links and meta tags.
- Accessible forms with ARIA attributes.

## Directory Structure

- `about.php`: About page.
- `config.php`: Configuration for database, SMTP, and app domain.
- `contact.php`: Contact form page.
- `forgot-password.php`: Password reset request page.
- `index.php`: Homepage.
- `login.php`: User login page.
- `portfolio-details.php`: Detailed view of portfolio projects.
- `portfolio.php`: Portfolio overview page.
- `register.php`: User registration page.
- `reset-password.php`: Password reset form.
- `resume.php`: Resume page.
- `verify.php`: Email verification page.
- `assets/`: CSS, JS, images (`vendor/bootstrap`, `vendor/aos`, `css/main.css`, `js/main.js`, `img/favicon.png`, `img/apple-touch-icon.png`, `img/login.png`, `img/main.png`).
- `lang/`: Translation files (if separate from PHP).
- `sessions/`: Session storage directory.
- `vendor/`: Composer dependencies (PHPMailer).
- `composer.json`, `composer.lock`: Composer configuration.

## Prerequisites

- PHP 8.0+ with extensions: `mysqli`, `openssl`, `filter`.
- MySQL/MariaDB 5.7+.
- Composer for dependency management.
- SMTP service (e.g., Gmail, SendGrid) for email sending.
- Web server (Apache/Nginx) with PHP support.
- Docker (optional) for session storage compatibility.
- Write permissions for `/tmp` or `sessions/` directory.

## Setup Instructions

1. **Clone the Project**
   ```bash
   git clone https://github.com/AbebeQ/portfolio-website.git
   cd portfolio-website


Install DependenciesInstall PHPMailer via Composer:
composer install


Configure Environment

Copy config.php.example (if available) to config.php or create config.php:<?php
define('DB_CONFIG', [
    'servername' => 'localhost',
    'username' => 'your_username',
    'password' => 'your_password',
    'database' => 'portfolio_db'
]);
define('SMTP_HOST', 'smtp.example.com');
define('SMTP_USERNAME', 'your_email@example.com');
define('SMTP_PASSWORD', 'your_smtp_password');
define('SMTP_PORT', 587);
define('APP_DOMAIN', 'http://yourdomain.com');
?>


Replace placeholders with your database and SMTP credentials.
Ensure APP_DOMAIN matches your domain (no trailing slash).


Set Up Database

Create a MySQL database (e.g., portfolio_db).
Import the following schema:CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    verification_code VARCHAR(6),
    code_expires_at DATETIME,
    is_verified TINYINT(1) DEFAULT 0
);


Update config.php with database credentials.


Configure Sessions

Ensure /tmp or sessions/ is writable:sudo chmod -R 777 sessions/


For Docker, verify session.save_path is set to /tmp in PHP files.


Set Up Web Server

Point your web server (Apache/Nginx) to the project root.
Example Apache virtual host:<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /var/www/portfolio
    <Directory /var/www/portfolio>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>


Restart the server:sudo systemctl restart apache2




Verify Assets

Ensure assets/ contains:
vendor/bootstrap/css/bootstrap.min.css
vendor/bootstrap-icons/bootstrap-icons.css
css/main.css
vendor/bootstrap/js/bootstrap.bundle.min.js
vendor/aos/aos.js
js/main.js
img/favicon.png
img/apple-touch-icon.png
img/login.png
img/main.png


If missing, copy from a Bootstrap 5.3.3 distribution or re-download.



Usage

Access the Website

Open http://yourdomain.com in a browser.
Navigate to pages (Home, About, Resume, Portfolio, Contact).


User Authentication

Register at /register.php.
Verify email via link sent to your inbox (check spam).
Log in at /login.php.
Use /forgot-password.php and /reset-password.php for password recovery.


Language Switching

Select language from the navigation dropdown or form dropdowns.
Supported languages: English, Amharic, Afan Oromo, Tigrinya, Persian.
Persian uses RTL layout.


Testing

Test registration, login, and email verification.
Verify RTL rendering for Persian.
Check responsive design on mobile devices.



Notes

Multilingual Support: Translations are embedded in PHP files using a translate() function. Add new languages by extending the translation arrays.
RTL: Persian (fa) uses dir="rtl" and custom CSS for right-to-left text.
Security: CSRF tokens protect forms. Passwords are hashed with password_hash().
Email: Configure SMTP in config.php. Test email sending locally with a service like Mailtrap.
Assets: main.js handles mobile navigation and AOS animations. Ensure it loads correctly.

Troubleshooting

Database Connection Error: Check config.php credentials and MySQL service status.
Email Not Sending: Verify SMTP settings and firewall/port access (e.g., port 587).
Session Issues: Ensure sessions/ or /tmp is writable. Check PHP session.save_path.
404 Errors: Confirm .htaccess or web server rewrite rules are enabled.
RTL Issues: Inspect CSS for Persian (fa) and ensure dir="rtl" is applied.

Contact
For issues or contributions, contact Abebe Bihonegn:

Email: [your-email@example.com]
LinkedIn: https://www.linkedin.com/in/abebe-bihonegn
Telegram: https://t.me/bihonegn2112

License
© 2025 Abebe Bihonegn. All Rights Reserved.
Portfolio Screenshots
Homepage:
Login Page:
General Screenshot:```
