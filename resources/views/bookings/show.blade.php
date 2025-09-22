@extends('layouts.adminlte')

@section('title', 'Detail Booking #' . $booking->id)

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-lg overflow-hidden">
        <!-- HEADER -->
        <div class="card-header text-white" style="background: #3d3d3d">
            <h4 class="mb-0">
                <i class="fas fa-bed me-2"></i> Detail Booking #{{ $booking->id }}
            </h4>
        </div>

        <!-- BODY -->
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $booking->id }}</td>
                </tr>
                <tr>
                    <th>Nama Tamu</th>
                    <td>{{ $booking->guest ? $booking->guest->name : 'N/A' }}</td>
                </tr>
                <tr>
                    <th>No. Kamar</th>
                    <td>{{ $booking->room ? $booking->room->number : 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Tipe Kamar</th>
                    <td>{{ $booking->room && $booking->room->tipeKamar ? $booking->room->tipeKamar->tipe_kamar : 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Check-In</th>
                    <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <th>Check-Out</th>
                    <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @switch($booking->status)
                            @case('booked')
                                <span class="badge bg-warning">Booked</span>
                                @break
                            @case('checked_in')
                                <span class="badge bg-info">Checked In</span>
                                @break
                            @case('checked_out')
                                <span class="badge bg-success">Checked Out</span>
                                @break
                            @case('canceled')
                                <span class="badge bg-danger">Canceled</span>
                                @break
                            @case('paid')
                                <span class="badge bg-primary">Paid</span>
                                @break
                            @default
                                <span class="badge bg-secondary">Unknown</span>
                        @endswitch
                    </td>
                </tr>

                <!-- Fasilitas Tambahan -->
                <tr>
                    <th>Fasilitas Tambahan</th>
                    <td>
                        @if($booking->facilities->isNotEmpty())
                            <ul class="list-unstyled mb-0">
                                @foreach($booking->facilities as $facility)
                                    <li>
                                        {{ $facility->name }} - 
                                        Rp {{ number_format($facility->pivot->price, 0, ',', '.') }}/malam
                                        @if(isset($facility->pivot->start_date) && isset($facility->pivot->end_date))
                                            <br>
                                            <small class="text-muted">
                                                ({{ \Carbon\Carbon::parse($facility->pivot->start_date)->format('d/m/Y') }} 
                                                - {{ \Carbon\Carbon::parse($facility->pivot->end_date)->format('d/m/Y') }})
                                            </small>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-muted">Tidak ada fasilitas tambahan</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Booked By</th>
                    <td>{{ $booking->user->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Dibuat Pada</th>
                    <td>{{ \Carbon\Carbon::parse($booking->created_at)->format('d-m-Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Diperbarui Pada</th>
                    <td>{{ \Carbon\Carbon::parse($booking->updated_at)->format('d-m-Y H:i') }}</td>
                </tr>
            </table>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route(auth()->user()->role . '.bookings.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <a href="{{ route(auth()->user()->role . '.bookings.edit', $booking->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit Booking
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .badge {
        font-size: 0.9rem;
        padding: 0.45em 0.8em;
        border-radius: 1rem;
    }
</style>
@endsection
