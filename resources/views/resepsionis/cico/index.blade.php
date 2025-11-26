@extends('layouts.adminlte')
@section('title', 'Check In/Out')

@push('css')
<style>
    :root {
        --primary: #3a86ff;
        --secondary: #2667cc;
        --dark: #1f2937;
        --light: #f9fafb;
        --success: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f5f7fb;
        color: var(--dark);
    }
    

    /* Sidebar */
    .sidebar {
        width: 280px;
        min-height: 100vh;
        background: linear-gradient(180deg, var(--primary), var(--secondary));
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        position: fixed;
        z-index: 100;
    }
    .sidebar-brand {
        padding: 1.5rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        
    }
    .sidebar-brand h3 {
        color: white;
        font-weight: 700;
        margin-bottom: 0;
    }
    .sidebar-brand .logo-icon {
        font-size: 2rem;
        margin-right: 10px;
        color: #fff;
    }
    .nav-item {
        position: relative;
        margin: 5px 15px;
        border-radius: 8px;
        overflow: hidden;
    }
    .nav-link {
        color: rgba(255,255,255,0.8);
        padding: 12px 15px;
        font-weight: 500;
        transition: all 0.3s;
    }
    .nav-link:hover, .nav-link.active {
        color: white;
        background-color: rgba(255,255,255,0.1);
    }

    .check-tabs .nav-item .nav-link {
        padding-left: 25px !important;
        padding-right: 45px !important;
    }

    .nav-link i {
        width: 24px;
        text-align: center;
        margin-right: 10px;
    }

    /* Main Content */
    .main-content {
        margin-left: 280px;
        padding: 30px;
    }

    /* Header */
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    .header h2 {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0;
    }

    /* Check In/Out Card (Satu Card Besar) */
    .check-in-out-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        padding: 20px;
        margin-bottom: 30px;
    }

    /* Tabs */
    .check-tabs .nav-link {
        color: var(--dark);
        border: none;
        padding: 10px 20px;
        font-weight: 500;
        border-bottom: 3px solid transparent;
        
    }
    .check-tabs .nav-link.active {
        color: var(--primary);
        border-bottom: 3px solid var(--primary);
        background: transparent;
    }

    /* Search Bar */
    .guest-search {
        position: relative;
        margin-bottom: 20px;
    }
    .guest-search input {
        padding-left: 40px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }
    .guest-search i {
        position: absolute;
        left: 15px;
        top: 12px;
        color: #9ca3af;
    }

    /* Guest List */
    .guest-list {
        max-height: 500px;
        overflow-y: auto;
    }
    .guest-item {
        display: flex;
        align-items: center;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 10px;
        background-color: #f9fafb;
        transition: all 0.3s;
    }
    .guest-item:hover {
        background-color: #f3f4f6;
        transform: translateX(5px);
    }
    .guest-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 15px;
    }
    .guest-info {
        flex: 1;
    }
    .guest-status {
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 500;
    }
    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
    }
    .status-checkedin {
        background-color: #d1fae5;
        color: #065f46;
    }
    .status-checkedout {
        background-color: #fee2e2;
        color: #991b1b;
    }

    /* Recent Check Ins Table */
    .recent-checkins-table {
        margin-top: 30px;
    }
    .recent-checkins-table .table {
        margin-bottom: 0;
    }
    .recent-checkins-table th,
    .recent-checkins-table td {
        padding: 12px 16px;
    }
    .recent-checkins-table th {
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #6b7280;
        background-color: #f9fafb;
        border-bottom: 2px solid #e5e7eb;
    }

    /* Modal */
    .check-modal .modal-header {
        border-bottom: none;
        padding-bottom: 0;
    }
    .check-modal .modal-footer {
        border-top: none;
        padding-top: 0;
    }
    .form-step {
        display: none;
    }
    .form-step.active {
        display: block;
    }
    .payment-methods {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }
    .payment-method {
        flex: 1;
        text-align: center;
        padding: 15px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
    }
    .payment-method:hover, .payment-method.active {
        border-color: var(--primary);
        background-color: #f0f7ff;
    }
    .payment-method i {
        font-size: 24px;
        margin-bottom: 10px;
        color: var(--primary);
    }
    .room-selection {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }
    .room-option {
        flex: 1 0 30%;
        padding: 15px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
    }
    .room-option:hover, .room-option.active {
        border-color: var(--primary);
        background-color: #f0f7ff;
    }
    .room-type {
        font-weight: 600;
        margin-bottom: 5px;
    }
    .room-price {
        color: var(--primary);
        font-weight: 600;
    }
    .room-features {
        font-size: 12px;
        color: #6b7280;
        margin-top: 5px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .main-content {
            margin-left: 0;
            padding: 20px;
        }
        .sidebar {
            display: none;
        }
        .check-in-out-card {
            padding: 15px;
        }
        .guest-item {
            flex-direction: column;
            align-items: flex-start;
        }
        .guest-avatar {
            margin-right: 0;
            margin-bottom: 10px;
        }
    }
