<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResepsionisProfileController extends Controller
{
    public function show()
    {
        return view('resepsionis.profile.show');
    }

    public function edit()
    {
        return view('resepsionis.profile.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
        ]);

        auth()->user()->update($request->only('name', 'email'));

        return redirect()->route('resepsionis.profile.show')->with('success', 'Profil resepsionis berhasil diperbarui.');
    }

    public function showChangePasswordForm()
    {
        return view('resepsionis.profile.change_password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        auth()->user()->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('resepsionis.profile.show')->with('success', 'Password resepsionis berhasil diubah.');
    }
}