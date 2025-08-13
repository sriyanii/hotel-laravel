@extends('layouts.adminlte')

@section('title', 'Laporan Resepsionis')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h1>Laporan Kinerja Resepsionis</h1>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Resepsionis</th>
                        <th>Email</th>
                        <th>Jumlah Booking</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resepsionis as $r)
                    <tr>
                        <td>{{ $r->name }}</td>
                        <td>{{ $r->email }}</td>
                        <td>{{ $r->bookings_count ?? 0 }}</td>
                        <td>
                            <a href="{{ route('admin.reports.resepsionis.detail', $r->id) }}" 
                               class="btn btn-sm btn-primary">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection