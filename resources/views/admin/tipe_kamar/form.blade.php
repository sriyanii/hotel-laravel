@extends('layouts.adminlte')

@section('content')
<div class="container py-4">

    {{-- Card Form --}}
    <div class="card shadow border-0">
        {{-- Card Header --}}
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #3d3d3d">
            <div>
                <i class="fas fa-bed me-2"></i>
                <span class="fw-bold">{{ $tipe ? 'Edit Tipe Kamar' : 'Tambah Tipe Kamar' }}</span>
            </div>
            <a href="{{ route('admin.tipe_kamar.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.tipe_kamar.save') }}" method="POST">
                @csrf
                @if($tipe)
                    <input type="hidden" name="id" value="{{ $tipe->id }}">
                @endif

                <div class="mb-3">
                    <label for="tipe_kamar" class="form-label fw-semibold">Tipe Kamar</label>
                    <input type="text" name="tipe_kamar" class="form-control" value="{{ $tipe->tipe_kamar ?? '' }}" required>
                </div>

                <div class="mb-3">
                    <label for="jumlah_kamar" class="form-label fw-semibold">Jumlah Kamar</label>
                    <input type="number" name="jumlah_kamar" class="form-control" value="{{ $tipe->jumlah_kamar ?? '' }}" required>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-dark">
                        <i class="me-1"></i> Simpan
                    </button>
                    <a href="{{ route('admin.tipe_kamar.index') }}" class="btn btn-secondary">
                        <i class="me-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Custom CSS --}}
<style>
    body {
        background-color: #f8f9fa; /* abu-abu muda */
    }

    .card {
        background-color: #ffffff;
    }

    .card-header {
        font-size: 1.25rem;
    }

    .form-control:focus {
        border-color: #6c757d;
        box-shadow: 0 0 0 0.2rem rgba(108,117,125,.25);
    }

    .btn-dark {
        background-color: #343a40;
        border-color: #343a40;
        color: #fff;
    }

    .btn-dark:hover {
        background-color: #495057;
        border-color: #495057;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        color: #fff;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #5a6268;
    }
</style>
@endsection
