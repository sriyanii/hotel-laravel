<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\ActivityLog;

class BookingController extends Controller
{
    /**
     * Tampilkan daftar booking
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');

        $bookings = Booking::with(['guest', 'room.tipeKamar', 'user'])
            ->when($search, function ($query, $search) {
                $query->whereHas('guest', fn($q) => $q->where('name', 'like', "%$search%"))
                      ->orWhereHas('room', fn($q) => $q->where('number', 'like', "%$search%"))
                      ->orWhere('status', 'like', "%$search%");
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->paginate(5);

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Form tambah booking
     */
    public function create()
    {
        try {
            $rooms = Room::with('tipeKamar')
                ->where('status', 'tersedia')
                ->get();

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

    /**
     * Form edit booking
     */
    public function edit($id)
    {
        try {
            $booking = Booking::with('room.tipeKamar')->findOrFail($id);

            $rooms = Room::with('tipeKamar')
                         ->where('status', 'tersedia')
                         ->orWhere('id', $booking->room_id)
                         ->get();

            $guests = Guest::all();

            return view('bookings.form', compact('booking', 'rooms', 'guests'));
        } catch (\Exception $e) {
            Log::error('Error accessing booking edit form: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat form edit booking.');
        }
    }

    /**
     * Tampilkan detail booking
     */
    public function show($id)
    {
        try {
            $booking = Booking::with(['guest', 'room.tipeKamar', 'user'])->findOrFail($id);
            return view('bookings.show', compact('booking'));
        } catch (\Exception $e) {
            Log::error('Error accessing booking details: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat detail booking.');
        }
    }

    /**
     * Simpan booking baru
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate($this->validationRules());

            // Tambah tamu baru jika diinput manual
            if ($request->filled('new_guest_name')) {
                $guest = Guest::create([
                    'name' => $request->new_guest_name,
                    'phone' => $request->new_guest_phone,
                    'identity_number' => $request->new_guest_identity
                ]);
                $validated['guest_id'] = $guest->id;
            }

            // Ambil kamar
            $room = Room::with('tipeKamar')->findOrFail($validated['room_id']);

            // Cek ketersediaan berdasarkan status
            if ($room->status !== 'tersedia') {
                return back()->with('error', 'Kamar ' . $room->number . ' tidak tersedia. Silakan pilih kamar lain.');
            }

            // Simpan booking
            $validated['user_id'] = auth()->id();
            $booking = Booking::create($validated);

            // Update status kamar menjadi 'terisi'
            $room->update(['status' => 'terisi']);

            // Catat aktivitas
            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity_type' => 'create',
                'description' => 'Membuat booking baru untuk kamar ' . $room->number . ' (' . ($room->tipeKamar->tipe_kamar ?? 'Tanpa tipe') . ')',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'role' => auth()->user()->role,
                'data' => json_encode($validated)
            ]);

            return redirect()->route(auth()->user()->role . '.bookings.index')
                ->with('success', 'Booking untuk kamar ' . $room->number . ' berhasil dibuat!');
        } catch (\Exception $e) {
            Log::error('Error creating booking: ' . $e->getMessage());
            return back()->with('error', 'Gagal membuat booking: ' . $e->getMessage());
        }
    }

    /**
     * Update booking
     */
    public function update(Request $request, $id)
    {
        try {
            $booking = Booking::with('room.tipeKamar')->findOrFail($id);
            $oldData = $booking->toArray();

            $validated = $request->validate($this->validationRules($id));

            // Tambah tamu baru jika diinput manual
            if ($request->filled('new_guest_name')) {
                $guest = Guest::create([
                    'name' => $request->new_guest_name,
                    'phone' => $request->new_guest_phone,
                    'identity_number' => $request->new_guest_identity
                ]);
                $validated['guest_id'] = $guest->id;
            }

            // Jika kamar diganti, update status kamar lama & baru
            if ($booking->room_id != $validated['room_id']) {
                $oldRoom = Room::find($booking->room_id);
                if ($oldRoom) {
                    $oldRoom->update(['status' => 'tersedia']);
                }

                $newRoom = Room::with('tipeKamar')->findOrFail($validated['room_id']);
                if ($newRoom->status !== 'tersedia') {
                    return back()->with('error', 'Kamar ' . $newRoom->number . ' tidak tersedia.');
                }
                $newRoom->update(['status' => 'terisi']);
            }

            // Update booking
            $booking->update($validated);

            // Catat aktivitas
            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity_type' => 'update',
                'description' => 'Memperbarui booking #' . $booking->id . ' untuk kamar ' . $booking->room->number,
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

    /**
     * Hapus booking
     */
    public function destroy($id)
    {
        try {
            $booking = Booking::with('room')->findOrFail($id);
            $bookingData = $booking->toArray();

            // Kembalikan status kamar ke tersedia
            if ($booking->room_id) {
                $room = Room::find($booking->room_id);
                if ($room) {
                    $room->update(['status' => 'tersedia']);
                }
            }

            // Catat aktivitas
            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity_type' => 'delete',
                'description' => 'Membatalkan booking #' . $booking->id . ' untuk kamar ' . ($booking->room->number ?? 'tidak diketahui'),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'method' => request()->method(),
                'url' => request()->fullUrl(),
                'role' => auth()->user()->role,
                'old_values' => json_encode($bookingData)
            ]);

            // Hapus booking
            $booking->delete();

            return redirect()->route(auth()->user()->role . '.bookings.index')
                ->with('success', 'Booking berhasil dibatalkan dan kamar dikembalikan ke status tersedia.');
        } catch (\Exception $e) {
            Log::error('Error deleting booking: ' . $e->getMessage());
            return back()->with('error', 'Gagal membatalkan booking: ' . $e->getMessage());
        }
    }

    /**
     * Rules validasi booking
     */
    protected function validationRules($bookingId = null)
    {
        return [
            'guest_id' => 'required|exists:guests,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'status' => 'required|in:booked,checked_in,checked_out,canceled,paid',
        ];
    }

    /**
     * Tampilkan kalender booking
     */
    public function calendar()
    {
        $bookings = Booking::with(['guest', 'room'])
            ->where('status', '!=', 'canceled')
            ->whereDate('check_in', '>=', now())
            ->get();

        $events = $bookings->map(function($booking) {
            return [
                'title' => $booking->guest->name,
                'start' => $booking->check_in,
                'end' => $booking->check_out,
                'booking_id' => $booking->id,
            ];
        });

        return view('guests.calendar', compact('bookings', 'events'));
    }
}