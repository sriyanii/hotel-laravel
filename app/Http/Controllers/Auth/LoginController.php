<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;

            // Redirect berdasarkan role
            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($role === 'resepsionis') {
                return redirect()->route('resepsionis.dashboard');
            } else {
                Auth::logout();
                return back()->withErrors(['email' => 'Role tidak dikenali.']);
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
    protected function authenticated(Request $request, $user)
{
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'resepsionis') {
        return redirect()->route('resepsionis.dashboard');
    }

    auth()->logout();
    return redirect()->route('login')->with('error', 'Role tidak valid.');
}

}

