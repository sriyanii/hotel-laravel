<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['booking.room', 'booking.guest'])
                         ->orderBy('paid_at', 'desc')
                         ->paginate(10);

        $view = view()->exists(auth()->user()->role . '.payments.index')
            ? auth()->user()->role . '.payments.index'
            : 'payments.index';

        return view($view, compact('payments'));
    }

    public function create()
    {
        $role = auth()->user()->role;

        // Hanya tampilkan booking yang belum memiliki pembayaran
        $bookings = Booking::with(['room', 'guest'])
            ->where('status', '!=', 'checked_out')
            ->whereDoesntHave('payments')
            ->select('id', 'guest_id', 'room_id', 'check_in', 'check_out')
            ->selectRaw('DATEDIFF(check_out, check_in) as duration_nights')
            ->get();

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

        $booking = Booking::with('room')->findOrFail($validatedData['booking_id']);
        
        $duration = Carbon::parse($booking->check_in)->diffInDays($booking->check_out);
        $calculatedTotal = $duration * $booking->room->price;

        // Validasi jumlah pembayaran
        if ($validatedData['method'] !== 'cash' && $validatedData['amount'] != $calculatedTotal) {
            return back()->withErrors([
                'amount' => 'Untuk metode non-tunai, jumlah harus sama dengan total'
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

            // Log activity
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

        // Tampilkan semua booking yang belum dibayar + booking yang sedang diedit
        $bookings = Booking::with(['room', 'guest'])
            ->where(function($query) use ($payment) {
                $query->whereDoesntHave('payments')
                      ->orWhere('id', $payment->booking_id);
            })
            ->where('status', '!=', 'checked_out')
            ->select('id', 'guest_id', 'room_id', 'check_in', 'check_out')
            ->selectRaw('DATEDIFF(check_out, check_in) as duration_nights')
            ->get();

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

        $booking = Booking::with('room')->findOrFail($validatedData['booking_id']);
        $duration = Carbon::parse($booking->check_in)->diffInDays($booking->check_out);
        $total = $duration * $booking->room->price;

        // Validasi jumlah pembayaran
        if ($validatedData['method'] !== 'cash' && $validatedData['amount'] != $total) {
            return back()->withErrors([
                'amount' => 'Untuk metode non-tunai, jumlah harus sama dengan total'
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

            // Log activity
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
            // Log activity sebelum dihapus
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
}