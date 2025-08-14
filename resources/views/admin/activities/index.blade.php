@extends('layouts.adminlte')

@section('content')
<style>
    :root {
        --gold-primary: #C9A227;
        --gold-light: #FFD700;
        --cream-bg: #FAF6F0;
        --dark-brown: #4E342E;
        --dark-secondary: #3E2723;
    }

    body {
        background-color: var(--cream-bg);
    }

    /* Modern Gold Theme */
    .bg-primary-soft {
        background-color: rgba(201, 162, 39, 0.1) !important;
    }

    .text-primary {
        color: var(--dark-brown) !important;
    }

    .text-primary-soft {
        color: var(--gold-primary) !important;
    }

    .badge-gold-pill {
        background-color: var(--gold-primary);
        color: var(--dark-brown);
        border-radius: 50rem;
        padding: 0.35em 0.8em;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .badge-gold-pill-outline {
        background-color: transparent;
        border: 1px solid var(--gold-primary);
        color: var(--dark-brown);
        border-radius: 50rem;
        padding: 0.35em 0.8em;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .card-modern {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 4px 15px rgba(201, 162, 39, 0.12);
    }

    .table-modern thead {
        background-color: rgba(201, 162, 39, 0.2);
        color: var(--dark-brown);
    }

    .table-modern tbody tr:hover {
        background-color: rgba(255, 215, 0, 0.05);
    }

    .form-control:focus {
        border-color: var(--gold-primary);
        box-shadow: 0 0 0 0.2rem rgba(201, 162, 39, 0.25);
    }

    .btn-filter {
        background-color: var(--gold-primary);
        color: var(--dark-brown);
        border: none;
    }

    .btn-filter:hover {
        background-color: var(--gold-light);
    }
</style>

<!-- FILTERS -->
<div class="card card-modern mb-4">
    <div class="card-header" style="background: rgba(201, 162, 39, 0.15);">
        <h5 class="mb-0 text-primary font-weight-bold">
            <i class="fas fa-filter mr-2"></i> Filter Aktivitas
        </h5>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="role" class="form-control">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="resepsionis" {{ request('role') == 'resepsionis' ? 'selected' : '' }}>Resepsionis</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="type" class="form-control">
                    <option value="">Semua Jenis</option>
                    <option value="login" {{ request('type') == 'login' ? 'selected' : '' }}>Login</option>
                    <option value="logout" {{ request('type') == 'logout' ? 'selected' : '' }}>Logout</option>
                    <option value="create" {{ request('type') == 'create' ? 'selected' : '' }}>Buat Data</option>
                    <option value="update" {{ request('type') == 'update' ? 'selected' : '' }}>Update Data</option>
                    <option value="delete" {{ request('type') == 'delete' ? 'selected' : '' }}>Hapus Data</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-2">
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-filter w-100">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- TABLE -->
<div class="card card-modern">
    <div class="card-header" style="background: rgba(201, 162, 39, 0.15);">
        <h5 class="mb-0 text-primary font-weight-bold">
            <i class="fas fa-history mr-2"></i> Daftar Aktivitas Sistem
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Aktivitas</th>
                        <th>Deskripsi</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $activity)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($activity->user && $activity->user->profile_photo)
                                    <img src="{{ asset('storage/'.$activity->user->profile_photo) }}" class="rounded-circle mr-2" width="35" height="35" alt="User">
                                @else
                                    <i class="fas fa-user-circle fa-2x text-muted mr-2"></i>
                                @endif
                                <div>
                                    <div class="font-weight-bold">{{ $activity->user->name ?? 'System' }}</div>
                                    <small class="text-muted">{{ $activity->user->email ?? '' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-gold-pill">{{ ucfirst($activity->role) }}</span>
                        </td>
                        <td>
                            <span class="badge-gold-pill-outline">{{ ucfirst($activity->activity_type) }}</span>
                        </td>
                        <td style="max-width: 300px; white-space: normal;">
                            {{ $activity->description }}
                        </td>
                        <td>
                            <div>{{ $activity->created_at->format('d/m/Y H:i') }}</div>
                            <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="fas fa-info-circle mr-2"></i> Tidak ada aktivitas ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-light">
        {{ $activities->links() }}
    </div>
</div>
@endsection