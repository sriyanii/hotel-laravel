<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ActivityLog;

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
        $bookedRoomIds = Booking::whereNotIn('status', ['checked_out', 'canceled'])
                        ->pluck('room_id');
        
        $rooms = Room::whereNotIn('id', $bookedRoomIds)->get();
        $guests = Guest::all();
        
        return view('bookings.form', [
            'booking' => null,
            'rooms' => $rooms,
            'guests' => $guests
        ]);
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        
        $bookedRoomIds = Booking::whereNotIn('status', ['checked_out', 'canceled'])
                        ->where('id', '!=', $id)
                        ->pluck('room_id');
        
        $rooms = Room::whereNotIn('id', $bookedRoomIds)
                ->orWhere('id', $booking->room_id)
                ->get();
        
        $guests = Guest::all();
        
        return view('bookings.form', compact('booking', 'rooms', 'guests'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules());
        
        // Add the current user ID to the booking
        $validated['user_id'] = auth()->id();
        
        if ($request->filled('new_guest_name')) {
            $guest = Guest::create([
                'name' => $request->new_guest_name,
                'phone' => $request->new_guest_phone,
                'identity_number' => $request->new_guest_identity
            ]);
            $validated['guest_id'] = $guest->id;
        }
        
        Booking::create($validated);
        
        return redirect()->route(auth()->user()->role . '.bookings.index')
               ->with('success', 'Booking created successfully');
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        $validated = $request->validate($this->validationRules());
        
        if ($request->filled('new_guest_name')) {
            $guest = Guest::create([
                'name' => $request->new_guest_name,
                'phone' => $request->new_guest_phone,
                'identity_number' => $request->new_guest_identity
            ]);
            $validated['guest_id'] = $guest->id;
        }
        
        $booking->update($validated);
        
        return redirect()->route(auth()->user()->role . '.bookings.index')
               ->with('success', 'Booking updated successfully');
    }

    protected function validationRules()
    {
        return [
            'guest_id' => 'nullable|exists:guests,id',
            'new_guest_name' => 'nullable|string|max:255',
            'new_guest_phone' => 'nullable|string|max:20',
            'new_guest_identity' => 'nullable|string|max:50',
            'room_id' => [
                'required',
                'exists:rooms,id',
                function ($attribute, $value, $fail) {
                    $isBooked = Booking::where('room_id', $value)
                                ->whereNotIn('status', ['checked_out', 'canceled'])
                                ->exists();
                    
                    if ($isBooked) {
                        $fail('The selected room is already booked.');
                    }
                },
            ],
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'status' => 'required|in:booked,checked_in,checked_out,canceled'
        ];
    }
}