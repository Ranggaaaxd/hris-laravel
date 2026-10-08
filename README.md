# HRIS Laravel

Human Resource Information System built with Laravel and MySQL.

## Technology Stack

* Laravel
* PHP
* MySQL
* Blade
* Tailwind CSS
* Alpine.js
* Git
* GitHub

## Requirements

* PHP >= 8.2
* Composer
* Node.js & NPM
* MySQL Server (MariaDB / MySQL 8+)
* Git

## Development

Cara menjalankan project secara lokal:

1. Clone repository:
   ```bash
   git clone <repository-url>
   cd hris-laravel
   ```
2. Install Composer dependencies:
   ```bash
   composer install
   ```
3. Install NPM dependencies:
   ```bash
   npm install
   ```
4. Salin file environment:
   ```bash
   cp .env.example .env
   ```
5. Konfigurasi database di file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=hris
   DB_USERNAME=your_mysql_username
   DB_PASSWORD=your_mysql_password
   ```
6. Generate application key:
   ```bash
   php artisan key:generate
   ```
7. Jalankan migration database:
   ```bash
   php artisan migrate
   ```
8. Build frontend assets (atau jalankan dev server vite):
   ```bash
   npm run build
   # atau untuk mode development:
   npm run dev
   ```
9. Jalankan Laravel development server:
   ```bash
   php artisan serve
   ```
10. Akses aplikasi di browser melalui `http://127.0.0.1:8000`.
