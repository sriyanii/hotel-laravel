@extends('layouts.adminlte')
@section('title', 'Daftar Booking')
@section('content')
<div class="container py-4" style="background-color: #FAF6F0;">
    <div class="card shadow-sm border-0 rounded-lg overflow-hidden" style="border-top: 4px solid #C9A227;">
        <!-- HEADER -->
        <div class="card-header bg-gradient-gold text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0" style="color: #4E342E;">
                <i class="fas fa-bed me-2"></i> Daftar Booking
            </h4>
            <a href="{{ route(auth()->user()->role . '.bookings.create') }}" class="btn btn-light text-gold fw-semibold">
                <i class="fas fa-plus me-1"></i> Tambah Booking
            </a>
        </div>

        <!-- BODY -->
        <div class="card-body" style="background-color: #fff;">
            @if(session('success'))
                <div class="alert alert-success rounded-pill px-4 py-2 mb-4" style="border-left: 4px solid #4E342E;">
                    <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            <h6 class="mb-3 fw-bold" style="color: #4E342E;">
                <i class="fas fa-list me-2"></i> List Booking Kamar
            </h6>

            @if($bookings->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="fa-solid fa-bed-empty fa-2x mb-3"></i><br>
                    Belum ada booking.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-light" style="background-color: #f5f5f5;">
                            <tr>
                                <th style="color: #4E342E;">No</th>
                                <th style="color: #4E342E;">Nama Tamu</th>
                                <th style="color: #4E342E;">Kamar</th>
                                <th style="color: #4E342E;">Durasi</th>
                                <th style="color: #4E342E;">Harga Permalam</th>
                                <th style="color: #4E342E;">Status</th>
                                <th style="color: #4E342E;">Petugas</th>
                                <th style="color: #4E342E;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $booking->guest->name }}</td>
                                    <td>
                                        <span class="badge bg-soft-gold">
                                            Kamar {{ $booking->room->number }} - {{ $booking->room->type }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($booking->check_in)->format('d/m/Y') }}<br>
                                        <small class="text-muted">→</small><br>
                                        {{ \Carbon\Carbon::parse($booking->check_out)->format('d/m/Y') }}
                                        <div class="text-muted mt-1">
                                            ({{ \Carbon\Carbon::parse($booking->check_out)->diffInDays($booking->check_in) }} malam)
                                        </div>
                                    </td>
                                    <td>
                                        Rp {{ number_format($booking->room->price ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        @php
                                            $badge = [
                                                'booked' => 'warning',
                                                'checked_in' => 'success',
                                                'checked_out' => 'secondary',
                                                'canceled' => 'danger',
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $badge[$booking->status] ?? 'dark' }}">
                                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $booking->user->name }}</td>
                                    <td class="text-center">
                                        <a href="{{ route(auth()->user()->role . '.bookings.edit', $booking->id) }}"
                                           class="btn btn-warning btn-sm me-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route(auth()->user()->role . '.bookings.destroy', $booking->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus booking ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
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

<style>
    .bg-gradient-gold {
        background: linear-gradient(90deg, #C9A227, #FFD700);
    }
    .text-gold {
        color: #C9A227 !important;
    }
    .bg-soft-gold {
        background-color: #FFF8E1;
        color: #4E342E;
    }
    .btn-light.text-gold:hover {
        background-color: #C9A227 !important;
        color: white !important;
    }
    .badge {
        font-size: 0.9rem;
        padding: 0.45em 0.8em;
        border-radius: 1rem;
    }
    .table th, .table td {
        vertical-align: middle;
    }
    .card {
        box-shadow: 0 4px 12px rgba(78, 52, 46, 0.1);
    }
    .table-light {
        background-color: #f9f9f9;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(201, 162, 39, 0.05);
    }
    .alert-success {
        background-color: #f6ffed;
        border-color: #b7eb8f;
    }
</style>
@endsection