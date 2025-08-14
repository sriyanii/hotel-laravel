@extends('layouts.adminlte')

@section('title', 'Ganti Password')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4" style="color:#d63384;"><i class="fa fa-key me-2"></i>Ganti Password</h4>

    <div class="card shadow-sm border-0 rounded-3" style="background-color:#ffe6f0;">
        <div class="card-body">
            <a href="{{ route('admin.profile.show') }}" class="btn btn-light btn-sm rounded-pill">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
            <form action="{{ route('admin.profile.change-password') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label" style="color:#c82375;">Password Saat Ini</label>
                    <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                    @error('current_password') 
                        <span class="text-danger">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" style="color:#c82375;">Password Baru</label>
                    <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" required>
                    @error('new_password') 
                        <span class="text-danger">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" style="color:#c82375;">Konfirmasi Password Baru</label>
                    <input type="password" name="new_password_confirmation" class="form-control" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn rounded-pill shadow-sm" style="background-color:#e83e8c; color:white;">
                        <i class="fa fa-key me-1"></i> Ganti Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #c82375;
        box-shadow: 0 0 0 0.2rem rgba(232, 62, 140, 0.25);
    }
    .btn:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        transition: 0.2s;
    }
</style>
@endsection
