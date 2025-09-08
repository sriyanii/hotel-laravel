@extends('layouts.adminlte')
@section('title', 'Daftar Booking')
@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-lg overflow-hidden">
        <!-- HEADER -->
        <div class="card-header text-white d-flex justify-content-between align-items-center " style="background: #3d3d3d">
            <h4 class="mb-0">
                <i class="fas fa-bed me-2"></i> Daftar Booking
            </h4>
            <a href="{{ route(auth()->user()->role . '.bookings.create') }}" class="btn btn-light text-dark fw-semibold">
                <i class="fas fa-plus me-1"></i> Tambah Booking
            </a>
        </div>

        <!-- BODY -->
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success rounded-pill px-4 py-2 mb-4">
                    <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            {{-- Pencarian --}}
            <form action="{{ route(auth()->user()->role . '.bookings.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" value="{{ request()->search }}" class="form-control" placeholder="Cari Nama Tamu atau Kamar" aria-label="Search Booking">
                    <button type="submit" class="btn btn-outline-secondary">
                        <i class="fas fa-search"></i>
                    </button>
                    {{-- Tombol Reset --}}
                    <a href="{{ route(auth()->user()->role . '.bookings.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>

            <h6 class="mb-3 text-secondary fw-bold">
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
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Tamu</th>
                                <th>Kamar</th>
                                <th>Durasi</th>
                                <th>Harga Permalam</th>
                                <th>Status</th>
                                <th>Petugas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $booking->guest->name }}</td>
                                    <td>
                                        <span class="badge bg-soft-pink text-dark">
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
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route(auth()->user()->role . '.bookings.edit', $booking->id) }}"
                                            class="btn btn-sm btn-outline-warning rounded-circle" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route(auth()->user()->role . '.bookings.show', $booking->id) }}"
                                            class="btn btn-sm btn-outline-info rounded-circle" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route(auth()->user()->role . '.bookings.destroy', $booking->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus booking ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger rounded-circle" title="Hapus">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- PAGINATION --}}
            @if($bookings->hasPages())
                <div class="d-flex justify-content-end my-4" style="margin-right: 30px;">
                    {{ $bookings->appends(request()->query())->links() }}
                </div>
            @endif

        </div>
    </div>
</div>

<!-- Pastikan style pink juga tersedia -->
<style>
    .text-pink {
        color:rgb(78, 77, 78) !important;
    }
    .bg-soft-pink {
        background-color:rgb(173, 173, 173);
    }
    .btn-light.text-pink:hover {
        background-color:rgb(134, 133, 134) !important;
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
</style>
@endsection
