@extends('layouts.adminlte')

@section('content')
@php
    $prefix = auth()->user()->role === 'admin' ? 'admin' : 'resepsionis';
@endphp

<div class="container py-4" style="background-color: #FAF6F0;">
    <div class="card shadow-sm border-0 rounded-lg overflow-hidden" style="border-top: 4px solid #C9A227;">

        {{-- HEADER --}}
        <div class="card-header bg-gradient-gold text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="fa-solid fa-users me-2"></i> Data Tamu
            </h4>
            <a href="{{ route($prefix . '.guests.create') }}" class="btn btn-light text-gold fw-semibold">
                <i class="fas fa-plus me-1"></i> Tambah Tamu
            </a>
        </div>

        {{-- BODY --}}
        <div class="card-body" style="background-color: #fff;">
            {{-- Notifikasi --}}
            @if (session('success'))
                <div class="alert alert-success rounded-pill px-4 py-2 mb-4" style="border-left: 4px solid #4E342E;">
                    <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            {{-- Judul --}}
            <h6 class="mb-3 fw-bold" style="color: #4E342E;">
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
                        <thead class="table-light" style="background-color: #f5f5f5;">
                            <tr>
                                <th style="color: #4E342E;">Nama</th>
                                <th style="color: #4E342E;">Telepon</th>
                                <th style="color: #4E342E;">No Identitas</th>
                                <th class="text-center" style="color: #4E342E;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($guests as $guest)
                                <tr>
                                    <td>{{ $guest->name }}</td>
                                    <td>{{ $guest->phone }}</td>
                                    <td>
                                        <span class="badge bg-soft-gold">
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
    .bg-gradient-gold {
        background: linear-gradient(90deg, #C9A227, #FFD700);
    }

    .text-gold {
        color: #C9A227 !important;
    }

    .bg-soft-gold {
        background-color: #FFF8E1;
        color: #4E342E;
    }

    .btn-light.text-gold:hover {
        background-color: #C9A227 !important;
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

    .card {
        box-shadow: 0 4px 12px rgba(78, 52, 46, 0.1);
    }

    .table-light {
        background-color: #f9f9f9;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(201, 162, 39, 0.05);
    }
</style>
@endsection