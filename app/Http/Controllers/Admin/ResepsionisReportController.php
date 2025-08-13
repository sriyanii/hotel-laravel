<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Asumsi kita menggunakan model User untuk data resepsionis
use App\Models\Booking; // Untuk data booking/reservasi

class ResepsionisReportController extends Controller
{
    /**
     * Menampilkan laporan kinerja resepsionis
     */
    public function index()
    {
        // Ambil data resepsionis (user dengan role resepsionis)
        $resepsionis = User::where('role', 'resepsionis')->get();
        
        return view('admin.reports.resepsionis', [
            'resepsionis' => $resepsionis
        ]);
    }

    /**
     * Menampilkan detail laporan untuk resepsionis tertentu
     */
    public function detail($id)
    {
        // Cari resepsionis berdasarkan ID
        $resepsionis = User::findOrFail($id);
        
        // Ambil data booking yang ditangani oleh resepsionis ini
        $bookings = Booking::where('user_id', $id)
                         ->with(['guest', 'room'])
                         ->latest()
                         ->get();
        
        return view('admin.reports.resepsionis_detail', [
            'resepsionis' => $resepsionis,
            'bookings' => $bookings
        ]);
    }
}