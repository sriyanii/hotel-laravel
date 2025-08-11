@extends('layouts.adminlte')

@section('content')
@php
    $role = auth()->user()->role;
@endphp

<div class="container py-3">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">
                <i class="fas fa-cash-register mr-2"></i>
                Transaksi Baru
            </h3>
        </div>

        <div class="card-body">
            <!-- Pilih Booking -->
            <div class="mb-4 border-bottom pb-3">
                <h5 class="fw-bold mb-3">Pilih Booking</h5>
                <div class="row align-items-end">
                    <div class="col-md-6">
                        <label class="fw-semibold">Booking (No Kamar - Nama Tamu - Harga Permalam)</label>
                        <select name="booking_id" id="booking_id" class="form-control" required>
                            <option value="">-- Pilih Booking --</option>
                            @foreach ($bookings as $booking)
                                <option 
                                    value="{{ $booking->id }}"
                                    data-duration="{{ $booking->duration_nights }}"
                                    data-price="{{ $booking->room->price }}"
                                >
                                    #{{ $booking->id }} - Kamar {{ $booking->room->number }} - {{ $booking->guest->name }} - Rp {{ number_format($booking->room->price, 0, ',', '.') }}/malam
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" id="select_booking" class="btn btn-primary w-100">
                            <i class="fas fa-check mr-1"></i> Pilih
                        </button>
                    </div>
                    <div class="col-md-3">
                        <label class="fw-semibold">Durasi Menginap</label>
                        <input type="text" id="duration" class="form-control bg-light" readonly>
                    </div>
                </div>
            </div>

            <!-- Detail Transaksi -->
            <div class="mb-4">
                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th>Harga Permalam</th>
                            <th>Durasi</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="price_per_night" class="bg-light">-</td>
                            <td id="duration_display" class="bg-light">-</td>
                            <td id="subtotal" class="fw-bold text-danger bg-light">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Form Pembayaran -->
            <form action="{{ $action }}" method="POST" id="payment_form">
                @csrf
                @if($payment->exists) @method('PUT') @endif

                <input type="hidden" name="booking_id" id="form_booking_id">
                <input type="hidden" name="subtotal" id="form_subtotal">

                <div class="row">
                    <div class="col-md-6 offset-md-6">
                        <div class="border p-3 bg-light rounded">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label fw-semibold">Metode</label>
                                <div class="col-sm-8">
                                    <select name="method" id="method" class="form-control" required>
                                        <option value="cash">Cash</option>
                                        <option value="transfer">Transfer</option>
                                        <option value="qris">QRIS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label fw-semibold">Bayar</label>
                                <div class="col-sm-8">
                                    <input type="number" name="amount" id="amount" class="form-control" min="0" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label fw-semibold">Kembalian</label>
                                <div class="col-sm-8">
                                    <input type="text" id="change" class="form-control bg-light" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label fw-semibold">Tanggal</label>
                                <div class="col-sm-8">
                                    <input type="date" name="paid_at" id="paid_at" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route($role . '.payments.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save mr-1"></i> Simpan Transaksi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Format rupiah
    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Tombol Pilih Booking
    document.getElementById('select_booking').addEventListener('click', function() {
        const bookingSelect = document.getElementById('booking_id');
        const selectedOption = bookingSelect.options[bookingSelect.selectedIndex];
        
        if (!selectedOption.value) {
            alert('Silakan pilih booking terlebih dahulu');
            return;
        }

        const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        const duration = parseInt(selectedOption.getAttribute('data-duration')) || 0;
        const subtotal = price * duration;

        // Update readonly fields
        document.getElementById('duration').value = duration + ' malam';
        document.getElementById('price_per_night').textContent = formatRupiah(price);
        document.getElementById('duration_display').textContent = duration + ' malam';
        document.getElementById('subtotal').textContent = formatRupiah(subtotal);
        document.getElementById('change').value = formatRupiah(0);
        
        // Update form hidden values
        document.getElementById('form_booking_id').value = selectedOption.value;
        document.getElementById('form_subtotal').value = subtotal;
        document.getElementById('amount').value = subtotal;
        
        // Trigger perhitungan kembalian
        updateChange();
    });

    // Hitung kembalian
    function updateChange() {
        const subtotal = parseFloat(document.getElementById('form_subtotal').value) || 0;
        const amount = parseFloat(document.getElementById('amount').value) || 0;
        const method = document.getElementById('method').value;

        if (method === 'cash' && amount >= subtotal) {
            document.getElementById('change').value = formatRupiah(amount - subtotal);
        } else {
            document.getElementById('change').value = '-';
        }
    }

    // Event listeners
    document.getElementById('amount').addEventListener('input', updateChange);
    document.getElementById('method').addEventListener('change', updateChange);
});
</script>
@endpush

@endsection