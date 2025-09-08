@extends('layouts.adminlte')

@section('content')
    <div class="container">
        <h2>Detail Booking #{{ $booking->id }}</h2>

        <div class="card">
            <div class="card-header">
                Booking Information
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td>{{ $booking->id }}</td>
                    </tr>
                    <tr>
                        <th>Guest Name</th>
                        <td>{{ $booking->guest ? $booking->guest->name : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Room Number</th>
                        <td>{{ $booking->room ? $booking->room->number : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Check-In</th>
                        <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('d-m-Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Check-Out</th>
                        <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('d-m-Y H:i') }}</td>
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
                    <tr>
                        <th>Booked By</th>
                        <td>{{ $booking->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ \Carbon\Carbon::parse($booking->created_at)->format('d-m-Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ \Carbon\Carbon::parse($booking->updated_at)->format('d-m-Y H:i') }}</td>
                    </tr>
                </table>

                <div class="d-flex justify-content-between">
                    <a href="{{ route(auth()->user()->role . '.bookings.index') }}" class="btn btn-secondary">Kembali</a>
                    <a href="{{ route(auth()->user()->role . '.bookings.edit', $booking->id) }}" class="btn btn-primary">Edit Booking</a>
                </div>
            </div>
        </div>
    </div>
@endsection
