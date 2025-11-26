<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\ActivityLog;
use Carbon\Carbon;

class PaymentController extends Controller
{
public function index(Request $request)
{
    $search = $request->input('search', '');
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');

    $payments = Payment::with(['booking.room', 'booking.guest'])
        ->whereHas('booking', function($query) use ($search) {
            $query->whereHas('guest', function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%')
                      ->orWhere('identity_number', 'like', '%' . $search . '%');
            })
            ->orWhereHas('room', function($query) use ($search) {
                $query->where('number', 'like', '%' . $search . '%');
            });
        })
        ->when($start_date && $end_date, function($query) use ($start_date, $end_date) {
            $query->whereBetween('paid_at', [$start_date, $end_date]);
        })
        ->orderBy('paid_at', 'desc')
        ->paginate(10);

    // Get unpaid bookings for invoice creation
    $unpaidBookings = Booking::with(['guest', 'room'])
        ->where('status', 'pending')
        ->whereDoesntHave('payments')
        ->get();

    $view = view()->exists(auth()->user()->role . '.payments.index')
        ? auth()->user()->role . '.payments.index'
        : 'payments.index';

    return view($view, compact('payments', 'search', 'start_date', 'end_date', 'unpaidBookings'));
}

    public function create()
    {
        $role = auth()->user()->role;

        $bookings = Booking::with(['room', 'guest'])
            ->where('status', '!=', 'checked_out')
            ->whereDoesntHave('payments')
            ->select('id', 'guest_id', 'room_id', 'check_in', 'check_out')
            ->selectRaw('DATEDIFF(check_out, check_in) as duration_nights')
            ->get()
            ->map(function ($booking) {
                $booking->total = $booking->duration_nights * optional($booking->room)->price;
                return $booking;
            });

        return view('payments.form', [
            'payment' => new Payment(),
            'bookings' => $bookings,
            'action' => route($role . '.payments.store'),
            'method' => 'POST',
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'booking_id' => [
                'required',
                'exists:bookings,id',
                Rule::unique('payments', 'booking_id')
            ],
            'amount' => 'required|numeric|min:0',
            'paid_at' => 'required|date',
            'method' => 'required|in:cash,transfer,qris',
        ]);

        $booking = Booking::selectRaw('id, room_id, check_in, check_out, DATEDIFF(check_out, check_in) as duration_nights')
            ->with('room')
            ->findOrFail($validatedData['booking_id']);

        if ($booking->duration_nights <= 0) {
            return back()->withErrors(['booking_id' => 'Durasi menginap tidak valid.'])->withInput();
        }

        $calculatedTotal = $booking->duration_nights * $booking->room->price;

        if ($validatedData['method'] !== 'cash' && $validatedData['amount'] != $calculatedTotal) {
            return back()->withErrors([
                'amount' => 'Untuk metode non-tunai, jumlah harus sama dengan total tagihan: Rp ' . number_format($calculatedTotal, 0, ',', '.')
            ])->withInput();
        }

        DB::transaction(function () use ($validatedData, $booking, $calculatedTotal) {
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'amount' => $validatedData['amount'],
                'paid_at' => $validatedData['paid_at'],
                'method' => $validatedData['method'],
                'total' => $calculatedTotal,
            ]);

            $booking->update(['status' => 'paid']);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity_type' => 'create',
                'description' => 'Mencatat pembayaran untuk booking #' . $booking->id,
                'ip_address' => request()->ip(),
                'role' => auth()->user()->role
            ]);
        });

        return redirect()->route(auth()->user()->role . '.payments.index')
               ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(Payment $payment)
    {
        $role = auth()->user()->role;

        $bookings = Booking::with(['room', 'guest'])
            ->where('status', '!=', 'checked_out')
            ->where(function($query) use ($payment) {
                $query->whereDoesntHave('payments')
                      ->orWhere('id', $payment->booking_id);
            })
            ->select('id', 'guest_id', 'room_id', 'check_in', 'check_out')
            ->selectRaw('DATEDIFF(check_out, check_in) as duration_nights')
            ->get()
            ->map(function ($booking) {
                $booking->total = $booking->duration_nights * optional($booking->room)->price;
                return $booking;
            });

        return view('payments.form', [
            'payment' => $payment,
            'bookings' => $bookings,
            'action' => route($role . '.payments.update', $payment->id),
            'method' => 'PUT',
        ]);
    }

    public function update(Request $request, Payment $payment)
    {
        $validatedData = $request->validate([
            'booking_id' => [
                'required',
                'exists:bookings,id',
                Rule::unique('payments', 'booking_id')->ignore($payment->id)
            ],
            'amount' => 'required|numeric|min:0',
            'paid_at' => 'required|date',
            'method' => 'required|in:cash,transfer,qris',
        ]);

        $booking = Booking::selectRaw('id, room_id, check_in, check_out, DATEDIFF(check_out, check_in) as duration_nights')
            ->with('room')
            ->findOrFail($validatedData['booking_id']);

        if ($booking->duration_nights <= 0) {
            return back()->withErrors(['booking_id' => 'Durasi menginap tidak valid.'])->withInput();
        }

        $total = $booking->duration_nights * $booking->room->price;

        if ($validatedData['method'] !== 'cash' && $validatedData['amount'] != $total) {
            return back()->withErrors([
                'amount' => 'Untuk metode non-tunai, jumlah harus sama dengan total tagihan: Rp ' . number_format($total, 0, ',', '.')
            ])->withInput();
        }

        $oldData = $payment->toArray();

        DB::transaction(function () use ($validatedData, $payment, $booking, $total, $oldData) {
            $payment->update([
                'booking_id' => $booking->id,
                'amount' => $validatedData['amount'],
                'paid_at' => $validatedData['paid_at'],
                'method' => $validatedData['method'],
                'total' => $total,
            ]);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity_type' => 'update',
                'description' => 'Memperbarui pembayaran #' . $payment->id,
                'ip_address' => request()->ip(),
                'role' => auth()->user()->role,
                'old_values' => json_encode($oldData),
                'new_values' => json_encode($validatedData)
            ]);
        });

        return redirect()->route(auth()->user()->role . '.payments.index')
               ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Payment $payment)
    {
        $oldData = $payment->toArray();

        DB::transaction(function () use ($payment, $oldData) {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity_type' => 'delete',
                'description' => 'Menghapus pembayaran #' . $payment->id,
                'ip_address' => request()->ip(),
                'role' => auth()->user()->role,
                'old_values' => json_encode($oldData)
            ]);
            
            $payment->delete();
        });

        return redirect()->route(auth()->user()->role . '.payments.index')
               ->with('success', 'Transaksi berhasil dihapus.');
    }

