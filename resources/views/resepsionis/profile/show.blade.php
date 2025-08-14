@extends('layouts.adminlte')

@section('title', 'Profil Resepsionis')

@section('content')
<div class="container-fluid px-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0" style="color:#4E342E;">
                    <i class="fas fa-user-circle me-2" style="color:#C9A227;"></i>Profil Resepsionis
                </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}" style="color:#C9A227;">Dashboard</a></li>
                        <li class="breadcrumb-item active" style="color:#4E342E;">Profil</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Informasi Profil --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-cream border-bottom py-3">
                    <h4 class="card-title mb-0" style="color:#4E342E;">
                        <i class="fas fa-id-card me-2" style="color:#C9A227;"></i>Informasi Profil
                    </h4>
                </div>
                
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-light p-3 rounded-circle me-3">
                                    <i class="fas fa-user" style="color:#C9A227;"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-1 small">Nama Lengkap</p>
                                    <h5 class="mb-0">{{ auth()->user()->name }}</h5>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-light p-3 rounded-circle me-3">
                                    <i class="fas fa-envelope" style="color:#C9A227;"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-1 small">Alamat Email</p>
                                    <h5 class="mb-0">{{ auth()->user()->email }}</h5>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-light p-3 rounded-circle me-3">
                                    <i class="fas fa-user-tag" style="color:#C9A227;"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-1 small">Role</p>
                                    <h5 class="mb-0">
                                        <span class="badge" style="background-color:#C9A227; color:#4E342E;">Resepsionis</span>
                                    </h5>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-light p-3 rounded-circle me-3">
                                    <i class="fas fa-calendar-alt" style="color:#C9A227;"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-1 small">Bergabung Sejak</p>
                                    <h5 class="mb-0">{{ auth()->user()->created_at->format('d F Y') }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 gap-2">
                        <a href="{{ route('resepsionis.profile.edit') }}" class="btn btn-gold me-3">
                            <i class="fas fa-edit me-2"></i> Edit Profil
                        </a>
                        <a href="{{ route('resepsionis.profile.change-password.show') }}" class="btn btn-outline-gold">
                            <i class="fas fa-key me-2"></i> Ganti Password
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Keamanan Akun --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-cream border-bottom py-3">
                    <h4 class="card-title mb-0" style="color:#4E342E;">
                        <i class="fas fa-shield-alt me-2" style="color:#C9A227;"></i>Keamanan Akun
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-success d-flex align-items-center mb-3">
                        <i class="fas fa-check-circle me-2"></i>
                        <div>
                            <strong>Email Terverifikasi</strong>
                            <div class="small">Email Anda telah diverifikasi</div>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning d-flex align-items-center mb-4">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <div>
                            <strong>Kata Sandi</strong>
                            <div class="small">
                                @if(auth()->user()->password_changed_at)
                                    Terakhir diubah {{ auth()->user()->password_changed_at->diffForHumans() }}
                                @else
                                    Belum pernah diubah
                                @endif
                            </div>
                        </div>
                    </div>

                    <h5 class="mb-3" style="color:#4E342E;">
                        <i class="fas fa-clock me-2" style="color:#C9A227;"></i>Aktivitas Terakhir
                    </h5>
                    <div class="small text-muted">
                        @if(auth()->user()->last_login_at)
                            <i class="fas fa-sign-in-alt me-1"></i> 
                            Login terakhir: {{ auth()->user()->last_login_at->format('d F Y H:i') }}
                            <br>
                            <i class="fas fa-globe me-1"></i> 
                            IP Address: {{ auth()->user()->last_login_ip ?? 'Tidak diketahui' }}
                        @else
                            Belum ada riwayat login
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #FAF6F0; /* Cream lembut */
    }
    .card {
        border-radius: 0.5rem;
        overflow: hidden;
    }
    .bg-cream {
        background-color: #FAF6F0 !important;
    }
    .rounded-circle {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-gold {
        background-color: #C9A227;
        border-color: #C9A227;
        color: #4E342E;
    }
    .btn-gold:hover {
        background-color: #b8931e;
        border-color: #b8931e;
        color: white;
    }
    .btn-outline-gold {
        color: #C9A227;
        border-color: #C9A227;
    }
    .btn-outline-gold:hover {
        background-color: #C9A227;
        color: #4E342E;
    }
</style>
@endsection
