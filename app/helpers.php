<?php

if (! function_exists('logActivity')) {
    function logActivity($description) {
        \App\Models\UserActivity::create([
            'user_id' => auth()->id(),
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
