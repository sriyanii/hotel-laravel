<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use App\Models\Facility;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');

        $bookings = Booking::with(['guest', 'room.tipeKamar', 'user', 'facilities'])
            ->when($search, fn($query) => $query->whereHas('guest', fn($q) => $q->where('name', 'like', "%$search%"))
                                               ->orWhereHas('room', fn($q) => $q->where('number', 'like', "%$search%"))
                                               ->orWhere('status', 'like', "%$search%"))
            ->when($status, fn($query, $status) => $query->where('status', $status))
            ->paginate(5);

        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        try {
            $rooms = Room::with('tipeKamar')->where('status', 'tersedia')->get();
            $guests = Guest::all();
            $facilities = Facility::where('status', 'active')->get();

            return view('bookings.form', compact('rooms', 'guests', 'facilities'))->with('booking', null);
        } catch (\Exception $e) {
            Log::error('Error accessing booking create form: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat form booking.');
        }
    }

    public function edit($id)
    {
        try {
            $booking = Booking::with('room.tipeKamar', 'facilities')->findOrFail($id);
            $rooms = Room::with('tipeKamar')
                         ->where('status', 'tersedia')
                         ->orWhere('id', $booking->room_id)
                         ->get();
            $guests = Guest::all();
            $facilities = Facility::where('status', 'active')->get();

            return view('bookings.form', compact('booking', 'rooms', 'guests', 'facilities'));
        } catch (\Exception $e) {
            Log::error('Error accessing booking edit form: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat form edit booking.');
        }
    }

    public function show($id)
    {
        try {
            $booking = Booking::with(['guest', 'room.tipeKamar', 'user', 'facilities'])->findOrFail($id);
            return view('bookings.show', compact('booking'));
        } catch (\Exception $e) {
            Log::error('Error accessing booking details: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat detail booking.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate($this->validationRules());

            if ($request->filled('new_guest_name')) {
                $guest = Guest::create([
                    'name' => $request->new_guest_name,
                    'phone' => $request->new_guest_phone,
                    'identity_number' => $request->new_guest_identity
                ]);
                $validated['guest_id'] = $guest->id;
            }

            $room = Room::with('tipeKamar')->findOrFail($validated['room_id']);
            if ($room->status !== 'tersedia') return back()->with('error', 'Kamar ' . $room->number . ' tidak tersedia.');

            $validated['user_id'] = auth()->id();
            $booking = Booking::create($validated);

            $room->update(['status' => 'terisi']);

            if ($request->filled('facilities')) {
                $facilityData = [];
                foreach ($request->facilities as $facilityId) {
                    $facility = Facility::find($facilityId);
                    if ($facility) {
                        $facilityData[$facilityId] = [
                            'price' => $facility->price_per_night,
                            'start_date' => $request->facility_start_date,
                            'end_date' => $request->facility_end_date
                        ];
                        $facility->update(['status' => 'inactive']);
                    }
                }
                $booking->facilities()->sync($facilityData);
            }

            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity_type' => 'create',
                'description' => 'Membuat booking baru untuk kamar ' . $room->number,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'role' => auth()->user()->role,
                'data' => json_encode($validated)
            ]);

            return redirect()->route(auth()->user()->role . '.bookings.index')
                             ->with('success', 'Booking berhasil dibuat!');
        } catch (\Exception $e) {
            Log::error('Error creating booking: ' . $e->getMessage());
            return back()->with('error', 'Gagal membuat booking: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $booking = Booking::with('room.tipeKamar', 'facilities')->findOrFail($id);
            $oldData = $booking->toArray();

            $validated = $request->validate($this->validationRules($id));

            if ($request->filled('new_guest_name')) {
                $guest = Guest::create([
                    'name' => $request->new_guest_name,
                    'phone' => $request->new_guest_phone,
                    'identity_number' => $request->new_guest_identity
                ]);
                $validated['guest_id'] = $guest->id;
            }

            if ($booking->room_id != $validated['room_id']) {
                $oldRoom = Room::find($booking->room_id);
                if ($oldRoom) $oldRoom->update(['status' => 'tersedia']);

                $newRoom = Room::findOrFail($validated['room_id']);
                if ($newRoom->status !== 'tersedia') return back()->with('error', 'Kamar ' . $newRoom->number . ' tidak tersedia.');
                $newRoom->update(['status' => 'terisi']);
            }

            $booking->update($validated);

            if ($request->filled('facilities')) {
                $facilityData = [];
                foreach ($request->facilities as $facilityId) {
                    $facility = Facility::find($facilityId);
                    if ($facility) {
                        $facilityData[$facilityId] = [
                            'price' => $facility->price_per_night,
                            'start_date' => $request->facility_start_date,
                            'end_date' => $request->facility_end_date
                        ];
                        $facility->update(['status' => 'inactive']);
                    }
                }
                $booking->facilities()->sync($facilityData);
            } else {
                $booking->facilities()->detach();
            }

            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity_type' => 'update',
                'description' => 'Memperbarui booking #' . $booking->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'role' => auth()->user()->role,
                'old_values' => json_encode($oldData),
                'new_values' => json_encode($validated)
            ]);

            return redirect()->route(auth()->user()->role . '.bookings.index')
                             ->with('success', 'Booking berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Error updating booking: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui booking: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        Log::info('DESTROY CALLED for ID: ' . $id);

        try {
            $booking = Booking::with('room')->findOrFail($id);
            Log::info('Booking found: ' . $booking->id);

            if ($booking->room_id) {
                $room = Room::find($booking->room_id);
                if ($room) {
                    $room->update(['status' => 'tersedia']);
                }
            }

            DB::table('booking_facility')->where('booking_id', $booking->id)->delete();

            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity_type' => 'delete',
                'description' => 'Membatalkan booking #' . $booking->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'method' => request()->method(),
                'url' => request()->fullUrl(),
                'role' => auth()->user()->role,
                'old_values' => json_encode($booking->toArray())
            ]);

            $booking->delete();

            return redirect()->route(auth()->user()->role . '.bookings.index')
                             ->with('success', 'Booking berhasil dibatalkan.');
        } catch (\Exception $e) {
            Log::error('Error deleting booking: ' . $e->getMessage());
            return back()->with('error', 'Gagal membatalkan booking: ' . $e->getMessage());
        }
    }

    protected function validationRules($bookingId = null)
    {
        return [
            'guest_id' => 'required|exists:guests,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'status' => 'required|in:booked,checked_in,checked_out,canceled,paid',
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
            'facility_start_date' => 'nullable|date|after_or_equal:check_in',
            'facility_end_date' => 'nullable|date|before_or_equal:check_out',
        ];
    }
}
