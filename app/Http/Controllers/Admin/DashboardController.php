<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Guest;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use App\Models\ActivityLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik umum
        $totalRooms = Room::count();
        $totalGuests = Guest::count();
        $bookingsToday = Booking::whereDate('created_at', Carbon::today())->count();
        $revenueThisMonth = Payment::whereMonth('created_at', now()->month)->sum('amount');

        // User terbaru (ambil 5)
        $recentUsers = User::latest()->take(5)->get();

        // Booking aktif (belum check-out)
        $activeBookings = Booking::where('status', '!=', 'checked_out')->take(10)->get();

        // Grafik booking bulanan (Januari - Desember)
        $monthlyLabels = [];
        $monthlyCounts = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create()->month($i)->translatedFormat('F');
            $monthlyLabels[] = $monthName;
            $monthlyCounts[] = Booking::whereMonth('created_at', $i)->count();
        }

        // Log aktivitas: catat bahwa admin membuka dashboard
        ActivityLog::create([
            'description' => 'Admin mengakses dashboard',
            'user' => auth()->user()->name ?? 'Guest',
        ]);

        // Log aktivitas (ambil 10 terbaru)
        $recentLogs = ActivityLog::latest()->take(10)->get();

        // Kirim data ke view
        return view('admin.dashboard', [
            'totalRooms' => $totalRooms,
            'totalGuests' => $totalGuests,
            'bookingsToday' => $bookingsToday,
            'revenueThisMonth' => $revenueThisMonth,
            'recentUsers' => $recentUsers,
            'activeBookings' => $activeBookings,
            'monthlyBookingLabels' => $monthlyLabels,
            'monthlyBookingCounts' => $monthlyCounts,
            'recentLogs' => $recentLogs,
        ]);
    }
}
