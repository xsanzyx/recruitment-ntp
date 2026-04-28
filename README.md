# 🚀 NTP Careers (Portal Rekrutmen PT Nusantara Turbin dan Propulsi)

Aplikasi portal rekrutmen modern yang dibangun untuk PT Nusantara Turbin dan Propulsi (NTP). Aplikasi ini menjembatani pelamar kerja (kandidat) dengan tim HR (Human Resources) untuk mempermudah proses pelamaran, penayangan lowongan kerja, dan manajemen kandidat secara digital.

Aplikasi ini menggunakan perpaduan **Laravel (Backend)** dan kombinasi **Tailwind CSS + Vanilla CSS (Frontend)** untuk memberikan pengalaman antarmuka yang sangat premium, mulus, dan dinamis, lengkap dengan sistem animasi interaktif.

---

## ✨ Fitur Utama

Aplikasi ini memiliki sistem *Role-Based Access Control* (RBAC) yang membagi pengguna menjadi dua peran utama:

### 👤 1. Guest / Kandidat (Pelamar)
- **Landing Page Interaktif:** Menampilkan informasi perusahaan, statistik, proses rekrutmen, dan lowongan pekerjaan yang sedang aktif.
- **Autentikasi OTP:** Sistem registrasi dan login yang aman menggunakan verifikasi OTP via email (Gmail SMTP).
- **Cari & Filter Lowongan:** Mencari lowongan pekerjaan sesuai divisi dan tipe pekerjaan.
- **Lacak Lamaran:** Kandidat dapat melihat riwayat lamaran dan melacak status (Pending, In Review, Interview, Shortlisted, Rejected).

### 👔 2. HR (Human Resources)
- **Dashboard Analitik:** Panel monitoring yang merangkum jumlah lowongan aktif, total pelamar, serta status lamaran kandidat secara sekilas.
- **Kelola Lowongan (CRUD):** Membuat, mengedit, melihat detail, dan menghapus lowongan pekerjaan. Termasuk mengubah status lowongan menjadi *Open* atau *Closed*.
- **Kelola Kandidat:** Melihat daftar kandidat yang melamar, meninjau CV/berkas, dan mengubah status kandidat (Tahap Review, Wawancara, dsb).
- **Panel Khusus (Tailwind CSS):** Dibangun dengan layout terpisah agar tampilan Dashboard HR lebih berkesan *clean*, modern, dan responsif.

---

## 🛠️ Teknologi yang Digunakan

Aplikasi ini dibangun di atas fondasi teknologi modern:

- **Framework Backend:** Laravel 10+ (PHP)
- **Database:** MySQL
- **Frontend (Kandidat):** Vanilla HTML/CSS + Bootstrap 5 (Khusus *grid* dan utilitas dasar)
- **Frontend (HR Panel):** Tailwind CSS + Alpine.js / Vanilla JS
- **Animasi & UI:** Custom CSS Keyframes, CSS Transitions, dan Intersection Observer API untuk efek *fade-up* saat digulir (*scroll*).
- **Email Service:** SMTP (Gmail) untuk pengiriman OTP.

---

## 💻 Panduan Instalasi (Lokal)

Jika Anda adalah anggota tim pengembang atau ingin menjalankan aplikasi ini di komputer Anda sendiri, ikuti langkah-langkah di bawah ini.

### Prasyarat:
Pastikan Anda telah menginstal perangkat lunak berikut:
- **PHP** (Minimal versi 8.1)
- **Composer**
- **Node.js & NPM** (Opsional, jika ada proses kompilasi asset)
- **MySQL / XAMPP / Laragon**
- **Git**

### Langkah Instalasi:

1. **Clone Repository**
   Buka terminal dan jalankan perintah berikut:
   ```bash
   git clone https://github.com/username-anda/rekrutmen-app.git
   cd rekrutmen-app
   ```

2. **Install Dependensi PHP**
   Unduh semua pustaka (library) yang dibutuhkan Laravel:
   ```bash
   composer install
   ```

3. **Konfigurasi Environment (`.env`)**
   Copy template `.env.example` menjadi file `.env`:
   ```bash
   cp .env.example .env
   ```
   *Bagi pengguna Windows Command Prompt:* `copy .env.example .env`

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Konfigurasi Database**
   Buka aplikasi *Database Manager* Anda (seperti phpMyAdmin, DBeaver, atau TablePlus), lalu buat database baru (misal: `rekrutmen_db`).
   Buka file `.env` di text editor (VS Code), dan sesuaikan bagian ini:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=rekrutmen_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Konfigurasi SMTP Email (Untuk Fitur OTP)**
   Di file `.env`, atur konfigurasi email menggunakan akun Gmail Anda:
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=465
   MAIL_USERNAME=emailanda@gmail.com
   MAIL_PASSWORD=app_password_gmail_anda
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=emailanda@gmail.com
   MAIL_FROM_NAME="NTP Careers"
   ```
   *(Gunakan App Password dari Google Account, bukan password email biasa).*

7. **Migrasi Database & Seeder**
   Jalankan perintah ini untuk membuat struktur tabel database beserta data *dummy* awal (seperti Akun HR):
   ```bash
   php artisan migrate --seed
   ```

8. **Jalankan Aplikasi**
   Terakhir, hidupkan server lokal Laravel:
   ```bash
   php artisan serve
   ```
   Aplikasi Anda kini bisa diakses melalui browser di alamat: `http://localhost:8000`

---

## 👥 Akun Uji Coba (Demo)

Jika Anda baru saja menjalankan `php artisan migrate --seed`, Anda bisa mencoba login dengan akun *default* HR berikut:
- **Email:** hr@ntp.id
- **Password:** password

---

## 📂 Struktur Aplikasi Penting
- `app/Http/Controllers/HR/` - Logika *backend* khusus panel HR.
- `resources/views/pages/guest/` - Tampilan publik untuk kandidat.
- `resources/views/pages/hr/` - Tampilan *dashboard* manajemen HR.
- `public/css/` - Semua skrip CSS termasuk file animasi *custom*.

---

*Dibuat untuk memudahkan operasional dan transparansi rekrutmen PT Nusantara Turbin dan Propulsi.*
