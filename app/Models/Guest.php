<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_code',
        'name',
        'phone',
        'identity_number',
        'date_of_birth',
        'notes',
        'photo',
        'marital_status',
        'guest_type',
        'address',           
        'gender',            
        'email',             
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Relationship with bookings
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

    /**
     * Accessor to get age from date_of_birth
     */
    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

    /**
     * Check if guest is VIP or VVIP
     */
    public function isVip(): bool
    {
        return in_array($this->guest_type, ['vip', 'vvip']);
    }
}
