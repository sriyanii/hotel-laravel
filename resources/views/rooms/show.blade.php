@extends('layouts.adminlte')

@section('title', 'Detail Kamar')

@section('content_header')
    <h1 class="text-dark">Detail Kamar</h1>
@stop

@section('content')
@php
    $prefix = auth()->user()->role === 'admin' ? 'admin' : 'resepsionis';
@endphp

<div class="container-fluid py-3" style="background-color: #FAF6F0;">
    <div class="card border-0 shadow rounded-4" style="border-top: 4px solid #C9A227;">
        <div class="card-header bg-gradient-gold d-flex justify-content-between align-items-center rounded-top-4">
            <h4 class="fw-bold mb-0 text-dark">
                <i class="fas fa-door-open me-2"></i> Detail Kamar
            </h4>
            <a href="{{ route($prefix . '.rooms.index') }}" class="btn btn-sm btn-outline-light rounded-pill">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card-body" style="background-color: #fff;">
            <div class="row align-items-center g-4">
                <div class="col-md-5 text-center">
                    @if ($room->photo)
                        <img src="{{ asset('storage/' . $room->photo) }}"
                             class="img-fluid rounded shadow-sm border" 
                             style="max-height: 260px; object-fit: cover; border-color: #C9A227 !important;" 
                             alt="Foto kamar">
                    @else
                        <div class="text-muted fst-italic">Tidak ada foto kamar</div>
                    @endif
                </div>
                <div class="col-md-7">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th class="w-30" style="color: #4E342E;">Nomor</th>
                            <td>: {{ $room->number }}</td>
                        </tr>
                        <tr>
                            <th style="color: #4E342E;">Tipe</th>
                            <td>: {{ $room->type }}</td>
                        </tr>
                        <tr>
                            <th style="color: #4E342E;">Harga</th>
                            <td>: Rp{{ number_format($room->price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th style="color: #4E342E;">Status</th>
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
            <hr class="my-4" style="border-color: #C9A227;">
            <div class="px-2">
                <h5 class="fw-semibold" style="color: #4E342E;">
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
<style>
    .bg-gradient-gold {
        background: linear-gradient(90deg, #C9A227, #FFD700);
    }
    .content-wrapper {
        background-color: #FAF6F0;
    }
    .btn-outline-light {
        border-color: #fff;
        color: #fff;
    }
    .btn-outline-light:hover {
        background-color: rgba(255,255,255,0.1);
    }
    .text-dark {
        color: #4E342E !important;
    }
    .card {
        box-shadow: 0 4px 12px rgba(78, 52, 46, 0.1);
    }
</style>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop