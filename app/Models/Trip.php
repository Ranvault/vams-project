<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'nama_trip', 'destinasi', 'tgl_berangkat', 'durasi', 'harga', 'kuota', 'deskripsi', 'poster'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}