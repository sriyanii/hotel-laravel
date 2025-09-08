<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class GuestController extends Controller
{
    public function index(Request $request)
    {
        // Inisialisasi query untuk mengambil semua tamu
        $query = Guest::query();
        
        // Jika ada query pencarian, terapkan filter
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%')
                  ->orWhere('identity_number', 'like', '%' . $request->search . '%');
            });
        }

        // Ambil hasil pencarian atau semua data tamu jika tidak ada pencarian
        $guests = $query->paginate(5);

        // Kembalikan tampilan dengan data tamu
        return view('guests.index', compact('guests'));
    }

    public function create()
    {
        return view('guests.form');
    }

    public function store(Request $request)
    {
        // Validasi data tamu
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'identity_number' => 'required|string|max:50|unique:guests',
        ]);

        // Buat tamu baru
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

        // Redirect setelah sukses
        return redirect()->route(auth()->user()->role . '.guests.index')
            ->with('success', 'Tamu berhasil ditambahkan.');
    }

    public function edit(Guest $guest)
    {
        return view('guests.form', compact('guest'));
    }

    public function update(Request $request, Guest $guest)
    {
        // Validasi data tamu
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'identity_number' => 'required|string|max:50|unique:guests,identity_number,' . $guest->id,
        ]);

        // Simpan data lama untuk log activity
        $oldData = $guest->toArray();

        // Update data tamu
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

        // Redirect setelah sukses
        return redirect()->route(auth()->user()->role . '.guests.index')
            ->with('success', 'Data tamu berhasil diperbarui.');
    }

    public function show(Guest $guest)
{
    // Menampilkan halaman detail tamu
    return view('guests.show', compact('guest'));
}


    public function destroy(Guest $guest, Request $request)
    {
        // Simpan data lama untuk log activity
        $oldData = $guest->toArray();

        // Log activity sebelum data dihapus
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity_type' => 'delete',
            'description' => 'Menghapus tamu: ' . $guest->name,
            'ip_address' => $request->ip(),
            'role' => auth()->user()->role,
            'old_values' => json_encode($oldData)
        ]);

        // Hapus tamu
        $guest->delete();

        // Redirect setelah sukses
        return redirect()->route(auth()->user()->role . '.guests.index')
            ->with('success', 'Tamu berhasil dihapus.');
    }
}
