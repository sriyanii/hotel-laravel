@extends('layouts.adminlte')

@section('title', 'Dashboard Resepsionis')

@section('content')
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
    
    .receptionist-dashboard {
        font-family: 'Poppins', sans-serif;
        background-color: #f5f7fb;
        color: var(--dark);
    }
    
    /* Header Styling */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding: 20px 0;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .dashboard-header h2 {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0;
    }
    
    /* Quick Actions */
    .quick-actions {
        display: flex;
        gap: 15px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }
    
    .quick-action-btn {
        flex: 1;
        min-width: 200px;
        background: white;
        border: none;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: all 0.3s;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        display: block;
    }
    
    .quick-action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        color: inherit;
        text-decoration: none;
    }
    
    .quick-action-btn i {
        font-size: 28px;
        margin-bottom: 10px;
        color: var(--primary);
        display: block;
    }
    
    .quick-action-btn h5 {
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .quick-action-btn .text-muted {
        font-size: 0.9rem;
    }
    
    /* Cards Styling */
    .dashboard-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        padding: 25px;
        margin-bottom: 30px;
        border: none;
    }
    
    .dashboard-card .card-header {
        background: transparent;
        border-bottom: 1px solid #f3f4f6;
        padding: 0 0 15px 0;
        margin-bottom: 15px;
    }
    
    .dashboard-card h4 {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0;
    }
    
    /* Schedule Items */
    .schedule-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #f3f4f6;
    }
    
    .schedule-item:last-child {
        border-bottom: none;
    }
    
    .room-status {
        display: inline-block;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 10px;
    }
    
    .status-available {
        background-color: var(--success);
    }
    
    .status-occupied {
        background-color: var(--danger);
    }
    
    .status-cleaning {
        background-color: var(--warning);
    }
    
    /* Guest Items */
    .guest-item {
        display: flex;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f3f4f6;
    }
    
    .guest-item:last-child {
        border-bottom: none;
    }
    
    .guest-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 15px;
        background: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
    }
    
    /* Table Styling */
    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
    }
    
    .table th {
        background-color: #f8fafc;
        font-weight: 600;
        border-bottom: 2px solid #e5e7eb;
    }
    
    /* Badge Styling */
    .badge-status {
        padding: 0.5em 0.75em;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    /* Stat Cards */
    .stat-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border: none;
        transition: transform 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
    }
    
    .stat-card i {
        font-size: 2rem;
        color: var(--primary);
        margin-bottom: 10px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .quick-actions {
            flex-direction: column;
        }
        
        .quick-action-btn {
            min-width: 100%;
        }
        
        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
    }
</style>

<div class="content receptionist-dashboard">
    <div class="container-fluid">

        <!-- Header -->
        <div class="dashboard-header">
            <h2><i class="fas fa-tachometer-alt me-2"></i>Receptionist Dashboard</h2>
            <div class="user-menu">
                                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ auth()->user()->photo ? asset('image/' . auth()->user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" alt="User">
                        <span class="ms-2 d-none d-sm-inline">{{ auth()->user()->name }}</span>
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

        <!-- Quick Actions -->
        <div class="quick-actions">
            <a href="{{ url('/resepsionis/checkin') }}" class="quick-action-btn">
                <i class="fas fa-check-circle"></i>
                <h5>Check In</h5>
                <p class="text-muted">{{ $checkInsToday->count() }} pending</p>
            </a>
            <a href="{{ url('/resepsionis/checkout') }}" class="quick-action-btn">
                <i class="fas fa-door-open"></i>
                <h5>Check Out</h5>
                <p class="text-muted">{{ $checkOutsToday->count() }} today</p>
            </a>
            <a href="{{ url('/resepsionis/bookings/create') }}" class="quick-action-btn">
                <i class="fas fa-plus-circle"></i>
                <h5>New Booking</h5>
                <p class="text-muted">Walk-in guest</p>
            </a>
            <a href="{{ url('/resepsionis/rooms') }}" class="quick-action-btn">
                <i class="fas fa-bed"></i>
                <h5>Room Status</h5>
                <p class="text-muted">{{ $totalRooms - $availableRooms }} unavailable</p>
            </a>
        </div>

        <!-- Today's Schedule & Current Guests -->
        <div class="row">
            <!-- Check-in Hari Ini -->
            <div class="col-md-6">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-sign-in-alt me-2"></i>Check-in Hari Ini</h4>
                    </div>
                    
                    @forelse($checkInsToday->take(5) as $booking)
                    <div class="schedule-item">
                        <div>
                            <span class="room-status status-occupied"></span>
                            <strong>{{ $booking->guest->name ?? 'N/A' }}</strong>
                            <p class="text-muted mb-0">Kamar {{ $booking->room->room_number ?? 'N/A' }}</p>
                        </div>
                        <button class="btn btn-sm btn-outline-primary">Process</button>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-calendar-times fa-2x mb-2"></i>
                        <p>Tidak ada check-in hari ini</p>
                    </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Check-out Hari Ini -->
            <div class="col-md-6">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-sign-out-alt me-2"></i>Check-out Hari Ini</h4>
                    </div>
                    
                    @forelse($checkOutsToday->take(5) as $booking)
                    <div class="schedule-item">
                        <div>
                            <span class="room-status status-occupied"></span>
                            <strong>{{ $booking->guest->name ?? 'N/A' }}</strong>
                            <p class="text-muted mb-0">Kamar {{ $booking->room->room_number ?? 'N/A' }}</p>
                        </div>
                        <button class="btn btn-sm btn-outline-primary">Process</button>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-calendar-times fa-2x mb-2"></i>
                        <p>Tidak ada check-out hari ini</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- Recent Bookings -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Booking Terbaru</h4>
                        <a href="{{ url('/resepsionis/bookings/create') }}" class="btn btn-sm btn-primary">New Booking</a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID Booking</th>
                                    <th>Tamu</th>
                                    <th>Kamar</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentBookings as $booking)
                                <tr>
                                    <td>#{{ $booking->id }}</td>
                                    <td>{{ $booking->guest->name ?? 'N/A' }}</td>
                                    <td>{{ $booking->room->room_number ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'confirmed' => 'success',
                                                'checked_in' => 'primary',
                                                'checked_out' => 'secondary',
                                                'cancelled' => 'danger',
                                                'pending' => 'warning'
                                            ];
                                            $color = $statusColors[$booking->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $color }} badge-status">
                                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ url('/resepsionis/bookings/' . $booking->id) }}" class="btn btn-sm btn-outline-primary">Details</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-calendar-times fa-2x mb-2"></i>
                                        <p>Tidak ada booking terbaru</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="text-end mt-3 text-muted small">
            Terakhir diperbarui: {{ now()->translatedFormat('d M Y H:i') }}
        </div>

    </div>
</div>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection