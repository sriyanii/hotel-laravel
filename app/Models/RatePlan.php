<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RatePlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'room_types',
        'start_date',
        'end_date',
        'rate_adjustment_sign',
        'rate_adjustment_value',
        'rate_adjustment_type',
        'min_stay',
        'release_days',
        'description',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'room_types' => 'array',
        'is_active' => 'boolean',
        'min_stay' => 'integer',
        'release_days' => 'integer',
        'rate_adjustment_value' => 'float',
    ];

    protected $attributes = [
        'is_active' => true,
        'min_stay' => 1,
        'release_days' => 0,
        'rate_adjustment_sign' => '+',
        'rate_adjustment_type' => 'percentage',
    ];

    /**
     * Boot method for model events
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->start_date && $model->end_date) {
                if ($model->end_date->lt($model->start_date)) {
                    throw new \Exception('End date cannot be before start date.');
                }
            }
        });
    }

    /**
     * Accessor for rate adjustment display
     */
    public function getRateAdjustmentDisplayAttribute()
    {
        $sign = $this->rate_adjustment_sign;
        $value = $this->rate_adjustment_value;
        $type = $this->rate_adjustment_type;

        if ($type === 'percentage') {
            return "{$sign}{$value}%";
        } else {
            return "{$sign}" . number_format($value, 0, ',', '.');
        }
    }

    /**
     * Accessor for status
     */
    public function getStatusAttribute()
    {
        // Jika tidak aktif, langsung return expired
        if (!$this->is_active) {
            return 'expired';
        }

        $now = now();
        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);

        // Validasi tanggal
        if (!$start || !$end) {
            return 'expired';
        }

        if ($now->between($start, $end)) {
            return 'active';
        } elseif ($now->lt($start)) {
            return 'upcoming'; 
        } else {
            return 'expired';
        }
    }

    /**
     * Scope for active rate plans (based on date)
     */
    public function scopeCurrentlyActive($query)
    {
        $now = now()->format('Y-m-d');
        return $query->where('is_active', true)
                    ->where('start_date', '<=', $now)
                    ->where('end_date', '>=', $now);
    }

    /**
     * Scope for upcoming rate plans
     */
    public function scopeUpcoming($query)
    {
        $now = now()->format('Y-m-d');
        return $query->where('is_active', true)
                    ->where('start_date', '>', $now);
    }

    /**
     * Scope for expired rate plans (based on date only)
     */
    public function scopeExpired($query)
    {
        $now = now()->format('Y-m-d');
        return $query->where('end_date', '<', $now);
    }

    /**
     * Scope for inactive rate plans
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope for filtering by status
     */
    public function scopeWithStatus($query, $status)
    {
        return match($status) {
            'active' => $query->currentlyActive(),
            'upcoming' => $query->upcoming(),
            'expired' => $query->expired(),
            'inactive' => $query->inactive(),
            default => $query
        };
    }

    /**
     * Scope for filtering by type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Check if rate plan is currently applicable for a given date
     */
    public function isApplicableOn($date = null)
    {
        $date = $date ? Carbon::parse($date) : now();
        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);

        return $this->is_active && $date->between($start, $end);
    }

    /**
     * Calculate adjusted price
     */
    public function calculateAdjustedPrice($basePrice)
    {
        $adjustment = $this->rate_adjustment_value;
        
        if ($this->rate_adjustment_sign === '-') {
            $adjustment = -$adjustment;
        }

        if ($this->rate_adjustment_type === 'percentage') {
            return $basePrice * (1 + $adjustment / 100);
        } else {
            return $basePrice + $adjustment;
        }
    }
}