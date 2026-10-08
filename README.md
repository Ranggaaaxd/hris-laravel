# HRIS Laravel

Human Resource Information System built with Laravel and MySQL.

## Technology Stack

* **Framework**: Laravel 12
* **Language**: PHP 8.2+
* **Database**: MySQL / MariaDB
* **Frontend**: Blade, Tailwind CSS, Alpine.js, Vite
* **Access Control**: Spatie Laravel Permission (RBAC)
* **Version Control**: Git & GitHub

## Requirements

* PHP >= 8.2 (extensions: `pdo_mysql`, `curl`, `mbstring`, `openssl`, `zip`)
* Composer
* Node.js & NPM
* MySQL Server (MariaDB / MySQL 8+)
* Git

## Development Setup

1. **Clone repository**:
   ```bash
   git clone https://github.com/Ranggaaaxd/hris-laravel.git
   cd hris-laravel
   ```

2. **Install Composer dependencies**:
   ```bash
   composer install
   ```

3. **Install NPM dependencies**:
   ```bash
   npm install
   ```

4. **Konfigurasi Environment**:
   Salin file `.env.example` ke `.env`:
   ```bash
   cp .env.example .env
   ```
   Sesuaikan konfigurasi database dan kredensial admin development:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=hris
   DB_USERNAME=your_mysql_username
   DB_PASSWORD=your_mysql_password

   # Kredensial Super Admin (Development)
   HRIS_ADMIN_EMAIL=admin@example.com
   HRIS_ADMIN_PASSWORD=your_secure_dev_password
   ```

5. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

6. **Jalankan Database Migration**:
   ```bash
   php artisan migrate
   ```

7. **Jalankan Database Seeder**:
   ```bash
   php artisan db:seed
   ```
   Perintah ini akan menjalankan `RoleAndPermissionSeeder` dan `SuperAdminSeeder` (serta akun sampel lokal untuk role lainnya).

8. **Build Frontend Assets**:
   ```bash
   npm run build
   # atau untuk mode live reload development:
   npm run dev
   ```

9. **Jalankan Laravel Server**:
   ```bash
   php artisan serve
   ```
   Akses aplikasi di browser pada: `http://127.0.0.1:8000`.

---

## Access Control & Roles Structure

Aplikasi menggunakan sistem Role-Based Access Control (RBAC) berbasis hak akses modular (`module.action`).

### Roles Awal

1. `super-admin`: Hak akses penuh ke seluruh modul sistem (bypass otorisasi).
2. `hr-admin`: Manajemen operasional HR (pengguna, role, izin, pengaturan).
3. `hr-staff`: Manajemen data pengguna terbatas dan dashboard.
4. `manager`: Akses dashboard manajerial.
5. `supervisor`: Akses dashboard supervisor.
6. `employee`: Akses portal karyawan standar.

### Permissions Awal

* **Dashboard**: `dashboard.view`
* **Users**: `users.view`, `users.create`, `users.update`, `users.delete`
* **Roles**: `roles.view`, `roles.create`, `roles.update`, `roles.delete`
* **Permissions**: `permissions.view`
* **Settings**: `settings.view`
* **Audit Logs**: `audit-logs.view`

### Matriks Otorisasi Awal

| Modul / Permission | Super Admin | HR Admin | HR Staff | Manager / Supervisor / Employee |
| :--- | :---: | :---: | :---: | :---: |
| `dashboard.view` | ✓ | ✓ | ✓ | ✓ |
| `users.view` | ✓ | ✓ | ✓ | - |
| `users.create` | ✓ | ✓ | - | - |
| `users.update` | ✓ | ✓ | - | - |
| `users.delete` | ✓ | - | - | - |
| `roles.view` | ✓ | ✓ | - | - |
| `roles.create` | ✓ | ✓ | - | - |
| `roles.update` | ✓ | ✓ | - | - |
| `roles.delete` | ✓ | - | - | - |
| `permissions.view` | ✓ | ✓ | - | - |
| `settings.view` | ✓ | ✓ | - | - |
| `audit-logs.view` | ✓ | - | - | - |

---

## Testing

Aplikasi dilengkapi automated feature dan unit tests:

```bash
php artisan test
```

Test mencakup skenario:
* Alur Login / Logout & Session Invalidation
* Proteksi Guest & User Nonaktif
* Hak Akses Super Admin & Non-admin (403 Forbidden)
* CRUD Pengguna & Proteksi Super Admin Terakhir
* CRUD Role & Proteksi Role Inti
* Tampilan Dashboard Berdasarkan Role
