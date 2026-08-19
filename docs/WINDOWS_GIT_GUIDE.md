# Secure Examination System - Windows Setup & Git Guide

This document covers setting up the project on Windows and guidelines for using Git.

## 1. Windows Development Setup (SQLite)

### Prerequisites
1.  **PHP**: Download and install [PHP for Windows](https://windows.php.net/download/). Ensure `php.exe` is in your system PATH.
2.  **Composer**: Download and install [Composer](https://getcomposer.org/download/).
3.  **Node.js/NPM**: Download and install [Node.js](https://nodejs.org/).
4.  **Git**: Download and install [Git for Windows](https://git-scm.com/).

### Installation
1.  **Clone the Repository**:
    ```bash
    git clone <repository-url>
    cd Secure-Examination-System
    ```
2.  **Setup Environment**:
    ```bash
    copy .env.example .env
    ```
3.  **Create SQLite Database**:
    ```bash
    type nul > database\database.sqlite
    ```
4.  **Install Dependencies**:
    ```bash
    composer install
    npm install
    npm run build
    ```
5.  **Generate Key & Migrate**:
    ```bash
    php artisan key:generate
    php artisan migrate
    php artisan db:seed
    ```
6.  **Start Server**:
    ```bash
    php artisan serve
    ```

---

## 2. Git Workflow & GitHub Pushing

To ensure the project remains stable and data is not lost:

### Crucial: Database Protection
**NEVER commit your database file.** It is ignored by default in the `.gitignore` file, but ensure it stays that way.
*   Check that `.gitignore` contains `database/*.sqlite`.

### Standard Workflow
1.  **Pull latest changes** (to avoid conflicts):
    ```bash
    git pull origin main
    ```
2.  **Stage your changes**:
    Only stage the files you modified. Do not use `git add .` unless you have verified the staged files list.
    ```bash
    git status
    git add path/to/changed/file.php
    ```
3.  **Commit with descriptive message**:
    ```bash
    git commit -m "feat: add reset functionality to lecturer dashboard"
    ```
4.  **Push to GitHub**:
    ```bash
    git push origin main
    ```

### Best Practices
*   **Keep commits atomic**: One commit per logical change (e.g., one for UI, one for logic).
*   **Never run `migrate:fresh` or `migrate:refresh`** on production or shared databases; it destroys all data.
*   Always test locally before pushing to the main branch.
