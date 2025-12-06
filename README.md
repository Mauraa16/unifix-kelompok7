# UNIFIX - Sistem Pengaduan Fasilitas Kampus

![UNIFIX Banner](public/images/logo.png)

**UNIFIX** adalah aplikasi berbasis web yang dibangun menggunakan **Laravel** untuk memfasilitasi pelaporan dan penanganan masalah fasilitas kampus. Aplikasi ini menghubungkan Mahasiswa, Petugas, dan Admin dalam satu platform yang transparan dan efisien.

## 🚀 Fitur Utama

* **Multi-Role User:**
    * **Admin:** Mengelola data pengguna (Mahasiswa & Petugas), memantau seluruh aktivitas, dan manajemen sistem.
    * **Petugas:** Menangani laporan masuk, memperbarui status pengerjaan, dan memberikan tanggapan.
    * **Mahasiswa:** Membuat laporan pengaduan, melampirkan foto bukti, dan memantau status laporan mereka.
* **Autentikasi Modern:**
    * Login & Register.
    * **Google OAuth:** Login instan menggunakan akun Google.
    * **Verifikasi Email:** Keamanan tambahan untuk validasi akun pengguna.
* **Manajemen Laporan:**
    * Status pelacakan: *Belum Diproses*, *Sedang Diproses*, *Selesai*.
    * Bukti laporan berupa unggahan gambar.
    * Sistem komentar/tanggapan pada setiap laporan.
* **Dashboard Interaktif:** Statistik ringkas untuk setiap role.
* **Profil Pengguna:** Kelola data diri dan foto profil.

## 🛠️ Teknologi yang Digunakan

* **Backend:** [Laravel](https://laravel.com) (PHP Framework)
* **Frontend:** Blade Templates, [Tailwind CSS](https://tailwindcss.com) (CDN), Alpine.js
* **Database:** MySQL
* **Auth Package:** Laravel Socialite (Google Login)

## 📋 Prasyarat

Sebelum menjalankan proyek ini, pastikan komputer Anda memiliki:

* PHP >= 8.1
* Composer
* MySQL / MariaDB
* Git

## ⚙️ Cara Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal (Localhost):

1.  **Clone Repository**
    ```bash
    git clone [https://github.com/Mauraa16/unifix-kelompok7.git](https://github.com/Mauraa16/unifix-kelompok7.git)
    cd unifix-kelompok7
    ```

2.  **Install Dependency PHP**
    ```bash
    composer install
    ```

3.  **Salin File Environment**
    Duplikat file `.env.example` menjadi `.env`.
    ```bash
    cp .env.example .env
    ```

4.  **Konfigurasi Database**
    Buka file `.env` dan sesuaikan pengaturan database Anda:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=unifix_db  # Pastikan buat database ini di phpMyAdmin
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5.  **Generate App Key**
    ```bash
    php artisan key:generate
    ```

6.  **Migrasi & Seeding Database**
    Jalankan migrasi untuk membuat tabel dan mengisi data awal (Admin/Petugas default).
    ```bash
    php artisan migrate --seed
    ```

7.  **Jalankan Server**
    ```bash
    php artisan serve
    ```
    Buka browser dan akses: `http://localhost:8000`

## 🔐 Konfigurasi Fitur Tambahan

Agar fitur **Login Google** dan **Verifikasi Email** berjalan, Anda wajib melengkapi file `.env`:

### 1. Setup Google Login
Dapatkan Client ID & Secret dari [Google Cloud Console](https://console.cloud.google.com/).
```env
GOOGLE_CLIENT_ID=masukkan_client_id_google_anda
GOOGLE_CLIENT_SECRET=masukkan_client_secret_google_anda
GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google/callback