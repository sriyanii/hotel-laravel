<?php

namespace App\Http\Controllers\Resepsionis;

use App\Models\Room;
use App\Models\Guest;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Log access to dashboard
            $this->logActivity('Mengakses dashboard resepsionis', auth()->user());

            // Hitung data untuk dashboard
            $totalRooms = Room::count();
            $availableRooms = Room::where('status', 'tersedia')->count();
            $totalGuests = Guest::count();
            $bookingsToday = Booking::whereDate('check_in', now()->toDateString())->count();

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

        } catch (\Exception $e) {
            Log::error('Error accessing dashboard: ' . $e->getMessage());
            $this->logActivity(
                'Gagal mengakses dashboard: ' . $e->getMessage(),
                auth()->user(),
                'error'
            );
            return back()->with('error', 'Gagal memuat dashboard.');
        }
    }

    /**
     * Helper method to log activities
     *
     * @param string $description
     * @param \App\Models\User $user
     * @param string $type
     */
    private function logActivity(string $description, $user, string $type = 'info')
    {
        try {
            ActivityLog::create([
                'user_id' => $user->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'description' => $description,
                'type' => $type,
                'method' => request()->method(),
                'url' => request()->fullUrl(),
                'referer' => request()->header('referer'),
                'data' => $type === 'error' ? null : json_encode([
                    'action' => 'dashboard_access',
                    'time' => now()->toDateTimeString()
                ])
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log dashboard activity: ' . $e->getMessage());
        }
    }
}