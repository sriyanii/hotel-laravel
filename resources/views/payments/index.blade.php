@extends('layouts.adminlte')

@section('title', 'Daftar Pembayaran')

@section('content')
<div class="container-fluid py-4">
<!-- Header -->
<div class="header d-flex justify-content-between align-items-center">
    <h2><i class="fas fa-receipt me-2"></i> Invoice Management</h2>
    <div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createInvoiceModal">
            <i class="fas fa-plus-circle me-2"></i> Create Invoice
        </button>
    </div>
</div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-md-3">
            <div class="stats-card">
                @php
                    $totalRevenue = $payments->where('status', '!=', 'refunded')->sum('amount');
                @endphp
                <div class="count">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="label">Total Revenue</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="count" style="color: var(--success);">{{ $payments->where('status', 'paid')->count() }}</div>
                <div class="label">Paid Invoices</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="count" style="color: var(--warning);">{{ $payments->where('status', 'pending')->count() }}</div>
                <div class="label">Pending Payments</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="count" style="color: var(--danger);">{{ $payments->where('status', 'failed')->count() }}</div>
                <div class="label">Overdue Invoices</div>
            </div>
        </div>
    </div>

    <!-- Payment List Card -->
    <div class="invoice-card">
        <ul class="nav nav-tabs invoice-tabs" id="paymentTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-payments" type="button" role="tab">
                    All Invoices
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed-payments" type="button" role="tab">
                    Paid <span class="badge bg-success ms-2">{{ $payments->where('status', 'paid')->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending-payments" type="button" role="tab">
                    Pending <span class="badge bg-warning ms-2">{{ $payments->where('status', 'pending')->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="failed-tab" data-bs-toggle="tab" data-bs-target="#failed-payments" type="button" role="tab">
                    Overdue <span class="badge bg-danger ms-2">{{ $payments->where('status', 'failed')->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="refunded-tab" data-bs-toggle="tab" data-bs-target="#refunded-payments" type="button" role="tab">
                    Refunded <span class="badge bg-info ms-2">{{ $payments->where('status', 'refunded')->count() }}</span>
                </button>
            </li>
        </ul>

        <div class="tab-content mt-4">
            <!-- All Payments Tab -->
            <div class="tab-pane fade show active" id="all-payments" role="tabpanel" aria-labelledby="all-tab">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <form method="GET" class="d-flex gap-2 align-items-center">
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" style="width: 170px;">
                        <span class="text-muted">to</span>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" style="width: 170px;">
                        <button type="submit" class="btn btn-outline-secondary">Apply</button>
                    </form>
                    <div class="invoice-search" style="width: 350px;">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" placeholder="Search Invoices..." id="searchInput" value="{{ request('search') }}">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Guest</th>
                                <th>Room</th>
                                <th>Issue Date</th>
                                <th>Due Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $payment)
                                <tr>
                                    <td>#PMT-{{ $payment->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($payment->booking->guest->name) }}&background=3a86ff&color=fff" alt="Guest" class="rounded-circle me-2" width="30" height="30">
                                            <span>{{ $payment->booking->guest->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $payment->booking->room->number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y') }}</td>
                                    <td>
                                        @if($payment->due_date)
                                            {{ \Carbon\Carbon::parse($payment->due_date)->format('d M Y') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($payment->created_at)->addDays(7)->format('d M Y') }}
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                    <td>
                                        @if($payment->status == 'paid')
                                            <span class="invoice-status status-paid">Selesai</span>
                                        @elseif($payment->status == 'pending')
                                            @php
                                                $dueDate = $payment->due_date ? \Carbon\Carbon::parse($payment->due_date) : \Carbon\Carbon::parse($payment->created_at)->addDays(7);
                                                $isOverdue = $dueDate->isPast() && $payment->status == 'pending';
                                            @endphp
                                            @if($isOverdue)
                                                <span class="invoice-status status-overdue">Overdue</span>
                                            @else
                                                <span class="invoice-status status-pending">Tertunda</span>
                                            @endif
                                        @elseif($payment->status == 'failed')
                                            <span class="invoice-status status-overdue">Gagal</span>
                                        @elseif($payment->status == 'refunded')
                                            <span class="invoice-status status-refunded">Dikembalikan</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#paymentModal" data-payment-id="{{ $payment->id }}">View</button>
                                        @if($payment->status != 'refunded')
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fas fa-receipt fa-2x mb-3"></i>
                                        <p>Belum ada data pembayaran</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $payments->appends(request()->query())->links() }}
            </div>

            <!-- Completed Tab -->
            <div class="tab-pane fade" id="completed-payments" role="tabpanel" aria-labelledby="completed-tab">
                <div class="d-flex justify-content-end mb-4">
                    <div class="invoice-search" style="width: 250px;">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" placeholder="Cari pembayaran..." id="searchCompleted">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID Pembayaran</th>
                                <th>Tamu</th>
                                <th>Kamar</th>
                                <th>Tanggal Bayar</th>
                                <th>Due Date</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments->where('status', 'paid') as $payment)
                                <tr>
                                    <td>#PMT-{{ $payment->id }}</td>
                                    <td>{{ $payment->booking->guest->name }}</td>
                                    <td>{{ $payment->booking->room->number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y') }}</td>
                                    <td>
                                        @if($payment->due_date)
                                            {{ \Carbon\Carbon::parse($payment->due_date)->format('d M Y') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($payment->created_at)->addDays(7)->format('d M Y') }}
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route(auth()->user()->role . '.payments.edit', $payment) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#paymentModal" data-payment-id="{{ $payment->id }}">Lihat</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pending Tab -->
            <div class="tab-pane fade" id="pending-payments" role="tabpanel" aria-labelledby="pending-tab">
                @if($payments->where('status', 'pending')->count() > 0)
                <div class="d-flex justify-content-end mb-4">
                    <div class="invoice-search" style="width: 250px;">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" placeholder="Cari pembayaran..." id="searchPending">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID Pembayaran</th>
                                <th>Tamu</th>
                                <th>Kamar</th>
                                <th>Tanggal Bayar</th>
                                <th>Due Date</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments->where('status', 'pending') as $payment)
                                @php
                                    $dueDate = $payment->due_date ? \Carbon\Carbon::parse($payment->due_date) : \Carbon\Carbon::parse($payment->created_at)->addDays(7);
                                    $isOverdue = $dueDate->isPast();
                                @endphp
                                <tr>
                                    <td>#PMT-{{ $payment->id }}</td>
                                    <td>{{ $payment->booking->guest->name }}</td>
                                    <td>{{ $payment->booking->room->number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y') }}</td>
                                    <td class="{{ $isOverdue ? 'text-danger fw-bold' : '' }}">
                                        {{ $dueDate->format('d M Y') }}
                                        @if($isOverdue)
                                            <i class="fas fa-exclamation-triangle ms-1"></i>
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                    <td>
                                        @if($isOverdue)
                                            <span class="invoice-status status-overdue">Overdue</span>
                                        @else
                                            <span class="invoice-status status-pending">Tertunda</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route(auth()->user()->role . '.payments.edit', $payment) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#paymentModal" data-payment-id="{{ $payment->id }}">Lihat</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                    <h4>Pembayaran Tertunda</h4>
                    <p class="text-muted">Belum ada pembayaran tertunda.</p>
                </div>
                @endif
            </div>

            <!-- Failed Tab -->
            <div class="tab-pane fade" id="failed-payments" role="tabpanel" aria-labelledby="failed-tab">
                @if($payments->where('status', 'failed')->count() > 0)
                <div class="d-flex justify-content-end mb-4">
                    <div class="invoice-search" style="width: 250px;">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" placeholder="Cari pembayaran..." id="searchFailed">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID Pembayaran</th>
                                <th>Tamu</th>
                                <th>Kamar</th>
                                <th>Tanggal Bayar</th>
                                <th>Due Date</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments->where('status', 'failed') as $payment)
                                <tr>
                                    <td>#PMT-{{ $payment->id }}</td>
                                    <td>{{ $payment->booking->guest->name }}</td>
                                    <td>{{ $payment->booking->room->number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y') }}</td>
                                    <td>
                                        @if($payment->due_date)
                                            {{ \Carbon\Carbon::parse($payment->due_date)->format('d M Y') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($payment->created_at)->addDays(7)->format('d M Y') }}
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route(auth()->user()->role . '.payments.edit', $payment) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#paymentModal" data-payment-id="{{ $payment->id }}">Lihat</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-exclamation-circle fa-3x text-danger mb-3"></i>
                    <h4>Pembayaran Gagal</h4>
                    <p class="text-muted">Belum ada pembayaran gagal.</p>
                </div>
                @endif
            </div>

            <!-- Refunded Tab -->
            <div class="tab-pane fade" id="refunded-payments" role="tabpanel" aria-labelledby="refunded-tab">
                @if($payments->where('status', 'refunded')->count() > 0)
                <div class="d-flex justify-content-end mb-4">
                    <div class="invoice-search" style="width: 250px;">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" placeholder="Cari pembayaran..." id="searchRefunded">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID Pembayaran</th>
                                <th>Tamu</th>
                                <th>Kamar</th>
                                <th>Tanggal Bayar</th>
                                <th>Due Date</th>
                                <th>Tanggal Refund</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments->where('status', 'refunded') as $payment)
                                <tr>
                                    <td>#PMT-{{ $payment->id }}</td>
                                    <td>{{ $payment->booking->guest->name }}</td>
                                    <td>{{ $payment->booking->room->number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y') }}</td>
                                    <td>
                                        @if($payment->due_date)
                                            {{ \Carbon\Carbon::parse($payment->due_date)->format('d M Y') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($payment->created_at)->addDays(7)->format('d M Y') }}
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($payment->refunded_at ?? $payment->updated_at)->format('d M Y') }}</td>
                                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#paymentModal" data-payment-id="{{ $payment->id }}">Lihat</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-undo fa-3x text-info mb-3"></i>
                    <h4>Pembayaran Dikembalikan</h4>
                    <p class="text-muted">Belum ada pembayaran yang dikembalikan.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Create Invoice Modal -->
<div class="modal fade" id="createInvoiceModal" tabindex="-1" aria-labelledby="createInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createInvoiceModalLabel">Create New Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.finance.invoices.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="invoiceClient" class="form-label">Client</label>
                            <select class="form-select" id="invoiceClient" name="client" required>
                                <option value="">Select Client</option>
                                @foreach($unpaidBookings as $booking)
                                    @if($booking->guest)
                                        <option value="{{ $booking->guest->name }}">
                                            {{ $booking->guest->name }}
                                            @if($booking->booking_code)
                                                — Booking #{{ $booking->booking_code }}
                                            @endif
                                            (Check-in: {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }})
                                        </option>
                                    @endif
                                @endforeach
                                <option value="other">+ Add New Client</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="invoiceDate" class="form-label">Invoice Date</label>
                            <input type="date" class="form-control" id="invoiceDate" name="issue_date" required value="{{ now()->format('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="dueDate" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="dueDate" name="due_date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="invoiceNumber" class="form-label">Invoice Number</label>
                            <input type="text" class="form-control" id="invoiceNumber" name="invoice_number" value="INV-{{ now()->format('Y-m') }}-{{ \Illuminate\Support\Str::random(6) }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Invoice Items</label>
                        <div class="table-responsive">
                            <table class="table table-bordered invoice-items-table">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th width="120">Quantity</th>
                                        <th width="150">Unit Price</th>
                                        <th width="150">Amount</th>
                                        <th width="50"></th>
                                    </tr>
                                </thead>
                                <tbody id="invoiceItems">
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" name="items[0][description]" placeholder="Item description" required>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control quantity" name="items[0][quantity]" value="1" min="1" required>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control unit-price" name="items[0][unit_price]" placeholder="0" required>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control amount" name="items[0][amount]" value="0" readonly>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger remove-item">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5">
                                            <button type="button" class="btn btn-sm btn-outline-primary" id="addInvoiceItem">
                                                <i class="fas fa-plus me-1"></i> Add Item
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end">Subtotal</td>
                                        <td colspan="2">
                                            <input type="text" class="form-control border-0 bg-transparent text-end fw-bold" id="subtotal" value="Rp 0" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end">Tax (10%)</td>
                                        <td colspan="2">
                                            <input type="text" class="form-control border-0 bg-transparent text-end fw-bold" id="tax" value="Rp 0" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Total</td>
                                        <td colspan="2">
                                            <input type="text" class="form-control border-0 bg-transparent text-end fw-bold" id="total" name="amount" value="Rp 0" readonly>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="invoiceNotes" class="form-label">Notes</label>
                        <textarea class="form-control" id="invoiceNotes" name="notes" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Invoice</button>
                    <button type="button" class="btn btn-success" id="saveAndSend">Save & Send</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Payment Details Modal -->
<div class="modal fade invoice-modal" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Detail Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="invoice-header">
                    <div class="invoice-title">PEMBAYARAN #PMT-<span id="payment-id"></span></div>
                    <div class="invoice-meta">
                        <div><strong>Status:</strong> <span id="payment-status"></span></div>
                        <div><strong>Tanggal Bayar:</strong> <span id="payment-date"></span></div>
                        <div><strong>Due Date:</strong> <span id="payment-due-date"></span></div>
                        <div><strong>Metode Pembayaran:</strong> <span id="payment-method"></span></div>
                    </div>
                </div>
                
                <div class="invoice-to">
                    <h5>Data Tamu:</h5>
                    <p id="guest-info">
                        <!-- Guest info will be populated by JavaScript -->
                    </p>
                </div>
                
                <table class="invoice-table">
                    <thead>
                        <tr>
                            <th>Deskripsi</th>
                            <th>Kamar</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="room-description">Deluxe Room (3 malam)</td>
                            <td id="room-number">A101</td>
                            <td id="check-in">12 Jul 2023</td>
                            <td id="check-out">15 Jul 2023</td>
                            <td id="room-amount">Rp 360.000</td>
                        </tr>
                        <tr>
                            <td>Minibar</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>Rp 18.500</td>
                        </tr>
                        <tr>
                            <td>Layanan Laundry</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>Rp 24.000</td>
                        </tr>
                        <tr class="total">
                            <td colspan="4">Subtotal</td>
                            <td>Rp 402.500</td>
                        </tr>
                        <tr>
                            <td colspan="4">Pajak (10%)</td>
                            <td>Rp 40.250</td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="invoice-summary">
                    <div class="invoice-totals">
                        <table>
                            <tr>
                                <td class="label">Subtotal:</td>
                                <td class="value">Rp 402.500</td>
                            </tr>
                            <tr>
                                <td class="label">Pajak:</td>
                                <td class="value">Rp 40.250</td>
                            </tr>
                            <tr>
                                <td class="label">Diskon:</td>
                                <td class="value">Rp 0</td>
                            </tr>
                            <tr class="grand-total">
                                <td class="label">Total:</td>
                                <td class="value">Rp 442.750</td>
                            </tr>
                            <tr>
                                <td class="label">Jumlah Dibayar:</td>
                                <td class="value">Rp 442.750</td>
                            </tr>
                            <tr>
                                <td class="label">Sisa:</td>
                                <td class="value">Rp 0</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h5>Metode Pembayaran</h5>
                    <p id="payment-details"><i class="fas fa-credit-card me-2"></i> Visa berakhir dengan 4242 (Dibayar pada 15 Jul 2023, 10:45)</p>
                    
                    <h5 class="mt-4">Catatan</h5>
                    <p>Terima kasih atas kunjungan Anda! Kami berharap dapat melayani Anda lagi.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-outline-primary" id="print-payment">
                    <i class="fas fa-print me-2"></i> Cetak
                </button>
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-envelope me-2"></i> Email
                </button>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary: #3a86ff;
    --secondary: #2667cc;
    --dark: #1f2937;
    --light: #f9fafb;
    --success: #10b981;
    --danger: #ef4444;
    --warning: #f59e0b;
    --info: #3b82f6;
}
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f5f7fb;
    color: var(--dark);
}
.stats-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    margin-bottom: 20px;
}
.stats-card .count {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 5px;
}
.stats-card .label {
    color: #6b7280;
    font-size: 14px;
}
.invoice-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    padding: 20px;
    margin-bottom: 30px;
}
.invoice-tabs {
    flex-wrap: nowrap;
    overflow-x: auto;
    white-space: nowrap;
}
.invoice-tabs .nav-link {
    color: var(--dark);
    border: none;
    padding: 12px 20px;
    font-weight: 500;
    white-space: nowrap;
    padding-right: 50px;
}
.invoice-tabs .nav-link.active {
    color: var(--primary);
    border-bottom: 3px solid var(--primary);
    background: transparent;
}
.invoice-search {
    position: relative;
}
.invoice-search input {
    padding-left: 40px;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}
.invoice-search i {
    position: absolute;
    left: 15px;
    top: 12px;
    color: #9ca3af;
}
.invoice-status {
    font-size: 12px;
    padding: 4px 10px;
    border-radius: 20px;
    font-weight: 500;
}
.status-paid {
    background-color: #d1fae5;
    color: #065f46;
}
.status-pending {
    background-color: #fef3c7;
    color: #92400e;
}
.status-overdue {
    background-color: #fee2e2;
    color: #991b1b;
}
.status-refunded {
    background-color: #e0f2fe;
    color: #0369a1;
}
.invoice-modal .modal-header {
    border-bottom: none;
    padding-bottom: 0;
}
.invoice-modal .modal-footer {
    border-top: none;
    padding-top: 0;
}
.invoice-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 30px;
}
.invoice-title {
    font-size: 24px;
    font-weight: 700;
    color: var(--primary);
}
.invoice-meta {
    text-align: right;
}
.invoice-to {
    margin-bottom: 30px;
}
.invoice-table {
    width: 100%;
    margin-bottom: 30px;
}
.invoice-table th {
    text-align: left;
    padding: 10px;
    border-bottom: 1px solid #e5e7eb;
}
.invoice-table td {
    padding: 10px;
    border-bottom: 1px solid #f3f4f6;
}
.invoice-table .total {
    font-weight: 700;
}
.invoice-summary {
    display: flex;
    justify-content: flex-end;
}
.invoice-totals {
    width: 300px;
}
.invoice-totals table {
    width: 100%;
}
.invoice-totals td {
    padding: 5px 0;
}
.invoice-totals .label {
    text-align: right;
    padding-right: 10px;
}
.invoice-totals .value {
    font-weight: 500;
}
.invoice-totals .grand-total {
    font-weight: 700;
    font-size: 18px;
    border-top: 1px solid #e5e7eb;
    padding-top: 10px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .invoice-tabs .nav-link {
        padding: 10px 15px;
        font-size: 14px;
    }
    
    .header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .d-flex.justify-content-between.align-items-center.mb-4 {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
    
    .invoice-search {
        width: 100% !important;
    }
}
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        document.getElementById('searchInput')?.addEventListener('input', function() {
            const term = this.value.toLowerCase();
            document.querySelectorAll('#all-payments tbody tr').forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(term) ? '' : 'none';
            });
        });
        
        document.getElementById('searchCompleted')?.addEventListener('input', function() {
            const term = this.value.toLowerCase();
            document.querySelectorAll('#completed-payments tbody tr').forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(term) ? '' : 'none';
            });
        });
        
        document.getElementById('searchPending')?.addEventListener('input', function() {
            const term = this.value.toLowerCase();
            document.querySelectorAll('#pending-payments tbody tr').forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(term) ? '' : 'none';
            });
        });
        
        document.getElementById('searchFailed')?.addEventListener('input', function() {
            const term = this.value.toLowerCase();
            document.querySelectorAll('#failed-payments tbody tr').forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(term) ? '' : 'none';
            });
        });

        document.getElementById('searchRefunded')?.addEventListener('input', function() {
            const term = this.value.toLowerCase();
            document.querySelectorAll('#refunded-payments tbody tr').forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(term) ? '' : 'none';
            });
        });

        // Invoice item calculations
        function calculateInvoiceTotals() {
            let subtotal = 0;
            
            document.querySelectorAll('#invoiceItems tr').forEach(row => {
                const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
                const unitPrice = parseFloat(row.querySelector('.unit-price').value) || 0;
                const amount = quantity * unitPrice;
                
                row.querySelector('.amount').value = amount.toLocaleString('id-ID');
                subtotal += amount;
            });
            
            const tax = subtotal * 0.1; // 10% tax
            const total = subtotal + tax;
            
            document.getElementById('subtotal').value = 'Rp ' + subtotal.toLocaleString('id-ID');
            document.getElementById('tax').value = 'Rp ' + tax.toLocaleString('id-ID');
            document.getElementById('total').value = 'Rp ' + total.toLocaleString('id-ID');
            document.querySelector('input[name="amount"]').value = total;
        }
        
        // Add new invoice item
        document.getElementById('addInvoiceItem')?.addEventListener('click', function() {
            const itemsContainer = document.getElementById('invoiceItems');
            const itemCount = itemsContainer.children.length;
            const newItem = document.createElement('tr');
            newItem.innerHTML = `
                <td>
                    <input type="text" class="form-control" name="items[${itemCount}][description]" placeholder="Item description" required>
                </td>
                <td>
                    <input type="number" class="form-control quantity" name="items[${itemCount}][quantity]" value="1" min="1" required>
                </td>
                <td>
                    <input type="number" class="form-control unit-price" name="items[${itemCount}][unit_price]" placeholder="0" required>
                </td>
                <td>
                    <input type="text" class="form-control amount" name="items[${itemCount}][amount]" value="0" readonly>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger remove-item">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            `;
            itemsContainer.appendChild(newItem);
            
            // Add event listeners to new inputs
            newItem.querySelector('.quantity').addEventListener('input', calculateInvoiceTotals);
            newItem.querySelector('.unit-price').addEventListener('input', calculateInvoiceTotals);
            newItem.querySelector('.remove-item').addEventListener('click', function() {
                newItem.remove();
                calculateInvoiceTotals();
            });
        });
        
        // Remove invoice item
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-item') || e.target.closest('.remove-item')) {
                const button = e.target.classList.contains('remove-item') ? e.target : e.target.closest('.remove-item');
                const row = button.closest('tr');
                if (document.querySelectorAll('#invoiceItems tr').length > 1) {
                    row.remove();
                    calculateInvoiceTotals();
                }
            }
        });
        
        // Calculate on input change
        document.querySelectorAll('.quantity, .unit-price').forEach(input => {
            input.addEventListener('input', calculateInvoiceTotals);
        });
        
        // Set due date to 7 days from now by default
        const dueDateInput = document.getElementById('dueDate');
        if (dueDateInput && !dueDateInput.value) {
            const nextWeek = new Date();
            nextWeek.setDate(nextWeek.getDate() + 7);
            dueDateInput.value = nextWeek.toISOString().split('T')[0];
        }
        
        // Initialize calculations
        calculateInvoiceTotals();
        
        // Payment modal functionality
        const paymentModal = document.getElementById('paymentModal');
        if (paymentModal) {
            paymentModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const paymentId = button.getAttribute('data-payment-id');
                
                // Fetch payment details via AJAX
                fetch(`/admin/finance/invoices/${paymentId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('payment-id').textContent = data.payment.id;
                        document.getElementById('payment-status').textContent = data.payment.status;
                        document.getElementById('payment-date').textContent = new Date(data.payment.paid_at).toLocaleDateString('id-ID', { 
                            day: 'numeric', month: 'short', year: 'numeric' 
                        });
                        document.getElementById('payment-due-date').textContent = new Date(data.payment.created_at).toLocaleDateString('id-ID', { 
                            day: 'numeric', month: 'short', year: 'numeric' 
                        });
                        document.getElementById('payment-method').textContent = data.payment.method;
                        
                        // Guest info
                        document.getElementById('guest-info').innerHTML = `
                            <strong>${data.guest.name}</strong><br>
                            ${data.guest.phone}<br>
                            ${data.guest.identity_number}
                        `;
                        
                        // Room info
                        document.getElementById('room-description').textContent = `${data.room.type} (${data.booking.duration_nights} malam)`;
                        document.getElementById('room-number').textContent = data.room.number;
                        document.getElementById('check-in').textContent = new Date(data.booking.check_in).toLocaleDateString('id-ID', { 
                            day: 'numeric', month: 'short', year: 'numeric' 
                        });
                        document.getElementById('check-out').textContent = new Date(data.booking.check_out).toLocaleDateString('id-ID', { 
                            day: 'numeric', month: 'short', year: 'numeric' 
                        });
                        document.getElementById('room-amount').textContent = 'Rp ' + data.payment.amount.toLocaleString('id-ID');
                    });
            });
        }
        
        // Print functionality
        document.getElementById('print-payment')?.addEventListener('click', function() {
            window.print();
        });
    });
</script>
@endpush
@endsection