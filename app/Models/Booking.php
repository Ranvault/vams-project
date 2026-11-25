<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'kode_booking', 'trip_id', 'nama_pemesan', 'no_wa', 'email', 'total_tagihan', 'status_booking'
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}