@extends('layouts.adminlte')
@section('title', isset($booking) ? 'Edit Booking' : 'Tambah Booking')
@section('content')
<div class="container py-4">
    <div class="card shadow border-0 rounded-3 overflow-hidden">
        <!-- HEADER -->
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-bed me-2"></i>
                {{ isset($booking) ? 'Edit Booking' : 'Tambah Booking' }}
            </h5>
            <a href="{{ route(auth()->user()->role . '.bookings.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <!-- BODY -->
        <div class="card-body bg-light">
            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Error validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Perbaiki kesalahan berikut:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ isset($booking) ? route(auth()->user()->role . '.bookings.update', $booking->id) : route(auth()->user()->role . '.bookings.store') }}" method="POST">
                @csrf
                @if(isset($booking))
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <!-- Guest Selection -->
                    <div class="col-md-6">
                        <label for="guest_id" class="form-label fw-semibold text-dark">Pilih Tamu</label>
                        <select name="guest_id" id="guest_id" class="form-select @error('guest_id') is-invalid @enderror" required>
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

                    <!-- Room Selection -->
                    <div class="col-md-6">
                        <label for="room_id" class="form-label fw-semibold text-dark">Pilih Kamar</label>
                        <select name="room_id" id="room_id" class="form-select @error('room_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Kamar --</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" data-price="{{ $room->price }}" {{ old('room_id', $booking->room_id ?? '') == $room->id ? 'selected' : '' }}>
                                    {{ $room->tipeKamar->tipe_kamar ?? 'Tanpa tipe' }} - Kamar {{ $room->number }} - Rp {{ number_format($room->price) }}
                                    ({{ ucfirst($room->status) }})
                                </option>
                            @endforeach
                        </select>
                        @error('room_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Check In -->
                    <div class="col-md-6">
                        <label for="check_in" class="form-label fw-semibold text-dark">Check In</label>
                        <input type="date" name="check_in" id="check_in" class="form-control @error('check_in') is-invalid @enderror" value="{{ old('check_in', isset($booking) ? $booking->check_in->format('Y-m-d') : '') }}" required />
                        @error('check_in')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Check Out -->
                    <div class="col-md-6">
                        <label for="check_out" class="form-label fw-semibold text-dark">Check Out</label>
                        <input type="date" name="check_out" id="check_out" class="form-control @error('check_out') is-invalid @enderror" value="{{ old('check_out', isset($booking) ? $booking->check_out->format('Y-m-d') : '') }}" required />
                        @error('check_out')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tambahan Fasilitas -->
                    <div class="col-md-12">
                        <label class="form-label fw-semibold text-dark">Tambahan Fasilitas</label>
                        <select name="facilities[]" id="facilities" class="form-select" multiple>
                            @foreach($facilities as $facility)
                                @if($facility->status === 'active')
                                    <option value="{{ $facility->id }}" {{ isset($booking) && $booking->facilities->contains($facility->id) ? 'selected' : '' }}>
                                        {{ $facility->name }} - Rp {{ number_format($facility->price_per_night) }}/malam
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- Tanggal Fasilitas -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Tanggal Mulai Fasilitas</label>
                        <input type="date" name="facility_start_date" class="form-control" value="{{ old('facility_start_date', isset($booking) ? $booking->facilities->first()?->pivot->start_date : '') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Tanggal Akhir Fasilitas</label>
                        <input type="date" name="facility_end_date" class="form-control" value="{{ old('facility_end_date', isset($booking) ? $booking->facilities->first()?->pivot->end_date : '') }}">
                    </div>

                    <!-- Status -->
                    <div class="col-md-12">
                        <label for="status" class="form-label fw-semibold text-dark">Status Booking</label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            @foreach(['booked' => 'Booked', 'checked_in' => 'Check In', 'checked_out' => 'Check Out', 'canceled' => 'Dibatalkan', 'paid' => 'Lunas'] as $value => $label)
                                <option value="{{ $value }}" {{ old('status', $booking->status ?? 'booked') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-dark">
                        <i class="fas me-1"></i> Simpan
                    </button>
                    <a href="{{ route(auth()->user()->role . '.bookings.index') }}" class="btn btn-secondary px-3">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JS Script: Check-in dan Check-out constraints -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkIn = document.getElementById('check_in');
        const checkOut = document.getElementById('check_out');
        if (checkIn && checkOut) {
            const today = new Date().toISOString().split('T')[0];
            checkIn.min = today;
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
