@extends('layouts.adminlte')

@section('content')
<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
    <div class="d-flex align-items-center">
        <i class="fas fa-bed me-3" style="font-size: 1.5rem;"></i>
        <span style="font-size: 1.25rem;">Detail Tipe Kamar</span>
    </div>
        <a href="{{ route('admin.tipe_kamar.index') }}" class="btn btn-secondary btn-md" style="background-color: #6c757d; color: #fff; border: 1px solid #000;">
            Kembali
        </a>
    </div>
    <div class="card-body">
        <p><strong>ID:</strong> {{ $tipe->id }}</p>
        <p><strong>Tipe Kamar:</strong> {{ $tipe->tipe_kamar }}</p>
        <p><strong>Jumlah Kamar:</strong> {{ $tipe->jumlah_kamar }}</p>
    </div>
</div>
@endsection
