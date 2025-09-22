@extends('layouts.adminlte')

@section('title', 'Manajemen Kamar')

@section('content_header')
    <h1 class="fw-bold text-dark"><i class="fas fa-bed me-2 text-white"></i>Manajemen Kamar</h1>
@stop

@section('content')
@php
    $prefix = auth()->user()->role === 'admin' ? 'admin' : 'resepsionis';
@endphp

<div class="container-fluid py-4">
    <div class="card shadow-sm border-0 rounded-2 overflow-hidden">

        {{-- HEADER --}}
        <div class="card-header text-white d-flex justify-content-between align-items-center rounded-top-2" style="background: #3d3d3d">
            <h4 class="mb-0 fw-bold"><i class="fas fa-bed me-2"></i> Manajemen Kamar</h4>
                @if (in_array(auth()->user()->role, ['admin', 'resepsionis']))
                <a href="{{ route($prefix . '.rooms.create') }}" class="btn btn-light text-dark fw-semibold">
                    <i class="fa fa-plus me-1"></i> Tambah Kamar
                </a>
            @endif
        </div>

        

        {{-- FILTER --}}
        <div class="card-body border-bottom" style="background-color:rgb(243, 243, 243)">
            <form class="row gy-3 gx-3 align-items-center" method="GET" action="{{ route($prefix . '.rooms.index') }}">
                {{-- Kolom Pencarian --}}
                <form action="{{ route($prefix . '.rooms.index') }}" method="GET" class="mb-4">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Cari Nama Tamu atau Kamar" value="{{ request('search') }}">
        <button type="submit" class="btn btn-outline-secondary ms-2">
            <i class="fas fa-search"></i>
        </button>
        @if(request('search'))
            <a href="{{ route($prefix . '.rooms.index') }}" class="btn btn-outline-secondary" title="Clear">
                <i class="fas fa-times"></i>
            </a>
        @endif
    </div>
</form>

<hr>

                {{-- Kolom Filter Status --}}
                <div class="col-12 col-md-6 text-md-end">
                    <div class="btn-group flex-wrap gap-2">
                        @foreach(['all' => 'Semua', 'tersedia' => 'Tersedia', 'terisi' => 'Terisi', 'maintenance' => 'Maintenance', 'dipesan' => 'Dipesan'] as $status => $label)
                            <a href="{{ route($prefix . '.rooms.index', array_merge(['status_filter' => $status], request()->except('status_filter', 'page'))) }}"
                               class="btn btn-sm {{ request('status_filter', 'all') === $status ? 'btn-primary' : 'btn-outline-secondary' }} rounded-pill px-3 shadow-sm">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>

        {{-- TABLE --}}
        <div class="table-responsive">
            @if($rooms->isEmpty())
                <div class="alert alert-warning m-3 text-center rounded-pill shadow-sm">
                    <i class="fas fa-exclamation-triangle me-1"></i> Tidak ada kamar ditemukan.
                </div>
            @else
            <table class="table table-hover align-middle mb-0">
                <thead class="table-gold">
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
                        <td>{{ $loop->iteration + ($rooms->currentPage() - 1) * $rooms->perPage() }}</td>
                        <td>
                            @if ($room->photo)
                                <img src="{{ asset('image/' . $room->photo) }}" class="rounded-3 shadow-sm" style="height: 60px; width: 100px; object-fit: cover;">
                            @else
                                <span class="text-muted fst-italic">Tidak ada</span>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $room->tipeKamar?->tipe_kamar ?? 'Tipe tidak ditemukan' }}</td>
                        <td>{{ $room->number }}</td>
                        <td>Rp{{ number_format($room->price, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge px-3 py-2 rounded-pill bg-{{ 
                                $room->status === 'tersedia' ? 'success' : 
                                ($room->status === 'terisi' ? 'danger' : 
                                ($room->status === 'maintenance' ? 'warning' : 
                                ($room->status === 'dipesan' ? 'info' : 'secondary'))) 
                            }}">
                                {{ ucfirst($room->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route($prefix . '.rooms.edit', $room->id) }}" class="btn btn-sm btn-outline-warning rounded-circle" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route($prefix . '.rooms.show', $room->id) }}" class="btn btn-sm btn-outline-info rounded-circle" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
@if (auth()->user()->role === 'admin' || auth()->user()->role === 'resepsionis')
                                <form action="{{ route($prefix . '.rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kamar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-delete btn-outline-danger rounded-circle" title="Hapus">
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
                <div class="d-flex justify-content-end my-4" style="margin-right: 30px;">
                    {{ $rooms->appends(request()->query())->links() }}
                </div>
            @endif
            @endif
        </div>

    </div>
</div>

<style>
    .table-gold {
        background: linear-gradient(135deg, #3d3d3d 0%, #5a5a5a 100%);
        color: white;
    }
    
    .table-gold th {
        border: none;
        padding: 15px 10px;
        font-weight: 600;
        text-align: center;
    }
    
    .table-gold th:first-child {
        border-top-left-radius: 10px;
    }
    
    .table-gold th:last-child {
        border-top-right-radius: 10px;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(61, 61, 61, 0.05);
    }
    
    .btn-outline-warning {
        border-color: #ffc107;
        color: #ffc107;
    }
    
    .btn-outline-warning:hover {
        background-color: #ffc107;
        color: #000;
    }
    
    .btn-outline-info {
        border-color: #0dcaf0;
        color: #0dcaf0;
    }
    
    .btn-outline-info:hover {
        background-color: #0dcaf0;
        color: #000;
    }
    
    .btn-outline-danger {
        border-color: #dc3545;
        color: #dc3545;
    }
    
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }
    
    .rounded-circle {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .badge {
        font-size: 0.85rem;
        font-weight: 500;
    }
    
    .bg-success { background-color: #198754 !important; }
    .bg-danger { background-color: #dc3545 !important; }
    .bg-warning { background-color: #ffc107 !important; color: #000; }
    .bg-info { background-color: #0dcaf0 !important; color: #000; }
    .bg-secondary { background-color: #6c757d !important; }
</style>
@endsection