</style>
@endpush

@section('content')

    <!-- Header -->
    <div class="header">
        <h2><i class="fas fa-calendar-check me-2"></i> Check In/Out</h2>
        <div class="user-menu">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ auth()->user()->photo ? asset('images/' . auth()->user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" alt="User" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                    <span class="ms-2">{{ auth()->user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i> Sign out</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="check-in-out-card">
        <!-- Tabs -->
        <ul class="nav nav-tabs check-tabs" id="checkTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="checkin-tab" data-bs-toggle="tab" data-bs-target="#checkin" type="button" role="tab">Check In <span class="badge bg-primary ms-2">{{ $checkInBookings->count() }}</span></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="checkout-tab" data-bs-toggle="tab" data-bs-target="#checkout" type="button" role="tab">Check Out <span class="badge bg-danger ms-2">{{ $checkOutBookings->count() }}</span></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="walkin-tab" data-bs-toggle="tab" data-bs-target="#walkin" type="button" role="tab">Walk-In Guest</button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-4">
            <!-- Check In Tab -->
            <div class="tab-pane fade show active" id="checkin" role="tabpanel">
                <!-- Search Bar -->
                <div class="guest-search">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control" placeholder="Search guests by name, booking ID or phone...">
                </div>
                <!-- Guest List -->
                <div class="guest-list">
                    @forelse($checkInBookings as $booking)
                    <div class="guest-item">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($booking->guest->first_name . ' ' . $booking->guest->last_name) }}&size=50" alt="Guest" class="guest-avatar">
                        <div class="guest-info">
                            <h6 class="mb-1">{{ $booking->guest->first_name }} {{ $booking->guest->last_name }}</h6>
                            <p class="text-muted mb-1">Booking #{{ $booking->booking_code }} • {{ $booking->room?->type ?? 'N/A' }}</p>
                            <p class="mb-0"><small>Arrival: {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}, {{ $booking->check_in_time ?? '2:00 PM' }} • {{ $booking->nights ?? 1 }} nights</small></p>
                        </div>
                        <span class="guest-status status-pending">Pending</span>
                        <button class="btn btn-sm btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#checkinModal{{ $booking->id }}">Check In</button>
                    </div>
                    @empty
                    <p class="text-muted text-center mt-3">No guests to check in.</p>
                    @endforelse
                </div>
            </div>

            <!-- Check Out Tab -->
            <div class="tab-pane fade" id="checkout" role="tabpanel">
                <!-- Search Bar -->
                <div class="guest-search">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control" placeholder="Search guests by name, room number...">
                </div>
                <!-- Guest List -->
                <div class="guest-list">
                    @forelse($checkOutBookings as $booking)
                    <div class="guest-item">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($booking->guest->first_name . ' ' . $booking->guest->last_name) }}&size=50" alt="Guest" class="guest-avatar">
                        <div class="guest-info">
                            <h6 class="mb-1">{{ $booking->guest->first_name }} {{ $booking->guest->last_name }}</h6>
                            <p class="text-muted mb-1">Room #{{ $booking->room?->number }} • {{ $booking->room?->type ?? 'N/A' }}</p>
                            <p class="mb-0"><small>Check-out: {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}, {{ $booking->check_out_time ?? '11:00 AM' }} • {{ $booking->nights ?? 1 }} nights</small></p>
                        </div>
                        <span class="guest-status status-checkedin">Checked In</span>
                        <button class="btn btn-sm btn-danger ms-3" data-bs-toggle="modal" data-bs-target="#checkoutModal{{ $booking->id }}">Check Out</button>
                    </div>
                    @empty
                    <p class="text-muted text-center mt-3">No guests to check out.</p>
                    @endforelse
                </div>
            </div>

            <!-- Walk-In Tab -->
            <div class="tab-pane fade" id="walkin" role="tabpanel">
                <div class="text-center py-5">
                    <i class="fas fa-user-plus fa-3x text-primary mb-3"></i>
                    <h4>Register Walk-In Guest</h4>
                    <p class="text-muted mb-4">Create a new booking for guests without prior reservation</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#walkinModal">
                        <i class="fas fa-plus-circle me-2"></i> New Walk-In
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="check-in-out-card">
        <!-- Recent Check Ins/Outs -->
        <div class="recent-checkins-table mt-4">
            <h5 class="mb-3"><i class="fas fa-history me-2"></i> Recent Check Ins/Outs</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Guest</th>
                            <th>Room</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentBookings as $booking)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($booking->guest->first_name . ' ' . $booking->guest->last_name) }}&size=50" alt="Guest" class="guest-avatar me-3">
                                    <span>{{ $booking->guest->first_name }} {{ $booking->guest->last_name }}</span>
                                </div>
                            </td>
                            <td>{{ $booking->room?->number }} {{ $booking->room?->type }}</td>
                            <td>{{ $booking->check_in }} {{ $booking->check_in_time }}</td>
                            <td>{{ $booking->check_out }} {{ $booking->check_out_time }}</td>
                            <td>
                                @if($booking->status === 'checked_in')
                                    <span class="guest-status status-checkedin">Checked In</span>
                                @elseif($booking->status === 'checked_out')
                                    <span class="guest-status status-checkedout">Checked Out</span>
                                @else
                                    <span class="guest-status status-pending">Pending</span>
                                @endif
                            </td>
                            <td><button class="btn btn-sm btn-outline-primary">Details</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modals -->
    @foreach($checkInBookings as $booking)
    <div class="modal fade check-modal" id="checkinModal{{ $booking->id }}" tabindex="-1" aria-labelledby="checkinModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-sign-in-alt me-2"></i> Check In Guest</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-step active" id="checkin-step1-{{ $booking->id }}">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($booking->guest->first_name . ' ' . $booking->guest->last_name) }}&size=100" alt="Guest" class="img-fluid rounded">
                            </div>
                            <div class="col-md-8">
                                <h4>{{ $booking->guest->first_name }} {{ $booking->guest->last_name }}</h4>
                                <p class="text-muted">Booking #{{ $booking->booking_code }}</p>
                                <div class="row">
                                    <div class="col-6">
                                        <p><strong>Room Type:</strong><br> {{ $booking->room?->type ?? 'N/A' }}</p>
                                        <p><strong>Check In:</strong><br> {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}, {{ $booking->check_in_time ?? '2:00 PM' }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p><strong>Duration:</strong><br> {{ $booking->nights ?? 1 }} nights</p>
                                        <p><strong>Check Out:</strong><br> {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}, {{ $booking->check_out_time ?? '11:00 AM' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 class="mb-3">Assign Room</h5>
                        <div class="room-selection">
                            @foreach($availableRooms as $room)
                            <div class="room-option {{ $loop->first ? 'active' : '' }}" data-room-id="{{ $room->id }}">
                                <div class="room-type">{{ $room->type }} {{ $room->number }}</div>
                                <div class="room-price">Rp{{ number_format($room->price, 0, ',', '.') }}/night</div>
                                <div class="room-features">
                                    {{ $room->beds ?? 1 }} beds • 
                                    {{ $room->view ?? 'N/A' }} • 
                                    {{ $room->room_size ?? 'N/A' }}m²
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" id="earlyCheckin{{ $booking->id }}">
                            <label class="form-check-label" for="earlyCheckin{{ $booking->id }}">
                                Early check-in (before 2:00 PM)
                            </label>
                        </div>
                    </div>
                    <div class="form-step" id="checkin-step2-{{ $booking->id }}">
                        <h5 class="mb-3">Guest Details</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" value="{{ $booking->guest->first_name }} {{ $booking->guest->last_name }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">ID/Passport Number *</label>
                                <input type="text" class="form-control identity-number" placeholder="Enter ID/Passport number" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" value="{{ $booking->guest->phone }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ $booking->guest->email ?? '' }}" readonly>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Special Requests</label>
                                <textarea class="form-control" rows="2" placeholder="Any special requests?">{{ $booking->special_requests ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-step" id="checkin-step3-{{ $booking->id }}">
                        <h5 class="mb-3">Payment</h5>
                        <div class="payment-methods">
                            <div class="payment-method active" data-method="Credit Card">
                                <i class="fas fa-credit-card"></i>
                                <div>Credit Card</div>
                            </div>
                            <div class="payment-method" data-method="Cash">
                                <i class="fas fa-money-bill-wave"></i>
                                <div>Cash</div>
                            </div>
                            <div class="payment-method" data-method="Bank Transfer">
                                <i class="fas fa-university"></i>
                                <div>Bank Transfer</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Total Amount</label>
                                <input type="text" class="form-control total-amount" value="Rp{{ number_format($booking->total_amount, 0, ',', '.') }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Deposit Amount *</label>
                                <input type="text" class="form-control deposit-amount" value="Rp{{ number_format($booking->deposit, 0, ',', '.') }}" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Payment Notes</label>
                                <textarea class="form-control payment-notes" rows="2" placeholder="Any payment notes?"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-outline-primary prev-checkin-btn" data-booking-id="{{ $booking->id }}" style="display: none;">Previous</button>
                    <button type="button" class="btn btn-primary next-checkin-btn" data-booking-id="{{ $booking->id }}">Next</button>
                    <button type="button" class="btn btn-success complete-checkin-btn" data-booking-id="{{ $booking->id }}" style="display: none;">Complete Check In</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @foreach($checkOutBookings as $booking)
    <div class="modal fade check-modal" id="checkoutModal{{ $booking->id }}" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-sign-out-alt me-2"></i> Check Out Guest</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($booking->guest->first_name . ' ' . $booking->guest->last_name) }}&size=100" alt="Guest" class="img-fluid rounded">
                        </div>
                        <div class="col-md-8">
                            <h4>{{ $booking->guest->first_name }} {{ $booking->guest->last_name }}</h4>
                            <p class="text-muted">Room #{{ $booking->room?->number }} • {{ $booking->room?->type }}</p>
                            <div class="row">
                                <div class="col-6">
                                    <p><strong>Room Type:</strong><br> {{ $booking->room?->type }}</p>
                                    <p><strong>Check In:</strong><br> {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}, {{ $booking->check_in_time }}</p>
                                </div>
                                <div class="col-6">
                                    <p><strong>Duration:</strong><br> {{ $booking->nights ?? 1 }} nights</p>
                                    <p><strong>Check Out:</strong><br> {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}, {{ $booking->check_out_time ?? '11:00 AM' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h5>Room Inspection</h5>
                        <div class="form-check">
                            <input class="form-check-input room-inspection" type="checkbox" id="roomClean{{ $booking->id }}" value="room_clean">
                            <label class="form-check-label" for="roomClean{{ $booking->id }}">
                                Room is clean and undamaged
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input room-inspection" type="checkbox" id="minibarEmpty{{ $booking->id }}" value="minibar_empty">
                            <label class="form-check-label" for="minibarEmpty{{ $booking->id }}">
                                Minibar items accounted for
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input room-inspection" type="checkbox" id="keysReturned{{ $booking->id }}" value="keys_returned">
                            <label class="form-check-label" for="keysReturned{{ $booking->id }}">
                                Room keys returned
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <h5>Additional Charges</h5>
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td>Room charges ({{ $booking->nights ?? 1 }} nights)</td>
                                    <td>Rp{{ number_format($booking->total_amount, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Additional Charges</td>
                                    <td><input type="number" class="form-control form-control-sm additional-charges" value="0" min="0"></td>
                                </tr>
                                <tr class="table-active">
                                    <th>Total</th>
                                    <th class="final-total">Rp{{ number_format($booking->total_amount, 0, ',', '.') }}</th>
                                </tr>
                                <tr class="table-active">
                                    <th>Deposit</th>
                                    <th>-Rp{{ number_format($booking->deposit, 0, ',', '.') }}</th>
                                </tr>
                                <tr class="table-active fw-bold">
                                    <th>Balance Due</th>
                                    <th class="balance-due">Rp{{ number_format($booking->total_amount - $booking->deposit, 0, ',', '.') }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <select class="form-select payment-method-select">
                            <option value="Credit Card">Credit Card</option>
                            <option value="Cash">Cash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                        </select>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="sendReceipt{{ $booking->id }}">
                        <label class="form-check-label" for="sendReceipt{{ $booking->id }}">
                            Email receipt to guest
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success complete-checkout-btn" data-booking-id="{{ $booking->id }}">Complete Check Out</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Walk In Modal -->
    <div class="modal fade check-modal" id="walkinModal" tabindex="-1" aria-labelledby="walkinModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="walkinModalLabel"><i class="fas fa-user-plus me-2"></i> New Walk-In Guest</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs mb-4" id="walkinTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="guestInfoTab" data-bs-toggle="tab" data-bs-target="#guestInfoContent" type="button" role="tab">Guest Information</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="roomSelectionTab" data-bs-toggle="tab" data-bs-target="#roomSelectionContent" type="button" role="tab">Room Selection</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="paymentTab" data-bs-toggle="tab" data-bs-target="#paymentContent" type="button" role="tab">Payment</button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- Guest Information Tab -->
                        <div class="tab-pane fade show active" id="guestInfoContent" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">First Name *</label>
                                    <input type="text" class="form-control walkin-first-name" placeholder="Enter first name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Last Name *</label>
                                    <input type="text" class="form-control walkin-last-name" placeholder="Enter last name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number *</label>
                                    <input type="tel" class="form-control walkin-phone" placeholder="Enter phone number" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control walkin-email" placeholder="Enter email">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">ID/Passport Number *</label>
                                    <input type="text" class="form-control walkin-identity" placeholder="Enter ID/Passport number" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nationality</label>
                                    <input type="text" class="form-control walkin-nationality" placeholder="Enter nationality">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control walkin-address" rows="2" placeholder="Enter address"></textarea>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Special Requests</label>
                                    <textarea class="form-control walkin-special-requests" rows="2" placeholder="Any special requests?"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- Room Selection Tab -->
                        <div class="tab-pane fade" id="roomSelectionContent" role="tabpanel">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Check In Date *</label>
                                    <input type="date" class="form-control walkin-checkin" value="{{ now()->format('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Check Out Date *</label>
                                    <input type="date" class="form-control walkin-checkout" value="{{ now()->addDay()->format('Y-m-d') }}" required>
                                </div>
                            </div>
                            <h5 class="mb-3">Available Rooms</h5>
                            <div class="room-selection">
                                @foreach($availableRooms as $room)
                                <div class="room-option {{ $loop->first ? 'active' : '' }}" data-room-id="{{ $room->id }}" data-room-price="{{ $room->price }}">
                                    <div class="room-type">{{ $room->type }} {{ $room->number }}</div>
                                    <div class="room-price">Rp{{ number_format($room->price, 0, ',', '.') }}/night</div>
                                    <div class="room-features">
                                        {{ $room->beds ?? 1 }} beds • 
                                        {{ $room->view ?? 'N/A' }} • 
                                        {{ $room->room_size ?? 'N/A' }}m²
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="includeBreakfast">
                                <label class="form-check-label" for="includeBreakfast">
                                    Include breakfast
                                </label>
                            </div>
                        </div>
                        <!-- Payment Tab -->
                        <div class="tab-pane fade" id="paymentContent" role="tabpanel">
                            <div class="mb-4">
                                <h5>Summary</h5>
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td>Room</td>
                                            <td><span class="walkin-nights">1</span> night</td>
                                            <td class="walkin-room-total">Rp{{ number_format($availableRooms->first()?->price ?? 0, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr class="table-active fw-bold">
                                            <td>Total</td>
                                            <td></td>
                                            <td class="walkin-total-amount">Rp{{ number_format($availableRooms->first()?->price ?? 0, 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <h5 class="mb-3">Payment Method</h5>
                            <div class="payment-methods">
                                <div class="payment-method active" data-method="Credit Card">
                                    <i class="fas fa-credit-card"></i>
                                    <div>Credit Card</div>
                                </div>
                                <div class="payment-method" data-method="Cash">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <div>Cash</div>
                                </div>
                                <div class="payment-method" data-method="Bank Transfer">
                                    <i class="fas fa-university"></i>
                                    <div>Bank Transfer</div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Deposit Amount *</label>
                                    <input type="number" class="form-control walkin-deposit" value="{{ $availableRooms->first()?->price ?? 0 }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary walkin-save-btn">Save & Check In</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check In Modal Step Navigation
    document.querySelectorAll('.next-checkin-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const bookingId = this.getAttribute('data-booking-id');
            const steps = [`checkin-step1-${bookingId}`, `checkin-step2-${bookingId}`, `checkin-step3-${bookingId}`];
            const currentStepEl = document.querySelector(`#checkin-step1-${bookingId}.active, #checkin-step2-${bookingId}.active, #checkin-step3-${bookingId}.active`);
            const currentStepIndex = steps.findIndex(step => document.getElementById(step).classList.contains('active'));
            if (currentStepIndex < steps.length - 1) {
                document.getElementById(steps[currentStepIndex]).classList.remove('active');
                document.getElementById(steps[currentStepIndex + 1]).classList.add('active');
                updateCheckinButtons(bookingId, currentStepIndex + 1);
            }
        });
    });

    document.querySelectorAll('.prev-checkin-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const bookingId = this.getAttribute('data-booking-id');
            const steps = [`checkin-step1-${bookingId}`, `checkin-step2-${bookingId}`, `checkin-step3-${bookingId}`];
            const currentStepEl = document.querySelector(`#checkin-step1-${bookingId}.active, #checkin-step2-${bookingId}.active, #checkin-step3-${bookingId}.active`);
            const currentStepIndex = steps.findIndex(step => document.getElementById(step).classList.contains('active'));
            if (currentStepIndex > 0) {
                document.getElementById(steps[currentStepIndex]).classList.remove('active');
                document.getElementById(steps[currentStepIndex - 1]).classList.add('active');
                updateCheckinButtons(bookingId, currentStepIndex - 1);
            }
        });
    });

    function updateCheckinButtons(bookingId, stepIndex) {
        const prevBtn = document.querySelector(`.prev-checkin-btn[data-booking-id="${bookingId}"]`);
        const nextBtn = document.querySelector(`.next-checkin-btn[data-booking-id="${bookingId}"]`);
        const completeBtn = document.querySelector(`.complete-checkin-btn[data-booking-id="${bookingId}"]`);
        if (stepIndex === 0) {
            prevBtn.style.display = 'none';
        } else {
            prevBtn.style.display = 'inline-block';
        }
        if (stepIndex === 2) {
            nextBtn.style.display = 'none';
            completeBtn.style.display = 'inline-block';
        } else {
            nextBtn.style.display = 'inline-block';
            completeBtn.style.display = 'none';
        }
    }

    // Complete Check In
    document.querySelectorAll('.complete-checkin-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const bookingId = this.getAttribute('data-booking-id');
            completeCheckIn(bookingId);
        });
    });

    // Complete Check Out
    document.querySelectorAll('.complete-checkout-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const bookingId = this.getAttribute('data-booking-id');
            completeCheckOut(bookingId);
        });
    });

    // Walk In Check In
    document.querySelector('.walkin-save-btn').addEventListener('click', function() {
        walkInCheckIn();
    });

    // Room & payment selection
    document.querySelectorAll('.room-option').forEach(el => {
        el.addEventListener('click', function() {
            this.parentElement.querySelectorAll('.room-option').forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            
            // Update walk-in pricing
            updateWalkInPricing();
        });
    });

    document.querySelectorAll('.payment-method').forEach(el => {
        el.addEventListener('click', function() {
            this.parentElement.querySelectorAll('.payment-method').forEach(m => m.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Update walk-in pricing when dates change
    document.querySelectorAll('.walkin-checkin, .walkin-checkout').forEach(el => {
        el.addEventListener('change', updateWalkInPricing);
    });

    // Update checkout pricing when additional charges change
    document.querySelectorAll('.additional-charges').forEach(el => {
        el.addEventListener('input', function() {
            const modal = this.closest('.modal');
            const baseAmount = parseFloat(modal.querySelector('.final-total').textContent.replace(/[^\d]/g, ''));
            const deposit = parseFloat(modal.querySelector('.table-active th:nth-child(2)').textContent.replace(/[^\d]/g, ''));
            const additional = parseFloat(this.value) || 0;
            const balance = baseAmount + additional - deposit;
            
            modal.querySelector('.balance-due').textContent = 'Rp' + balance.toLocaleString('id-ID');
        });
    });

    function updateWalkInPricing() {
        const checkin = new Date(document.querySelector('.walkin-checkin').value);
        const checkout = new Date(document.querySelector('.walkin-checkout').value);
        const nights = Math.ceil((checkout - checkin) / (1000 * 60 * 60 * 24));
        const selectedRoom = document.querySelector('.room-option.active');
        const roomPrice = selectedRoom ? parseFloat(selectedRoom.getAttribute('data-room-price')) : 0;
        const totalAmount = roomPrice * nights;

        document.querySelector('.walkin-nights').textContent = nights;
        document.querySelector('.walkin-room-total').textContent = 'Rp' + (roomPrice * nights).toLocaleString('id-ID');
        document.querySelector('.walkin-total-amount').textContent = 'Rp' + totalAmount.toLocaleString('id-ID');
        document.querySelector('.walkin-deposit').value = totalAmount;
    }

    // Functions untuk AJAX calls
    async function completeCheckIn(bookingId) {
        const modal = document.getElementById(`checkinModal${bookingId}`);
        const roomId = modal.querySelector('.room-option.active').getAttribute('data-room-id');
        const identityNumber = modal.querySelector('.identity-number').value;
        const paymentMethod = modal.querySelector('.payment-method.active').getAttribute('data-method');
        const depositAmount = parseFloat(modal.querySelector('.deposit-amount').value.replace(/[^\d]/g, ''));
        const paymentNotes = modal.querySelector('.payment-notes').value;

        if (!identityNumber) {
            showAlert('Please enter ID/Passport number', 'error');
            return;
        }

        if (!depositAmount || depositAmount <= 0) {
            showAlert('Please enter valid deposit amount', 'error');
            return;
        }

        try {
            const response = await fetch(`/resepsionis/check-in-out/check-in/${bookingId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    room_id: roomId,
                    identity_number: identityNumber,
                    payment_method: paymentMethod,
                    deposit_amount: depositAmount,
                    payment_notes: paymentNotes
                })
            });

            const result = await response.json();

            if (result.success) {
                showAlert('Check in successful!', 'success');
                bootstrap.Modal.getInstance(modal).hide();
                setTimeout(() => location.reload(), 1500);
            } else {
                showAlert('Error: ' + result.message, 'error');
            }
        } catch (error) {
            showAlert('Network error: ' + error.message, 'error');
        }
    }

    async function completeCheckOut(bookingId) {
        const modal = document.getElementById(`checkoutModal${bookingId}`);
        const roomInspection = Array.from(modal.querySelectorAll('.room-inspection:checked')).map(cb => cb.value);
        const additionalCharges = parseFloat(modal.querySelector('.additional-charges').value) || 0;
        const paymentMethod = modal.querySelector('.payment-method-select').value;

        if (roomInspection.length === 0) {
            showAlert('Please complete room inspection', 'error');
            return;
        }

        try {
            const response = await fetch(`/resepsionis/check-in-out/check-out/${bookingId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    room_inspection: roomInspection,
                    additional_charges: additionalCharges,
                    payment_method: paymentMethod
                })
            });

            const result = await response.json();

            if (result.success) {
                showAlert('Check out successful!', 'success');
                bootstrap.Modal.getInstance(modal).hide();
                setTimeout(() => location.reload(), 1500);
            } else {
                showAlert('Error: ' + result.message, 'error');
            }
        } catch (error) {
            showAlert('Network error: ' + error.message, 'error');
        }
    }

    async function walkInCheckIn() {
        const modal = document.getElementById('walkinModal');
        
        // Collect data
        const formData = {
            first_name: modal.querySelector('.walkin-first-name').value,
            last_name: modal.querySelector('.walkin-last-name').value,
            phone: modal.querySelector('.walkin-phone').value,
            email: modal.querySelector('.walkin-email').value,
            identity_number: modal.querySelector('.walkin-identity').value,
            address: modal.querySelector('.walkin-address').value,
            nationality: modal.querySelector('.walkin-nationality').value,
            room_id: modal.querySelector('.room-option.active').getAttribute('data-room-id'),
            check_in: modal.querySelector('.walkin-checkin').value,
            check_out: modal.querySelector('.walkin-checkout').value,
            payment_method: modal.querySelector('.payment-method.active').getAttribute('data-method'),
            deposit_amount: parseFloat(modal.querySelector('.walkin-deposit').value),
            special_requests: modal.querySelector('.walkin-special-requests').value
        };

        // Validation
        if (!formData.first_name || !formData.last_name || !formData.phone || !formData.identity_number) {
            showAlert('Please fill all required fields', 'error');
            return;
        }

        if (!formData.room_id) {
            showAlert('Please select a room', 'error');
            return;
        }

        try {
            const response = await fetch('/resepsionis/check-in-out/walkin-checkin', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();

            if (result.success) {
                showAlert('Walk-in guest checked in successfully!', 'success');
                bootstrap.Modal.getInstance(modal).hide();
                setTimeout(() => location.reload(), 1500);
            } else {
                showAlert('Error: ' + result.message, 'error');
            }
        } catch (error) {
            showAlert('Network error: ' + error.message, 'error');
        }
    }

    function showAlert(message, type) {
        // Remove existing alerts
        document.querySelectorAll('.alert').forEach(alert => alert.remove());

        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show position-fixed`;
        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            if (alertDiv.parentElement) {
                alertDiv.remove();
            }
        }, 5000);
    }

    // Initialize walk-in pricing
    updateWalkInPricing();
});
</script>
@endpush