@extends('layouts.adminlte')

@section('title', isset($facility) ? 'Edit Fasilitas' : 'Buat Fasilitas')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow border-0">
                <div class="card-header d-flex justify-content-between align-items-center text-white" style="background-color: #3d3d3d">
                    <div>
                        <i class="fas fa-concierge-bell me-2 fs-4"></i>
                        <span class="fw-bold">{{ isset($facility) ? 'Edit Fasilitas' : 'Buat Fasilitas Baru' }}</span>
                    </div>
                    <a href="{{ route('admin.facilities.index') }}" class="btn btn-light btn-md">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body p-4">
                    <form action="{{ isset($facility) ? route('admin.facilities.update', $facility->id) : route('admin.facilities.store') }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($facility)) @method('PUT') @endif

                        {{-- Nama --}}
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">Nama Fasilitas</label>
                            <input type="text" name="name" id="name" 
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Contoh: Kolam Renang" 
                                   value="{{ old('name', $facility->name ?? '') }}"
                                   {{ isset($facility) && $facility->isBooked() ? 'readonly' : '' }}>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="description" id="description" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      rows="3" {{ isset($facility) && $facility->isBooked() ? 'readonly' : '' }}>{{ old('description', $facility->description ?? '') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Foto --}}
                        <div class="mb-4">
                            <label for="image" class="form-label fw-semibold">Foto Fasilitas</label>
                            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" {{ isset($facility) && $facility->isBooked() ? 'disabled' : '' }}>
                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @if(isset($facility) && $facility->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/'.$facility->image) }}" alt="{{ $facility->name }}" class="rounded border" width="160">
                                </div>
                            @endif
                        </div>

                        {{-- Status --}}
                        <div class="mb-4">
                            <label for="status" class="form-label fw-semibold">Status</label>
                            <select name="status" id="status" class="form-select" {{ isset($facility) && $facility->isBooked() ? 'disabled' : '' }}>
                                <option value="active" {{ old('status', $facility->status ?? '') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ old('status', $facility->status ?? '') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>

                        {{-- Kapasitas --}}
                        <div class="mb-4">
                            <label for="capacity" class="form-label fw-semibold">Kapasitas</label>
                            <input type="number" name="capacity" id="capacity" 
                                   class="form-control @error('capacity') is-invalid @enderror" 
                                   value="{{ old('capacity', $facility->capacity ?? '') }}" min="0" 
                                   {{ isset($facility) && $facility->isBooked() ? 'readonly' : '' }}>
                            @error('capacity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Harga --}}
                        <div class="mb-4">
                            <label for="price_per_night" class="form-label fw-semibold">Harga Per Malam</label>
                            <input type="number" name="price_per_night" id="price_per_night" 
                                   class="form-control @error('price_per_night') is-invalid @enderror" 
                                   value="{{ old('price_per_night', $facility->price_per_night ?? '') }}" min="0" step="0.01" 
                                   {{ isset($facility) && $facility->isBooked() ? 'readonly' : '' }}>
                            @error('price_per_night') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="submit" class="btn btn-dark" {{ isset($facility) && $facility->isBooked() ? 'disabled' : '' }}>
                                {{ isset($facility) ? 'Simpan Perubahan' : 'Simpan' }}
                            </button>
                            <a href="{{ route('admin.facilities.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
