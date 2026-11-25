<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = ['booking_id', 'nama_peserta', 'no_identitas', 'kontak_darurat'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}