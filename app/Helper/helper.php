<?php

use App\Models\UserActivity;

if (! function_exists('logActivity')) {
    function logActivity($type, $description = null)
    {
        UserActivity::create([
            'user_id'      => auth()->id(),
            'activity_type'=> $type,
            'description'  => $description,
            'ip_address'   => request()->ip(),
        ]);
    }
}
