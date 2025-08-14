@extends('layouts.adminlte')

@section('content')
@php
    $prefix = auth()->user()->role;
    $isEdit = isset($guest);
@endphp

<div class="container py-4" style="background-color: #FAF6F0;">
    <div class="card shadow-sm border-0" style="border-top: 4px solid #C9A227;">

        {{-- Header --}}
        <div class="card-header bg-gradient-gold text-dark d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold" style="color: #4E342E;">
                <i class="fa-solid fa-user me-2"></i>
                {{ $isEdit ? 'Edit Data Tamu' : 'Tambah Tamu Baru' }}
            </h4>
        </div>

        {{-- Body --}}
        <div class="card-body" style="background-color: #fff;">
            <form action="{{ $isEdit ? route("$prefix.guests.update", $guest->id) : route("$prefix.guests.store") }}" method="POST">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <div class="row">
                    {{-- Nama --}}
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label fw-semibold" style="color: #4E342E;">Nama Lengkap</label>
                        <input type="text" name="name" id="name"
                            class="form-control rounded-pill @error('name') is-invalid @enderror"
                            value="{{ old('name', $guest->name ?? '') }}"
                            placeholder="Contoh: Budi Santoso" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Telepon --}}
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label fw-semibold" style="color: #4E342E;">Nomor Telepon</label>
                        <input type="text" name="phone" id="phone"
                            class="form-control rounded-pill @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $guest->phone ?? '') }}"
                            placeholder="Contoh: 081234567890" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Nomor Identitas --}}
                <div class="mb-3">
                    <label for="identity_number" class="form-label fw-semibold" style="color: #4E342E;">Nomor Identitas (KTP/SIM)</label>
                    <input type="text" name="identity_number" id="identity_number"
                        class="form-control rounded-pill @error('identity_number') is-invalid @enderror"
                        value="{{ old('identity_number', $guest->identity_number ?? '') }}"
                        placeholder="Contoh: 1234567890" required>
                    @error('identity_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route("$prefix.guests.index") }}" class="btn btn-outline-secondary rounded-pill">
                        <i class="fa fa-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-gold rounded-pill">
                        <i class="fa fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Custom Styles --}}
<style>
    .bg-gradient-gold {
        background: linear-gradient(90deg, #C9A227, #FFD700);
    }

    .btn-gold {
        background-color: #C9A227;
        color: white;
        border: none;
    }

    .btn-gold:hover {
        background-color: #B08D1E;
        color: white;
    }

    .form-label {
        font-size: 0.95rem;
    }

    .form-control:focus {
        border-color: #C9A227;
        box-shadow: 0 0 0 0.2rem rgba(201, 162, 39, 0.25);
    }

    .card {
        box-shadow: 0 4px 12px rgba(78, 52, 46, 0.1);
    }

    .rounded-pill {
        border-radius: 50rem !important;
    }

    .btn-outline-secondary {
        border-color: #6c757d;
        color: #6c757d;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }
</style>
@endsection