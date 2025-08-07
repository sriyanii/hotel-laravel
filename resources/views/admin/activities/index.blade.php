@extends('layouts.adminlte')

@section('title', 'Log Aktivitas')

@section('content')
<style>
    body {
        background-color: #fff5f7;
    }

    .log-wrapper {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .log-header {
        background: linear-gradient(135deg, #fce4ec, #f8bbd0);
        color: #6b0033;
        padding: 1.2rem 1.5rem;
        border-bottom: 1px solid #f8bbd0;
    }

    .log-header h4 {
        margin: 0;
        font-weight: bold;
        font-size: 1.25rem;
    }

    .table-log {
        margin: 0;
        font-size: 0.875rem;
    }

    .table-log th {
        background-color: #fce4ec;
        color: #6b0033;
        border: 1px solid #f8bbd0;
    }

    .table-log td {
        background-color: #fffafc;
        border: 1px solid #f8bbd0;
    }

    .badge-log {
        background-color: #e1bee7;
        color: #4a148c;
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .pagination .page-link {
        color: #6b0033;
    }

    .pagination .active .page-link {
        background-color: #f48fb1;
        border-color: #f48fb1;
    }
</style>

<div class="container-fluid py-4">
    <div class="log-wrapper">
        {{-- HEADER --}}
        <div class="log-header d-flex justify-content-between align-items-center">
            <h4><i class="fas fa-history me-2"></i> Log Aktivitas Sistem</h4>
            <small class="text-muted">Terakhir diperbarui: {{ now()->format('d M Y, H:i') }}</small>
        </div>

        {{-- TABEL --}}
        <div class="p-3">
            <div class="table-responsive">
                <table class="table table-log table-bordered table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">#</th>
                            <th width="15%">Waktu</th>
                            <th width="15%">User</th>
                            <th width="15%">Tipe</th>
                            <th width="40%">Deskripsi</th>
                            <th width="10%">IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $activity)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + ($activities->currentPage() - 1) * $activities->perPage() }}</td>
                            <td>{{ $activity->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $activity->user->name ?? 'System' }}</td>
                            <td>
                                <span class="badge-log">
                                    {{ ucfirst($activity->activity_type) }}
                                </span>
                            </td>
                            <td>{{ $activity->description }}</td>
                            <td>{{ $activity->ip_address }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-info-circle me-1"></i> Tidak ada aktivitas tercatat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- FOOTER --}}
        @if ($activities->hasPages())
        <div class="px-3 py-2 bg-white border-top">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Menampilkan {{ $activities->firstItem() }} - {{ $activities->lastItem() }} dari total {{ $activities->total() }} data
                </small>
                <div>
                    {{ $activities->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
