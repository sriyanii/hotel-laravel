@extends('layouts.adminlte')

@section('title', 'Daftar Pembayaran')

@section('content')
<div class="container py-4">
    <div class="card shadow rounded-2 border-0">

        {{-- HEADER --}}
        <div class="card-header text-white d-flex justify-content-between align-items-center rounded-top-4" style="background: #3d3d3d">
            <h4 class="mb-0 fw-bold">
                <i class="fas fa-credit-card me-2"></i> Daftar Pembayaran
            </h4>
            <a href="{{ route('admin.payments.create') }}" class="btn btn-light text-dark fw-semibold"> 
                <i class="fas fa-plus"></i> Tambah Pembayaran
            </a>
        </div>

        {{-- SEARCH FORM --}}
        <div class="card-body">
            <form action="{{ route('admin.payments.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama Tamu atau Kamar" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-secondary">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
               </div>
            </form>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Kamar (Harga/Malam)</th>
                            <th>Tamu</th>
                            <th>Jumlah Bayar</th>
                            <th>Kembalian</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            @php
                                $checkIn = \Carbon\Carbon::parse($payment->booking->check_in);
                                $checkOut = \Carbon\Carbon::parse($payment->booking->check_out);
                                $duration = $checkIn->diffInDays($checkOut);
                                $totalBill = $payment->booking->room->price * $duration;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration + ($payments->perPage() * ($payments->currentPage() - 1)) }}</td>
                                <td>
                                    {{ $payment->booking->room->number }} 
                                    <br>
                                    <small class="text-muted">Rp {{ number_format($payment->booking->room->price, 0, ',', '.') }}/malam</small>
                                </td>
                                <td>{{ $payment->booking->guest->name }}</td>
                                <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td>
                                    @if($payment->method == 'cash' && $payment->amount > $totalBill)
                                        Rp {{ number_format($payment->amount - $totalBill, 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-pink-soft text-dark">
                                        {{ ucfirst($payment->method) }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        // Mapping Status Booking ke format lebih ramah pengguna
                                        $statusMap = [
                                            'booked' => 'Booked',
                                            'checked_in' => 'Checked In',
                                            'checked_out' => 'Checked Out',
                                            'canceled' => 'Canceled',
                                            'paid' => 'Paid'
                                        ];
                                        $status = $statusMap[$payment->booking->status] ?? '-';
                                    @endphp
                                    <span class="badge bg-{{ $payment->status == 'completed' ? 'success' : 'warning' }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.payments.edit', $payment->id) }}" class="btn btn-sm btn-outline-warning rounded-circle me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <button class="btn btn-sm btn-outline-info me-1 view-btn rounded-circle" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#paymentModal" 
                                            data-payment='@json($payment)'>
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    
                                    <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data pembayaran?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Belum ada data pembayaran</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-end my-4" style="margin-right: 30px;">
                {{ $payments->links() }}
            </div>
        </div>

    </div>
</div>

<!-- Payment Detail Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-2 border-0 shadow">
            <div class="modal-header text-white rounded-top-2" style="background: #3d3d3d">
                <h5 class="modal-title fw-bold" id="paymentModalLabel">
                    <i class="fas fa-receipt me-2"></i> Detail Pembayaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="fw-bold text-pink">Informasi Booking</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th width="40%">ID Booking</th>
                                    <td id="modal-booking-id"></td>
                                </tr>
                                <tr>
                                    <th>Kamar</th>
                                    <td id="modal-room"></td>
                                </tr>
                                <tr>
                                    <th>Harga Permalam</th>
                                    <td id="modal-price"></td>
                                </tr>
                                <tr>
                                    <th>Durasi Menginap</th>
                                    <td id="modal-duration"></td>
                                </tr>
                                <tr>
                                    <th>Total Tagihan</th>
                                    <td id="modal-total-bill"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="fw-bold text-pink">Informasi Tamu</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th width="40%">Nama Tamu</th>
                                    <td id="modal-guest"></td>
                                </tr>
                                <tr>
                                    <th>Kontak</th>
                                    <td id="modal-contact"></td>
                                </tr>
                                <tr>
                                    <th>Identitas</th>
                                    <td id="modal-identity"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="border-top pt-3">
                    <h6 class="fw-bold text-pink">Detail Pembayaran</h6>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="40%">Jumlah Bayar</th>
                            <td id="modal-amount"></td>
                        </tr>
                        <tr>
                            <th>Kembalian</th>
                            <td id="modal-change"></td>
                        </tr>
                        <tr>
                            <th>Metode Pembayaran</th>
                            <td id="modal-method"></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td id="modal-status"></td>
                        </tr>
                        <tr>
                            <th>Tanggal Pembayaran</th>
                            <td id="modal-paid-at"></td>
                        </tr>
                        <tr>
                            <th>Catatan</th>
                            <td id="modal-notes"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-btn');
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const paymentData = JSON.parse(this.getAttribute('data-payment'));

            // Mapping status booking
            const bookingStatusMap = {
                'booked': 'Booked',
                'checked_in': 'Checked In',
                'checked_out': 'Checked Out',
                'canceled': 'Canceled',
                'paid': 'Paid'
            };

            const bookingStatus = bookingStatusMap[paymentData.booking.status] || '-';

            // Calculate duration and total bill
            const checkIn = new Date(paymentData.booking.check_in);
            const checkOut = new Date(paymentData.booking.check_out);
            const durationInDays = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));

            // Calculate total bill
            const pricePerNight = parseFloat(paymentData.booking.room.price);
            const totalBill = pricePerNight * durationInDays;
            const amountPaid = parseFloat(paymentData.amount);

            // Calculate change (only for cash method and when the paid amount is greater)
            const change = (paymentData.method === 'cash' && amountPaid > totalBill)
                ? amountPaid - totalBill
                : 0;

            // Format paid date
            const paidDate = new Date(paymentData.paid_at);
            const formattedDate = paidDate.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            // Fill modal with payment data
            document.getElementById('modal-booking-id').textContent = '#' + paymentData.booking_id;
            document.getElementById('modal-room').textContent = 'Kamar ' + paymentData.booking.room.number;
            document.getElementById('modal-price').textContent = 'Rp ' + pricePerNight.toLocaleString('id-ID') + '/malam';
            document.getElementById('modal-duration').textContent = durationInDays + ' malam';
            document.getElementById('modal-total-bill').textContent = 'Rp ' + totalBill.toLocaleString('id-ID');
            document.getElementById('modal-guest').textContent = paymentData.booking.guest.name;
            document.getElementById('modal-contact').textContent = paymentData.booking.guest.phone;
            document.getElementById('modal-identity').textContent = paymentData.booking.guest.identity_number;
            document.getElementById('modal-amount').textContent = 'Rp ' + amountPaid.toLocaleString('id-ID');
            document.getElementById('modal-change').textContent = change > 0
                ? 'Rp ' + change.toLocaleString('id-ID')
                : '-';
            document.getElementById('modal-method').textContent = paymentData.method.charAt(0).toUpperCase() + paymentData.method.slice(1);
            document.getElementById('modal-status').textContent = bookingStatus;
            document.getElementById('modal-paid-at').textContent = formattedDate;
            document.getElementById('modal-notes').textContent = paymentData.notes || '-';
        });
    });
});
</script>
@endsection
