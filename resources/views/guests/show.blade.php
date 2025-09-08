@extends('layouts.adminlte')

@section('title', 'Detail Tamu')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4"><i class="fas fa-user-tag text-info"></i> Detail Tamu</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card card-outline card-info shadow-sm">
                <div class="card-header">
                    <h5 class="card-title"><i class="fas fa-id-card"></i> Informasi Tamu</h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID Tamu:</strong> <span class="text-muted">{{ $guest->id }}</span></p>
                            <p><strong>Nama:</strong> <span class="text-dark">{{ $guest->name }}</span></p>
                            <p><strong>Nomor Telepon:</strong> <span class="text-muted">{{ $guest->phone }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Nomor Identitas:</strong> <span class="text-muted">{{ $guest->identity_number }}</span></p>
                            <p><strong>Dibuat pada:</strong> {{ $guest->created_at ? $guest->created_at->format('d M Y H:i') : '-' }}</p>
                            <p><strong>Diperbarui pada:</strong> {{ $guest->updated_at ? $guest->updated_at->format('d M Y H:i') : '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <!-- Tombol Kembali -->
                    <a href="{{ route('admin.guests.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Tamu
                    </a>

                    <!-- Opsional: Tombol Edit (hanya untuk admin) -->
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.guests.edit', $guest->id) }}" class="btn btn-primary rounded-pill px-4">
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
</style>
@endsection