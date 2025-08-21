@extends('layouts.adminlte')

@section('title', 'Profil Admin')

@section('content')
<div class="container-fluid py-4" style="background: linear-gradient(135deg, #FAF6F0 0%, #F5EDE3 100%); min-height: 100vh;">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">
            <i class="fas fa-user-cog text-warning me-2"></i>Profil Admin
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 bg-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}" class="text-warning fw-medium">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active text-muted">Profil</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4">
        <!-- Kolom Kiri: Foto Profil & Ringkasan -->
        <div class="col-lg-4">
            <!-- Kartu Profil -->
            <div class="card shadow-sm border-0 overflow-hidden" style="border-radius: 16px;">
                <div class="card-header bg-warning bg-opacity-10 py-4 border-0 position-relative">
                    <div class="position-absolute top-0 end-0 mt-3 me-3">
                        <span class="badge bg-warning text-dark">
                            <i class="fas fa-star me-1"></i> Admin
                        </span>
                    </div>
                    <div class="text-center">
                        <div class="position-relative d-inline-block mb-3">
                            <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('images/default-avatar.png') }}"
                                 alt="Foto Profil"
                                 class="rounded-circle img-fluid shadow"
                                 width="120" height="120"
                                 style="object-fit: cover; border: 4px solid white; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                            <span class="position-absolute bottom-0 end-0 bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                                  style="width: 30px; height: 30px; border: 2px solid white;">
                                <i class="fas fa-check" style="font-size: 0.7rem;"></i>
                            </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">{{ auth()->user()->name }}</h5>
                        <p class="text-muted mb-2">
                            <i class="fas fa-envelope me-1"></i> {{ auth()->user()->email }}
                        </p>
                    </div>
                </div>
                <div class="card-body p-4">
                    <!-- Statistik Sederhana -->
                    <div class="row text-center mb-3">
                        <div class="col-6 border-end">
                            <div class="text-muted small">Bergabung</div>
                            <div class="fw-bold text-dark">{{ auth()->user()->created_at->format('d M Y') }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted small">Status</div>
                            <div class="fw-bold text-success">
                                <i class="fas fa-circle me-1" style="font-size: 0.6rem;"></i> Aktif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Progress Keamanan -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small fw-bold">Keamanan Akun</span>
                            <span class="text-dark fw-bold">85%</span>
                        </div>
                        <div class="progress" style="height: 8px; border-radius: 10px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 85%"></div>
                        </div>
                    </div>
                    
                    <!-- Tombol Aksi -->
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.profile.edit') }}" class="btn btn-warning text-white">
                            <i class="fas fa-edit me-2"></i> Edit Profil
                        </a>
                        <a href="{{ route('admin.profile.change-password.show') }}" class="btn btn-outline-warning">
                            <i class="fas fa-lock me-2"></i> Ganti Password
                        </a>
                    </div>
                </div>
            </div>

            <!-- Panel Akses Cepat -->
            <!-- <div class="card mt-4 shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-header bg-white border-0">
                    <h6 class="mb-0 text-dark fw-bold">
                        <i class="fas fa-rocket text-warning me-2"></i> Akses Cepat
                    </h6>
                </div>
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-warning text-start py-2">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard Utama
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-warning text-start py-2">
                            <i class="fas fa-users me-2"></i> Kelola Pengguna
                        </a>
                    </div>
                </div>
            </div> -->
        </div>

        <!-- Kolom Kanan: Detail Profil & Aktivitas -->
        <div class="col-lg-8">
            <!-- Informasi Pribadi -->
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 16px;">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark fw-bold">
                        <i class="fas fa-user-circle text-warning me-2"></i>Informasi Pribadi
                    </h5>
                    <span class="badge bg-warning bg-opacity-10 text-warning">Lengkap</span>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-center">
                                <div class="icon-container bg-warning bg-opacity-10 rounded p-3 me-3">
                                    <i class="fas fa-user text-warning"></i>
                                </div>
                                <div>
                                    <label class="form-label text-muted small fw-bold mb-0">Nama Lengkap</label>
                                    <p class="mb-0 text-dark fw-medium">{{ auth()->user()->name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-center">
                                <div class="icon-container bg-warning bg-opacity-10 rounded p-3 me-3">
                                    <i class="fas fa-envelope text-warning"></i>
                                </div>
                                <div>
                                    <label class="form-label text-muted small fw-bold mb-0">Email</label>
                                    <p class="mb-0 text-dark fw-medium">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-center">
                                <div class="icon-container bg-warning bg-opacity-10 rounded p-3 me-3">
                                    <i class="fas fa-phone text-warning"></i>
                                </div>
                                <div>
                                    <label class="form-label text-muted small fw-bold mb-0">Telepon</label>
                                    <p class="mb-0 text-dark fw-medium">{{ auth()->user()->phone ?? 'Belum diatur' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-center">
                                <div class="icon-container bg-warning bg-opacity-10 rounded p-3 me-3">
                                    <i class="fas fa-map-marker-alt text-warning"></i>
                                </div>
                                <div>
                                    <label class="form-label text-muted small fw-bold mb-0">Alamat</label>
                                    <p class="mb-0 text-dark fw-medium">{{ auth()->user()->address ?? 'Belum diatur' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-0">
                            <div class="d-flex align-items-center">
                                <div class="icon-container bg-warning bg-opacity-10 rounded p-3 me-3">
                                    <i class="fas fa-calendar-alt text-warning"></i>
                                </div>
                                <div>
                                    <label class="form-label text-muted small fw-bold mb-0">Bergabung Sejak</label>
                                    <p class="mb-0 text-dark fw-medium">{{ auth()->user()->created_at->format('d F Y') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-0">
                            <div class="d-flex align-items-center">
                                <div class="icon-container bg-warning bg-opacity-10 rounded p-3 me-3">
                                    <i class="fas fa-clock text-warning"></i>
                                </div>
                                <div>
                                    <label class="form-label text-muted small fw-bold mb-0">Login Terakhir</label>
                                    <p class="mb-0 text-dark fw-medium">
                                        {{ auth()->user()->last_login_at ? auth()->user()->last_login_at->diffForHumans() : 'Tidak ada data' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aktivitas Terakhir & Notifikasi -->
            <!-- <div class="card shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 text-dark fw-bold">
                        <i class="fas fa-bell text-warning me-2"></i>Aktivitas Terakhir & Notifikasi
                    </h5>
                </div>
                <div class="card-body p-4">
                    <ul class="list-group list-group-flush"> -->
                        <!-- Notifikasi 1 -->
                        <!-- <li class="list-group-item px-0 py-3 border-0">
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle bg-info bg-opacity-10 p-2 me-3">
                                    <i class="fas fa-user-plus text-info"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-medium">Pengguna baru terdaftar: <strong>Andi Pratama</strong></p>
                                    <small class="text-muted">Hari ini, 11:30 AM • IP: 192.168.1.10</small>
                                </div>
                                <span class="badge bg-info bg-opacity-10 text-info small">Baru</span>
                            </div>
                        </li> -->

                        <!-- Notifikasi 2 -->
                        <!-- <li class="list-group-item px-0 py-3 border-0">
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle bg-warning bg-opacity-10 p-2 me-3">
                                    <i class="fas fa-exclamation-triangle text-warning"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-medium">Login gagal dari IP tidak dikenal</p>
                                    <small class="text-muted">Kemarin, 08:15 PM • IP: 103.45.22.11 (Brasil)</small>
                                </div>
                                <span class="badge bg-warning bg-opacity-10 text-warning small">Peringatan</span>
                            </div>
                        </li> -->

                        <!-- Notifikasi 3 -->
                        <!-- <li class="list-group-item px-0 py-3 border-0">
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3">
                                    <i class="fas fa-shield-alt text-success"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-medium">Backup harian berhasil diselesaikan</p>
                                    <small class="text-muted">Kemarin, 02:00 AM • Ukuran: 2.4 GB</small>
                                </div>
                                <span class="badge bg-success bg-opacity-10 text-success small">Sukses</span>
                            </div>
                        </li> -->

                        <!-- Notifikasi 4 -->
                        <!-- <li class="list-group-item px-0 py-3 border-0">
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                    <i class="fas fa-edit text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-medium">Profil Anda diperbarui</p>
                                    <small class="text-muted">2 hari lalu • Perubahan: Nomor telepon & alamat</small>
                                </div>
                            </div>
                        </li> -->
                    <!-- </ul> -->

                    <hr class="my-4">

                    <!-- Tombol Lihat Semua -->
                    

                    <!-- Pengumuman Internal -->
                    <!-- <div class="alert alert-warning bg-opacity-10 border-0 mt-4 p-3">
                        <i class="fas fa-megaphone me-2"></i>
                        <strong>Pengumuman:</strong> Sistem akan maintenance pada 15 April 2025, pukul 02:00 - 04:00 WIB. Harap siapkan data sebelumnya.
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gaya Kustom -->
<style>
    .card {
        border: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.1) !important;
    }

    .icon-container {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-warning {
        background: linear-gradient(135deg, #C9A227 0%, #E6C35C 100%);
        border: none;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s;
        padding: 10px 20px;
    }
    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(201, 162, 39, 0.3);
    }

    .btn-outline-warning {
        border: 2px solid #C9A227;
        color: #C9A227;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s;
        padding: 10px 20px;
    }
    .btn-outline-warning:hover {
        background: linear-gradient(135deg, #C9A227 0%, #E6C35C 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(201, 162, 39, 0.3);
    }

    .rounded-circle {
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .activity-item, .list-group-item {
        transition: all 0.3s;
    }
    .list-group-item:hover {
        background-color: #FFFBF0;
        border-radius: 10px;
    }
    
    .progress {
        overflow: visible;
    }
    .progress-bar {
        border-radius: 10px;
        position: relative;
    }
    .progress-bar:after {
        content: '';
        position: absolute;
        right: -5px;
        top: -3px;
        width: 15px;
        height: 15px;
        background-color: #C9A227;
        border-radius: 50%;
        border: 2px solid white;
        box-shadow: 0 0 0 2px #C9A227;
    }
    
    .btn-outline-warning.text-start {
        text-align: left;
        display: flex;
        align-items: center;
        padding: 10px 15px;
        margin-bottom: 8px;
        transition: all 0.3s;
    }
    
    .btn-outline-warning.text-start:hover {
        background-color: #FFFBF0;
    }

    .alert-warning {
        background-color: #fff3cd;
        border-left: 4px solid #C9A227;
    }
</style>
@endsection