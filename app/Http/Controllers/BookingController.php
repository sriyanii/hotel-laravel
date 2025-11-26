<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use App\Models\Facility;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
public function index(Request $request)
{
    $search = $request->get('search');
    $status = $request->get('status');

    $year = $request->get('year', now()->year);
    $month = $request->get('month', now()->month);
    $currentDate = Carbon::create($year, $month, 1);
    $prevDate = $currentDate->copy()->subMonth();
    $nextDate = $currentDate->copy()->addMonth();

    $prevYear = $prevDate->year;
    $prevMonth = $prevDate->month;
    $nextYear = $nextDate->year;
    $nextMonth = $nextDate->month;

    $bookings = Booking::with(['guest', 'room.tipeKamar', 'user', 'facilities'])
        ->when($search, fn($query) => $query->whereHas('guest', fn($q) => $q->where('name', 'like', "%$search%"))
                                           ->orWhereHas('room', fn($q) => $q->where('number', 'like', "%$search%"))
                                           ->orWhere('status', 'like', "%$search%"))
        ->when($status, fn($query, $status) => $query->where('status', $status))
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    // Data untuk Room Availability Calendar
    $bookingsByDate = [];
    $allBookings = Booking::with(['guest', 'room.tipeKamar'])
        ->where(function($query) use ($year, $month) {
            $query->whereYear('check_in', $year)->whereMonth('check_in', $month)
                  ->orWhereYear('check_out', $year)->whereMonth('check_out', $month);
        })
        ->get();

    foreach ($allBookings as $booking) {
        $checkIn = Carbon::parse($booking->check_in);
        $checkOut = Carbon::parse($booking->check_out);
        for ($date = $checkIn->copy(); $date->lte($checkOut); $date->addDay()) {
            $dateString = $date->format('Y-m-d');
            if (!isset($bookingsByDate[$dateString])) {
                $bookingsByDate[$dateString] = [];
            }
            $bookingsByDate[$dateString][] = $booking;
        }
    }

    // Statistik
    $stats = [
        'total' => Booking::count(),
        'confirmed' => Booking::where('status', 'confirmed')->count(),
        'pending' => Booking::where('status', 'booked')->count(),
        'checked_in' => Booking::where('status', 'checked_in')->count(),
        'checked_out' => Booking::where('status', 'checked_out')->count(),
        'canceled' => Booking::where('status', 'canceled')->count(),
        'paid' => Booking::where('status', 'paid')->count(),
        'monthly_total' => Booking::whereYear('created_at', $year)
                                 ->whereMonth('created_at', $month)
                                 ->count(),
        'monthly_revenue' => Booking::whereYear('created_at', $year)
                                   ->whereMonth('created_at', $month)
                                   ->sum('total_price'),
        'today_arrivals' => Booking::whereDate('check_in', today())
                                  ->whereIn('status', ['confirmed', 'booked'])
                                  ->count(),
        'today_departures' => Booking::whereDate('check_out', today())
                                    ->where('status', 'checked_in')
                                    ->count(),
    ];

    // Chart Data
    $chartData = [
        'confirmed' => $stats['confirmed'],
        'pending' => $stats['pending'],
        'canceled' => $stats['canceled'],
        'checked_in' => $stats['checked_in'],
        'checked_out' => $stats['checked_out'],
        'paid' => $stats['paid'],
    ];

    // Calendar Events
    $calendarEvents = [];
    foreach ($bookings as $booking) {
        $color = match($booking->status) {
            'confirmed' => '#10b981',
            'checked_in' => '#3b82f6',
            'checked_out' => '#6b7280',
            'canceled' => '#ef4444',
            'paid' => '#8b5cf6',
            default => '#f59e0b'
        };

        $calendarEvents[] = [
            'title' => $booking->room->number . ' - ' . $booking->guest->name,
            'start' => $booking->check_in,
            'end' => Carbon::parse($booking->check_out)->addDay()->format('Y-m-d'),
            'color' => $color,
            'extendedProps' => [
                'booking_id' => $booking->id,
                'status' => $booking->status
            ]
        ];
    }

    // === TAMBAHKAN INI ===
    $today = today();
    $todayArrivals = Booking::with(['guest', 'room'])
        ->whereDate('check_in', $today)
        ->whereIn('status', ['booked', 'confirmed'])
        ->get();

    $todayDepartures = Booking::with(['guest', 'room'])
        ->whereDate('check_out', $today)
        ->where('status', 'checked_in')
        ->get();

    return view('bookings.index', compact(
        'bookings', 
        'year', 
        'month', 
        'prevDate', 
        'nextDate',
        'prevYear',
        'prevMonth', 
        'nextYear',
        'nextMonth',
        'stats',
        'chartData',
        'calendarEvents',
        'bookingsByDate',
        'todayArrivals',
        'todayDepartures'
    ));
}

    public function create()
    {
        try {
            $rooms = Room::with('tipeKamar')->where('status', 'tersedia')->get();
            $guests = Guest::all();
            $facilities = Facility::where('status', 'active')->get();

            return view('bookings.create', compact('rooms', 'guests', 'facilities'));
        } catch (\Exception $e) {
            Log::error('Error accessing booking create form: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat form booking.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'guest_id' => 'required|exists:guests,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'booking_source' => 'nullable|string',
            'adults' => 'nullable|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'special_requests' => 'nullable|string',
            'confirm_immediately' => 'nullable|boolean',
        ]);

        $room = Room::with('tipeKamar')->findOrFail($request->room_id);
        $checkIn = \Carbon\Carbon::parse($request->check_in);
        $checkOut = \Carbon\Carbon::parse($request->check_out);
        $nights = $checkOut->diffInDays($checkIn);

        // Ambil harga dari tipe_kamar
        $pricePerNight = $room->tipeKamar->price ?? 0;
        $totalPrice = $pricePerNight * $nights;

        $status = $request->confirm_immediately ? 'confirmed' : 'booked';

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'guest_id' => $request->guest_id,
            'room_id' => $request->room_id,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'status' => $status,
            'total_price' => $totalPrice,
            'booking_source' => $request->booking_source,
            'adults' => $request->adults ?? 1,
            'children' => $request->children ?? 0,
            'special_requests' => $request->special_requests,
        ]);

        return redirect()->back()->with('success', 'Booking berhasil dibuat!');
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

            return view('bookings.edit', compact('booking', 'rooms', 'guests', 'facilities'));
        } catch (\Exception $e) {
            Log::error('Error accessing booking edit form: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat form edit booking.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $booking = Booking::with('room.tipeKamar', 'facilities')->findOrFail($id);
            $oldData = $booking->toArray();

            $validated = $request->validate([
                'guest_id' => 'required|exists:guests,id',
                'room_id' => 'required|exists:rooms,id',
                'check_in' => 'required|date',
                'check_out' => 'required|date|after:check_in',
                'status' => 'required|in:booked,confirmed,checked_in,checked_out,canceled',
                'facilities' => 'nullable|array',
                'facilities.*' => 'exists:facilities,id',
            ]);

            // Hitung total harga
            $room = Room::with('tipeKamar')->findOrFail($validated['room_id']);
            $nights = Carbon::parse($validated['check_out'])->diffInDays($validated['check_in']);
            $totalPrice = ($room->price ?? 0) * $nights;

            // Tambah harga fasilitas
            if ($request->filled('facilities')) {
                foreach ($request->facilities as $facilityId) {
                    $facility = Facility::find($facilityId);
                    if ($facility) {
                        $totalPrice += $facility->price_per_night * $nights;
                    }
                }
            }

            $validated['total_price'] = $totalPrice;

            // Update status kamar jika room berubah
            if ($booking->room_id != $validated['room_id']) {
                $oldRoom = Room::find($booking->room_id);
                if ($oldRoom) $oldRoom->update(['status' => 'tersedia']);

                $newRoom = Room::findOrFail($validated['room_id']);
                $newRoom->update(['status' => 'terisi']);
            }

            $booking->update($validated);

            // Update facilities
            if ($request->filled('facilities')) {
                $facilityData = [];
                foreach ($request->facilities as $facilityId) {
                    $facility = Facility::find($facilityId);
                    if ($facility) {
                        $facilityData[$facilityId] = [
                            'price' => $facility->price_per_night,
                            'start_date' => $validated['check_in'],
                            'end_date' => $validated['check_out']
                        ];
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
        try {
            $booking = Booking::with('room')->findOrFail($id);

            if ($booking->room_id) {
                $room = Room::find($booking->room_id);
                if ($room) {
                    $room->update(['status' => 'tersedia']);
                }
            }

            // Detach facilities
            $booking->facilities()->detach();

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

    public function checkin($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->update(['status' => 'checked_in']);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity_type' => 'update',
                'description' => 'Check-in booking #' . $booking->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'method' => request()->method(),
                'url' => request()->fullUrl(),
                'role' => auth()->user()->role,
            ]);

            return back()->with('success', 'Check-in berhasil!');
        } catch (\Exception $e) {
            Log::error('Error during check-in: ' . $e->getMessage());
            return back()->with('error', 'Gagal melakukan check-in.');
        }
    }

    public function checkout($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->update(['status' => 'checked_out']);

            // Kembalikan status kamar menjadi tersedia
            if ($booking->room_id) {
                $room = Room::find($booking->room_id);
                if ($room) {
                    $room->update(['status' => 'tersedia']);
                }
            }

            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity_type' => 'update',
                'description' => 'Check-out booking #' . $booking->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'method' => request()->method(),
                'url' => request()->fullUrl(),
                'role' => auth()->user()->role,
            ]);

            return back()->with('success', 'Check-out berhasil!');
        } catch (\Exception $e) {
            Log::error('Error during check-out: ' . $e->getMessage());
            return back()->with('error', 'Gagal melakukan check-out.');
        }
    }

    public function confirm($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->update(['status' => 'confirmed']);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity_type' => 'update',
                'description' => 'Mengonfirmasi booking #' . $booking->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'method' => request()->method(),
                'url' => request()->fullUrl(),
                'role' => auth()->user()->role,
            ]);

            return back()->with('success', 'Booking berhasil dikonfirmasi!');
        } catch (\Exception $e) {
            Log::error('Error confirming booking: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengonfirmasi booking.');
        }
    }

    public function getGuests()
    {
        // Ambil tamu yang TIDAK memiliki booking aktif (status booked/confirmed/checked_in)
        $activeBookingGuestIds = \DB::table('bookings')
            ->whereIn('status', ['booked', 'confirmed', 'checked_in'])
            ->pluck('guest_id');

        $guests = Guest::whereNotIn('id', $activeBookingGuestIds)->get();

        return response()->json([
            'guests' => $guests
        ]);
    }

    public function getRooms()
    {
        $rooms = Room::with('tipeKamar')
            ->where('status', 'available') // asumsi ada kolom status
            ->get()
            ->map(function ($room) {
                return [
                    'id' => $room->id,
                    'number' => $room->number,
                    'tipe_kamar' => $room->tipeKamar?->tipe_kamar ?? 'Standard',
                    'price' => $room->tipeKamar?->price ?? 0, // <-- dari tipe_kamar
                ];
            });

        return response()->json(['rooms' => $rooms]);
    }

    public function getFacilities()
    {
        $facilities = Facility::where('status', 'active')->get();
        return response()->json(['facilities' => $facilities]);
    }

    public function getDetails($id)
{
    $booking = Booking::with(['guest', 'room.tipeKamar', 'bookedBy'])->find($id);

    if (!$booking) {
        return response()->json(['success' => false, 'message' => 'Booking not found'], 404);
    }

    // Format fasilitas tambahan (jika ada relasi)
    $facilities = $booking->additionalFacilities->map(function ($af) {
        return [
            'name' => $af->facility->name ?? 'Unknown',
            'price' => $af->facility->price ?? 0,
            'dates' => $af->dates ? implode(', ', json_decode($af->dates)) : null,
        ];
    });

    return response()->json([
        'success' => true,
        'booking' => [
            'id' => $booking->id,
            'guest_name' => $booking->guest->name ?? 'N/A',
            'room_number' => $booking->room->number ?? $booking->room->name ?? 'N/A',
            'room_type' => $booking->room->tipeKamar->tipe_kamar ?? 'N/A',
            'check_in_formatted' => $booking->check_in ? \Carbon\Carbon::parse($booking->check_in)->format('d M Y') : 'N/A',
            'check_out_formatted' => $booking->check_out ? \Carbon\Carbon::parse($booking->check_out)->format('d M Y') : 'N/A',
            'status' => $booking->status,
            'facilities' => $facilities,
            'booked_by' => $booking->bookedBy->name ?? 'N/A',
            'created_at_formatted' => $booking->created_at->format('d M Y H:i'),
            'updated_at_formatted' => $booking->updated_at->format('d M Y H:i'),
        ]
    ]);
}
}