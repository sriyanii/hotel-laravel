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
    public function index(Request $request)
    {
        $query = Payment::with(['booking.guest', 'booking.room']);

        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun', date('Y'));

        if ($bulan) {
            $query->whereMonth('paid_at', $bulan);
        }

        if ($tahun) {
            $query->whereYear('paid_at', $tahun);
        }

        $payments = $query->latest()->get();
        $totalPendapatan = $payments->sum('amount');

        // Statistik bulanan
        $statistik = Payment::selectRaw('MONTH(paid_at) as month, SUM(amount) as total')
            ->whereYear('paid_at', $tahun)
            ->groupBy(DB::raw('MONTH(paid_at)'))
            ->orderBy('month')
            ->get();

        $months = [];
        $totals = [];

        foreach ($statistik as $item) {
            $months[] = Carbon::create()->month($item->month)->locale('id')->monthName;
            $totals[] = $item->total;
        }

        return view('admin.laporan_keuangan.index', compact(
            'payments',
            'totalPendapatan',
            'months',
            'totals',
            'bulan',
            'tahun'
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
