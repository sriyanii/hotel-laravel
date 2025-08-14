@extends('layouts.adminlte')

@section('title', 'Profil Admin')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4" style="color:#d63384;"><i class="fa fa-user-shield me-2"></i>Profil Admin</h4>

    <div class="card shadow-sm border-0 rounded-3" style="background-color: #ffe6f0;">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 fw-bold" style="color:#c82375;">Nama:</div>
                <div class="col-md-9">{{ auth()->user()->name }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold" style="color:#c82375;">Email:</div>
                <div class="col-md-9">{{ auth()->user()->email }}</div>
            </div>
            <div class="row mb-4">
                <div class="col-md-3 fw-bold" style="color:#c82375;">Role:</div>
                <div class="col-md-9">
                    <span class="badge rounded-pill" style="background-color:#e83e8c; color:white;">Admin</span>
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.profile.edit') }}" class="btn rounded-pill shadow-sm" style="background-color:#e83e8c; color:white;">
                    <i class="fa fa-edit me-1"></i> Edit Profil
                </a>
                <a href="{{ route('admin.profile.change-password.show') }}" class="btn rounded-pill shadow-sm" style="background-color:#c82375; color:white;">
                    <i class="fa fa-key me-1"></i> Ganti Password
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .card-body a.btn:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        transition: 0.2s;
    }
</style>
@endsection
