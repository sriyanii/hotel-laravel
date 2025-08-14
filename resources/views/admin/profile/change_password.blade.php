@extends('layouts.adminlte')

@section('title', 'Ganti Password')

@section('content')
<div class="container-fluid p-4" style="background-color: #FAF6F0;">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0" style="color: #4E342E;">
                <i class="fas fa-key me-2" style="color: #C9A227;"></i>Ganti Password
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" style="color: #4E342E;">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.profile.show') }}" style="color: #4E342E;">Profil</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: #C9A227;">Ganti Password</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.profile.show') }}" class="btn btn-outline-secondary rounded-pill" style="border-color: #C9A227; color: #4E342E;">
            <i class="fas fa-arrow-left me-1" style="color: #C9A227;"></i> Kembali
        </a>
    </div>

    <!-- Password Change Card - Full Width -->
    <div class="card border-0 shadow rounded-lg" style="border-left: 4px solid #C9A227;">
        <div class="card-header py-3" style="background-color: #3E2723; color: #FAF6F0;">
            <h5 class="mb-0"><i class="fas fa-lock me-2" style="color: #FFD700;"></i>Form Ganti Password</h5>
        </div>
        
        <div class="card-body p-4">
            <form action="{{ route('admin.profile.change-password') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- Current Password -->
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-medium" style="color: #4E342E;">Password Saat Ini <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" name="current_password" 
                                   class="form-control @error('current_password') is-invalid @enderror" 
                                   required id="currentPassword">
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="currentPassword" style="border-color: #C9A227; color: #4E342E;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <div class="invalid-feedback d-block">
                                <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-medium" style="color: #4E342E;">Password Baru <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" name="new_password" 
                                   class="form-control @error('new_password') is-invalid @enderror" 
                                   required id="newPassword">
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="newPassword" style="border-color: #C9A227; color: #4E342E;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="text-muted">Minimal 8 karakter, kombinasi huruf dan angka</small>
                        @error('new_password')
                            <div class="invalid-feedback d-block">
                                <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Confirm New Password -->
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-medium" style="color: #4E342E;">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" name="new_password_confirmation" 
                                   class="form-control" required id="confirmPassword">
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirmPassword" style="border-color: #C9A227; color: #4E342E;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Password Strength Meter -->
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-medium" style="color: #4E342E;">Kekuatan Password</label>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-danger" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                        </div>
                        <small id="passwordStrengthText" class="text-muted">Masukkan password baru untuk melihat kekuatan</small>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between border-top pt-4">
                    <button type="reset" class="btn btn-outline-secondary rounded-pill px-4" style="border-color: #C9A227; color: #4E342E;">
                        <i class="fas fa-undo me-2" style="color: #4E342E;"></i> Reset
                    </button>
                    <button type="submit" class="btn rounded-pill px-4" style="background-color: #C9A227; color: #3E2723;">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Security Tips - Full Width -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="alert" style="background-color: #FAF6F0; border-left: 4px solid #C9A227; color: #4E342E;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-shield-alt fa-2x me-3" style="color: #C9A227;"></i>
                    <div>
                        <h5 class="alert-heading mb-2" style="color: #3E2723;">Tips Keamanan Password</h5>
                        <ul class="mb-0 ps-3">
                            <li>Gunakan kombinasi huruf besar dan kecil</li>
                            <li>Sertakan angka dan karakter khusus (contoh: !@#$%)</li>
                            <li>Jangan gunakan informasi pribadi seperti tanggal lahir</li>
                            <li>Gunakan password yang berbeda untuk setiap akun</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
    
    .card-header {
        background: linear-gradient(135deg, #3E2723, #4E342E);
    }
    
    .form-control:focus {
        border-color: #C9A227;
        box-shadow: 0 0 0 0.2rem rgba(201, 162, 39, 0.25);
    }
    
    .btn-primary {
        background-color: #C9A227;
        border-color: #C9A227;
        color: #3E2723;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background-color: #B08D1E;
        transform: translateY(-2px);
        color: #FAF6F0;
    }
    
    .btn-outline-primary {
        color: #C9A227;
        border-color: #C9A227;
    }
    
    .btn-outline-primary:hover {
        background-color: #C9A227;
        color: #3E2723;
    }
    
    .toggle-password {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
    
    .invalid-feedback {
        display: flex;
        align-items: center;
    }
    
    .alert-info {
        border-radius: 12px;
        border-left: 4px solid #C9A227;
    }
    
    .breadcrumb {
        background-color: transparent;
        padding: 0;
    }
    
    .breadcrumb-item.active {
        color: #C9A227;
        font-weight: 500;
    }
    
    .progress {
        background-color: #e9ecef;
    }
    
    a {
        color: #C9A227;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    a:hover {
        color: #B08D1E;
    }
</style>

<script>
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Password strength meter
    document.getElementById('newPassword').addEventListener('input', function() {
        const password = this.value;
        const strengthBar = document.getElementById('passwordStrength');
        const strengthText = document.getElementById('passwordStrengthText');
        
        // Reset
        let strength = 0;
        strengthBar.style.width = '0%';
        strengthBar.classList.remove('bg-danger', 'bg-warning', 'bg-success');
        
        if (password.length === 0) {
            strengthText.textContent = 'Masukkan password baru untuk melihat kekuatan';
            strengthText.style.color = '#6c757d';
            return;
        }
        
        // Length check
        if (password.length > 7) strength += 25;
        
        // Contains numbers
        if (/\d/.test(password)) strength += 25;
        
        // Contains lowercase
        if (/[a-z]/.test(password)) strength += 15;
        
        // Contains uppercase
        if (/[A-Z]/.test(password)) strength += 15;
        
        // Contains special chars
        if (/[^a-zA-Z0-9]/.test(password)) strength += 20;
        
        // Update UI
        strengthBar.style.width = strength + '%';
        
        if (strength < 40) {
            strengthBar.classList.add('bg-danger');
            strengthText.textContent = 'Lemah';
            strengthText.style.color = '#dc3545';
        } 
        else if (strength < 70) {
            strengthBar.classList.add('bg-warning');
            strengthText.textContent = 'Sedang';
            strengthText.style.color = '#fd7e14';
        } 
        else {
            strengthBar.classList.add('bg-success');
            strengthText.textContent = 'Kuat';
            strengthText.style.color = '#28a745';
        }
    });
</script>
@endsection