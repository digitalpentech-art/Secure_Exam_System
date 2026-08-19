# Secure Examination System - Installation Guide

This project is a Laravel-based Secure Examination System. Follow these steps to set up the application in your local environment.

## 1. System Requirements
- **PHP** >= 8.2 (with SQLite extension enabled)
- **Composer** (PHP dependency manager)
- **Node.js** & **NPM** (Frontend asset compilation)
- **Git**

## 2. Installation Steps

### Step 1: Clone the Repository
```bash
git clone https://github.com/digitalpentech-art/Secure_Exam_System.git
cd Secure_Exam_System
```

### Step 2: Configure Environment
Copy the example environment file and configure it:
```bash
cp .env.example .env
```
*(On Windows, use `copy .env.example .env`)*

### Step 3: Create the SQLite Database
Ensure the database file exists:
- **Linux/macOS**: `touch database/database.sqlite`
- **Windows**: `type nul > database\database.sqlite`

### Step 4: Install Dependencies
Install both PHP and JavaScript dependencies:
```bash
composer install
npm install
npm run build
```

### Step 5: Initialize Application
Generate the application key and set up the database structure:
```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
```

### Step 6: Start the Server
Run the application locally:
```bash
php artisan serve
```
Access the application at `http://127.0.0.1:8000`.

---

## Further Information
- **Windows Setup**: See `docs/WINDOWS_GIT_GUIDE.md` for platform-specific Git and setup details.
- **Security**: Never commit your `.env` file or `database/database.sqlite` to version control.
