@extends('layouts.adminlte')

@section('content')
@php
    $prefix = auth()->user()->role === 'admin' ? 'admin' : 'resepsionis';
@endphp

<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-lg overflow-hidden">

        {{-- HEADER --}}
        <div class="card-header bg-pink-gradient text-white d-flex justify-content-between align-items-center">
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

            {{-- Judul --}}
            <h6 class="mb-3 text-secondary fw-bold">
                <i class="fa-solid fa-address-book me-2"></i>List Tamu Terdaftar
            </h6>

            {{-- Tabel --}}
            @if ($guests->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="fa-solid fa-face-sad-tear fa-2x mb-3"></i><br>
                    Belum ada data tamu.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
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
                                        <a href="{{ route($prefix . '.guests.edit', $guest->id) }}"
                                           class="btn btn-warning btn-sm me-1" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route($prefix . '.guests.destroy', $guest->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus tamu ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</div>

{{-- Custom Styles --}}
<style>
    .bg-pink-gradient {
        background: linear-gradient(90deg, #f8bbd0, #f48fb1);
    }

    .text-pink {
        color: #d63384 !important;
    }

    .bg-soft-pink {
        background-color: #ffe2ec;
    }

    .btn-light.text-pink:hover {
        background-color: #f1a5c3 !important;
        color: white !important;
    }

    .table th, .table td {
        vertical-align: middle;
    }

    .badge {
        font-size: 0.9rem;
        padding: 0.45em 0.8em;
        border-radius: 1rem;
    }
</style>
@endsection
