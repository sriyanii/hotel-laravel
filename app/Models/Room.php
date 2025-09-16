<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'number',
        'price',
        'status',
        'photo',
        'description',
        'tipe_kamar_id',
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isAvailable($checkIn, $checkOut)
    {
        return !$this->bookings()
            ->whereNotIn('status', ['checked_out', 'canceled'])
            ->where(function($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in', [$checkIn, $checkOut])
                      ->orWhereBetween('check_out', [$checkIn, $checkOut])
                      ->orWhere(function($q) use ($checkIn, $checkOut) {
                          $q->where('check_in', '<', $checkIn)
                            ->where('check_out', '>', $checkOut);
                      });
            })
            ->exists();
    }

public function tipeKamar()
{
    return $this->belongsTo(TipeKamar::class, 'tipe_kamar_id');
}




    public function bookedRoomsCount()
    {
        return $this->whereIn('status', ['terisi', 'maintenance', 'dipesan'])->count();
    }

}