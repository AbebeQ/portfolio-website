# Portfolio Website for Abebe Bihonegn

Developer: Abebe Bihonegn
Updated: May 13, 2025
Bootstrap Version: 5.3.3
Author: Abebe

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

- about.php: About page.
- config.php: Configuration for database, SMTP, and app domain.
- contact.php: Contact form page.
- forgot-password.php: Password reset request page.
- index.php: Homepage.
- login.php: User login page.
- portfolio-details.php: Detailed view of portfolio projects.
- portfolio.php: Portfolio overview page.
- register.php: User registration page.
- reset-password.php: Password reset form.
- resume.php: Resume page.
- verify.php: Email verification page.
- assets/: CSS, JS, images (vendor/bootstrap, vendor/aos, css/main.css, js/main.js, img/favicon.png, img/apple-touch-icon.png).
- lang/: Translation files (if separate from PHP).
- sessions/: Session storage directory.
- vendor/: Composer dependencies (PHPMailer).
- composer.json, composer.lock: Composer configuration.

## Prerequisites

- PHP 8.0+ with extensions: mysqli, openssl, filter.
- MySQL/MariaDB 5.7+.
- Composer for dependency management.
- SMTP service (e.g., Gmail, SendGrid) for email sending.
- Web server (Apache/Nginx) with PHP support.
- Docker (optional) for session storage compatibility.
- Write permissions for /tmp or sessions/ directory.

## Setup Instructions

1. **Clone the Project**
