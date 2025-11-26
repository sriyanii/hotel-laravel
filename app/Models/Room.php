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
        'capacity',
        'floor',
        'tipe_kamar_id',
        'room_size',
        'bed_type',
        'max_occupancy',
        'features'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'facilities' => 'array',
        'features' => 'array'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function currentBooking()
    {
        return $this->hasOne(Booking::class)
                    ->whereIn('status', ['confirmed', 'checked_in'])
                    ->latest();
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

    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'room_facility', 'room_id', 'facility_id')
                    ->withTimestamps();
    }

    public function bookedRoomsCount()
    {
        return $this->whereIn('status', ['terisi', 'maintenance', 'dipesan'])->count();
    }

}