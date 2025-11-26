<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['admin', 'resepsionis']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%");
            });
        }

        $users = $query->paginate(10);
        $totalStaff = User::whereIn('role', ['admin', 'resepsionis'])->count();
        $activeStaff = User::whereIn('role', ['admin', 'resepsionis'])->where('status', 'active')->count();
        $onLeaveStaff = User::whereIn('role', ['admin', 'resepsionis'])->where('status', 'on-leave')->count();
        $newHires = User::whereIn('role', ['admin', 'resepsionis'])
                        ->where('created_at', '>=', now()->subDays(30))
                        ->count();

        return view('admin.users.index', compact(
            'users',
            'totalStaff',
            'activeStaff',
            'onLeaveStaff',
            'newHires'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'position' => 'required|string|max:255',
            'department' => 'required|in:front-office,housekeeping,food-beverage,maintenance,management',
            'join_date' => 'required|date',
            'status' => 'required|in:active,inactive,on-leave',
            'salary' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->name = trim($request->first_name . ' ' . $request->last_name);
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->position = $request->position;
        $user->department = $request->department;
        $user->join_date = $request->join_date;
        $user->status = $request->status;
        $user->salary = $request->salary ?? 0;
        $user->notes = $request->notes;
        $user->role = 'resepsionis';
        $user->password = Hash::make($request->password);

        if ($request->hasFile('photo')) {
            $photoName = time() . '_' . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('image'), $photoName);
            $user->photo = $photoName;
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Staff berhasil ditambahkan.');
    }
    
public function update(Request $request, User $user)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'phone' => 'required|string|max:15',
        'address' => 'required|string',
        'position' => 'required|string|max:255',
        'department' => 'required|string',
        'join_date' => 'required|date',
        'status' => 'required|string|in:active,inactive,on-leave',
        'salary' => 'nullable|numeric|min:0',
        'notes' => 'nullable|string',
        'password' => 'nullable|min:6',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;
    $user->name = $request->first_name . ' ' . $request->last_name;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->address = $request->address;
    $user->position = $request->position;
    $user->department = $request->department;
    $user->join_date = $request->join_date;
    $user->status = $request->status;
    $user->salary = $request->salary ?? 0;
    $user->notes = $request->notes;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
        $user->password_plain = $request->password;
    }

    if ($request->hasFile('photo')) {
        if ($user->photo && file_exists(public_path('image/' . $user->photo))) {
            unlink(public_path('image/' . $user->photo));
        }
        $photo = $request->file('photo');
        $photoName = time() . '_' . $photo->getClientOriginalName();
        $photo->move(public_path('image'), $photoName);
        $user->photo = $photoName;
    }

    $user->save();

    return redirect()->route('admin.users.index')->with('success', 'Data resepsionis berhasil diperbarui.');
}

    public function edit(User $user)
    {
        return view('admin.users.form', compact('user'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        // Hapus foto
        if ($user->photo && file_exists(public_path('image/' . $user->photo))) {
            unlink(public_path('image/' . $user->photo));
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Resepsionis berhasil dihapus.');
    }
}