<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminResepsionisMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Periksa apakah user memiliki role admin atau resepsionis
        if (!in_array(auth()->user()->role, ['admin', 'resepsionis'])) {
            abort(403, 'Akses ditolak. Hanya untuk admin dan resepsionis.');
        }

        return $next($request);
    }
}