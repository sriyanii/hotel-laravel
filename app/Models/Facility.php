<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $table = 'facilities';

    protected $fillable = [
        'name',
        'description',
        'image',
        'status',
        'capacity',
        'price_per_night',
    ];

    /**
     * Rooms that have this facility (many-to-many)
     */
    public function rooms()
    {
        // jika pivot table bernama room_facility:
        return $this->belongsToMany(Room::class, 'room_facility', 'facility_id', 'room_id')
                    ->withTimestamps();
    }

    // scope aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

public function bookings()
{
    return $this->belongsToMany(Booking::class, 'booking_facility')
                ->withPivot(['price', 'start_date', 'end_date'])
                ->withTimestamps();
}


    public function isBooked(): bool
    {
        $today = now()->toDateString();
        return $this->bookings()
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->exists();
    }

        public function activeBooking()
    {
        $today = now()->toDateString();
        return $this->bookings()
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->first();
    }

        public function getDynamicStatusAttribute()
    {
        return $this->isBooked() ? 'inactive' : $this->status;
    }

}
