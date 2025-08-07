<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Pastikan user sudah login
        if (!auth()->check()) {
            Log::warning('Attempt to access admin route by unauthenticated user', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent()
            ]);
            
            return redirect()->route('login')->with('error', 'Please login first');
        }

        // 2. Verifikasi role admin
        if (auth()->user()->role !== 'admin') {
            $user = auth()->user();
            Log::warning('Unauthorized admin access attempt', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'user_role' => $user->role,
                'ip' => $request->ip(),
                'url' => $request->fullUrl()
            ]);

            // 3. Response berbeda berdasarkan request type
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthorized access',
                    'errors' => ['You do not have permission to access this resource']
                ], 403);
            }

            // 4. Redirect dengan pesan error untuk web request
            return redirect()
                ->route('dashboard')
                ->with('error', 'You do not have permission to access this page');
        }

        // 5. Tambahkan header khusus untuk admin routes
        $response = $next($request);
        $response->headers->set('X-Admin-Access', 'true');
        
        return $response;
    }
}