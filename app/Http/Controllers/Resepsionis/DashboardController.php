<?php

namespace App\Http\Controllers\Resepsionis;

use App\Models\Room;
use App\Models\Guest;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung data untuk dashboard
        $totalRooms     = Room::count();
        $availableRooms = Room::where('status', 'tersedia')->count();
        $totalGuests    = Guest::count();
        $bookingsToday  = Booking::whereDate('check_in', now()->toDateString())->count();

        // Booking yang check-in hari ini
        $checkInsToday = Booking::whereDate('check_in', now()->toDateString())
            ->with(['guest', 'room'])
            ->get();

        // Booking yang check-out hari ini
        $checkOutsToday = Booking::whereDate('check_out', now()->toDateString())
            ->with(['guest', 'room'])
            ->get();

        // 5 booking terbaru
        $recentBookings = Booking::latest()
            ->with(['guest', 'room'])
            ->take(5)
            ->get();

        // Kirim semua data ke view
        return view('resepsionis.dashboard', compact(
            'totalRooms',
            'availableRooms',
            'totalGuests',
            'bookingsToday',
            'checkInsToday',
            'checkOutsToday',
            'recentBookings'
        ));
    }
}
