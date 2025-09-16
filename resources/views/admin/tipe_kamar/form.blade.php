@extends('layouts.adminlte')

@section('content')
<h1>{{ $tipe ? 'Edit' : 'Tambah' }} Tipe Kamar</h1>

<form action="{{ route('admin.tipe_kamar.save') }}" method="POST">
    @csrf
    @if($tipe)
        <input type="hidden" name="id" value="{{ $tipe->id }}">
    @endif

    <div class="mb-3">
        <label for="tipe_kamar" class="form-label">Tipe Kamar</label>
        <input type="text" name="tipe_kamar" class="form-control" value="{{ $tipe->tipe_kamar ?? '' }}" required>
    </div>

    <div class="mb-3">
        <label for="jumlah_kamar" class="form-label">Jumlah Kamar</label>
        <input type="number" name="jumlah_kamar" class="form-control" value="{{ $tipe->jumlah_kamar ?? '' }}" required>
    </div>

    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('admin.tipe_kamar.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
