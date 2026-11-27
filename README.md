# VEROS Adventure Management System (VAMS)

## Deskripsi Aplikasi
**VEROS Adventure Management System (VAMS)** adalah aplikasi web pengelolaan layanan perjalanan wisata terbuka (*Open Trip*) berbasis **Laravel** dan **MySQL**. Aplikasi ini dirancang untuk menggantikan pencatatan pendaftaran peserta secara manual dengan sistem terintegrasi yang mencakup katalog perjalanan publik, formulir pendaftaran banyak peserta dalam satu transaksi, pengurangan kuota otomatis, hingga verifikasi pembayaran bertahap (DP dan Pelunasan) oleh administrator.

---

## Fitur Utama
1. **Autentikasi & Pembatasan Hak Akses Admin**
   * Login dan logout administrator menggunakan **Laravel Breeze** serta pembatasan akses halaman pengelolaan (`/admin/*`) melalui **Middleware `auth`**.
2. **Manajemen Paket Open Trip (CRUD Admin)**
   * Administrator dapat menambah, melihat, memperbarui, dan menghapus paket Open Trip (destinasi, tanggal keberangkatan, durasi, harga per peserta, kuota, deskripsi, dan unggahan poster) dengan validasi input di sisi server.
3. **Katalog Open Trip & Pendaftaran Multi-Peserta (Public)**
   * Pengunjung dapat melihat daftar paket perjalanan yang masih memiliki kuota dan mendaftarkan beberapa peserta rombongan sekaligus dalam satu formulir dinamis. Sistem secara otomatis menghitung total tagihan, mengurangi sisa kuota trip, dan menghasilkan kode booking unik.
4. **Cek Booking & Pembayaran Bertahap (DP & Pelunasan)**
   * Pemesan dapat mengecek status pesanan menggunakan kode booking serta mengunggah bukti transfer pembayaran DP maupun Pelunasan.
5. **Verifikasi Pembayaran Manual (Admin)**
   * Administrator dapat memeriksa bukti transfer yang masuk dan memvalidasi status pembayaran peserta dari *Menunggu Verifikasi*, *DP Terverifikasi*, hingga *Lunas*.

## Cara Menjalankan Aplikasi
1. **Clone repository ini dan masuk ke folder proyek:**
   ```bash
   git clone [https://github.com/Ranvault/vams-project.git](https://github.com/Ranvault/vams-project.git)
   cd vams-project

2. Install dependensi Composer:
composer install

3. Salin file konfigurasi .env dan buat application key:
cp .env.example .env
php artisan key:generate

4. Konfigurasi koneksi database pada file .env:
DB_DATABASE=db_vams
DB_USERNAME=root
DB_PASSWORD=

5. Jalankan migrasi tabel, data contoh (seeder), dan tautan penyimpanan gambar:
php artisan migrate:fresh --seed
php artisan storage:link

6. Jalankan server lokal Laravel:
php artisan serve
Buka aplikasi melalui browser pada alamat http://127.0.0.1:8000.

7. Akun & Data Simulasi Pengujian (Hasil Seeder)
Login Admin (/login): Email admin@veros.com | Password password123
Kode Booking Contoh (Menu Cek Booking):
VAMS-20261126-LUN1 (Status: Lunas — 2 Peserta)
VAMS-20261126-PND2 (Status: Menunggu Verifikasi DP — 1 Peserta) 

---

## Teknologi yang Digunakan
* **Backend & Arsitektur:** PHP 8.2, Framework Laravel 12 (Routing, MVC Controller, Eloquent ORM, Database Migration & Seeder, Request Validation, dan CSRF Protection).
* **Database:** MySQL (5 tabel relasional: `users`, `trips`, `bookings`, `participants`, `payments`).
* **Frontend:** Laravel Blade Template & Bootstrap 5.
* **Autentikasi:** Laravel Breeze.

## Nama Anggota Kelompok

Kelas: IF-4
Anggota 1: Khairan Ariq Putra Marendra - 10124128
Anggota 2: Muhammad Rifaldi Aprilian - 10124136

---