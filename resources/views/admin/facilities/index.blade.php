@extends('layouts.adminlte')

@section('content')
<div class="container py-4">
  <div class="card">
    <div class="card-header text-white d-flex flex-wrap justify-content-between align-items-center" style="background: #3d3d3d">
      <h5 class="fs-4 mb-2 mb-md-0">
        <i class="fas fa-concierge-bell me-2"></i> Daftar Fasilitas
      </h5>
      <a href="{{ route('admin.facilities.create') }}" class="btn btn-light text-dark fw-semibold">+ Tambah Fasilitas</a>
    </div>

    <div class="card-body">
      {{-- Notifikasi --}}
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      {{-- Pencarian & Filter --}}
<form method="GET" action="{{ route('admin.facilities.index') }}" class="mb-3">
  <div class="d-flex flex-wrap gap-2">
    {{-- Input Pencarian --}}
    <div class="flex-grow-1" style="min-width: 200px;">
      <input type="text" name="q" class="form-control" placeholder="Cari fasilitas..." value="{{ request('q') }}">
    </div>

    {{-- Dropdown Status --}}
    <div style="min-width: 160px;">
      <select name="status" class="form-select">
        <option value="">-- Semua Status --</option>
        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
      </select>
    </div>

    {{-- Tombol Filter --}}
    <div>
      <button type="submit" class="btn btn-dark">Filter</button>
    </div>

    {{-- Tombol Reset --}}
    <div>
      <a href="{{ route('admin.facilities.index') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
  </div>
</form>



      {{-- Tabel --}}
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Id</th>
              <th>Nama</th>
              <th>Status</th>
              <th>Kapasitas</th>
              <th>Harga / Malam</th>
              <th>Dibuat</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @php
              $hasSearch = request('q') || request('status');
              $isEmpty = $facilities->count() === 0;
            @endphp

            @if($hasSearch && $isEmpty)
              <tr>
                <td colspan="7" class="text-center">
                  <div class="alert alert-warning mb-0 fw-bold">
                    <i class="fas fa-exclamation-circle"></i> Fasilitas yang anda cari tidak ada/belum dibuat.
                  </div>
                </td>
              </tr>
            @else
              @forelse($facilities as $f)
                <tr>
                  <td>{{ $f->id }}</td>
                  <td>{{ $f->name }}</td>
                  <td>
                    @if($f->status === 'active')
                      <span class="badge bg-success">Aktif</span>
                    @else
                      <span class="badge bg-secondary">Nonaktif</span>
                    @endif
                  </td>
                  <td>{{ $f->capacity ?? '-' }}</td>
                  <td>Rp {{ number_format($f->price_per_night ?? 0, 0, ',', '.') }}</td>
                  <td>{{ $f->created_at ? $f->created_at->format('Y-m-d') : '-' }}</td>
                  <td>
                    <div class="d-flex flex-wrap gap-1">
                      <a href="{{ route('admin.facilities.edit', $f) }}" class="btn btn-sm btn-outline-warning rounded-circle">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="{{ route('admin.facilities.show', $f) }}" class="btn btn-sm btn-outline-info rounded-circle">
                        <i class="fas fa-eye"></i>
                      </a>
                      <form action="{{ route('admin.facilities.destroy', $f) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-delete btn-outline-danger rounded-circle">
                          <i class="fas fa-trash"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center text-muted">Tidak ada data</td>
                </tr>
              @endforelse
            @endif
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      <div class="mt-3">
        {{ $facilities->links() }}
      </div>
    </div>
  </div>
</div>
@endsection
