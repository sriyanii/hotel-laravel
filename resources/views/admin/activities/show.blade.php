@extends('layouts.adminlte')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Activity Details</h3>
        <div class="card-tools">
            <a href="{{ route('admin.activities.index') }}" class="btn btn-sm btn-default">
                Back to List
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td>{{ $activity->id }}</td>
                    </tr>
                    <tr>
                        <th>User</th>
                        <td>{{ $activity->user->name ?? 'System' }}</td>
                    </tr>
                    <tr>
                        <th>Activity Type</th>
                        <td><span class="badge {{ $activity->getActivityBadgeClass() }}">{{ $activity->activity_type }}</span></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $activity->description }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th>IP Address</th>
                        <td>{{ $activity->ip_address }}</td>
                    </tr>
                    <tr>
                        <th>Device</th>
                        <td>{{ $activity->device }}</td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $activity->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection