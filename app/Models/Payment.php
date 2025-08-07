<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'amount',
        'paid_at',
        'method',
    ];

    // Relasi ke tabel bookings
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
