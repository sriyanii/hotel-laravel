<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'identity_number'];

    /**
     * Define the relationship between Guest and Booking
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Check if guest has any active bookings
     */
    public function hasActiveBooking(): bool
    {
        return $this->bookings()
            ->whereIn('status', ['booked', 'checked_in'])
            ->exists();
    }
}