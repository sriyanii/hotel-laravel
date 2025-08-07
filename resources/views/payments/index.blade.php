@extends('layouts.adminlte')

@section('content')
@php
    $role = auth()->user()->role;
@endphp

<div class="container py-4">
    <div class="card shadow-sm border-0">

        {{-- HEADER --}}
        <div class="card-header bg-pink-gradient text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="fas fa-money-bill-wave me-2"></i> Data Transaksi Pembayaran
            </h4>
            <a href="{{ route($role . '.payments.create') }}" class="btn btn-light text-pink fw-semibold">
                <i class="fas fa-plus me-1"></i> Tambah Transaksi
            </a>
        </div>

        {{-- BODY --}}
        <div class="card-body">
            {{-- Notifikasi --}}
            @if (session('success'))
                <div class="alert alert-success rounded-pill px-4 py-2 mb-4">
                    <i class="fa-solid fa-check-circle me-1"></i> {{ session('success') }}
                </div>
            @endif

            {{-- List --}}
            <h5 class="mb-3 text-secondary fw-bold">
                <i class="fas fa-list me-2"></i>List Pembayaran Terbaru
            </h5>

            @if ($payments->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="fa-solid fa-face-sad-tear fa-2x mb-3"></i><br>
                    Belum ada transaksi pembayaran.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>ID Booking</th>
                                <th>Jumlah</th>
                                <th>Tanggal Bayar</th>
                                <th>Metode</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $payment->booking_id }}</span>
                                    </td>
                                    <td><strong>Rp{{ number_format($payment->amount, 0, ',', '.') }}</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($payment->paid_at)->format('d-m-Y') }}</td>
                                    <td>
                                        <span class="badge bg-soft-pink text-dark text-capitalize">
                                            <i class="fa-solid fa-wallet me-1"></i>{{ $payment->method }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route($role . '.payments.edit', $payment->id) }}" class="btn btn-warning btn-sm me-1">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route($role . '.payments.destroy', $payment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
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

{{-- Custom Styles --}}
<style>
    .bg-pink-gradient {
        background: linear-gradient(90deg, #f8bbd0, #f48fb1);
    }

    .text-pink {
        color: #d63384 !important;
    }

    .bg-soft-pink {
        background-color: #ffe2ec;
    }

    .btn-light.text-pink:hover {
        background-color: #f1a5c3 !important;
        color: white !important;
    }

    .table th, .table td {
        vertical-align: middle;
    }

    .badge {
        font-size: 0.9rem;
        padding: 0.45em 0.8em;
        border-radius: 1rem;
    }
</style>
@endsection
