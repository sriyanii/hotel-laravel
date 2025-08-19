@extends('layouts.adminlte')

@section('title', 'Manajemen Kamar')

@section('content_header')
    <h1 class="fw-bold text-dark"><i class="fas fa-bed me-2 text-white"></i>Manajemen Kamar</h1>
@stop

@php use Illuminate\Support\Facades\Storage; @endphp

@section('content')
@php
    $prefix = auth()->user()->role === 'admin' ? 'admin' : 'resepsionis';
@endphp

<div class="container-fluid py-3">
    <div class="card shadow border-0 rounded-4 overflow-hidden">

        {{-- HEADER --}}
        <div class="card-header text-white py-3 d-flex justify-content-between align-items-center" style="background: #3d3d3d">
            <h4 class="mb-0 fw-bold"><i class="fas fa-bed me-2"></i> Manajemen Kamar</h4>
            @if (auth()->user()->role === 'admin')
                <a href="{{ route($prefix . '.rooms.create') }}" class="btn btn-light text-dark fw-semibold">
                    <i class="fa fa-plus me-1"></i> Tambah Kamar
                </a>
            @endif
        </div>

        {{-- FILTER --}}
        <div class="card-body border-bottom bg-light">
            <form class="row gy-3 gx-3 align-items-center" method="GET" action="{{ route($prefix . '.rooms.index') }}">
                {{-- Kolom Pencarian --}}
                <div class="col-12 col-md-6">
                    <input 
                        type="search" 
                        name="search" 
                        class="form-control rounded-pill shadow-sm" 
                        placeholder="Cari tipe kamar..." 
                        value="{{ request('search') }}">
                </div>

                {{-- Kolom Filter Status --}}
                <div class="col-12 col-md-6 text-md-end">
                    <div class="btn-group flex-wrap gap-2">
                        @foreach(['all' => 'Semua', 'tersedia' => 'Tersedia', 'terisi' => 'Terisi', 'maintenance' => 'Maintenance'] as $status => $label)
                            <a href="{{ route($prefix . '.rooms.index', array_merge(['status_filter' => $status], request()->except('status_filter', 'page'))) }}"
                               class="btn btn-sm {{ request('status_filter', 'all') === $status ? 'btn-outline-secondary' : 'btn-outline-secondary' }} rounded-pill px-3 shadow-lg">
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
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if ($room->photo)
                                <img src="{{ Storage::url($room->photo) }}" class="rounded-3 shadow-sm" style="height: 60px; width: 100px; object-fit: cover;">
                            @else
                                <span class="text-muted fst-italic">Tidak ada</span>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $room->type }}</td>
                        <td>{{ $room->number }}</td>
                        <td>Rp{{ number_format($room->price, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge px-3 py-2 rounded-pill bg-{{ $room->status === 'tersedia' ? 'success' : ($room->status === 'terisi' ? 'danger' : ($room->status === 'maintenance' ? 'warning' : 'secondary')) }}">
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
                <div class="d-flex justify-content-center my-4">
                    {{ $rooms->appends(request()->query())->links() }}
                </div>
            @endif
            @endif
        </div>

    </div>
</div>

{{-- STYLE --}}
<!-- <style>
    .bg-gradient-pink {
        background: linear-gradient(90deg, #f48fb1, #f06292);
    }
    .table-gold thead {
        background: #C9A227;
        color: #fff;
    }
    .btn-gold-soft {
        background-color: #C9A227;
        color: #fff;
    }
    .btn-gold-soft:hover {
        background-color: #b8921f;
        color: white;
    }
    .btn-outline-gold-soft {
        border: 1px solid #C9A227;
        color: #C9A227;
        background: white;
    }
    .btn-outline-gold-soft:hover {
        background-color: #C9A227;
        color: white;
    }
    .table-hover tbody tr:hover {
        background-color: #fff8e1;
    }
</style> -->
@endsection
