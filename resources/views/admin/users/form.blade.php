@extends('layouts.adminlte')

@section('content')
<div class="container py-4">
    {{-- Form Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">{{ isset($user) ? 'Edit Resepsionis' : 'Tambah Resepsionis' }}</h3>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger shadow-sm">
            <strong>Oops!</strong> Ada kesalahan:
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Card Form --}}
    <div class="card border-0 shadow rounded-4">
        <div class="card-body px-4 py-4">
            <form 
                action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}" 
                method="POST" enctype="multipart/form-data"
            >
                @csrf
                @if(isset($user)) @method('PUT') @endif

                <div class="row g-4">
                    <div class="col-md-8">
                        {{-- Nama --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name ?? '') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email ?? '') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold">Nomor Telepon</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $user->phone ?? '') }}" required>
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Address --}}
                        <div class="mb-3">
                            <label for="address" class="form-label fw-semibold">Alamat</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" required>{{ old('address', $user->address ?? '') }}</textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">
                                {{ isset($user) ? 'Password Baru' : 'Password' }}
                            </label>
                            <input type="text" name="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="{{ isset($user) ? 'Kosongkan jika tidak ingin mengubah' : 'Masukkan password' }}"
                                {{ isset($user) ? '' : 'required' }}>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        {{-- Foto --}}
                        <div class="mb-3">
                            <label for="photo" class="form-label fw-semibold">Foto (Opsional)</label>
                            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                            @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        @if(isset($user))
                            <div class="text-center mt-3">
                                <img src="{{ $user->photo ? asset('storage/photos/' . $user->photo) : asset('img/default-avatar.png') }}" 
                                     alt="Foto Resepsionis" 
                                     class="rounded-circle shadow border border-primary"
                                     style="width: 120px; height: 120px; object-fit: cover;">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="fas fa-save me-1"></i> {{ isset($user) ? 'Update Data' : 'Simpan Resepsionis' }}
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Custom CSS --}}
<style>
    :root {
        --gold-primary: #C9A227;
        --gold-light: #FFD700;
        --cream-bg: #FAF6F0;
        --dark-brown: #4E342E;
        --dark-secondary: #3E2723;
    }

    body {
        background-color: var(--cream-bg);
    }

    .text-primary {
        color: var(--dark-brown) !important;
    }

    .btn-primary {
        background-color: var(--gold-primary);
        color: var(--dark-brown);
        border: 1px solid var(--gold-primary);
    }

    .btn-primary:hover {
        background-color: var(--gold-light);
        color: var(--dark-secondary);
        border-color: var(--gold-light);
    }

    .btn-outline-primary {
        border: 1px solid var(--gold-primary);
        color: var(--dark-brown);
    }

    .btn-outline-primary:hover {
        background-color: var(--gold-primary);
        color: var(--dark-brown);
    }

    .bg-primary {
        background-color: var(--gold-primary) !important;
    }

    .border-primary {
        border-color: var(--gold-primary) !important;
    }

    .card {
        background-color: white;
        border: none;
    }

    .form-control:focus {
        border-color: var(--gold-primary);
        box-shadow: 0 0 0 0.25rem rgba(201, 162, 39, 0.25);
    }
</style>
@endsection