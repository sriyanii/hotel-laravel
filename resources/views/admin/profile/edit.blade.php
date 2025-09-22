@extends('layouts.adminlte')

@section('title', 'Edit Profil')

@section('content')
<div class="container-fluid py-4" style="background-color: #FAF6F0;">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-semibold text-dark">
            <i class="fas fa-user-edit text-warning me-2"></i>Edit Profil
        </h2>
        <a href="{{ route('admin.profile.show') }}" class="btn btn-outline-warning btn-sm px-3">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.profile.update') }}" class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Nama -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label text-dark">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-warning border-end-0">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror border-start-0"
                                           name="name" value="{{ old('name', auth()->user()->name) }}"
                                           required autocomplete="name">
                                    @error('name')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label text-dark">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-warning border-end-0">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror border-start-0"
                                           name="email" value="{{ old('email', auth()->user()->email) }}"
                                           required autocomplete="email">
                                    @error('email')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Telepon -->
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label text-dark">Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-warning border-end-0">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                    <input id="phone" type="text"
                                           class="form-control @error('phone') is-invalid @enderror border-start-0"
                                           name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                                           autocomplete="tel">
                                    @error('phone')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label text-dark">Alamat</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-warning border-end-0">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
                                    <textarea id="address"
                                              class="form-control @error('address') is-invalid @enderror border-start-0"
                                              name="address" rows="2">{{ old('address', auth()->user()->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Foto Profil -->
                            <div class="col-md-12">
                                <div class="row align-items-start">
                                    <div class="col-md-4 text-center">
                                        <label for="photo" class="form-label text-dark fw-normal">Foto Profil</label>
                                        <div class="mb-2">
                                            <img src="{{ auth()->user()->photo ? asset('image/' . auth()->user()->photo) : asset('img/default-avatar.png') }}"
                                                 alt="Foto Profil"
                                                 class="rounded-circle shadow-sm"
                                                 style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #C9A227;">
                                        </div>
                                        <input type="file" name="photo" class="form-control form-control-sm @error('photo') is-invalid @enderror" accept="image/*">
                                        @error('photo')
                                            <div class="invalid-feedback d-block text-start">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Format: JPG, PNG. Maks: 2MB.</small>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="alert alert-light border rounded p-3 mt-4 mt-md-0" style="background: #FFF8E1; border-color: #FFE082;">
                                            <i class="fas fa-info-circle text-warning me-2"></i>
                                            <strong>Informasi:</strong> Unggah foto profesional untuk tampilan profil yang lebih baik.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-warning text-white px-4 py-2" style="border: none;">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gaya Tambahan -->
<style>
    .form-control:focus {
        border-color: #C9A227;
        box-shadow: 0 0 0 0.2rem rgba(201, 162, 39, 0.2);
    }
    .input-group-text {
        background-color: #FFF8E1;
        color: #C9A227;
        border: 1px solid #FFE082;
    }
    .form-control, .form-select {
        border: 1px solid #E0E0E0;
    }
    .invalid-feedback {
        font-size: 0.875rem;
    }
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
    .btn-warning:hover {
        background-color: #b89325;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(201, 162, 39, 0.3);
    }
</style>

<!-- Validasi Form -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
});
</script>
@endsection