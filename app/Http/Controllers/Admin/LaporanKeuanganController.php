<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanKeuanganController extends Controller
{
    // In your LaporanKeuanganController.php

public function index()
{
    $currentYear = date('Y');
    
    // Get all payments for the current year
    $payments = Payment::whereYear('paid_at', $currentYear)
        ->orderBy('created_at', 'desc')
        ->get();
    
    // Calculate total revenue
    $totalPendapatan = $payments->sum('amount');
    
    // Get monthly data for the chart
    $monthlyData = Payment::selectRaw('MONTH(paid_at) as month, SUM(amount) as total')
        ->whereYear('paid_at', $currentYear)
        ->groupBy('month')
        ->orderBy('month')
        ->get();
    
    // Prepare months and totals for the chart
    $months = [];
    $totals = [];
    $monthNames = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    
    // Fill all months with data (including months with no payments)
    for ($i = 1; $i <= 12; $i++) {
        $months[] = $monthNames[$i];
        $monthData = $monthlyData->firstWhere('month', $i);
        $totals[] = $monthData ? $monthData->total : 0;
    }
    
    // Current month statistics
    $currentMonth = date('m');
    $currentMonthRevenue = Payment::whereYear('paid_at', $currentYear)
        ->whereMonth('paid_at', $currentMonth)
        ->sum('amount');
    
    $lastMonthRevenue = Payment::whereYear('paid_at', $currentYear)
        ->whereMonth('paid_at', $currentMonth - 1)
        ->sum('amount');
    
    $monthlyGrowthRate = $lastMonthRevenue != 0 
        ? (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 
        : 0;
    
    // Get best month
    $bestMonthData = Payment::selectRaw('MONTH(paid_at) as month, SUM(amount) as revenue')
        ->whereYear('paid_at', $currentYear)
        ->groupBy('month')
        ->orderBy('revenue', 'desc')
        ->first();
    
    $bestMonth = [
        'month' => $bestMonthData ? $monthNames[$bestMonthData->month] : 'Belum ada data',
        'revenue' => $bestMonthData ? $bestMonthData->revenue : 0
    ];
    
    // Calculate average monthly revenue
    $averageMonthlyRevenue = Payment::whereYear('paid_at', $currentYear)
        ->avg('amount');
    
    // Monthly target (you can set this as needed)
    $monthlyTarget = 15000000; // Example target: 15 million
    
    return view('admin.laporan_keuangan.index', compact(
        'payments',
        'totalPendapatan',
        'currentMonthRevenue',
        'monthlyGrowthRate',
        'bestMonth',
        'averageMonthlyRevenue',
        'monthlyTarget',
        'months',
        'totals'
    ));
}

    public function cetak()
    {
        // Optional: sesuaikan dengan bulan/tahun tertentu
        $payments = Payment::with(['booking.guest', 'booking.room'])->latest()->get();
        $totalPendapatan = $payments->sum('amount');

        return view('admin.laporan_keuangan.pdf', compact('payments', 'totalPendapatan'));
    }

    public function exportExcel(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        return Excel::download(new PaymentsExport($bulan, $tahun), 'laporan-keuangan.xlsx');
    }



        public function cetakPdf(Request $request)
        {
            $tahun = $request->input('tahun', date('Y'));
            $bulan = $request->input('bulan');

            $query = Payment::with(['booking.guest', 'booking.room'])->orderBy('paid_at', 'desc');

            $query->whereYear('paid_at', $tahun);

            if ($bulan) {
                $query->whereMonth('paid_at', $bulan);
            }

            $payments = $query->get();
            $totalPendapatan = $payments->sum('amount');

            $pdf = Pdf::loadView('admin.laporan_keuangan.pdf', compact('payments', 'totalPendapatan', 'bulan', 'tahun'))
                ->setPaper('A4', 'landscape');

            return $pdf->download("laporan_keuangan_{$bulan}_{$tahun}.pdf");
        }

}
