<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\TipeKamar;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'last_7_days');
        $roomType = $request->get('room_type', 'all');
        $channel = $request->get('channel', 'all');

        // Periode saat ini
        list($currentStartDate, $currentEndDate) = $this->getDateRange($period);
        
        // Periode sebelumnya untuk perbandingan
        list($previousStartDate, $previousEndDate) = $this->getPreviousDateRange($period);

        // Data periode saat ini
        $currentData = $this->getAnalyticsData($currentStartDate, $currentEndDate, $roomType, $channel);
        
        // Data periode sebelumnya untuk perbandingan
        $previousData = $this->getAnalyticsData($previousStartDate, $previousEndDate, $roomType, $channel);

        // Hitung persentase perubahan
        $changes = $this->calculateChanges($currentData, $previousData);

        // Data untuk charts
        $sources = $this->getBookingSources($currentStartDate, $currentEndDate, $roomType, $channel);
        $roomPerformance = $this->getRoomPerformance($currentStartDate, $currentEndDate, $roomType, $channel);
        $revenueTrend = $this->getRevenueTrend($currentStartDate, $currentEndDate, $roomType, $channel);

        // Generate dates and revenues for chart
        $dates = [];
        $revenues = [];
        $current = $currentStartDate->copy();
        
        while ($current->lte($currentEndDate)) {
            $dates[] = $current->format('j M');
            
            // Cari revenue untuk tanggal ini
            $dateString = $current->toDateString();
            $revenueForDate = $revenueTrend->firstWhere('date', $dateString);
            
            $revenues[] = $revenueForDate ? $revenueForDate->revenue : 0;
            $current->addDay();
        }

        return view('admin.analytics', compact(
            'currentData',
            'changes',
            'sources',
            'roomPerformance',
            'dates',
            'revenues',
            'period',
            'roomType',
            'channel'
        ));
    }

    private function getDateRange($period)
    {
        $endDate = Carbon::today();
        switch ($period) {
            case 'last_7_days':
                $startDate = $endDate->copy()->subDays(6);
                break;
            case 'last_30_days':
                $startDate = $endDate->copy()->subDays(29);
                break;
            case 'this_month':
                $startDate = $endDate->copy()->startOfMonth();
                $endDate = $endDate->copy()->endOfMonth();
                break;
            case 'last_month':
                $startDate = $endDate->copy()->subMonth()->startOfMonth();
                $endDate = $endDate->copy()->subMonth()->endOfMonth();
                break;
            case 'this_year':
                $startDate = $endDate->copy()->startOfYear();
                $endDate = $endDate->copy()->endOfYear();
                break;
            default:
                $startDate = $endDate->copy()->subDays(6);
        }
        return [$startDate, $endDate];
    }

    private function getPreviousDateRange($period)
    {
        $endDate = Carbon::today();
        switch ($period) {
            case 'last_7_days':
                $startDate = $endDate->copy()->subDays(13);
                $endDate = $endDate->copy()->subDays(7);
                break;
            case 'last_30_days':
                $startDate = $endDate->copy()->subDays(59);
                $endDate = $endDate->copy()->subDays(30);
                break;
            case 'this_month':
                $startDate = $endDate->copy()->subMonth()->startOfMonth();
                $endDate = $endDate->copy()->subMonth()->endOfMonth();
                break;
            case 'last_month':
                $startDate = $endDate->copy()->subMonths(2)->startOfMonth();
                $endDate = $endDate->copy()->subMonths(2)->endOfMonth();
                break;
            case 'this_year':
                $startDate = $endDate->copy()->subYear()->startOfYear();
                $endDate = $endDate->copy()->subYear()->endOfYear();
                break;
            default:
                $startDate = $endDate->copy()->subDays(13);
                $endDate = $endDate->copy()->subDays(7);
        }
        return [$startDate, $endDate];
    }

    private function getAnalyticsData($startDate, $endDate, $roomType, $channel)
    {
        $query = Booking::whereBetween('check_in', [$startDate, $endDate])
            ->whereIn('status', ['confirmed', 'checked_in', 'checked_out', 'paid']);

        if ($roomType !== 'all') {
            $query->whereHas('room.tipeKamar', function($q) use ($roomType) {
                $q->where('tipe_kamar', $roomType);
            });
        }

        if ($channel !== 'all') {
            $query->where('booking_source', $channel);
        }

        $bookings = $query->get();

        $totalRevenue = $bookings->sum('total_price');
        $totalBookings = $bookings->count();

        $totalRoomNights = $bookings->sum(function ($booking) {
            $checkIn = Carbon::parse($booking->check_in);
            $checkOut = Carbon::parse($booking->check_out);
            return $checkIn->diffInDays($checkOut);
        });
        
        // Asumsi hotel memiliki 20 kamar
        $totalPossibleNights = 20 * ($startDate->diffInDays($endDate) + 1);
        $occupancyRate = $totalPossibleNights > 0 ? round(($totalRoomNights / $totalPossibleNights) * 100, 1) : 0;

        $adr = $totalRoomNights > 0 ? round($totalRevenue / $totalRoomNights) : 0;

        return [
            'totalRevenue' => $totalRevenue,
            'occupancyRate' => $occupancyRate,
            'totalBookings' => $totalBookings,
            'adr' => $adr,
            'totalRoomNights' => $totalRoomNights
        ];
    }

    private function calculateChanges($current, $previous)
    {
        $changes = [];
        
        foreach ($current as $key => $currentValue) {
            $previousValue = $previous[$key] ?? 0;
            
            if ($previousValue == 0) {
                if ($currentValue == 0) {
                    $percentage = 0;
                    $direction = 'neutral';
                } else {
                    $percentage = 100;
                    $direction = 'positive';
                }
            } else {
                $percentage = (($currentValue - $previousValue) / abs($previousValue)) * 100;
                $direction = $percentage >= 0 ? 'positive' : 'negative';
                $percentage = abs($percentage);
            }
            
            $changes[$key] = [
                'percentage' => round($percentage, 1),
                'direction' => $direction
            ];
        }
        
        return $changes;
    }

    private function getBookingSources($startDate, $endDate, $roomType, $channel)
    {
        $query = Booking::select('booking_source')
            ->selectRaw('COUNT(*) as count')
            ->whereBetween('check_in', [$startDate, $endDate])
            ->whereIn('status', ['confirmed', 'checked_in', 'checked_out', 'paid']);

        if ($roomType !== 'all') {
            $query->whereHas('room.tipeKamar', function($q) use ($roomType) {
                $q->where('tipe_kamar', $roomType);
            });
        }

        if ($channel !== 'all') {
            $query->where('booking_source', $channel);
        }

        $sources = $query->groupBy('booking_source')
            ->get()
            ->pluck('count', 'booking_source')
            ->toArray();

        // Pastikan semua sumber booking ada, bahkan jika 0
        $allSources = ['website', 'booking_com', 'agoda', 'walk_in', 'phone'];
        foreach ($allSources as $source) {
            if (!isset($sources[$source])) {
                $sources[$source] = 0;
            }
        }

        return $sources;
    }

    private function getRoomPerformance($startDate, $endDate, $roomType, $channel)
    {
        $query = TipeKamar::select('tipe_kamar.id', 'tipe_kamar.tipe_kamar')
            ->selectRaw('COUNT(bookings.id) as bookings')
            ->selectRaw('COALESCE(SUM(bookings.total_price), 0) as revenue')
            ->leftJoin('rooms', 'tipe_kamar.id', '=', 'rooms.tipe_kamar_id')
            ->leftJoin('bookings', function($join) use ($startDate, $endDate, $channel) {
                $join->on('rooms.id', '=', 'bookings.room_id')
                    ->whereBetween('bookings.check_in', [$startDate, $endDate])
                    ->whereIn('bookings.status', ['confirmed', 'checked_in', 'checked_out', 'paid']);
                
                if ($channel !== 'all') {
                    $join->where('bookings.booking_source', $channel);
                }
            });

        if ($roomType !== 'all') {
            $query->where('tipe_kamar.tipe_kamar', $roomType);
        }

        $results = $query->groupBy('tipe_kamar.id', 'tipe_kamar.tipe_kamar')
            ->orderBy('revenue', 'desc')
            ->get();

        // Hitung occupancy rate untuk setiap tipe kamar
        foreach ($results as $room) {
            $roomNightsQuery = Booking::join('rooms', 'bookings.room_id', '=', 'rooms.id')
                ->where('rooms.tipe_kamar_id', $room->id)
                ->whereBetween('bookings.check_in', [$startDate, $endDate])
                ->whereIn('bookings.status', ['confirmed', 'checked_in', 'checked_out', 'paid']);

            if ($channel !== 'all') {
                $roomNightsQuery->where('bookings.booking_source', $channel);
            }

            $totalRoomNights = $roomNightsQuery->get()->sum(function ($booking) {
                $checkIn = Carbon::parse($booking->check_in);
                $checkOut = Carbon::parse($booking->check_out);
                return $checkIn->diffInDays($checkOut);
            });

            // Hitung jumlah kamar untuk tipe ini
            $roomCount = Room::where('tipe_kamar_id', $room->id)->count();
            $totalPossibleNights = $roomCount * ($startDate->diffInDays($endDate) + 1);
            $room->occupancy_rate = $totalPossibleNights > 0 ? round(($totalRoomNights / $totalPossibleNights) * 100, 1) : 0;
        }

        return $results;
    }

    private function getRevenueTrend($startDate, $endDate, $roomType, $channel)
    {
        $query = Booking::selectRaw('DATE(check_in) as date')
            ->selectRaw('COALESCE(SUM(total_price), 0) as revenue')
            ->whereBetween('check_in', [$startDate, $endDate])
            ->whereIn('status', ['confirmed', 'checked_in', 'checked_out', 'paid']);

        if ($roomType !== 'all') {
            $query->whereHas('room.tipeKamar', function($q) use ($roomType) {
                $q->where('tipe_kamar', $roomType);
            });
        }

        if ($channel !== 'all') {
            $query->where('booking_source', $channel);
        }

        return $query->groupBy('date')
            ->orderBy('date')
            ->get();
    }
}