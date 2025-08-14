@extends('layouts.adminlte')

@section('title', 'Dashboard Admin')

@section('content')
<style>
    body {
        background-color: #fff5f7;
    }

    .stat-card {
        background: linear-gradient(135deg, #fce4ec, #f8bbd0);
        color: #6b0033;
        border: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15);
    }

    .quick-links a {
        border-color: #f48fb1;
        color: #880e4f;
        flex: 1 1 calc(50% - 10px);
    }

    .quick-links a:hover {
        background-color: #f8bbd0;
        color: #6b0033;
        transform: scale(1.05);
        transition: 0.3s;
    }

    .card-header.bg-white {
        background-color: #fff0f5 !important;
        color: #880e4f;
    }

    .badge.bg-primary,
    .badge.bg-success,
    .badge.bg-info,
    .badge.bg-danger,
    .badge.bg-secondary {
        background-color: #f8bbd0 !important;
        color: #6b0033;
    }

    .badge-status {
        background-color: #96515b !important;
        color: #fff !important;
        padding: 0.4em 0.75em;
        font-size: 0.85rem;
    }

    .breadcrumb-item a {
        color: #d63384;
    }

    canvas {
        background-color: #fffafa;
        border-radius: 8px;
        padding: 5px;
        max-width: 100%;
        height: auto !important;
    }

    /* Mobile optimization */
    @media (max-width: 576px) {
        .stat-card .card-body {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .quick-links a {
            flex: 1 1 100%;
        }
    }
</style>

<div class="content-header py-4 shadow-sm mb-4 rounded" style="background-color: #ffe5ec;">
    <div class="container-fluid">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div>
                <h1 class="m-0 fw-bold text-dark"><i class="fas fa-hotel me-2"></i>Dashboard Admin Hotel Abadi</h1>
                <small class="text-muted">Selamat datang kembali, {{ auth()->user()->name }}!</small>
            </div>
            <!-- <ol class="breadcrumb mt-2 mt-md-0">
                <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol> -->
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        {{-- Statistik --}}
        <div class="row">
            @php
                $stats = [
                    ['label' => 'Total Kamar', 'value' => $stats['totalRooms'], 'icon' => 'bed'],
                    ['label' => 'Tamu Terdaftar', 'value' => $stats['totalGuests'], 'icon' => 'users'],
                    ['label' => 'Booking Hari Ini', 'value' => $stats['bookingsToday'], 'icon' => 'calendar-check'],
                    ['label' => 'Pendapatan Bulan Ini', 'value' => 'Rp ' . number_format($stats['revenueThisMonth'], 0, ',', '.'), 'icon' => 'money-bill-wave'],
                ];
            @endphp

            @foreach($stats as $stat)
            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card stat-card h-100 shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold">{{ $stat['value'] }}</h5>
                            <p class="mb-0">{{ $stat['label'] }}</p>
                        </div>
                        <i class="fas fa-{{ $stat['icon'] }} fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Akses Cepat --}}
        <div class="row quick-links mb-4">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold">
                        <i class="fas fa-bolt me-1 text-pink"></i> Akses Cepat
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
        </div>

        {{-- Grafik + User --}}
        <div class="row mb-4">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white fw-bold">
                        <i class="fas fa-chart-line me-1 text-pink"></i> Statistik Booking Bulanan
                    </div>
                    <div class="card-body" style="height: 300px;">
                        <canvas id="bookingChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white fw-bold">
                        <i class="fas fa-user-plus me-1 text-pink"></i> User Terbaru
                    </div>
                    <div class="card-body p-3">
                        @forelse($recentUsers as $user)
                            <div class="d-flex align-items-center border-bottom py-2">
                                <img src="{{ $user->photo ? asset('storage/photos/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" 
                                     class="rounded-circle me-2" width="40" height="40" alt="foto">
                                <div>
                                    <strong>{{ $user->name }}</strong><br>
                                    <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">Belum ada user baru.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Booking Aktif --}}
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <strong><i class="fas fa-list me-1"></i> Booking Aktif</strong>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i> Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background-color: #fdeff2;">
                            <tr>
                                <th>Nama Tamu</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activeBookings as $booking)
                                <tr>
                                    <td>{{ $booking->guest->name ?? 'N/A' }}</td>
                                    <td>{{ $booking->check_in ? \Carbon\Carbon::parse($booking->check_in)->format('d M Y') : 'N/A' }}</td>
                                    <td>{{ $booking->check_out ? \Carbon\Carbon::parse($booking->check_out)->format('d M Y') : 'N/A' }}</td>
                                    <td>
                                        <span class="badge rounded-pill badge-status">
                                            {{ ucfirst(str_replace('_', ' ', $booking->status ?? 'unknown')) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Tidak ada booking aktif.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Log Aktivitas --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold">
                <i class="fas fa-history text-secondary me-1"></i> Aktivitas Sistem Terakhir
            </div>
            <div class="card-body p-3">
                @forelse($recentLogs as $log)
                    <div class="d-flex justify-content-between border-bottom py-2 flex-wrap">
                        <span><i class="fas fa-info-circle me-2 text-muted"></i>{{ $log->description }}</span>
                        <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                    </div>
                @empty
                    <p class="text-muted">Belum ada log aktivitas.</p>
                @endforelse
            </div>
        </div>

    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('bookingChart').getContext('2d');
    const bookingChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyBookingLabels) !!},
            datasets: [{
                label: 'Jumlah Booking',
                data: {!! json_encode($monthlyBookingCounts) !!},
                backgroundColor: 'rgba(248, 187, 208, 0.3)',
                borderColor: 'rgba(233, 30, 99, 1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
