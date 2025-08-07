<?php

namespace App\Traits;

use App\Models\UserActivity;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        foreach (static::getModelEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->logActivity($event);
            });
        }
    }

    protected static function getModelEvents()
    {
        return ['created', 'updated', 'deleted'];
    }

    protected function logActivity($event)
    {
        $description = $this->getActivityDescription($event);
        
        UserActivity::create([
            'user_id' => auth()->id(),
            'activity_type' => $event,
            'description' => $description,
            'ip_address' => Request::ip(),
            'device' => Request::userAgent()
        ]);
    }

    protected function getActivityDescription($event)
    {
        $modelName = class_basename($this);
        
        return "{$modelName} has been {$event} by " . auth()->user()->name;
    }
}