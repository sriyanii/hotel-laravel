<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['booking.guest', 'booking.room'])->latest()->get();
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $role = auth()->user()->role;

        $bookings = Booking::with(['room', 'guest'])
            ->where('status', '!=', 'checked_out')
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
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric|min:0',
            'paid_at' => 'required|date',
            'method' => 'required|in:cash,transfer,qris',
            'total' => 'required|numeric|min:0', // Tambah validasi untuk total
        ]);

        // Hitung total berdasarkan data booking
        $booking = Booking::find($request->booking_id);
        $duration = \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out);
        $price = $booking->room->price;
        $total = $duration * $price;

        // Simpan data payment dengan total yang dihitung
        Payment::create([
            'booking_id' => $request->booking_id,
            'amount' => $request->amount,
            'paid_at' => $request->paid_at,
            'method' => $request->method,
            'total' => $total, // Tambah kolom total di tabel payments
        ]);

        $role = auth()->user()->role;
        return redirect()->route($role . '.payments.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(Payment $payment)
    {
        $role = auth()->user()->role;

        $bookings = Booking::with(['room', 'guest'])
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
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric|min:0',
            'paid_at' => 'required|date',
            'method' => 'required|in:cash,transfer,qris',
            'total' => 'required|numeric|min:0', // Tambah validasi untuk total
        ]);

        // Hitung total berdasarkan data booking
        $booking = Booking::find($request->booking_id);
        $duration = \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out);
        $price = $booking->room->price;
        $total = $duration * $price;

        // Update data payment dengan total yang dihitung
        $payment->update([
            'booking_id' => $request->booking_id,
            'amount' => $request->amount,
            'paid_at' => $request->paid_at,
            'method' => $request->method,
            'total' => $total, // Tambah kolom total di tabel payments
        ]);

        $role = auth()->user()->role;
        return redirect()->route($role . '.payments.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        $role = auth()->user()->role;
        return redirect()->route($role . '.payments.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}