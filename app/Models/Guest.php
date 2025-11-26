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
        'first_name',      // Tambahkan ini
        'last_name',       // Tambahkan ini
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
        'nationality',     // Tambahkan ini
        'city',            // Tambahkan ini
        'country',         // Tambahkan ini
        'profession',      // Tambahkan ini
        'company',         // Tambahkan ini
        'loyalty_points',  // Tambahkan ini
        'social_account',  // Tambahkan ini
        'health_notes',    // Tambahkan ini
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
     * Relationship with reservations
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
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

    /**
     * Boot method to handle creating event
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($guest) {
            // Generate guest code if not set
            if (empty($guest->guest_code)) {
                $guest->guest_code = 'G' . strtoupper(substr(uniqid(), -6));
            }
            
            // Combine first and last name to create full name
            if (empty($guest->name)) {
                $guest->name = trim($guest->first_name . ' ' . ($guest->last_name ?? ''));
            }
        });

        static::updating(function ($guest) {
            // Update name when first_name or last_name changes
            $guest->name = trim($guest->first_name . ' ' . ($guest->last_name ?? ''));
        });
    }
}