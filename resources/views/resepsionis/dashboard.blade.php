@extends('layouts.adminlte')

@section('title', 'Dashboard Resepsionis')

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

    .card-header.bg-white {
        background-color: #fff0f5 !important;
        color: #880e4f;
    }

    .badge {
        background-color: #f8bbd0 !important;
        color: #6b0033;
    }

    .breadcrumb-item a {
        color: #d63384;
    }
</style>

<div class="content-header py-4 shadow-sm mb-4 rounded" style="background-color: #ffe5ec;">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="m-0 fw-bold text-dark"><i class="fas fa-hotel me-2"></i>Dashboard Resepsionis</h1>
                <small class="text-muted">Selamat datang kembali, {{ auth()->user()->name }}!</small>
            </div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        {{-- Kartu Statistik --}}
        <div class="row">
            @php
                $cards = [
                    ['label' => 'Total Kamar', 'value' => $totalRooms, 'icon' => 'bed'],
                    ['label' => 'Kamar Tersedia', 'value' => $availableRooms, 'icon' => 'door-open'],
                    ['label' => 'Total Tamu', 'value' => $totalGuests, 'icon' => 'users'],
                    ['label' => 'Booking Hari Ini', 'value' => $bookingsToday, 'icon' => 'calendar-day'],
                ];
            @endphp

            @foreach ($cards as $card)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card stat-card h-100 shadow-sm">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="fw-bold">{{ $card['value'] }}</h5>
                                <p class="mb-0">{{ $card['label'] }}</p>
                            </div>
                            <i class="fas fa-{{ $card['icon'] }} fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Check-in & Check-out --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold">
                        <i class="fas fa-sign-in-alt me-1"></i> Check-in Hari Ini
                    </div>
                    <div class="card-body">
                        @forelse ($checkInsToday->take(5) as $booking)
                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                <span>{{ optional($booking->guest)->name }}</span>
                                <span class="badge">Kamar {{ optional($booking->room)->room_number }}</span>
                            </div>
                        @empty
                            <p class="text-muted">Tidak ada tamu check-in.</p>
                        @endforelse
                        @if ($checkInsToday->count() > 5)
                            <p class="text-muted small mt-2 text-end">+{{ $checkInsToday->count() - 5 }} lainnya</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold">
                        <i class="fas fa-sign-out-alt me-1"></i> Check-out Hari Ini
                    </div>
                    <div class="card-body">
                        @forelse ($checkOutsToday->take(5) as $booking)
                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                <span>{{ optional($booking->guest)->name }}</span>
                                <span class="badge">Kamar {{ optional($booking->room)->room_number }}</span>
                            </div>
                        @empty
                            <p class="text-muted">Tidak ada tamu check-out.</p>
                        @endforelse
                        @if ($checkOutsToday->count() > 5)
                            <p class="text-muted small mt-2 text-end">+{{ $checkOutsToday->count() - 5 }} lainnya</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Booking Terbaru --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <strong><i class="fas fa-history me-1"></i> Booking Terbaru</strong>
                <a href="{{ route('resepsionis.bookings.index') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-eye"></i> Lihat Semua
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background-color: #fdeff2;">
                            <tr>
                                <th>Nama Tamu</th>
                                <th>Kamar</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentBookings as $booking)
                                <tr>
                                    <td>{{ optional($booking->guest)->name }}</td>
                                    <td>{{ optional($booking->room)->room_number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</td>
                                    <td><span class="badge">{{ ucfirst(str_replace('_', ' ', $booking->status)) }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted">Tidak ada booking terbaru.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Footer Info --}}
        <div class="text-end mt-3 text-muted small">
            Terakhir diperbarui: {{ now()->translatedFormat('d M Y H:i') }}
        </div>

    </div>
</section>
@endsection
