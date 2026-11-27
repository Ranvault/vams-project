<?php

namespace Database\Seeders;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Admin Default untuk Pengujian
        User::create([
            'name'     => 'Admin VEROS',
            'email'    => 'admin@veros.com',
            'password' => Hash::make('password123'),
        ]);

        // Data Contoh Paket Open Trip
        Trip::create([
            'nama_trip'     => 'Open Trip Gunung Prau Golden Sunrise',
            'destinasi'     => 'Dieng, Wonosobo, Jawa Tengah',
            'tgl_berangkat' => '2026-12-20',
            'durasi'        => '2 Hari 1 Malam',
            'harga'         => 650000,
            'kuota'         => 15,
            'deskripsi'     => 'Paket pendakian santai Gunung Prau via Patak Banteng. Termasuk transportasi PP, tenda, logistik makan 3x, guide lokal, dan dokumentasi.',
        ]);

        Trip::create([
            'nama_trip'     => 'Sailing Komodo & Labuan Bajo',
            'destinasi'     => 'Labuan Bajo, Nusa Tenggara Timur',
            'tgl_berangkat' => '2027-01-10',
            'durasi'        => '3 Hari 2 Malam',
            'harga'         => 2450000,
            'kuota'         => 12,
            'deskripsi'     => 'Eksplorasi Pulau Padar, Pink Beach, Pulau Komodo, dan Taka Makassar menggunakan kapal Phinisi AC.',
        ]);
    }
}