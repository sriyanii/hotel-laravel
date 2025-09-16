<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeKamar extends Model
{
    use HasFactory;

    protected $table = 'tipe_kamar'; 
    protected $primaryKey = 'id';    

    protected $fillable = [
        'tipe_kamar',
        'jumlah_kamar',
        'kamar_tersedia',
    ];

    // Relationship with rooms
    public function rooms()
    {
        return $this->hasMany(Room::class, 'tipe_kamar_id');
    }

    // Calculate available rooms based on status
    public function availableRooms()
    {
        // Menghitung kamar yang tersedia dengan mengecualikan status 'terisi', 'maintenance', dan 'dipesan'
        return $this->jumlah_kamar - $this->rooms()->whereIn('status', ['terisi', 'maintenance', 'dipesan'])->count();
    }

    // This method is redundant, you can remove it.
    // public function kamarTersedia()
    // {
    //     return $this->rooms()
    //         ->whereNotIn('status', ['terisi', 'maintenance', 'dipesan'])
    //         ->count();
    // }
}
