<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // file login.blade.php kamu
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:admin,resepsionis',
        ]);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $user = Auth::user();

            if ($user->role !== $credentials['role']) {
                Auth::logout();
                return back()->withErrors(['role' => 'Role tidak sesuai dengan akun ini.']);
            }

            $request->session()->regenerate();

            // Redirect sesuai role
            return redirect()->route($user->role . '.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau kata sandi salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.form');
    }
}
