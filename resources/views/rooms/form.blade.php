@extends('layouts.adminlte')

@php
    $isEdit = $isEdit ?? false;
    $prefix = request()->segment(1);
    $currentPhoto = $isEdit && isset($room) && $room->photo ? $room->photo : null;
@endphp

@section('title', $isEdit ? 'Edit Kamar' : 'Tambah Kamar')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow rounded-2">
        <div class="card-header text-white py-3 px-4 rounded-top-2 d-flex justify-content-between align-items-center" style="background: #3d3d3d">
            <h5 class="mb-0">
                <i class="fas fa-bed me-2"></i>
                {{ $isEdit ? 'Edit Kamar' : 'Tambah Kamar' }}
            </h5>
            <a href="{{ route("$prefix.rooms.index") }}" class="btn btn-sm btn-light rounded-pill">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card-body p-4">
            @if($errors->any())
                <div class="alert alert-danger rounded-3">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                  action="{{ $isEdit ? route("$prefix.rooms.update", $room->id) : route("$prefix.rooms.store") }}"
                  enctype="multipart/form-data"
                  class="needs-validation" novalidate>
                @csrf
                @if($isEdit) @method('PUT') @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="number" class="form-label fw-semibold">Nomor Kamar <span class="text-danger">*</span></label>
                        <input type="text" id="number" name="number"
                               class="form-control rounded-pill @error('number') is-invalid @enderror"
                               value="{{ old('number', $room->number ?? '') }}" required>
                        @error('number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label for="type" class="form-label fw-semibold">Tipe Kamar <span class="text-danger">*</span></label>
                        <input type="text" id="type" name="type"
                               class="form-control rounded-pill @error('type') is-invalid @enderror"
                               value="{{ old('type', $room->type ?? '') }}" required>
                        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label for="price" class="form-label fw-semibold">Harga per Malam <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text rounded-start-pill">Rp</span>
                            <input type="number" id="price" name="price"
                                   class="form-control rounded-end-pill @error('price') is-invalid @enderror"
                                   value="{{ old('price', $room->price ?? '') }}" required>
                        </div>
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select id="status" name="status"
                                class="form-select rounded-pill @error('status') is-invalid @enderror" required>
                            <option value="">-- Pilih Status --</option>
                            @foreach(['tersedia', 'terisi', 'maintenance'] as $status)
                                <option value="{{ $status }}"
                                    {{ old('status', $room->status ?? '') === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Kamar</label>
                        <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $isEdit ? $room->description : '') }}</textarea>
                    </div>


                    <div class="col-12">
                        <label for="photo" class="form-label fw-semibold">Foto Kamar</label>
                        <input type="file" name="photo" id="photo"
                               class="form-control @error('photo') is-invalid @enderror"
                               accept="image/*" onchange="previewImage(this)">
                        @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror

                        <div class="mt-3" id="imagePreviewContainer">
                            @if ($currentPhoto)
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('storage/' . $currentPhoto) }}" class="img-thumbnail"
                                         style="max-width: 150px; max-height: 150px;">
                                    <div class="form-check">
                                        <input type="checkbox" name="hapus_gambar" id="hapus_gambar" class="form-check-input">
                                        <label for="hapus_gambar" class="form-check-label text-danger">Hapus foto saat ini</label>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-12 mt-4 d-flex justify-content-end gap-2">
                        <a href="{{ route("$prefix.rooms.index") }}" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="fas fa-times me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="fas fa-save me-1"></i> {{ $isEdit ? 'Update' : 'Simpan' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- <style>
    .bg-gradient-pink {
        background: linear-gradient(135deg, #ff6a9f, #ffb5d2);
    }

    .btn-pink {
        background-color: #ff6a9f;
        border: none;
        color: white;
    }

    .btn-pink:hover {
        background-color: #ff3e84;
        color: white;
    }

    .img-thumbnail {
        border-radius: 8px;
        object-fit: cover;
    }
</style> -->

<script>
    function previewImage(input) {
        const previewContainer = document.getElementById('imagePreviewContainer');
        previewContainer.innerHTML = '';
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.maxWidth = '150px';
                img.style.maxHeight = '150px';
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection


