<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'guest_id',
        'room_id',
        'check_in',
        'check_out',
        'status',
    ];

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
