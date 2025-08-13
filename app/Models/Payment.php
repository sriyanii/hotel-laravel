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
        'total', // Tambah kolom total
    ];
      protected $casts = [
        'paid_at' => 'datetime',
    ];
    // Relasi ke tabel bookings
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Relasi ke tamu (guest)
    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    // Relasi ke kamar (room)
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // Relasi ke user (admin/resepsionis yang buat booking)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke pembayaran (payment)
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}