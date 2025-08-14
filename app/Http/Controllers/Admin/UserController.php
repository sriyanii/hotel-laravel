<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'resepsionis')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $users = User::where('role', 'resepsionis')->get();
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone'    => 'required',
            'address'  => 'required',
            'photo'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->role = 'resepsionis';
        $user->password = Hash::make($request->password);
        $user->password_plain = $request->password;

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('photos', 'public');
            $user->photo = basename($photo);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Resepsionis ditambahkan.');
    }

    public function edit(User $user)
    {
        $users = User::where('role', 'resepsionis')->get();
        return view('admin.users.index', [
            'users' => $users,
            'editUser' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'   => 'required',
            'address'  => 'required',
            'password' => 'nullable|min:6',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->password_plain = $request->password;
        }

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete('photos/' . $user->photo);
            }

            $photo = $request->file('photo')->store('photos', 'public');
            $user->photo = basename($photo);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Resepsionis diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->photo) {
            Storage::disk('public')->delete('photos/' . $user->photo);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Resepsionis dihapus.');
    }
}