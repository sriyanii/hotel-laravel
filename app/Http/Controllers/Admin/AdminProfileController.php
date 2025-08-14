<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    // Tampilkan profil admin
    public function show()
    {
        return view('admin.profile.show'); // pastikan file view admin/profile/show.blade.php ada
    }

    // Form edit profil
    public function edit()
    {
        return view('admin.profile.edit'); // pastikan file view admin/profile/edit.blade.php ada
    }

    // Update profil
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->only('name', 'email');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        auth()->user()->update($data);

        return redirect()->route('admin.profile.show')->with('success', 'Profil admin berhasil diperbarui.');
    }

    // Form ganti password
    public function showChangePasswordForm()
    {
        return view('admin.profile.change_password'); // pastikan view admin/profile/change_password.blade.php ada
    }

    // Proses ganti password
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        auth()->user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('admin.profile.show')->with('success', 'Password berhasil diubah.');
    }
}
