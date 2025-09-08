@extends('layouts.adminlte')

@section('content')
@php
    $prefix = auth()->user()->role;
    $isEdit = isset($guest);
@endphp

<div class="container py-4">
    <div class="card shadow-sm border-0">

        {{-- Header --}}
        <div class="card-header text-white d-flex justify-content-between align-items-center" style="background: #3d3d3d">
            <h4 class="mb-0 fw-bold">
                <i class="fa-solid fa-user me-2"></i>
                {{ $isEdit ? 'Edit Data Tamu' : 'Tambah Tamu Baru' }}
            </h4>
        </div>

        {{-- Body --}}
        <div class="card-body">
            <form action="{{ $isEdit ? route("$prefix.guests.update", $guest->id) : route("$prefix.guests.store") }}" method="POST">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <div class="row">
                    {{-- Nama --}}
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
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
                        <label for="phone" class="form-label fw-semibold">Nomor Telepon</label>
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
                    <label for="identity_number" class="form-label fw-semibold">Nomor Identitas (KTP/SIM)</label>
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
                    <button type="submit" class="btn btn-secondary rounded-pill">
                        <i class="fa fa-save me-1 text-white"></i> Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- Gaya pink soft --}}
<!-- <style>
    .bg-soft-pink {
        background: linear-gradient(90deg, #f8d7da, #fce4ec);
    }

    .btn-pink {
        background-color: #f06292;
        color: white;
        border: none;
    }

    .btn-pink:hover {
        background-color: #ec407a;
        color: white;
    }

    .form-label {
        font-size: 0.95rem;
    }

    .form-control:focus {
        border-color: #f06292;
        box-shadow: 0 0 0 0.2rem rgba(240, 98, 146, 0.25);
    }
</style> -->
@endsection


