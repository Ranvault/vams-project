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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('nama_trip');
            $table->string('destinasi');
            $table->date('tgl_berangkat');
            $table->string('durasi'); // Contoh: "3 Hari 2 Malam"
            $table->integer('harga');
            $table->integer('kuota');
            $table->text('deskripsi');
            $table->string('poster')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
