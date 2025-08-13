<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    // Konstanta untuk jenis aktivitas
    public const TYPE_CREATE = 'create';
    public const TYPE_UPDATE = 'update';
    public const TYPE_DELETE = 'delete';
    public const TYPE_LOGIN = 'login';
    public const TYPE_LOGOUT = 'logout';

    // Konstanta untuk role
    public const ROLE_RESEPSIONIS = 'resepsionis';
    public const ROLE_ADMIN = 'admin';

    protected $fillable = [
        'user_id',
        'activity_type',
        'description',
        'ip_address',
        'device',
        'browser',
        'platform',
        'role',
        'target_role',
        'old_values',
        'new_values'
    ];

    protected $appends = [
        'time_ago',
        'activity_badge_class'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Method untuk mendapatkan class badge
    public function getActivityBadgeClass()
{
    return match ($this->activity_type ?? '') {
        'login'     => 'bg-success',
        'logout'    => 'bg-secondary',
        'error'     => 'bg-danger',
        'update'    => 'bg-warning',
        default     => 'bg-info',
    };
}


    // Scope untuk aktivitas resepsionis
    public function scopeResepsionisActivities($query)
    {
        return $query->where(function($q) {
            $q->where('role', self::ROLE_RESEPSIONIS)
              ->orWhere('target_role', self::ROLE_RESEPSIONIS);
        });
    }

    // Scope untuk aktivitas admin
    public function scopeAdminActivities($query)
    {
        return $query->where(function($q) {
            $q->where('role', self::ROLE_ADMIN)
              ->orWhere('target_role', self::ROLE_ADMIN);
        });
    }

    // Method untuk waktu yang mudah dibaca
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    // Scope untuk filter tanggal
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [
            Carbon::parse($startDate)->startOfDay(),
            Carbon::parse($endDate)->endOfDay()
        ]);
    }

    // Daftar jenis aktivitas
    public static function getActivityTypes()
    {
        return [
            self::TYPE_CREATE => 'Buat Data',
            self::TYPE_UPDATE => 'Perbarui Data',
            self::TYPE_DELETE => 'Hapus Data',
            self::TYPE_LOGIN => 'Login',
            self::TYPE_LOGOUT => 'Logout'
        ];
    }

    // Method untuk mencatat aktivitas baru
    public static function logActivity($data)
    {
        // Deteksi browser dan platform
        $agent = new \Jenssegers\Agent\Agent();
        
        return self::create([
            'user_id' => auth()->id(),
            'activity_type' => $data['type'],
            'description' => $data['description'],
            'ip_address' => request()->ip(),
            'device' => $agent->device(),
            'browser' => $agent->browser(),
            'platform' => $agent->platform(),
            'role' => auth()->user()->role ?? null,
            'old_values' => json_encode($data['old_values'] ?? null),
            'new_values' => json_encode($data['new_values'] ?? null)
        ]);
    }
}