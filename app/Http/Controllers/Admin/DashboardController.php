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
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // === Statistik umum ===
        $totalRooms   = Room::count();
        $totalGuests  = Guest::count();
        $bookingsToday = Booking::whereDate('created_at', today())->count();
        $revenueThisMonth = Payment::whereYear('created_at', now()->year)
                                   ->whereMonth('created_at', now()->month)
                                   ->sum('amount');

        $stats = [
            'totalRooms'      => $totalRooms,
            'totalGuests'     => $totalGuests,
            'bookingsToday'   => $bookingsToday,
            'revenueThisMonth'=> $revenueThisMonth
        ];

        // === Status kamar ===
        $roomStatus = [
            'available'   => Room::where('status', 'available')->count(),
            'occupied'    => Room::where('status', 'occupied')->count(),
            'maintenance' => Room::where('status', 'maintenance')->count(),
        ];

        // === Statistik pendapatan (perbandingan) ===
        $todayRevenue      = Payment::whereDate('created_at', today())->sum('amount');
        $yesterdayRevenue  = Payment::whereDate('created_at', today()->subDay())->sum('amount');

        $weekRevenue       = Payment::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('amount');
        $lastWeekRevenue   = Payment::whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])->sum('amount');

        $monthRevenue      = Payment::whereMonth('created_at', now()->month)->sum('amount');
        $lastMonthRevenue  = Payment::whereMonth('created_at', now()->subMonth()->month)->sum('amount');

        $revenueStats = [
            'today'         => $todayRevenue,
            'today_percent' => $yesterdayRevenue > 0 ? round((($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100, 2) : 100,

            'week'          => $weekRevenue,
            'week_percent'  => $lastWeekRevenue > 0 ? round((($weekRevenue - $lastWeekRevenue) / $lastWeekRevenue) * 100, 2) : 100,

            'month'         => $monthRevenue,
            'month_percent' => $lastMonthRevenue > 0 ? round((($monthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 2) : 100,
        ];

        // === User terbaru ===
        $recentUsers = User::where('role', 'resepsionis')
    ->latest()
    ->take(5)
    ->get();

    // $recentUsers = User::latest()->take(5)->get();

        // === Booking aktif (booked & checked_in) ===
        $activeBookings = Booking::with(['guest', 'room'])
            ->whereIn('status', ['booked', 'checked_in'])
            ->orderBy('check_in')
            ->take(10)
            ->get();

        // === Booking terbaru ===
        $recentBookings = Booking::with(['guest', 'room'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // === Data check-in & check-out hari ini ===
        $checkInsToday = Booking::with(['guest', 'room'])
            ->whereDate('check_in', Carbon::today())
            ->where('status', '!=', 'checked_out')
            ->orderBy('check_in', 'asc')
            ->get();

        $checkOutsToday = Booking::with(['guest', 'room'])
            ->whereDate('check_out', Carbon::today())
            ->where('status', '!=', 'checked_out')
            ->orderBy('check_out', 'asc')
            ->get();

        // === Data grafik bulanan booking (perbaikan) ===
        $monthlyData = Booking::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', now()->year) // hanya tahun ini
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

        // === Simpan log akses dashboard ===
        try {
            ActivityLog::create([
                'user_id'       => auth()->id(),
                'activity_type' => 'access',
                'description'   => 'Admin mengakses dashboard',
                'ip_address'    => request()->ip(),
                'user_agent'    => request()->userAgent(),
                'role'          => auth()->user()->role,
                'created_at'    => now(),
                'updated_at'    => now()
            ]);
        } catch (\Exception $e) {
            logger()->error('Gagal mencatat aktivitas dashboard: ' . $e->getMessage());
        }

        // === Log aktivitas terbaru ===
        $recentLogs = ActivityLog::with('user:id,name')
            ->latest()
            ->take(10)
            ->get();

        // === Activities dengan pagination ===
        $activities = ActivityLog::with('user:id,name,role,email')
            ->latest()
            ->paginate(15);

        // === Kirim data ke view ===
        return view('admin.dashboard', [
            'stats'                 => $stats,
            'roomStatus'            => $roomStatus,
            'revenueStats'          => $revenueStats,
            'recentUsers'           => $recentUsers,
            'activeBookings'        => $activeBookings,
            'recentBookings'        => $recentBookings,
            'checkInsToday'         => $checkInsToday,
            'checkOutsToday'        => $checkOutsToday,
            'monthlyBookingLabels'  => $monthlyLabels,
            'monthlyBookingCounts'  => $monthlyCounts,
            'recentLogs'            => $recentLogs,
            'activities'            => $activities,

            // kompatibilitas untuk Blade lama
            'totalRooms'            => $totalRooms,
            'availableRooms'        => $roomStatus['available'],
            'totalGuests'           => $totalGuests,
            'bookingsToday'         => $bookingsToday,
        ]);
    }
}
