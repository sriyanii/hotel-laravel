@extends('layouts.adminlte')
@section('title', isset($user) ? 'Edit Resepsionis' : 'Tambah Resepsionis')

@section('content')
<div class="container py-4">
    <h4>{{ isset($user) ? 'Edit Resepsionis' : 'Tambah Resepsionis Baru' }}</h4>

    <form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($user))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
            @if(isset($user))
                <small class="text-muted">Kosongkan jika tidak ingin mengganti password</small>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Telepon</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="address" class="form-control" rows="3" required>{{ old('address', $user->address ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Foto</label>
            <input type="file" name="photo" class="form-control" accept="image/*">
            @if(isset($user) && $user->photo)
                <div class="mt-2">
                    <img src="{{ asset('image/' . $user->photo) }}" alt="Foto" style="width: 100px; height: 100px; object-fit: cover;">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Update' : 'Simpan' }}</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection