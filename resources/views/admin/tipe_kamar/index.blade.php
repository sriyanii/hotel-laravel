@extends('layouts.adminlte')

@section('content')

<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-lg overflow-hidden">

        <div class="card-header text-white d-flex justify-content-between align-items-center" style="background: #3d3d3d">
            <h4 class="mb-0">
                <i class="fas fa-bed me-2"></i> Daftar Tipe Kamar
            </h4>
            <a href="{{ route('admin.tipe_kamar.form') }}" class="btn btn-light text-dark fw-semibold">
                <i class="fas fa-plus me-1"></i> Tambah Tipe Kamar
            </a>
        </div>

        <div class="card-body">
            {{-- Pencarian --}}
            <form action="{{ route(auth()->user()->role . '.tipe_kamar.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari Tipe Kamar" aria-label="Search Tipe Kamar">
                    <button type="submit" class="btn btn-outline-secondary">
                        <i class="fas fa-search"></i>
                    </button>
                    {{-- Tombol Reset --}}
                    <a href="{{ route(auth()->user()->role . '.tipe_kamar.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>

            <h6 class="mb-3 text-secondary fw-bold">
                <i class="fas fa-list me-2"></i> List Tipe Kamar
            </h6>

            <div class="table-responsive">
                @if($tipeKamar->isEmpty())
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-bed fa-2x mb-3"></i><br>
                        Tidak ada tipe kamar yang ditemukan.
                    </div>
                @else
                    <table class="table table-hover align-middle text-center mt-3">
                        <thead style="background-color: rgba(128,128,128,0.2);">
                            <tr>
                                <th>ID</th>
                                <th>Tipe Kamar</th>
                                <th>Jumlah Kamar</th>
                                <th>Kamar Tersedia</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tipeKamar as $tipe)
                                <tr>
                                    <td>{{ $tipe->id }}</td>
                                    <td>{{ $tipe->tipe_kamar }}</td>
                                    <td>{{ $tipe->jumlah_kamar }}</td>
                                    <td>
                                        {{-- Menghitung kamar tersedia --}}
                                        {{ $tipe->jumlah_kamar - $tipe->rooms()->whereIn('status', ['terisi', 'maintenance', 'dipesan'])->count() }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.tipe_kamar.edit', $tipe->id) }}" class="btn btn-sm btn-outline-warning rounded-circle">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="{{ route('admin.tipe_kamar.show', $tipe->id) }}" class="btn btn-sm btn-outline-info rounded-circle">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <form action="{{ route('admin.tipe_kamar.delete', $tipe->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-delete btn-outline-danger rounded-circle">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </div>
</div>

@endsection
