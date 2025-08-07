@extends('layouts.adminlte')

@section('content')
<div class="container mt-4">
    {{-- Judul dan tombol kembali --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>{{ isset($user) ? 'Edit Resepsionis' : 'Tambah Resepsionis' }}</h4>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Error validasi --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Tambah/Edit --}}
    <form 
        action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}" 
        method="POST"
    >
        @csrf
        @if(isset($user))
            @method('PUT')
        @endif

        {{-- Nama --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input 
                type="text" 
                name="name" 
                id="name"
                class="form-control @error('name') is-invalid @enderror" 
                value="{{ old('name', $user->name ?? '') }}" 
                required
            >
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input 
                type="email" 
                name="email" 
                id="email"
                class="form-control @error('email') is-invalid @enderror" 
                value="{{ old('email', $user->email ?? '') }}" 
                required
            >
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input 
                type="text" 
                name="password" 
                id="password"
                class="form-control @error('password') is-invalid @enderror"
                {{ isset($user) ? '' : 'required' }}
                placeholder="{{ isset($user) ? 'Kosongkan jika tidak ingin mengubah' : 'Masukkan password' }}"
            >
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror

            @if(isset($user))
                <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
            @endif
        </div>

        <button type="submit" class="btn btn-success">
            {{ isset($user) ? 'Update' : 'Simpan' }}
        </button>
    </form>
</div>
@endsection
