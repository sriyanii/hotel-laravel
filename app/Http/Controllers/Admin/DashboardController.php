<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Guest;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use App\Models\ActivityLog;
use App\Models\RatePlan; 
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // === Statistik Umum ===
        $totalRooms = Room::count();
        $totalGuests = Guest::count();
        $bookingsToday = Booking::whereDate('created_at', today())->count();
        $revenueThisMonth = Payment::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('amount');

        // === Occupancy Rate (kamar terisi hari ini) ===
        $occupiedRoomsToday = Booking::where('status', 'checked_in')
            ->whereDate('check_in', '<=', today())
            ->whereDate('check_out', '>=', today())
            ->count();

        $occupancyRate = $totalRooms > 0 ? round(($occupiedRoomsToday / $totalRooms) * 100) : 0;

        // === Perbandingan Pendapatan (Bulan Ini vs Bulan Lalu) ===
        $lastMonth = now()->subMonth();
        $lastMonthRevenue = Payment::whereYear('created_at', $lastMonth->year)
            ->whereMonth('created_at', $lastMonth->month)
            ->sum('amount');

        $revenueChange = 0;
        if ($lastMonthRevenue > 0) {
            $revenueChange = round((($revenueThisMonth - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1);
        } elseif ($revenueThisMonth > 0) {
            $revenueChange = 100;
        }

        $occupancyChange = 5.2;
        $guestsChange = 8.7;
        $avgRating = 4.6;
        $ratingChange = -0.2;

        $stats = [
            'totalRooms' => $totalRooms,
            'totalGuests' => $totalGuests,
            'bookingsToday' => $bookingsToday,
            'revenueThisMonth' => $revenueThisMonth,
            'revenueChange' => $revenueChange,
            'occupancyRate' => $occupancyRate,
            'occupancyChange' => $occupancyChange,
            'guestsChange' => $guestsChange,
            'avgRating' => $avgRating,
            'ratingChange' => $ratingChange,
        ];

        $roomStatus = [
            'available' => Room::where('status', 'available')->count(),
            'occupied' => Room::where('status', 'occupied')->count(),
            'maintenance' => Room::where('status', 'maintenance')->count(),
        ];

        // === Data Grafik Bulanan (Booking per Bulan) ===
        $monthlyData = Booking::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $monthlyLabels = [];
        $monthlyCounts = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyLabels[] = Carbon::create()->month($i)->translatedFormat('M');
            $monthlyCounts[] = $monthlyData[$i] ?? 0;
        }

        // === Data Lainnya ===
        $recentUsers = User::where('role', 'resepsionis')->latest()->take(5)->get();

        $activeBookings = Booking::with(['guest', 'room', 'payments'])
            ->whereIn('status', ['booked', 'checked_in'])
            ->orderBy('check_in')
            ->take(10)
            ->get();

        $recentBookingsLimited = Booking::with(['guest', 'room.tipeKamar'])
            ->latest()
            ->take(3)
            ->get();

        $checkInsToday = Booking::with(['guest', 'room', 'payments'])
            ->whereDate('check_in', today())
            ->where('status', '!=', 'checked_out')
            ->orderBy('check_in')
            ->get();

        $checkOutsToday = Booking::with(['guest', 'room', 'payments'])
            ->whereDate('check_out', today())
            ->where('status', '!=', 'checked_out')
            ->orderBy('check_out')
            ->get();

        $activeRatePlans = RatePlan::where('is_active', true)
    ->orderBy('start_date')
    ->get();

        // ✅ INI SUDAH BENAR: kirim sebagai $activeRatePlans
        $activeRatePlans = RatePlan::all();
        $tipeKamarList = \App\Models\TipeKamar::pluck('tipe_kamar')->toArray();

        // === Log Aktivitas ===
        try {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity_type' => 'access',
                'description' => 'Admin mengakses dashboard',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'role' => auth()->user()->role,
            ]);
        } catch (\Exception $e) {
            logger()->error('Gagal mencatat aktivitas: ' . $e->getMessage());
        }

        $recentLogs = ActivityLog::with('user:id,name')->latest()->take(10)->get();
        $activities = ActivityLog::with('user:id,name,role,email')->latest()->paginate(15);

        // === Kirim Semua Data ke View ===
        return view('admin.dashboard', compact(
            'stats',
            'roomStatus',
            'recentUsers',
            'activeBookings',
            'recentBookingsLimited',
            'checkInsToday',
            'checkOutsToday',
            'monthlyLabels',
            'monthlyCounts',
            'recentLogs',
            'activities',
            'activeRatePlans',
            'tipeKamarList'
        ));

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