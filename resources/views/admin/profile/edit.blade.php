@extends('layouts.adminlte')

@section('title', 'Edit Profil')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-3" style="background-color: #ffe6f0;">
                <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #e83e8c; color: white; border-radius: .5rem .5rem 0 0;">
                    <h3 class="card-title mb-0"><i class="fa fa-edit me-2"></i>Edit Profil</h3>
                    <a href="{{ route('admin.profile.show') }}" class="btn btn-light btn-sm rounded-pill">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label" style="color:#c82375;">Nama Lengkap</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name', auth()->user()->name) }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label" style="color:#c82375;">Alamat Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email', auth()->user()->email) }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label" style="color:#c82375;">Nomor Telepon</label>
                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   name="phone" value="{{ old('phone', auth()->user()->phone) }}" autocomplete="phone">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label" style="color:#c82375;">Alamat</label>
                            <textarea id="address" class="form-control @error('address') is-invalid @enderror" 
                                      name="address" rows="3" autocomplete="address">{{ old('address', auth()->user()->address) }}</textarea>
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn rounded-pill shadow-sm" style="background-color:#e83e8c; color:white;">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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
