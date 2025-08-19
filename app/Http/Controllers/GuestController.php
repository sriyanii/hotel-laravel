<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class GuestController extends Controller
{
    public function index()
    {
        $guests = Guest::all();
        return view('guests.index', compact('guests'));
    }

    public function create()
    {
        return view('guests.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'identity_number' => 'required|string|max:50|unique:guests',
        ]);

        $guest = Guest::create($validated);

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity_type' => 'create',
            'description' => 'Menambahkan tamu baru: ' . $guest->name,
            'ip_address' => $request->ip(),
            'role' => auth()->user()->role,
            'new_values' => json_encode($guest->toArray())
        ]);

        return redirect()->route(auth()->user()->role . '.guests.index')
            ->with('success', 'Tamu berhasil ditambahkan.');
    }

    public function edit(Guest $guest)
    {
        return view('guests.form', compact('guest'));
    }

    public function update(Request $request, Guest $guest)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'identity_number' => 'required|string|max:50|unique:guests,identity_number,' . $guest->id,
        ]);

        $oldData = $guest->toArray();

        $guest->update($validated);

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity_type' => 'update',
            'description' => 'Memperbarui data tamu: ' . $guest->name,
            'ip_address' => $request->ip(),
            'role' => auth()->user()->role,
            'old_values' => json_encode($oldData),
            'new_values' => json_encode($validated)
        ]);

        return redirect()->route(auth()->user()->role . '.guests.index')
            ->with('success', 'Data tamu berhasil diperbarui.');
    }

    public function destroy(Guest $guest, Request $request)
    {
        $oldData = $guest->toArray();

        // Log activity sebelum dihapus
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity_type' => 'delete',
            'description' => 'Menghapus tamu: ' . $guest->name,
            'ip_address' => $request->ip(),
            'role' => auth()->user()->role,
            'old_values' => json_encode($oldData)
        ]);

        $guest->delete();

        return redirect()->route(auth()->user()->role . '.guests.index')
            ->with('success', 'Tamu berhasil dihapus.');
    }
}
