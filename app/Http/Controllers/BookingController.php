<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['guest', 'room', 'user'])
                          ->orderBy('created_at', 'desc')
                          ->get();

        $view = view()->exists(auth()->user()->role . '.bookings.index')
            ? auth()->user()->role . '.bookings.index'
            : 'bookings.index';

        return view($view, compact('bookings'));
    }

    public function create()
    {
        $rooms = Room::orderBy('number')->get();
        $guests = Guest::orderBy('name')->get();

        $view = view()->exists(auth()->user()->role . '.bookings.form')
            ? auth()->user()->role . '.bookings.form'
            : 'bookings.form';

        return view($view, compact('rooms', 'guests'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'guest_id' => 'nullable|exists:guests,id',
            'new_guest_name' => 'nullable|string|max:255',
            'new_guest_phone' => 'nullable|string|max:20',
            'new_guest_identity' => 'nullable|string|max:20',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'status' => 'required|in:booked,checked_in,checked_out,canceled',
        ]);

        $guestId = $validatedData['guest_id'];
        if (!$guestId && $validatedData['new_guest_name']) {
            $guest = Guest::create([
                'name' => $validatedData['new_guest_name'],
                'phone' => $validatedData['new_guest_phone'] ?? '-',
                'identity_number' => $validatedData['new_guest_identity'] ?? '-',
            ]);
            $guestId = $guest->id;
        }

        $room = Room::findOrFail($validatedData['room_id']);
        $checkIn = Carbon::parse($validatedData['check_in']);
        $checkOut = Carbon::parse($validatedData['check_out']);
        $duration = $checkOut->diffInDays($checkIn);

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'guest_id' => $guestId,
            'room_id' => $room->id,
            'check_in' => $validatedData['check_in'],
            'check_out' => $validatedData['check_out'],
            'status' => $validatedData['status'],
            'total_price' => $room->price, // Store the room price per night
        ]);

        if ($validatedData['status'] === 'checked_in') {
            $room->update(['status' => 'terisi']);
        } elseif ($validatedData['status'] === 'booked') {
            $room->update(['status' => 'dipesan']);
        }

        return redirect()->route(auth()->user()->role . '.bookings.index')->with('success', 'Booking berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $booking = Booking::with('guest', 'room')->findOrFail($id);
        $booking->check_in = Carbon::parse($booking->check_in);
        $booking->check_out = Carbon::parse($booking->check_out);

        $rooms = Room::orderBy('number')->get();
        $guests = Guest::orderBy('name')->get();

        $view = view()->exists(auth()->user()->role . '.bookings.form')
            ? auth()->user()->role . '.bookings.form'
            : 'bookings.form';

        return view($view, compact('booking', 'rooms', 'guests'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'guest_id' => 'nullable|exists:guests,id',
            'new_guest_name' => 'nullable|string|max:255',
            'new_guest_phone' => 'nullable|string|max:20',
            'new_guest_identity' => 'nullable|string|max:20',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'status' => 'required|in:booked,checked_in,checked_out,canceled',
        ]);

        $booking = Booking::findOrFail($id);
        $originalRoom = $booking->room;
        $newRoom = Room::findOrFail($validatedData['room_id']);
        $guestId = $validatedData['guest_id'];

        if (!$guestId && $validatedData['new_guest_name']) {
            $guest = Guest::create([
                'name' => $validatedData['new_guest_name'],
                'phone' => $validatedData['new_guest_phone'] ?? '-',
                'identity_number' => $validatedData['new_guest_identity'] ?? '-',
            ]);
            $guestId = $guest->id;
        }

        $checkIn = Carbon::parse($validatedData['check_in']);
        $checkOut = Carbon::parse($validatedData['check_out']);

        $booking->update([
            'guest_id' => $guestId,
            'room_id' => $validatedData['room_id'],
            'check_in' => $validatedData['check_in'],
            'check_out' => $validatedData['check_out'],
            'status' => $validatedData['status'],
            'total_price' => $newRoom->price, // Update with new room price
        ]);

        if ($originalRoom->id != $newRoom->id) {
            $originalRoom->update(['status' => 'tersedia']);
        }

        if ($validatedData['status'] === 'checked_in') {
            $newRoom->update(['status' => 'terisi']);
        } elseif (in_array($validatedData['status'], ['canceled', 'checked_out'])) {
            $newRoom->update(['status' => 'tersedia']);
        } elseif ($validatedData['status'] === 'booked') {
            $newRoom->update(['status' => 'dipesan']);
        }

        return redirect()->route(auth()->user()->role . '.bookings.index')->with('success', 'Booking berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $room = $booking->room;

        $booking->delete();

        if ($room) {
            $room->update(['status' => 'tersedia']);
        }

        return redirect()->route(auth()->user()->role . '.bookings.index')->with('success', 'Booking berhasil dihapus.');
    }
}