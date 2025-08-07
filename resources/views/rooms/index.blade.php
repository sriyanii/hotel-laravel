@extends('layouts.adminlte')

@section('title', 'Manajemen Kamar')

@section('content_header')
    <h1>Manajemen Kamar</h1>
@stop
@php use Illuminate\Support\Facades\Storage; @endphp
@section('content')

@php
    $prefix = auth()->user()->role === 'admin' ? 'admin' : 'resepsionis';
@endphp

<div class="container-fluid py-3">
    <div class="card shadow-sm border-0 rounded-lg">

        {{-- HEADER --}}
        <div class="card-header bg-pink-soft text-dark d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-semibold"><i class="fas fa-bed me-2"></i> Manajemen Kamar</h4>
            @if (auth()->user()->role === 'admin')
                <a href="{{ route($prefix . '.rooms.create') }}" class="btn btn-sm btn-outline-pink rounded-pill fw-semibold">
                    <i class="fa fa-plus me-1"></i> Tambah Kamar
                </a>
            @endif
        </div>

        {{-- FILTER --}}
<div class="card-body border-bottom">
    <form class="row gy-3 gx-3 align-items-center justify-content-between" method="GET" action="{{ route($prefix . '.rooms.index') }}">
        {{-- Kolom Pencarian --}}
        <div class="col-12 col-md-6">
            <input 
                type="search" 
                name="search" 
                class="form-control rounded-pill" 
                placeholder="Cari tipe kamar..." 
                value="{{ request('search') }}">
        </div>

        {{-- Kolom Filter Status --}}
        <div class="col-12 col-md-6 text-md-end text-start">
            <div class="btn-group flex-wrap gap-2 d-flex justify-content-md-end justify-content-start">
                @foreach(['all' => 'Semua', 'tersedia' => 'Tersedia', 'terisi' => 'Terisi', 'maintenance' => 'Maintenance'] as $status => $label)
                    <a href="{{ route($prefix . '.rooms.index', array_merge(['status_filter' => $status], request()->except('status_filter', 'page'))) }}"
                       class="btn btn-sm {{ request('status_filter', 'all') === $status ? 'btn-pink-soft text-white' : 'btn-outline-pink-soft' }} rounded-pill">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>
    </form>
</div>


        {{-- TABLE --}}
        <div class="table-responsive px-3">
            @if($rooms->isEmpty())
                <div class="alert alert-warning m-3 text-center">
                    <i class="fas fa-exclamation-triangle me-1"></i> Tidak ada kamar ditemukan.
                </div>
            @else
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Tipe</th>
                        <th>No. Kamar</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rooms as $room)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if ($room->photo)
                                <img src="{{ Storage::url($room->photo) }}" alt="Foto" class="rounded" style="height: 60px; width: 100px; object-fit: cover;">
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                        <td>{{ $room->type }}</td>
                        <td>{{ $room->number }}</td>
                        <td>Rp{{ number_format($room->price, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $room->status === 'tersedia' ? 'success' : ($room->status === 'terisi' ? 'danger' : ($room->status === 'maintenance' ? 'warning' : 'secondary')) }}">
                                {{ ucfirst($room->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center align-items-center gap-1">
                                <a href="{{ route($prefix . '.rooms.edit', $room->id) }}" class="btn btn-sm btn-outline-warning rounded-circle" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route($prefix . '.rooms.show', $room->id) }}" class="btn btn-sm btn-outline-info rounded-circle" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if (auth()->user()->role === 'admin')
                                <form action="{{ route($prefix . '.rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kamar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-circle" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- PAGINATION --}}
            @if($rooms->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $rooms->appends(request()->query())->links() }}
                </div>
            @endif
            @endif
        </div>

    </div>
</div>

{{-- STYLE --}}
<style>
    .bg-pink-soft {
        background: linear-gradient(90deg, #fce4ec, #f8bbd0);
    }
    .btn-pink-soft {
        background-color: #f8bbd0;
        color: #6a1b4d;
        border: 1px solid transparent;
    }
    .btn-pink-soft:hover {
        background-color: #f48fb1;
        color: white;
    }
    .btn-outline-pink-soft {
        border: 1px solid #f48fb1;
        color: #c2185b;
        background-color: white;
    }
    .btn-outline-pink-soft:hover {
        background-color: #f8bbd0;
        color: #6a1b4d;
    }
    .content-wrapper {
        background-color: #f4f6f9;
    }
</style>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop