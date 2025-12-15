# 📘 Panduan Instalasi KidsLearn - Langkah demi Langkah

Dokumen ini memberikan panduan instalasi yang lebih detail dan lengkap untuk project KidsLearn.

## 📋 Daftar Isi

1. [Persiapan Environment](#persiapan-environment)
2. [Instalasi Project](#instalasi-project)
3. [Konfigurasi Database](#konfigurasi-database)
4. [Setup Assets](#setup-assets)
5. [Testing Aplikasi](#testing-aplikasi)
6. [Troubleshooting](#troubleshooting)

---

## 1. Persiapan Environment

### 1.1 Install PHP 8.2 atau lebih tinggi

**Windows (dengan Laragon):**

-   Download Laragon dari [https://laragon.org/download/](https://laragon.org/download/)
-   Install Laragon Full
-   Pastikan PHP versi 8.2 atau lebih tinggi sudah aktif

**Cek versi PHP:**

```bash
php -v
```

Output yang diharapkan:

```
PHP 8.2.x (cli) ...
```

### 1.2 Install Composer

**Cek apakah Composer sudah terinstall:**

```bash
composer --version
```

**Jika belum terinstall:**

-   Download dari [https://getcomposer.org/download/](https://getcomposer.org/download/)
-   Install dan pastikan masuk ke PATH environment

### 1.3 Install Node.js dan NPM

**Cek versi Node.js:**

```bash
node -v
npm -v
```

**Jika belum terinstall:**

-   Download dari [https://nodejs.org/](https://nodejs.org/)
-   Install versi LTS (Long Term Support)

---

## 2. Instalasi Project

### 2.1 Navigasi ke Folder Laragon

```bash
cd c:\laragon\www\duolingo-abc\kidslearn-laravel
```

### 2.2 Install Dependencies PHP

```bash
composer install
```

**Catatan:** Proses ini akan memakan waktu beberapa menit.

### 2.3 Install Dependencies JavaScript

```bash
npm install
```

### 2.4 Setup File Environment

```bash
copy .env.example .env
```

### 2.5 Generate Application Key

```bash
php artisan key:generate
```

Output yang diharapkan:

```
Application key set successfully.
```

---

## 3. Konfigurasi Database

### Pilihan 1: SQLite (Rekomendasi untuk Development)

SQLite sudah dikonfigurasi secara default. Anda tidak perlu melakukan perubahan apapun.

**Jalankan migration:**

```bash
php artisan migrate
```

**Jalankan seeder:**

```bash
php artisan db:seed
```

### Pilihan 2: MySQL/MariaDB

#### 3.1 Buat Database

**Buka HeidiSQL atau phpMyAdmin** dan jalankan:

```sql
CREATE DATABASE kidslearn CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**Atau via command line:**

```bash
mysql -u root -p
```

Kemudian di MySQL prompt:

```sql
CREATE DATABASE kidslearn;
exit;
```

#### 3.2 Edit File .env

Buka file `.env` dan ubah konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kidslearn
DB_USERNAME=root
DB_PASSWORD=
```

**Catatan:** Sesuaikan `DB_PASSWORD` dengan password MySQL Anda.

#### 3.3 Jalankan Migration dan Seeder

```bash
php artisan migrate
php artisan db:seed
```

---

## 4. Setup Assets

### 4.1 Copy Assets dari Project Lama

Jika Anda memiliki project lama dengan assets (gambar, suara, dll):

```bash
# Copy images
xcopy /E /I /Y ..\duolingo-abc\img public\img

# Copy sounds
xcopy /E /I /Y ..\duolingo-abc\sound public\sound

# Copy CSS (optional, untuk referensi)
xcopy /E /I /Y ..\duolingo-abc\css public\css
```

### 4.2 Struktur Folder Assets

Pastikan struktur folder assets seperti ini:

```
public/
├── img/
│   ├── mascot-login.png
│   ├── mascot-regis.png
│   ├── mascot-learn.png
│   ├── mascot_learning.png
│   ├── avatar1.png
│   ├── avatar2.png
│   ├── avatar3.png
│   ├── avatar4.png
│   ├── avatar5.png
│   ├── avatar6.png
│   ├── dog1.png
│   ├── elephant.png
│   ├── kucing.png
│   ├── cow.png
│   ├── taman.jpg
│   ├── anomali.png
│   ├── mammals.png
│   ├── birds.png
│   ├── fish.png
│   ├── insect.png
│   ├── reptile.png
│   ├── amphibi.png
│   ├── ig.png
│   ├── twt.png
│   └── fb.png
└── sound/
    ├── dog.mp3
    ├── Elephant.mp3
    ├── cat.mp3
    └── cow.mp3
```

### 4.3 Compile Assets

```bash
# Development mode
npm run dev

# Production mode
npm run build
```

---

## 5. Testing Aplikasi

### 5.1 Jalankan Development Server

```bash
php artisan serve
```

Output yang diharapkan:

```
INFO  Server running on [http://127.0.0.1:8000]
```

### 5.2 Akses Aplikasi

Buka browser dan akses: `http://localhost:8000`

### 5.3 Login dengan Akun Demo

**Akun 1:**

-   Nama: `Budi`
-   Password: `password123`

**Akun 2:**

-   Nama: `Siti`
-   Password: `password123`

### 5.4 Test Fitur-Fitur

1. ✅ Register akun baru
2. ✅ Login
3. ✅ Lihat dashboard
4. ✅ Akses learning module
5. ✅ Mainkan quiz
6. ✅ Logout

---

## 6. Troubleshooting

### Problem 1: composer install gagal

**Error:**

```
Your requirements could not be resolved to an installable set of packages.
```

**Solusi:**

```bash
composer update
composer install
```

### Problem 2: npm install gagal

**Error:**

```
npm ERR! code ENOENT
```

**Solusi:**

```bash
# Hapus node_modules dan package-lock.json
rmdir /s /q node_modules
del package-lock.json

# Install ulang
npm install
```

### Problem 3: Migration gagal

**Error:**

```
SQLSTATE[HY000] [1049] Unknown database 'kidslearn'
```

**Solusi:**

```bash
# Buat database terlebih dahulu
mysql -u root -p
CREATE DATABASE kidslearn;
exit;

# Atau gunakan SQLite
php artisan migrate --database=sqlite
```

### Problem 4: Assets tidak muncul

**Solusi:**

```bash
# Create symbolic link untuk storage
php artisan storage:link

# Compile assets
npm run build

# Clear cache
php artisan cache:clear
php artisan view:clear
```

### Problem 5: Error 419 - CSRF Token Mismatch

**Solusi:**

```bash
# Clear config cache
php artisan config:clear

# Clear route cache
php artisan route:clear

# Reload browser dengan Ctrl+F5
```

### Problem 6: Class not found

**Error:**

```
Class 'App\Models\User' not found
```

**Solusi:**

```bash
composer dump-autoload
php artisan clear-compiled
php artisan cache:clear
```

### Problem 7: Permission denied (Linux/Mac)

**Solusi:**

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### Problem 8: Port 8000 sudah digunakan

**Solusi:**

```bash
# Gunakan port lain
php artisan serve --port=8001

# Atau matikan aplikasi yang menggunakan port 8000
```

---

## 🔄 Update Project

Jika project sudah terinstall dan Anda ingin update:

```bash
# Pull latest code
git pull origin main

# Update dependencies
composer install
npm install

# Run migration baru (jika ada)
php artisan migrate

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Recompile assets
npm run build
```

---

## 🧪 Testing Environment

### Cek PHP Extensions

```bash
php -m
```

Extensions yang diperlukan:

-   OpenSSL
-   PDO
-   Mbstring
-   Tokenizer
-   XML
-   Ctype
-   JSON
-   BCMath

### Cek Laravel Installation

```bash
php artisan --version
```

### Cek Database Connection

```bash
php artisan tinker
```

Di Tinker prompt:

```php
DB::connection()->getPdo();
exit;
```

Jika berhasil, akan muncul object PDO.

---

## 📊 Database Seeder Detail

### Data yang di-seed:

**Users (2 akun):**

1. Budi - password123
2. Siti - password123

**Animals (13 hewan):**

-   4 Mammals (Dog, Elephant, Cat, Cow)
-   2 Birds (Eagle, Parrot)
-   2 Sea Animals (Dolphin, Shark)
-   2 Insects (Butterfly, Ant)
-   2 Reptiles (Snake, Crocodile)
-   1 Amphibian (Frog)

**Quiz Questions (4 pertanyaan):**

-   Pertanyaan tentang Mammals
-   Pertanyaan tentang Birds
-   Pertanyaan tentang Sea Animals

### Re-seed Database

Jika ingin reset database dan seed ulang:

```bash
# Fresh migration (hapus semua data)
php artisan migrate:fresh

# Seed ulang
php artisan db:seed

# Atau sekaligus
php artisan migrate:fresh --seed
```

---

## 🚀 Production Checklist

Sebelum deploy ke production:

-   [ ] Set `APP_ENV=production` di `.env`
-   [ ] Set `APP_DEBUG=false` di `.env`
-   [ ] Generate production key: `php artisan key:generate`
-   [ ] Configure production database
-   [ ] Run: `composer install --optimize-autoloader --no-dev`
-   [ ] Run: `php artisan config:cache`
-   [ ] Run: `php artisan route:cache`
-   [ ] Run: `php artisan view:cache`
-   [ ] Run: `npm run build`
-   [ ] Set file permissions: `chmod -R 755 storage bootstrap/cache`
-   [ ] Setup HTTPS/SSL
-   [ ] Configure web server (Apache/Nginx)
-   [ ] Setup backup database
-   [ ] Setup monitoring

---

## 📞 Bantuan Lebih Lanjut

Jika Anda mengalami masalah yang tidak tercantum di sini:

1. Baca dokumentasi Laravel: [https://laravel.com/docs](https://laravel.com/docs)
2. Check Laravel error log di `storage/logs/laravel.log`
3. Gunakan `php artisan tinker` untuk debugging
4. Create issue di repository GitHub

---

**Selamat! Aplikasi KidsLearn berhasil diinstall! 🎉**

_Jika Anda mengalami masalah, jangan ragu untuk bertanya._
