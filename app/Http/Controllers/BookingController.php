<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
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
        $bookings = Booking::with('guest', 'room', 'user')->latest()->get();

        $view = view()->exists(auth()->user()->role . '.bookings.index')
            ? auth()->user()->role . '.bookings.index'
            : 'bookings.index';

        return view($view, compact('bookings'));
    }

    public function create()
    {
        $rooms = Room::where('status', 'tersedia')->get();
        $guests = Guest::all();

        $view = view()->exists(auth()->user()->role . '.bookings.form')
            ? auth()->user()->role . '.bookings.form'
            : 'bookings.form';

        return view($view, compact('rooms', 'guests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guest_id' => 'nullable|exists:guests,id',
            'new_guest_name' => 'nullable|string|max:255',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'status' => 'required|in:Booked,Check-In,Cancelled',
        ]);

        $guestId = $request->guest_id;
        if (!$guestId && $request->new_guest_name) {
            $guest = Guest::create(['name' => $request->new_guest_name]);
            $guestId = $guest->id;
        }

        $room = Room::findOrFail($request->room_id);
        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $duration = $checkOut->diffInDays($checkIn);
        $totalPrice = $room->price * $duration;

        Booking::create([
    'user_id' => Auth::id(),
    'guest_id' => $guestId,
    'room_id' => $request->room_id,
    'check_in' => $request->check_in,
    'check_out' => $request->check_out,
    'status' => strtolower($request->status), // ini yang penting
    'total_price' => $totalPrice,
]);


        return redirect()->route(auth()->user()->role . '.bookings.index')
                         ->with('success', 'Booking berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $rooms = Room::where('status', 'tersedia')->orWhere('id', $booking->room_id)->get();
        $guests = Guest::all();

        $view = view()->exists(auth()->user()->role . '.bookings.form')
            ? auth()->user()->role . '.bookings.form'
            : 'bookings.form';

        return view($view, compact('booking', 'rooms', 'guests'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'guest_id' => 'nullable|exists:guests,id',
            'new_guest_name' => 'nullable|string|max:255',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'status' => 'required|in:Booked,Check-In,Cancelled',
        ]);

        $booking = Booking::findOrFail($id);

        $guestId = $request->guest_id;
        if (!$guestId && $request->new_guest_name) {
            $guest = Guest::create(['name' => $request->new_guest_name]);
            $guestId = $guest->id;
        }

        $room = Room::findOrFail($request->room_id);
        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $duration = $checkOut->diffInDays($checkIn);
        $totalPrice = $room->price * $duration;

        $booking->update([
            'guest_id' => $guestId,
            'room_id' => $request->room_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'status' => $request->status,
            'total_price' => $totalPrice,
        ]);

        return redirect()->route(auth()->user()->role . '.bookings.index')
                         ->with('success', 'Booking berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route(auth()->user()->role . '.bookings.index')
                         ->with('success', 'Booking berhasil dihapus.');
    }
}
