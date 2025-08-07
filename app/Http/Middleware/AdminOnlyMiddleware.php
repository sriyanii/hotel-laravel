<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat mengakses laporan keuangan.');
        }

        return $next($request);
    }
}
