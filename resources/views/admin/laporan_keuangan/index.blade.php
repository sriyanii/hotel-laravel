@extends('layouts.adminlte')

@section('title', 'Laporan Keuangan')

@section('content')
<style>
    :root {
        --gold-primary: #C9A227;
        --gold-light: #FFD700;
        --cream-bg: #FAF6F0;
        --dark-brown: #4E342E;
        --dark-secondary: #3E2723;
    }

    body {
        background-color: var(--cream-bg);
    }

    .bg-primary-soft {
        background-color: rgba(201, 162, 39, 0.1) !important;
    }

    .text-primary {
        color: var(--dark-brown) !important;
    }

    .text-primary-soft {
        color: var(--gold-primary) !important;
    }

    .border-primary-soft {
        border-left: 5px solid var(--gold-primary) !important;
    }

    .badge-method {
        background-color: var(--gold-primary) !important;
        color: white;
    }

    .shadow-soft {
        box-shadow: 0 4px 8px rgba(201, 162, 39, 0.2) !important;
    }

    .btn-outline-danger {
        border-color: var(--gold-primary);
        color: var(--dark-brown);
    }

    .btn-outline-danger:hover {
        background-color: var(--gold-primary);
        color: white;
    }

    .stat-card {
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }
</style>

<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary"><i class="bi bi-cash-coin me-2"></i> Laporan Keuangan</h2>
        <a href="{{ route('admin.laporan_keuangan.cetak') }}" class="btn btn-outline-danger">
            <i class="bi bi-file-earmark-pdf me-2"></i> Cetak PDF
        </a>
    </div>

    {{-- Total Pendapatan & Target Bulanan side by side --}}
    <div class="row mb-4">
        <div class="col-lg-6 col-md-6 mb-3">
            <div class="card bg-white border-0 shadow-soft border-primary-soft rounded-4 stat-card h-100">
                <div class="card-body">
                    <h6 class="text-muted">Total Pendapatan</h6>
                    <h3 class="text-primary fw-bold mt-2">
                        Rp{{ number_format($totalPendapatan, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 mb-3">
            <div class="card stat-card h-100 shadow-soft" style="background: linear-gradient(135deg, #e3f2fd, #bbdefb); border-radius:12px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h5 class="fw-bold mb-1">
                                Rp{{ number_format($monthlyTarget ?? 0, 0, ',', '.') }}
                            </h5>
                            <p class="mb-1">Target Bulanan</p>
                        </div>
                        <i class="fas fa-bullseye fa-2x opacity-75"></i>
                    </div>
                    <div class="mt-3">
                        @php
                            $progress = isset($currentMonthRevenue, $monthlyTarget) && $monthlyTarget > 0 
                                ? min(100, ($currentMonthRevenue / $monthlyTarget) * 100) 
                                : 0;
                        @endphp
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-primary" role="progressbar" 
                                style="width: {{ $progress }}%" 
                                aria-valuenow="{{ $progress }}" 
                                aria-valuemin="0" 
                                aria-valuemax="100">
                            </div>
                        </div>
                        <small class="text-muted">{{ number_format($progress, 1) }}% tercapai</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistik Pendapatan Perbulan --}}
    <div class="row mb-4">
        @php
            $monthlyStats = [
                [
                    'label' => 'Pendapatan Bulan Ini', 
                    'value' => isset($currentMonthRevenue) ? 'Rp' . number_format($currentMonthRevenue, 0, ',', '.') : 'Rp0', 
                    'icon' => 'calendar-day',
                    'bg' => 'linear-gradient(135deg, #faf6f0, #f0e6cc)',
                    'change' => $monthlyGrowthRate ?? 0
                ],
                [
                    'label' => 'Bulan Terbaik', 
                    'value' => isset($bestMonth) ? $bestMonth['month'] . ' (' . 'Rp' . number_format($bestMonth['revenue'], 0, ',', '.') . ')' : 'Belum ada data', 
                    'icon' => 'trophy',
                    'bg' => 'linear-gradient(135deg, #fff8e1, #ffecb3)'
                ],
                [
                    'label' => 'Rata-rata Perbulan', 
                    'value' => isset($averageMonthlyRevenue) ? 'Rp' . number_format($averageMonthlyRevenue, 0, ',', '.') : 'Rp0', 
                    'icon' => 'chart-line',
                    'bg' => 'linear-gradient(135deg, #f5f5f5, #e0e0e0)'
                ]
            ];
        @endphp

        @foreach($monthlyStats as $stat)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card stat-card h-100 shadow-sm" style="background: {{ $stat['bg'] }};">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h5 class="fw-bold mb-1">{{ $stat['value'] }}</h5>
                            <p class="mb-1">{{ $stat['label'] }}</p>
                        </div>
                        <i class="fas fa-{{ $stat['icon'] }} fa-2x opacity-75"></i>
                    </div>
                    
                    @isset($stat['change'])
                    <div class="mt-2">
                        <span class="badge {{ $stat['change'] >= 0 ? 'bg-success' : 'bg-danger' }} rounded-pill">
                            <i class="fas fa-arrow-{{ $stat['change'] >= 0 ? 'up' : 'down' }} me-1"></i>
                            {{ number_format(abs($stat['change']), 1) }}% {{ $stat['change'] >= 0 ? 'Naik' : 'Turun' }}
                        </span>
                        <small class="text-muted ms-2">vs bulan lalu</small>
                    </div>
                    @endisset
                </div>
            </div>
        </div>
        @endforeach
    </div>

   
    {{-- Tabel Riwayat Pembayaran --}}
    <div class="card shadow-soft border-0 rounded-4">
        <div class="card-header bg-primary-soft border-0 d-flex justify-content-between align-items-center">
            <h5 class="fw-semibold text-primary mb-0"><i class="bi bi-clock-history me-2"></i> Riwayat Pembayaran</h5>
        </div>
        <div class="card-body bg-white table-responsive">
            <table class="table table-hover table-bordered align-middle mb-0">
                <thead class="table-light text-center">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Nama Tamu</th>
                        <th>No. Kamar</th>
                        <th>Total Bayar</th>
                        <th>Tanggal</th>
                        <th>Metode</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse ($payments as $key => $payment)
                        <tr>
                            <td>{{ $payments->firstItem() + $key }}</td>
                            <td>{{ $payment->booking->guest->name ?? '-' }}</td>
                            <td>{{ $payment->booking->room->number ?? '-' }}</td>
                            <td class="text-end">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->paid_at)->format('d-m-Y') }}</td>
                            <td>
                                <span class="badge badge-method text-uppercase">
                                    <i class="bi bi-credit-card-2-back me-1"></i>{{ $payment->method }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-muted">Belum ada data pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            @if($payments->hasPages())
                <div class="d-flex justify-content-end my-4" style="margin-right: 30px;">
                    {{ $payments->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('monthlyChart').getContext('2d');
        const monthlyChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($months ?? []) !!},
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: {!! json_encode($totals ?? []) !!},
                    backgroundColor: 'rgba(201, 162, 39, 0.7)',
                    borderRadius: 8,
                    borderColor: 'rgba(201, 162, 39, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp' + value.toLocaleString('id-ID');
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
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
    });
</script>
@endpush
