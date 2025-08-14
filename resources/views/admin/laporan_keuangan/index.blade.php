@extends('layouts.adminlte')

@section('title', 'Laporan Keuangan')

@section('content')
<style>
    .bg-pink-soft {
        background-color: #fce4ec !important;
    }
    .text-pink-soft {
        color: #d81b60 !important;
    }
    .border-pink-soft {
        border-left: 5px solid #ec407a !important;
    }
    .badge-method {
        background-color: #f06292 !important;
        color: white;
    }
    .shadow-soft {
        box-shadow: 0 4px 8px rgba(236, 64, 122, 0.2) !important;
    }
</style>

<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-pink-soft"><i class="bi bi-cash-coin me-2"></i> Laporan Keuangan</h2>
        <a href="{{ route('admin.laporan_keuangan.cetak') }}" class="btn btn-outline-danger">
            <i class="bi bi-file-earmark-pdf me-2"></i> Cetak PDF
        </a>
    </div>

    {{-- Ringkasan Total Pendapatan --}}
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6">
            <div class="card bg-white border-0 shadow-soft border-pink-soft rounded-4">
                <div class="card-body">
                    <h6 class="text-muted">Total Pendapatan</h6>
                    <h3 class="text-pink-soft fw-bold mt-2">
                        Rp{{ number_format($totalPendapatan, 0, ',', '.') }}
                    </h3>
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
                'bg' => 'linear-gradient(135deg, #f3e5f5, #e1bee7)',
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
                'bg' => 'linear-gradient(135deg, #e8f5e9, #c8e6c9)'
            ],
            [
                'label' => 'Target Bulanan', 
                'value' => 'Rp' . number_format($monthlyTarget ?? 0, 0, ',', '.'), 
                'icon' => 'bullseye',
                'bg' => 'linear-gradient(135deg, #e3f2fd, #bbdefb)',
                'progress' => isset($currentMonthRevenue, $monthlyTarget) 
                    ? min(100, ($currentMonthRevenue/$monthlyTarget)*100) 
                    : 0
            ],
        ];
    @endphp

    @foreach($monthlyStats as $stat)
    <div class="col-lg-3 col-md-6 mb-4">
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
                
                @isset($stat['progress'])
                <div class="mt-3">
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-primary" role="progressbar" 
                             style="width: {{ $stat['progress'] }}%" 
                             aria-valuenow="{{ $stat['progress'] }}" 
                             aria-valuemin="0" 
                             aria-valuemax="100">
                        </div>
                    </div>
                    <small class="text-muted">{{ number_format($stat['progress'], 1) }}% tercapai</small>
                </div>
                @endisset
            </div>
        </div>
    </div>
    @endforeach
</div>

    {{-- Tabel Riwayat Pembayaran --}}
    <div class="card shadow-soft border-0 rounded-4">
        <div class="card-header bg-pink-soft border-0 d-flex justify-content-between align-items-center">
            <h5 class="fw-semibold text-pink-soft mb-0"><i class="bi bi-clock-history me-2"></i> Riwayat Pembayaran</h5>
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
                            <td>{{ $key + 1 }}</td>
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
                    backgroundColor: '#f06292',
                    borderRadius: 8,
                    borderColor: '#ec407a',
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