@extends('layouts.adminlte')

@section('content')
<style>
    /* Pink Soft Modern Theme */
    .bg-pink-soft {
        background-color: #fce4ec !important;
    }
    .text-pink-soft {
        color: #d81b60 !important;
    }
    .badge-pink-pill {
        background-color: #f8bbd0;
        color: #4a148c;
        border-radius: 50rem;
        padding: 0.35em 0.8em;
        font-weight: 600;
        font-size: 0.75rem;
    }
    .badge-pink-pill-outline {
        background-color: transparent;
        border: 1px solid #f48fb1;
        color: #d81b60;
        border-radius: 50rem;
        padding: 0.35em 0.8em;
        font-weight: 600;
        font-size: 0.75rem;
    }
    .card-modern {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 4px 15px rgba(236, 64, 122, 0.12);
    }
    .table-modern thead {
        background-color: #f8bbd0;
        color: #4a148c;
    }
    .table-modern tbody tr:hover {
        background-color: #fff0f5;
    }
    .form-control:focus {
        border-color: #ec407a;
        box-shadow: 0 0 0 0.2rem rgba(236, 64, 122, 0.25);
    }
</style>

<!-- FILTERS -->
<div class="card card-modern mb-4">
    <div class="card-header bg-pink-soft">
        <h5 class="mb-0 text-pink-soft font-weight-bold">
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
                <button type="submit" class="btn badge-pink-pill w-100">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- TABLE -->
<div class="card card-modern">
    <div class="card-header bg-pink-soft">
        <h5 class="mb-0 text-pink-soft font-weight-bold">
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
                            <span class="badge-pink-pill">{{ ucfirst($activity->role) }}</span>
                        </td>
                        <td>
                            <span class="badge-pink-pill-outline">{{ ucfirst($activity->activity_type) }}</span>
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
