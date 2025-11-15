# SPK Sistem - Laravel Project

Sistem pendukung keputusan (SPK) berbasis web yang dibangun dengan Laravel framework.

## 📋 Requirements

Sebelum memulai, pastikan Anda telah menginstall software berikut:

### Software yang Diperlukan:

1. **PHP** >= 8.1

    - Extensions yang diperlukan:
        - BCMath
        - Ctype
        - Fileinfo
        - JSON
        - Mbstring
        - OpenSSL
        - PDO
        - Tokenizer
        - XML

2. **Composer** (PHP Package Manager)

    - Download dari: https://getcomposer.org/

3. **Node.js** >= 16.x dan **npm** (atau **yarn**)

    - Download dari: https://nodejs.org/

4. **Database Server** (pilih salah satu):

    - MySQL >= 5.7
    - PostgreSQL >= 10
    - SQLite >= 3.8.8

5. **Web Server** (pilih salah satu):
    - Apache dengan mod_rewrite
    - Nginx
    - PHP Built-in Server (untuk development)

## 🚀 Cara Clone Repository

1. Clone repository ini menggunakan Git:

```bash
git clone <repository-url>
cd bigproject
```

Atau jika menggunakan SSH:

```bash
git clone git@github.com:username/bigproject.git
cd bigproject
```

## 📦 Instalasi

### 1. Install Dependencies PHP (Composer)

```bash
composer install
```

### 2. Setup Environment File

Copy file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Jika file `.env.example` tidak ada, buat file `.env` baru dan isi dengan konfigurasi berikut:

```env
APP_NAME="SPK Sistem"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bigproject
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
```

### 3. Generate Application Key

```bash
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=username_database_anda
DB_PASSWORD=password_database_anda
```

### 5. Buat Database

Buat database baru di MySQL/PostgreSQL:

```sql
CREATE DATABASE bigproject CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Atau untuk SQLite, cukup pastikan file database dapat ditulis oleh aplikasi.

### 6. Jalankan Migration

```bash
php artisan migrate
```

### 7. Install Dependencies Frontend (Node.js)

```bash
npm install
```

atau jika menggunakan yarn:

```bash
yarn install
```

## ▶️ Cara Menjalankan Project

### Development Mode

1. **Jalankan Laravel Development Server:**

```bash
php artisan serve
```

Server akan berjalan di: `http://localhost:8000`

2. **Jalankan Vite Development Server** (di terminal terpisah):

```bash
npm run dev
```

atau:

```bash
yarn dev
```

3. **Akses aplikasi di browser:**

Buka browser dan akses: `http://localhost:8000`

### Production Mode

1. **Build assets untuk production:**

```bash
npm run build
```

atau:

```bash
yarn build
```

2. **Optimize Laravel:**

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. **Jalankan server production** (sesuai dengan web server yang digunakan)

## 🔧 Konfigurasi Tambahan

### Membuat User Baru

Untuk membuat user baru, Anda bisa:

1. **Menggunakan Tinker:**

```bash
php artisan tinker
```

Kemudian jalankan:

```php
$user = new App\Models\User();
$user->nama = 'Nama Lengkap';
$user->username = 'username';
$user->email = 'email@example.com';
$user->password = Hash::make('password');
$user->save();
```

2. **Atau menggunakan Seeder** (jika ada)

```bash
php artisan db:seed
```

### Storage Link (jika menggunakan storage)

```bash
php artisan storage:link
```

## 📁 Struktur Project

```
bigproject/
├── app/                    # Application logic
│   ├── Http/
│   │   └── Controllers/    # Controllers
│   └── Models/             # Eloquent Models
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/            # Database seeders
├── public/                 # Public assets
├── resources/
│   ├── views/              # Blade templates
│   ├── css/               # CSS files
│   └── js/                # JavaScript files
├── routes/
│   └── web.php            # Web routes
├── .env                   # Environment configuration
└── composer.json          # PHP dependencies
```

## 🛠️ Teknologi yang Digunakan

-   **Backend:**

    -   Laravel 10.x
    -   PHP 8.1+

-   **Frontend:**

    -   Tailwind CSS 3.x
    -   Alpine.js 3.x
    -   Font Awesome 6.4.0 (via CDN)
    -   Vite (Build Tool)

-   **Database:**
    -   MySQL/PostgreSQL/SQLite

## 📝 Routes yang Tersedia

-   `/` - Login page
-   `/login` - Login page
-   `/register` - Register page
-   `/dashboard` - Dashboard (requires authentication)
-   `/user-detail` - User profile detail (requires authentication)
-   `/user-detail/edit` - Edit profile (requires authentication)
-   `/input-data` - Input data page (requires authentication)
-   `/perhitungan` - Calculation page (requires authentication)
-   `/result` - Result page (requires authentication)

## 🔐 Authentication

Aplikasi menggunakan Laravel's built-in authentication. User harus:

1. Register akun baru di `/register`
2. Login di `/login`
3. Setelah login, akan diarahkan ke `/dashboard`

## 🐛 Troubleshooting

### Error: "Class 'PDO' not found"

-   Install PHP PDO extension: `sudo apt-get install php-pdo php-mysql`

### Error: "Vite manifest not found"

-   Jalankan `npm run dev` atau `npm run build`

### Error: "SQLSTATE[HY000] [2002] Connection refused"

-   Pastikan database server berjalan
-   Periksa konfigurasi database di file `.env`

### Error: "The stream or file could not be opened"

-   Pastikan folder `storage/logs` dan `storage/framework` memiliki permission write:
    ```bash
    chmod -R 775 storage bootstrap/cache
    ```

### Assets tidak ter-load

-   Pastikan Vite dev server berjalan: `npm run dev`
-   Atau build assets: `npm run build`

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👥 Contributing

Jika Anda ingin berkontribusi pada project ini, silakan:

1. Fork repository
2. Buat branch baru untuk fitur Anda
3. Commit perubahan Anda
4. Push ke branch
5. Buat Pull Request

## 📞 Support

Untuk pertanyaan atau bantuan, silakan buat issue di repository ini.
