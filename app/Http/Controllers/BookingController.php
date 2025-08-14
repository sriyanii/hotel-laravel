<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function index()
    {
        try {
            $bookings = Booking::with(['guest', 'room', 'user'])
                            ->orderBy('created_at', 'desc')
                            ->get();

            $view = view()->exists(auth()->user()->role . '.bookings.index')
                ? auth()->user()->role . '.bookings.index'
                : 'bookings.index';

            return view($view, compact('bookings'));
        } catch (\Exception $e) {
            Log::error('Error accessing bookings index: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat daftar booking.');
        }

        $rooms = Room::whereDoesntHave('bookings', function($query) {
        $query->whereIn('status', ['booked', 'checked_in']);
    })->get();

    // Get only guests without active bookings
    $guests = Guest::whereDoesntHave('bookings', function($query) {
        $query->whereIn('status', ['booked', 'checked_in']);
    })->get();

    return view('bookings.form', [
        'rooms' => $rooms,
        'guests' => $guests,
    ]);
    }
    
    public function create()
    {
        try {
            $bookedRoomIds = Booking::whereNotIn('status', ['checked_out', 'canceled'])
                            ->pluck('room_id');
            
            $rooms = Room::whereNotIn('id', $bookedRoomIds)->get();
            $guests = Guest::all();
            
            return view('bookings.form', [
                'booking' => null,
                'rooms' => $rooms,
                'guests' => $guests
            ]);
        } catch (\Exception $e) {
            Log::error('Error accessing booking create form: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat form booking.');
        }
    }

    public function edit($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            
            $bookedRoomIds = Booking::whereNotIn('status', ['checked_out', 'canceled'])
                            ->where('id', '!=', $id)
                            ->pluck('room_id');
            
            $rooms = Room::whereNotIn('id', $bookedRoomIds)
                    ->orWhere('id', $booking->room_id)
                    ->get();
            
            $guests = Guest::all();
            
            return view('bookings.form', compact('booking', 'rooms', 'guests'));
        } catch (\Exception $e) {
            Log::error('Error accessing booking edit form: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat form edit booking.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate($this->validationRules());
            
            $validated['user_id'] = auth()->id();
            
            if ($request->filled('new_guest_name')) {
                $guest = Guest::create([
                    'name' => $request->new_guest_name,
                    'phone' => $request->new_guest_phone,
                    'identity_number' => $request->new_guest_identity
                ]);
                $validated['guest_id'] = $guest->id;
            }
            
            $booking = Booking::create($validated);
            $room = Room::find($validated['room_id']);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity_type' => 'create',
                'description' => 'Membuat booking baru untuk kamar ' . $room->room_number,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'method' => request()->method(),
                'url' => request()->fullUrl(),
                'role' => auth()->user()->role,
                'data' => json_encode($validated)
            ]);
            
            return redirect()->route(auth()->user()->role . '.bookings.index')
                   ->with('success', 'Booking berhasil dibuat');
        } catch (\Exception $e) {
            Log::error('Error creating booking: ' . $e->getMessage());
            return back()->with('error', 'Gagal membuat booking.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $oldData = $booking->toArray();
            
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

            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity_type' => 'update',
                'description' => 'Memperbarui booking #' . $booking->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'method' => request()->method(),
                'url' => request()->fullUrl(),
                'role' => auth()->user()->role,
                'old_values' => json_encode($oldData),
                'new_values' => json_encode($validated)
            ]);
            
            return redirect()->route(auth()->user()->role . '.bookings.index')
                   ->with('success', 'Booking berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Error updating booking: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui booking.');
        }
    }

    public function destroy($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $bookingData = $booking->toArray();
            
            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity_type' => 'delete',
                'description' => 'Membatalkan booking #' . $booking->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'method' => request()->method(),
                'url' => request()->fullUrl(),
                'role' => auth()->user()->role,
                'old_values' => json_encode($bookingData)
            ]);
            
            $booking->delete();
            
            return redirect()->route(auth()->user()->role . '.bookings.index')
                   ->with('success', 'Booking berhasil dibatalkan');
        } catch (\Exception $e) {
            Log::error('Error deleting booking: ' . $e->getMessage());
            return back()->with('error', 'Gagal membatalkan booking.');
        }
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
                        $fail('Kamar sudah dipesan.');
                    }
                },
            ],
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'status' => 'required|in:booked,checked_in,checked_out,canceled'
        ];
    }
}