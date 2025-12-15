# KidsLearn - Aplikasi Pembelajaran Anak-Anak

![Laravel](https://img.shields.io/badge/Laravel-12.x-red)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue)
![License](https://img.shields.io/badge/License-MIT-green)

## 📖 Tentang Aplikasi

**KidsLearn** adalah aplikasi pembelajaran interaktif yang dirancang khusus untuk anak-anak. Aplikasi ini membantu anak-anak belajar tentang berbagai jenis hewan dengan cara yang menyenangkan dan interaktif melalui gambar, suara, dan mini games.

### ✨ Fitur Utama

-   🔐 **Sistem Autentikasi**: Login dan register dengan avatar pilihan
-   📊 **Progress Tracking**: Sistem level dan XP untuk memotivasi anak belajar
-   🐾 **Learning Module**: Belajar tentang berbagai kategori hewan:
    -   Mammals (Mamalia)
    -   Birds (Burung)
    -   Sea Animals (Hewan Laut)
    -   Insects (Serangga)
    -   Reptiles (Reptil)
    -   Amphibians (Amfibi)
-   🎮 **Mini Games**: Quiz interaktif untuk menguji pengetahuan
-   🎨 **User-Friendly Interface**: Desain colorful dan menarik untuk anak-anak
-   🔊 **Audio Support**: Suara hewan untuk pengalaman belajar yang lebih baik

## 📋 Persyaratan Sistem

-   PHP >= 8.2
-   Composer
-   MySQL/MariaDB atau SQLite
-   Node.js & NPM (untuk asset compilation)

## 🚀 Instalasi

### 1. Clone Repository

```bash
cd c:\laragon\www
git clone <repository-url> kidslearn-laravel
cd kidslearn-laravel
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Setup Environment

```bash
# Copy file .env.example ke .env
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

#### Untuk MySQL/MariaDB:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kidslearn
DB_USERNAME=root
DB_PASSWORD=
```

#### Untuk SQLite (Default):

```env
DB_CONNECTION=sqlite
# DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD tidak perlu diisi
```

### 5. Jalankan Migration dan Seeder

```bash
# Jalankan migration untuk membuat tabel database
php artisan migrate

# Jalankan seeder untuk mengisi data dummy
php artisan db:seed
```

### 6. Setup Assets

Pastikan folder `public/img` dan `public/sound` sudah berisi file-file yang diperlukan. Copy dari project lama:

```bash
# Copy assets dari project lama
xcopy /E /I /Y ..\duolingo-abc\img public\img
xcopy /E /I /Y ..\duolingo-abc\sound public\sound
xcopy /E /I /Y ..\duolingo-abc\css public\css
```

### 7. Compile Assets

```bash
npm run dev
```

### 8. Jalankan Aplikasi

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## 👥 Akun Demo

Setelah menjalankan seeder, Anda dapat login dengan akun berikut:

**Akun 1:**

-   Nama: `Budi`
-   Password: `password123`

**Akun 2:**

-   Nama: `Siti`
-   Password: `password123`

## 📁 Struktur Database

### Tabel: users

-   `id`: Primary key
-   `name`: Nama user
-   `email`: Email user (auto-generated)
-   `password`: Password (hashed)
-   `avatar`: Nama file avatar
-   `created_at`, `updated_at`: Timestamps

### Tabel: animals

-   `id`: Primary key
-   `name`: Nama hewan
-   `category`: Kategori (mammals, birds, sea, insects, reptils, amphibi)
-   `description`: Deskripsi hewan
-   `image_path`: Path gambar hewan
-   `sound_path`: Path suara hewan (nullable)
-   `created_at`, `updated_at`: Timestamps

### Tabel: quiz_questions

-   `id`: Primary key
-   `question`: Pertanyaan quiz
-   `image_path`: Path gambar
-   `correct_answer`: Jawaban yang benar
-   `options`: Array pilihan jawaban (JSON)
-   `category`: Kategori hewan
-   `created_at`, `updated_at`: Timestamps

### Tabel: user_progress

-   `id`: Primary key
-   `user_id`: Foreign key ke tabel users
-   `level`: Level user
-   `xp`: Experience points
-   `total_quizzes_completed`: Total quiz yang diselesaikan
-   `correct_answers`: Jumlah jawaban benar
-   `created_at`, `updated_at`: Timestamps

## 🗺️ Routes

### Guest Routes (Tidak perlu login)

-   `GET /` - Halaman login
-   `GET /login` - Halaman login
-   `POST /login` - Proses login
-   `GET /register` - Halaman register
-   `POST /register` - Proses register

### Authenticated Routes (Perlu login)

-   `GET /dashboard` - Dashboard utama
-   `POST /logout` - Logout
-   `GET /learning` - Menu learning
-   `GET /learning/{category}` - Halaman learning per kategori
-   `GET /api/animals/{category}` - API untuk mendapatkan data hewan
-   `GET /quiz` - Halaman mini games/quiz
-   `POST /quiz/check` - Check jawaban quiz

## 🎨 Models

### User

-   Relationship: `hasOne(UserProgress)`
-   Method: `getOrCreateProgress()` - Membuat atau mengambil progress user

### Animal

-   Static Method: `getByCategory($category)` - Ambil hewan berdasarkan kategori
-   Static Method: `getCategories()` - Ambil semua kategori

### QuizQuestion

-   Cast: `options` as array
-   Static Method: `getRandomByCategory($category)` - Ambil pertanyaan random
-   Method: `checkAnswer($answer)` - Cek jawaban benar/salah

### UserProgress

-   Relationship: `belongsTo(User)`
-   Method: `addXp($xp)` - Tambah XP dan update level
-   Method: `incrementQuizCompleted($isCorrect)` - Update statistik quiz
-   Method: `getAccuracy()` - Hitung persentase akurasi

## 🛠️ Controllers

### AuthController

-   `showLogin()` - Tampilkan halaman login
-   `login(Request)` - Proses login
-   `showRegister()` - Tampilkan halaman register
-   `register(Request)` - Proses register
-   `logout(Request)` - Logout user

### DashboardController

-   `index()` - Tampilkan dashboard dengan progress user

### LearningController

-   `index()` - Tampilkan menu kategori learning
-   `category($category)` - Tampilkan daftar hewan per kategori
-   `getAnimals($category)` - API untuk mendapatkan data hewan (JSON)

### QuizController

-   `index(Request)` - Tampilkan halaman quiz
-   `checkAnswer(Request)` - Cek jawaban dan update progress

## 📊 Sistem Level & XP

-   User mulai dari Level 1 dengan 0 XP
-   Setiap jawaban benar di quiz: **+10 XP**
-   Level up setiap **100 XP**
-   Progress bar menunjukkan XP dalam level saat ini

## 🎮 Cara Bermain

1. **Register** - Buat akun dengan memilih avatar kesukaan
2. **Login** - Masuk dengan nama dan password
3. **Dashboard** - Lihat level dan XP kamu
4. **Learning** - Pilih kategori hewan untuk belajar
5. **Mini Games** - Mainkan quiz untuk mendapatkan XP

## 🔧 Development

### Menjalankan Development Server

```bash
# Terminal 1 - Laravel server
php artisan serve

# Terminal 2 - Vite dev server (untuk hot reload)
npm run dev
```

### Membuat Migration Baru

```bash
php artisan make:migration create_table_name
php artisan migrate
```

### Membuat Model

```bash
php artisan make:model ModelName -m  # dengan migration
php artisan make:model ModelName -mcr  # dengan migration, controller, resource
```

### Membuat Controller

```bash
php artisan make:controller ControllerName
```

### Membuat Seeder

```bash
php artisan make:seeder SeederName
php artisan db:seed --class=SeederName
```

### Clear Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## 🧪 Testing

```bash
# Jalankan semua tests
php artisan test

# Jalankan test spesifik
php artisan test --filter TestName
```

## 📦 Production Deployment

### 1. Optimize Application

```bash
# Optimize autoloader
composer install --optimize-autoloader --no-dev

# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Compile assets for production
npm run build
```

### 2. Setup Environment

-   Set `APP_ENV=production` di file `.env`
-   Set `APP_DEBUG=false`
-   Generate production key: `php artisan key:generate`
-   Setup database production

### 3. File Permissions

```bash
chmod -R 755 storage bootstrap/cache
```

## 📝 API Documentation

### Get Animals by Category

**Endpoint:** `GET /api/animals/{category}`

**Parameters:**

-   `category` (string): mammals, birds, sea, insects, reptils, amphibi

**Response:**

```json
{
    "success": true,
    "animals": [
        {
            "id": 1,
            "name": "Dog",
            "category": "mammals",
            "description": "has four legs...",
            "image_path": "img/dog1.png",
            "sound_path": "sound/dog.mp3"
        }
    ]
}
```

### Check Quiz Answer

**Endpoint:** `POST /quiz/check`

**Request Body:**

```json
{
    "question_id": 1,
    "answer": "cat"
}
```

**Response (Correct):**

```json
{
    "success": true,
    "result": "correct",
    "message": "🎉 Jawaban kamu BENAR!",
    "xp_gained": 10
}
```

**Response (Wrong):**

```json
{
    "success": true,
    "result": "wrong",
    "message": "❌ Jawaban kamu kurang tepat..."
}
```

## 🐛 Troubleshooting

### Error: SQLSTATE[HY000] [1049] Unknown database

**Solusi:**

```bash
# Buat database terlebih dahulu
mysql -u root -p
CREATE DATABASE kidslearn;
exit;

# Atau gunakan SQLite
php artisan migrate --database=sqlite
```

### Error: Class 'App\Models\...' not found

**Solusi:**

```bash
composer dump-autoload
php artisan clear-compiled
```

### Assets tidak muncul

**Solusi:**

```bash
php artisan storage:link
npm run build
```

### Error 419 (CSRF Token Mismatch)

**Solusi:**

```bash
php artisan cache:clear
# Reload halaman dengan Ctrl+F5
```

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👨‍💻 Author

**KidsLearn Team**

-   Website: [kidslearn.com](https://kidslearn.com)
-   Email: support@kidslearn.com

## 🙏 Acknowledgments

-   Laravel Framework
-   Font Awesome for icons
-   All contributors who helped with this project

## 📞 Support

Jika Anda memiliki pertanyaan atau memerlukan bantuan:

-   Create an issue di GitHub
-   Email: support@kidslearn.com
-   Documentation: [docs.kidslearn.com](https://docs.kidslearn.com)

---

**Happy Coding! 🚀**

_KidsLearn © 2025 — Belajar Dengan Senang!_
