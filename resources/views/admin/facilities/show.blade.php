@extends('layouts.adminlte')

@section('title', 'Detail Fasilitas')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h3 class="fw-bold text-primary mb-3">{{ $facility->name }}</h3>

                {{-- Deskripsi --}}
                <div class="mb-4">
                    <h6 class="text-muted">Deskripsi</h6>
                    <p>{{ $facility->description ?? 'Tidak ada deskripsi.' }}</p>
                </div>

                {{-- Status & Kapasitas --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Status</h6>
                        @if($facility->isBooked())
                            <span class="badge bg-danger">Sedang dibooking</span>
                        @else
                            <span class="badge {{ $facility->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($facility->status) }}
                            </span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Kapasitas</h6>
                        <p>{{ $facility->capacity ?? 0 }} orang</p>
                    </div>
                    <div class="col-12">
                        <h6 class="text-muted">Harga Per Malam</h6>
                        <p class="text-success fw-bold">Rp {{ number_format($facility->price_per_night ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>

                {{-- Info Booking --}}
                @if($facility->isBooked())
                    @php $booking = $facility->activeBooking() @endphp
                    <div class="mb-3 p-3 bg-light rounded">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Di booking dari {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} 
                        sampai {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}
                    </div>
                @endif

                <a href="{{ route('admin.facilities.index') }}" class="btn btn-outline-secondary mt-3">Kembali</a>
            </div>
        </div>
    </div>

    {{-- Gambar --}}
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                @if($facility->image)
                    <img src="{{ asset('storage/'.$facility->image) }}" alt="Gambar Fasilitas" class="img-fluid rounded" style="max-height: 300px; object-fit: cover;">
                @else
                    <i class="fas fa-image fa-3x text-muted"></i>
                    <p class="text-muted">Tidak ada gambar tersedia</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
