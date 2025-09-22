@extends('layouts.adminlte')

@section('content')
@php
    $role = auth()->user()->role;
@endphp

<div class="container py-4">

    <!-- Modal Konfirmasi Pembayaran -->
    <div class="modal fade" id="paymentMismatchModal" tabindex="-1" role="dialog" aria-labelledby="paymentMismatchModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header text-white" style="background: #3d3d3d">
                    <h5 class="modal-title fw-bold" id="paymentMismatchModalLabel">
                        <i class="fas fa-money-check-alt me-2"></i>
                        Konfirmasi Pembayaran
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-secondary">
                    <p id="mismatchMessage" class="mb-0">
                        Apakah Anda yakin ingin melanjutkan?
                    </p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn text-white" data-bs-dismiss="modal" style="background-color: #6c757d;">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="button" class="btn text-white" id="confirmProceed" style="background-color: #495057;">
                        <i class="fas fa-check me-1"></i> Lanjutkan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Transaksi -->
    <div class="card shadow border-0">
        <div class="card-header text-white d-flex justify-content-between align-items-center" style="background: #3d3d3d">
            <div>
                <i class="fas fa-cash-register me-2"></i>
                <span class="fw-bold">@isset($payment->id) Edit @else Buat @endisset Transaksi</span>
            </div>
            <a href="{{ route($role . '.payments.index') }}" class="btn btn-sm btn-light">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger rounded-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

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
                                    @selected(old('booking_id', $payment->booking_id ?? '') == $booking->id)
                                >
                                    #{{ $booking->id }} - Kamar {{ $booking->room->number }} - {{ $booking->guest->name }} - Rp {{ number_format($booking->room->price, 0, ',', '.') }}/malam
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="fw-semibold">Durasi Menginap</label>
                        <input type="text" id="duration" class="form-control bg-light" readonly>
                    </div>
                </div>
            </div>

            <!-- Detail Transaksi -->
            <div class="mb-4">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Harga Permalam</th>
                            <th>Durasi</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="price_per_night" class="bg-light">Rp 0</td>
                            <td id="duration_display" class="bg-light">0 malam</td>
                            <td id="subtotal" class="fw-bold text-danger bg-light">Rp 0</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Form Pembayaran -->
            <form action="{{ $action }}" method="POST" id="payment_form">
                @csrf
                @isset($payment->id) @method('PUT') @endisset

                <input type="hidden" name="booking_id" id="form_booking_id" value="{{ old('booking_id', $payment->booking_id ?? '') }}">
                <input type="hidden" name="subtotal" id="form_subtotal" value="0">

                <div class="row">
                    <div class="col-md-6">
                        <label class="fw-semibold">Metode Pembayaran</label>
                        <select name="method" id="payment_method" class="form-control" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="cash" @selected(old('method', $payment->method ?? '') == 'cash')>Cash</option>
                            <option value="transfer" @selected(old('method', $payment->method ?? '') == 'transfer')>Transfer</option>
                            <option value="qris" @selected(old('method', $payment->method ?? '') == 'qris')>QRIS</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-semibold">Tanggal Pembayaran</label>
                        <input type="datetime-local" name="paid_at" class="form-control" required 
                               value="{{ old('paid_at', isset($payment->paid_at) ? $payment->paid_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="fw-semibold">Jumlah Bayar</label>
                        <input type="number" name="amount" id="amount_input" class="form-control" required min="0"
                               value="{{ old('amount', $payment->amount ?? 0) }}">
                        <small class="text-danger" id="amount_error" style="display:none;">Error</small>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-semibold">Kembalian</label>
                        <input type="text" id="change_amount" class="form-control bg-light" readonly value="Rp 0">
                    </div>
                </div>

                <!-- Footer Form -->
                <div class="mt-4 text-end">
                    <button type="button" id="submit_btn" class="btn btn-dark me-2">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                    <a href="{{ route($role . '.payments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bookingSelect = document.getElementById('booking_id');
    const methodSelect = document.getElementById('payment_method');
    const amountInput = document.getElementById('amount_input');
    const amountError = document.getElementById('amount_error');
    const changeAmount = document.getElementById('change_amount');
    const submitBtn = document.getElementById('submit_btn');
    const paymentForm = document.getElementById('payment_form');
    const mismatchModal = $('#paymentMismatchModal');
    const mismatchMessage = document.getElementById('mismatchMessage');

    function updatePaymentDetails() {
        const selected = bookingSelect.options[bookingSelect.selectedIndex];
        if (!selected.value) return;

        const duration = Math.abs(parseInt(selected.getAttribute('data-duration')));
        const price = Math.abs(parseInt(selected.getAttribute('data-price')));
        const subtotal = price * duration;

        document.getElementById('duration').value = duration + ' malam';
        document.getElementById('price_per_night').innerText = 'Rp ' + price.toLocaleString('id-ID');
        document.getElementById('duration_display').innerText = duration + ' malam';
        document.getElementById('subtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');

        document.getElementById('form_booking_id').value = selected.value;
        document.getElementById('form_subtotal').value = subtotal;

        if (!amountInput.value || amountInput.value === '0') {
            amountInput.value = subtotal;
        }

        amountInput.min = 0;
        calculateChange();
    }

    function calculateChange() {
        const subtotal = Math.abs(parseInt(document.getElementById('form_subtotal').value) || 0);
        let amount = parseInt(amountInput.value) || 0;
        amount = Math.max(0, amount);
        const method = methodSelect.value;
        const change = amount - subtotal;

        if (method === 'cash') {
            if (change >= 0) {
                changeAmount.value = 'Rp ' + change.toLocaleString('id-ID');
                changeAmount.style.color = '#28a745';
            } else {
                changeAmount.value = 'Rp ' + Math.abs(change).toLocaleString('id-ID') + ' (Kurang)';
                changeAmount.style.color = '#dc3545';
            }
        } else {
            changeAmount.value = '-';
            changeAmount.style.color = '#6c757d';
        }
    }

    bookingSelect.addEventListener('change', updatePaymentDetails);
    methodSelect.addEventListener('change', calculateChange);
    amountInput.addEventListener('input', function () {
        if (this.value < 0) this.value = 0;
        calculateChange();
    });

    if (bookingSelect.value) updatePaymentDetails();

    submitBtn.addEventListener('click', function(e) {
        e.preventDefault();

        const subtotal = Math.abs(parseInt(document.getElementById('form_subtotal').value) || 0);
        let amount = parseInt(amountInput.value);
        const method = methodSelect.value;

        if (!bookingSelect.value) {
            alert('Pilih booking terlebih dahulu!');
            return;
        }

        if (isNaN(amount) || amount < 0) {
            amountError.textContent = 'Jumlah bayar tidak valid!';
            amountError.style.display = 'block';
            return;
        }

        if (amount < subtotal) {
            amountError.textContent = 'Jumlah bayar tidak boleh kurang dari subtotal!';
            amountError.style.display = 'block';
            return;
        }

        if (amount > subtotal && method !== 'cash') {
            amountError.textContent = `Metode ${method.toUpperCase()} tidak boleh melebihi jumlah tagihan!`;
            amountError.style.display = 'block';
            return;
        }

        amountError.style.display = 'none';

        if (amount > subtotal && method === 'cash') {
            const selisih = amount - subtotal;
            mismatchMessage.textContent = `Jumlah pembayaran melebihi tagihan sebesar Rp ${selisih.toLocaleString('id-ID')}. Uang lebih akan dikembalikan. Apakah Anda yakin ingin melanjutkan?`;
            mismatchModal.modal('show');
        } else {
            paymentForm.submit();
        }
    });

    document.getElementById('confirmProceed').addEventListener('click', function() {
        mismatchModal.modal('hide');
        paymentForm.submit();
    });
});
</script>

@endsection
