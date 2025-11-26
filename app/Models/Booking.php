<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'guest_id',
        'customer_id',
        'room_id',
        'room_id',
        'check_in',
        'check_out',
        'status',
    ];

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'total_price' => 'integer',
    ];

    // Relasi ke tamu (guest)
    public function guest()
{
    return $this->belongsTo(Guest::class)->withDefault([
        'name' => 'Guest Deleted'
    ]);
}

public function room()
{
    return $this->belongsTo(Room::class)->withDefault([
        'number' => 'Room Deleted'
    ]);
}

public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
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

    // Accessor untuk durasi menginap
    public function getDurationNightsAttribute()
    {
        return $this->check_out->diffInDays($this->check_in);
    }

    // Accessor untuk format check_in
    public function getFormattedCheckInAttribute()
    {
        return $this->check_in->format('d/m/Y');
    }

    // Accessor untuk format check_out
    public function getFormattedCheckOutAttribute()
    {
        return $this->check_out->format('d/m/Y');
    }

public function facilities()
{
    return $this->belongsToMany(Facility::class, 'booking_facility')
                ->withPivot('price', 'quantity', 'start_date', 'end_date')
                ->withTimestamps();
}

    public function activeBooking()
    {
        $today = now()->toDateString();
        return $this->bookings()
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->first();
    }


    
public function getPricePerNightAttribute()
{
    return $this->room?->tipeKamar?->price ?? 0;
}

public function getNightsAttribute()
{
    return $this->check_out->diffInDays($this->check_in);
}

// Helper methods
    public function isCheckedIn()
    {
        return !is_null($this->checked_in_at);
    }

    public function isCheckedOut()
    {
        return !is_null($this->checked_out_at);
    }

    public function canCheckIn()
    {
        return $this->status === 'confirmed' && !$this->isCheckedIn();
    }

    public function canCheckOut()
    {
        return $this->isCheckedIn() && !$this->isCheckedOut();
    }
    
    public function bookedBy()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function additionalFacilities()
{
    return $this->hasMany(BookingFacility::class, 'booking_id');
}

}