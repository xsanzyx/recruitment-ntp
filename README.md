# 🏢 Sistem Informasi Rekrutmen Karyawan — PT Nusantara Turbin dan Propulsi

Aplikasi web untuk mengelola seluruh proses rekrutmen karyawan, mulai dari pendaftaran kandidat, pelamaran kerja, seleksi otomatis (*eligibility check*), hingga penilaian akhir oleh HR dan peninjauan oleh Manager per departemen.

---

## ✅ 1. Kebutuhan Sistem

Pastikan komputer Anda sudah memenuhi persyaratan berikut sebelum melakukan instalasi:

| Komponen          | Versi Minimum        | Keterangan                                      |
| ----------------- | -------------------- | ----------------------------------------------- |
| **PHP**           | 8.2 atau lebih baru  | Pastikan ekstensi aktif (lihat di bawah)         |
| **MySQL**         | 8.0 atau lebih baru  | Disertakan dalam XAMPP                           |
| **Composer**      | 2.x                  | [Download di sini](https://getcomposer.org)      |
| **XAMPP**         | 8.2.x                | [Download di sini](https://apachefriends.org)    |
| **Web Browser**   | Versi terbaru         | Chrome, Firefox, atau Edge                      |

### Ekstensi PHP yang Diperlukan

Ekstensi berikut **harus aktif** di file `php.ini` XAMPP Anda:

```
php_fileinfo
php_mbstring
php_openssl
php_pdo_mysql
php_tokenizer
php_xml
php_ctype
php_json
php_curl
```

> 💡 **Cara mengaktifkan:** Buka file `C:\xampp\php\php.ini`, cari nama ekstensi, hapus tanda `;` (titik koma) di depannya, lalu restart Apache.

---

## 🔧 2. Langkah Instalasi

### Langkah 1 — Clone atau Ekstrak Project

**Opsi A — Via Git:**
```bash
cd C:\xampp\htdocs
git clone <url-repository> rekrutmen-app
```

**Opsi B — Via ZIP:**
1. Ekstrak file ZIP project
2. Pindahkan folder hasil ekstrak ke `C:\xampp\htdocs\`
3. Rename folder menjadi `rekrutmen-app` (opsional, untuk kemudahan akses)

---

### Langkah 2 — Install Dependencies

Buka terminal (Command Prompt / PowerShell), arahkan ke folder project, lalu jalankan:

```bash
cd C:\xampp\htdocs\rekrutmen-app
composer install
```

> ℹ️ Perintah ini akan mengunduh seluruh package PHP yang dibutuhkan oleh Laravel dan menyimpannya ke folder `vendor/`. Proses ini memerlukan koneksi internet dan membutuhkan waktu beberapa menit.

---

### Langkah 3 — Konfigurasi Environment

Salin file konfigurasi template:

```bash
copy .env.example .env
```

Buka file `.env` dengan text editor (Notepad++, VS Code, dsb.) dan sesuaikan variabel berikut:

#### 🔹 Konfigurasi Aplikasi
```env
APP_NAME="Rekrutmen NTP"
APP_URL=http://localhost:8000
```

#### 🔹 Konfigurasi Database
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rekrutmen_app
DB_USERNAME=root
DB_PASSWORD=
```
> ⚠️ Sesuaikan `DB_USERNAME` dan `DB_PASSWORD` jika MySQL Anda menggunakan password.

#### 🔹 Konfigurasi Email (SMTP)
Sistem ini mengirim email untuk **verifikasi OTP** dan **notifikasi status lamaran**. Email **wajib dikonfigurasi** agar fitur registrasi berfungsi.

**Untuk development/testing (Mailtrap.io):**
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=<username_mailtrap_anda>
MAIL_PASSWORD=<password_mailtrap_anda>
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@ntp.co.id"
MAIL_FROM_NAME="PT Nusantara Turbin dan Propulsi"
```

**Untuk production (Gmail):**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email-perusahaan@gmail.com
MAIL_PASSWORD="app-password-16-karakter"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="email-perusahaan@gmail.com"
MAIL_FROM_NAME="PT Nusantara Turbin dan Propulsi"
```
> 💡 Untuk Gmail, gunakan **App Password** (bukan password akun utama). Cara mendapatkannya: Google Account → Security → 2-Step Verification → App passwords.

---

### Langkah 4 — Generate Application Key

```bash
php artisan key:generate
```

> ℹ️ Perintah ini membuat kunci enkripsi unik untuk aplikasi Anda. Kunci ini digunakan oleh Laravel untuk mengenkripsi session, cookie, dan data sensitif lainnya. Tanpa kunci ini, aplikasi tidak akan berjalan dengan aman.

---

### Langkah 5 — Setup Database

**5a. Buat database baru:**
1. Buka XAMPP → Start **Apache** dan **MySQL**
2. Buka browser → akses `http://localhost/phpmyadmin`
3. Klik **"New"** di sidebar kiri
4. Masukkan nama database: `rekrutmen_app`
5. Pilih collation: `utf8mb4_unicode_ci`
6. Klik **"Create"**

**5b. Jalankan migrasi (membuat tabel):**
```bash
php artisan migrate
```
> ℹ️ Perintah ini membaca seluruh file di folder `database/migrations/` dan membuat tabel-tabel yang diperlukan secara otomatis di database.

**5c. Jalankan seeder (mengisi data demo):**
```bash
php artisan db:seed
```
> ℹ️ Perintah ini mengisi database dengan akun demo untuk semua role, contoh lowongan pekerjaan, dan contoh lamaran agar sistem dapat langsung dicoba.

---

### Langkah 6 — Buat Storage Link

```bash
php artisan storage:link
```

> ℹ️ Perintah ini membuat *symbolic link* dari `public/storage` ke `storage/app/public`. Ini diperlukan agar file yang diupload oleh pengguna (CV, dokumen, foto profil) dapat diakses melalui browser.

---

### Langkah 7 — Menjalankan Aplikasi

**Opsi A — Via Artisan Serve (Direkomendasikan untuk development):**
```bash
php artisan serve
```
Akses di browser: **http://localhost:8000**

**Opsi B — Via XAMPP Apache:**
Akses di browser: **http://localhost/rekrutmen-app/public**

> 💡 **Rekomendasi:** Gunakan `php artisan serve` karena lebih mudah dan tidak memerlukan konfigurasi virtual host tambahan.

---

## 👤 3. Akun Login Default

Setelah menjalankan seeder (`php artisan db:seed`), sistem memiliki akun-akun berikut:

| Role            | Email                      | Password          |
| --------------- | -------------------------- | ----------------- |
| **Super Admin** | `admin@ntp.co.id`          | `Admin@Ntp2026`   |
| **HR**          | `hr@ntp.co.id`             | `HrNtp@2026`      |
| **Manager MIS** | `manager.mis@ntp.co.id`    | `Manager@2026`    |
| **Manager Eng** | `manager.eng@ntp.co.id`    | `Manager@2026`    |
| **Kandidat**    | `kandidat@example.com`     | `Kandidat@2026`   |

> ⚠️ **PENTING:** Segera ganti semua password default setelah pertama kali login ke sistem production.

---

## 📧 4. Panduan Konfigurasi Email

Sistem ini mengirim email pada dua fitur utama:
1. **Verifikasi OTP** — saat kandidat mendaftar akun baru
2. **Notifikasi Status Lamaran** — saat HR mengubah status lamaran menjadi Lolos/Tidak Lolos

### Setup Mailtrap (untuk Development/Testing)

1. Buka [mailtrap.io](https://mailtrap.io) → Daftar akun gratis
2. Buat **Inbox** baru → Masuk ke inbox → Klik **"SMTP Settings"**
3. Pilih **Integrations: Laravel 9+**
4. Copy kredensial (`MAIL_USERNAME` dan `MAIL_PASSWORD`)
5. Paste ke file `.env` Anda
6. Restart server (`Ctrl+C` lalu `php artisan serve` ulang)

> 💡 Mailtrap menangkap semua email yang dikirim tanpa benar-benar mengirimnya ke alamat tujuan — ideal untuk testing agar tidak mengganggu email asli.

### Setup Gmail (untuk Production)

1. Pastikan akun Gmail sudah mengaktifkan **2-Step Verification**
2. Buka: Google Account → Security → App passwords
3. Generate password baru untuk "Mail"
4. Copy 16-karakter password yang dihasilkan
5. Masukkan ke `.env` sebagai `MAIL_PASSWORD`

---

## 🔍 5. Troubleshooting

| Masalah | Penyebab | Solusi |
| ------- | -------- | ----- |
| **"Class not found"** | Autoload cache belum diperbarui | `composer dump-autoload` |
| **"Table already exists"** saat migrasi | Database sudah ada tabel dari migrasi sebelumnya | `php artisan migrate:fresh --seed` (⚠️ menghapus semua data) |
| **Upload file/gambar tidak muncul** | Storage link belum dibuat | `php artisan storage:link` |
| **OTP email tidak terkirim** | Konfigurasi SMTP salah | Cek `MAIL_*` di file `.env`, pastikan kredensial benar |
| **Halaman menampilkan error 500** | Error pada kode/konfigurasi | Set `APP_DEBUG=true` di `.env`, cek log di `storage/logs/laravel.log` |
| **File `.env` tidak ditemukan** | Belum disalin dari template | `copy .env.example .env` lalu `php artisan key:generate` |
| **Permission denied (Linux/Mac)** | Folder storage tidak writable | `chmod -R 775 storage bootstrap/cache` |
| **Halaman login redirect terus** | Session driver error | Pastikan `SESSION_DRIVER=cookie` di `.env` |

---

## 📁 6. Struktur Project

```
rekrutmen-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/              ← Controller Super Admin (UserManagement)
│   │   │   ├── HR/                 ← Controller HR (Dashboard, Vacancy, Application)
│   │   │   ├── Manager/            ← Controller Manager (Dashboard, Application)
│   │   │   ├── AuthController      ← Login, Register, OTP
│   │   │   ├── ApplicationController ← Proses melamar kerja (Kandidat)
│   │   │   └── ProfileController   ← Kelola profil kandidat
│   │   ├── Middleware/
│   │   │   ├── AdminMiddleware     ← Proteksi route Super Admin
│   │   │   ├── HRMiddleware        ← Proteksi route HR (+ Admin)
│   │   │   ├── ManagerMiddleware   ← Proteksi route Manager
│   │   │   ├── CandidateMiddleware ← Proteksi route Kandidat
│   │   │   └── CheckUserStatus     ← Cek status akun aktif di setiap request
│   │   └── ...
│   ├── Mail/
│   │   ├── OtpMail                 ← Template email OTP
│   │   └── ApplicationStatusMail   ← Template email notifikasi status
│   └── Models/
│       ├── User                    ← Model pengguna (4 role)
│       ├── CandidateProfile        ← Model profil kandidat
│       ├── JobVacancy              ← Model lowongan pekerjaan
│       └── Application             ← Model lamaran kerja
├── database/
│   ├── migrations/                 ← 18 file migrasi skema database
│   └── seeders/
│       ├── DatabaseSeeder          ← Seeder utama
│       └── DemoSeeder              ← Data demo lengkap semua role
├── routes/
│   └── web.php                     ← Seluruh definisi rute aplikasi
├── resources/views/                ← Seluruh tampilan Blade
├── public/                         ← Asset publik (CSS, JS, gambar)
├── storage/                        ← File upload, log, cache
└── .env                            ← Konfigurasi environment (JANGAN di-commit)
```

---

## 📋 7. Catatan untuk Administrator IT

### 🔒 Keamanan
- File `.env` berisi kredensial sensitif (database, SMTP). **Jangan pernah** membagikan atau meng-commit file ini ke repository publik.
- Untuk production, set `APP_DEBUG=false` dan `APP_ENV=production` di `.env`.
- Ganti semua password default segera setelah deployment.

### 💾 Backup Database
Disarankan melakukan backup database secara berkala:
```bash
# Via command line (mysqldump)
mysqldump -u root -p rekrutmen_app > backup_rekrutmen_2026.sql

# Atau via phpMyAdmin → pilih database → tab "Export" → Go
```

### 👨‍💻 Membuat Akun Super Admin Baru (via Tinker)
Jika perlu membuat akun Super Admin baru secara manual:
```bash
php artisan tinker
```
```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::create([
    'first_name'        => 'Nama',
    'last_name'         => 'Admin',
    'email'             => 'admin.baru@ntp.co.id',
    'password'          => Hash::make('PasswordAman123!'),
    'role'              => 'admin',
    'status'            => 'active',
    'email_verified_at' => now(),
]);
```

### 🌐 Deployment Production
Aplikasi ini saat ini dikonfigurasi untuk lingkungan **localhost/development**. Untuk deployment ke server production, diperlukan konfigurasi tambahan:
- Web server (Apache/Nginx) dengan virtual host
- Sertifikat SSL (HTTPS)
- Konfigurasi SMTP production (email perusahaan)
- Mengatur `APP_ENV=production` dan `APP_DEBUG=false`
- Queue worker untuk pengiriman email (opsional, untuk performa)

---

## 🛠️ Teknologi yang Digunakan

| Komponen       | Teknologi              |
| -------------- | ---------------------- |
| Bahasa         | PHP 8.2                |
| Framework      | Laravel 11             |
| Database       | MySQL 8.0              |
| Arsitektur     | MVC (Model-View-Controller) |
| ORM            | Eloquent ORM           |
| Template       | Blade (Laravel)        |
| Autentikasi    | Laravel Auth + OTP     |
| Otorisasi      | Custom Middleware RBAC  |

---

## 📄 Lisensi

Project ini dikembangkan sebagai bagian dari program Kerja Praktik di **PT Nusantara Turbin dan Propulsi (NTP)**.

© 2026 — Hak cipta dilindungi.