public function invoiceIndex(Request $request)
{
    $search = $request->input('search', '');
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');

    $payments = Payment::with(['booking.room', 'booking.guest'])
        ->whereHas('booking', function($query) use ($search) {
            $query->whereHas('guest', function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        })
        ->when($start_date && $end_date, function($query) use ($start_date, $end_date) {
            $query->whereBetween('paid_at', [$start_date, $end_date]);
        })
        ->orderBy('paid_at', 'desc')
        ->paginate(10);

    // Get unpaid bookings for invoice creation
    $unpaidBookings = Booking::with(['guest', 'room'])
        ->where('status', 'pending')
        ->whereDoesntHave('payments')
        ->get();

    return view('invoices.index', compact('payments', 'search', 'start_date', 'end_date', 'unpaidBookings'));
}
    public function storeInvoice(Request $request)
    {
        $validatedData = $request->validate([
            'client' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after:issue_date',
            'invoice_number' => 'required|string|unique:invoices,invoice_number',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.amount' => 'required|numeric|min:0',
            'amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validatedData) {
            $invoice = Invoice::create([
                'invoice_number' => $validatedData['invoice_number'],
                'client_name' => $validatedData['client'],
                'issue_date' => $validatedData['issue_date'],
                'due_date' => $validatedData['due_date'],
                'amount' => $validatedData['amount'],
                'tax_rate' => 10, // Default tax rate 10%
                'notes' => $validatedData['notes'],
                'status' => 'pending',
                'created_by' => auth()->id(),
            ]);

            foreach ($validatedData['items'] as $item) {
                $invoice->items()->create([
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'amount' => $item['amount'],
                ]);
            }

            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity_type' => 'create',
                'description' => 'Membuat invoice #' . $invoice->invoice_number,
                'ip_address' => request()->ip(),
                'role' => auth()->user()->role
            ]);
        });

        return redirect()->route('admin.finance.invoices')
               ->with('success', 'Invoice berhasil dibuat.');
    }

    public function showInvoice($id)
    {
        $payment = Payment::with(['booking.room', 'booking.guest'])->findOrFail($id);
        
        return response()->json([
            'payment' => $payment,
            'guest' => $payment->booking->guest,
            'room' => $payment->booking->room,
            'booking' => $payment->booking,
        ]);
    }

    public function printInvoice($id)
    {
        $payment = Payment::with(['booking.room', 'booking.guest'])->findOrFail($id);
        
        return view('admin.finance.invoice-print', compact('payment'));
    }

    
}