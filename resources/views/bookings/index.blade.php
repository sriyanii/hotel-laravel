@extends('layouts.adminlte')

@section('title', 'Daftar Booking')

@section('content')
<div class="container py-4">
    <div class="card shadow rounded-4 border-0">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold text-primary">
                <i class="fas fa-bed me-2"></i>Data Booking
            </h4>
            <a href="{{ route(auth()->user()->role . '.bookings.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Booking
            </a>
        </div>
        <div class="card-body table-responsive">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tamu</th>
                        <th>No. Telepon</th>
                        <th>No. Identitas</th>
                        <th>Kamar</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Status</th>
                        <th>Total Harga</th>
                        <th>Dibuat Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $index => $booking)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $booking->guest->name ?? '-' }}</td>
                            <td>{{ $booking->guest->phone ?? '-' }}</td>
                            <td>{{ $booking->guest->identity_number ?? '-' }}</td>
                            <td>
                                {{ $booking->room->number ?? '-' }}
                                (Rp{{ number_format($booking->room->price ?? 0, 0, ',', '.') }}/malam)
                            </td>
                            <td>{{ $booking->check_in }}</td>
                            <td>{{ $booking->check_out }}</td>
                            <td>
                                <span class="badge 
                                    {{ $booking->status == 'booked' ? 'bg-warning' : '' }}
                                    {{ $booking->status == 'check-in' ? 'bg-success' : '' }}
                                    {{ $booking->status == 'cancelled' ? 'bg-danger' : '' }}
                                ">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td>
                                @if($booking->total_price > 0)
                                    Rp{{ number_format($booking->total_price, 0, ',', '.') }}
                                    <small class="text-muted">({{ $booking->check_out->diffInDays($booking->check_in) }} malam)</small>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $booking->user->name ?? '-' }}</td>
                            <td>
                                <a href="{{ route(auth()->user()->role . '.bookings.edit', $booking->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route(auth()->user()->role . '.bookings.destroy', $booking->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if($bookings->isEmpty())
                        <tr>
                            <td colspan="11" class="text-center text-muted">Tidak ada data booking.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection