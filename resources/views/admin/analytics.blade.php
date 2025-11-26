@extends('layouts.adminlte')
@section('title', 'Analytics Dashboard')

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
    
    /* Analytics Cards */
    .analytics-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 24px;
        transition: all 0.3s;
    }
    
    .analytics-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .analytics-card .card-header {
        background-color: white;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding: 15px 20px;
        border-radius: 12px 12px 0 0 !important;
    }
    
    .analytics-card .card-title {
        font-weight: 600;
        margin-bottom: 0;
        color: var(--dark);
    }
    
    .analytics-card .card-body {
        padding: 20px;
    }
    
    /* Filter Controls */
    .filter-controls {
        background-color: white;
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    
    /* KPI Cards */
    .kpi-card {
        background-color: white;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 15px;
        text-align: center;
    }
    
    .kpi-card .kpi-value {
        font-size: 24px;
        font-weight: 600;
        margin: 10px 0;
        color: var(--primary);
    }
    
    .kpi-card .kpi-label {
        font-size: 14px;
        color: #6b7280;
    }
    
    .kpi-card .kpi-change {
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .kpi-card .kpi-change.positive {
        color: var(--success);
    }
    
    .kpi-card .kpi-change.negative {
        color: var(--danger);
    }
    
    .kpi-card .kpi-change.neutral {
        color: #6b7280;
    }
    
    /* Comparison Cards */
    .comparison-card {
        background-color: white;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 15px;
    }
    
    .comparison-card .comparison-label {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 5px;
    }
    
    .comparison-card .comparison-bar {
        height: 8px;
        background-color: #e5e7eb;
        border-radius: 4px;
        overflow: hidden;
        margin-bottom: 5px;
    }
    
    .comparison-card .comparison-bar-fill {
        height: 100%;
        border-radius: 4px;
    }
    
    .comparison-card .comparison-value {
        font-size: 12px;
        display: flex;
        justify-content: space-between;
    }

    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }

    .chart-container-sm {
        position: relative;
        height: 250px;
        width: 100%;
    }

    .no-data {
        text-align: center;
        padding: 40px;
        color: #6b7280;
    }

    .no-data i {
        font-size: 48px;
        margin-bottom: 15px;
        color: #d1d5db;
    }
</style>

<div class="container-fluid">
<!-- Header -->
<div class="header d-flex justify-content-between align-items-center">
    <h2><i class="fas fa-chart-pie me-2"></i> Analytics Dashboard</h2>

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

    <!-- Filter Controls -->
    <div class="filter-controls">
        <form method="GET">
            <div class="row">
                <div class="col-md-3 mb-3 mb-md-0">
                    <label for="timePeriod" class="form-label">Time Period</label>
                    <select class="form-select" id="timePeriod" name="period">
                        <option value="last_7_days" {{ request('period') == 'last_7_days' ? 'selected' : '' }}>Last 7 Days</option>
                        <option value="last_30_days" {{ request('period') == 'last_30_days' ? 'selected' : '' }}>Last 30 Days</option>
                        <option value="this_month" {{ request('period') == 'this_month' ? 'selected' : '' }}>This Month</option>
                        <option value="last_month" {{ request('period') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                        <option value="this_year" {{ request('period') == 'this_year' ? 'selected' : '' }}>This Year</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <label for="roomTypeFilter" class="form-label">Room Type</label>
                    <select class="form-select" id="roomTypeFilter" name="room_type">
                        <option value="all" {{ request('room_type') == 'all' ? 'selected' : '' }}>All Room Types</option>
                        <option value="Standard" {{ request('room_type') == 'Standard' ? 'selected' : '' }}>Standard</option>
                        <option value="Deluxe" {{ request('room_type') == 'Deluxe' ? 'selected' : '' }}>Deluxe</option>
                        <option value="Suite" {{ request('room_type') == 'Suite' ? 'selected' : '' }}>Suite</option>
                        <option value="Family" {{ request('room_type') == 'Family' ? 'selected' : '' }}>Family</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <label for="channelFilter" class="form-label">Booking Channel</label>
                    <select class="form-select" id="channelFilter" name="channel">
                        <option value="all" {{ request('channel') == 'all' ? 'selected' : '' }}>All Channels</option>
                        <option value="website" {{ request('channel') == 'website' ? 'selected' : '' }}>Website Direct</option>
                        <option value="booking_com" {{ request('channel') == 'booking_com' ? 'selected' : '' }}>OTA (Booking.com)</option>
                        <option value="agoda" {{ request('channel') == 'agoda' ? 'selected' : '' }}>OTA (Agoda)</option>
                        <option value="walk_in" {{ request('channel') == 'walk_in' ? 'selected' : '' }}>Walk-in</option>
                        <option value="phone" {{ request('channel') == 'phone' ? 'selected' : '' }}>Phone</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100" style="margin-top: 28px;">
                        <i class="fas fa-filter me-1"></i> Apply Filters
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Key Metrics Row -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="kpi-card">
                <i class="fas fa-wallet text-primary"></i>
                <div class="kpi-value">Rp {{ number_format($currentData['totalRevenue'] ?? 0, 0, ',', '.') }}</div>
                <div class="kpi-label">Total Revenue</div>
                <div class="kpi-change {{ $changes['totalRevenue']['direction'] ?? 'neutral' }}">
                    <i class="fas fa-arrow-{{ ($changes['totalRevenue']['direction'] ?? 'neutral') == 'positive' ? 'up' : (($changes['totalRevenue']['direction'] ?? 'neutral') == 'negative' ? 'down' : 'right') }} me-1"></i> 
                    {{ $changes['totalRevenue']['percentage'] ?? 0 }}% vs last period
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="kpi-card">
                <i class="fas fa-bed text-success"></i>
                <div class="kpi-value">{{ $currentData['occupancyRate'] ?? 0 }}%</div>
                <div class="kpi-label">Occupancy Rate</div>
                <div class="kpi-change {{ $changes['occupancyRate']['direction'] ?? 'neutral' }}">
                    <i class="fas fa-arrow-{{ ($changes['occupancyRate']['direction'] ?? 'neutral') == 'positive' ? 'up' : (($changes['occupancyRate']['direction'] ?? 'neutral') == 'negative' ? 'down' : 'right') }} me-1"></i> 
                    {{ $changes['occupancyRate']['percentage'] ?? 0 }}% vs last period
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="kpi-card">
                <i class="fas fa-calendar-check text-info"></i>
                <div class="kpi-value">{{ $currentData['totalBookings'] ?? 0 }}</div>
                <div class="kpi-label">Bookings</div>
                <div class="kpi-change {{ $changes['totalBookings']['direction'] ?? 'neutral' }}">
                    <i class="fas fa-arrow-{{ ($changes['totalBookings']['direction'] ?? 'neutral') == 'positive' ? 'up' : (($changes['totalBookings']['direction'] ?? 'neutral') == 'negative' ? 'down' : 'right') }} me-1"></i> 
                    {{ $changes['totalBookings']['percentage'] ?? 0 }}% vs last period
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="kpi-card">
                <i class="fas fa-money-bill-wave text-warning"></i>
                <div class="kpi-value">Rp {{ number_format($currentData['adr'] ?? 0, 0, ',', '.') }}</div>
                <div class="kpi-label">Average Daily Rate</div>
                <div class="kpi-change {{ $changes['adr']['direction'] ?? 'neutral' }}">
                    <i class="fas fa-arrow-{{ ($changes['adr']['direction'] ?? 'neutral') == 'positive' ? 'up' : (($changes['adr']['direction'] ?? 'neutral') == 'negative' ? 'down' : 'right') }} me-1"></i> 
                    {{ $changes['adr']['percentage'] ?? 0 }}% vs last period
                </div>
            </div>
        </div>
    </div>

    <!-- Main Charts Row -->
    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="analytics-card card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Revenue Trend</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="revenueDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Daily
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="revenueDropdown">
                            <li><a class="dropdown-item" href="#">Daily</a></li>
                            <li><a class="dropdown-item" href="#">Weekly</a></li>
                            <li><a class="dropdown-item" href="#">Monthly</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="revenueTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="analytics-card card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Booking Sources</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="sourcesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            This Month
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="sourcesDropdown">
                            <li><a class="dropdown-item" href="#">This Week</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="bookingSourcesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Charts Row -->
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="analytics-card card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Occupancy Rate by Room Type</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="occupancyDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            This Month
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="occupancyDropdown">
                            <li><a class="dropdown-item" href="#">This Week</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container-sm">
                        <canvas id="occupancyByRoomChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="analytics-card card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Guest Demographics</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="demographicsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            This Year
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="demographicsDropdown">
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Quarter</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container-sm">
                        <canvas id="guestDemographicsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Comparison Row -->
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="analytics-card card">
                <div class="card-header">
                    <h5 class="card-title">Room Type Performance</h5>
                </div>
                <div class="card-body">
                    @if($roomPerformance->count() > 0)
                        @foreach($roomPerformance as $room)
                        @php
                            $maxBookings = $roomPerformance->max('bookings');
                            $percentage = $maxBookings > 0 ? ($room->bookings / $maxBookings) * 100 : 0;
                        @endphp
                        <div class="comparison-card">
                            <div class="comparison-label">{{ $room->tipe_kamar }}</div>
                            <div class="comparison-bar">
                                <div class="comparison-bar-fill bg-primary" style="width: {{ $percentage }}%"></div>
                            </div>
                            <div class="comparison-value">
                                <span>{{ $room->bookings }} bookings</span>
                                <span>Rp {{ number_format($room->revenue, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="no-data">
                            <i class="fas fa-bed"></i>
                            <p>No room performance data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="analytics-card card">
                <div class="card-header">
                    <h5 class="card-title">Seasonal Performance Comparison</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container-sm">
                        <canvas id="seasonalComparisonChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Initializing charts...');
        
        // Sample data for demonstration
        const sampleDates = ['1 Jul', '2 Jul', '3 Jul', '4 Jul', '5 Jul', '6 Jul', '7 Jul'];
        const sampleRevenues = [1200000, 950000, 1400000, 1100000, 1650000, 1850000, 2100000];
        const sampleSources = [35, 25, 20, 15, 5];
        const sampleOccupancy = [75, 85, 65, 55];

        // Revenue Trend Chart
        const revenueTrendCtx = document.getElementById('revenueTrendChart');
        if (revenueTrendCtx) {
            const dates = @json($dates);
            const revenues = @json($revenues);
            
            new Chart(revenueTrendCtx, {
                type: 'line',
                data: {
                    labels: dates.length > 0 ? dates : sampleDates,
                    datasets: [{
                        label: 'Revenue',
                        data: revenues.length > 0 ? revenues : sampleRevenues,
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
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + context.raw.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { drawBorder: false },
                            ticks: {
                                callback: function(value) {
                                    if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                                    if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(0) + 'K';
                                    return 'Rp ' + value;
                                }
                            }
                        },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        // Booking Sources Chart
        const bookingSourcesCtx = document.getElementById('bookingSourcesChart');
        if (bookingSourcesCtx) {
            const sources = @json($sources);
            const sourceValues = Object.values(sources);
            
            const sourceLabels = Object.keys(sources).map(source => {
                const labelMap = {
                    'website': 'Website Direct',
                    'booking_com': 'OTA (Booking.com)',
                    'agoda': 'OTA (Agoda)',
                    'walk_in': 'Walk-in',
                    'phone': 'Phone'
                };
                return labelMap[source] || source;
            });

            new Chart(bookingSourcesCtx, {
                type: 'doughnut',
                data: {
                    labels: sourceLabels,
                    datasets: [{
                        data: sourceValues.some(v => v > 0) ? sourceValues : sampleSources,
                        backgroundColor: [
                            'rgba(67, 97, 238, 0.8)',
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(245, 158, 11, 0.8)',
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(156, 163, 175, 0.8)'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { 
                            position: 'right',
                            labels: {
                                usePointStyle: true,
                                padding: 15
                            }
                        } 
                    },
                    cutout: '65%'
                }
            });
        }

        // Occupancy by Room Type Chart
        const occupancyByRoomCtx = document.getElementById('occupancyByRoomChart');
        if (occupancyByRoomCtx) {
            const roomLabels = @json($roomPerformance->pluck('tipe_kamar'));
            const occupancyData = @json($roomPerformance->pluck('occupancy_rate'));
            
            new Chart(occupancyByRoomCtx, {
                type: 'bar',
                data: {
                    labels: roomLabels.length > 0 ? roomLabels : ['Standard', 'Deluxe', 'Suite', 'Family'],
                    datasets: [{
                        label: 'Occupancy Rate %',
                        data: occupancyData.length > 0 ? occupancyData : sampleOccupancy,
                        backgroundColor: [
                            'rgba(16, 185, 129, 0.7)',
                            'rgba(67, 97, 238, 0.7)',
                            'rgba(245, 158, 11, 0.7)',
                            'rgba(59, 130, 246, 0.7)'
                        ],
                        borderColor: [
                            'rgba(16, 185, 129, 1)',
                            'rgba(67, 97, 238, 1)',
                            'rgba(245, 158, 11, 1)',
                            'rgba(59, 130, 246, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + '%';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: { 
                                callback: v => v + '%',
                                stepSize: 20
                            },
                            grid: {
                                drawBorder: false
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
        }

        // Guest Demographics Chart
        const guestDemographicsCtx = document.getElementById('guestDemographicsChart');
        if (guestDemographicsCtx) {
            new Chart(guestDemographicsCtx, {
                type: 'polarArea',
                data: {
                    labels: ['Business', 'Leisure', 'Family', 'Couples', 'Solo'],
                    datasets: [{
                        data: [35, 25, 20, 15, 5],
                        backgroundColor: [
                            'rgba(67, 97, 238, 0.7)',
                            'rgba(16, 185, 129, 0.7)',
                            'rgba(245, 158, 11, 0.7)',
                            'rgba(239, 68, 68, 0.7)',
                            'rgba(156, 163, 175, 0.7)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { 
                            position: 'right',
                            labels: {
                                usePointStyle: true,
                                padding: 15
                            }
                        } 
                    }
                }
            });
        }

        // Seasonal Comparison Chart
        const seasonalComparisonCtx = document.getElementById('seasonalComparisonChart');
        if (seasonalComparisonCtx) {
            new Chart(seasonalComparisonCtx, {
                type: 'radar',
                data: {
                    labels: ['Occupancy Rate', 'ADR', 'RevPAR', 'Direct Bookings', 'Guest Satisfaction'],
                    datasets: [
                        {
                            label: 'High Season',
                            data: [90, 850000, 765000, 45, 4.8],
                            backgroundColor: 'rgba(67, 97, 238, 0.2)',
                            borderColor: 'rgba(67, 97, 238, 1)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(67, 97, 238, 1)'
                        },
                        {
                            label: 'Low Season',
                            data: [65, 650000, 422500, 30, 4.5],
                            backgroundColor: 'rgba(16, 185, 129, 0.2)',
                            borderColor: 'rgba(16, 185, 129, 1)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(16, 185, 129, 1)'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        r: {
                            angleLines: { display: true },
                            suggestedMin: 0,
                            ticks: {
                                callback: function(value) {
                                    if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                                    if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(0) + 'K';
                                    return value;
                                },
                                stepSize: 20
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        console.log('All charts initialized successfully!');
    });
</script>
@endpush