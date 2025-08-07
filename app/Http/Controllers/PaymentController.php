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

        // Hanya ambil booking yang masih berlaku (tidak dihapus) dan status valid
        $bookings = Booking::whereIn('status', ['Booked', 'Checked Out'])->get();

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
        ]);

        Payment::create($request->all());

        $role = auth()->user()->role;
        return redirect()->route($role . '.payments.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(Payment $payment)
    {
        $role = auth()->user()->role;

        // Sama seperti create(), hanya ambil booking yang aktif
        $bookings = Booking::whereIn('status', ['Booked', 'Checked Out'])->get();

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
            'method' => 'required|in:cash,transfer,qris', // konsisten dengan form create
        ]);

        $payment->update($request->all());

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
