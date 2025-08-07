<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResepsionisMiddleware
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

        // Pastikan user memiliki role resepsionis
        if (auth()->user()->role !== 'resepsionis') {
            abort(403, 'Akses ditolak. Hanya untuk resepsionis.');
        }

        return $next($request);
    }
}