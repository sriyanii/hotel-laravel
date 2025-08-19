@extends('layouts.adminlte')
@section('title', isset($booking) ? 'Edit Booking' : 'Tambah Booking')
@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-lg overflow-hidden">
        <!-- HEADER -->
        <div class="card-header text-white" style="background: #3d3d3d">
            <h4 class="mb-0">
                <i class="fas fa-bed me-2"></i>
                {{ isset($booking) ? 'Edit Booking' : 'Tambah Booking Baru' }}
            </h4>
        </div>

        <!-- BODY -->
        <div class="card-body">
            <form action="{{ isset($booking) ? route(auth()->user()->role . '.bookings.update', $booking->id) : route(auth()->user()->role . '.bookings.store') }}" method="POST">
                @csrf
                @if(isset($booking))
                    @method('PUT')
                @endif

                <!-- Guest Selection -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="guest_id" class="form-label fw-semibold text-dark">Pilih Tamu</label>
                        <select name="guest_id" id="guest_id" class="form-select @error('guest_id') is-invalid @enderror">
                            <option value="">-- Pilih Tamu --</option>
                            @foreach($guests as $guest)
                                @if(!$guest->hasActiveBooking())
                                    <option value="{{ $guest->id }}" {{ old('guest_id', $booking->guest_id ?? '') == $guest->id ? 'selected' : '' }}>
                                        {{ $guest->name }} ({{ $guest->phone }})
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('guest_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Hanya menampilkan tamu yang tidak memiliki booking aktif</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Atau Tambah Tamu Baru</label>
                        <div class="input-group">
                            <input type="text" name="new_guest_name" class="form-control @error('new_guest_name') is-invalid @enderror" placeholder="Nama Tamu" value="{{ old('new_guest_name') }}">
                            <input type="text" name="new_guest_phone" class="form-control @error('new_guest_phone') is-invalid @enderror" placeholder="No. Telepon" value="{{ old('new_guest_phone') }}">
                            <input type="text" name="new_guest_identity" class="form-control @error('new_guest_identity') is-invalid @enderror" placeholder="No. Identitas" value="{{ old('new_guest_identity') }}">
                        </div>
                        @error('new_guest_name', 'new_guest_phone', 'new_guest_identity')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Rest of your form remains the same -->
                <!-- Room Selection -->
                <div class="mb-3">
                    <label for="room_id" class="form-label fw-semibold text-dark">Pilih Kamar</label>
                    <select name="room_id" id="room_id" class="form-select @error('room_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kamar --</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}"
                                data-price="{{ $room->price }}"
                                {{ old('room_id', $booking->room_id ?? '') == $room->id ? 'selected' : '' }}
                                @if(isset($booking) && $booking->room_id == $room->id) 
                                    style="font-weight: bold; background-color: #f0f8ff;"
                                @endif>
                                Kamar {{ $room->number }} - {{ $room->type }} (Rp {{ number_format($room->price) }})
                                @if(isset($booking) && $booking->room_id == $room->id)
                                    (Kamar saat ini)
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('room_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Hanya kamar yang tersedia yang ditampilkan</div>
                </div>

                <!-- Date Selection -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="check_in" class="form-label fw-semibold text-dark">Check In</label>
                        <input type="date" name="check_in" id="check_in" class="form-control @error('check_in') is-invalid @enderror" 
                               value="{{ old('check_in', isset($booking) ? $booking->check_in->format('Y-m-d') : '') }}" required />
                        @error('check_in')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="check_out" class="form-label fw-semibold text-dark">Check Out</label>
                        <input type="date" name="check_out" id="check_out" class="form-control @error('check_out') is-invalid @enderror" 
                               value="{{ old('check_out', isset($booking) ? $booking->check_out->format('Y-m-d') : '') }}" required />
                        @error('check_out')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Status Selection -->
                <div class="mb-3">
                    <label for="status" class="form-label fw-semibold text-dark">Status Booking</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        @foreach(['booked' => 'Booked', 'checked_in' => 'Check In', 'checked_out' => 'Check Out', 'canceled' => 'Dibatalkan'] as $value => $label)
                            <option value="{{ $value }}" {{ old('status', $booking->status ?? 'booked') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route(auth()->user()->role . '.bookings.index') }}" class="btn btn-secondary px-3">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn text-white px-4" style="background: #3d3d3d">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-pink-gradient {
        background: linear-gradient(90deg, #f8bbd0, #f48fb1);
    }
    .text-pink {
        color: #d63384 !important;
    }
    .btn-pink-gradient {
        background: linear-gradient(90deg, #ec407a, #d81b60);
        border: none;
        color: white;
        font-weight: bold;
    }
    .btn-pink-gradient:hover {
        background: linear-gradient(90deg, #d81b60, #c2185b);
    }
    .form-label {
        font-weight: 500;
    }
    .card-body {
        background-color: #fdf2f6;
    }
</style>

<script>
    // Client-side validation for dates
    document.addEventListener('DOMContentLoaded', function() {
        const checkIn = document.getElementById('check_in');
        const checkOut = document.getElementById('check_out');
        
        if (checkIn && checkOut) {
            // Set minimum date for check-in to today
            const today = new Date().toISOString().split('T')[0];
            checkIn.min = today;
            
            // Update check-out min date when check-in changes
            checkIn.addEventListener('change', function() {
                checkOut.min = this.value;
                if (checkOut.value && checkOut.value < this.value) {
                    checkOut.value = '';
                }
            });
        }
    });
</script>
@endsection
