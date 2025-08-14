@extends('layouts.adminlte')

@section('title', 'Ganti Password')

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0 text-primary">
                    <i class="fas fa-key mr-2"></i>Ganti Password
                </h3>
            </div>
        </div>
    </div>

    <div class="row justify-content-start">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-primary text-white py-3 d-flex align-items-center justify-content-between">
                    <h4 class="card-title mb-0"><i class="fas fa-lock me-2"></i>Form Ganti Password</h4>
                    <!-- Tombol kembali (Modal Trigger) -->
                    <button type="button" class="btn btn-outline-light btn-sm rounded-circle" 
                            data-bs-toggle="modal" data-bs-target="#modalKembali" aria-label="Kembali">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('resepsionis.profile.change-password') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <!-- Password Saat Ini -->
                        <div class="mb-4">
                            <label for="current_password" class="form-label text-primary">Password Saat Ini</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" name="current_password" required>
                                <button type="button" class="input-group-text toggle-password" data-target="current_password" aria-label="Tampilkan/Sembunyikan Password">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('current_password')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Baru -->
                        <div class="mb-4">
                            <label for="new_password" class="form-label text-primary">Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                       id="new_password" name="new_password" required>
                                <button type="button" class="input-group-text toggle-password" data-target="new_password" aria-label="Tampilkan/Sembunyikan Password">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('new_password')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">Minimal 8 karakter, kombinasi huruf dan angka</small>
                        </div>

                        <!-- Konfirmasi Password Baru -->
                        <div class="mb-4">
                            <label for="new_password_confirmation" class="form-label text-primary">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                <input type="password" class="form-control" 
                                       id="new_password_confirmation" name="new_password_confirmation" required>
                                <button type="button" class="input-group-text toggle-password" data-target="new_password_confirmation" aria-label="Tampilkan/Sembunyikan Password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-gradient rounded-pill py-2 px-4 shadow-sm">
                                <i class="fas fa-save me-2"></i> Ganti Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Kembali -->
<div class="modal fade" id="modalKembali" tabindex="-1" aria-labelledby="modalKembaliLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="modalKembaliLabel"><i class="fas fa-arrow-left me-2"></i>Konfirmasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin kembali? Perubahan yang belum disimpan akan hilang.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="{{ route('resepsionis.profile.show') }}" class="btn btn-gradient">Ya, Kembali</a>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #FAF6F0;
        color: #4E342E;
    }
    .card {
        border-radius: 12px;
        overflow: hidden;
        background-color: #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .bg-gradient-primary {
        background: linear-gradient(135deg, #C9A227 0%, #FFD700 100%);
    }
    .btn-gradient {
        background: linear-gradient(to right, #C9A227, #FFD700);
        border: none;
        font-weight: 600;
        color: #3E2723;
        transition: all 0.3s ease;
    }
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(201, 162, 39, 0.4);
        color: white;
    }
    .form-control {
        border-radius: 8px;
        border: 1px solid #C9A227;
    }
    .form-control:focus {
        border-color: #FFD700;
        box-shadow: 0 0 0 0.2rem rgba(201, 162, 39, 0.25);
    }
    .input-group-text {
        background-color: #FAF6F0;
        color: #C9A227;
        cursor: pointer;
    }
    .invalid-feedback {
        display: block;
        margin-top: 5px;
        color: #B71C1C;
    }
    .text-primary {
        color: #C9A227 !important;
    }
</style>

<script>
(function () {
  'use strict';
  document.querySelectorAll('.needs-validation').forEach(function (form) {
    form.addEventListener('submit', function (event) {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();
document.querySelectorAll('.toggle-password').forEach(function (button) {
    button.addEventListener('click', function () {
        const target = this.getAttribute('data-target');
        const input = document.getElementById(target);
        const icon = this.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });
});
</script>
@endsection
