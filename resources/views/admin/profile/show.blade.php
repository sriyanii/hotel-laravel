@extends('layouts.adminlte')

@section('title', 'Profil Admin')

@section('content')
<div class="container-fluid" style="background-color: #FAF6F0; padding: 20px; border-radius: 10px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0" style="color: #4E342E;">
            <i class="fas fa-user-cog me-2" style="color: #C9A227;"></i>Profil Admin
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="background: transparent;">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" style="color: #C9A227;">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="color: #4E342E;">Profil</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- Informasi Profil -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-lg mb-4" style="background-color: #ffffff;">
                <div class="card-header border-0 py-3" style="background-color: #C9A227; color: white;">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Profil</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th width="30%" style="color: #4E342E;">Nama Lengkap</th>
                                    <td>{{ auth()->user()->name }}</td>
                                </tr>
                                <tr>
                                    <th style="color: #4E342E;">Email</th>
                                    <td>{{ auth()->user()->email }}</td>
                                </tr>
                                <tr>
                                    <th style="color: #4E342E;">Peran</th>
                                    <td><span class="badge" style="background-color: #C9A227;">Admin</span></td>
                                </tr>
                                <tr>
                                    <th style="color: #4E342E;">Bergabung Sejak</th>
                                    <td>{{ auth()->user()->created_at->format('d F Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('admin.profile.edit') }}" class="btn me-2" style="background-color: #C9A227; color: white; border: none;">
                            <i class="fas fa-edit me-1"></i> Edit Profil
                        </a>
                        <a href="{{ route('admin.profile.change-password.show') }}" class="btn" style="border: 1px solid #C9A227; color: #C9A227;">
                            <i class="fas fa-key me-1"></i> Ganti Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Keamanan Akun -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-lg" style="background-color: #ffffff;">
                <div class="card-header border-0 py-3" style="background-color: #C9A227; color: white;">
                    <h5 class="mb-0"><i class="fas fa-shield-alt me-2"></i>Keamanan Akun</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-success d-flex align-items-center mb-3" style="background-color: #eaf2e0; color: #4E342E;">
                        <i class="fas fa-check-circle me-2" style="color: #C9A227;"></i>
                        <div>
                            <strong>Email Terverifikasi</strong>
                            <div class="small">Email Anda telah diverifikasi</div>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning d-flex align-items-center" style="background-color: #fff6e0; color: #4E342E;">
                        <i class="fas fa-exclamation-triangle me-2" style="color: #FFD700;"></i>
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
                    
                    <hr>
                    
                    <h5 class="mb-3" style="color: #4E342E;">
                        <i class="fas fa-clock me-2" style="color: #C9A227;"></i>Login Terakhir
                    </h5>
                    <div class="small" style="color: #4E342E;">
                        @if(auth()->user()->last_login_at)
                            <i class="fas fa-calendar-alt me-1"></i> 
                            {{ auth()->user()->last_login_at->format('d F Y H:i') }}
                            <br>
                            <i class="fas fa-globe me-1"></i> 
                            {{ auth()->user()->last_login_ip ?? 'Tidak diketahui' }}
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
    .card {
        transition: transform 0.2s ease;
    }
    .card:hover {
        transform: translateY(-2px);
    }
</style>
@endsection
