@extends('layouts.adminlte')

@section('title', 'Profil Resepsionis')

@section('content')
<div class="container-fluid">
    <h4><i class="fa fa-user"></i> Profil Resepsionis</h4>
    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ auth()->user()->name }}</p>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
            <p><strong>Role:</strong> <span class="badge bg-info text-dark">Resepsionis</span></p>

            <a href="{{ route('resepsionis.profile.edit') }}" class="btn btn-primary">Edit Profil</a>
            <a href="{{ route('resepsionis.profile.change-password.show') }}" class="btn btn-warning text-white">Ganti Password</a>
        </div>
    </div>
</div>
@endsection