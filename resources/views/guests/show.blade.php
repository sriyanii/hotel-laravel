@extends('layouts.adminlte')

@section('title', 'Detail Tamu')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm rounded">
                <!-- Header Card -->
                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 text-white">
                        <i class="fas fa-user-tag"></i> Detail Tamu
                    </h5>
                    <a href="{{ route(auth()->user()->role . '.guests.index') }}" class="btn btn-light btn-sm rounded-pill px-3">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <!-- Body Card -->
                <div class="card-body">
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <p><strong>ID Tamu:</strong> <span class="text-muted">{{ $guest->guest_code ?? '-' }}</span></p>
                            <p><strong>Nama:</strong> <span class="text-dark">{{ $guest->name }}</span></p>
                            <p><strong>Email:</strong> <span class="text-muted">{{ $guest->email ?? '-' }}</span></p>
                            <p><strong>Jenis Kelamin:</strong> 
                                <span class="text-muted">
                                    @switch($guest->gender)
                                        @case('male') Laki-laki @break
                                        @case('female') Perempuan @break
                                        @case('other') Lainnya @break
                                        @default -
                                    @endswitch
                                </span>
                            </p>
                            <p><strong>Nomor Telepon:</strong> <span class="text-muted">{{ $guest->phone }}</span></p>
                            <p><strong>Nomor Identitas:</strong> <span class="text-muted">{{ $guest->identity_number }}</span></p>
                            <p><strong>Tanggal Lahir:</strong> 
                                <span class="text-muted">{{ $guest->date_of_birth ? $guest->date_of_birth->format('d M Y') : '-' }}</span>
                            </p>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <p><strong>Tipe Tamu:</strong> <span class="text-muted">{{ ucfirst($guest->guest_type ?? '-') }}</span></p>
                            <p><strong>Status Pernikahan:</strong> <span class="text-muted">{{ ucfirst($guest->marital_status ?? '-') }}</span></p>
                            <p><strong>Alamat:</strong> <span class="text-muted">{{ $guest->address ?? '-' }}</span></p>
                            <p><strong>Catatan / Preferensi:</strong> <span class="text-muted">{{ $guest->notes ?? '-' }}</span></p>
                            <p><strong>Dibuat pada:</strong> {{ $guest->created_at ? $guest->created_at->format('d M Y H:i') : '-' }}</p>
                            <p><strong>Diperbarui pada:</strong> {{ $guest->updated_at ? $guest->updated_at->format('d M Y H:i') : '-' }}</p>
                        </div>
                    </div>

                    @if($guest->photo)
                        <div class="mt-3 text-center">
                            <strong>Foto Tamu:</strong><br>
                            <img src="{{ asset('guests/'.$guest->photo) }}" alt="Foto Tamu" style="max-width:200px; border-radius:8px;">
                        </div>
                    @endif
                </div>

                <!-- Footer Card -->
                <div class="card-footer d-flex justify-content-end">
                    @if (auth()->user()->role === 'admin' || auth()->user()->role === 'resepsionis')
                        <a href="{{ route(auth()->user()->role . '.guests.edit', $guest->id) }}" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-edit"></i> Edit Data
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .card-title i {
        margin-right: 8px;
    }
    .card {
        border-radius: 12px;
    }
    .card-header {
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }
</style>
@endsection
