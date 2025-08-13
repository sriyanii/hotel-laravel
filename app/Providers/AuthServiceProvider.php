<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
{
    Gate::define('manage-payments', function ($user) {
        return $user->hasRole(['admin', 'resepsionis']); // Gunakan method dari model
    });
}
}