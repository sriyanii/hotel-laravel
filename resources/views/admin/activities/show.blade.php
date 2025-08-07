@extends('layouts.adminlte')

@section('title', 'Detail Aktivitas')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-dark">
            <h3 class="card-title">Detail Aktivitas</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">User</th>
                            <td>{{ $activity->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Activity Type</th>
                            <td>
                                <span class="badge 
                                    @if(str_contains($activity->activity_type, 'create')) bg-success
                                    @elseif(str_contains($activity->activity_type, 'update')) bg-primary
                                    @elseif(str_contains($activity->activity_type, 'delete')) bg-danger
                                    @else bg-info @endif">
                                    {{ $activity->activity_type }}
                                </span>
                            </td>
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
                            <th width="30%">IP Address</th>
                            <td>{{ $activity->ip_address }}</td>
                        </tr>
                        <tr>
                            <th>Device</th>
                            <td>{{ $activity->device }}</td>
                        </tr>
                        <tr>
                            <th>Waktu</th>
                            <td>{{ $activity->created_at->format('d F Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.activities.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection