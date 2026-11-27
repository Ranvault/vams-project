# VEROS Adventure Management System (VAMS)

Sistem Informasi Pengelolaan Open Trip berbasis web yang memudahkan penyelenggara wisata mengelola jadwal perjalanan, pemesanan rombongan dalam satu formulir, serta verifikasi pembayaran bertahap (DP dan Pelunasan).

## Anggota Kelompok
- Khairab Ariq Putra Marendra — NIM: 10124128
- Muhammad Rifaldi Aprilian — NIM: 10124136

## Teknologi yang Digunakan
- **Backend:** PHP 8.2, Laravel Framework
- **Frontend:** Blade Template, Bootstrap 5
- **Database:** MySQL
- **Autentikasi:** Laravel Breeze

## Fitur Utama
1. **Autentikasi Admin:** Login terproteksi menggunakan middleware `auth` untuk mengakses dashboard pengelolaan.
2. **Manajemen Paket Open Trip (CRUD):** Admin dapat menambah, melihat, mengubah, dan menghapus paket trip beserta poster dan kuota peserta.
3. **Katalog Trip & Pendaftaran Multi-Peserta (Public):** Pengunjung dapat memilih trip dan mendaftarkan banyak peserta sekaligus dalam satu formulir dengan kalkulasi tagihan dan kode booking otomatis.
4. **Pembayaran Bertahap & Verifikasi Manual:** Pengunjung dapat mengecek status pesanan via Kode Booking dan mengunggah bukti transfer DP maupun Pelunasan untuk divalidasi oleh Admin.

## Cara Menjalankan Aplikasi di Lokal
1. Clone repository ini:
   git clone [(https://github.com/Ranvault/vams-project.git)]
   cd vams-project
2. Install dependensi PHP & Frontend:
    composer install
    npm install && npm run build
3. Salin file konfigurasi .env dan buat application key:
    cp .env.example .env
    php artisan key:generate
4. Atur koneksi database pada file .env (DB_DATABASE=db_vams), lalu jalankan migrasi, seeder, dan storage link:
    php artisan migrate --seed
    php artisan storage:link
5. Jalankan server lokal:
    php artisan serve
6. Akses aplikasi di http://127.0.0.1:8000 (Login Admin default: admin@veros.com / password123).