@extends('layouts.adminlte')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Activity Logs</h3>
    </div>
    <div class="card-body">

        {{-- Form pencarian --}}
        <form method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari aktivitas...">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>

        {{-- Form filter tanggal --}}
        <form method="GET" class="mb-4">
            <div class="row g-2">
                <div class="col-md-5">
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
                </div>
                <div class="col-md-5">
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info w-100">Filter</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Activity</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $activity)
                        <tr>
                            <td>{{ $activity->id }}</td>
                            <td>{{ $activity->user->name ?? 'System' }}</td>
                            <td>
                                <span class="badge {{ $activity->activity_badge_class }}">
                                    {{ $activity->activity_type }}
                                </span>

                            </td>
                            <td>{{ $activity->description }}</td>
                            <td>{{ $activity->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.activities.show', $activity->id) }}" class="btn btn-sm btn-info">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada aktivitas ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $activities->links() }}
    </div>
</div>
@endsection
