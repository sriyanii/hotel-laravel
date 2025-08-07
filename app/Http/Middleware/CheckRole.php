<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        Log::info('CheckRole middleware executed', [
            'user' => Auth::id(),
            'required_role' => $role
        ]);

        if (!Auth::check()) {
            Log::warning('User not authenticated');
            return redirect()->route('login');
        }

        Log::info('User role check', [
            'actual_role' => Auth::user()->role,
            'required_role' => $role
        ]);

        if (Auth::user()->role !== $role) {
            Log::warning('Role mismatch', [
                'user_id' => Auth::id(),
                'actual_role' => Auth::user()->role,
                'required_role' => $role
            ]);
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
