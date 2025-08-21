@extends('layouts.adminlte')

@section('title', 'Ganti Password')

@section('content')
<div class="container-fluid py-4" style="background-color: #FAF6F0;">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="fw-semibold text-dark">
                <i class="fas fa-key text-warning me-2"></i>Ganti Password
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.profile.show') }}" class="text-muted">Profil</a></li>
                    <li class="breadcrumb-item active">Ganti Password</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.profile.show') }}" class="btn btn-outline-warning btn-sm px-3">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <!-- Form Ganti Password -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom-0">
            <h5 class="mb-0 text-dark">
                <i class="fas fa-lock text-warning me-2"></i>Ubah Kata Sandi
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.profile.change-password') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- Password Saat Ini -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-dark">Password Saat Ini</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-warning border-end-0">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="current_password"
                                   class="form-control @error('current_password') is-invalid @enderror"
                                   id="currentPassword" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="currentPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <div class="invalid-feedback d-block mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Baru -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-dark">Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-warning border-end-0">
                                <i class="fas fa-key"></i>
                            </span>
                            <input type="password" name="new_password"
                                   class="form-control @error('new_password') is-invalid @enderror"
                                   id="newPassword" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="newPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="text-muted">Minimal 8 karakter, gunakan huruf, angka, dan simbol.</small>
                        @error('new_password')
                            <div class="invalid-feedback d-block mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Konfirmasi Password -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-dark">Konfirmasi Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-warning border-end-0">
                                <i class="fas fa-check"></i>
                            </span>
                            <input type="password" name="new_password_confirmation"
                                   class="form-control" id="confirmPassword" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirmPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Strength Meter -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-dark">Kekuatan Password</label>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                        </div>
                        <small id="passwordStrengthText" class="text-muted">Masukkan password untuk melihat kekuatan</small>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="reset" class="btn btn-outline-secondary btn-sm px-3">
                        <i class="fas fa-undo me-1"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-warning text-white btn-sm px-3">
                        <i class="fas fa-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tips Keamanan -->
    <div class="alert alert-light border rounded p-3 mt-4" style="background: #FFF8E1; border-color: #FFE082;">
        <div class="d-flex align-items-start">
            <i class="fas fa-shield-alt fa-lg text-warning mt-1 me-3"></i>
            <div>
                <h6 class="mb-1 text-dark">Tips Keamanan:</h6>
                <ul class="mb-0 small text-muted ps-3">
                    <li>Gunakan kombinasi huruf besar, kecil, angka, dan simbol.</li>
                    <li>Hindari informasi pribadi seperti tanggal lahir.</li>
                    <li>Gunakan password unik yang tidak digunakan di tempat lain.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Gaya Tambahan -->
<style>
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
    .card-header {
        padding: 0.75rem 1rem;
    }
    .form-control:focus {
        border-color: #C9A227;
        box-shadow: 0 0 0 0.2rem rgba(201, 162, 39, 0.2);
    }
    .input-group-text {
        background-color: #FFF8E1;
        color: #C9A227;
        border: 1px solid #FFE082;
    }
    .toggle-password {
        border-radius: 0;
    }
    .invalid-feedback {
        font-size: 0.875rem;
    }
    .progress {
        background-color: #e9ecef;
        border-radius: 4px;
    }
    .progress-bar {
        transition: width 0.3s ease;
    }
    .btn-warning:hover {
        background-color: #b89325;
    }
    .breadcrumb-item a {
        color: #6c757d;
        text-decoration: none;
    }
    .breadcrumb-item a:hover {
        color: #C9A227;
    }
    .breadcrumb-item.active {
        color: #C9A227;
    }
</style>

<!-- Script: Toggle & Strength Meter -->
<script>
    // Toggle Password Visibility
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
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

    // Password Strength Meter
    document.getElementById('newPassword').addEventListener('input', function () {
        const password = this.value;
        const strengthBar = document.getElementById('passwordStrength');
        const strengthText = document.getElementById('passwordStrengthText');

        if (!password) {
            strengthBar.style.width = '0%';
            strengthBar.className = 'progress-bar';
            strengthText.textContent = 'Masukkan password baru untuk melihat kekuatan';
            strengthText.style.color = '#6c757d';
            return;
        }

        let strength = 0;
        if (password.length >= 8) strength += 25;
        if (/[a-z]/.test(password)) strength += 25;
        if (/[A-Z]/.test(password)) strength += 25;
        if (/[^a-zA-Z0-9]/.test(password)) strength += 25;

        strengthBar.style.width = `${strength}%`;
        if (strength < 50) {
            strengthBar.className = 'progress-bar bg-danger';
            strengthText.textContent = 'Lemah';
            strengthText.style.color = '#dc3545';
        } else if (strength < 80) {
            strengthBar.className = 'progress-bar bg-warning';
            strengthText.textContent = 'Sedang';
            strengthText.style.color = '#fd7e14';
        } else {
            strengthBar.className = 'progress-bar bg-success';
            strengthText.textContent = 'Kuat';
            strengthText.style.color = '#28a745';
        }
    });
</script>
@endsection