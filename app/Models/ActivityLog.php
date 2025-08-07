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
        'device'
    ];

    // Define relationship to User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Helper method to get activity badge class
    public function getActivityBadgeClass()
    {
        if (str_contains($this->activity_type, 'create')) {
            return 'bg-success';
        } elseif (str_contains($this->activity_type, 'update')) {
            return 'bg-primary';
        } elseif (str_contains($this->activity_type, 'delete')) {
            return 'bg-danger';
        }
        return 'bg-info';
    }
}