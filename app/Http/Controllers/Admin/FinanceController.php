<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Finance;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{

public function index(Request $request)
{
    // Comment sementara bagian yang bermasalah
    // $unpaidBookings = \App\Models\Booking::with('guest')
    //     ->whereNotIn('status', ['paid', 'canceled'])
    //     ->whereNotNull('guest_id')
    //     ->orderBy('check_in', 'desc')
    //     ->get()
    //     ->unique('guest_id');
    
    $unpaidBookings = collect(); // kosongkan dulu
    
    // Lanjutkan dengan data lainnya...
}

public function storeInvoice(Request $request)
{
    $request->validate([
        'client' => 'required|string',
        'issue_date' => 'required|date',
        'due_date' => 'required|date|after:issue_date',
        'amount' => 'required|integer|min:1000',
    ]);

    try {
        // Gunakan lock untuk menghindari race condition
        $latestInvoice = Invoice::latest()->first();
        $nextId = $latestInvoice ? (int) substr($latestInvoice->invoice_number, -3) + 1 : 1;
        
        $invoiceNumber = 'INV-' . now()->year . '-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        Invoice::create([
            'invoice_number' => $invoiceNumber,
            'client' => $request->client,
            'issue_date' => $request->issue_date,
            'due_date' => $request->due_date,
            'amount' => $request->amount,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Invoice created successfully!');
        
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error creating invoice: ' . $e->getMessage());
    }
}

public function markInvoicePaid(Request $request, Invoice $invoice)
{
    // Pastikan hanya status 'pending' atau 'overdue' yang bisa diubah
    if ($invoice->status !== 'paid') {
        $invoice->update(['status' => 'paid']);
    }

    return redirect()->back()->with('success', 'Invoice marked as paid successfully!');
}
}
