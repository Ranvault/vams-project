<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking')->unique(); // Contoh: VAMS-20261125-ABCD
            $table->foreignId('trip_id')->constrained('trips')->cascadeOnDelete();
            $table->string('nama_pemesan');
            $table->string('no_wa');
            $table->string('email');
            $table->integer('total_tagihan');
            $table->enum('status_booking', ['menunggu_dp', 'dp_terverifikasi', 'lunas', 'batal'])->default('menunggu_dp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
