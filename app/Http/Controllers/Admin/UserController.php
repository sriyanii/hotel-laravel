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
            // Simpan foto ke public/imge
            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('imge'), $photoName);
            $user->photo = $photoName;
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
            // Hapus foto lama jika ada
            if ($user->photo && file_exists(public_path('imge/' . $user->photo))) {
                unlink(public_path('imge/' . $user->photo));
            }

            // Simpan foto baru ke public/imge
            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('imge'), $photoName);
            $user->photo = $photoName;
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Resepsionis diperbarui.');
    }

    public function destroy(User $user)
    {
        // Hapus foto dari public/imge
        if ($user->photo && file_exists(public_path('imge/' . $user->photo))) {
            unlink(public_path('imge/' . $user->photo));
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Resepsionis dihapus.');
    }
}