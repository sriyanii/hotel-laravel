<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'activity_type',
        'description',
        'ip_address',
        'user_agent',
        'role',
        'old_values',
        'new_values',
        'model_type',
        'model_id'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'System'
        ]);
    }

    // Relasi ke model apapun
    public function model()
    {
        return $this->morphTo();
    }

    // Helper untuk mencatat aktivitas
    public static function log($activityType, $description, $model = null)
    {
        $user = auth()->user();
        
        return self::create([
            'user_id' => $user ? $user->id : null,
            'activity_type' => $activityType,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'role' => $user ? $user->role : 'system',
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model ? $model->id : null,
        ]);
    }
}