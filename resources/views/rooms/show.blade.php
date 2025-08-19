@extends('layouts.adminlte')

@section('title', 'Detail Kamar')

@section('content_header')
    <h1>Detail Kamar</h1>
@stop

@section('content')
@php
    $prefix = auth()->user()->role === 'admin' ? 'admin' : 'resepsionis';
@endphp

<div class="container-fluid py-3">
    <div class="card border-0 shadow rounded-4">
        <div class="card-header d-flex justify-content-between align-items-center rounded-top-4" style="background: #3d3d3d">
            <h4 class="fw-bold mb-0 text-white">
                <i class="fas fa-door-open me-2"></i> Detail Kamar
            </h4>
            <a href="{{ route($prefix . '.rooms.index') }}" class="btn btn-light btn-sm rounded-pill fw-semibold shadow-sm">
                <i class="fas fa-arrow-left me-1 text-dark"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <div class="row align-items-center g-4">
                <div class="col-md-5 text-center">
                    @if ($room->photo)
                        <img src="{{ asset('storage/' . $room->photo) }}"
                             class="img-fluid rounded shadow-sm" 
                             style="max-height: 260px; object-fit: cover;" 
                             alt="Foto kamar">
                    @else
                        <div class="text-muted fst-italic">Tidak ada foto kamar</div>
                    @endif
                </div>
                <div class="col-md-7">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th class="w-30 text-muted">Nomor</th>
                            <td>: {{ $room->number }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Tipe</th>
                            <td>: {{ $room->type }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Harga</th>
                            <td>: Rp{{ number_format($room->price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Status</th>
                            <td>: 
                                <span class="badge bg-{{ 
                                    $room->status === 'tersedia' ? 'success' : 
                                    ($room->status === 'terisi' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($room->status) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Deskripsi --}}
            <hr class="my-4">
            <div class="px-2">
                <h5 class="fw-semibold text-dark mb-2">
                    <i class="fas fa-align-left me-2"></i>Deskripsi Kamar
                </h5>
                <p class="text-muted" style="white-space: pre-line;">
                    {{ $room->description ?? 'Tidak ada deskripsi.' }}
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Styling tambahan --}}
<!-- <style>
    .bg-pink-soft {
        background: linear-gradient(90deg, #fce4ec, #f8bbd0);
    }
    .content-wrapper {
        background-color: #f4f6f9;
    }
</style> -->
@endsection

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop


