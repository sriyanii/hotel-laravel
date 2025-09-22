@extends('layouts.adminlte')

@php
    $isEdit = $isEdit ?? false;
@endphp

@section('title', $isEdit ? 'Edit Tamu' : 'Tambah Tamu')

@section('content')
<div class="container py-4">
    <div class="card shadow rounded-3 border-0">
        <!-- Header -->
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center rounded-top">
            <div class="d-flex align-items-center">
                <i class="fas fa-user me-2"></i>
                <h5 class="mb-0">{{ $isEdit ? 'Edit Tamu' : 'Tambah Tamu' }}</h5>
            </div>
            <a href="{{ route(auth()->user()->role.'.guests.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
        </div>

        <!-- Body -->
        <div class="card-body bg-light">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ $isEdit ? route(auth()->user()->role.'.guests.update', $guest->id) : route(auth()->user()->role.'.guests.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($isEdit) @method('PUT') @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <label>Nama <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $guest->name ?? '') }}" required placeholder="Masukkan nama tamu">
                    </div>
                    <div class="col-md-6">
                        <label>Telepon <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $guest->phone ?? '') }}" required placeholder="Masukkan nomor telepon">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="guest_code">Kode Tamu</label>
                        <input type="text" name="guest_code" id="guest_code" class="form-control" value="{{ old('guest_code', $guest->guest_code) }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label>No. Identitas <span class="text-danger">*</span></label>
                        <input type="text" name="identity_number" class="form-control" value="{{ old('identity_number', $guest->identity_number ?? '') }}" required placeholder="Masukkan nomor identitas">
                    </div>
                    <div class="col-md-6">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', isset($guest->date_of_birth) ? $guest->date_of_birth->format('Y-m-d') : '') }}">
                    </div>
                    <div class="col-md-6">
                        <label>Kebangsaan</label>
                        <input type="text" name="nationality" class="form-control" value="{{ old('nationality', $guest->nationality ?? '') }}" placeholder="Contoh: Indonesia">
                    </div>
                    <div class="col-md-6">
                        <label>Tipe Tamu</label>
                        <select name="guest_type" class="form-control">
                            <option value="">-- Pilih --</option>
                            @foreach(['reguler','vip','vvip','corporate','staff'] as $type)
                                <option value="{{ $type }}" {{ old('guest_type', $guest->guest_type ?? '') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $guest->email ?? '') }}" placeholder="Masukkan email">
                    </div>

                    <div class="col-md-6">
                        <label>Jenis Kelamin</label>
                        <select name="gender" class="form-control">
                            <option value="">-- Pilih --</option>
                            @foreach(['male' => 'Laki-laki', 'female' => 'Perempuan', 'other' => 'Lainnya'] as $key => $label)
                                <option value="{{ $key }}" {{ old('gender', $guest->gender ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Status Pernikahan</label>
                        <select name="marital_status" class="form-control">
                            <option value="">-- Pilih --</option>
                            @foreach(['single','married','divorced','widowed'] as $status)
                                <option value="{{ $status }}" {{ old('marital_status', $guest->marital_status ?? '') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label>Alamat</label>
                        <textarea name="address" class="form-control" rows="2" placeholder="Masukkan alamat">{{ old('address', $guest->address ?? '') }}</textarea>
                    </div>

                    <div class="col-12">
                        <label>Catatan / Preferensi</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $guest->notes ?? '') }}</textarea>
                    </div>

                    <div class="col-12">
                        <label>Foto Tamu</label>
                        <input type="file" name="photo" class="form-control">
                        @if($isEdit && $guest->photo)
                            <div class="mt-2">
                                <img src="{{ asset('guests/'.$guest->photo) }}" style="max-width:150px;" class="rounded shadow-sm border">
                                <div class="form-check mt-2">
                                    <input type="checkbox" name="delete_photo" class="form-check-input" id="deletePhoto">
                                    <label for="deletePhoto" class="form-check-label">Hapus foto lama</label>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tombol Simpan & Batal -->
                <div class="mt-4 text-end">
                    <button class="btn btn-dark">{{ $isEdit ? 'Update' : 'Simpan' }}</button>
                    <a href="{{ route(auth()->user()->role.'.guests.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
