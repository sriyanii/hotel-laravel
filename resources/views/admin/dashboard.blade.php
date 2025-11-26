@extends('layouts.adminlte')

@section('title', 'Dashboard Admin')

@section('content')
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
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
        
        /* Sidebar Pro */
        .sidebar {
            width: 280px;
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary), var(--secondary));
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            position: fixed;
            z-index: 100;
            transition: all 0.3s;
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
        
        .nav-link i {
            width: 24px;
            text-align: center;
            margin-right: 10px;
        }
        
        .nav-link .badge {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
        }
        
        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 30px;
            transition: all 0.3s;
        }
        
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
        
        .user-menu {
            display: flex;
            align-items: center;
        }
        
        .user-menu img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }
        
        /* Stats Cards */
        .stats-card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 24px;
            transition: all 0.3s;
            overflow: hidden;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .stats-card .card-body {
            padding: 20px;
            position: relative;
        }
        
        .stats-card .card-icon {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 2.5rem;
            opacity: 0.2;
        }
        
        .stats-card .card-title {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .stats-card .card-value {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .stats-card .card-change {
            font-size: 12px;
            display: flex;
            align-items: center;
        }
        
        .stats-card .card-change.positive {
            color: var(--success);
        }
        
        .stats-card .card-change.negative {
            color: var(--danger);
        }
        
        /* Chart Card */
        .chart-card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 24px;
        }
        
        .chart-card .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 15px 20px;
            border-radius: 12px 12px 0 0 !important;
        }
        
        .chart-card .card-title {
            font-weight: 600;
            margin-bottom: 0;
            color: var(--dark);
        }
        
        /* Table */
        .data-table {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        .data-table .table {
            margin-bottom: 0;
        }
        
        .data-table .table thead th {
            background-color: #f9fafb;
            color: #6b7280;
            font-weight: 600;
            padding: 15px 20px;
            border-bottom: none;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        
        .data-table .table tbody td {
            padding: 15px 20px;
            vertical-align: middle;
            border-top: 1px solid #f3f4f6;
        }
        
        .status-badge {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status-badge.success {
            background-color: #ecfdf5;
            color: var(--success);
        }
        
        .status-badge.warning {
            background-color: #fffbeb;
            color: var(--warning);
        }
        
        .status-badge.danger {
            background-color: #fef2f2;
            color: var(--danger);
        }
        
        .status-badge.info {
            background-color: #eff6ff;
            color: var(--info);
        }
        
        .status-badge.secondary {
            background-color: #f3f4f6;
            color: #6b7280;
        }
        
        /* Modal Custom */
        .modal-header {
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        /* Rate Plan Badge */
        .rate-plan-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .rate-plan-badge.event {
            background-color: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }
        
        .rate-plan-badge.season {
            background-color: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
        }
        
        /* Rate Plan Type Badge */
        .rateplan-type {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
        }
        
        .rateplan-type.seasonal {
            background-color: #eff6ff;
            color: #3b82f6;
            border: 1px solid #bfdbfe;
        }
        
        .rateplan-type.event {
            background-color: #f0fdf4;
            color: #10b981;
            border: 1px solid #bbf7d0;
        }
        
        .rateplan-type.promotion {
            background-color: #fef2f2;
            color: var(--danger);
            border: 1px solid #fecaca;
        }
        
        /* Rate Adjustment Badge */
        .rate-adjustment-badge {
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            min-width: 60px;
            text-align: center;
            background-color: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
        
        /* Status Badge untuk Rate Plans */
        .status-badge.active {
            background-color: #ecfdf5;
            color: #10b981;
        }
        
        .status-badge.upcoming {
            background-color: #fefbe9;
            color:rgb(248, 166, 1)
        }
        
        .status-badge.expired {
            background-color: #f3f4f6;
            color: #6b7280;
        }
        
        /* Booking Details Modal */
        .booking-details-content table {
            width: 100%;
            margin-bottom: 0;
        }
        
        .booking-details-content table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: var(--dark);
            width: 30%;
        }
        
        .booking-details-content table td {
            vertical-align: top;
        }
        
        .facility-item {
            padding: 4px 0;
            border-bottom: 1px solid #f1f1f1;
        }
        
        .facility-item:last-child {
            border-bottom: none;
        }
        
        .loading-spinner {
            min-height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                margin-left: -280px;
            }
            
            .sidebar.active {
                margin-left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .header h2 {
                font-size: 1.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .main-content {
                padding: 20px 15px;
            }
            
            .stats-card .card-value {
                font-size: 20px;
            }
        }
    </style>

    <!-- Header -->
    <div class="header d-flex justify-content-between align-items-center">
        <h2><i class="fas fa-tachometer-alt me-2"></i> Owner Dashboard</h2>

        <div class="user-menu">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ auth()->user()->photo ? asset('image/' . auth()->user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" alt="User" class="rounded-circle" width="32" height="32">
                    <span class="ms-2 d-none d-sm-inline">{{ auth()->user()->name }}</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i> Sign out
                        </a>
                        <!-- Hidden Logout Form -->
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <!-- Stats Row -->
            <div class="row">
                {{-- Total Revenue --}}
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stats-card bg-white shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-wallet card-icon text-primary"></i>
                            <p class="card-title">TOTAL REVENUE</p>
                            <h3 class="card-value">
                                @php
                                    $rev = $stats['revenueThisMonth'] ?? 0;
                                    if ($rev >= 1_000_000) {
                                        echo 'Rp ' . number_format($rev / 1_000_000, 1) . 'M';
                                    } else {
                                        echo 'Rp ' . number_format($rev, 0, ',', '.');
                                    }
                                @endphp
                            </h3>
                            @php
                                $revChange = $stats['revenueChange'] ?? 0;
                                $revTrend = $revChange >= 0 ? 'positive' : 'negative';
                                $revArrow = $revChange >= 0 ? 'up' : 'down';
                            @endphp
                            <div class="card-change {{ $revTrend }}">
                                <i class="fas fa-arrow-{{ $revArrow }} me-1"></i>
                                {{ number_format(abs($revChange), 1) }}% from last month
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Occupancy Rate --}}
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stats-card bg-white shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-bed card-icon text-success"></i>
                            <p class="card-title">OCCUPANCY RATE</p>
                            <h3 class="card-value">{{ ($stats['occupancyRate'] ?? 0) }}%</h3>
                            @php
                                $occChange = $stats['occupancyChange'] ?? 0;
                                $occTrend = $occChange >= 0 ? 'positive' : 'negative';
                                $occArrow = $occChange >= 0 ? 'up' : 'down';
                            @endphp
                            <div class="card-change {{ $occTrend }}">
                                <i class="fas fa-arrow-{{ $occArrow }} me-1"></i>
                                {{ number_format(abs($occChange), 1) }}% from last month
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Guests --}}
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stats-card bg-white shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-users card-icon text-info"></i>
                            <p class="card-title">TOTAL GUESTS</p>
                            <h3 class="card-value">{{ number_format($stats['totalGuests'] ?? 0, 0, ',', '.') }}</h3>
                            @php
                                $guestsChange = $stats['guestsChange'] ?? 0;
                                $guestsTrend = $guestsChange >= 0 ? 'positive' : 'negative';
                                $guestsArrow = $guestsChange >= 0 ? 'up' : 'down';
                            @endphp
                            <div class="card-change {{ $guestsTrend }}">
                                <i class="fas fa-arrow-{{ $guestsArrow }} me-1"></i>
                                {{ number_format(abs($guestsChange), 1) }}% from last month
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Average Rating --}}
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stats-card bg-white shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-star card-icon text-warning"></i>
                            <p class="card-title">AVG RATING</p>
                            <h3 class="card-value">{{ number_format($stats['avgRating'] ?? 0, 1) }}</h3>
                            @php
                                $ratingChange = $stats['ratingChange'] ?? 0;
                                $ratingTrend = $ratingChange >= 0 ? 'positive' : 'negative';
                                $ratingArrow = $ratingChange >= 0 ? 'up' : 'down';
                            @endphp
                            <div class="card-change {{ $ratingTrend }}">
                                <i class="fas fa-arrow-{{ $ratingArrow }} me-1"></i>
                                {{ number_format(abs($ratingChange), 1) }} from last month
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- {{-- Akses Cepat --}}
            <div class="row quick-links mb-4">
                <div class="col-lg-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white fw-bold">
                            <i class="fas fa-bolt me-1" style="color:#C9A227;"></i> Akses Cepat
                        </div>
                        <div class="card-body d-flex flex-wrap gap-3">
                            <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-primary"><i class="fas fa-bed me-1"></i> Manajemen Kamar</a>
                            <a href="{{ route('admin.guests.index') }}" class="btn btn-outline-primary"><i class="fas fa-users me-1"></i> Data Tamu</a>
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-primary"><i class="fas fa-calendar-alt me-1"></i> Semua Booking</a>
                            <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-primary"><i class="fas fa-file-invoice-dollar me-1"></i> Pembayaran</a>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary"><i class="fas fa-user-cog me-1"></i> Resepsionis</a>
                        </div>
                    </div>
                </div>
            </div> -->

            {{-- Grafik + User --}}
            <div class="row">
                {{-- Revenue Overview --}}
                <div class="col-lg-8">
                    <div class="chart-card card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Revenue Overview</h5>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    This Month
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="#">This Week</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="revenueChart" height="300"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Room Occupancy --}}
                <div class="col-lg-4">
                    <div class="chart-card card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Room Occupancy</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="roomOccupancyChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="row">
                <div class="col-12">
                    <div class="chart-card card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Recent Bookings</h5>
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-primary">View All</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="data-table">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Booking ID</th>
                                            <th>Guest</th>
                                            <th>Room</th>
                                            <th>Check In</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentBookingsLimited as $booking)
                                            <tr>
                                                <td>#BK-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ $booking->guest->photo 
                                                            ? asset('image/' . $booking->guest->photo) 
                                                            : 'https://ui-avatars.com/api/?name=' . urlencode($booking->guest->name ?? 'Guest') }}" 
                                                                alt="Guest" 
                                                                style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; margin-right: 10px;">
                                                        <span>{{ $booking->guest->name ?? 'N/A' }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($booking->room && $booking->room->tipeKamar)
                                                        {{ $booking->room->tipeKamar->tipe_kamar }}
                                                        @if($booking->room->name || $booking->room->number)
                                                            - {{ $booking->room->name ?? $booking->room->number }}
                                                        @endif
                                                    @elseif($booking->room)
                                                        {{ $booking->room->name ?? $booking->room->number ?? 'N/A' }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>{{ $booking->check_in ? \Carbon\Carbon::parse($booking->check_in)->format('d M Y') : 'N/A' }}</td>
                                                <td>
                                                    Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    @php
                                                        $status = $booking->status ?? 'unknown';
                                                        $badgeClass = match($status) {
                                                            'booked', 'confirmed', 'paid' => 'success',
                                                            'checked_in' => 'info',
                                                            'pending' => 'warning',
                                                            'canceled', 'cancelled' => 'danger',
                                                            default => 'secondary'
                                                        };
                                                    @endphp
                                                    <span class="status-badge {{ $badgeClass }}">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-primary view-booking-details" 
                                                            data-booking-id="{{ $booking->id }}"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#bookingDetailModal">
                                                        Details
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-3">No recent bookings found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rate Plans Table -->
            <div class="row">
                <div class="col-12">
                    <div class="chart-card card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">All Rate Plans</h5>
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#createRatePlanModal">
                                    <i class="fas fa-plus me-1"></i> Add Rate Plan
                                </button>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-filter me-1"></i> Filter
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('admin.rate-plans.index') }}">All Rate Plans</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.rate-plans.index', ['status' => 'active']) }}">Active Only</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.rate-plans.index', ['status' => 'upcoming']) }}">Upcoming</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.rate-plans.index', ['status' => 'expired']) }}">Expired</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.rate-plans.index', ['type' => 'seasonal']) }}">Seasonal</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.rate-plans.index', ['type' => 'event']) }}">Event</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            @if(session('success'))
                                <div class="alert alert-success shadow-sm mb-0">
                                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                </div>
                            @endif

                            @if($activeRatePlans->isEmpty())
                                <div class="text-center text-muted py-5">
                                    <i class="fas fa-percentage fa-3x mb-3 text-primary"></i>
                                    <h5 class="text-dark">No rate plans found</h5>
                                    <p class="mb-0">Click "Add Rate Plan" to create a new pricing strategy</p>
                                </div>
                            @else
                                <div class="data-table">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>Plan Name</th>
                                                <th>Type</th>
                                                <th>Room Types</th>
                                                <th>Date Range</th>
                                                <th>Rate Adjustment</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($activeRatePlans as $plan)
                                                <tr>
                                                    <td>{{ $plan->name }}</td>
                                                    <td>
                                                        <span class="rateplan-type {{ $plan->type }}">
                                                            {{ ucfirst($plan->type) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if (is_array($plan->room_types))
                                                            @if (in_array('all', $plan->room_types) || (count($plan->room_types) === 1 && $plan->room_types[0] === 'all'))
                                                                All Rooms
                                                            @else
                                                                {{ implode(', ', $plan->room_types) }}
                                                            @endif
                                                        @else
                                                            {{ $plan->room_types == 'all' ? 'All Rooms' : ($plan->room_types ?? 'N/A') }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <small>
                                                            {{ \Carbon\Carbon::parse($plan->start_date)->format('d M Y') }} - 
                                                            {{ \Carbon\Carbon::parse($plan->end_date)->format('d M Y') }}
                                                        </small><br>
                                                        <small class="text-muted">
                                                            {{ \Carbon\Carbon::parse($plan->start_date)->diffInDays(\Carbon\Carbon::parse($plan->end_date)) + 1 }} days
                                                        </small>
                                                    </td>
                                                    <td>
                                                        {{ $plan->rate_adjustment_sign }}{{ $plan->rate_adjustment_value }}
                                                        {{ $plan->rate_adjustment_type === 'percentage' ? '%' : 'IDR' }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $status = $plan->status; // Menggunakan accessor
                                                            $badgeClass = match($status) {
                                                                'active' => 'active',
                                                                'upcoming' => 'upcoming',
                                                                'expired' => 'expired',
                                                                default => 'expired' // Fallback untuk status tidak dikenal
                                                            };
                                                            
                                                            $statusText = match($status) {
                                                                'active' => 'Active',
                                                                'upcoming' => 'Upcoming', 
                                                                'expired' => 'Expired',
                                                                default => 'Expired' // Fallback
                                                            };
                                                        @endphp
                                                        <span class="status-badge {{ $badgeClass }}">
                                                            {{ $statusText }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-outline-primary me-1 edit-btn"
                                                            data-id="{{ $plan->id }}"
                                                            data-name="{{ $plan->name }}"
                                                            data-type="{{ $plan->type }}"
                                                            data-start_date="{{ $plan->start_date }}"
                                                            data-end_date="{{ $plan->end_date }}"
                                                            data-room_types="{{ json_encode($plan->room_types) }}"
                                                            data-rate_adjustment_sign="{{ $plan->rate_adjustment_sign }}"
                                                            data-rate_adjustment_value="{{ $plan->rate_adjustment_value }}"
                                                            data-rate_adjustment_type="{{ $plan->rate_adjustment_type }}"
                                                            data-min_stay="{{ $plan->min_stay }}"
                                                            data-release_days="{{ $plan->release_days }}"
                                                            data-description="{{ $plan->description }}"
                                                            data-is_active="{{ $plan->is_active ? '1' : '0' }}">
                                                            Edit
                                                        </button>
                                                        <form action="{{ route('admin.rate-plans.destroy', $plan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this rate plan?')">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Modal: Booking Details -->
    <div class="modal fade" id="bookingDetailModal" tabindex="-1" aria-labelledby="bookingDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingDetailModalLabel">
                        <i class="fas fa-bed me-2"></i> Detail Booking #<span id="modalBookingId"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="loading-spinner text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Memuat data booking...</p>
                    </div>
                    <div class="booking-details-content" style="display: none;">
                        <table class="table table-bordered">
                            <tr>
                                <th>ID</th>
                                <td id="detailId">-</td>
                            </tr>
                            <tr>
                                <th>Nama Tamu</th>
                                <td id="detailGuest">-</td>
                            </tr>
                            <tr>
                                <th>No. Kamar</th>
                                <td id="detailRoomNumber">-</td>
                            </tr>
                            <tr>
                                <th>Tipe Kamar</th>
                                <td id="detailRoomType">-</td>
                            </tr>
                            <tr>
                                <th>Check-In</th>
                                <td id="detailCheckIn">-</td>
                            </tr>
                            <tr>
                                <th>Check-Out</th>
                                <td id="detailCheckOut">-</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td id="detailStatus">-</td>
                            </tr>
                            <tr>
                                <th>Fasilitas Tambahan</th>
                                <td id="detailFacilities">-</td>
                            </tr>
                            <tr>
                                <th>Booked By</th>
                                <td id="detailBookedBy">-</td>
                            </tr>
                            <tr>
                                <th>Dibuat Pada</th>
                                <td id="detailCreatedAt">-</td>
                            </tr>
                            <tr>
                                <th>Diperbarui Pada</th>
                                <td id="detailUpdatedAt">-</td>
                            </tr>
                        </table>
                    </div>
                    <div class="error-message alert alert-danger" style="display: none;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <span id="errorText">Terjadi kesalahan saat memuat data booking.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </button>
                    <a href="#" class="btn btn-primary" id="editBookingBtn">
                        <i class="fas fa-edit me-1"></i> Edit Booking
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Create Rate Plan -->
    <div class="modal fade" id="createRatePlanModal" tabindex="-1" aria-labelledby="createRatePlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createRatePlanModalLabel">
                        <i class="fas fa-percentage me-2"></i> Create New Rate Plan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.rate-plans.store') }}" method="POST" id="ratePlanForm">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Plan Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="type" class="form-label">Plan Type</label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="seasonal" {{ old('type') == 'seasonal' ? 'selected' : '' }}>Seasonal</option>
                                    <option value="event" {{ old('type') == 'event' ? 'selected' : '' }}>Event</option>
                                    <option value="promotion" {{ old('type') == 'promotion' ? 'selected' : '' }}>promotion</option>
                                </select>
                                @error('type')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                                @error('start_date')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                                @error('end_date')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="room_types" class="form-label">Apply To Room Types</label>
                                <select class="form-select" id="room_types" name="room_types[]" multiple required>
                                    <option value="all" {{ in_array('all', old('room_types', [])) ? 'selected' : '' }}>All Rooms</option>
                                    @foreach($tipeKamarList as $tipe)
                                        <option value="{{ $tipe }}" {{ in_array($tipe, old('room_types', [])) ? 'selected' : '' }}>
                                            {{ $tipe }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_types')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Rate Adjustment</label>
                                <div class="input-group">
                                    <select class="form-select" name="rate_adjustment_sign" style="max-width: 80px;" required>
                                        <option value="+" {{ old('rate_adjustment_sign', '+') == '+' ? 'selected' : '' }}>+</option>
                                        <option value="-" {{ old('rate_adjustment_sign') == '-' ? 'selected' : '' }}>-</option>
                                    </select>
                                    <input type="number" step="0.01" class="form-control" name="rate_adjustment_value"
                                           value="{{ old('rate_adjustment_value') }}" min="0" placeholder="0" required>
                                    <span class="input-group-text">
                                        <select class="form-select border-0 bg-transparent" name="rate_adjustment_type" style="width: auto; padding: 0; height: auto;" required>
                                            <option value="percentage" {{ old('rate_adjustment_type', 'percentage') == 'percentage' ? 'selected' : '' }}>%</option>
                                            <option value="fixed" {{ old('rate_adjustment_type') == 'fixed' ? 'selected' : '' }}>IDR</option>
                                        </select>
                                    </span>
                                </div>
                                @error('rate_adjustment_sign')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                                @error('rate_adjustment_value')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                                @error('rate_adjustment_type')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="min_stay" class="form-label">Minimum Stay (nights)</label>
                                <input type="number" class="form-control" id="min_stay" name="min_stay" min="1" value="{{ old('min_stay', 1) }}">
                                @error('min_stay')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="release_days" class="form-label">Release Days (prior to arrival)</label>
                                <input type="number" class="form-control" id="release_days" name="release_days" min="0" value="{{ old('release_days', 0) }}">
                                @error('release_days')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Activate this plan immediately</label>
                            @error('is_active')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" form="ratePlanForm" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Save Rate Plan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Edit Rate Plan -->
    <div class="modal fade" id="editRatePlanModal" tabindex="-1" aria-labelledby="editRatePlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRatePlanModalLabel">
                        <i class="fas fa-edit me-2"></i> Edit Rate Plan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editRatePlanForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="edit_plan_id" name="id">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_name" class="form-label">Plan Name</label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_type" class="form-label">Plan Type</label>
                                <select class="form-select" id="edit_type" name="type" required>
                                    <option value="seasonal">Seasonal</option>
                                    <option value="event">Event</option>
                                    <option value="promotion">promotion</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="edit_start_date" name="start_date" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="edit_end_date" name="end_date" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_room_types" class="form-label">Apply To Room Types</label>
                                <select class="form-select" id="edit_room_types" name="room_types[]" multiple required>
                                    <option value="all">All Rooms</option>
                                    @foreach($tipeKamarList as $tipe)
                                        <option value="{{ $tipe }}">{{ $tipe }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Rate Adjustment</label>
                                <div class="input-group">
                                    <select class="form-select" name="rate_adjustment_sign" style="max-width: 80px;" required>
                                        <option value="+">+</option>
                                        <option value="-">-</option>
                                    </select>
                                    <input type="number" step="0.01" class="form-control" name="rate_adjustment_value" min="0" placeholder="0" required>
                                    <span class="input-group-text">
                                        <select class="form-select border-0 bg-transparent" name="rate_adjustment_type" style="width: auto; padding: 0; height: auto;" required>
                                            <option value="percentage">%</option>
                                            <option value="fixed">IDR</option>
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_min_stay" class="form-label">Minimum Stay (nights)</label>
                                <input type="number" class="form-control" id="edit_min_stay" name="min_stay" min="1">
                            </div>
                            <div class="col-md-6">
                                <label for="edit_release_days" class="form-label">Release Days</label>
                                <input type="number" class="form-control" id="edit_release_days" name="release_days" min="0">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="edit_is_active" name="is_active" value="1">
                            <label class="form-check-label" for="edit_is_active">Activate this plan immediately</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Rate Plan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Coupon Modal -->
    <div class="modal fade" id="couponModal" tabindex="-1" aria-labelledby="couponModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="couponModalLabel">Create New Coupon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form dengan ID untuk pengiriman data -->
                    <form id="couponForm">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="couponCode" class="form-label">Coupon Code</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="couponCode" name="code" required>
                                    <button class="btn btn-outline-secondary" type="button" id="generateCode">Generate</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="discountType" class="form-label">Discount Type</label>
                                <select class="form-select" id="discountType" name="discount_type" required>
                                    <option value="percentage">Percentage</option>
                                    <option value="fixed">Fixed Amount</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="discountValue" class="form-label">Discount Value</label>
                                <input type="number" class="form-control" id="discountValue" name="discount_value" required>
                            </div>
                            <div class="col-md-6">
                                <label for="maxUses" class="form-label">Max Uses</label>
                                <input type="number" class="form-control" id="maxUses" name="max_uses">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="validFrom" class="form-label">Valid From</label>
                                <input type="date" class="form-control" id="validFrom" name="valid_from" required>
                            </div>
                            <div class="col-md-6">
                                <label for="validTo" class="form-label">Valid To</label>
                                <input type="date" class="form-control" id="validTo" name="valid_to" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="couponDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="couponDescription" name="description" rows="2"></textarea>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="activeCoupon" name="is_active" checked>
                            <label class="form-check-label" for="activeCoupon">Active</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveCouponBtn">Create Coupon</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Revenue (in millions)',
                    data: [3.2, 4.1, 3.8, 5.2, 6.0, 7.5, 8.2],
                    backgroundColor: 'rgba(67, 97, 238, 0.1)',
                    borderColor: 'rgba(67, 97, 238, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value + 'M';
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Room Occupancy Chart
        const roomOccupancyCtx = document.getElementById('roomOccupancyChart').getContext('2d');
        const roomOccupancyChart = new Chart(roomOccupancyCtx, {
            type: 'doughnut',
            data: {
                labels: ['Standard', 'Deluxe', 'Suite', 'Family'],
                datasets: [{
                    data: [35, 25, 20, 20],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                cutout: '70%'
            }
        });

        // Generate random coupon code
        document.getElementById('generateCode').addEventListener('click', function() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let result = '';
            for (let i = 0; i < 8; i++) {
                result += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            document.getElementById('couponCode').value = result;
        });

        // Toggle sidebar for mobile
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });

        // Booking Details Modal Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const bookingModal = document.getElementById('bookingDetailModal');
            const viewButtons = document.querySelectorAll('.view-booking-details');
            
            viewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const bookingId = this.getAttribute('data-booking-id');
                    loadBookingDetails(bookingId);
                });
            });

            // Reset modal when closed
            bookingModal.addEventListener('hidden.bs.modal', function() {
                resetModal();
            });

            function loadBookingDetails(bookingId) {
                const modal = document.getElementById('bookingDetailModal');
                const loadingEl = modal.querySelector('.loading-spinner');
                const contentEl = modal.querySelector('.booking-details-content');
                const errorEl = modal.querySelector('.error-message');
                
                // Show loading, hide content and error
                loadingEl.style.display = 'flex';
                contentEl.style.display = 'none';
                errorEl.style.display = 'none';
                
                // Update modal title
                document.getElementById('modalBookingId').textContent = 'BK-' + bookingId.padStart(4, '0');
                
                // Fetch booking details via AJAX
                fetch(`/admin/bookings/${bookingId}/details`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        populateBookingDetails(data.booking);
                        loadingEl.style.display = 'none';
                        contentEl.style.display = 'block';
                    } else {
                        throw new Error(data.message || 'Failed to load booking details');
                    }
                })
                .catch(error => {
                    console.error('Error loading booking details:', error);
                    loadingEl.style.display = 'none';
                    errorEl.style.display = 'block';
                    document.getElementById('errorText').textContent = error.message;
                });
            }

            function populateBookingDetails(booking) {
                document.getElementById('detailId').textContent = 'BK-' + booking.id.toString().padStart(4, '0');
                document.getElementById('detailGuest').textContent = booking.guest_name || 'N/A';
                document.getElementById('detailRoomNumber').textContent = booking.room_number || 'N/A';
                document.getElementById('detailRoomType').textContent = booking.room_type || 'N/A';
                document.getElementById('detailCheckIn').textContent = booking.check_in_formatted || 'N/A';
                document.getElementById('detailCheckOut').textContent = booking.check_out_formatted || 'N/A';
                
                // Status dengan badge
                const statusBadge = getStatusBadge(booking.status);
                document.getElementById('detailStatus').innerHTML = statusBadge;
                
                // Facilities
                const facilitiesHtml = booking.facilities && booking.facilities.length > 0 
                    ? booking.facilities.map(facility => 
                        `<div class="facility-item">
                            <strong>${facility.name}</strong> - Rp ${formatCurrency(facility.price)}/malam
                            ${facility.dates ? `<br><small class="text-muted">${facility.dates}</small>` : ''}
                        </div>`
                    ).join('')
                    : '<span class="text-muted">Tidak ada fasilitas tambahan</span>';
                document.getElementById('detailFacilities').innerHTML = facilitiesHtml;
                
                document.getElementById('detailBookedBy').textContent = booking.booked_by || 'N/A';
                document.getElementById('detailCreatedAt').textContent = booking.created_at_formatted || 'N/A';
                document.getElementById('detailUpdatedAt').textContent = booking.updated_at_formatted || 'N/A';
                
                // Set edit button URL
                document.getElementById('editBookingBtn').href = `/admin/bookings/${booking.id}/edit`;
            }

            function getStatusBadge(status) {
                const statusMap = {
                    'booked': { class: 'warning', text: 'Booked' },
                    'checked_in': { class: 'info', text: 'Checked In' },
                    'checked_out': { class: 'success', text: 'Checked Out' },
                    'canceled': { class: 'danger', text: 'Canceled' },
                    'paid': { class: 'primary', text: 'Paid' }
                };
                
                const statusInfo = statusMap[status] || { class: 'secondary', text: status };
                return `<span class="status-badge ${statusInfo.class}">${statusInfo.text}</span>`;
            }

            function formatCurrency(amount) {
                return new Intl.NumberFormat('id-ID').format(amount);
            }

            function resetModal() {
                const contentEl = document.querySelector('.booking-details-content');
                const errorEl = document.querySelector('.error-message');
                
                contentEl.style.display = 'none';
                errorEl.style.display = 'none';
                
                // Reset all fields
                const fields = ['detailId', 'detailGuest', 'detailRoomNumber', 'detailRoomType', 
                               'detailCheckIn', 'detailCheckOut', 'detailStatus', 'detailFacilities',
                               'detailBookedBy', 'detailCreatedAt', 'detailUpdatedAt'];
                
                fields.forEach(field => {
                    document.getElementById(field).textContent = '-';
                });
            }

            // Handle Edit button click for rate plans
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const modal = document.getElementById('editRatePlanModal');
                    const form = document.getElementById('editRatePlanForm');
                    const planId = this.dataset.id;

                    // Set form action
                    form.action = `/admin/rate-plans/${planId}`;

                    // Fill form fields
                    document.getElementById('edit_plan_id').value = planId;
                    document.getElementById('edit_name').value = this.dataset.name;
                    document.getElementById('edit_type').value = this.dataset.type;
                    document.getElementById('edit_start_date').value = this.dataset.start_date;
                    document.getElementById('edit_end_date').value = this.dataset.end_date;
                    document.getElementById('edit_min_stay').value = this.dataset.min_stay || 1;
                    document.getElementById('edit_release_days').value = this.dataset.release_days || 0;
                    document.getElementById('edit_description').value = this.dataset.description || '';

                    // Handle is_active checkbox
                    document.getElementById('edit_is_active').checked = this.dataset.is_active === '1';

                    // Handle room_types (multiple select)
                    const roomTypesSelect = document.getElementById('edit_room_types');
                    const roomTypes = JSON.parse(this.dataset.room_types || '[]');
                    for (let option of roomTypesSelect.options) {
                        option.selected = roomTypes.includes(option.value);
                    }

                    // Set rate adjustment fields
                    document.querySelector('[name="rate_adjustment_sign"]').value = this.dataset.rate_adjustment_sign;
                    document.querySelector('[name="rate_adjustment_value"]').value = this.dataset.rate_adjustment_value;
                    document.querySelector('[name="rate_adjustment_type"]').value = this.dataset.rate_adjustment_type;

                    // Show modal
                    const bootstrapModal = new bootstrap.Modal(modal);
                    bootstrapModal.show();
                });
            });

            // Coupon functionality
            document.getElementById('saveCouponBtn').addEventListener('click', function () {
                const formData = new FormData(document.getElementById('couponForm'));
                const data = Object.fromEntries(formData);

                // Validasi sederhana
                if (!data.code || !data.discount_type || !data.discount_value || !data.valid_from || !data.valid_to) {
                    alert('Please fill all required fields.');
                    return;
                }

                // Kirim ke backend (sesuaikan URL dengan endpoint API Anda)
                fetch('{{ route("admin.coupons.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content // jika pakai Laravel/CSRF
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        alert('Coupon created successfully!');
                        // Tutup modal
                        var modal = bootstrap.Modal.getInstance(document.getElementById('couponModal'));
                        modal.hide();
                        // Reset form
                        document.getElementById('couponForm').reset();
                    } else {
                        alert('Error: ' + (result.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to save coupon. Check console for details.');
                });
            });
        });

        function loadBookingDetail(id) {
  fetch(`/bookings/${id}/details`)
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        // tampilkan data di modal
      } else {
        alert('Data booking tidak ditemukan');
      }
    })
    .catch(err => console.error(err));
}

    </script>
@endsection