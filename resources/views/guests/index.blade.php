@extends('layouts.adminlte')

@section('content')
@php
    $prefix = auth()->user()->role === 'admin' ? 'admin' : 'resepsionis';
@endphp

<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-lg overflow-hidden">

        {{-- HEADER --}}
        <div class="card-header text-white d-flex justify-content-between align-items-center" style="background: #3d3d3d">
            <h4 class="mb-0">
                <i class="fa-solid fa-users me-2"></i> Data Tamu
            </h4>
            <a href="{{ route($prefix . '.guests.create') }}" class="btn btn-light text-pink fw-semibold">
                <i class="fas fa-plus me-1"></i> Tambah Tamu
            </a>
        </div>

        {{-- BODY --}}
        <div class="card-body">
            {{-- Notifikasi --}}
            @if (session('success'))
                <div class="alert alert-success rounded-pill px-4 py-2 mb-4">
                    <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            {{-- Search Form --}}
            <form action="{{ route($prefix . '.guests.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" value="{{ request()->search }}" class="form-control" placeholder="Cari Tamu..." aria-label="Search Guests">
                    <button type="submit" class="btn btn-outline-secondary">
                        <i class="fas fa-search"></i>
                    </button>
                    {{-- Tombol Reset --}}
                    <a href="{{ route($prefix . '.guests.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>
            

            {{-- Judul --}}
            <h6 class="mb-3 text-secondary fw-bold">
                <i class="fa-solid fa-address-book me-2"></i>List Tamu Terdaftar
            </h6>

            <div class="col-12 col-md-3 text-md-end mb-3">
                    <div class="d-flex flex-wrap justify-content-md-start gap-2">
                <!-- <a href="{{ route('guests.calendar') }}" 
                class="btn btn-sm btn-outline-secondary rounded-pill px-3 shadow-sm">
                <i class="fas fa-calendar me-1"></i> Kalender
                </a> -->

                <a href="{{ route('guests.timeline') }}" 
                class="btn btn-sm btn-outline-secondary rounded-pill px-3 shadow-sm">
                    <i class="fas fa-timeline me-1"></i> Timeline
                </a>
                    </div>
            </div>

            

            {{-- Tabel --}}
            @if ($guests->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="fa-solid fa-face-sad-tear fa-2x mb-3"></i><br>
                    Belum ada data tamu.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-start">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>No Identitas</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($guests as $guest)
                                <tr>
                                    <td>{{ $guest->name }}</td>
                                    <td>{{ $guest->phone }}</td>
                                    <td>
                                        <span class="badge bg-soft-pink text-dark">
                                            {{ $guest->identity_number }}
                                        </span>
                                    </td>
                                    <td class="text-center">

                                        <a href="{{ route($prefix . '.guests.edit', $guest->id) }}" class="btn btn-sm btn-outline-warning rounded-circle" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="{{ route($prefix . '.guests.show', $guest->id) }}" class="btn btn-sm btn-outline-info rounded-circle" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <form action="{{ route($prefix . '.guests.destroy', $guest->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus tamu ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger btn-delete rounded-circle" title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- PAGINATION --}}
            @if($guests->hasPages())
                <div class="d-flex justify-content-end my-4" style="margin-right: 30px;">
                    {{ $guests->appends(request()->query())->links() }}
                </div>
            @endif

        </div>

    </div>
</div>

{{-- Custom Styles --}}
<style>
    .text-pink {
        color:rgb(14, 13, 13) !important;
    }

    .bg-soft-pink {
        background-color:rgb(202, 202, 202);
    }

    .btn-light.text-pink:hover {
        background-color:rgb(179, 174, 176) !important;
        color: white !important;
    }

    .table th, .table td {
        vertical-align: middle;
        padding: 10px;
    }

    .table th {
        text-align: left;
    }

    .badge {
        font-size: 0.9rem;
        padding: 0.45em 0.8em;
        border-radius: 1rem;
    }
</style>
@endsection
