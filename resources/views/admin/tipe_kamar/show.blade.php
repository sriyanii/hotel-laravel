@extends('layouts.adminlte')

@section('content')
<h1>Detail Tipe Kamar</h1>

<div class="card">
    <div class="card-body">
        <p><strong>ID:</strong> {{ $tipe->id }}</p>
        <p><strong>Tipe Kamar:</strong> {{ $tipe->tipe_kamar }}</p>
        <p><strong>Jumlah Kamar:</strong> {{ $tipe->jumlah_kamar }}</p>
    </div>
</div>

<a href="{{ route('admin.tipe_kamar.index') }}" class="btn btn-secondary mt-3">Kembali</a>
@endsection
