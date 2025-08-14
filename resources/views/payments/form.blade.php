@extends('layouts.adminlte')

@section('content')
@php
    $role = auth()->user()->role;
@endphp

<div class="container py-3">
    <!-- Modal Konfirmasi Pembayaran -->
    <div class="modal fade" id="paymentMismatchModal" tabindex="-1" role="dialog" aria-labelledby="paymentMismatchModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-4 shadow-lg border-0">
                <!-- HEADER -->
                <div class="modal-header text-white rounded-top-4" style="background: linear-gradient(45deg, #C9A227, #D4AF37);">
                    <h5 class="modal-title fw-bold" id="paymentMismatchModalLabel">
                        <i class="fas fa-coins me-2"></i>
                        Konfirmasi Pembayaran
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- BODY -->
                <div class="modal-body text-dark-brown">
                    <div id="normalConfirmation" class="d-block">
                        <p>Apakah Anda yakin ingin menyimpan transaksi ini?</p>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Pastikan semua data sudah benar sebelum menyimpan.
                        </div>
                    </div>
                    <div id="excessConfirmation" class="d-none">
                        <p id="mismatchMessage" class="mb-2">
                            Jumlah pembayaran melebihi tagihan. Uang lebih akan dikembalikan.
                        </p>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Perhatian:</strong> Pastikan Anda sudah memberikan kembalian kepada tamu.
                        </div>
                        <table class="table table-sm">
                            <tr>
                                <th>Subtotal</th>
                                <td id="modalSubtotal">Rp 0</td>
                            </tr>
                            <tr>
                                <th>Jumlah Bayar</th>
                                <td id="modalAmount">Rp 0</td>
                            </tr>
                            <tr class="table-success">
                                <th>Kembalian</th>
                                <td id="modalChange">Rp 0</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="modal-footer border-0 bg-cream">
                    <button type="button" class="btn btn-outline-dark-brown" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="button" class="btn text-white" id="confirmProceed" style="background: linear-gradient(45deg, #C9A227, #D4AF37);">
                        <i class="fas fa-check me-1"></i> Konfirmasi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow rounded-4 border-0">
        <div class="card-header bg-gold text-dark d-flex align-items-center rounded-top-4">
            <h4 class="mb-0 fw-bold">
                <i class="fas fa-cash-register me-2"></i>
                @isset($payment->id) Edit @else Buat @endisset Transaksi
            </h4>
            <div class="ms-auto">
                <span class="badge bg-light-gold text-dark-brown fs-6">
                    <i class="fas fa-hashtag me-1"></i>
                    @isset($payment->id) #{{ $payment->id }} @else Baru @endisset
                </span>
            </div>
        </div>

        <div class="card-body bg-cream">
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
                <h5 class="fw-bold mb-3 text-dark-brown">
                    <i class="fas fa-calendar-check me-2"></i>
                    Pilih Booking
                </h5>
                <div class="row align-items-end">
                    <div class="col-md-6">
                        <label class="fw-semibold text-dark-brown">
                            <i class="fas fa-bed me-1"></i>
                            Booking (No Kamar - Nama Tamu - Harga Permalam)
                        </label>
                        <select name="booking_id" id="booking_id" class="form-control" required>
                            <option value="">-- Pilih Booking --</option>
                            @foreach ($bookings as $booking)
                                <option 
                                    value="{{ $booking->id }}"
                                    data-duration="{{ $booking->duration_nights }}"
                                    data-price="{{ $booking->room->price }}"
                                    data-room-number="{{ $booking->room->number }}"
                                    data-guest-name="{{ $booking->guest->name }}"
                                    @selected(old('booking_id', $payment->booking_id ?? '') == $booking->id)
                                >
                                    #{{ $booking->id }} - Kamar {{ $booking->room->number }} - {{ $booking->guest->name }} - Rp {{ number_format($booking->room->price, 0, ',', '.') }}/malam
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="fw-semibold text-dark-brown">
                            <i class="fas fa-moon me-1"></i>
                            Durasi Menginap
                        </label>
                        <input type="text" id="duration" class="form-control bg-light" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="fw-semibold text-dark-brown">
                            <i class="fas fa-door-open me-1"></i>
                            Nomor Kamar
                        </label>
                        <input type="text" id="room_number" class="form-control bg-light" readonly>
                    </div>
                </div>
            </div>

            <!-- Detail Transaksi -->
            <div class="mb-4">
                <h5 class="fw-bold mb-3 text-dark-brown">
                    <i class="fas fa-receipt me-2"></i>
                    Detail Transaksi
                </h5>
                <table class="table table-bordered align-middle">
                    <thead class="table-dark-brown text-white">
                        <tr>
                            <th>Harga Permalam</th>
                            <th>Durasi</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="price_per_night" class="bg-light-gold">Rp 0</td>
                            <td id="duration_display" class="bg-light-gold">0 malam</td>
                            <td id="subtotal" class="fw-bold text-dark-brown bg-light-gold">Rp 0</td>
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
                        <div class="form-group">
                            <label class="fw-semibold text-dark-brown">
                                <i class="fas fa-credit-card me-1"></i>
                                Metode Pembayaran
                            </label>
                            <select name="method" id="payment_method" class="form-control" required>
                                <option value="">-- Pilih Metode --</option>
                                <option value="cash" @selected(old('method', $payment->method ?? '') == 'cash')>Cash</option>
                                <option value="transfer" @selected(old('method', $payment->method ?? '') == 'transfer')>Transfer</option>
                                <option value="qris" @selected(old('method', $payment->method ?? '') == 'qris')>QRIS</option>
                                <option value="debit" @selected(old('method', $payment->method ?? '') == 'debit')>Kartu Debit</option>
                                <option value="credit" @selected(old('method', $payment->method ?? '') == 'credit')>Kartu Kredit</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-semibold text-dark-brown">
                                <i class="fas fa-calendar-day me-1"></i>
                                Tanggal Pembayaran
                            </label>
                            <input type="datetime-local" name="paid_at" class="form-control" required 
                                   value="{{ old('paid_at', isset($payment->paid_at) ? $payment->paid_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}">
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-semibold text-dark-brown">
                                <i class="fas fa-money-bill-wave me-1"></i>
                                Jumlah Bayar
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light-gold">Rp</span>
                                <input type="number" name="amount" id="amount_input" class="form-control" required min="0"
                                       value="{{ old('amount', $payment->amount ?? 0) }}" step="1000">
                            </div>
                            <small class="text-danger" id="amount_error" style="display:none;"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fw-semibold text-dark-brown">
                                <i class="fas fa-exchange-alt me-1"></i>
                                Kembalian
                            </label>
                            <input type="text" id="change_amount" class="form-control bg-light-gold fw-bold" readonly value="Rp 0">
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route($role . '.payments.index') }}" class="btn btn-outline-dark-brown">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="button" id="submit_btn" class="btn btn-gold rounded-pill px-4">
                                <i class="fas fa-save me-1"></i> Simpan Transaksi
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- CSS Tema Gold dan Brown --}}
<style>
    /* Warna Utama */
    .bg-gold {
        background: linear-gradient(45deg, #C9A227, #D4AF37) !important;
    }
    .bg-cream {
        background-color: #FAF6F0 !important;
    }
    .text-dark-brown {
        color: #4E342E !important;
    }
    .bg-dark-brown {
        background-color: #4E342E !important;
    }
    .table-dark-brown {
        background: linear-gradient(45deg, #3E2723, #5D4037);
        color: white;
    }
    
    /* Warna Sekunder */
    .bg-light-gold {
        background-color: rgba(201, 162, 39, 0.15) !important;
    }
    .text-gold {
        color: #C9A227 !important;
    }
    
    /* Tombol */
    .btn-outline-gold {
        color: #C9A227;
        border: 1px solid #C9A227;
        background-color: transparent;
    }
    .btn-outline-gold:hover {
        background-color: #C9A227;
        color: white;
    }
    .btn-outline-dark-brown {
        color: #4E342E;
        border: 1px solid #4E342E;
        background-color: transparent;
    }
    .btn-outline-dark-brown:hover {
        background-color: #4E342E;
        color: white;
    }
    
    .btn-gold {
        background: linear-gradient(45deg, #C9A227, #D4AF37);
        color: white;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-gold:hover {
        background: linear-gradient(45deg, #B7931A, #C9A227);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    /* Badge */
    .badge.bg-light-gold {
        background-color: rgba(201, 162, 39, 0.2);
    }
    
    /* Form */
    .form-control:focus {
        border-color: #C9A227;
        box-shadow: 0 0 0 0.25rem rgba(201, 162, 39, 0.25);
    }
    
    /* Animasi */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
    }
    .pulse-animation {
        animation: pulse 1.5s infinite;
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 for booking selection
    $('#booking_id').select2({
        placeholder: "Cari booking...",
        templateResult: formatBookingOption,
        templateSelection: formatBookingSelection,
        width: '100%'
    });

    function formatBookingOption(booking) {
        if (!booking.id) return booking.text;
        const $option = $(booking.element);
        return $(
            `<div>
                <strong>#${$option.val()}</strong> - Kamar ${$option.data('room-number')}
                <div class="text-muted">${$option.data('guest-name')}</div>
                <div class="text-success">Rp ${parseInt($option.data('price')).toLocaleString('id-ID')}/malam</div>
            </div>`
        );
    }

    function formatBookingSelection(booking) {
        if (!booking.id) return booking.text;
        const $option = $(booking.element);
        return `#${$option.val()} - Kamar ${$option.data('room-number')} - ${$option.data('guest-name')}`;
    }

    const bookingSelect = document.getElementById('booking_id');
    const methodSelect = document.getElementById('payment_method');
    const amountInput = document.getElementById('amount_input');
    const amountError = document.getElementById('amount_error');
    const changeAmount = document.getElementById('change_amount');
    const submitBtn = document.getElementById('submit_btn');
    const paymentForm = document.getElementById('payment_form');
    const mismatchModal = $('#paymentMismatchModal');
    const normalConfirmation = document.getElementById('normalConfirmation');
    const excessConfirmation = document.getElementById('excessConfirmation');

    function updatePaymentDetails() {
        const selected = bookingSelect.options[bookingSelect.selectedIndex];
        if (!selected.value) {
            resetPaymentDetails();
            return;
        }

        const duration = Math.abs(parseInt(selected.getAttribute('data-duration')));
        const price = Math.abs(parseInt(selected.getAttribute('data-price')));
        const roomNumber = selected.getAttribute('data-room-number');
        const subtotal = price * duration;

        document.getElementById('duration').value = duration + ' malam';
        document.getElementById('room_number').value = 'Kamar ' + roomNumber;
        document.getElementById('price_per_night').innerText = 'Rp ' + price.toLocaleString('id-ID');
        document.getElementById('duration_display').innerText = duration + ' malam';
        document.getElementById('subtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');

        document.getElementById('form_booking_id').value = selected.value;
        document.getElementById('form_subtotal').value = subtotal;

        // Auto-fill amount with subtotal if empty
        if (!amountInput.value || amountInput.value === '0') {
            amountInput.value = subtotal;
        }

        amountInput.min = methodSelect.value === 'cash' ? 0 : subtotal;
        calculateChange();
    }

    function resetPaymentDetails() {
        document.getElementById('duration').value = '';
        document.getElementById('room_number').value = '';
        document.getElementById('price_per_night').innerText = 'Rp 0';
        document.getElementById('duration_display').innerText = '0 malam';
        document.getElementById('subtotal').innerText = 'Rp 0';
        document.getElementById('form_booking_id').value = '';
        document.getElementById('form_subtotal').value = '0';
        changeAmount.value = 'Rp 0';
        amountError.style.display = 'none';
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
                changeAmount.classList.remove('text-danger');
                changeAmount.classList.add('text-success');
            } else {
                changeAmount.value = 'Rp ' + Math.abs(change).toLocaleString('id-ID') + ' (Kurang)';
                changeAmount.classList.remove('text-success');
                changeAmount.classList.add('text-danger');
            }
        } else {
            changeAmount.value = amount >= subtotal ? 'Lunas' : 'Kurang';
            changeAmount.classList.remove('text-success', 'text-danger');
            changeAmount.classList.add(amount >= subtotal ? 'text-success' : 'text-danger');
        }
    }

    function validateForm() {
        const subtotal = Math.abs(parseInt(document.getElementById('form_subtotal').value) || 0);
        let amount = parseInt(amountInput.value);
        const method = methodSelect.value;
        let isValid = true;

        // Reset error
        amountError.style.display = 'none';

        if (!bookingSelect.value) {
            Swal.fire({
                icon: 'error',
                title: 'Peringatan',
                text: 'Pilih booking terlebih dahulu!',
                confirmButtonColor: '#C9A227'
            });
            isValid = false;
        }

        if (isNaN(amount) || amount < 0) {
            amountError.textContent = 'Jumlah bayar tidak valid!';
            amountError.style.display = 'block';
            isValid = false;
        }

        if (method !== 'cash' && amount > subtotal) {
            amountError.textContent = `Metode ${method.toUpperCase()} tidak boleh melebihi jumlah tagihan!`;
            amountError.style.display = 'block';
            isValid = false;
        }

        if (amount < subtotal) {
            amountError.textContent = 'Jumlah bayar tidak boleh kurang dari subtotal!';
            amountError.style.display = 'block';
            isValid = false;
        }

        return isValid;
    }

    // Event Listeners
    bookingSelect.addEventListener('change', updatePaymentDetails);
    methodSelect.addEventListener('change', function() {
        const subtotal = Math.abs(parseInt(document.getElementById('form_subtotal').value) || 0);
        amountInput.min = this.value === 'cash' ? 0 : subtotal;
        calculateChange();
    });
    
    amountInput.addEventListener('input', function() {
        if (this.value < 0) this.value = 0;
        calculateChange();
    });

    // Initialize form if editing
    if (bookingSelect.value) {
        updatePaymentDetails();
    }

    submitBtn.addEventListener('click', function(e) {
        e.preventDefault();

        if (!validateForm()) return;

        const subtotal = Math.abs(parseInt(document.getElementById('form_subtotal').value) || 0);
        let amount = parseInt(amountInput.value);
        const method = methodSelect.value;
        const change = amount - subtotal;

        // Prepare modal content based on payment situation
        if (method === 'cash' && amount > subtotal) {
            // Show excess payment confirmation
            normalConfirmation.classList.add('d-none');
            excessConfirmation.classList.remove('d-none');
            
            document.getElementById('modalSubtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            document.getElementById('modalAmount').textContent = 'Rp ' + amount.toLocaleString('id-ID');
            document.getElementById('modalChange').textContent = 'Rp ' + change.toLocaleString('id-ID');
            
            mismatchMessage.textContent = `Jumlah pembayaran melebihi tagihan sebesar Rp ${change.toLocaleString('id-ID')}.`;
        } else {
            // Show normal confirmation
            normalConfirmation.classList.remove('d-none');
            excessConfirmation.classList.add('d-none');
        }

        mismatchModal.modal('show');
    });

    // Confirm proceed button
    document.getElementById('confirmProceed').addEventListener('click', function() {
        mismatchModal.modal('hide');
        // Add loading state
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
        submitBtn.disabled = true;
        
        // Submit form after a slight delay to allow modal to hide
        setTimeout(() => {
            paymentForm.submit();
        }, 300);
    });

    // Auto-format amount input on blur
    amountInput.addEventListener('blur', function() {
        if (this.value) {
            this.value = parseInt(this.value).toLocaleString('id-ID');
        }
    });

    amountInput.addEventListener('focus', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
});
</script>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#C9A227',
        timer: 3000,
        timerProgressBar: true
    });
});
</script>
@endif
@endsection