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
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'identity_number' => 'required',
        ]);

        Guest::create($request->all());
        return redirect()->route(auth()->user()->role . '.guests.index')->with('success', 'Tamu berhasil ditambahkan.');
    }

    public function edit(Guest $guest)
    {
        return view('guests.form', compact('guest'));
    }

    public function update(Request $request, Guest $guest)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'identity_number' => 'required',
        ]);

        $guest->update($request->all());
        return redirect()->route(auth()->user()->role . '.guests.index')->with('success', 'Data tamu berhasil diupdate.');
    }

    public function destroy(Guest $guest)
    {
        $guest->delete();
        return redirect()->route(auth()->user()->role . '.guests.index')->with('success', 'Tamu berhasil dihapus.');
    }
}
