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

    {{-- Grafik Pendapatan Bulanan --}}
    <div class="card mb-4 shadow-soft rounded-4 border-0">
        <div class="card-header bg-pink-soft border-0">
            <h5 class="fw-semibold text-pink-soft mb-0"><i class="bi bi-bar-chart-line me-2"></i> Statistik Bulanan - {{ now()->year }}</h5>
        </div>
        <div class="card-body bg-white">
            <canvas id="monthlyChart" height="100"></canvas>
        </div>
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
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($totals) !!},
                backgroundColor: '#f06292',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
